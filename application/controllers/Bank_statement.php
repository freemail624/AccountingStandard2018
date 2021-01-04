<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_statement extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Bank_statement_model');
        $this->load->model('Account_title_model');
        $this->load->model('Months_model');
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
        $data['title'] = 'Bank Statement';

        $data['accounts']=$this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $data['months']=$this->Months_model->get_list();
        (in_array('11-2',$this->session->user_rights)? 
        $this->load->view('bank_statement_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_bank_statement = $this->Bank_statement_model;
                $response['data'] = $m_bank_statement->get_bank_statement_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_categories = $this->Bank_statement_model;

                $m_categories->category_name = $this->input->post('category_name', TRUE);
                $m_categories->category_desc = $this->input->post('category_desc', TRUE);
                $m_categories->save();

                $category_id = $m_categories->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=45; // TRANS TYPE
                $m_trans->trans_log='Created Category: '.$this->input->post('category_name', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'category information successfully created.';
                $response['row_added'] = $m_categories->get_category_list($category_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_categories=$this->Bank_statement_model;

                $category_id=$this->input->post('category_id',TRUE);

                $m_categories->is_deleted=1;
                if($m_categories->modify($category_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='category information successfully deleted.';
                    $category_name = $m_categories->get_list($category_id,'category_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=45; // TRANS TYPE
                    $m_trans->trans_log='Deleted Category: '.$category_name[0]->category_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_categories=$this->Bank_statement_model;

                $category_id=$this->input->post('category_id',TRUE);
                $m_categories->category_name=$this->input->post('category_name',TRUE);
                $m_categories->category_desc=$this->input->post('category_desc',TRUE);

                $m_categories->modify($category_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=45; // TRANS TYPE
                $m_trans->trans_log='Updated Category: '.$this->input->post('category_name',TRUE).' ID('.$category_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='category information successfully updated.';
                $response['row_updated']=$m_categories->get_category_list($category_id);
                echo json_encode($response);

                break;
        }
    }
}
