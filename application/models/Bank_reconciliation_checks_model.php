<?php
	
	class Bank_reconciliation_checks_model extends CORE_Model
	{
		protected $table="bank_reconciliation_checks";
		protected $pk_id="bank_recon_check_id";
		protected $fk_id="bank_recon_id";

		function __construct()
		{
			parent::__construct();
		}
	}

?>