<?php

class Months_model extends CORE_Model {
    protected  $table="months";
    protected  $pk_id="month_id";

    function __construct() {
        parent::__construct();
    }


    function get_between_dates($start_date,$end_date)
    {
        $query = $this->db->query("SELECT

			full.*,
			CONCAT(DATE_FORMAT(full.start_date, '%M'),' ',DATE_FORMAT(full.start_date, '%Y')) AS app_month_year,
		    CONCAT(DATE_FORMAT(full.start_date,'%m/%d/%Y'),' to ',DATE_FORMAT(full.end_date,'%m/%d/%Y')) as date_span

		    FROM

		    (SELECT 
			    m.month_id,
			    m.year_id,
			    (CASE
			        WHEN MIN(m.selected_date) = '$start_date' THEN '$start_date'
			        ELSE m.selected_date
			    END) AS start_date,
			    (CASE
			        WHEN MAX(m.selected_date) = '$end_date' THEN '$end_date'
			        ELSE (SELECT LAST_DAY(DATE(CONCAT_WS('-', m.year_id, m.month_id, 1))))
			    END) AS end_date
			FROM
			    (SELECT 
			        main.selected_date,
			            DATE_FORMAT(selected_date, '%m') AS month_id,
			            DATE_FORMAT(selected_date, '%Y') AS year_id
			    FROM
			        (SELECT 
			        *
			    FROM
			        (SELECT 
			        ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) selected_date
			    FROM
			        (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0, (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1, (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2, (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3, (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) v
			    WHERE
			        selected_date BETWEEN '$start_date' AND '$end_date') AS main) AS m
			GROUP BY m.year_id , m.month_id) as full");
        return $query->result();
    }


}
?>