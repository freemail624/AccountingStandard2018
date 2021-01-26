<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open_purchase_request extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Purchase_request_model');
        $this->load->model('Purchase_request_items_model');
        $this->load->model('Products_model');
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);


        $data['title'] = 'Open Purchase Request';
        
        (in_array('12-8',$this->session->user_rights)? 
        $this->load->view('Open_purchase_request_view', $data)
        :redirect(base_url('dashboard')));

    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

                case'list';
                    $m_request_items=$this->Purchase_request_items_model;
                    $response['data']=$m_request_items->get_list_open_requests();
                    echo json_encode($response);
                break;

                case'report';
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];

                $m_request_items=$this->Purchase_request_items_model;
                $data['requests']=$m_request_items->get_list_open_requests();
                $data['item']=$m_request_items->get_pr_no_of_open_purchase_request();

                $this->load->view('template/open_purchase_request_report',$data);
                break;

                case'export';
                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $m_request_items=$this->Purchase_request_items_model;
                $requests=$m_request_items->get_list_open_requests();
                $item=$m_request_items->get_pr_no_of_open_purchase_request();

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->setTitle('Open Purchase Request');

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

                $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                                        ->mergeCells('A1:D1')
                                        ->getStyle('A1:D1')->getFont()->setBold(True)
                                        ->setSize(16);

                $excel->getActiveSheet()->setCellValue('A2',$company_info->company_address)
                                        ->mergeCells('A2:D2')
                                        ->setCellValue('A3',$company_info->landline.' / '.$company_info->mobile_no)
                                        ->mergeCells('A3:D3');

                    $border_bottom= array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()->setCellValue('A5')
                                            ->mergeCells('A5:F5')
                                            ->getStyle('A5:F5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:F6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','Open Purchase Requests')
                                            ->mergeCells('A6:F6')
                                            ->getStyle('A6:F6')->getFont()->setBold(True)
                                            ->setSize(14);

                $i=8;

                foreach ($item as $batchNo) {

                $excel->getActiveSheet()
                    ->getStyle('A'.$i.':'.'F'.$i)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF9900');

                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'F'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'PR #: '.$batchNo->pr_no)
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $i++;
                                         
                $excel->getActiveSheet()->setCellValue('A'.$i,'Purchase Request No')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Product Code')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Product Description')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Requested Qty')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Ordered Qty')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Balance')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);

                $i++;

                    foreach ($requests as $pr) {    
                        if ($batchNo->pr_no == $pr->pr_no) { 
                            $excel->getActiveSheet()->setCellValue('A'.$i,$pr->pr_no);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$pr->product_code);
                            $excel->getActiveSheet()->setCellValue('C'.$i,$pr->product_desc);
                            $excel->getActiveSheet()->setCellValue('D'.$i,$pr->PrQtyTotal);
                            $excel->getActiveSheet()->setCellValue('E'.$i,$pr->PrQtyDelivered);
                            $excel->getActiveSheet()->setCellValue('F'.$i,$pr->PrQtyBalance);
                            $i++;                                                                                                                                                                                                                                  
                        }
                    }         
                }


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Open Purchase Request Report.xlsx".'');
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

                case'email';
                $excel = $this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $m_request_items=$this->Purchase_request_items_model;
                $requests=$m_request_items->get_list_open_requests();
                $item=$m_request_items->get_pr_no_of_open_purchase_request();

                ob_start();
                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Open Purchase Request');

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

                $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                                        ->mergeCells('A1:D1')
                                        ->getStyle('A1:D1')->getFont()->setBold(True)
                                        ->setSize(16);

                $excel->getActiveSheet()->setCellValue('A2',$company_info->company_address)
                                        ->mergeCells('A2:D2')
                                        ->setCellValue('A3',$company_info->landline.' / '.$company_info->mobile_no)
                                        ->mergeCells('A3:D3');

                    $border_bottom= array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()->setCellValue('A5')
                                            ->mergeCells('A5:F5')
                                            ->getStyle('A5:F5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:F6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','Open Purchase Requests')
                                            ->mergeCells('A6:F6')
                                            ->getStyle('A6:F6')->getFont()->setBold(True)
                                            ->setSize(14);

                $i=8;

                foreach ($item as $batchNo) {

                $excel->getActiveSheet()
                    ->getStyle('A'.$i.':'.'F'.$i)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF9900');

                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'F'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'PR #: '.$batchNo->pr_no)
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $i++;
                                         
                $excel->getActiveSheet()->setCellValue('A'.$i,'Purchase Request No')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Product Code')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Product Description')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Requested Qty')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Ordered Qty')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Balance')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);

                $i++;

                    foreach ($requests as $pr) {    
                        if ($batchNo->pr_no == $pr->pr_no) { 
                            $excel->getActiveSheet()->setCellValue('A'.$i,$pr->pr_no);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$pr->product_code);
                            $excel->getActiveSheet()->setCellValue('C'.$i,$pr->product_desc);
                            $excel->getActiveSheet()->setCellValue('D'.$i,$pr->PrQtyTotal);
                            $excel->getActiveSheet()->setCellValue('E'.$i,$pr->PrQtyDelivered);
                            $excel->getActiveSheet()->setCellValue('F'.$i,$pr->PrQtyBalance);
                            $i++;                                                                                                                                                                                                                                  
                        }
                    }         
                }


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Open Purchase Request Report.xlsx".'');
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

                            $file_name='Open Purchase Request Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Open Purchase Request Report';
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


