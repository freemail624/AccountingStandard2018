<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_code extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Tax_code_model');
        $this->load->model('Tax_type_model');
        $this->load->model('Business_type_model');
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
        $data['tax_types'] = $this->Tax_type_model->get_list();
        $data['business_types'] = $this->Business_type_model->get_list();
        $data['title'] = 'Tax Code Management';
        (in_array('4-8',$this->session->user_rights)? 
        $this->load->view('tax_code_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_taxcode = $this->Tax_code_model;
                $response['data'] = $m_taxcode->get_taxcode_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_taxcode = $this->Tax_code_model;

                $m_taxcode->tax_type_id = $this->input->post('tax_type_id', TRUE);
                $m_taxcode->business_type_id = $this->input->post('business_type_id', TRUE);
                $m_taxcode->atc = $this->input->post('atc', TRUE);
                $m_taxcode->description = $this->input->post('description', TRUE);
                $m_taxcode->tax_rate=$this->get_numeric_value($this->input->post('tax_rate',TRUE));
                $m_taxcode->save();

                $atc_id = $m_taxcode->last_insert_id();

                // $m_trans=$this->Trans_model;
                // $m_trans->user_id=$this->session->user_id;
                // $m_trans->set('trans_date','NOW()');
                // $m_trans->trans_key_id=1; //CRUD
                // $m_trans->trans_type_id=45; // TRANS TYPE
                // $m_trans->trans_log='Created Category: '.$this->input->post('category_name', TRUE);
                // $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Tax Code information successfully created.';
                $response['row_added'] = $m_taxcode->get_taxcode_list($atc_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_taxcode = $this->Tax_code_model;

                $atc_id=$this->input->post('atc_id',TRUE);

                $m_taxcode->is_deleted=1;
                if($m_taxcode->modify($atc_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Tax Code information successfully deleted.';
                    // $category_name = $m_taxcode->get_list($atc_id,'category_name');
                    // $m_trans=$this->Trans_model;
                    // $m_trans->user_id=$this->session->user_id;
                    // $m_trans->set('trans_date','NOW()');
                    // $m_trans->trans_key_id=3; //CRUD
                    // $m_trans->trans_type_id=45; // TRANS TYPE
                    // $m_trans->trans_log='Deleted Category: '.$category_name[0]->category_name;
                    // $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_taxcode = $this->Tax_code_model;

                $atc_id=$this->input->post('atc_id',TRUE);

                $m_taxcode->tax_type_id = $this->input->post('tax_type_id', TRUE);
                $m_taxcode->business_type_id = $this->input->post('business_type_id', TRUE);
                $m_taxcode->atc = $this->input->post('atc', TRUE);
                $m_taxcode->description = $this->input->post('description', TRUE);
                $m_taxcode->tax_rate=$this->get_numeric_value($this->input->post('tax_rate',TRUE));
                $m_taxcode->modify($atc_id);

                // $m_trans=$this->Trans_model;
                // $m_trans->user_id=$this->session->user_id;
                // $m_trans->set('trans_date','NOW()');
                // $m_trans->trans_key_id=2; //CRUD
                // $m_trans->trans_type_id=45; // TRANS TYPE
                // $m_trans->trans_log='Updated Category: '.$this->input->post('category_name',TRUE).' ID('.$category_id.')';
                // $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Tax Code information successfully updated.';
                $response['row_updated']=$m_taxcode->get_taxcode_list($atc_id);
                echo json_encode($response);

                break;
        }
    }
}
