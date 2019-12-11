<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comparative_cash_flow extends CORE_Controller
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
                'Cash_flow_items_model',
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
        $data['title'] = 'Comparative Cash Flow Report';

        (in_array('9-2',$this->session->user_rights)? 
        $this->load->view('comparative_cash_view', $data)
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

    function transaction($txn)
    {
        switch($txn)
        {


            case 'export-cash-flow':
                    $excel=$this->excel;                    
                    $m_journal=$this->Journal_info_model;
                    $m_company=$this->Company_model;
                    $company_info=$m_company->get_list();
                    $data['company_info']=$company_info[0];


            $m_journal_accounts=$this->Journal_account_model;
            $m_cash_flow = $this->Cash_flow_items_model;
            $years = ['2018','2019','2020','2021'];


            // SET VARIABLES 
            $provisions=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>11),'account_id');
            $acc_provision_for_income_tax = [];
            foreach ($provisions as $provision) { $acc_provision_for_income_tax[]=$provision->account_id; }
            $acc_provision_filter =  implode(",", $acc_provision_for_income_tax);

            $depreciations=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>1),'account_id');
            $acc_depreciation = [];
            foreach ($depreciations as $depreciation) { $acc_depreciation[]=$depreciation->account_id; }
            $acc_amortization_filter =  implode(",", $acc_depreciation);

            $receivables=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>2),'account_id');
            $acc_receivable = [];
            foreach ($receivables as $receivable) { $acc_receivable[]=$receivable->account_id; }
            $acc_receivable_filter =  implode(",", $acc_receivable);


            $advances=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>3),'account_id');
            $acc_advances = [];
            foreach ($advances as $advance) { $acc_advances[]=$advance->account_id; }
            $acc_advances_filter =  implode(",", $acc_advances);


            $prepayments=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>4),'account_id');
            $acc_prepayments = [];
            foreach ($prepayments as $prepayment) { $acc_prepayments[]=$prepayment->account_id; }
            $acc_prepayments_filter =  implode(",", $acc_prepayments);

            $other_currents=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>5),'account_id');
            $acc_others = [];
            foreach ($other_currents as $other_current) { $acc_others[]=$other_current->account_id; }
            $acc_others_filter =  implode(",", $acc_others);


            $payables=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>6),'account_id');
            $acc_payables = [];
            foreach ($payables as $payable) { $acc_payables[]=$payable->account_id; }
            $acc_payables_filter =  implode(",", $acc_payables);


            $interests=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>7),'account_id');
            $acc_interest = [];
            foreach ($interests as $interest) { $acc_interest[]=$interest->account_id; }
            $acc_interest_filter =  implode(",", $acc_interest);

            $taxes=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>8),'account_id');
            $acc_tax = [];
            foreach ($taxes as $tax) { $acc_tax[]=$tax->account_id; }
            $acc_tax_filter =  implode(",", $acc_tax);

            $properties=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>9),'account_id');
            $acc_property = [];
            foreach ($properties as $property) { $acc_property[]=$property->account_id; }
            $acc_properties_filter =  implode(",", $acc_property);

            $dividends=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>10),'account_id');
            $acc_dividends = [];
            foreach ($dividends as $dividend) { $acc_dividends[]=$dividend->account_id; }
            $acc_dividends_filter =  implode(",", $acc_dividends);


            $data = array();
            foreach($years as $year){

            $start_date = date("Y-m-d",strtotime($year."-01-01"));
            $end_date = date("Y-m-d",strtotime($year."-12-31"));
            $get_provision_for_income_tax=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_provision_filter);
            $get_amortization=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_amortization_filter);
            $get_receivables=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_receivable_filter);
            $get_advances=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_advances_filter);
            $get_prepayments=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_prepayments_filter);
            $get_others=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_others_filter);
            $get_payables=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_payables_filter);
            $get_interests=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_interest_filter);
            $get_taxes=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_tax_filter);
            $get_properties=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_properties_filter);
            $get_dividends=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_dividends_filter);


            $data[$year] = array(
                'start_date' =>  $start_date, 
                'end_date'=> $end_date,
                'after_tax' => $m_journal_accounts->get_net_income(array($start_date,$end_date)),
                'provision_for_income_tax' => $this->get_numeric_value($get_provision_for_income_tax[0]->balance),
                'amortization' => $this->get_numeric_value($get_amortization[0]->balance),
                'receivables' => $this->get_numeric_value($get_receivables[0]->balance),
                'advances' => $this->get_numeric_value($get_advances[0]->balance),
                'prepayments' => $this->get_numeric_value($get_prepayments[0]->balance),
                'others' => $this->get_numeric_value($get_others[0]->balance),
                'payables' => $this->get_numeric_value($get_payables[0]->balance),
                'interests' => $this->get_numeric_value($get_interests[0]->balance),
                'taxes' => $this->get_numeric_value($get_taxes[0]->balance),
                'properties' => $this->get_numeric_value($get_properties[0]->balance),
                'dividends' => $this->get_numeric_value($get_dividends[0]->balance)
                );




            //set it to january 1, of specified date
            // $net_income_end=date("Y-m-d",strtotime($as_of_date));
            //     $prev_after_tax=$m_journal_accounts->get_net_income(array(
            //         $prev_date_start,
            //         $prev_date_end
            //     ));


            }

                   $double_underline = array(
                          'font'  => array(
                            'underline' => 'doubleAccounting'
                          )
                    );
                    $single_underline = array(
                          'font'  => array(
                            'underline' => 'singleAccounting'
                          )
                    );

                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("REPLENISHMENT BATCH REPORT");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A2:B2');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->setCellValue('A6','COMPARATIVE CASH FLOW STATEMENT')
                                            ->getStyle('A6')->getFont()->setBold(TRUE);


                    $i=9;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOWS FROM OPERATING ACTIVITIES'); $i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Income before income tax');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Adjustments for:');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Depreciation and amortization');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Operating income before working capital changes');$i++;
                    $i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Decrease  (increase) in:');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Receivables');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Advances');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Prepayments');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Other Current Assets');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Increase in accounts payable and other current liabilities');$i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Cash generated from operations');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Interest received');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Income taxes paid, including creditable withholding taxes');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Net cash from operating activities');$i++; $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOWS FROM INVESTING ACTIVITIES');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Addition of property and equipment');$i++;$i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOWS FROM FINANCING ACTIVITIES');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Dividends');$i++; $i++;


                    $excel->getActiveSheet()->setCellValue('A'.$i,'NET INCREASE DECREATE IN CASH AND CASH EQUIVALENTS');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH AND CASH EQUIVALENTS AT THE BEGINNING OF THE YEAR');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH AND CASH EQUIVALENTS AT THE END OF THE YEAR');$i++;

