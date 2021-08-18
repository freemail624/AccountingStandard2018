<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Issuances extends CORE_Controller
{
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Issuance_model');
        $this->load->model('Issuance_item_model');
        $this->load->model('Departments_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        $this->load->model('Customers_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Repair_order_model');
        $this->load->model('Product_locations_model');
    }
    public function index() {
        $this->Users_model->validate();
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );
        /*$data['customers']=$this->Customers_model->get_list(
            array('customers.is_active'=>TRUE, 'customers.is_deleted'=>FALSE)
        );*/
        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE',null,null,'refproduct.refproduct_id'
        );

        $data['locations']=$this->Product_locations_model->get_list(array("is_deleted"=>FALSE));

        // $data['products']=$this->Products_model->get_list(
        //     null, //no id filter
        //     array(
        //         'products.product_id',
        //         'products.product_code',
        //         'products.product_desc',
        //         'products.product_desc1',
        //         'products.is_tax_exempt',
        //         'products.size',
        //         'FORMAT(products.sale_price,2)as sale_price',
        //         //'FORMAT(products.sale_price,2)as sale_price',
        //         'FORMAT(products.purchase_cost,2)as purchase_cost',
        //         'products.unit_id',
        //         'products.on_hand',
        //         'units.unit_name',
        //         'tax_types.tax_type_id',
        //         'tax_types.tax_rate'
        //     ),
        //     array(
        //         // parameter (table to join(left) , the reference field)
        //         array('units','units.unit_id=products.unit_id','left'),
        //         array('categories','categories.category_id=products.category_id','left'),
        //         array('tax_types','tax_types.tax_type_id=products.tax_type_id','left')
        //     )
        // );
        $data['title'] = 'Parts Requisition & Issuance Slip';
        (in_array('15-2',$this->session->user_rights)? 
        $this->load->view('issuance_view', $data)
        :redirect(base_url('dashboard')));
        
    }
    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_issuance=$this->Issuance_model;
                $response['data']=$this->response_rows(
                    'issuance_info.is_active=TRUE AND issuance_info.is_deleted=FALSE'.($id_filter==null?'':' AND issuance_info.issuance_id='.$id_filter)
                );
                echo json_encode($response);
                break;
            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Issuance_item_model;
                $response['data']=$m_items->get_list(
                    array('issuance_id'=>$id_filter),
                    array(
                        'issuance_items.*',
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
                        array('products','products.product_id=issuance_items.product_id','left')
                    ),
                    'issuance_items.issuance_item_id DESC'
                );
                echo json_encode($response);
                break;

            // case 'issuance-for-review':  //this returns JSON of Issuance to be rendered on Datatable
            //     $m_issuance=$this->Issuance_model;
            //     $response['data']=$this->Issuance_model->get_list('issuance_info.is_active=TRUE AND issuance_info.is_deleted=FALSE AND is_journal_posted = FALSE',
            //     array(
            //         'issuance_info.issuance_id',
            //         'issuance_info.slip_no',
            //         'issuance_info.remarks',
            //         'issuance_info.issued_to_person',
            //         'issuance_info.date_created',
            //         'DATE_FORMAT(issuance_info.date_issued,"%m/%d/%Y") as date_issued',
            //         'issuance_info.terms',
            //         'departments.department_id',
            //         'departments.department_name'
            //     ),
            //     array(
            //         array('departments','departments.department_id=issuance_info.issued_department_id','left')
            //         //array('customers','customers.customer_id=issuance_info.issued_to_person','left')
            //     ),
            //     'issuance_info.issuance_id DESC'
            // );
            //     echo json_encode($response);
            //     break;

            //***************************************create new Items************************************************
            case 'create':
                $m_issuance=$this->Issuance_model;
                $m_products=$this->Products_model;

                // if(count($m_issuance->get_list(array('slip_no'=>$this->input->post('slip_no',TRUE))))>0){
                //     $response['title'] = 'Invalid!';
                //     $response['stat'] = 'error';
                //     $response['msg'] = 'Slip No. already exists.';
                //     echo json_encode($response);
                //     exit;
                // }

                $repair_order_id = $this->input->post('repair_order_id',TRUE);

                $m_issuance->begin();
                $m_issuance->set('date_created','NOW()'); //treat NOW() as function and not string
                $m_issuance->issued_department_id=$this->input->post('department',TRUE);

                // $m_issuance->product=$this->input->post('department',TRUE);


                //$m_issuance->issued_to_person=$this->input->post('issued_to_person',TRUE);
                $m_issuance->repair_order_id=$repair_order_id;
                $m_issuance->remarks=$this->input->post('remarks',TRUE);
                $m_issuance->date_issued=date('Y-m-d',strtotime($this->input->post('date_issued',TRUE)));
                //$m_issuance->customer_id=$this->input->post('customer_id',TRUE);
                //$m_issuance->address=$this->input->post('address',TRUE);
                $m_issuance->terms=$this->input->post('terms',TRUE);
                $m_issuance->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_issuance->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_issuance->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_issuance->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_issuance->posted_by_user=$this->session->user_id;
                $m_issuance->product_location_id=$this->get_numeric_value($this->input->post('product_location_id',TRUE));
                $m_issuance->save();

                $issuance_id=$m_issuance->last_insert_id();

                $m_issue_items=$this->Issuance_item_model;
                $prod_id=$this->input->post('product_id',TRUE);
                $issue_qty=$this->input->post('issue_qty',TRUE);
                $issue_price=$this->input->post('issue_price',TRUE);
                $issue_discount=$this->input->post('issue_discount',TRUE);
                $issue_line_total_discount=$this->input->post('issue_line_total_discount',TRUE);
                $issue_tax_rate=$this->input->post('issue_tax_rate',TRUE);
                $issue_line_total_price=$this->input->post('issue_line_total_price',TRUE);
                $issue_tax_amount=$this->input->post('issue_tax_amount',TRUE);
                $issue_non_tax_amount=$this->input->post('issue_non_tax_amount',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){
                    $m_issue_items->issuance_id=$issuance_id;
                    $m_issue_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_issue_items->issue_qty=$this->get_numeric_value($issue_qty[$i]);
                    $m_issue_items->issue_price=$this->get_numeric_value($issue_price[$i]);
                    $m_issue_items->issue_discount=$this->get_numeric_value($issue_discount[$i]);
                    $m_issue_items->issue_line_total_discount=$this->get_numeric_value($issue_line_total_discount[$i]);
                    $m_issue_items->issue_tax_rate=$this->get_numeric_value($issue_tax_rate[$i]);
                    $m_issue_items->issue_line_total_price=$this->get_numeric_value($issue_line_total_price[$i]);
                    $m_issue_items->issue_tax_amount=$this->get_numeric_value($issue_tax_amount[$i]);
                    $m_issue_items->issue_non_tax_amount=$this->get_numeric_value($issue_non_tax_amount[$i]);
                    $m_issue_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);
                    // $m_issue_items->batch_no=$batch_no[$i];
                    // $m_issue_items->exp_date=date('Y-m-d',strtotime($exp_date[$i]));

                    //unit id retrieval is change, because of TRIGGER restriction
                    $m_issue_items->is_parent=$this->get_numeric_value($is_parent[$i]);

                    if($is_parent[$i] == '1'){

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_issue_items->unit_id=$unit_id[0]->bulk_unit_id;

                    }else{

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_issue_items->unit_id=$unit_id[0]->parent_unit_id;

                    }   

                    $product = $m_products->product_list(
                            TRUE,
                            date('Y-m-d'),
                            $this->get_numeric_value($prod_id[$i]),
                            0,
                            0,
                            0,
                            $pick_list=FALSE,
                            0,
                            TRUE,
                            FALSE,
                            0,
                            0,
                            0,
                            null,
                            1,
                            0,
                            null,
                            null,
                            'all'
                        );


                    if(count($product) > 0){
                        $rem_balance = $this->get_numeric_value($product[0]->total_qty_balance) - $this->get_numeric_value($issue_qty[$i]);
                        $m_issue_items->curr_soh = $rem_balance;
                    }else{
                        $m_issue_items->curr_soh = 0;
                    }

                    $m_issue_items->save();
                    // $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    // $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }
                //update invoice number base on formatted last insert id
                $m_issuance->slip_no='SLP-'.date('Ymd').'-'.$issuance_id;
                $m_issuance->modify($issuance_id);

                if($repair_order_id > 0){
                    $m_order = $this->Repair_order_model;
                    $m_order->issued_status_id = TRUE;
                    $m_order->modify($repair_order_id);
                }

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=14; // TRANS TYPE
                $m_trans->trans_log='Created Parts Requisition & Issuance Slip: SLP-'.date('Ymd').'-'.$issuance_id;
                $m_trans->save();

                $m_issuance->commit();
                if($m_issuance->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Items successfully issued.';
                    $response['row_added']=$this->response_rows($issuance_id);
                    echo json_encode($response);
                }
                break;

            ////***************************************update Items************************************************
            case 'update':
                $m_issuance=$this->Issuance_model;
                $m_products=$this->Products_model;

                $issuance_id=$this->input->post('issuance_id',TRUE);
                $repair_order_id=$this->input->post('repair_order_id',TRUE);

                $m_issuance->begin();
                $m_issuance->issued_department_id=$this->input->post('department',TRUE);
                //$m_issuance->issued_to_person=$this->input->post('issued_to_person',TRUE);
                $m_issuance->remarks=$this->input->post('remarks',TRUE);
                $m_issuance->repair_order_id=$repair_order_id;
                $m_issuance->date_issued=date('Y-m-d',strtotime($this->input->post('date_issued',TRUE)));
                //$m_issuance->customer_id=$this->input->post('customer_id',TRUE);
                //$m_issuance->address=$this->input->post('address',TRUE);
                $m_issuance->terms=$this->input->post('terms',TRUE);
                $m_issuance->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_issuance->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_issuance->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_issuance->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_issuance->modified_by_user=$this->session->user_id;
                $m_issuance->product_location_id=$this->get_numeric_value($this->input->post('product_location_id',TRUE));
                $m_issuance->modify($issuance_id);
                $m_issue_items=$this->Issuance_item_model;
                $tmp_prod_id = $m_issue_items->get_list(
                    array('issuance_id'=>$issuance_id),
                    'product_id'
                );
                $m_issue_items->delete_via_fk($issuance_id); //delete previous items then insert those new
                $prod_id=$this->input->post('product_id',TRUE);
                $issue_price=$this->input->post('issue_price',TRUE);
                $issue_discount=$this->input->post('issue_discount',TRUE);
                $issue_line_total_discount=$this->input->post('issue_line_total_discount',TRUE);
                $issue_tax_rate=$this->input->post('issue_tax_rate',TRUE);
                $issue_qty=$this->input->post('issue_qty',TRUE);
                $issue_line_total_price=$this->input->post('issue_line_total_price',TRUE);
                $issue_tax_amount=$this->input->post('issue_tax_amount',TRUE);
                $issue_non_tax_amount=$this->input->post('issue_non_tax_amount',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){
                    $m_issue_items->issuance_id=$issuance_id;
                    $m_issue_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_issue_items->issue_price=$this->get_numeric_value($issue_price[$i]);
                    $m_issue_items->issue_discount=$this->get_numeric_value($issue_discount[$i]);
                    $m_issue_items->issue_line_total_discount=$this->get_numeric_value($issue_line_total_discount[$i]);
                    $m_issue_items->issue_tax_rate=$this->get_numeric_value($issue_tax_rate[$i]);
                    $m_issue_items->issue_qty=$this->get_numeric_value($issue_qty[$i]);
                    $m_issue_items->issue_line_total_price=$this->get_numeric_value($issue_line_total_price[$i]);
                    $m_issue_items->issue_tax_amount=$this->get_numeric_value($issue_tax_amount[$i]);
                    $m_issue_items->issue_non_tax_amount=$this->get_numeric_value($issue_non_tax_amount[$i]);
                    $m_issue_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);
                    // $m_issue_items->batch_no=$batch_no[$i];
                    // $m_issue_items->exp_date=date('Y-m-d',strtotime($exp_date[$i]));

                    //unit id retrieval is change, because of TRIGGER restriction
                    $m_issue_items->is_parent=$this->get_numeric_value($is_parent[$i]);

                    if($is_parent[$i] == '1'){

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_issue_items->unit_id=$unit_id[0]->bulk_unit_id;

                    }else{

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_issue_items->unit_id=$unit_id[0]->parent_unit_id;

                    }   

                    $product = $m_products->product_list(
                            TRUE,
                            date('Y-m-d'),
                            $this->get_numeric_value($prod_id[$i]),
                            0,
                            0,
                            0,
                            $pick_list=FALSE,
                            0,
                            TRUE,
                            FALSE,
                            0,
                            0,
                            0,
                            null,
                            1,
                            0,
                            null,
                            null,
                            'all'
                        );

                    if(count($product) > 0){
                        $rem_balance = $this->get_numeric_value($product[0]->total_qty_balance) - $this->get_numeric_value($issue_qty[$i]);
                        $m_issue_items->curr_soh = $rem_balance;
                    }else{
                        $m_issue_items->curr_soh = 0;
                    }

                    $m_issue_items->save();

                }

                // for($i=0;$i<count($tmp_prod_id);$i++) {
                //     $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($tmp_prod_id[$i]->product_id));
                //     $m_products->modify($this->get_numeric_value($tmp_prod_id[$i]->product_id));
                // }

                $iss_info=$m_issuance->get_list($issuance_id,'slip_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=14; // TRANS TYPE
                $m_trans->trans_log='Updated Parts Requisition & Issuance Slip: '.$iss_info[0]->slip_no;
                $m_trans->save();
                $m_issuance->commit();

                if($m_issuance->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Issue items successfully updated.';
                    $response['row_updated']=$this->response_rows($issuance_id);
                    echo json_encode($response);
                }
                break;
            //***************************************************************************************
            case 'delete':
                $m_issuance=$this->Issuance_model;
                $m_issuance_items=$this->Issuance_item_model;
                $m_order=$this->Repair_order_model;
                $m_products=$this->Products_model;
                $issuance_id=$this->input->post('issuance_id',TRUE);

                //mark Items as deleted
                $m_issuance->set('date_deleted','NOW()'); //treat NOW() as function and not string, set deletion date
                $m_issuance->deleted_by_user=$this->session->user_id;
                $m_issuance->is_deleted=1;
                $m_issuance->modify($issuance_id);

                // Update Repair Order Issuance Status
                $issuance = $m_issuance->get_list($issuance_id);
                $repair_order_id = $issuance[0]->repair_order_id;
                
                if($repair_order_id > 0){
                    $m_order->issued_status_id = FALSE;
                    $m_order->modify($repair_order_id);
                }

                //update product on_hand after issuance is deleted...
                $products=$m_issuance_items->get_list(
                    'issuance_id='.$issuance_id,
                    'product_id'
                ); 
                for($i=0;$i<count($products);$i++) {
                    $prod_id=$products[$i]->product_id;
                    $m_products->on_hand=$m_products->get_product_qty($prod_id);
                    $m_products->modify($prod_id);
                }
                //end update product on_hand after issuance is deleted...
                $iss_info=$m_issuance->get_list($issuance_id,'slip_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=14; // TRANS TYPE
                $m_trans->trans_log='Deleted Issuance No: '.$iss_info[0]->slip_no;
                $m_trans->save();
                
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);
                break;
            //***************************************************************************************
        }
    }
//**************************************user defined*************************************************
    function response_rows($filter_value){
        return $this->Issuance_model->get_list(
            $filter_value,
            array(
                'issuance_info.*',
                'customers.customer_no',
                'customers.customer_name',
                'repair_order.repair_order_no',
                'customer_vehicles.plate_no',
                'DATE_FORMAT(issuance_info.date_issued,"%m/%d/%Y") as date_issued',
                'departments.department_id',
                'departments.department_name',
                'locations.location'
            ),
            array(
                array('departments','departments.department_id=issuance_info.issued_department_id','left'),
                array('repair_order','repair_order.repair_order_id=issuance_info.repair_order_id','left'),
                array('customers','customers.customer_id=repair_order.customer_id','left'),
                array('customer_vehicles','customer_vehicles.vehicle_id=repair_order.vehicle_id','left'),
                array('product_locations locations','locations.product_location_id=issuance_info.product_location_id','left')
            ),
            'issuance_info.issuance_id DESC'
        );
    }
//***************************************************************************************
}
