<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary_before_posting extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Account_integration_model',
                'Hotel_system_settings_model',
                'Hotel_system_model',
                'Users_model',
                'Sched_expense_integration',
                'Departments_model',
                'Customers_model',
            )

        );
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Hotel Integration Control Panel';
        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $data['customers'] = $this->Customers_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
        $data['departments'] = $this->Departments_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
        $prime_hotel_integration = $this->Hotel_system_settings_model->get_list(1);
        $data['prime_hotel_integration'] = $prime_hotel_integration[0]; 
        // (in_array('6-13',$this->session->user_rights)? 
        $this->load->view('summary_before_posting_view', $data);
        // :redirect(base_url('dashboard')));

    }

    public function transaction($txn=null){
        switch($txn){
            case 'list':
                $m_hotel=$this->Hotel_system_model;
                $date=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
                $response['data']=$m_hotel->get_transaction_summary($date);
                echo json_encode($response);

                break;

        }
    }
}
