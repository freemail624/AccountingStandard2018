<?php

class Service_invoice_model extends CORE_Model
{
    protected $table = "service_invoice";
    protected $pk_id = "service_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_all_data($search_value=null,$start_date=null,$end_date=null)
    {
        $sql="SELECT si.* 
        FROM
            service_invoice si
                LEFT JOIN
            repair_order ro ON ro.repair_order_id = si.repair_order_id
                LEFT JOIN
            customers c ON c.customer_id = si.customer_id
                LEFT JOIN
            customer_vehicles v ON v.vehicle_id = si.vehicle_id
                LEFT JOIN
            advisors ON advisors.advisor_id = si.advisor_id

    		WHERE si.is_deleted = FALSE AND si.is_active = TRUE

            ".($start_date==null?"":" AND DATE_FORMAT(si.document_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")."
            ".($search_value==null?"":" 
            AND (LOWER(si.service_invoice_no) LIKE LOWER('".$search_value."%') OR 
            LOWER(ro.repair_order_no) LIKE LOWER('%".$search_value."%') OR 
            LOWER(c.customer_name) LIKE LOWER('%".$search_value."%') OR
            LOWER(v.plate_no) LIKE LOWER('%".$search_value."%') OR 
            LOWER(CONCAT_WS(' ',advisors.advisor_fname,advisors.advisor_mname,advisors.advisor_lname)) LIKE LOWER('%".$search_value."%'))")."


        ";
        return $this->db->query($sql)->num_rows();
    }

    function get_service_invoice_list(
            $service_invoice_id=null,
            $start_date=null,
            $end_date=null,
            $search_value=null,
		    $length=null,
		    $start=0,
		    $order_column=null,
		    $order_dir=null){

        $query = $this->db->query("SELECT 
            c.customer_no,
            c.customer_name,
            c.tin_no,
            si.*,
            ro.repair_order_no,
            v.plate_no,
            CONCAT_WS(' ',
                    advisors.advisor_fname,
                    advisors.advisor_mname,
                    advisors.advisor_lname) AS advisor_fullname,
            DATE_FORMAT(si.document_date, '%d %b %Y') AS document_date,
            DATE_FORMAT(si.document_date, '%I:%i %p') AS time_received,
            DATE_FORMAT(si.date_time_promised,
                    '%d %b %Y   %I:%i %p') AS date_time_promised,
            DATE_FORMAT(v.delivery_date, '%d %b %Y') AS delivery_date,
            DATE_FORMAT(si.next_svc_date, '%d %b %Y') AS next_svc_date,
            DATE_FORMAT(si.next_svc_date, '%m/%d/%Y') AS next_svc_date_edit,
            DATE_FORMAT(v.delivery_date, '%m/%d/%Y') AS delivery_date_edit,
            DATE_FORMAT(si.document_date, '%m/%d/%Y %h:%i %p') AS document_date_edit,
            DATE_FORMAT(si.date_time_promised, '%m/%d/%Y %h:%i %p') AS date_time_promised_edit

        FROM
            service_invoice si
                LEFT JOIN
            repair_order ro ON ro.repair_order_id = si.repair_order_id
                LEFT JOIN
            customers c ON c.customer_id = si.customer_id
                LEFT JOIN
            customer_vehicles v ON v.vehicle_id = si.vehicle_id
                LEFT JOIN
            advisors ON advisors.advisor_id = si.advisor_id

            WHERE si.is_deleted = FALSE AND
                si.is_active = TRUE
                ".($start_date==null?"":" AND DATE_FORMAT(si.document_date, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'")."
                ".($service_invoice_id==null?"":" AND si.service_invoice_id='".$service_invoice_id."'")."

                ".($search_value==null?"":" 
                AND (LOWER(si.service_invoice_no) LIKE LOWER('".$search_value."%') OR 
                LOWER(ro.repair_order_no) LIKE LOWER('%".$search_value."%') OR 
                LOWER(c.customer_name) LIKE LOWER('%".$search_value."%') OR
                LOWER(v.plate_no) LIKE LOWER('%".$search_value."%') OR 
                LOWER(CONCAT_WS(' ',advisors.advisor_fname,advisors.advisor_mname,advisors.advisor_lname)) LIKE LOWER('%".$search_value."%'))")."
    
                ".($order_column==null?" ORDER BY si.service_invoice_id DESC ":" ORDER BY ".$order_column." ".$order_dir."")."
                ".($length==null?"":" LIMIT ".$length."")."
                ".($start==0?"":" OFFSET ".$start."")."

            ");
        return $query->result();
    }

 function get_journal_entries($service_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            s.income_account_id as account_id,
            '' as memo,
            SUM(sii.service_line_total) as cr_amount,
            0 as dr_amount

            FROM `service_invoice_items` as sii
            INNER JOIN services as s ON sii.service_id=s.service_id
            WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0
            GROUP BY s.income_account_id

            UNION ALL

			         SELECT acc_receivable.*
             FROM
            (SELECT 

            (SELECT receivable_account_id FROM account_integration) as account_id,
            '' as memo,
            0 cr_amount,
            si.total_amount_after_discount as dr_amount

            FROM service_invoice as si
            WHERE si.service_invoice_id=$service_invoice_id
            ) as acc_receivable GROUP BY acc_receivable.account_id
            
            UNION ALL
            
            SELECT acc_discount.*
             FROM
            (SELECT 

            (SELECT receivable_discount_account_id FROM account_integration) as account_id,
            '' as memo,
            0 cr_amount,
            si.total_overall_discount_amount as dr_amount

            FROM service_invoice as si
            WHERE si.service_invoice_id=$service_invoice_id
            ) as acc_discount GROUP BY acc_discount.account_id     


            ) as main WHERE main.dr_amount>0 OR main.cr_amount>0";


        return $this->db->query($sql)->result();

 }

        function get_journal_entries_2($service_invoice_id){

        $sql="SELECT 
                main.*
            FROM
                (SELECT 
                    acc_receivable.account_id,
                        acc_receivable.memo,
                        0 AS cr_amount,
                        SUM(acc_receivable.dr_amount) AS dr_amount
                FROM
                    (SELECT 
                    sii.product_id,
                        (SELECT 
                                receivable_account_id
                            FROM
                                account_integration) AS account_id,
                        '' AS memo,
                        0 cr_amount,
                        SUM(sii.service_line_total_price) AS dr_amount
                FROM
                    `service_invoice_items` AS sii
                INNER JOIN products AS p ON sii.product_id = p.product_id
                WHERE
                    sii.service_invoice_id = $service_invoice_id
                        AND p.income_account_id > 0) AS acc_receivable
                GROUP BY acc_receivable.account_id UNION ALL SELECT 
                    p.cos_account_id AS account_id,
                        '' AS memo,
                        0 AS cr_amount,
                        SUM(sii.service_qty * sii.cost_upon_invoice) AS dr_amount
                FROM
                    `service_invoice_items` AS sii
                INNER JOIN products AS p ON sii.product_id = p.product_id
                WHERE
                    sii.service_invoice_id = $service_invoice_id
                        AND p.cos_account_id > 0
                GROUP BY p.cos_account_id UNION ALL SELECT 
                    p.sd_account_id AS account_id,
                        '' AS memo,
                        0 cr_amount,
                        (si.total_overall_discount_amount + si.total_amount_after_discount) AS dr_amount
                FROM
                    `service_invoice_items` AS sii
                INNER JOIN products AS p ON sii.product_id = p.product_id
                LEFT JOIN service_invoice si ON si.service_invoice_id = sii.service_invoice_id
                WHERE
                    sii.service_invoice_id = $service_invoice_id
                        AND p.sd_account_id > 0
                GROUP BY p.sd_account_id UNION ALL SELECT 
                    p.expense_account_id AS account_id,
                        '' AS memo,
                        SUM(sii.service_qty * sii.cost_upon_invoice) cr_amount,
                        0 AS dr_amount
                FROM
                    `service_invoice_items` AS sii
                INNER JOIN products AS p ON sii.product_id = p.product_id
                WHERE
                    sii.service_invoice_id = $service_invoice_id
                        AND p.expense_account_id > 0
                GROUP BY p.expense_account_id UNION ALL SELECT 
                    p.income_account_id AS account_id,
                        '' AS memo,
                        (SUM(sii.service_non_tax_amount) + si.total_overall_discount_amount + si.total_amount_after_discount) cr_amount,
                        0 AS dr_amount
                FROM
                    `service_invoice_items` AS sii
                INNER JOIN products AS p ON sii.product_id = p.product_id
                LEFT JOIN service_invoice si ON si.service_invoice_id = sii.service_invoice_id
                WHERE
                    sii.service_invoice_id = $service_invoice_id
                        AND p.income_account_id > 0
                GROUP BY p.income_account_id UNION ALL SELECT 
                    output_tax.account_id,
                        output_tax.memo,
                        SUM(output_tax.cr_amount) AS cr_amount,
                        0 AS dr_amount
                FROM
                    (SELECT 
                    sii.product_id,
                        (SELECT 
                                output_tax_account_id
                            FROM
                                account_integration) AS account_id,
                        '' AS memo,
                        SUM(sii.service_tax_amount) AS cr_amount,
                        0 AS dr_amount
                FROM
                    `service_invoice_items` AS sii
                INNER JOIN products AS p ON sii.product_id = p.product_id
                WHERE
                    sii.service_invoice_id = $service_invoice_id
                        AND p.income_account_id > 0) AS output_tax
                GROUP BY output_tax.account_id) AS main
            WHERE
                main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();
}

    // function get_journal_entries_2($service_invoice_id){


    //     $sql="SELECT main.* FROM
    //         (SELECT
    //         s.income_account_id as account_id,
    //         '' as memo,
    //         SUM(sii.service_line_total) cr_amount,
    //         0 as dr_amount

    //         FROM `service_invoice_items` as sii
    //         INNER JOIN services as s ON sii.service_id=s.service_id
    //         WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0

    //         GROUP BY s.income_account_id
            
    //         UNION ALL
            
    //         SELECT acc_receivable.account_id,acc_receivable.memo,
    //         0 as cr_amount,SUM(acc_receivable.dr_amount) as dr_amount
    //          FROM
    //         (SELECT sii.service_id,

    //         (SELECT receivable_account_id FROM account_integration) as account_id
    //         ,
    //         '' as memo,
    //         0 cr_amount,
    //         SUM(sii.service_line_total_after_global) as dr_amount

    //         FROM `service_invoice_items` as sii
    //         INNER JOIN services as s ON sii.service_id=s.service_id
    //         WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0
    //         ) as acc_receivable GROUP BY acc_receivable.account_id
            
    //         UNION ALL
            
    //         SELECT acc_receivable.account_id,acc_receivable.memo,
    //         0 as cr_amount, 
    //         (line_total - line_total_after_global) as dr_amount
    //          FROM
    //         (SELECT sii.service_id,

    //         (SELECT receivable_discount_account_id FROM account_integration) as account_id
    //         ,
    //         '' as memo,
    //         0 cr_amount,
    //         SUM(IFNULL(sii.service_line_total_after_global,0)) as line_total_after_global,
    //         SUM(IFNULL(sii.service_line_total,0)) as line_total

    //         FROM `service_invoice_items` as sii
    //         INNER JOIN services as s ON sii.service_id=s.service_id
    //         WHERE sii.service_invoice_id=$service_invoice_id AND s.income_account_id>0
    //         ) as acc_receivable GROUP BY acc_receivable.account_id
            
    //         )as main WHERE main.dr_amount>0 OR main.cr_amount>0";

    //     return $this->db->query($sql)->result();

    // }

}


?>