<?php

class Cash_vouchers_model extends CORE_Model {
    protected  $table="cv_info";
    protected  $pk_id="cv_id";

    function __construct() {
        parent::__construct();
    }

     function check_validation($cv_id=null,$ref_type=null,$ref_no=null,$check_no=null){
	    $sql="SELECT * FROM cv_info
	    	WHERE is_deleted = FALSE
			".($cv_id==null?"":" AND cv_id!='".$cv_id."'")."
			".($ref_type==null?"":" AND ref_type='".$ref_type."'")."
			".($ref_no==null?"":" AND ref_no='".$ref_no."'")."
			".($check_no==null?"":" AND check_no='".$check_no."'")."";
		return $this->db->query($sql)->result();
     }
}
?>