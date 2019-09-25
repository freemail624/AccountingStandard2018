<?php

class Billing_contract_other_model extends CORE_Model {
    protected  $table="b_contract_othr_charges";
    protected  $pk_id="contract_othr_id";
    protected  $fk_id="contract_id";

    function __construct() {
        parent::__construct();
    }

}
?>

