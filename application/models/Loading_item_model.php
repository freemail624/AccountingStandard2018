<?php

class Loading_item_model extends CORE_Model{

    protected  $table="loading_items"; //table name
    protected  $pk_id="loading_item_id"; //primary key id
    protected  $fk_id="loading_id"; //foreign key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



}




?>