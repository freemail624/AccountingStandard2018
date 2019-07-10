<?php

class Pos_item_sales_model extends CORE_Model {
    protected  $table="pos_item_sales";
    protected  $pk_id="pos_item_sales_id";

    function __construct() {
        parent::__construct();
    }

    function get_xreading() {
        $sql="  SELECT distinct x_reading_id,DATE_FORMAT(CAST(start_datetime as DATE),'%m/%d/%Y')  as trans_date FROM pos_item_sales";
        return $this->db->query($sql)->result();
    }


    function get_pos_sales_for_review() {
        $sql="SELECT 
			DATE_FORMAT(CAST(start_datetime as DATE),'%m/%d/%Y')  as trans_date,
			x_reading_id,
			CONCAT('X Reading # ', x_reading_id) x_reading_desc,
			SUM(item_total) as trans_total
			FROM pos_item_sales

			WHERE is_journal_posted = FALSE 
			GROUP BY x_reading_id";
        return $this->db->query($sql)->result();
    }


    function set_as_posted($journal_id,$x_reading_id) {
        $sql="UPDATE pos_item_sales SET is_journal_posted = TRUE, journal_id = $journal_id WHERE x_reading_id = $x_reading_id";
         $this->db->query($sql);
    }





    function get_journal_entries($x_reading_id) {
        $sql="SELECT * FROM(SELECT 
        (SELECT payment_from_customer_id FROM account_integration) as account_id,
        '' as memo,
        SUM(pis.item_total - pis.discount_amount) as dr_amount,
        0 as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0
        
        UNION ALL
        
        SELECT 
        (SELECT receivable_discount_account_id FROM account_integration) as account_id,
        '' as memo,
        SUM(pis.discount_amount) as dr_amount,
        0 as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0
        
        UNION ALL
        
        SELECT 
        p.income_account_id as account_id,
        '' as memo,
        0 as dr_amount,
        SUM(pis.item_total - pis.vat_amount) as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0
        GROUP BY p.income_account_id
        
        UNION ALL
        
        SELECT 
        (SELECT output_tax_account_id FROM account_integration) as account_id,
        '' as memo,
        0 as dr_amount,
        SUM(pis.vat_amount) as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0) 
        as main WHERE main.dr_amount > 0 or main.cr_amount > 0";
        return $this->db->query($sql)->result();
    }





}
?>