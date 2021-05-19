<?php

class Purchases_model extends CORE_Model {
    protected  $table="purchase_order";
    protected  $pk_id="purchase_order_id";

    function __construct() {
        parent::__construct();
    }

    function get_po_for_approval($filter_by){
        $sql="SELECT 

        po.*,
        s.supplier_name,
        COUNT(pa.po_attachment_id) as attachment,
        CONCAT_WS(' ',po.terms,po.duration)As term_description,
        CONCAT_WS(' ',ua.user_fname,ua.user_lname)as posted_by

        FROM
        purchase_order po
        LEFT JOIN suppliers s ON po.supplier_id = s.supplier_id
        LEFT JOIN user_accounts ua ON ua.user_id = po.posted_by_user
        LEFT JOIN po_attachments pa ON pa.purchase_order_id = po.purchase_order_id

        WHERE po.is_active = TRUE AND
            po.is_deleted = FALSE AND
            po.approval_id = 2 AND 
            po.is_reviewed = TRUE AND
            po.is_checked = FALSE AND
            po.total_after_discount $filter_by

        GROUP BY po.purchase_order_id
        ORDER BY po.purchase_order_id DESC
        ";
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