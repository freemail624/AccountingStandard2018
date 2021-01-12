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
                $department_id = $this->input->get('department_id', TRUE);
                $response['data']=$this->Temp_journal_info_model->getBillingList($department_id);
                echo json_encode($response);
                break;

            case 'list-billing-payment-for-review':
                $response['data']=$this->Temp_journal_info_model->get_list(array('is_sales'=>0,'book_type_id'=>1,'is_journal_posted'=>FALSE),
                    'temp_journal_info.*,
                    customers.customer_name,
                    b_payment_info.transaction_no,
                    b_payment_info.remarks,
                    IF(b_payment_info.payment_type = 1, DATEDIFF(b_payment_info.check_date,NOW()),0) as rem_day_for_due,',
                    array(array('customers','customers.customer_id = temp_journal_info.customer_id','left'),
                        array('b_payment_info','b_payment_info.payment_id = temp_journal_info.payment_id','left'))
                    );
                echo json_encode($response);
                break;

            case 'list-billing-advances-for-review':
                $department_id = $this->input->get('department_id', TRUE);
                $response['data']=$this->Temp_journal_info_model->getBillingAdvancesList($department_id);
                echo json_encode($response);
                break;
        };
    }









}
