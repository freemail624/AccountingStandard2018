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

        $sql="SELECT 
                    (SELECT payable_account_id FROM account_integration) as account_id,
                    rp.total_paid_amount as dr_amount,
                    0 as cr_amount,
                    '' as memo
                FROM
                    payable_payments rp
                    WHERE rp.payment_id = $payment_id

                UNION ALL

                SELECT 
                    (CASE
                        WHEN rp.payment_method_id = 2
                        THEN b.account_id
                        ELSE (SELECT payment_to_supplier_id FROM account_integration)
                    END) as account_id,
                    0 as dr_amount,
                    rp.total_paid_amount as cr_amount,
                    '' as memo
                FROM
                    payable_payments rp
                    LEFT JOIN bank b ON b.bank_id = rp.bank_id
                    WHERE rp.payment_id = $payment_id";

        return $this->db->query($sql)->result();
    }


}



?>