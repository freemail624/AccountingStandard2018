<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_locations extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Product_locations_model');
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
        $data['title'] = 'Product Location Management';
        (in_array('4-15',$this->session->user_rights)? 
        $this->load->view('product_location_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_locations = $this->Product_locations_model;
                $response['data'] = $m_locations->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
                echo json_encode($response);
                break;

            case 'create':
                $m_locations = $this->Product_locations_model;

                $m_locations->location = $this->input->post('location', TRUE);
                $m_locations->date_created = date('Y-m-d H:i:s');
                $m_locations->save();

                $product_location_id = $m_locations->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=83; // TRANS TYPE
                $m_trans->trans_log='Created Product Location : '.$this->input->post('location', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Product Location Information successfully created.';
                $response['row_added'] = $m_locations->get_location_list($product_location_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_locations=$this->Product_locations_model;

                $product_location_id=$this->input->post('product_location_id',TRUE);

                $m_locations->is_deleted=1;
                if($m_locations->modify($product_location_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Product Location Information successfully deleted.';

                    $location = $m_locations->get_list($product_location_id,'location');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=83; // TRANS TYPE
                    $m_trans->trans_log='Deleted Product Location: '.$location[0]->location;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_locations=$this->Product_locations_model;

                $product_location_id=$this->input->post('product_location_id',TRUE);
                $m_locations->location=$this->input->post('location',TRUE);
                $m_locations->date_modified = date('Y-m-d H:i:s');
                $m_locations->modify($product_location_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=83; // TRANS TYPE
                $m_trans->trans_log='Updated Department: '.$this->input->post('location',TRUE).' ID('.$product_location_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Product Location Information successfully updated.';
                $response['row_updated']=$m_locations->get_location_list($product_location_id);
                echo json_encode($response);

                break;
        }
    }
}
