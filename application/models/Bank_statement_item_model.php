<?php
	class Bank_statement_item_model extends CORE_Model {
	    protected  $table="bank_statement_items";
	    protected  $pk_id="bank_statement_item_id";
	    protected  $fk_id="bank_statement_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_items($bank_statement_id=null){
	    	$sql="SELECT * FROM bank_statement_items WHERE bank_statement_id = $bank_statement_id
	    		ORDER BY bank_statement_item_id ASC";
	        return $this->db->query($sql)->result();
	    }

	    function get_bank_items($account_id=0,$month_id,$year_id){
	    	$sql="SELECT * FROM
				    bank_statement_items bsi
				        LEFT JOIN
				    bank_statement bs ON bs.bank_statement_id = bsi.bank_statement_id
				WHERE
				    bs.is_deleted = FALSE
				        AND bs.is_active = TRUE
				        AND bs.account_id = $account_id
				        AND bs.month_id = $month_id
				        AND bs.year = $year_id
				ORDER BY bsi.bank_statement_item_id ASC";
	        return $this->db->query($sql)->result();
	    }	   

	}
?>