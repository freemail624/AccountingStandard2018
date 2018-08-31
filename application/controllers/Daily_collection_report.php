<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Daily_collection_report extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Company_model'
				)
			);
	        $this->load->library('excel');
	        $this->load->model('Email_settings_model');
		}

		public function index() {
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Daily Collection Report';
        (in_array('14-4',$this->session->user_rights)? 
        $this->load->view('daily_collection_report_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch ($txn) {
				case 'list':
					$m_journal=$this->Journal_info_model;

					$date=date('Y-m-d',strtotime($this->input->get('date',TRUE)));
					$bal = $m_journal->get_revolving_fund_balance($date);
					$response['carf'] = $m_journal->get_revolving_fund_carf($date);
					$response['collection'] = $m_journal->get_revolving_fund_collection($date);
					$response['balance']=$bal[0]->Balance;

					echo json_encode($response);
				break;

				case 'report':
					$m_company=$this->Company_model;
					$company_info=$m_company->get_list();
					$data['company_info']=$company_info[0];
					$m_journal=$this->Journal_info_model;
					$date=date('Y-m-d',strtotime($this->input->get('date',TRUE)));
					$bal = $m_journal->get_revolving_fund_balance($date);
					$data['carf'] = $m_journal->get_revolving_fund_carf($date);
					$data['collection'] = $m_journal->get_revolving_fund_collection($date);
					$data['balance']=$bal[0]->Balance;

					$this->load->view('template/daily_collection_report_content',$data);
				break;

			

			}
		}
	}
?>