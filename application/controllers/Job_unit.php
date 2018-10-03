<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_unit extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Job_unit_model');
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
        $data['title'] = 'Jobs Unit Management';
        // (in_array('13-4',$this->session->user_rights)?
        $this->load->view('job_unit_view', $data);
        // :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_units = $this->Job_unit_model;
                $response['data'] = $m_units->get_job_unit_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_units = $this->Job_unit_model;

                $m_units->job_unit_name = $this->input->post('job_unit_name', TRUE);
                $m_units->job_unit_desc = $this->input->post('job_unit_desc', TRUE);
                $m_units->save();

                $job_unit_id = $m_units->last_insert_id();

        
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=77; // TRANS TYPE
                $m_trans->trans_log='Created Job Unit: '. $this->input->post('job_unit_name', TRUE);;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Unit information successfully created.';
                $response['row_added'] = $m_units->get_job_unit_list($job_unit_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_units=$this->Job_unit_model;

                $job_unit_id=$this->input->post('job_unit_id',TRUE);

                $m_units->is_deleted=1;
                if($m_units->modify($job_unit_id)){


                    $job_unit_name = $m_units->get_list($job_unit_id,'job_unit_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=77; // TRANS TYPE
                    $m_trans->trans_log='Deleted Job Unit: '.$job_unit_name[0]->job_unit_name;
                    $m_trans->save();



                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Unit information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_units=$this->Job_unit_model;

                $job_unit_id=$this->input->post('job_unit_id',TRUE);
                $m_units->job_unit_name=$this->input->post('job_unit_name',TRUE);
                $m_units->job_unit_desc=$this->input->post('job_unit_desc',TRUE);

                $m_units->modify($job_unit_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=77; // TRANS TYPE
                $m_trans->trans_log='Updated Job Unit: '.$this->input->post('job_unit_name',TRUE).' ID('.$job_unit_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Unit information successfully updated.';
                $response['row_updated']=$m_units->get_job_unit_list($job_unit_id);
                echo json_encode($response);

                break;
        }
    }
}
