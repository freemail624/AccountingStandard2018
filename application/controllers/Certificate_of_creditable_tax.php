<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_of_creditable_tax extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Users_model');
        $this->load->model('Months_model');
        $this->load->model('Bir_2307_model');
        $this->load->model('Company_model');
        $this->load->library('M_pdf');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['months']=$this->Months_model->get_list();
        $data['title'] = 'Certificate of Creditable Tax';
        (in_array('16-3',$this->session->user_rights)? 
        $this->load->view('certificate_of_creditable_tax_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_form_2307 = $this->Bir_2307_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                if($month == 0){$month = null;}
                $response['data'] = $m_form_2307->get_2307_list($month,$year);
                echo json_encode($response);
                break;


            case 'print-list':
                $m_form_2307 = $this->Bir_2307_model;
                $month = $this->input->get('month', TRUE);
                $year = $this->input->get('year', TRUE);
                if($month == 0){$month = null;}
                $data['items'] = $m_form_2307->get_2307_list($month,$year);
                $data['company_info']=$this->Company_model->get_list()[0];

                $file_name='Certificate of Creditable Tax Report';
                $pdfFilePath = $file_name.".pdf";
                $pdf = $this->m_pdf->load(); 
                $pdf->AddPage('L');
                $content =  $this->load->view('template/2307_content',$data,TRUE);
                $pdf->SetTitle('Certificate of Creditable Tax Report');
                $pdf->WriteHTML($content);
                $pdf->Output();
                
                break;
        }
    }
}