$a= 'B';

 $account_net_increase_in_cash =array();
foreach ($years as $year) {
$i = 8; 
$excel->getActiveSheet()->setCellValue($a.''.$i, $year);
$i++; $i++;

    $this_year = $year;
    $previous_year = $year-1;
    $next_year = $year+1;
    $sum_before_tax =   $data[$this_year]['after_tax'] - $data[$this_year]['provision_for_income_tax']; 
    $sum_amortization =   $data[$this_year]['amortization']; 
    $interests =   $data[$this_year]['interests']; 
    $taxes =   $data[$this_year]['taxes']; 
    $properties =   $data[$this_year]['properties'] + $data[$this_year]['amortization']; 
    $dividends =   $data[$this_year]['dividends']; 

    if (!isset($data[$previous_year])){
        // PREVIOUS PERIOD LESS CURRENT PERIOD
        $i_d_receivables =   - $data[$this_year]['receivables']; 
        $i_d_advances =  - $data[$this_year]['advances']; 
        $i_d_prepayments =  - $data[$this_year]['prepayments']; 
        $i_d_others =  - $data[$this_year]['others']; 

        // CURERNT PERIOD LESS PREVIOUS PERIOD
        $i_d_payables =  $data[$this_year]['payables']; 
    }else{
        // PREVIOUS PERIOD LESS CURRENT PERIOD
        $i_d_receivables =  $data[$previous_year]['receivables'] - $data[$this_year]['receivables']; 
        $i_d_advances = $data[$previous_year]['advances'] - $data[$this_year]['advances'];
        $i_d_prepayments = $data[$previous_year]['prepayments'] - $data[$this_year]['prepayments'];
        $i_d_others = $data[$previous_year]['others'] - $data[$this_year]['others'];

        // CURERNT PERIOD LESS PREVIOUS PERIOD
        $i_d_payables =  $data[$this_year]['payables'] - $data[$previous_year]['payables']; 

    }

    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($sum_before_tax,2)); $i++;$i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($sum_amortization,2)); $i++;
    $income_before_working_capital = (float)$sum_before_tax+(float)$sum_amortization;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($income_before_working_capital,2)); $i++; $i++;$i++;

    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($i_d_receivables,2)); $i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($i_d_advances,2)); $i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($i_d_prepayments,2));$i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($i_d_others,2));$i++;

    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($i_d_payables,2));$i++;
    $net_cash_operation = (float)$income_before_working_capital + (float)$i_d_receivables + (float)$i_d_advances + (float)$i_d_prepayments +(float)$i_d_others +(float)$i_d_payables;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($net_cash_operation,2));$i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($interests,2));$i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($taxes,2));$i++;
    $net_cash_activities = (float)$net_cash_operation + (float)$interests + (float)$taxes;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($net_cash_activities,2));$i++; $i++; $i++;

    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display(-$properties,2));$i++; $i++; $i++;
    $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display(-$dividends,2));$i++; $i++;
    $sum_ppe_dividends  = (float)$properties + (float)$dividends;

    $net_cash_equivalents = (float)$net_cash_activities - (float)$sum_ppe_dividends;

    $account_net_increase_in_cash[$year]  = $net_cash_equivalents;

    $cash_equivalent_previous_year[$next_year]  = $net_cash_equivalents;

    $excel->getActiveSheet()->setCellValue($a.''.$i,$this->format_display($net_cash_equivalents,2));$i++;
    $a++;
}

