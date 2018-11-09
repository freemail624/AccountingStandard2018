<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temporary_voucher extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Temporary_voucher_items_model');
        $this->load->model('Temporary_voucher_model');
        $this->load->model('Users_model');
        $this->load->model('Check_layout_model');
        $this->load->model('Trans_model');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Temporary Voucher';
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');
        (in_array('1-8',$this->session->user_rights)? 
        $this->load->view('temporary_voucher_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_tem = $this->Temporary_voucher_model;
                $response['data'] = $m_tem->get_list(null,
                    'temp_voucher_info.*,IFNULL(ji.txn_no,"Pending") as txn_no,
                    DATE_FORMAT(temp_voucher_info.check_date,"%m/%d/%Y")as check_date,
                    s.supplier_name',
                    array(array('journal_info ji','ji.journal_id = temp_voucher_info.journal_id','left'),
                        array('suppliers s','s.supplier_id = temp_voucher_info.supplier_id','left'))
                    );
                echo json_encode($response);
                break;

        }
    }
}
