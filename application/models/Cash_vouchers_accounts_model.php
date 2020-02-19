<?php

class Cash_vouchers_accounts_model extends CORE_Model {
    protected  $table="cv_accounts";
    protected  $pk_id="cv_account_id";
    protected  $fk_id="cv_id"; //foreign key id

    function __construct() {
        parent::__construct();
    }
}
?>