<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bins extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Bins_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Bin Management';
        (in_array('4-14',$this->session->user_rights)? 
        $this->load->view('bin_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_bin = $this->Bins_model;
                $response['data'] = $m_bin->get_bin_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_bin = $this->Bins_model;
                $bin_code = $this->input->post('bin_code', TRUE);

                //validate bin
                $check_bin=$m_bin->check_bin($bin_code);

                if(count($check_bin)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$bin_code.' is already existing. <br/>Please make sure bin is unique!<br />';
                    die(json_encode($response));
                }

                $m_bin->begin();

                $m_bin->bin_code = $bin_code;
                $m_bin->description = $this->input->post('description', TRUE);
                $m_bin->save();
                $bin_id = $m_bin->last_insert_id();

                $m_bin->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=82; // TRANS TYPE
                $m_trans->trans_log='Created Bin: '.$bin_code;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Bin Information successfully created.';
                $response['row_added'] = $m_bin->get_bin_list($bin_id);
                echo json_encode($response);

                break;

            case 'update':
                $m_bin=$this->Bins_model;

                $bin_id=$this->input->post('bin_id',TRUE);
                $bin_code = $this->input->post('bin_code', TRUE);

                //validate bin
                $check_bin=$m_bin->check_bin($bin_code,$bin_id);

                if(count($check_bin)>0){
                    $response['stat']='error';
                    $response['title']='<b>Reference Error</b>';
                    $response['msg']=$bin_code.' is already existing. <br/>Please make sure bin is unique!<br />';
                    die(json_encode($response));
                }

                $m_bin->begin();

                $m_bin->bin_code=$bin_code;
                $m_bin->description=$this->input->post('description',TRUE);
                $m_bin->modify($bin_id);

                $m_bin->commit();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=82; // TRANS TYPE
                $m_trans->trans_log='Updated Bin: '.$bin_code.' ID('.$bin_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Bin Information successfully updated.';
                $response['row_updated']=$m_bin->get_bin_list($bin_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_bin=$this->Bins_model;

                $bin_id=$this->input->post('bin_id',TRUE);

                $m_bin->is_deleted=1;
                if($m_bin->modify($bin_id)){

                    $bin = $m_bin->get_list($bin_id,'bin_code');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=82; // TRANS TYPE
                    $m_trans->trans_log='Deleted Bin: '.$bin[0]->bin_code;
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Bin Information successfully deleted.';

                    echo json_encode($response);
                }

                break;
        }
    }
}
