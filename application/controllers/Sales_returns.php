<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Sales_returns extends CORE_Controller
    {
        
        function __construct()
        {
            parent::__construct('');
            $this->validate_session();
            $this->load->model(
                array(
                    'Pos_item_returns_model',
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
	        $data['title'] = 'Sales Returns Report';

        $data['xreadings']=$this->Pos_item_returns_model->get_xreading();
        (in_array('3-10',$this->session->user_rights)? 
        $this->load->view('sales_returns_view',$data)
        :redirect(base_url('dashboard')));
            
        }

        function transaction($txn=null){
            switch($txn){
                case 'list':
					$x_id=$this->input->get('x_id',TRUE);
					$m_xreading=$this->Pos_item_returns_model;
					$response['data']=$m_xreading->get_list(array('x_reading_id'=>$x_id),
                        'pos_item_returns.*,products.product_desc',
                        array(array('products','products.product_id = pos_item_returns.product_id','left'))
                        );
					echo json_encode($response);

                break;


                case 'pos-returns-for-review':
                $m_xreading=$this->Pos_item_returns_model;
                    $response['data']=$m_xreading->get_pos_returns_for_review();
                    echo json_encode($response);

                break;

            

            }
        }
    }
?>