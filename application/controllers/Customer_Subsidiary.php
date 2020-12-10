<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Customer_Subsidiary extends CORE_Controller 
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
					'Customers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
					'Customer_subsidiary_model',
                    'Account_integration_model',
					'Company_model',
					'Email_settings_model'
				)
			);

			$this->load->library('excel');
		}

		public function index() {
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);


	        $data['title'] = 'Customer Subsidiary';

            $m_integration=$this->Account_integration_model;
	        $data['customers'] = $this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE AND customer_name!=""',"customers.*",null,'customer_name');
	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE',null,null,'account_title');
            $ar_account=$m_integration->get_list();
            $data['ar_account']=$ar_account[0]->receivable_account_id;
	        

        (in_array('9-6',$this->session->user_rights)? 
        $this->load->view('customer_subsidiary_view',$data)
        :redirect(base_url('dashboard')));

		}

		function transaction($txn=null){
			switch($txn){
				case 'get-customer-subsidiary':

					$customer_Id=$this->input->get('customerId',TRUE);
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_customer_subsidiary=$this->Customer_subsidiary_model;


					$response['data']=$m_customer_subsidiary->get_customer_subsidiary($customer_Id,$account_Id,$start_Date,$end_Date);

					echo json_encode($response);

				break;

				case 'customer-subsidiary-export' :
	                $excel=$this->excel;
	                $type=$this->input->get('type',TRUE);
	                $customer_Id=$this->input->get('customerId',TRUE);
	                $account_Id=$this->input->get('accountId',TRUE);
	                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
	                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

	                $m_customer_subsidiary=$this->Customer_subsidiary_model;
	                $m_journal_info=$this->Journal_info_model;
	                $m_company_info=$this->Company_model;

	                $customer = $this->Customers_model->get_list($customer_Id);
	                $account = $this->Account_title_model->get_list($account_Id);

	                $company_info=$m_company_info->get_list();

	                $data['company_info']=$company_info[0];
	                $customer_subsidiary=$m_customer_subsidiary->get_customer_subsidiary($customer_Id,$account_Id,$start_Date,$end_Date);

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("ACCOUNT SUBSIDIARY REPORT");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->mergeCells('A6:B6');                     
	                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A8:B8');                     
	                $excel->getActiveSheet()->setCellValue('A8','CUSTOMER SUBSIDIARY REPORT')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A10','CUSTOMER: '.$customer[0]->customer_name)
	                                        ->mergeCells('A10:D10');                                         
	                $excel->getActiveSheet()->setCellValue('E10','ACCOUNT: '.$account[0]->account_title)
	                                        ->mergeCells('E10:H10');

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

	                $excel->getActiveSheet()
	                        ->getStyle('G')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('H')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('F')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A12','Txn Date')
	                                        ->getStyle('A12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B12','Txn #')
	                                        ->getStyle('B12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C12','Memo')
	                                        ->getStyle('C12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D12','Remarks')
	                                        ->getStyle('D12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E12','Posted by')
	                                        ->getStyle('E12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F12','Debit')
	                                        ->getStyle('F12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G12','Credit')
	                                        ->getStyle('G12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H12','Balance')
	                                        ->getStyle('H12')->getFont()->setBold(TRUE);

	                $i=13;

	                foreach ($customer_subsidiary as $items){
	                    $excel->getActiveSheet()
	                            ->getStyle('G')
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                    $excel->getActiveSheet()
	                            ->getStyle('H')
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                    $excel->getActiveSheet()
	                            ->getStyle('F')
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                    $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
	                    $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
	                    $excel->getActiveSheet()->setCellValue('C'.$i,$items->memo);
	                    $excel->getActiveSheet()->setCellValue('D'.$i,$items->remarks);
	                    $excel->getActiveSheet()->setCellValue('E'.$i,$items->posted_by);
	                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($items->debit,2));
	                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->credit,2));
	                    $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                    $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->balance,2));
	    
	                    $i++;

	                }

	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."CUSTOMER SUBSIDIARY REPORT.xlsx".'');
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

                case 'customer-subsidiary-email' :
	                $excel=$this->excel;
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);
	                $type=$this->input->get('type',TRUE);
	                $customer_Id=$this->input->get('customerId',TRUE);
	                $account_Id=$this->input->get('accountId',TRUE);
	                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
	                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

	                $m_customer_subsidiary=$this->Customer_subsidiary_model;
	                $m_company_info=$this->Company_model;
	                $m_journal_info=$this->Journal_info_model;

	                $customer = $this->Customers_model->get_list($customer_Id);
	                $account = $this->Account_title_model->get_list($account_Id);
	                $company_info=$m_company_info->get_list();

	                $data['company_info']=$company_info[0];
	                $subsidiary_info=$journal_info[0];
	                $customer_subsidiary=$m_customer_subsidiary->get_customer_subsidiary($customer_Id,$account_Id,$start_Date,$end_Date);

	                ob_start();
	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("ACCOUNT SUBSIDIARY REPORT");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->mergeCells('A6:B6');                     
	                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A8:B8');                     
	                $excel->getActiveSheet()->setCellValue('A8','CUSTOMER SUBSIDIARY REPORT')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A10','CUSTOMER: '.$customer[0]->customer_name)
	                                        ->mergeCells('A10:D10');                                         
	                $excel->getActiveSheet()->setCellValue('E10','ACCOUNT: '.$account[0]->account_title)
	                                        ->mergeCells('E10:H10');

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

	                $excel->getActiveSheet()
	                        ->getStyle('G')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('H')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('F')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A12','Txn Date')
	                                        ->getStyle('A12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B12','Txn #')
	                                        ->getStyle('B12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C12','Memo')
	                                        ->getStyle('C12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D12','Remarks')
	                                        ->getStyle('D12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E12','Posted by')
	                                        ->getStyle('E12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F12','Debit')
	                                        ->getStyle('F12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G12','Credit')
	                                        ->getStyle('G12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H12','Balance')
	                                        ->getStyle('H12')->getFont()->setBold(TRUE);

	                $i=13;

	                foreach ($customer_subsidiary as $items){
	                    $excel->getActiveSheet()
	                            ->getStyle('G')
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                    $excel->getActiveSheet()
	                            ->getStyle('H')
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                    $excel->getActiveSheet()
	                            ->getStyle('F')
	                            ->getAlignment()
	                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                    $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
	                    $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
	                    $excel->getActiveSheet()->setCellValue('C'.$i,$items->memo);
	                    $excel->getActiveSheet()->setCellValue('D'.$i,$items->remarks);
	                    $excel->getActiveSheet()->setCellValue('E'.$i,$items->posted_by);
	                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($items->debit,2));
	                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->credit,2));
	                    $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                    $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->balance,2));
	    
	                    $i++;

	                }
	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."CUSTOMER SUBSIDIARY REPORT.xlsx".'');
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

	                            $file_name='CUSTOMER SUBSIDIARY REPORT '.date('Y-m-d h:i:A', now());
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
	                            $subject = 'CUSTOMER SUBSIDIARY REPORT';
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