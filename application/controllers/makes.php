<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class makes extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Makes_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Makes Management';
        (in_array('4-13',$this->session->user_rights)? 
        $this->load->view('makes_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_makes = $this->Makes_model;
                $response['data'] = $m_makes->get_makes_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_makes = $this->Makes_model;

                $m_makes->make_code = $this->input->post('make_code', TRUE);
                $m_makes->make_desc = $this->input->post('make_desc', TRUE);
                $m_makes->save();

                $make_id = $m_makes->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=78; // TRANS TYPE
                $m_trans->trans_log='Created Make: '.$this->input->post('make_desc', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Make information successfully created.';
                $response['row_added'] = $m_makes->get_makes_list($make_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_makes=$this->Makes_model;

                $make_id=$this->input->post('make_id',TRUE);

                $m_makes->is_deleted=1;
                if($m_makes->modify($make_id)){

                    $makes = $m_makes->get_list($make_id,'make_desc');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=78; // TRANS TYPE
                    $m_trans->trans_log='Deleted Make: '.$makes[0]->make_desc;
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Make information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_makes=$this->Makes_model;

                $make_id=$this->input->post('make_id',TRUE);
                $m_makes->make_code=$this->input->post('make_code',TRUE);
                $m_makes->make_desc=$this->input->post('make_desc',TRUE);
                $m_makes->modify($make_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=78; // TRANS TYPE
                $m_trans->trans_log='Updated Make: '.$this->input->post('make_desc',TRUE).' ID('.$make_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Make information successfully updated.';
                $response['row_updated']=$m_makes->get_makes_list($make_id);
                echo json_encode($response);

                break;
        }
    }
}
