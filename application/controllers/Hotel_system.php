<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Hotel_system extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Hotel_system_model',
					'Hotel_system_settings_model',
					'Company_model',
					'Journal_account_model',
					'Customers_model',
					'Departments_model',
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
	        $data['title'] = 'Hotel Integration Control Panel';
	        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        // (in_array('16-3',$this->session->user_rights)? 
        $this->load->view('hotel_system_view',$data);
        // :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null,$id_filter=null){
			switch ($txn) {
				case 'list':
					$m_items = $this->Hotel_system_model;
					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
					$response['data']=$m_items->get_list_hotel_integration($aod);
					echo json_encode($response);
				break;

			case 'integration-for-review':
				$m_items = $this->Hotel_system_model;
				$m_customers = $this->Customers_model;
				$m_departments = $this->Departments_model;
				$m_accounts=$this->Account_title_model;
				$info=$m_items->get_list($id_filter,
					'prime_hotel_integration.*,
					DATE_FORMAT(prime_hotel_integration.shift_date,"%m/%d/%Y") as date_sales');
				$type = $info[0]->item_type;
				$settings_info = $this->Hotel_system_settings_model->get_list(1);


				if($type == 'ADV'){
					$entries =$m_items->adv_journal($id_filter); 
					$data['customer_id']= $settings_info[0]->customer_id;
					$customer_id = $settings_info[0]->customer_id;
					$data['customer_note'] = '';

				} else if($type == 'COUT' || $type == 'AR'){
					$entries =$m_items->cout_and_ar_journal($id_filter); 



					// CHECK IF AR, THEN CHECK IF CUSTOMER EXISTS, CREATE NEW IF NOT
					if($type == 'AR'){ // check first the ar customer 
							$check_ar_guest_id= $info[0]->ar_guest_id;
							$check_ar_guest_name = $info[0]->ar_guest_name;
							$get_ar_info = $m_customers->get_list(array('hotel_customer_id'=>$check_ar_guest_id));
							$check_ar_info = count($get_ar_info);
							if($check_ar_info == 0){
								$ar_customer_id = 0;
								$m_customer_create_ar = $this->Customers_model; // redeclared customer model to ensure that no duplication of create code
								$m_customer_create_ar->hotel_customer_id = $check_ar_guest_id;
								$m_customer_create_ar->customer_name = $check_ar_guest_name;
								$m_customer_create_ar->save();
								$ar_customer_id =$m_customer_create_ar->last_insert_id();
							}else if ($check_ar_info > 0){
								$ar_customer_id = 0;
								$ar_customer_id = $get_ar_info[0]->customer_id;
								$m_customers_modify_ar = $this->Customers_model;
								$m_customers_modify_ar->customer_name = $check_ar_guest_name;
								$m_customers_modify_ar->hotel_customer_id = $check_ar_guest_id;
								$m_customers_modify_ar->modify($ar_customer_id);
							}

							$data['ar_info']=$check_ar_info;
					}
					// END OF IF ELSE CHECK OF AR CUSTOMER
					// CHECK CUSTOMER IN EVERY COUT AND AR TRANSACTION ... INCLUDED
					$check_customer_id = $info[0]->guest_id;
					$check_guest_name = $info[0]->guest_name;
					$get_customer_info  = $m_customers->get_list(array('hotel_customer_id'=>$check_customer_id));
					$check_customer_info = count($get_customer_info);
						if($check_customer_info == 0){ // means customer is not existing, create new
							$m_customer_create_cus = $this->Customers_model; // redeclared customer model to ensure that no duplication of create code
							$m_customer_create_cus->hotel_customer_id = $check_customer_id;
							$m_customer_create_cus->customer_name = $check_guest_name;
							$m_customer_create_cus->save();
							$customer_id =$m_customer_create_cus->last_insert_id();
							$data['customer_note'] = '<i>Note: New Customer created.</i>';
							//SET NEWLY SAVED CUSTOMER ID AS CUSTOMER SELECTED
						}else if ($check_customer_info > 0){ // if existing, just update the customer_name 
							$customer_id = 0;
							$customer_id = $get_customer_info[0]->customer_id;
							$m_customers_modify_cus = $this->Customers_model;
							$m_customers_modify_cus ->customer_name = $check_guest_name;
							$m_customers_modify_cus ->hotel_customer_id = $check_customer_id;
							$m_customers_modify_cus->modify($customer_id);
							$data['customer_note'] = '<i>Note: Customer updated.</i>';
							
						} 


					// END OF IF ELSE CUSTOMER CREATE OR MODIFY	
						if($type == 'COUT' ){
							$data['customer_id'] = $customer_id;
						}else if ($type == 'AR'){
							$data['customer_id'] = $ar_customer_id;
						}

				}else if($type == 'REV'){
					$entries =$m_items->rev_journal($id_filter); 
					$data['customer_id']= $settings_info[0]->customer_id;
					$customer_id = $settings_info[0]->customer_id;
					$data['customer_note'] = '';

				}

 $check_no = $info[0]->check_no;
 $check_date = $info[0]->check_date;

 $check_type_id = $info[0]->check_type_id;
 $check_type_name = $info[0]->check_type_name;

 $card_no = $info[0]->card_no;
 $card_type_name = $info[0]->card_type_name;

 $or_no = $info[0]->or_no;
 $folio_no = $info[0]->folio_no;
 $receipt_no = $info[0]->receipt_no;

 

$rem_check = '';
if($check_no != '' || $check_no != 0){
	$rem_check = 'Check No : '.$check_no.', Check Name: '.$check_type_name.', Check Date: '.$check_date."\n";
}
$rem_card = '';
if($card_no != '' || $card_no != 0){
	$rem_card = 'Card No : '.$card_no.', Card Type Name: '.$card_type_name."\n";
}
$rem_billed_to = '';
if($type == 'AR'){
$rem_billed_to = 'Originally Billed To '.$info[0]->guest_name." - ID(".$info[0]->guest_id.")\n";

}

$data['info_remarks'] =  $rem_billed_to."".$rem_check."".$rem_card."OR No: ".$or_no."\nFolio No: ".$folio_no."\nReceipt No: ".$receipt_no;

                $data['department_id'] = $settings_info[0]->department_id;  // department id comes from settings
                $data['customers']=$m_customers->get_list(array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE),
					array('customers.customer_id','customers.customer_name'));
                $valid_customer=$m_customers->get_list(array('customer_id'=>$customer_id,'is_active'=>TRUE,'is_deleted'=>FALSE));
                $data['valid_particular']=(count($valid_customer)>0);
                $data['departments']=$m_departments->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
                $data['accounts']=$m_accounts->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE));
				$data['info']=$info[0];
				$data['entries']=$entries;
					echo $this->load->view('template/prime_hotel_integration_content',$data,TRUE);
				break;




				case 'finalize':
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }
                $prime_hotel_integration_id = $this->input->post('prime_hotel_integration_id',TRUE);

                $valid_id=$this->Hotel_system_model->get_list('is_journal_posted = TRUE AND prime_hotel_integration_id='.$prime_hotel_integration_id);
                if(count($valid_id)>0){

                	$journal_info_validate = $m_journal->get_list('hotel_integration_id='.$prime_hotel_integration_id,'txn_no');
                    $response['stat']='error';
                    $response['title']='<b>Already Posted!</b>';
                    $response['msg']='Please  Check '.$journal_info_validate[0]->txn_no.' in the Sales Journal!<br />';
                    die(json_encode($response));
                }


                $m_journal->customer_id=$this->input->post('customer_id',TRUE);
                $m_journal->department_id=$this->input->post('department_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->hotel_integration_id=$prime_hotel_integration_id;
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='SJE';
                $m_journal->ref_no=$this->input->post('ref_no',TRUE);
                $m_journal->is_sales=1;

                //for audit details
                $m_journal->set('date_created','NOW()');
                $m_journal->created_by_user=$this->session->user_id;
                $m_journal->save();					

				$journal_id=$m_journal->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->save();
                }
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);
                // mark as posted hotel items

                
                $m_items=$this->Hotel_system_model;
                $m_items->is_journal_posted = 1;
                $m_items->journal_id = $journal_id;
                $m_items->posted_by_user=$this->session->user_id;
                $m_items->set('date_posted','NOW()');
                $m_items->modify($prime_hotel_integration_id);

				
                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Information successfully Posted";
				


					echo json_encode($response);
				break;

			case'upload-trial':
	                $allowed = array('jdev');

	                $data=array();
	                $files=array();
	                $directory='assets/files/hotel_text_files/';

					$duplicate_count = 0;
					$success_count = 0;
					$invalid_extension_count = 0;
	                foreach($_FILES as $file){

		                $server_file_name=uniqid('');
		                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
		                $file_path=$directory.date("Y-m-d").'-'.date("H-i-s").'-'.$file['name'];
		                $orig_file_name=$file['name'];


		                	// echo $orig_file_name;

						if(move_uploaded_file($file['tmp_name'],$file_path)){

		                	$temp_lines=file($file_path);

		                	foreach($temp_lines as $lines){
		                	$exp_line =explode('|', $lines);
		                	$temp_count = count($exp_line);

		                		// VALIDATION  Check if every Line if the contents are complete. 29 lines
			                	if($temp_count != 29){ 
			                		$stat = 'FALSE';
			                		echo json_encode($this->invalid_file());
			                		exit;
			                	}

			                	if(!(ctype_alpha($exp_line[0]))){
			                		echo json_encode($this->invalid_file());
			                	}
								if(!(is_numeric($exp_line[2]))|| // adv cash
									!(is_numeric($exp_line[3])) ||  // adv check
									!(is_numeric($exp_line[4])) ||  // adv card 
									!(is_numeric($exp_line[5])) || 	// adv ar
									!(is_numeric($exp_line[6]))		// adv bank deposit
								){ echo json_encode($this->invalid_file()); exit; }

								if(!(is_numeric($exp_line[7])) ||   // cash
									!(is_numeric($exp_line[8])) ||  //  check
									!(is_numeric($exp_line[9])) ||  //  card 
									!(is_numeric($exp_line[10])) || 	//  ar
									!(is_numeric($exp_line[11]))		//  bank deposit
								){ echo json_encode($this->invalid_file()); exit; }

								if(!(is_numeric($exp_line[12])) ||   // Room Sales
									!(is_numeric($exp_line[13])) ||  //  Bar Sales
									!(is_numeric($exp_line[14])) ||  //  Other Sales
									!(is_numeric($exp_line[15])) 	//  Advance Sales
								){ echo json_encode($this->invalid_file());  exit;}

		                	}

		                	// WHEN CODE COMES HERE .. MEANS THAT THERE IS NO ERROR IN FILE BECAUSE OF THE VALIDATION ABOVE TOGETHER WITH THE EXIT FUNCTION OF PHP
		                	foreach($temp_lines as $ins_lines){
		                	$ins_line =explode('|', $ins_lines);

		                	$m_hotel_items = $this->Hotel_system_model;
		                		$m_hotel_items->item_type = $ins_line[0];
		                		$m_hotel_items->shift_date = $ins_line[1];
		                		$m_hotel_items->adv_cash_total = $ins_line[2];
		                		$m_hotel_items->adv_check_total = $ins_line[3];
		                		$m_hotel_items->adv_card_total = $ins_line[4];
		                		$m_hotel_items->adv_charge_total = $ins_line[5];
		                		$m_hotel_items->adv_bank_dep_total = $ins_line[6];
		                		$m_hotel_items->cash_sales = $ins_line[7];
		                		$m_hotel_items->check_sales = $ins_line[8];
		                		$m_hotel_items->card_sales = $ins_line[9];
		                		$m_hotel_items->charge_sales = $ins_line[10];
		                		$m_hotel_items->bank_dep_sales = $ins_line[11];
		                		$m_hotel_items->room_sales = $ins_line[12];
		                		$m_hotel_items->bar_sales = $ins_line[13];
		                		$m_hotel_items->other_sales = $ins_line[14];
		                		$m_hotel_items->adv_sales = $ins_line[15];
		                		$m_hotel_items->guest_id = $ins_line[16];
		                		$m_hotel_items->guest_name = $ins_line[17];
		                		$m_hotel_items->ar_guest_id = $ins_line[18];
		                		$m_hotel_items->ar_guest_name = $ins_line[19];
		                		$m_hotel_items->check_no = $ins_line[20];
		                		$m_hotel_items->check_date = $ins_line[21];
		                		$m_hotel_items->check_type_id = $ins_line[22];
		                		$m_hotel_items->check_type_name = $ins_line[23];
		                		$m_hotel_items->card_no = $ins_line[24];
		                		$m_hotel_items->card_type_name = $ins_line[25];
		                		$m_hotel_items->or_no = $ins_line[26];
		                		$m_hotel_items->folio_no = $ins_line[27];
		                		$m_hotel_items->receipt_no = $ins_line[28];
		                		$m_hotel_items->save();

		                		
		                	}




		                	
			                $response['stat']="success";
			                $response['title']="Success!";
			                $response['msg']="Information successfully Posted";

		                	echo json_encode($response);



	            	} // END OF IF FILE IS MOVED TO DIRECTORY

	            } // END OF FOREACH FILE
			break;




            case 'upload':
                $allowed = array('jdev');

                $data=array();
                $files=array();
                $directory='assets/files/quickie_reports/';

				$duplicate_count = 0;
				$success_count = 0;
				$invalid_extension_count = 0;
                foreach($_FILES as $file){

	                $server_file_name=uniqid('');
	                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
	                $file_path=$directory.date("Y-m-d").'-'.date("H-i-s").'-'.$file['name'];
	                $orig_file_name=$file['name'];
					$m_hotel_items = $this->Integration_hotel_model;


					$duplicatecheck = count($m_hotel_items->get_list(array('hotel_items.file_path='=>$orig_file_name)));


					if($duplicatecheck > 0){
						$duplicate_count ++ ;
					}else{
			                    if(!in_array(strtolower($extension), $allowed)){
			                        $response['title']='Invalid!';
			                        $response['stat']='error';
			                        $response['msg']='File is invalid. Please select a valid file!';
			                        die(json_encode($response));
			                    	$invalid_extension_count ++;

			                    }else{ 

			                    	if(move_uploaded_file($file['tmp_name'],$file_path)){
				                    	$success_count ++;
							            $names=file($file_path);

										foreach($names as $name)
										{
									    	$name =explode('|', $name);
									        $m_hotel_items->item_type=$name[0];
									        $m_hotel_items->department_id=$name[1];
									        $m_hotel_items->sales_date=date('Y-m-d',strtotime($name[2]));
									        $m_hotel_items->shift=$name[3];

									        $m_hotel_items->adv_cash=$name[4];
									        $m_hotel_items->adv_check=$name[5];
									        $m_hotel_items->adv_card=$name[6];
									        $m_hotel_items->adv_charge=$name[7];
									        $m_hotel_items->adv_bank=$name[8];

									        $m_hotel_items->cash_amount=$name[9];
									        $m_hotel_items->check_amount=$name[10];
									        $m_hotel_items->card_amount=$name[11];
									        $m_hotel_items->charge_amount=$name[12];
									        $m_hotel_items->bank_amount=$name[13];

									        $m_hotel_items->room_sales=$name[14];
									        $m_hotel_items->bar_sales=$name[15];
									        $m_hotel_items->other_sales=$name[16];

									        $m_hotel_items->advance_sales=$name[17];

									        $m_hotel_items->file_path=$file['name'];
									        $m_hotel_items->save();
										}
									}
			                    } //end of if else extension checking
			        } // end of duplicate checking
            	} // end of foreach files

                        $response['title']='Uploaded. <br>'.$success_count.' Successful<br>'.$duplicate_count.' Duplicate Text file<br>'.$invalid_extension_count.' Invalid Extension<br>' ;
                        $response['stat']='info';
                        $response['msg']='Text File(s) successfully validated and uploaded.';
                        echo json_encode($response);

                break;

			}
		}


    function invalid_file(){
    		$response=array();
	        $response['stat']="error";
	        $response['title']="Error!";
	        $response['msg']="Invalid File. Please Contact the Administrator.";
	        return $response;
    }


	}
?>