<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->library('excel');
        $this->load->model('Units_model');
        $this->load->model('Account_title_model');
        $this->load->model('Items_model');
        $this->load->model('Item_units_model');
        $this->load->model('Users_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Item Management';
        $data['units'] = $this->Item_units_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE),'account_id,account_title');

        (in_array('16-1',$this->session->user_rights)? 
        $this->load->view('items_view', $data)       
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $response['data']=$this->response_rows(array('items.is_active'=>TRUE,'items.is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'create';
                $m_items = $this->Items_model;
                $m_items->item_code = $this->input->post('item_code',TRUE);
                $m_items->item_desc = $this->input->post('item_desc',TRUE);
                $m_items->item_unit_id = $this->input->post('item_unit_id',TRUE);
                $m_items->income_account_id = $this->input->post('income_account_id',TRUE);
                $m_items->item_amount = $this->get_numeric_value($this->input->post('item_amount',TRUE));
                $m_items->save();
                $item_id = $m_items->last_insert_id();
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Item information successfully updated.';
                $response['row_added']=$this->response_rows($item_id);
                echo json_encode($response);

                break;

            case 'update';
                $m_items = $this->Items_model;
                $item_id = $this->input->post('item_id',TRUE);
                $m_items->item_code = $this->input->post('item_code',TRUE);
                $m_items->item_desc = $this->input->post('item_desc',TRUE);
                $m_items->item_unit_id = $this->input->post('item_unit_id',TRUE);
                $m_items->income_account_id = $this->input->post('income_account_id',TRUE);
                $m_items->item_amount = $this->get_numeric_value($this->input->post('item_amount',TRUE));
                $m_items->modify($item_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Item information successfully updated.';
                $response['row_updated']=$this->response_rows($item_id);
                echo json_encode($response);



                break;


            case 'delete';
                $m_items = $this->Items_model;
                $item_id = $this->input->post('item_id',TRUE);
                $m_items->deleted_by_user = $this->session->user_id;
                $m_items->is_deleted=1;
                    if($m_items->modify($item_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Item information successfully deleted.';

                        echo json_encode($response); 

                    }


                    break;

        }
    }

        function response_rows($filter){
        return $this->Items_model->get_list(
            $filter,
            'items.*,item_unit.item_unit_name',
            array(array('item_unit','item_unit.item_unit_id=items.item_unit_id','left'))
            );
        }











}