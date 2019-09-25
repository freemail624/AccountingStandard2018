<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_contracts extends CORE_Controller
{
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Billing_contracts_model');
        $this->load->model('Billing_contract_schedule_model');
        $this->load->model('Billing_contract_utilities_model');
        $this->load->model('Billing_contract_misc_model');
        $this->load->model('Billing_contract_other_model');
        $this->load->model('Billing_contract_other_fees_model');
        $this->load->model('Users_model');
        $this->load->library('M_pdf');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Billing Contracts for Approval';
        (in_array('18',$this->session->parent_rights)? 
        $this->load->view('billing_contracts_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'list':  //this returns JSON of Purchase Order to be rendered on Datatable
                $response['data']=$this->Billing_contracts_model->get_list(null,'b_tenants.*,b_contract_info.*,b_reflocations.location_desc,
                    DATE_FORMAT(b_contract_info.commencement_date,"%m/%d/%Y") as commencement_date,
                    DATE_FORMAT(b_contract_info.termination_date,"%m/%d/%Y") as termination_date',
                    array(
                        array('b_tenants','b_tenants.tenant_id = b_contract_info.tenant_id','left'),
                        array('b_reflocations','b_reflocations.location_id = b_contract_info.location_id','left')
                        ));
                echo json_encode($response);
            break;

            case 'contract-details': 
                        $contract_id = $id_filter;
                        $data['schedules'] = $this->Billing_contract_schedule_model->get_list(array('b_contract_schedule.contract_id'=>$contract_id),
                            'b_contract_schedule.*,months.*',
                            array(
                                array('months','months.month_id=b_contract_schedule.month_id','left')
                                )
                            );
                        $data['util_charges'] =$this->Billing_contract_utilities_model->get_list(array('b_contract_util_charges.contract_id'=>$contract_id),'b_contract_util_charges.*,b_refcharges.*',
                            array(
                                array('b_refcharges','b_refcharges.charge_id=b_contract_util_charges.charge_id','left')
                                ));
                        $data['misc_charges'] = $this->Billing_contract_misc_model->get_list(array('b_contract_misc_charges.contract_id'=>$contract_id),'b_contract_misc_charges.*,b_refcharges.*',
                            array(
                                array('b_refcharges','b_refcharges.charge_id=b_contract_misc_charges.charge_id','left')
                                ));
                        $data['othr_charges'] = $this->Billing_contract_other_model->get_list(array('b_contract_othr_charges.contract_id'=>$contract_id),'b_contract_othr_charges.*,b_refcharges.*',
                            array(
                                array('b_refcharges','b_refcharges.charge_id=b_contract_othr_charges.charge_id','left')
                                ));
                        $data['other_fees'] = $this->Billing_contract_other_fees_model->get_contract_advances($contract_id);
                        $data['contract_info'] =$this->Billing_contracts_model->get_list($contract_id,
                            'b_tenants.*,
                            b_contract_info.*,
                            b_reflocations.location_desc,
                            b_refcategory.category_desc,
                            b_refcontracttype.contract_type_desc,
                            b_refdepartments.department_desc,
                            b_refnatureofbusiness.nature_of_business_desc,
                            DATE_FORMAT(b_contract_info.commencement_date,"%m/%d/%Y") as commencement_date,
                            DATE_FORMAT(b_contract_info.termination_date,"%m/%d/%Y") as termination_date,
                            DATE_FORMAT(b_contract_info.start_billing_date,"%m/%d/%Y") as start_billing_date',
                            array(
                                array('b_tenants','b_tenants.tenant_id = b_contract_info.tenant_id','left'),
                                array('b_reflocations','b_reflocations.location_id = b_contract_info.location_id','left'),
                                array('b_refcontracttype','b_refcontracttype.contract_type_id = b_contract_info.contract_type_id','left'),
                                array('b_refdepartments','b_refdepartments.department_id = b_contract_info.department_id','left'),
                                array('b_refnatureofbusiness','b_refnatureofbusiness.nature_of_business_id = b_contract_info.nature_of_business_id','left'),
                                array('b_refcategory','b_refcategory.category_id = b_contract_info.category_id','left')
                                ))[0];
                        echo $this->load->view('template/billing_contracts_content',$data,TRUE);

            break;
        }
    }
}


 