// $a = 'C';
// foreach ($years as $year) {
//     $this_year = $year;
//     $previous_year = $year-1;
//     $next_year = $year+1;
//         if(!isset($cash_equivalent_previous_year[$year])){
//             $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($account_net_increase_in_cash[$year],2));
//         }else{
//             $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($account_net_increase_in_cash[$year]+$cash_equivalent_previous_year[$year],2));
//         }

        
//     $a++;
// }
$i++;

// print_r($account_net_increase_in_cash);
// print_r($cash_equivalent_previous_year);

$b = 'B';
$c = 'C';
$total = 0;
foreach ($years as $year) {
    if(!isset($cash_equivalent_previous_year[$year])){
        $total  += $account_net_increase_in_cash[$year];
        $excel->getActiveSheet()->setCellValue($b.'34', $this->format_display($total,2));
        $excel->getActiveSheet()->setCellValue($c.'33', $this->format_display($total,2));
    }else {
        $total  += $account_net_increase_in_cash[$year];
        $excel->getActiveSheet()->setCellValue($b.'34', $this->format_display($total,2));
        $excel->getActiveSheet()->setCellValue($c.'33', $this->format_display($total,2));
    }
    $b++; $c++;
}


$excel->getActiveSheet()->getStyle('B10:E10')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B11:E11')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B12:E12')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B13:E13')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

