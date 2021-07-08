<?php

class Payable_payment_model extends CORE_Model
{
    protected $table = "payable_payments";
    protected $pk_id = "payment_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_journal_entries($payment_id){

        $sql="
            SELECT
            /* CASH */
                ai.payable_account_id AS account_id,
                (SELECT 
                        rp.total_paid_amount
                    FROM
                        payable_payments AS rp
                    WHERE
                        rp.payment_id = $payment_id) AS dr_amount,
                0 AS cr_amount,
                '' AS memo
            FROM
                `account_integration` AS ai 
            
            /* AP */
            UNION ALL SELECT 
                ai.payment_to_supplier_id AS account_id,
                0 AS dr_amount,
                (SELECT 
                        rp.total_paid_amount
                    FROM
                        payable_payments AS rp
                    WHERE
                        rp.payment_id = $payment_id) AS cr_amount,
                '' AS memo
            FROM
                `account_integration` AS ai";

        return $this->db->query($sql)->result();
    }


}



?>