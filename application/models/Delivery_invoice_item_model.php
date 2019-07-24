<?php

class Delivery_invoice_item_model extends CORE_Model {
    protected  $table="delivery_invoice_items";
    protected  $pk_id="dr_invoice_item_id";
    protected  $fk_id="dr_invoice_id";

    function __construct() {
        parent::__construct();
    }

    function get_fixed_asset_items($dr_invoice_id=null,$fixed_asset_accounts=null,$dr_invoice_item_id=null){
	      $sql="SELECT 
		    dii.*, di.*, u.unit_name, p.category_id, p.*,
		    DATE_FORMAT(di.date_delivered,'%m/%d/%Y') as date_delivered
		FROM
		    delivery_invoice_items dii
		        LEFT JOIN
		    delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
		        LEFT JOIN
		    products p ON p.product_id = dii.product_id
		        LEFT JOIN
		    units u ON u.unit_id = dii.unit_id
		WHERE
			di.is_active = TRUE
			AND di.is_deleted = FALSE
		        ".($dr_invoice_id==null?"":" AND dii.dr_invoice_id='".$dr_invoice_id."'")."
		        ".($fixed_asset_accounts==null?"":" AND p.expense_account_id IN(".$fixed_asset_accounts.")")."
		        ".($dr_invoice_item_id==null?"":" AND dii.dr_invoice_item_id='".$dr_invoice_item_id."'")."
		ORDER BY dii.dr_invoice_item_id ASC";
        return $this->db->query($sql)->result();
    }

}



?>