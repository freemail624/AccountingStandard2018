<?php

class Sales_order_model extends CORE_Model
{
    protected $table = "sales_order";
    protected $pk_id = "sales_order_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_so_list($sales_order_id=null,$order_status_id=0,$department_id=0){
        $sql="SELECT 
                so.*,
                DATE_FORMAT(so.date_order,'%m/%d/%Y') as date_order,
                d.department_id,
                d.department_name,
                c.customer_name,
                ord_stat.order_status
            FROM
                sales_order so
                LEFT JOIN departments d ON d.department_id = so.department_id
                LEFT JOIN customers c ON c.customer_id = so.customer_id
                LEFT JOIN order_status ord_stat ON ord_stat.order_status_id = so.order_status_id
                WHERE 
                    so.is_deleted = FALSE AND
                    so.is_active = TRUE
                    ".($sales_order_id==null?"":" AND so.sales_order_id='".$sales_order_id."'")."
                    ".($order_status_id==0?"":" AND so.order_status_id='".$order_status_id."'")."
                    ".($department_id==0?"":" AND so.department_id='".$department_id."'")."
                    ORDER BY so.sales_order_id DESC";
            
            return $this->db->query($sql)->result();
    }

    function get_tbl_amount($order_status_id=0,$department_id=0){
        $sql="SELECT 
                COALESCE(SUM(soi.so_line_total_price), 0) AS total_tbl_amount
            FROM
                sales_order_items soi
                    LEFT JOIN
                sales_order so ON so.sales_order_id = soi.sales_order_id
                WHERE so.is_deleted = FALSE AND
                    so.is_active = TRUE
                ".($order_status_id==0?"":" AND so.order_status_id='".$order_status_id."'")."
                ".($department_id==0?"":" AND so.department_id='".$department_id."'")."";
            
            return $this->db->query($sql)->result();
    }

    function get_so_balance_qty($id){
        $sql="SELECT SUM(x.Balance)as Balance
        FROM
        (SELECT
        m.sales_order_id,
        m.so_no,m.product_id,

        SUM(m.SoQty) as SoQty,
        SUM(m.InvQty)as InvQty,
        (SUM(m.SoQty)-SUM(m.InvQty))as Balance


        FROM

        (SELECT so.sales_order_id,so.so_no,soi.product_id,SUM(soi.so_qty) as SoQty,0 as InvQty FROM sales_order as so
        INNER JOIN sales_order_items as soi ON so.sales_order_id=soi.sales_order_id
        WHERE so.sales_order_id=$id AND so.is_active=TRUE AND so.is_deleted=FALSE
        GROUP BY so.so_no,soi.product_id


        UNION ALL

        SELECT so.sales_order_id,so.so_no,sii.product_id,0 as SoQty,SUM(sii.inv_qty) as InvQty FROM (sales_invoice as si
        INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
        INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
        WHERE so.sales_order_id=$id AND si.is_active=TRUE AND si.is_deleted=FALSE
        GROUP BY so.so_no,sii.product_id

        UNION ALL

        SELECT 
        so.sales_order_id,
        so.so_no,
        cii.product_id,
        0 as SoQty,
        SUM(cii.inv_qty) as InvQty

        FROM
        (cash_invoice as ci
        INNER JOIN sales_order as so ON ci.sales_order_id = so.sales_order_id)
        INNER JOIN cash_invoice_items cii ON ci.cash_invoice_id = cii.cash_invoice_id
        WHERE so.sales_order_id = $id AND ci.is_active = TRUE AND ci.is_deleted = FALSE
        GROUP BY so.so_no, cii.product_id

        )as

        m GROUP BY m.so_no,m.product_id) as x";

        return $this->db->query($sql)->result();
    }



}


?>