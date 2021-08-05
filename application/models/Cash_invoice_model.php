<?php

class Cash_invoice_model extends CORE_Model
{
    protected $table = "cash_invoice";
    protected $pk_id = "cash_invoice_id";

    function __construct()
    {
        parent::__construct();
    }


	function get_journal_entries($cash_invoice_id){
		$sql="SELECT 
			    main.*
			FROM
				/* CASH */
			    (SELECT 
			        acc_receivable.account_id,
			            acc_receivable.memo,
			            0 AS cr_amount,
			            SUM(acc_receivable.dr_amount) AS dr_amount
			    FROM
			        (SELECT 
			        cii.product_id,
			            (SELECT 
			                    payment_from_customer_id
			                FROM
			                    account_integration) AS account_id,
			            '' AS memo,
			            0 cr_amount,
			            SUM(cii.inv_line_total_price) AS dr_amount
			    FROM
			        `cash_invoice_items` AS cii
			    INNER JOIN products AS p ON cii.product_id = p.product_id
			    WHERE
			        cii.cash_invoice_id = $cash_invoice_id
			            AND p.income_account_id > 0) AS acc_receivable
			    GROUP BY acc_receivable.account_id 

			    /* COS */
			    UNION ALL SELECT 
			        p.cos_account_id AS account_id,
			            '' AS memo,
			            0 AS cr_amount,
			            SUM(cii.inv_qty * cii.cost_upon_invoice) AS dr_amount
			    FROM
			        `cash_invoice_items` AS cii
			    INNER JOIN products AS p ON cii.product_id = p.product_id
			    WHERE
			        cii.cash_invoice_id = $cash_invoice_id
			            AND p.cos_account_id > 0
			    GROUP BY p.cos_account_id 

			    /* DISCOUNT */
			    UNION ALL SELECT 
			        p.sd_account_id AS account_id,
			            '' AS memo,
			            0 AS cr_amount,
			            (ci.total_discount + ci.total_overall_discount_amount) AS dr_amount
			    FROM
			        `cash_invoice_items` AS cii
			    INNER JOIN products AS p ON cii.product_id = p.product_id
			    LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
			    WHERE
			        cii.cash_invoice_id = $cash_invoice_id
			            AND p.sd_account_id > 0
			    GROUP BY p.sd_account_id 

			    /* INVENTORY */
			    UNION ALL SELECT 
			        p.expense_account_id AS account_id,
			            '' AS memo,
			            SUM(cii.inv_qty * cii.cost_upon_invoice) cr_amount,
			            0 AS dr_amount
			    FROM
			        `cash_invoice_items` AS cii
			    INNER JOIN products AS p ON cii.product_id = p.product_id
			    WHERE
			        cii.cash_invoice_id = $cash_invoice_id
			            AND p.expense_account_id > 0
			    GROUP BY p.expense_account_id 

			    /* SALES */
			    UNION ALL SELECT 
			        p.income_account_id AS account_id,
			            '' AS memo,
			            (SUM(cii.inv_non_tax_amount) + ci.total_discount + ci.total_overall_discount_amount) cr_amount,
			            0 AS dr_amount
			    FROM
			        `cash_invoice_items` AS cii
			    INNER JOIN products AS p ON cii.product_id = p.product_id
			    LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
			    WHERE
			        cii.cash_invoice_id = $cash_invoice_id
			            AND p.income_account_id > 0
			    GROUP BY p.income_account_id 

			    /* TAX */
			    UNION ALL SELECT 
			        output_tax.account_id,
			            output_tax.memo,
			            SUM(output_tax.cr_amount) AS cr_amount,
			            0 AS dr_amount
			    FROM
			        (SELECT 
			        cii.product_id,
			            (SELECT 
			                    output_tax_account_id
			                FROM
			                    account_integration) AS account_id,
			            '' AS memo,
			            SUM(cii.inv_tax_amount) AS cr_amount,
			            0 AS dr_amount
			    FROM
			        `cash_invoice_items` AS cii
			    INNER JOIN products AS p ON cii.product_id = p.product_id
			    WHERE
			        cii.cash_invoice_id = $cash_invoice_id
			            AND p.income_account_id > 0) AS output_tax
			    GROUP BY output_tax.account_id) main
			WHERE
			    main.dr_amount > 0 OR main.cr_amount > 0";

		return $this->db->query($sql)->result();
	}





	function get_cash_invoice_for_review(){
		$sql='SELECT 
		ci.cash_invoice_id,
		ci.cash_inv_no,
		DATE_FORMAT(ci.date_invoice,"%m/%d/%Y") as date_invoice,
		c.customer_name,
		ci.remarks
		FROM
		cash_invoice ci

		LEFT JOIN customers c ON c.customer_id = ci.customer_id
		WHERE ci.is_active = TRUE AND
		ci.is_deleted = FALSE AND 
		ci.is_journal_posted = FALSE AND
		ci.is_closed = FALSE';
		
		return $this->db->query($sql)->result();
		}

}

?>
