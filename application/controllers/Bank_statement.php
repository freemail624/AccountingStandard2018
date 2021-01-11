<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_statement extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Bank_statement_model');
        $this->load->model('Bank_statement_item_model');
        $this->load->model('Account_title_model');
        $this->load->model('Months_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Bank Statement';

        $data['accounts']=$this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $data['months']=$this->Months_model->get_list();
        (in_array('11-2',$this->session->user_rights)? 
        $this->load->view('bank_statement_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_bank_statement = $this->Bank_statement_model;
                $year = $this->input->get('year',TRUE);
                $account_id = $this->input->get('account_id',TRUE);

                $response['data'] = $m_bank_statement->get_bank_statement_list(null,$year,$account_id);
                echo json_encode($response);
                break;

            case 'check_bank_statement':
                $m_bank_statement = $this->Bank_statement_model;

                $account = $this->input->post('account_id',TRUE);
                $month_id = $this->input->post('month_id',TRUE);
                $year_id = $this->input->post('year_id',TRUE);

                $account_id = 0;

                if ($account != null || ""){
                    $account_id = $this->input->post('account_id',TRUE);
                }

                $response['data'] = $m_bank_statement->get_bank_statement_recon_list($year_id,$account_id,$month_id);
                echo json_encode($response);
                break;

            case 'items':
                $m_items=$this->Bank_statement_item_model;
                $bank_statement_id = $this->input->get('id',TRUE);
                $data['items']=$m_items->get_items($bank_statement_id);
                echo $this->load->view('template/bank_statement_items',$data,TRUE);
                break;

            case 'bank-items':
                $m_items=$this->Bank_statement_item_model;

                $account_id = $this->input->get('account_id',TRUE);
                $month_id = $this->input->get('month_id',TRUE);
                $year_id = $this->input->get('year_id',TRUE);

                $data['items']=$m_items->get_bank_items($account_id,$month_id,$year_id);
                echo $this->load->view('template/bank_statement_items',$data,TRUE);
                break;

            case 'create':
                $m_bank_statement = $this->Bank_statement_model;
                $m_bank_statement_items = $this->Bank_statement_item_model;

                $month_id = $this->input->post('month_id', TRUE);
                $year_id = $this->input->post('year_id', TRUE);
                $account_id = $this->input->post('account_id',TRUE);

                $month = $this->Months_model->get_list($month_id);

                $check_month = $m_bank_statement->get_list(array('month_id'=>$month_id,'year'=>$year_id,'is_deleted'=>FALSE,'is_active'=>TRUE));

                if(count($check_month) > 0){
                    $response['title'] = 'Error!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Bank Statement of '.$month[0]->month_name.' '.$year_id.' is already existed!';
                    echo json_encode($response);
                    exit();
                }

                $m_bank_statement->begin();

                // ## Saving Bank Statement Entries
                $opening_balance = $this->input->post('opening_balance',TRUE);
                $closing_balance = $this->input->post('closing_balance',TRUE);

                $general_ledger_date = $this->input->post('general_ledger_date',TRUE);
                $value_date = $this->input->post('value_date',TRUE);
                $cheque_no = $this->input->post('cheque_no',TRUE);
                $dr_amount = $this->input->post('dr_amount',TRUE);
                $cr_amount = $this->input->post('cr_amount',TRUE);
                $balance_amount = $this->input->post('balance_amount', TRUE);
                $remarks = $this->input->post('memo',TRUE);

                $m_bank_statement->month_id = $month_id;
                $m_bank_statement->year = $year_id;
                $m_bank_statement->account_id = $account_id;
                $m_bank_statement->opening_balance = $this->get_numeric_value($opening_balance);
                $m_bank_statement->closing_balance = $this->get_numeric_value($closing_balance);
                $m_bank_statement->save();

                $bank_statement_id = $m_bank_statement->last_insert_id();

                for ($i=0; $i < count($balance_amount); $i++) { 
                    $m_bank_statement_items->bank_statement_id = $bank_statement_id;
                    $m_bank_statement_items->general_ledger_date = date('Y-m-d',strtotime($general_ledger_date[$i]));
                    $m_bank_statement_items->value_date = date('Y-m-d',strtotime($value_date[$i]));
                    $m_bank_statement_items->check_no = $cheque_no[$i];
                    $m_bank_statement_items->dr_amount = $this->get_numeric_value($dr_amount[$i]);
                    $m_bank_statement_items->cr_amount = $this->get_numeric_value($cr_amount[$i]);
                    $m_bank_statement_items->balance_amount = $this->get_numeric_value($balance_amount[$i]);
                    $m_bank_statement_items->remarks = $remarks[$i];
                    $m_bank_statement_items->save();
                }

                $m_bank_statement->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Created Bank Statement for : '.$month[0]->month_name.' '.$year_id;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Bank statement successfully created.';
                $response['row_added'] = $m_bank_statement->get_bank_statement_list($bank_statement_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_bank_statement=$this->Bank_statement_model;

                $bank_statement_id=$this->input->post('bank_statement_id',TRUE);
                $bank_statement = $m_bank_statement->get_bank_statement_list($bank_statement_id);

                $m_bank_statement->is_deleted=1;
                if($m_bank_statement->modify($bank_statement_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Bank Statement information successfully deleted.';

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Deleted Bank statement for : '.$bank_statement[0]->month_name.' '.$bank_statement[0]->year;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_bank_statement = $this->Bank_statement_model;
                $m_bank_statement_items = $this->Bank_statement_item_model;

                $bank_statement_id = $this->input->post('bank_statement_id', TRUE);

                $month_id = $this->input->post('month_id', TRUE);
                $year_id = $this->input->post('year_id', TRUE);
                $month = $this->Months_model->get_list($month_id);

                $check_month = $m_bank_statement->get_list(array('month_id'=>$month_id,'year'=>$year_id,'is_deleted'=>FALSE,'is_active'=>TRUE,'bank_statement_id'!=$bank_statement_id));

                if(count($check_month) > 0){
                    $response['title'] = 'Error!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Bank Statement of '.$month[0]->month_name.' '.$year_id.' is already existed!';
                    echo json_encode($response);
                    exit();
                }

                $m_bank_statement->begin();

                // ## Saving Bank Statement Entries
                $opening_balance = $this->input->post('opening_balance',TRUE);
                $closing_balance = $this->input->post('closing_balance',TRUE);

                $general_ledger_date = $this->input->post('general_ledger_date',TRUE);
                $value_date = $this->input->post('value_date',TRUE);
                $cheque_no = $this->input->post('cheque_no',TRUE);
                $dr_amount = $this->input->post('dr_amount',TRUE);
                $cr_amount = $this->input->post('cr_amount',TRUE);
                $balance_amount = $this->input->post('balance_amount', TRUE);
                $remarks = $this->input->post('memo',TRUE);

                $m_bank_statement->month_id = $month_id;
                $m_bank_statement->year = $year_id;
                $m_bank_statement->account_id=$this->input->post('account_id',TRUE);
                $m_bank_statement->opening_balance = $this->get_numeric_value($opening_balance);
                $m_bank_statement->closing_balance = $this->get_numeric_value($closing_balance);
                $m_bank_statement->modify($bank_statement_id);

                $m_bank_statement_items->delete_via_fk($bank_statement_id); //delete previous items then insert those new

                for ($i=0; $i < count($balance_amount); $i++) { 
                    $m_bank_statement_items->bank_statement_id = $bank_statement_id;
                    $m_bank_statement_items->general_ledger_date = date('Y-m-d',strtotime($general_ledger_date[$i]));
                    $m_bank_statement_items->value_date = date('Y-m-d',strtotime($value_date[$i]));
                    $m_bank_statement_items->check_no = $cheque_no[$i];
                    $m_bank_statement_items->dr_amount = $this->get_numeric_value($dr_amount[$i]);
                    $m_bank_statement_items->cr_amount = $this->get_numeric_value($cr_amount[$i]);
                    $m_bank_statement_items->balance_amount = $this->get_numeric_value($balance_amount[$i]);
                    $m_bank_statement_items->remarks = $remarks[$i];
                    $m_bank_statement_items->save();
                }

                $m_bank_statement->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Updated Bank Statement for : '.$month[0]->month_name.' '.$year_id.' ID('.$bank_statement_id.')';
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Bank statement successfully updated.';
                $response['row_updated'] = $m_bank_statement->get_bank_statement_list($bank_statement_id);
                echo json_encode($response);

                break;

        }
    }
}
