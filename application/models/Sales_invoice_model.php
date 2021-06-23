<?php

class Sales_invoice_model extends CORE_Model
{
    protected $table = "sales_invoice";
    protected $pk_id = "sales_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_journal_entries($sales_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            p.income_account_id as account_id,
            '' as memo,
            SUM(sii.inv_non_tax_amount) cr_amount,
            0 as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            GROUP BY p.income_account_id

            UNION ALL


            SELECT output_tax.account_id,output_tax.memo,
            SUM(output_tax.cr_amount)as cr_amount,0 as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT output_tax_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            SUM(sii.inv_tax_amount) as cr_amount,
            0 as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            )as output_tax GROUP BY output_tax.account_id

            UNION ALL

            SELECT acc_receivable.account_id,acc_receivable.memo,
            0 as cr_amount,SUM(acc_receivable.dr_amount) as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT receivable_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 cr_amount,
            SUM(sii.inv_line_total_price) as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            ) as acc_receivable GROUP BY acc_receivable.account_id)as main WHERE main.dr_amount>0 OR main.cr_amount>0";

        return $this->db->query($sql)->result();
    }


function get_journal_entries_2($sales_invoice_id){

$sql="SELECT main.* FROM(
            SELECT acc_receivable.account_id,acc_receivable.memo,
            0 as cr_amount,SUM(acc_receivable.dr_amount) as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT receivable_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 cr_amount,
            SUM(sii.inv_line_total_after_global) as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            ) as acc_receivable GROUP BY acc_receivable.account_id

            UNION ALL
            
            SELECT acc_discount.account_id,acc_discount.memo,
            0 as cr_amount,SUM(acc_discount.dr_amount) as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT receivable_discount_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 cr_amount,
            SUM((sii.inv_line_total_price - sii.inv_line_total_after_global) + sii.inv_line_total_discount) as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            ) as acc_discount GROUP BY acc_discount.account_id

            UNION ALL
            SELECT
            p.income_account_id as account_id,
            '' as memo,
            SUM(sii.inv_non_tax_amount) cr_amount,
            0 as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            GROUP BY p.income_account_id

            UNION ALL


            SELECT output_tax.account_id,output_tax.memo,
            SUM(output_tax.cr_amount)as cr_amount,0 as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT output_tax_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            SUM(sii.inv_tax_amount) as cr_amount,
            0 as dr_amount
            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            )as output_tax GROUP BY output_tax.account_id

            )as main WHERE main.dr_amount>0 OR main.cr_amount>0
            

            ";
        return $this->db->query($sql)->result();
}

    function get_customer_soa_final($now, $customer_id, $status, $payment_date,$filter_accounts){
$sql="
SELECT 
ji.journal_id,
IFNULL(ji.ref_no,txn_no) as invoice_no,
c.customer_name,
ji.is_sales,
ji.date_txn,
IFNULL(receivables.dr_amount,0) as receivable_amount,
IFNULL(payment.payment_amount,0) as payment_amount,
(IFNULL(receivables.dr_amount,0) - IFNULL(payment.payment_amount,0)) as balance
 FROM journal_info ji

LEFT JOIN customers c ON c.customer_id = ji.customer_id
LEFT JOIN (
SELECT ja.journal_id, SUM(dr_amount) as dr_amount FROM journal_accounts ja
WHERE account_id IN ($filter_accounts)
GROUP BY  ja.journal_id
) as receivables

ON receivables.journal_id=ji.journal_id

LEFT JOIN
(SELECT
rpl.journal_id,
rpl.receivable_amount,
SUM(IFNULL(rpl.payment_amount,0)) payment_amount
FROM
receivable_payments_list rpl
INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
WHERE rp.is_deleted=FALSE
AND rp.is_active=TRUE 
AND rp.customer_id = $customer_id

GROUP BY rpl.journal_id) as payment
ON payment.journal_id = ji.journal_id

WHERE book_type = 'SJE'
AND ji.is_active = TRUE 
AND ji.is_deleted = FALSE
AND ji.customer_id=$customer_id
 ".($now == true ? "AND MONTH(ji.date_txn) = MONTH(NOW()) AND YEAR(ji.date_txn) <= YEAR(NOW())" : " AND ji.date_txn < DATE(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-01')) ")."

HAVING balance > 0
";


return $this->db->query($sql)->result();
 // ".($date = null ? "AND YEAR(ji.date_txn) = YEAR(NOW())" : "AND MONTH(ji.date_txn) $date AND YEAR(ji.date_txn) <= YEAR(NOW())")." OLD CODE 

    }


    function get_customer_soa_complete($date, $customer_id, $status, $payment_date){
$sql="SELECT * FROM (
        SELECT
        1 as group_status,
        m.sales_invoice_id as invoice_id,
        m.sales_inv_no as invoice_no,
        m.date_invoice as date_invoice,
        m.customer_name,
        m.total_after_tax as receivable_amount,
        m.payment_amount as payment_amount,
        IF(m.balance = 0, m.payment_amount, m.balance) balance_amount,
        m.status

        FROM (SELECT
            sales.*,
            payments.receipt_no,
            payments.date_paid,
            IFNULL(sales.total_after_tax,0) receivable_amount,
            IFNULL(payments.payment_amount,0) payment_amount,
            (IFNULL(sales.total_after_tax,0) - IFNULL(payments.payment_amount,0)) balance,
            IF(IFNULL(payments.payment_amount,0) != IFNULL(sales.total_after_tax,0),'unpaid','paid') status
        FROM
        (
            SELECT
            si.*,
            c.customer_name,
            IFNULL(si.address,c.address) customer_address,
            c.contact_name
            FROM
            sales_invoice si
            LEFT JOIN customers c ON c.customer_id = si.customer_id
            WHERE si.is_deleted=FALSE
            AND si.is_active=TRUE
            AND si.customer_id = $customer_id
         ".($date = null ? "AND YEAR(date_invoice) = YEAR(NOW())" : "AND MONTH(date_invoice) $date AND YEAR(date_invoice) = YEAR(NOW())")."
        ) sales

        LEFT JOIN

        (
            SELECT
                rp.*,
                rpl.sales_invoice_id,
                SUM(IFNULL(rpl.receivable_amount,0)) receivable_amount,
                SUM(IFNULL(rpl.payment_amount,0)) payment_amount
            FROM
            receivable_payments_list rpl
            INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
            WHERE rp.is_deleted=FALSE
            AND rp.is_active=TRUE
            AND rp.customer_id = $customer_id
            AND MONTH(rp.date_paid) = MONTH(NOW()) AND YEAR(rp.date_paid) = YEAR(NOW())
            GROUP BY rpl.journal_id
        ) payments

        ON sales.sales_invoice_id = payments.sales_invoice_id) m HAVING balance_amount > 0


        ) as sales

        UNION
        (
        SELECT
        n.*
        FROM (
        SELECT
        0 as group_status,
        service_invoice.service_invoice_id as invoice_id,
        service_invoice.service_invoice_no as invoice_no,
        service_invoice.date_invoice as date_invoice,
        service_invoice.customer_name,
        IFNULL(service_invoice.total_amount,0) receivable_amount,
        IFNULL(service_payment.payment_amount,0) payment_amount,
        (IFNULL(service_invoice.total_amount,0) - IFNULL(service_payment.payment_amount,0)) balance_amount,
        IF(IFNULL(service_payment.payment_amount,0) != IFNULL(service_invoice.total_amount,0),'unpaid','paid') status


        FROM

        (SELECT
        service_invoice.*,c.customer_name FROM
        service_invoice
        LEFT JOIN
        customers c on c.customer_id =  service_invoice.customer_id
        WHERE service_invoice.is_deleted = FALSE
        AND service_invoice.is_active= TRUE
        AND service_invoice.customer_id= $customer_id
         ".($date = null ? "AND YEAR(date_invoice) = YEAR(NOW())" : "AND MONTH(date_invoice) $date AND YEAR(date_invoice) = YEAR(NOW())")." ) as service_invoice

        LEFT JOIN
        (SELECT
        IF(rpl.sales_invoice_id = 0, 1 , 0) status_group,
            rp.*,
            rpl.sales_invoice_id,
            rpl.service_invoice_id,
            SUM(IFNULL(rpl.receivable_amount,0)) receivable_amount,
            SUM(IFNULL(rpl.payment_amount,0)) payment_amount
        FROM
        receivable_payments_list rpl
        INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
        WHERE rp.is_deleted=FALSE
        AND rp.is_active=TRUE
        AND rp.customer_id = $customer_id
        AND MONTH(rp.date_paid) = MONTH(NOW()) AND YEAR(rp.date_paid) = YEAR(NOW())
        GROUP BY rpl.service_invoice_id
        ) as service_payment

        ON service_invoice.service_invoice_id = service_payment.service_invoice_id ) as n  HAVING balance_amount > 0)
";


return $this->db->query($sql)->result();

    }
    function get_customer_soa_payment($customer_id,$filter_accounts){
$sql="SELECT * FROM
(SELECT * FROM
        (SELECT
            rp.*,
            ji.is_sales,
            c.customer_name,
            GROUP_CONCAT(rp.receipt_no) receipt_no_desc,
            IFNULL(receivables.dr_amount,0) receivable_amount,
            SUM(IFNULL(rpl.payment_amount,0)) payment_amount,
            (IFNULL(receivables.dr_amount,0) - SUM(IFNULL(rpl.payment_amount,0))) balance
        FROM
        receivable_payments_list rpl
        INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
        LEFT JOIN customers c ON c.customer_id = rp.customer_id
        LEFT JOIN (
        SELECT ja.journal_id, SUM(dr_amount) as dr_amount FROM journal_accounts ja
        WHERE account_id  IN ($filter_accounts)
        GROUP BY  ja.journal_id
        ) as receivables

        ON receivables.journal_id=rpl.journal_id
        LEFT JOIN (SELECT ji.journal_id,ji.is_sales FROM journal_info ji) as ji ON ji.journal_id = rpl.journal_id
        WHERE rp.is_deleted=FALSE
        AND rp.is_active=TRUE
        AND rp.customer_id = $customer_id
        AND MONTH(rp.date_paid) <= MONTH(NOW()) AND YEAR(NOW())
        GROUP BY rpl.journal_id) m HAVING balance > 0) as m";



return $this->db->query($sql)->result();

    }


    function get_customer_soa($date, $customer_id, $status, $payment_date)
    {
        $sql = "SELECT
                *,
                IF(m.balance = 0, m.payment_amount, m.balance) balance_amount
                FROM (SELECT
                    sales.*,
                    payments.receipt_no,
                    payments.date_paid,
                    IFNULL(sales.total_after_tax,0) receivable_amount,
                    IFNULL(payments.payment_amount,0) payment_amount,
                    (IFNULL(sales.total_after_tax,0) - IFNULL(payments.payment_amount,0)) balance,
                    IF(IFNULL(payments.payment_amount,0) != IFNULL(sales.total_after_tax,0),'unpaid','paid') status
                FROM
                (
                    SELECT
                    si.*,
                    c.customer_name,
                    IFNULL(si.address,c.address) customer_address,
                    c.contact_name
                    FROM
                    sales_invoice si
                    LEFT JOIN customers c ON c.customer_id = si.customer_id
                    WHERE si.is_deleted=FALSE
                    AND si.is_active=TRUE
                    AND si.customer_id = $customer_id
                    ".($date = null ? "AND YEAR(date_invoice) = YEAR(NOW())" : "AND MONTH(date_invoice) $date AND YEAR(date_invoice) = YEAR(NOW())")."
                ) sales

                LEFT JOIN

                (
                    SELECT
                        rp.*,
                        rpl.sales_invoice_id,
                        SUM(IFNULL(rpl.receivable_amount,0)) receivable_amount,
                        SUM(IFNULL(rpl.payment_amount,0)) payment_amount
                    FROM
                    receivable_payments_list rpl
                    INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
                    WHERE rp.is_deleted=FALSE
                    AND rp.is_active=TRUE
                    AND rp.customer_id = $customer_id
                    AND MONTH(rp.date_paid) = MONTH(NOW()) AND YEAR(rp.date_paid) = YEAR(NOW())
                    GROUP BY rpl.sales_invoice_id
                ) payments

                ON sales.sales_invoice_id = payments.sales_invoice_id) m HAVING balance > 0";

        return $this->db->query($sql)->result();
    }

    function get_customer_payments($customer_id)
    {
        $sql = "SELECT * FROM
        (SELECT
            rp.*,
            c.customer_name,
            rpl.sales_invoice_id,
            GROUP_CONCAT(rp.receipt_no) receipt_no_desc,
            IFNULL(rpl.receivable_amount,0) receivable_amount,
            SUM(IFNULL(rpl.payment_amount,0)) payment_amount,
            (IFNULL(rpl.receivable_amount,0) - SUM(IFNULL(rpl.payment_amount,0))) balance
        FROM
        receivable_payments_list rpl
        INNER JOIN receivable_payments rp ON rp.payment_id = rpl.payment_id
        LEFT JOIN customers c ON c.customer_id = rp.customer_id
        WHERE rp.is_deleted=FALSE
        AND rp.is_active=TRUE
        AND rp.customer_id = $customer_id
        AND MONTH(rp.date_paid) = MONTH(NOW()) AND YEAR(NOW())
        GROUP BY rpl.sales_invoice_id) m HAVING balance > 0";

        return $this->db->query($sql)->result();
    }

    function get_aging_receivables($filter_account)
    {
        $sql = "SELECT
n.customer_name,
SUM(n.days) days,
SUM(n.current) current,
SUM(n.30days) thirty_days,
SUM(n.45days) fortyfive_days,
SUM(n.60days) sixty_days,
SUM(n.over_90days) over_ninetydays,
(IFNULL(SUM(n.current),0)+
IFNULL(SUM(n.30days),0)+
IFNULL(SUM(n.45days),0)+
IFNULL(SUM(n.60days),0)+
IFNULL(SUM(n.over_90days),0)) as total_balance
FROM
    (SELECT
    m.customer_id,
    m.customer_name,
    m.days,
    IF(m.days >= 0 AND m.days < 30, m.balance,'') AS current,
    IF(m.days >= 30 AND m.days <= 44, m.balance,'') AS 30days,
    IF(m.days >= 45 AND m.days <= 59, m.balance,'') AS 45days,
    IF(m.days >= 60 AND m.days <= 89, m.balance,'') AS 60days,
    IF(m.days >= 90, m.balance,'') AS over_90days
    FROM
        (SELECT 
        SUM(ja.dr_amount) as dr_amount,
        c.customer_name,
        ABS(DATEDIFF(NOW(),ji.date_txn)) AS days,
        (SUM(ja.dr_amount) - IFNULL(payment.payment_amount,0)) as balance,
        ji.*
        FROM journal_info ji
        
        LEFT JOIN customers c on c.customer_id = ji.customer_id
        LEFT JOIN journal_accounts ja on ja.journal_id = ji.journal_id
        LEFT JOIN 
        (SELECT 
        SUM(rpl.payment_amount) as payment_amount,
        rpl.journal_id FROM 
        receivable_payments_list rpl 
LEFT JOIN 
    receivable_payments as rp
    
    ON rp.payment_id = rpl.payment_id
 WHERE rp.is_active = TRUE
 AND rp.is_deleted = FALSE
GROUP BY rpl.journal_id) as payment
        ON payment.journal_id = ji.journal_id
        
        WHERE book_type = 'SJE'
        AND ja.account_id IN ($filter_account)
        AND ji.is_active = TRUE
        AND ji.is_deleted = FALSE

        GROUP BY ja.journal_id
        ) as m
    )n
GROUP BY n.customer_id HAVING total_balance > 0";

        return $this->db->query($sql)->result();
    }

