<?php

class Temp_journal_info_model extends CORE_Model
{
    protected  $table = "temp_journal_info"; //table name
    protected  $pk_id = "temp_journal_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getBillingList($department_id=0)
    {
        $query = $this->db->query("SELECT 
        		tji.*, c.customer_name,
        		CONCAT(m.month_name,' ',billing.app_year) as billing_period
        	FROM temp_journal_info tji 
        	LEFT JOIN customers c ON c.customer_id = tji.customer_id
        	LEFT JOIN b_billing_info billing ON billing.billing_no = tji.ref_no
        	LEFT JOIN b_refmonths m ON m.month_id = billing.month_id
        	WHERE 
                tji.is_deleted = FALSE AND
        		tji.is_sales = TRUE AND
        		tji.book_type_id = 0 AND
        		tji.is_journal_posted = FALSE
        		".($department_id==0?"":" AND c.link_department_id='".$department_id."'")."");
        return $query->result();
    }

    function getBillingAdvancesList($department_id=0)
    {
        $query = $this->db->query("SELECT 
                tji.*, c.customer_name
            FROM temp_journal_info tji 
            LEFT JOIN customers c ON c.customer_id = tji.customer_id
            WHERE 
                tji.is_deleted = FALSE AND
                tji.book_type_id = 2 AND
                tji.is_journal_posted = FALSE
                ".($department_id==0?"":" AND c.link_department_id='".$department_id."'")."");
        return $query->result();
    }    

}

?>