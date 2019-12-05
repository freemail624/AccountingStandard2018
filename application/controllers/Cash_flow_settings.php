<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_flow_settings extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Cash_flow_ref_model',
                'Cash_flow_items_model',
                'Account_title_model',
                'Users_model',
                'Trans_model',
                'Journal_account_model',
                'Company_model',
                'Journal_info_model'
            )
        );
        $this->load->library('excel');
        $this->load->model('Email_settings_model');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['accounts']=$this->Account_title_model->get_list(
            'account_titles.is_active=1 AND account_titles.is_deleted=0',
            array(
                'account_titles.*',
                'ac.account_class',
                'at.account_type',
                'cfi.cash_flow_ref_id'
            ),
            array(
                array( 'account_classes as ac','ac.account_class_id=account_titles.account_class_id','left'),
                array( 'account_types as at','at.account_type_id=ac.account_type_id','left'),
                array( 'cash_flow_items cfi','cfi.account_id=account_titles.account_id','left')
            ),
            'account_class_id,account_no'
        );

        $data['cash_flow_references'] =$this->Cash_flow_ref_model->get_list();


        $data['title'] = 'Cash Flow Settings';
        // (in_array('4-3',$this->session->user_rights)? 
        $this->load->view('cash_flow_settings_view', $data);
        // :redirect(base_url('dashboard')));
        
    }

    function transaction($txn) {
        switch ($txn) {
            case  'save-cash-flow-configuration':
                $this->db->truncate('cash_flow_items'); 
                $account_id = $this->input->post('account_id', TRUE);
                $cash_flow_ref_id = $this->input->post('ref_id', TRUE);

                $m_cash_flow = $this->Cash_flow_items_model;
                for($i=0;$i<count($account_id);$i++){
                    if($cash_flow_ref_id[$i]  > 0){
                       $m_cash_flow->account_id = $account_id[$i];
                       $m_cash_flow->cash_flow_ref_id = $cash_flow_ref_id[$i];
                       $m_cash_flow->save();
                    } // END OF IF
                } // END OF FOR LOOP


                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Cash Flow Configuration Saved.';
                echo json_encode($response);

            break;

            case 'array':
            $m_journal_accounts=$this->Journal_account_model;
            $m_cash_flow = $this->Cash_flow_items_model;
            $years = ['2020','2021','2022'];


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

            $dividends=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>9),'account_id');
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



            print_r($data);
            // // print_r($data);
            // $i_d_receivables = 0;
            // $i_d_advances = 0;
            // foreach ($years as $year) {
            //     $this_year = $year;
            //     $previous_year = $year-1;
            //     echo $this_year; echo '&nbsp;';
            //         abs($i_d_receivables);
            //                 if (!isset($data[$previous_year])){
            //                 $i_d_receivables =   - $data[$this_year]['receivables']; 
            //                 $i_d_advances =  - $data[$this_year]['advances']; 

            //                 }else{

            //                 $i_d_receivables =  $data[$previous_year]['receivables'] - $data[$this_year]['receivables']; 
            //                 $i_d_advances = $data[$previous_year]['advances'] - $data[$this_year]['advances']; 

            //                 }






            //          echo $i_d_receivables;  echo '<br>';
            //          echo $i_d_advances;  echo '<br>';
            // }

            // // echo $data['2019']['receivables'];
            // // print_r($data);

            // // print_r($data['2018']); echo '<br>';
            // // print_r($data['2019']); echo '<br>';
            break;





            case 'computation':
                $m_journal_accounts=$this->Journal_account_model;
                

                $prev_date_start=date("Y-m-d",strtotime("2018-01-01"));
                $prev_date_end=date("Y-m-d",strtotime("2018-12-31"));

                $cur_date_start=date("Y-m-d",strtotime("2019-01-01"));
                $cur_date_end=date("Y-m-d",strtotime("2019-12-31"));
                // PREVIOUS INCOME AFTER INCOME TAX
                $prev_after_tax=$m_journal_accounts->get_net_income(array(
                    $prev_date_start,
                    $prev_date_end
                ));
                // CURRENT INCOME AFTER INCOME TAX
                $current_after_tax=$m_journal_accounts->get_net_income(array(
                    $cur_date_start,
                    $cur_date_end
                ));

                // !! GET PROVISION FOR INCOME TAX 
                $provisions=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>11),'account_id');
                $acc_provision_for_income_tax = [];
                foreach ($provisions as $provision) { $acc_provision_for_income_tax[]=$provision->account_id; }
                $acc_provision_filter =  implode(",", $acc_provision_for_income_tax);
                $prev_provision_for_income_tax = 0;
                $cur_provision_for_income_tax = 0;
                if($acc_provision_filter != ''){
                    // PREVIOUS PROVISION FOR INCOME TAX
                    $get_prev_provision_for_income_tax=$m_cash_flow->get_summation_account_subsidary(array($prev_date_start,$prev_date_end),$acc_provision_filter);
                    $prev_provision_for_income_tax = $this->get_numeric_value($get_prev_provision_for_income_tax[0]->balance);
                     // CURRENT PROVISION FOR INCOME TAX
                    $get_cur_provision_for_income_tax=$m_cash_flow->get_summation_account_subsidary(array($cur_date_start,$cur_date_end),$acc_provision_filter);
                    $cur_provision_for_income_tax = $this->get_numeric_value($get_cur_provision_for_income_tax[0]->balance);
                }
                // PREVIOUS INCOME BEFORE INCOME TAX
                $prev_before_tax = $prev_after_tax + $prev_provision_for_income_tax;
                // CURRENT INCOME BEFORE INCOME TAX
                $current_before_tax = $current_after_tax + $cur_provision_for_income_tax;



                // !! GET AMORTIZATION AND DEPRECIATION 
                $accounts=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>1),'account_id');
                $acc_depreciation = [];
                foreach ($accounts as $account) { $acc_depreciation[]=$account->account_id; }
                $acc_amortization_filter =  implode(",", $acc_depreciation);
                $prev_amortization = 0;
                $cur_amortization = 0;
                if($acc_amortization_filter != ''){
                    // PREVIOUS AMORTIZATION
                    $get_prev_amortization=$m_cash_flow->get_summation_account_subsidary(array($prev_date_start,$prev_date_end),$acc_amortization_filter);
                    $prev_amortization = $this->get_numeric_value($get_prev_amortization[0]->balance);
                     // CURRENT AMORTIZATION
                    $get_cur_amortization=$m_cash_flow->get_summation_account_subsidary(array($cur_date_start,$cur_date_end),$acc_amortization_filter);
                    $cur_amortization = $this->get_numeric_value($get_cur_amortization[0]->balance);
                }


                // !! GET RECEIVABLES FIRST THEN COMPUTE
                // GET RECEIVABLES
                $accounts=$this->Cash_flow_items_model->get_list(array('cash_flow_ref_id'=>2),'account_id');
                $acc_depreciation = [];
                foreach ($accounts as $account) { $acc_depreciation[]=$account->account_id; }
                $acc_amortization_filter =  implode(",", $acc_depreciation);
                $prev_receivables = 0;
                $cur_receivables = 0;
                if($acc_amortization_filter != ''){
                    // PREVIOUS RECEIVABLES
                    $get_prev_receivables=$m_cash_flow->get_summation_account_subsidary(array($prev_date_start,$prev_date_end),$acc_amortization_filter);
                    $prev_receivables = $this->get_numeric_value($get_prev_receivables[0]->balance);
                     // CURRENT RECEIVABLES
                    $get_cur_receivables=$m_cash_flow->get_summation_account_subsidary(array($cur_date_start,$cur_date_end),$acc_amortization_filter);
                    $cur_receivables = $this->get_numeric_value($get_cur_receivables[0]->balance);
                }

                // COMPUTE FOR RECEIVABLES
                $cur_i_d_receivables = $prev_receivables - $cur_receivables;


                echo "Prev after tax ";
                echo $prev_after_tax;   echo "<br>";
                echo "Prev Provision ";
                echo $prev_provision_for_income_tax; echo "<br>";
                echo "Prev Before Tax ";
                echo $prev_before_tax; echo "<br>";
                echo "Cur after tax ";
                echo $current_after_tax; echo "<br>";
                echo "Cur Provision ";
                echo $cur_provision_for_income_tax; echo "<br>";
                echo "Cur Before Tax";
                echo $current_before_tax; echo "<br>";



                echo "Prev Amortization ";
                echo $prev_amortization; echo "<br>";
                echo "Cur Amortization";
                echo $cur_amortization; echo "<br>";


                echo "Prev Receivables ";
                echo $prev_receivables; echo "<br>";
                echo "Cur Receivables";
                echo $cur_receivables; echo "<br>";

                echo "Cur Receivables";
                echo $cur_i_d_receivables; echo "<br>";
                

                // echo json_encode($data);
            break;


               
        }
    }
}

?>
