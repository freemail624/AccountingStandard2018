<?php

class Purchase_request_form_items_model extends CORE_Model {
    protected  $table="purchase_request_form_items";
    protected  $pk_id="prf_item_id";
    protected  $fk_id="purchase_request_form_id";

    function __construct() {
        parent::__construct();
    }


}



?>