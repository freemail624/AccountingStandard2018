<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quarterly_percentage_tax_return extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Months_model');
        $this->load->model('Bir_2551m_model');
        $this->load->model('Company_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Quarterly Percentage Tax Return';
        (in_array('17-3',$this->session->user_rights)? 
        $this->load->view('quarterly_percentage_tax_return_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_2551 = $this->Bir_2551m_model;
                $year = $this->input->get('year', TRUE);
                $response['data'] = $m_2551->get_2551q_list($year);
                echo json_encode($response);
                break;

        }
    }
}
