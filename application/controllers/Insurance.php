<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insurance extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Insurance_model');
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
        $data['title']='Insurance Management';
        (in_array('5-8',$this->session->user_rights)? 
        $this->load->view('insurance_view',$data)
        :redirect(base_url('dashboard')));
        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_insurance=$this->Insurance_model;
                $response['data']=$m_insurance->get_insurance_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_insurance=$this->Insurance_model;

                $m_insurance->begin();
                $m_insurance->set('date_created','NOW()');

                $m_insurance->insurer_company=$this->input->post('insurer_company',TRUE);
                $m_insurance->contact_person=$this->input->post('contact_person',TRUE);
                $m_insurance->contact_no=$this->input->post('contact_no',TRUE);
                $m_insurance->address=$this->input->post('address',TRUE);
                $m_insurance->email_address=$this->input->post('email_address',TRUE);
                $m_insurance->posted_by_user=$this->session->user_id;
                $m_insurance->save();
                $insurance_id=$m_insurance->last_insert_id();
                $m_insurance->commit();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Insurance Information successfully created.';
                $response['row_added']= $m_insurance->get_insurance_list($insurance_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=80; // TRANS TYPE
                $m_trans->trans_log='Created Insurance: '.$this->input->post('insurer_company',TRUE);
                $m_trans->save();

                echo json_encode($response);

                break;

            case 'delete':
                $m_insurance=$this->Insurance_model;
                $insurance_id=$this->input->post('insurance_id',TRUE);

                $m_insurance->is_deleted=1;
                if($m_insurance->modify($insurance_id)){
                    
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Insurance information successfully deleted.';
                    $m_trans=$this->Trans_model;

                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=80; // TRANS TYPE
                    $m_trans->trans_log='Deleted Insurance: ID('.$insurance_id.')';
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_insurance=$this->Insurance_model;
                $insurance_id=$this->input->post('insurance_id',TRUE);
                
                $m_insurance->begin();

                $m_insurance->insurer_company=$this->input->post('insurer_company',TRUE);
                $m_insurance->contact_person=$this->input->post('contact_person',TRUE);
                $m_insurance->contact_no=$this->input->post('contact_no',TRUE);
                $m_insurance->address=$this->input->post('address',TRUE);
                $m_insurance->email_address=$this->input->post('email_address',TRUE);
                $m_insurance->modify($insurance_id);

                $m_insurance->commit();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Insurance Information successfully updated.';
                $response['row_updated']=$m_insurance->get_insurance_list($insurance_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=80; // TRANS TYPE
                $m_trans->trans_log='Updated Insurance: ID('.$insurance_id.')'; 
                $m_trans->save();

                echo json_encode($response);

                break;
       	}
    }
}
