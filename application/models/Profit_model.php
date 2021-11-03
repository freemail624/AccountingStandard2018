<?php

class Profit_model extends CORE_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_returns_by_invoice_summary($start,$end,$customer_id=0){
        $sql="
            SELECT 
                allmain.inv_no,
                SUM(allmain.total_net_returned) as total_net_returned,
                SUM(allmain.returned_qty) as returned_qty,
                SUM(allmain.total) as total,
                (CASE
                    WHEN allmain.inv_type_id = 1
                    THEN si_customer.customer_name
                    ELSE ci_customer.customer_name
                END) as customer_name

            FROM

                (SELECT main.*,
                    (main.returned_qty * main.net_returned) as total_net_returned
                FROM 

                (SELECT
                        ai.inv_type_id,
                        ai.inv_no,
                        aii.product_id,
                        aii.adjust_qty as returned_qty,
                        aii.adjust_price,
                        aii.adjust_line_total_price as total,
                        p.product_code,
                        p.product_desc,
                        units.unit_name,


                        (CASE 
                            WHEN ai.inv_type_id = 1 AND aii.adjust_price > 0
                            THEN

                            COALESCE((SELECT 
                                MAX(sii.cost_upon_invoice) as cost_upon_invoice
                                FROM sales_invoice_items sii 
                                LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                                WHERE sii.product_id = aii.product_id AND si.sales_inv_no = ai.inv_no
                            ),0)

                            WHEN ai.inv_type_id = 2 AND aii.adjust_price > 0
                            THEN

                            COALESCE((SELECT 
                                MAX(cii.cost_upon_invoice) as cost_upon_invoice
                                FROM cash_invoice_items cii 
                                LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
                                WHERE cii.product_id = aii.product_id AND ci.cash_inv_no = ai.inv_no
                            ),0)

                            ELSE 0

                        END) as net_returned

                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    LEFT JOIN products p ON p.product_id = aii.product_id
                    LEFT JOIN units ON units.unit_id = aii.unit_id
                    WHERE 
                    ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                    ai.adjustment_type = 'IN' AND 
                    ai.is_returns = 1 AND
                    ai.date_adjusted BETWEEN '$start' AND '$end'
                    ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'").") as main
                ) as allmain
                LEFT JOIN sales_invoice si ON si.sales_inv_no=allmain.inv_no
                LEFT JOIN cash_invoice ci ON ci.cash_inv_no=allmain.inv_no
                LEFT JOIN customers si_customer ON si_customer.customer_id = si.customer_id
                LEFT JOIN customers ci_customer ON ci_customer.customer_id = ci.customer_id
                GROUP BY allmain.inv_no
        ";
        return $this->db->query($sql)->result();
    }

    function get_returns_by_invoice_summary_charge($start,$end,$agent_id=0,$customer_id=0){
        $sql="
            SELECT 
                allmain.inv_no,
                SUM(allmain.total_net_returned) as total_net_returned,
                SUM(allmain.returned_qty) as returned_qty,
                SUM(allmain.total) as total,
                customers.customer_name

            FROM

                (SELECT main.*,
                    (main.returned_qty * main.net_returned) as total_net_returned
                FROM 

                (SELECT
                        ai.inv_type_id,
                        ai.inv_no,
                        aii.product_id,
                        aii.adjust_qty as returned_qty,
                        aii.adjust_price,
                        aii.adjust_line_total_price as total,
                        p.product_code,
                        p.product_desc,
                        units.unit_name,


                        (CASE 
                            WHEN ai.inv_type_id = 1 AND aii.adjust_price > 0
                            THEN

                            COALESCE((SELECT 
                                MAX(sii.cost_upon_invoice) as cost_upon_invoice
                                FROM sales_invoice_items sii 
                                LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                                WHERE sii.product_id = aii.product_id AND si.sales_inv_no = ai.inv_no
                            ),0)
                            ELSE 0

                        END) as net_returned

                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    LEFT JOIN sales_invoice si ON si.sales_inv_no = ai.inv_no
                    LEFT JOIN products p ON p.product_id = aii.product_id
                    LEFT JOIN units ON units.unit_id = aii.unit_id
                    WHERE 
                    ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                    ai.adjustment_type = 'IN' AND 
                    ai.is_returns = 1 AND
                    ai.inv_type_id = 1 AND
                    ai.date_adjusted BETWEEN '$start' AND '$end'
                    ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    ".($agent_id==0?"":" AND si.agent_id='".$agent_id."'").") as main
                ) as allmain
                LEFT JOIN sales_invoice si ON si.sales_inv_no=allmain.inv_no
                LEFT JOIN customers ON customers.customer_id = si.customer_id
                GROUP BY allmain.inv_no
        ";
        return $this->db->query($sql)->result();
    }


