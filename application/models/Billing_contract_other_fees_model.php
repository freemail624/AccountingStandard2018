<?php

class Billing_contract_other_fees_model extends CORE_Model {
    protected  $table="b_contract_other_fees";
    protected  $pk_id="fee_id";
    protected  $fk_id="tenant_id";

    function __construct() {
        parent::__construct();
    }

    function get_contract_advances($contract_id){
        $sql="SELECT
				br.fee_type_desc,
				IFNULL(bci.balance,0) as balance 
				FROM b_reffeetype br 

				LEFT JOIN 
					(SELECT bci.tenant_id,
					bcof.fee_type_id,
					(IFNULL(bcof.total_fee_credit,0) - IFNULL(bcofp.total_fee_debit,0)) as balance
					FROM b_contract_info  bci 

					LEFT JOIN
						(SELECT bcof.tenant_id,
						bcof.fee_type_id,
						SUM(IFNULL(bcof.fee_credit,0))  as total_fee_credit
						FROM b_contract_other_fees  bcof 

							LEFT JOIN 
								temp_journal_info tji ON tji.fee_id = bcof.fee_id
								WHERE tji.is_journal_posted = TRUE
								GROUP BY tenant_id,fee_type_id) 
							as bcof On bcof.tenant_id = bci.tenant_id

					LEFT JOIN
						(SELECT bcof.tenant_id,
						bcof.fee_type_id,
						SUM(IFNULL(bcof.fee_debit,0)) as total_fee_debit
						FROM b_contract_other_fees  bcof 

							LEFT JOIN 
							temp_journal_info tji ON tji.payment_id = bcof.payment_id
							WHERE tji.is_journal_posted = TRUE
							GROUP BY tenant_id,fee_type_id) 
							as bcofp On bcofp.tenant_id = bci.tenant_id
				        
				WHERE bci.contract_id= $contract_id) as bci ON bci.fee_type_id  = br.fee_type_id";

        return $this->db->query($sql)->result();
    }

}
?>

