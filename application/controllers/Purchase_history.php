<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_history extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        // $this->load->model('Pos_integration_items_model');
        $this->load->library('M_pdf');
        $this->load->library('excel');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Departments_model');
        $this->load->model('Email_settings_model');
        $this->load->model('Delivery_invoice_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Purchase History';
        // $data['cashiers'] = $this->Pos_integration_items_model->cashier_list();
        $data['suppliers']=$this->Suppliers_model->get_list(
            'suppliers.is_active=TRUE AND suppliers.is_deleted=FALSE',
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );


        (in_array('2-8',$this->session->user_rights)? 
        $this->load->view('purchase_history_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn) {
            case 'list':
                $m_pos = $this->Pos_integration_items_model;
                $cashier=$this->input->get('cashier',TRUE);
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));
                ($cashier == '0')? $cashier = null :$cashier =$cashier ;
                $response['data'] = $m_pos->bar_sales_report_list($cashier,$from,$to);
                echo json_encode($response);
                break;

            case'delivery_list_count': 

                $m_delivery=$this->Delivery_invoice_model;
                $department=$this->input->get('department',TRUE);
                $supplier=$this->input->get('supplier',TRUE);
                ($department == '0')? $department = null :$department =$department ;
                ($supplier == '0')? $supplier = null :$supplier =$supplier ;
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));

                $response['data']=$m_delivery->delivery_list_count($id_filter,$department,$supplier,$from,$to,1);

                echo json_encode($response);    

            break;

            case 'print':
                $m_company_info=$this->Company_model;
                $m_delivery=$this->Delivery_invoice_model;
                $m_department=$this->Departments_model;
                $m_supplier=$this->Suppliers_model;

                $type=$this->input->get('type',TRUE);
                $department_id=$this->input->get('department_id',TRUE);
                $supplier_id=$this->input->get('supplier_id',TRUE);
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));

                // Get Department Name
                if($department_id == 0){
                    $department_id = null;
                    $data['department_name'] = 'ALL';
                }else{
                    $department_id=$department_id;
                    $data['department_name'] = $m_department->get_list($department_id)[0]->department_name;
                }

                // Get Supplier Name
                if($supplier_id == 0){
                    $supplier_id = null;
                    $data['supplier_name'] = 'ALL';
                }else{
                    $supplier_id=$supplier_id;
                    $data['supplier_name'] = $m_supplier->get_list($supplier_id)[0]->supplier_name;
                }

                $data['data']=$m_delivery->delivery_list_count($id_filter,$department_id,$supplier_id,$from,$to,1);

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $data['from'] =date('F j, Y',strtotime($this->input->get('frm',TRUE)));
                $data['to'] =date('F j, Y',strtotime($this->input->get('to',TRUE)));

                //preview on browser
                if($type=='contentview'){
                    $file_name='Purchase History';
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/purchase_history_content',$data,TRUE); //load the template
                    // $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'export':
          
                $m_company=$this->Company_model;
                $m_delivery=$this->Delivery_invoice_model;
                $m_department=$this->Departments_model;
                $m_supplier=$this->Suppliers_model;
                $excel=$this->excel;

                $department_id=$this->input->get('department_id',TRUE);
                $supplier_id=$this->input->get('supplier_id',TRUE);
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));

                // Get Department Name
                if($department_id == 0){
                    $department_id = null;
                    $department_name = 'ALL';
                }else{
                    $department_id=$department_id;
                    $department_name = $m_department->get_list($department_id)[0]->department_name;
                }

                // Get Supplier Name
                if($supplier_id == 0){
                    $supplier_id = null;
                    $supplier_name = 'ALL';
                }else{
                    $supplier_id=$supplier_id;
                    $supplier_name = $m_supplier->get_list($supplier_id)[0]->supplier_name;
                }

                $data=$m_delivery->delivery_list_count($id_filter,$department_id,$supplier_id,$from,$to,1);
                $from =date('F j, Y',strtotime($this->input->get('frm',TRUE)));
                $to =date('F j, Y',strtotime($this->input->get('to',TRUE)));
                $company_info = $m_company->get_list();

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Purchase History");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:B2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);
                                          
                // $excel->getActiveSheet()->mergeCells('A6:D6');
                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','Purchase History')
                                        ->setCellValue('A7','Supplier : ')
                                        ->setCellValue('B7',$supplier_name)
                                        ->setCellValue('A8','Department : ')
                                        ->setCellValue('B8',$department_name)
                                        ->setCellValue('A9','From '.$from.' to '.$to);

                $excel->getActiveSheet()->getStyle('A11:H11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A11','Invoice #')
                                        ->setCellValue('B11','Supplier')
                                        ->setCellValue('C11','Department')
                                        ->setCellValue('D11','External Ref #')
                                        ->setCellValue('E11','PO#')
                                        ->setCellValue('F11','Terms')
                                        ->setCellValue('G11','Delivered');          

                $i = 12;

                foreach($data as $data){

                    $excel->getActiveSheet()->setCellValue('A'.$i,$data->dr_invoice_no)
                                ->setCellValue('B'.$i,$data->supplier_name)
                                ->setCellValue('C'.$i,$data->department_name)
                                ->setCellValue('D'.$i,$data->external_ref_no)
                                ->setCellValue('E'.$i,$data->po_no)
                                ->setCellValue('F'.$i,$data->term_description)
                                ->setCellValue('G'.$i,$data->date_delivered);
                                
                    $i++;

                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Purchase History.xlsx".'');
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
                $m_company=$this->Company_model;
                $m_delivery=$this->Delivery_invoice_model;
                $m_department=$this->Departments_model;
                $m_supplier=$this->Suppliers_model;

                $department_id=$this->input->get('department_id',TRUE);
                $supplier_id=$this->input->get('supplier_id',TRUE);
                $from=date('Y-m-d',strtotime($this->input->get('frm',TRUE)));
                $to=date('Y-m-d',strtotime($this->input->get('to',TRUE)));

                // Get Department Name
                if($department_id == 0){
                    $department_id = null;
                    $department_name = 'ALL';
                }else{
                    $department_id=$department_id;
                    $department_name = $m_department->get_list($department_id)[0]->department_name;
                }

                // Get Supplier Name
                if($supplier_id == 0){
                    $supplier_id = null;
                    $supplier_name = 'ALL';
                }else{
                    $supplier_id=$supplier_id;
                    $supplier_name = $m_supplier->get_list($supplier_id)[0]->supplier_name;
                }

                $data=$m_delivery->delivery_list_count($id_filter,$department_id,$supplier_id,$from,$to,1);
                $from =date('F j, Y',strtotime($this->input->get('frm',TRUE)));
                $to =date('F j, Y',strtotime($this->input->get('to',TRUE)));
                $company_info = $m_company->get_list();
                $email=$m_email->get_list(2);    

                $excel->setActiveSheetIndex(0);
                ob_start();

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Purchase History");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:B2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);
                                          
                // $excel->getActiveSheet()->mergeCells('A6:D6');
                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A6','Purchase History')
                                        ->setCellValue('A7','Supplier : ')
                                        ->setCellValue('B7',$supplier_name)
                                        ->setCellValue('A8','Department : ')
                                        ->setCellValue('B8',$department_name)
                                        ->setCellValue('A9','From '.$from.' to '.$to);

                $excel->getActiveSheet()->getStyle('A11:H11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A11','Invoice #')
                                        ->setCellValue('B11','Supplier')
                                        ->setCellValue('C11','Department')
                                        ->setCellValue('D11','External Ref #')
                                        ->setCellValue('E11','PO#')
                                        ->setCellValue('F11','Terms')
                                        ->setCellValue('G11','Delivered');          

                $i = 12;

                foreach($data as $data){

                    $excel->getActiveSheet()->setCellValue('A'.$i,$data->dr_invoice_no)
                                ->setCellValue('B'.$i,$data->supplier_name)
                                ->setCellValue('C'.$i,$data->department_name)
                                ->setCellValue('D'.$i,$data->external_ref_no)
                                ->setCellValue('E'.$i,$data->po_no)
                                ->setCellValue('F'.$i,$data->term_description)
                                ->setCellValue('G'.$i,$data->date_delivered);
                                
                    $i++;

                }

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Purchase History.xlsx".'');
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

                $file_name='Purchase History '.date('Y-m-d h:i:A', now());
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
                    $subject = 'Purchase History';
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
