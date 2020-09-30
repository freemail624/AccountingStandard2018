<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_vouchers extends CORE_Controller
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
                'Cash_vouchers_model',
                'Cash_vouchers_accounts_model',
                'Tax_types_model',
                'Delivery_invoice_model',
                'Payment_method_model',
                'Check_layout_model',
                'Payable_payment_model',
                'Accounting_period_model',
                'Company_model',
                'Users_model',
                'Check_types_model',
                'Trans_model',
                'Bir_2307_model',
                'Account_integration_model'
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

        $data['check_types']=$this->Check_types_model->get_list('b_refchecktype.is_deleted=FALSE',
            'b_refchecktype.*,account_titles.account_title',
            array(array( 'account_titles' , 'account_titles.account_id = b_refchecktype. account_id', 'left'))
            );
        $data['suppliers']=$this->Suppliers_model->get_list('is_deleted = FALSE',null, null,'supplier_name ASC');
        $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE',null, null,'department_name ASC');
        $data['accounts']=$this->Account_title_model->get_list('is_deleted = FALSE',null, null,'trim(account_title) ASC');
        $data['methods']=$this->Payment_method_model->get_list();
        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['payment_methods']=$this->Payment_method_model->get_list('is_deleted=0');
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');

        $data['title'] = 'Temporary Cash Voucher Journal';
        (in_array('1-8',$this->session->user_rights)? 
        $this->load->view('cash_vouchers_view', $data)
        :redirect(base_url('dashboard')));
        
    }


    public function transaction($txn=null){
        switch($txn){
            case 'list':
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $fil = $this->input->get('fil');
                if($fil == 1){ // PENDING OR VERIFIED
                    $additional = " AND DATE(cv_info.date_txn) BETWEEN '$tsd' AND '$ted' AND cv_info.approved_by_user = 0 AND cv_info.cancelled_by_user = 0";
                }else if($fil == 2) { // APPROVED AND POSTED
                    $additional = " AND DATE(cv_info.date_txn) BETWEEN '$tsd' AND '$ted' AND cv_info.approved_by_user > 0 AND cv_info.cancelled_by_user = 0";
                }else if($fil == 3) { // DISAPPROVED AND CANCELLED
                    $additional = " AND DATE(cv_info.date_txn) BETWEEN '$tsd' AND '$ted' AND cv_info.approved_by_user = 0 AND cv_info.cancelled_by_user > 0";
                }
                
                $response['data']=$this->get_response_rows(null,$additional);
                echo json_encode($response);
                break;

            case 'list-for-approval':               
                $response['data']=$this->get_response_rows(null,'AND cv_info.approved_by_user = 0 AND cv_info.cancelled_by_user = 0 AND cv_info.verified_by_user > 0');
                echo json_encode($response);
                break;

            case 'get-entries':
                $cv_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_cv_accounts=$this->Cash_vouchers_accounts_model;

                $data['accounts']=$m_accounts->get_list(array('is_deleted'=>FALSE),null, null,'trim(account_title) ASC');
                $data['entries']=$m_cv_accounts->get_list('cv_accounts.cv_id='.$cv_id);
                $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE',null, null,'department_name ASC');

                $this->load->view('template/cv_journal_entries', $data);

                break;

            case 'create' :
                $m_info=$this->Cash_vouchers_model;
                $m_supplier=$this->Suppliers_model;
                $m_form_2307=$this->Bir_2307_model;
                $m_cv_accounts=$this->Cash_vouchers_accounts_model;
                $m_company=$this->Company_model;
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $m_info->ref_type=$this->input->post('ref_type');
                $m_info->ref_no=$this->input->post('ref_no');
                $m_info->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_info->remarks=$this->input->post('remarks',TRUE);
                $m_info->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_info->department_id=$this->input->post('department_id');
                $m_info->payment_method_id=$this->input->post('payment_method');
                $m_info->check_type_id=$this->input->post('check_type_id');
                if($this->input->post('check_date',TRUE) != '' || $this->input->post('check_date',TRUE) != null){
                    $m_info->check_no=$this->input->post('check_no');
                    $m_info->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                }
                $m_info->amount=$this->get_numeric_value($this->input->post('amount'));

                //for audit details
                $m_info->set('date_created','NOW()');
                $m_info->created_by_user=$this->session->user_id;


                $m_info->is_2307 =$this->get_numeric_value($this->input->post('is_2307',TRUE));
                $m_info->atc_2307=$this->input->post('atc_2307',TRUE);
                $m_info->remarks_2307=$this->input->post('remarks_2307',TRUE);
                $m_info->save();

                $cv_id=$m_info->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);
                $department_id_line=$this->input->post('department_id_line',TRUE);

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_cv_accounts->cv_id=$cv_id;
                    $m_cv_accounts->account_id=$accounts[$i];
                    $m_cv_accounts->memo=$memos[$i];
                    $m_cv_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_cv_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_cv_accounts->department_id=$this->get_numeric_value($department_id_line[$i]); 
                    $m_cv_accounts->save();
                }

                $m_info->txn_no='TMP-'.date('Ymd').'-'.$cv_id;
                $m_info->modify($cv_id);


                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Created Temporary Voucher TMP-'.date('Ymd').'-'.$cv_id;
                $m_trans->save();

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Temporary Voucher successfully posted';
                $response['row_added']=$this->get_response_rows($cv_id);
                echo json_encode($response);
                break;


            case 'update' :
                $cv_id=$this->input->get('id');
                $m_info=$this->Cash_vouchers_model;
                $m_supplier=$this->Suppliers_model;
                $m_form_2307=$this->Bir_2307_model;
                $m_cv_accounts=$this->Cash_vouchers_accounts_model;
                $m_company=$this->Company_model;


                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $m_info->ref_type=$this->input->post('ref_type');
                $m_info->ref_no=$this->input->post('ref_no');
                $m_info->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_info->remarks=$this->input->post('remarks',TRUE);
                $m_info->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_info->department_id=$this->input->post('department_id');
                $m_info->payment_method_id=$this->input->post('payment_method');
                $m_info->check_type_id=$this->input->post('check_type_id');
                if($this->input->post('check_date',TRUE) != '' || $this->input->post('check_date',TRUE) != null){
                    $m_info->check_no=$this->input->post('check_no');
                    $m_info->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                }
                $m_info->amount=$this->get_numeric_value($this->input->post('amount'));

                //for audit details
                $m_info->set('date_modified','NOW()');
                $m_info->modified_by_user=$this->session->user_id;


                $m_info->is_2307 =$this->get_numeric_value($this->input->post('is_2307',TRUE));
                $m_info->atc_2307=$this->input->post('atc_2307',TRUE);
                $m_info->remarks_2307=$this->input->post('remarks_2307',TRUE);
                $m_info->modify($cv_id);


                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);
                $department_id_line=$this->input->post('department_id_line',TRUE);

                $m_cv_accounts->delete_via_fk($cv_id);
                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_cv_accounts->cv_id=$cv_id;
                    $m_cv_accounts->account_id=$accounts[$i];
                    $m_cv_accounts->memo=$memos[$i];
                    $m_cv_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_cv_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_cv_accounts->department_id=$this->get_numeric_value($department_id_line[$i]); 
                    $m_cv_accounts->save();
                }

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Updated Temporary Voucher ('.$cv_id.')';
                $m_trans->save();

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Temporary Voucher successfully posted';
                $response['row_updated']=$this->get_response_rows($cv_id);
                echo json_encode($response);
                break;

            case 'delete':
                $m_info=$this->Cash_vouchers_model;
                $cv_id=$this->input->post('cv_id',TRUE);

                //mark Items as deleted
                $m_info->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_info->deleted_by_user=$this->session->user_id;//user that cancelled the record
                $m_info->is_deleted = 1;
                $m_info->modify($cv_id);

                $response['title']='Deleted!';
                $response['stat']='success';
                $response['msg']='Temporary Voucher Successfully deleted.';
                $response['row_updated']=$this->get_response_rows($cv_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Deleted Temporary Voucher ('.$cv_id.')';
                $m_trans->save();

                echo json_encode($response);

            break;

            case 'verify':
                $m_info=$this->Cash_vouchers_model;
                $cv_id=$this->input->post('cv_id',TRUE);

                //mark Items as deleted
                $m_info->set('date_verified','NOW()'); //treat NOW() as function and not string
                $m_info->verified_by_user=$this->session->user_id;//user that cancelled the record
                $m_info->modify($cv_id);


                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Marked as Final Temporary Voucher ('.$cv_id.')';
                $m_trans->save();


                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Temporary Voucher Successfully Marked as Verified.';
                $response['row_updated']=$this->get_response_rows($cv_id);

                echo json_encode($response);

                break;
        };
    }



    public function get_response_rows($criteria=null,$additional=null){
        $m_info=$this->Cash_vouchers_model;
        return $m_info->get_list(
            "cv_info.is_deleted=FALSE ".($criteria==null?'':' AND cv_info.cv_id='.$criteria)."".($additional==null?'':$additional),
            array(
                'cv_info.*',
                'DATE_FORMAT(cv_info.date_txn,"%m/%d/%Y")as date_txn',
                'DATE_FORMAT(cv_info.check_date,"%m/%d/%Y") as check_date',
                'payment_methods.payment_method',
                'suppliers.supplier_name as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                'CONCAT_WS(" ",vbu.user_fname,vbu.user_lname)as verified_by',
                'CONCAT_WS(" ",abu.user_fname,abu.user_lname)as approved_by'
            ),
            array(
                array('suppliers','suppliers.supplier_id=cv_info.supplier_id','left'),
                array('departments','departments.department_id=cv_info.department_id','left'),
                array('user_accounts','user_accounts.user_id=cv_info.created_by_user','left'),
                array('user_accounts vbu','vbu.user_id=cv_info.verified_by_user','left'),
                array('user_accounts abu','abu.user_id=cv_info.approved_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=cv_info.payment_method_id','left')
            ),
            'cv_info.cv_id DESC'
        );
    }






}
