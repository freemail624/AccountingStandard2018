<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_units extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Item_units_model');
        $this->load->model('Users_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Item Unit Management';
        (in_array('16-2',$this->session->user_rights)? 
        $this->load->view('item_units_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_units = $this->Item_units_model;
                $response['data'] = $m_units->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'create':
                $m_units = $this->Item_units_model;

                $m_units->item_unit_name = $this->input->post('item_unit_name', TRUE);
                $m_units->item_unit_desc = $this->input->post('item_unit_desc', TRUE);
                $m_units->save();

                $unit_id = $m_units->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Unit information successfully created.';
                $response['row_added'] = $m_units->get_list($unit_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_units=$this->Item_units_model;

                $unit_id=$this->input->post('unit_id',TRUE);

                $m_units->is_deleted=1;
                if($m_units->modify($unit_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Unit information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_units=$this->Item_units_model;

                $unit_id=$this->input->post('unit_id',TRUE);
                $m_units->item_unit_name=$this->input->post('item_unit_name',TRUE);
                $m_units->item_unit_desc=$this->input->post('item_unit_desc',TRUE);

                $m_units->modify($unit_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Unit information successfully updated.';
                $response['row_updated']=$m_units->get_list($unit_id);
                echo json_encode($response);

                break;
        }
    }
}
