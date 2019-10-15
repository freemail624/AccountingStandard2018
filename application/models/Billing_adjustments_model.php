<?php

class Billing_adjustments_model extends CORE_Model {
    protected  $table="b_adjustments";
    protected  $pk_id="adjustment_id";

    function __construct() {
        parent::__construct();
    }

}
?>