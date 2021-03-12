<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account_receivable_schedule extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Journal_info_model',
                'Journal_account_model',
                'Account_title_model',
                'Users_model',
                'Account_integration_model',
                'Company_model',
                'Email_settings_model'
            )
        );

        $this->load->library('excel');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['title'] = 'Accounts Receivable Schedule';
        $m_account_integration=$this->Account_integration_model;

        $ar_id=$m_account_integration->get_list();
        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['ar_account']=$ar_id[0]->receivable_account_id;
        (in_array('9-4',$this->session->user_rights)? 
        $this->load->view('accounts_receivable_schedule_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn=null){
        switch($txn){
            case 'ar-list':
                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->post('account_id');
                $date=$this->input->post('date');

                $response['data']=$m_journal_accounts->get_account_schedule($account_id,$date);
                echo json_encode($response);

                break;

            case 'account-receivable-schedule-export':
                $excel=$this->excel;

                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $ar_accounts=$m_journal_accounts->get_account_schedule($account_id,$date);

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A5')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("AR SCHEDULE REPORT");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address)
                                        ->setCellValue('A5','As of Date'.$date);

                $excel->getActiveSheet()->setCellValue('A7','Account Receivable Schedule')
                                        ->getStyle('A7')->getFont()->setBold(TRUE);


                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');

                $excel->getActiveSheet()
                        ->getStyle('B:D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Customer')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Previous')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','This Month')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Total')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i=10;
                $total = 0.00;

                foreach($ar_accounts as $ar){

                    $excel->getActiveSheet()->setCellValue('A'.$i,$ar->customer_name);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$ar->previous);
                    $excel->getActiveSheet()->setCellValue('C'.$i,$ar->current);
                    // $excel->getActiveSheet()->setCellValue('D'.$i,$ar->total);

                    $excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(B".$i."+C".$i.")");

                    $excel->getActiveSheet()->getStyle('B'.$i.':D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                    $i++;
                    $total+=$ar->total;                    
                }


                    $lastrow = count($ar_accounts) + 9;

                    $excel->getActiveSheet()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->getStyle('A'.$i)->getFont()->setBold(TRUE);

                    // $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total,2))
                    //                         ->getStyle('D'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(D9:D".$lastrow.")")
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);                   
                    $excel->getActiveSheet()->getStyle('D'.$i.':I'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');
                                             

                    $i++;

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Account Receivable Schedule Report.xlsx".'');
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

            case 'account-receivable-schedule-email':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $ar_accounts=$m_journal_accounts->get_account_schedule($account_id,$date);

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A5')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("AR SCHEDULE REPORT");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address)
                                        ->setCellValue('A5','As of Date'.$date);

                $excel->getActiveSheet()->setCellValue('A7','Account Receivable Schedule')
                                        ->getStyle('A7')->getFont()->setBold(TRUE);


                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');

                $excel->getActiveSheet()
                        ->getStyle('B:D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Customer')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Previous')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','This Month')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Total')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i=10;
                $total = 0.00;

                foreach($ar_accounts as $ar){

                    $excel->getActiveSheet()->setCellValue('A'.$i,$ar->customer_name);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$ar->previous);
                    $excel->getActiveSheet()->setCellValue('C'.$i,$ar->current);
                    // $excel->getActiveSheet()->setCellValue('D'.$i,$ar->total);

                    $excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(B".$i."+C".$i.")");

                    $excel->getActiveSheet()->getStyle('B'.$i.':D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                    $i++;
                    $total+=$ar->total;                    
                }


                    $lastrow = count($ar_accounts) + 9;

                    $excel->getActiveSheet()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->getStyle('A'.$i)->getFont()->setBold(TRUE);

                    // $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total,2))
                    //                         ->getStyle('D'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(D10:D".$lastrow.")")
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);                   
                    $excel->getActiveSheet()->getStyle('D'.$i.':I'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');
                                             

                    $i++;

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Account Receivable Schedule Report.xlsx".'');
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

                            $file_name='ACCOUNT RECEIVABLE SCHEDULE REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'AR SCHEDULE REPORT';
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
