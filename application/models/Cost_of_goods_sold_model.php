<?php

class Cost_of_goods_sold_model extends CORE_Model {
    protected  $table="products";
    protected  $pk_id="product_id";

    function __construct() {
        parent::__construct();
    }



    function get_purchases_for_cogs($department_id=null,$start_date,$end_date) {
        $sql="SELECT 
            di.dr_invoice_no,
            s.supplier_name,
            DATE_FORMAT(di.date_delivered,'%M %d, %Y')as delivered_date,
            p.product_desc,
            IFNULL(dii.dr_qty,0) as qty,
            IFNULL(dii.dr_price,0) as price,
            dii.dr_line_total_price

            FROM

            delivery_invoice_items as dii
            LEFT JOIN delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
            LEFT JOIN products p on p.product_id = dii.product_id
            LEFT JOIN suppliers s ON s.supplier_id= di.supplier_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE
            AND di.date_delivered BETWEEN '$start_date' AND '$end_date'
            AND di.is_finalized = TRUE
            AND p.is_active = TRUE AND p.is_deleted = FALSE AND p.item_type_id = 1
            ".($department_id==1||$department_id==null?"":" AND di.department_id=$department_id")."
            ";
        return $this->db->query($sql)->result();
    }

    function get_merchandise_inventory_for_cogs($department=null,$as_of_date) {
        $sql="
            SELECT m.product_id,m.product_desc,
            (m.pbalance + m.cbalance) as balance,
            m.avg_cost,
            (IFNULL(ROUND(m.avg_cost,2),0)*IFNULL(ROUND(m.pbalance,2) + ROUND(m.cbalance,2),0)) as avg_net
            
            FROM
            (SELECT main.*,

            (ReceiveQty+AdjInQty-AdjOutQty-CashOutQty-SaleOutQty+IssueInQty-IssueOutQty) as pbalance,
            (CASE
                WHEN main.is_parent = 1 THEN (ReceiveQtyChld+AdjInQtyChld-AdjOutQtyChld-CashOutQtyChld-SaleOutQtyChld+IssueInQtyChld-IssueOutQtyChld) / main.bulk_conversion_rate
                ELSE 0
            END) as cbalance
 
            FROM

            (SELECT p.product_id,p.product_desc,p.bulk_conversion_rate,p.is_parent,p.parent_id,
            ##IFNULL(ReceiveQuery.avg_cost,0) as avg_cost,
            p.purchase_cost as avg_cost,
            IFNULL(ReceiveQuery.ReceiveQty,0) as ReceiveQty,
            IFNULL(AdjInQuery.AdjInQty,0) as AdjInQty,
            IFNULL(AdjOutQuery.AdjOutQty,0) as AdjOutQty,
            IFNULL(CashOutQuery.CashOutQty,0) as CashOutQty,
            IFNULL(SaleOutQuery.SaleOutQty,0) as SaleOutQty,
            IFNULL(IssueInQuery.IssueInQty,0) as IssueInQty,
            IFNULL(IssueOutQuery.IssueOutQty,0) as IssueOutQty,


            IFNULL(ReceiveQueryChld.ReceiveQtyChld,0) as ReceiveQtyChld,
            IFNULL(AdjInQueryChld.AdjInQtyChld,0) as AdjInQtyChld,
            IFNULL(AdjOutQueryChld.AdjOutQtyChld,0) as AdjOutQtyChld,
            IFNULL(CashOutQueryChld.CashOutQtyChld,0) as CashOutQtyChld,
            IFNULL(SaleOutQueryChld.SaleOutQtyChld,0) as SaleOutQtyChld,
            IFNULL(IssueInQueryChld.IssueInQtyChld,0) as IssueInQtyChld,
            IFNULL(IssueOutQueryChld.IssueOutQtyChld,0) as IssueOutQtyChld

            FROM products p 
            

            LEFT JOIN
            (SELECT 
            p.product_id,
            SUM(IFNULL(dii.dr_qty,0)) as ReceiveQty,
            AVG(IFNULL(dii.dr_price,0)) as avg_cost
            FROM delivery_invoice_items as dii
            LEFT JOIN delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
            LEFT JOIN products p on p.product_id = dii.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE AND di.date_delivered<='$as_of_date' AND di.is_finalized = TRUE
            ".($department==1||$department==null?"":" AND di.department_id=$department")."
            GROUP BY dii.product_id) as ReceiveQuery ON ReceiveQuery.product_id = p.product_id

            LEFT JOIN

            (SELECT 
            p.parent_id,
            SUM(IFNULL(dii.dr_qty,0) * p.conversion_rate) as ReceiveQtyChld
            FROM delivery_invoice_items as dii
            LEFT JOIN delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
            LEFT JOIN products p on p.product_id = dii.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE AND di.date_delivered<='$as_of_date' AND di.is_finalized = TRUE
            ".($department==1||$department==null?"":" AND di.department_id=$department")."
            GROUP BY p.parent_id) as ReceiveQueryChld ON ReceiveQueryChld.parent_id = p.product_id


            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IFNULL(aii.adjust_qty,0)) as AdjInQty
            FROM adjustment_items aii
            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN products p ON p.product_id = aii.product_id
            WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE  AND ai.adjustment_type = 'IN' AND ai.date_adjusted<='$as_of_date'
            ".($department==1||$department==null?"":" AND ai.department_id=$department")."
            GROUP BY aii.product_id) as AdjInQuery ON AdjInQuery.product_id = p.product_id


            LEFT JOIN(
            SELECT 
            p.parent_id,
            SUM(IFNULL(aii.adjust_qty,0) * p.conversion_rate) as AdjInQtyChld
            FROM adjustment_items aii
            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN products p ON p.product_id = aii.product_id
            WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE  AND ai.adjustment_type = 'IN' AND ai.date_adjusted<='$as_of_date'
            ".($department==1||$department==null?"":" AND ai.department_id=$department")."
            GROUP BY p.parent_id) as AdjInQueryChld ON AdjInQueryChld.parent_id = p.product_id


            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IFNULL(aii.adjust_qty,0)) as AdjOutQty
            FROM adjustment_items aii
            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN products p ON p.product_id = aii.product_id
            WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.adjustment_type = 'OUT' AND ai.date_adjusted<='$as_of_date'
            ".($department==1||$department==null?"":" AND ai.department_id=$department")."
            GROUP BY aii.product_id) as AdjOutQuery ON AdjOutQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.parent_id,
            SUM(IFNULL(aii.adjust_qty,0) * p.conversion_rate) as AdjOutQtyChld
            FROM adjustment_items aii
            LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
            LEFT JOIN products p ON p.product_id = aii.product_id
            WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.adjustment_type = 'OUT' AND ai.date_adjusted<='$as_of_date'
            ".($department==1||$department==null?"":" AND ai.department_id=$department")."
            GROUP BY p.parent_id) as AdjOutQueryChld ON AdjOutQueryChld.parent_id = p.product_id


            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IFNULL(cii.inv_qty,0)) as CashOutQty
            FROM cash_invoice_items cii
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id =cii.cash_invoice_id
            LEFT JOIN products p ON p.product_id = cii.product_id 
            WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE AND ci.date_invoice<='$as_of_date'
            ".($department==1||$department==null?"":" AND ci.department_id=$department")."
            GROUP BY cii.product_id) as CashOutQuery ON CashOutQuery.product_id = p.product_id 


            LEFT JOIN(
            SELECT 
            p.parent_id,
            SUM(IFNULL(cii.inv_qty,0) * p.conversion_rate) as CashOutQtyChld
            FROM cash_invoice_items cii
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id =cii.cash_invoice_id
            LEFT JOIN products p ON p.product_id = cii.product_id 
            WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE AND ci.date_invoice<='$as_of_date'
            ".($department==1||$department==null?"":" AND ci.department_id=$department")."
            GROUP BY p.parent_id) as CashOutQueryChld ON CashOutQueryChld.parent_id = p.product_id 


            LEFT JOIN(
            SELECT p.product_id,
            SUM(IFNULL(sii.inv_qty,0)) as SaleOutQty
            FROM sales_invoice_items sii
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
            LEFT JOIN products p ON p.product_id = sii.product_id
            WHERE si.is_active = TRUE AND si.is_deleted = FALSE AND si.date_invoice<='$as_of_date'
            ".($department==1||$department==null?"":" AND si.department_id=$department")."
            GROUP BY sii.product_id) as SaleOutQuery ON SaleOutQuery.product_id = p.product_id


            LEFT JOIN(
            SELECT
            p.parent_id,
            SUM(IFNULL(sii.inv_qty,0) * p.conversion_rate) as SaleOutQtyChld
            FROM sales_invoice_items sii
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
            LEFT JOIN products p ON p.product_id = sii.product_id
            WHERE si.is_active = TRUE AND si.is_deleted = FALSE AND si.date_invoice<='$as_of_date'
            ".($department==1||$department==null?"":" AND si.department_id=$department")."
            GROUP BY p.parent_id) as SaleOutQueryChld ON SaleOutQueryChld.parent_id = p.product_id


            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IFNULL(idi.issue_qty,0)) as IssueInQty
            FROM issuance_department_items as idi
            LEFT JOIN issuance_department_info di ON di.issuance_department_id = idi.issuance_department_id
            LEFT JOIN products p on p.product_id = idi.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE  AND di.date_issued<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.to_department_id=$department")."
            GROUP BY idi.product_id) as IssueInQuery ON IssueInQuery.product_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.parent_id,
            SUM(IFNULL(idi.issue_qty,0) * p.conversion_rate) as IssueInQtyChld
            FROM issuance_department_items as idi
            LEFT JOIN issuance_department_info di ON di.issuance_department_id = idi.issuance_department_id
            LEFT JOIN products p on p.product_id = idi.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE  AND di.date_issued<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.to_department_id=$department")."
            GROUP BY p.parent_id) as IssueInQueryChld ON IssueInQueryChld.parent_id = p.product_id

            LEFT JOIN(
            SELECT 
            p.product_id,
            SUM(IFNULL(idi.issue_qty,0)) as IssueOutQty
            FROM issuance_department_items as idi
            LEFT JOIN issuance_department_info di ON di.issuance_department_id = idi.issuance_department_id
            LEFT JOIN products p on p.product_id = idi.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE  AND di.date_issued<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.from_department_id=$department")."
            GROUP BY idi.product_id) as IssueOutQuery ON IssueOutQuery.product_id= p.product_id  

            LEFT JOIN(
            SELECT 
            p.parent_id,
            SUM(IFNULL(idi.issue_qty,0) * p.conversion_rate) as IssueOutQtyChld
            FROM issuance_department_items as idi
            LEFT JOIN issuance_department_info di ON di.issuance_department_id = idi.issuance_department_id
            LEFT JOIN products p on p.product_id = idi.product_id
            WHERE di.is_deleted = FALSE AND di.is_active = TRUE  AND di.date_issued<='$as_of_date'
            ".($department==1||$department==null?"":" AND di.from_department_id=$department")."
            GROUP BY p.parent_id) as IssueOutQueryChld ON IssueOutQueryChld.parent_id= p.product_id  

            WHERE 
                p.is_active = TRUE AND 
                p.is_deleted = FALSE AND 
                p.item_type_id  = 1 AND
                (p.is_parent = TRUE OR (p.is_parent = FALSE AND p.parent_id = 0))
                ) as main) as m
            ORDER BY m.product_desc ASC


            ";
        return $this->db->query($sql)->result();
    }


}
?>