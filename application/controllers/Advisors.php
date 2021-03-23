<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advisors extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Advisor_model');
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
        $data['title']='Advisor Management';
        $data['departments']=$this->Departments_model->get_list(array('departments.is_deleted'=>FALSE));
        (in_array('5-7',$this->session->user_rights)? 
        $this->load->view('advisor_view',$data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_advisor=$this->Advisor_model;
                $response['data']=$m_advisor->get_advisors_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_advisor=$this->Advisor_model;

                $m_advisor->set('date_created','NOW()');

                $m_advisor->advisor_code=$this->input->post('advisor_code',TRUE);
                $m_advisor->advisor_fname=$this->input->post('advisor_fname',TRUE);
                $m_advisor->advisor_mname=$this->input->post('advisor_mname',TRUE);
                $m_advisor->advisor_lname=$this->input->post('advisor_lname',TRUE);
                $m_advisor->advisor_contact_no=$this->input->post('advisor_contact_no',TRUE);
                $m_advisor->department_id=$this->input->post('department_id',TRUE);
                $m_advisor->posted_by_user=$this->session->user_id;
                $m_advisor->save();

                $advisor_id=$m_advisor->last_insert_id();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Advisor Information successfully created.';
                $response['row_added']= $m_advisor->get_advisors_list($advisor_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=79; // TRANS TYPE
                $m_trans->trans_log='Created Advisor: '.$this->input->post('advisor_fname',TRUE).' '.$this->input->post('advisor_mname',TRUE).' '.$this->input->post('advisor_lname',TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_advisor=$this->Advisor_model;
                $advisor_id=$this->input->post('advisor_id',TRUE);

                $m_advisor->is_deleted=1;
                if($m_advisor->modify($advisor_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Advisor information successfully deleted.';
                    $m_trans=$this->Trans_model;

                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=79; // TRANS TYPE
                    $m_trans->trans_log='Deleted Advisor: ID('.$advisor_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_advisor=$this->Advisor_model;
                $advisor_id=$this->input->post('advisor_id',TRUE);

                $m_advisor->advisor_code=$this->input->post('advisor_code',TRUE);
                $m_advisor->firstname=$this->input->post('firstname',TRUE);
                $m_advisor->advisor_mname=$this->input->post('advisor_mname',TRUE);
                $m_advisor->advisor_lname=$this->input->post('advisor_lname',TRUE);
                $m_advisor->advisor_contact_no=$this->input->post('advisor_contact_no',TRUE);
                $m_advisor->department_id=$this->input->post('department_id',TRUE);
                $m_advisor->modify($advisor_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Advisor Information successfully updated.';
                $response['row_updated']=$m_advisor->get_advisors_list($advisor_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=79; // TRANS TYPE
                $m_trans->trans_log='Updated Advisor: ID('.$advisor_id.')'; 
                $m_trans->save();

                echo json_encode($response);

                break;
       	}
    }
}
