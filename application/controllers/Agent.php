<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Agent_model');
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['title']='Agent Management';

        (in_array('5-5',$this->session->user_rights)? 
        $this->load->view('agent_view',$data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_agent=$this->Agent_model;
                $response['data']=$m_agent->get_list(array('agent.is_deleted'=>FALSE));
                echo json_encode($response);

                break;

            case 'create':
                $m_agent=$this->Agent_model;

                $m_agent->set('date_created','NOW()');
                $m_agent->agent_code=$this->input->post('agent_code',TRUE);
                $m_agent->agent_name=$this->input->post('agent_name',TRUE);
                $m_agent->created_by_user=$this->session->user_id;
                $m_agent->save();

                $agent_id=$m_agent->last_insert_id();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Agent Information successfully created.';
                $response['row_added']= $m_agent->get_list($agent_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=68; // TRANS TYPE
                $m_trans->trans_log='Created Agent: '.$this->input->post('agent_name',TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_agent=$this->Agent_model;
                $agent_id=$this->input->post('agent_id',TRUE);
                
                $m_agent->set('date_deleted','NOW()');
                $m_agent->deleted_by_user=$this->session->user_id;
                $m_agent->is_deleted=1;

                if($m_agent->modify($agent_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Agent information successfully deleted.';
                    $m_trans=$this->Trans_model;

                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=68; // TRANS TYPE
                    $m_trans->trans_log='Deleted Agent: ID('.$agent_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_agent=$this->Agent_model;
                $agent_id=$this->input->post('agent_id',TRUE);

                $m_agent->set('date_modified','NOW()');
                $m_agent->agent_code=$this->input->post('agent_code',TRUE);
                $m_agent->agent_name=$this->input->post('agent_name',TRUE);
                $m_agent->modified_by_user=$this->session->user_id;
                $m_agent->modify($agent_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Agent Information successfully updated.';
                $response['row_updated']=$m_agent->get_list($agent_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=68; // TRANS TYPE
                $m_trans->trans_log='Updated Agent: ID('.$agent_id.')'; 
                $m_trans->save();

                echo json_encode($response);

                break;
       	}
    }
}
