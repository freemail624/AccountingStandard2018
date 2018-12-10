<?php

class Purchases_integration_model extends CORE_Model{

    protected  $table="purchase_integration"; //table name
    protected  $pk_id="purchase_integration_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function get_list_pos_integration($date=null,$post_id=null){

        $sql="
        SELECT main.*,IF(main.total_amount = main.gross_total, 1,0) as is_balance
        FROM (
        SELECT *,DATE_FORMAT(purchase_integration.date_invoice,'%m/%d/%Y') as date_invoice_format,(purchase_integration.total_tax_amount + purchase_integration.total_before_tax_amount) as gross_total FROM purchase_integration
        ".($date==null?"":" WHERE purchase_integration.is_journal_posted = FALSE AND purchase_integration.date_invoice = '$date'")."
        ".($post_id==null?"":" WHERE purchase_integration.purchase_integration_id=$post_id")."

        ) as main
        ";

        return $this->db->query($sql)->result();
    }

    function get_journal_entries_ap($purchase_integration_id){
        $sql="SELECT main.*
        
            FROM (SELECT 
            (SELECT supplier_inventory_debit_account_id FROM account_integration) as account_id,
            '' as memo,
            IFNULL(pi.total_before_tax_amount,0) as dr_amount,
            0 as cr_amount
            FROM purchase_integration pi
            WHERE pi.purchase_integration_id = $purchase_integration_id

            UNION ALL

            SELECT 
            (SELECT input_tax_account_id FROM account_integration) as account_id,
            '' as memo,
            IFNULL(pi.total_tax_amount,0) as dr_amount,
            0 as cr_amount
            FROM purchase_integration pi
            WHERE pi.purchase_integration_id = $purchase_integration_id
             
             
             UNION ALL
             
             
            SELECT 
            (SELECT payable_account_id FROM account_integration) as account_id,
            '' as memo,
             0 as dr_amount,
            IFNULL(pi.total_amount,0) as cr_amount
            FROM purchase_integration pi
            WHERE pi.purchase_integration_id = $purchase_integration_id

            UNION ALL
            SELECT 
            (SELECT supplier_wtax_account_id FROM account_integration) as account_id,
            '' as memo,
             0 as dr_amount,
            IFNULL(pi.total_wtax,0) as cr_amount
            FROM purchase_integration pi
            WHERE pi.purchase_integration_id = $purchase_integration_id

            ) as main WHERE main.dr_amount>0 OR main.cr_amount>0 ";

        return $this->db->query($sql)->result();
}
}

?>