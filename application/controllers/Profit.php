<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profit extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Profit_model');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
        $this->load->model('Email_settings_model');
        $this->load->model('Order_source_model');
        $this->load->model('Agent_model');
        $this->load->model('Customers_model');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['trucks']=$this->Agent_model->get_list(array('is_deleted'=>FALSE));
        $data['customers']=$this->Customers_model->get_list(array('is_deleted'=>FALSE));

        $data['title'] = 'Profit Report';
        $this->load->view('profit_view', $data);
        (in_array('8-6',$this->session->user_rights)? 
        :redirect(base_url('dashboard')));

    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

                case'report-by-product';
                $m_sales=$this->Profit_model;
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');

                if($invoice_type == 1){//All Invoices
                    $response['data']=$m_sales->get_profit_by_product($start,$end,$customer_id); 
                }else if($invoice_type == 2){//Charge Invoices
                    $response['data']=$m_sales->get_profit_by_product_charge($start,$end,$agent_id,$customer_id); 
                }else{//Cash Invoices
                    $response['data']=$m_sales->get_profit_by_product_cash($start,$end,$customer_id); //Cash Invoice
                }

                echo json_encode($response);
                break;      


                case'report-by-invoice-detailed';
                $m_sales=$this->Profit_model;
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');

                if($invoice_type == 1){ //All Invoices

                    $response['data']=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,FALSE,$customer_id);
                    $response['distinct']=$m_sales->get_profit_by_invoice_detailed($start,$end,TRUE,FALSE,$customer_id);
                    $response['subtotal']=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,TRUE,$customer_id);

                }else if($invoice_type == 2){ //Charge Invoices
 
                    $response['data']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,FALSE,$agent_id,$customer_id);
                    $response['distinct']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,TRUE,FALSE,$agent_id,$customer_id);
                    $response['subtotal']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,TRUE,$agent_id,$customer_id);

                }else{ //Cash Invoices

                    $response['data']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,FALSE,$customer_id);
                    $response['distinct']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,TRUE,FALSE,$customer_id);
                    $response['subtotal']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,TRUE,$customer_id);

                }

                echo json_encode($response);
                break;     


                case'report-by-invoice-summary';
                $m_sales=$this->Profit_model;
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');

                if($invoice_type == 1){//All Invoices
                    $response['summary']=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,TRUE,$customer_id);
                }else if($invoice_type == 2){//Charge Invoices
                    $response['summary']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,TRUE,$agent_id,$customer_id); 
                }else{//Cash Invoices
                   $response['summary']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,TRUE,$customer_id);
                }

                    echo json_encode($response);
                break;           


                case'print-by-product';                
                $m_company=$this->Company_model;
                $m_customer=$this->Customers_model;

                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];

                $m_sales=$this->Profit_model;
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $type = $this->input->get('type');
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');


                if($type=='1'){

                    if($customer_id==0){
                        $data['customer_name'] = 'All Customers';
                    }else{
                        $data['customer_name'] = $m_customer->get_list($customer_id)[0]->customer_name;
                    }

                    if($invoice_type == 1){//All Invoices
                        $data['items']=$m_sales->get_profit_by_product($start,$end,$customer_id); 
                    }else if($invoice_type == 2){//Charge Invoices
                        $data['items']=$m_sales->get_profit_by_product_charge($start,$end,$agent_id,$customer_id); 
                    }else{//Cash Invoices
                        $data['items']=$m_sales->get_profit_by_product_cash($start,$end,$customer_id); //Cash Invoice
                    }
                    $this->load->view('template/profit_content',$data);
                }

                if($type=='2'){
                
                    if($invoice_type == 1){ //All Invoices

                        $data['items']=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,FALSE,$customer_id);
                        $data['distinct']=$m_sales->get_profit_by_invoice_detailed($start,$end,TRUE,FALSE,$customer_id);
                        $data['subtotal']=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,TRUE,$customer_id);

                    }else if($invoice_type == 2){ //Charge Invoices
     
                        $data['items']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,FALSE,$agent_id,$customer_id);
                        $data['distinct']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,TRUE,FALSE,$agent_id,$customer_id);
                        $data['subtotal']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,TRUE,$agent_id,$customer_id);

                    }else{ //Cash Invoices

                        $data['items']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,FALSE,$customer_id);
                        $data['distinct']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,TRUE,FALSE,$customer_id);
                        $data['subtotal']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,TRUE,$customer_id);

                    }

                    $this->load->view('template/profit_content_detailed',$data);
                }
                if($type=='3'){

                    if($invoice_type == 1){//All Invoices
                        $data['summary']=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,TRUE,$customer_id);
                    }else if($invoice_type == 2){//Charge Invoices
                        $data['summary']=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,TRUE,$agent_id,$customer_id); 
                    }else{//Cash Invoices
                       $data['summary']=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,TRUE,$customer_id);
                    }

                    $this->load->view('template/profit_content_summary',$data);
                }
                
                break;      


                case'export-by-product';
                $excel = $this->excel;
                $m_company=$this->Company_model;
                $m_customer=$this->Customers_model;

                $company_info=$m_company->get_list();
                $company_info=$company_info[0];
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');

                if($customer_id==0){
                    $customer_name = 'All Customers';
                }else{
                    $customer_name = $m_customer->get_list($customer_id)[0]->customer_name;
                }

                $m_sales=$this->Profit_model;

                if($invoice_type == 1){//All Invoices
                    $items = $m_sales->get_profit_by_product($start,$end,$customer_id);
                }else if($invoice_type == 2){//Charge Invoices
                    $items = $m_sales->get_profit_by_product_charge($start,$end,$agent_id,$customer_id); 
                }else{//Cash Invoices
                    $items = $m_sales->get_profit_by_product_cash($start,$end,$customer_id);
                }

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Profit Report by Product');
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

                $rettotal = 0;
                $gtotal = 0;
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

                    // $excel->getActiveSheet()->setCellValue('A5')
                    //                         ->mergeCells('A5:G5')
                    //                         ->getStyle('A5:G5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:I6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','Profit Report by Product')
                                            ->mergeCells('A6:I6')
                                            ->getStyle('A6:I6')->getFont()->setBold(True)
                                            ->setSize(14);

                    $excel->getActiveSheet()->setCellValue('A7','Customer : ')
                                            ->setCellValue('B7',$customer_name)
                                            ->getStyle('A7:B7')->getFont()->setBold(True);

                $i=8;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Period : '.$start.' - '.$end); $i++;

                            $excel->getActiveSheet()
                            ->getStyle('D'.$i.':'.'I'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,'Item Code')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Description')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'UM')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Qty Sold')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'SRP')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Unit Cost')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Gross')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Net Cost')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I'.$i,'Net Profit')
                                        ->getStyle('I'.$i)->getFont()->setBold(TRUE);


                $i++;

                $p_qty = 0;
                $p_gross = 0;
                $p_net_cost = 0;
                $p_net = 0;



                foreach ($items  as $value) {
                            $excel->getActiveSheet()
                            ->getStyle('D'.$i.':'.'I'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A'.$i,$value->product_code);
                $excel->getActiveSheet()->setCellValue('B'.$i,$value->product_desc);
                $excel->getActiveSheet()->setCellValue('C'.$i,$value->unit_name);
                $excel->getActiveSheet()->setCellValue('D'.$i,$value->qty_sold)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('E'.$i,$value->srp)->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('F'.$i,$value->purchase_cost)->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,$value->gross)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,$value->net_cost)->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('I'.$i,$value->net_profit)->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');
                $p_qty+=$value->qty_sold;
                $p_gross+=$value->gross;
                $p_net_cost+=$value->net_cost;
                $p_net+=$value->net_profit;
                $i++;


                }

                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'I'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'I'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL');
                $excel->getActiveSheet()->setCellValue('D'.$i,$p_qty)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,$p_gross)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,$p_net_cost)->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('I'.$i,$p_net)->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');





                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Profit Report by Product.xlsx".'');
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




                case'export-by-invoice-detailed';
                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');

                $m_sales=$this->Profit_model;

                if($invoice_type == 1){ //All Invoices

                    $data=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,FALSE,$customer_id);
                    $distinct=$m_sales->get_profit_by_invoice_detailed($start,$end,TRUE,FALSE,$customer_id);
                    $subtotal=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,TRUE,$customer_id);

                }else if($invoice_type == 2){ //Charge Invoices
 
                    $data=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,FALSE,$agent_id,$customer_id);
                    $distinct=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,TRUE,FALSE,$agent_id,$customer_id);
                    $subtotal=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,TRUE,$agent_id,$customer_id);

                }else{ //Cash Invoices

                    $data=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,FALSE,$customer_id);
                    $distinct=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,TRUE,FALSE,$customer_id);
                    $subtotal=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,TRUE,$customer_id);

                }

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Profit Report by Invoice');
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

                $rettotal = 0;
                $gtotal = 0;
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

                    // $excel->getActiveSheet()->setCellValue('A5')
                    //                         ->mergeCells('A5:G5')
                    //                         ->getStyle('A5:G5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:I6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','Profit Report by Invoice (Detailed)')
                                            ->mergeCells('A6:I6')
                                            ->getStyle('A6:I6')->getFont()->setBold(True)
                                            ->setSize(14);

                $i=8;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Period : '.$start.' - '.$end); $i++;


                $p_qty = 0;
                $p_gross = 0;
                $p_net_cost = 0;
                $p_net = 0;

                foreach ($distinct as $inv) {

                $excel->getActiveSheet()
                    ->getStyle('A'.$i.':'.'I'.$i)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('99ffff');

                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'I'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,$inv->inv_no)
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A'.$i.':'.'I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $i++;

                $excel->getActiveSheet()
                            ->getStyle('D'.$i.':'.'I'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,'Item Code')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Description')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'UM')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Qty Sold')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'SRP')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Unit Cost')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Gross')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Net Cost')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I'.$i,'Net Profit')
                                        ->getStyle('I'.$i)->getFont()->setBold(TRUE);

                $i++;

                foreach ($data as $value) {
                    if($value->identifier == $inv->identifier && $value->invoice_id == $inv->invoice_id ){
                                $excel->getActiveSheet()->getStyle('D'.$i.':'.'H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $excel->getActiveSheet()->setCellValue('A'.$i,$value->product_code);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$value->product_desc);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$value->unit_name);

                                $excel->getActiveSheet()->setCellValue('D'.$i,$value->inv_qty)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('E'.$i,$value->srp)->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('F'.$i,$value->purchase_cost)->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('G'.$i,$value->inv_gross)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('H'.$i,$value->net_cost)->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('I'.$i,$value->net_profit)->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $p_qty+=$value->inv_qty;
                                $p_gross+=$value->inv_gross;
                                $p_net_cost+=$value->net_cost;
                                $p_net+=$value->net_profit;
                        $i++;
                    }
                }
                     

                foreach ($subtotal as $sub) {
                    if($sub->identifier == $inv->identifier && $sub->invoice_id == $inv->invoice_id ){
                        $excel->getActiveSheet()
                        ->getStyle('D'.$i.':'.'I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()
                        ->getStyle('A'.$i.':'.'I'.$i)
                        ->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL ('.$sub->inv_no.')');
                        $excel->getActiveSheet()->setCellValue('D'.$i,$sub->qty_total)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                        $excel->getActiveSheet()->setCellValue('G'.$i,$sub->gross_total)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                        $excel->getActiveSheet()->setCellValue('H'.$i,$sub->net_cost_total)->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                        $excel->getActiveSheet()->setCellValue('I'.$i,$sub->profit_total)->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');
                        $i++;
                    }
                }

                $i++;


                }






                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'I'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'I'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'GRAND TOTAL');
                $excel->getActiveSheet()->setCellValue('D'.$i,$p_qty)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,$p_gross)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,$p_net_cost)->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('I'.$i,$p_net)->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');





                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Profit Report by Invoice Detailed.xlsx".'');
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


    case'export-by-invoice-summary';
                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];
                $start = date('Y-m-d',strtotime($this->input->get('start')));
                $end = date('Y-m-d',strtotime($this->input->get('end')));
                $invoice_type = $this->input->get('invoice_type');
                $agent_id = $this->input->get('agent_id');
                $customer_id = $this->input->get('customer_id');

                $m_sales=$this->Profit_model;

                if($invoice_type == 1){//All Invoices
                    $summary=$m_sales->get_profit_by_invoice_detailed($start,$end,FALSE,TRUE,$customer_id);
                }else if($invoice_type == 2){//Charge Invoices
                    $summary=$m_sales->get_profit_by_invoice_detailed_charge($start,$end,FALSE,TRUE,$agent_id,$customer_id); 
                }else{//Cash Invoices
                   $summary=$m_sales->get_profit_by_invoice_detailed_cash($start,$end,FALSE,TRUE,$customer_id);
                }

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Profit Report by Invoice');
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

                $rettotal = 0;
                $gtotal = 0;
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

                    // $excel->getActiveSheet()->setCellValue('A5')
                    //                         ->mergeCells('A5:G5')
                    //                         ->getStyle('A5:G5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:G6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','Profit Report by Invoice (Summary)')
                                            ->mergeCells('A6:G6')
                                            ->getStyle('A6:G6')->getFont()->setBold(True)
                                            ->setSize(14);

                $i=8;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Period : '.$start.' - '.$end); $i++;


                $p_qty = 0;
                $p_gross = 0;
                $p_net_cost = 0;
                $p_net = 0;

                $excel->getActiveSheet()
                            ->getStyle('D'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,'Invoice No')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Customer Name')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Date')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Qty Sold')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Gross')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Net Cost')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Net Profit')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);

                $i++;

                foreach ($summary as $value) {
                                $excel->getActiveSheet()->getStyle('D'.$i.':'.'H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $excel->getActiveSheet()->setCellValue('A'.$i,$value->inv_no);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$value->customer_name);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$value->date_invoice);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$value->qty_total)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('E'.$i,$value->gross_total)->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('F'.$i,$value->net_cost_total)->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                                $excel->getActiveSheet()->setCellValue('G'.$i,$value->profit_total)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');

                                $p_qty+=$value->qty_total;
                                $p_gross+=$value->gross_total;
                                $p_net_cost+=$value->net_cost_total;
                                $p_net+=$value->profit_total;
                        $i++;
                }
                


                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'H'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'GRAND TOTAL');
                $excel->getActiveSheet()->setCellValue('D'.$i,$p_qty)->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('E'.$i,$p_gross)->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('F'.$i,$p_net_cost)->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,$p_net)->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');





                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Profit Report by Invoice Summary.xlsx".'');
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
        }
    }
}


