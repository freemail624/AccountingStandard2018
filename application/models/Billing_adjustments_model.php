<?php

class Billing_adjustments_model extends CORE_Model {
    protected  $table="b_adjustments";
    protected  $pk_id="adjustment_id";

    function __construct() {
        parent::__construct();
    }

    function getBillingAdjustmentList($is_approved,$department_id=0)
    {
        $query = $this->db->query("SELECT
	        	b_adjustments.*,
	        	IFNULL(b_adjustments.notes,'') as notes,
	            IF(b_adjustments.adjustment_type = 1,'OUT','IN') as adjustment_type,
	            b_tenants.trade_name,
	            b_refcharges.charge_desc,
	            CONCAT(DATE(b_refbillingperiod.period_start_date),' - ',DATE(b_refbillingperiod.period_end_date)) as period_date,
	            CONCAT(b_refmonths.month_name,' ',b_adjustments.app_year) as period_desc,
                departments.department_name
        	FROM b_adjustments
	        	LEFT JOIN b_tenants ON b_tenants.tenant_id = b_adjustments.tenant_id
	        	LEFT JOIN b_refmonths ON b_refmonths.month_id = b_adjustments.month_id
	        	LEFT JOIN b_refbillingperiod ON b_refbillingperiod.period_id = b_adjustments.period_id
	        	LEFT JOIN b_refcharges ON b_refcharges.charge_id = b_adjustments.charge_id
                LEFT JOIN departments ON departments.department_id = b_tenants.accounting_department_id
        	WHERE 
        		b_adjustments.is_deleted = FALSE AND
        		b_adjustments.is_approved = $is_approved
        		".($department_id==0?"":" AND b_tenants.accounting_department_id='".$department_id."'")."");
        return $query->result();
    }

}
?>