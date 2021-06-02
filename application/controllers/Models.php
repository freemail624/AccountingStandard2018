<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Models_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Model Management';
        (in_array('4-11',$this->session->user_rights)? 
        $this->load->view('model_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_model = $this->Models_model;
                $response['data'] = $m_model->get_model_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_model = $this->Models_model;

                $m_model->model_name = $this->input->post('model_name', TRUE);
                $m_model->save();

                $model_id = $m_model->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=76; // TRANS TYPE
                $m_trans->trans_log='Created New Model : '.$this->input->post('model_name', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Model Information successfully created.';
                $response['row_added'] = $m_model->get_model_list($model_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_model=$this->Models_model;

                $model_id=$this->input->post('model_id',TRUE);
                $m_model->is_deleted=1;

                if($m_model->modify($model_id)){

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=76; // TRANS TYPE
                    $m_trans->trans_log='Deleted Model ID('.$this->input->post('model_id',TRUE).')';
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Model Information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_model=$this->Models_model;

                $model_id=$this->input->post('model_id',TRUE);
                $m_model->model_name=$this->input->post('model_name',TRUE);

                $m_model->modify($model_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=76; // TRANS TYPE
                $m_trans->trans_log='Updated Model ID('.$this->input->post('model_id',TRUE).') : '.$this->input->post('model_name', TRUE);
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Model Information successfully updated.';
                $response['row_updated']=$m_model->get_model_list($model_id);
                echo json_encode($response);

                break;
        }
    }
}
