<?php
	
	class Bank_reconciliation_additional_model extends CORE_Model
	{
		protected $table="bank_reconciliation_additionals";
		protected $pk_id="bank_reconciliation_additional_id";
		protected $fk_id="bank_recon_id";

		function __construct()
		{
			parent::__construct();
		}

	}

?>