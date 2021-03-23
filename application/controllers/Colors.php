<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colors extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
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
        $data['title'] = 'Colors Management';

        (in_array('4-11',$this->session->user_rights)? 
        $this->load->view('colors_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_colors = $this->Colors_model;
                $response['data'] = $m_colors->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
                echo json_encode($response);
                break;

            case 'create':
                $m_colors = $this->Colors_model;
                $color =  $this->input->post('color', TRUE);

                //validate color
                $check_color=$m_colors->check_color($color);

                if(count($check_color)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$color.' is already existing. <br/>Please make sure color is unique!<br />';
                    die(json_encode($response));
                }

                $m_colors->color = $color;
                $m_colors->save();

                $color_id = $m_colors->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=76; // TRANS TYPE
                $m_trans->trans_log='Created Color: '.$this->input->post('color', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Color Information successfully created.';
                $response['row_added'] = $m_colors->get_colors_list($color_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_colors=$this->Colors_model;

                $color_id=$this->input->post('color_id',TRUE);
                $m_colors->is_deleted=1;

                if($m_colors->modify($color_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Color Information successfully deleted.';

                    $colors = $m_colors->get_list($color_id,'color');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=76; // TRANS TYPE
                    $m_trans->trans_log='Deleted Color: '.$colors[0]->color;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_colors=$this->Colors_model;

                $color_id=$this->input->post('color_id',TRUE);
                $color=$this->input->post('color',TRUE);

                //validate color
                $check_color=$m_colors->check_color($color,$color_id);

                if(count($check_color)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$color.' is already existing. <br/>Please make sure color is unique!<br />';
                    die(json_encode($response));
                }

                $m_colors->color=$color;
                $m_colors->modify($color_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=76; // TRANS TYPE
                $m_trans->trans_log='Updated Color: '.$this->input->post('color',TRUE).' ID('.$color_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Color Information successfully updated.';
                $response['row_updated']=$m_colors->get_colors_list($color_id);
                echo json_encode($response);

                break;
        }
    }
}
