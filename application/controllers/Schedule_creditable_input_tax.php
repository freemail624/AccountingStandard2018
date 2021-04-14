<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_creditable_input_tax extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Months_model');
        $this->load->model('Bir_2307_model');
        $this->load->model('Company_model');
        $this->load->model('Departments_model');
        $this->load->model('Account_integration_model');
        $this->load->library('excel');
        $this->load->library('M_pdf');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['months']=$this->Months_model->get_list();
        $data['title'] = 'Certificate of Creditable Tax';

        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        (in_array('17-4',$this->session->user_rights)? 
        $this->load->view('schedule_of_creditable_input_tax_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_form_2307 = $this->Bir_2307_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                $department_id = $this->input->get('department_id', TRUE);

                if($month == 0){$month = null;}
                // $response['data'] = $m_form_2307->get_2307_list($month,$year);

                $account = $this->Account_integration_model->get_list();
                $account_id = $account[0]->input_tax_account_id;

                $response['data'] = $m_form_2307->get_creditable_input_tax($department_id,$month,$year,$account_id);
                echo json_encode($response);
                break;


            case 'print-list':
                $m_form_2307 = $this->Bir_2307_model;
                $month_id = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                $department_id = $this->input->get('department_id', TRUE);

                $account = $this->Account_integration_model->get_list();
                $account_id = $account[0]->input_tax_account_id;


                $data['month'] = $this->Months_model->get_list($month_id,'month_name')[0];

                if($department_id == 'all'){
                    $data['department_name'] = 'All';
                }else{
                    $data['department_name'] = $this->Departments_model->get_list($department_id,'department_name')[0];
                }

                if($month_id == 0){$month_id = null;}
                $data['items'] = $m_form_2307->get_creditable_input_tax($department_id,$month_id,$year,$account_id);
                $data['company_info']=$this->Company_model->get_list()[0];
                $data['month_id']=$month_id;

                $file_name='Schedule of Creditable Input Tax Report';
                $pdfFilePath = $file_name.".pdf";
                $pdf = $this->m_pdf->load(); 
                $pdf->AddPage('L');
                $content =  $this->load->view('template/input_tax_content',$data,TRUE);
                $pdf->SetTitle('Schedule of Creditable Input Tax Report');
                $pdf->WriteHTML($content);
                $pdf->Output();
                
                break;

            case 'export-list':

                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $m_form_2307 = $this->Bir_2307_model;

                $month_id = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                $department_id = $this->input->get('department_id', TRUE);

                $company_info=$m_company_info->get_list();

                if($month_id == 0){$month_id = null;}
                // $data = $m_form_2307->get_2307_list($month_id,$year);     
                $month = $this->Months_model->get_list($month_id,'month_name');               

                $account = $this->Account_integration_model->get_list();
                $account_id = $account[0]->input_tax_account_id;

                if($department_id == 'all'){
                    $department_name = 'All';
                }else{
                    $department_name = $this->Departments_model->get_list($department_id,'department_name')[0]->department_name;
                }

                $items = $m_form_2307->get_creditable_input_tax($department_id,$month_id,$year,28);

                if($month_id == 0 || null){  
                    $filename = 'Schedule of Creditable Input Tax - ('.$year.').xlsx';
                }else{
                    $filename = 'Schedule of Creditable Input Tax - ('.$month[0]->month_name.' '.$year.').xlsx';
                }

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('20');

                //name the worksheet
                $excel->getActiveSheet()->setTitle($month[0]->month_name.' '.$year);
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                // $excel->getActiveSheet()->mergeCells('A1:D1');
                // $excel->getActiveSheet()->mergeCells('A2:D2');
                // $excel->getActiveSheet()->mergeCells('A3:D3');
                // $excel->getActiveSheet()->mergeCells('A4:D4');

                $bottom_header = array(
                  'borders' => array(               
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );                                                

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->registered_to)
                                        ->setCellValue('A2',substr($company_info[0]->tin_no,0, 3).'-'.
                                                            substr($company_info[0]->tin_no,3, 3).'-'.
                                                            substr($company_info[0]->tin_no,6, 3).'-'.
                                                            substr($company_info[0]->tin_no,9, 3))
                                        ->setCellValue('A3','SCHEDULE OF CREDITABLE INPUT TAX')
                                        ->setCellValue('A4','FOR THE MONTH OF'.$month[0]->month_name.' '.$year);                           
                // $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                // $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                // $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
                // $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('K')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('L')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('M')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('N')->setWidth('20');
                // $excel->getActiveSheet()->getColumnDimension('O')->setWidth('20');

                // $style_header = array(
                //     'font' => array(
                //         'bold' => true,
                //     )
                // );

                // $excel->getActiveSheet()->getStyle('A6:06')->applyFromArray( $style_header );

                $top = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );                                                                           

                $excel->getActiveSheet()->getStyle('A6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('B6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('C6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('D6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('E6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('F6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('G6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('H6')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('I6')->applyFromArray($top);  
                $excel->getActiveSheet()->getStyle('J6')->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('K6')->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('L6')->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('M6')->applyFromArray($top);    
                $excel->getActiveSheet()->getStyle('N6')->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('O6')->applyFromArray($top);                          

                $excel->getActiveSheet()
                        ->getStyle('A6:G6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('H6:K6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

                $excel->getActiveSheet()
                        ->getStyle('L6:M6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('N6:O6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // $excel->getActiveSheet()
                //         ->getStyle('A6:06')
                //         ->getAlignment()
                //         ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


                $excel->getActiveSheet()->setCellValue('A6','DATE')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B6','TIN #')
                                        ->getStyle('B6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C6','SUPPLIER NAME')
                                        ->getStyle('C6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D6','OR #')
                                        ->getStyle('D6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E6','ADDRESS')
                                        ->getStyle('E6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F6','INCOME CENTER')
                                        ->getStyle('F6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G6','DESCRIPTION')
                                        ->getStyle('G6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H6','PURCHASES SUBJ TO VAT')
                                        ->getStyle('H6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('I6','VAT EXEMPT PURCHASES')
                                        ->getStyle('I6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('J6','INPUT TAX')
                                        ->getStyle('J6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('K6','GROSS TAXABLE')
                                        ->getStyle('K6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('L6','ATC')
                                        ->getStyle('L6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('M6','Nature of Income')
                                        ->getStyle('M6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('N6','Tax Rate')
                                        ->getStyle('N6')->getFont()->setBold(TRUE);   
                $excel->getActiveSheet()->setCellValue('O6','Tax Withheld')
                                        ->getStyle('O6')->getFont()->setBold(TRUE);                                                                                    
                $i=7;

                // $total_amount_tax_based = 0;
                // $total_tax_withheld = 0;

                foreach ($items as $row) {

                // $total_amount_tax_based += $row->gross_amount;
                // $total_tax_withheld += $row->deducted_amount;
                
                $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $sides = array(
                  'borders' => array(
                    'right' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                    'left' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );   

                $excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($sides);  
                $excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($sides);   
                $excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($sides);   
                $excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($sides);   
                $excel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($sides);    
                $excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($sides);   
                $excel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($sides);  

                unset($sides);



                $tin_no="";
                if ($row->tin_no != "" || null){
                    $tin_no = substr($row->tin_no,0, 3).'-'.
                              substr($row->tin_no,3, 3).'-'.
                              substr($row->tin_no,6, 3).'-'.
                              substr($row->tin_no,9, 3);
                }

                $excel->getActiveSheet()->setCellValue('A'.$i,$row->date_txn)
                                        ->setCellValue('B'.$i,$tin_no)
                                        ->setCellValue('C'.$i,$row->particular)
                                        ->setCellValue('D'.$i,$row->ref_no)
                                        ->setCellValue('E'.$i,$row->address)
                                        ->setCellValue('F'.$i,$row->department_name)
                                        ->setCellValue('G'.$i,$row->remarks)
                                        ->setCellValue('H'.$i,number_format($row->net_vat,2))
                                        ->setCellValue('I'.$i,number_format(0,2))
                                        ->setCellValue('J'.$i,number_format($row->input_tax,2))
                                        ->setCellValue('K'.$i,number_format($row->gross_taxable,2))
                                        ->setCellValue('L'.$i,$row->atc)
                                        ->setCellValue('M'.$i,$row->description)
                                        ->setCellValue('N'.$i,number_format($row->tax_rate,2))
                                        ->setCellValue('O'.$i,number_format($row->deducted_amount,2));    


                $excel->getActiveSheet()->getStyle('H'.$i.':K'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('N'.$i.':O'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  

                $excel->getActiveSheet()
                        ->getStyle('A'.$i.':G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('H'.$i.':K'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

                $excel->getActiveSheet()
                        ->getStyle('L'.$i.':M'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('N'.$i.':O'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                                                      
                $i++;
                }

                $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $sides = array(
                  'borders' => array(
                    'right' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                    'left' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );         

                $top = array(
                  'borders' => array(
                    'top' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($top);  
                $excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($top);    
                $excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($top);   
                $excel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($top); 
                // $excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($styleArray);
                // unset($styleArray);

                // $excel->getActiveSheet()->setCellValue('D'.$i,'AMOUNT');
                // $excel->getActiveSheet()->setCellValue('G'.$i,$total_amount_tax_based);
                // $excel->getActiveSheet()->setCellValue('I'.$i,$total_tax_withheld);

                // $excel->getActiveSheet()->getStyle('D'.$i.':I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    
                // $excel->getActiveSheet()->getStyle('D'.$i.':I'.$i)->getFont()->setBold(TRUE);    

                // $excel->getActiveSheet()
                //         ->getStyle('D'.$i.':I'.$i)
                //         ->getAlignment()
                //         ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $i++;                   

                $excel->getActiveSheet()->setCellValue('A'.$i,'Date Printed: '.date('Y-m-d h:i:s'));
                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Printed by: '.$this->session->user_fullname);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$filename);
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
