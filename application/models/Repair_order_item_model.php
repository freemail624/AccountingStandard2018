<?php

class Repair_order_item_model extends CORE_Model
{
    protected $table = "repair_order_items";
    protected $pk_id = "repair_order_item_id";
    protected $fk_id = "repair_order_id";

    function __construct()
    {
        parent::__construct();
    }

	function get_tbl_count_items($repair_order_id)
    {
        $query = $this->db->query("SELECT 
			    DISTINCT tbl_no, vehicle_service_id,
			    (CASE 
					WHEN tbl_no = 1 THEN ro.sdesc_1
					WHEN tbl_no = 2 THEN ro.sdesc_2
					WHEN tbl_no = 3 THEN ro.sdesc_3
					WHEN tbl_no = 4 THEN ro.sdesc_4
					WHEN tbl_no = 5 THEN ro.sdesc_5
					WHEN tbl_no = 6 THEN ro.sdesc_6
					WHEN tbl_no = 7 THEN ro.sdesc_7
					WHEN tbl_no = 8 THEN ro.sdesc_8
					WHEN tbl_no = 9 THEN ro.sdesc_9
					WHEN tbl_no = 10 THEN ro.sdesc_10
					WHEN tbl_no = 11 THEN ro.sdesc_11
					WHEN tbl_no = 12 THEN ro.sdesc_12
					WHEN tbl_no = 13 THEN ro.sdesc_13
					WHEN tbl_no = 14 THEN ro.sdesc_14
					WHEN tbl_no = 15 THEN ro.sdesc_15
					WHEN tbl_no = 16 THEN ro.sdesc_16
					WHEN tbl_no = 17 THEN ro.sdesc_17
					WHEN tbl_no = 18 THEN ro.sdesc_18
					WHEN tbl_no = 19 THEN ro.sdesc_19
					WHEN tbl_no = 20 THEN ro.sdesc_20
					WHEN tbl_no = 21 THEN ro.sdesc_21
					WHEN tbl_no = 22 THEN ro.sdesc_22
					WHEN tbl_no = 23 THEN ro.sdesc_23
					WHEN tbl_no = 24 THEN ro.sdesc_24
					WHEN tbl_no = 25 THEN ro.sdesc_25
					WHEN tbl_no = 26 THEN ro.sdesc_26
					WHEN tbl_no = 27 THEN ro.sdesc_27
					WHEN tbl_no = 28 THEN ro.sdesc_28
					WHEN tbl_no = 29 THEN ro.sdesc_29
					WHEN tbl_no = 30 THEN ro.sdesc_30
					ELSE ''
				END) as sdesc		    
			FROM
			    repair_order_items roi
        		LEFT JOIN repair_order ro ON ro.repair_order_id = roi.repair_order_id
			    WHERE roi.repair_order_id = $repair_order_id
			    ORDER BY tbl_no ASC");
        return $query->result();
    }

    function get_repair_order_items($repair_order_id)
    {
        $query = $this->db->query("SELECT 
			    roi.*,
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
			    u.unit_code
			FROM
			    repair_order_items roi
			        LEFT JOIN
			    products p ON p.product_id = roi.product_id
			        LEFT JOIN
			    units u ON u.unit_id = roi.unit_id
			        LEFT JOIN
			    units blkunit ON blkunit.unit_id = p.bulk_unit_id
			        LEFT JOIN
			    units chldunit ON chldunit.unit_id = p.parent_unit_id
			    WHERE roi.repair_order_id = $repair_order_id
			    ORDER BY roi.repair_order_item_id ASC");
        return $query->result();
    }

    function get_repair_order_inv_items($repair_order_id)
    {
        $query = $this->db->query("SELECT 
			    roi.*,
                SUM(roi.order_qty) as order_qty,
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
			    u.unit_code
			FROM
			    repair_order_items roi
			        LEFT JOIN
			    products p ON p.product_id = roi.product_id
			        LEFT JOIN
			    units u ON u.unit_id = roi.unit_id
			        LEFT JOIN
			    units blkunit ON blkunit.unit_id = p.bulk_unit_id
			        LEFT JOIN
			    units chldunit ON chldunit.unit_id = p.parent_unit_id
			    WHERE roi.repair_order_id = $repair_order_id
                AND p.item_type_id = 1
                GROUP BY product_id
			    ORDER BY roi.repair_order_item_id ASC");
        return $query->result();
    }

    function get_category_items($repair_order_id)
    {
        $query = $this->db->query("SELECT 
			    c.category_desc, roi.total_amount
			FROM
			    categories c
			        LEFT JOIN
			    (SELECT 
			        p.category_id, SUM(roi.order_gross) AS total_amount
			    FROM
			        repair_order_items roi
			    LEFT JOIN repair_order ro ON ro.repair_order_id = roi.repair_order_id
			    LEFT JOIN products p ON p.product_id = roi.product_id
			    WHERE
			        ro.is_deleted = FALSE
			            AND ro.is_active = TRUE
			            AND ro.repair_order_id = $repair_order_id
			    GROUP BY p.category_id) AS roi ON roi.category_id = c.category_id
			WHERE
			    c.is_deleted = FALSE
			        AND c.is_active = TRUE");
        return $query->result();
    }


}


?>