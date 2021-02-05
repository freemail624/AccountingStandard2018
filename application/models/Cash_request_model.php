<?php

class Cash_request_model extends CORE_Model {
    protected  $table="cash_request";
    protected  $pk_id="cash_request_id";

    function __construct() {
        parent::__construct();
    }

    function get_request_list($cash_request_id=null){
        $sql="  SELECT
                  a.*,
                  DATE_FORMAT(request_date,'%m/%d/%Y') as request_date,
                  DATE_FORMAT(date_needed,'%m/%d/%Y') as date_needed
                FROM
                  cash_request as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($cash_request_id==null?"":" AND a.cash_request_id=$cash_request_id")."
            ";
        return $this->db->query($sql)->result();
    }

}
?>