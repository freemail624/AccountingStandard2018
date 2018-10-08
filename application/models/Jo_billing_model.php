<?php

class Jo_billing_model extends CORE_Model
{
    protected $table = "jo_billing";
    protected $pk_id = "jo_billing_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_jobs_with_balance_qty($job_order_id=null)
    {
        $sql = "SELECT main.*,
                (main.job_qty * main.job_price) as job_line_total
                ,ju.job_unit_name


                 FROM

                (SELECT 

                m.job_order_id,
                m.job_order_no,
                m.job_id,
                m.job_code,
                m.job_desc,
                MAX(m.job_price) as job_price,
                (SUM(m.JoQty) - SUM(m.JbQty)) AS job_qty,
                MAX(m.job_unit) AS job_unit_id

                 FROM 


                (SELECT 
                jo.job_order_id,
                jo.job_order_no,
                joi.job_id,
                joi.job_code,
                joi.job_desc,
                SUM(joi.job_qty) as JoQty,
                0 as JbQty,
                joi.job_price,
                joi.job_unit

                FROM
                job_order jo 

                INNER JOIN job_order_items joi ON joi.job_order_id = jo.job_order_id
                WHERE jo.job_order_id = $job_order_id AND jo.is_active= TRUE AND jo.is_deleted = FALSe

                GROUP BY jo.job_order_no,joi.job_id

                UNION ALL

                SELECT 
                jo.job_order_id,
                jo.job_order_no,
                jbl.job_id,
                jbl.job_code,
                jbl.job_desc,
                0 as JoQty,
                SUM(jbl.job_qty) as JbQty,
                0 AS job_price,
                0 AS unit_id

                FROM (jo_billing jb
                INNER JOIN job_order jo On jo.job_order_id = jb.job_order_id)
                INNER JOIN jo_billing_items jbl ON jbl.jo_billing_id = jb.jo_billing_id
                WHERE jb.job_order_id = $job_order_id AND jb.is_active = TRUE AND jb.is_deleted = FALSE

                GROUP BY jo.job_order_no,jbl.job_id) as m

                GROUP BY m.job_order_no,m.job_id
                HAVING job_qty > 0) as main
                LEFT JOIN jobs jj ON jj.job_id = main.job_id
                LEFT JOIN job_unit ju ON ju.job_unit_id = main.job_unit_id


                ";

            return $this->db->query($sql)->result();
    }
        //  THIS IS THE DISCOUNT FOR get_journal_entries_for_billing - IT WAS REMOVED, BECAUSE IT IS NOT NEEDED IN ACCOUNTING
            // UNION ALL


            // SELECT acc_payable.account_id,
            // acc_payable.memo,
            // 0 as dr_amount,
            // (line_total - line_total_after_global) as cr_amount
            //  FROM
            // (SELECT joi.job_id,

            // (SELECT payable_discount_account_id FROM account_integration) as account_id
            // ,
            // '' as memo,
            // 0 cr_amount,
            // SUM(IFNULL(joi.job_line_total_after_global,0)) as line_total_after_global,
            // SUM(IFNULL(joi.job_line_total,0)) as line_total

            // FROM jo_billing_items as joi
            // INNER JOIN jobs as j ON j.job_id=joi.job_id
            // WHERE joi.jo_billing_id= $jo_billing_id AND j.expense_account_id>0
            // ) as acc_payable GROUP BY acc_payable.account_id


    function get_journal_entries_for_billing($jo_billing_id){


        $sql="SELECT main.* FROM(
            SELECT 
            j.expense_account_id as account_id,
            '' as memo,
            SUM(joi.job_line_total_after_global) as dr_amount,
            0 as cr_amount


            FROM 
            jo_billing_items joi 
            LEFT JOIN jobs j ON j.job_id = joi.job_id
            WHERE joi.jo_billing_id= $jo_billing_id AND j.expense_account_id>0
            GROUP BY j.expense_account_id

            UNION ALL


            SELECT acc_payable.account_id,
            acc_payable.memo,
            0 as dr_amount,
            SUM(acc_payable.dr_amount) as cr_amount

            FROM 

            (SELECT joi.job_id,
            (SELECT payable_account_id FROM account_integration) as account_id,
            '' as memo,
            SUM(joi.job_line_total_after_global) as dr_amount,
            0 as cr_amount

            FROM jo_billing_items as joi
            INNER JOIN jobs j ON j.job_id  = joi.job_id
            WHERE joi.jo_billing_id = $jo_billing_id AND j.expense_account_id > 0

            ) as acc_payable 

            GROUP BY acc_payable.account_id


           

            )as main WHERE main.dr_amount>0 OR main.cr_amount>0
            ";

        return $this->db->query($sql)->result();

    }


    function get_jo_balance_qty($id){
        $sql="SELECT SUM(x.balance) as balance FROM 

        (SELECT 
        m.job_order_id,m.job_order_no,m.job_id,
        (SUM(m.JoQty) - SUM(m.JbQty)) AS balance
        FROM 
            (SELECT 
            jo.job_order_id,jo.job_order_no,joi.job_id,
            SUM(joi.job_qty) as JoQty,
            0 as JbQty
            FROM
            job_order jo 
            INNER JOIN job_order_items joi ON joi.job_order_id = jo.job_order_id
            WHERE jo.job_order_id = $id AND jo.is_active= TRUE AND jo.is_deleted = FALSe
            GROUP BY jo.job_order_no,joi.job_id

            UNION ALL

            SELECT 
            jo.job_order_id,jo.job_order_no,jbl.job_id,0 as JoQty,
            SUM(jbl.job_qty) as JbQty

            FROM (jo_billing jb
            INNER JOIN job_order jo On jo.job_order_id = jb.job_order_id)
            INNER JOIN jo_billing_items jbl ON jbl.jo_billing_id = jb.jo_billing_id
            WHERE jb.job_order_id = $id AND jb.is_active = TRUE AND jb.is_deleted = FALSE
            GROUP BY jo.job_order_no,jbl.job_id) as m
        GROUP BY m.job_order_no, m.job_id) as x";

        return $this->db->query($sql)->result();
    }

}


?>