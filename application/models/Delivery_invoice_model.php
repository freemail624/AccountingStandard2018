<?php

class Delivery_invoice_model extends CORE_Model {
    protected  $table="delivery_invoice";
    protected  $pk_id="dr_invoice_id";

    function __construct() {
        parent::__construct();
    }

 function get_aging_payables()
    {
        $sql = "SELECT
n.supplier_name,
SUM(n.days) days,
SUM(n.current) current,
SUM(n.30days) thirty_days,
SUM(n.45days) fortyfive_days,
SUM(n.60days) sixty_days,
SUM(n.over_90days) over_ninetydays,
(SUM(n.current)+
SUM(n.30days)+
SUM(n.45days)+
SUM(n.60days)+
SUM(n.over_90days)) as total_balance
FROM
    (SELECT
    m.supplier_id,
    m.supplier_name,
    m.days,
    IF(m.days >= 0 AND m.days < 30, m.balance,'') AS current,
    IF(m.days >= 30 AND m.days <= 44, m.balance,'') AS 30days,
    IF(m.days >= 45 AND m.days <= 59, m.balance,'') AS 45days,
    IF(m.days >= 60 AND m.days <= 89, m.balance,'') AS 60days,
    IF(m.days >= 90, m.balance,'') AS over_90days
    FROM
        (SELECT 
        ji.journal_id,
        ji.txn_no,
        ji.date_txn,
        ji.ref_no,
        s.supplier_id,
        s.supplier_name,
        SUM(IFNULL(ja.cr_amount,0))as cr_amount,
        ABS(DATEDIFF(NOW(),ji.date_txn)) AS days,
        (SUM(ja.cr_amount) - IFNULL(payment.payment_amount,0)) as balance

        FROM
        journal_info ji
        LEFT JOIN  journal_accounts ja ON ja.journal_id = ji.journal_id
        LEFT JOIN suppliers s ON s.supplier_id = ji.supplier_id
        LEFT JOIN (
        SELECT ppl.dr_invoice_id, SUM(ppl.payment_amount) as payment_amount FROM payable_payments_list ppl
        LEFT JOIN
        payable_payments pp
        ON pp.payment_id = ppl.payment_id
        WHERE pp.is_active=TRUE AND pp.is_deleted = FALSE
        GROUP BY ppl.dr_invoice_id
        ) as payment 
        ON payment.dr_invoice_id = ji.journal_id

        WHERE ja.account_id = (SELECT payable_account_id FROM account_integration)
        AND ji.is_active=TRUE AND ji.is_deleted = FALSE
        GROUP BY ja.journal_id
        ) as m
    ) n
GROUP BY n.supplier_id HAVING total_balance > 0

        
        ";

            return $this->db->query($sql)->result();
    }
    function get_report_summary($startDate,$endDate,$supplier_id){
        $sql="SELECT
            di.dr_invoice_no,
            di.external_ref_no,
            s.*,
            di.date_delivered,
            di.total_after_tax as total_after_discount 
            FROM 
            delivery_invoice AS di
            LEFT JOIN suppliers AS s ON s.supplier_id = di.`supplier_id`
            WHERE date_delivered BETWEEN '$startDate' AND '$endDate' AND di.is_active=TRUE AND di.is_deleted=FALSE 

            ".($supplier_id==0?"":" AND di.supplier_id = '$supplier_id'")."

            ORDER BY di.date_delivered,di.dr_invoice_id";

        return $this->db->query($sql)->result();
    }

    function get_report_detailed($startDate,$endDate,$supplier_id){
        $sql="SELECT
            di.*,
            s.*,
            p.product_desc,
            p.`purchase_cost`,
            dii.`dr_qty`,
            dii.*,
            dr_qty * dr_price AS total_amount
            FROM 
            delivery_invoice AS di
            LEFT JOIN suppliers AS s ON s.supplier_id = di.`supplier_id`
            LEFT JOIN delivery_invoice_items AS dii ON dii.`dr_invoice_id`=di.`dr_invoice_id`
            LEFT JOIN products AS p ON p.`product_id`=dii.`product_id`
            WHERE date_delivered BETWEEN '$startDate' AND '$endDate' AND di.is_active=TRUE AND di.is_deleted=FALSE
             ".($supplier_id==0?"":" AND di.supplier_id = '$supplier_id'")."
            ORDER BY di.date_delivered,di.dr_invoice_id";

        return $this->db->query($sql)->result();
    }

