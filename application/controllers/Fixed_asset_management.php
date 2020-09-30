<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Fixed_asset_management extends CORE_Controller
	{		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array(
					'Locations_model',
					'Categories_model',
					'Asset_property_status_model',
					'Fixed_asset_management_model',
					'Users_model',
					'Departments_model',
					'Delivery_invoice_item_model',
					'Company_model',
					'Asset_movement_model',
					'Trans_model'
				)
			);
		    

        	$this->load->library('excel');
		    $this->load->library('M_pdf');
		}

		public function index()
		{
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Fixed Asset Management';

	        $data['locations']=$this->Locations_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['categories']=$this->Categories_model->get_category_list();
	        $data['asset_properties']=$this->Asset_property_status_model->get_list('is_deleted=FALSE');
	        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE AND is_active=TRUE');
	        (in_array('10-1',$this->session->user_rights)? 
	        $this->load->view('fixed_asset_management_view',$data)
	        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null) {
			switch($txn) {
				case 'list':
					$m_fixed_asset=$this->Fixed_asset_management_model;

					$filter = "";
                	$category_id = $this->input->get('category_id');

                	if($category_id!=0){
                		$filter = 'AND fixed_assets.category_id = '.$category_id;
                	}

					$response['data']=$m_fixed_asset->get_list(
						'fixed_assets.is_deleted=FALSE AND fixed_assets.is_active=TRUE '.$filter,
						array(
							'fixed_assets.fixed_asset_id',
							'fixed_assets.asset_code',
							'fixed_assets.asset_description',
							'fixed_assets.serial_no',
							'fixed_assets.location_id',
							'fixed_assets.department_id',
							'fixed_assets.category_id',
							'fixed_assets.life_years',
							'fixed_assets.asset_status_id',
							'DATE_FORMAT(fixed_assets.date_acquired,"%m/%d/%Y")as date_acquired',
							'fixed_assets.remarks',
							'FORMAT(fixed_assets.acquisition_cost, 2) AS acquisition_cost',
							'FORMAT(fixed_assets.salvage_value, 2) AS salvage_value',
							'locations.*',
							'departments.*',
							'categories.*',
							'asset_property_status.*',
							'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
						),
						array(
							array('locations','locations.location_id=fixed_assets.location_id','left'),
							array('departments','departments.department_id=fixed_assets.department_id','left'),
							array('categories','categories.category_id=fixed_assets.category_id','left'),
							array('asset_property_status','asset_property_status.asset_status_id=fixed_assets.asset_status_id','left'),
							array('user_accounts','user_accounts.user_id=fixed_assets.posted_by_user','left')
						),
						'fixed_assets.fixed_asset_id DESC'
					);

					echo json_encode($response);
				break;

				case 'print':
	                $m_company_info=$this->Company_model;
	                $company_info=$m_company_info->get_list();

                	$category_id = $this->input->get('category_id');

                	if($category_id==0){
                		$category_id = null;
                		$data['category_name'] = 'All';
                	}else{
                		$data['category_name'] = $this->Categories_model->get_list($category_id,'category_name')[0]->category_name;
                	}

	                $m_movement = $this->Asset_movement_model;
	                $data['data'] = $m_movement->get_list_with_status($category_id);

	                $data['company_info']=$company_info[0];
	                $data['user'] = $this->session->user_fullname;

	                $this->load->view('template/fixed_asset_management_content',$data);

                break;

				case 'print-by-location':
	                $m_company_info=$this->Company_model;
	                $company_info=$m_company_info->get_list();

	                $m_movement = $this->Asset_movement_model;
	                $data['data'] = $m_movement->get_list_with_status();

	                $data['company_info']=$company_info[0];
	                $data['user'] = $this->session->user_fullname;
					$data['locations']=$m_movement->get_list_with_location_count();
	                $this->load->view('template/fixed_asset_management_location_content',$data);

                break;                

	            case 'export':

	                $excel = $this->excel;

	                $m_company_info=$this->Company_model;
	                $m_movement = $this->Asset_movement_model;

                	$category_id = $this->input->get('category_id');

                	if($category_id==0){
                		$category_id = null;
                		$category_name = 'All';
                	}else{
                		$category_name = $this->Categories_model->get_list($category_id,'category_name')[0]->category_name;
                	}

	                $company_info=$m_company_info->get_list();
	                $data = $m_movement->get_list_with_status($category_id);

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Fixed Asset Management");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:D1');
	                $excel->getActiveSheet()->mergeCells('A2:D2');
	                $excel->getActiveSheet()->mergeCells('A3:D3');
	                $excel->getActiveSheet()->mergeCells('A4:D4');

	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->setCellValue('A6','Fixed Asset Management')
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('A7','Category : '.$category_name)
	                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
	                $excel->getActiveSheet()->setCellValue('A8','')
	                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

	                 $style_header = array(

	                    'fill' => array(
	                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                        'color' => array('rgb'=>'CCFF99'),
	                    ),
	                    'font' => array(
	                        'bold' => true,
	                    )
	                );

	                $excel->getActiveSheet()->getStyle('A8:O8')->applyFromArray( $style_header );

	                $excel->getActiveSheet()->setCellValue('A8','Asset Code')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B8','Asset Description')
	                                        ->getStyle('B8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C8','Acquisition Cost')
	                                        ->getStyle('C8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D8','Posted By')	                
	                                        ->getStyle('D8')->getFont()->setBold(TRUE);	                                        
	                $excel->getActiveSheet()->setCellValue('E8','Present Location')
	                                        ->getStyle('E8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F8','Present Status')
	                                        ->getStyle('F8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G8','Date')
	                                        ->getStyle('G8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H8','Record')
	                                        ->getStyle('H8')->getFont()->setBold(TRUE);

	                $a=1;
	                $i=9;
	                $total_acquisition_cost = 0;

	                foreach ($data as $row) {

	                $total_acquisition_cost += $row->acquisition_cost;
	                $record = "";
	                if($row->is_acquired == 1){  $record = 'Acquired'; }else{ $record = 'Moved'; }
	                
	                $excel->getActiveSheet()->setCellValue('A'.$i,$row->asset_code)
	                                        ->setCellValue('B'.$i,$row->asset_description)
	                                        ->setCellValue('C'.$i,number_format($row->acquisition_cost,2))
	                                        ->setCellValue('D'.$i,$row->posted_by)
	                                        ->setCellValue('E'.$i,$row->location_name)
	                                        ->setCellValue('F'.$i,$row->asset_property_status)
	                                        ->setCellValue('G'.$i,$row->date_movement)
	                                        ->setCellValue('H'.$i,$record);       
					$excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');	
					$excel->getActiveSheet()
							->getStyle('C'.$i)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                                                      
	                $i++;
	                $a++;

	                }

	                $excel->getActiveSheet()->setCellValue('B'.$i,'Total: ');
	                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($total_acquisition_cost,2));
					$excel->getActiveSheet()
							->getStyle('B'.$i.':C'.$i)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$excel->getActiveSheet()->getStyle('B'.$i.':C'.$i)->getFont()->setBold(TRUE);

	                $i++; $i++;
	                $excel->getActiveSheet()->setCellValue('A'.$i,'Date Printed: '.date('Y-m-d h:i:s'));
	                $i++;
	                $excel->getActiveSheet()->setCellValue('A'.$i,'Printed by: '.$this->session->user_fullname);


	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename="Fixed Asset Managment '.date('M-d-Y',NOW()).'.xlsx"');
	                header('Cache-Control: max-age=0');
	                // If you're serving to IE 9, then the following may be needed
	                header('Cache-Control: max-age=1');

	                // If you're serving to IE over SSL, then the following may be needed
	                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	                header ('Pragma: public'); // HTTP/1.0

	                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	                $objWriter->save('php://output');            
	                     
	            break;                

				case 'createFixedAsset':
					$m_fixed_asset=$this->Fixed_asset_management_model;
					$m_dr_item=$this->Delivery_invoice_item_model;

					$m_fixed_asset->begin();

					$dr_invoice_item_id = $this->input->post('dr_invoice_item_id',TRUE);
					$dr_item_info = $m_dr_item->get_list(
						array("dr_invoice_item_id"=>$dr_invoice_item_id),
						array(
							'delivery_invoice_items.product_id',
							'delivery_invoice_items.dr_qty'
							)
						);

					$product_id = $dr_item_info[0]->product_id;
					$dr_qty = $dr_item_info[0]->dr_qty;

					$code = $this->input->post('asset_code',TRUE);

					$fixed_asset_count = $m_fixed_asset->get_list(array('product_id'=>$product_id));
					$product_count = count($fixed_asset_count);

					for ($i=0; $i < $dr_qty; $i++) { 
							$count = $product_count + ($i+1);
							$asset_code = $code.'-'.$count;
							$m_fixed_asset->asset_code = $asset_code;
							$m_fixed_asset->asset_description = $this->input->post('asset_description',TRUE);
							$m_fixed_asset->location_id = $this->input->post('location_id',TRUE);
							$m_fixed_asset->department_id = $this->input->post('department_id',TRUE);
							$m_fixed_asset->category_id = $this->input->post('category_id',TRUE);
							$m_fixed_asset->acquisition_cost = $this->get_numeric_value($this->input->post('acquisition_cost',TRUE));
							$m_fixed_asset->salvage_value = $this->get_numeric_value($this->input->post('salvage_value',TRUE));
							$m_fixed_asset->life_years = $this->get_numeric_value($this->input->post('life_years',TRUE));
							$m_fixed_asset->date_acquired = date('Y-m-d',strtotime($this->input->post('date_acquired',TRUE)));
							$m_fixed_asset->asset_status_id = 1;
							$m_fixed_asset->product_id = $product_id;
							$m_fixed_asset->posted_by_user=$this->session->user_id;
							$m_fixed_asset->set('date_posted','NOW()');
							$m_fixed_asset->save();

							// Audit Trail Create 
		                    $m_trans=$this->Trans_model;
		                    $m_trans->user_id=$this->session->user_id;
		                    $m_trans->set('trans_date','NOW()');
		                    $m_trans->trans_key_id=1; //CRUD
		                    $m_trans->trans_type_id=54; // TRANS TYPE
		                    $m_trans->trans_log='Created Fixed Asset Code: '.$asset_code;
		                    $m_trans->save();
					}

					// Update DR Item Fixed Asset Status
					$m_dr_item->fixed_asset_status = 1;
					$m_dr_item->modify($dr_invoice_item_id);

					$m_fixed_asset->commit();

					$response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Asset successfully created.';
                    $response['row_updated']=$m_dr_item->get_fixed_asset_items(null,null,$dr_invoice_item_id);

                    echo json_encode($response);
					break;

				case 'create':
					$m_fixed_asset=$this->Fixed_asset_management_model;

					if(count($m_fixed_asset->get_list(array('asset_code'=>$this->input->post('asset_code',TRUE))))>0){
	                    $response['title'] = 'Invalid!';
	                    $response['stat'] = 'error';
	                    $response['msg'] = 'Asset Code already exists.';

	                    echo json_encode($response);
	                    exit;
	                }

					$m_fixed_asset->begin();

					$m_fixed_asset->set('date_posted','NOW()');
					$m_fixed_asset->asset_code=$this->input->post('asset_code',TRUE);
					$m_fixed_asset->asset_description=$this->input->post('asset_description',TRUE);
					$m_fixed_asset->serial_no=$this->input->post('serial_no',TRUE);
					$m_fixed_asset->location_id=$this->input->post('location_id',TRUE);
					$m_fixed_asset->department_id=$this->input->post('department_id',TRUE);
					$m_fixed_asset->category_id=$this->input->post('category_id',TRUE);
					$m_fixed_asset->acquisition_cost=$this->get_numeric_value($this->input->post('acquisition_cost',TRUE));
					$m_fixed_asset->salvage_value=$this->get_numeric_value($this->input->post('salvage_value',TRUE));
					$m_fixed_asset->life_years=$this->input->post('life_years',TRUE);
					$m_fixed_asset->asset_status_id=$this->input->post('asset_status_id',TRUE);
					$m_fixed_asset->date_acquired=date('Y-m-d', strtotime($this->input->post('date_acquired',TRUE)));
					$m_fixed_asset->remarks=$this->input->post('remarks',TRUE);
					$m_fixed_asset->posted_by_user=$this->session->user_id;

					$m_fixed_asset->save();

					$fixed_asset_id=$m_fixed_asset->last_insert_id();

					$m_fixed_asset->commit();

					// Audit Trail Create 
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=1; //CRUD
                    $m_trans->trans_type_id=54; // TRANS TYPE
                    $m_trans->trans_log='Created Fixed Asset Code: '.$this->input->post('asset_code',TRUE);
                    $m_trans->save();							

					$response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Asset successfully created.';
                    $response['row_added']=$this->response_rows($fixed_asset_id);

                    echo json_encode($response);

				break;

				case 'update':
					$m_fixed_asset=$this->Fixed_asset_management_model;
	                
					$fixed_asset_id=$this->input->post('fixed_asset_id',TRUE);

					$m_fixed_asset->set('date_modified','NOW()');
					$m_fixed_asset->asset_code=$this->input->post('asset_code',TRUE);
					$m_fixed_asset->asset_description=$this->input->post('asset_description',TRUE);
					$m_fixed_asset->serial_no=$this->input->post('serial_no',TRUE);
					$m_fixed_asset->location_id=$this->input->post('location_id',TRUE);
					$m_fixed_asset->department_id=$this->input->post('department_id',TRUE);
					$m_fixed_asset->category_id=$this->input->post('category_id',TRUE);
					$m_fixed_asset->acquisition_cost=$this->get_numeric_value($this->input->post('acquisition_cost',TRUE));
					$m_fixed_asset->salvage_value=$this->get_numeric_value($this->input->post('salvage_value',TRUE));
					$m_fixed_asset->life_years=$this->input->post('life_years',TRUE);
					$m_fixed_asset->asset_status_id=$this->input->post('asset_status_id',TRUE);
					$m_fixed_asset->date_acquired=date('Y-m-d', strtotime($this->input->post('date_acquired',TRUE)));
					$m_fixed_asset->remarks=$this->input->post('remarks',TRUE);
					$m_fixed_asset->modified_by_user=$this->session->user_id;

					$m_fixed_asset->modify($fixed_asset_id);

					// Audit Trail Updated 
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=54; // TRANS TYPE
                    $m_trans->trans_log='Updated Fixed Asset Code: '.$this->input->post('asset_code',TRUE);
                    $m_trans->save();					

					$response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Asset successfully updated.';
                    $response['row_updated']=$this->response_rows($fixed_asset_id);

                    echo json_encode($response);
				break;

				case 'delete':
					$m_fixed_asset=$this->Fixed_asset_management_model;

	                $fixed_asset_id=$this->input->post('fixed_asset_id',TRUE);

	                $m_fixed_asset->set('date_deleted','NOW()');
	                $m_fixed_asset->deleted_by_user = $this->session->user_id;
	                $m_fixed_asset->is_deleted=1;
	                if($m_fixed_asset->modify($fixed_asset_id)){

	                	$asset_info=$m_fixed_asset->get_list($fixed_asset_id,'asset_code');

						// Audit Trail Deleted 
	                    $m_trans=$this->Trans_model;
	                    $m_trans->user_id=$this->session->user_id;
	                    $m_trans->set('trans_date','NOW()');
	                    $m_trans->trans_key_id=3; //CRUD
	                    $m_trans->trans_type_id=54; // TRANS TYPE
	                    $m_trans->trans_log='Deleted Fixed Asset Code: '.$asset_info[0]->asset_code;
	                    $m_trans->save();
	                	
	                    $response['title']='Success!';
	                    $response['stat']='success';
	                    $response['msg']='Asset successfully deleted.';

	                    echo json_encode($response);
	                }
				break;

				case 'asset-history':

	                $m_company=$this->Company_model;
	                $company_info = $m_company->get_list();
	                $data['company_info']=$company_info[0];
					$m_fixed_asset=$this->Fixed_asset_management_model;
	                $fixed_asset_id=$this->input->get('id',TRUE);
	                $type=$this->input->get('type',TRUE);
	                $info=$m_fixed_asset->get_list($fixed_asset_id,
						array(
							'fixed_assets.fixed_asset_id',
							'fixed_assets.asset_code',
							'fixed_assets.asset_description',
							'fixed_assets.serial_no',
							'fixed_assets.location_id',
							'fixed_assets.department_id',
							'fixed_assets.category_id',
							'fixed_assets.life_years',
							'fixed_assets.asset_status_id',
							'DATE_FORMAT(fixed_assets.date_acquired,"%m/%d/%Y")as date_acquired',
							'fixed_assets.remarks',
							'FORMAT(fixed_assets.acquisition_cost, 2) AS acquisition_cost',
							'FORMAT(fixed_assets.salvage_value, 2) AS salvage_value',
							'locations.*',
							'departments.*',
							'categories.*',
							'asset_property_status.*'
						),
						array(
							array('locations','locations.location_id=fixed_assets.location_id','left'),
							array('departments','departments.department_id=fixed_assets.department_id','left'),
							array('categories','categories.category_id=fixed_assets.category_id','left'),
							array('asset_property_status','asset_property_status.asset_status_id=fixed_assets.asset_status_id','left')
						),
						'fixed_assets.fixed_asset_id DESC'
					);

	                $data['info']=$info[0];
	                $data['items'] = $m_fixed_asset->get_history_asset($fixed_asset_id);

	                if($type=='preview'){
                    echo $this->load->view('template/fixed_asset_history_content',$data,TRUE);
                    echo $this->load->view('template/fixed_asset_history_content_menus',$data,TRUE);

	                }else if($type=='print'){


                    $file_name=$info[0]->asset_description;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/fixed_asset_history_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();

	                }

                

				break;
			}
		}

		function response_rows($filter=null){

			return $this->Fixed_asset_management_model->get_list(
				array('fixed_asset_id'=>$filter,'fixed_assets.is_deleted=FALSE AND fixed_assets.is_active=TRUE'),
				array(
					'fixed_assets.fixed_asset_id',
					'fixed_assets.asset_code',
					'fixed_assets.asset_description',
					'fixed_assets.serial_no',
					'fixed_assets.location_id',
					'fixed_assets.department_id',
					'fixed_assets.category_id',
					'fixed_assets.life_years',
					'fixed_assets.asset_status_id',
					'fixed_assets.date_acquired',
					'fixed_assets.remarks',
					'FORMAT(fixed_assets.acquisition_cost, 2) AS acquisition_cost',
					'FORMAT(fixed_assets.salvage_value, 2) AS salvage_value',
					'locations.*',
					'departments.*',
					'categories.*',
					'asset_property_status.*',
					'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
				),
				array(
					array('locations','locations.location_id=fixed_assets.location_id','left'),
					array('departments','departments.department_id=fixed_assets.department_id','left'),
					array('categories','categories.category_id=fixed_assets.category_id','left'),
					array('asset_property_status','asset_property_status.asset_status_id=fixed_assets.asset_status_id','left'),
					array('user_accounts','user_accounts.user_id=fixed_assets.posted_by_user','left')
				)
			);
		}
	}
?>