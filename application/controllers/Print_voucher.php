<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_voucher extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Journal_info_model');
        $this->load->model('Journal_account_model');
        $this->load->model('Company_model');
        $this->load->library('M_pdf');
    }

    public function index() {
        $this->Users_model->validate();
       
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'print-voucher':
                $voucher_format_id =  $this->input->get('format', TRUE);
                $type =  $this->input->get('type', TRUE);
                $journal_id =  $this->input->get('id', TRUE);

                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    array('journal_id'=>$journal_id),
                    array(
                        'journal_info.*',
                        'journal_info.is_active as cancelled',
                        'suppliers.supplier_name',
                        'suppliers.address',
                        'suppliers.email_address',
                        'suppliers.contact_no',
                        'suppliers.contact_name',
                        'departments.department_name',
                        'payment_methods.*'
                    ),
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('departments','departments.department_id=journal_info.department_id','left'),
                        array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left')
                    )
                );
                $company=$m_company->get_list();
                $data['company_info']=$company[0];
                $data['journal_info']=$journal_info[0];
                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(
                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),
                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title'
                    ),
                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                    ,
                    'journal_accounts.dr_amount DESC,journal_accounts.journal_account_id '
                );
                $data['num_words']=$this->convertDecimalToWords($journal_info[0]->amount);

                $file_name=$journal_info[0]->txn_no;
                $pdfFilePath = $file_name.".pdf"; 
                $pdf = $this->m_pdf->load(); 

                if($voucher_format_id=='1'){ // RCBC/CHINA BANK
                    $content=$this->load->view('template/cdj_journal_entries_content',$data,TRUE);
                } else if($voucher_format_id=='2'){ // RCBC/CHINA BANK
                    $content=$this->load->view('template/cdj_journal_entries_content_version_2',$data,TRUE);
                } else if($voucher_format_id=='3'){ // RCBC/CHINA BANK WITH CHECK
                    $content=$this->load->view('template/cdj_journal_entries_content_version_3',$data,TRUE);
                } else if($voucher_format_id=='4'){ // BPI
                    $content=$this->load->view('template/cdj_journal_entries_content_version_4',$data,TRUE);
                } else if($voucher_format_id=='5'){ // BPI WITH CHECK
                    $content=$this->load->view('template/cdj_journal_entries_content_version_5',$data,TRUE);
                }

                $pdf->WriteHTML($content);
                $pdf->Output();

                break;

        }
    }
}