/*    -- Over 90 Days
    CONVERT( IF(@balance < (o.over_ninetydays ) , (o.over_ninetydays - @balance ), (o.over_ninetydays - o.over_ninetydays  ) )  , DECIMAL (20 , 2 ))as  balance_over_ninetydays,
    CONVERT( IF(@balance < o.over_ninetydays , @balance := @balance-@balance , @balance:= @balance-o.over_ninetydays ), DECIMAL (20 , 2 )) as rem_after_over_ninety,
    
    -- 90 Days
    CONVERT( IF(@balance < (o.ninety_days ) , (o.ninety_days - @balance ), (o.ninety_days - o.ninety_days  ) )  , DECIMAL (20 , 2 ))as  balance_ninety_days,
    CONVERT( IF(@balance < o.ninety_days , @balance := @balance-@balance , @balance:= @balance-o.ninety_days ), DECIMAL (20 , 2 )) as rem_after_ninety,

    -- 60 Days
    CONVERT( IF(@balance < (o.sixty_days ) , (o.sixty_days - @balance ), (o.sixty_days - o.sixty_days  ) )  , DECIMAL (20 , 2 ))as  balance_sixty_days,
    CONVERT( IF(@balance < o.sixty_days , @balance := @balance-@balance , @balance:= @balance-o.sixty_days ), DECIMAL (20 , 2 )) as rem_after_sixty,

    -- 30 Days
    CONVERT( IF(@balance < (o.thirty_days ) , (o.thirty_days - @balance ), (o.thirty_days - o.thirty_days  ) )  , DECIMAL (20 , 2 ))as  balance_thirty_days,
    CONVERT( IF(@balance < o.thirty_days , @balance := @balance-@balance , @balance:= @balance-o.thirty_days ), DECIMAL (20 , 2 )) as rem_after_thirty,*/

    function get_aging_receivables_billing($department_id=0,$as_of_date=null,$status_id='all')
    {
        $sql = "SELECT aging.* FROM (SELECT 
        p.tenant_id,
        (CASE
            WHEN COALESCE(contracts.active_count,0) > 0
            THEN 1
            ELSE 0
        END) tenant_active,
        (CASE
            WHEN COALESCE(contracts.active_count,0) > 0
            THEN 'Active'
            ELSE 'Inactive'
        END) status,
        bt.tenant_code,
        bt.trade_name,
        bt.accounting_department_id,
        sd.total_security_deposit,
        p.total_payment,
        p.total_balance,
        p.balance_thirty_days,
        p.balance_sixty_days,
        p.balance_ninety_days,
        p.balance_over_ninetydays,
        (p.total_balance - p.total_payment) as total_tenant_balance

            FROM (SELECT 
                @balance:=  IFNULL(bp.total_payment,0) as total_payment,
                    
                -- Over 90 Days
                  CONVERT( 
                    (CASE
                        WHEN @balance <= o.over_ninetydays
                            THEN (o.over_ninetydays - @balance)
                        WHEN @balance > o.over_ninetydays
                            THEN (o.over_ninetydays - o.over_ninetydays)
                        ELSE ''
                    END)
                    , DECIMAL (20 , 2 ))as  balance_over_ninetydays,
                
                    CONVERT( 
                    (CASE
                        WHEN @balance <= o.over_ninetydays
                            THEN @balance:=0
                        WHEN @balance > o.over_ninetydays
                            THEN @balance:=(@balance - o.over_ninetydays)
                        ELSE @balance:=0
                    END)
                    , DECIMAL (20 , 2 ))as  rem_after_over_ninety,
                
                -- 90 Days
                  CONVERT( 
                    (CASE
                        WHEN @balance <= o.ninety_days
                            THEN (o.ninety_days - @balance)
                        WHEN @balance > o.ninety_days
                            THEN 
                                (CASE 
                                    WHEN o.ninety_days >= 0
                                        THEN 0
                                    ELSE o.ninety_days
                                END)
                                    
                        ELSE o.ninety_days
                    END)
                    , DECIMAL (20 , 2 ))as  balance_ninety_days,
                    
                    CONVERT( 
                    (CASE
                        WHEN @balance <= o.ninety_days
                            THEN @balance:=0
                        WHEN @balance > o.ninety_days
                            THEN 
                                (CASE 
                                    WHEN o.ninety_days >= 0
                                        THEN @balance:=(@balance - o.ninety_days)
                                    ELSE @balance:=0
                                END)
                                    
                        ELSE o.ninety_days
                    END)
                    , DECIMAL (20 , 2 ))as  rem_after_ninety_days,
                    
                    
                -- 60 Days
                  CONVERT( 
                    (CASE
                        WHEN @balance <= o.sixty_days
                            THEN (o.sixty_days - @balance)
                        WHEN @balance > o.sixty_days
                            THEN 
                                (CASE 
                                    WHEN o.sixty_days >= 0
                                        THEN 0
                                    ELSE o.sixty_days
                                END)
                                    
                        ELSE o.sixty_days
                    END)
                    , DECIMAL (20 , 2 ))as  balance_sixty_days,
                    

               CONVERT( 
                    (CASE
                        WHEN @balance <= o.sixty_days
                            THEN @balance:=0
                        WHEN @balance > o.sixty_days
                            THEN 
                                (CASE 
                                    WHEN o.sixty_days >= 0
                                        THEN @balance:=(@balance - o.sixty_days)
                                    ELSE @balance:=0
                                END)
                                    
                        ELSE o.sixty_days
                    END)
                    , DECIMAL (20 , 2 ))as  rem_after_sixty_days,
                    
                      
                -- 30 Days
                  CONVERT( 
                    (CASE
                        WHEN @balance <= o.thirty_days
                            THEN (o.thirty_days - @balance)
                        WHEN @balance > o.thirty_days
                            THEN 
                                (CASE 
                                    WHEN o.thirty_days >= 0
                                        THEN 0
                                    ELSE o.thirty_days
                                END)
                                    
                        ELSE o.thirty_days
                    END)
                    , DECIMAL (20 , 2 ))as  balance_thirty_days,
                
                CONVERT( 
                    (CASE
                        WHEN @balance <= o.thirty_days
                            THEN @balance:=0
                        WHEN @balance > o.thirty_days
                            THEN 
                                (CASE 
                                    WHEN o.thirty_days >= 0
                                        THEN @balance:=(@balance - o.thirty_days)
                                    ELSE @balance:=0
                                END)
                                    
                        ELSE o.thirty_days
                    END)
                    , DECIMAL (20 , 2 ))as  rem_after_thirty_days,
                
                o.*
                
                FROM 
                    (SELECT
                    n.tenant_id, 
                    n.billing_date,
                    SUM(n.over_90days) over_ninetydays,
                    SUM(n.90days) ninety_days,
                    SUM(n.60days) sixty_days,
                    SUM(n.30days) thirty_days,
                    SUM(n.days) days,
                    (IFNULL(SUM(n.30days),0)+
                    IFNULL(SUM(n.60days),0)+
                    IFNULL(SUM(n.90days),0)+
                    IFNULL(SUM(n.over_90days),0)) as total_balance
                    FROM
                        (SELECT
                        m.tenant_id,
                        m.days,
                        m.billing_date,
                        IF(m.days >= 0 AND m.days <= 30, m.total_amount_due,'') AS 30days,
                        IF(m.days >= 31 AND m.days <= 60, m.total_amount_due,'') AS 60days,
                        IF(m.days >= 61 AND m.days <= 90, m.total_amount_due,'') AS 90days,
                        IF(m.days >= 91, m.total_amount_due,'') AS over_90days
                        FROM 
                            (SELECT main.*,
                            ABS(
                            DATEDIFF(
                            IF(isnull($as_of_date), NOW(), '$as_of_date')
                            ,main.billing_date)) AS days
                            FROM 
                                (SELECT 
                                bi.tenant_id,
                                CONVERT(CONCAT(bi.app_year,'-',LPAD(bi.month_id, 2, 0),'-01'), DATE) as billing_date,
                                bi.total_amount_due
                                FROM b_billing_info bi 

                                WHERE bi.is_deleted = FALSE
                                ) as main 
                        ) as m
                    )as n GROUP BY n.tenant_id
                ) as o

                LEFT JOIN
                (SELECT 
                bp.tenant_id,
                IFNULL(SUM(bp.amount_paid),0) + IFNULL(SUM(bp.used_security_deposit),0) as total_payment 
                FROM b_payment_info bp 
                WHERE bp.is_canceled = FALSE
                GROUP BY bp.tenant_id) as bp ON bp.tenant_id = o.tenant_id
            
            ) as p
            LEFT JOIN b_tenants as bt ON bt.tenant_id = p.tenant_id
            LEFT JOIN 
            (SELECT 
                    contract.tenant_id,
                    COUNT(*) as active_count
                FROM
                    b_contract_info contract
                    WHERE is_deleted = 0 AND is_active = 1
                    GROUP BY contract.tenant_id) as contracts ON contracts.tenant_id = p.tenant_id

            LEFT JOIN
                (SELECT main.tenant_id,
                    (COALESCE(SUM(main.total_fee),0) - COALESCE(SUM(main.total_payment),0)) as total_security_deposit
                    
                 FROM(
                        SELECT 
                        cof.tenant_id,
                        (SUM(cof.fee_credit) - SUM(cof.fee_debit)) AS total_fee,
                        0 as total_payment
                        FROM
                        b_contract_other_fees cof
                        LEFT JOIN
                        temp_journal_info tji ON tji.fee_id = cof.fee_id
                        WHERE tji.is_deleted = FALSE AND cof.fee_type_id = 2
                        GROUP BY cof.tenant_id
                        
                    UNION ALL
                    
                        SELECT 
                        cof.tenant_id,
                        0 as total_fee,
                        (SUM(cof.fee_debit) - SUM(cof.fee_credit)) AS total_payment
                        FROM
                        b_contract_other_fees cof
                        LEFT JOIN
                        b_payment_info pi ON pi.payment_id = cof.payment_id
                        LEFT JOIN
                        temp_journal_info tji ON tji.payment_id = pi.payment_id
                        WHERE tji.is_deleted = FALSE AND cof.fee_type_id = 2
                        GROUP BY cof.tenant_id
                        
                    ) as main
                    group by main.tenant_id
                ) as sd ON sd.tenant_id = bt.tenant_id
            ) as aging
            WHERE 1 = 1
            ".($department_id==0?"":" AND aging.accounting_department_id='".$department_id."'")."
            ".($status_id=='all'?"":" AND aging.tenant_active='".$status_id."'")."
            ";

        return $this->db->query($sql)->result();
    }

    function get_report_summary($startDate,$endDate){
        $sql="SELECT
            si.sales_inv_no,
            c.*,
            si.date_invoice,
            si.total_after_tax,
            si.remarks
            FROM
            sales_invoice AS si
            LEFT JOIN customers AS c ON c.customer_id = si.customer_id
            WHERE date_invoice BETWEEN '$startDate' AND '$endDate' AND inv_type=1
            ORDER BY si.customer_id";

        return $this->db->query($sql)->result();
    }


    function get_sales_summary($start=null,$end=null){
        $sql="SELECT mQ.*,DATE_FORMAT(mQ.date_invoice,'%m/%d/%Y') as inv_date,(mQ.sales-mQ.cost_of_sales) as net_profit
                FROM
                (

                SELECT nQ.*,
                (

                IF(nQ.inv_price=0,0,nQ.purchase_cost*nQ.inv_qty)

                )as cost_of_sales

                FROM
                (SELECT si.sales_inv_no,si.date_invoice,sii.inv_price,
                '' as dr_si,'' as vr,c.customer_name,
                IF(sii.inv_price=0,CONCAT(pr.product_desc,' (Free)'),pr.product_desc)as product_desc,
                refp.product_type,

                IF(sii.inv_price=0,0,SUM(sii.inv_qty))as inv_qty,

                IF(sii.inv_price=0,SUM(sii.inv_qty),0) as fg, /**this free item**/

                pr.size,
                s.supplier_name,sii.inv_price as srp,
                IFNULL(SUM(sii.inv_line_total_price),0) as sales,

                IF(sii.inv_price=0,
                  0,
                  sii.cost_upon_invoice
                )as purchase_cost /**GET THE COST OF THE PRODUCT WHEN IT WAS INVOICED**/



                FROM sales_invoice as si

                LEFT JOIN customers as c ON si.customer_id=c.customer_id
                INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
                LEFT JOIN (products as pr  LEFT JOIN refproduct as refp ON refp.refproduct_id=pr.refproduct_id)ON sii.product_id=pr.product_id
                LEFT JOIN suppliers as s ON pr.supplier_id=s.supplier_id

                WHERE si.date_invoice BETWEEN '$start' AND '$end' AND si.is_active=TRUE AND si.is_deleted=FALSE

                GROUP BY si.sales_inv_no,sii.product_id,sii.inv_price,IF(sii.inv_price=0,
                  0,
                  sii.cost_upon_invoice
                ))as nQ) mQ
                ";

            return $this->db->query($sql)->result();
    }


    function get_per_customer_sales_summary($start=null,$end=null,$customer_id=null){
        $sql="SELECT n.* FROM(SELECT si.sales_invoice_id,
            si.sales_inv_no,si.customer_id,c.customer_name,'SI' as type,c.address,c.contact_no,c.email_address,
            SUM(sii.inv_line_total_price)as total_amount_invoice

            FROM (sales_invoice as si
            LEFT JOIN customers as c ON c.customer_id=si.customer_id)
            INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
            WHERE si.is_active=TRUE AND si.is_deleted=FALSE
            AND si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type=1
            GROUP BY si.customer_id


            UNION ALL


            SELECT si.sales_invoice_id,
            si.sales_inv_no,d.department_id as customer_id,
            CONCAT(d.department_name,' (DR)') as customer_name,'DR' as type,'' as address,'' as contact_no,'' as email_address,
            SUM(sii.inv_line_total_price)as total_amount_invoice

            FROM (sales_invoice as si
            LEFT JOIN departments as d ON d.department_id=si.issue_to_department)
            INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
            WHERE si.is_active=TRUE AND si.is_deleted=FALSE
            AND si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type=2
            GROUP BY si.department_id) as  n ORDER By n.customer_name";
        return $this->db->query($sql)->result();
    }


    function get_per_customer_sales_detailed($start=null,$end=null,$customer_id=null){
        $sql = "SELECT 
                DISTINCT main.customer_id,
                c.customer_name 
                FROM(
                SELECT DISTINCT si.customer_id
                FROM sales_invoice si WHERE si.is_active= TRUE AND si.is_deleted = FALSE
                AND si.date_invoice BETWEEN '$start' AND '$end'

                UNION ALL
                SELECT DISTINCT ci.customer_id
                FROM cash_invoice ci WHERE ci.is_active= TRUE AND ci.is_deleted = FALSE
                AND ci.date_invoice BETWEEN '$start' AND '$end'
                ) as main

                LEFT JOIN customers c ON c.customer_id = main.customer_id";

            return $this->db->query($sql)->result();

    }

    function get_per_salesperson_sales_detailed($start=null,$end=null){
        $sql = "SELECT 
                DISTINCT IFNULL(main.salesperson_id,0) as salesperson_id,
                IFNULL(CONCAT(s.firstname,' ',s.lastname),'None') as salesperson_name
                FROM(
                SELECT DISTINCT IFNULL(si.salesperson_id,0) as salesperson_id
                FROM sales_invoice si WHERE si.is_active= TRUE AND si.is_deleted = FALSE
                AND si.date_invoice BETWEEN '$start' AND '$end'

                UNION ALL
                SELECT DISTINCT IFNULL(ci.salesperson_id,0) as salesperson_id
                FROM cash_invoice ci WHERE ci.is_active= TRUE AND ci.is_deleted = FALSE
                AND ci.date_invoice BETWEEN '$start' AND '$end'
                ) as main

                LEFT JOIN salesperson s ON s.salesperson_id = main.salesperson_id";

            return $this->db->query($sql)->result();
    }


    function get_sales_detailed_list($start=null,$end=null){
        $sql="SELECT 
            main.customer_id,
            IFNULL(main.salesperson_id,0) as salesperson_id,
            c.customer_name,
            IFNULL(CONCAT(s.firstname,' ',s.lastname),'None') as salesperson_name,
            main.inv_no as sales_inv_no,
            main.date_invoice,
            main.product_id,
            p.product_code,
            p.product_desc,

            main.inv_qty,
            main.inv_price,
            main.inv_line_total_after_global as total_amount

             FROM (SELECT
                si.sales_inv_no as inv_no,
                si.date_invoice,
                si.customer_id,
                IFNULL(si.salesperson_id,0)  as salesperson_id,
                sii.product_id,
                sii.inv_qty,
                sii.inv_price,
                sii.inv_line_total_after_global
            FROM
                sales_invoice AS si
                INNER JOIN sales_invoice_items AS sii ON si.sales_invoice_id = sii.sales_invoice_id
            WHERE
                si.is_active = TRUE AND si.is_deleted = FALSE
                AND si.date_invoice BETWEEN '$start' AND '$end'
                
                
            UNION ALL

            SELECT
                ci.cash_inv_no as inv_no,
                ci.date_invoice,
                ci.customer_id,
                ci.salesperson_id,
                cii.product_id,
                cii.inv_qty,
                cii.inv_price,
                cii.inv_line_total_after_global
            FROM
                cash_invoice AS ci
                INNER JOIN cash_invoice_items AS cii ON ci.cash_invoice_id = cii.cash_invoice_id
            WHERE
                ci.is_active = TRUE AND ci.is_deleted = FALSE
                AND ci.date_invoice BETWEEN '$start' AND '$end') as main
            LEFT JOIN customers AS c ON c.customer_id = main.customer_id
            LEFT JOIN products AS p ON p.product_id=main.product_id
            LEFT JOIN salesperson AS s ON s.salesperson_id=main.salesperson_id

            ORDER BY main.date_invoice DESC
            ";
        return $this->db->query($sql)->result();
    }

    function get_sales_summary_list($start=null,$end=null){
        $sql="SELECT main.customer_id,
            c.customer_name,
            SUM(main.inv_line_total_after_global) as total_amount

            FROM

            (SELECT si.customer_id,
            si.salesperson_id,
            sii.inv_line_total_after_global

            FROM sales_invoice_items sii 
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id

            WHERE si.is_active = TRUE AND si.is_deleted = FALSE
            AND si.date_invoice BETWEEN '$start' AND '$end'
             
             UNION ALL
             
             SELECT ci.customer_id,
            ci.salesperson_id,
            cii.inv_line_total_after_global

            FROM cash_invoice_items cii 
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id

            WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE
            AND ci.date_invoice BETWEEN '$start' AND '$end'
            ) as main
            LEFT JOIN customers c ON c.customer_id = main.customer_id

            GROUP BY main.customer_id";
        return $this->db->query($sql)->result();
    }

    function get_sales_summary_list_salesperson($start=null,$end=null){
        $sql="SELECT 
            main.salesperson_id,
            IFNULL(CONCAT(s.firstname,' ',s.lastname),'None') as salesperson_name,
            SUM(main.inv_line_total_after_global) as total_amount

            FROM

            (SELECT 
            si.salesperson_id,
            sii.inv_line_total_after_global

            FROM sales_invoice_items sii 
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id

            WHERE si.is_active = TRUE AND si.is_deleted = FALSE
            AND si.date_invoice BETWEEN '$start' AND '$end'
             
             UNION ALL
             
             SELECT
            ci.salesperson_id,
            cii.inv_line_total_after_global

            FROM cash_invoice_items cii 
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id

            WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE
            AND ci.date_invoice BETWEEN '$start' AND '$end'
            ) as main
            LEFT JOIN salesperson s ON s.salesperson_id = main.salesperson_id

            GROUP BY main.salesperson_id";
        return $this->db->query($sql)->result();
    }

    function get_sales_product_summary_list($start=null,$end=null){
        $sql="
        SELECT main.product_id,
        p.product_code,
        p.product_desc,
        SUM(main.inv_line_total_after_global) as total_amount


        FROM 


            (SELECT 
                  sii.product_id,
                  sii.inv_line_total_after_global
              FROM
                  (sales_invoice AS si)
                  INNER JOIN sales_invoice_items AS sii ON si.sales_invoice_id = sii.sales_invoice_id
              WHERE
                  si.is_active = TRUE AND si.is_deleted = FALSE
                  AND si.date_invoice BETWEEN '$start' AND '$end'

                UNION ALL

            SELECT 
                cii.product_id,
                cii.inv_line_total_after_global
              FROM
                  (cash_invoice AS ci)
                  INNER JOIN cash_invoice_items AS cii ON ci.cash_invoice_id = cii.cash_invoice_id
                  
              WHERE
                  ci.is_active = TRUE AND ci.is_deleted = FALSE
                  AND ci.date_invoice BETWEEN '$start' AND '$end') as main

                  LEFT JOIN products AS p ON p.product_id=main.product_id

              GROUP BY main.product_id";
         return $this->db->query($sql)->result();
    }

    function list_with_count($filter_id){
    $sql="SELECT
        si.*,
        DATE_FORMAT(si.date_invoice,'%m/%d/%Y') as date_invoice,
        DATE_FORMAT(si.date_due,'%m/%d/%Y') as date_due,

        si.salesperson_id,
        si.address,

        departments.department_id,
        departments.department_name,
        customers.customer_name,
        sales_order.so_no,


        IFNULL(count.count,0) as count
        FROM sales_invoice AS si

        LEFT JOIN

        (SELECT
        rp.payment_id,
        rpl.sales_invoice_id,
        count(sales_invoice_id) AS count
        FROM receivable_payments_list AS rpl
        LEFT JOIN receivable_payments AS rp ON rp.payment_id = rpl.payment_id
        WHERE rp.is_active= TRUE AND rp.is_deleted = FALSE
        group by rpl.sales_invoice_id) AS count

        ON count.sales_invoice_id = si.sales_invoice_id
        LEFT JOIN departments ON departments.department_id=si.department_id
        LEFT JOIN customers  ON customers.customer_id=si.customer_id
        LEFT JOIN sales_order ON sales_order.sales_order_id=si.sales_order_id


        WHERE si.is_active= TRUE AND si.is_deleted =  FALSE";

         return $this->db->query($sql)->result();
    }

    function get_invoices_per_month($month,$year){
    $sql="SELECT 
            SUM(IFNULL(income_amount,0)) as income_amount

            FROM
            (SELECT
            SUM(si.total_after_tax) as income_amount 
            FROM sales_invoice si 
            WHERE si.is_active = TRUE AND si.is_deleted = FALSE
            AND MONTH(si.date_invoice) = '$month' AND YEAR(si.date_invoice) = '$year'
            UNION ALL

            SELECT 

            SUM(ci.total_after_tax) as income_amount
            FROM  cash_invoice ci
            WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE
            AND MONTH(ci.date_invoice) = '$month' AND YEAR(ci.date_invoice) = '$year'

            ) as main";

         return $this->db->query($sql)->result();
    }


    function get_sales_invoice_for_review(){
        $sql='SELECT 
        si.sales_invoice_id,
        si.sales_inv_no,
        si.remarks,
        DATE_FORMAT(si.date_invoice,"%m/%d/%Y") as date_invoice,
        c.customer_name
        FROM sales_invoice si 
        LEFT JOIN customers c on c.customer_id  = si.customer_id
        LEFT JOIN (SELECT 
        sii.sales_invoice_id,
        SUM(IFNULL(p.income_account_id,0)) as identifier
        FROM sales_invoice_items sii
        LEFT JOIN products p ON p.product_id = sii.product_id
        GROUP BY sii.sales_invoice_id) as sii ON sii.sales_invoice_id = si.sales_invoice_id


        WHERE
        si.is_active = TRUE AND
        si.is_deleted = FALSE AND
        si.is_journal_posted = FALSE AND 
        sii.identifier > 0';

        return $this->db->query($sql)->result();
    }

}


?>
