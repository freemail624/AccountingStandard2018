<?php

class Job_unit_model extends CORE_Model {
    protected  $table="job_unit";
    protected  $pk_id="job_unit_id";

    function __construct() {
        parent::__construct();
    }

    function get_job_unit_list($job_unit_id=null){
        $sql="  SELECT
                  a.*
                FROM
                  job_unit as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($job_unit_id==null?"":" AND a.job_unit_id=$job_unit_id")."
            ";
        return $this->db->query($sql)->result();
    }
}
?>