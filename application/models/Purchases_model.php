<?php

class Purchases_model extends CORE_Model {
    protected  $table="purchase_order";
    protected  $pk_id="purchase_order_id";

    function __construct() {
        parent::__construct();
    }

    function get_po_list($purchase_order_id=null,$order_status_id=0){
        $sql="SELECT 
                po.*,
                terms.term_description,
                s.supplier_name,
                tax_types.tax_type,
                app_stat.approval_status,
                ord_stat.order_status,
                pr.pr_no,
                DATE_FORMAT(po.delivery_date, '%m/%d/%Y') AS delivery_date,
                (CASE
                    WHEN po.ship_out_date != null || po.ship_out_date != ''
                    THEN DATE_FORMAT(po.ship_out_date, '%m/%d/%Y')
                    ELSE ''
                END) as ship_out_date
            FROM
                purchase_order po
                    LEFT JOIN
                suppliers s ON s.supplier_id = po.supplier_id
                    LEFT JOIN
                tax_types ON tax_types.tax_type_id = po.tax_type_id
                    LEFT JOIN
                approval_status app_stat ON app_stat.approval_id = po.approval_id
                    LEFT JOIN
                order_status ord_stat ON ord_stat.order_status_id = po.order_status_id
                    LEFT JOIN
                purchase_request pr ON pr.purchase_request_id = po.purchase_request_id
                    LEFT JOIN
                terms ON terms.term_id = po.term_id
            WHERE
                po.is_deleted = FALSE
                    AND po.is_active = TRUE
                    ".($purchase_order_id==null?"":" AND po.purchase_order_id='".$purchase_order_id."'")."
                    ".($order_status_id==0?"":" AND po.order_status_id='".$order_status_id."'")."
            ORDER BY po.purchase_order_id DESC";
            return $this->db->query($sql)->result();
    }

    function get_tbl_amount($order_status_id=0){
        $sql="SELECT 
                COALESCE(SUM(poi.po_line_total_after_global), 0) AS total_tbl_amount
            FROM
                purchase_order_items poi
                    LEFT JOIN
                purchase_order po ON po.purchase_order_id = poi.purchase_order_id
                WHERE po.is_deleted = FALSE AND
                    po.is_active = TRUE
                ".($order_status_id==0?"":" AND po.order_status_id='".$order_status_id."'")."";
            
            return $this->db->query($sql)->result();
    }


    function get_po_balance_qty($id){
        $sql="SELECT SUM(x.Balance)as Balance
        FROM
        (SELECT
        m.purchase_order_id,
        m.po_no,m.product_id,

        SUM(m.PoQty) as PoQty,
        SUM(m.DrQty)as DrQty,
        (SUM(m.PoQty)-SUM(m.DrQty))as Balance


        FROM

        (SELECT po.purchase_order_id,po.po_no,poi.product_id,SUM(poi.po_qty) as PoQty,0 as DrQty FROM purchase_order as po
        INNER JOIN purchase_order_items as poi ON po.purchase_order_id=poi.purchase_order_id
        WHERE po.purchase_order_id=$id AND po.is_active=TRUE AND po.is_deleted=FALSE
        GROUP BY po.po_no,poi.product_id


        UNION ALL

        SELECT po.purchase_order_id,po.po_no,dii.product_id,0 as PoQty,SUM(dii.dr_qty) as DrQty FROM (delivery_invoice as di
        INNER JOIN purchase_order as po ON di.purchase_order_id=po.purchase_order_id)
        INNER JOIN delivery_invoice_items as dii ON di.dr_invoice_id=dii.dr_invoice_id
        WHERE po.purchase_order_id=$id AND di.is_active=TRUE AND di.is_deleted=FALSE
        GROUP BY po.po_no,dii.product_id)as

        m GROUP BY m.po_no,m.product_id) as x";

        return $this->db->query($sql)->result();
    }

}



?>