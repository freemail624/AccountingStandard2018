<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_movement extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Asset_movement_model');
        $this->load->model('Locations_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Asset_property_status_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Movement of Assets';
        $data['locations']=$this->Locations_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        $data['statuses']=$this->Asset_property_status_model->get_list('is_deleted=FALSE');
        (in_array('10-3',$this->session->user_rights)? 
        $this->load->view('asset_movement_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_movement = $this->Asset_movement_model;
                $response['data'] = $m_movement->get_list(array('asset_movement.is_deleted'=>FALSE,'asset_movement.is_active'=>TRUE),
                    'asset_movement.*,
                    aps.asset_property_status',
                    array(
                        array('asset_property_status aps','aps.asset_status_id = asset_movement.asset_status_id','left')
                        )
                    );
                echo json_encode($response);
                break;

            case 'list-with-status':
                $m_movement = $this->Asset_movement_model;
                $response['data'] = $m_movement->get_list_with_status();
                echo json_encode($response);
                break;

            case 'create':
                $m_movement = $this->Asset_movement_model;
                $m_movement->set('date_posted','NOW()'); //treat NOW() as function and not string
                $m_movement->asset_code = $this->input->post('asset_code', TRUE);
                $m_movement->asset_description = $this->input->post('asset_description', TRUE);
                $m_movement->fixed_asset_id = $this->input->post('fixed_asset_id', TRUE);
                $m_movement->remarks = $this->input->post('remarks', TRUE);
                $m_movement->date_movement=date('Y-m-d',strtotime($this->input->post('date_movement',TRUE)));
                $m_movement->location_id_from = $this->input->post('location_id_from', TRUE);
                $m_movement->location_id_to = $this->input->post('location_id_to', TRUE);
                $m_movement->asset_status_id = $this->input->post('asset_status_id', TRUE);
                $m_movement->save();

                $asset_movement_id = $m_movement->last_insert_id();

                // $m_trans=$this->Trans_model;
                // $m_trans->user_id=$this->session->user_id;
                // $m_trans->set('trans_date','NOW()');
                // $m_trans->trans_key_id=1; //CRUD
                // $m_trans->trans_type_id=46; // TRANS TYPE
                // $m_trans->trans_log='Created Department: '.$this->input->post('department_name', TRUE);
                // $m_trans->save();
                $m_movement->asset_no='AM-'.date('Ymd').'-'.$asset_movement_id;
                $m_movement->modify($asset_movement_id);


                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Movement Record successfully created.';
                $response['row_added'] = $m_movement->get_list($asset_movement_id,
                    'asset_movement.*,
                    aps.asset_property_status',
                    array(
                        array('asset_property_status aps','aps.asset_status_id = asset_movement.asset_status_id','left')
                        )
                    );
                echo json_encode($response);

                break;

            case 'delete':
                $m_movement = $this->Asset_movement_model;

                $asset_movement_id=$this->input->post('asset_movement_id',TRUE);

                $m_movement->is_deleted=1;
                if($m_movement->modify($asset_movement_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Asset Movement successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $asset_movement_id =$this->input->post('asset_movement_id');
                $m_movement = $this->Asset_movement_model;
                $m_movement->set('date_modified','NOW()'); //treat NOW() as function and not string
                $m_movement->asset_code = $this->input->post('asset_code', TRUE);
                $m_movement->asset_description = $this->input->post('asset_description', TRUE);
                $m_movement->fixed_asset_id = $this->input->post('fixed_asset_id', TRUE);
                $m_movement->remarks = $this->input->post('remarks', TRUE);
                $m_movement->date_movement=date('Y-m-d',strtotime($this->input->post('date_movement',TRUE)));
                $m_movement->location_id_from = $this->input->post('location_id_from', TRUE);
                $m_movement->location_id_to = $this->input->post('location_id_to', TRUE);
                $m_movement->asset_status_id = $this->input->post('asset_status_id', TRUE);
                $m_movement->modify($asset_movement_id);


                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Asset Movement successfully updated.';
                $response['row_updated']=$m_movement->get_list($asset_movement_id,
                    'asset_movement.*,
                    aps.asset_property_status',
                    array(
                        array('asset_property_status aps','aps.asset_status_id = asset_movement.asset_status_id','left')
                        )
                    );
                echo json_encode($response);

                break;
        }
    }
}
