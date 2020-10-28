<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operating_expense extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_class_model',
                'Journal_info_model',
                'Journal_account_model',
                'Users_model',
                'Departments_model',
                'Company_model',
                'Book_type_model'
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
        $data['title'] = 'Operating Expense';

        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');
        $data['book_types']=$this->Book_type_model->get_list();
        // $data['income_accounts']=$this->Journal_info_model->get_account_balance(4);
        // $data['expense_accounts']=$this->Journal_info_model->get_account_balance(5);
        (in_array('9-27',$this->session->user_rights)? 
        $this->load->view('operating_expense_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn)
    {
        switch($txn)
        {

            case 'export-excel':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;

                $type=$this->input->get('type',TRUE);
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $book_type_id=$this->input->get('bookid',TRUE);

                $book = $this->Book_type_model->get_list($book_type_id);
                $book_type = $book[0]->book_type;

                $sDate = date("Y-m-d",strtotime($start));
                $eDate = date("Y-m-d",strtotime($end));
                $operating_expense_id = 6;

                $m_company=$this->Company_model;
                $company=$m_company->get_list();
                $filename="";

                $book_type_name=$book[0]->book_type_name;

                $start=date("m/d/Y",strtotime($start));
                $end=date("m/d/Y",strtotime($end));

                if($type == 1){
                    $items=$this->Journal_info_model->get_operating_expense($book_type,$sDate,$eDate,$operating_expense_id);
                    $filename = "Operating Expense - ".$book_type_name." (".$start."-".$end.").xlsx";
                    $opex_title = $book_type_name;
                }else{
                    $items=$this->Journal_info_model->get_operating_summary($sDate,$eDate,$operating_expense_id);
                    $filename = "Operating Expense Summary (".$start."-".$end.").xlsx";
                    $opex_title = "SUMMARY";
                }

                $excel=$this->excel;
   

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->setTitle('OPEX-'.$book_type_name);                 

                $border = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );    

                $bouble_bottom = array(
                  'borders' => array(               
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                    )
                  )
                );                                                                                         

                $rowCount1 = 5;
                $column1 = 'B';

                $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
                $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');

                foreach($items[0] as $key => $value)
                {

                    $excel->getActiveSheet()->setCellValue($column1.$rowCount1, $key); 
                    $excel->getActiveSheet()->getStyle($column1.$rowCount1)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle($column1.$rowCount1)->applyFromArray($border);

                    $excel->getActiveSheet()
                            ->getStyle($column1.$rowCount1)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $column1++;
                }
                
                $excel->getActiveSheet()
                        ->mergeCells('B1:'.$column1.'1')
                        ->setCellValue('B1', $company[0]->company_name)
                        ->getStyle('B1:'.$column1.'1')->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()
                        ->getStyle('B1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()
                        ->mergeCells('B2:'.$column1.'2')
                        ->setCellValue('B2', 'Operating Expense ('.$opex_title.')')
                        ->getStyle('B2:'.$column1.'2')->getFont()
                        ->setBold(TRUE);                        

                $excel->getActiveSheet()
                        ->getStyle('B2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                        

                $excel->getActiveSheet()
                        ->mergeCells('B3:'.$column1.'3')
                        ->setCellValue('B3', $start.' to '.$end)
                        ->getStyle('B3:'.$column1.'3')->getFont()
                        ->setBold(TRUE);    

                $excel->getActiveSheet()
                        ->getStyle('B3')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                                  

                //end of adding column names 
                //start foreach loop to get data

                $rowCount = 6;

                foreach($items as $key => $values) 
                {
                 //start of printing column names as names of MySQL fields 
                 $column = 'B';

                 foreach($values as $value) 
                 {

                    $excel->getActiveSheet()->setCellValue($column.$rowCount, $value);
                    $excel->getActiveSheet()->getStyle($column.$rowCount)->applyFromArray($border);
                    $excel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                 $column++; 

                 } 

                 $rowCount++;

                }

                $rowCount2 = $rowCount;
                $column2 = 'B';
                $lastrow = count($items) + 5;

                // $excel->getActiveSheet()->getStyle($column.$rowCount.':'.$column.$lastrow)->getFont()->setBold(TRUE);

                // $excel->getActiveSheet()->setCellValue('AH31', $column.$rowCount); 

                foreach($items[0] as $key => $value)
                {

                    if($column2 == "B"){
                        $excel->getActiveSheet()->setCellValue($column2.$rowCount2, 'Total'); 
                    }else{
                        $excel->getActiveSheet()->setCellValue($column2.$rowCount2, "=SUM(".$column2."6:".$column2.$lastrow.")"); 

                    $excel->getActiveSheet()->getStyle($column2.$rowCount2)->applyFromArray($bouble_bottom);
                    $excel->getActiveSheet()->getStyle($column2.$rowCount2)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 
                    }

                    $excel->getActiveSheet()->getStyle($column2.$rowCount2)->getFont()->setBold(TRUE);
                    
                    $column2++;
                }


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$filename);
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

                case 'email-excel':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;
                
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);

                $type=$this->input->get('type',TRUE);
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $book_type_id=$this->input->get('bookid',TRUE);

                $book = $this->Book_type_model->get_list($book_type_id);
                $book_type = $book[0]->book_type;

                $sDate = date("Y-m-d",strtotime($start));
                $eDate = date("Y-m-d",strtotime($end));
                $operating_expense_id = 6;

                $m_company=$this->Company_model;
                $company=$m_company->get_list();
                $filename="";

                $book_type_name=$book[0]->book_type_name;

                $start=date("m/d/Y",strtotime($start));
                $end=date("m/d/Y",strtotime($end));

                if($type == 1){
                    $items=$this->Journal_info_model->get_operating_expense($book_type,$sDate,$eDate,$operating_expense_id);
                    $filename = "Operating Expense - ".$book_type_name." (".$start."-".$end.").xlsx";
                    $fname = "Operating Expense - ".$book_type_name." (".$start."-".$end.")";
                    $opex_title = $book_type_name;
                }else{
                    $items=$this->Journal_info_model->get_operating_summary($sDate,$eDate,$operating_expense_id);
                    $filename = "Operating Expense Summary (".$start."-".$end.").xlsx";
                    $fname = "Operating Expense Summary (".$start."-".$end.")";
                    $opex_title = "SUMMARY";
                }

                $excel=$this->excel;

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->setTitle('OPEX-'.$book_type_name);                 

                $border = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );    

                $bouble_bottom = array(
                  'borders' => array(               
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                    )
                  )
                );                                                                                         

                $rowCount1 = 5;
                $column1 = 'B';

                $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
                $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');

                foreach($items[0] as $key => $value)
                {

                    $excel->getActiveSheet()->setCellValue($column1.$rowCount1, $key); 
                    $excel->getActiveSheet()->getStyle($column1.$rowCount1)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle($column1.$rowCount1)->applyFromArray($border);

                    $excel->getActiveSheet()
                            ->getStyle($column1.$rowCount1)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $column1++;
                }
                
                $excel->getActiveSheet()
                        ->mergeCells('B1:'.$column1.'1')
                        ->setCellValue('B1', $company[0]->company_name)
                        ->getStyle('B1:'.$column1.'1')->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()
                        ->getStyle('B1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()
                        ->mergeCells('B2:'.$column1.'2')
                        ->setCellValue('B2', 'Operating Expense ('.$opex_title.')')
                        ->getStyle('B2:'.$column1.'2')->getFont()
                        ->setBold(TRUE);                        

                $excel->getActiveSheet()
                        ->getStyle('B2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                        

                $excel->getActiveSheet()
                        ->mergeCells('B3:'.$column1.'3')
                        ->setCellValue('B3', $start.' to '.$end)
                        ->getStyle('B3:'.$column1.'3')->getFont()
                        ->setBold(TRUE);    

                $excel->getActiveSheet()
                        ->getStyle('B3')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                                  

                //end of adding column names 
                //start foreach loop to get data

                $rowCount = 6;

                foreach($items as $key => $values) 
                {
                 //start of printing column names as names of MySQL fields 
                 $column = 'B';

                 foreach($values as $value) 
                 {

                    $excel->getActiveSheet()->setCellValue($column.$rowCount, $value);
                    $excel->getActiveSheet()->getStyle($column.$rowCount)->applyFromArray($border);
                    $excel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                 $column++; 

                 } 

                 $rowCount++;

                }

                $rowCount2 = $rowCount;
                $column2 = 'B';
                $lastrow = count($items) + 5;

                foreach($items[0] as $key => $value)
                {

                    if($column2 == "B"){
                        $excel->getActiveSheet()->setCellValue($column2.$rowCount2, 'Total'); 
                    }else{
                        $excel->getActiveSheet()->setCellValue($column2.$rowCount2, "=SUM(".$column2."6:".$column2.$lastrow.")"); 

                    $excel->getActiveSheet()->getStyle($column2.$rowCount2)->applyFromArray($bouble_bottom);
                    $excel->getActiveSheet()->getStyle($column2.$rowCount2)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 
                    }

                    $excel->getActiveSheet()->getStyle($column2.$rowCount2)->getFont()->setBold(TRUE);
                    
                    $column2++;
                }


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$filename);
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

                          $file_name=$fname.' '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Operating Expense';
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
