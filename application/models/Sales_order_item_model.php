<?php

class Sales_order_item_model extends CORE_Model
{
    protected $table = "sales_order_items";
    protected $pk_id = "sales_order_item_id";
    protected $fk_id = "sales_order_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_products_with_balance_qty_so($sales_order_id){
/*    $sql="SELECT o.*,(o.so_line_total-o.non_tax_amount)as tax_amount FROM

                (SELECT n.*,

                ((n.so_price*n.so_qty)-(n.so_discount*n.so_qty))as so_line_total,
                ((n.so_price*n.so_qty)/(1+tax_rate_decimal))as non_tax_amount,
                (n.so_discount*n.so_qty) as so_line_total_discount
ORIGINAL QUERY OF THE FUNCTION
*/
    $sql="SELECT o.*,(o.so_line_total-o.non_tax_amount) as tax_amount FROM

                (SELECT n.*,               
                (n.so_price*n.so_qty) as inv_gross,
                (n.so_price*n.so_qty) as line_total,
                ((((n.so_price*n.so_qty)-(n.so_discount*n.so_qty)) -  
                (((n.so_price*n.so_qty)-(n.so_discount*n.so_qty))*(n.total_overall_discount/100))
                ) / (1+tax_rate_decimal)) as non_tax_amount,
                (((n.so_price*n.so_qty)-(n.so_discount*n.so_qty)) -  
                (((n.so_price*n.so_qty)-(n.so_discount*n.so_qty))*(n.total_overall_discount/100))
                ) as so_line_total,
                (n.so_discount*n.so_qty) as so_line_total_discount  

                -- ((n.so_price*n.so_qty)-((n.so_price*n.so_qty)*(n.so_discount/100)))as so_line_total,
                -- ((n.so_price*n.so_qty)*(n.so_discount/100)) as so_line_total_discount,

            /* END OF EDIT FOR COMPUTATION FOR SALES ORDER AS BUTTON ACCEPT IS CLICKED */          
                FROM
                (SELECT main.*,
                p.purchase_cost,
                p.size, (main.so_tax_rate/100)as tax_rate_decimal,
                p.product_code,
                p.product_desc,
                p.sale_price,
                p.discounted_price,
                p.dealer_price,
                p.distributor_price,
                p.public_price,
                p.parent_unit_id,
                p.child_unit_id,
                p.child_unit_desc,
                p.is_bulk,
                p.is_basyo,
                (CASE
                    WHEN p.is_parent = TRUE 
                        THEN p.bulk_unit_id
                    ELSE parent_unit_id
                END) as product_unit_id,
                (CASE
                    WHEN p.is_parent = TRUE 
                        THEN blkunit.unit_name
                    ELSE chldunit.unit_name
                END) as product_unit_name,
                (SELECT unit_name FROM units u WHERE u.unit_id = p.parent_unit_id) as parent_unit_name,
                (SELECT unit_name FROM units u WHERE u.unit_id = p.child_unit_id) as child_unit_name,
                (SELECT count(*) FROM account_integration WHERE basyo_product_id = p.product_id) as is_product_basyo

                 FROM

                (
                SELECT
                m.sales_order_id,
                m.so_no,m.product_id,m.batch_no,m.exp_date,
                MAX(m.so_price)as so_price,
                MAX(m.so_discount)as so_discount,
                MAX(m.so_tax_rate)as so_tax_rate,
                (SUM(m.SoQty)-SUM(m.InvQty))as so_qty,
                MAX(m.unit_id) as unit_id,
                MAX(m.is_parent) as is_parent,
                MAX(m.total_overall_discount) as total_overall_discount


                FROM

                (
                    SELECT so.sales_order_id,
                    so.so_no,
                    soi.product_id,
                    so_price as price,SUM(soi.so_qty) as SoQty,
                    0 as InvQty,
                    soi.so_price,
                    soi.so_discount,
                    soi.so_tax_rate,
                    soi.batch_no,
                    soi.exp_date,
                        soi.unit_id,
                        soi.is_parent,
                        so.total_overall_discount
                    FROM sales_order as so
                    INNER JOIN sales_order_items as soi ON so.sales_order_id=soi.sales_order_id
                    WHERE so.sales_order_id=$sales_order_id AND so.is_active=TRUE AND so.is_deleted=FALSE
                    GROUP BY so.so_no,soi.product_id


                    UNION ALL
                    

                    SELECT so.sales_order_id,
                    so.so_no,
                    sii.product_id,
                    orig_so_price as price,
                    0 as SoQty,
                    SUM(sii.inv_qty) as InvQty,
                    0 as so_price,
                    0 as so_discount,
                    0 as so_tax_rate,
                    sii.batch_no,
                    sii.exp_date,
                        0 as unit_id,
                        0 as is_parent,
                        0 as total_overall_discount

                    FROM (sales_invoice as si
                    INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
                    INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
                    WHERE so.sales_order_id=$sales_order_id AND si.is_active=TRUE AND si.is_deleted=FALSE
                    GROUP BY so.so_no,sii.product_id

                    UNION ALL

                    SELECT so.sales_order_id,
                    so.so_no,
                    cii.product_id,
                    orig_so_price as price,
                    0 as SoQty,
                    SUM(cii.inv_qty) as InvQty,
                    0 as so_price,
                    0 as so_discount,
                    0 as so_tax_rate,
                    cii.batch_no,
                    cii.exp_date,
                        0 as unit_id,
                        0 as is_parent,
                        0 as total_overall_discount

                    FROM (cash_invoice as ci
                    INNER JOIN sales_order as so ON ci.sales_order_id=so.sales_order_id)
                    INNER JOIN cash_invoice_items as cii ON ci.cash_invoice_id=cii.cash_invoice_id
                    WHERE so.sales_order_id=$sales_order_id AND ci.is_active=TRUE AND ci.is_deleted=FALSE
                    GROUP BY so.so_no,cii.product_id


                    )as

                    m GROUP BY m.so_no,m.product_id HAVING so_qty>0

                )as main


                LEFT JOIN products as p ON main.product_id=p.product_id
                LEFT JOIN units as blkunit ON blkunit.unit_id = p.bulk_unit_id
                LEFT JOIN units as chldunit ON chldunit.unit_id = p.parent_unit_id

                ) as n) as o ";

        return $this->db->query($sql)->result();

    }




