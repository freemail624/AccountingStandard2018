<?php

class Other_income_model extends CORE_Model
{
    protected $table = "other_invoice";
    protected $pk_id = "other_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

	function get_journal_entries($other_invoice_id){
		$sql="SELECT main.* FROM (SELECT 
			acc_payable.account_id,
			'' as memo,
			acc_payable.dr_amount,
			0 as cr_amount
			 FROM 

			(SELECT 
			oii.item_id,
			(SELECT other_income_receivable_account_id FROM account_integration) as account_id,
			SUM(oii.oi_line_total_after_global) as dr_amount
			 FROM

			other_invoice_items oii
			LEFT JOIN items i ON i.item_id = oii.item_id
			WHERE oii.other_invoice_id = $other_invoice_id AND  i.income_account_id > 0) 
			as acc_payable GROUP BY acc_payable.account_id

			UNION ALL

			SELECT 
			i.income_account_id as account_id,
			'' as memo,
			0 as dr_amount,
			SUM(oii.oi_line_total_after_global) as cr_amount
			 FROM
			other_invoice_items oii
			LEFT JOIN items i ON i.item_id = oii.item_id
			WHERE oii.other_invoice_id = $other_invoice_id AND  i.income_account_id > 0
			GROUP BY i.income_account_id) as main 
			WHERE main.dr_amount > 0 or main.cr_amount > 0";

		return $this->db->query($sql)->result();
	}

}


?>