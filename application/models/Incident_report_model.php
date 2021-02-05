<?php

class Incident_report_model extends CORE_Model {
    protected  $table="incident_report";
    protected  $pk_id="incident_report_id";

    function __construct() {
        parent::__construct();
    }

    function get_incident_list($incident_report_id=null){
        $sql="  SELECT
                  a.*,
                  DATE_FORMAT(incident_date_time,'%m/%d/%Y %h:%i') as incident_date_time
                FROM
                  incident_report as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($incident_report_id==null?"":" AND a.incident_report_id=$incident_report_id")."
            ";
        return $this->db->query($sql)->result();
    }

}
?>