$excel->getActiveSheet()->getStyle('B16:B24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('C16:C24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('D16:D24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('E16:E24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');


$excel->getActiveSheet()->getStyle('B27:E27')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B30:E30')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B32:E32')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B33:E33')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
$excel->getActiveSheet()->getStyle('B34:E34')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');


$excel->getActiveSheet()->getStyle('B10:B34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$excel->getActiveSheet()->getStyle('C10:C34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$excel->getActiveSheet()->getStyle('D10:D34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$excel->getActiveSheet()->getStyle('E10:E34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
// print_r($cash_equivalent_previous_year);

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."COMPARATIVE CASH FLOW STATEMENT.xlsx".'');
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

            case 'export-cash-flow-statement':
            $excel=$this->excel;                    
            $m_journal=$this->Journal_info_model;
            $m_company=$this->Company_model;
            $company_info=$m_company->get_list();
            $data['company_info']=$company_info[0];
            $m_journal_accounts=$this->Journal_account_model;
            $m_cash_flow = $this->Cash_flow_items_model;

            $latest_year = $this->input->get('year',TRUE); // GET LATEST YEAR TO COMPARE TO PREVIOUS YEARS
            $years= array();
            // BASELINE FOR YEAR IS 2017
            for($ii=2017;$ii<=$latest_year;$ii++){$years[] = $ii;} // GENERATE ARRAY FOR LOOPING

            // SET VARIABLES 
            $provisions=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>11),'account_id');
            $acc_provision_for_income_tax = [];
            foreach ($provisions as $provision) { $acc_provision_for_income_tax[]=$provision->account_id; }
            $acc_provision_filter =  implode(",", $acc_provision_for_income_tax);

            $depreciations=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>1),'account_id');
            $acc_depreciation = [];
            foreach ($depreciations as $depreciation) { $acc_depreciation[]=$depreciation->account_id; }
            $acc_amortization_filter =  implode(",", $acc_depreciation);

            $receivables=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>2),'account_id');
            $acc_receivable = [];
            foreach ($receivables as $receivable) { $acc_receivable[]=$receivable->account_id; }
            $acc_receivable_filter =  implode(",", $acc_receivable);

            $advances=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>3),'account_id');
            $acc_advances = [];
            foreach ($advances as $advance) { $acc_advances[]=$advance->account_id; }
            $acc_advances_filter =  implode(",", $acc_advances);

            $prepayments=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>4),'account_id');
            $acc_prepayments = [];
            foreach ($prepayments as $prepayment) { $acc_prepayments[]=$prepayment->account_id; }
            $acc_prepayments_filter =  implode(",", $acc_prepayments);

            $other_currents=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>5),'account_id');
            $acc_others = [];
            foreach ($other_currents as $other_current) { $acc_others[]=$other_current->account_id; }
            $acc_others_filter =  implode(",", $acc_others);

            $payables=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>6),'account_id');
            $acc_payables = [];
            foreach ($payables as $payable) { $acc_payables[]=$payable->account_id; }
            $acc_payables_filter =  implode(",", $acc_payables);

            $interests=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>7),'account_id');
            $acc_interest = [];
            foreach ($interests as $interest) { $acc_interest[]=$interest->account_id; }
            $acc_interest_filter =  implode(",", $acc_interest);

            $taxes=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>8),'account_id');
            $acc_tax = [];
            foreach ($taxes as $tax) { $acc_tax[]=$tax->account_id; }
            $acc_tax_filter =  implode(",", $acc_tax);

            $properties=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>9),'account_id');
            $acc_property = [];
            foreach ($properties as $property) { $acc_property[]=$property->account_id; }
            $acc_properties_filter =  implode(",", $acc_property);

            $dividends=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>10),'account_id');
            $acc_dividends = [];
            foreach ($dividends as $dividend) { $acc_dividends[]=$dividend->account_id; }
            $acc_dividends_filter =  implode(",", $acc_dividends);


            $data = array();
            foreach($years as $year){

            $start_date = date("Y-m-d",strtotime($year."-01-01"));
            $end_date = date("Y-m-d",strtotime($year."-12-31"));
            $get_provision_for_income_tax=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_provision_filter);
            $get_amortization=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_amortization_filter);
            $get_receivables=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_receivable_filter);
            $get_advances=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_advances_filter);
            $get_prepayments=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_prepayments_filter);
            $get_others=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_others_filter);
            $get_payables=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_payables_filter);
            $get_interests=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_interest_filter);
            $get_taxes=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_tax_filter);
            $get_properties=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_properties_filter);
            $get_dividends=$m_cash_flow->get_summation_account_subsidary(array($start_date,$end_date),$acc_dividends_filter);

            // GET RAW DATA BALANCES
            $data[$year] = array(
                'start_date' =>  $start_date, 
                'end_date'=> $end_date,
                'after_tax' => $m_journal_accounts->get_net_income(array($start_date,$end_date)),
                'provision_for_income_tax' => $this->get_numeric_value($get_provision_for_income_tax[0]->balance),
                'amortization' => $this->get_numeric_value($get_amortization[0]->balance),
                'receivables' => $this->get_numeric_value($get_receivables[0]->balance),
                'advances' => $this->get_numeric_value($get_advances[0]->balance),
                'prepayments' => $this->get_numeric_value($get_prepayments[0]->balance),
                'others' => $this->get_numeric_value($get_others[0]->balance),
                'payables' => $this->get_numeric_value($get_payables[0]->balance),
                'interests' => $this->get_numeric_value($get_interests[0]->balance),
                'taxes' => $this->get_numeric_value($get_taxes[0]->balance),
                'properties' => $this->get_numeric_value($get_properties[0]->balance),
                'dividends' => $this->get_numeric_value($get_dividends[0]->balance)
                );

            }

            // COMPARISONS OF RAW BALANCES, SUMMARY OF BALANCES
            $total = 0;
            $beginning = array(); 
            $ending = array();
            $raw = array();
            $account_net_increase_in_cash =array();
            foreach ($years as $year) {
                $this_year = $year;
                $previous_year = $year-1;
                $next_year = $year+1;
                $sum_before_tax =   $data[$this_year]['after_tax'] - $data[$this_year]['provision_for_income_tax']; 
                $sum_amortization =   $data[$this_year]['amortization']; 
                $interests =   $data[$this_year]['interests']; 
                $taxes =   $data[$this_year]['taxes']; 
                $properties =   $data[$this_year]['properties']; 
                $dividends =   $data[$this_year]['dividends']; 

                if (!isset($data[$previous_year])){
                    // PREVIOUS PERIOD LESS CURRENT PERIOD
                    $i_d_receivables =   - $data[$this_year]['receivables']; 
                    $i_d_advances =  - $data[$this_year]['advances']; 
                    $i_d_prepayments =  - $data[$this_year]['prepayments']; 
                    $i_d_others =  - $data[$this_year]['others']; 

                    // CURERNT PERIOD LESS PREVIOUS PERIOD
                    $i_d_payables =  $data[$this_year]['payables']; 
                }else{
                    // PREVIOUS PERIOD LESS CURRENT PERIOD
                    $i_d_receivables =  $data[$previous_year]['receivables'] - $data[$this_year]['receivables']; 
                    $i_d_advances = $data[$previous_year]['advances'] - $data[$this_year]['advances'];
                    $i_d_prepayments = $data[$previous_year]['prepayments'] - $data[$this_year]['prepayments'];
                    $i_d_others = $data[$previous_year]['others'] - $data[$this_year]['others'];

                    // CURERNT PERIOD LESS PREVIOUS PERIOD
                    $i_d_payables =  $data[$this_year]['payables'] - $data[$previous_year]['payables']; 

                }

                // SUMMATIONS SUMMARY
                $income_before_working_capital = (float)$sum_before_tax+(float)$sum_amortization;
                $net_cash_operation = (float)$income_before_working_capital + (float)$i_d_receivables + (float)$i_d_advances + (float)$i_d_prepayments +(float)$i_d_others +(float)$i_d_payables;
                $net_cash_activities = (float)$net_cash_operation + (float)$interests + (float)$taxes;
                $sum_ppe_dividends  = (float)$properties + (float)$dividends;
                $net_cash_equivalents = (float)$net_cash_activities - (float)$sum_ppe_dividends;
                $account_net_increase_in_cash[$year]  = $net_cash_equivalents;
                $cash_equivalent_previous_year[$next_year]  = $net_cash_equivalents;
                $total  += $account_net_increase_in_cash[$year];


                // ADDING IN FINAL YEARLY DATA  (PROCESSED)
                $raw[$year] = array(
                    'sum_before_tax' => $sum_before_tax,
                    'sum_amortization'=>$sum_amortization,
                    'income_before_working_capital'=>$income_before_working_capital,
                    'i_d_receivables'=>$i_d_receivables,
                    'i_d_advances'=>$i_d_advances,
                    'i_d_prepayments'=>$i_d_prepayments,
                    'i_d_others'=>$i_d_others,
                    'i_d_payables'=>$i_d_payables,
                    'net_cash_operation'=>$net_cash_operation,
                    'interests'=>$interests,
                    'taxes'=>$taxes,
                    'net_cash_activities'=>$net_cash_activities,
                    'properties'=>$properties,
                    'dividends'=>$dividends,
                    'net_cash_equivalents'=>$net_cash_equivalents,
                    );
                $beginning[$year+1] = array('beginning_of_year'=> $total);
                $ending[$year] = array('ending'=> $total);

            }

                    $double_underline = array(
                          'font'  => array(
                            'underline' => 'doubleAccounting'
                          )
                    );
                    $single_underline = array(
                          'font'  => array(
                            'underline' => 'singleAccounting'
                          )
                    );

                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("REPLENISHMENT BATCH REPORT");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A2:B2');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->setCellValue('A6','COMPARATIVE CASH FLOW STATEMENT')
                                            ->getStyle('A6')->getFont()->setBold(TRUE);


                    $i=9;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOWS FROM OPERATING ACTIVITIES'); $i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Income before income tax');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Adjustments for:');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Depreciation and amortization');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Operating income before working capital changes');$i++;
                    $i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Decrease  (increase) in:');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Receivables');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Advances');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Prepayments');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Other Current Assets');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Increase in accounts payable and other current liabilities');$i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'Cash generated from operations');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Interest received');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Income taxes paid, including creditable withholding taxes');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Net cash from operating activities');$i++; $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOWS FROM INVESTING ACTIVITIES');$i++;
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Addition of property and equipment');$i++;$i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH FLOWS FROM FINANCING ACTIVITIES');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Dividends');$i++; $i++;


                    $excel->getActiveSheet()->setCellValue('A'.$i,'NET INCREASE DECREATE IN CASH AND CASH EQUIVALENTS');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($single_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH AND CASH EQUIVALENTS AT THE BEGINNING OF THE YEAR');$i++;
                    $excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($double_underline);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'CASH AND CASH EQUIVALENTS AT THE END OF THE YEAR');$i++;


                    $this_year  = $latest_year;
                    $last_year = $this_year - 1;
                    


                     $a= 'B';
                    for($this_year;$this_year>=$last_year;$this_year--){
                        $i = 8; 
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this_year);
                        $i++; $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['sum_before_tax'],2)); $i++;$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['sum_amortization'],2)); $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['income_before_working_capital'],2)); $i++; $i++;$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['i_d_receivables'],2)); $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['i_d_advances'],2)); $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['i_d_prepayments'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['i_d_others'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['i_d_payables'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['net_cash_operation'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['interests'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['taxes'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($raw[$this_year]['net_cash_activities'],2));$i++; $i++; $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display(-$raw[$this_year]['properties'],2));$i++; $i++; $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display(-$raw[$this_year]['dividends'],2));$i++; $i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i,$this->format_display($raw[$this_year]['net_cash_equivalents'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($beginning[$this_year]['beginning_of_year'],2));$i++;
                        $excel->getActiveSheet()->setCellValue($a.''.$i, $this->format_display($ending[$this_year]['ending'],2));
                        $a++;

                    } 

                    $excel->getActiveSheet()->getStyle('B10:E10')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B11:E11')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B12:E12')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B13:E13')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                    $excel->getActiveSheet()->getStyle('B16:B24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('C16:C24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('D16:D24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('E16:E24')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');


                    $excel->getActiveSheet()->getStyle('B27:E27')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B30:E30')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B32:E32')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B33:E33')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->getStyle('B34:E34')->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');


                    $excel->getActiveSheet()->getStyle('B10:B34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()->getStyle('C10:C34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()->getStyle('D10:D34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()->getStyle('E10:E34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."COMPARATIVE CASH FLOW STATEMENT.xlsx".'');
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
