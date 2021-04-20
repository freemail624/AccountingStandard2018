<?php

class Customer_vehicles_model extends CORE_Model {
    protected  $table="customer_vehicles";
    protected  $pk_id="vehicle_id";

    function __construct() {
        parent::__construct();
    }

    function get_vehicles($vehicle_id=null,$customer_id=0) {
        $sql="SELECT vehicle.*,
                    c.customer_name,
                    make.make_code,
                    make.make_desc,
                    year.vehicle_year,
                    model.model_name,
                    colors.color,
                    (CASE
                      WHEN vehicle.crp_no_type = 1 THEN vehicle.conduction_no
                      ELSE vehicle.plate_no
                    END) as crp_no
                 FROM
                  customer_vehicles vehicle
                  LEFT JOIN customers c ON c.customer_id = vehicle.customer_id
                  LEFT JOIN makes make ON make.make_id = vehicle.make_id
                  LEFT JOIN vehicle_year year ON year.vehicle_year_id = vehicle.vehicle_year_id
                  LEFT JOIN vehicle_model model ON model.model_id = vehicle.model_id
                  LEFT JOIN colors ON colors.color_id = vehicle.color_id
                WHERE
                    vehicle.is_deleted=FALSE AND 
                    vehicle.is_active=TRUE
                    ".($vehicle_id==null?"":" AND vehicle.vehicle_id=$vehicle_id")."
                    ".($customer_id==0?"":" AND vehicle.customer_id=$customer_id")."";
        return $this->db->query($sql)->result();
    }

}
?>