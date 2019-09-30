<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->library('excel');
        $this->load->model('Account_title_model');
        $this->load->model('Projects_model');
        $this->load->model('Job_unit_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Locations_model');
        }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Project Management';

        $data['locations'] = $this->Locations_model->get_location_list();


        (in_array('19-1',$this->session->user_rights)?
        $this->load->view('projects_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $response['data']=$this->response_rows(array('projects.is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'create';
                $m_projects = $this->Projects_model;
                $m_projects->project_name = $this->input->post('project_name',TRUE);
                $m_projects->project_desc = $this->input->post('project_desc',TRUE);
                $m_projects->budget_cost_estimate = $this->get_numeric_value($this->input->post('budget_cost_estimate',TRUE));
                $m_projects->location_id = $this->input->post('location_id',TRUE);
                $m_projects->date_start = date('Y-m-d',strtotime($this->input->post('date_start',TRUE)));
                $m_projects->date_due = date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_projects->save();
                $project_id = $m_projects->last_insert_id();
                $m_projects->project_code = 'PR-'.date('Ymd').'-'.$project_id;
                $m_projects->modify($project_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=70; // TRANS TYPE
                $m_trans->trans_log='Created a new Project: '.$this->input->post('project_name', TRUE);
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Project Information successfully updated.';
                $response['row_added']=$this->response_rows($project_id);
                echo json_encode($response);

                break;

            case 'update';
                $m_projects = $this->Projects_model;
                $project_id = $this->input->post('project_id',TRUE);
                $m_projects->project_name = $this->input->post('project_name',TRUE);
                $m_projects->project_desc = $this->input->post('project_desc',TRUE);
                $m_projects->budget_cost_estimate = $this->get_numeric_value($this->input->post('budget_cost_estimate',TRUE));
                $m_projects->location_id = $this->input->post('location_id',TRUE);
                $m_projects->date_start = date('Y-m-d',strtotime($this->input->post('date_start',TRUE)));
                $m_projects->date_due = date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_projects->modify($project_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=70; // TRANS TYPE
                $m_trans->trans_log='Updated Project : '.$this->input->post('project_name', TRUE).' ID('.$project_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Project information successfully updated.';
                $response['row_updated']=$this->response_rows($project_id);
                echo json_encode($response);



                break;


            case 'delete';
                $m_projects = $this->Projects_model;
                $project_id = $this->input->post('project_id',TRUE);
                $m_projects->deleted_by_user = $this->session->user_id;
                $m_projects->is_deleted=1;
                    if($m_projects->modify($project_id)){


                    $project_name= $m_projects->get_list($project_id,'project_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=70; // TRANS TYPE
                    $m_trans->trans_log='Deleted Project: '.$project_name[0]->project_name;
                    $m_trans->save();


                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Project Information successfully deleted.';

                        echo json_encode($response); 

                    }


                    break;

        }
    }

        function response_rows($filter){
        return $this->Projects_model->get_list(
            $filter,'projects.*,locations.location_name,
            DATE_FORMAT(projects.date_start,"%m/%d/%Y") as date_start,
            DATE_FORMAT(projects.date_due,"%m/%d/%Y") as date_due',
            array(array('locations','locations.location_id = projects.location_id','left')));
        }











}