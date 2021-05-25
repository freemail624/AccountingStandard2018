<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicles extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Customer_vehicles_model');
        $this->load->model('Customers_model');
        $this->load->model('Makes_model');
        $this->load->model('Vehicle_year_model');
        $this->load->model('Vehicle_model');
        $this->load->model('Colors_model');
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
        $data['title'] = 'Vehicles Management';

        $data['makes'] = $this->Makes_model->get_makes_list();
        $data['years'] = $this->Vehicle_year_model->get_vehicle_year_list();
        $data['models'] = $this->Vehicle_model->get_models_list();
        $data['colors'] = $this->Colors_model->get_colors_list();

        (in_array('5-9',$this->session->user_rights)? 
        $this->load->view('customer_vehicle_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_vehicles = $this->Customer_vehicles_model;

                $customer_id = $this->input->post('customer_id');
                $vehicle_id = $this->input->post('vehicle_id');
                $draw = $this->input->post('draw', TRUE);
                $search =  $this->input->post('search', TRUE);
                $length = $this->input->post('length', TRUE);
                $start = $this->input->post('start', TRUE);
                $order = $this->input->post('order', TRUE);
                $search_value = $search['value'];
                $column = $order[0]['column'];
                $order_dir = $order[0]['dir'];

                $valid_columns = array(
                    0=>'details-control',
                    1=>'customer_no',
                    2=>'customer_name',
                    3=>'model_id',
                    4=>'conduction_no',
                    5=>'plate_no',
                    6=>'crp_no'
                );     

                $order_column = $valid_columns[$column];

                if($column == 0 OR $column == 4){
                    $order_column = null;
                }

                $data=$m_vehicles->get_vehicles(
                    $vehicle_id,
                    $customer_id,
                    $search_value,
                    $length,
                    $start,
                    $order_column,
                    $order_dir
                ); 

                $recordsTotal = $m_vehicles->get_all_data($customer_id);
                $recordsFiltered = $m_vehicles->get_all_data($customer_id,$search_value);

                $response = array(
                    "draw"            => intval($draw),
                    "recordsTotal"    => $recordsTotal,
                    "recordsFiltered" => $recordsFiltered,
                    "data"            => $data
                );

                echo json_encode($response);
                exit();

                break;

            case 'get-customer-vehicles':
                $m_vehicle = $this->Customer_vehicles_model;
                $customer_id = $this->input->post('customer_id');
                $response['data'] = $m_vehicle->get_vehicles(null,$customer_id);
                echo json_encode($response);
                break;

            case 'create':
                $m_vehicle = $this->Customer_vehicles_model;
                $m_customers = $this->Customers_model;

                $customer_id = $this->input->post('customer_id', TRUE);
                $plate_no = $this->input->post('plate_no', TRUE);
                $conduction_no = $this->input->post('conduction_no', TRUE);

                $m_vehicle->begin();
                $m_vehicle->customer_id = $customer_id;
                $m_vehicle->make_id = $this->input->post('make_id', TRUE);
                $m_vehicle->vehicle_year_id = $this->input->post('vehicle_year_id', TRUE);
                $m_vehicle->model_id = $this->input->post('model_id', TRUE);
                $m_vehicle->color_id = $this->input->post('color_id', TRUE);
                $m_vehicle->conduction_no = $conduction_no;
                $m_vehicle->plate_no = $plate_no;
                $m_vehicle->chassis_no = $this->input->post('chassis_no', TRUE);
                $m_vehicle->engine_no = $this->input->post('engine_no', TRUE);
                $m_vehicle->crp_no_type = $this->input->post('crp_no_type', TRUE);

                $date = $this->input->post('delivery_date', TRUE);

                if($date == "" || $date == null){
                    $delivery_date = null;
                }else{
                    $delivery_date = date('Y-m-d', strtotime($date));
                }

                $m_vehicle->delivery_date = $delivery_date;
                $m_vehicle->save();
                
                date('Y-m-d', strtotime($this->input->post('crp_no_type', TRUE)));

                $vehicle_id = $m_vehicle->last_insert_id();

                $m_vehicle->commit();


                $customer = $m_customers->get_list($customer_id,'customer_name');
                $trans_log="";

                if($plate_no != "" || $plate_no != null){
                    $trans_log = 'Created vehicle for '.$customer[0]->customer_name.' with plate # '.$plate_no;
                }else{
                    $trans_log = 'Created vehicle for '.$customer[0]->customer_name.' with conduction # '.$conduction_no;
                }

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=81; // TRANS TYPE
                $m_trans->trans_log=$trans_log;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Vehicle Information successfully created.';
                $response['row_added'] = $m_vehicle->get_vehicles($vehicle_id);
                echo json_encode($response);

                break;

            case 'update':
                $m_vehicle = $this->Customer_vehicles_model;
                $m_customers = $this->Customers_model;

                $vehicle_id = $this->input->post('vehicle_id', TRUE);
                $customer_id = $this->input->post('customer_id', TRUE);
                $plate_no = $this->input->post('plate_no', TRUE);
                $conduction_no = $this->input->post('conduction_no', TRUE);

                $m_vehicle->begin();
                $m_vehicle->customer_id = $customer_id;
                $m_vehicle->make_id = $this->input->post('make_id', TRUE);
                $m_vehicle->vehicle_year_id = $this->input->post('vehicle_year_id', TRUE);
                $m_vehicle->model_id = $this->input->post('model_id', TRUE);
                $m_vehicle->color_id = $this->input->post('color_id', TRUE);
                $m_vehicle->conduction_no = $conduction_no;
                $m_vehicle->plate_no = $plate_no;
                $m_vehicle->chassis_no = $this->input->post('chassis_no', TRUE);
                $m_vehicle->engine_no = $this->input->post('engine_no', TRUE);
                $m_vehicle->crp_no_type = $this->input->post('crp_no_type', TRUE);
                $date = $this->input->post('delivery_date', TRUE);

                if($date == "" || $date == null){
                    $delivery_date = null;
                }else{
                    $delivery_date = date('Y-m-d', strtotime($date));
                }

                $m_vehicle->delivery_date = $delivery_date;

                $m_vehicle->modify($vehicle_id);
                $m_vehicle->commit();

                $customer = $m_customers->get_list($customer_id,'customer_name');

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=81; // TRANS TYPE
                $m_trans->trans_log='Updated vehivle of '.$customer[0]->customer_name.' ID('.$vehicle_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Vehicle Information successfully updated.';
                $response['row_updated']=$m_vehicle->get_vehicles($vehicle_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_vehicle=$this->Customer_vehicles_model;
                $vehicle_id=$this->input->post('vehicle_id',TRUE);

                $m_vehicle->is_deleted=1;
                if($m_vehicle->modify($vehicle_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Vehicle Information successfully deleted.';

                    $vehicle = $m_vehicle->get_list($vehicle_id, 'plate_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=81; // TRANS TYPE
                    $m_trans->trans_log='Deleted vehicle with plate # : '.$vehicle[0]->plate_no;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;                
        }
    }
}