    function get_list_open_sales(){
        $sql="SELECT o.* FROM

                (SELECT n.*

                FROM
                (SELECT main.*,p.product_code,p.product_desc FROM

                (
                SELECT
                m.sales_order_id,
                m.so_no,m.product_id,
                max(m.date_invoice) as last_invoice_date,
                m.SoQty as SoQtyTotal,
                (m.SoQty - (SUM(m.SoQty)-SUM(m.InvQty))) as SoQtyDelivered,
                (SUM(m.SoQty)-SUM(m.InvQty))as SoQtyBalance


                FROM

                (
                    SELECT so.sales_order_id,so.so_no,'' as date_invoice,soi.product_id,SUM(soi.so_qty) as SoQty,0 as InvQty
                    FROM sales_order as so
                    INNER JOIN sales_order_items as soi ON so.sales_order_id=soi.sales_order_id
                    WHERE  so.is_active=TRUE AND so.is_deleted=FALSE
                    GROUP BY so.so_no,soi.product_id

                    UNION ALL

                    SELECT so.sales_order_id,so.so_no,max(si.date_invoice),sii.product_id,0 as SoQty,SUM(sii.inv_qty) as InvQty
                    FROM (sales_invoice as si
                    INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
                    INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
                    WHERE  si.is_active=TRUE AND si.is_deleted=FALSE
                    GROUP BY so.so_no,sii.product_id

                    UNION ALL

                    SELECT 
                    so.sales_order_id,so.so_no,max(ci.date_invoice),cii.product_id,0 as SoQty,SUM(cii.inv_qty) as InvQty
                    FROM cash_invoice ci
                    INNER JOIN sales_order so ON so.sales_order_id = ci.sales_order_id
                    INNER JOIN cash_invoice_items cii ON cii.cash_invoice_id = ci.cash_invoice_id
                    WHERE ci.is_active = TRUE AND ci.is_deleted = FALSE
                    GROUP BY so.so_no,cii.product_id

                    )as

                    m GROUP BY m.so_no,m.product_id HAVING SoQtyBalance>0

                )as main


                LEFT JOIN products as p ON main.product_id=p.product_id
              )as n) as o";


        return $this->db->query($sql)->result();
    }


    function get_so_no_of_open_sales(){
        $sql="SELECT o.* FROM

                (SELECT n.*

        


                FROM
                (SELECT DISTINCT main.so_no FROM

                (
                SELECT
                m.sales_order_id,
                m.so_no,m.product_id,
            
                m.SoQty as SoQtyTotal,
   
                (SUM(m.SoQty)-SUM(m.InvQty))as SoQtyBalance


                FROM

                (
                    SELECT so.sales_order_id,so.so_no,soi.product_id,SUM(soi.so_qty) as SoQty,0 as InvQty
                    FROM sales_order as so
                    INNER JOIN sales_order_items as soi ON so.sales_order_id=soi.sales_order_id
                    WHERE  so.is_active=TRUE AND so.is_deleted=FALSE
                    GROUP BY so.so_no,soi.product_id


                    UNION ALL
                    

                    SELECT so.sales_order_id,so.so_no,sii.product_id,0 as SoQty,SUM(sii.inv_qty) as InvQty
                    FROM (sales_invoice as si
                    INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
                    INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
                    WHERE  si.is_active=TRUE AND si.is_deleted=FALSE
                    GROUP BY so.so_no,sii.product_id)as

                    m GROUP BY m.so_no,m.product_id HAVING SoQtyBalance>0

                )as main


                LEFT JOIN products as p ON main.product_id=p.product_id
               )as n) as o";




        return $this->db->query($sql)->result();


    }

}


?>