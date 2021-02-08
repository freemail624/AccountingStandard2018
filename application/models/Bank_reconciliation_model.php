<?php
	
	class Bank_reconciliation_model extends CORE_Model
	{
		protected $table="bank_reconciliation";
		protected $pk_id="bank_recon_id";

		function __construct()
		{
			parent::__construct();
		}

	    function get_bank_reconciliation_list($bank_recon_id=null,$account_id=0,$is_list=TRUE){
	    	$sql="SELECT 
				    br.*,
				    at.account_title,
				    bs.*,
				    DATE_FORMAT(br.start_date,'%m/%d/%Y') as start_date,
				    DATE_FORMAT(br.end_date,'%m/%d/%Y') as end_date

				FROM
				    bank_reconciliation br
				    LEFT JOIN account_titles at ON at.account_id = br.account_id
				    LEFT JOIN bank_statement bs ON bs.bank_statement_id = br.bank_statement_id
				    WHERE br.is_deleted = FALSE AND br.is_active = TRUE
        			".($bank_recon_id==null?"":" AND br.bank_recon_id=".$bank_recon_id."")."
        			".($account_id==0?"":" AND br.account_id=".$account_id."")."
        			".($is_list==TRUE?" AND br.is_processed=TRUE":" AND br.is_processed=FALSE")."";
	        return $this->db->query($sql)->result();
	    }


	}

?>