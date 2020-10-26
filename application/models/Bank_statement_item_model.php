<?php
	class Bank_statement_item_model extends CORE_Model {
	    protected  $table="bank_statement_items";
	    protected  $pk_id="bank_statement_item_id";

	    function __construct() {
	        parent::__construct();
	    }
	}
?>