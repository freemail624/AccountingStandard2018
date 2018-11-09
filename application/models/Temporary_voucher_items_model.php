<?php

class Temporary_voucher_items_model extends CORE_Model {
    protected  $table="temp_voucher_items";
    protected  $pk_id="temp_voucher_item_id";
    protected  $fk_id="temp_voucher_id";

    function __construct() {
        parent::__construct();
    }

}
?>