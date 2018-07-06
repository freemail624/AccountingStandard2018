<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel_system_settings extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Account_integration_model',
                'Hotel_system_settings_model',
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
        (in_array('16-2',$this->session->user_rights)? 
        $this->load->view('hotel_system_settings_view', $data)
        :redirect(base_url('dashboard')));

    }

    public function transaction($txn=null){
        switch($txn){
            case 'save':
                $m_settings=$this->Hotel_system_settings_model;

                $m_settings->cash_id=$this->input->post('cash_id',TRUE);
                $m_settings->check_id=$this->input->post('check_id',TRUE);
                $m_settings->card_id=$this->input->post('card_id',TRUE);
                $m_settings->charge_id=$this->input->post('charge_id',TRUE);
                $m_settings->bank_dep_id=$this->input->post('bank_dep_id',TRUE);

                $m_settings->adv_cash_id=$this->input->post('adv_cash_id',TRUE);
                $m_settings->adv_check_id=$this->input->post('adv_check_id',TRUE);
                $m_settings->adv_card_id=$this->input->post('adv_card_id',TRUE);
                $m_settings->adv_charge_id=$this->input->post('adv_charge_id',TRUE);
                $m_settings->adv_bank_dep_id=$this->input->post('adv_bank_dep_id',TRUE);
                $m_settings->adv_sales_id=$this->input->post('adv_sales_id',TRUE);

                $m_settings->room_sales_id=$this->input->post('room_sales_id',TRUE);
                $m_settings->bar_sales_id=$this->input->post('bar_sales_id',TRUE);
                $m_settings->other_sales_id=$this->input->post('other_sales_id',TRUE);
                $m_settings->transpo_hotel_id=$this->input->post('transpo_hotel_id',TRUE);
                $m_settings->transpo_outsource_id=$this->input->post('transpo_outsource_id',TRUE);
                $m_settings->adv_sales_id=$this->input->post('adv_sales_id',TRUE);

                $m_settings->customer_id=$this->input->post('customer_id',TRUE);
                $m_settings->department_id=$this->input->post('department_id',TRUE);

                $m_settings->modify(1);

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Accounts successfully modified.";

                echo json_encode($response);

                break;

        }
    }
}
