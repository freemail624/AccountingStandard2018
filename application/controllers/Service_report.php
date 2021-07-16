<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_report extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Repair_order_model');
        $this->load->model('Vehicle_services_model');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->library('M_pdf');
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['vehicle_services'] = $this->Vehicle_services_model->get_list();
        $data['title'] = 'Service Report';

        $this->load->view('service_report_view', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
          case 'list':
            $m_repair_order = $this->Repair_order_model;
            $startDate = date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));;
            $endDate = date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));;
            $vehicleServiceId = $this->input->get('vehicle_service_id', TRUE);
            $response['data'] = $m_repair_order->serviceReport($startDate, $endDate, $vehicleServiceId);
            echo json_encode($response);
            break;

          case 'preview':
            $m_company_info=$this->Company_model;

            $data['company_info']=$m_company_info->get_list()[0];

            $m_repair_order = $this->Repair_order_model;
            $startDate = date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));;
            $endDate = date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));;
            $vehicleServiceId = $this->input->get('vehicle_service_id', TRUE);
            $data['repair_orders'] = $m_repair_order->serviceReport($startDate, $endDate, $vehicleServiceId);

            $data['date_from'] = $startDate;
            $data['date_to'] = $endDate;

            $data['service_type'] = $this->Vehicle_services_model->get_list(array('vehicle_service_id'=>$vehicleServiceId))[0]->service_name;

            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
            $content=$this->load->view('template/service_report',$data,TRUE); //load the template
            //$pdf->setFooter('{PAGENO}');
            $pdf->WriteHTML($content);
            //download it.
            $pdf->Output();
            break;

          case 'excel':
            $m_company_info=$this->Company_model;

            $data['company_info']=$m_company_info->get_list()[0];

            $m_repair_order = $this->Repair_order_model;
            $startDate = date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));;
            $endDate = date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));;
            $vehicleServiceId = $this->input->get('vehicle_service_id', TRUE);
            $data['repair_orders'] = $m_repair_order->serviceReport($startDate, $endDate, $vehicleServiceId);

            $data['date_from'] = $startDate;
            $data['date_to'] = $endDate;

            $data['service_type'] = $this->Vehicle_services_model->get_list(array('vehicle_service_id'=>$vehicleServiceId))[0]->service_name;
            $excel = $this->excel($data);
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');  
            break;

          case 'email':
            $m_email=$this->Email_settings_model;
            $email=$m_email->get_list(2);
            $m_company_info=$this->Company_model;

            $data['company_info']=$m_company_info->get_list()[0];

            $m_repair_order = $this->Repair_order_model;
            $startDate = date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));;
            $endDate = date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));;
            $vehicleServiceId = $this->input->get('vehicle_service_id', TRUE);
            $data['repair_orders'] = $m_repair_order->serviceReport($startDate, $endDate, $vehicleServiceId);

            $data['date_from'] = $startDate;
            $data['date_to'] = $endDate;

            $data['service_type'] = $this->Vehicle_services_model->get_list(array('vehicle_service_id'=>$vehicleServiceId))[0]->service_name;
            $excel = $this->excel($data);

            ob_start();
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');                 
            $data = ob_get_clean();
            $file_name='Service Report'.date('Y-m-d h:i:A', now());
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
            $subject = 'Service Report';
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

    function excel($data) {
      $excel=$this->excel;

      $excel->setActiveSheetIndex(0);

      $excel->getActiveSheet()->getColumnDimensionByColumn('A1:F1')->setWidth('30');
      $excel->getActiveSheet()->getColumnDimensionByColumn('A2:F2')->setWidth('50');
      $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');

      //name the worksheet

      $excel->getActiveSheet()
              ->getStyle('A1:F1')
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

      $excel->getActiveSheet()
              ->getStyle('A2:F2')
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

      $excel->getActiveSheet()
              ->getStyle('A3:F3')
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

      $excel->getActiveSheet()->setTitle("Repair Order List");
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
      $excel->getActiveSheet()->mergeCells('A1:F1');
      $excel->getActiveSheet()->mergeCells('A2:F2');
      $excel->getActiveSheet()->mergeCells('A3:F3');
      $excel->getActiveSheet()->setCellValue('A1',$data['company_info']->company_name)
                              ->setCellValue('A2',$data['company_info'] ->company_address)
                              ->setCellValue('A3',$data['company_info']->landline.'/'.$data['company_info']->mobile_no); 


      $excel->getActiveSheet()
              ->getStyle('A5:F5')
              ->getAlignment()
              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

      $excel->getActiveSheet()->getColumnDimensionByColumn('A5:F5')->setWidth('40');                                          
      $excel->getActiveSheet()->mergeCells('A5:F5');
      $excel->getActiveSheet()->setCellValue('A5','SERVICE REPORT ('.$data['date_from'].' - '.$data['date_to']);
      $excel->getActiveSheet()->mergeCells('A6:F6');
      $excel->getActiveSheet()->setCellValue('A6','SERVICE TYPE : '.$data['service_type']);

      $excel->getActiveSheet()->setCellValue('A8','RO #')
                              ->getStyle('A8')->getFont()->setBold(TRUE);
      $excel->getActiveSheet()->setCellValue('B8','DOCUMENT DATE')
                              ->getStyle('B8')->getFont()->setBold(TRUE);
      $excel->getActiveSheet()->setCellValue('C8','CUSTOMER')
                              ->getStyle('C8')->getFont()->setBold(TRUE);
      $excel->getActiveSheet()->setCellValue('D8','PLATE NO')
                              ->getStyle('D8')->getFont()->setBold(TRUE);
      $excel->getActiveSheet()->setCellValue('E8','ADVISOR')
                              ->getStyle('E8')->getFont()->setBold(TRUE);    
      $excel->getActiveSheet()->setCellValue('F8','TOTAL AMOUNT')
                              ->getStyle('F8')->getFont()->setBold(TRUE);

      $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
      $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
      $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
      $excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
      $excel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
      $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');

      $i=10;
      foreach($data['repair_orders'] as $ro){
          $excel->getActiveSheet()->setCellValue('A'.$i,$ro->repair_order_no);
          $excel->getActiveSheet()->setCellValue('B'.$i,$ro->document_date);
          $excel->getActiveSheet()->setCellValue('C'.$i,$ro->customer_name);
          $excel->getActiveSheet()->setCellValue('D'.$i,$ro->plate_no);
          $excel->getActiveSheet()->setCellValue('E'.$i,$ro->advisor);
          $excel->getActiveSheet()->setCellValue('F'.$i,$ro->total_amount);

          $i++;
      }


      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename='."Service Report.xlsx".'');
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');

      // If you're serving to IE over SSL, then the following may be needed
      header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
      header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header ('Pragma: public'); // HTTP/1.0

      return $excel;
    }
}
