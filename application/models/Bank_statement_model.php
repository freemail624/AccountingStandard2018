<?php
	class Bank_statement_model extends CORE_Model {
	    protected  $table="bank_statement";
	    protected  $pk_id="bank_statement_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_bank_statement_list($bank_statement_id=null,$year=null,$account_id=null,$month_id=null){
	    	$sql="SELECT 
				    bs.*,
				    at.account_title,
				    m.month_name
				FROM
				    bank_statement bs
				    LEFT JOIN account_titles at ON at.account_id = bs.account_id
				    LEFT JOIN months m ON m.month_id = bs.month_id
				    WHERE bs.is_deleted = FALSE AND bs.is_active = TRUE
        			".($bank_statement_id==null?"":" AND bs.bank_statement_id=".$bank_statement_id."")."
        			".($year==null?"":" AND bs.year=".$year."")."
        			".($account_id==null?"":" AND bs.account_id=".$account_id."")."
        			".($month_id==null?"":" AND bs.month_id=".$month_id."")."";
	        return $this->db->query($sql)->result();
	    }

	    function get_bank_statement_recon_list($year=null,$account_id=0,$month_id=null){
	    	$sql="SELECT 
				    bs.*,
				    at.account_title,
				    m.month_name
				FROM
				    bank_statement bs
				    LEFT JOIN account_titles at ON at.account_id = bs.account_id
				    LEFT JOIN months m ON m.month_id = bs.month_id
				    WHERE bs.is_deleted = FALSE AND bs.is_active = TRUE
        			".($year==null?"":" AND bs.year=".$year."")."
        			".($account_id==null?"":" AND bs.account_id=".$account_id."")."
        			".($month_id==null?"":" AND bs.month_id=".$month_id."")."";
	        return $this->db->query($sql)->result();
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