<?php

class Receipt_model extends CORE_Model{

    protected  $table="receipt"; //table name
    protected  $pk_id="receipt_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function delete_all(){
    	$sql = 'DELETE FROM receipt';
    	$this->db->query($sql);
    }

}

?>