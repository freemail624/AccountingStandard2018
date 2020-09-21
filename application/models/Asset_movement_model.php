<?php

class Asset_movement_model extends CORE_Model {
    protected  $table="asset_movement";
    protected  $pk_id="asset_movement_id";

    function __construct() {
        parent::__construct();
    }



         function get_list_with_status(){
                $this->db->query("SET @row_number = 0;");
                $this->db->query("SET @fixed_id = 0;");
                $sql="


                SELECT o.*,
                aps.asset_property_status,
                l.location_name
                 FROM(
                SELECT
                fa.fixed_asset_id,
                fa.acquisition_cost,
                IFNULL(am.asset_code,fa.asset_code) as asset_code,
                IFNULL(am.asset_description,fa.asset_description) as asset_description,
                IFNULL(am.location_id_to,fa.location_id) as current_location_id,
                IFNULL(am.asset_status_id,fa.asset_status_id) as current_status_id,
                IFNULL(am.date_movement,fa.date_acquired) as date_movement,
                (am.location_id_to IS NULL) AS is_acquired,
                CONCAT_WS(' ',user_accounts.user_fname,user_accounts.user_lname)as posted_by

                FROM fixed_assets fa
                LEFT JOIN user_accounts ON  user_accounts.user_id=fa.posted_by_user
                LEFT JOIN

                (SELECT 
                    fixed_asset_id,
                    asset_movement_id,
                    location_id_to,
                    asset_status_id,
                    date_movement,
                    asset_code,
                    asset_description
                FROM
                    (SELECT 
                        @row_number:=CASE
                                WHEN @fixed_id = fixed_asset_id THEN @row_number + 1
                                ELSE 1
                            END AS num,
                            @fixed_id:=fixed_asset_id AS fixed_asset_id,
                            asset_movement_id,
                            location_id_to,
                            asset_status_id,
                            date_movement,
                            asset_code,
                            asset_description
                    FROM
                        asset_movement
                    WHERE asset_movement.is_active = TRUE AND asset_movement.is_deleted = FALSE
                    ORDER BY fixed_asset_id , date_movement DESC , asset_movement_id DESC) main
                WHERE
                    main.num = 1) as am On am.fixed_asset_id = fa.fixed_asset_id 
                    WHERE fa.is_active = TRUE AND fa.is_deleted = FALSE
                    
                    ) as o  
                    
                    LEFT JOIN asset_property_status aps ON aps.asset_status_id = o.current_status_id
                    LEFT JOIN locations l ON l.location_id = o.current_location_id
                   
                    ORDER BY o.fixed_asset_id ASC";

                return $this->db->query($sql)->result();
        }

}
?>