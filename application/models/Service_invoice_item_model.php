<?php

class Service_invoice_item_model extends CORE_Model
{
    protected $table = "service_invoice_items";
    protected $pk_id = "service_item_id";
    protected $fk_id = "service_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

	function get_invoice_tbl_count_items($service_invoice_id, $is_insured = null)
    {
        $query = $this->db->query("SELECT 
			    DISTINCT tbl_no, vehicle_service_id,
			    (CASE 
					WHEN tbl_no = 1 THEN si.sdesc_1
					WHEN tbl_no = 2 THEN si.sdesc_2
					WHEN tbl_no = 3 THEN si.sdesc_3
					WHEN tbl_no = 4 THEN si.sdesc_4
					WHEN tbl_no = 5 THEN si.sdesc_5
					WHEN tbl_no = 6 THEN si.sdesc_6
					WHEN tbl_no = 7 THEN si.sdesc_7
					WHEN tbl_no = 8 THEN si.sdesc_8
					WHEN tbl_no = 9 THEN si.sdesc_9
					WHEN tbl_no = 10 THEN si.sdesc_10
					WHEN tbl_no = 11 THEN si.sdesc_11
					WHEN tbl_no = 12 THEN si.sdesc_12
					WHEN tbl_no = 13 THEN si.sdesc_13
					WHEN tbl_no = 14 THEN si.sdesc_14
					WHEN tbl_no = 15 THEN si.sdesc_15
					WHEN tbl_no = 16 THEN si.sdesc_16
					WHEN tbl_no = 17 THEN si.sdesc_17
					WHEN tbl_no = 18 THEN si.sdesc_18
					WHEN tbl_no = 19 THEN si.sdesc_19
					WHEN tbl_no = 20 THEN si.sdesc_20
					WHEN tbl_no = 21 THEN si.sdesc_21
					WHEN tbl_no = 22 THEN si.sdesc_22
					WHEN tbl_no = 23 THEN si.sdesc_23
					WHEN tbl_no = 24 THEN si.sdesc_24
					WHEN tbl_no = 25 THEN si.sdesc_25
					WHEN tbl_no = 26 THEN si.sdesc_26
					WHEN tbl_no = 27 THEN si.sdesc_27
					WHEN tbl_no = 28 THEN si.sdesc_28
					WHEN tbl_no = 29 THEN si.sdesc_29
					WHEN tbl_no = 30 THEN si.sdesc_30
					ELSE ''
				END) as sdesc		    
			FROM
			    service_invoice_items sii
        		LEFT JOIN service_invoice si ON si.service_invoice_id = sii.service_invoice_id
			    WHERE sii.service_invoice_id = $service_invoice_id
					" . ($is_insured === null ? "" : " AND sii.is_insured=" . $is_insured) . "
			    ORDER BY tbl_no ASC");
        return $query->result();
    }

    function get_service_invoice_items($service_invoice_id, $is_insured = null)
    {
        $query = $this->db->query("SELECT 
			    sii.*,
			    p.product_code,
			    p.product_desc,
			    p.sale_price,
			    p.is_bulk,
			    p.is_basyo,
			    p.child_unit_id,
			    p.parent_unit_id,
			    p.child_unit_desc,
			    p.discounted_price,
			    p.dealer_price,
			    p.distributor_price,
			    p.public_price,
			    (CASE
			        WHEN p.is_parent = TRUE THEN p.bulk_unit_id
			        ELSE p.parent_unit_id
			    END) AS product_unit_id,
			    (CASE
			        WHEN p.is_parent = TRUE THEN blkunit.unit_name
			        ELSE chldunit.unit_name
			    END) AS product_unit_name,
			    (SELECT units.unit_name FROM units WHERE units.unit_id = p.parent_unit_id) AS parent_unit_name,
			    (SELECT units.unit_name FROM units WHERE units.unit_id = p.child_unit_id) AS child_unit_name,
			    (SELECT COUNT(*) FROM account_integration WHERE basyo_product_id = p.product_id) AS is_product_basyo,
			    u.unit_code,
			    u.unit_name
			FROM
			    service_invoice_items sii
			        LEFT JOIN
			    products p ON p.product_id = sii.product_id
			        LEFT JOIN
			    units u ON u.unit_id = sii.unit_id
			        LEFT JOIN
			    units blkunit ON blkunit.unit_id = p.bulk_unit_id
			        LEFT JOIN
			    units chldunit ON chldunit.unit_id = p.parent_unit_id
			    WHERE sii.service_invoice_id = $service_invoice_id
					" . ($is_insured === null ? "" : " AND sii.is_insured=" . $is_insured) . "
			    ORDER BY sii.service_item_id ASC");
        return $query->result();
    }

}


?>