    function get_returns_by_invoice_summary_cash($start,$end,$customer_id=0){
        $sql="
            SELECT 
                allmain.inv_no,
                SUM(allmain.total_net_returned) as total_net_returned,
                SUM(allmain.returned_qty) as returned_qty,
                SUM(allmain.total) as total,
                customers.customer_name

            FROM

                (SELECT main.*,
                    (main.returned_qty * main.net_returned) as total_net_returned
                FROM 

                (SELECT
                        ai.inv_type_id,
                        ai.inv_no,
                        aii.product_id,
                        aii.adjust_qty as returned_qty,
                        aii.adjust_price,
                        aii.adjust_line_total_price as total,
                        p.product_code,
                        p.product_desc,
                        units.unit_name,


                        (CASE 
                            WHEN ai.inv_type_id = 2 AND aii.adjust_price > 0
                            THEN

                                COALESCE((SELECT 
                                    MAX(cii.cost_upon_invoice) as cost_upon_invoice
                                    FROM cash_invoice_items cii 
                                    LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
                                    WHERE cii.product_id = aii.product_id AND ci.cash_inv_no = ai.inv_no
                                ),0)

                            ELSE 0

                        END) as net_returned

                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    LEFT JOIN products p ON p.product_id = aii.product_id
                    LEFT JOIN units ON units.unit_id = aii.unit_id
                    WHERE 
                    ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                    ai.adjustment_type = 'IN' AND 
                    ai.is_returns = 1 AND
                    ai.inv_type_id = 2 AND
                    ai.date_adjusted BETWEEN '$start' AND '$end'
                    ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'").") as main
                ) as allmain
                LEFT JOIN cash_invoice ci ON ci.cash_inv_no=allmain.inv_no
                LEFT JOIN customers ON customers.customer_id = ci.customer_id
                GROUP BY allmain.inv_no
        ";
        return $this->db->query($sql)->result();
    }

    function get_returns_by_invoice_detailed($start,$end,$customer_id=0){
        $sql="SELECT main.*,
                (main.returned_qty * main.net_returned) as total_net_returned
            FROM 

            (SELECT
                    ai.inv_no,
                    aii.product_id,
                    aii.adjust_qty as returned_qty,
                    aii.adjust_price,
                    aii.adjust_line_total_price as total,
                    p.product_code,
                    p.product_desc,
                    units.unit_name,

                    (CASE 
                        WHEN ai.inv_type_id = 1 AND aii.adjust_price > 0
                        THEN

                        COALESCE((SELECT 
                            MAX(sii.cost_upon_invoice) as cost_upon_invoice
                            FROM sales_invoice_items sii 
                            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                            WHERE sii.product_id = aii.product_id AND si.sales_inv_no = ai.inv_no
                        ),0)

                        WHEN ai.inv_type_id = 2 AND aii.adjust_price > 0
                        THEN

                        COALESCE((SELECT 
                            MAX(cii.cost_upon_invoice) as cost_upon_invoice
                            FROM cash_invoice_items cii 
                            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
                            WHERE cii.product_id = aii.product_id AND ci.cash_inv_no = ai.inv_no
                        ),0)

                        ELSE 0

                    END) as net_returned

                FROM adjustment_items aii
                LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                LEFT JOIN products p ON p.product_id = aii.product_id
                LEFT JOIN units ON units.unit_id = aii.unit_id
                WHERE 
                ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                ai.adjustment_type = 'IN' AND 
                ai.is_returns = 1 AND
                ai.date_adjusted BETWEEN '$start' AND '$end'
                ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'").") as main
        ";
        return $this->db->query($sql)->result();
    }

    function get_returns_by_invoice_detailed_charge($start,$end,$agent_id=0,$customer_id=0){
        $sql="SELECT main.*,
                (main.returned_qty * main.net_returned) as total_net_returned
            FROM 

            (SELECT
                    ai.inv_no,
                    aii.product_id,
                    aii.adjust_qty as returned_qty,
                    aii.adjust_price,
                    aii.adjust_line_total_price as total,
                    p.product_code,
                    p.product_desc,
                    units.unit_name,

                    (CASE 
                        WHEN ai.inv_type_id = 1 AND aii.adjust_price > 0
                        THEN

                        COALESCE((SELECT 
                            MAX(sii.cost_upon_invoice) as cost_upon_invoice
                            FROM sales_invoice_items sii 
                            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                            WHERE sii.product_id = aii.product_id AND si.sales_inv_no = ai.inv_no
                        ),0)

                        ELSE 0

                    END) as net_returned

                FROM adjustment_items aii
                LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                LEFT JOIN sales_invoice si ON si.sales_inv_no = ai.inv_no
                LEFT JOIN products p ON p.product_id = aii.product_id
                LEFT JOIN units ON units.unit_id = aii.unit_id
                WHERE 
                ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                ai.adjustment_type = 'IN' AND 
                ai.is_returns = 1 AND
                ai.inv_type_id = 1 AND
                ai.date_adjusted BETWEEN '$start' AND '$end'
                ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                ".($agent_id==0?"":" AND si.agent_id='".$agent_id."'").") as main
        ";
        return $this->db->query($sql)->result();
    }

    function get_returns_by_invoice_detailed_cash($start,$end,$customer_id=0){
        $sql="SELECT main.*,
                (main.returned_qty * main.net_returned) as total_net_returned
            FROM 

            (SELECT
                    ai.inv_no,
                    aii.product_id,
                    aii.adjust_qty as returned_qty,
                    aii.adjust_price,
                    aii.adjust_line_total_price as total,
                    p.product_code,
                    p.product_desc,
                    units.unit_name,

                    (CASE 
                        WHEN ai.inv_type_id = 2 AND aii.adjust_price > 0
                        THEN

                        COALESCE((SELECT 
                            MAX(cii.cost_upon_invoice) as cost_upon_invoice
                            FROM cash_invoice_items cii 
                            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
                            WHERE cii.product_id = aii.product_id AND ci.cash_inv_no = ai.inv_no
                        ),0)

                        ELSE 0

                    END) as net_returned

                FROM adjustment_items aii
                LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                LEFT JOIN products p ON p.product_id = aii.product_id
                LEFT JOIN units ON units.unit_id = aii.unit_id
                WHERE 
                ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                ai.adjustment_type = 'IN' AND 
                ai.is_returns = 1 AND
                ai.inv_type_id = 2 AND
                ai.date_adjusted BETWEEN '$start' AND '$end'
                ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'").") as main
        ";
        return $this->db->query($sql)->result();
    }

    function get_profit_by_product($start,$end,$customer_id=0){
        $sql="SELECT

                main.product_id,
                p.product_code,
                p.product_desc,
                (CASE
                    WHEN p.is_parent = TRUE 
                        THEN blkunit.unit_name
                    ELSE chldunit.unit_name
                END) as unit_name,
                SUM(main.inv_qty) as qty_sold,
                p.sale_price as srp,
                SUM(main.inv_gross) as gross,
                p.purchase_cost,
                SUM(main.net_cost) as net_cost,
                (SUM(main.inv_gross) - SUM(main.net_cost)) - (COALESCE(returns.total,0)) as net_profit,
                main.invoice_status,
                (COALESCE(returns.qty,0)) as return_qty,
                (COALESCE(returns.total,0)) as return_amount

                FROM(
                SELECT charge.* FROM (SELECT 
                sii.product_id,
                SUM(sii.inv_qty) as inv_qty,
                SUM(sii.inv_line_total_price) as inv_gross,
                SUM((sii.inv_qty - COALESCE(si_returns.qty,0)) * sii.cost_upon_invoice) as net_cost,
               (CASE
                    WHEN COALESCE(loading.invoice_id,0) > 0
                    THEN 1
                    ELSE 0
                END) as invoice_status

                FROM 
                sales_invoice_items sii
                LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                LEFT JOIN
                (SELECT 
                    li.invoice_id, l.loading_date
                FROM
                    loading_items li
                    LEFT JOIN loading l ON l.loading_id = li.loading_id
                    LEFT JOIN sales_invoice si ON si.sales_invoice_id = li.invoice_id
                    WHERE l.is_deleted = FALSE AND l.is_active = TRUE
                    GROUP BY li.invoice_id) as loading ON loading.invoice_id = si.sales_invoice_id

                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    ai.inv_no,
                    SUM(aii.adjust_qty) as qty
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.inv_type_id = 1 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY ai.inv_no, aii.product_id
                ) as si_returns ON si_returns.inv_no = si.sales_inv_no AND si_returns.product_id = sii.product_id


                WHERE (loading.loading_date BETWEEN '$start' AND '$end') AND si.is_active = TRUE AND si.is_deleted = FALSE
                ".($customer_id==0?"":" AND si.customer_id='".$customer_id."'")."
                GROUP BY sii.sales_invoice_id, sii.product_id) as charge
                WHERE charge.invoice_status > 0

                UNION ALL

                SELECT 
                cii.product_id,
                SUM(cii.inv_qty) as inv_qty,
                SUM(cii.inv_line_total_price) as inv_gross,
                SUM((cii.inv_qty - COALESCE(ci_returns.qty,0)) * cii.cost_upon_invoice) as net_cost,
                1 as invoice_status

                FROM 
                cash_invoice_items cii
                LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id

                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    ai.inv_no,
                    SUM(aii.adjust_qty) as qty
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.inv_type_id = 2 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY ai.inv_no, aii.product_id
                ) as ci_returns ON ci_returns.inv_no = ci.cash_inv_no AND ci_returns.product_id = cii.product_id

                WHERE (ci.date_invoice BETWEEN '$start' AND '$end') AND ci.is_active = TRUE AND ci.is_deleted = FALSE

                ".($customer_id==0?"":" AND ci.customer_id='".$customer_id."'")."
                GROUP BY cii.product_id) as main

                LEFT JOIN products p ON p.product_id = main.product_id
                LEFT JOIN units u ON u.unit_id = p.parent_unit_id
                LEFT JOIN units as blkunit ON blkunit.unit_id = p.bulk_unit_id
                LEFT JOIN units as chldunit ON chldunit.unit_id = p.parent_unit_id
                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    SUM(aii.adjust_qty) as qty,
                    SUM(aii.adjust_line_total_price) as total
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY aii.product_id
                ) as returns ON returns.product_id = main.product_id

                WHERE main.invoice_status > 0

                GROUP BY 
                main.product_id

                ORDER BY p.product_desc ASC
    

        ";

        return $this->db->query($sql)->result();
    }
    function get_profit_by_product_charge($start,$end,$agent_id,$customer_id=0){
        $sql="SELECT

                main.product_id,
                p.product_code,
                p.product_desc,
                (CASE
                    WHEN p.is_parent = TRUE 
                        THEN blkunit.unit_name
                    ELSE chldunit.unit_name
                END) as unit_name,
                SUM(main.inv_qty) as qty_sold,
                p.sale_price as srp,
                SUM(main.inv_gross) as gross,
                p.purchase_cost,
                SUM(main.net_cost) as net_cost,
                (SUM(main.inv_gross) - SUM(main.net_cost)) - (COALESCE(returns.total,0)) as net_profit,
                main.invoice_status,
                (COALESCE(returns.qty,0)) as return_qty,
                (COALESCE(returns.total,0)) as return_amount

                FROM(
                SELECT charge.* FROM (SELECT 
                sii.product_id,
                SUM(sii.inv_qty) as inv_qty,
                SUM(sii.inv_line_total_price) as inv_gross,
                SUM((sii.inv_qty - COALESCE(si_returns.qty,0)) * sii.cost_upon_invoice) as net_cost,
                (CASE
                    WHEN COALESCE(loading.invoice_id,0) > 0
                    THEN 1
                    ELSE 0
                END) as invoice_status                

                FROM 
                sales_invoice_items sii
                LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                LEFT JOIN
                (SELECT 
                    li.invoice_id, l.loading_date
                FROM
                    loading_items li
                    LEFT JOIN loading l ON l.loading_id = li.loading_id
                    LEFT JOIN sales_invoice si ON si.sales_invoice_id = li.invoice_id
                    WHERE l.is_deleted = FALSE AND l.is_active = TRUE
                    GROUP BY li.invoice_id) as loading ON loading.invoice_id = si.sales_invoice_id
                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    ai.inv_no,
                    SUM(aii.adjust_qty) as qty
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.inv_type_id = 1 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY ai.inv_no, aii.product_id
                ) as si_returns ON si_returns.inv_no = si.sales_inv_no AND si_returns.product_id = sii.product_id

                WHERE (loading.loading_date BETWEEN '$start' AND '$end') AND si.is_active = TRUE AND si.is_deleted = FALSE

                ".($customer_id==0?"":" AND si.customer_id='".$customer_id."'")."
                ".($agent_id==0?"":" AND si.agent_id='".$agent_id."'")."

                GROUP BY sii.sales_invoice_id, sii.product_id) as charge
                WHERE charge.invoice_status > 0


                ) as main

