<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sizes extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Sizes_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Size Management';
        (in_array('4-10',$this->session->user_rights)? 
        $this->load->view('size_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_size = $this->Sizes_model;
                $response['data'] = $m_size->get_size_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_size = $this->Sizes_model;

                $m_size->size_desc = $this->input->post('size_desc', TRUE);
                $m_size->save();

                $size_id = $m_size->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Created New Size : '.$this->input->post('size_desc', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Size Information successfully created.';
                $response['row_added'] = $m_size->get_size_list($size_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_size=$this->Sizes_model;

                $size_id=$this->input->post('size_id',TRUE);
                $m_size->is_deleted=1;

                if($m_size->modify($size_id)){

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Deleted Size ID('.$this->input->post('size_id',TRUE).')';
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Size Information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_size=$this->Sizes_model;

                $size_id=$this->input->post('size_id',TRUE);
                $m_size->size_desc=$this->input->post('size_desc',TRUE);

                $m_size->modify($size_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Updated Size ID('.$this->input->post('size_id',TRUE).') : '.$this->input->post('size_desc', TRUE);
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Size Information successfully updated.';
                $response['row_updated']=$m_size->get_size_list($size_id);
                echo json_encode($response);

                break;
        }
    }
}
