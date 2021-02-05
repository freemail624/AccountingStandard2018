<?php

class Travel_order_model extends CORE_Model {
    protected  $table="travel_order";
    protected  $pk_id="travel_order_id";

    function __construct() {
        parent::__construct();
    }

    function get_travel_list($travel_order_id=null){
        $sql="  SELECT
                  a.*,
                  DATE_FORMAT(travel_date,'%m/%d/%Y') as travel_date
                FROM
                  travel_order as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($travel_order_id==null?"":" AND a.travel_order_id=$travel_order_id")."
            ";
        return $this->db->query($sql)->result();
    }

}
?>