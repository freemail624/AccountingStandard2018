<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_types extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Check_types_model');
        $this->load->model('Users_model');
        $this->load->model('Account_title_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Check Types Management';
        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        (in_array('4-6',$this->session->user_rights)? 
        $this->load->view('check_type_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_checktype = $this->Check_types_model;
                $response['data'] = $m_checktype->get_list(array('b_refchecktype.is_deleted'=>0),
                    'b_refchecktype.*,account_titles.account_title',
                    array(array('account_titles','account_titles.account_id = b_refchecktype.account_id','left')));
                echo json_encode($response);
                break;

            case 'create':
                $m_checktype = $this->Check_types_model;

                $m_checktype->check_type_code = $this->input->post('check_type_code', TRUE);
                $m_checktype->check_type_desc = $this->input->post('check_type_desc', TRUE);
                $m_checktype->account_id = $this->input->post('account_id', TRUE);
                $m_checktype->save();
                $check_type_id = $m_checktype->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Check Type information successfully created.';
                $response['row_added'] = $m_checktype->get_list($check_type_id,                    
                    'b_refchecktype.*,account_titles.account_title',array(array('account_titles','account_titles.account_id = b_refchecktype.account_id','left')));
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=49; // TRANS TYPE
                $m_trans->trans_log='Created Check Type: '.$this->input->post('check_type_desc', TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_checktype=$this->Check_types_model;

                $check_type_id=$this->input->post('check_type_id',TRUE);

                $m_checktype->is_deleted=1;
                if($m_checktype->modify($check_type_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Check Type information successfully deleted.';

                    $check_type_desc = $m_checktype->get_list($check_type_id,'check_type_desc');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=49; // TRANS TYPE
                    $m_trans->trans_log='Deleted Check Type: '.$check_type_desc[0]->check_type_desc;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_checktype=$this->Check_types_model;

                $check_type_id=$this->input->post('check_type_id',TRUE);
                $m_checktype->check_type_code = $this->input->post('check_type_code', TRUE);
                $m_checktype->check_type_desc = $this->input->post('check_type_desc', TRUE);
                $m_checktype->account_id = $this->input->post('account_id', TRUE);

                $m_checktype->modify($check_type_id);


                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=49; // TRANS TYPE
                $m_trans->trans_log='Updated Check Type : '.$this->input->post('check_type_desc', TRUE).' ID('.$check_type_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Check Type information successfully updated.';
                $response['row_updated']=$m_checktype->get_list($check_type_id,                    
                    'b_refchecktype.*,account_titles.account_title',array(array('account_titles','account_titles.account_id = b_refchecktype.account_id','left')));
                echo json_encode($response);

                break;
        }
    }
}
