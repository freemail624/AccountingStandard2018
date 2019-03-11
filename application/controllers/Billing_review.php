<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_review extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Temp_journal_info_model', 
                'Temp_journal_accounts_model'
            )
        );

    }

    public function index() {
    }


    public function transaction($txn=null){
        switch($txn){
            case 'list-billing-for-review':
                $response['data']=$this->Temp_journal_info_model->get_list(array('is_sales'=>1,'is_journal_posted'=>FALSE),
                    'temp_journal_info.*,
                    customers.customer_name',
                    array(array('customers','customers.customer_id = temp_journal_info.customer_id','left'))
                    );
                echo json_encode($response);
                break;

            case 'list-billing-payment-for-review':
                $response['data']=$this->Temp_journal_info_model->get_list(array('is_sales'=>0,'is_journal_posted'=>FALSE),
                    'temp_journal_info.*,
                    customers.customer_name',
                    array(array('customers','customers.customer_id = temp_journal_info.customer_id','left'))
                    );
                echo json_encode($response);
                break;
        };
    }









}
