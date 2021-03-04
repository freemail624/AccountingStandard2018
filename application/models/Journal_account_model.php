<?php

class Journal_account_model extends CORE_Model{

    protected  $table="journal_accounts"; //table name
    protected  $pk_id="journal_account_id"; //primary key id
    protected  $fk_id="journal_id"; //foreign key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_payable_balance() {
        $sql="SELECT 
            IF(ac.account_type_id = 1
                    OR ac.account_type_id = 5,
                (SUM(ja.dr_amount) - SUM(ja.cr_amount)),
                (SUM(ja.cr_amount) - SUM(ja.dr_amount))) AS Balance
        FROM
            journal_accounts ja
                INNER JOIN
            journal_info ji ON ji.journal_id = ja.journal_id
                LEFT JOIN
            account_titles at ON at.account_id = ja.account_id
                LEFT JOIN
            account_classes ac ON ac.account_class_id = at.account_class_id
        WHERE
            ja.account_id IN (SELECT 
                    payable_account_id
                FROM
                    account_integration)
                AND ji.is_deleted = FALSE
                AND ji.is_active = TRUE";

        return $this->db->query($sql)->result();
    }

    function get_receivable_balance() {
        $sql="SELECT 
            IF(ac.account_type_id = 1
                    OR ac.account_type_id = 5,
                (SUM(ja.dr_amount) - SUM(ja.cr_amount)),
                (SUM(ja.cr_amount) - SUM(ja.dr_amount))) AS Balance
        FROM
            journal_accounts ja
                INNER JOIN
            journal_info ji ON ji.journal_id = ja.journal_id
                LEFT JOIN
            account_titles at ON at.account_id = ja.account_id
                LEFT JOIN
            account_classes ac ON ac.account_class_id = at.account_class_id
        WHERE
            ja.account_id IN (SELECT 
                    receivable_account_id
                FROM
                    account_integration)
                AND ji.is_deleted = FALSE
                AND ji.is_active = TRUE";

        return $this->db->query($sql)->result();
    }

    function get_bs_account_classes($date,$department_id=null){
        $sql="SELECT ac.account_type_id,ac.account_class_id,ac.account_class
                FROM (journal_accounts as ja
                INNER JOIN journal_info as ji ON ji.journal_id=ja.journal_id)
                INNER JOIN (account_titles as at
                INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
                ON at.account_id=ja.account_id
                WHERE
                  ac.account_type_id IN(1,2,3) AND ji.is_active=TRUE AND ji.is_deleted=FALSE
                  AND ji.date_txn<='$date'
                  ".($department_id==null?"":" AND ji.department_id=$department_id")."
                GROUP BY ac.account_class_id
            ";
        return $this->db->query($sql)->result();
    }


    function get_bs_parent_account_balances($date,$department_id=null){
        $sql="SELECT m.*,mQat.account_title
                FROM
                (SELECT at.grand_parent_id,at.account_class_id,ac.account_type_id,
                (
                    IF(ac.account_type_id=1,
                    SUM(ja.dr_amount)-SUM(ja.cr_amount),
                    SUM(ja.cr_amount)-SUM(ja.dr_amount))
                ) as balance
                FROM (journal_accounts as ja
                INNER JOIN journal_info as ji ON ji.journal_id=ja.journal_id)
                INNER JOIN (account_titles as at
                INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
                ON at.account_id=ja.account_id
                WHERE ac.account_type_id IN(1,2,3) AND ji.is_active=TRUE AND ji.is_deleted=FALSE
                AND ji.date_txn<='$date'
                ".($department_id==null?"":" AND ji.department_id=$department_id")."
                GROUP BY at.grand_parent_id) as m
                LEFT JOIN account_titles as mQat ON mQat.account_id=m.grand_parent_id
        ";
        return $this->db->query($sql)->result();
    }


    // ASH
    function comparative_get_bs_parent_account_balances($current_start,$current_end,$previous_start,$previous_end,$department_id=null){
        $sql="SELECT
            main.*,
            (main.current_balance - main.previous_balance) as change_amount,
            COALESCE(((((main.current_balance - main.previous_balance) / main.previous_balance) * 100)),0) as percentage_change
            FROM
            (SELECT 
            at_main.grand_parent_id,
            at_main.account_class_id,
            ac.account_type_id,
            COALESCE(current_balance,0) as current_balance,
            COALESCE(previous_balance,0) as previous_balance,
            at_main.account_title
        FROM
            account_titles at_main
            LEFT JOIN account_classes ac ON ac.account_class_id = at_main.account_class_id
            LEFT JOIN ((SELECT
                        (IF(ac.account_type_id=1,
                            SUM(ja.dr_amount)-SUM(ja.cr_amount),
                            SUM(ja.cr_amount)-SUM(ja.dr_amount))
                        ) as current_balance,
                        ja.account_id
                        FROM (journal_accounts as ja
                        INNER JOIN journal_info as ji ON ji.journal_id=ja.journal_id)
                        INNER JOIN (account_titles as at
                        INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
                        ON at.account_id=ja.account_id
                        WHERE ac.account_type_id IN(1,2,3) AND ji.is_active=TRUE AND ji.is_deleted=FALSE
                        AND ji.date_txn BETWEEN '$current_start' AND '$current_end'
                        ".($department_id==null?"":" AND ji.department_id=$department_id")."
                        GROUP BY at.grand_parent_id) as current ) ON current.account_id = at_main.account_id

            LEFT JOIN ((SELECT
                        (IF(ac.account_type_id=1,
                            SUM(ja.dr_amount)-SUM(ja.cr_amount),
                            SUM(ja.cr_amount)-SUM(ja.dr_amount))
                        ) as previous_balance,
                        ja.account_id
                        FROM (journal_accounts as ja
                        INNER JOIN journal_info as ji ON ji.journal_id=ja.journal_id)
                        INNER JOIN (account_titles as at
                        INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
                        ON at.account_id=ja.account_id
                        WHERE ac.account_type_id IN(1,2,3) AND ji.is_active=TRUE AND ji.is_deleted=FALSE
                        AND ji.date_txn BETWEEN '$previous_start' AND '$previous_end'
                        ".($department_id==null?"":" AND ji.department_id=$department_id")."
                        GROUP BY at.grand_parent_id) as previous ) ON previous.account_id = at_main.account_id                
                        
            WHERE ac.account_type_id IN (1,2,3)
            AND (current_balance > 0 OR previous_balance > 0)) as main";
            return $this->db->query($sql)->result();
    }    


    function get_net_income($date_filter,$department_id=null){
        $sql="SELECT (SUM(m.income_balance)-SUM(m.expense_balance)) as net_income

                FROM

                (SELECT IFNULL((SUM(ja.cr_amount)-SUM(ja.dr_amount)),0)as income_balance,0 as expense_balance FROM (journal_accounts as ja
                INNER JOIN (account_titles as at
                INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
                ON at.account_id=ja.account_id)
                INNER JOIN journal_info as ji ON ja.journal_id=ji.journal_id
                WHERE ac.account_type_id=4 AND ji.is_active=TRUE AND ji.is_deleted=FALSE
                ".(is_array($date_filter)?" AND ji.date_txn BETWEEN '".date("Y-m-d",strtotime($date_filter[0]))."' AND '".date("Y-m-d",strtotime($date_filter[1]))."'":" AND ji.date_txn<'".date("Y-m-d",strtotime($date_filter))."'")."
                ".($department_id==null?"":" AND ji.department_id=$department_id")."
                UNION ALL

                SELECT 0 as income_balance,IFNULL((SUM(ja.dr_amount)-SUM(ja.cr_amount)),0)as expense_balance  FROM (journal_accounts as ja
                INNER JOIN (account_titles as at
                INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
                ON at.account_id=ja.account_id)
                INNER JOIN journal_info as ji ON ja.journal_id=ji.journal_id
                WHERE ac.account_type_id=5 AND ji.is_active=TRUE AND ji.is_deleted=FALSE
                ".(is_array($date_filter)?" AND ji.date_txn BETWEEN '".date("Y-m-d",strtotime($date_filter[0]))."' AND '".date("Y-m-d",strtotime($date_filter[1]))."'":" AND ji.date_txn<'".date("Y-m-d",strtotime($date_filter))."'")."
                ".($department_id==null?"":" AND ji.department_id=$department_id")."
                ) as m

                ";

        $net_income_result=$this->db->query($sql)->result();
        return (count($net_income_result)>0?$net_income_result[0]->net_income:0);
    }


    function get_bs_account_balances($date){

        //get what period the argument date is
        $sql="SELECT period_start,period_end FROM accounting_period WHERE '$date' BETWEEN period_start AND period_end";
        $period=$this->db->query($sql);

        //*************GET PERIOD START AND PERIOD END OF NET INCOME
        if(count($period)>0){ //if period is found, means this period is already closed

                //we will be using the start date of the "closed period" and "As of Date" argument/parameter to Filter Net Income
                $net_income_start=date('Y-m-d',strtotime($period[0]->period_start));
                $net_income_end=date('Y-m-d',strtotime($date));

        }else{ //if not found on accounting period

                //check if there is closed transactions
                $sql="SELECT period_start,period_end FROM accounting_period";
                $count_closed_trans=$this->db->query($sql);
                if(count($count_closed_trans)>0){ //there is closed transactions

                }else{ //if there is no closed transactions

                }

        }


    }

    function get_account_schedule($account_id,$as_of_date,$particular_tye='C'){

        $as_of_date=date('Y-m-d',strtotime($as_of_date));
        $this_month_start_date=date('Y',strtotime($as_of_date)).'-'.date('m',strtotime($as_of_date))."-01";
        $prev_month=date('Y-m-d',strtotime("-1 days", strtotime($this_month_start_date)));

        if($particular_tye=='C'){
            $sql="SELECT

                m.customer_id,
                IFNULL(c.`customer_name`,'Unknown') as customer_name,
                SUM(m.previous) as previous,
                SUM(m.current) as current,
                (SUM(m.previous)+SUM(m.current)) as total

                FROM

                (SELECT
                ji.customer_id,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                    )
                ) as previous,
                0 as current
                FROM `journal_info` as ji

                INNER JOIN (`journal_accounts` as ja
                LEFT JOIN (account_titles as at
                LEFT JOIN account_classes as ac ON ac.account_class_id=at.account_class_id
                ) ON at.account_id=ja.account_id
                ) ON ja.journal_id=ji.journal_id

                WHERE ji.`date_txn`<='$prev_month'
                AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=$account_id

                GROUP BY ji.customer_id

                UNION ALL

                SELECT
                ji.customer_id,0 as previous,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                    )
                ) as current
                FROM `journal_info` as ji

                INNER JOIN (`journal_accounts` as ja
                LEFT JOIN (account_titles as at
                LEFT JOIN account_classes as ac ON ac.account_class_id=at.account_class_id
                ) ON at.account_id=ja.account_id
                ) ON ja.journal_id=ji.journal_id

                WHERE ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=$account_id

                GROUP BY ji.customer_id) as m

                LEFT JOIN customers as c ON c.customer_id=m.customer_id

                GROUP BY m.customer_id ORDER BY IFNULL(c.`customer_name`,'Unknown')";
        }else{
            $sql="SELECT

                m.supplier_id,
                IFNULL(s.`supplier_name`,'Unknown') as supplier_name,
                SUM(m.previous) as previous,
                SUM(m.current) as current,
                (SUM(m.previous)+SUM(m.current)) as total

                FROM

                (SELECT
                ji.supplier_id,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                    )
                ) as previous,
                0 as current
                FROM `journal_info` as ji

                INNER JOIN (`journal_accounts` as ja
                LEFT JOIN (account_titles as at
                LEFT JOIN account_classes as ac ON ac.account_class_id=at.account_class_id
                ) ON at.account_id=ja.account_id
                ) ON ja.journal_id=ji.journal_id

                WHERE ji.`date_txn`<='$prev_month'
                AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=$account_id

                GROUP BY ji.supplier_id

                UNION ALL

                SELECT
                ji.supplier_id,0 as previous,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                    )
                ) as current
                FROM `journal_info` as ji

                INNER JOIN (`journal_accounts` as ja
                LEFT JOIN (account_titles as at
                LEFT JOIN account_classes as ac ON ac.account_class_id=at.account_class_id
                ) ON at.account_id=ja.account_id
                ) ON ja.journal_id=ji.journal_id

                WHERE ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=$account_id

                GROUP BY ji.supplier_id) as m

                LEFT JOIN suppliers as s ON s.supplier_id=m.supplier_id

                GROUP BY m.supplier_id ORDER BY IFNULL(s.`supplier_name`,'Unknown')";
        }



        return $this->db->query($sql)->result();
    }


    function get_account_schedule_tenants($account_id,$as_of_date){

        $as_of_date=date('Y-m-d',strtotime($as_of_date));
        $this_month_start_date=date('Y',strtotime($as_of_date)).'-'.date('m',strtotime($as_of_date))."-01";
        $prev_month=date('Y-m-d',strtotime("-1 days", strtotime($this_month_start_date)));

        $sql="SELECT
            m.customer_id,
            IFNULL(c.`customer_name`,'Unknown') as customer_name,
            MAX(m.or_details) as or_details,
            SUM(m.previous) as previous,
            SUM(m.current) as current,
            SUM(m.billing) as billing,
            SUM(m.payment) as payment,
            SUM(m.adjustment_dr) as adjustment_dr,
            SUM(m.adjustment_cr) as adjustment_cr,
            SUM(m.wtax_expanded) as wtax_expanded,
            (
                (SUM(m.previous) + 
                (SUM(m.billing) - SUM(m.adjustment_dr) - SUM(m.adjustment_cr)) +
                SUM(m.adjustment_dr)) +
                SUM(m.adjustment_cr)
                - 
                (SUM(m.payment))

            ) as total


            FROM

            (
            -- Previous Month
            SELECT
            ji.customer_id,
            (
                IF( ac.account_type_id=1 OR ac.account_type_id=5
                    ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                    ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                )
            ) as previous,
            0 as current,
            0 as billing,
            0 as payment,
            '' as or_details,
            0 as adjustment_dr,
            0 as adjustment_cr,
            0 as wtax_expanded

            FROM `journal_info` as ji

            INNER JOIN (`journal_accounts` as ja
            LEFT JOIN (account_titles as at
            LEFT JOIN account_classes as ac ON ac.account_class_id=at.account_class_id
            ) ON at.account_id=ja.account_id
            ) ON ja.journal_id=ji.journal_id

            WHERE ji.`date_txn`<='$prev_month'
            AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=$account_id
            GROUP BY ji.customer_id

            -- Billing
            UNION ALL

            SELECT 
                ji.customer_id,
                0 as previous,
                0 as current,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                    )
                ) as billing,
                0 as payment,
                '' as or_details,
                0 as adjustment_dr,
                0 as adjustment_cr,
                0 as wtax_expanded

            FROM
                temp_journal_info tji 
                LEFT JOIN journal_info ji ON ji.journal_id = tji.journal_id
                LEFT JOIN journal_accounts ja ON ja.journal_id = tji.journal_id
                LEFT JOIN account_titles at ON at.account_id = ja.account_id
                LEFT JOIN account_classes ac ON ac.account_class_id = at.account_class_id
                
                WHERE tji.is_deleted = FALSE AND tji.is_active = TRUE
                AND tji.is_sales = TRUE AND tji.is_journal_posted = TRUE AND tji.journal_id > 0
                AND ji.is_deleted = FALSE AND ji.is_active = TRUE
                AND ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ja.account_id = $account_id
                GROUP BY ji.customer_id

            -- Adjustment (dr)
            UNION ALL

            SELECT 
                ji.customer_id,
                0 as previous,
                0 as current,
                0 as billing,
                0 as payment,
                '' as or_details,
                SUM(COALESCE(ba.billing_adjustment_line_total,0)) as adjustment_dr,
                0 as adjustment_cr,
                0 as wtax_expanded

            FROM
                temp_journal_info tji 
                LEFT JOIN journal_info ji ON ji.journal_id = tji.journal_id
                LEFT JOIN b_billing_info bi ON bi.billing_no = tji.ref_no
                LEFT JOIN b_billing_adjustments ba ON ba.billing_id = bi.billing_id
                
                WHERE tji.is_deleted = FALSE AND tji.is_active = TRUE
                AND tji.is_sales = TRUE AND tji.is_journal_posted = TRUE AND tji.journal_id > 0
                AND ji.is_deleted = FALSE AND ji.is_active = TRUE
                AND ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ba.billing_adjustment_type = 0
                GROUP BY ji.customer_id            

            -- Adjustment (cr)
            UNION ALL

            SELECT 
                ji.customer_id,
                0 as previous,
                0 as current,
                0 as billing,
                0 as payment,
                '' as or_details,
                0 as adjustment_dr,
                SUM(COALESCE(ba.billing_adjustment_line_total,0)) as adjustment_cr,
                0 as wtax_expanded

            FROM
                temp_journal_info tji 
                LEFT JOIN journal_info ji ON ji.journal_id = tji.journal_id
                LEFT JOIN b_billing_info bi ON bi.billing_no = tji.ref_no
                LEFT JOIN b_billing_adjustments ba ON ba.billing_id = bi.billing_id
                
                WHERE tji.is_deleted = FALSE AND tji.is_active = TRUE
                AND tji.is_sales = TRUE AND tji.is_journal_posted = TRUE AND tji.journal_id > 0
                AND ji.is_deleted = FALSE AND ji.is_active = TRUE
                AND ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ba.billing_adjustment_type = 1
                GROUP BY ji.customer_id            

            -- Payment
            UNION ALL

            SELECT 
                ji.customer_id,
                0 as previous,
                0 as current,
                0 as billing,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                    )
                ) as payment,
                group_concat(DISTINCT(ji.ref_no)) as or_details,
                0 as adjustment_dr,
                0 as adjustment_cr,
                0 as wtax_expanded

            FROM
                temp_journal_info tji 
                LEFT JOIN journal_info ji ON ji.journal_id = tji.journal_id
                LEFT JOIN journal_accounts ja ON ja.journal_id = tji.journal_id
                LEFT JOIN account_titles at ON at.account_id = ja.account_id
                LEFT JOIN account_classes ac ON ac.account_class_id = at.account_class_id
                
                WHERE tji.is_deleted = FALSE AND tji.is_active = TRUE
                AND tji.is_sales = FALSE AND tji.is_journal_posted = TRUE AND tji.journal_id > 0
                AND tji.payment_id > 0
                AND ji.is_deleted = FALSE AND ji.is_active = TRUE
                AND ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ja.account_id = $account_id
                GROUP BY ji.customer_id

            -- Current
            UNION ALL

                SELECT
                ji.customer_id,
                0 as previous,
                (
                    IF( ac.account_type_id=1 OR ac.account_type_id=5
                        ,SUM(ja.dr_amount)-SUM(ja.cr_amount)
                        ,SUM(ja.cr_amount)-SUM(ja.dr_amount)
                    )
                ) as current,
                0 as billing,
                0 as payment,
                '' as or_details,
                0 as adjustment_dr,
                0 as adjustment_cr,
                0 as wtax_expanded

                FROM `journal_info` as ji

                INNER JOIN (`journal_accounts` as ja
                LEFT JOIN (account_titles as at
                LEFT JOIN account_classes as ac ON ac.account_class_id=at.account_class_id
                ) ON at.account_id=ja.account_id
                ) ON ja.journal_id=ji.journal_id

                WHERE ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=$account_id

                GROUP BY ji.customer_id

            -- 2307 (Withholding Tax (Expanded) Payable) 

            UNION ALL
                SELECT 
                    ji.customer_id,
                    0 as previous,
                    0 as current,
                    0 as billing,
                    0 as payment,
                    '' as or_details,
                    0 as adjustment_dr,
                    0 as adjustment_cr,
                    (SUM(ja.dr_amount) + SUM(ja.cr_amount)) as wtax_expanded
                FROM
                    journal_accounts ja
                    LEFT JOIN journal_info ji ON ji.journal_id = ja.journal_id
                    WHERE ji.`date_txn` BETWEEN '$this_month_start_date' AND '$as_of_date'
                    AND ji.is_active=TRUE AND ji.is_deleted=FALSE AND ja.account_id=
                    (SELECT supplier_wtax_account_id FROM account_integration)
                    
                    GROUP BY ji.customer_id



            ) as m

            LEFT JOIN customers as c ON c.customer_id=m.customer_id

            GROUP BY m.customer_id ORDER BY IFNULL(c.`customer_name`,'Unknown')";

        return $this->db->query($sql)->result();
    }    


    function get_t_account($book,$start,$end,$dep_id){
        $sql="SELECT 
            DATE_FORMAT(ji.date_txn,'%m/%d/%Y')as date_txn,
            ji.txn_no,
            CONCAT(
              IFNULL(s.supplier_name,''),
              IFNULL(c.customer_name,'')
            )as description,
            ji.remarks,
            at.account_title,
            ja.dr_amount,
            ja.cr_amount,
            ji.is_active,
            ji.is_deleted,
            (CASE 
                WHEN (ji.book_type='CRJ')
                THEN 
                    CONCAT(
                      IFNULL(ji.ref_type,''),
                      IFNULL(ji.or_no,'')
                    )
                ELSE
                    CONCAT(
                      IFNULL(ji.ref_type,''),
                      IFNULL(ji.ref_no,''),
                      IFNULL(ji.or_no,'')
                    )
            END) as reference_desc,

            ji.journal_id

            FROM ((`journal_info` as ji
            LEFT JOIN customers as c ON c.customer_id=ji.customer_id)
            LEFT JOIN suppliers as s ON s.supplier_id=ji.supplier_id)
            INNER JOIN (`journal_accounts` as ja
            INNER JOIN account_titles as at ON at.account_id=ja.account_id)
            ON ja.journal_id=ji.journal_id WHERE ji.book_type='$book' AND ji.date_txn BETWEEN '$start' AND '$end' AND ji.is_active = TRUE AND ji.is_deleted = FALSE
            ".($dep_id==0?"":" AND ji.department_id=$dep_id")."
            ORDER BY ji.journal_id ASC";

        return $this->db->query($sql)->result();
    }

        function get_t_account_summary_cdj($book,$start,$end,$dep_id){
        $sql="SELECT 
        journal_data.account_id,
        SUM(journal_data.dr_amount) as dr_amount,
        SUM(journal_data.cr_amount) as cr_amount,
        journal_data.account_title,
        journal_data.account_no
        FROM 
        (SELECT 
            DATE_FORMAT(ji.date_txn,'%m/%d/%Y')as date_txn,
            ji.txn_no,
            CONCAT(
              IFNULL(s.supplier_name,''),
              IFNULL(c.customer_name,'')
            )as description,
            ji.remarks,
            at.account_title,
            ja.dr_amount,
            ja.cr_amount,
            ja.account_id,
            at.account_no

            FROM ((`journal_info` as ji
            LEFT JOIN customers as c ON c.customer_id=ji.customer_id)
            LEFT JOIN suppliers as s ON s.supplier_id=ji.supplier_id)
            INNER JOIN (`journal_accounts` as ja
            INNER JOIN account_titles as at ON at.account_id=ja.account_id)
            ON ja.journal_id=ji.journal_id WHERE ji.book_type='$book'
            AND ji.is_active = TRUE AND ji.is_deleted = FALSE
            AND ji.date_txn BETWEEN '$start' AND '$end'
            ".($dep_id==0?"":" AND ji.department_id=$dep_id")."
            ORDER BY ja.account_id ASC) as journal_data
        GROUP BY journal_data.account_id";
        return $this->db->query($sql)->result();
    }


}

?>