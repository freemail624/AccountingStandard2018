<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_inventory extends CORE_Controller
{
    function __construct()
    {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(
            array
            (
                'Departments_model',
                'Company_model',
                'Users_model',
                'Products_model',
                'Account_integration_model'
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
        $data['title'] = 'Batch Inventory Report';

        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['products']=$this->Products_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE,'item_type_id'=>1));
        (in_array('15-7',$this->session->user_rights)? 
        $this->load->view('batch_inventory_report_view',$data)
        :redirect(base_url('dashboard')));
    }



    public function transaction($txn=null){
        switch($txn){
            case 'get-inventory':
                $m_products = $this->Products_model;
                $ccf = null;

                $product_id = $this->input->post('product_id',TRUE);
                $depid = $this->input->post('depid',TRUE);
                $currentcountfilter = $this->input->post('ccf',TRUE);
                $date = date('Y-m-d',strtotime($this->input->post('date',TRUE)));

                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter == 1){ 
                    $ccf = null; 
                }else if ($currentcountfilter == 2) { 
                    $ccf = ' > 0'; 
                }else if($currentcountfilter == 3){ 
                    $ccf = ' < 0'; 
                }else if($currentcountfilter == 4){ 
                    $ccf = ' = 0';
                }

                $response['data']=$m_products->batch_inventory($product_id,$depid,$ccf,$date);


                echo json_encode($response);    
                break;

            case 'product-batch-history':
                $m_products = $this->Products_model;
                $uniq_id=$this->input->get('uniq_id');
                $department_id=$this->input->get('depid');
                $as_of_date=date('Y-m-d',strtotime($this->input->get('date')));

                $data['items']=$m_products->batch_inventory_history($uniq_id,$department_id,$as_of_date);
                $this->load->view('template/batch_inventory_history',$data);
                break;

            case 'export-batch-inventory':

                $excel = $this->excel;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $ccf = null;
                $type = $this->input->get('type',TRUE);
                $product_id = $this->input->get('product_id',TRUE);
                $depid = $this->input->get('depid',TRUE);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));

                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter == 1){ 
                    $ccf = null; 
                }else if ($currentcountfilter == 2) { 
                    $ccf = ' > 0'; 
                }else if($currentcountfilter == 3){ 
                    $ccf = ' < 0'; 
                }else if($currentcountfilter == 4){ 
                    $ccf = ' = 0';
                }

                if($currentcountfilter  == 1){ 
                    $ccf_data = 'All Count Items'; 
                }else if ($currentcountfilter  == 2) {
                    $ccf_data = 'Items Greater than Zero'; 
                }else if($currentcountfilter  == 3){ 
                    $ccf_data = 'Items Less than Zero'; 
                }else if($currentcountfilter  == 4){ 
                    $ccf_data = 'Items Equal to Zero';
                }

                $info=$m_department->get_list($depid);
                $as_of_date = date('m/d/Y',strtotime($date));
                $batches=$m_products->batch_inventory($product_id,$depid,$ccf,$date);

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department = 'All';
                }

                if($product_id==0){
                    $product='All';
                }else{
                    $product=$m_products->get_list($product_id)[0]->product_desc;
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Batch Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Batch Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Product : '.$product)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','As of '.$as_of_date)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A9',$ccf_data)
                                        ->getStyle('A9')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
    
                $excel->getActiveSheet()
                        ->getStyle('E10:G10')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A10','PLU')
                                        ->getStyle('A10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B10','Description')
                                        ->getStyle('B10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C10','Expiration')
                                        ->getStyle('C10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D10','LOT#')
                                        ->getStyle('D10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E10','Qty IN')
                                        ->getStyle('E10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F10','Qty OUT')
                                        ->getStyle('F10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G10','On Hand')
                                        ->getStyle('G10')->getFont()->setBold(TRUE);

                $i=11;

                foreach($batches as $batch){

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i.':D'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()
                                ->getStyle('E'.$i.':G'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        $excel->getActiveSheet()->setCellValue('A'.$i,$batch->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$batch->product_desc);                 
                        $excel->getActiveSheet()->setCellValue('C'.$i,$batch->exp_date);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$batch->batch_no);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$batch->qty_in);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$batch->qty_out);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$batch->on_hand_per_batch);
                        $i++;                  
                }

                if($product_id != 0){
                    $last_row = count($batches) + 10;
                    $excel->getActiveSheet()->setCellValue('D'.$i, "Total")
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('E'.$i, "=SUM(E11:E".$last_row.")")
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('F'.$i, "=SUM(F11:F".$last_row.")")
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('G'.$i, "=SUM(G11:G".$last_row.")")
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                }

                if(count($batches)==0){
                    $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Batch Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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

            case 'email-batch-inventory':

                $excel = $this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $ccf = null;
                $type = $this->input->get('type',TRUE);
                $product_id = $this->input->get('product_id',TRUE);
                $depid = $this->input->get('depid',TRUE);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));

                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter == 1){ 
                    $ccf = null; 
                }else if ($currentcountfilter == 2) { 
                    $ccf = ' > 0'; 
                }else if($currentcountfilter == 3){ 
                    $ccf = ' < 0'; 
                }else if($currentcountfilter == 4){ 
                    $ccf = ' = 0';
                }

                if($currentcountfilter  == 1){ 
                    $ccf_data = 'All Count Items'; 
                }else if ($currentcountfilter  == 2) {
                    $ccf_data = 'Items Greater than Zero'; 
                }else if($currentcountfilter  == 3){ 
                    $ccf_data = 'Items Less than Zero'; 
                }else if($currentcountfilter  == 4){ 
                    $ccf_data = 'Items Equal to Zero';
                }

                $info=$m_department->get_list($depid);
                $as_of_date = date('m/d/Y',strtotime($date));
                $batches=$m_products->batch_inventory($product_id,$depid,$ccf,$date);

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department = 'All';
                }

                if($product_id==0){
                    $product='All';
                }else{
                    $product=$m_products->get_list($product_id)[0]->product_desc;
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();


                ob_start();
                
                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Batch Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Batch Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Product : '.$product)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','As of '.$as_of_date)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A9',$ccf_data)
                                        ->getStyle('A9')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
    
                $excel->getActiveSheet()
                        ->getStyle('E10:G10')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A10','PLU')
                                        ->getStyle('A10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B10','Description')
                                        ->getStyle('B10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C10','Expiration')
                                        ->getStyle('C10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D10','LOT#')
                                        ->getStyle('D10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E10','Qty IN')
                                        ->getStyle('E10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F10','Qty OUT')
                                        ->getStyle('F10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G10','On Hand')
                                        ->getStyle('G10')->getFont()->setBold(TRUE);

                $i=11;

                foreach($batches as $batch){

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i.':D'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()
                                ->getStyle('E'.$i.':G'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        $excel->getActiveSheet()->setCellValue('A'.$i,$batch->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$batch->product_desc);                 
                        $excel->getActiveSheet()->setCellValue('C'.$i,$batch->exp_date);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$batch->batch_no);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$batch->qty_in);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$batch->qty_out);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$batch->on_hand_per_batch);
                        $i++;                  
                }

                if($product_id != 0){
                    $last_row = count($batches) + 10;
                    $excel->getActiveSheet()->setCellValue('D'.$i, "Total")
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('E'.$i, "=SUM(E11:E".$last_row.")")
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('F'.$i, "=SUM(F11:F".$last_row.")")
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('G'.$i, "=SUM(G11:G".$last_row.")")
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                }

                if(count($batches)==0){
                    $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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

                            $file_name='Batch Inventory Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Batch Inventory Report';
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