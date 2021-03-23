<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicles extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Customer_vehicles_model');
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
        $data['title'] = 'Vehicles Management';

        (in_array('4-9',$this->session->user_rights)? 
        $this->load->view('terms_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_term = $this->Customer_vehicles_model;
                $response['data'] = $m_term->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
                echo json_encode($response);
                break;

            case 'create':
                $m_term = $this->Customer_vehicles_model;

                $m_term->term_description = $this->input->post('term_description', TRUE);
                $m_term->save();

                $term_id = $m_term->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=71; // TRANS TYPE
                $m_trans->trans_log='Created Term: '.$this->input->post('term_description', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Term Information successfully created.';
                $response['row_added'] = $m_term->get_terms_list($term_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_term=$this->Customer_vehicles_model;

                $term_id=$this->input->post('term_id',TRUE);

                $m_term->is_deleted=1;
                if($m_term->modify($term_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Term Information successfully deleted.';

                    $terms = $m_term->get_list($term_id,'term_description');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=71; // TRANS TYPE
                    $m_trans->trans_log='Deleted Term: '.$terms[0]->term_description;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_term=$this->Customer_vehicles_model;

                $term_id=$this->input->post('term_id',TRUE);
                $m_term->term_description=$this->input->post('term_description',TRUE);
                $m_term->modify($term_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=71; // TRANS TYPE
                $m_trans->trans_log='Updated Term: '.$this->input->post('term_description',TRUE).' ID('.$term_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Term Information successfully updated.';
                $response['row_updated']=$m_term->get_terms_list($term_id);
                echo json_encode($response);

                break;
        }
    }
}
