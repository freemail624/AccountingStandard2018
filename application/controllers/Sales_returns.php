<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Sales_returns extends CORE_Controller
    {
        
        function __construct()
        {
            parent::__construct('');
            $this->validate_session();
            $this->load->model(
                array(
                    'Pos_item_returns_model',
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
	        $data['title'] = 'Sales Returns Report';

        $data['xreadings']=$this->Pos_item_returns_model->get_xreading();
        (in_array('3-8',$this->session->user_rights)? 
        $this->load->view('sales_returns_view',$data)
        :redirect(base_url('dashboard')));
            
        }

        function transaction($txn=null){
            switch($txn){
                case 'list':
					$x_id=$this->input->get('x_id',TRUE);
					$m_xreading=$this->Pos_item_returns_model;
					$response['data']=$m_xreading->get_list(array('x_reading_id'=>$x_id),
                        'pos_item_returns.*,products.product_desc',
                        array(array('products','products.product_id = pos_item_returns.product_id','left'))
                        );
					echo json_encode($response);

                break;

                case 'returns-list':
                    $m_returns=$this->Pos_item_returns_model;

                    $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                    $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));

                    $response['data']=$m_returns->get_sales_returns_from_date($start,$end);
                    echo json_encode($response);                    

                break;

                case 'pos-returns-for-review':
                $m_xreading=$this->Pos_item_returns_model;
                    $response['data']=$m_xreading->get_pos_returns_for_review();
                    echo json_encode($response);

                break;

                case 'export':

                $x_id=$this->input->get('id',TRUE);
                $m_xreading=$this->Pos_item_returns_model;

                $info=$m_xreading->get_xreading_filter($x_id);
                $products=$m_xreading->get_list(array('x_reading_id'=>$x_id),
                    'pos_item_returns.*,products.product_desc, DATE_FORMAT(CAST(pos_item_returns.start_datetime as DATE),"%m/%d/%Y") as trans_date',
                    array(array('products','products.product_id = pos_item_returns.product_id','left'))
                    );

                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle('Sales Returns');
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

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
                            ->getStyle('A5:H5')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A5','Sales Returns')
                                            ->mergeCells('A5:H5')
                                            ->getStyle('A5:H5')->getFont()->setBold(True)
                                            ->setSize(12);

                $i=6;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Sales Date : '.$info[0]->trans_date.' - Terminal '.$info[0]->terminal_id); $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Product')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Quantity')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Discount')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Vatable Sales')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Vat Amount')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Vat Excempt Sales')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Zero Rated')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Invoice Amount')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()
                            ->getStyle('B'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $i++;

                $total_discount_amount = 0;
                $total_vatable_sales = 0;
                $total_vat_amount = 0;
                $total_vat_exempt_sales = 0;
                $total_zero_rated_sales = 0;
                $total_item_total = 0;

                foreach ($products  as $value) {

                            $excel->getActiveSheet()
                            ->getStyle('B'.$i.':'.'H'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,$value->product_desc);
                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($value->product_quantity,0))->getStyle('B'.$i);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($value->discount_amount,2))->getStyle('C'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($value->vatable_sales,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($value->vat_amount,2))->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($value->vat_exempt_sales,2))->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($value->zero_rated_sales,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');
                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($value->item_total,2))->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');

                $total_discount_amount += $value->discount_amount;
                $total_vatable_sales += $value->vatable_sales;
                $total_vat_amount += $value->vat_amount;
                $total_vat_exempt_sales += $value->vat_exempt_sales;
                $total_zero_rated_sales += $value->zero_rated_sales;
                $total_item_total += $value->item_total;

                $i++;
                }

                $excel->getActiveSheet()
                ->getStyle('B'.$i.':'.'H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                ->getStyle('A'.$i.':'.'H'.$i)
                ->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('B'.$i,'TOTAL');
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($total_discount_amount,2))->getStyle('C'.$i)->getNumberFormat()->setFormatCode('0.00');

                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_vatable_sales,2))->getStyle('D'.$i)->getNumberFormat()->setFormatCode('0.00');

                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($total_vat_amount,2))->getStyle('E'.$i)->getNumberFormat()->setFormatCode('0.00');

                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($total_vat_exempt_sales,2))->getStyle('F'.$i)->getNumberFormat()->setFormatCode('0.00');

                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($total_zero_rated_sales,2))->getStyle('G'.$i)->getNumberFormat()->setFormatCode('0.00');

                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($total_item_total,2))->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00');


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Sales Returns (".$info[0]->trans_date." - Terminal ".$info[0]->terminal_id.").xlsx");
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