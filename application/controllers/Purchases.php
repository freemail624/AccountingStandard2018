<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Purchases_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        $this->load->model('Purchase_items_model');
        $this->load->model('Delivery_invoice_model');
        $this->load->model('Delivery_invoice_item_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Departments_model');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Email_settings_model');
        $this->load->model('Trans_model');
        $this->load->model('Approval_status_model');
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

        $data['approvals']=$this->Approval_status_model->get_list(
            array('is_active'=>TRUE,'is_deleted'=>FALSE)
        );


        $data['suppliers']=$this->Suppliers_model->get_supplier_list();
        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');

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

        $data['title'] = 'Purchase Order';
        (in_array('2-1',$this->session->user_rights)? 
        $this->load->view('po_view', $data)
        :redirect(base_url('dashboard')));
        


    }

    function transaction($txn = null,$id_filter=null) {
            switch ($txn){
                case 'list':  //this returns JSON of Purchase Order to be rendered on Datatable
                    $m_purchases=$this->Purchases_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $approval_id = $this->input->get('approval_id');
                if($approval_id == 0){
                    $filter_value = "purchase_order.is_deleted = FALSE AND  purchase_order.is_active = TRUE AND purchase_order.date_invoice BETWEEN '$tsd' AND '$ted'";
                }else{
                    $filter_value = "purchase_order.is_deleted = FALSE AND  purchase_order.is_active = TRUE AND purchase_order.approval_id = '$approval_id' AND purchase_order.date_invoice BETWEEN '$tsd' AND '$ted'";
                }
                
                $response['data']=$this->row_response($filter_value);
                    echo json_encode($response);
                    break;

                case 'get-po-details':
                    $m_purchases=$this->Purchases_model;

                    $purchase_order_id = $this->input->get('s',TRUE);

                    $response['data']=$this->row_response(
                        array(
                            'purchase_order.is_deleted'=>FALSE,
                            'purchase_order.is_active'=>TRUE,
                            'purchase_order.purchase_order_id'=>$purchase_order_id
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

                case 'transfer-po':

                    $m_purchases=$this->Purchases_model;

                    $purchase_order_id = $this->input->post('purchase_order_id', TRUE);
                    $m_purchases->is_transfer = TRUE;
                    
                    if($m_purchases->modify($purchase_order_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully transferred.';
                        echo json_encode($response);
                    }

                    break;

                case 'po-for-approved':  //is called on DASHBOARD, returns PO list for approval
                    //approval id 2 are those pending
                    $m_integration=$this->Account_integration_model;
                    $m_purchases=$this->Purchases_model;

                    $po_for_final_approval_amt = $m_integration->get_list(1)[0]->po_for_final_approval;
                    $filter = "(po.total_after_discount >= ".$po_for_final_approval_amt." OR po.is_transfer = TRUE)";

                    $response['data']=$m_purchases->get_po_for_approval($filter);
                    echo json_encode($response);
                    break;

                case 'po-for-checking':  //is called on DASHBOARD, returns PO list for approval
                    //approval id 2 are those pending
                    $m_integration=$this->Account_integration_model;
                    $m_purchases=$this->Purchases_model;

                    $po_for_accounting_approval_amt = $m_integration->get_list(1)[0]->po_for_accounting_approval;
                    $filter = "(po.total_after_discount <= ".$po_for_accounting_approval_amt." AND po.is_transfer = FALSE)";

                    $response['data']=$m_purchases->get_po_for_approval($filter);
                    echo json_encode($response);
                    break;

                case 'po-for-review':  //is called on DASHBOARD, returns PO list for approval
                    //approval id 2 are those pending
                    $m_purchases=$this->Purchases_model;
                    $response['data']=$m_purchases->get_list(
                        //filter
                        'purchase_order.is_active=TRUE AND purchase_order.is_deleted=FALSE AND purchase_order.approval_id=2 AND purchase_order.is_reviewed = FALSE',
                        //fields
                        'purchase_order.*,suppliers.supplier_name,COUNT(po_attachments.po_attachment_id) as attachment,
                        CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)As term_description,
                        CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                        //joins
                        array(
                            array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left'),
                            array('user_accounts','user_accounts.user_id=purchase_order.posted_by_user','left'),
                            array('po_attachments','po_attachments.purchase_order_id=purchase_order.purchase_order_id','left')
                        ),

                        //order by
                        'purchase_order.purchase_order_id DESC',
                        //group by
                        'purchase_order.purchase_order_id'
                    );
                    echo json_encode($response);
                    break;

                case 'open':  //this returns PO that are already approved
                    $m_purchases=$this->Purchases_model;
                    //$where_filter=null,$select_list=null,$join_array=null,$order_by=null,$group_by=null,$auto_select_escape=TRUE,$custom_where_filter=null
                    $response['data']= $m_purchases->get_list(

                        'purchase_order.is_deleted=FALSE AND purchase_order.is_active=TRUE AND purchase_order.approval_id=1 AND (purchase_order.order_status_id=1 OR purchase_order.order_status_id=3)',

                        array(
                            'purchase_order.*',
                            'CONCAT_WS(" ",CAST(purchase_order.terms AS CHAR),purchase_order.duration)as term_description',
                            'suppliers.supplier_name',
                            'tax_types.tax_type',
                            'approval_status.approval_status',
                            'order_status.order_status'
                        ),
                        array(
                            array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left'),
                            array('tax_types','tax_types.tax_type_id=purchase_order.tax_type_id','left'),
                            array('approval_status','approval_status.approval_id=purchase_order.approval_id','left'),
                            array('order_status','order_status.order_status_id=purchase_order.order_status_id','left')
                        ),
                        'purchase_order.purchase_order_id DESC'

                    );
                    echo json_encode($response);
                    break;

                case 'items': //items on the specific PO, loads when edit button is called
                    $m_items=$this->Purchase_items_model;

                    $response['data']=$m_items->get_list(
                        array('purchase_order_id'=>$id_filter),
                        array(
                            'purchase_order_items.*',
                            'products.product_code',
                            'products.product_desc',
                            'products.purchase_cost',
                            'products.is_bulk',
                            'products.child_unit_id',
                            'products.parent_unit_id',
                            'products.child_unit_desc',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.parent_unit_id) as parent_unit_name',
                            '(SELECT units.unit_name  FROM units WHERE  units.unit_id = products.child_unit_id) as child_unit_name'
                        ),
                        array(
                            array('products','products.product_id=purchase_order_items.product_id','left')
                        ),
                        'purchase_order_items.po_item_id ASC'
                    );


                    echo json_encode($response);
                    break;

                case 'item-balance':
                    $m_items=$this->Purchase_items_model;
                    $response['data']=$m_items->get_products_with_balance_qty2($id_filter);
                    echo json_encode($response);

                    break;

                case 'create':
                    $m_purchases=$this->Purchases_model;

                    /*if(count($m_purchases->get_list(array('po_no'=>$this->input->post('po_no',TRUE))))>0){
                        $response['title'] = 'Invalid!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'PO # already exists.';

                        echo json_encode($response);
                        exit;
                    }*/


                    $m_purchases->begin();

                    $m_purchases->set('date_created','NOW()'); //treat NOW() as function and not string
                    //$m_purchases->po_no=$this->input->post('po_no',TRUE);
                    $m_purchases->terms=$this->input->post('terms',TRUE);
                    $m_purchases->duration=$this->input->post('duration',TRUE);
                    $m_purchases->date_delivery = date('Y-m-d',strtotime($this->input->post('date_delivery',TRUE)));
                    $m_purchases->date_invoice = date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                    $m_purchases->contact_no=$this->input->post('contact_no',TRUE);
                    $m_purchases->deliver_to_address=$this->input->post('deliver_to_address',TRUE);
                    $m_purchases->contact_person=$this->input->post('contact_person',TRUE);
                    $m_purchases->supplier_id=$this->input->post('supplier',TRUE);
                    $m_purchases->department_id=$this->input->post('department',TRUE);
                    $m_purchases->remarks=$this->input->post('remarks',TRUE);
                    $m_purchases->tax_type_id=$this->input->post('tax_type',TRUE);
                    $m_purchases->approval_id=2;
                    $m_purchases->posted_by_user=$this->session->user_id;
                    $m_purchases->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                    $m_purchases->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                    $m_purchases->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                    $m_purchases->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                    $m_purchases->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                    $m_purchases->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                    $m_purchases->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));

                    $m_purchases->discount_type_id=$this->get_numeric_value($this->input->post('discount_type_id',TRUE));


                    $m_purchases->save();

                    $po_id=$m_purchases->last_insert_id();
                    $m_po_items=$this->Purchase_items_model;

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

                        $m_po_items->purchase_order_id=$po_id;
                        $m_po_items->product_id=$this->get_numeric_value($prod_id[$i]);
                        $m_po_items->po_qty=$this->get_numeric_value($po_qty[$i]);
                        $m_po_items->po_price=$this->get_numeric_value($po_price[$i]);
                        $m_po_items->po_discount=$this->get_numeric_value($po_discount[$i]);
                        $m_po_items->po_line_total_discount=$this->get_numeric_value($po_line_total_discount[$i]);
                        $m_po_items->po_tax_rate=$this->get_numeric_value($po_tax_rate[$i]);
                        $m_po_items->po_line_total=$this->get_numeric_value($po_line_total[$i]);
                        $m_po_items->tax_amount=$this->get_numeric_value($tax_amount[$i]);
                        $m_po_items->non_tax_amount=$this->get_numeric_value($non_tax_amount[$i]);
                        $m_po_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                        $m_po_items->po_line_total_after_global=$this->get_numeric_value($po_line_total_after_global[$i]);

                        if($is_parent[$i] == '1'){
                            $m_po_items->set('unit_id','(SELECT parent_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }else{
                             $m_po_items->set('unit_id','(SELECT child_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }                        
                        $m_po_items->save();
                    }

                    //update po number base on formatted last insert id
                    $m_purchases->po_no='PO-'.date('Ymd').'-'.$po_id;
                    $m_purchases->modify($po_id);

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=1; //CRUD
                    $m_trans->trans_type_id=11; // TRANS TYPE
                    $m_trans->trans_log='Created Purchase Order No: PO-'.date('Ymd').'-'.$po_id;
                    $m_trans->save();

                    $m_purchases->commit();



                    if($m_purchases->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Purchase order successfully created.';

                        $response['row_added'] = $this->row_response($po_id);

                        echo json_encode($response);
                    }


                    break;

                case 'update':
                    $m_purchases=$this->Purchases_model;
                    $po_id=$this->input->post('purchase_order_id',TRUE);

                    $m_purchases->begin();

                    //$m_purchases->po_no=$this->input->post('po_no',TRUE);
                    $m_purchases->terms=$this->input->post('terms',TRUE);
                    $m_purchases->duration=$this->input->post('duration',TRUE);
                    $m_purchases->date_delivery = date('Y-m-d',strtotime($this->input->post('date_delivery',TRUE)));
                    $m_purchases->date_invoice = date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                    $m_purchases->contact_no=$this->input->post('contact_no',TRUE);
                    $m_purchases->deliver_to_address=$this->input->post('deliver_to_address',TRUE);
                    $m_purchases->contact_person=$this->input->post('contact_person',TRUE);
                    $m_purchases->supplier_id=$this->input->post('supplier',TRUE);
                    $m_purchases->department_id=$this->input->post('department',TRUE);
                    $m_purchases->remarks=$this->input->post('remarks',TRUE);
                    $m_purchases->tax_type_id=$this->input->post('tax_type',TRUE);
                    $m_purchases->modified_by_user=$this->session->user_id;
                    $m_purchases->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                    $m_purchases->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                    $m_purchases->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                    $m_purchases->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                    $m_purchases->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                    $m_purchases->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                    $m_purchases->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));
                    
                    $m_purchases->discount_type_id=$this->get_numeric_value($this->input->post('discount_type_id',TRUE));
                    $m_purchases->modify($po_id);


                    $m_po_items=$this->Purchase_items_model;

                    $m_po_items->delete_via_fk($po_id); //delete previous items then insert those new

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

                        $m_po_items->purchase_order_id=$po_id;
                        $m_po_items->product_id=$this->get_numeric_value($prod_id[$i]);
                        $m_po_items->po_qty=$this->get_numeric_value($po_qty[$i]);
                        $m_po_items->po_price=$this->get_numeric_value($po_price[$i]);
                        $m_po_items->po_discount=$this->get_numeric_value($po_discount[$i]);
                        $m_po_items->po_line_total_discount=$this->get_numeric_value($po_line_total_discount[$i]);
                        $m_po_items->po_tax_rate=$this->get_numeric_value($po_tax_rate[$i]);
                        $m_po_items->po_line_total=$this->get_numeric_value($po_line_total[$i]);
                        $m_po_items->tax_amount=$this->get_numeric_value($tax_amount[$i]);
                        $m_po_items->non_tax_amount=$this->get_numeric_value($non_tax_amount[$i]);
                        $m_po_items->is_parent=$this->get_numeric_value($is_parent[$i]);
                        $m_po_items->po_line_total_after_global=$this->get_numeric_value($po_line_total_after_global[$i]);
                        if($is_parent[$i] == '1'){
                            $m_po_items->set('unit_id','(SELECT parent_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }else{
                             $m_po_items->set('unit_id','(SELECT child_unit_id FROM products WHERE product_id='.(int)$this->get_numeric_value($prod_id[$i]).')');
                        }                        
                        $m_po_items->save();
                    }
                    $po_info=$m_purchases->get_list($po_id,'po_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=11; // TRANS TYPE
                    $m_trans->trans_log='Updated Purchase Order No: '.$po_info[0]->po_no;
                    $m_trans->save();
                    $m_purchases->commit();



                    if($m_purchases->status()===TRUE){
                        $response['title'] = 'Success!';
                        $response['stat'] = 'success';
                        $response['msg'] = 'Purchase order successfully updated.';

                        $response['row_updated'] = $this->row_response($po_id);

                        echo json_encode($response);
                    }


                    break;

                case 'delete':
                    $m_purchases=$this->Purchases_model;
                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);

                    //validations
                    $m_delivery=$this->Delivery_invoice_model;
                    if(count($m_delivery->get_list(array('delivery_invoice.purchase_order_id'=>$purchase_order_id,'delivery_invoice.is_deleted'=>FALSE,'delivery_invoice.is_active'=>TRUE)))>0){
                        $response['title']='Error!';
                        $response['stat']='error';
                        $response['msg']='Sorry, you cannot delete purchase order that is already been received.';
                        echo json_encode($response);
                        exit;
                    }



                    $m_purchases->set('date_deleted','NOW()'); //treat NOW() as function and not string, set date of deletion
                    $m_purchases->deleted_by_user=$this->session->user_id; //deleted by user
                    $m_purchases->is_deleted=1;
                    if($m_purchases->modify($purchase_order_id)){

                    $po_info=$m_purchases->get_list($purchase_order_id,'po_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=11; // TRANS TYPE
                    $m_trans->trans_log='Deleted Purchase Order No: '.$po_info[0]->po_no;
                    $m_trans->save();
                    
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully deleted.';
                        echo json_encode($response);
                    }
                    break;

                case 'close':
                    $m_purchase_order=$this->Purchases_model;
                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);

                    $m_purchase_order->set('date_closed','NOW()'); //treat NOW() as function and not string
                    $m_purchase_order->closed_by_user=$this->session->user_id;//user that closed the record
                    $m_purchase_order->is_closed=1;//mark as closed
                    $m_purchase_order->order_status_id=4;//mark as closed
                    $m_purchase_order->modify($purchase_order_id);


                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Record successfully marked as closed.';
                    $response['row_updated']=$this->row_response($purchase_order_id);
                    echo json_encode($response);

                    break;                    

                case 'cancel_info':
                    $m_purchases=$this->Purchases_model;
                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);
                    $cancel_reason=$this->input->post('cancel_reason',TRUE);

                    //validations
                    $m_delivery=$this->Delivery_invoice_model;
                    if(count($m_delivery->get_list(array('delivery_invoice.purchase_order_id'=>$purchase_order_id,'delivery_invoice.is_deleted'=>FALSE,'delivery_invoice.is_active'=>TRUE)))>0){
                        $response['title']='Error!';
                        $response['stat']='error';
                        $response['msg']='Sorry, you cannot cancel Purchase Order that is already been received.';
                        echo json_encode($response);
                        exit;
                    }



                    // $m_purchases->set('date_deleted','NOW()'); //treat NOW() as function and not string, set date of deletion
                    // $m_purchases->deleted_by_user=$this->session->user_id; //deleted by user
                    $m_purchases->approval_id=3;
                    $m_purchases->cancelled_by_user=$this->session->user_id;
                    $m_purchases->set('date_cancelled','NOW()'); 
                    $m_purchases->cancel_reason=$cancel_reason;
                    if($m_purchases->modify($purchase_order_id)){

                    $po_info=$m_purchases->get_list($purchase_order_id,'po_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=4; //CRUD
                    $m_trans->trans_type_id=11; // TRANS TYPE
                    $m_trans->trans_log='Cancelled Purchase Order No: '.$po_info[0]->po_no;
                    $m_trans->save();
                    
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully cancelled.';
                        $response['row_updated'] = $this->row_response($purchase_order_id);
                        echo json_encode($response);
                    }
                    break;


                // case 'mark-approved': //called on DASHBOARD when approved button is clicked
                //     $m_purchases=$this->Purchases_model;
                //     $purchase_order_id=$this->input->post('purchase_order_id',TRUE);



                //     $m_purchases->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                //     $m_purchases->approved_by_user=$this->session->user_id; //deleted by user
                //     $m_purchases->approval_id=1; //1 means approved
                //     if($m_purchases->modify($purchase_order_id)){

                //         $info=$m_purchases->get_list(
                //             $purchase_order_id,
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

                case 'mark-reviewed': //called on DASHBOARD when reviewed button is clicked
                    $m_purchases=$this->Purchases_model;
                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);

                    $m_purchases->set('date_reviewed','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_purchases->reviewed_by_user=$this->session->user_id; //deleted by user
                    $m_purchases->review_remarks=$this->input->post('review_remarks',TRUE);
                    $m_purchases->is_reviewed=1; //1 means approved
                    if($m_purchases->modify($purchase_order_id)){
                        $response['data']=$m_purchases->get_list(
                            'purchase_order.is_active=TRUE AND purchase_order.is_deleted=FALSE AND purchase_order.purchase_order_id='.$purchase_order_id,
                            //fields
                            'purchase_order.*,suppliers.supplier_name,COUNT(po_attachments.po_attachment_id) as attachment,
                            CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)As term_description,
                            CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                            //joins
                            array(
                                array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left'),
                                array('user_accounts','user_accounts.user_id=purchase_order.posted_by_user','left'),
                                array('po_attachments','po_attachments.purchase_order_id=purchase_order.purchase_order_id','left')
                            )
                        )[0];
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully marked as reviewed.';
                        echo json_encode($response);
                    }
                    break;

                case 'mark-checked': //called on DASHBOARD when reviewed button is clicked
                    $m_purchases=$this->Purchases_model;
                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);

                    $m_purchases->set('date_checked','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_purchases->checked_by_user=$this->session->user_id; //deleted by user
                    $m_purchases->checking_remarks=$this->input->post('checking_remarks',TRUE);
                    $m_purchases->is_checked=1; //1 means approved
                    if($m_purchases->modify($purchase_order_id)){
                        $response['data']=$m_purchases->get_list(
                            'purchase_order.is_active=TRUE AND purchase_order.is_deleted=FALSE AND purchase_order.purchase_order_id='.$purchase_order_id,
                            //fields
                            'purchase_order.*,suppliers.supplier_name,COUNT(po_attachments.po_attachment_id) as attachment,
                            CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)As term_description,
                            CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by',
                            //joins
                            array(
                                array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left'),
                                array('user_accounts','user_accounts.user_id=purchase_order.posted_by_user','left'),
                                array('po_attachments','po_attachments.purchase_order_id=purchase_order.purchase_order_id','left')
                            )
                        )[0];
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully marked as checked by Accounting.';
                        echo json_encode($response);
                    }
                    break;                    

                case 'mark-disapproved': //called on DASHBOARD when disapproved button is clicked
                    $m_purchases=$this->Purchases_model;
                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);
                    $m_purchases->set('date_disapproved','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_purchases->disapproved_by_user=$this->session->user_id; //deleted by user
                    $m_purchases->disapproval_remarks=$this->input->post('disapproval_remarks',TRUE);
                    $m_purchases->approval_id=4; //1 means disapproved
                    if($m_purchases->modify($purchase_order_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully disapproved.';
                        echo json_encode($response);
                    }
                    break;


                case 'mark-approved': //called on DASHBOARD when approved button is clicked
                    $m_purchases=$this->Purchases_model;
                    $m_po_items=$this->Purchase_items_model;
                    $m_delivery_invoice=$this->Delivery_invoice_model;
                    $m_dr_items=$this->Delivery_invoice_item_model;

                    $purchase_order_id=$this->input->post('purchase_order_id',TRUE);
                    $info = $m_purchases->get_list($purchase_order_id);

                    $m_purchases->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                    $m_purchases->approved_by_user=$this->session->user_id; //deleted by user
                    $m_purchases->approval_remarks=$this->input->post('approval_remarks',TRUE);
                    $m_purchases->approval_id=1; //1 means approved

                    if($m_purchases->modify($purchase_order_id)){

                        $m_delivery_invoice->begin();

                        /* INSERT PO INFO */
                        $m_delivery_invoice->set('date_created','NOW()');
                        $m_delivery_invoice->purchase_order_id=$purchase_order_id;
                        $m_delivery_invoice->contact_person=$info[0]->contact_person;
                        $m_delivery_invoice->terms=$info[0]->terms;
                        $m_delivery_invoice->supplier_id = $info[0]->supplier_id;
                        $m_delivery_invoice->department_id = $info[0]->department_id;
                        $m_delivery_invoice->remarks = $info[0]->remarks;
                        $m_delivery_invoice->date_delivered = date('Y-m-d');
                        $m_delivery_invoice->date_due = date('Y-m-d');
                        $m_delivery_invoice->tax_type_id = $info[0]->tax_type_id;
                        $m_delivery_invoice->posted_by_user = $this->session->user_id;
                        $m_delivery_invoice->total_discount = $this->get_numeric_value($info[0]->total_discount);
                        $m_delivery_invoice->total_before_tax=$this->get_numeric_value($info[0]->total_before_tax);
                        $m_delivery_invoice->total_tax_amount=$this->get_numeric_value($info[0]->total_tax_amount);
                        $m_delivery_invoice->total_after_tax=$this->get_numeric_value($info[0]->total_after_tax);
                        $m_delivery_invoice->total_overall_discount=$this->get_numeric_value($info[0]->total_overall_discount);
                        $m_delivery_invoice->total_overall_discount_amount=$this->get_numeric_value($info[0]->total_overall_discount_amount);
                        $m_delivery_invoice->total_after_discount=$this->get_numeric_value($info[0]->total_after_discount);
                        $m_delivery_invoice->discount_type_id=$this->get_numeric_value($info[0]->discount_type_id);
                        $m_delivery_invoice->save();

                        $dr_invoice_id=$m_delivery_invoice->last_insert_id();

                        /* INSERT PO ITEMS */
                        $items = $m_po_items->get_list(array("purchase_order_id"=>$purchase_order_id));

                        foreach ($items as $item){

                            $m_dr_items->dr_invoice_id=$dr_invoice_id;
                            $m_dr_items->product_id=$this->get_numeric_value($item->product_id);
                            $m_dr_items->dr_qty=$this->get_numeric_value($item->po_qty);
                            $m_dr_items->dr_price=$this->get_numeric_value($item->po_price);
                            $m_dr_items->dr_discount=$this->get_numeric_value($item->po_discount);
                            $m_dr_items->dr_line_total_discount=$this->get_numeric_value($item->po_line_total_discount);
                            $m_dr_items->dr_tax_rate=$this->get_numeric_value($item->po_tax_rate);
                            $m_dr_items->dr_line_total_price=$this->get_numeric_value($item->po_line_total);
                            $m_dr_items->dr_tax_amount=$this->get_numeric_value($item->tax_amount);
                            $m_dr_items->dr_non_tax_amount=$this->get_numeric_value($item->non_tax_amount);
                            $m_dr_items->dr_line_total_after_global=$this->get_numeric_value($item->po_line_total_after_global);
                            $m_dr_items->is_parent=$this->get_numeric_value($item->is_parent);
                            $m_dr_items->unit_id=$this->get_numeric_value($item->unit_id);
                            $m_dr_items->save();

                        }

                        //update invoice number base on formatted last insert id
                        $m_delivery_invoice->dr_invoice_no='P-INV-'.date('Ymd').'-'.$dr_invoice_id;
                        $m_delivery_invoice->modify($dr_invoice_id);

                        //update status of po
                        $m_purchases->order_status_id=$this->get_po_status($purchase_order_id);
                        $m_purchases->modify($purchase_order_id);

                        //update payable amount of supplier
                        $m_suppliers=$this->Suppliers_model;
                        $m_suppliers->recalculate_supplier_payable($info[0]->supplier_id);

                        $m_trans=$this->Trans_model;
                        $m_trans->user_id=$this->session->user_id;
                        $m_trans->set('trans_date','NOW()');
                        $m_trans->trans_key_id=1; //CRUD
                        $m_trans->trans_type_id=12; // TRANS TYPE
                        $m_trans->trans_log='Created Purchase Invoice No: P-INV-'.date('Ymd').'-'.$dr_invoice_id;
                        $m_trans->save();

                        $m_delivery_invoice->commit();

                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Purchase order successfully approved.';
                        echo json_encode($response);
                    }
                    break;


                    case 'email':

                        $m_purchases=$this->Purchases_model;
                        $m_po_items=$this->Purchase_items_model;
                        $m_company=$this->Company_model;
                        $m_email=$this->Email_settings_model;
                        $filter_value = $id_filter;

                        $info=$m_purchases->get_list(
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
                        $data['po_items']=$m_po_items->get_list(
                                array('purchase_order_id'=>$filter_value),
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
                            $m_purchases->is_email_sent=1;
                            $m_purchases->modify($filter_value);
 
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
        return $this->Purchases_model->get_list(
            $filter_value,
            array(
                'purchase_order.*',
                'DATE_FORMAT(purchase_order.date_delivery,"%m/%d/%Y") as date_delivery',
                'DATE_FORMAT(purchase_order.date_invoice,"%m/%d/%Y") as date_invoice',
                'CONCAT_WS(" ",CAST(purchase_order.terms AS CHAR),purchase_order.duration)as term_description',
                'suppliers.supplier_name',
                'tax_types.tax_type',
                'approval_status.approval_status',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as cancelled_by',
                'CONCAT_WS(" ",uad.user_fname,uad.user_lname)as disapproved_by',
                'CONCAT_WS(" ",uaa.user_fname,uaa.user_lname)as approved_by',
                'order_status.order_status'
            ),
            array(
                array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left'),
                array('tax_types','tax_types.tax_type_id=purchase_order.tax_type_id','left'),
                array('approval_status','approval_status.approval_id=purchase_order.approval_id','left'),
                array('user_accounts','user_accounts.user_id=purchase_order.cancelled_by_user','left'),
                array('user_accounts uad','uad.user_id=purchase_order.disapproved_by_user','left'),
                array('user_accounts uaa','uaa.user_id=purchase_order.approved_by_user','left'),
                array('order_status','order_status.order_status_id=purchase_order.order_status_id','left')
            ),
            'purchase_order.purchase_order_id DESC'
        );
    }

    function get_po_status($id){
            //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
            $m_delivery=$this->Delivery_invoice_model;

            if(count($m_delivery->get_list(
                        array('delivery_invoice.purchase_order_id'=>$id,'delivery_invoice.is_active'=>TRUE,'delivery_invoice.is_deleted'=>FALSE),
                        'delivery_invoice.dr_invoice_id'))==0 ){ //means no po found on delivery/purchase invoice that means this po is still open

                return 1;

            }else{

                $m_po=$this->Purchases_model;
                $row=$m_po->get_po_balance_qty($id);
                return ($row[0]->Balance>0?3:2);

            }

    }

}


 
