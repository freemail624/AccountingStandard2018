<?php

class Makes_model extends CORE_Model {
    protected  $table="makes";
    protected  $pk_id="make_id";

    function __construct() {
        parent::__construct();
    }

        function get_makes_list($make_id=null){
            $sql="  SELECT
                      a.*
                    FROM
                      makes as a
                    WHERE
                        a.is_deleted=FALSE AND a.is_active=TRUE
                    ".($make_id==null?"":" AND a.make_id=$make_id")."
                ";
            return $this->db->query($sql)->result();
        }
}
?>