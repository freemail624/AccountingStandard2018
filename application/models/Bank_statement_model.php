<?php
	class Bank_statement_model extends CORE_Model {
	    protected  $table="bank_statement";
	    protected  $pk_id="bank_statement_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_prev_balance($month_id,$year,$account_id=0){
	        $sql="SELECT 
			    *
			FROM
			    bank_statement b
			WHERE
				b.account_id = $account_id
			    AND b.month_id = MONTH(DATE_SUB(CONCAT('".$year."-".$month_id."-01'),
			            INTERVAL 1 MONTH))

			    AND b.year = YEAR(DATE_SUB(CONCAT('".$year."-".$month_id."-01'),
			            INTERVAL 1 MONTH))";
	        return $this->db->query($sql)->result();
    	}
	}
?>