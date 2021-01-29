<?php

class Terms_model extends CORE_Model {
    protected  $table="terms";
    protected  $pk_id="term_id";

    function __construct() {
        parent::__construct();
    }

    function get_terms_list($term_id=null) {
        $sql="SELECT a.* FROM
                  terms as a
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($term_id==null?"":" AND a.term_id=$term_id")."";
        return $this->db->query($sql)->result();
    }

}
?>