<?php
	class Insurance_model extends CORE_Model {
	    protected  $table="insurance";
	    protected  $pk_id="insurance_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_insurance_list($insurance_id=null) {
	        $sql="SELECT 
					    insurance.*,
					    CONCAT_WS(' ',ua.user_fname,ua.user_mname,ua.user_lname) AS posted_by
					FROM
					    insurance
				    LEFT JOIN user_accounts ua ON ua.user_id = insurance.posted_by_user
				    WHERE 
				    	insurance.is_deleted = FALSE AND
				    	insurance.is_active = TRUE
	                	".($insurance_id==null?"":" AND insurance.insurance_id=$insurance_id")."";
	        return $this->db->query($sql)->result();
	    }

	}
?>