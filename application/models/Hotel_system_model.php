<?php

class Hotel_system_model extends CORE_Model{

    protected  $table="prime_hotel_integration"; //table name
    protected  $pk_id="prime_hotel_integration_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_list_hotel_integration($date){
        $sql="SELECT hi.*,
        (CASE 
            WHEN item_type = 'ADV' THEN  'Advance Payment'
            WHEN item_type = 'REV' THEN 'Reverse Transaction'
            WHEN item_type = 'COUT' THEN 'Check Out'
            WHEN item_type = 'AR' THEN 'Accounts Receivable' END ) as transaction,
        DATE_FORMAT(hi.shift_date,'%m/%d/%Y')as shift_date
        FROM prime_hotel_integration hi
        WHERE hi.is_journal_posted = FALSE AND hi.shift_date = '$date'
        ORDER BY hi.prime_hotel_integration_id ASC";

        return $this->db->query($sql)->result();
    }


    function get_transaction_summary($date){
        $sql="SELECT main.*, ac.account_title FROM
        (

        SELECT adv_cash.*,
        (IFNULL(adv_cash.dr_amount,0) - IFNULL(adv_cash.cr_amount,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.adv_cash_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.adv_cash_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'ADV' AND phi.shift_date = '$date') as dr_amount,
        (SELECT IFNULL(SUM(phi.adv_cash_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'REV' AND phi.shift_date = '$date') as cr_amount) as adv_cash
        

        UNION ALL

        SELECT adv_check.*,
        (IFNULL(adv_check.dr_amount,0) - IFNULL(adv_check.cr_amount,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.adv_check_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.adv_check_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'ADV' AND phi.shift_date = '$date') as dr_amount,
        (SELECT IFNULL(SUM(phi.adv_check_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'REV' AND phi.shift_date = '$date') as cr_amount) as adv_check


        UNION ALL

        SELECT adv_card.*,
        (IFNULL(adv_card.dr_amount,0) - IFNULL(adv_card.cr_amount,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.adv_card_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.adv_card_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'ADV' AND phi.shift_date = '$date') as dr_amount,
        (SELECT IFNULL(SUM(phi.adv_card_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'REV' AND phi.shift_date = '$date') as cr_amount) as adv_card

        UNION ALL

        SELECT adv_charge.*,
        (IFNULL(adv_charge.dr_amount,0) - IFNULL(adv_charge.cr_amount,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.adv_charge_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.adv_charge_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'ADV' AND phi.shift_date = '$date') as dr_amount,
        (SELECT IFNULL(SUM(phi.adv_charge_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'REV' AND phi.shift_date = '$date') as cr_amount) as adv_charge


        UNION ALL

        SELECT adv_bank_dep.*,
        (IFNULL(adv_bank_dep.dr_amount,0) - IFNULL(adv_bank_dep.cr_amount,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.adv_bank_dep_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.adv_bank_dep_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'ADV' AND phi.shift_date = '$date') as dr_amount,
        (SELECT IFNULL(SUM(phi.adv_bank_dep_total),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'REV' AND phi.shift_date = '$date') as cr_amount) as adv_bank_dep

        UNION ALL

        SELECT adv_sales.*,
        (IFNULL(adv_sales.dr_amount,0) - IFNULL(adv_sales.cr_amount,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.adv_sales_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.adv_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'ADV' AND phi.shift_date = '$date') as dr_amount,
        (SELECT IFNULL(SUM(phi.adv_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'REV' AND phi.shift_date = '$date') as cr_amount) as adv_sales

        UNION ALL

        SELECT 
        cash_sales.account_id,
        (IFNULL(cash_sales.cout_cash,0) + IFNULL(cash_sales.ar_cash,0)) as dr_amount,
        0 as cr_amount,
        (IFNULL(cash_sales.cout_cash,0) + IFNULL(cash_sales.ar_cash,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.cash_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.cash_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_cash,
        (SELECT IFNULL(SUM(phi.cash_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_cash) as cash_sales

        UNION ALL

        SELECT 
        check_sales.account_id,
        (IFNULL(check_sales.cout_check,0) + IFNULL(check_sales.ar_check,0)) as dr_amount,
        0 as cr_amount,
        (IFNULL(check_sales.cout_check,0) + IFNULL(check_sales.ar_check,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.check_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.check_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_check,
        (SELECT IFNULL(SUM(phi.check_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_check) as check_sales

        UNION ALL

        SELECT 
        card_sales.account_id,
        (IFNULL(card_sales.cout_card,0) + IFNULL(card_sales.ar_card,0)) as dr_amount,
        0 as cr_amount,
        (IFNULL(card_sales.cout_card,0) + IFNULL(card_sales.ar_card,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.card_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.card_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT'  AND phi.shift_date = '$date') as cout_card,
        (SELECT IFNULL(SUM(phi.card_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR'  AND phi.shift_date = '$date') as ar_card) as card_sales

        UNION ALL

        SELECT 
        charge_sales.account_id,
        (IFNULL(charge_sales.cout_charge,0) + IFNULL(charge_sales.ar_charge,0)) as dr_amount,
        0 as cr_amount,
        (IFNULL(charge_sales.cout_charge,0) + IFNULL(charge_sales.ar_charge,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.charge_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.charge_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_charge,
        (SELECT IFNULL(SUM(phi.charge_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_charge) as charge_sales



        UNION ALL

        SELECT 
        bank_dep_sales.account_id,
        (IFNULL(bank_dep_sales.cout_bank_dep,0) + IFNULL(bank_dep_sales.ar_bank_dep,0)) as dr_amount,
        0 as cr_amount,
        (IFNULL(bank_dep_sales.cout_bank_dep,0) + IFNULL(bank_dep_sales.ar_bank_dep,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.bank_dep_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.bank_dep_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_bank_dep,
        (SELECT IFNULL(SUM(phi.bank_dep_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_bank_dep) as bank_dep_sales    

        UNION ALL

        SELECT 
        room_sales.account_id,
        0 as dr_amount,
        (IFNULL(room_sales.cout_room_sales,0) + IFNULL(room_sales.ar_room_sales,0)) as cr_amount,
        (IFNULL(room_sales.cout_room_sales,0) + IFNULL(room_sales.ar_room_sales,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.room_sales_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.room_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_room_sales,
        (SELECT IFNULL(SUM(phi.room_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_room_sales) as room_sales  

        UNION ALL

        SELECT 
        bar_sales.account_id,
        0 as dr_amount,
        (IFNULL(bar_sales.cout_bar_sales,0) + IFNULL(bar_sales.ar_bar_sales,0)) as cr_amount,
        (IFNULL(bar_sales.cout_bar_sales,0) + IFNULL(bar_sales.ar_bar_sales,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.bar_sales_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.bar_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_bar_sales,
        (SELECT IFNULL(SUM(phi.bar_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_bar_sales) as bar_sales 


        UNION ALL

        SELECT 
        other_sales.account_id,
        0 as dr_amount,
        (IFNULL(other_sales.cout_other_sales,0) + IFNULL(other_sales.ar_other_sales,0)) as cr_amount,
        (IFNULL(other_sales.cout_other_sales,0) + IFNULL(other_sales.ar_other_sales,0)) as balance
         FROM 
        (SELECT
        (SELECT phis.other_sales_id FROM prime_hotel_integration_settings phis) as account_id, 
        (SELECT IFNULL(SUM(phi.other_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT'  AND phi.shift_date = '$date') as cout_other_sales,
        (SELECT IFNULL(SUM(phi.other_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR'  AND phi.shift_date = '$date') as ar_other_sales) as other_sales   


        UNION ALL

        SELECT 
        transpo_hotel.account_id,
        0 as dr_amount,
        (IFNULL(transpo_hotel.cout_transpo_hotel,0) + IFNULL(transpo_hotel.ar_transpo_hotel,0)) as cr_amount,
        (IFNULL(transpo_hotel.cout_transpo_hotel,0) + IFNULL(transpo_hotel.ar_transpo_hotel,0)) as balance
        FROM
        (SELECT
        (SELECT phis.transpo_hotel_id FROM prime_hotel_integration_settings phis) as account_id,
        (SELECT IFNULL(SUM(phi.transpo_hotel_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT'  AND phi.shift_date = '$date') as cout_transpo_hotel,
        (SELECT IFNULL(SUM(phi.transpo_hotel_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR'  AND phi.shift_date = '$date') as ar_transpo_hotel) as transpo_hotel

        UNION ALL

        SELECT 
        transpo_outsource.account_id,
        0 as dr_amount,
        (IFNULL(transpo_outsource.cout_transpo_outsource,0) + IFNULL(transpo_outsource.ar_transpo_outsource,0)) as cr_amount,
        (IFNULL(transpo_outsource.cout_transpo_outsource,0) + IFNULL(transpo_outsource.ar_transpo_outsource,0)) as balance
        FROM
        (SELECT
        (SELECT phis.transpo_outsource_id FROM prime_hotel_integration_settings phis) as account_id,
        (SELECT IFNULL(SUM(phi.transpo_outsource_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'COUT' AND phi.shift_date = '$date') as cout_transpo_outsource,
        (SELECT IFNULL(SUM(phi.transpo_outsource_sales),0) FROM prime_hotel_integration phi WHERE phi.item_type = 'AR' AND phi.shift_date = '$date') as ar_transpo_outsource) as transpo_outsource

        ) as main
        LEFT JOIN account_titles ac ON ac.account_id = main.account_id

         ";

        return $this->db->query($sql)->result();
    }






function adv_journal($item_id){
   $sql="SELECT main.* FROM
        (SELECT 
        (SELECT adv_cash_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.adv_cash_total as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL

        SELECT
        (SELECT adv_check_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.adv_check_total as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL

        SELECT
        (SELECT adv_card_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.adv_card_total as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL

        SELECT
        (SELECT adv_charge_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.adv_charge_total as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL

        SELECT
        (SELECT adv_bank_dep_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.adv_bank_dep_total as dr_amount,    
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
         
        SELECT
        (SELECT adv_sales_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.adv_sales as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id
    )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0
     ";
    return $this->db->query($sql)->result();
}



function rev_journal($item_id){
   $sql="SELECT main.* FROM
        (SELECT 
        (SELECT adv_sales_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.adv_sales as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT adv_cash_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.adv_cash_total as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT adv_check_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.adv_check_total as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT adv_card_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.adv_card_total as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT adv_charge_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.adv_charge_total as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT adv_bank_dep_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.adv_bank_dep_total as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id
         )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0";
    return $this->db->query($sql)->result();
}



function cout_and_ar_journal($item_id){
   $sql="SELECT main.* FROM
        (SELECT
        (SELECT cash_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.cash_sales as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT check_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.check_sales as dr_amount,   
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT card_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.card_sales as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT charge_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.charge_sales as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT bank_dep_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        phi.bank_dep_sales as dr_amount,
        0 as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id


        UNION ALL
        SELECT
        (SELECT room_sales_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.room_sales as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT bar_sales_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.bar_sales as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id

        UNION ALL
        SELECT
        (SELECT other_sales_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.other_sales as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id 

        UNION ALL
        SELECT
        (SELECT transpo_hotel_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.transpo_hotel_sales as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id 


        UNION ALL
        SELECT
        (SELECT transpo_outsource_id FROM prime_hotel_integration_settings) as account_id,
        '' as memo,
        0 as dr_amount,
        phi.transpo_outsource_sales as cr_amount
        FROM prime_hotel_integration phi
        WHERE phi.prime_hotel_integration_id = $item_id 


        )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0";
    return $this->db->query($sql)->result();
}





}


?>