<?php
	class Bir_2307_model extends CORE_Model {
	    protected  $table="form_2307";
	    protected  $pk_id="form_2307_id";

	    function __construct() {
	        parent::__construct();
	    }

	    function get_2307_items($supplier_id,$month=null,$year=null){
	    	$sql="SELECT 
			    form_2307.*,
			    m.month_name,
			    m.quarter,
			    tc.atc as atc,
			    tc.description as remarks,
			    SUM(form_2307.gross_amount) AS gross_amount,
			    SUM(form_2307.deducted_amount) AS deducted_amount
			FROM
			    form_2307
			        LEFT JOIN
			    months m ON m.month_id = MONTH(date)
			        LEFT JOIN
			    tax_code tc ON tc.atc_id = form_2307.atc_id
			WHERE
				form_2307.is_deleted = FALSE AND form_2307.is_active = TRUE 
			    AND form_2307.supplier_id = '$supplier_id'
			        AND MONTH(form_2307.date) = '$month'
			        AND YEAR(form_2307.date) = '$year'
			GROUP BY form_2307.atc_id";
			return $this->db->query($sql)->result();
	    }

	    function get_2307_suppliers($month=null,$year=null){
	    	$sql="SELECT 
	    		s.supplier_id,
			    s.supplier_name,
			    s.tin_no,
				DATE_FORMAT(ji.date_txn,'%m/%y') as period,
				DATE_FORMAT(ji.date_txn,'%m') as month_id,
				DATE_FORMAT(ji.date_txn,'%Y') as year,
				m.quarter
			FROM
			    form_2307
			    LEFT JOIN journal_info ji ON ji.journal_id = form_2307.journal_id
			    LEFT JOIN suppliers s ON s.supplier_id = form_2307.supplier_id
			   	LEFT JOIN months m ON m.month_id = MONTH(form_2307.date)			    
				WHERE 
					form_2307.is_active = TRUE
					AND form_2307.is_deleted = FALSE
			        ".($month==null?"":" AND MONTH(ji.date_txn) = $month")."
			        ".($year==null?"":" AND YEAR(ji.date_txn) = $year")."
			GROUP BY form_2307.supplier_id, MONTH(ji.date_txn)";
	    	return $this->db->query($sql)->result();
	    }

	    function get_2307_list($month=null,$year=null,$journal_id=null){
	    	$sql="SELECT 
				    form_2307.*,
				    ji.date_txn,
				    m.month_name,
				    m.quarter,
				    s.*,
				    tc.atc as atc,
				    tc.description as remarks,
				    tc.tax_rate as tax_rate
				FROM
				    form_2307 
				    LEFT JOIN journal_info ji ON ji.journal_id = form_2307.journal_id
				    LEFT JOIN months m ON m.month_id = MONTH(ji.date_txn)
				    LEFT JOIN suppliers s ON s.supplier_id = form_2307.supplier_id
				    LEFT JOIN tax_code tc ON tc.atc_id = form_2307.atc_id
				    WHERE 
				    	form_2307.is_active = TRUE
				        AND form_2307.is_deleted = FALSE
				        ".($month==null?"":" AND MONTH(ji.date_txn) = $month")."
				        ".($year==null?"":" AND YEAR(ji.date_txn) = $year")."
				        ".($journal_id==null?"":" AND form_2307.journal_id = $journal_id")."
				        ";
	    	return $this->db->query($sql)->result();
	    }

        function get_2307($startDate,$endDate,$supplier_id) {
        $sql="SELECT 
				((IFNULL(s.tax_output,0) /100)* ji.amount) as tax_deducted,
				IFNULL(s.tax_output,0) as tax_output,
				ji.*
				 FROM journal_info ji
				LEFT JOIN  suppliers s ON s.supplier_id = ji.supplier_id
				WHERE 

				ji.supplier_id = $supplier_id
				AND  ji.is_active = TRUE AND ji.is_deleted = FALSE AND ji.book_type = 'CDJ'
				AND ji.date_txn BETWEEN '$startDate' AND '$endDate'
          ";
            return $this->db->query($sql)->result();
    	}

        function get_2307_files($month,$year,$supplier_id) {
        $sql="
        SELECT 
				((IFNULL(s.tax_output,0) /100)* ji.amount) as tax_deducted,
				IFNULL(s.tax_output,0) as tax_output,
				ji.*
				 FROM journal_info ji
				LEFT JOIN  suppliers s ON s.supplier_id = ji.supplier_id
				WHERE 

				ji.supplier_id = $supplier_id
				AND  ji.is_active = TRUE AND ji.is_deleted = FALSE AND ji.book_type = 'CDJ'
				AND MONTH(ji.date_txn) = '$month' AND YEAR (ji.date_txn) = '$year' 
          ";
            return $this->db->query($sql)->result();
    	}

        function get_2307_validate($month,$year,$supplier_id) {
        $sql="
       SELECT f.* FROM form_2307 f
		WHERE MONTH(f.date)  = $month AND year(f.date) = $year
		AND supplier_id = $supplier_id AND f.is_active = TRUE AND f.is_deleted = FALSE
          ";
            return $this->db->query($sql)->result();
    	}


    	function get_creditable_input_tax($department_id='all',$month=null,$year,$account_id){
    		$sql="SELECT 
				    main.*,
    				(main.gross_taxable - main.input_tax) as net_vat
				FROM
				    (SELECT 
				        x.*, (dr_amount + cr_amount) AS input_tax
				    FROM
				        (SELECT 
				        ji.journal_id,
				            DATE_FORMAT(ji.date_txn, '%m/%d/%Y') AS date_txn,
				            ji.txn_no,
				            ji.department_id,
				            ji.supplier_id,
				            ji.remarks,
				            ji.book_type,
				            suppliers.tin_no,
				            suppliers.supplier_name,
				            suppliers.address,
				            CONCAT(ji.ref_no, ' ', ji.or_no) AS ref_no,
				            departments.department_name,
				            COALESCE((SELECT 
				                    SUM(accounts.dr_amount)
				                FROM
				                    journal_accounts accounts
				                WHERE
				                    accounts.journal_id = ji.journal_id), 0) AS gross_taxable,
				            COALESCE((SELECT 
				                    SUM(accounts.dr_amount)
				                FROM
				                    journal_accounts accounts
				                WHERE
				                    accounts.journal_id = ji.journal_id
				                        AND accounts.account_id = $account_id), 0) AS dr_amount,
				            COALESCE((SELECT 
				                    SUM(accounts.cr_amount)
				                FROM
				                    journal_accounts accounts
				                WHERE
				                    accounts.journal_id = ji.journal_id
				                        AND accounts.account_id = $account_id), 0) AS cr_amount,
				            tax_code.atc,
				            tax_code.tax_rate,
				            tax_code.description,
				            form_2307.deducted_amount
				    FROM
				        journal_info ji
				    LEFT JOIN suppliers ON suppliers.supplier_id = ji.supplier_id
				    LEFT JOIN departments ON departments.department_id = ji.department_id
				    LEFT JOIN (SELECT 
				        form_2307.atc_id,
				            form_2307.is_applied,
				            form_2307.journal_id,
				            form_2307.deducted_amount
				    FROM
				        form_2307
				    WHERE
				        form_2307.is_applied = TRUE) AS form_2307 ON form_2307.journal_id = ji.journal_id
				    LEFT JOIN tax_code ON tax_code.atc_id = form_2307.atc_id
				    WHERE
				        ji.is_active = TRUE
				            AND ji.is_deleted = FALSE
				            AND ji.book_type = 'CDJ'
				            AND YEAR(ji.date_txn) = $year
				        	".($month==null?"":" AND MONTH(ji.date_txn) = $month")."
				        	".($department_id=='all'?"":" AND ji.department_id = $department_id")."
				    GROUP BY ji.journal_id) AS x) main
				WHERE
				    main.input_tax > 0
				    ORDER BY main.date_txn ASC";
            return $this->db->query($sql)->result();
    	}

	}
?>