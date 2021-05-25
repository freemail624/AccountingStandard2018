<?php

class Customer_vehicles_model extends CORE_Model {
    protected  $table="customer_vehicles";
    protected  $pk_id="vehicle_id";

    function __construct() {
        parent::__construct();
    }


    function get_all_data($customer_id=0,$search_value=null)
    {
        $sql="SELECT vehicle.*, 
                    c.customer_no,
                    c.customer_name,
                    model.model_name
            FROM customer_vehicles vehicle 
            LEFT JOIN customers c ON c.customer_id = vehicle.customer_id
            LEFT JOIN vehicle_model model ON model.model_id = vehicle.model_id
            WHERE vehicle.is_deleted = FALSE AND vehicle.is_active = TRUE
            ".($customer_id==0?"":" AND vehicle.customer_id=$customer_id")."
            ".($search_value==null?"":" 
                AND (c.customer_no LIKE '".$search_value."%' OR 
                  c.customer_name LIKE '%".$search_value."%' OR 
                  model.model_name LIKE '%".$search_value."%' OR
                  vehicle.conduction_no LIKE '%".$search_value."%' OR 
                  vehicle.plate_no LIKE '%".$search_value."%')
            ")."
        ";
        return $this->db->query($sql)->num_rows();
    }

    function get_vehicles(
                $vehicle_id=null,
                $customer_id=0,
                $search_value=null,
                $length=null,
                $start=0,
                $order_column=null,
                $order_dir=null
              ) {

        $sql="SELECT vehicle.*,
                    c.customer_no,
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
                    ".($customer_id==0?"":" AND vehicle.customer_id=$customer_id")."

                    ".($search_value==null?"":" 
                        AND (c.customer_no LIKE '".$search_value."%' OR 
                          c.customer_name LIKE '%".$search_value."%' OR 
                          model.model_name LIKE '%".$search_value."%' OR
                          vehicle.conduction_no LIKE '%".$search_value."%' OR 
                          vehicle.plate_no LIKE '%".$search_value."%')
                    ")."

                    ".($order_column==null?" ORDER BY c.customer_name ASC ":" ORDER BY ".$order_column." ".$order_dir."")."
                    ".($length==null?"":" LIMIT ".$length."")."
                    ".($start==0?"":" OFFSET ".$start."")."

                    ";
        return $this->db->query($sql)->result();
    }

}
?>