    function get_journal_entries($purchase_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            p.expense_account_id as account_id,
            '' as memo,
            SUM(dii.dr_non_tax_amount) dr_amount,
            0 as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            GROUP BY p.expense_account_id

            UNION ALL


            SELECT input_tax.account_id,input_tax.memo,
            SUM(input_tax.dr_amount)as dr_amount,0 as cr_amount

             FROM
            (SELECT dii.product_id,

            (SELECT input_tax_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            SUM(dii.dr_tax_amount) as dr_amount,
            0 as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            )as input_tax GROUP BY input_tax.account_id

            UNION ALL

            SELECT acc_payable.account_id,acc_payable.memo,
            0 as dr_amount,SUM(acc_payable.cr_amount) as cr_amount
             FROM
            (SELECT dii.product_id,

            (SELECT payable_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 dr_amount,
            SUM(dii.dr_line_total_price) as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            ) as acc_payable GROUP BY acc_payable.account_id)as main WHERE main.dr_amount>0 OR main.cr_amount>0";

        return $this->db->query($sql)->result();
    }

    function get_journal_entries_2($purchase_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            p.expense_account_id as account_id,
            '' as memo,
            SUM(dii.dr_non_tax_amount) dr_amount,
            0 as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            GROUP BY p.expense_account_id

            UNION ALL


            SELECT input_tax.account_id,input_tax.memo,
            SUM(input_tax.dr_amount)as dr_amount,0 as cr_amount

             FROM
            (SELECT dii.product_id,

            (SELECT input_tax_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            SUM(dii.dr_tax_amount) as dr_amount,
            0 as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            )as input_tax GROUP BY input_tax.account_id

            UNION ALL

            SELECT acc_payable.account_id,acc_payable.memo,
            0 as dr_amount,SUM(acc_payable.cr_amount) as cr_amount
             FROM
            (SELECT dii.product_id,

            (SELECT payable_account_id FROM account_integration) as account_id,
            '' as memo,
            0 dr_amount,
            SUM(dii.dr_line_total_after_global) as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            ) as acc_payable GROUP BY acc_payable.account_id
            
            )as main WHERE main.dr_amount>0 OR main.cr_amount>0";

        return $this->db->query($sql)->result();



    }


    function get_vat_relief($startDate,$endDate) {
        $sql="SELECT main.* FROM (      SELECT
            di.*,
            s.supplier_name,s.tin_no,
            (IFNULL(dr_taxable.dr_taxable,0) - IFNULL(di.total_tax_amount,0)) AS net_of_vat,
            IFNULL(dr_non_taxable.dr_non_taxable,0) AS invoice_non_vat,
            dr_taxable.dr_taxable as dr_taxable
            FROM
            `delivery_invoice` AS di
            LEFT JOIN suppliers AS s ON s.`supplier_id`=di.`supplier_id`
            LEFT JOIN (SELECT dr_invoice_id, 
                            SUM(IFNULL(core.dr_line_total_price,0)) as dr_taxable
                            FROM(SELECT * FROM delivery_invoice_items dii

                            WHERE dii.dr_tax_rate > 0 AND dii.dr_tax_amount > 0) as core
                            GROUP BY dr_invoice_id) as dr_taxable
            ON dr_taxable.dr_invoice_id = di.dr_invoice_id

            LEFT JOIN (SELECT dr_invoice_id, 
                        SUM(IFNULL(core.dr_line_total_price,0)) as dr_non_taxable
                        FROM(SELECT * FROM delivery_invoice_items dii

                        WHERE dii.dr_tax_rate = 0 AND dii.dr_tax_amount = 0) as core
                        GROUP BY dr_invoice_id) as dr_non_taxable

            ON dr_non_taxable.dr_invoice_id = di.dr_invoice_id
            
            
            WHERE di.is_deleted=FALSE AND di.is_active=TRUE
            AND di.date_delivered BETWEEN '$startDate' AND '$endDate' 
            AND s.tax_type_id=2) main";

            return $this->db->query($sql)->result();
    }

    function get_vat_relief_supplier_list($startDate,$endDate) {
        $sql="SELECT
            DISTINCT(s.supplier_name),
            s.*
            FROM
            `delivery_invoice` AS di
            LEFT JOIN suppliers AS s ON s.`supplier_id`=di.`supplier_id`
            WHERE di.is_deleted=FALSE AND di.is_active=TRUE
            AND di.date_delivered BETWEEN '$startDate' AND '$endDate'
            AND s.tax_type_id=2";

            return $this->db->query($sql)->result();
    }


