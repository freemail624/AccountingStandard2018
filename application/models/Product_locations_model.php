<?php

class Product_locations_model extends CORE_Model {
    protected  $table="product_locations";
    protected  $pk_id="product_location_id";

    function __construct() {
        parent::__construct();
    }

    function get_location_list($product_location_id=null) {
        $sql="  SELECT
                  a.*
                FROM
                  product_locations as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($product_location_id==null?"":" AND a.product_location_id=$product_location_id")."
            ";
        return $this->db->query($sql)->result();
    }
}
?>