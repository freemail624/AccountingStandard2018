<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_flow extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_class_model',
                'Journal_info_model',
                'Journal_account_model',
                'Users_model',
                'Departments_model',
                'Company_model',
                'Cash_flow_items_model'
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
        $data['title'] = 'Cash Flow Report';

        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');
        // $data['income_accounts']=$this->Journal_info_model->get_account_balance(4);
        // $data['expense_accounts']=$this->Journal_info_model->get_account_balance(5);
        (in_array('9-29',$this->session->user_rights)? 
        $this->load->view('cash_flow_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn)
    {
        switch($txn)
        {
            case 'export-excel':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;
                $m_cash_flow=$this->Cash_flow_items_model;

                $company_info=$m_company->get_list();
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);

                $start_date = date("Y-m-d",strtotime($start));
                $end_date = date("Y-m-d",strtotime($end));

                $sdate = date("m/d/Y",strtotime($start));
                $edate = date("m/d/Y",strtotime($end));

                $income_accounts = $m_journal->get_account_balance(4,NULL,$start_date,$end_date);
                $expense_accounts = $m_journal->get_account_balance(5,NULL,$start_date,$end_date);

                $cash_equivalents = $m_cash_flow->get_cash_flow(1,$start_date,$end_date);
                $non_cash_expenses = $m_cash_flow->get_cash_flow(2,$start_date,$end_date);
                $operating_assets = $m_cash_flow->get_cash_flow(3,$start_date,$end_date);
                $operating_liabilities = $m_cash_flow->get_cash_flow(4,$start_date,$end_date);
                $non_current_assets = $m_cash_flow->get_cash_flow(5,$start_date,$end_date);
                $non_current_liabilities = $m_cash_flow->get_cash_flow(6,$start_date,$end_date);

                $total_income = 0;
                $total_expense = 0;
                $net_income = 0;

                foreach($income_accounts as $income_account){
                    $total_income += $income_account->account_balance;
                }

                foreach($expense_accounts as $expense_account){
                    $total_expense += $expense_account->account_balance;
                }           

                $net_income = ($total_income - $total_expense);

                $excel=$this->excel;
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('75');


                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')
                                        ->setAutoSize(false)
                                        ->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')
                                        ->setAutoSize(false)
                                        ->setWidth('20');                                        

                $excel->getActiveSheet()->setTitle('Cash Flow');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2','CASH FLOW')
                                        ->setCellValue('A3',$sdate.' to '.$edate);

                $excel->getActiveSheet()->getStyle('D6')->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D6')->getFont()->setBold(TRUE);

                $top_bottom = array(
                  'borders' => array(               
                    'top' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),         
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                  )
                );                                                                                         

                $bottom = array(
                  'borders' => array(              
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                  )
                );                                                                                         


                $bouble_bottom = array(
                  'borders' => array(               
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                    )
                  )
                );                                                                                         

                $excel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($top_bottom);

                $excel->getActiveSheet()->setCellValue('A5','CASH FLOW FROM OPERATING ACTIVITIES');
                $excel->getActiveSheet()->setCellValue('A6','NET INCOME ('.$sdate.' to '.$edate.')');
                $excel->getActiveSheet()->setCellValue('D6',$net_income)
                        ->getStyle('D6')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A7','Adjustments to reconcile net income to net cash provided by operating Activities');

                $i=8;
                foreach($non_cash_expenses as $nce){

                    if($nce->parent_account_id > 0){
                        $excel->getActiveSheet()->setCellValue('A'.$i,'                     '.$nce->account_title);
                    }else{
                        $excel->getActiveSheet()->setCellValue('A'.$i,'              '.$nce->account_title);
                    }

                    $excel->getActiveSheet()->setCellValue('B'.$i,$nce->total_amount)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 
                    $i++;
                }

                $lastrow_non_cash = count($non_cash_expenses) + 7;

                $excel->getActiveSheet()->setCellValue('D'.$lastrow_non_cash, "=SUM(B8:B".$lastrow_non_cash.")");
                $excel->getActiveSheet()->getStyle('D'.$lastrow_non_cash)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                $first_row_operating = $i;

                foreach($operating_assets as $oa){

                    if($oa->parent_account_id > 0){
                        $excel->getActiveSheet()->setCellValue('A'.$i,'                     '.$oa->account_title);
                    }else{
                        $excel->getActiveSheet()->setCellValue('A'.$i,'              Decrease (Increase) in '.$oa->account_title);
                    }

                    $excel->getActiveSheet()->setCellValue('B'.$i,$oa->total_amount)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                    $i++;
                }

                foreach($operating_liabilities as $ol){

                    if($ol->parent_account_id > 0){
                        $excel->getActiveSheet()->setCellValue('A'.$i,'                     '.$ol->account_title);
                    }else{
                        $excel->getActiveSheet()->setCellValue('A'.$i,'              Increase (Decrease) in  '.$ol->account_title);
                    }

                    $excel->getActiveSheet()->setCellValue('B'.$i,$ol->total_amount)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                    $i++;
                }

                $last_row_operating = count($operating_assets) + count($operating_liabilities) + $lastrow_non_cash;

                $excel->getActiveSheet()->setCellValue('D'.$last_row_operating, "=SUM(B".$first_row_operating.":B".$last_row_operating.")");
                $excel->getActiveSheet()->getStyle('D'.$last_row_operating)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 


                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($top_bottom);

                $excel->getActiveSheet()->setCellValue('A'.$i,'                                   CASH GENERATED FROM OPERATAIONS');

                $operating_activities = $i;

                $excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(D6:D".$last_row_operating.")")
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 


                $i+=2;


                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($top_bottom);

                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOW FROM INVESTING ACTIVITIES');

                $i++;
                $first_row_investing = $i;

                foreach($non_current_assets as $nca){

                    $excel->getActiveSheet()->setCellValue('A'.$i,'              '.$nca->account_title);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$nca->total_amount)
                            ->getStyle('D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                    $i++;
                }

                $last_row_investing = $i - 1;

                $excel->getActiveSheet()->setCellValue('A'.$i,'                                   NET CASH USED BY INVESTING ACTIVITIES');

                $investing_activities = $i;

                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($top_bottom);

                $excel->getActiveSheet()->setCellValue('D'.$i, "=SUM(D".$first_row_investing.":D".$last_row_investing.")")
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 


                $i+=2;


                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($top_bottom);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOW FROM FINANCING ACTIVITIES');

                $i++;
                $first_row_financing = $i;

                foreach($non_current_liabilities as $ncl){

                    $excel->getActiveSheet()->setCellValue('A'.$i,'              '.$ncl->account_title);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$ncl->total_amount)
                            ->getStyle('D'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                    $i++;
                }

                $last_row_financing = $i - 1;

                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($top_bottom);
                $excel->getActiveSheet()->setCellValue('A'.$i,'                                   NET CASH USED BY FINANCING ACTIVITIES');
                $row = 0;

                if(count($non_current_liabilities) > 0){
                    $row = "=SUM(D".$first_row_financing.":D".$last_row_financing.")";
                }else{
                    $row = 0; 
                }

                $financing_activities = $i;

                $excel->getActiveSheet()->setCellValue('D'.$i, $row)
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                $i++;

                $net_in_cash = $i;
                $excel->getActiveSheet()->setCellValue('A'.$i,'NET Increase (Decrease) in Cash');
                $excel->getActiveSheet()->setCellValue('D'.$i, "=D".$operating_activities."+D".$investing_activities."+D".$financing_activities)
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                $i++;

                $cash_beg = $i;

                $total_cash_beg = 0;

                foreach($cash_equivalents as $cash_equivalent){
                    $total_cash_beg += $cash_equivalent->total_amount;
                }

                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($bottom);
                $excel->getActiveSheet()->setCellValue('A'.$i,'Cash (Beg.) '.$sdate);
                $excel->getActiveSheet()->setCellValue('D'.$i, $total_cash_beg)
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                $i++;                    


                $next_date = date('m/d/Y', strtotime('+1 day', strtotime($end_date)));

                $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($bouble_bottom);
                $excel->getActiveSheet()->setCellValue('A'.$i,'Cash (End.) '.$next_date);
                $excel->getActiveSheet()->setCellValue('D'.$i, "=D".$net_in_cash."+D".$cash_beg)
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

                $i++;                    


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Cash Flow '.date('Y-m-d',strtotime($end)).'.xlsx"');
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
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;

                $company_info=$m_company->get_list();
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $dep_id=$this->input->get('depid',TRUE);

                $departments = $this->Departments_model->get_list('is_active = TRUE AND is_deleted  = FALSE');

                $income_accounts = $m_journal->get_account_balance_for_summary_income(4,null,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $expense_accounts = $m_journal->get_account_balance_for_summary_income(5,null,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $excel=$this->excel;
   

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('50');

                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('20');

                $excel->getActiveSheet()->setTitle('Income Statement');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()
                        ->setCellValue('A9', 'INCOME')
                        ->getStyle('A9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A6','INCOME STATEMENT')
                                        ->setCellValue('A7',$start.' to '.$end);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B9:D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A7')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()
                        ->setCellValue('B8', 'ALL Departments')
                        ->getStyle('B8')->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('B9', '')
                        ->getStyle('B9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);

                $i = 9;
                $income_total=0;
                $total_net = 0;
                foreach($income_accounts as $income_account)
                {
                    $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_title);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$income_account->account_balance)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');

                    $income_total+=$income_account->account_balance;

                }

                $i++;

                $lastrow_income = count($income_accounts) + 9;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Income:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,"=SUM(B10:B".$lastrow_income.")")
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');

                $total_income_row = 'B'.$i;   
                $i+=2;

                $first_row_expense = $i+1;

                $excel->getActiveSheet()
                        ->mergeCells('A'.$i.':'.'B'.$i)
                        ->setCellValue('A'.$i, 'EXPENSE')
                        ->getStyle('A'.$i.':'.'B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                $expense_total = 0;
                foreach($expense_accounts as $expense_account)
                {
                    $i++;

                    $excel->getActiveSheet()
                            ->setCellValue('A'.$i,$expense_account->account_title);

                    $excel->getActiveSheet()
                            ->setCellValue('B'.$i,$expense_account->account_balance)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');

                    $expense_total+=$expense_account->account_balance;
                }

                $i++;

                $lastrow_expense = (count($expense_accounts) + $first_row_expense) - 1;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Expense:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,"=SUM(B".$first_row_expense.":B".$lastrow_expense.")")
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');

                $total_net = $income_total - $expense_total;
                $total_expense_row = 'B'.$i;  

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i, 'NET INCOME:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i, "=SUM(".$total_income_row."+".$total_expense_row.")")
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');


                $a = 'c';  
                foreach ($departments as $department) {

                    $excel->getActiveSheet()->getColumnDimension($a)
                                        ->setAutoSize(false)
                                        ->setWidth('20');         


                    $income_accounts = $m_journal->get_account_balance_for_summary_income(4,$department->department_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                    $expense_accounts = $m_journal->get_account_balance_for_summary_income(5,$department->department_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));

                    $i = 9;
                    $income_total=0;
                    $total_net = 0;


                    $excel->getActiveSheet()
                            ->setCellValue($a.''.$i, '')
                            ->getStyle($a.''.$i)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '53C1F0')
                                    )
                                )
                            )->getFont()
                            ->setBold(TRUE);                                                   

                    $excel->getActiveSheet()->setCellValue($a.'8', $department->department_name)->getStyle($a.'8')->getFont()->setBold(TRUE); 

                            foreach($income_accounts as $income_account)
                            {
                                $i++;
                                $excel->getActiveSheet()->setCellValue($a.''.$i,$income_account->account_balance)
                                        ->getStyle($a.''.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                                $excel->getActiveSheet()->getStyle($a.''.$i)->getNumberFormat()
                                                        ->setFormatCode('###,##0.00;(###,##0.00)');

                                $income_total+=$income_account->account_balance;

                            }

                            $i++;
                            
                            $lastrow_income = count($income_accounts) + 9;
                            
                            $excel->getActiveSheet()->setCellValue($a.''.$i,"=SUM(".$a."10:".$a.$lastrow_income.")")
                                                    ->getStyle($a.''.$i)
                                                    ->getFont()
                                                    ->setBold(TRUE)
                                                    ->getActiveSheet()
                                                    ->getStyle($a.''.$i)
                                                    ->getAlignment()
                                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle($a.''.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');

                            $total_income_row = $a.$i;

                            $i+=2;

                            $first_row_expense = $i+1;

                            $excel->getActiveSheet()
                                    ->setCellValue($a.''.$i, '')
                                    ->getStyle($a.''.$i)->applyFromArray(
                                        array(
                                            'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '53C1F0')
                                            )
                                        )
                                    )->getFont()
                                    ->setBold(TRUE);   

                            $expense_total = 0;
                            foreach($expense_accounts as $expense_account)
                            {
                                $i++;

                                $excel->getActiveSheet()
                                        ->setCellValue($a.''.$i,$expense_account->account_balance)
                                        ->getStyle($a.''.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                                $excel->getActiveSheet()->getStyle($a.''.$i)->getNumberFormat()
                                                        ->setFormatCode('###,##0.00;(###,##0.00)');

                                $expense_total+=$expense_account->account_balance;
                            }

                            $i++;

                            $lastrow_expense = (count($expense_accounts) + $first_row_expense) - 1;

                            $excel->getActiveSheet()->setCellValue($a.''.$i,"=SUM(".$a.$first_row_expense.":".$a.$lastrow_expense.")")
                                                    ->getStyle($a.''.$i)
                                                    ->getFont()
                                                    ->setBold(TRUE)
                                                    ->getActiveSheet()
                                                    ->getStyle($a.''.$i)
                                                    ->getAlignment()
                                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $total_net = $income_total - $expense_total;

                            $excel->getActiveSheet()->getStyle($a.''.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');

                            $total_expense_row = $a.$i;  
                            
                            $i++;

                            $excel->getActiveSheet()->setCellValue($a.''.$i, "=SUM(".$total_income_row."+".$total_expense_row.")"
)
                                                    ->getStyle($a.''.$i)
                                                    ->getFont()
                                                    ->setBold(TRUE)
                                                    ->getActiveSheet()
                                                    ->getStyle($a.''.$i)
                                                    ->getAlignment()
                                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            
                            $excel->getActiveSheet()->getStyle($a.''.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');                                                    
                $a++;
                }





                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Income Statement '.date('Y-m-d',strtotime($end)).'.xlsx"');
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

                case 'email-excel':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;
                
                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);    

                $company_info=$m_company->get_list();
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                if($dep_id == 1){$dep_id=null;}
                $income_accounts = $m_journal->get_account_balance(4,$dep_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $expense_accounts = $m_journal->get_account_balance(5,$dep_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));

                $excel=$this->excel;

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('50');

                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('25');

                $excel->getActiveSheet()->setTitle('Income Statement'.$dep_id);

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()
                        ->mergeCells('A9:B9')
                        ->setCellValue('A9', 'INCOME')
                        ->getStyle('A9:B9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A6','INCOME STATEMENT - '.$department_name)
                                        ->setCellValue('A7',$start.' to '.$end);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B9:D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A7')->getFont()->setItalic(TRUE);

                $i = 9;
                $income_total=0;
                $total_net = 0;
                foreach($income_accounts as $income_account)
                {
                    $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_title);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$income_account->account_balance)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');

                    $income_total+=$income_account->account_balance;

                }

                $i++;

                $lastrow_income = count($income_accounts) + 9;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Income:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,"=SUM(B10:B".$lastrow_income.")")
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)'); 

                $total_income_row = 'B'.$i;                                        
                $i+=2;

                $first_row_expense = $i+1;

                $excel->getActiveSheet()
                        ->mergeCells('A'.$i.':'.'B'.$i)
                        ->setCellValue('A'.$i, 'EXPENSE')
                        ->getStyle('A'.$i.':'.'B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                $expense_total = 0;
                foreach($expense_accounts as $expense_account)
                {
                    $i++;

                    $excel->getActiveSheet()
                            ->setCellValue('A'.$i,$expense_account->account_title);

                    $excel->getActiveSheet()
                            ->setCellValue('B'.$i,$expense_account->account_balance)
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $expense_total+=$expense_account->account_balance;

                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                            ->setFormatCode('###,##0.00;(###,##0.00)');
                }

                $i++;

                $lastrow_expense = (count($expense_accounts) + $first_row_expense) - 1;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Expense:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,"=SUM(B".$first_row_expense.":B".$lastrow_expense.")")
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');

                $total_net = $income_total - $expense_total;

                $total_expense_row = 'B'.$i;
                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i, 'NET INCOME:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i, "=SUM(".$total_income_row."-".$total_expense_row.")")
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Income Statement '.date('Y-m-d',strtotime($end)).'.xlsx"');
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

                          $file_name='Income Statement '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Income Statement';
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
