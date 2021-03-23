<?php

class Customer_vehicles_model extends CORE_Model {
    protected  $table="customer_vehicles";
    protected  $pk_id="vehicle_id";

    function __construct() {
        parent::__construct();
    }

    function get_vehicles($vehicle_id=null) {
        $sql="SELECT a.* FROM
                  customer_vehicles as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($vehicle_id==null?"":" AND a.vehicle_id=$vehicle_id")."";
        return $this->db->query($sql)->result();
    }

}
?>