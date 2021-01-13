<?php

class Loading_model extends CORE_Model{

    protected  $table="loading"; //table name
    protected  $pk_id="loading_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_loading($loading_id=null,$tsd=null,$ted=null){
        $sql="SELECT 
            loading.*,
            DATE_FORMAT(loading.loading_date,'%m/%d/%Y') as loading_date,
            agent.agent_name,
            agent.truck_no,
            CONCAT_WS(user.user_fname,user.user_mname,user.user_lname) as loaded_by,
            user.journal_approved_by,
            items.grand_total_amount,
            invoices.total
        FROM
            loading
            LEFT JOIN agent ON agent.agent_id = loading.agent_id
            LEFT JOIN user_accounts user ON user.user_id = loading.posted_by_user
            LEFT JOIN (SELECT 
            li.loading_id,
            SUM(li.total_after_discount) AS grand_total_amount,
            (SELECT 
                        SUM(sii.inv_qty) AS inv_qty
                    FROM
                        sales_invoice_items sii
                            LEFT JOIN
                        products p ON p.product_id = sii.product_id
                            LEFT JOIN
                        sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                            LEFT JOIN
                        loading_items li ON li.invoice_id = si.sales_invoice_id
                    WHERE
                        p.is_basyo = TRUE
                            AND si.is_deleted = FALSE
                            AND si.is_active = TRUE
                            AND li.loading_id = l.loading_id
                    GROUP BY li.loading_id) AS total_inv_qty
            FROM
                loading_items li
                    LEFT JOIN
                loading l ON l.loading_id = li.loading_id
            WHERE
                l.is_deleted = FALSE
                    AND l.is_active = TRUE
            GROUP BY li.loading_id) as items ON items.loading_id = loading.loading_id
            LEFT JOIN (
                SELECT loading_id, count(*) as total FROM loading_items GROUP BY loading_id 
            ) as invoices ON invoices.loading_id = loading.loading_id
        WHERE
            loading.is_deleted = FALSE AND loading.is_active = TRUE
            ".($loading_id==null?"":" AND loading.loading_id='".$loading_id."'")."
            ".($tsd==null?"":" AND loading.loading_date BETWEEN '".$tsd."' AND '".$ted."'")."
            ";
        return $this->db->query($sql)->result();
    }

    function get_loading_customers($loading_id){
        $sql="SELECT 
            c.customer_name,
            SUM(li.total_after_discount) AS total_payment,
            (SELECT 
                    SUM(sii.inv_qty) AS inv_qty
                FROM
                    sales_invoice_items sii
                        LEFT JOIN
                    products p ON p.product_id = sii.product_id
                        LEFT JOIN
                    sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                        LEFT JOIN
                    loading_items li ON li.invoice_id = si.sales_invoice_id
                WHERE
                    p.is_basyo = TRUE
                        AND si.is_deleted = FALSE
                        AND si.is_active = TRUE
                        AND li.loading_id = l.loading_id
                        AND si.customer_id = c.customer_id
                GROUP BY li.loading_id , si.customer_id) AS total_qty
        FROM
            loading_items li
                LEFT JOIN
            loading l ON l.loading_id = li.loading_id
                LEFT JOIN
            customers c ON c.customer_id = li.customer_id
        WHERE
            l.is_deleted = FALSE
                AND l.is_active = TRUE
                AND l.loading_id = $loading_id
        GROUP BY li.customer_id";
        return $this->db->query($sql)->result();                
    }

    function get_loading_total($loading_id){
        $sql="SELECT 
            SUM(li.total_after_discount) AS total_amount,
            (SELECT 
                    SUM(sii.inv_qty) AS inv_qty
                FROM
                    sales_invoice_items sii
                        LEFT JOIN
                    products p ON p.product_id = sii.product_id
                        LEFT JOIN
                    sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
                        LEFT JOIN
                    loading_items li ON li.invoice_id = si.sales_invoice_id
                WHERE
                    p.is_basyo = TRUE
                        AND si.is_deleted = FALSE
                        AND si.is_active = TRUE
                        AND li.loading_id = l.loading_id
                GROUP BY li.loading_id) AS total_inv_qty
        FROM
            loading_items li
                LEFT JOIN
            loading l ON l.loading_id = li.loading_id
        WHERE
            l.is_deleted = FALSE
                AND l.is_active = TRUE
                AND l.loading_id = $loading_id
        GROUP BY li.loading_id";
        return $this->db->query($sql)->result();         
    }

    function check_invoices($loading_id){
        $sql="SELECT 
            COUNT(*) as total_posted
        FROM
            loading_items li
            LEFT JOIN sales_invoice si ON si.sales_invoice_id = li.invoice_id
            WHERE li.loading_id = $loading_id
            AND is_journal_posted = TRUE";
        return $this->db->query($sql)->result();                
    }

    function check_invoice_loading($sales_invoice_id){
        $sql="SELECT 
                *
            FROM
                loading_items li
                LEFT JOIN loading l ON l.loading_id = li.loading_id
                WHERE l.is_deleted = FALSE AND l.is_active = TRUE
                AND li.invoice_id = $sales_invoice_id";
        return $this->db->query($sql)->result();                
    }


    function get_loading_items($loading_id){
        $sql="SELECT 
            p.category_id,
            p.product_desc,
            SUM(sii.inv_qty) as inv_qty
        FROM
            loading l
            LEFT JOIN loading_items li ON li.loading_id = l.loading_id
            LEFT JOIN sales_invoice_items sii ON sii.sales_invoice_id = li.invoice_id
            LEFT JOIN products p ON p.product_id = sii.product_id
            LEFT JOIN categories c ON c.category_id = p.category_id
            WHERE l.loading_id = $loading_id
            GROUP BY sii.product_id
            ORDER BY p.category_id, p.product_id ASC";
        return $this->db->query($sql)->result();
    }

    function get_loading_categories($loading_id){
        $sql="SELECT 
            DISTINCT c.category_id,
            c.category_name
        FROM
            loading l
            LEFT JOIN loading_items li ON li.loading_id = l.loading_id
            LEFT JOIN sales_invoice_items sii ON sii.sales_invoice_id = li.invoice_id
            LEFT JOIN products p ON p.product_id = sii.product_id
            LEFT JOIN categories c ON c.category_id = p.category_id
            WHERE l.loading_id = $loading_id
            AND c.category_id > 0
            GROUP BY p.category_id
            ORDER BY c.category_id ASC";
        return $this->db->query($sql)->result();
    }


}




?>