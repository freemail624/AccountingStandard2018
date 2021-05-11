<?php

class Bank_model extends CORE_Model {
    protected  $table="bank";
    protected  $pk_id="bank_id";

    function __construct() {
        parent::__construct();
    }

    function get_bank_list($bank_id=null) {
        $sql="SELECT 
        	bank.*, 
        	account_titles.account_title

        	FROM bank
        	LEFT JOIN account_titles ON account_titles.account_id = bank.account_id
        	WHERE 
        	bank.is_deleted = FALSE AND
        	bank.is_active = TRUE
        	".($bank_id==null?"":" AND bank.bank_id='".$bank_id."'")."";

        return $this->db->query($sql)->result();
    }

}
?>