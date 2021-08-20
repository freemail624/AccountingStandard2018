<?php

class Receivable_payment_list_model extends CORE_Model
{
    protected $table = "receivable_payments_list";
    protected $pk_id = "payment_list_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_adjustments($payment_id=0)
    {
        $sql  = "SELECT
	            rp.receipt_no,
                main.*
            FROM
                (SELECT 
                    rpl.*,
                        si.sales_inv_no,
                        COALESCE(ai.adjustment_id, 0) AS adjustment_id
                FROM
                    receivable_payments_list rpl
                LEFT JOIN sales_invoice si ON si.sales_invoice_id = rpl.sales_invoice_id
                LEFT JOIN adjustment_info ai ON ai.inv_no = si.sales_inv_no
                WHERE
                    payment_id = $payment_id) AS main
            LEFT JOIN receivable_payments rp ON rp.payment_id = main.payment_id
            WHERE
                main.adjustment_id > 0";
        return $this->db->query($sql)->result();
    }

    function get_customer($customer_name,$customer_id=null){
        $sql="SELECT * FROM customers 
            WHERE is_deleted = FALSE AND 
            customer_name = '".$customer_name."' 
            ".($customer_id==null?"":" AND customer_id!=$customer_id")."";
        return $this->db->query($sql)->result();
    }


}



?>