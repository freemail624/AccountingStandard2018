<?php

class Billing_contracts_model extends CORE_Model {
    protected  $table="b_contract_info";
    protected  $pk_id="contract_id";

    function __construct() {
        parent::__construct();
    }

}
?>