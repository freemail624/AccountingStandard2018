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
                'Customers_model',
                'Departments_model',
                'Account_title_model',
                'Payment_method_model',
                'Cash_vouchers_model',
                'Cash_vouchers_accounts_model',
                'CV_status_model',
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
                'Account_integration_model',
                'Tax_code_model'
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
        $data['customers']=$this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE',null, null,'customer_name ASC');
        $data['suppliers']=$this->Suppliers_model->get_list('is_deleted = FALSE',null, null,'supplier_name ASC');
        $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE',null, null,'department_name ASC');
        $data['accounts']=$this->Account_title_model->get_list('is_deleted = FALSE',null, null,'trim(account_title) ASC');
        $data['methods']=$this->Payment_method_model->get_list();
        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['payment_methods']=$this->Payment_method_model->get_list('is_deleted=0');
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');
        $data['tax_codes']=$this->Tax_code_model->get_taxcode_list();
        $data['cv_status']=$this->CV_status_model->get_list(null, null, null, 'sort_id ASC');

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
                $additional = " AND DATE(cv_info.date_txn) BETWEEN '$tsd' AND '$ted' AND cv_info.cv_status_id = ".$fil;
                $response['data']=$this->get_response_rows(null,$additional);
                echo json_encode($response);
                break;

            case 'list-for-approval':               
                $response['data']=$this->get_response_rows(null,'AND cv_info.cv_status_id=5');
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

            case 'get-rr-entries':
                $dr_invoice_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_deliveries=$this->Delivery_invoice_model;

                $data['accounts']=$m_accounts->get_list(array('is_deleted'=>FALSE),null, null,'trim(account_title) ASC');
                $data['entries']=$m_deliveries->get_balance_rr($dr_invoice_id);
                $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE',null, null,'department_name ASC');

                $this->load->view('template/rr_journal_entries', $data);

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

                $ref_type = $this->input->post('ref_type');
                $ref_no = $this->input->post('ref_no');
                $check_no = $this->input->post('check_no');

                $valid_refno=$this->Cash_vouchers_model->check_validation(null,$ref_type,$ref_no);

                if(count($valid_refno)>0){
                    $response['stat']='error';
                    $response['title']='<b>'.$ref_type.'-'.$ref_no.' is already existing!</b>';
                    $response['msg']='Please make sure reference no is unique!<br />';
                    die(json_encode($response));
                }  

                if($this->input->post('check_date',TRUE) != '' || $this->input->post('check_date',TRUE) != null){
                    $valid_checkno=$this->Cash_vouchers_model->check_validation(null,null,null,$check_no);

                    if(count($valid_checkno)>0){
                        $response['stat']='error';
                        $response['title']='<b> Check No#: '.$check_no.' is already existing!</b>';
                        $response['msg']='Please make sure check no is unique!<br />';
                        die(json_encode($response));
                    }                      
                }

                $m_dr=$this->Delivery_invoice_model;
                $arr_rr_info=$m_dr->get_list(
                    array('delivery_invoice.dr_invoice_no'=>$this->input->post('dr_invoice_no',TRUE)),
                    'delivery_invoice.dr_invoice_id'
                );
                $dr_invoice_id=(count($arr_rr_info)>0?$arr_rr_info[0]->dr_invoice_id:0);


                $particular=explode('-',$this->input->post('particular_id',TRUE));
                if($particular[0]=='C'){
                    $m_info->customer_id=$particular[1];
                    $m_info->supplier_id=0;
                }else{
                    $m_info->customer_id=0;
                    $m_info->supplier_id=$particular[1];
                }

                $m_info->ref_type=$ref_type;
                $m_info->ref_no=$ref_no;
                $m_info->remarks=$this->input->post('remarks',TRUE);
                $m_info->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_info->department_id=$this->input->post('department_id');
                $m_info->payment_method_id=$this->input->post('payment_method');
                $m_info->check_type_id=$this->input->post('check_type_id');
                if($this->input->post('check_date',TRUE) != '' || $this->input->post('check_date',TRUE) != null){
                    $m_info->check_no=$check_no;
                    $m_info->check_date=date('Y-m-d',strtotime($this->input->post('check_date',TRUE)));
                }
                $m_info->amount=$this->get_numeric_value($this->input->post('amount'));

                //for audit details
                $m_info->set('date_created','NOW()');
                $m_info->created_by_user=$this->session->user_id;


                $m_info->is_2307 =$this->get_numeric_value($this->input->post('is_2307',TRUE));
                $m_info->atc_id=$this->input->post('atc_id',TRUE);
                // $m_info->atc_2307=$this->input->post('atc_2307',TRUE);
                // $m_info->remarks_2307=$this->input->post('remarks_2307',TRUE);

                $m_info->dr_invoice_id=$dr_invoice_id;
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

                //update status of dr
                if($dr_invoice_id>0){
                    $m_dr->order_status_id=$this->get_dr_status($dr_invoice_id);
                    $m_dr->modify($dr_invoice_id);
                }

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

                $ref_type = $this->input->post('ref_type');
                $ref_no = $this->input->post('ref_no');
                $check_no = $this->input->post('check_no');

                $valid_refno=$this->Cash_vouchers_model->check_validation($cv_id,$ref_type,$ref_no);

                if(count($valid_refno)>0){
                    $response['stat']='error';
                    $response['title']='<b>'.$ref_type.'-'.$ref_no.' is already existing!</b>';
                    $response['msg']='Please make sure reference no is unique!<br />';
                    die(json_encode($response));
                }  

                if($this->input->post('check_date',TRUE) != '' || $this->input->post('check_date',TRUE) != null){
                    $valid_checkno=$this->Cash_vouchers_model->check_validation($cv_id,null,null,$check_no);

                    if(count($valid_checkno)>0){
                        $response['stat']='error';
                        $response['title']='<b> Check No#: '.$check_no.' is already existing!</b>';
                        $response['msg']='Please make sure check no is unique!<br />';
                        die(json_encode($response));
                    }                      
                }                

                $m_dr=$this->Delivery_invoice_model;
                $arr_rr_info=$m_dr->get_list(
                    array('delivery_invoice.dr_invoice_no'=>$this->input->post('dr_invoice_no',TRUE)),
                    'delivery_invoice.dr_invoice_id'
                );
                $dr_invoice_id=(count($arr_rr_info)>0?$arr_rr_info[0]->dr_invoice_id:0);

                $particular=explode('-',$this->input->post('particular_id',TRUE));
                if($particular[0]=='C'){
                    $m_info->customer_id=$particular[1];
                    $m_info->supplier_id=0;
                }else{
                    $m_info->customer_id=0;
                    $m_info->supplier_id=$particular[1];
                }

                $m_info->ref_type=$this->input->post('ref_type');
                $m_info->ref_no=$this->input->post('ref_no');
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
                $m_info->atc_id=$this->input->post('atc_id',TRUE);
                // $m_info->atc_2307=$this->input->post('atc_2307',TRUE);
                // $m_info->remarks_2307=$this->input->post('remarks_2307',TRUE);
                $m_info->dr_invoice_id=$dr_invoice_id;

                $cv_status = $this->Cash_vouchers_model->get_list($cv_id);
                if(count($cv_status)>0){
                    $cv_status_id = $cv_status[0]->cv_status_id;
                    if($cv_status_id == 3){
                        $m_info->cv_status_id = 1; // Pending for verification
                    }
                }

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

                //update status of dr
                if($dr_invoice_id>0){
                    $m_dr->order_status_id=$this->get_dr_status($dr_invoice_id);
                    $m_dr->modify($dr_invoice_id);
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

                $dr_info=$m_info->get_list($cv_id,'cv_info.dr_invoice_id'); //get delivery invoice first
                if(count($dr_info)>0){ //make sure dr info return resultset before executing other process
                    $dr_invoice_id=$dr_info[0]->dr_invoice_id; //pass it to variable
                    //update delivery invoice status
                    $m_deliveries=$this->Delivery_invoice_model;
                    $m_deliveries->order_status_id=$this->get_dr_status($dr_invoice_id);
                    $m_deliveries->modify($dr_invoice_id);
                }

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
                $m_info->verified_by_user=$this->session->user_id;//user that verified the record
                $m_info->cv_status_id=5; // Verify
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


            case 'get_dr_balance':
                $dr_invoice_id = $this->input->post('dr_invoice_id', TRUE);
                $response['data']=$this->Delivery_invoice_model->get_dr_balance_qty($dr_invoice_id);
                echo json_encode($response);
                break;
        }
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
                'CONCAT(IF(NOT ISNULL(customers.customer_id),CONCAT("C-",customers.customer_id),""),IF(NOT ISNULL(suppliers.supplier_id),CONCAT("S-",suppliers.supplier_id),"")) as particular_id',
                'CONCAT_WS(" ",IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,"")) as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                'CONCAT_WS(" ",vbu.user_fname,vbu.user_lname)as verified_by',
                'CONCAT_WS(" ",abu.user_fname,abu.user_lname)as approved_by',
                'dr.dr_invoice_no'
            ),
            array(
                array('customers','customers.customer_id=cv_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=cv_info.supplier_id','left'),
                array('departments','departments.department_id=cv_info.department_id','left'),
                array('user_accounts','user_accounts.user_id=cv_info.created_by_user','left'),
                array('user_accounts vbu','vbu.user_id=cv_info.verified_by_user','left'),
                array('user_accounts abu','abu.user_id=cv_info.approved_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=cv_info.payment_method_id','left'),
                array('delivery_invoice dr','dr.dr_invoice_id=cv_info.dr_invoice_id','left')
            ),
            'cv_info.cv_id DESC'
        );
    }

    public function get_dr_status($id){
            //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
            $m_cash_voucher=$this->Cash_vouchers_model;

            if(count($m_cash_voucher->get_list(
                        array('cv_info.dr_invoice_id'=>$id,'cv_info.is_active'=>TRUE,'cv_info.is_deleted'=>FALSE),
                        'cv_info.cv_id'))==0 ){ //means no rr found on cash voucher that means this rr is still open

                return 1;

            }else{

                $m_dr=$this->Delivery_invoice_model;
                $row=$m_dr->get_dr_balance_qty($id);
                $order_status_id = 1;

                if(count($row)>0){
                    $order_status_id;
                    if($row[0]->Balance == $row[0]->total_dr_amount){
                        $order_status_id = 1;
                    }else if($row[0]->Balance > 0){
                        $order_status_id = 3;
                    }else{
                        $order_status_id = 2;
                    }

                }

                return $order_status_id;

                // $m_dr=$this->Delivery_invoice_model;
                // $row=$m_dr->get_dr_balance_qty($id);
                // return ($row[0]->Balance>0?3:2);                    

            }
    }

}
