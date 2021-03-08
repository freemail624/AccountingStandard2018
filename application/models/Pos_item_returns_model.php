<?php

class Pos_item_returns_model extends CORE_Model {
    protected  $table="pos_item_returns";
    protected  $pk_id="pos_item_returns_id";

    function __construct() {
        parent::__construct();
    }

    function get_xreading() {
        $sql="  SELECT distinct x_reading_id,DATE_FORMAT(CAST(start_datetime as DATE),'%m/%d/%Y') as trans_date, terminal_id FROM pos_item_returns";
        return $this->db->query($sql)->result();
    }


    function get_pos_returns_for_review() {
        $sql="SELECT 
			DATE_FORMAT(CAST(start_datetime as DATE),'%m/%d/%Y')  as trans_date,
			x_reading_id,
			CONCAT('X Reading # ', x_reading_id) x_reading_desc,
			SUM(item_total) as trans_total
			FROM pos_item_returns

			WHERE is_journal_posted = FALSE 
			GROUP BY x_reading_id";
        return $this->db->query($sql)->result();
    }


    function set_as_posted($journal_id,$x_reading_id) {
        $sql="UPDATE pos_item_returns SET is_journal_posted = TRUE, journal_id = $journal_id WHERE x_reading_id = $x_reading_id";
         $this->db->query($sql);
    }

    function get_journal_entries($x_reading_id) {
        $sql="SELECT main.* FROM (

        /* Sales Return */
        SELECT 
        p.sales_return_account_id as account_id,
        SUM(pir.item_total - pir.vat_amount) as dr_amount,
        0 as cr_amount,
        '' as memo
        FROM pos_item_returns pir
        LEFT JOIN products p ON p.product_id = pir.product_id
        WHERE pir.x_reading_id = $x_reading_id  AND p.sales_return_account_id > 0
        GROUP BY p.sales_return_account_id

        /* Inventory */
        UNION ALL

        SELECT
        p.expense_account_id as account_id,
        SUM(pir.product_quantity * p.purchase_cost) as dr_amount,
        0 as cr_amount,
        '' as memo
        FROM pos_item_returns pir
        INNER JOIN products p ON p.product_id = pir.product_id
        WHERE pir.x_reading_id = $x_reading_id  AND p.expense_account_id > 0
        GROUP BY p.expense_account_id

        -- Output Tax
        UNION ALL
        
        SELECT output_tax.* FROM(
            SELECT
            (SELECT output_tax_account_id FROM account_integration) as account_id,
            SUM(pir.vat_amount) as dr_amount,
            0 as cr_amount,
            '' as memo
            FROM pos_item_returns pir
            LEFT JOIN products p ON p.product_id = pir.product_id
            WHERE pir.x_reading_id = $x_reading_id
        ) as output_tax
        WHERE output_tax.account_id > 0
        GROUP BY output_tax.account_id

        /* CASH */
        UNION ALL

        SELECT cash.* FROM(
            SELECT
            (SELECT payment_from_customer_id FROM account_integration) as account_id,
            0 as dr_amount,
            SUM(pir.item_total - pir.discount_amount) as cr_amount,
            '' as memo
            FROM pos_item_returns pir
            LEFT JOIN products p ON p.product_id = pir.product_id
            WHERE pir.x_reading_id = $x_reading_id
        ) as cash
        WHERE cash.account_id > 0
        GROUP BY cash.account_id

        /* Cost of Sales */
        UNION ALL

        SELECT
        p.cos_account_id as account_id,
        0 as dr_amount,
        SUM(pir.product_quantity * p.purchase_cost) as cr_amount,
        '' as memo
        FROM pos_item_returns pir
        INNER JOIN products p ON p.product_id = pir.product_id
        WHERE pir.x_reading_id = $x_reading_id  AND p.cos_account_id > 0
        GROUP BY p.cos_account_id

        /* Discount */
        UNION ALL

        SELECT
        p.sd_account_id as account_id,
        0 as dr_amount,
        SUM(pir.discount_amount) as cr_amount,
        '' as memo
        FROM pos_item_returns pir
        INNER JOIN products p ON p.product_id = pir.product_id
        WHERE pir.x_reading_id = $x_reading_id  AND p.sd_account_id > 0
        GROUP BY p.sd_account_id)

        as main WHERE main.dr_amount > 0 or main.cr_amount > 0";
        return $this->db->query($sql)->result();
    }





}
?>