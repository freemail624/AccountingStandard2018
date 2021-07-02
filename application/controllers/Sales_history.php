<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_history extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->library('M_pdf');
        $this->load->library('excel');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Products_model');
        $this->load->model('Invoice_counter_model');
        $this->load->model('Company_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Cash_invoice_model');
        $this->load->model('Customer_type_model');
        $this->load->model('Order_source_model');
        $this->load->model('Email_settings_model');
        $this->load->model('Inv_receipt_types_model');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);


        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        $data['salespersons']=$this->Salesperson_model->get_list(
            array('salesperson.is_active'=>TRUE,'salesperson.is_deleted'=>FALSE),
            'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
        );

        //data required by active view
        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE)
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE'
        );

        $data['customer_type']=$this->Customer_type_model->get_list(
            'is_deleted=FALSE'
        );

        $data['customer_type_create']=$this->Customer_type_model->get_list(
            'is_deleted=FALSE'
        );

        $tax_rate=$this->Company_model->get_list(
            null,
            array(
                'company_info.tax_type_id',
                'tt.tax_rate'
            ),
            array(
                array('tax_types as tt','tt.tax_type_id=company_info.tax_type_id','left')
            )
        );

        $data['tax_percentage']=(count($tax_rate)>0?$tax_rate[0]->tax_rate:0);
        $data['invoice_counter']=$this->Invoice_counter_model->get_list(array('user_id'=>$this->session->user_id));
        $data['order_sources'] = $this->Order_source_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['inv_receipt_types'] =$this->Inv_receipt_types_model->get_list();

        $data['title'] = 'Sales History';
        
        (in_array('3-6',$this->session->user_rights)? 
        $this->load->view('sales_history_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            case 'list_with_count':  //this returns JSON of Issuance to be rendered on Datatable
                $m_invoice=$this->Sales_invoice_model;
                $customer_id = $this->input->get('id');
                $inv_receipt_type_id = $this->input->get('inv_receipt_type_id');
                $response['data']=$m_invoice->get_sales_history($customer_id,$inv_receipt_type_id);
                echo json_encode($response);
                break;

            case 'print':
                $m_invoice=$this->Sales_invoice_model;
                $m_customer=$this->Customers_model;
                $m_company=$this->Company_model;
                $m_inv_receipt_type=$this->Inv_receipt_types_model;

                $company=$m_company->get_list();
                $customer_id = $this->input->get('customer_id');
                $inv_receipt_type_id = $this->input->get('inv_receipt_type_id');
                $data['data']=$m_invoice->get_sales_history($customer_id,$inv_receipt_type_id);
                $data['company_info']=$company[0];

                if($customer_id == 0){
                    $data['customer_name'] = 'ALL';
                }else{
                    $data['customer_name'] = $m_customer->get_list($customer_id)[0]->customer_name;
                }

                if($inv_receipt_type_id == 0){
                    $data['inv_receipt_type'] = 'ALL';
                }else{
                    $data['inv_receipt_type'] = $m_inv_receipt_type->get_list($inv_receipt_type_id)[0]->inv_receipt_type;
                }

                $file_name='Sales History';
                $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                $pdf = $this->m_pdf->load('A4-L'); //pass the instance of the mpdf class
                $content=$this->load->view('template/sales_history_content',$data,TRUE); //load the template
                // $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                //download it.
                $pdf->Output();

                break;

            case 'excel':
                $m_invoice=$this->Sales_invoice_model;
                $m_product=$this->Products_model;
                $m_customer=$this->Customers_model;
                $m_company=$this->Company_model;
                $m_inv_receipt_type=$this->Inv_receipt_types_model;

                $company_info=$m_company->get_list();
                $customer_id = $this->input->get('customer_id');
                $inv_receipt_type_id = $this->input->get('inv_receipt_type_id');

                $data=$m_invoice->get_sales_history($customer_id,$inv_receipt_type_id);

                if($customer_id == 0){
                    $customer_name = 'ALL';
                }else{
                    $customer_name = $m_customer->get_list($customer_id)[0]->customer_name;
                }

                if($inv_receipt_type_id == 0){
                    $inv_receipt_type = 'ALL';
                }else{
                    $inv_receipt_type = $m_inv_receipt_type->get_list($inv_receipt_type_id)[0]->inv_receipt_type;
                }

                $excel=$this->excel;
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

                $excel->getActiveSheet()->setTitle('Sales History');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()->getStyle('B8')
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','Sales History')
                                        ->setCellValue('A7','Customer :')
                                        ->setCellValue('B7',$customer_name)
                                        ->setCellValue('A8','Receipt Type :')
                                        ->setCellValue('B8',$inv_receipt_type);

                $excel->getActiveSheet()->getStyle('A10:G10')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A10','Date')
                                        ->setCellValue('B10','Receipt Type')
                                        ->setCellValue('C10','Receipt No')
                                        ->setCellValue('D10','Particular')
                                        ->setCellValue('E10','Amount')
                                        ->setCellValue('F10','Department')
                                        ->setCellValue('G10','Remarks');

                $i = 11;

                   foreach ($data as $data) {

                    $excel->getActiveSheet()
                          ->setCellValue('A'.$i,$data->date_invoice)
                          ->setCellValue('B'.$i,$data->inv_receipt_type)
                          ->setCellValue('C'.$i,$data->receipt_no)
                          ->setCellValue('D'.$i,$data->customer_name)
                          ->setCellValue('E'.$i,$data->total_after_tax)
                          ->setCellValue('F'.$i,$data->department_name)
                          ->setCellValue('G'.$i,$data->remarks);
                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('* #,##0.00;_* #,##0.00;_(@_)');
                    $i++;
                }

                $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Exported By: '.$this->session->user_fullname);
                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Date Exported: '.date("Y-m-d H:i:s"));

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Sales History '.date("Y-m-d H:i:s").'.xlsx"');
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
                $m_email=$this->Email_settings_model;
                $m_invoice=$this->Sales_invoice_model;
                $m_customer=$this->Customers_model;
                $m_company=$this->Company_model;
                $m_inv_receipt_type=$this->Inv_receipt_types_model;

                $email=$m_email->get_list(2);   
                $company_info=$m_company->get_list();
                $customer_id = $this->input->get('customer_id');
                $inv_receipt_type_id = $this->input->get('inv_receipt_type_id');

                $data=$m_invoice->get_sales_history($customer_id,$inv_receipt_type_id);

                if($customer_id == 0){
                    $customer_name = 'ALL';
                }else{
                    $customer_name = $m_customer->get_list($customer_id)[0]->customer_name;
                }

                if($inv_receipt_type_id == 0){
                    $inv_receipt_type = 'ALL';
                }else{
                    $inv_receipt_type = $m_inv_receipt_type->get_list($inv_receipt_type_id)[0]->inv_receipt_type;
                }

                // SET WIDTH
                ob_start();
                $excel=$this->excel;
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

                $excel->getActiveSheet()->setTitle('Sales History');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()->getStyle('B8')
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','Sales History')
                                        ->setCellValue('A7','Customer :')
                                        ->setCellValue('B7',$customer_name)
                                        ->setCellValue('A8','Receipt Type :')
                                        ->setCellValue('B8',$inv_receipt_type);

                $excel->getActiveSheet()->getStyle('A10:G10')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A10','Date')
                                        ->setCellValue('B10','Receipt Type')
                                        ->setCellValue('C10','Receipt No')
                                        ->setCellValue('D10','Particular')
                                        ->setCellValue('E10','Amount')
                                        ->setCellValue('F10','Department')
                                        ->setCellValue('G10','Remarks');

                $i = 11;

                   foreach ($data as $data) {

                    $excel->getActiveSheet()
                          ->setCellValue('A'.$i,$data->date_invoice)
                          ->setCellValue('B'.$i,$data->inv_receipt_type)
                          ->setCellValue('C'.$i,$data->receipt_no)
                          ->setCellValue('D'.$i,$data->customer_name)
                          ->setCellValue('E'.$i,$data->total_after_tax)
                          ->setCellValue('F'.$i,$data->department_name)
                          ->setCellValue('G'.$i,$data->remarks);
                    $excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('* #,##0.00;_* #,##0.00;_(@_)');
                    $i++;
                }

                $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Exported By: '.$this->session->user_fullname);
                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Date Exported: '.date("Y-m-d H:i:s"));

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Sales History '.date("Y-m-d H:i:s").'.xlsx"');
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
                ob_end_clean();

                $file_name='Sales History '.date('Y-m-d H:i:s', now());
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
                    $subject = 'Sales History';
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
                    $response['msg']='Please check the Email Address or your Internet Connection.';

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