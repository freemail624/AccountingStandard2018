<?php

class Other_invoice_items_model extends CORE_Model
{
    protected $table = "other_invoice_items";
    protected $pk_id = "other_invoice_item_id";
    protected $fk_id = "other_invoice_id";

    function __construct()
    {
        parent::__construct();
    }
}


?>