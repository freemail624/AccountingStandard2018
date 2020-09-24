<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Treasury extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Suppliers_model',
                'Departments_model',
                'Account_title_model',
                'Payment_method_model',
                'Journal_info_model',
                'Journal_account_model',
                'Tax_types_model',
                'Delivery_invoice_model',
                'Payment_method_model',
                'Check_layout_model',
                'Payable_payment_model',
                'Accounting_period_model',
                'Journal_template_info_model',
                'Journal_template_entry_model',
                'Company_model',
                'Users_model',
                'Check_types_model'
            )
        );

    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['check_types']=$this->Check_types_model->get_list('is_deleted=FALSE');
        $data['suppliers']=$this->Suppliers_model->get_list('is_deleted = FALSE');
        $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE');
        $data['accounts']=$this->Account_title_model->get_list('is_deleted = FALSE');
        $data['methods']=$this->Payment_method_model->get_list();
        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['payment_methods']=$this->Payment_method_model->get_list('is_deleted=0');
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');

        $data['title'] = 'Treasury';
        (in_array('1-2',$this->session->user_rights)? 
        $this->load->view('treasury_view', $data)
        :redirect(base_url('dashboard')));
        
    }


    public function transaction($txn=null){
        switch($txn){
            case 'get-check-list':
                $m_journal=$this->Journal_info_model;

                $approval_id = $this->input->get('approval_id');
                $approval_filter="";

                if($approval_id!="all"){
                    $approval_filter = "AND is_check_approved=".$approval_id;
                }

                $response['data']=$m_journal->get_list(
                    "journal_info.is_active=1 AND journal_info.is_deleted=0  AND journal_info.book_type='CDJ' AND journal_info.payment_method_id=2 AND journal_info.check_status=0 ".$approval_filter,
                    array(
                        'journal_info.*',
                        's.supplier_name',
                        'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date'
                    ),
                    array(
                        array('suppliers as s','s.supplier_id=journal_info.supplier_id','left')
                    )
                );
                echo json_encode($response);
                break;

            case 'check-for-release':
                $m_journal=$this->Journal_info_model;
                $response['data']=$m_journal->get_list(
                    "journal_info.is_active=1 AND journal_info.is_check_delivered=FALSE AND journal_info.is_deleted=0 AND journal_info.book_type='CDJ' AND journal_info.payment_method_id=2 AND journal_info.check_status=1",
                    array(
                        'journal_info.*',
                        's.supplier_name',
                        'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date'
                    ),
                    array(
                        array('suppliers as s','s.supplier_id=journal_info.supplier_id','left')
                    )
                );
                echo json_encode($response);
                break;

            case 'check-delivered':
                $m_journal=$this->Journal_info_model;
                $response['data']=$m_journal->get_list(
                    "journal_info.is_active=1 AND journal_info.is_check_delivered=TRUE AND journal_info.is_deleted=0 AND journal_info.book_type='CDJ' AND journal_info.payment_method_id=2 AND journal_info.check_status=1",
                    array(
                        'journal_info.*',
                        's.supplier_name',
                        'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date'
                    ),
                    array(
                        array('suppliers as s','s.supplier_id=journal_info.supplier_id','left')
                    )
                );
                echo json_encode($response);
                break;

            case 'get-entries':
                $journal_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_journal_accounts=$this->Journal_account_model;

                $data['accounts']=$m_accounts->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE));
                $data['entries']=$m_journal_accounts->get_list('journal_accounts.journal_id='.$journal_id);

                $this->load->view('template/journal_entries', $data);
                break;

            case 'mark-delivered':
                $journal_id=$this->input->post('journal_id');
                $m_journal=$this->Journal_info_model;
                $m_journal->is_check_delivered=TRUE;
                $m_journal->modify($journal_id);

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Check successfully marked as delivered.';
                echo json_encode($response);
            break;

            case 'mark-issued':
                $journal_id=$this->input->post('journal_id');
                $m_journal=$this->Journal_info_model;
                $m_journal->check_status=TRUE;
                $m_journal->modify($journal_id);

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Check successfully marked as issued.';
                echo json_encode($response);
            break;

            case 'mark-approved':
                $journal_id=$this->input->post('journal_id');
                $m_journal=$this->Journal_info_model;
                $m_journal->is_check_approved=TRUE;
                $m_journal->modify($journal_id);

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Check successfully marked as approved.';
                echo json_encode($response);
            break;            
        };
    }



    public function get_response_rows($criteria=null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='CDJ'".($criteria==null?'':' AND journal_info.journal_id='.$criteria),

            array(
                'journal_info.journal_id',
                'journal_info.txn_no',
                'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                'journal_info.is_active',
                'journal_info.remarks',
                'journal_info.department_id',
                'journal_info.check_type_id',
                'journal_info.supplier_id',
                'journal_info.customer_id',
                'journal_info.payment_method_id',
                'payment_methods.payment_method',
                'journal_info.check_no',
                'journal_info.check_status',
                'suppliers.supplier_name',
                'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y") as check_date',
                'journal_info.ref_type',
                'journal_info.ref_no',
                'journal_info.amount',

                'CONCAT(IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,""))as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
            ),
            array(
                array('customers','customers.customer_id=journal_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                array('departments','departments.department_id=journal_info.department_id','left'),
                array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left')
            ),
            'journal_info.journal_id DESC'
        );
    }






}
