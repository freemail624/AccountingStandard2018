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
        WHERE hi.is_journal_posted = FALSE AND hi.shift_date <='$date'
        ORDER BY hi.prime_hotel_integration_id ASC
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
        WHERE phi.prime_hotel_integration_id = $item_id )  as main WHERE main.dr_amount > 0 OR main.cr_amount > 0";
    return $this->db->query($sql)->result();
}





}


?>