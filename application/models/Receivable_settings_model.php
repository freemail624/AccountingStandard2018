<?php
	class Receivable_settings_model extends CORE_Model {
	    protected  $table="receivable_settings";
	    protected  $pk_id="receivable_settings_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_receivable_accounts()
	    {
	        $query = $this->db->query('SELECT at.* FROM receivable_settings rs
				LEFT JOIN account_titles at ON at.account_id = rs.receivable_account_id
				WHERE at.is_active = TRUE AND at.is_deleted = FALSE');
	        return $query->result();
	    }

	}
?>