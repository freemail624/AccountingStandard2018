<?php

class Repair_order_model extends CORE_Model
{
    protected $table = "repair_order";
    protected $pk_id = "repair_order_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_all_data($search_value=null,$start_date=null,$end_date=null,$status=null,$advisor_id=null)
    {
        $sql="SELECT ro.* FROM 

		    repair_order ro
		        LEFT JOIN
		    customers c ON c.customer_id = ro.customer_id
		        LEFT JOIN
		    customer_vehicles v ON v.vehicle_id = ro.vehicle_id
		        LEFT JOIN
		    advisors ON advisors.advisor_id = ro.advisor_id
		    	LEFT JOIN
		    insurance ON insurance.insurance_id = ro.insurance_id

    		WHERE c.is_deleted = FALSE AND c.is_active = TRUE
				".($status== null ? "" : "AND repair_order_status = ". $status)."
				".($advisor_id== null ? "" : "AND ro.advisor_id = ". $advisor_id)."

	    	".($start_date==null?"":" AND DATE_FORMAT(ro.document_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")."
            ".($search_value==null?"":" 
            	AND (ro.repair_order_no LIKE '".$search_value."%' OR 
            	c.customer_no LIKE '%".$search_value."%' OR 
            	c.customer_name LIKE '%".$search_value."%' OR
            	v.plate_no LIKE '%".$search_value."%' OR 
            	CONCAT_WS(' ',advisors.advisor_fname,advisors.advisor_mname,advisors.advisor_lname) LIKE '%".$search_value."%')")."


        ";
        return $this->db->query($sql)->num_rows();
    }

    function get_repair_order(
		    $repair_order_id=null,
		    $start_date=null,
		    $end_date=null,
		    $search_value=null,
		    $length=null,
		    $start=0,
		    $order_column=null,
		    $order_dir=null,
				$status=null,
				$advisor_id=null){

        $query = $this->db->query("SELECT 
		    c.customer_no,
		    c.customer_name,
		    ro.*,
		    insurance.insurer_company,
		    v.plate_no,
		    CONCAT_WS(' ',
		            advisors.advisor_fname,
		            advisors.advisor_mname,
		            advisors.advisor_lname) AS advisor_fullname,
		    DATE_FORMAT(ro.document_date, '%d %b %Y') AS document_date,
		    DATE_FORMAT(ro.document_date, '%I:%i %p') AS time_received,
		    DATE_FORMAT(ro.date_time_promised,
		            '%d %b %Y   %I:%i %p') AS date_time_promised,
		    DATE_FORMAT(v.delivery_date, '%d %b %Y') AS delivery_date,
		    DATE_FORMAT(ro.next_svc_date, '%d %b %Y') AS next_svc_date,
		    DATE_FORMAT(ro.next_svc_date, '%m/%d/%Y') AS next_svc_date_edit,
		    DATE_FORMAT(v.delivery_date, '%m/%d/%Y') AS delivery_date_edit,
		    DATE_FORMAT(ro.document_date, '%m/%d/%Y %h:%i %p') AS document_date_edit,
		    DATE_FORMAT(ro.date_time_promised, '%m/%d/%Y %h:%i %p') AS date_time_promised_edit,
				ros.name as status

		FROM
		    repair_order ro
		        LEFT JOIN
		    customers c ON c.customer_id = ro.customer_id
		        LEFT JOIN
		    customer_vehicles v ON v.vehicle_id = ro.vehicle_id
		        LEFT JOIN
		    advisors ON advisors.advisor_id = ro.advisor_id
		    	LEFT JOIN
		    insurance ON insurance.insurance_id = ro.insurance_id
					LEFT JOIN
				repair_order_statuses ros ON ros.id = ro.repair_order_status

		    WHERE ro.is_deleted = FALSE AND
		    	ro.is_active = TRUE
					".($status== null ? "" : "AND repair_order_status = ". $status)."
					".($advisor_id== null ? "" : "AND ro.advisor_id = ". $advisor_id)."
	    		".($start_date==null?"":" AND DATE_FORMAT(ro.document_date, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")."
	    		".($repair_order_id==null?"":" AND ro.repair_order_id='".$repair_order_id."'")."

	            ".($search_value==null?"":" 
	            	AND (ro.repair_order_no LIKE '".$search_value."%' OR 
	            	c.customer_no LIKE '%".$search_value."%' OR 
	            	c.customer_name LIKE '%".$search_value."%' OR
	            	v.plate_no LIKE '%".$search_value."%' OR 
	            	CONCAT_WS(' ',advisors.advisor_fname,advisors.advisor_mname,advisors.advisor_lname) LIKE '%".$search_value."%')")."

	            ".($order_column==null?" ORDER BY ro.repair_order_id DESC ":" ORDER BY ".$order_column." ".$order_dir."")."
	            ".($length==null?"":" LIMIT ".$length."")."
	            ".($start==0?"":" OFFSET ".$start."")."
		    ");
        return $query->result();
    }

    function get_repair_order_issuance()
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
		    DATE_FORMAT(v.delivery_date, '%d %b %Y') AS delivery_date,
		    DATE_FORMAT(ro.next_svc_date, '%d %b %Y') AS next_svc_date,
		    DATE_FORMAT(ro.next_svc_date, '%m/%d/%Y') AS next_svc_date_edit,
		    DATE_FORMAT(v.delivery_date, '%m/%d/%Y') AS delivery_date_edit,
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
		    	ro.is_active = TRUE AND 
		    	ro.issued_status_id=0

	    	ORDER BY ro.repair_order_id DESC
		    ");
        return $query->result();
    }


    function get_repair_order_invoice()
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
		    DATE_FORMAT(v.delivery_date, '%d %b %Y') AS delivery_date,
		    DATE_FORMAT(ro.next_svc_date, '%d %b %Y') AS next_svc_date,
		    DATE_FORMAT(ro.next_svc_date, '%m/%d/%Y') AS next_svc_date_edit,
		    DATE_FORMAT(v.delivery_date, '%m/%d/%Y') AS delivery_date_edit,
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
		    	ro.is_active = TRUE AND 
		    	ro.ro_status_id=0

	    	ORDER BY ro.repair_order_id DESC
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

		function serviceReport($start_date=null,$end_date=null,$vehicle_service_id=null)
		{
			$query = $this->db->query("SELECT
					ro.repair_order_no,
					ro.document_date,
					CONCAT(customer_no, ' - ', customer_name) as customer_name,
					CONCAT_WS(' ',
		            a.advisor_fname,
		            a.advisor_mname,
		            a.advisor_lname) AS advisor,
					ro.crp_no as plate_no,
					roi.total_amount
				FROM repair_order ro
				LEFT JOIN customers c ON c.customer_id = ro.customer_id
				-- LEFT JOIN customer_vehicles v ON v.vehicle_id = ro.vehicle_id
				LEFT JOIN advisors a ON a.advisor_id = ro.advisor_id
				LEFT JOIN (
					SELECT
						repair_order_id,
								vehicle_service_id,
						SUM(IFNULL(order_line_total_after_global,0)) as total_amount
					FROM repair_order_items
					WHERE vehicle_service_id = ".$vehicle_service_id."
					GROUP BY repair_order_id
				) roi using(repair_order_id)
				WHERE roi.vehicle_service_id = ".$vehicle_service_id." 
				AND DATE(document_date) BETWEEN '".$start_date."' AND '".$end_date."';"
			);

			return $query->result();
		}


}

?>