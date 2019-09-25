<?php

class Billing_contract_schedule_model extends CORE_Model {
    protected  $table="b_contract_schedule";
    protected  $pk_id="contract_schedule_id";
    protected  $fk_id="contract_id";

    function __construct() {
        parent::__construct();
    }

}
?>

