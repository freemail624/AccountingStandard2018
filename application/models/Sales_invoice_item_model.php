<?php

class Sales_invoice_item_model extends CORE_Model
{
    protected $table = "sales_invoice_items";
    protected $pk_id = "sales_item_id";
    protected $fk_id = "sales_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_sales_wo_cost(){
        $sql="SELECT * FROM sales_invoice_items WHERE cost_upon_invoice <= 0";
        return $this->db->query($sql)->result();
    }

    function get_item($sales_invoice_id,$product_id){

        $sql="SELECT 
            sii.*
        FROM
            sales_invoice_items sii
            WHERE sii.sales_invoice_id = $sales_invoice_id AND 
                sii.product_id = $product_id";
        return $this->db->query($sql)->result();
    }

    function get_adj_return_list($id){
        $sql="SELECT 
            sii.*,
            p.product_desc,
            COALESCE(returns.adjust_qty,0) as adjust_qty
        FROM
            sales_invoice_items sii
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
            LEFT JOIN products p ON p.product_id = sii.product_id
            LEFT JOIN 
            
            (SELECT 
            si.sales_invoice_id,
            SUM(aii.adjust_qty) as adjust_qty,
            aii.product_id 
            FROM 
            adjustment_items aii
            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN sales_invoice si ON si.sales_inv_no = ai.inv_no
            WHERE ai.is_returns = TRUE AND ai.is_deleted = FALSE AND si.sales_invoice_id = $id
            GROUP BY aii.product_id) as returns ON returns.product_id = sii.product_id

            WHERE si.sales_invoice_id = $id";
        return $this->db->query($sql)->result();
    }
}


?>