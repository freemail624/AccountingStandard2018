<?php
	defined('BASEPATH') OR exit('No direct script access allowed.');

	class Aging_receivables extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Sales_invoice_model',
					'Users_model',
					'Soa_settings_model',
					'Company_model',
					'Departments_model'
				)
			);
			$this->load->library('M_pdf');
	        $this->load->library('excel');
	        $this->load->model('Email_settings_model');
		}

		public function index()
		{
			$this->Users_model->validate();
	        //default resources of the active view
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
	        $data['title'] = "Aging of Receivables";

	        $data['departments'] = $this->Departments_model->get_list(array("is_deleted"=>FALSE));
	        $this->load->view('aging_receivables_view',$data);
		}

		function transaction($txn)
		{
			switch ($txn) {
				// ACCOUNTING VERSION
				// case 'list':
				// 	$m_sales = $this->Sales_invoice_model;
	   //              $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id');
	   //              $acc = [];
	   //              foreach ($accounts as $account) { $acc[]=$account->soa_account_id; }
	   //              $filter_accounts =  implode(",", $acc);

				// 	$response['data'] = $m_sales->get_aging_receivables($filter_accounts);

				// 	echo json_encode($response);
				// 	break;

				// NEW VERSION - BILLING VERSION 
				case 'list': 
					$m_sales = $this->Sales_invoice_model;
					$department_id = $this->input->get('id', TRUE);
					$as_of_date = $this->input->get('as_of_date', TRUE);
					$status_id = $this->input->get('status_id', TRUE);

					if($as_of_date != null){
						$as_of_date = date("Y-m-d", strtotime($this->input->get('as_of_date', TRUE)));
					}else{
						$as_of_date = date("Y-m-d");
					}

					$response['data'] = $m_sales->get_aging_receivables_billing($department_id,$as_of_date,$status_id);

					echo json_encode($response);
					break;		


				// ACCOUNTING VERSION
				// case 'print':

				// 	$m_sales = $this->Sales_invoice_model;
				// 	$m_company = $this->Company_model;

				// 	$company_info = $m_company->get_list();

				// 	$data['company_info'] = $company_info[0];
	   //              $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id');
	   //              $acc = [];
	   //              foreach ($accounts as $account) { $acc[]=$account->soa_account_id; }
	   //              $filter_accounts =  implode(",", $acc);

				// 	$data['receivables'] = $m_sales->get_aging_receivables($filter_accounts);

    //                 $file_name='Aging of Receivables';
    //                 $pdfFilePath = $file_name.".pdf"; //generate filename base on id
    //                 $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
    //                 $content=$this->load->view('template/aging_receivables_report',$data,TRUE); //load the template
    //                 $pdf->setFooter('{PAGENO}');
    //                 $pdf->WriteHTML($content);
    //                 //download it.
    //                 $pdf->Output();


				// 	// $this->load->view('template/aging_receivables_report',$data);
				// 	break;							

				case 'print': // BILLING VERSION
					$m_sales = $this->Sales_invoice_model;
					$m_department = $this->Departments_model;
					$m_company = $this->Company_model;

					$company_info = $m_company->get_list();

					$data['company_info'] = $company_info[0];

					$department_id = $this->input->get('id', TRUE);
					$as_of_date = $this->input->get('as_of_date', TRUE);
					$status_id = $this->input->get('status_id', TRUE);

					if($as_of_date != null){
						$as_of_date = date("Y-m-d", strtotime($this->input->get('as_of_date', TRUE)));
					}else{
						$as_of_date = date("Y-m-d");
					}

					$data['receivables'] = $m_sales->get_aging_receivables_billing($department_id,$as_of_date,$status_id);

					if($department_id == 0){
						$data['department_name'] = "All Departments";
					}else{
						$data['department_name'] = $m_department->get_list($department_id)[0]->department_name;
					}

                    $file_name='Aging of Receivables';
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $pdf = new mPDF('c', 'A4-L'); 
                    $content=$this->load->view('template/aging_receivables_report',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();


					// $this->load->view('template/aging_receivables_report',$data);
					break;
				
				default:
					# code...
					break;

				case 'export':
          
                	$excel=$this->excel;
					$m_sales = $this->Sales_invoice_model;
					$m_department = $this->Departments_model;
					$m_company = $this->Company_model;

					$company_info = $m_company->get_list();

					$data['company_info'] = $company_info[0];

					$department_id = $this->input->get('id', TRUE);
					$as_of_date = $this->input->get('as_of_date', TRUE);
					$status_id = $this->input->get('status_id', TRUE);

					if($as_of_date != null){
						$as_of_date = date("Y-m-d", strtotime($this->input->get('as_of_date', TRUE)));
					}else{
						$as_of_date = date("Y-m-d");
					}

					$receivables = $m_sales->get_aging_receivables_billing($department_id,$as_of_date,$status_id);

					if($department_id == 0){
						$department_name = "All Departments";
					}else{
						$department_name = $m_department->get_list($department_id)[0]->department_name;
					}

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Aging of Receivables");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:B1');
	                $excel->getActiveSheet()->mergeCells('A2:B2');
	                $excel->getActiveSheet()->mergeCells('A3:B3');
	                $excel->getActiveSheet()->mergeCells('A4:B4');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A6:B6')->setWidth('40');	                                        
	                $excel->getActiveSheet()->mergeCells('A6:B6');
                	$excel->getActiveSheet()->setCellValue('A6',"TENANTS' AGING OF RECEIVABLES REPORT")
                                        	->getStyle('A6')->getFont()->setBold(TRUE)
                                        	->setSize(12);

                	$excel->getActiveSheet()->setCellValue('A7',"Department : ".$department_name)
                                        	->getStyle('A7')->getFont()->setBold(TRUE)
                                        	->setSize(12);


	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
	                	                	                
	                $excel->getActiveSheet()
	                        ->getStyle('C:H')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

	                $excel->getActiveSheet()->setCellValue('A8','TENANT CODE')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B8','TENANT NAME')
	                                        ->getStyle('B8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C8','0-30 DAYS')
	                                        ->getStyle('C8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D8','31-60 DAYS')
	                                        ->getStyle('D8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E8','61-90 DAYS')
	                                        ->getStyle('E8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F8','90 DAYS AND ABOVE')
	                                        ->getStyle('F8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G8','BALANCE')
	                                        ->getStyle('G8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H8','TOTAL SECURITY DEPOSIT')
	                                        ->getStyle('H8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('I8','STATUS')
	                                        ->getStyle('I8')->getFont()->setBold(TRUE);
	                $i=9;
					$sum_thirty = 0; 
					$sum_sixty = 0;
					$sum_ninety = 0;
					$sum_over_ninety = 0;
					$sum_balance = 0;
					$sum_security_deposit = 0;  
					
					foreach($receivables as $receivable) {		
		                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('60');
		                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('10');


		                $excel->getActiveSheet()
		                        ->getStyle('C'.$i.':H'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		                        
                    	$excel->getActiveSheet()->getStyle('C'.$i.':H'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

		                $excel->getActiveSheet()->setCellValue('A'.$i,$receivable->tenant_code);
		                $excel->getActiveSheet()->setCellValue('B'.$i,$receivable->trade_name);     
		                $excel->getActiveSheet()->setCellValue('C'.$i,$receivable->balance_thirty_days);
		                $excel->getActiveSheet()->setCellValue('D'.$i,$receivable->balance_sixty_days);    
		                $excel->getActiveSheet()->setCellValue('E'.$i,$receivable->balance_ninety_days);
		                $excel->getActiveSheet()->setCellValue('F'.$i,$receivable->balance_over_ninetydays);   
		                $excel->getActiveSheet()->setCellValue('G'.$i,$receivable->total_tenant_balance);  
		                $excel->getActiveSheet()->setCellValue('H'.$i,$receivable->total_security_deposit);
		                $excel->getActiveSheet()->setCellValue('I'.$i,$receivable->status);

						
						$i++; 
						$sum_thirty += $receivable->balance_thirty_days;  
						$sum_sixty += $receivable->balance_sixty_days; 
						$sum_ninety += $receivable->balance_ninety_days; 
						$sum_over_ninety += $receivable->balance_over_ninetydays; 
						$sum_balance += $receivable->total_tenant_balance; 
						$sum_security_deposit += $receivable->total_security_deposit;   											
					}			  

                    	$lastrow = count($receivables) + 8;

                    	$excel->getActiveSheet()->getStyle('C'.$i.':H'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 
		                $excel->getActiveSheet()->getStyle('C'.$i.':H'.$i)->getFont()->setBold(TRUE);	            
		                // $excel->getActiveSheet()->setCellValue('C'.$i,$sum_thirty);
		                // $excel->getActiveSheet()->setCellValue('D'.$i,$sum_sixty);
		                // $excel->getActiveSheet()->setCellValue('E'.$i,$sum_ninety);
		                // $excel->getActiveSheet()->setCellValue('F'.$i,$sum_over_ninety);
		                // $excel->getActiveSheet()->setCellValue('G'.$i,$sum_balance);
		                // $excel->getActiveSheet()->setCellValue('H'.$i,$sum_security_deposit);

                    	$excel->getActiveSheet()->setCellValue('C'.$i, "=SUM(C9:C".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(D9:D".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('E'.$i, "=SUM(E9:E".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('F'.$i, "=SUM(F9:F".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('G'.$i, "=SUM(G9:G".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('H'.$i, "=SUM(H9:H".$lastrow.")");
		                

		                $i++;

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Aging of Receivables Report.xlsx".'');
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

				case 'email':
          
                	$excel=$this->excel;
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);
					$m_sales = $this->Sales_invoice_model;
					$m_company = $this->Company_model;

					$company_info = $m_company->get_list();

					$data['company_info'] = $company_info[0];
	                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id');
	                $acc = [];
	                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; }
	                $filter_accounts =  implode(",", $acc);

					$receivables = $m_sales->get_aging_receivables($filter_accounts);

					ob_start();

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('30');

	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("Aging of Receivables");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A1:B1');
	                $excel->getActiveSheet()->mergeCells('A2:B2');
	                $excel->getActiveSheet()->mergeCells('A3:B3');
	                $excel->getActiveSheet()->mergeCells('A4:B4');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A6:B6')->setWidth('40');	                                        
	                $excel->getActiveSheet()->mergeCells('A6:B6');
                	$excel->getActiveSheet()->setCellValue('A6',"TENANTS' AGING OF RECEIVABLES REPORT")
                                        	->getStyle('A6')->getFont()->setBold(TRUE)
                                        	->setSize(12);

                	$excel->getActiveSheet()->setCellValue('A7',"Department : ".$department_name)
                                        	->getStyle('A7')->getFont()->setBold(TRUE)
                                        	->setSize(12);


	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
	                	                	                
	                $excel->getActiveSheet()
	                        ->getStyle('C:H')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

	                $excel->getActiveSheet()->setCellValue('A8','Tenant Code')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B8','Tenant Name')
	                                        ->getStyle('B8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C8','0-30 DAYS')
	                                        ->getStyle('C8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D8','31-60 DAYS')
	                                        ->getStyle('D8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E8','61-90 DAYS')
	                                        ->getStyle('E8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F8','90 DAYS AND ABOVE')
	                                        ->getStyle('F8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G8','BALANCE')
	                                        ->getStyle('G8')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H8','TOTAL SECURITY DEPOSIT')
	                                        ->getStyle('H8')->getFont()->setBold(TRUE);
	                $i=9;
					$sum_thirty = 0; 
					$sum_sixty = 0;
					$sum_ninety = 0;
					$sum_over_ninety = 0;
					$sum_balance = 0;
					$sum_security_deposit = 0;  
					
					foreach($receivables as $receivable) {		
		                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('60');
		                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
		                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');


		                $excel->getActiveSheet()
		                        ->getStyle('C'.$i.':H'.$i)
		                        ->getAlignment()
		                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		                        
                    	$excel->getActiveSheet()->getStyle('C'.$i.':H'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

		                $excel->getActiveSheet()->setCellValue('A'.$i,$receivable->tenant_code);
		                $excel->getActiveSheet()->setCellValue('B'.$i,$receivable->trade_name);     
		                $excel->getActiveSheet()->setCellValue('C'.$i,$receivable->balance_thirty_days);
		                $excel->getActiveSheet()->setCellValue('D'.$i,$receivable->balance_sixty_days);    
		                $excel->getActiveSheet()->setCellValue('E'.$i,$receivable->balance_ninety_days);
		                $excel->getActiveSheet()->setCellValue('F'.$i,$receivable->balance_over_ninetydays);   
		                $excel->getActiveSheet()->setCellValue('G'.$i,$receivable->total_tenant_balance);  
		                $excel->getActiveSheet()->setCellValue('H'.$i,$receivable->total_security_deposit);

						
						$i++; 
						$sum_thirty += $receivable->balance_thirty_days;  
						$sum_sixty += $receivable->balance_sixty_days; 
						$sum_ninety += $receivable->balance_ninety_days; 
						$sum_over_ninety += $receivable->balance_over_ninetydays; 
						$sum_balance += $receivable->total_tenant_balance; 
						$sum_security_deposit += $receivable->total_security_deposit;   											
					}			  

                    	$lastrow = count($receivables) + 8;

                    	$excel->getActiveSheet()->getStyle('C'.$i.':H'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 
		                $excel->getActiveSheet()->getStyle('C'.$i.':H'.$i)->getFont()->setBold(TRUE);	            
		                // $excel->getActiveSheet()->setCellValue('C'.$i,$sum_thirty);
		                // $excel->getActiveSheet()->setCellValue('D'.$i,$sum_sixty);
		                // $excel->getActiveSheet()->setCellValue('E'.$i,$sum_ninety);
		                // $excel->getActiveSheet()->setCellValue('F'.$i,$sum_over_ninety);
		                // $excel->getActiveSheet()->setCellValue('G'.$i,$sum_balance);
		                // $excel->getActiveSheet()->setCellValue('H'.$i,$sum_security_deposit);

                    	$excel->getActiveSheet()->setCellValue('C'.$i, "=SUM(C9:C".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(D9:D".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('E'.$i, "=SUM(E9:E".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('F'.$i, "=SUM(F9:F".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('G'.$i, "=SUM(G9:G".$lastrow.")");
                    	$excel->getActiveSheet()->setCellValue('H'.$i, "=SUM(H9:H".$lastrow.")");
		                

		                $i++;
		                
	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."Aging of Receivables Report.xlsx".'');
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

                            $file_name='Aging of Receivables Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Aging of Receivables';
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

				break;

			}
		}
	}
?>