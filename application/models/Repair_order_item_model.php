<?php

class Repair_order_item_model extends CORE_Model
{
    protected $table = "repair_order_items";
    protected $pk_id = "repair_order_item_id";
    protected $fk_id = "repair_order_id";

    function __construct()
    {
        parent::__construct();
    }
}


?>