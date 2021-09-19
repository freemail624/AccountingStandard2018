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

	function get_tbl_count_items($id)
	{
		$query = $this->db->query("SELECT 
		main.*
		FROM
		(
			SELECT 1 as tbl_no, 1 as vehicle_service_id, sdesc_1 as sdesc, instruct_1 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 2 as tbl_no, 1 as vehicle_service_id, sdesc_2 as sdesc, instruct_2 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 3 as tbl_no, 1 as vehicle_service_id, sdesc_3 as sdesc, instruct_3 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 4 as tbl_no, 1 as vehicle_service_id, sdesc_4 as sdesc, instruct_4 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 5 as tbl_no, 1 as vehicle_service_id, sdesc_5 as sdesc, instruct_5 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 6 as tbl_no, 1 as vehicle_service_id, sdesc_6 as sdesc, instruct_6 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 7 as tbl_no, 1 as vehicle_service_id, sdesc_7 as sdesc, instruct_7 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 8 as tbl_no, 1 as vehicle_service_id, sdesc_8 as sdesc, instruct_8 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 9 as tbl_no, 1 as vehicle_service_id, sdesc_9 as sdesc, instruct_9 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 10 as tbl_no, 1 as vehicle_service_id, sdesc_10 as sdesc, instruct_10 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL

			SELECT 11 as tbl_no, 2 as vehicle_service_id, sdesc_11 as sdesc, instruct_11 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 12 as tbl_no, 2 as vehicle_service_id, sdesc_12 as sdesc, instruct_12 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 13 as tbl_no, 2 as vehicle_service_id, sdesc_13 as sdesc, instruct_13 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 14 as tbl_no, 2 as vehicle_service_id, sdesc_14 as sdesc, instruct_14 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 15 as tbl_no, 2 as vehicle_service_id, sdesc_15 as sdesc, instruct_15 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 16 as tbl_no, 2 as vehicle_service_id, sdesc_16 as sdesc, instruct_16 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 17 as tbl_no, 2 as vehicle_service_id, sdesc_17 as sdesc, instruct_17 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 18 as tbl_no, 2 as vehicle_service_id, sdesc_18 as sdesc, instruct_18 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 19 as tbl_no, 2 as vehicle_service_id, sdesc_19 as sdesc, instruct_19 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 20 as tbl_no, 2 as vehicle_service_id, sdesc_20 as sdesc, instruct_20 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL

			SELECT 21 as tbl_no, 3 as vehicle_service_id, sdesc_21 as sdesc, instruct_21 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 22 as tbl_no, 3 as vehicle_service_id, sdesc_22 as sdesc, instruct_22 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 23 as tbl_no, 3 as vehicle_service_id, sdesc_23 as sdesc, instruct_23 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 24 as tbl_no, 3 as vehicle_service_id, sdesc_24 as sdesc, instruct_24 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 25 as tbl_no, 3 as vehicle_service_id, sdesc_25 as sdesc, instruct_25 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 26 as tbl_no, 3 as vehicle_service_id, sdesc_26 as sdesc, instruct_26 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 27 as tbl_no, 3 as vehicle_service_id, sdesc_27 as sdesc, instruct_27 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 28 as tbl_no, 3 as vehicle_service_id, sdesc_28 as sdesc, instruct_28 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 29 as tbl_no, 3 as vehicle_service_id, sdesc_29 as sdesc, instruct_29 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 30 as tbl_no, 3 as vehicle_service_id, sdesc_30 as sdesc, instruct_30 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL

			SELECT 31 as tbl_no, 4 as vehicle_service_id, sdesc_31 as sdesc, instruct_31 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 32 as tbl_no, 4 as vehicle_service_id, sdesc_32 as sdesc, instruct_32 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 33 as tbl_no, 4 as vehicle_service_id, sdesc_33 as sdesc, instruct_33 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 34 as tbl_no, 4 as vehicle_service_id, sdesc_34 as sdesc, instruct_34 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 35 as tbl_no, 4 as vehicle_service_id, sdesc_35 as sdesc, instruct_35 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 36 as tbl_no, 4 as vehicle_service_id, sdesc_36 as sdesc, instruct_36 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 37 as tbl_no, 4 as vehicle_service_id, sdesc_37 as sdesc, instruct_37 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 38 as tbl_no, 4 as vehicle_service_id, sdesc_38 as sdesc, instruct_38 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 39 as tbl_no, 4 as vehicle_service_id, sdesc_39 as sdesc, instruct_39 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 40 as tbl_no, 4 as vehicle_service_id, sdesc_40 as sdesc, instruct_40 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL


			SELECT 41 as tbl_no, 5 as vehicle_service_id, sdesc_41 as sdesc, instruct_41 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 42 as tbl_no, 5 as vehicle_service_id, sdesc_42 as sdesc, instruct_42 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 43 as tbl_no, 5 as vehicle_service_id, sdesc_43 as sdesc, instruct_43 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 44 as tbl_no, 5 as vehicle_service_id, sdesc_44 as sdesc, instruct_44 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 45 as tbl_no, 5 as vehicle_service_id, sdesc_45 as sdesc, instruct_45 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 46 as tbl_no, 5 as vehicle_service_id, sdesc_46 as sdesc, instruct_46 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 47 as tbl_no, 5 as vehicle_service_id, sdesc_47 as sdesc, instruct_47 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 48 as tbl_no, 5 as vehicle_service_id, sdesc_48 as sdesc, instruct_48 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 49 as tbl_no, 5 as vehicle_service_id, sdesc_49 as sdesc, instruct_49 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 50 as tbl_no, 5 as vehicle_service_id, sdesc_50 as sdesc, instruct_50 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL

			SELECT 51 as tbl_no, 6 as vehicle_service_id, sdesc_51 as sdesc, instruct_51 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 52 as tbl_no, 6 as vehicle_service_id, sdesc_52 as sdesc, instruct_52 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 53 as tbl_no, 6 as vehicle_service_id, sdesc_53 as sdesc, instruct_53 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 54 as tbl_no, 6 as vehicle_service_id, sdesc_54 as sdesc, instruct_54 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 55 as tbl_no, 6 as vehicle_service_id, sdesc_55 as sdesc, instruct_55 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 56 as tbl_no, 6 as vehicle_service_id, sdesc_56 as sdesc, instruct_56 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 57 as tbl_no, 6 as vehicle_service_id, sdesc_57 as sdesc, instruct_57 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 58 as tbl_no, 6 as vehicle_service_id, sdesc_58 as sdesc, instruct_58 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 59 as tbl_no, 6 as vehicle_service_id, sdesc_59 as sdesc, instruct_59 as instruction FROM repair_order WHERE repair_order_id = $id UNION ALL
			SELECT 60 as tbl_no, 6 as vehicle_service_id, sdesc_60 as sdesc, instruct_60 as instruction FROM repair_order WHERE repair_order_id = $id
		)as main
		WHERE main.sdesc != '' AND main.sdesc IS NOT NULL");
		return $query->result();
	}

	// function get_tbl_count_items($repair_order_id)
    // {
    //     $query = $this->db->query("SELECT 
	// 		    DISTINCT tbl_no, vehicle_service_id,
	// 		    (CASE 
	// 				WHEN tbl_no = 1 THEN ro.sdesc_1
	// 				WHEN tbl_no = 2 THEN ro.sdesc_2
	// 				WHEN tbl_no = 3 THEN ro.sdesc_3
	// 				WHEN tbl_no = 4 THEN ro.sdesc_4
	// 				WHEN tbl_no = 5 THEN ro.sdesc_5
	// 				WHEN tbl_no = 6 THEN ro.sdesc_6
	// 				WHEN tbl_no = 7 THEN ro.sdesc_7
	// 				WHEN tbl_no = 8 THEN ro.sdesc_8
	// 				WHEN tbl_no = 9 THEN ro.sdesc_9
	// 				WHEN tbl_no = 10 THEN ro.sdesc_10
	// 				WHEN tbl_no = 11 THEN ro.sdesc_11
	// 				WHEN tbl_no = 12 THEN ro.sdesc_12
	// 				WHEN tbl_no = 13 THEN ro.sdesc_13
	// 				WHEN tbl_no = 14 THEN ro.sdesc_14
	// 				WHEN tbl_no = 15 THEN ro.sdesc_15
	// 				WHEN tbl_no = 16 THEN ro.sdesc_16
	// 				WHEN tbl_no = 17 THEN ro.sdesc_17
	// 				WHEN tbl_no = 18 THEN ro.sdesc_18
	// 				WHEN tbl_no = 19 THEN ro.sdesc_19
	// 				WHEN tbl_no = 20 THEN ro.sdesc_20
	// 				WHEN tbl_no = 21 THEN ro.sdesc_21
	// 				WHEN tbl_no = 22 THEN ro.sdesc_22
	// 				WHEN tbl_no = 23 THEN ro.sdesc_23
	// 				WHEN tbl_no = 24 THEN ro.sdesc_24
	// 				WHEN tbl_no = 25 THEN ro.sdesc_25
	// 				WHEN tbl_no = 26 THEN ro.sdesc_26
	// 				WHEN tbl_no = 27 THEN ro.sdesc_27
	// 				WHEN tbl_no = 28 THEN ro.sdesc_28
	// 				WHEN tbl_no = 29 THEN ro.sdesc_29
	// 				WHEN tbl_no = 30 THEN ro.sdesc_30
	// 				ELSE ''
	// 			END) as sdesc		    
	// 		FROM
	// 		    repair_order_items roi
    //     		LEFT JOIN repair_order ro ON ro.repair_order_id = roi.repair_order_id
	// 		    WHERE roi.repair_order_id = $repair_order_id
	// 		    ORDER BY tbl_no ASC");
    //     return $query->result();
    // }

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
				p.item_type_id,
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
			        p.category_id, SUM(roi.order_line_total_after_global) AS total_amount
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