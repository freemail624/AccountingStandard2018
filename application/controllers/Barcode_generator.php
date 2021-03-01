<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_generator extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_class_model',
                'Journal_info_model',
                'Journal_account_model',
                'Users_model',
                'Departments_model',
                'Company_model',
                'Products_model'
            )
        );
        $this->load->library('excel');
        $this->load->model('Email_settings_model');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
        $data['title'] = 'Barcode Generator';

        $data['products']=$this->Products_model->get_list('is_deleted=FALSE');
        (in_array('15-8',$this->session->user_rights)? 
        $this->load->view('barcode_generator_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn)
    {
        switch($txn)
        {
            case 'get_batches':
                $m_products = $this->Products_model;
                $ccf = null;
                $product_id = $this->input->get('id',TRUE);
                $date = date('Y-m-d');
                $response['data']=$m_products->batch_inventory($product_id,0,null,$date);
                echo json_encode($response);    
                break;
        }
    }
}
