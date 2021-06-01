<?php

class Sales_invoice_item_model extends CORE_Model
{
    protected $table = "sales_invoice_items";
    protected $pk_id = "sales_item_id";
    protected $fk_id = "sales_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_sales_wo_cost(){
        $sql="SELECT * FROM sales_invoice_items WHERE cost_upon_invoice <= 0";
        return $this->db->query($sql)->result();
    }

    function get_adj_return_list($id){
        $sql="SELECT * FROM sales_invoice_items WHERE cost_upon_invoice <= 0";
        return $this->db->query($sql)->result();
    }
}


?>