<?php

class Bins_model extends CORE_Model {
    protected  $table="bins";
    protected  $pk_id="bin_id";

    function __construct() {
        parent::__construct();
    }

    function get_bin_list($bin_id=null){
        $sql="SELECT bins.* FROM bins
                WHERE bins.is_deleted = FALSE AND
                      bins.is_active = TRUE
            ".($bin_id==null?"":" AND bins.bin_id=$bin_id")."
            ORDER BY bins.bin_code";
        return $this->db->query($sql)->result();
    }

    function check_bin($bin_code,$bin_id=null){
        $sql="SELECT * FROM bins 
            WHERE is_deleted = FALSE AND bin_code = '".$bin_code."' 
            ".($bin_id==null?"":" AND bin_id!=$bin_id")."";
        return $this->db->query($sql)->result();
    }    
}
?>