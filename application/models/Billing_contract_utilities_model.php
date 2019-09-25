<?php

class Billing_contract_utilities_model extends CORE_Model {
    protected  $table="b_contract_util_charges";
    protected  $pk_id="contract_util_id";
    protected  $fk_id="contract_id";

    function __construct() {
        parent::__construct();
    }

}
?>

