<?php
class Cash_flow_items_model extends CORE_Model {
    protected  $table="cash_flow_items";
    protected  $pk_id="cash_flow_items_id";
    protected  $fk_id="cash_flow_ref_id";

    function __construct() {
        parent::__construct();
    }
    	
	function get_cash_flow($cash_flow_ref_id=null,$start_date,$end_date){
    	$sql="SELECT 
			    main.*,
			    (CASE
					WHEN main.cash_flow_ref_id = 1 THEN (main.previous)
			        WHEN main.cash_flow_ref_id = 3 THEN (main.current - main.previous)
			        WHEN main.cash_flow_ref_id = 4 THEN (main.previous - main.current)
			        ELSE main.current
			    END) AS total_amount
			FROM
			    (SELECT 
			        cfi.*,
			            at.account_title,
			            at.parent_account_id,
			            COALESCE((SELECT 
			                    (CASE
			                    	WHEN cfi.cash_flow_ref_id = 5 THEN (SUM(ja.cr_amount) - SUM(ja.dr_amount))
			                    	WHEN cfi.cash_flow_ref_id = 6 THEN (SUM(ja.cr_amount) - SUM(ja.dr_amount))
			                    	ELSE 
			                    		(SUM(ja.dr_amount) - SUM(ja.cr_amount))
			                    END) AS amount
			                FROM
			                    journal_info ji
			                LEFT JOIN journal_accounts ja ON ja.journal_id = ji.journal_id
			                WHERE
			                    ji.is_deleted = FALSE
			                        AND ji.is_active = TRUE
			                        AND ji.date_txn < '$start_date'
			                        AND ja.account_id = cfi.account_id
			                GROUP BY ja.account_id), 0) AS previous,
			            COALESCE((SELECT 
			                    (CASE
			                    	WHEN cfi.cash_flow_ref_id = 5 THEN (SUM(ja.cr_amount) - SUM(ja.dr_amount))
			                    	WHEN cfi.cash_flow_ref_id = 6 THEN (SUM(ja.cr_amount) - SUM(ja.dr_amount))
			                    	ELSE 
			                    		(SUM(ja.dr_amount) - SUM(ja.cr_amount))
			                    END) AS amount
			                FROM
			                    journal_info ji
			                LEFT JOIN journal_accounts ja ON ja.journal_id = ji.journal_id
			                WHERE
			                    ji.is_deleted = FALSE
			                        AND ji.is_active = TRUE
			                        AND ji.date_txn BETWEEN '$start_date' AND '$end_date'
			                        AND ja.account_id = cfi.account_id
			                GROUP BY ja.account_id), 0) AS current
			    FROM
			        cash_flow_items cfi
			    LEFT JOIN account_titles at ON at.account_id = cfi.account_id) AS main
			".($cash_flow_ref_id==null?"":" WHERE main.cash_flow_ref_id='".$cash_flow_ref_id."'")."
			ORDER BY main.cash_flow_ref_id ASC , main.account_id ASC";
        return $this->db->query($sql)->result();
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
