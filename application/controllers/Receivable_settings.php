<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receivable_settings extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Soa_settings_model',
                'Receivable_settings_model',
                'Sales_invoice_model',
                'Users_model',
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
        $data['title'] = 'Statement of Accounts Settings';

        $data['accounts_receivable'] = $this->Account_title_model->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE,'account_classes.account_type_id'=>1),
            'account_titles.account_id,account_titles.account_title,
            IF(ISNULL(rs.receivable_account_id),0,1) as is_allowed',
            array(array('receivable_settings rs','rs.receivable_account_id = account_titles.account_id','left'),
                array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left'))
            );

        (in_array('6-18',$this->session->user_rights)? 
        $this->load->view('receivable_settings_view', $data)
        :redirect(base_url('dashboard')));
        

    }


    public function transaction($txn=null){
        switch($txn){

           case 'save_receivable_accounts':
                $this->db->truncate('receivable_settings'); 
                $m_rights=$this->Receivable_settings_model;

                $receivable_account_id=$this->input->post('receivable_account_id',TRUE);
                foreach($receivable_account_id as $receivable_account_id){
                        $m_rights->receivable_account_id=$receivable_account_id;
                        $m_rights->save();
                }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Receivable Settings Saved Successfully.';

                echo json_encode($response);

           break;           

        }

    }

}
