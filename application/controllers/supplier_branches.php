<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier_branches extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Supplier_branches_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Supplier Branches Management';
        (in_array('4-9',$this->session->user_rights)? 
        $this->load->view('supplier_branches_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_branches = $this->Supplier_branches_model;
                $response['data'] = $m_branches->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
                echo json_encode($response);
                break;

            case 'create':
                $m_branches = $this->Supplier_branches_model;

                $m_branches->branch_name = $this->input->post('branch_name', TRUE);
                $m_branches->save();

                $supplier_branch_id = $m_branches->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=77; // TRANS TYPE
                $m_trans->trans_log='Created Supplier Branches: '.$this->input->post('branch_name', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Supplier Branches Information successfully created.';
                $response['row_added'] = $m_branches->get_list($supplier_branch_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_branches=$this->Supplier_branches_model;

                $supplier_branch_id=$this->input->post('supplier_branch_id',TRUE);

                $m_branches->is_deleted=1;
                if($m_branches->modify($supplier_branch_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Supplier Branches Information successfully deleted.';

                    $branch_name = $m_branches->get_list($supplier_branch_id,'branch_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=77; // TRANS TYPE
                    $m_trans->trans_log='Deleted Supplier Branches: '.$branch_name[0]->branch_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_branches=$this->Supplier_branches_model;

                $supplier_branch_id=$this->input->post('supplier_branch_id',TRUE);
                $m_branches->branch_name=$this->input->post('branch_name',TRUE);
                $m_branches->modify($supplier_branch_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=77; // TRANS TYPE
                $m_trans->trans_log='Updated Supplier Branches: '.$this->input->post('branch_name',TRUE).' ID('.$supplier_branch_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Supplier Branches Information successfully updated.';
                $response['row_updated']=$m_branches->get_list($supplier_branch_id);
                echo json_encode($response);

                break;
        }
    }
}
