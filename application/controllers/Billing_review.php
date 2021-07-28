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
                $department_id = $this->input->get('department_id', TRUE);
                $response['data']=$this->Temp_journal_info_model->getBillingPaymentList($department_id);
                echo json_encode($response);
                break;

            case 'list-billing-advances-for-review':
                $department_id = $this->input->get('department_id', TRUE);
                $response['data']=$this->Temp_journal_info_model->getBillingAdvancesList($department_id);
                echo json_encode($response);
                break;

            case 'list-billing-security-deposit-for-review':
                $department_id = $this->input->get('department_id', TRUE);
                $response['data']=$this->Temp_journal_info_model->getBillingSecDepList($department_id);
                echo json_encode($response);
                break;
        };
    }
}
