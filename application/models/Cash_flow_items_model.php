<?php
class Cash_flow_items_model extends CORE_Model {
    protected  $table="cash_flow_items";
    protected  $pk_id="cash_flow_items_id";
    protected  $fk_id="cash_flow_ref_id";

    function __construct() {
        parent::__construct();
    }
    
    function get_summation_account_subsidary($date_filter,$filter_accounts){
        $sql="SELECT SUM(IFNULL(main.balance,0)) as balance 
			FROM (SELECT m.*,mQat.account_id, mQat.account_title
				FROM
				(SELECT at.grand_parent_id,at.account_class_id,ac.account_type_id,
				(
					IF(ac.account_type_id=1 OR ac.account_type_id=5,
					SUM(ja.dr_amount)-SUM(ja.cr_amount),
					SUM(ja.cr_amount)-SUM(ja.dr_amount))
				) as balance
				FROM (journal_accounts as ja
				INNER JOIN journal_info as ji ON ji.journal_id=ja.journal_id)
				INNER JOIN (account_titles as at
				INNER JOIN account_classes as ac ON ac.account_class_id=at.account_class_id)
				ON at.account_id=ja.account_id AND ji.is_active=TRUE AND ji.is_deleted=FALSE
				AND at.account_id IN ($filter_accounts)
				".(is_array($date_filter)?" AND ji.date_txn BETWEEN '".date("Y-m-d",strtotime($date_filter[0]))."' AND '".date("Y-m-d",strtotime($date_filter[1]))."'":"")."
				GROUP BY at.grand_parent_id) as m
				LEFT JOIN account_titles as mQat ON mQat.account_id=m.grand_parent_id) as main
        ";
        return $this->db->query($sql)->result();
    }
}
?>
