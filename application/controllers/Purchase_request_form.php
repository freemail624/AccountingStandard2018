<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_request_form extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Purchase_request_form_model');
        $this->load->model('Purchase_request_form_items_model');

        $this->load->model('Suppliers_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Email_settings_model');
        $this->load->model('Trans_model');
        $this->load->model('Account_integration_model');

        $this->load->library('M_pdf');


    }

    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);


        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE'
        );

        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        //data required by active view
        $data['suppliers']=$this->Suppliers_model->get_list(
            array('suppliers.is_deleted'=>FALSE, 'suppliers.is_active'=>TRUE),
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );

        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['company']=$this->Company_model->getDefaultRemarks()[0];
        $data['accounts']=$this->Account_integration_model->get_list(1);

        $data['title'] = 'Purchase Request (Form)';
        (in_array('2-10',$this->session->user_rights)? 
        $this->load->view('pr_form_request_view', $data)
        :redirect(base_url('dashboard')));
        


    }

    function transaction($txn = null,$id_filter=null) {
            switch ($txn){
                case 'list':  //this returns JSON of Purchase Order to be rendered on Datatable
                    $m_request_form=$this->Purchase_request_form_model;
                    $response['data']=$this->row_response(
                        array(
                            'purchase_request_form.is_deleted'=>FALSE,
                            'purchase_request_form.is_active'=>TRUE
                        )
                    );
                    echo json_encode($response);
                    break;

                case 'get-po-details':
                    $m_request_form=$this->Purchase_request_form_model;

                    $purchase_request_form_id = $this->input->get('s',TRUE);

                    $response['data']=$this->row_response(
                        array(
                            'purchase_request.is_deleted'=>FALSE,
                            'purchase_request.is_active'=>TRUE,
                            'purchase_request.purchase_request_form_id'=>$purchase_request_form_id
                        )
                    );

                    echo json_encode($response);

                    break;

                case 'product-lookup':
                    $m_products=$this->Products_model;
                    $supplier_id=$this->input->get('sid',TRUE);
                    $type_id=$this->input->get('type',TRUE);
                    $description=$this->input->get('description',TRUE);

                    //not 3 means show all product type
                    echo json_encode(
                        $m_products->get_list(
                                "(products.product_code LIKE '".$description."%' OR products.product_desc LIKE '%".$description."%') AND products.is_deleted=FALSE ".($supplier_id>0?" AND products.supplier_id=".$supplier_id:"").($type_id==1||$type_id==2?" AND products.refproduct_id=".$type_id:""),

                            array(
                                'products.*',
                                'IFNULL(tax_types.tax_rate,0) as tax_rate',
                                'FORMAT(products.purchase_cost,4)as cost',
                                'units.unit_name'
                            ),

                            array(
                                array('tax_types','tax_types.tax_type_id=products.tax_type_id','left'),
                                array('units','units.unit_id=products.unit_id','left')
                            )
                        )
                    );
                    break;

                case 'prf-pending': //Pending
                    $m_request_form=$this->Purchase_request_form_model;
                    $response['data']=$m_request_form->get_list(
                        //filter
                        'purchase_request_form.is_active=TRUE AND purchase_request_form.is_deleted=FALSE AND purchase_request_form.approval_id=1',
                        //fields
                        'purchase_request_form.*,
                        CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by, 
                        departments.department_name
                        ',
                        //joins
                        array(
                            array('user_accounts','user_accounts.user_id=purchase_request_form.posted_by_user','left'),
                            array('departments','departments.department_id=purchase_request_form.department_id','left')
                        ),

                        //order by
                        'purchase_request_form.purchase_request_form_id DESC',
                        //group by
                        'purchase_request_form.purchase_request_form_id'
                    );
                    echo json_encode($response);
                    break;

                case 'prf-for-final-approval': //For Final Approval
                    $m_request_form=$this->Purchase_request_form_model;
                    $response['data']=$m_request_form->get_list(
                        //filter
                        'purchase_request_form.is_active=TRUE AND purchase_request_form.is_deleted=FALSE AND purchase_request_form.approval_id=2',
                        //fields
                        'purchase_request_form.*,
                        CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by, 
                        departments.department_name
                        ',
                        //joins
                        array(
                            array('user_accounts','user_accounts.user_id=purchase_request_form.posted_by_user','left'),
                            array('departments','departments.department_id=purchase_request_form.department_id','left')
                        ),

                        //order by
                        'purchase_request_form.purchase_request_form_id DESC',
                        //group by
                        'purchase_request_form.purchase_request_form_id'
                    );
                    echo json_encode($response);
                    break;                    

                case 'open':  //this returns PO that are already approved
                    $m_request_form=$this->Purchase_request_form_model;
                    $response['data']= $m_request_form->get_list(

                        'purchase_request.is_deleted=FALSE AND purchase_request.is_active=TRUE AND purchase_request.approval_id=3 AND (purchase_request.order_status_id=1 OR purchase_request.order_status_id=3)',

                        array(
                            'purchase_request.*',
                            'CONCAT_WS(" ",CAST(purchase_request.terms AS CHAR),purchase_request.duration)as term_description',
                            'suppliers.supplier_name',
                            'tax_types.tax_type',
                            'approval_status.approval_status',
                            'order_status.order_status',
                            'DATE_FORMAT(purchase_request.date_created,"%m/%d/%Y") as date_created'
                        ),
                        array(
                            array('suppliers','suppliers.supplier_id=purchase_request.supplier_id','left'),
                            array('tax_types','tax_types.tax_type_id=purchase_request.tax_type_id','left'),
                            array('approval_status','approval_status.approval_id=purchase_request.approval_id','left'),
                            array('order_status','order_status.order_status_id=purchase_request.order_status_id','left')
                        ),
                        'purchase_request.purchase_request_form_id DESC'

                    );
                    echo json_encode($response);
                    break;

                case 'items': //items on the specific PO, loads when edit button is called
                    $m_items=$this->Purchase_request_form_items_model;

                    $response['data']=$m_items->get_list(
                        array('purchase_request_form_id'=>$id_filter),
                        array(
                            'purchase_request_form_items.*'
                        ),
                        '',
                        'purchase_request_form_items.prf_item_id ASC'
                    );

                    echo json_encode($response);
                    break;

                case 'item-balance':
                    $m_items=$this->Purchase_request_form_items_model;
                    $response['data']=$m_items->get_products_with_balance_qty2($id_filter);
                    echo json_encode($response);

                    break;

                case 'create':
                    $m_request_form=$this->Purchase_request_form_model;

                    $m_request_form->begin();
                    $m_request_form->set('date_created','NOW()');
                    $m_request_form->department_id=$this->input->post('department_id',TRUE);
                    $m_request_form->remarks=$this->input->post('remarks',TRUE);
                    $m_request_form->posted_by_user=$this->session->user_id;
                    $m_request_form->save();

                    $purchase_request_form_id=$m_request_form->last_insert_id();
                    $m_prf_items=$this->Purchase_request_form_items_model;

                    $prf_qty=$this->input->post('prf_qty',TRUE);
                    $product_desc=$this->input->post('product_desc',TRUE);

                    for($i=0;$i<count($product_desc);$i++){
                        $m_prf_items->purchase_request_form_id=$purchase_request_form_id;
                        $m_prf_items->prf_qty=$this->get_numeric_value($prf_qty[$i]);
                        $m_prf_items->product_desc=$product_desc[$i];        
                        $m_prf_items->save();
                    }

                    //update po number base on formatted last insert id
                    $m_request_form->prf_no='PRF-'.date('Ymd').'-'.$purchase_request_form_id;
                    $m_request_form->modify($purchase_request_form_id);

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=1; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Created Purchase Order Request (Form) No: PRF-'.date('Ymd').'-'.$purchase_request_form_id;
                    $m_trans->save();

                    $m_request_form->commit();
                    if($m_request_form->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Purchase request (Form) successfully created.';
                        $response['row_added'] = $this->row_response($purchase_request_form_id);
                        echo json_encode($response);
                    }

                    break;

                case 'update':
                    $m_request_form=$this->Purchase_request_form_model;
                    $purchase_request_form_id=$this->input->post('purchase_request_form_id',TRUE);

                    $m_request_form->begin();
                    $m_request_form->department_id=$this->input->post('department_id',TRUE);
                    $m_request_form->remarks=$this->input->post('remarks',TRUE);
                    $m_request_form->modified_by_user=$this->session->user_id;
                    $m_request_form->modify($purchase_request_form_id);


                    $m_prf_items=$this->Purchase_request_form_items_model;
                    $m_prf_items->delete_via_fk($purchase_request_form_id); //delete previous items then insert those new

                    $prf_qty=$this->input->post('prf_qty',TRUE);
                    $product_desc=$this->input->post('product_desc',TRUE);

                    for($i=0;$i<count($product_desc);$i++){
                        $m_prf_items->purchase_request_form_id=$purchase_request_form_id;
                        $m_prf_items->prf_qty=$this->get_numeric_value($prf_qty[$i]);
                        $m_prf_items->product_desc=$product_desc[$i];        
                        $m_prf_items->save();
                    }

                    $prf_info=$m_request_form->get_list($purchase_request_form_id,'prf_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Updated Purchase Request (Form) No: '.$prf_info[0]->prf_no;
                    $m_trans->save();
                    $m_request_form->commit();


                    if($m_request_form->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Purchase request (Form) successfully updated.';
                        $response['row_updated'] = $this->row_response($purchase_request_form_id);
                        echo json_encode($response);
                    }

                    break;

                case 'delete':
                    $m_request_form=$this->Purchase_request_form_model;
                    $purchase_request_form_id=$this->input->post('purchase_request_form_id',TRUE);

                    $m_request_form->set('date_deleted','NOW()'); //treat NOW() as function and not string, set date of deletion
                    $m_request_form->deleted_by_user=$this->session->user_id; //deleted by user
                    $m_request_form->is_deleted=1;

                    if($m_request_form->modify($purchase_request_form_id)){

                        $prf_info=$m_request_form->get_list($purchase_request_form_id,'prf_no');
                        $m_trans=$this->Trans_model;
                        $m_trans->user_id=$this->session->user_id;
                        $m_trans->set('trans_date','NOW()');
                        $m_trans->trans_key_id=3; //CRUD
                        $m_trans->trans_type_id=75; // TRANS TYPE
                        $m_trans->trans_log='Deleted Purchase Request (Form) No: '.$prf_info[0]->prf_no;
                        $m_trans->save();
                        
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase request (Form) successfully deleted.';
                        echo json_encode($response);
                    }

                    break;

                case 'close':
                    $m_purchase_request=$this->Purchase_request_form_model;
                    $purchase_request_form_id=$this->input->post('purchase_request_form_id',TRUE);

                    $m_purchase_request->set('date_closed','NOW()'); //treat NOW() as function and not string
                    $m_purchase_request->closed_by_user=$this->session->user_id;//user that closed the record
                    $m_purchase_request->is_closed=1;//mark as closed
                    $m_purchase_request->order_status_id=4;//mark as closed
                    $m_purchase_request->modify($purchase_request_form_id);

                    $prf_info=$m_purchase_request->get_list($purchase_request_form_id,'prf_no');

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=11; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Closed Purchase Request (Form) No: '.$prf_info[0]->prf_no;
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Record successfully marked as closed.';
                    $response['row_updated']=$this->row_response($purchase_request_form_id);
                    echo json_encode($response);

                    break;
                    
                case 'mark-pending-approved': //called on DASHBOARD when approved button is clicked
                    $m_request_form=$this->Purchase_request_form_model;
                    $purchase_request_form_id=$this->input->post('purchase_request_form_id',TRUE);

                    $m_request_form->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_request_form->approved_by_user=$this->session->user_id; //deleted by user
                    $m_request_form->approval_id=2; //2 means for final approval
                    
                    if($m_request_form->modify($purchase_request_form_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase request (Form) successfully approved for final approval.';
                        echo json_encode($response);
                    }

                    break;

                case 'mark-final-approved': //called on DASHBOARD when approved button is clicked
                    $m_request_form=$this->Purchase_request_form_model;
                    $purchase_request_form_id=$this->input->post('purchase_request_form_id',TRUE);

                    $m_request_form->set('date_final_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_request_form->final_approved_by_user=$this->session->user_id; //deleted by user
                    $m_request_form->approval_id=3; //3 means approved
                    
                    if($m_request_form->modify($purchase_request_form_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase request (Form) successfully final approved.';
                        echo json_encode($response);
                    }

                    break;                    

            }
    }



    function row_response($filter_value){
        return $this->Purchase_request_form_model->get_list(
            $filter_value,
            array(
                'purchase_request_form.*',
                'approval_status.approval_status',
                'order_status.order_status',
                'departments.department_name'
            ),
            array(
                array('departments','departments.department_id=purchase_request_form.department_id','left'),
                array('approval_status','approval_status.approval_id=purchase_request_form.approval_id','left'),
                array('order_status','order_status.order_status_id=purchase_request_form.order_status_id','left')
            ),
            'purchase_request_form.purchase_request_form_id DESC'
        );
    }
}
