<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Supplier_Subsidiary extends CORE_Controller 
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array
				(
					'Journal_account_model',
					'Journal_info_model',
					'Suppliers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
					'Customer_subsidiary_model',
					'Company_model',
                    'Account_integration_model',
					'Email_settings_model'
				)
			);
        $this->load->library('excel');
        $this->load->library('M_pdf');
		}

		public function index() {
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);


	        $data['title'] = 'Supplier Subsidiary';
	        $data['suppliers']=$this->Suppliers_model->get_supplier_list();
	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE',null,null,'account_title');

            $ap_account=$this->Account_integration_model->get_list();
            $data['ap_account']=$ap_account[0]->payable_account_id;
        (in_array('9-7',$this->session->user_rights)? 
        $this->load->view('supplier_subsidiary_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch($txn){
				case 'get-supplier-subsidiary':

					$supplier_Id=$this->input->get('supplierId',TRUE);
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_journal=$this->Journal_info_model;

					$response['data']=$m_journal->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
					echo json_encode($response);

				break;

				case 'get-supplier-subsidiary-all':
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_journal=$this->Journal_info_model;
	                $m_company_info=$this->Company_model;	
	               	$data['account'] = $this->Account_title_model->get_list($account_Id)[0];
	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];
					$suppliers = $this->Suppliers_model->get_list(array('is_active'=>true,'is_deleted'=>false));
					foreach ($suppliers as $supplier) {
						$responses[$supplier->supplier_id]=$m_journal->get_supplier_subsidiary($supplier->supplier_id,$account_Id,$start_Date,$end_Date);

					}

				$data['suppliers'] = $suppliers;
				$data['responses'] = $responses;
                $pdf = $this->m_pdf->load("A4-L");
                $content=$this->load->view('template/supplier_all_subsidiary_report',$data,TRUE);
                $pdf->WriteHTML($content);
                $pdf->Output();

				break;


				case 'get-supplier-subsidiary-all-export':
				$account_Id=$this->input->get('accountId',TRUE);
				$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
				$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
				$m_journal=$this->Journal_info_model;
                $m_company_info=$this->Company_model;	
               	$account = $this->Account_title_model->get_list($account_Id)[0];
                $company_info=$m_company_info->get_list();
				$suppliers = $this->Suppliers_model->get_list(array('is_active'=>true,'is_deleted'=>false));
				foreach ($suppliers as $supplier) {
					$responses[$supplier->supplier_id]=$m_journal->get_supplier_subsidiary($supplier->supplier_id,$account_Id,$start_Date,$end_Date);

				}
               
                $excel=$this->excel;
   

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')
                                        ->setAutoSize(false)
                                        ->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('G')
                                        ->setAutoSize(false)
                                        ->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('H')
                                        ->setAutoSize(false)
                                        ->setWidth('15');

                $excel->getActiveSheet()->setTitle('SUPPLIER SUBSIDIARY');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);


                 $excel->getActiveSheet()->setCellValue('A6','Supplier Detailed Subsidiary')
                 						->setCellValue('A7','ACCOUNT: '.$account->account_no.' - '.$account->account_title)
                                        ->setCellValue('A8','PERIOD: '.$this->input->get('startDate',TRUE).' to '.$this->input->get('endDate',TRUE));                       


				$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold( true );
            $i = 9;
 			$count = 0; foreach ($suppliers as $supplier) { 
	 						if(!empty($responses[$supplier->supplier_id])){
	 							$excel->getActiveSheet()->setCellValue('A'.$i,$supplier->supplier_name)->mergeCells('A'.$i.':H'.$i);
	 							$excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()
                                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                            ->getStartColor()->setARGB('00ffec');
	 								$i++;
	         						$excel->getActiveSheet()->setCellValue('A'.$i,'Txn Date')
	         						->setCellValue('B'.$i,'Txn #')
	         						->setCellValue('C'.$i,'Memo')
	         						->setCellValue('D'.$i,'Remarks')
	         						->setCellValue('E'.$i,'Posted by')
	         						->setCellValue('F'.$i,'Debit')
	         						->setCellValue('G'.$i,'Credit')
	         						->setCellValue('H'.$i,'Balance');
	         						$excel->Align_right('F',$i);
	         						$excel->Align_right('G',$i);
	         						$excel->Align_right('H',$i);
	         						$excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFont()->setBold( true );
	         							
	   							foreach($responses[$supplier->supplier_id] as $items) { 
	   								$i++;
	   								$excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn)
	         						->setCellValue('B'.$i,$items->txn_no)
	         						->setCellValue('C'.$i,$items->memo)
	         						->setCellValue('D'.$i,$items->remarks)
	         						->setCellValue('E'.$i,$items->posted_by)
	         						->setCellValue('F'.$i,$items->debit)
	         						->setCellValue('G'.$i,$items->credit)
	         						->setCellValue('H'.$i,$items->balance);
	         						$excel->Align_right('F',$i);
	         						$excel->Align_right('G',$i);
	         						$excel->Align_right('H',$i);
	         						$excel->getActiveSheet()->getStyle('F'.$i.':H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	         						$count++; 
	         					
	         					}  
      						} // END IF 
      						$i++;
					    }  // END FOREACH
					  if($count == 0){}

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Supplier Detailed Subsidiary.xlsx"');
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

			case 'supplier-subsidiary-export' :
                $excel=$this->excel;
                $type=$this->input->get('type',TRUE);
                $supplier_Id=$this->input->get('supplierId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.supplier_id'=>$supplier_Id, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                if (isset($journal_info[0])) 
                {

                    $supplier_subsidiary=$m_journal_info->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
                    $data['company_info']=$company_info[0];
                    $subsidiary_info=$journal_info[0];

                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("SUPPLIER SUBSIDIARY REPORT");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:C2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->mergeCells('A4:B4');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->setCellValue('A6','PERIOD : '.$start_Date.' to '.$end_Date)
                                            ->getStyle('A6')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('A8','SUPPLIER SUBSIDIARY REPORT')
                                            ->getStyle('A8')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('A10:D10');
                    $excel->getActiveSheet()->setCellValue('A10','Supplier: '.$subsidiary_info->supplier_name)
                                            ->getStyle('A10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('E10:H10');
                    $excel->getActiveSheet()->setCellValue('E10','Account: '.$subsidiary_info->account_title)
                                            ->getStyle('E10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');

                    $excel->getActiveSheet()
                            ->getStyle('A12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                   
                     $excel->getActiveSheet()
                            ->getStyle('B12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                  
                     $excel->getActiveSheet()
                            ->getStyle('C12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                                           
                    $excel->getActiveSheet()
                            ->getStyle('G')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('H')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('I')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);    

                    $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                            ->getStyle('A12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B12','Book')
                                            ->getStyle('B12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C12','Txn #')
                                            ->getStyle('C12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D12','Memo')
                                            ->getStyle('D12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E12','Remarks')
                                            ->getStyle('E12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F12','Posted by')
                                            ->getStyle('F12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('G12','Debit')
                                            ->getStyle('G12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('H12','Credit')
                                            ->getStyle('H12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('I12','Balance')
                                            ->getStyle('I12')->getFont()->setBold(TRUE);

                    $i=13;

                    foreach($supplier_subsidiary as $items){
                        $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$items->book_type);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$items->txn_no);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$items->memo);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$items->remarks);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$items->posted_by);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$items->debit);
                        $excel->getActiveSheet()->setCellValue('H'.$i,$items->credit);
                        $excel->getActiveSheet()->setCellValue('I'.$i,$items->balance);

                        $excel->getActiveSheet()->getStyle('G'.$i.':I'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');

                        $i++;
                    }

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."SUPPLIER SUBSIDIARY REPORT.xlsx".'');
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


                } else {
                        
                    echo '<center style="font-family: Arial, sans-serif;"><h1 style="color:#2196f3">Information</h1><hr><h3>No record associated to this supplier.</h3></center>';
                }
               
                break;

			case 'supplier-subsidiary-email':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $type=$this->input->get('type',TRUE);
                $supplier_Id=$this->input->get('supplierId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.supplier_id'=>$supplier_Id, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                if (isset($journal_info[0])) 
                {

                    $supplier_subsidiary=$m_journal_info->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
                    $data['company_info']=$company_info[0];
                    $subsidiary_info=$journal_info[0];

                    ob_start();
                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("SUPPLIER SUBSIDIARY REPORT");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:C2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->mergeCells('A4:B4');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->setCellValue('A6','PERIOD : '.$start_Date.' to '.$end_Date)
                                            ->getStyle('A6')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('A8','SUPPLIER SUBSIDIARY REPORT')
                                            ->getStyle('A8')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('A10:D10');
                    $excel->getActiveSheet()->setCellValue('A10','Supplier: '.$subsidiary_info->supplier_name)
                                            ->getStyle('A10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('E10:H10');
                    $excel->getActiveSheet()->setCellValue('E10','Account: '.$subsidiary_info->account_title)
                                            ->getStyle('E10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');

                    $excel->getActiveSheet()
                            ->getStyle('A12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                   
                     $excel->getActiveSheet()
                            ->getStyle('B12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                  
                     $excel->getActiveSheet()
                            ->getStyle('C12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                                           
                    $excel->getActiveSheet()
                            ->getStyle('G')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('H')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('I')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);    

                    $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                            ->getStyle('A12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B12','Book')
                                            ->getStyle('B12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C12','Txn #')
                                            ->getStyle('C12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D12','Memo')
                                            ->getStyle('D12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E12','Remarks')
                                            ->getStyle('E12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F12','Posted by')
                                            ->getStyle('F12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('G12','Debit')
                                            ->getStyle('G12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('H12','Credit')
                                            ->getStyle('H12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('I12','Balance')
                                            ->getStyle('I12')->getFont()->setBold(TRUE);

                    $i=13;

                    foreach($supplier_subsidiary as $items){
                        $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$items->book_type);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$items->txn_no);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$items->memo);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$items->remarks);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$items->posted_by);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$items->debit);
                        $excel->getActiveSheet()->setCellValue('H'.$i,$items->credit);
                        $excel->getActiveSheet()->setCellValue('I'.$i,$items->balance);
                        
                        $excel->getActiveSheet()->getStyle('G'.$i.':I'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');
                        $i++;
                    }

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."SUPPLIER SUBSIDIARY REPORT.xlsx".'');
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

                    $data = ob_get_clean();

                            $file_name='SUPPLIER SUBSIDIARY REPORT '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $email[0]->email_address, 
                                'smtp_pass' => $email[0]->password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = array($email[0]->email_to);
                            $subject = 'SUPPLIER SUBSIDIARY REPORT';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Supplier or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }
               
                } else {
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='No record associated to this supplier.';

                            echo json_encode($response);                        
                }   

                break;                

			}
		}
	}

?>