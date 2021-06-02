<?php

class Sizes_model extends CORE_Model {
    protected  $table="sizes";
    protected  $pk_id="size_id";

    function __construct() {
        parent::__construct();
    }

        function get_size_list($size_id=null){
            $sql="  SELECT
                      a.*
                    FROM
                      sizes as a
                    WHERE
                        a.is_deleted=FALSE AND a.is_active=TRUE
                    ".($size_id==null?"":" AND a.size_id=$size_id")."
                ";
            return $this->db->query($sql)->result();
        }
}
?>