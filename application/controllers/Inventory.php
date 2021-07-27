<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CORE_Controller
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
        $data['title'] = 'Inventory Report';

        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        
        (in_array('15-4',$this->session->user_rights)? 
        $this->load->view('inventory_report_view',$data)
        :redirect(base_url('dashboard')));
    }



    public function transaction($txn=null){
        switch($txn){
            case 'get-inventory':
                $m_products = $this->Products_model;
                
                $is_parent = $this->input->post('is_parent', TRUE);
                $is_nonsalable = $this->input->post('is_nonsalable', TRUE);
                $pick_list = $this->input->post('pick_list', TRUE);
                $item_type_id = $this->input->post('item_type_id', TRUE);
                $product_id = $this->input->post('product_id', TRUE);
                $supplier_id = $this->input->post('supplier_id', TRUE);
                $category_id = $this->input->post('category_id', TRUE);
                $draw = $this->input->post('draw', TRUE);
                $search =  $this->input->post('search', TRUE);
                $length = $this->input->post('length', TRUE);
                $start = $this->input->post('start', TRUE);
                $order = $this->input->post('order', TRUE);
                $search_value = $search['value'];
                $column = $order[0]['column'];
                $order_dir = $order[0]['dir'];
                $is_fast_moving = $this->input->post('is_fast_moving', TRUE);

                $valid_columns = array(
                    0=>'details-control',
                    1=>'product_code',
                    2=>'product_desc',
                    3=>'quantity_in',
                    4=>'quantity_out',
                    5=>'productmain.total_qty_balance',
                    6=>'total_qty_bulk'
                );

                $order_column = $valid_columns[$column];

                if($column == 0){
                    $order_column = null;
                }

                $ccf = null;
                $date = date('Y-m-d',strtotime($this->input->post('date',TRUE)));
                $depid = $this->input->post('depid',TRUE);
                $currentcountfilter = $this->input->post('ccf',TRUE);

                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $account_cii =$a_i[0]->cash_invoice_inventory; // Cash Invoice 
                $account_dis =$a_i[0]->dispatching_invoice_inventory; // Cash Invoice 

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
            
                $recordsTotal = $m_products->get_all_data($item_type_id);
                $recordsFiltered = $m_products->get_all_data($item_type_id,$search_value,$is_fast_moving);

                if($length == null){
                    $length_value = $recordsTotal;
                }else{
                    $length_value = $length;
                }

                $data=$m_products->product_list(
                    $account, 
                    $date, 
                    $product_id,
                    $supplier_id, 
                    $category_id, 
                    $item_type_id, 
                    $pick_list, 
                    $depid, 
                    $account_cii,
                    $account_dis, 
                    $currentcountfilter,
                    $is_parent,
                    $is_nonsalable, 
                    $search_value, 
                    $length_value, 
                    $start,
                    $order_column,
                    $order_dir,
                    $is_fast_moving);

                $response = array(
                    "draw"            => intval($draw),
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsFiltered,
                    "data"            => $data
                );

                echo json_encode($response);
                exit();

                break;

            case 'preview-inventory-with-total':
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}
                $info = $m_department->get_department_list($depid);
                $data['products']=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf,1);
                // $data['products'] = $m_products->get_product_list_inventory($date,$depid,$account);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $data['department'] =$info[0]->department_name;
                }else{
                    $data['department'] = 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $this->load->view('template/batch_inventory_report_with_total',$data);
                break;


            case 'new-export-inventory':
                $this->load->view('template/elements/xlsxwriter.class.php', '', true);

                $filename = "Inventory Report ".date('M-d-Y',NOW()).".xlsx";
                header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
                header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');

                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;
                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $length = $m_products->get_all_data(1);
                $offset = 0;

                $products=$m_products->product_list(
                        $account, 
                        $date, 0, 0, 0, 1, FALSE,
                        $depid, 
                        $ci_account,
                        $account_dis, 
                        $currentcountfilter, 0, 0, null, 
                        $length, 
                        $offset, null, null);

                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department= 'All';
                }

                $writer = new XLSXWriter();

                $styles2 = array( 'font'=>'Calibri','font-size'=>11);
                $title=array(
                    'Product Code'=>'string', 
                    'Description'=>'string', 
                    'Quantity In'=>'0.00', 
                    'Quantity Out'=>'0.00', 
                    'Balance'=>'0.00');
                $sheet1="sheet1";

                $styles1=array ("font" =>"Calibri", 
                                "font-size" =>11, 
                                "font-style" =>"bold", 
                                "fill" =>"#eee",
                                "halign" =>["left","left","right","right","right"], 
                                "border" =>"left, right, top, bottom",
                                "widths"=>[20,40,15,15,20]
                            );

                $writer->writesheetheader ($sheet1, $title, $styles1);

                foreach($products as $product)
                {
                    $writer->writeSheetRow($sheet1, 
                        array(
                            $product->product_code,
                            $product->product_desc,
                            $product->quantity_in,
                            $product->quantity_out,
                            $product->total_qty_balance
                        ),
                        $styles2
                    );
                }

                $writer->writetostdout();
                exit(0);
                break;

            case 'export-inventory':

                $excel = $this->excel;
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;
                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}

                $products=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf,1);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department= 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                // $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
    
                $excel->getActiveSheet()
                        ->getStyle('C9:E9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:E9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','PLU')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Description')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Quantity In')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Quantity Out')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Balance')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                // $excel->getActiveSheet()->setCellValue('F9','Bulk Balance')
                //                         ->getStyle('F9')->getFont()->setBold(TRUE);

                $i=10;

                foreach($products as $product){
                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                        // $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()
                                ->getStyle('C'.$i.':F'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->product_desc);

                        $excel->getActiveSheet()->getStyle('C'.$i.':F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('C'.$i,number_format($product->quantity_in,2));
                        $excel->getActiveSheet()->setCellValue('D'.$i,number_format($product->quantity_out,2));
                        $excel->getActiveSheet()->setCellValue('E'.$i,number_format($product->total_qty_balance,2).' '.$product->parent_unit_name);
                        // $excel->getActiveSheet()->setCellValue('F'.$i,number_format($product->total_qty_bulk,2).' '.$product->product_unit_name);
                        $i++;                  
                }
                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'E'.$i)->applyFromArray( $style_header );

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

                // $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, $excel->sFileFormat);
                //echo "Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB";exit;
                $objWriter->save('php://output');            
                     
            break;

            case 'export-inventory-with-total':

                $excel = $this->excel;
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;
                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);

                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}


                $products=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf,1);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department= 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('30');
    
    
                $excel->getActiveSheet()
                        ->getStyle('E9:J9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:J9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','PLU')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Description')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Category')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Unit')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Quantity In')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Quantity Out')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Balance')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Bulk Balance')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Unit Cost')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('J9','Total')
                                        ->getStyle('J9')->getFont()->setBold(TRUE);

                $i=10;
                $gtotal=0;
                foreach($products as $product){
                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()
                                ->getStyle('E'.$i.':J'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->product_desc);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$product->category_name);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$product->product_unit_name);


                        $excel->getActiveSheet()->getStyle('E'.$i.':J'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                                         
                        $excel->getActiveSheet()->setCellValue('E'.$i,number_format($product->quantity_in,2));      
                        $excel->getActiveSheet()->setCellValue('F'.$i,number_format($product->quantity_out,2));
                        $excel->getActiveSheet()->setCellValue('G'.$i,number_format($product->total_qty_balance,2));
                        $excel->getActiveSheet()->setCellValue('H'.$i,number_format($product->total_qty_bulk,2)); 
                        $excel->getActiveSheet()->setCellValue('I'.$i,number_format($product->purchase_cost,2)); 
                        $excel->getActiveSheet()->setCellValue('J'.$i,number_format((round($product->purchase_cost,2) * round($product->total_qty_bulk,2)),2));



                        $gtotal += (round($product->purchase_cost,2) * round($product->total_qty_bulk,2));
                        $i++;                  
                }

                        $excel->getActiveSheet()->setCellValue('A'.$i,'Grand Total');
                        $excel->getActiveSheet()->setCellValue('J'.$i,number_format($gtotal,2));
                        $excel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');


                $excel->getActiveSheet()
                        ->getStyle('J'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('J'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()
                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);

                        $i++;


                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'J'.$i)->applyFromArray( $style_header );

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
                     
            break;

            case 'email-inventory':

                $excel = $this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}

                $products=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf,1);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department = 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                // $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
    
                $excel->getActiveSheet()
                        ->getStyle('C9:E9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:F9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','PLU')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Description')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Quantity In')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Quantity Out')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Balance')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                // $excel->getActiveSheet()->setCellValue('F9','Bulk Balance')
                //                         ->getStyle('F9')->getFont()->setBold(TRUE);

                $i=10;

                foreach($products as $product){
                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                        // $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()
                                ->getStyle('C'.$i.':E'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->product_desc);

                        $excel->getActiveSheet()->getStyle('C'.$i.':F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                        $excel->getActiveSheet()->setCellValue('C'.$i,number_format($product->quantity_in,2));
                        $excel->getActiveSheet()->setCellValue('D'.$i,number_format($product->quantity_out,2));
                        $excel->getActiveSheet()->setCellValue('E'.$i,number_format($product->total_qty_balance,2).' '.$product->parent_unit_name);
                        // $excel->getActiveSheet()->setCellValue('F'.$i,number_format($product->total_qty_bulk,2).' '.$product->product_unit_name);
                        $i++;                  
                }
                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'E'.$i)->applyFromArray( $style_header );

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

                            $file_name='Inventory Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Inventory Report';
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