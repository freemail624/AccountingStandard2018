<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class X_reading_report extends CORE_Controller
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
	        $data['title'] = 'X Reading Report';

        $data['xreadings']=$this->Pos_item_sales_model->get_xreading();
        (in_array('3-9',$this->session->user_rights)? 
        $this->load->view('x_reading_report_view',$data)
        :redirect(base_url('dashboard')));
            
        }

        function transaction($txn=null){
            switch($txn){
                case 'list':

					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                    $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$x_id=$this->input->get('x_id',TRUE);
					$m_xreading=$this->Pos_item_sales_model;

                    if($x_id == null || ""){
                        $x_id = 0;
                    }

					$response['data']=$m_xreading->get_x_reading_sales($x_id);
					echo json_encode($response);

                break;


                case 'pos-sales-for-review':
                $m_xreading=$this->Pos_item_sales_model;
                    $response['data']=$m_xreading->get_pos_sales_for_review();
                    echo json_encode($response);

                break;

                case 'export':
                $x_id=$this->input->get('x_id',TRUE);
                $m_xreading=$this->Pos_item_sales_model;

                $report_sales=$m_xreading->get_x_reading_sales($x_id);
                $x_reading_info = $this->Pos_item_sales_model->get_xreading($x_id)[0];

                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('X Reading Report');
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

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

                $excel->getActiveSheet()
                        ->getStyle('A5:K5')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->setCellValue('A5','X Reading Report')
                                        ->mergeCells('A5:K5')
                                        ->getStyle('A5:K5')->getFont()->setBold(True)
                                        ->setSize(12);

                $i=6;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Sales Date - '.$x_reading_info->trans_date.', Terminal '.$x_reading_info->terminal_id.', X Reading ID '.$x_reading_info->x_reading_id); $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Item Code')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Description')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Purchase Cost')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Sale Price')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Qty Sold')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Discount')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Vatable Sales')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Vat Amount')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I'.$i,'Vat Exempt')
                                        ->getStyle('I'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('J'.$i,'Zero Rated')
                                        ->getStyle('J'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('K'.$i,'Invoice Amount')
                                        ->getStyle('K'.$i)->getFont()->setBold(TRUE);

                            $excel->getActiveSheet()
                            ->getStyle('C'.$i.':'.'K'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $i++;

                $total_discount = 0;
                $total_vatable = 0;
                $total_vat = 0;
                $total_exempt = 0;
                $total_zero = 0;
                $total_invoice  = 0;
                foreach ($report_sales  as $value) {
                            $excel->getActiveSheet()
                            ->getStyle('C'.$i.':'.'K'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()->setCellValue('A'.$i,$value->product_code);
                $excel->getActiveSheet()->setCellValue('B'.$i,$value->product_desc);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($value->purchase_cost,2))->getStyle('C'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($value->sale_price,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($value->product_quantity,0));
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($value->discount_amount,2))->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($value->vatable_sales,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($value->vat_amount,2))->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($value->vat_exempt_sales,2))->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('J'.$i,number_format($value->zero_rated_sales,2))->getStyle('J'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('K'.$i,number_format($value->item_total,2))->getStyle('K'.$i)->getNumberFormat()->setFormatCode('0.00');
                $total_discount += $value->discount_amount;
                $total_vatable  += $value->vatable_sales;
                $total_vat += $value->vat_amount;
                $total_exempt += $value->vat_exempt_sales;
                $total_zero += $value->zero_rated_sales;
                $total_invoice  += $value->item_total;

                $i++;
                }

                $excel->getActiveSheet()
                ->getStyle('D'.$i.':'.'K'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'K'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL');
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($total_discount,2))->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($total_vatable,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($total_vat,2))->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($total_exempt,2))->getStyle('I'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('J'.$i,number_format($total_zero,2))->getStyle('J'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('K'.$i,number_format($total_invoice,2))->getStyle('K'.$i)->getNumberFormat()->setFormatCode('0.00');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Report.xlsx");
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