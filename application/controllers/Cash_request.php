<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_request extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Cash_request_model');
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
        $data['title'] = 'Cash Request';
        (in_array('17-1',$this->session->user_rights)? 
        $this->load->view('cash_request_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_cash_request = $this->Cash_request_model;
                $response['data'] = $m_cash_request->get_request_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_cash_request = $this->Cash_request_model;

                $m_cash_request->requesting_unit = $this->input->post('requesting_unit', TRUE);
                $m_cash_request->request_date = date('Y-m-d',strtotime($this->input->post('request_date', TRUE)));
                $m_cash_request->requested_amount = $this->get_numeric_value($this->input->post('requested_amount', TRUE));
                $m_cash_request->request_description = $this->input->post('request_description', TRUE);
                $m_cash_request->date_needed = date('Y-m-d',strtotime($this->input->post('date_needed', TRUE)));
                $m_cash_request->account_number = $this->input->post('account_number', TRUE);

                $m_cash_request->save();

                $cash_request_id = $m_cash_request->last_insert_id();

                //update cash request number base on formatted last insert id
                $cash_request_no='CR-'.date('Ymd').'-'.$cash_request_id;
                $m_cash_request->cash_request_no=$cash_request_no;
                $m_cash_request->modify($cash_request_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=72; // TRANS TYPE
                $m_trans->trans_log='Created Cash Request for '.$this->input->post('requesting_unit', TRUE).' : Request# '.$cash_request_no;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Cash Request successfully created.';
                $response['row_added'] = $m_cash_request->get_request_list($cash_request_id);
                echo json_encode($response);

                break;

            case 'update':
                $m_cash_request=$this->Cash_request_model;

                $cash_request_id=$this->input->post('cash_request_id',TRUE);

                $m_cash_request->requesting_unit = $this->input->post('requesting_unit', TRUE);
                $m_cash_request->request_date = date('Y-m-d',strtotime($this->input->post('request_date', TRUE)));
                $m_cash_request->requested_amount = $this->get_numeric_value($this->input->post('requested_amount', TRUE));
                $m_cash_request->request_description = $this->input->post('request_description', TRUE);
                $m_cash_request->date_needed = date('Y-m-d',strtotime($this->input->post('date_needed', TRUE)));
                $m_cash_request->account_number = $this->input->post('account_number', TRUE);
                $m_cash_request->modify($cash_request_id);

                $cash_request = $m_cash_request->get_list($cash_request_id,'cash_request_no');

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=72; // TRANS TYPE
                $m_trans->trans_log='Updated Cash Request: Request#('.$cash_request[0]->cash_request_no.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Cash Request successfully updated.';
                $response['row_updated']=$m_cash_request->get_request_list($cash_request_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_cash_request=$this->Cash_request_model;

                $cash_request_id=$this->input->post('cash_request_id',TRUE);
                $m_cash_request->is_deleted=1;

                if($m_cash_request->modify($cash_request_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Cash Request successfully deleted.';

                    $cash_request = $m_cash_request->get_list($cash_request_id,'cash_request_no');

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=72; // TRANS TYPE
                    $m_trans->trans_log='Deleted Cash Request : '.$cash_request[0]->cash_request_no;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

        }
    }
}
