<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comparative_Balance_sheet extends CORE_Controller
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
        $data['title'] = 'Comparative Balance Sheet';

        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');

        (in_array('9-25',$this->session->user_rights)? 
        $this->load->view('comparative_balance_sheet_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function format_display($balance){
        $balance=(float)$balance;
        if($balance<0){
            $balance=str_replace("-","",$balance);
            return "(".number_format($balance,2).")";
        }else{
            return number_format($balance,2);
        }
    }

    function format_display_percentage($balance){
        $balance=(float)$balance;
        if($balance<0){
            $balance=str_replace("-","",$balance);
            return "(".number_format($balance,2)."%)";
        }else{
            if ($balance == 0){
                return number_format(100,2).'%';
            }else{
                return number_format($balance,2).'%';
            }
        }
    }      

    function transaction($txn)
    {
        switch($txn)
        {
            case 'bs':
                //$as_of_date=$this->input->get('date',TRUE);
                $curr_year = $this->input->get('year', TRUE);
                $net_income_start = date('Y-m-d', strtotime('01/01/'.$curr_year));
                $as_of_date = date('Y-m-d', strtotime($this->input->get('date', TRUE)));

                $prev_year = $this->input->get('year_end', TRUE);
                $prev_net_income_start = date('Y-m-d', strtotime('01/01/'.$prev_year));
                $as_of_end_date = date('Y-m-d', strtotime($this->input->get('end_date', TRUE)));

                $department_id = $this->input->get('depid', TRUE);
                $type=$this->input->get('type',TRUE);

                $m_journal_accounts=$this->Journal_account_model;

                if($department_id==1){$department_id=null;}

                //get list of account classifications
                $data['acc_classes']=$m_journal_accounts->get_bs_account_classes($as_of_date,$department_id);
                $data['acc_titles']=$m_journal_accounts->comparative_get_bs_parent_account_balances($net_income_start,$as_of_date,$prev_net_income_start,$as_of_end_date,$department_id);
                
                $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $data['company_info']=$company[0];
                $dep_info=$this->Departments_model->get_list($department_id);
                $data['dep_info']=$dep_info[0];

                $data['as_of_date']=$as_of_date;
                $data['curr_year']=$curr_year;
                $data['prev_year']=$prev_year;

                $this->load->view('template/comparative_balance_sheet_report',$data);

                break;  

            case 'export-excel':

                $double_underline = array(
                  'borders' => array(
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                    )
                  )
                );


                $single_underline = array(
                  'borders' => array(
                    'top' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );                

                $m_journal_accounts=$this->Journal_account_model;
                $m_company=$this->Company_model;

                //$as_of_date=$this->input->get('date',TRUE);
                $curr_year = $this->input->get('year', TRUE);
                $net_income_start = date('Y-m-d', strtotime('01/01/'.$curr_year));
                $as_of_date = date('Y-m-d', strtotime($this->input->get('date', TRUE)));

                $prev_year = $this->input->get('year_end', TRUE);
                $prev_net_income_start = date('Y-m-d', strtotime('01/01/'.$prev_year));
                $as_of_end_date = date('Y-m-d', strtotime($this->input->get('end_date', TRUE)));

                $department_id = $this->input->get('depid', TRUE);
                $type=$this->input->get('type',TRUE);

                if($department_id==1){$department_id=null;}

                //get list of account classifications
                $acc_classes=$m_journal_accounts->get_bs_account_classes($as_of_date,$department_id);
                $acc_titles=$m_journal_accounts->comparative_get_bs_parent_account_balances($net_income_start,$as_of_date,$prev_net_income_start,$as_of_end_date,$department_id);

                $company_info=$m_company->get_list();
                $dep_info=$this->Departments_model->get_list($department_id);

                $excel=$this->excel;

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('50');

                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('20');

                $excel->getActiveSheet()->setTitle('Comparative Balance Sheet');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()
                        ->mergeCells('A8:F8')
                        ->setCellValue('A8', 'ASSETS')
                        ->getStyle('A8')
                        ->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()
                        ->getStyle('A8')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A6','COMPARATIVE STATEMENT OF FINANCIAL POSITION - '.$dep_info[0]->department_name)
                                        ->setCellValue('A7','AS OF DECEMBER'.date('F d, Y', strtotime($as_of_date)).' & '.date('Y', strtotime($as_of_end_date)));


                $excel->getActiveSheet()->getColumnDimension('C')
                                        ->setAutoSize(false)
                                        ->setWidth('20');


                $excel->getActiveSheet()->getColumnDimension('D')
                                        ->setAutoSize(false)
                                        ->setWidth('20');


                $excel->getActiveSheet()->getColumnDimension('E')
                                        ->setAutoSize(false)
                                        ->setWidth('20');

                $excel->getActiveSheet()->getColumnDimension('F')
                                        ->setAutoSize(false)
                                        ->setWidth('40');

                $excel->getActiveSheet()->setCellValue('B9',$curr_year)
                                        ->setCellValue('C9',$prev_year)
                                        ->setCellValue('D9','Increase / (Decrease)')
                                        ->setCellValue('E9','% Change')
                                        ->setCellValue('F9','*Explanation of Increase/(Decrease)');


                $excel->getActiveSheet()->getStyle('B9:F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B9:F9')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B8:D8')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A7')->getFont()->setItalic(TRUE);


                $i = 9;
                $total_curr_assets=0;
                $total_prev_assets=0; 
                $total_assets_change_amount=0;
                $total_assets_percentage_change=0;

                foreach($acc_classes as $class)
                {
                    if($class->account_type_id==1){

                        $i++;

                        $total_curr_balance=0;
                        $total_prev_balance=0; 
                        $total_change_amount=0;
                        $total_percentage_change=0;

                        $a=$i;

                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getFont()
                                ->setBold(TRUE);

                        $excel->getActiveSheet()->setCellValue('A'.$i,$class->account_class.':');

                        foreach($acc_titles as $account){ 

                            if($class->account_class_id==$account->account_class_id){
                            $a++;

                            $excel->getActiveSheet()->getStyle('B'.$a.':F'.$a)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $excel->getActiveSheet()->setCellValue('A'.$a,$account->account_title)
                                    ->getStyle('A'.$a)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                            $excel->getActiveSheet()->setCellValue('B'.$a,$this->format_display($account->current_balance))
                                    ->getStyle('B'.$a)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('C'.$a,$this->format_display($account->previous_balance))
                                    ->getStyle('C'.$a)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('D'.$a,$this->format_display($account->change_amount))
                                    ->getStyle('D'.$a)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('E'.$a,$this->format_display_percentage($account->percentage_change))
                                    ->getStyle('E'.$a)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                                $total_curr_balance+=$account->current_balance;
                                $total_prev_balance+=$account->previous_balance;
                                $total_change_amount=$total_curr_balance-$total_prev_balance;

                                if($total_prev_balance == 0){
                                    $total_percentage_change=100;
                                }else{
                                    $total_percentage_change=(($total_curr_balance-$total_prev_balance)/$total_prev_balance) * 100;
                                }

                                $total_curr_assets=$total_curr_balance;
                                $total_prev_assets=$total_prev_balance; 
                                $total_assets_change_amount=$total_change_amount;

                                if($total_prev_assets == 0){
                                    $total_assets_percentage_change=100;
                                }else{
                                    $total_assets_percentage_change=(($total_curr_assets-$total_prev_assets)/$total_prev_assets)*100;
                                }


                            }

                        }

                        $d=$a+1;

                        // Total Current Asset

                        $excel->getActiveSheet()->getStyle('B'.$d.':F'.$d)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                        $excel->getActiveSheet()->getStyle('A'.$d.':F'.$d)->getFont()->setBold(TRUE);

                        $excel->getActiveSheet()->getStyle('B'.$d.':F'.$d)->applyFromArray($single_underline);

                        $excel->getActiveSheet()->setCellValue('A'.$d,'Total '.$class->account_class)
                                ->getStyle('A'.$d)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()->setCellValue('B'.$d,$this->format_display($total_curr_balance))
                                ->getStyle('B'.$d)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('C'.$d,$this->format_display($total_prev_balance))
                                ->getStyle('C'.$d)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('D'.$d,$this->format_display($total_change_amount))
                                ->getStyle('D'.$d)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('E'.$d,$this->format_display_percentage($total_percentage_change))
                                ->getStyle('E'.$d)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                        $d++;
                    }
                }

                $e=$d+1;

                $excel->getActiveSheet()->getStyle('B'.$e.':F'.$e)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                $excel->getActiveSheet()->getStyle('A'.$e.':F'.$e)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('B'.$e.':F'.$e)->applyFromArray($double_underline);

                $excel->getActiveSheet()->setCellValue('A'.$e,'TOTAL ASSETS')
                        ->getStyle('A'.$e)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->setCellValue('B'.$e,$this->format_display($total_curr_assets))
                        ->getStyle('B'.$e)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('C'.$e,$this->format_display($total_prev_assets))
                        ->getStyle('C'.$e)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('D'.$e,$this->format_display($total_assets_change_amount))
                        ->getStyle('D'.$e)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('E'.$e,$this->format_display_percentage($total_assets_percentage_change))
                        ->getStyle('E'.$e)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                $f=$e+2;

                $excel->getActiveSheet()
                        ->mergeCells('A'.$f.':F'.$f)
                        ->setCellValue('A'.$f, 'LIABILITIES & SHAREHOLDERS EQUITY')
                        ->getStyle('A'.$f)
                        ->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()
                        ->getStyle('A'.$f)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $g=$f;

                $total_curr_liabilities=0;
                $total_prev_liabilities=0; 
                $total_liabilities_change_amount=0;
                $total_liabilities_percentage_change=0;

                foreach($acc_classes as $class)
                {
                    if($class->account_type_id==2){

                        $g++;

                        $total_curr_balance=0;
                        $total_prev_balance=0; 
                        $total_change_amount=0;
                        $total_percentage_change=0;

                        $h=$g;

                        $excel->getActiveSheet()
                                ->getStyle('A'.$g)
                                ->getFont()
                                ->setBold(TRUE);

                        $excel->getActiveSheet()->setCellValue('A'.$g,$class->account_class.':');

                        foreach($acc_titles as $account){ 

                            if($class->account_class_id==$account->account_class_id){
                            $h++;

                            $excel->getActiveSheet()->getStyle('B'.$h.':F'.$h)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $excel->getActiveSheet()->setCellValue('A'.$h,$account->account_title)
                                    ->getStyle('A'.$h)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                            $excel->getActiveSheet()->setCellValue('B'.$h,$this->format_display($account->current_balance))
                                    ->getStyle('B'.$h)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('C'.$h,$this->format_display($account->previous_balance))
                                    ->getStyle('C'.$h)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('D'.$h,$this->format_display($account->change_amount))
                                    ->getStyle('D'.$h)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('E'.$h,$this->format_display_percentage($account->percentage_change))
                                    ->getStyle('E'.$h)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                                $total_curr_balance+=$account->current_balance;
                                $total_prev_balance+=$account->previous_balance;
                                $total_change_amount=$total_curr_balance-$total_prev_balance;

                                if($total_prev_balance == 0){
                                    $total_percentage_change=100;
                                }else{
                                    $total_percentage_change=(($total_curr_balance-$total_prev_balance)/$total_prev_balance) * 100;
                                }

                                $total_curr_liabilities=$total_curr_balance;
                                $total_prev_liabilities=$total_prev_balance; 
                                $total_liabilities_change_amount=$total_change_amount;

                                if($total_prev_liabilities == 0){
                                    $total_liabilities_percentage_change = 100;
                                }else{
                                    $total_liabilities_percentage_change=(($total_curr_liabilities-$total_prev_liabilities)/$total_prev_liabilities)*100;    
                                }    

                            }

                        }

                        $j=$h+1;

                        // Total Current Asset

                        $excel->getActiveSheet()->getStyle('B'.$j.':F'.$j)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                        $excel->getActiveSheet()->getStyle('A'.$j.':F'.$j)->getFont()->setBold(TRUE);

                        $excel->getActiveSheet()->getStyle('B'.$j.':F'.$j)->applyFromArray($single_underline);

                        $excel->getActiveSheet()->setCellValue('A'.$j,'Total '.$class->account_class)
                                ->getStyle('A'.$j)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()->setCellValue('B'.$j,$this->format_display($total_curr_balance))
                                ->getStyle('B'.$j)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('C'.$j,$this->format_display($total_prev_balance))
                                ->getStyle('C'.$j)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('D'.$j,$this->format_display($total_change_amount))
                                ->getStyle('D'.$j)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('E'.$j,$this->format_display_percentage($total_percentage_change))
                                ->getStyle('E'.$j)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                        $j++;
                    }
                }

                $k=$j+1;

                $excel->getActiveSheet()->getStyle('B'.$k.':F'.$k)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                $excel->getActiveSheet()->getStyle('A'.$k.':F'.$k)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('B'.$k.':F'.$k)->applyFromArray($double_underline);                

                $excel->getActiveSheet()->setCellValue('A'.$k,'TOTAL LIABILITIES')
                        ->getStyle('A'.$k)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->setCellValue('B'.$k,$this->format_display($total_curr_liabilities))
                        ->getStyle('B'.$k)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('C'.$k,$this->format_display($total_prev_liabilities))
                        ->getStyle('C'.$k)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('D'.$k,$this->format_display($total_liabilities_change_amount))
                        ->getStyle('D'.$k)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('E'.$k,$this->format_display_percentage($total_liabilities_percentage_change))
                        ->getStyle('E'.$k)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                   

                $l=$k+1;

                $total_curr_equity=0;
                $total_prev_equity=0; 
                $total_equity_change_amount=0;
                $total_equity_percentage_change=0;

                foreach($acc_classes as $class)
                {
                    if($class->account_type_id==3){

                        $l++;

                        $total_curr_balance=0;
                        $total_prev_balance=0; 
                        $total_change_amount=0;
                        $total_percentage_change=0;

                        $m=$l;

                        $excel->getActiveSheet()
                                ->getStyle('A'.$l)
                                ->getFont()
                                ->setBold(TRUE);

                        $excel->getActiveSheet()->setCellValue('A'.$l,$class->account_class.':');

                        foreach($acc_titles as $account){ 

                            if($class->account_class_id==$account->account_class_id){
                            $m++;

                            $excel->getActiveSheet()->getStyle('B'.$m.':F'.$m)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $excel->getActiveSheet()->setCellValue('A'.$m,$account->account_title)
                                    ->getStyle('A'.$m)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                            $excel->getActiveSheet()->setCellValue('B'.$m,$this->format_display($account->current_balance))
                                    ->getStyle('B'.$m)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('C'.$m,$this->format_display($account->previous_balance))
                                    ->getStyle('C'.$m)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('D'.$m,$this->format_display($account->change_amount))
                                    ->getStyle('D'.$m)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->setCellValue('E'.$m,$this->format_display_percentage($account->percentage_change))
                                    ->getStyle('E'.$m)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                                $total_curr_balance+=$account->current_balance;
                                $total_prev_balance+=$account->previous_balance;
                                $total_change_amount=$total_curr_balance-$total_prev_balance;

                                if($total_prev_balance == 0){
                                    $total_percentage_change=100;
                                }else{
                                    $total_percentage_change=(($total_curr_balance-$total_prev_balance)/$total_prev_balance) * 100;
                                }

                                $total_curr_equity=$total_curr_balance+$total_curr_liabilities;
                                $total_prev_equity=$total_prev_balance+$total_prev_liabilities; 
                                $total_equity_change_amount=$total_change_amount+$total_liabilities_change_amount;

                                if($total_prev_equity == 0){
                                    $total_equity_percentage_change = 100;
                                }else{
                                    $total_equity_percentage_change = (($total_curr_equity-$total_prev_equity)/$total_prev_equity)*100;
                                }                                    


                            }

                        }

                        $n=$m+1;

                        // Total Current Asset

                        $excel->getActiveSheet()->getStyle('B'.$n.':F'.$n)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                        $excel->getActiveSheet()->getStyle('A'.$n.':F'.$n)->getFont()->setBold(TRUE);

                        $excel->getActiveSheet()->getStyle('B'.$n.':F'.$n)->applyFromArray($single_underline);

                        $excel->getActiveSheet()->setCellValue('A'.$n,'Total '.$class->account_class)
                                ->getStyle('A'.$n)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()->setCellValue('B'.$n,$this->format_display($total_curr_balance))
                                ->getStyle('B'.$n)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('C'.$n,$this->format_display($total_prev_balance))
                                ->getStyle('C'.$n)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('D'.$n,$this->format_display($total_change_amount))
                                ->getStyle('D'.$n)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('E'.$n,$this->format_display_percentage($total_percentage_change))
                                ->getStyle('E'.$n)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   


                        $n++;
                    }
                }

                $o=$n+1;

                $excel->getActiveSheet()->getStyle('B'.$o.':F'.$o)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                $excel->getActiveSheet()->getStyle('A'.$o.':F'.$o)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('B'.$o.':F'.$o)->applyFromArray($double_underline);

                $excel->getActiveSheet()->setCellValue('A'.$o,'TOTAL LIABILITIES AND SHAREHOLDERS EQUITY')
                        ->getStyle('A'.$o)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->setCellValue('B'.$o,$this->format_display($total_curr_equity))
                        ->getStyle('B'.$o)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('C'.$o,$this->format_display($total_prev_equity))
                        ->getStyle('C'.$o)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('D'.$o,$this->format_display($total_equity_change_amount))
                        ->getStyle('D'.$o)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('E'.$o,$this->format_display_percentage($total_equity_percentage_change))
                        ->getStyle('E'.$o)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);   

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Comparative Statement of Financial Position ('.date('F d, Y', strtotime($as_of_date)).' & '.date('Y', strtotime($as_of_end_date)).').xlsx"');
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
