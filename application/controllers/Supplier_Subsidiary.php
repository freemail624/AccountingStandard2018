<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Supplier_Subsidiary extends CORE_Controller 
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array
				(
					'Journal_account_model',
					'Journal_info_model',
					'Suppliers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
					'Customer_subsidiary_model',
					'Company_model',
                    'Account_integration_model'
				)
			);

        $this->load->library('M_pdf');
		}

		public function index() {
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);


	        $data['title'] = 'Supplier Subsidiary';
	        $data['suppliers'] = $this->Suppliers_model->get_list('is_deleted=FALSE AND supplier_name != "" AND is_active=TRUE',null,null,'supplier_name');
	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE',null,null,'account_title');

            $ap_account=$this->Account_integration_model->get_list();
            $data['ap_account']=$ap_account[0]->payable_account_id;
        (in_array('9-7',$this->session->user_rights)? 
        $this->load->view('supplier_subsidiary_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch($txn){
				case 'get-supplier-subsidiary':

					$supplier_Id=$this->input->get('supplierId',TRUE);
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_journal=$this->Journal_info_model;

					$response['data']=$m_journal->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
					echo json_encode($response);

				break;

				case 'get-supplier-subsidiary-all':
					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_journal=$this->Journal_info_model;
	                $m_company_info=$this->Company_model;	
	               	$data['account'] = $this->Account_title_model->get_list($account_Id)[0];
	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];
					$suppliers = $this->Suppliers_model->get_list(array('is_active'=>true,'is_deleted'=>false));
					foreach ($suppliers as $supplier) {
						$responses[$supplier->supplier_id]=$m_journal->get_supplier_subsidiary($supplier->supplier_id,$account_Id,$start_Date,$end_Date);

					}

				$data['suppliers'] = $suppliers;
				$data['responses'] = $responses;
                $pdf = $this->m_pdf->load("A4-L");
                $content=$this->load->view('template/supplier_all_subsidiary_report',$data,TRUE);
                $pdf->WriteHTML($content);
                $pdf->Output();

				break;
			}
		}
	}

?>