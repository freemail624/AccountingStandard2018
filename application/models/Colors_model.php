<?php

class Colors_model extends CORE_Model {
    protected  $table="colors";
    protected  $pk_id="color_id";

    function __construct() {
        parent::__construct();
    }

    function get_colors_list($color_id=null) {
        $sql="SELECT a.* FROM
                  colors as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($color_id==null?"":" AND a.color_id=$color_id")."";
        return $this->db->query($sql)->result();
    }

    function check_color($color,$color_id=null){
        $sql="SELECT * FROM colors 
            WHERE is_deleted = FALSE AND 
            color = '".$color."' 
            ".($color_id==null?"":" AND color_id!=$color_id")."";
        return $this->db->query($sql)->result();
    }


}
?>