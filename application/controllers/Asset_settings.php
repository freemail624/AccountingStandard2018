<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_settings extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Asset_settings_model',
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
        $data['title'] = 'Fxied Asset Accounts Settings';

        $data['accounts'] = $this->Account_title_model->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE,'account_classes.account_type_id'=>1),
            'account_titles.account_id,account_titles.account_title,
            IF(ISNULL(as.asset_account_id),0,1) as is_allowed',
            array(array('asset_settings as','as.asset_account_id = account_titles.account_id','left'),
                array('account_classes','account_classes.account_class_id=account_titles.account_class_id','left'))
            );

        (in_array('6-15',$this->session->user_rights)? 
        $this->load->view('asset_settings_view', $data)
        :redirect(base_url('dashboard')));
        

    }


    public function transaction($txn=null){
        switch($txn){
           case 'save_accounts':
           $this->db->truncate('asset_settings'); 
                $m_rights=$this->Asset_settings_model;

                $account_id=$this->input->post('account_id',TRUE);
                foreach($account_id as $account_id){
                        $m_rights->asset_account_id=$account_id;
                        $m_rights->save();
                }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Fixed Asset Account Settings Saved Successfully.';

                echo json_encode($response);

           break;

        }

    }

}
