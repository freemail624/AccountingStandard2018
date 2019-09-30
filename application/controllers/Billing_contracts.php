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
        $this->load->model('Trans_model');
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

                $approval_id=$this->input->get('approval_id',TRUE);
                if($approval_id == '0' || $approval_id == '2'){
                    $filter =  "b_contract_info.is_active = TRUE AND b_contract_info.status = $approval_id";
                }else{
                    $filter = "b_contract_info.is_active = TRUE AND (b_contract_info.status=1 OR b_contract_info.status=3 OR b_contract_info.status=4)";
                }
                $response['filter'] = $filter;
                $response['data']=$this->Billing_contracts_model->get_list($filter,'b_tenants.*,b_contract_info.*,b_reflocations.location_desc,
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


            case 'mark-approved': //called on DASHBOARD when approved button is clicked
                $m_contract=$this->Billing_contracts_model;
                $contract_id=$this->input->post('contract_id',TRUE);


                // $m_contract->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                // $m_contract->approved_by_user=$this->session->user_id; //deleted by user
                // $m_contract->approval_remarks=$this->input->post('approval_remarks',TRUE);
                $m_contract->status=1; //1 means approved
                if($m_contract->modify($contract_id)){
                    $contract_info = $m_contract->get_list($contract_id,'contract_no')[0];
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=11; //CRUD
                    $m_trans->trans_type_id=73; // TRANS TYPE
                    $m_trans->trans_log='Approved Contract '.$contract_info->contract_no.' ID('.$contract_id.'): with remarks '.$this->input->post('approval_remarks',TRUE);
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Contract successfully Approved.';
                    echo json_encode($response);
                }
            break;

            case 'mark-disapproved': //called on DASHBOARD when approved button is clicked
                $m_contract=$this->Billing_contracts_model;
                $contract_id=$this->input->post('contract_id',TRUE);


                // $m_contract->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                // $m_contract->approved_by_user=$this->session->user_id; //deleted by user
                // $m_contract->disapproval_remarks=$this->input->post('disapproval_remarks',TRUE);
                $m_contract->status=2; //1 means approved
                if($m_contract->modify($contract_id)){
                    $contract_info = $m_contract->get_list($contract_id,'contract_no')[0];
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=12; //CRUD
                    $m_trans->trans_type_id=73; // TRANS TYPE
                    $m_trans->trans_log='Disapproved Contract '.$contract_info->contract_no.' ID('.$contract_id.'): with remarks '.$this->input->post('disapproval_remarks',TRUE);
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Contract successfully Disapproved.';
                    echo json_encode($response);
                }
            break;
        }
    }
}


 
