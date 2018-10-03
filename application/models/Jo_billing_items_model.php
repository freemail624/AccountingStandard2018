<?php

class Jo_billing_items_model extends CORE_Model
{
    protected $table = "Jo_billing_items";
    protected $pk_id = "jo_billing_item_id";
    protected $fk_id = "jo_billing_id";

    function __construct()
    {
        parent::__construct();
    }
}


?>