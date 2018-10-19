<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->library('excel');
        $this->load->model('Account_title_model');
        $this->load->model('Jobs_model');
        $this->load->model('Job_unit_model');
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
        $data['title'] = 'Jobs Management';




        $data['units'] = $this->Job_unit_model->get_list(array('job_unit.is_deleted'=>FALSE));

        $data['accounts'] = $this->Account_title_model->get_list((array('is_active'=>TRUE,'is_deleted'=>FALSE),'account_id,account_title');

        // (in_array('13-5',$this->session->user_rights)?
        $this->load->view('jobs_view', $data);
        // :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_jobs = $this->Jobs_model;
                $response['data']=$this->response_rows(array('jobs.is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'create';
                $m_jobs = $this->Jobs_model;
                $m_jobs->job_code = $this->input->post('job_code',TRUE);
                $m_jobs->job_desc = $this->input->post('job_desc',TRUE);
                $m_jobs->job_unit = $this->input->post('job_unit',TRUE);
                $m_jobs->expense_account_id = $this->input->post('expense_account_id',TRUE);
                $m_jobs->job_amount = $this->get_numeric_value($this->input->post('job_amount',TRUE));
                $m_jobs->save();
                $job_id = $m_jobs->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=78; // TRANS TYPE
                $m_trans->trans_log='Created a new Job: '.$this->input->post('job_desc', TRUE);
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Job information successfully updated.';
                $response['row_added']=$this->response_rows($job_id);
                echo json_encode($response);

                break;

            case 'update';
                $m_jobs = $this->Jobs_model;
                $job_id = $this->input->post('job_id',TRUE);
                $m_jobs->job_code = $this->input->post('job_code',TRUE);
                $m_jobs->job_desc = $this->input->post('job_desc',TRUE);
                $m_jobs->job_unit = $this->input->post('job_unit',TRUE);
                $m_jobs->expense_account_id = $this->input->post('expense_account_id',TRUE);
                $m_jobs->job_amount = $this->get_numeric_value($this->input->post('job_amount',TRUE));
                $m_jobs->modify($job_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=78; // TRANS TYPE
                $m_trans->trans_log='Updated Job : '.$this->input->post('job_desc', TRUE).' ID('.$job_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Job information successfully updated.';
                $response['row_updated']=$this->response_rows($job_id);
                echo json_encode($response);



                break;


            case 'delete';
                $m_jobs = $this->Jobs_model;
                $job_id = $this->input->post('job_id',TRUE);
                $m_jobs->deleted_by_user = $this->session->user_id;
                $m_jobs->is_deleted=1;
                    if($m_jobs->modify($job_id)){


                    $job_desc= $m_jobs->get_list($job_id,'job_desc');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=78; // TRANS TYPE
                    $m_trans->trans_log='Deleted Job: '.$job_desc[0]->job_desc;
                    $m_trans->save();


                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Job information successfully deleted.';

                        echo json_encode($response); 

                    }


                    break;

        }
    }

        function response_rows($filter){
        return $this->Jobs_model->get_list(
            $filter,

            'jobs.*,
            account_titles.account_title as expense_account',
            array(array('account_titles','account_titles.account_id=jobs.expense_account_id','left'))
          

            );
        }











}