                LEFT JOIN products p ON p.product_id = main.product_id
                LEFT JOIN units u ON u.unit_id = p.parent_unit_id
                LEFT JOIN units as blkunit ON blkunit.unit_id = p.bulk_unit_id
                LEFT JOIN units as chldunit ON chldunit.unit_id = p.parent_unit_id
                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    SUM(aii.adjust_qty) as qty,
                    SUM(aii.adjust_line_total_price) as total
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.inv_type_id = 1 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY aii.product_id
                ) as returns ON returns.product_id = main.product_id

                WHERE main.invoice_status > 0

                GROUP BY 
                main.product_id

                ORDER BY p.product_desc ASC
    

        ";

        return $this->db->query($sql)->result();
    }

    function get_profit_by_product_cash($start,$end,$customer_id=0){
        $sql="SELECT

                main.product_id,
                p.product_code,
                p.product_desc,
                (CASE
                    WHEN p.is_parent = TRUE 
                        THEN blkunit.unit_name
                    ELSE chldunit.unit_name
                END) as unit_name,
                SUM(main.inv_qty) as qty_sold,
                p.sale_price as srp,
                SUM(main.inv_gross) as gross,
                p.purchase_cost,
                 SUM(main.net_cost) as net_cost,
                (SUM(main.inv_gross) - SUM(main.net_cost)) - (COALESCE(returns.total,0)) as net_profit,
                (COALESCE(returns.qty,0)) as return_qty,
                (COALESCE(returns.total,0)) as return_amount

                FROM(

                SELECT 
                cii.product_id,
                SUM(cii.inv_qty) as inv_qty,
                SUM(cii.inv_line_total_price) as inv_gross,
                SUM((cii.inv_qty - COALESCE(ci_returns.qty,0)) * cii.cost_upon_invoice) as net_cost

                FROM 
                cash_invoice_items cii
                LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    ai.inv_no,
                    SUM(aii.adjust_qty) as qty
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.inv_type_id = 2 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY ai.inv_no, aii.product_id
                ) as ci_returns ON ci_returns.inv_no = ci.cash_inv_no AND ci_returns.product_id = cii.product_id                
                WHERE (ci.date_invoice BETWEEN '$start' AND '$end') AND ci.is_active = TRUE AND ci.is_deleted = FALSE

                ".($customer_id==0?"":" AND ci.customer_id='".$customer_id."'")."                
                GROUP BY cii.product_id) as main

                LEFT JOIN products p ON p.product_id = main.product_id
                LEFT JOIN units u ON u.unit_id = p.parent_unit_id
                LEFT JOIN units as blkunit ON blkunit.unit_id = p.bulk_unit_id
                LEFT JOIN units as chldunit ON chldunit.unit_id = p.parent_unit_id
                LEFT JOIN
                (
                    SELECT
                    aii.product_id,
                    SUM(aii.adjust_qty) as qty,
                    SUM(aii.adjust_line_total_price) as total
                    FROM adjustment_items aii
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                    WHERE 
                        ai.is_deleted = FALSE AND ai.is_active = TRUE AND
                        ai.adjustment_type = 'IN' AND 
                        ai.is_returns = 1 AND
                        ai.date_adjusted BETWEEN '$start' AND '$end'
                        ".($customer_id==0?"":" AND ai.customer_id='".$customer_id."'")."
                    GROUP BY aii.product_id
                ) as returns ON returns.product_id = main.product_id

                GROUP BY main.product_id

                ORDER BY p.product_desc ASC
    

        ";

        return $this->db->query($sql)->result();
    }


    function get_profit_by_invoice_detailed($start,$end,$distinct=false,$subtotal=false,$customer_id=0){


        $sql="
             ".($distinct==TRUE?" SELECT DISTINCT n.identifier,n.invoice_id,n.inv_no,c.customer_name,n.invoice_status FROM (":" ")."
             ".($subtotal==TRUE?" SELECT n.identifier,n.invoice_id,n.inv_no,c.customer_name,n.date_invoice,SUM(n.inv_qty) as qty_total,SUM(n.inv_gross) as gross_total,SUM(n.net_profit) as profit_total, SUM(n.net_cost) as net_cost_total, n.invoice_status  FROM( ":" ")."

        SELECT
            main.identifier,
            main.invoice_id,
            main.inv_no,
            main.customer_id,
            main.date_invoice,
            p.product_code,
            p.product_desc,
            u.unit_name,
            main.inv_qty,
            main.inv_gross,
            main.net_cost,
            main.srp,
            main.cost_upon_invoice as purchase_cost,
            (main.inv_gross - main.net_cost) as net_profit,
            main.invoice_status

             FROM
             
            (SELECT 
            '1' as identifier,
            si.sales_invoice_id as invoice_id,
            si.sales_inv_no as inv_no,
            si.customer_id,
            si.date_invoice,
            sii.product_id,
            sii.unit_id,
            sii.inv_qty,
            sii.cost_upon_invoice,
            sii.inv_line_total_price as inv_gross,
            (sii.inv_price - sii.inv_discount) as srp,
            (sii.inv_qty * sii.cost_upon_invoice) as net_cost,
            (CASE
                WHEN COALESCE(loading.invoice_id,0) > 0
                THEN 1
                ELSE 0
            END) as invoice_status

            FROM sales_invoice_items sii
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
            LEFT JOIN 
            (SELECT 
                li.invoice_id, l.loading_date
            FROM
                loading_items li
                LEFT JOIN loading l ON l.loading_id = li.loading_id
                LEFT JOIN sales_invoice si ON si.sales_invoice_id = li.invoice_id
                WHERE l.is_deleted = FALSE AND l.is_active = TRUE
                GROUP BY li.invoice_id) as loading ON loading.invoice_id = si.sales_invoice_id

            WHERE (loading.loading_date BETWEEN '$start' AND '$end') AND si.is_active = TRUE AND si.is_deleted = FALSE

            ".($customer_id==0?"":" AND si.customer_id='".$customer_id."'")."
            
            UNION ALL

            SELECT 
            '2' as identifier,
            ci.cash_invoice_id as invoice_id,
            ci.cash_inv_no as inv_no,
            ci.customer_id,
            ci.date_invoice,
            cii.product_id,
            cii.unit_id,
            cii.inv_qty,
            cii.cost_upon_invoice,
            cii.inv_line_total_price as inv_gross,
            (cii.inv_price - cii.inv_discount) as srp,
            (cii.inv_qty * cii.cost_upon_invoice) as net_cost,
            1 as invoice_status

            FROM cash_invoice_items cii
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
            WHERE (ci.date_invoice BETWEEN '$start' AND '$end') AND ci.is_active = TRUE AND ci.is_deleted = FALSE

            ".($customer_id==0?"":" AND ci.customer_id='".$customer_id."'")."

            ) as main

            LEFT JOIN products p ON p.product_id = main.product_id
            LEFT JOIN units u ON u.unit_id = main.unit_id

            ORDER BY main.identifier ASC, main.invoice_id ASC

             ".($distinct==TRUE?") as n 
                LEFT JOIN customers c ON c.customer_id = n.customer_id
                WHERE invoice_status = 1
                ORDER BY n.identifier ASC, n.invoice_id ASC":" ")."
             ".($subtotal==TRUE?" ) as n
                LEFT JOIN customers c ON c.customer_id = n.customer_id
                WHERE invoice_status = 1
                GROUP BY n.invoice_id,n.identifier 
                ORDER BY n.identifier ASC, n.invoice_id ASC
            ":" ")."


             ";

        return $this->db->query($sql)->result();
    }


    function get_profit_by_invoice_detailed_charge($start,$end,$distinct=false,$subtotal=false,$agent_id,$customer_id=0){


        $sql="
             ".($distinct==TRUE?" SELECT DISTINCT n.identifier,n.invoice_id,n.inv_no,c.customer_name,n.invoice_status FROM (":" ")."
             ".($subtotal==TRUE?" SELECT n.identifier,n.invoice_id,n.inv_no,c.customer_name,n.date_invoice,SUM(n.inv_qty) as qty_total,SUM(n.inv_gross) as gross_total,SUM(n.net_profit) as profit_total, SUM(n.net_cost) as net_cost_total, n.invoice_status FROM( ":" ")."

        SELECT
            main.identifier,
            main.invoice_id,
            main.inv_no,
            main.customer_id,
            main.date_invoice,
            p.product_code,
            p.product_desc,
            u.unit_name,
            main.inv_qty,
            main.srp,
            main.cost_upon_invoice as purchase_cost,
            main.inv_gross,
            main.net_cost,
            (main.inv_gross - main.net_cost) as net_profit,
            main.invoice_status

             FROM
             
            (SELECT 
            '1' as identifier,
            si.sales_invoice_id as invoice_id,
            si.sales_inv_no as inv_no,
            si.customer_id,
            si.date_invoice,
            sii.product_id,
            sii.unit_id,
            sii.inv_qty,
            sii.cost_upon_invoice,
            sii.inv_line_total_price as inv_gross,
            (sii.inv_price - sii.inv_discount) as srp,
            (sii.inv_qty * sii.cost_upon_invoice) as net_cost,
            (CASE
                WHEN COALESCE(loading.invoice_id,0) > 0
                THEN 1
                ELSE 0
            END) as invoice_status            

            FROM sales_invoice_items sii
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
            LEFT JOIN
            (SELECT 
                li.invoice_id, l.loading_date
            FROM
                loading_items li
                LEFT JOIN loading l ON l.loading_id = li.loading_id
                LEFT JOIN sales_invoice si ON si.sales_invoice_id = li.invoice_id
                WHERE l.is_deleted = FALSE AND l.is_active = TRUE
                GROUP BY li.invoice_id) as loading ON loading.invoice_id = si.sales_invoice_id

            WHERE (loading.loading_date BETWEEN '$start' AND '$end') AND si.is_active = TRUE AND si.is_deleted = FALSE

            ".($customer_id==0?"":" AND si.customer_id='".$customer_id."'")."
            ".($agent_id==0?"":" AND si.agent_id='".$agent_id."'")."
            
            ) as main

            LEFT JOIN products p ON p.product_id = main.product_id
            LEFT JOIN units u ON u.unit_id = main.unit_id

            ORDER BY main.identifier ASC, main.invoice_id ASC

            ".($distinct==TRUE?") as n 
                LEFT JOIN customers c ON c.customer_id = n.customer_id
                WHERE n.invoice_status > 0
                ORDER BY n.identifier ASC, n.invoice_id ASC":" 
            ")."
            ".($subtotal==TRUE?" ) as n
                LEFT JOIN customers c ON c.customer_id = n.customer_id
                WHERE n.invoice_status > 0
                GROUP BY n.invoice_id,n.identifier 
                ORDER BY n.identifier ASC, n.invoice_id ASC
            ":" ")."

            ";

        return $this->db->query($sql)->result();
    }

    function get_profit_by_invoice_detailed_cash($start,$end,$distinct=false,$subtotal=false,$customer_id=0){


        $sql="
             ".($distinct==TRUE?" SELECT DISTINCT n.identifier,n.invoice_id,n.inv_no,c.customer_name FROM (":" ")."
             ".($subtotal==TRUE?" SELECT n.identifier,n.invoice_id,n.inv_no,c.customer_name,n.date_invoice,SUM(n.inv_qty) as qty_total,SUM(n.inv_gross) as gross_total,SUM(n.net_profit) as profit_total, SUM(n.net_cost) as net_cost_total FROM( ":" ")."

        SELECT
            main.identifier,
            main.invoice_id,
            main.inv_no,
            main.customer_id,
            main.date_invoice,
            p.product_code,
            p.product_desc,
            u.unit_name,
            main.inv_qty,
            main.srp,
            main.cost_upon_invoice as purchase_cost,
            main.inv_gross,
            main.net_cost,
            (main.inv_gross - main.net_cost) as net_profit
             FROM
             
            (
            SELECT 
            '2' as identifier,
            ci.cash_invoice_id as invoice_id,
            ci.cash_inv_no as inv_no,
            ci.customer_id,
            ci.date_invoice,
            cii.product_id,
            cii.unit_id,
            cii.inv_qty,
            cii.cost_upon_invoice,
            cii.inv_line_total_price as inv_gross,
            (cii.inv_price - cii.inv_discount) as srp,
            (cii.inv_qty * cii.cost_upon_invoice) as net_cost

            FROM cash_invoice_items cii
            LEFT JOIN cash_invoice ci ON ci.cash_invoice_id = cii.cash_invoice_id
            WHERE (ci.date_invoice BETWEEN '$start' AND '$end') AND ci.is_active = TRUE AND ci.is_deleted = FALSE

            ".($customer_id==0?"":" AND ci.customer_id='".$customer_id."'")."

            ) as main

            LEFT JOIN products p ON p.product_id = main.product_id
            LEFT JOIN units u ON u.unit_id = main.unit_id

            ORDER BY main.identifier ASC, main.invoice_id ASC

             ".($distinct==TRUE?") as n 
            LEFT JOIN customers c ON c.customer_id = n.customer_id
            ORDER BY n.identifier ASC, n.invoice_id ASC":" ")."
             ".($subtotal==TRUE?" ) as n

            LEFT JOIN customers c ON c.customer_id = n.customer_id
            GROUP BY n.invoice_id,n.identifier 
            ORDER BY n.identifier ASC, n.invoice_id ASC
            ":" ")."


             ";

        return $this->db->query($sql)->result();
    }

 }

 ?>