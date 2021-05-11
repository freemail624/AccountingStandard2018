<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_request extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Purchase_request_model');
        $this->load->model('Purchase_request_items_model');
        $this->load->model('Delivery_invoice_model');
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
        // $data['products']=$this->Products_model->get_list(
        //         null, //no id filter
        //         array(
        //                    'products.product_id',
        //                    'products.product_code',
        //                    'products.product_desc',
        //                    'products.product_desc1',
        //                    'products.is_tax_exempt',
        //                    'FORMAT(products.sale_price,2)as sale_price',
        //                    'FORMAT(products.purchase_cost,2)as purchase_cost',
        //                    'products.unit_id',
        //                    'products.on_hand',
        //                    'units.unit_name',
        //                    'tax_types.tax_type_id',
        //                    'tax_types.tax_rate'
        //         ),
        //         array(
        //             // parameter (table to join(left) , the reference field)
        //             array('units','units.unit_id=products.unit_id','left'),
        //             array('categories','categories.category_id=products.category_id','left'),
        //             array('tax_types','tax_types.tax_type_id=products.tax_type_id','left')

        //         )

        //     );

        $data['title'] = 'Purchase Request';
        (in_array('2-9',$this->session->user_rights)? 
        $this->load->view('po_request_view', $data)
        :redirect(base_url('dashboard')));
        


    }

    function transaction($txn = null,$id_filter=null) {
            switch ($txn){
                case 'list':  //this returns JSON of Purchase Order to be rendered on Datatable
                    $m_requests=$this->Purchase_request_model;
                    $response['data']=$this->row_response(
                        array(
                            'purchase_request.is_deleted'=>FALSE,
                            'purchase_request.is_active'=>TRUE
                        )
                    );
                    echo json_encode($response);
                    break;

                case 'get-po-details':
                    $m_requests=$this->Purchase_request_model;

                    $purchase_request_id = $this->input->get('s',TRUE);

                    $response['data']=$this->row_response(
                        array(
                            'purchase_request.is_deleted'=>FALSE,
                            'purchase_request.is_active'=>TRUE,
                            'purchase_request.purchase_request_id'=>$purchase_request_id
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

                case 'pr-for-approved':  //is called on DASHBOARD, returns PO list for approval
                    //approval id 2 are those pending
                    $m_requests=$this->Purchase_request_model;
                    $response['data']=$m_requests->get_list(
                        //filter
                        'purchase_request.is_active=TRUE AND purchase_request.is_deleted=FALSE AND purchase_request.approval_id=2',
                        //fields
                        'purchase_request.*,
                        CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                        //joins
                        array(
                            array('user_accounts','user_accounts.user_id=purchase_request.posted_by_user','left')
                        ),

                        //order by
                        'purchase_request.purchase_request_id DESC',
                        //group by
                        'purchase_request.purchase_request_id'
                    );
                    echo json_encode($response);
                    break;

                case 'open':  //this returns PO that are already approved
                    $m_requests=$this->Purchase_request_model;
                    $response['data']= $m_requests->get_list(

                        'purchase_request.is_deleted=FALSE AND purchase_request.is_active=TRUE AND purchase_request.approval_id=1 AND (purchase_request.order_status_id=1 OR purchase_request.order_status_id=3)',

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
                        'purchase_request.purchase_request_id DESC'

                    );
                    echo json_encode($response);
                    break;

                case 'items': //items on the specific PO, loads when edit button is called
                    $m_items=$this->Purchase_request_items_model;

                    $response['data']=$m_items->get_list(
                        array('purchase_request_id'=>$id_filter),
                        array(
                            'purchase_request_items.*',
                            'products.product_code',
                            'products.product_desc',
                            'products.purchase_cost',
                            'products.is_bulk',
                            'products.child_unit_id',
                            'products.parent_unit_id',
                            'products.child_unit_desc',
                            '(CASE
                                WHEN products.is_parent = TRUE 
                                    THEN products.bulk_unit_id
                                ELSE products.parent_unit_id
                            END) as product_unit_id',
                            '(CASE
                                WHEN products.is_parent = TRUE 
                                    THEN blkunit.unit_name
                                ELSE chldunit.unit_name
                            END) as product_unit_name',                               
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.parent_unit_id) as parent_unit_name',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.child_unit_id) as child_unit_name'
                        ),
                        array(
                            array('products','products.product_id=purchase_request_items.product_id','left'),
                            array('units blkunit','blkunit.unit_id=products.bulk_unit_id','left'),
                            array('units chldunit','chldunit.unit_id=products.parent_unit_id','left'),                             
                        ),
                        'purchase_request_items.pr_item_id ASC'
                    );


                    echo json_encode($response);
                    break;

                case 'item-balance':
                    $m_items=$this->Purchase_request_items_model;
                    $response['data']=$m_items->get_products_with_balance_qty2($id_filter);
                    echo json_encode($response);

                    break;

                case 'create':
                    $m_requests=$this->Purchase_request_model;

                    $prod_id=$this->input->post('product_id',TRUE);

                    if(count($prod_id)<=0){
                        $response['title'] = 'Invalid!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'Please select an item to proceed!';
                        echo json_encode($response);
                        exit;
                    }

                    $m_requests->begin();
                    $m_requests->set('date_created','NOW()'); //treat NOW() as function and not string
                    //$m_requests->po_no=$this->input->post('po_no',TRUE);
                    $m_requests->terms=$this->input->post('terms',TRUE);
                    $m_requests->duration=$this->input->post('duration',TRUE);
                    $m_requests->deliver_to_address=$this->input->post('deliver_to_address',TRUE);
                    $m_requests->contact_person=$this->input->post('contact_person',TRUE);
                    $m_requests->supplier_id=$this->input->post('supplier',TRUE);
                    $m_requests->department_id=$this->input->post('department',TRUE);
                    $m_requests->remarks=$this->input->post('remarks',TRUE);
                    $m_requests->tax_type_id=$this->input->post('tax_type',TRUE);
                    $m_requests->approval_id=1;
                    $m_requests->posted_by_user=$this->session->user_id;
                    $m_requests->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                    $m_requests->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                    $m_requests->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                    $m_requests->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                    $m_requests->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                    $m_requests->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                    $m_requests->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));

                    $m_requests->save();

                    $purchase_request_id=$m_requests->last_insert_id();
                    $m_pr_items=$this->Purchase_request_items_model;

                    $prod_id=$this->input->post('product_id',TRUE);
                    $po_qty=$this->input->post('po_qty',TRUE);
                    $po_price=$this->input->post('po_price',TRUE);
                    $po_discount=$this->input->post('po_discount',TRUE);
                    $po_line_total_discount=$this->input->post('po_line_total_discount',TRUE);
                    $po_tax_rate=$this->input->post('po_tax_rate',TRUE);
                    $po_line_total=$this->input->post('po_line_total',TRUE);
                    $po_line_total_after_global=$this->input->post('po_line_total_after_global',TRUE);
                    $tax_amount=$this->input->post('tax_amount',TRUE);
                    $non_tax_amount=$this->input->post('non_tax_amount',TRUE);
                    $is_parent=$this->input->post('is_parent',TRUE);

                    for($i=0;$i<count($prod_id);$i++){

                        $m_pr_items->purchase_request_id=$purchase_request_id;
                        $m_pr_items->product_id=$this->get_numeric_value($prod_id[$i]);
                        $m_pr_items->po_qty=$this->get_numeric_value($po_qty[$i]);
                        $m_pr_items->po_price=$this->get_numeric_value($po_price[$i]);
                        $m_pr_items->po_discount=$this->get_numeric_value($po_discount[$i]);
                        $m_pr_items->po_line_total_discount=$this->get_numeric_value($po_line_total_discount[$i]);
                        $m_pr_items->po_tax_rate=$this->get_numeric_value($po_tax_rate[$i]);
                        $m_pr_items->po_line_total=$this->get_numeric_value($po_line_total[$i]);
                        $m_pr_items->tax_amount=$this->get_numeric_value($tax_amount[$i]);
                        $m_pr_items->non_tax_amount=$this->get_numeric_value($non_tax_amount[$i]);
                        $m_pr_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                        $m_pr_items->po_line_total_after_global=$this->get_numeric_value($po_line_total_after_global[$i]);

                        if($is_parent[$i] == '1'){
                            $m_pr_items->set('unit_id','(SELECT bulk_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }else{
                             $m_pr_items->set('unit_id','(SELECT parent_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }                        
                        $m_pr_items->save();
                    }

                    //update po number base on formatted last insert id
                    $m_requests->pr_no='PR-'.date('Ymd').'-'.$purchase_request_id;
                    $m_requests->modify($purchase_request_id);

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=1; //CRUD
                    $m_trans->trans_type_id=70; // TRANS TYPE
                    $m_trans->trans_log='Created Purchase Order Request No: PR-'.date('Ymd').'-'.$purchase_request_id;
                    $m_trans->save();

                    $m_requests->commit();



                    if($m_requests->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Purchase request successfully created.';
                        $response['row_added'] = $this->row_response($purchase_request_id);

                        echo json_encode($response);
                    }

                    break;

                case 'update':
                    $m_requests=$this->Purchase_request_model;
                    $purchase_request_id=$this->input->post('purchase_request_id',TRUE);

                    $prod_id=$this->input->post('product_id',TRUE);

                    if(count($prod_id)<=0){
                        $response['title'] = 'Invalid!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'Please select an item to proceed!';
                        echo json_encode($response);
                        exit;
                    }

                    $m_requests->begin();

                    $m_requests->terms=$this->input->post('terms',TRUE);
                    $m_requests->duration=$this->input->post('duration',TRUE);
                    $m_requests->deliver_to_address=$this->input->post('deliver_to_address',TRUE);
                    $m_requests->contact_person=$this->input->post('contact_person',TRUE);
                    $m_requests->supplier_id=$this->input->post('supplier',TRUE);
                    $m_requests->department_id=$this->input->post('department',TRUE);
                    $m_requests->remarks=$this->input->post('remarks',TRUE);
                    $m_requests->tax_type_id=$this->input->post('tax_type',TRUE);
                    $m_requests->modified_by_user=$this->session->user_id;
                    $m_requests->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                    $m_requests->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                    $m_requests->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                    $m_requests->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                    $m_requests->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                    $m_requests->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                    $m_requests->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));
                    $m_requests->modify($purchase_request_id);


                    $m_pr_items=$this->Purchase_request_items_model;

                    $m_pr_items->delete_via_fk($purchase_request_id); //delete previous items then insert those new

                    $prod_id=$this->input->post('product_id',TRUE);
                    $po_price=$this->input->post('po_price',TRUE);
                    $po_discount=$this->input->post('po_discount',TRUE);
                    $po_line_total_discount=$this->input->post('po_line_total_discount',TRUE);
                    $po_tax_rate=$this->input->post('po_tax_rate',TRUE);
                    $po_qty=$this->input->post('po_qty',TRUE);
                    $po_line_total=$this->input->post('po_line_total',TRUE);
                    $tax_amount=$this->input->post('tax_amount',TRUE);
                    $non_tax_amount=$this->input->post('non_tax_amount',TRUE);
                    $is_parent=$this->input->post('is_parent',TRUE);
                    $po_line_total_after_global=$this->input->post('po_line_total_after_global',TRUE);
                    for($i=0;$i<count($prod_id);$i++){

                        $m_pr_items->purchase_request_id=$purchase_request_id;
                        $m_pr_items->product_id=$this->get_numeric_value($prod_id[$i]);
                        $m_pr_items->po_qty=$this->get_numeric_value($po_qty[$i]);
                        $m_pr_items->po_price=$this->get_numeric_value($po_price[$i]);
                        $m_pr_items->po_discount=$this->get_numeric_value($po_discount[$i]);
                        $m_pr_items->po_line_total_discount=$this->get_numeric_value($po_line_total_discount[$i]);
                        $m_pr_items->po_tax_rate=$this->get_numeric_value($po_tax_rate[$i]);
                        $m_pr_items->po_line_total=$this->get_numeric_value($po_line_total[$i]);
                        $m_pr_items->tax_amount=$this->get_numeric_value($tax_amount[$i]);
                        $m_pr_items->non_tax_amount=$this->get_numeric_value($non_tax_amount[$i]);
                        $m_pr_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                        $m_pr_items->po_line_total_after_global=$this->get_numeric_value($po_line_total_after_global[$i]);

                        if($is_parent[$i] == '1'){
                            $m_pr_items->set('unit_id','(SELECT bulk_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }else{
                             $m_pr_items->set('unit_id','(SELECT parent_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }       

                        $m_pr_items->save();
                    }
                    $pr_info=$m_requests->get_list($purchase_request_id,'pr_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=70; // TRANS TYPE
                    $m_trans->trans_log='Updated Purchase Request No: '.$pr_info[0]->pr_no;
                    $m_trans->save();
                    $m_requests->commit();



                    if($m_requests->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Purchase request successfully updated.';

                        $response['row_updated'] = $this->row_response($purchase_request_id);

                        echo json_encode($response);
                    }


                    break;

                case 'delete':
                    $m_requests=$this->Purchase_request_model;
                    $purchase_request_id=$this->input->post('purchase_request_id',TRUE);

                    //validations
                    // $m_delivery=$this->Delivery_invoice_model;
                    // if(count($m_delivery->get_list(array('delivery_invoice.purchase_request_id'=>$purchase_request_id,'delivery_invoice.is_deleted'=>FALSE,'delivery_invoice.is_active'=>TRUE)))>0){
                    //     $response['title']='Error!';
                    //     $response['stat']='error';
                    //     $response['msg']='Sorry, you cannot delete purchase order that is already been received.';
                    //     echo json_encode($response);
                    //     exit;
                    // }



                    $m_requests->set('date_deleted','NOW()'); //treat NOW() as function and not string, set date of deletion
                    $m_requests->deleted_by_user=$this->session->user_id; //deleted by user
                    $m_requests->is_deleted=1;
                    if($m_requests->modify($purchase_request_id)){

                    $pr_info=$m_requests->get_list($purchase_request_id,'pr_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=70; // TRANS TYPE
                    $m_trans->trans_log='Deleted Purchase Request No: '.$pr_info[0]->pr_no;
                    $m_trans->save();
                    
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase request successfully deleted.';
                        echo json_encode($response);
                    }
                    break;

                case 'close':
                    $m_purchase_request=$this->Purchase_request_model;
                    $purchase_request_id=$this->input->post('purchase_request_id',TRUE);

                    $m_purchase_request->set('date_closed','NOW()'); //treat NOW() as function and not string
                    $m_purchase_request->closed_by_user=$this->session->user_id;//user that closed the record
                    $m_purchase_request->is_closed=1;//mark as closed
                    $m_purchase_request->order_status_id=4;//mark as closed
                    $m_purchase_request->modify($purchase_request_id);

                    $pr_info=$m_purchase_request->get_list($purchase_request_id,'pr_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=11; //CRUD
                    $m_trans->trans_type_id=11; // TRANS TYPE
                    $m_trans->trans_log='Closed Purchase Request No: '.$pr_info[0]->pr_no;
                    $m_trans->save();

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Record successfully marked as closed.';
                    $response['row_updated']=$this->row_response($purchase_request_id);
                    echo json_encode($response);

                    break;

                // case 'mark-approved': //called on DASHBOARD when approved button is clicked
                //     $m_requests=$this->Purchase_request_model;
                //     $purchase_request_id=$this->input->post('purchase_request_id',TRUE);



                //     $m_requests->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                //     $m_requests->approved_by_user=$this->session->user_id; //deleted by user
                //     $m_requests->approval_id=1; //1 means approved
                //     if($m_requests->modify($purchase_request_id)){

                //         $info=$m_requests->get_list(
                //             $purchase_request_id,
                //             array(
                //                 'user_accounts.user_email',
                //                 'purchase_order.po_no'
                //             ),
                //             array(
                //                 array('user_accounts','user_accounts.user_id=purchase_order.posted_by_user','left')
                //             )
                //         );

                //         if(strlen($info[0]->user_email)>0){ //if email is found, notify the user who posted it
                //             $email_setting  = array('mailtype'=>'html');
                //             $this->email->initialize($email_setting);

                //             $this->email->from('jdevsystems@jdevsolution.com', 'Paul Christian Rueda');
                //             $this->email->to($info[0]->user_email);
                //             //$this->email->cc('another@another-example.com');
                //             //$this->email->bcc('them@their-example.com');

                //             $this->email->subject('PO Notification!');
                //             $this->email->message('<p>Good Day!</p><br /><br /><p>Hi! your Purchase Order '.$info[0]->po_no.' is already approved. Kindly check your account.</p>');
                //             //$this->email->set_mailtype('html');

                //             $this->email->send();
                //         }

                //         $response['title']='Success!';
                //         $response['stat']='success';
                //         $response['msg']='Purchase order successfully approved.';
                //         echo json_encode($response);
                //     }
                //     break;

                case 'mark-approved': //called on DASHBOARD when approved button is clicked
                    $m_requests=$this->Purchase_request_model;
                    $purchase_request_id=$this->input->post('purchase_request_id',TRUE);

                    $m_email=$this->Email_settings_model;
                    $email=$m_email->get_list();

                    $m_requests->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_requests->approved_by_user=$this->session->user_id; //deleted by user
                    $m_requests->approval_id=1; //1 means approved
                    if($m_requests->modify($purchase_request_id)){

                        $info=$m_requests->get_list(
                            $purchase_request_id,
                            array(
                                'user_accounts.user_email',
                                'purchase_request.pr_no'
                            ),
                            array(
                                array('user_accounts','user_accounts.user_id=purchase_request.posted_by_user','left')
                            )
                        );

                        // if(strlen($info[0]->user_email)>0){ //if email is found, notify the user who posted it
                        //     $emailConfig = array('protocol' => 'smtp', 
                        //         'smtp_host' => 'ssl://smtp.googlemail.com', 
                        //         'smtp_port' => 465, 
                        //         'smtp_user' => $email[0]->email_address, 
                        //         'smtp_pass' => $email[0]->password, 
                        //         'mailtype' => 'html', 
                        //         'charset' => 'iso-8859-1');

                        //     // Set your email information
                            
                        //     $from = array('email' => $email[0]->email_from,
                        //         'name' => $email[0]->name_from);
                                

                        //     $to = array($info[0]->user_email);
                        //     $subject = 'Purchase Order';
                        //   //  $message = 'Type your gmail message here';
                        //     $message = '<p>Good Day!</p><br /><br /><p>Hi! your Purchase Order '.$info[0]->po_no.' is already approved. Kindly check your account.</p>';

                        //     // Load CodeIgniter Email library
                        //     $this->load->library('email', $emailConfig);
                        //     // Sometimes you have to set the new line character for better result
                        //     $this->email->set_newline("\r\n");
                        //     // Set email preferences
                        //     $this->email->from($from['email'], $from['name']);
                        //     $this->email->to($to);
                        //     $this->email->subject($subject);
                        //     $this->email->message($message);
                         
                        //     $this->email->set_mailtype("html");
                        //     $this->email->send();
                        // }





                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase request successfully approved.';
                        echo json_encode($response);
                    }
                    break;


                    case 'email':

                        $m_requests=$this->Purchase_request_model;
                        $m_pr_items=$this->Purchase_request_items_model;
                        $m_company=$this->Company_model;
                        $m_email=$this->Email_settings_model;
                        $filter_value = $id_filter;

                        $info=$m_requests->get_list(
                                $filter_value,
                                'purchase_order.*,CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)as term_description,suppliers.supplier_name,suppliers.address,suppliers.email_address,suppliers.contact_no',
                                array(
                                    array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left')
                                )
                            );
                        $email=$m_email->get_list();
                        $company=$m_company->get_list();

                        $data['purchase_info']=$info[0];
                        $data['company_info']=$company[0];
                        $data['po_items']=$m_pr_items->get_list(
                                array('purchase_request_id'=>$filter_value),
                                'purchase_order_items.*,products.product_desc,units.unit_name',

                                array(
                                    array('products','products.product_id=purchase_order_items.product_id','left'),
                                    array('units','units.unit_id=purchase_order_items.unit_id','left')
                                )
                                
                            );
                            $file_name=$info[0]->po_no;
                            $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/po_content_new',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
        
                            $content = $pdf->Output('', 'S');
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $email[0]->email_address, 
                                'smtp_pass' => $email[0]->password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $email[0]->email_from,
                                'name' => $email[0]->name_from
                            );

                            $to = array($info[0]->email_address);
                            $subject = 'Purchase Order';
                          //  $message = 'Type your gmail message here';
                            $message = $email[0]->default_message;

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($content, 'attachment', $pdfFilePath , 'application/pdf');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Supplier or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                            $m_requests->is_email_sent=1;
                            $m_requests->modify($filter_value);
 
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';
                            $response['row_updated'] =$this->row_response($filter_value);
 
                            echo json_encode($response);
                            }
                    break;
            }








    }



    function row_response($filter_value){
        return $this->Purchase_request_model->get_list(
            $filter_value,
            array(
                'purchase_request.*',
                'CONCAT_WS(" ",CAST(purchase_request.terms AS CHAR),purchase_request.duration)as term_description',
                'suppliers.supplier_name',
                'tax_types.tax_type',
                'approval_status.approval_status',
                'order_status.order_status'
            ),
            array(
                array('suppliers','suppliers.supplier_id=purchase_request.supplier_id','left'),
                array('tax_types','tax_types.tax_type_id=purchase_request.tax_type_id','left'),
                array('approval_status','approval_status.approval_id=purchase_request.approval_id','left'),
                array('order_status','order_status.order_status_id=purchase_request.order_status_id','left')
            ),
            'purchase_request.purchase_request_id DESC'
        );
    }
}
