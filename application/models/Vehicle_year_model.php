<?php

class Vehicle_year_model extends CORE_Model {
    protected  $table="vehicle_year";
    protected  $pk_id="vehicle_year_id";

    function __construct() {
        parent::__construct();
    }

    function get_vehicle_year_list($vehicle_year_id=null) {
        $sql="SELECT a.* FROM
                  vehicle_year as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($vehicle_year_id==null?"":" AND a.vehicle_year_id=$vehicle_year_id")."";
        return $this->db->query($sql)->result();
    }

    function check_vehicle_year($vehicle_year,$vehicle_year_id=null){
        $sql="SELECT * FROM vehicle_year 
            WHERE is_deleted = FALSE AND 
            vehicle_year = '".$vehicle_year."' 
            ".($vehicle_year_id==null?"":" AND vehicle_year_id!=$vehicle_year_id")."";
        return $this->db->query($sql)->result();
    }


}
?>