<?php

class Models_model extends CORE_Model {
    protected  $table="models";
    protected  $pk_id="model_id";

    function __construct() {
        parent::__construct();
    }

        function get_model_list($model_id=null){
            $sql="  SELECT
                      a.*
                    FROM
                      models as a
                    WHERE
                        a.is_deleted=FALSE AND a.is_active=TRUE
                    ".($model_id==null?"":" AND a.model_id=$model_id")."
                ";
            return $this->db->query($sql)->result();
        }
}
?>