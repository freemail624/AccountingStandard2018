<?php

class Repair_order_model extends CORE_Model
{
    protected $table = "repair_order";
    protected $pk_id = "repair_order_id";

    function __construct()
    {
        parent::__construct();
    }


    function get_repair_order($repair_order_id=null,$start_date=null,$end_date=null)
    {
        $query = $this->db->query("SELECT 
		    c.customer_no,
		    c.customer_name,
		    ro.*,
		    v.plate_no,
		    CONCAT_WS(' ',
		            advisors.advisor_fname,
		            advisors.advisor_mname,
		            advisors.advisor_lname) AS advisor_fullname,
		    DATE_FORMAT(ro.document_date, '%d %b %Y') AS document_date,
		    DATE_FORMAT(ro.document_date, '%I:%i %p') AS time_received,
		    DATE_FORMAT(ro.date_time_promised,
		            '%d %b %Y   %I:%i %p') AS date_time_promised,
		    DATE_FORMAT(ro.delivery_date, '%d %b %Y') AS delivery_date,
		    DATE_FORMAT(ro.next_svc_date, '%d %b %Y') AS next_svc_date,
		    DATE_FORMAT(ro.next_svc_date, '%m/%d/%Y') AS next_svc_date_edit,
		    DATE_FORMAT(ro.delivery_date, '%m/%d/%Y') AS delivery_date_edit,
		    DATE_FORMAT(ro.document_date, '%m/%d/%Y %h:%i %p') AS document_date_edit,
		    DATE_FORMAT(ro.date_time_promised, '%m/%d/%Y %h:%i %p') AS date_time_promised_edit

		FROM
		    repair_order ro
		        LEFT JOIN
		    customers c ON c.customer_id = ro.customer_id
		        LEFT JOIN
		    customer_vehicles v ON v.vehicle_id = ro.vehicle_id
		        LEFT JOIN
		    advisors ON advisors.advisor_id = ro.advisor_id

		    WHERE ro.is_deleted = FALSE AND
		    	ro.is_active = TRUE
	    		".($start_date==null?"":" AND DATE_FORMAT(ro.document_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")."
	    		".($repair_order_id==null?"":" AND ro.repair_order_id='".$repair_order_id."'")."
		    ");
        return $query->result();
    }

    function get_customer_history($customer_id,$vehicle_id,$repair_order_id)
    {
        $query = $this->db->query("SELECT 
		    DATE_FORMAT(ro.document_date, '%m/%d/%Y') AS document_date,
		    ro.repair_order_no,
		    ro.km_reading,
		    CONCAT_WS(' ',
		            a.advisor_fname,
		            a.advisor_mname,
		            a.advisor_lname) AS advisor_fullname
		FROM
		    repair_order ro
		        LEFT JOIN
		    advisors a ON a.advisor_id = ro.advisor_id
		WHERE
		    ro.customer_id = $customer_id
		        AND ro.vehicle_id = $vehicle_id
		        AND ro.repair_order_id != $repair_order_id
		        AND ro.is_deleted = FALSE AND ro.is_active = TRUE
		        ORDER BY ro.repair_order_id DESC
		        LIMIT 5");

        return $query->result();
    }


}

?>