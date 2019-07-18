<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class X_reading_report extends CORE_Controller
    {
        
        function __construct()
        {
            parent::__construct('');
            $this->validate_session();
            $this->load->model(
                array(
                    'Pos_item_sales_model',
                    'Users_model',
                    'Company_model'
                )
            );
            $this->load->library('excel');
            $this->load->model('Email_settings_model');
        }

		public function index()
		{	
			$this->Users_model->validate();
		 	$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'X Reading Report';

        $data['xreadings']=$this->Pos_item_sales_model->get_xreading();
        (in_array('3-7',$this->session->user_rights)? 
        $this->load->view('x_reading_report_view',$data)
        :redirect(base_url('dashboard')));
            
        }

        function transaction($txn=null){
            switch($txn){
                case 'list':

					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                    $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$x_id=$this->input->get('x_id',TRUE);
					$m_xreading=$this->Pos_item_sales_model;

					$response['data']=$m_xreading->get_x_reading_sales($x_id);
					echo json_encode($response);

                break;


                case 'pos-sales-for-review':
                $m_xreading=$this->Pos_item_sales_model;
                    $response['data']=$m_xreading->get_pos_sales_for_review();
                    echo json_encode($response);

                break;

            

            }
        }
    }
?>