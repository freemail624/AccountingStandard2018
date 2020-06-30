<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Report_sales extends CORE_Controller
    {
        
        function __construct()
        {
            parent::__construct('');
            $this->validate_session();
            $this->load->model(
                array(
                    'Pos_item_sales_model',
                    'Users_model',
                    'Company_model'
                )
            );
            $this->load->library('excel');
            $this->load->model('Email_settings_model');
        }

		public function index()
		{	
			$this->Users_model->validate();
		 	$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Sales Report';

        $data['xreadings']=$this->Pos_item_sales_model->get_xreading();
        (in_array('3-9',$this->session->user_rights)? 
        $this->load->view('report_sales_view',$data)
        :redirect(base_url('dashboard')));
    
        }

        function transaction($txn=null){
            switch($txn){
                case 'list':

                    $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                    $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                    $m_xreading=$this->Pos_item_sales_model;
					$response['data']=$m_xreading->get_sales_from_date($start,$end);
					echo json_encode($response);

                break;


                case 'pos-sales-for-review':
                $m_xreading=$this->Pos_item_sales_model;
                    $response['data']=$m_xreading->get_pos_sales_for_review();
                    echo json_encode($response);

                break;

                case 'export':

                    $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                    $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                    $m_xreading=$this->Pos_item_sales_model;
                    $report_info=$m_xreading->get_sales_from_date($start,$end);

                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Sales Report');
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
                            ->getStyle('A5:H5')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A5','Sales Report')
                                            ->mergeCells('A5:H5')
                                            ->getStyle('A5:H5')->getFont()->setBold(True)
                                            ->setSize(12);

                $i=6;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Period : '.$start.' - '.$end); $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Item Code')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Description')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Qty Sold')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Purchase Cost')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Sale Price')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Invoice Total')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'On Hand Stocks')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Critical')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                            ->getStyle('C'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $i++;

                $total_sales = 0;
                foreach ($report_info  as $value) {
                            $excel->getActiveSheet()
                            ->getStyle('C'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A'.$i,$value->product_code);
                $excel->getActiveSheet()->setCellValue('B'.$i,$value->product_desc);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($value->product_quantity,0))->getStyle('C'.$i);
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($value->purchase_cost,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($value->sale_price,2))->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($value->item_total,2))->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($value->CurrentQty,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,$value->critical,2);
                $total_sales += $value->item_total;
                $i++;
                }

                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'H'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL');
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($total_sales,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report ".$start.' to '.$end.".xlsx");
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

                case 'export-all':

                    $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                    $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                    $m_xreading=$this->Pos_item_sales_model;
                    $report_info=$m_xreading->get_sales_from_date_all_products($start,$end);

                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Sales Report');
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
                            ->getStyle('A5:H5')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A5','Sales Report')
                                            ->mergeCells('A5:H5')
                                            ->getStyle('A5:H5')->getFont()->setBold(True)
                                            ->setSize(12);

                $i=6;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Period : '.$start.' - '.$end); $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Item Code')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Description')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Qty Sold')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Purchase Cost')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Sale Price')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Invoice Total')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'On Hand Stocks')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Critical')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                            ->getStyle('C'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $i++;

                $total_sales = 0;
                foreach ($report_info  as $value) {
                            $excel->getActiveSheet()
                            ->getStyle('C'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A'.$i,$value->product_code);
                $excel->getActiveSheet()->setCellValue('B'.$i,$value->product_desc);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($value->product_quantity,0))->getStyle('C'.$i);
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($value->purchase_cost,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($value->sale_price,2))->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($value->item_total,2))->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($value->CurrentQty,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,$value->critical,2);
                $total_sales += $value->item_total;
                $i++;
                }

                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'H'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL');
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($total_sales,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report ".$start.' to '.$end.".xlsx");
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

                case 'export-with-supplier':

                    $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                    $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                    $m_xreading=$this->Pos_item_sales_model;
                    $report_info=$m_xreading->get_sales_from_date($start,$end);

                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Sales Report');
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
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
                            ->getStyle('A5:H5')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A5','Sales Report')
                                            ->mergeCells('A5:H5')
                                            ->getStyle('A5:H5')->getFont()->setBold(True)
                                            ->setSize(12);

                $i=6;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Period : '.$start.' - '.$end); $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Supplier')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Item Code')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Description')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Qty Sold')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'On Hand Stocks')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Critical')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                            ->getStyle('D'.$i.':'.'E'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $i++;

                $total_sales = 0;
                foreach ($report_info  as $value) {
                $excel->getActiveSheet()->setCellValue('A'.$i,$value->supplier_name);
                $excel->getActiveSheet()->setCellValue('B'.$i,$value->product_code);
                $excel->getActiveSheet()->setCellValue('C'.$i,$value->product_desc);
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($value->product_quantity,0))->getStyle('C'.$i);
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($value->CurrentQty,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('F'.$i,$value->critical,2);
                $total_sales += $value->item_total;
                $i++;
                }

                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'E'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // $excel->getActiveSheet()
                // ->getStyle('A'.$i.':'.'H'.$i)
                // ->getFont()->setBold(TRUE);

                // $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL');
                // $excel->getActiveSheet()->setCellValue('F'.$i,number_format($total_sales,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report ".$start.' to '.$end.".xlsx");
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
?>