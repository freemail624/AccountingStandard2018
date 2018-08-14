<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Purchases_integration extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Company_model',
					'Purchases_integration_model',
					'Journal_account_model',
					'Suppliers_model',
					'Departments_model',		
					'Account_integration_model',			
					'Account_title_model',
					'Accounting_period_model'
				)
			);
	        $this->load->library('excel');
	        $this->load->model('Email_settings_model');
		}

		public function index() {
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Purchases Integration Control Panel';
	        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        (in_array('2-9',$this->session->user_rights)? 
        $this->load->view('purchases_integration_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null,$id_filter=null){
			switch ($txn) {
				case 'list':
					$m_items = $this->Purchases_integration_model;
					// as of date aod changed to one date only 
					$date=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
					$response['data']=$m_items->get_list_pos_integration($date);
					echo json_encode($response);
				break;

				case 'invoice-for-review':
					$ap_info = $this->Purchases_integration_model->get_list($id_filter,'purchase_integration.*,DATE_FORMAT(purchase_integration.date_invoice,"%m/%d/%Y") as date_invoice');
			        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
			        $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE');
			        $data['suppliers']=$this->Suppliers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
			        $data['entries']=$this->Purchases_integration_model->get_journal_entries_ap($id_filter);
			        $supplier_info = $this->Suppliers_model->get_list(array('pos_supplier_id'=>$ap_info[0]->pos_supplier_id));
        			$current_accounts= $this->Account_integration_model->get_list();
        			$data['department_id'] = $current_accounts[0]->purchases_department_id;
			        $data['supplier_id'] = $supplier_info[0]->supplier_id;

					$data['ap_info']=$ap_info[0];
                  echo $this->load->view('template/ap_invoice_for_review',$data,TRUE); //details of the journal
				break;


				case 'create-pos':
				$m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;
				$m_items = $this->Purchases_integration_model;

                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br /> ';
                    die(json_encode($response));
                }


               $purchase_integration_id=$this->input->post('purchase_integration_id',TRUE);
               $validate=$m_items->get_list(array('is_journal_posted'=>TRUE, 'purchase_integration_id'=>$purchase_integration_id));
               if(count($validate)>0){
               	    $journal_info = $m_journal->get_list($validate[0]->journal_id,'txn_no');
               	    $response['stat']='error';
                    $response['title']='<b>Already Posted to Accounting!</b>';
                    $response['msg']='Please Check Sales Journal Transaction '.$journal_info[0]->txn_no;
                    $response['aa']= json_encode($validate);
                    die(json_encode($response));
               }

                $m_journal->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_journal->department_id=$this->input->post('department_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='PJE';
                $m_journal->ref_no=$this->input->post('ref_no',TRUE);
                $m_journal->pos_integration_id=$this->input->post('purchase_integration_id',TRUE);
				$m_journal->set('date_created','NOW()');

				$m_journal->created_by_user=$this->session->user_id;
				$m_journal->save();
				$journal_id=$m_journal->last_insert_id();
				$accounts=$this->input->post('accounts',TRUE);
				$memo=$this->input->post('memo',TRUE);
				$dr_amount=$this->input->post('dr_amount',TRUE);
				$cr_amount=$this->input->post('cr_amount',TRUE);

				for($i=0;$i<=count($accounts)-1;$i++){
					$m_journal_accounts->journal_id=$journal_id;
					$m_journal_accounts->account_id=$accounts[$i];
					$m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amount[$i]);
					$m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amount[$i]);
					$m_journal_accounts->save();
				}
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;



                $m_journal->modify($journal_id);
                //mark pos integration item as posted
                $purchase_integration_id =$this->input->post('purchase_integration_id',TRUE);	
				$m_items->is_journal_posted = 1;
				$m_items->journal_id = $journal_id;
				$m_items->posted_by_user=$this->session->user_id;
				$m_items->set('date_posted','NOW()');
				$m_items->modify($purchase_integration_id);
				$response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted';
                echo json_encode($response);
				break;



			case'upload-trial':
					$m_check = $this->Purchases_integration_model;
	                $allowed = array('jdev');
	                $data=array();
	                $fildataes=array();
	                $directory='assets/files/pos_text_files/';
	                foreach($_FILES as $file){

		                $server_file_name=uniqid('');
		                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
		                if($extension !== 'jdev'){echo json_encode($this->invalid_file_extension());  exit;}
		                $file_path=$directory.date("Y-m-d").'-'.date("H-i-s").'-'.$file['name'];
		                $orig_file_name=$file['name'];

						if(move_uploaded_file($file['tmp_name'],$file_path)){
		                	$temp_lines=file($file_path);
		                	foreach($temp_lines as $lines){
		                	$exp_line =explode('|', $lines);
		                	$temp_count = count($exp_line);
		                		// VALIDATION  Check if every Line if the contents are complete. 29 lines
			                	if($temp_count != 11){ 
			                		$stat = 'FALSE';
			                		echo json_encode($this->invalid_file());
			                		exit;
			                	}
						 		if(!(is_numeric($exp_line[5])) ||    //Total Amount
						 			!(is_numeric($exp_line[6])) ||  // Tax Amount 
						 			!(is_numeric($exp_line[7]))     //  Total amount before tax
						 		){ echo json_encode($this->invalid_file()); exit; }
						 			$invoice_id = $exp_line[0];  // Invoice ID Check if Exists // if 
						 			if(COUNT($m_check->get_list(array('invoice_id'=>$invoice_id))) > 0){
						 				echo json_encode($this->invalid_file_duplication()); exit;
						 			}
		                	}

		    //             	// WHEN CODE COMES HERE .. MEANS THAT THERE IS NO ERROR IN FILE BECAUSE OF THE VALIDATION ABOVE TOGETHER WITH THE EXIT FUNCTION OF PHP
		                	foreach($temp_lines as $ins_lines){
		                	$ins_line =explode('|', $ins_lines);
		                	$m_purchase_items = $this->Purchases_integration_model;
		                		$m_purchase_items->invoice_id = $ins_line[0]; // Invoice ID
		                		$m_purchase_items->invoice_no = $ins_line[1]; // Invoice No
		                		$m_purchase_items->date_invoice = $ins_line[2]; // Transaction Date
		                		$m_purchase_items->pos_supplier_id = $ins_line[3]; // Supplier ID
		                		$m_purchase_items->pos_supplier_name = $ins_line[4]; // Supplier Name
		                		$m_purchase_items->total_amount = $this->get_numeric_value($ins_line[5]); // Total Amount
		                		$m_purchase_items->total_tax_amount = $this->get_numeric_value($ins_line[6]); // Total Tax Amount
		                		$m_purchase_items->total_before_tax_amount =$this->get_numeric_value($ins_line[7]); // Total Before Tax Amount
		                		$m_purchase_items->remarks = $ins_line[8]; // Remarks
		                		$m_purchase_items->external_ref_no = $ins_line[9]; // External Reference No
		                		$m_purchase_items->terms = $ins_line[10]; //Terms
		                		$m_purchase_items->is_txt_file = TRUE;
		                		$m_purchase_items->filename=$orig_file_name;
		                		$m_purchase_items->uploaded_by=$this->session->user_id;
		                		$m_purchase_items->save();

		                		$pos_supplier_id = $ins_line[3];
		                		$supplier_info = $this->Suppliers_model->get_list(array('pos_supplier_id'=>$pos_supplier_id));
		                		if(COUNT($supplier_info) > 0){ // supplier exists but modify the name
		                			$m_update_supplier = $this->Suppliers_model;
		                			$supplier_id = $supplier_info[0]->supplier_id;
		                			$m_update_supplier->supplier_name = $ins_line[4]; 
		                			$m_update_supplier->modify($supplier_id);
		                		}else{ // supplier does not exist
		                			$m_create_supplier = $this->Suppliers_model;
		                			$m_create_supplier->pos_supplier_id = $pos_supplier_id;
		                			$m_create_supplier->supplier_name = $ins_line[4];
		                			$m_create_supplier->save();
		                		}
		                	}
	            	} // END OF IF FILE IS MOVED TO DIRECTORY

	            	    $response['title']='Uploaded successfully.' ;
                        $response['stat']='info';
                        $response['msg']='Text File(s) successfully validated and uploaded.';
                        echo json_encode($response);

	            } // END OF FOREACH FILE
			break;



















				case 'post_selected':
					$m_purchase_items =  $this->Purchases_integration_model;
					$post_id = $this->input->post('post_id',TRUE);
					$m_journal = $this->Journal_info_model;
					$m_journal_accounts = $this->Journal_account_model;
					$m_journal=$this->Journal_info_model;
					$current_accounts= $this->Account_integration_model->get_list();
        			$department_id = $current_accounts[0]->purchases_department_id;
					$total_posted = 0;	
					$total_unposted = 0;	
				 	for($i=0;$i<count($post_id);$i++){
						$ap_info = $m_purchase_items->get_list_pos_integration(null,$post_id[$i]);
							if($ap_info[0]->is_balance == TRUE){



		                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($ap_info[0]->date_invoice))."'<=period_end");
		                if(count($valid_range)>0){
		                    $response['stat']='error';
		                    $response['title']='<b>Accounting Period is Closed!</b>';
		                    $response['msg']='Please make sure transaction date is valid!<br /> ';
		                    die(json_encode($response));
		                }


		               $validate=$m_purchase_items->get_list(array('is_journal_posted'=>TRUE, 'purchase_integration_id'=>$post_id[$i]));
		               if(count($validate)>0){
		               	    $journal_info = $m_journal->get_list($validate[0]->journal_id,'txn_no');
		               	    $response['stat']='error';
		                    $response['title']='<b>Already Posted to Accounting!</b>';
		                    $response['msg']='Please Check Sales Journal Transaction '.$journal_info[0]->txn_no;
		                    $response['aa']= json_encode($validate);
		                    die(json_encode($response));
		               }


				$supplier_info = $this->Suppliers_model->get_list(array('pos_supplier_id'=>$ap_info[0]->pos_supplier_id));
				$supplier_id = $supplier_info[0]->supplier_id;
                $m_journal->supplier_id=$supplier_id;
                $m_journal->department_id=$department_id;
                // $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($ap_info[0]->date_invoice));
                $m_journal->book_type='PJE';
                $m_journal->ref_no=$ap_info[0]->invoice_no;
                $m_journal->pos_integration_id=$post_id[$i];
				$m_journal->set('date_created','NOW()');
				$m_journal->created_by_user=$this->session->user_id;
				$m_journal->save();
				$journal_id=$m_journal->last_insert_id();


						$entries=$this->Purchases_integration_model->get_journal_entries_ap($post_id[$i]);

							foreach ($entries as $entry) {
			                    $m_journal_accounts->journal_id=$journal_id;
			                    $m_journal_accounts->account_id=$entry->account_id;
			                    $m_journal_accounts->memo='';
			                    $m_journal_accounts->dr_amount=$this->get_numeric_value($entry->dr_amount);
			                    $m_journal_accounts->cr_amount=$this->get_numeric_value($entry->cr_amount);
			                    $m_journal_accounts->save();
							}

						$m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
						$m_journal->modify($journal_id);

						$m_purchase_items->is_journal_posted = 1;
						$m_purchase_items->journal_id = $journal_id;
						$m_purchase_items->posted_by_user=$this->session->user_id;
						$m_purchase_items->set('date_posted','NOW()');
						$m_purchase_items->modify($post_id[$i]);









								$total_posted ++;
							}else{
								$total_unposted ++;
							}


				} // end of foreach post id

				if($total_posted == 0){
					$response['stat']="info";
	                $response['title']="Information!";
	                $response['msg']="0 Journal/s Posted";

				}else{
					$response['stat']="success";
	                $response['title']="Success!";
	                $response['msg']=$total_posted." Journal/s successfully Posted";
				}

					echo json_encode($response);
				break;










































			}
		}

    function invalid_file(){
    		$response=array();
	        $response['stat']="error";
	        $response['title']="Error!";
	        $response['msg']="Invalid File. <br>Please Contact the Administrator.";
	        return $response;
    }

    function invalid_file_extension(){
    		$response=array();
	        $response['stat']="error";
	        $response['title']="Error!";
	        $response['msg']="Invalid File Extension. <br>Please Contact the Administrator.";
	        return $response;
    }


    function invalid_file_duplication(){
    		$response=array();
	        $response['stat']="error";
	        $response['title']="Error!";
	        $response['msg']="Duplicate Invoice detected. <br>Please Contact the Administrator.";
	        return $response;
    }


	}
?>