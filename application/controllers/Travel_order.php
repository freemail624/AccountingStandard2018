<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Travel_order extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Travel_order_model');
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
        $data['title'] = 'Travel Order';
        (in_array('17-2',$this->session->user_rights)? 
        $this->load->view('travel_order_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_travel_order = $this->Travel_order_model;
                $response['data'] = $m_travel_order->get_travel_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_travel_order = $this->Travel_order_model;

                $m_travel_order->employee_name = $this->input->post('employee_name', TRUE);
                $m_travel_order->official_designation = $this->input->post('official_designation', TRUE);
                $m_travel_order->travel_date = date('Y-m-d',strtotime($this->input->post('travel_date', TRUE)));
                $m_travel_order->destination = $this->input->post('destination', TRUE);
                $m_travel_order->person_to_visit = $this->input->post('person_to_visit', TRUE);
                $m_travel_order->designation = $this->input->post('designation', TRUE);
                $m_travel_order->purpose_of_travel = $this->input->post('purpose_of_travel', TRUE);
                $m_travel_order->save();

                $travel_order_id = $m_travel_order->last_insert_id();

                //update travel order number base on formatted last insert id
                $travel_order_no='TR-'.date('Ymd').'-'.$travel_order_id;
                $m_travel_order->travel_order_no=$travel_order_no;
                $m_travel_order->modify($travel_order_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=73; // TRANS TYPE
                $m_trans->trans_log='Created Travel Order for '.$this->input->post('employee_name', TRUE).' : Order# '.$travel_order_no;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Travel Order successfully created.';
                $response['row_added'] = $m_travel_order->get_travel_list($travel_order_id);
                echo json_encode($response);

                break;

            case 'update':
                $m_travel_order=$this->Travel_order_model;

                $travel_order_id=$this->input->post('travel_order_id',TRUE);

                $m_travel_order->employee_name = $this->input->post('employee_name', TRUE);
                $m_travel_order->official_designation = $this->input->post('official_designation', TRUE);
                $m_travel_order->travel_date = date('Y-m-d',strtotime($this->input->post('travel_date', TRUE)));
                $m_travel_order->destination = $this->input->post('destination', TRUE);
                $m_travel_order->person_to_visit = $this->input->post('person_to_visit', TRUE);
                $m_travel_order->designation = $this->input->post('designation', TRUE);
                $m_travel_order->purpose_of_travel = $this->input->post('purpose_of_travel', TRUE);
                $m_travel_order->modify($travel_order_id);

                $travel_order = $m_travel_order->get_list($travel_order_id,'travel_order_no');

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=73; // TRANS TYPE
                $m_trans->trans_log='Updated Travel Order: Order#('.$travel_order[0]->travel_order_no.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Travel Order successfully updated.';
                $response['row_updated']=$m_travel_order->get_travel_list($travel_order_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_travel_order=$this->Travel_order_model;

                $travel_order_id=$this->input->post('travel_order_id',TRUE);
                $m_travel_order->is_deleted=1;

                if($m_travel_order->modify($travel_order_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Travel Order successfully deleted.';

                    $travel_order = $m_travel_order->get_list($travel_order_id,'travel_order_no');

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=73; // TRANS TYPE
                    $m_trans->trans_log='Deleted Travel Order : '.$travel_order[0]->travel_order_no;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

        }
    }
}
