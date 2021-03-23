<?php

class Vehicle_model extends CORE_Model {
    protected  $table="vehicle_model";
    protected  $pk_id="model_id";

    function __construct() {
        parent::__construct();
    }

    function get_models_list($model_id=null) {
        $sql="SELECT a.* FROM
                  vehicle_model as a
                WHERE
                    a.is_deleted=FALSE
                ".($model_id==null?"":" AND a.model_id=$model_id")."";
        return $this->db->query($sql)->result();
    }

    function check_model($model_name,$model_id=null){
        $sql="SELECT * FROM vehicle_model 
            WHERE is_deleted = FALSE AND 
            model_name = '".$model_name."' 
            ".($model_id==null?"":" AND model_id!=$model_id")."";
        return $this->db->query($sql)->result();
    }
}
?>