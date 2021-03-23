<?php
	class Advisor_model extends CORE_Model {
	    protected  $table="advisors";
	    protected  $pk_id="advisor_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_advisors_list($advisor_id=null) {
	        $sql="SELECT 
					    advisors.*,
					    CONCAT_WS(' ',advisor_fname,advisor_mname,advisor_lname) AS fullname,
					    d.department_name
					FROM
					    advisors
				    LEFT JOIN departments d ON d.department_id = advisors.department_id
				    WHERE advisors.is_deleted = FALSE
				    AND advisors.is_active = TRUE
	                ".($advisor_id==null?"":" AND advisors.advisor_id=$advisor_id")."";
	        return $this->db->query($sql)->result();
	    }

	}
?>