    function delivery_list_count($id_filter,$department_id=null,$supplier_id=null,$startDate=null,$endDate=null,$open_filter=null){
        $sql="
        SELECT di.*,
        suppliers.supplier_name,
        departments.department_name,
        tax_types.tax_type,
        purchase_order.po_no,
        purchase_order.order_status_id,
        DATE_FORMAT(di.date_due,'%m/%d/%Y')as date_due,
        DATE_FORMAT(di.date_delivered,'%m/%d/%Y')as date_delivered,
        CONCAT_WS(' ',CAST(di.terms as CHAR(250)) ,di.duration) as term_description,
        order_status.order_status

        FROM
        delivery_invoice as di

        LEFT JOIN suppliers ON suppliers.supplier_id = di.supplier_id
        LEFT JOIN departments ON departments.department_id = di.department_id
        LEFT JOIN tax_types ON tax_types.tax_type_id=di.tax_type_id
        LEFT JOIN purchase_order ON purchase_order.purchase_order_id=di.purchase_order_id 
        LEFT JOIN order_status ON order_status.order_status_id=di.order_status_id

        WHERE
        di.is_active = TRUE AND di.is_deleted=FALSE 

        ".($department_id==null?"":" AND di.department_id=$department_id")."
        ".($supplier_id==null?"":" AND di.supplier_id=$supplier_id")."
        ".($id_filter==null?"":" AND di.dr_invoice_id=$id_filter")."
        ".($startDate==null?"":" AND di.date_delivered BETWEEN '$startDate' AND '$endDate'")."
        ".($open_filter==null?"":" AND (di.order_status_id=1 OR di.order_status_id=3)")."
        ";

        return $this->db->query($sql)->result();

    }
 function purchase_monitoring($product_id,$startDate=null,$endDate=null,$supplier_id){
        $sql="
        SELECT 
        dii.product_id,
        dii.dr_invoice_id,
        p.product_desc,
        p.product_code,
        u.unit_name,
        dii.dr_price,
        s.supplier_name,
        di.dr_invoice_no,
        di.date_delivered
        FROM delivery_invoice_items dii 



        LEFT JOIN units u ON u.unit_id = dii.unit_id
        LEFT JOIN products p ON p.product_id = dii.product_id
        LEFT JOIN delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
        LEFT JOIN suppliers s ON s.supplier_id = di.supplier_id

/* IF product is ALL (null) then WHERE BETWEEN is used , ELSE  WHERE filter of product_id and between dates are used */

        ".($product_id==null?"

            ".($startDate==null?"":" WHERE di.date_delivered BETWEEN '$startDate' AND '$endDate'")."
            ".($supplier_id==0?"":" AND di.supplier_id=$supplier_id")."
        ":" WHERE p.product_id=$product_id 
        
            ".($startDate==null?"":" AND di.date_delivered BETWEEN '$startDate' AND '$endDate'")."
            ".($supplier_id==0?"":" AND di.supplier_id=$supplier_id")."

        ")."





        ORDER BY di.date_delivered DESC
        ";
        return $this->db->query($sql)->result();

    }




 function get_purchases_for_review(){
    $sql='SELECT 
        di.dr_invoice_id,
        di.dr_invoice_no,
        di.remarks,
        di.external_ref_no,
        CONCAT_WS(" ",di.terms,di.duration)as term_description,
        DATE_FORMAT(di.date_delivered,"%m/%d/%Y") as date_delivered,
        s.supplier_name

        FROM delivery_invoice di
        LEFT JOIN suppliers s ON s.supplier_id = di.supplier_id
        LEFT JOIN (SELECT dii.dr_invoice_id,SUM(IFNULL(p.expense_account_id,0)) as identifier FROM delivery_invoice_items dii
        LEFT JOIN products p ON p.product_id = dii.product_id
        GROUP BY dii.dr_invoice_id ) as dii ON dii.dr_invoice_id = di.dr_invoice_id

        WHERE di.is_active = TRUE AND
        di.is_deleted = FALSE AND
        di.is_journal_posted = FALSE
        AND dii.identifier > 0';

         return $this->db->query($sql)->result();

     }

