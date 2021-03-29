<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vehicle_years extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Vehicle_year_model');
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
        $data['title'] = 'Vehicle Year Management';

        (in_array('4-12',$this->session->user_rights)? 
        $this->load->view('vehicle_year_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_vehicle_year = $this->Vehicle_year_model;
                $response['data'] = $m_vehicle_year->get_vehicle_year_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_vehicle_year = $this->Vehicle_year_model;

                $vehicle_year =  $this->input->post('vehicle_year', TRUE);
                $remarks =  $this->input->post('remarks', TRUE);

                //validate year
                $check_vehicle_year=$m_vehicle_year->check_vehicle_year($vehicle_year);

                if(count($check_vehicle_year)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$vehicle_year.' is already existing. <br/>Please make sure year is unique!<br />';
                    die(json_encode($response));
                }
                
                $m_vehicle_year->begin();

                $m_vehicle_year->vehicle_year = $vehicle_year;
                $m_vehicle_year->remarks = $remarks;
                $m_vehicle_year->save();

                $vehicle_year_id = $m_vehicle_year->last_insert_id();

                $m_vehicle_year->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=77; // TRANS TYPE
                $m_trans->trans_log='Created Vehicle Year: '.$vehicle_year;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Vehicle Year Information successfully created.';
                $response['row_added'] = $m_vehicle_year->get_vehicle_year_list($vehicle_year_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_vehicle_year=$this->Vehicle_year_model;

                $vehicle_year_id=$this->input->post('vehicle_year_id',TRUE);
                $m_vehicle_year->is_deleted=1;

                if($m_vehicle_year->modify($vehicle_year_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Vehicle Year Information successfully deleted.';

                    $year = $m_vehicle_year->get_list($vehicle_year_id,'vehicle_year');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=77; // TRANS TYPE
                    $m_trans->trans_log='Deleted Vehicle Year: '.$year[0]->vehicle_year;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_vehicle_year=$this->Vehicle_year_model;

                $vehicle_year_id=$this->input->post('vehicle_year_id',TRUE);
                $vehicle_year=$this->input->post('vehicle_year',TRUE);
                $remarks=$this->input->post('remarks',TRUE);

                //validate year
                $check_vehicle_year=$m_vehicle_year->check_vehicle_year($vehicle_year,$vehicle_year_id);

                if(count($check_vehicle_year)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$vehicle_year.' is already existing. <br/>Please make sure year is unique!<br />';
                    die(json_encode($response));
                }

                $m_vehicle_year->begin();

                $m_vehicle_year->vehicle_year=$vehicle_year;
                $m_vehicle_year->remarks=$remarks;
                $m_vehicle_year->modify($vehicle_year_id);

                $m_vehicle_year->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=77; // TRANS TYPE
                $m_trans->trans_log='Updated Vehicle Year: '.$this->input->post('vehicle_year',TRUE).' ID('.$vehicle_year_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Vehicle Year Information successfully updated.';
                $response['row_updated']=$m_vehicle_year->get_vehicle_year_list($vehicle_year_id);
                echo json_encode($response);

                break;
        }
    }
}
