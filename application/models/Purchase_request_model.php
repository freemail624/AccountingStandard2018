<?php

class Purchase_request_model extends CORE_Model {
    protected  $table="purchase_request";
    protected  $pk_id="purchase_request_id";

    function __construct() {
        parent::__construct();
    }


    function get_pr_balance_qty($id){
        $sql="SELECT SUM(x.Balance)as Balance
        FROM
        (SELECT
        m.purchase_request_id,
        m.pr_no,m.product_id,

        SUM(m.PrQty)as PrQty,
        SUM(m.PoQty) as PoQty,
        (SUM(m.PoQty)-SUM(m.PrQty))as Balance


        FROM

        (SELECT 
            pr.purchase_request_id,
            pr.pr_no,pri.product_id,
            SUM(pri.po_qty) as PoQty,
            0 as PrQty 

            FROM purchase_request as pr
        INNER JOIN purchase_request_items as pri ON pr.purchase_request_id=pri.purchase_request_id
        WHERE pr.purchase_request_id=$id AND pr.is_active=TRUE AND pr.is_deleted=FALSE
        GROUP BY pr.pr_no,pri.product_id


        UNION ALL

        SELECT po.purchase_request_id,pr.pr_no,poi.product_id,0 as PoQty,SUM(poi.po_qty) as PrQty 
        FROM (purchase_order as po
        INNER JOIN purchase_request as pr ON po.purchase_request_id=pr.purchase_request_id)
        INNER JOIN purchase_order_items as poi ON po.purchase_order_id=poi.purchase_order_id
        WHERE po.purchase_request_id=$id AND po.is_active=TRUE AND po.is_deleted=FALSE
        GROUP BY pr.pr_no,poi.product_id)as

        m GROUP BY m.pr_no,m.product_id) as x";

        return $this->db->query($sql)->result();
    }

}



?>