    function get_dr_balance_qty($dr_invoice_id=null,$supplier_id=null){
        $sql="SELECT 
                z.*
            FROM
                (SELECT 
                    main.*,
                        (main.total_dr_amount - main.total_cv_amount) AS Balance
                FROM
                    (SELECT 
                    di.dr_invoice_id,
                        di.dr_invoice_no,
                        suppliers.supplier_name,
                        departments.department_name,
                        di.supplier_id,
                        purchase_order.po_no,
                        DATE_FORMAT(di.date_due, '%m/%d/%Y') AS date_due,
                        DATE_FORMAT(di.date_delivered, '%m/%d/%Y') AS date_delivered,
                        CONCAT_WS(' ', CAST(di.terms AS CHAR (250)), di.duration) AS term_description,
                        SUM(di.total_after_discount) AS total_dr_amount,
                        (SELECT 
                                COALESCE(SUM(accounts.dr_amount), 0) AS total_cv_amount
                            FROM
                                cv_info
                            LEFT JOIN cv_accounts accounts ON accounts.cv_id = cv_info.cv_id
                            WHERE
                                cv_info.dr_invoice_id = di.dr_invoice_id
                                    AND cv_info.is_deleted = FALSE
                                    AND cv_info.is_active = TRUE
                                    AND cv_info.cancelled_by_user <= 0) AS total_cv_amount
                FROM
                    delivery_invoice AS di
                LEFT JOIN suppliers ON suppliers.supplier_id = di.supplier_id
                LEFT JOIN departments ON departments.department_id = di.department_id
                LEFT JOIN purchase_order ON purchase_order.purchase_order_id = di.purchase_order_id
                WHERE
                    di.is_deleted = FALSE
                        AND di.is_active = TRUE
                        ".($dr_invoice_id==null?"":" AND di.dr_invoice_id = $dr_invoice_id")."
                    ".($supplier_id==null?" GROUP BY di.dr_invoice_id":" GROUP BY di.supplier_id")."
                ) main) AS z
                ".($dr_invoice_id==null?" WHERE z.Balance > 0":"")."";
         return $this->db->query($sql)->result();
    } 


    function get_balance_rr($dr_invoice_id){
        $sql="SELECT 
                    main.*
                FROM
                    (SELECT 
                        1 AS sort_id,
                            delivery_invoice.dr_invoice_id,
                            COALESCE((SELECT 
                                    payable_account_id
                                FROM
                                    account_integration), 0) AS account_id,
                            '' AS memo,
                            (SELECT 
                                    (x.total_dr_amount - x.total_cv_amount) AS Balance
                                FROM
                                    (SELECT 
                                    SUM(total_after_discount) AS total_dr_amount,
                                        (SELECT 
                                                COALESCE(SUM(accounts.dr_amount), 0) AS total_cv_amount
                                            FROM
                                                cv_info
                                            LEFT JOIN cv_accounts accounts ON accounts.cv_id = cv_info.cv_id
                                            WHERE
                                                cv_info.dr_invoice_id = di.dr_invoice_id AND
                                                cv_info.is_deleted = FALSE AND
                                                cv_info.is_active = TRUE AND
                                                cv_info.cancelled_by_user <= 0) AS total_cv_amount
                                FROM
                                    delivery_invoice AS di
                                WHERE
                                    di.dr_invoice_id = $dr_invoice_id) x) AS dr_amount,
                            0 AS cr_amount,
                            delivery_invoice.department_id
                    FROM
                        delivery_invoice UNION ALL SELECT 
                        2 AS sort_id,
                            delivery_invoice.dr_invoice_id,
                            COALESCE((SELECT 
                                    payment_to_supplier_id
                                FROM
                                    account_integration), 0) AS account_id,
                            '' AS memo,
                            0 AS dr_amount,
                            (SELECT 
                                    (x.total_dr_amount - x.total_cv_amount) AS Balance
                                FROM
                                    (SELECT 
                                    SUM(total_after_discount) AS total_dr_amount,
                                        (SELECT 
                                                COALESCE(SUM(accounts.dr_amount), 0) AS total_cv_amount
                                            FROM
                                                cv_info
                                            LEFT JOIN cv_accounts accounts ON accounts.cv_id = cv_info.cv_id
                                            WHERE
                                                cv_info.dr_invoice_id = di.dr_invoice_id AND
                                                cv_info.is_deleted = FALSE AND
                                                cv_info.is_active = TRUE AND
                                                cv_info.cancelled_by_user <= 0) AS total_cv_amount
                                FROM
                                    delivery_invoice AS di
                                WHERE
                                    di.dr_invoice_id = $dr_invoice_id) x) AS cr_amount,
                            delivery_invoice.department_id
                    FROM
                        delivery_invoice) AS main
                WHERE
                    main.dr_invoice_id = $dr_invoice_id
                ORDER BY main.sort_id ASC";
        return $this->db->query($sql)->result();
    }
}



?>