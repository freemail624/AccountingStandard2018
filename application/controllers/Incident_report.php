<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident_report extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Incident_report_model');
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
        $data['title'] = 'Incident Report';
        (in_array('17-3',$this->session->user_rights)? 
        $this->load->view('incident_report_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_incident = $this->Incident_report_model;
                $response['data'] = $m_incident->get_incident_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_incident = $this->Incident_report_model;

                $m_incident->incident_date_time = date('Y-m-d h:i:s',strtotime($this->input->post('incident_date_time', TRUE)));
                $m_incident->location = $this->input->post('location', TRUE);
                $m_incident->incident_details = $this->input->post('incident_details', TRUE);
                $m_incident->incident_causes = $this->input->post('incident_causes', TRUE);
                $m_incident->follow_up = $this->input->post('follow_up', TRUE);
                $m_incident->is_dealer_notified = $this->input->post('is_dealer_notified', TRUE);
                $m_incident->save();

                $incident_report_id = $m_incident->last_insert_id();

                //update incident report number base on formatted last insert id
                $incident_report_no='IR-'.date('Ymd').'-'.$incident_report_id;
                $m_incident->incident_report_no=$incident_report_no;
                $m_incident->modify($incident_report_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=74; // TRANS TYPE
                $m_trans->trans_log='Created Incident Report for report # '.$incident_report_no;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Incident Report successfully created.';
                $response['row_added'] = $m_incident->get_incident_list($incident_report_id);
                echo json_encode($response);

                break;

            case 'update':
                $m_incident=$this->Incident_report_model;

                $incident_report_id=$this->input->post('incident_report_id',TRUE);

                $m_incident->incident_date_time = date('Y-m-d h:i:s',strtotime($this->input->post('incident_date_time', TRUE)));
                $m_incident->location = $this->input->post('location', TRUE);
                $m_incident->incident_details = $this->input->post('incident_details', TRUE);
                $m_incident->incident_causes = $this->input->post('incident_causes', TRUE);
                $m_incident->follow_up = $this->input->post('follow_up', TRUE);
                $m_incident->is_dealer_notified = $this->input->post('is_dealer_notified', TRUE);
                $m_incident->modify($incident_report_id);

                $incident = $m_incident->get_list($incident_report_id,'incident_report_no');

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=74; // TRANS TYPE
                $m_trans->trans_log='Updated Incident Report: Report#('.$incident[0]->incident_report_no.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Incident Report successfully updated.';
                $response['row_updated']=$m_incident->get_incident_list($incident_report_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_incident=$this->Incident_report_model;

                $incident_report_id=$this->input->post('incident_report_id',TRUE);
                $m_incident->is_deleted=1;

                if($m_incident->modify($incident_report_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Incident Report successfully deleted.';

                    $incident = $m_incident->get_list($incident_report_id,'incident_report_no');

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=74; // TRANS TYPE
                    $m_trans->trans_log='Deleted Incident Report : '.$incident[0]->incident_report_no;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

        }
    }
}
