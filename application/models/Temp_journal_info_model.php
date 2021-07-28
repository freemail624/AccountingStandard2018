<?php

class Temp_journal_info_model extends CORE_Model
{
    protected  $table = "temp_journal_info"; //table name
    protected  $pk_id = "temp_journal_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getBillingPaymentList($department_id=0)
    {
        $query = $this->db->query("
                SELECT 
                    temp_journal_info.*,
                    customers.customer_name,
                    departments.department_name,
                    b_payment_info.transaction_no,
                    b_payment_info.reference_no,
                    b_payment_info.remarks,
                    IF(b_payment_info.payment_type = 1, DATEDIFF(b_payment_info.check_date,NOW()),0) as rem_day_for_due
                FROM temp_journal_info
                LEFT JOIN customers ON customers.customer_id = temp_journal_info.customer_id
                LEFT JOIN departments ON departments.department_id = customers.link_department_id
                LEFT JOIN b_payment_info ON b_payment_info.payment_id = temp_journal_info.payment_id
                WHERE 
                    temp_journal_info.is_deleted = FALSE AND
                    temp_journal_info.is_active = TRUE AND
                    temp_journal_info.is_journal_posted = FALSE AND
                    temp_journal_info.is_sales = FALSE AND 
                    temp_journal_info.book_type_id = 1 AND
                    b_payment_info.used_security_deposit <= 0
                    ".($department_id==0?"":" AND customers.link_department_id='".$department_id."'")."");
        return $query->result();
    }


    function getBillingList($department_id=0)
    {
        $query = $this->db->query("SELECT 
        		tji.*, c.customer_name,
        		CONCAT(m.month_name,' ',billing.app_year) as billing_period,
                d.department_name
        	FROM temp_journal_info tji 
        	LEFT JOIN customers c ON c.customer_id = tji.customer_id
        	LEFT JOIN b_billing_info billing ON billing.billing_no = tji.ref_no
        	LEFT JOIN b_refmonths m ON m.month_id = billing.month_id
            LEFT JOIN departments d ON d.department_id = c.link_department_id
        	WHERE 
                tji.is_deleted = FALSE AND
        		tji.is_sales = TRUE AND
        		tji.book_type_id = 0 AND
        		tji.is_journal_posted = FALSE
        		".($department_id==0?"":" AND c.link_department_id='".$department_id."'")."");
        return $query->result();
    }

    function getBillingAdvancesList($department_id=0)
    {
        $query = $this->db->query("SELECT 
                tji.*, c.customer_name,
                d.department_name
            FROM temp_journal_info tji 
            LEFT JOIN customers c ON c.customer_id = tji.customer_id
            LEFT JOIN departments d ON d.department_id = c.link_department_id
            LEFT JOIN b_contract_other_fees fees ON fees.fee_id = tji.fee_id
            WHERE 
                tji.is_deleted = FALSE AND
                tji.book_type_id = 2 AND
                fees.fee_type_id != 2 AND
                tji.is_journal_posted = FALSE
                ".($department_id==0?"":" AND c.link_department_id='".$department_id."'")."");
        return $query->result();
    }    

    function getBillingSecDepList($department_id=0)
    {
        $query = $this->db->query("
                SELECT 
                    temp_journal_info.*,
                    customers.customer_name,
                    departments.department_name,
                    IFNULL(b_payment_info.transaction_no, '') as transaction_no,
                    IFNULL(b_payment_info.reference_no, fees.fee_no) as ref_no,
                    IFNULL(b_payment_info.remarks, temp_journal_info.remarks) as remarks,
                    IF(b_payment_info.payment_type = 1, DATEDIFF(b_payment_info.check_date,NOW()),0) as rem_day_for_due
                FROM temp_journal_info
                LEFT JOIN customers ON customers.customer_id = temp_journal_info.customer_id
                LEFT JOIN departments ON departments.department_id = customers.link_department_id
                LEFT JOIN b_payment_info ON b_payment_info.payment_id = temp_journal_info.payment_id
                LEFT JOIN b_contract_other_fees fees ON fees.fee_id = temp_journal_info.fee_id
                WHERE 
                    temp_journal_info.is_deleted = FALSE AND
                    temp_journal_info.is_active = TRUE AND
                    temp_journal_info.is_journal_posted = FALSE AND
                    (b_payment_info.used_security_deposit > 0 OR fees.fee_type_id = 2)
                    ".($department_id==0?"":" AND customers.link_department_id='".$department_id."'")."");
        return $query->result();
    }

}

?>