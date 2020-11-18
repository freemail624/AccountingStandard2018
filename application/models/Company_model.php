<?php

class Company_model extends CORE_Model{

    protected  $table="company_info"; //table name
    protected  $pk_id="company_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getDefaultRemarks()
    {
        $query = $this->db->query('SELECT 
    	(CASE 
    		WHEN is_purchasing_default = 1
    		THEN purchase_remarks
    		ELSE ""
    	END) as purchase_remarks,
    	(CASE
    		WHEN is_sales_default = 1
    		THEN sales_remarks
    		ELSE ""
    	END) as sales_remarks,
        is_print_auto

        FROM company_info WHERE company_id = 1');
        return $query->result();
    }


}




?>