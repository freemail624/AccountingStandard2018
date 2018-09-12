<?php

class Payment_terms_model extends CORE_Model {
    protected  $table="payment_terms";
    protected  $pk_id="payment_term_id";

    function __construct() {
        parent::__construct();
    }


}
?>