<?php

class Purchase_journal_info_model extends CORE_Model{

    protected  $table="purchase_journal_info"; //table name
    protected  $pk_id="purchase_journal_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

 	function get_purchases_for_posting($dr_invoice_id=null){
    	$sql="SELECT 
				pji.purchase_journal_id,
			    di.dr_invoice_id,
			    di.dr_invoice_no,
			    di.external_ref_no,
			    CONCAT_WS(' ',di.terms,di.duration)as term_description,
				DATE_FORMAT(di.date_delivered,'%m/%d/%Y') as date_delivered,
			    pji.remarks,
			    s.supplier_name        
			FROM
			    purchase_journal_info pji
			    LEFT JOIN delivery_invoice di ON di.dr_invoice_id = pji.dr_invoice_id
			    LEFT JOIN suppliers s ON s.supplier_id = pji.supplier_id
			    
			    WHERE di.is_active = TRUE AND
					di.is_deleted = FALSE AND
			        di.is_journal_posted = FALSE AND
			        di.is_saved = TRUE AND 
					pji.is_deleted = FALSE
					".($dr_invoice_id==null?"":" AND di.dr_invoice_id='".$dr_invoice_id."'")."";

         return $this->db->query($sql)->result();

     }
}

?>
