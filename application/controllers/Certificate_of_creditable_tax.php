<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_of_creditable_tax extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Months_model');
        $this->load->model('Bir_2307_model');
        $this->load->model('Company_model');

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
        (in_array('17-1',$this->session->user_rights)? 
        $this->load->view('certificate_of_creditable_tax_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_form_2307 = $this->Bir_2307_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                if($month == 0){$month = null;}
                $response['data'] = $m_form_2307->get_2307_list($month,$year);
                echo json_encode($response);
                break;


            case 'print-list':
                $m_form_2307 = $this->Bir_2307_model;
                $month_id = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                $data['month'] = $this->Months_model->get_list($month_id,'month_name')[0];

                if($month_id == 0){$month_id = null;}
                $data['items'] = $m_form_2307->get_2307_list($month_id,$year);
                $data['company_info']=$this->Company_model->get_list()[0];
                $data['month_id']=$month_id;

                $file_name='Certificate of Creditable Tax Report';
                $pdfFilePath = $file_name.".pdf";
                $pdf = $this->m_pdf->load(); 
                $pdf->AddPage('L');
                $content =  $this->load->view('template/2307_content_1',$data,TRUE);
                $pdf->SetTitle('Certificate of Creditable Tax Report');
                $pdf->WriteHTML($content);
                $pdf->Output();
                
                break;

            case 'export-list':

                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $m_form_2307 = $this->Bir_2307_model;

                $month_id = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);

                $company_info=$m_company_info->get_list();

                if($month_id == 0){$month_id = null;}
                $data = $m_form_2307->get_2307_list($month_id,$year);     
                $month = $this->Months_model->get_list($month_id,'month_name');               

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('5');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle($month[0]->month_name.' '.$year);
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                // $excel->getActiveSheet()->mergeCells('A1:D1');
                // $excel->getActiveSheet()->mergeCells('A2:D2');
                // $excel->getActiveSheet()->mergeCells('A3:D3');
                // $excel->getActiveSheet()->mergeCells('A4:D4');

                $excel->getActiveSheet()->setCellValue('A1','BIR REGISTERED NAME')
                                        ->setCellValue('A2','TRADE NAME')
                                        ->setCellValue('A3','ADDRESS')
                                        ->setCellValue('A4','TIN NUMBER');

                $bottom_header = array(
                  'borders' => array(               
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );                                                

                $excel->getActiveSheet()->getStyle('B1')->applyFromArray($bottom_header);
                $excel->getActiveSheet()->getStyle('B2')->applyFromArray($bottom_header);
                $excel->getActiveSheet()->getStyle('B3')->applyFromArray($bottom_header);
                $excel->getActiveSheet()->getStyle('B4')->applyFromArray($bottom_header);

                $excel->getActiveSheet()->setCellValue('B1',$company_info[0]->registered_to)
                                        ->setCellValue('B2',$company_info[0]->company_name)
                                        ->setCellValue('B3',$company_info[0]->registered_address)
                                        ->setCellValue('B4',substr($company_info[0]->tin_no,0, 3).'-'.
                                                            substr($company_info[0]->tin_no,3, 3).'-'.
                                                            substr($company_info[0]->tin_no,6, 3).'-'.
                                                            substr($company_info[0]->tin_no,9, 3));                                            
                $excel->getActiveSheet()->mergeCells('A6:I6');                                            
                $excel->getActiveSheet()->mergeCells('A7:I7');

                $excel->getActiveSheet()
                        ->getStyle('A6:I7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                

                if($month_id == null){
                    $excel->getActiveSheet()->setCellValue('A6','ALPHALIST OF PAYESS (MAP)')
                                            ->getStyle('A6')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A7','FOR THE YEAR OF '.$year)
                                            ->getStyle('A7')->getFont()->setBold(TRUE);

                    $filename = 'Alphalist of Payess (MAP) for the year of '.$year.'_'.date('M-d-Y',NOW()).'.xlsx';

                }else{
                    $excel->getActiveSheet()->setCellValue('A6','MONTHLY ALPHALIST OF PAYESS (MAP)')
                                            ->getStyle('A6')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('A7','FOR THE MONTH OF '.$month[0]->month_name.' '.$year)
                                            ->getStyle('A7')->getFont()->setBold(TRUE);
                    
                    $filename = 'Monthly Alphalist of Payess (MAP) for the month of '.$month[0]->month_name.' '.$year.'_'.date('M-d-Y',NOW()).'.xlsx';                                        
                }
                                       
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');

                 $style_header = array(
                    'font' => array(
                        'bold' => true,
                    )
                );

                $excel->getActiveSheet()->getStyle('A9:I9')->applyFromArray( $style_header );

                $top = array(
                  'borders' => array(
                    'right' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                    'left' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),             
                    'top' => array(
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
                $bottom = array(
                  'borders' => array(
                    'right' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                    'left' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),                
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );                                                

                $excel->getActiveSheet()->getStyle('A9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('B9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('C9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('D9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('E9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('F9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('G9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('H9')->applyFromArray($top);
                $excel->getActiveSheet()->getStyle('I9')->applyFromArray($top);

                $excel->getActiveSheet()->getStyle('A10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('B10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('C10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('D10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('E10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('F10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('G10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('H10')->applyFromArray($sides);
                $excel->getActiveSheet()->getStyle('I10')->applyFromArray($sides);     
                
                $excel->getActiveSheet()->getStyle('A11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('B11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('C11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('D11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('E11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('F11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('G11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('H11')->applyFromArray($bottom);
                $excel->getActiveSheet()->getStyle('I11')->applyFromArray($bottom);                              

                $excel->getActiveSheet()
                        ->getStyle('A9:I12')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


                $excel->getActiveSheet()->setCellValue('A9','')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','TIN')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Registered Name')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Return Period')                    
                                        ->getStyle('D9')->getFont()->setBold(TRUE);                                         
                $excel->getActiveSheet()->setCellValue('E9','ATC')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Nature')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Amount Tax Base')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Tax')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A10','Seq. No.')
                                        ->getStyle('A10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B10','Including Branch Code')
                                        ->getStyle('B10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C10','(Alphalist)')
                                        ->getStyle('C10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D10','mm/yy')                    
                                        ->getStyle('D10')->getFont()->setBold(TRUE);                                         
                $excel->getActiveSheet()->setCellValue('E10','')
                                        ->getStyle('E10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F10','Income Payment')
                                        ->getStyle('F10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G10','')
                                        ->getStyle('G10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H10','Rate')
                                        ->getStyle('H10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I10','Tax Withheld')
                                        ->getStyle('I10')->getFont()->setBold(TRUE);                                        

                $excel->getActiveSheet()->setCellValue('A11','(1)')
                                        ->getStyle('A11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B11','(2)')
                                        ->getStyle('B11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C11','(3)')
                                        ->getStyle('C11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D11','(4')                    
                                        ->getStyle('D11')->getFont()->setBold(TRUE);                                         
                $excel->getActiveSheet()->setCellValue('E11','(5)')
                                        ->getStyle('E11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F11','(6)')
                                        ->getStyle('F11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G11','(7)')
                                        ->getStyle('G11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H11','(8)')
                                        ->getStyle('H11')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I11','(9)')
                                        ->getStyle('I11')->getFont()->setBold(TRUE);                                            

                $a=1;
                $i=12;

                $total_amount_tax_based = 0;
                $total_tax_withheld = 0;

                foreach ($data as $row) {

                $total_amount_tax_based += $row->gross_amount;
                $total_tax_withheld += $row->deducted_amount;
                
                $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($styleArray);
                unset($styleArray);

                $excel->getActiveSheet()->setCellValue('A'.$i,$a)
                                        ->setCellValue('B'.$i,substr($row->tin_no,0, 3).'-'.
                                                              substr($row->tin_no,3, 3).'-'.
                                                              substr($row->tin_no,6, 3).'-'.
                                                              substr($row->tin_no,9, 3))
                                        ->setCellValue('C'.$i,$row->supplier_name)
                                        ->setCellValue('D'.$i,date_format(date_create($row->date_txn),"m/y"))
                                        ->setCellValue('E'.$i,$row->atc)
                                        // ->setCellValue('F'.$i,$row->remarks)
                                        ->setCellValue('F'.$i,'')
                                        ->setCellValue('G'.$i,number_format($row->gross_amount,2))
                                        ->setCellValue('H'.$i,number_format($row->tax_rate,2))
                                        ->setCellValue('I'.$i,number_format($row->deducted_amount,2));    


                $excel->getActiveSheet()->getStyle('G'.$i.':I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    
                $excel->getActiveSheet()
                        ->getStyle('A'.$i.':C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('E'.$i.':F'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);                                                

                $excel->getActiveSheet()
                        ->getStyle('G'.$i.':I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                                                      
                $i++;
                $a++;

                }

                $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                $excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($styleArray);
                unset($styleArray);

                $excel->getActiveSheet()->setCellValue('D'.$i,'AMOUNT');
                $excel->getActiveSheet()->setCellValue('G'.$i,$total_amount_tax_based);
                $excel->getActiveSheet()->setCellValue('I'.$i,$total_tax_withheld);

                $excel->getActiveSheet()->getStyle('D'.$i.':I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    
                $excel->getActiveSheet()->getStyle('D'.$i.':I'.$i)->getFont()->setBold(TRUE);    

                $excel->getActiveSheet()
                        ->getStyle('D'.$i.':I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $i++; 
                $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'I, declare under the penalties of perjury, that this has been made in good faith, verified by me, and to the best of my knowledge and belief, is true & correct pursuant to the provisions of the NIRC, and the regulations issued under the authority thereof, that the information contained herein completeley reflects all income payments with the corresponding taxes withheld from payees are duly remitted to the BIR and proper Certificates of Creditable Withholding Tax at Source (BIR Form No. 2307) have been issued to payees; that the information appearing herein shall be consistent with the total amount remitted and that, inconsistent information appearing herein shall be consistent with the total amount remitted and that, inconsistent information shall result to dental of the claims to expenses.');

                $excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);

                $excel->getActiveSheet()
                        ->getStyle('A'.$i.':I'.$i)
                        ->getAlignment()
                        ->setWrapText(true);

                $excel->getActiveSheet()->getRowDimension($i)->setRowHeight(60);                        
            

                $i++;$i++;

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
