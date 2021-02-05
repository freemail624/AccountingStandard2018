<?php

class Sales_attachment_model extends CORE_Model
{
    protected  $table = "sales_attachments"; //table name
    protected  $pk_id = "sales_attachment_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


}

?>