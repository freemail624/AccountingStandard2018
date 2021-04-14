<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_summary extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Journal_info_model',
                'Journal_account_model',
                'Check_types_model',
                'Users_model',
                'Company_model',
                'Check_layout_model',
                'Cash_vouchers_model',
                'Cash_vouchers_accounts_model'
            )
        );

        $this->load->library('excel');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['check_types']=$this->Check_types_model->get_list('b_refchecktype.is_deleted=FALSE',
            'b_refchecktype.*,account_titles.account_title',
            array(array( 'account_titles' , 'account_titles.account_id = b_refchecktype. account_id', 'left'))
            );
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');        

        $data['title'] = 'Check Summary';
        (in_array('1-9',$this->session->user_rights)? 
        $this->load->view('check_summary_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    public function transaction($txn=null){
        switch($txn){

            case 'get-check-list':
                $m_journal=$this->Journal_info_model;
                $check_type_id = $this->input->get('check_type_id', TRUE);
                $tsd = date('Y-m-d',strtotime($this->input->get('start_date', TRUE)));
                $ted = date('Y-m-d',strtotime($this->input->get('end_date', TRUE)));
                $response['data']=$m_journal->get_check_list($check_type_id,$tsd,$ted);
                echo json_encode($response);
                break;

            case 'print-check-list':
                $m_journal=$this->Journal_info_model;
                $m_bank=$this->Check_types_model;

                $check_type_id = $this->input->get('bank', TRUE);
                $tsd = date('Y-m-d',strtotime($this->input->get('start', TRUE)));
                $ted = date('Y-m-d',strtotime($this->input->get('end', TRUE)));

                $data['checks']=$m_journal->get_check_list($check_type_id,$tsd,$ted);

                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];

                $bank_name = "";

                if($check_type_id == 'all'){
                    $bank_name = 'All Banks';
                }else{
                    $bank=$m_bank->get_list($check_type_id);
                    if(count($bank)>0){
                        $bank_name = $bank[0]->check_type_desc;
                    }else{
                        $bank_name = 'None';
                    }
                }

                $data['bank']=$bank_name;
                $data['start']=date('m/d/Y',strtotime($this->input->get('start')));
                $data['end']=date('m/d/Y',strtotime($this->input->get('end')));

                $data['company_header']=$this->load->view('template/company_header',$params,TRUE);
                $this->load->view('template/check_list_report',$data);
                break;

            case 'export-check-list':

                $excel = $this->excel;
                 
                $m_journal=$this->Journal_info_model;
                $m_bank=$this->Check_types_model;

                $check_type_id = $this->input->get('bank', TRUE);
                $tsd = date('Y-m-d',strtotime($this->input->get('start', TRUE)));
                $ted = date('Y-m-d',strtotime($this->input->get('end', TRUE)));

                $checks=$m_journal->get_check_list($check_type_id,$tsd,$ted);
                $company_info=$this->Company_model->get_list();
                $bank_name = "";

                if($check_type_id == 'all'){
                    $bank_name = 'All Banks';
                }else{
                    $bank=$m_bank->get_list($check_type_id);
                    if(count($bank)>0){
                        $bank_name = $bank[0]->check_type_desc;
                    }else{
                        $bank_name = 'None';
                    }
                }

                $start=date('m/d/Y',strtotime($this->input->get('start')));
                $end=date('m/d/Y',strtotime($this->input->get('end')));            

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('5');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle('Check Summary');
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->registered_to)
                                        ->setCellValue('A2',$company_info[0]->company_name)
                                        ->setCellValue('A3',$company_info[0]->registered_address)
                                        ->setCellValue('A4',substr($company_info[0]->tin_no,0, 3).'-'.
                                                            substr($company_info[0]->tin_no,3, 3).'-'.
                                                            substr($company_info[0]->tin_no,6, 3).'-'.
                                                            substr($company_info[0]->tin_no,9, 3));                                            
                $excel->getActiveSheet()->mergeCells('A6:I6');                                            
                $excel->getActiveSheet()->mergeCells('A7:I7');

                $excel->getActiveSheet()
                        ->getStyle('A6:I7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                


                $excel->getActiveSheet()->setCellValue('A6','Check Summary - '.$bank_name)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Period '.$start.' to '.$end)
                                        ->getStyle('A7')->getFont()->setBold(TRUE);

                $filename = 'Check Summary - '.$start.' to '.$end.'.xlsx';  
                                       
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');

                 $style_header = array(
                    'font' => array(
                        'bold' => true,
                    )
                );

                $excel->getActiveSheet()->getStyle('A9:I9')->applyFromArray( $style_header );            

                $excel->getActiveSheet()
                        ->getStyle('A9:C9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('D9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

                $excel->getActiveSheet()
                        ->getStyle('E9:I9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);                                                


                $excel->getActiveSheet()->setCellValue('A9','Bank')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Check #')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Check Date')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Amount')                    
                                        ->getStyle('D9')->getFont()->setBold(TRUE);          
                $excel->getActiveSheet()->setCellValue('E9','Reference')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Book Type')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Particular')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Remarks')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Issued')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                      
                $i=10;

                foreach ($checks as $row) {
                
                $excel->getActiveSheet()->setCellValue('A'.$i,$row->bank)
                                        ->setCellValue('B'.$i,$row->check_no)
                                        ->setCellValue('C'.$i,$row->check_date)
                                        ->setCellValue('D'.$i,number_format($row->amount,2))
                                        ->setCellValue('E'.$i,$row->ref_no)
                                        ->setCellValue('F'.$i,$row->book_type)
                                        ->setCellValue('G'.$i,$row->particular)
                                        ->setCellValue('H'.$i,$row->remarks)
                                        ->setCellValue('I'.$i,$row->status);    

                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                $excel->getActiveSheet()
                        ->getStyle('A'.$i.':C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

                $excel->getActiveSheet()
                        ->getStyle('E'.$i.':I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);                                                
                $i++;

                }

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

            case 'export-voucher':
                $excel = $this->excel;
                $m_cash_voucher=$this->Cash_vouchers_model;

                $cv_id = $this->input->get('id',TRUE);
                $info= $m_cash_voucher->get_list($cv_id,
                    array(
                        'cv_info.*',
                        'DATE_FORMAT(cv_info.date_txn,"%m/%d/%Y")as date_txn',
                        'DATE_FORMAT(cv_info.check_date,"%m/%d/%Y") as check_date',
                        'payment_methods.payment_method',
                        'CONCAT(IF(NOT ISNULL(customers.customer_id),CONCAT("C-",customers.customer_id),""),IF(NOT ISNULL(suppliers.supplier_id),CONCAT("S-",suppliers.supplier_id),"")) as particular_id',
                        'CONCAT_WS(" ",IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,"")) as particular',
                        'departments.department_name',
                        'b_refchecktype.check_type_desc',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                        'CONCAT_WS(" ",vbu.user_fname,vbu.user_lname)as verified_by',
                        'CONCAT_WS(" ",abu.user_fname,abu.user_lname)as approved_by',
                        'CONCAT_WS(" ",cbu.user_fname,cbu.user_lname)as cancelled_by',
                        'dr.dr_invoice_no'
                    ),
                    array(
                        array('customers','customers.customer_id=cv_info.customer_id','left'),
                        array('suppliers','suppliers.supplier_id=cv_info.supplier_id','left'),
                        array('departments','departments.department_id=cv_info.department_id','left'),
                        array('user_accounts','user_accounts.user_id=cv_info.created_by_user','left'),
                        array('user_accounts vbu','vbu.user_id=cv_info.verified_by_user','left'),
                        array('user_accounts abu','abu.user_id=cv_info.approved_by_user','left'),
                        array('user_accounts cbu','cbu.user_id=cv_info.cancelled_by_user','left'),
                        array('payment_methods','payment_methods.payment_method_id=cv_info.payment_method_id','left'),
                        array('b_refchecktype','b_refchecktype.check_type_id=cv_info.check_type_id','left'),
                        array('delivery_invoice dr','dr.dr_invoice_id=cv_info.dr_invoice_id','left')
                    ),
                    'cv_info.cv_id DESC'
                )[0];

                $journal_accounts=$this->Cash_vouchers_accounts_model->get_list(

                    array(
                        'cv_accounts.cv_id'=>$cv_id
                    ),

                    array(
                        'cv_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title',
                        'departments.department_name'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=cv_accounts.account_id','left'),
                        array('departments','departments.department_id=cv_accounts.department_id','left') 
                    )

                );                

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();

                $excel->setActiveSheetIndex(0);
                $excel->getActiveSheet()->setTitle("CHECK");
                $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->mergeCells('A3:H3');
                $excel->getActiveSheet()->mergeCells('A4:H4');
                $excel->getActiveSheet()->mergeCells('A5:H5');

                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('logo');
                $objDrawing->setDescription('logo');
                $objDrawing->setPath($company_info[0]->logo_path);
                $objDrawing->setCoordinates('A3');                      
                //setOffsetX works properly
                $objDrawing->setOffsetX(25); 
                $objDrawing->setOffsetY(5);                
                //set width, height
                $objDrawing->setWidth(70); 
                $objDrawing->setHeight(70); 
                $objDrawing->setWorksheet($excel->getActiveSheet());

                $excel->getActiveSheet()
                        ->getStyle('A3:A5')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->setCellValue('A3',$company_info[0]->registered_to)
                                        ->setCellValue('A4',$company_info[0]->company_address)
                                        ->setCellValue('A5','CHECK VOUCHER');

                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

                $excel->getActiveSheet()
                        ->getStyle('G5:G9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('H5:H9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);                        

                $excel->getActiveSheet()->mergeCells('B7:F7');
                $excel->getActiveSheet()->getStyle('H6:H7')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A7','PAYEE:')
                                        ->setCellValue('B7',$info->particular.'***')
                                        ->setCellValue('G6','CV #')
                                        ->setCellValue('H6',$info->ref_no)
                                        ->setCellValue('G7','CK #')
                                        ->setCellValue('H7',$info->check_no)
                                        ->setCellValue('G8','CV Date:')
                                        ->setCellValue('H8',date_format(new DateTime($info->date_txn),"F d, Y"))
                                        ->setCellValue('G9','CK Date:')
                                        ->setCellValue('H9',date_format(new DateTime($info->check_date),"F d, Y"));

                $excel->getActiveSheet()->mergeCells('A10:D10');
                $excel->getActiveSheet()->mergeCells('E10:F10');
                $excel->getActiveSheet()->mergeCells('G10:H10');

                $excel->getActiveSheet()
                        ->getStyle('A10:G10')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->getStyle('A10:G10')->getFont()->setBold(TRUE);


                $border_dashed = array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_DASHED,
                        ),
                    ),
                );
                $excel->getActiveSheet()->getStyle('A10:H10')->applyFromArray($border_dashed);
                $excel->getActiveSheet()->setCellValue('A10','ACCOUNT DESCRIPTION')
                                        ->setCellValue('E10','AMOUNT')
                                        ->setCellValue('G10','PARTICULARS');                                        

                $border_right = array(
                    'borders' => array(
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );

                $excel->getActiveSheet()
                        ->getStyle('E11:F11')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

                $excel->getActiveSheet()->getStyle('E11:F11')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('D11:D12')->applyFromArray($border_right);
                $excel->getActiveSheet()->getStyle('E11:E12')->applyFromArray($border_right);
                $excel->getActiveSheet()->getStyle('F11:F12')->applyFromArray($border_right);

                $excel->getActiveSheet()->setCellValue('E11','DEBIT')
                                        ->setCellValue('F11','CREDIT');   

                $dr_row = 13;

                $dr_amount=0;
                $cr_amount=0;

                foreach($journal_accounts as $account){

                $dr_amount+=$account->dr_amount;
                $cr_amount+=$account->cr_amount;

                    if($account->dr_amount>0){ 
            
                        $excel->getActiveSheet()->getStyle('D'.$dr_row)->applyFromArray($border_right);
                        $excel->getActiveSheet()->getStyle('E'.$dr_row)->applyFromArray($border_right);
                        $excel->getActiveSheet()->getStyle('F'.$dr_row)->applyFromArray($border_right);

                        $excel->getActiveSheet()->getStyle('E'.$dr_row)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                        $excel->getActiveSheet()->mergeCells('A'.$dr_row.':C'.$dr_row);
                        $excel->getActiveSheet()->setCellValue('A'.$dr_row,$account->account_title);
                        $excel->getActiveSheet()->setCellValue('E'.$dr_row,$account->dr_amount);

                        $dr_row++;
                    }

                }

                $after_dr_row = $dr_row+3;

                for ($i=0; $i < 4; $i++) { 

                    $row = $dr_row+$i;

                    $excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($border_right);
                    $excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($border_right);
                    $excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($border_right);
                }

                $excel->getActiveSheet()->mergeCells('G14'.':H'.$after_dr_row);
                $excel->getActiveSheet()->setCellValue('G14',$info->remarks);
                $excel->getActiveSheet()->getStyle('G14')->getAlignment()->setWrapText(true);
                $excel->getActiveSheet()->getStyle('G14')
                                        ->getAlignment()
                                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);


                $cr_row = $after_dr_row+1;

                foreach($journal_accounts as $account){

                    if($account->cr_amount>0){ 

                        $excel->getActiveSheet()->getStyle('D'.$cr_row)->applyFromArray($border_right);
                        $excel->getActiveSheet()->getStyle('E'.$cr_row)->applyFromArray($border_right);
                        $excel->getActiveSheet()->getStyle('F'.$cr_row)->applyFromArray($border_right);

                        $excel->getActiveSheet()->getStyle('F'.$cr_row)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                        $excel->getActiveSheet()->mergeCells('C'.$cr_row.':E'.$cr_row);
                        $excel->getActiveSheet()->setCellValue('C'.$cr_row,$account->account_title);
                        $excel->getActiveSheet()->setCellValue('F'.$cr_row,$account->cr_amount);

                        $cr_row++;

                    }

                }


                $after_cr_row = $cr_row+5;

                for ($a=0; $a < 5; $a++) { 

                    $row = $cr_row+$a;

                    $excel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($border_right);
                    $excel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($border_right);
                    $excel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($border_right);
                }


                $excel->getActiveSheet()->getStyle('D'.$after_cr_row)->applyFromArray($border_right);
                $excel->getActiveSheet()->getStyle('E'.$after_cr_row)->applyFromArray($border_right);
                $excel->getActiveSheet()->getStyle('F'.$after_cr_row)->applyFromArray($border_right);

                $excel->getActiveSheet()->getStyle('E'.$after_cr_row.':F'.$after_cr_row)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)');                 
                $excel->getActiveSheet()->getStyle('E'.$after_cr_row.':F'.$after_cr_row)->getFont()->setBold(TRUE);


                $excel->getActiveSheet()->setCellValue('E'.$after_cr_row,$dr_amount);
                $excel->getActiveSheet()->setCellValue('F'.$after_cr_row,$cr_amount);

                $excel->getActiveSheet()->getStyle('A'.$after_cr_row.':H'.$after_cr_row)->applyFromArray($border_dashed);

                $footer = $after_cr_row+2;

                $excel->getActiveSheet()->mergeCells('B'.$footer.':D'.$footer);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(4);

                $footer_details = $footer+1;

                $excel->getActiveSheet()
                        ->getStyle('E'.$footer.':G'.$footer)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->mergeCells('B'.$footer_details.':D'.$footer_details);
                $excel->getActiveSheet()->setCellValue('A'.$footer,'Prepared:')
                                        ->setCellValue('A'.$footer_details,$info->posted_by)
                                        ->setCellValue('B'.$footer,'Certified By:')
                                        ->setCellValue('B'.$footer_details,$info->verified_by)
                                        ->setCellValue('G'.$footer,'Payment Received:');


                if($info->cv_status_id == 4){
                    $excel->getActiveSheet()->setCellValue('E'.$footer,'Cancelled By:')
                                            ->setCellValue('E'.$footer_details,$info->cancelled_by);
                }else{
                    $excel->getActiveSheet()->setCellValue('E'.$footer,'Approved:')
                                            ->setCellValue('E'.$footer_details,$info->approved_by);
                }

                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('logo');
                $objDrawing->setDescription('logo');
                $objDrawing->setPath($company_info[0]->logo_path);
                $objDrawing->setCoordinates('A34');                      
                //setOffsetX works properly
                $objDrawing->setOffsetX(40); 
                $objDrawing->setOffsetY(5);                
                //set width, height
                $objDrawing->setWidth(40); 
                $objDrawing->setHeight(40); 
                $objDrawing->setWorksheet($excel->getActiveSheet());

                $excel->getActiveSheet()->mergeCells('G'.$footer_details.':H'.$footer_details);
                $excel->getActiveSheet()
                        ->getStyle('G'.$footer_details)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()->setCellValue('G'.$footer_details,'_________________________________');


                $footer_last = $footer_details+1;

                $excel->getActiveSheet()->mergeCells('G'.$footer_last.':H'.$footer_last);
                $excel->getActiveSheet()
                        ->getStyle('G'.$footer_last)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()->setCellValue('G'.$footer_last,'Signature Over Printed Name/ Date');

                $check_layout = $footer_last + 4;
                $excel->getActiveSheet()
                        ->getStyle('H'.$check_layout)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('H'.$check_layout,date_format(new DateTime($info->check_date),"F d, Y"));

                $check_layout_1 = $check_layout + 1;

                $num_words=$this->convertDecimalToWords($info->amount);

                $excel->getActiveSheet()
                        ->getStyle('B'.$check_layout_1)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   

                $excel->getActiveSheet()
                        ->getStyle('H'.$check_layout_1)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   

                $excel->getActiveSheet()->getStyle('H'.$check_layout_1)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)');         

                $excel->getActiveSheet()->setCellValue('B'.$check_layout_1,'***')
                                        ->setCellValue('C'.$check_layout_1,$info->particular.'***')
                                        ->setCellValue('H'.$check_layout_1,$info->amount);

                $check_layout_2 = $check_layout_1 + 1;
 
                $excel->getActiveSheet()
                        ->getStyle('B'.$check_layout_2)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   
 
                $excel->getActiveSheet()->setCellValue('B'.$check_layout_2,'***')
                                        ->setCellValue('C'.$check_layout_2,$num_words);



                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Check Voucher - '.$info->ref_no.'.xlsx"');
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

        };
    }

}
