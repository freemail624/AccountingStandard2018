<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_disbursement extends CORE_Controller
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
                'Check_types_model',
                'Trans_model',
                'Bir_2307_model',
                'Account_integration_model',
                'Tax_code_model'

            )
        );
        $this->load->model('Cash_vouchers_model');
        $this->load->model('Cash_vouchers_accounts_model');
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
        $data['tax_codes']=$this->Tax_code_model->get_taxcode_list();

        $data['title'] = 'Disbursement Journal';
        (in_array('1-2',$this->session->user_rights)? 
        $this->load->view('cash_disbursement_view', $data)
        :redirect(base_url('dashboard')));
        
    }


    public function transaction($txn=null){
        switch($txn){
            case 'list':
                $m_journal=$this->Journal_info_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $department_id = $this->input->get('dfilter');
                if($department_id == 0){
                    $additional = " AND DATE(journal_info.date_txn) BETWEEN '$tsd' AND '$ted' ";
                }else {
                    $additional = " AND DATE(journal_info.date_txn) BETWEEN '$tsd' AND '$ted' AND journal_info.department_id = '$department_id' ";  
                }
                $response['data']=$this->get_response_rows(null,$additional);
                echo json_encode($response);
                break;

            case 'get-entries':
                $journal_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_journal_accounts=$this->Journal_account_model;

                $data['accounts']=$m_accounts->get_list(array('is_deleted'=>FALSE),null, null,'trim(account_title) ASC');
                $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'department_name ASC');
                $data['entries']=$m_journal_accounts->get_list('journal_accounts.journal_id='.$journal_id);

                $this->load->view('template/journal_entries', $data);
                break;
            case 'create-template':
                $m_journal_temp_info=$this->Journal_template_info_model;
                $m_journal_temp_entry=$this->Journal_template_entry_model;

                $m_journal_temp_info->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_journal_temp_info->template_code=$this->input->post('template_code',TRUE);
                $m_journal_temp_info->template_description=$this->input->post('template_description',TRUE);
                $m_journal_temp_info->remarks=$this->input->post('remarks',TRUE);
                $m_journal_temp_info->book_type=$this->input->post('book_type',TRUE);
                $m_journal_temp_info->posted_by=$this->session->user_id;
                $m_journal_temp_info->save();

                $journal_template_id=$m_journal_temp_info->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);
                $department_id_line=$this->input->post('department_id_line',TRUE);

                for($i=0;$i<=count($accounts)-1;$i++) {
                    $m_journal_temp_entry->template_id=$journal_template_id;
                    $m_journal_temp_entry->account_id=$accounts[$i];
                    $m_journal_temp_entry->memo=$memos[$i];
                    $m_journal_temp_entry->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_temp_entry->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_temp_entry->department_id=$this->get_numeric_value($department_id_line[$i]); 
                    $m_journal_temp_entry->save();
                }

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Template successfully saved';
                $response['row_added']=$this->get_response_rows($journal_template_id);
                echo json_encode($response);
                break;
            case 'post-voucher' :
                $cv_id = $this->input->post('cv_id',TRUE);
                $voucher_info= $this->Cash_vouchers_model->get_list($cv_id)[0];

                $m_journal=$this->Journal_info_model;
                $m_supplier=$this->Suppliers_model;
                $m_form_2307=$this->Bir_2307_model;
                $m_journal_accounts=$this->Journal_account_model;
                $m_company=$this->Company_model;
                $m_accounts=$this->Account_integration_model;
                $account_integration=$m_accounts->get_list();
                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $ref_type = $voucher_info->ref_type;
                if($ref_type == 'CV'){
                    $ref_type_count = COUNT($m_journal->get_list(array('ref_type'=>$ref_type)))+1+ $account_integration[0]->cv_start_no;
                }else{
                    $ref_type_count = COUNT($m_journal->get_list(array('ref_type'=>$ref_type)))+1 + $account_integration[0]->jv_start_no;
                }

                

                $m_journal->ref_type=$ref_type;
                // $m_journal->ref_no=str_pad($ref_type_count, 8, "0", STR_PAD_LEFT); // Commented for a while 
                $m_journal->ref_no = $voucher_info->ref_no;
                $m_journal->supplier_id=$voucher_info->supplier_id;
                $m_journal->remarks=$voucher_info->remarks;
                $m_journal->date_txn=date('Y-m-d',strtotime($voucher_info->date_txn));
                $m_journal->book_type='CDJ';
                $m_journal->department_id=$voucher_info->department_id;
                $m_journal->payment_method_id=$voucher_info->payment_method_id;
                $m_journal->check_type_id=$voucher_info->check_type_id;
                $m_journal->check_no=$voucher_info->check_no;
                $m_journal->check_date=date('Y-m-d',strtotime($voucher_info->check_date));
                $m_journal->amount=$this->get_numeric_value($voucher_info->amount);

                //for audit details
                $m_journal->set('date_created','NOW()');
                $m_journal->created_by_user=$this->session->user_id;
                $m_journal->save();

                $journal_id=$m_journal->last_insert_id();                   
                $total_amount=0;
                $total_wtax=0;
                
                $j_accounts=$this->Cash_vouchers_accounts_model->get_list(array('cv_accounts.cv_id'=>$cv_id));
                foreach($j_accounts as $j_account){
                    $total_amount+=$this->get_numeric_value($j_account->dr_amount);
                    if ($account_integration[0]->supplier_wtax_account_id == $j_account->account_id){
                        $total_wtax+=$this->get_numeric_value($j_account->cr_amount);
                    }
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$j_account->account_id;
                    $m_journal_accounts->memo=$j_account->memo;
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($j_account->dr_amount);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($j_account->cr_amount);
                    $m_journal_accounts->department_id=$this->get_numeric_value($j_account->department_id); 
                    $m_journal_accounts->save();
                }


                //update transaction number base on formatted last insert id
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);


                $m_modify_voucher = $this->Cash_vouchers_model;
                $m_modify_voucher->approved_by_user = $this->session->user_id;
                $m_modify_voucher->journal_id = $journal_id;
                $m_modify_voucher->set('date_approved','NOW()');
                $m_modify_voucher->modify($cv_id);

                $form_2307_apply=$voucher_info->is_2307;
                $supplier=$m_supplier->get_list($voucher_info->supplier_id);
                $company=$m_company->get_list();
                $tax_rate = ($total_wtax/$total_amount)*100;

                if ($form_2307_apply == 1){
                    $m_form_2307->journal_id=$journal_id;
                    $m_form_2307->supplier_id=$voucher_info->supplier_id;
                    $m_form_2307->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                    $m_form_2307->date=date('Y-m-d',strtotime($voucher_info->date_txn));
                    // $m_form_2307->payee_tin=$supplier[0]->tin_no;
                    // $m_form_2307->payee_name=$supplier[0]->supplier_name;
                    // $m_form_2307->payee_address=$supplier[0]->address;
                    // $m_form_2307->payor_name=$company[0]->registered_to;
                    // $m_form_2307->payor_tin=$company[0]->tin_no;
                    // $m_form_2307->payor_address=$company[0]->registered_address;
                    // $m_form_2307->zip_code = $company[0]->zip_code; 
                    $m_form_2307->gross_amount=$this->get_numeric_value($total_amount);
                    $m_form_2307->deducted_amount=$this->get_numeric_value($total_wtax);
                    $m_form_2307->tax_rate=$this->get_numeric_value($tax_rate);
                    $m_form_2307->atc_id=$voucher_info->atc_id;
                    $m_form_2307->set('date_created','NOW()');
                    $m_form_2307->created_by_user=$this->session->user_id;
                    $m_form_2307->save();
                }


                // AUDIT TRAIL START

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=11; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Approved and Posted  '.$voucher_info->txn_no;
                $m_trans->save();
                //AUDIT TRAIL END

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=2; // TRANS TYPE
                $m_trans->trans_log='Created Cash Disbursement Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted';
                echo json_encode($response);
                break;

            case 'cancel-voucher' :
                $cv_id = $this->input->post('cv_id',TRUE);
                $voucher_info= $this->Cash_vouchers_model->get_list($cv_id)[0];
                $dr_invoice_id = $voucher_info->dr_invoice_id;

                $m_modify_voucher = $this->Cash_vouchers_model;
                $m_modify_voucher->cancelled_by_user = $this->session->user_id;
                $m_modify_voucher->set('date_cancelled','NOW()');
                $m_modify_voucher->modify($cv_id);

                // AUDIT TRAIL START

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=12; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Disapproved and Cancelled  '.$voucher_info->txn_no;
                $m_trans->save();
                //AUDIT TRAIL END

                //update status of dr
                $m_dr=$this->Delivery_invoice_model;
                $m_dr->order_status_id=$this->get_dr_status($dr_invoice_id);
                $m_dr->modify($dr_invoice_id);

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Voucher successfully Disapproved !';
                echo json_encode($response);
                break;
            case 'create' :
                $m_journal=$this->Journal_info_model;
                $m_supplier=$this->Suppliers_model;
                $m_form_2307=$this->Bir_2307_model;
                $m_journal_accounts=$this->Journal_account_model;
                $m_company=$this->Company_model;
                $m_accounts=$this->Account_integration_model;
                $account_integration=$m_accounts->get_list();
                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }
                $ref_type = $this->input->post('ref_type');
                if($ref_type == 'CV'){
                    $ref_type_count = COUNT($m_journal->get_list(array('ref_type'=>$ref_type)))+1+ $account_integration[0]->cv_start_no;
                }else{
                    $ref_type_count = COUNT($m_journal->get_list(array('ref_type'=>$ref_type)))+1 + $account_integration[0]->jv_start_no;
                }

                

                $m_journal->ref_type=$ref_type;
                // $m_journal->ref_no=str_pad($ref_type_count, 8, "0", STR_PAD_LEFT); // Commented for a while 
                $m_journal->ref_no=$this->input->post('ref_no');
                $m_journal->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CDJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->payment_method_id=$this->input->post('payment_method');
                $m_journal->check_type_id=$this->input->post('check_type_id');
                if($this->input->post('check_date',TRUE) != '' || $this->input->post('check_date',TRUE) != null){
                    $m_journal->check_no=$this->input->post('check_no');
                    $m_journal->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                }
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));

                //for audit details
                $m_journal->set('date_created','NOW()');
                $m_journal->created_by_user=$this->session->user_id;
                $m_journal->save();

                $journal_id=$m_journal->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);
                $department_id_line=$this->input->post('department_id_line',TRUE);
                    
                $total_amount=0;
                $total_wtax=0;
                

                for($i=0;$i<=count($accounts)-1;$i++){
                    $total_amount+=$this->get_numeric_value($dr_amounts[$i]);
                    if ($account_integration[0]->supplier_wtax_account_id == $accounts[$i]){
                        $total_wtax+=$this->get_numeric_value($cr_amounts[$i]);
                    }
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->department_id=$this->get_numeric_value($department_id_line[$i]); 
                    $m_journal_accounts->save();
                }

                //update transaction number base on formatted last insert id
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);

                $form_2307_apply=$this->input->post('2307_apply',TRUE);
                $supplier_id=$this->input->post('supplier_id',TRUE);
                $supplier=$m_supplier->get_list($supplier_id);
                $company=$m_company->get_list();
                $tax_rate = ($total_wtax/$total_amount)*100;

                if ($form_2307_apply == 1){
                    $m_form_2307->journal_id=$journal_id;
                    $m_form_2307->supplier_id=$supplier_id;
                    $m_form_2307->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                    $m_form_2307->date=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                    // $m_form_2307->payee_tin=$supplier[0]->tin_no;
                    // $m_form_2307->payee_name=$supplier[0]->supplier_name;
                    // $m_form_2307->payee_address=$supplier[0]->address;
                    // $m_form_2307->payor_name=$company[0]->registered_to;
                    // $m_form_2307->payor_tin=$company[0]->tin_no;
                    // $m_form_2307->payor_address=$company[0]->registered_address;
                    // $m_form_2307->zip_code = $company[0]->zip_code; 
                    $m_form_2307->gross_amount=$this->get_numeric_value($total_amount);
                    $m_form_2307->deducted_amount=$this->get_numeric_value($total_wtax);
                    $m_form_2307->tax_rate=$this->get_numeric_value($tax_rate);                    
                    $m_form_2307->atc_id=$this->input->post('atc_id',TRUE);
                    $m_form_2307->set('date_created','NOW()');
                    $m_form_2307->created_by_user=$this->session->user_id;
                    $m_form_2307->save();
                }


                //if dr invoice is available, purchase invoice is recorded as journal
                $payment_id=$this->input->post('payment_id',TRUE);
                if($payment_id!=null){
                    $m_payable_payment=$this->Payable_payment_model;
                    $m_payable_payment->journal_id=$journal_id;
                    $m_payable_payment->is_journal_posted=TRUE;
                    $m_payable_payment->is_posted=TRUE;
                    $m_payable_payment->modify($payment_id);

                // AUDIT TRAIL START
                $payment_info=$m_payable_payment->get_list($payment_id,'payment_id,receipt_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=13; // TRANS TYPE
                $m_trans->trans_log='Finalized Payment No.'.$payment_info[0]->receipt_no.' ('.$payment_info[0]->payment_id.')For Cash Disbursement';
                $m_trans->save();
                //AUDIT TRAIL END

                }

                // AUDIT TRAIL START

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=2; // TRANS TYPE
                $m_trans->trans_log='Created Cash Disbursement Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted';
                $response['row_added']=$this->get_response_rows($journal_id);
                echo json_encode($response);
                break;

            case 'update':
                $journal_id=$this->input->get('id');
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;
                $m_accounts=$this->Account_integration_model;
                $account_integration=$m_accounts->get_list();

                //validate if this transaction is not yet closed
                $not_closed=$m_journal->get_list('accounting_period_id>0 AND journal_id='.$journal_id);
                if(count($not_closed)>0){
                    $response['stat']='error';
                    $response['title']='<b>Journal is Locked!</b>';
                    $response['msg']='Sorry, you cannot update journal that is already closed!<br />';
                    die(json_encode($response));
                }

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $m_journal->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CDJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->payment_method_id=$this->input->post('payment_method');
                $m_journal->check_type_id=$this->input->post('check_type_id');
                $m_journal->check_no=$this->input->post('check_no');
                $m_journal->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                $m_journal->ref_type=$this->input->post('ref_type');
                $m_journal->ref_no=$this->input->post('ref_no');
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));

                //for audit details
                $m_journal->set('date_modified','NOW()');
                $m_journal->modified_by_user=$this->session->user_id;
                $m_journal->modify($journal_id);


                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);
                $department_id_line=$this->input->post('department_id_line',TRUE);

                $m_journal_accounts->delete_via_fk($journal_id);

                $total_amount=0;
                $total_wtax=0;

                for($i=0;$i<=count($accounts)-1;$i++){
                    $total_amount+=$this->get_numeric_value($dr_amounts[$i]);
                    if ($account_integration[0]->supplier_wtax_account_id == $accounts[$i]){
                        $total_wtax+=$this->get_numeric_value($cr_amounts[$i]);
                    }
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->department_id=$this->get_numeric_value($department_id_line[$i]); 
                    $m_journal_accounts->save();
                }

                $m_form_2307=$this->Bir_2307_model;
                $m_supplier=$this->Suppliers_model;
                $m_company=$this->Company_model;

                $chck_form = $m_form_2307->get_list('journal_id='.$journal_id);
                $form_2307_apply=$this->input->post('2307_apply',TRUE);
                $supplier_id=$this->input->post('supplier_id',TRUE);
                $supplier=$m_supplier->get_list($supplier_id);
                $company=$m_company->get_list();
                $tax_rate = ($total_wtax/$total_amount)*100;

                if ($form_2307_apply == 1){

                    $m_form_2307->journal_id=$journal_id;
                    $m_form_2307->supplier_id=$supplier_id;
                    $m_form_2307->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                    $m_form_2307->date=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                    // $m_form_2307->payee_tin=$supplier[0]->tin_no;
                    // $m_form_2307->payee_name=$supplier[0]->supplier_name;
                    // $m_form_2307->payee_address=$supplier[0]->address;
                    // $m_form_2307->payor_name=$company[0]->registered_to;
                    // $m_form_2307->payor_tin=$company[0]->tin_no;
                    // $m_form_2307->payor_address=$company[0]->registered_address;
                    // $m_form_2307->zip_code = $company[0]->zip_code; 
                    $m_form_2307->gross_amount=$this->get_numeric_value($total_amount);
                    $m_form_2307->deducted_amount=$this->get_numeric_value($total_wtax);
                    $m_form_2307->tax_rate=$this->get_numeric_value($tax_rate);                      
                    $m_form_2307->atc_id=$this->input->post('atc_id',TRUE);
                    $m_form_2307->set('date_created','NOW()');
                    $m_form_2307->created_by_user=$this->session->user_id;
                    $m_form_2307->is_applied=1;

                    $journal=$m_journal->get_list($journal_id);

                    if($journal[0]->is_active == true){
                        $m_form_2307->is_deleted = 0;
                    }else{
                        $m_form_2307->is_deleted = 1;
                    }

                    //2307 is created for journal
                    if(count($chck_form) > 0){      
                        $m_form_2307->modify($chck_form[0]->form_2307_id);
                    }//no 2307 associated with the journal
                    else{                          
                        $m_form_2307->save();
                    } 
                
                }else{

                    if(count($chck_form) > 0){//2307 is created for journal
                        $m_form_2307->is_applied=0;
                        $m_form_2307->is_deleted = 1;
                        $m_form_2307->modify($chck_form[0]->form_2307_id);
                    }
                }


                $ji_info = $m_journal->get_list($journal_id,'txn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->trans_key_id=2;
                $m_trans->trans_type_id=2;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_log='Updated Cash Disbursement Journal '.$ji_info[0]->txn_no;
                $m_trans->save();

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully updated';
                $response['row_updated']=$this->get_response_rows($journal_id);
                echo json_encode($response);
                break;

            //***************************************************************************************
            case 'cancel':
                $m_journal=$this->Journal_info_model;
                $journal_id=$this->input->post('journal_id',TRUE);

                //validate if this transaction is not yet closed
                $not_closed=$m_journal->get_list('accounting_period_id>0 AND journal_id='.$journal_id);
                if(count($not_closed)>0){
                    $response['stat']='error';
                    $response['title']='<b>Journal is Locked!</b>';
                    $response['msg']='Sorry, you cannot cancel journal that is already closed!<br />';
                    die(json_encode($response));
                }

                //mark Items as deleted
                $m_journal->set('date_cancelled','NOW()'); //treat NOW() as function and not string
                $m_journal->cancelled_by_user=$this->session->user_id;//user that cancelled the record
                $m_journal->set('is_active','NOT is_active');
                $m_journal->modify($journal_id);

                $journal_txn_no =$m_journal->get_list($journal_id,'txn_no,is_active');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');

                if($journal_txn_no[0]->is_active ==TRUE){

                    $m_trans->trans_key_id=9; //CRUD
                    $m_trans->trans_type_id=2; // TRANS TYPE
                    $m_trans->trans_log='Uncancelled Cash Disbursement Entry : '.$journal_txn_no[0]->txn_no;
                    $response['title']='Uncancelled!';
                    $response['msg']='Journal successfully opened.';
                    $is_deleted = FALSE;

                }else if($journal_txn_no[0]->is_active ==FALSE){
                    $m_trans->trans_key_id=4; //CRUD
                    $m_trans->trans_type_id=2; // TRANS TYPE
                    $m_trans->trans_log='Cancelled Cash Disbursement Entry : '.$journal_txn_no[0]->txn_no;
                    $response['title']='Cancelled!';
                    $response['msg']='Journal successfully cancelled.';
                    $is_deleted = TRUE;
                }
                $m_trans->save();

                $m_form_2307=$this->Bir_2307_model;
                $chck_form = $m_form_2307->get_list('journal_id='.$journal_id);
                if(count($chck_form) > 0){//2307 is created for journal
                    $m_form_2307->is_deleted = $is_deleted;
                    $m_form_2307->modify($chck_form[0]->form_2307_id);
                }
                    

                $response['stat']='success';

                $response['row_updated']=$this->get_response_rows($journal_id);

                echo json_encode($response);

                break;

            case 'get_2307_journal':

                $m_form_2307=$this->Bir_2307_model;
                $journal_id = $this->input->post('journal_id',TRUE);
                $response['data'] = $m_form_2307->get_list('journal_id='.$journal_id);
                echo json_encode($response);
                break;

        };
    }



    public function get_response_rows($criteria=null,$additional=null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='CDJ'".($criteria==null?'':' AND journal_info.journal_id='.$criteria)."".($additional==null?'':$additional),

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
                'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y") as check_date',
                'journal_info.ref_type',
                'journal_info.ref_no',
                'CONCAT(IFNULL(journal_info.ref_type,""),"-",IFNULL(journal_info.ref_no,"")) as reference_no',
                'journal_info.amount',
                'departments.department_name',
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

    public function get_dr_status($id){
            //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
            $m_cash_voucher=$this->Cash_vouchers_model;

            if(count($m_cash_voucher->get_list(
                        array('cv_info.dr_invoice_id'=>$id,'cv_info.is_active'=>TRUE,'cv_info.is_deleted'=>FALSE,'cv_info.cancelled_by_user'>0),
                        'cv_info.cv_id'))==0 ){ //means no rr found on cash voucher that means this rr is still open

                return 1;

            }else{

                $m_dr=$this->Delivery_invoice_model;
                $row=$m_dr->get_dr_balance_qty($id);
                $order_status_id;
                if($row[0]->Balance == $row[0]->total_dr_amount){
                    $order_status_id = 1;
                }else if($row[0]->Balance > 0){
                    $order_status_id = 3;
                }else{
                    $order_status_id = 2;
                }

                return $order_status_id;

            }

    }



}
