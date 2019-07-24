<?php
	class Fixed_asset_management_model extends CORE_Model
	{
		protected $table="fixed_assets";
		protected $pk_id="fixed_asset_id";

		function __construct()
		{
			parent::__construct();
		}

		function get_depreciation_expense($month=null,$year=null) {
			$sql="SELECT 
			ai.*,
			DATE_FORMAT(ai.date_acquired,'%m-%d-%Y') AS acquired_date,
			x.*
			FROM
			(SELECT 
				fa.fixed_asset_id,
				fa.asset_code,
				fa.asset_description,
				fa.date_acquired,
				fa.acquisition_cost,
				fa.life_years,
				fa.salvage_value,
				l.location_name,
				d.department_name,
				c.category_name,
				asi.asset_property_status
			FROM
				fixed_assets AS fa
				LEFT JOIN locations AS l ON l.location_id=fa.location_id
				LEFT JOIN departments AS d ON d.department_id=fa.department_id
				LEFT JOIN categories AS c ON c.category_id=fa.category_id
				LEFT JOIN asset_property_status AS asi ON asi.asset_status_id=fa.asset_status_id
			WHERE
				fa.is_deleted = FALSE AND fa.is_active = TRUE) AS ai
				
			INNER JOIN

			(SELECT
				ci.fixed_asset_id,
				ci.accu_dep,
				ci.depreciation_expense,
			    ci.acquisition_cost,
			    ci.interval_date,
				(IFNULL(ci.acquisition_cost,0) - IFNULL(ci.accu_dep,0)) AS book_value
			FROM
			(SELECT
				i.*,
				(IFNULL(interval_date,0) * IFNULL(i.depreciation_expense,0)) as accu_dep
			FROM
			(SELECT 
				fixed_asset_id,
				acquisition_cost,
				salvage_value,
				life_years,
				date_acquired,
				((IFNULL(acquisition_cost,0) - IFNULL(salvage_value,0)) / IFNULL(life_years,0) / 12) AS depreciation_expense,
				PERIOD_DIFF( DATE_FORMAT('".$year.'-'.$month.'-01'."','%Y%m'), DATE_FORMAT(date_acquired,'%Y%m') ) AS interval_date
			FROM fixed_assets
			WHERE is_deleted=FALSE AND is_active=TRUE) as i
			) as ci ) AS x
			ON x.fixed_asset_id = ai.fixed_asset_id

			ORDER BY ai.asset_description ASC";

			return $this->db->query($sql)->result();

		}

		function get_history_asset($fixed_asset_id) {
			$sql="SELECT main.*,
			l.location_name, aps.asset_property_status FROM 
			(SELECT 0 as asset_movement_id,
			'Acquisition' as asset_no,
			fa.date_acquired as date,
			fa.location_id,
			fa.asset_status_id,
			fa.remarks

			FROM fixed_assets fa
			WHERE fa.fixed_asset_id = $fixed_asset_id

			UNION ALL

			SELECT am.asset_movement_id,
			am.asset_no,
			am.date_movement,
			am.location_id_to,
			am.asset_status_id,
			am.remarks

			 FROM asset_movement am

			WHERE am.fixed_asset_id = $fixed_asset_id
			 AND am.is_active = TRUE 
			 AND am.is_deleted = FALSE) as main
			 
			 LEFT JOIN locations l ON l.location_id = main.location_id
			 LEFT JOIN asset_property_status aps ON aps.asset_status_id = main.asset_status_id
			 
			 ORDER BY main.date ASC, main.asset_movement_id ASC";

			return $this->db->query($sql)->result();

		}
	}
?>