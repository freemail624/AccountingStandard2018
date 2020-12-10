<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Account_Subsidiary extends CORE_Controller 
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
					'Suppliers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
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
	        $data['title'] = 'Per Account Subsidiary';
	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE',null,null,'account_title');
        (in_array('9-8',$this->session->user_rights)? 
        $this->load->view('account_subsidiary_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch($txn){
				case 'get-account-subsidiary':

					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
                    $includeChild=$this->input->get('includeChild',TRUE);

					$m_journal_info=$this->Journal_info_model;

					$response['data']=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date,$includeChild);
					echo json_encode($response);

				break;

				case 'export-account-subsidiary':
	                $excel=$this->excel;
	                $type=$this->input->get('type',TRUE);
	                $account_Id=$this->input->get('accountId',TRUE);
	                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
	                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

	                $m_journal_info=$this->Journal_info_model;
	                $m_company_info=$this->Company_model;

	                $journal_info=$m_journal_info->get_list(
	                    array('journal_info.is_deleted'=>FALSE, 'journal_accounts.account_id'=>$account_Id),
	                    'supplier_name, customer_name, account_title',
	                    array(
	                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
	                        array('customers','customers.customer_id=journal_info.customer_id','left'),
	                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
	                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
	                    )
	                );

	                $company_info=$m_company_info->get_list();

	                $data['company_info']=$company_info[0];
	                $subsidiary_info=$journal_info[0];
	                $supplier_subsidiary=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date);

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

	                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A8','ACCOUNT SUBSIDIARY REPORT')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A10','ACCOUNT: '.$subsidiary_info->account_title);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('37');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('18');
	                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('18');
	                $excel->getActiveSheet()->getColumnDimension('K')->setWidth('18');

	                $excel->getActiveSheet()
	                        ->getStyle('I:K')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A12','Book')
	                                        ->getStyle('A12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B12','Txn Date')
	                                        ->getStyle('B12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C12','Txn #')
	                                        ->getStyle('C12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D12','Particular')
	                                        ->getStyle('D12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E12','TIN')
	                                        ->getStyle('E12')->getFont()->setBold(TRUE);                                        
	                $excel->getActiveSheet()->setCellValue('F12','Memo')
	                                        ->getStyle('F12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G12','Remarks')
	                                        ->getStyle('G12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H12','Posted by')
	                                        ->getStyle('H12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('I12','Debit')
	                                        ->getStyle('I12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('J12','Credit')
	                                        ->getStyle('J12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('K12','Balance')
	                                        ->getStyle('K12')->getFont()->setBold(TRUE);
	                $i=13;
	                foreach($supplier_subsidiary as $items) {
	                $excel->getActiveSheet()
	                        ->getStyle('I'.$i.':K'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A'.$i,$items->book_type);
	                $excel->getActiveSheet()->setCellValue('B'.$i,$items->date_txn);
	                $excel->getActiveSheet()->setCellValue('C'.$i,$items->txn_no);
	                $excel->getActiveSheet()->setCellValue('D'.$i,$items->particular);
	                $excel->getActiveSheet()->setCellValue('E'.$i,$items->tin_no);
	                $excel->getActiveSheet()->setCellValue('F'.$i,$items->memo);
	                $excel->getActiveSheet()->setCellValue('G'.$i,$items->remarks);
	                $excel->getActiveSheet()->setCellValue('H'.$i,$items->posted_by);
	                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($items->debit,2));
	                $excel->getActiveSheet()->setCellValue('J'.$i,number_format($items->credit,2));
	                $excel->getActiveSheet()->setCellValue('K'.$i,number_format($items->balance,2))
	                                        ->getStyle('K'.$i)->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->getStyle('I'.$i.':K'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

	                $i++;
	                }


	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."ACCOUNT SUBSIDIARY REPORT.xlsx".'');
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


			case 'email-account-subsidiary':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $type=$this->input->get('type',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, customer_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $subsidiary_info=$journal_info[0];
                $supplier_subsidiary=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date);

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

	                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A8','ACCOUNT SUBSIDIARY REPORT')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A10','ACCOUNT: '.$subsidiary_info->account_title);

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('37');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('18');
	                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('18');
	                $excel->getActiveSheet()->getColumnDimension('K')->setWidth('18');

	                $excel->getActiveSheet()
	                        ->getStyle('I:K')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A12','Book')
	                                        ->getStyle('A12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B12','Txn Date')
	                                        ->getStyle('B12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C12','Txn #')
	                                        ->getStyle('C12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D12','Particular')
	                                        ->getStyle('D12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E12','TIN')
	                                        ->getStyle('E12')->getFont()->setBold(TRUE);                                        
	                $excel->getActiveSheet()->setCellValue('F12','Memo')
	                                        ->getStyle('F12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G12','Remarks')
	                                        ->getStyle('G12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H12','Posted by')
	                                        ->getStyle('H12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('I12','Debit')
	                                        ->getStyle('I12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('J12','Credit')
	                                        ->getStyle('J12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('K12','Balance')
	                                        ->getStyle('K12')->getFont()->setBold(TRUE);
	                $i=13;
	                foreach($supplier_subsidiary as $items) {
	                $excel->getActiveSheet()
	                        ->getStyle('I'.$i.':K'.$i)
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A'.$i,$items->book_type);
	                $excel->getActiveSheet()->setCellValue('B'.$i,$items->date_txn);
	                $excel->getActiveSheet()->setCellValue('C'.$i,$items->txn_no);
	                $excel->getActiveSheet()->setCellValue('D'.$i,$items->particular);
	                $excel->getActiveSheet()->setCellValue('E'.$i,$items->tin_no);
	                $excel->getActiveSheet()->setCellValue('F'.$i,$items->memo);
	                $excel->getActiveSheet()->setCellValue('G'.$i,$items->remarks);
	                $excel->getActiveSheet()->setCellValue('H'.$i,$items->posted_by);
	                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($items->debit,2));
	                $excel->getActiveSheet()->setCellValue('J'.$i,number_format($items->credit,2));
	                $excel->getActiveSheet()->setCellValue('K'.$i,number_format($items->balance,2))
	                                        ->getStyle('K'.$i)->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->getStyle('I'.$i.':K'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

	                $i++;
	            }


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."ACCOUNT SUBSIDIARY REPORT.xlsx".'');
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


                            $file_name='ACCOUNT SUBSIDIARY REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'ACCOUNT SUBSIDIARY REPORT';
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