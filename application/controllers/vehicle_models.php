<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vehicle_models extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Vehicle_model');
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
        $data['title'] = 'Vehicle Models Management';

        (in_array('4-10',$this->session->user_rights)? 
        $this->load->view('vehicle_models_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_models = $this->Vehicle_model;
                $response['data'] = $m_models->get_list(array('is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'create':
                $m_models = $this->Vehicle_model;

                $model_name = $this->input->post('model_name', TRUE);

                //validate model
                $check_model=$m_models->check_model($model_name);

                if(count($check_model)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$model_name.' is already existing. <br/>Please make sure model is unique!<br />';
                    die(json_encode($response));
                }

                $m_models->begin();

                $m_models->model_name = $model_name;
                $m_models->save();

                $model_id = $m_models->last_insert_id();

                $m_models->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Created Vehicle Model: '.$this->input->post('model_name', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Vehicle Model Information successfully created.';
                $response['row_added'] = $m_models->get_models_list($model_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_models=$this->Vehicle_model;

                $model_id=$this->input->post('model_id',TRUE);
                $m_models->is_deleted=1;
                if($m_models->modify($model_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Vehicle Model Information successfully deleted.';

                    $models = $m_models->get_list($model_id,'model_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Deleted Vehicle Model: '.$models[0]->model_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_models=$this->Vehicle_model;

                $model_id=$this->input->post('model_id',TRUE);
                $model_name = $this->input->post('model_name',TRUE);
                //validate model
                $check_model=$m_models->check_model($model_name,$model_id);
                
                if(count($check_model)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$model_name.' is already existing. <br/>Please make sure model is unique!<br />';
                    die(json_encode($response));
                }

                $m_models->begin();

                $m_models->model_name=$model_name;
                $m_models->modify($model_id);

                $m_models->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Updated Vehicle Model: '.$this->input->post('model_name',TRUE).' ID('.$model_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Vehicle Model Information successfully updated.';
                $response['row_updated']=$m_models->get_models_list($model_id);
                echo json_encode($response);

                break;
        }
    }
}
