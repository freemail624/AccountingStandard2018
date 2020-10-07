<?php

class Tax_code_model extends CORE_Model{

    protected  $table="tax_code"; //table name
    protected  $pk_id="atc_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_taxcode_list($atc_id=null){
        $sql="SELECT 
		    tc.*,
		    tt.tax_type,
		    bt.business_type
		FROM
		    tax_code tc
		    LEFT JOIN tax_type tt ON tt.tax_type_id = tc.tax_type_id
		    LEFT JOIN business_type bt ON bt.business_type_id = tc.business_type_id
		    WHERE tc.is_deleted = FALSE AND is_active = TRUE
		    ".($atc_id==null?"":" AND tc.atc_id='".$atc_id."'")."
            ORDER BY tc.atc_id ASC";
        
        return $this->db->query($sql)->result();
    }


}

?>

