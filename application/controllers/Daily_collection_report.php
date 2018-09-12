<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Daily_collection_report extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Departments_model',
					'Company_model'
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
	        $data['title'] = 'Revolving Fund Monitor';
	        $data['departments']=$this->Departments_model->get_list(array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE));

        (in_array('14-4',$this->session->user_rights)? 
        $this->load->view('daily_collection_report_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch ($txn) {
				case 'list':
					$m_journal=$this->Journal_info_model;

					$date=date('Y-m-d',strtotime($this->input->get('date',TRUE)));
					$department=$this->input->get('dep',TRUE);
					if($department == '1'){ $department = null; }
					$bal = $m_journal->get_revolving_fund_balance($date,$department);
					$response['carf'] = $m_journal->get_revolving_fund_carf($date,$department);
					$response['collection'] = $m_journal->get_revolving_fund_collection($date,$department);
					$response['balance']=$bal[0]->Balance;

					echo json_encode($response);
				break;

				case 'report':
					$m_company=$this->Company_model;
					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];
					$m_journal=$this->Journal_info_model;
					$date=date('Y-m-d',strtotime($this->input->get('date',TRUE)));
					$department=$this->input->get('dep',TRUE);
					$department_info = $this->Departments_model->get_list($department);
					if($department == '1'){ $department = null; }
					$data['department_name'] = $department_info[0]->department_name;
					$bal = $m_journal->get_revolving_fund_balance($date,$department);
					$data['carf'] = $m_journal->get_revolving_fund_carf($date,$department);
					$data['collection'] = $m_journal->get_revolving_fund_collection($date,$department);
					$data['balance']=$bal[0]->Balance;
					$data['out_summary'] = $m_journal->get_revolving_fund_summary($is_carf_collection = false,$date,$department);
					$data['in_summary'] = $m_journal->get_revolving_fund_summary($is_carf_collection = true,$date,$department);

					$this->load->view('template/daily_collection_report_content',$data);
				break;

	case 'export-daily-collection':
                $excel=$this->excel;
				$m_company=$this->Company_model;
				$company_info=$m_company->get_list();
				$data['company_info']=$company_info[0];

				$m_journal=$this->Journal_info_model;

				$date=date('Y-m-d',strtotime($this->input->get('date',TRUE)));
				$department=$this->input->get('dep',TRUE);

				$department_info = $this->Departments_model->get_list($department);
				if($department == '1'){ $department = null; }

				$department_name = $department_info[0]->department_name;

				$bal = $m_journal->get_revolving_fund_balance($date,$department);
				$carf = $m_journal->get_revolving_fund_carf($date,$department);
				$collection = $m_journal->get_revolving_fund_collection($date,$department);
				$beginning_balance=$bal[0]->Balance;
				$out_summary = $m_journal->get_revolving_fund_summary($is_carf_collection = false,$date,$department);
				$in_summary = $m_journal->get_revolving_fund_summary($is_carf_collection = true,$date,$department);



                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('25');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Revolving Fund Monitor");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                						->setCellValue('A2',$company_info[0]->company_address)
                						->setCellValue('A3',$company_info[0]->email_address)
                						->setCellValue('A4',$company_info[0]->mobile_no);

               	$i = 6;

				$excel->getActiveSheet()
                        ->mergeCells('A'.$i.':E'.$i)
                        ->setCellValue('A'.$i, 'Revolving Fund Monitor as of '.$date)
                        ->getStyle('A'.$i.':E'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$i++;
				$excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Department: ');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('E'.$i,$department_name);
				$i++;

				$excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Date');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('E'.$i,$date);
				$i++;

				$excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Beginning Balance');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('E'.$i,number_format($beginning_balance,2));
				$excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
				$i++;
				$i++;

				$excel->getActiveSheet()
                        ->mergeCells('A'.$i.':E'.$i)
                        ->setCellValue('A'.$i, 'Add : Collection')
                        ->getStyle('A'.$i.':E'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);

				$i++;

				$excel->getActiveSheet()->setCellValue('A'.$i,'Particular');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('B'.$i,'Receipt No');
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('C'.$i,'Payment Type');
				$excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('D'.$i,'Transaction No');
				$excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('E'.$i,'Amount');
				$excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);

 				$i++;

 				$total_collection = 0;
 				foreach ($collection as $collection) {
 				$total_collection += $collection->collection_amount;
                $excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()->setCellValue('A'.$i,$collection->supplier_name);
	                $excel->getActiveSheet()->setCellValue('B'.$i,$collection->or_no);
	                $excel->getActiveSheet()->setCellValue('C'.$i,$collection->payment_method);
	                $excel->getActiveSheet()->setCellValue('D'.$i,$collection->txn_no);
					$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($collection->collection_amount,2));
	              $i++;
				}
				$excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('D'.$i,'Total');
				$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	            $excel->getActiveSheet()->setCellValue('E'.$i,number_format($total_collection,2));
				$i++;

				$i++;
				$excel->getActiveSheet()
                        ->mergeCells('A'.$i.':E'.$i)
                        ->setCellValue('A'.$i, 'Less : Out')
                        ->getStyle('A'.$i.':E'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);

	    		  $i++;
	    		 $excel->getActiveSheet()->setCellValue('A'.$i,'Particular');
	    		 $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()->setCellValue('B'.$i,'Transaction Type');
                 $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
	    		 $excel->getActiveSheet()->setCellValue('C'.$i,'Payment Type');
                 $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(TRUE);
	    		 $excel->getActiveSheet()->setCellValue('D'.$i,'Transaction No');
                 $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
	    		 $excel->getActiveSheet()->setCellValue('E'.$i,'Amount');
	    		 $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
	    		 $i++;
	    		 $total_carf = 0;
 				foreach ($carf as $carf) {
 					$total_carf += $carf->carf_amount;
                	$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()->setCellValue('A'.$i,$carf->supplier_name);
	                $excel->getActiveSheet()->setCellValue('B'.$i,$carf->carf_trans_name);
	                $excel->getActiveSheet()->setCellValue('C'.$i,$carf->payment_method);
	                $excel->getActiveSheet()->setCellValue('D'.$i,$carf->txn_no);
					$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($carf->carf_amount,2));
	              $i++;
				}
				$excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('D'.$i,'Total');
				$excel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	            $excel->getActiveSheet()->setCellValue('E'.$i,number_format($total_carf,2));
				$i++;$i++;

				$ending_balance = $beginning_balance + $total_collection - $total_carf;

				$excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Daily Balance');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('E'.$i,number_format($ending_balance,2));
				$excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(TRUE);
				$i++;
				$i++;
				$i++;

				$excel->getActiveSheet()
                        ->mergeCells('A'.$i.':B'.$i)
                        ->setCellValue('A'.$i, 'Revolving Fund Monitor Summary as of '.$date)
                        ->getStyle('A'.$i.':B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$i++;
				$excel->getActiveSheet()->setCellValue('A'.$i,'Department: ');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('B'.$i,$department_name);
				$i++;
				$excel->getActiveSheet()->setCellValue('A'.$i,'Date');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('B'.$i,$date);
				$i++;
				$excel->getActiveSheet()->setCellValue('A'.$i,'Beginning Balance');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('B'.$i,number_format($beginning_balance,2));
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$i++;
				$i++;


				$excel->getActiveSheet()
                        ->mergeCells('A'.$i.':B'.$i)
                        ->setCellValue('A'.$i, 'Add : Collection')
                        ->getStyle('A'.$i.':B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);

				$i++;
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Payment Method');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('B'.$i,'Amount');
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$i++;
 				foreach ($in_summary as $in_summary) {
 					$total_in_summary += $in_summary->dr_amount;
                	$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()->setCellValue('A'.$i,$in_summary->payment_method);
					$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($in_summary->dr_amount,2));
	              $i++;
				}

				$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Total');
				$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	            $excel->getActiveSheet()->setCellValue('B'.$i,number_format($total_in_summary,2));
				$i++;$i++;



				$excel->getActiveSheet()
                        ->mergeCells('A'.$i.':B'.$i)
                        ->setCellValue('A'.$i, 'Less : (Out)')
                        ->getStyle('A'.$i.':B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);

				$i++;
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Payment Method');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('B'.$i,'Amount');
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$i++;
 				foreach ($out_summary as $out_summary) {
 					$total_out_summary += $out_summary->cr_amount;
                	$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()->setCellValue('A'.$i,$out_summary->payment_method);
					$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($out_summary->cr_amount,2));
	              $i++;
				}

				$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->setCellValue('A'.$i,'Total');
				$excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	            $excel->getActiveSheet()->setCellValue('B'.$i,number_format($total_out_summary,2));
				$i++;$i++;

				$ending_balance_summary = $beginning_balance + $total_in_summary - $total_out_summary;
				$excel->getActiveSheet()->setCellValue('A'.$i,'Daily Balance');
				$excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
				$excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$excel->getActiveSheet()->setCellValue('B'.$i,number_format($ending_balance_summary,2));
				$excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(TRUE);
				$i++;
				$i++;
				$i++;
                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Revolving Fund Monitor.xlsx".'');
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