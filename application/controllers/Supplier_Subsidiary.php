<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Supplier_Subsidiary extends CORE_Controller 
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array
				(
					'Journal_account_model',
					'Journal_info_model',
					'Suppliers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
					'Customer_subsidiary_model',
					'Company_model',
                    'Account_integration_model'
				)
			);
        $this->load->library('excel');
        $this->load->library('M_pdf');
		}

		public function index() {
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);


	        $data['title'] = 'Supplier Subsidiary';
	        $data['suppliers'] = $this->Suppliers_model->get_list('is_deleted=FALSE AND supplier_name != "" AND is_active=TRUE',null,null,'supplier_name');
	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE',null,null,'account_title');

            $ap_account=$this->Account_integration_model->get_list();
            $data['ap_account']=$ap_account[0]->payable_account_id;
        (in_array('9-7',$this->session->user_rights)? 
        $this->load->view('supplier_subsidiary_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch($txn){
				case 'get-supplier-subsidiary':

					$supplier_Id=$this->input->get('supplierId',TRUE);
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_journal=$this->Journal_info_model;

					$response['data']=$m_journal->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
					echo json_encode($response);

				break;

				case 'get-supplier-subsidiary-all':
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_journal=$this->Journal_info_model;
	                $m_company_info=$this->Company_model;	
	               	$data['account'] = $this->Account_title_model->get_list($account_Id)[0];
	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];
					$suppliers = $this->Suppliers_model->get_list(array('is_active'=>true,'is_deleted'=>false));
					foreach ($suppliers as $supplier) {
						$responses[$supplier->supplier_id]=$m_journal->get_supplier_subsidiary($supplier->supplier_id,$account_Id,$start_Date,$end_Date);

					}

				$data['suppliers'] = $suppliers;
				$data['responses'] = $responses;
                $pdf = $this->m_pdf->load("A4-L");
                $content=$this->load->view('template/supplier_all_subsidiary_report',$data,TRUE);
                $pdf->WriteHTML($content);
                $pdf->Output();

				break;


				case 'get-supplier-subsidiary-all-export':
				$account_Id=$this->input->get('accountId',TRUE);
				$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
				$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
				$m_journal=$this->Journal_info_model;
                $m_company_info=$this->Company_model;	
               	$account = $this->Account_title_model->get_list($account_Id)[0];
                $company_info=$m_company_info->get_list();
				$suppliers = $this->Suppliers_model->get_list(array('is_active'=>true,'is_deleted'=>false));
				foreach ($suppliers as $supplier) {
					$responses[$supplier->supplier_id]=$m_journal->get_supplier_subsidiary($supplier->supplier_id,$account_Id,$start_Date,$end_Date);

				}
               
                $excel=$this->excel;
   

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')
                                        ->setAutoSize(false)
                                        ->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')
                                        ->setAutoSize(false)
                                        ->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('G')
                                        ->setAutoSize(false)
                                        ->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('H')
                                        ->setAutoSize(false)
                                        ->setWidth('15');

                $excel->getActiveSheet()->setTitle('SUPPLIER SUBSIDIARY');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);


                 $excel->getActiveSheet()->setCellValue('A6','Supplier Detailed Subsidiary')
                 						->setCellValue('A7','ACCOUNT: '.$account->account_no.' - '.$account->account_title)
                                        ->setCellValue('A8','PERIOD: '.$this->input->get('startDate',TRUE).' to '.$this->input->get('endDate',TRUE));                       


				$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold( true );
            $i = 9;
 			$count = 0; foreach ($suppliers as $supplier) { 
	 						if(!empty($responses[$supplier->supplier_id])){
	 							$excel->getActiveSheet()->setCellValue('A'.$i,$supplier->supplier_name)->mergeCells('A'.$i.':H'.$i);
	 							$excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()
                                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                            ->getStartColor()->setARGB('00ffec');
	 								$i++;
	         						$excel->getActiveSheet()->setCellValue('A'.$i,'Txn Date')
	         						->setCellValue('B'.$i,'Txn #')
	         						->setCellValue('C'.$i,'Memo')
	         						->setCellValue('D'.$i,'Remarks')
	         						->setCellValue('E'.$i,'Posted by')
	         						->setCellValue('F'.$i,'Debit')
	         						->setCellValue('G'.$i,'Credit')
	         						->setCellValue('H'.$i,'Balance');
	         						$excel->Align_right('F',$i);
	         						$excel->Align_right('G',$i);
	         						$excel->Align_right('H',$i);
	         						$excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFont()->setBold( true );
	         							
	   							foreach($responses[$supplier->supplier_id] as $items) { 
	   								$i++;
	   								$excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn)
	         						->setCellValue('B'.$i,$items->txn_no)
	         						->setCellValue('C'.$i,$items->memo)
	         						->setCellValue('D'.$i,$items->remarks)
	         						->setCellValue('E'.$i,$items->posted_by)
	         						->setCellValue('F'.$i,$items->debit)
	         						->setCellValue('G'.$i,$items->credit)
	         						->setCellValue('H'.$i,$items->balance);
	         						$excel->Align_right('F',$i);
	         						$excel->Align_right('G',$i);
	         						$excel->Align_right('H',$i);
	         						$excel->getActiveSheet()->getStyle('F'.$i.':H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
	         						$count++; 
	         					
	         					}  
      						} // END IF 
      						$i++;
					    }  // END FOREACH
					  if($count == 0){}

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Supplier Detailed Subsidiary.xlsx"');
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