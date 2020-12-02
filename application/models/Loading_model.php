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
            agent.agent_name
        FROM
            loading
            LEFT JOIN agent ON agent.agent_id = loading.agent_id
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
            SUM(li.total_after_tax) AS total_payment,
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
                    p.category_id = (SELECT 
                            loading_category_id
                        FROM
                            account_integration)
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


}




?>