<?php

class Pos_item_sales_model extends CORE_Model {
    protected  $table="pos_item_sales";
    protected  $pk_id="pos_item_sales_id";

    function __construct() {
        parent::__construct();
    }

    function get_xreading($x_id=null) {
        $sql="  SELECT distinct x_reading_id,DATE_FORMAT(CAST(start_datetime as DATE),'%m/%d/%Y')  as trans_date, terminal_id FROM pos_item_sales
                ".($x_id==null?"":" WHERE x_reading_id=$x_id")."

        ";
        return $this->db->query($sql)->result();
    }

    function get_x_reading_sales($x_id=0) {
        $sql="SELECT pos_item_sales.*,products.product_desc,pos_item_sales.x_reading_id,products.product_code,products.purchase_cost,products.sale_price,
            SUM(pos_item_sales.product_quantity) as product_quantity,
            SUM(pos_item_sales.discount_amount) as discount_amount,
            SUM(pos_item_sales.vatable_sales) as vatable_sales,
            SUM(pos_item_sales.vat_amount) as vat_amount,
            SUM(pos_item_sales.vat_exempt_sales) as vat_exempt_sales,
            SUM(pos_item_sales.zero_rated_sales) as zero_rated_sales,
            SUM(pos_item_sales.item_total) as item_total

         FROM pos_item_sales
        LEFT JOIN products ON products.product_id = pos_item_sales.product_id WHERE pos_item_sales.x_reading_id = $x_id

        GROUP BY products.product_id
        ";
        return $this->db->query($sql)->result();
    }

