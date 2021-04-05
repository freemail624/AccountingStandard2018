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

    function get_service_invoice_items($service_invoice_id)
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
			    ORDER BY sii.service_item_id ASC");
        return $query->result();
    }

}


?>