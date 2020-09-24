<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_receipt extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Customers_model',
                'Suppliers_model',
                'Account_title_model',
                'Payment_method_model',
                'Journal_info_model',
                'Journal_account_model',
                'Departments_model',
                'Receivable_payment_model',
                'Check_types_model',
                'Users_model',
                'Account_integration_model',
                'Accounting_period_model',
                'Cash_invoice_model',
                'Trans_model',
                'Tax_model',
                'Other_income_model',
                'Temp_journal_info_model',
                'Customer_type_model'

            )
        );
        $this->load->model('Ar_trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['tax_types']=$this->Tax_model->get_list(array('tax_types.is_deleted'=>FALSE));
        $data['customers']=$this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'customer_name ASC');
        $data['suppliers']=$this->Suppliers_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'supplier_name ASC');
        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'trim(account_title) ASC');
        $data['methods']=$this->Payment_method_model->get_list('is_deleted=0');
        $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'department_name ASC');
        $data['check_types']=$this->Check_types_model->get_list('b_refchecktype.is_deleted=FALSE',
            'b_refchecktype.*,account_titles.account_title',
            array(array( 'account_titles' , 'account_titles.account_id = b_refchecktype. account_id', 'left'))
            );
        $data['customer_type']=$this->Customer_type_model->get_list('is_deleted=FALSE');

        $data['ar_trans']=$this->Ar_trans_model->get_list(
            'is_deleted=FALSE AND is_active = TRUE'
        );
        $data['title'] = 'Cash Receipt';
        (in_array('1-5',$this->session->user_rights)? 
        $this->load->view('cash_receipt_journal_view', $data)
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

            case 'list-other': // list of journals in inner joined in other income
                $m_journal=$this->Journal_info_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $additional = " AND DATE(journal_info.date_txn) BETWEEN '$tsd' AND '$ted'";
                $response['data']=$this->get_response_rows_other_income(null,$additional);
                echo json_encode($response);
                break;

            case 'get-entries':
                $journal_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_journal_accounts=$this->Journal_account_model;

                $data['accounts']=$m_accounts->get_list('is_deleted=0',null, null,'trim(account_title) ASC');
                $data['entries']=$m_journal_accounts->get_list('journal_accounts.journal_id='.$journal_id);
                $data['departments']=$this->Departments_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'department_name ASC');
                $this->load->view('template/journal_entries', $data);
                break;
            case 'create' :
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;

                 // REMOVED 2020-07-29 // FOR UPLOADING FOR 2307
                // $account_tax=$this->Account_integration_model->get_list(1);
                // $tax_account = $account_tax[0]->customer_wtax_account_id;
                // $check_account=$this->input->post('accounts',TRUE);
                // $check_dr_amounts=$this->input->post('dr_amount',TRUE);

                // $file_2307=$this->input->post('file_2307',TRUE);
                // $stat = 'false';
                // for($i=0;$i<=count($check_account)-1;$i++){
                //     if($check_account[$i] == $tax_account && $check_dr_amounts[$i] > 0){ // CHECK IF THERE IS A FILE
                //         $stat='true';
                //         if($file_2307==null){
                //             $response['stat']='error';
                //             $response['title']='<b>Error!</b>';
                //             $response['msg']='Please upload a BIR Form 2307 Before Proceeding!!<br />';
                //             die(json_encode($response));
                //         }
                //     }
                // }

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $particular=explode('-',$this->input->post('particular_id',TRUE));
                if($particular[0]=='C'){
                    $m_journal->customer_id=$particular[1];
                    $m_journal->supplier_id=0;
                }else{
                    $m_journal->customer_id=0;
                    $m_journal->supplier_id=$particular[1];
                }



                $m_journal->remarks=$this->input->post('remarks',TRUE);
                // if($stat =='true' ){
                //     $m_journal->path_2307=$this->input->post('file_2307',TRUE);
                // }
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CRJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->payment_method_id=$this->input->post('payment_method');
                $m_journal->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));
                $m_journal->or_no=$this->input->post('or_no');
                $m_journal->check_no=$this->input->post('check_no');
                $m_journal->check_type_id=$this->input->post('check_type_id');
                $m_journal->ref_no=$this->input->post('ref_no');


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

                for($i=0;$i<=count($accounts)-1;$i++){
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



                $payment_id=$this->input->post('payment_id',TRUE);
                if($payment_id!=null){
                    $m_receivable_payment=$this->Receivable_payment_model;
                    $m_receivable_payment->journal_id=$journal_id;
                    $m_receivable_payment->is_journal_posted=TRUE;
                    $m_receivable_payment->modify($payment_id);
                 // AUDIT TRAIL START
                $payment_info=$m_receivable_payment->get_list($payment_id,'payment_id,receipt_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=18; // TRANS TYPE
                $m_trans->trans_log='Finalized Payment No.'.$payment_info[0]->receipt_no.' ('.$payment_info[0]->payment_id.') For Cash Receipt Journal TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END
                }

                $temp_journal_id=$this->input->post('temp_journal_id',TRUE);
                if($temp_journal_id!=null){
                    $m_journal->is_billing=1;
                    $m_journal->modify($journal_id);
                    $m_temp_journal=$this->Temp_journal_info_model;
                    $m_temp_journal->journal_id=$journal_id;
                    $m_temp_journal->is_journal_posted=TRUE;
                    $m_temp_journal->modify($temp_journal_id);
                // AUDIT TRAIL START
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=69; // TRANS TYPE
                $m_trans->trans_log='Finalized Customer Advances Reference No. '.$this->input->post('ref_no',TRUE).' For Cash Receipt Journal Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END
                }


                // AUDIT TRAIL START

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=6; // TRANS TYPE
                $m_trans->trans_log='Created Cash Receipt Journal Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted';
                $response['row_added']=$this->get_response_rows($journal_id);
                echo json_encode($response);
                break;




       case 'create-from-other-income' :
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;



                $account_tax=$this->Account_integration_model->get_list(1);
                $tax_account = $account_tax[0]->customer_wtax_account_id;
                $check_account=$this->input->post('accounts',TRUE);
                $check_dr_amounts=$this->input->post('dr_amount',TRUE);

                $file_2307=$this->input->post('other_file_2307',TRUE);
                $stat = 'false';
                for($i=0;$i<=count($check_account)-1;$i++){
                    if($check_account[$i] == $tax_account && $check_dr_amounts[$i] > 0){ // CHECK IF THERE IS A FILE
                        $stat='true';
                        if($file_2307==null){
                            $response['stat']='error';
                            $response['title']='<b>Error!</b>';
                            $response['msg']='Please upload a BIR Form 2307 Before Proceeding!!<br />';
                            die(json_encode($response));
                        }
                    }
                }



                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                if($stat =='true' ){
                    $m_journal->path_2307=$this->input->post('other_file_2307',TRUE);
                }
                $m_journal->supplier_id=$this->input->post('supplier_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CRJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));
                $m_journal->ref_no=$this->input->post('ref_no');


                //for audit details
                $m_journal->set('date_created','NOW()');
                $m_journal->created_by_user=$this->session->user_id;
                $m_journal->save();

                $journal_id=$m_journal->last_insert_id();
                $accounts=$this->input->post('accounts',TRUE);
                $memos=$this->input->post('memo',TRUE);
                $dr_amounts=$this->input->post('dr_amount',TRUE);
                $cr_amounts=$this->input->post('cr_amount',TRUE);

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->save();
                }

                //update transaction number base on formatted last insert id
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);
                // AUDIT TRAIL START
                $other_invoice_id=$this->input->post('other_invoice_id',TRUE);
                if($other_invoice_id!=null){
                    $m_other_invoice=$this->Other_income_model;
                    $m_other_invoice->journal_id=$journal_id;
                    $m_other_invoice->is_journal_posted=TRUE;
                    $m_other_invoice->modify($other_invoice_id);
                }
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=6; // TRANS TYPE
                $m_trans->trans_log='Created Cash Receipt Journal Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END

                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted';
                $response['row_added']=$this->get_response_rows_other_income($journal_id);
                echo json_encode($response);
                break;

            case 'create-from-cash-invoice' :
                $m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;

                //validate if still in valid range
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br />';
                    die(json_encode($response));
                }

                $m_journal->customer_id=$this->input->post('customer_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CRJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->payment_method_id=$this->input->post('payment_method');
                $m_journal->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));
                $m_journal->or_no=$this->input->post('or_no');
                $m_journal->check_no=$this->input->post('check_no');
                $m_journal->check_type_id=$this->input->post('check_type_id');
                $m_journal->ref_no=$this->input->post('ref_no');


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

                for($i=0;$i<=count($accounts)-1;$i++){
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



                $cash_invoice_id=$this->input->post('cash_invoice_id',TRUE);
                if($cash_invoice_id!=null){
                    $m_cash_invoice=$this->Cash_invoice_model;
                    $m_cash_invoice->journal_id=$journal_id;
                    $m_cash_invoice->is_journal_posted=TRUE;
                    $m_cash_invoice->modify($cash_invoice_id);
                }


                $temp_journal_id=$this->input->post('temp_journal_id',TRUE);
                if($temp_journal_id!=null){
                    $m_journal->is_billing=1;
                    $m_journal->modify($journal_id);
                    $m_temp_journal=$this->Temp_journal_info_model;
                    $m_temp_journal->journal_id=$journal_id;
                    $m_temp_journal->is_journal_posted=TRUE;
                    $m_temp_journal->modify($temp_journal_id);
                // AUDIT TRAIL START
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=69; // TRANS TYPE
                $m_trans->trans_log='Finalized Payment Reference No. '.$this->input->post('ref_no',TRUE).' Cash Receipt Journal Entry TXN-'.date('Ymd').'-'.$journal_id;
                $m_trans->save();
                //AUDIT TRAIL END
                }

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

                $particular=explode('-',$this->input->post('particular_id',TRUE));
                if($particular[0]=='C'){
                    $m_journal->customer_id=$particular[1];
                    $m_journal->supplier_id=0;
                }else{
                    $m_journal->customer_id=0;
                    $m_journal->supplier_id=$particular[1];
                }

                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='CRJ';
                $m_journal->department_id=$this->input->post('department_id');
                $m_journal->payment_method_id=$this->input->post('payment_method');
                $m_journal->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                $m_journal->amount=$this->get_numeric_value($this->input->post('amount'));
                $m_journal->or_no=$this->input->post('or_no');
                $m_journal->check_no=$this->input->post('check_no');
                $m_journal->check_type_id=$this->input->post('check_type_id');

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

                for($i=0;$i<=count($accounts)-1;$i++){
                    $m_journal_accounts->journal_id=$journal_id;
                    $m_journal_accounts->account_id=$accounts[$i];
                    $m_journal_accounts->memo=$memos[$i];
                    $m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amounts[$i]);
                    $m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amounts[$i]);
                    $m_journal_accounts->department_id=$this->get_numeric_value($department_id_line[$i]); 
                    $m_journal_accounts->save();
                }


                $ji_info = $m_journal->get_list($journal_id,'txn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->trans_key_id=2;
                $m_trans->trans_type_id=6;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_log='Updated Cash Receipt Journal '.$ji_info[0]->txn_no;
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
                $m_trans->trans_type_id=6; // TRANS TYPE
                $m_trans->trans_log='Uncancelled Cash Receipt Journal Entry : '.$journal_txn_no[0]->txn_no;
                $response['title']='Opened!';
                $response['msg']='Journal successfully opened.';

                }else if($journal_txn_no[0]->is_active ==FALSE){
                $m_trans->trans_key_id=4; //CRUD
                $m_trans->trans_type_id=6; // TRANS TYPE
                $m_trans->trans_log='Cancelled Cash Receipt Journal Entry : '.$journal_txn_no[0]->txn_no;

                $response['title']='Cancelled!';
                $response['msg']='Journal successfully cancelled.';
                }
                $m_trans->save();


                $response['stat']='success';

                $response['row_updated']=$this->get_response_rows($journal_id);

                echo json_encode($response);

                break;
        };
    }



    public function get_response_rows($criteria=null,$additional=null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='CRJ'".($criteria==null?'':' AND journal_info.journal_id='.$criteria)."".($additional==null?'':$additional),

            array(
                'journal_info.journal_id',
                'journal_info.txn_no',
                'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                'journal_info.is_active',
                'journal_info.remarks',
                'journal_info.or_no',
                'journal_info.check_no',
                'payment_methods.payment_method_id',
                'journal_info.department_id',
                'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date',
                'journal_info.amount',
                'journal_info.check_type_id',
                'departments.department_name',
                'CONCAT(IF(NOT ISNULL(customers.customer_id),CONCAT("C-",customers.customer_id),""),IF(NOT ISNULL(suppliers.supplier_id),CONCAT("S-",suppliers.supplier_id),"")) as particular_id',
                'CONCAT_WS(" ",IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,"")) as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
            ),
            array(
                array('customers','customers.customer_id=journal_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left'),
                array('departments','departments.department_id=journal_info.department_id','left')
            ),
            'journal_info.journal_id DESC'
        );
    }



    public function get_response_rows_other_income($criteria=null,$additional=null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list_v2(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='CRJ'".($criteria==null?'':' AND journal_info.journal_id='.$criteria)."".($additional==null?'':$additional),

            array(
                'journal_info.journal_id',
                'journal_info.txn_no',
                'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                'journal_info.is_active',
                'journal_info.remarks',
                'journal_info.or_no',
                'journal_info.check_no',
                'payment_methods.payment_method_id',
                'journal_info.department_id',
                'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y")as check_date',
                'journal_info.amount',
                'journal_info.check_type_id',
                'CONCAT(IF(NOT ISNULL(customers.customer_id),CONCAT("C-",customers.customer_id),""),IF(NOT ISNULL(suppliers.supplier_id),CONCAT("S-",suppliers.supplier_id),"")) as particular_id',
                'CONCAT_WS(" ",IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,"")) as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
            ),
            array(
                array('customers','customers.customer_id=journal_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left'),
                array('departments','departments.department_id=journal_info.department_id','left')
            ),
            array(
                array('other_invoice','other_invoice.other_invoice_no=journal_info.ref_no'),
            ),

            'journal_info.journal_id DESC'
        );
    }



}
