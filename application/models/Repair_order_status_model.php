<?php

class Repair_order_status_model extends CORE_Model
{
    protected $table = "repair_order_statuses";
    protected $pk_id = "id";

    function __construct()
    {
        parent::__construct();
    }
}
?>