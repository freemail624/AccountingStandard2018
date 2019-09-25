<?php

class Billing_contract_misc_model extends CORE_Model {
    protected  $table="b_contract_misc_charges";
    protected  $pk_id="contract_misc_id";
    protected  $fk_id="contract_id";

    function __construct() {
        parent::__construct();
    }

}
?>

