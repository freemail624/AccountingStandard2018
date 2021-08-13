<?php

class Purchase_journal_account_model extends CORE_Model{

    protected  $table="purchase_journal_accounts"; //table name
    protected  $pk_id="purchase_journal_account_id"; //primary key id
    protected  $fk_id="purchase_journal_id"; //foreign key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

}

?>