    function get_sales_from_date($start,$end) {
        $sql="SELECT *,
                IF(m.CurrentQty < m.product_quantity, 'Yes','') as critical,
                m.supplier_name
                 FROM (SELECT  core.product_id,core.product_desc,core.product_code,core.purchase_cost,core.sale_price, core.supplier_name,
                core.product_quantity,
                core.item_total,
                ROUND((ReceiveQtyP+AdjustInQtyP-SalesOUtQtyP-POSInvOutP+POSInvInP-CInvOutP-AdjustOutP-IssueFromInvOutP+IssueToInvInP),2) as CurrentQty

                 FROM 

                (

                SELECT core.*,
                p.product_desc,
                p.product_code,
                p.purchase_cost,
                p.sale_price,
                sup.supplier_name,
                IFNULL(aiin.parent_in_qty,0) as AdjustInQtyP,
                IFNULL(di.parent_in_qty,0) as ReceiveQtyP,
                IFNULL(si.parent_out_qty,0) as SalesOUtQtyP,
                IFNULL(aiout.parent_out_qty,0) as AdjustOutP,
                IFNULL(ciout.parent_out_qty,0) as CInvOutP,
                IFNULL(issuefromout.parent_out_qty,0) as IssueFromInvOutP,
                IFNULL(issuetoin.parent_in_qty,0) as IssueToInvInP,
                IFNULL(possalesout.parent_out_qty,0) as POSInvOutP,
                IFNULL(possalesreturn.parent_in_qty,0) as POSInvInP
                 FROM ( 
                SELECT   pos_item_sales.product_id,
                            SUM(pos_item_sales.product_quantity) as product_quantity,
                            SUM(pos_item_sales.item_total) as item_total
                         FROM pos_item_sales
                         WHERE  CAST(start_datetime as DATE) BETWEEN '$start' AND '$end'

                        GROUP BY pos_item_sales.product_id) as core

                LEFT JOIN products p On p.product_id = core.product_id
                LEFT JOIN suppliers sup ON sup.supplier_id = p.supplier_id
                        
                LEFT JOIN 

                (SELECT aii.product_id,
                SUM(IF(aii.is_parent = 1, IFNULL(aii.adjust_qty,0),IFNULL(aii.adjust_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_in_qty
                FROM adjustment_info as ai
                INNER JOIN adjustment_items as aii ON aii.adjustment_id=ai.adjustment_id
                LEFT JOIN products p on p.product_id = aii.product_id
                WHERE ai.adjustment_type='IN' 
                AND ai.is_deleted=0 
                GROUP BY aii.product_id) as aiin ON aiin.product_id = p.product_id 
                
                
                LEFT JOIN
                (SELECT dii.product_id,
                SUM(IF(dii.is_parent = 1, IFNULL(dii.dr_qty,0),IFNULL(dii.dr_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_in_qty
                FROM delivery_invoice as di
                INNER JOIN delivery_invoice_items as dii ON dii.dr_invoice_id=di.dr_invoice_id
                LEFT JOIN products p on p.product_id = dii.product_id
                 WHERE  di.is_deleted=0 
                GROUP BY dii.product_id) as di ON di.product_id = p.product_id
                
                
          
                LEFT JOIN

                (SELECT sii.product_id,
                SUM(IF(sii.is_parent = 1, IFNULL(sii.inv_qty,0),IFNULL(sii.inv_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM sales_invoice si
                INNER JOIN sales_invoice_items  sii ON sii.sales_invoice_id =  si.sales_invoice_id
                LEFT JOIN products p on p.product_id = sii.product_id
                WHERE  si.is_deleted = 0 
                GROUP BY sii.product_id) as si on si.product_id = p.product_id      
                
                
                LEFT JOIN

                (SELECT iii.product_id,
                SUM(IF(iii.is_parent = 1, IFNULL(iii.issue_qty,0),IFNULL(iii.issue_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM issuance_department_info as ii 
                INNER JOIN issuance_department_items as iii ON iii.issuance_department_id=ii.issuance_department_id
                LEFT JOIN products p on p.product_id = iii.product_id
                WHERE ii.is_deleted=0
                GROUP BY iii.product_id) as issuefromout ON issuefromout.product_id = p.product_id
                
                
                LEFT JOIN
                (SELECT pis.product_id,
                SUM(pis.product_quantity) as parent_out_qty
                FROM pos_item_sales pis
                WHERE  pis.x_reading_id != 0 
                GROUP BY pis.product_id) as possalesout ON possalesout.product_id = p.product_id 

                LEFT JOIN
                (SELECT pir.product_id,
                SUM(pir.product_quantity) as parent_in_qty
                FROM pos_item_returns pir
                WHERE  pir.x_reading_id != 0 
                GROUP BY pir.product_id) as possalesreturn ON possalesreturn.product_id = p.product_id 
                
                LEFT JOIN

                (SELECT iii.product_id,
                SUM(IF(iii.is_parent = 1, IFNULL(iii.issue_qty,0),IFNULL(iii.issue_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_in_qty
                FROM issuance_department_info as ii 
                INNER JOIN issuance_department_items as iii ON iii.issuance_department_id=ii.issuance_department_id
                LEFT JOIN products p on p.product_id = iii.product_id
                WHERE ii.is_deleted=0
                GROUP BY iii.product_id) as issuetoin ON issuetoin.product_id = p.product_id

          
                LEFT JOIN

                (SELECT aii.product_id,
                SUM(IF(aii.is_parent = 1, IFNULL(aii.adjust_qty,0),IFNULL(aii.adjust_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM adjustment_info as ai
                INNER JOIN adjustment_items as aii ON aii.adjustment_id=ai.adjustment_id
                LEFT JOIN products p on p.product_id = aii.product_id
                WHERE ai.adjustment_type='OUT' 
                AND ai.is_deleted=0 
                GROUP BY aii.product_id) as aiout ON aiout.product_id = p.product_id
      
                LEFT JOIN

                (SELECT cii.product_id,
                SUM(IF(cii.is_parent = 1, IFNULL(cii.inv_qty,0),IFNULL(cii.inv_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM cash_invoice ci
                INNER JOIN cash_invoice_items  cii ON cii.cash_invoice_id =  ci.cash_invoice_id
                LEFT JOIN products p on p.product_id = cii.product_id
                WHERE  ci.is_deleted = 0
                AND ci.is_active=1 
                GROUP BY cii.product_id) as ciout ON ciout.product_id = p.product_id
                
                ) as core ) as m

                ORDER BY ISNULL(m.supplier_name) ASC, m.supplier_name ASC

        ";
        return $this->db->query($sql)->result();
    }

    function get_sales_from_date_all_products($start,$end) {
        $sql="SELECT *,
                IF(m.CurrentQty < m.product_quantity, 'Yes','') as critical
                 FROM (SELECT  core.product_id,core.product_desc,core.product_code,core.purchase_cost,core.sale_price,
                core.product_quantity,
                core.item_total,
                ROUND((ReceiveQtyP+AdjustInQtyP-SalesOUtQtyP-POSInvOutP+POSInvInP-CInvOutP-AdjustOutP-IssueFromInvOutP+IssueToInvInP),2) as CurrentQty

                 FROM 

                (

                SELECT core.*,
                p.product_desc,
                p.product_code,
                p.purchase_cost,
                p.sale_price,
                IFNULL(aiin.parent_in_qty,0) as AdjustInQtyP,
                IFNULL(di.parent_in_qty,0) as ReceiveQtyP,
                IFNULL(si.parent_out_qty,0) as SalesOUtQtyP,
                IFNULL(aiout.parent_out_qty,0) as AdjustOutP,
                IFNULL(ciout.parent_out_qty,0) as CInvOutP,
                IFNULL(issuefromout.parent_out_qty,0) as IssueFromInvOutP,
                IFNULL(issuetoin.parent_in_qty,0) as IssueToInvInP,
                IFNULL(possalesout.parent_out_qty,0) as POSInvOutP,
                IFNULL(possalesreturn.parent_in_qty,0) as POSInvInP
                 FROM ( 
                SELECT   pos_item_sales.product_id,
                            SUM(pos_item_sales.product_quantity) as product_quantity,
                            SUM(pos_item_sales.item_total) as item_total
                         FROM pos_item_sales
                         WHERE  CAST(start_datetime as DATE) BETWEEN '$start' AND '$end'

                        GROUP BY pos_item_sales.product_id) as core

                RIGHT JOIN products p On p.product_id = core.product_id
                        
                LEFT JOIN 

                (SELECT aii.product_id,
                SUM(IF(aii.is_parent = 1, IFNULL(aii.adjust_qty,0),IFNULL(aii.adjust_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_in_qty
                FROM adjustment_info as ai
                INNER JOIN adjustment_items as aii ON aii.adjustment_id=ai.adjustment_id
                LEFT JOIN products p on p.product_id = aii.product_id
                WHERE ai.adjustment_type='IN' 
                AND ai.is_deleted=0 
                GROUP BY aii.product_id) as aiin ON aiin.product_id = p.product_id 
                
                
                LEFT JOIN
                (SELECT dii.product_id,
                SUM(IF(dii.is_parent = 1, IFNULL(dii.dr_qty,0),IFNULL(dii.dr_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_in_qty
                FROM delivery_invoice as di
                INNER JOIN delivery_invoice_items as dii ON dii.dr_invoice_id=di.dr_invoice_id
                LEFT JOIN products p on p.product_id = dii.product_id
                 WHERE  di.is_deleted=0 
                GROUP BY dii.product_id) as di ON di.product_id = p.product_id
                
                
          
                LEFT JOIN

                (SELECT sii.product_id,
                SUM(IF(sii.is_parent = 1, IFNULL(sii.inv_qty,0),IFNULL(sii.inv_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM sales_invoice si
                INNER JOIN sales_invoice_items  sii ON sii.sales_invoice_id =  si.sales_invoice_id
                LEFT JOIN products p on p.product_id = sii.product_id
                WHERE  si.is_deleted = 0 
                GROUP BY sii.product_id) as si on si.product_id = p.product_id      
                
                
                LEFT JOIN

                (SELECT iii.product_id,
                SUM(IF(iii.is_parent = 1, IFNULL(iii.issue_qty,0),IFNULL(iii.issue_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM issuance_department_info as ii 
                INNER JOIN issuance_department_items as iii ON iii.issuance_department_id=ii.issuance_department_id
                LEFT JOIN products p on p.product_id = iii.product_id
                WHERE ii.is_deleted=0
                GROUP BY iii.product_id) as issuefromout ON issuefromout.product_id = p.product_id
                
                
                LEFT JOIN
                (SELECT pis.product_id,
                SUM(pis.product_quantity) as parent_out_qty
                FROM pos_item_sales pis
                WHERE  pis.x_reading_id != 0 
                GROUP BY pis.product_id) as possalesout ON possalesout.product_id = p.product_id 

                LEFT JOIN
                (SELECT pir.product_id,
                SUM(pir.product_quantity) as parent_in_qty
                FROM pos_item_returns pir
                WHERE  pir.x_reading_id != 0 
                GROUP BY pir.product_id) as possalesreturn ON possalesreturn.product_id = p.product_id 
                
                LEFT JOIN

                (SELECT iii.product_id,
                SUM(IF(iii.is_parent = 1, IFNULL(iii.issue_qty,0),IFNULL(iii.issue_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_in_qty
                FROM issuance_department_info as ii 
                INNER JOIN issuance_department_items as iii ON iii.issuance_department_id=ii.issuance_department_id
                LEFT JOIN products p on p.product_id = iii.product_id
                WHERE ii.is_deleted=0
                GROUP BY iii.product_id) as issuetoin ON issuetoin.product_id = p.product_id

          
                LEFT JOIN

                (SELECT aii.product_id,
                SUM(IF(aii.is_parent = 1, IFNULL(aii.adjust_qty,0),IFNULL(aii.adjust_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM adjustment_info as ai
                INNER JOIN adjustment_items as aii ON aii.adjustment_id=ai.adjustment_id
                LEFT JOIN products p on p.product_id = aii.product_id
                WHERE ai.adjustment_type='OUT' 
                AND ai.is_deleted=0 
                GROUP BY aii.product_id) as aiout ON aiout.product_id = p.product_id
      
                LEFT JOIN

                (SELECT cii.product_id,
                SUM(IF(cii.is_parent = 1, IFNULL(cii.inv_qty,0),IFNULL(cii.inv_qty,0)/IFNULL(p.child_unit_desc,0))) as parent_out_qty
                FROM cash_invoice ci
                INNER JOIN cash_invoice_items  cii ON cii.cash_invoice_id =  ci.cash_invoice_id
                LEFT JOIN products p on p.product_id = cii.product_id
                WHERE  ci.is_deleted = 0
                AND ci.is_active=1 
                GROUP BY cii.product_id) as ciout ON ciout.product_id = p.product_id
                
                ) as core ) as m
                ORDER BY m.product_quantity DESC
        ";
        return $this->db->query($sql)->result();
    }


    function get_pos_sales_for_review() {
        $sql="SELECT 
			DATE_FORMAT(CAST(start_datetime as DATE),'%m/%d/%Y')  as trans_date,
			x_reading_id,
			CONCAT('X Reading # ', x_reading_id) x_reading_desc,
			SUM(item_total) as trans_total
			FROM pos_item_sales

			WHERE is_journal_posted = FALSE 
			GROUP BY x_reading_id";
        return $this->db->query($sql)->result();
    }


    function set_as_posted($journal_id,$x_reading_id) {
        $sql="UPDATE pos_item_sales SET is_journal_posted = TRUE, journal_id = $journal_id WHERE x_reading_id = $x_reading_id";
         $this->db->query($sql);
    }





    function get_journal_entries($x_reading_id) {
        $sql="SELECT * FROM(SELECT 
        (SELECT payment_from_customer_id FROM account_integration) as account_id,
        '' as memo,
        SUM(pis.item_total - pis.discount_amount) as dr_amount,
        0 as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0
        
        UNION ALL
        
        SELECT 
        (SELECT receivable_discount_account_id FROM account_integration) as account_id,
        '' as memo,
        SUM(pis.discount_amount) as dr_amount,
        0 as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0
        
        UNION ALL
        
        SELECT 
        p.income_account_id as account_id,
        '' as memo,
        0 as dr_amount,
        SUM(pis.item_total - pis.vat_amount) as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0
        GROUP BY p.income_account_id
        
        UNION ALL
        
        SELECT 
        (SELECT output_tax_account_id FROM account_integration) as account_id,
        '' as memo,
        0 as dr_amount,
        SUM(pis.vat_amount) as cr_amount
        
        FROM pos_item_sales pis
        LEFT JOIN products p ON p.product_id = pis.product_id
        WHERE pis.x_reading_id = $x_reading_id  AND p.income_account_id > 0) 
        as main WHERE main.dr_amount > 0 or main.cr_amount > 0";
        return $this->db->query($sql)->result();
    }





}
?>