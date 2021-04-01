<?php

class Vehicle_services_model extends CORE_Model {
    protected  $table="vehicle_services";
    protected  $pk_id="vehicle_service_id";

    function __construct() {
        parent::__construct();
    }

    function get_vehicle_services()
    {
        $query = $this->db->query("SELECT * FROM vehicle_services ORDER BY vehicle_service_id ASC");
        return $query->result();
    }


}
?>