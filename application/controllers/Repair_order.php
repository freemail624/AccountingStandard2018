<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Repair_order extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Products_model');
        $this->load->model('Invoice_counter_model');
        $this->load->model('Company_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Cash_invoice_model');
        $this->load->model('Customer_type_model');
        $this->load->model('Order_source_model');
        $this->load->model('Loading_model');
        $this->load->model('Loading_item_model');
        $this->load->model('Agent_model');
        $this->load->model('Account_integration_model');
        $this->load->model('Customer_vehicles_model');
        $this->load->model('Advisor_model');
        $this->load->model('Makes_model');
        $this->load->model('Vehicle_year_model');
        $this->load->model('Vehicle_model');
        $this->load->model('Colors_model');
        $this->load->model('Repair_order_model');
        $this->load->model('Repair_order_item_model');

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

        $data['salespersons']=$this->Salesperson_model->get_list(
            array('salesperson.is_active'=>TRUE,'salesperson.is_deleted'=>FALSE),
            'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
        );

        //data required by active view
        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE)
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE'
        );

        $data['customer_type']=$this->Customer_type_model->get_list(
            'is_deleted=FALSE'
        );

        $data['customer_type_create']=$this->Customer_type_model->get_list(
            'is_deleted=FALSE'
        );

        $tax_rate=$this->Company_model->get_list(
            null,
            array(
                'company_info.tax_type_id',
                'tt.tax_rate'
            ),
            array(
                array('tax_types as tt','tt.tax_type_id=company_info.tax_type_id','left')
            )
        );

        $data['tax_percentage']=(count($tax_rate)>0?$tax_rate[0]->tax_rate:0);
        $data['company']=$this->Company_model->getDefaultRemarks()[0];
        $data['agents']=$this->Agent_model->get_list(array('is_deleted'=>FALSE));
        $data['invoice_counter']=$this->Invoice_counter_model->get_list(array('user_id'=>$this->session->user_id));
        $data['order_sources'] = $this->Order_source_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['accounts']=$this->Account_integration_model->get_list(1);
        $data['vehicles'] = $this->Customer_vehicles_model->get_vehicles();
        $data['advisors'] = $this->Advisor_model->get_advisors_list();
        $data['makes'] = $this->Makes_model->get_makes_list();
        $data['years'] = $this->Vehicle_year_model->get_vehicle_year_list();
        $data['models'] = $this->Vehicle_model->get_models_list();
        $data['colors'] = $this->Colors_model->get_colors_list();

        $data['title'] = 'Repair Order';
        
        (in_array('3-2',$this->session->user_rights)? 
        $this->load->view('repair_order_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null,$id_filter2=null) {
        switch ($txn){

            case 'current-items':
                $type=$this->input->get('type');
                $description=$this->input->get('description');
                echo json_encode($this->Products_model->get_current_item_list($description,$type));
                break;

            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_order=$this->Repair_order_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $response['data']=$m_order->get_repair_order(null,$tsd,$ted);
                echo json_encode($response);
                break;

            case 'list_with_count':  //this returns JSON of Issuance to be rendered on Datatable
                $m_invoice=$this->Sales_invoice_model;
                $response['data']=$this->response_rows_count($id_filter);
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_order_item=$this->Repair_order_item_model;
                $response['data']=$m_order_item->get_repair_order_items($id_filter);
                echo json_encode($response);
                break;

            case 'item-issuance':
                $m_order_item=$this->Repair_order_item_model;
                $response['data']=$m_order_item->get_repair_order_inv_items($id_filter);
                echo json_encode($response);
                break;


            //***********************************************************************************************************
            case 'open': 
                $m_order=$this->Repair_order_model;
                // $sdate = $this->input->get('start_date'); 
                // $edate = $this->input->get('end_date'); 

                // $start_date = date('Y-m-d',strtotime($sdate));
                // $end_date = date('Y-m-d',strtotime($edate));
                $response['data']= $m_order->get_repair_order_issuance();
                echo json_encode($response);
                break;

            case 'ro-open':
                $m_order=$this->Repair_order_model;
                $response['data']= $m_order->get_repair_order_invoice();
                echo json_encode($response);
                break;

            case 'open-si':
                $m_sales_invoice=$this->Sales_invoice_model;
                $agent_id = $id_filter; 
                $loading_date = date('Y-m-d',strtotime($id_filter2));
                $response['data']= $m_sales_invoice->get_open_sales_invoice_list($agent_id,$loading_date,1);
                echo json_encode($response);
                break;


            case 'current-items-search':
                $m_sales_invoice=$this->Sales_invoice_model;
                $description=trim($this->input->post('description'));
                $response['data']= $this->Products_model->get_current_item_list($description);
                echo json_encode($response);
                break;    


            //***************************************create new Items************************************************

            
            case 'create':
                $m_order=$this->Repair_order_model;
                $m_order_item=$this->Repair_order_item_model;

                $m_order->begin();

                /* Customers Info */

                $m_order->customer_id= $this->get_numeric_value($this->input->post('customer_id',TRUE));
                $m_order->address = $this->input->post('address',TRUE);
                $m_order->address = $this->input->post('address',TRUE);
                $m_order->mobile_no = $this->input->post('mobile_no',TRUE);
                $m_order->tel_no_home = $this->input->post('tel_no_home',TRUE);
                $m_order->tel_no_bus = $this->input->post('tel_no_bus',TRUE);
                $m_order->representative_name = $this->input->post('representative_name',TRUE);
                $m_order->representative_no = $this->input->post('representative_no',TRUE);

                /* Vehicle Information */

                $m_order->vehicle_id = $this->get_numeric_value($this->input->post('vehicle_id', TRUE));
                $m_order->year_make_id = $this->input->post('year_make_id', TRUE);
                $m_order->model_name = $this->input->post('model_name', TRUE);
                $m_order->color_name = $this->input->post('color_name', TRUE);
                $m_order->chassis_no = $this->input->post('chassis_no', TRUE);
                $m_order->engine_no = $this->input->post('engine_no', TRUE);
                $m_order->km_reading = $this->get_numeric_value($this->input->post('km_reading', TRUE));
                $m_order->next_svc_date = date('Y-m-d',strtotime($this->input->post('next_svc_date', TRUE)));
                $m_order->next_svc_km = $this->get_numeric_value($this->input->post('next_svc_km', TRUE));

                /* Repair Order Information */

                $m_order->set('date_created','NOW()');
                $m_order->set('document_date','NOW()');
                $m_order->pms_desc = $this->input->post('pms_desc', TRUE);
                $m_order->bpr_desc = $this->input->post('bpr_desc', TRUE);
                $m_order->gj_desc = $this->input->post('gj_desc', TRUE);
                $m_order->date_time_promised = date('Y-m-d h:i:s',strtotime($this->input->post('date_time_promised', TRUE)));
                $m_order->delivery_date = date('Y-m-d',strtotime($this->input->post('delivery_date', TRUE)));
                $m_order->selling_dealer=$this->input->post('selling_dealer',TRUE);
                $m_order->advisor_id=$this->input->post('advisor_id',TRUE);
                $m_order->advisor_remarks=$this->input->post('advisor_remarks',TRUE);
                $m_order->customer_remarks=$this->input->post('customer_remarks',TRUE);

                // $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                // $m_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                // $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                // $m_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                // $m_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                // $m_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                // $m_invoice->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));

                $m_order->posted_by_user=$this->session->user_id;
                $m_order->save();

                $repair_order_id=$m_order->last_insert_id();

                $prod_id=$this->input->post('product_id',TRUE);
                $order_qty=$this->input->post('order_qty',TRUE);
                $order_price=$this->input->post('order_price',TRUE);
                $order_gross=$this->input->post('order_gross',TRUE);
                $order_discount=$this->input->post('order_discount',TRUE);
                $order_line_total_discount=$this->input->post('order_line_total_discount',TRUE);
                $order_tax_rate=$this->input->post('order_tax_rate',TRUE);
                $order_line_total_price=$this->input->post('order_line_total_price',TRUE);
                $order_tax_amount=$this->input->post('order_tax_amount',TRUE);
                $order_non_tax_amount=$this->input->post('order_non_tax_amount',TRUE);
                $order_line_total_after_global=$this->input->post('order_line_total_after_global',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                $vehicle_service_id=$this->input->post('vehicle_service_id',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);
            
                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_order_item->repair_order_id=$repair_order_id;
                    $m_order_item->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_order_item->order_line_total_after_global=$this->get_numeric_value($order_line_total_after_global[$i]);
                    $m_order_item->order_qty=$this->get_numeric_value($order_qty[$i]);
                    $m_order_item->order_price=$this->get_numeric_value($order_price[$i]);
                    $m_order_item->order_gross=$this->get_numeric_value($order_gross[$i]);
                    $m_order_item->order_discount=$this->get_numeric_value($order_discount[$i]);
                    $m_order_item->order_line_total_discount=$this->get_numeric_value($order_line_total_discount[$i]);
                    $m_order_item->order_tax_rate=$this->get_numeric_value($order_tax_rate[$i]);
                    $m_order_item->order_line_total_price=$this->get_numeric_value($order_line_total_price[$i]);
                    $m_order_item->order_tax_amount=$this->get_numeric_value($order_tax_amount[$i]);
                    $m_order_item->order_non_tax_amount=$this->get_numeric_value($order_non_tax_amount[$i]);
                    $m_order_item->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_order_item->batch_no=$batch_no[$i];
                    $m_order_item->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);
                    $m_order_item->vehicle_service_id=$this->get_numeric_value($vehicle_service_id[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $m_order_item->is_parent=$this->get_numeric_value($is_parent[$i]);

                    if($is_parent[$i] == '1'){

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_order_item->unit_id=$unit_id[0]->bulk_unit_id;

                    }else{

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_order_item->unit_id=$unit_id[0]->parent_unit_id;

                    }   

                    $m_order_item->save();
                    $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }

                //update repair order on formatted last insert id
                $m_order->repair_order_no='RA02888'.$repair_order_id;
                $m_order->modify($repair_order_id);

                //update status of so
                // $m_so->order_status_id=$this->get_so_status($sales_order_id);
                // $m_so->modify($sales_order_id);

                $m_order->commit();

                if($m_order->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Repair order successfully created.';
                    $response['row_added']=$m_order->get_repair_order($repair_order_id);
                    // $response['is_auto_print']=$this->input->post('is_auto_print',TRUE);

                    echo json_encode($response);
                }

                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_order=$this->Repair_order_model;
                $m_order_item=$this->Repair_order_item_model;

                $repair_order_id=$this->input->post('repair_order_id',TRUE);

                $m_order->begin();

                /* Customers Info */

                $m_order->customer_id= $this->get_numeric_value($this->input->post('customer_id',TRUE));
                $m_order->address = $this->input->post('address',TRUE);
                $m_order->address = $this->input->post('address',TRUE);
                $m_order->mobile_no = $this->input->post('mobile_no',TRUE);
                $m_order->tel_no_home = $this->input->post('tel_no_home',TRUE);
                $m_order->tel_no_bus = $this->input->post('tel_no_bus',TRUE);
                $m_order->representative_name = $this->input->post('representative_name',TRUE);
                $m_order->representative_no = $this->input->post('representative_no',TRUE);

                /* Vehicle Information */

                $m_order->vehicle_id = $this->get_numeric_value($this->input->post('vehicle_id', TRUE));
                $m_order->year_make_id = $this->input->post('year_make_id', TRUE);
                $m_order->model_name = $this->input->post('model_name', TRUE);
                $m_order->color_name = $this->input->post('color_name', TRUE);
                $m_order->chassis_no = $this->input->post('chassis_no', TRUE);
                $m_order->engine_no = $this->input->post('engine_no', TRUE);
                $m_order->km_reading = $this->get_numeric_value($this->input->post('km_reading', TRUE));
                $m_order->next_svc_date = date('Y-m-d',strtotime($this->input->post('next_svc_date', TRUE)));
                $m_order->next_svc_km = $this->get_numeric_value($this->input->post('next_svc_km', TRUE));

                /* Repair Order Information */

                $m_order->pms_desc = $this->input->post('pms_desc', TRUE);
                $m_order->bpr_desc = $this->input->post('bpr_desc', TRUE);
                $m_order->gj_desc = $this->input->post('gj_desc', TRUE);
                $m_order->date_time_promised = date('Y-m-d h:i:s',strtotime($this->input->post('date_time_promised', TRUE)));
                $m_order->delivery_date = date('Y-m-d',strtotime($this->input->post('delivery_date', TRUE)));
                $m_order->selling_dealer=$this->input->post('selling_dealer',TRUE);
                $m_order->advisor_id=$this->input->post('advisor_id',TRUE);
                $m_order->advisor_remarks=$this->input->post('advisor_remarks',TRUE);
                $m_order->customer_remarks=$this->input->post('customer_remarks',TRUE);

                $m_order->modify($repair_order_id);

                $m_order_item->delete_via_fk($repair_order_id); //delete previous items then insert those new

                $prod_id=$this->input->post('product_id',TRUE);
                $order_qty=$this->input->post('order_qty',TRUE);
                $order_price=$this->input->post('order_price',TRUE);
                $order_gross=$this->input->post('order_gross',TRUE);
                $order_discount=$this->input->post('order_discount',TRUE);
                $order_line_total_discount=$this->input->post('order_line_total_discount',TRUE);
                $order_tax_rate=$this->input->post('order_tax_rate',TRUE);
                $order_line_total_price=$this->input->post('order_line_total_price',TRUE);
                $order_tax_amount=$this->input->post('order_tax_amount',TRUE);
                $order_non_tax_amount=$this->input->post('order_non_tax_amount',TRUE);
                $order_line_total_after_global=$this->input->post('order_line_total_after_global',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
                $vehicle_service_id=$this->input->post('vehicle_service_id',TRUE);
                $is_parent=$this->input->post('is_parent',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_order_item->repair_order_id=$repair_order_id;
                    $m_order_item->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_order_item->order_line_total_after_global=$this->get_numeric_value($order_line_total_after_global[$i]);
                    $m_order_item->order_qty=$this->get_numeric_value($order_qty[$i]);
                    $m_order_item->order_price=$this->get_numeric_value($order_price[$i]);
                    $m_order_item->order_gross=$this->get_numeric_value($order_gross[$i]);
                    $m_order_item->order_discount=$this->get_numeric_value($order_discount[$i]);
                    $m_order_item->order_line_total_discount=$this->get_numeric_value($order_line_total_discount[$i]);
                    $m_order_item->order_tax_rate=$this->get_numeric_value($order_tax_rate[$i]);
                    $m_order_item->order_line_total_price=$this->get_numeric_value($order_line_total_price[$i]);
                    $m_order_item->order_tax_amount=$this->get_numeric_value($order_tax_amount[$i]);
                    $m_order_item->order_non_tax_amount=$this->get_numeric_value($order_non_tax_amount[$i]);
                    $m_order_item->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_order_item->batch_no=$batch_no[$i];
                    $m_order_item->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);
                    $m_order_item->vehicle_service_id=$this->get_numeric_value($vehicle_service_id[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $m_order_item->is_parent=$this->get_numeric_value($is_parent[$i]);

                    if($is_parent[$i] == '1'){

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_order_item->unit_id=$unit_id[0]->bulk_unit_id;

                    }else{

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_order_item->unit_id=$unit_id[0]->parent_unit_id;

                    }   

                    $m_order_item->save();
                    $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }

                $m_order->commit();

                if($m_order->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Repair Order successfully updated.';
                    $response['row_updated']=$m_order->get_repair_order($repair_order_id);
                    echo json_encode($response);
                }

                break;


            //***************************************************************************************
            case 'delete':
                /*$m_invoice=$this->Sales_invoice_model;
                $sales_invoice_id=$this->input->post('sales_invoice_id',TRUE);

                //mark Items as deleted
                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($sales_invoice_id);

                $so_info=$m_invoice->get_list($sales_invoice_id,'sales_invoice.sales_order_id'); //get purchase order first
                if(count($so_info)>0){ //make sure po info return resultset before executing other process
                    $sales_order_id=$so_info[0]->sales_order_id; //pass it to variable
                    //update purchase order status
                    $m_order=$this->Sales_order_model;
                    $m_order->order_status_id=$this->get_so_status($sales_order_id);
                    $m_order->modify($sales_order_id);
                }


                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);*/

                $m_order=$this->Repair_order_model;

                $repair_order_id=$this->input->post('repair_order_id',TRUE);

                //mark Items as deleted
                $m_order->is_deleted=1;//mark as deleted
                $m_order->modify($repair_order_id);

                //update product on_hand after invoice is deleted...
                // $products=$m_order_item->get_list(
                //     'sales_invoice_id='.$sales_invoice_id,
                //     'product_id'
                // ); 

                // for($i=0;$i<count($products);$i++) {
                //     $prod_id=$products[$i]->product_id;
                //     $m_products->on_hand=$m_products->get_product_qty($prod_id);
                //     $m_products->modify($prod_id);
                // }
                //end update product on_hand after invoice is deleted...

                // $so_info=$m_invoice->get_list($sales_invoice_id,'sales_invoice.sales_order_id');// get purchase order first

                // if(count($so_info)>0){
                //     $sales_order_id=$so_info[0]->sales_order_id;// pass to variable
                //     $m_so=$this->Sales_order_model;
                //     $m_so->order_status_id=$this->get_so_status(
                //         $sales_order_id);
                //     $m_so->modify($sales_order_id);

                // }

                // $sal_info=$m_invoice->get_list($sales_invoice_id,'sales_inv_no');
                // $m_trans=$this->Trans_model;
                // $m_trans->user_id=$this->session->user_id;
                // $m_trans->set('trans_date','NOW()');
                // $m_trans->trans_key_id=3; //CRUD
                // $m_trans->trans_type_id=17; // TRANS TYPE
                // $m_trans->trans_log='Deleted Sales Invoice No: '.$sal_info[0]->sales_inv_no;
                // $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Repair Order successfully deleted.';
                echo json_encode($response);

                break;

            //***************************************************************************************
            case 'sales-for-review':
                $m_sales_invoice=$this->Sales_invoice_model;
                // $response['data']=$m_sales_invoice->get_list(

                //     array(
                //         'sales_invoice.is_active'=>TRUE,
                //         'sales_invoice.is_deleted'=>FALSE,
                //         'sales_invoice.is_journal_posted'=>FALSE
                //     ),

                //     array(
                //         'sales_invoice.sales_invoice_id',
                //         'sales_invoice.sales_inv_no',
                //         'sales_invoice.remarks',
                //         'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                //         'customers.customer_name'
                //     ),

                //     array(
                //         array('customers','customers.customer_id=sales_invoice.customer_id','left')
                //     ),
                //     'sales_invoice.sales_invoice_id DESC'
                // );
                // OLD Response - Invoice not subject to finalizing are still showing up so i revised the code                

                $response['data']=$m_sales_invoice->get_sales_invoice_for_review();
                echo json_encode($response);
                break;

            case 'si-report':
                $m_sales_invoice=$this->Sales_invoice_model;
                $m_sales_invoice_items=$this->Sales_invoice_item_model;
                $m_company=$this->Company_model;

                $company_info=$m_company->get_list();
                $info=$m_sales_invoice->get_list(
                    $id_filter,
                    array(
                        'sales_invoice.sales_invoice_id',
                        'sales_invoice.sales_inv_no',
                        'sales_invoice.remarks', 
                        'sales_invoice.date_created',
                        'sales_invoice.customer_id',
                        'sales_invoice.inv_type',
                        'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                        'DATE_FORMAT(sales_invoice.date_due,"%m/%d/%Y") as date_due',
                        'departments.department_id',
                        'departments.department_name',
                        'customers.customer_name',
                        'sales_invoice.salesperson_id',
                        'sales_invoice.address',
                        'sales_order.so_no',
                        'CONCAT(salesperson.firstname," ",salesperson.lastname) AS salesperson_name'
                    ),
                    array(
                        array('departments','departments.department_id=sales_invoice.department_id','left'),
                        array('salesperson','salesperson.salesperson_id=sales_invoice.salesperson_id','left'),
                        array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                        array('sales_order','sales_order.sales_order_id=sales_invoice.sales_order_id','left'),
                    )
                );

                $data['company_info']=$company_info[0];
                $data['sales_info']=$info[0];
                $data['sales_invoice_items']=$m_sales_invoice_items->get_list(
                    array('sales_invoice_items.sales_invoice_id'=>$id_filter),
                    'sales_invoice_items.*,products.product_desc,products.size,units.unit_name',
                    array(
                        array('products','products.product_id=sales_invoice_items.product_id','left'),
                        array('units','units.unit_id=sales_invoice_items.unit_id','left')
                    )
                );

                $this->load->view('template\sales_invoice_content_standard',$data);
            break;  

            case 'per-customer-sales':
                $m_sales_invoice=$this->Sales_invoice_model;
                $response['data']=$m_sales_invoice->get_customers_sales_summary();
                echo(
                    json_encode($response)
                );
                break;
        }

    }



//**************************************user defined*************************************************
    function response_rows($filter_value,$additional=null){
        return $this->Sales_invoice_model->get_list(
             'sales_invoice.is_active = TRUE AND sales_invoice.is_deleted = FALSE '.($filter_value==null?'':' AND sales_invoice.sales_invoice_id='.$filter_value).''.($additional==null?'':$additional),
            array(
                'sales_invoice.sales_invoice_id',
                'sales_invoice.sales_inv_no',
                'sales_invoice.remarks', 
                'sales_invoice.date_created',
                'sales_invoice.customer_id',
                'sales_invoice.inv_type',
                'sales_invoice.contact_person',
                'sales_invoice.customer_type_id',
                'sales_invoice.agent_id',
                'sales_invoice.order_source_id',
                'sales_invoice.for_dispatching',
                'sales_invoice.is_journal_posted',
                'sales_invoice.total_overall_discount',
                'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(sales_invoice.date_due,"%m/%d/%Y") as date_due',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'sales_invoice.salesperson_id',
                'sales_invoice.address',
                'sales_order.so_no',
                '(SELECT count(*) FROM sales_attachments WHERE sales_invoice_id = sales_invoice.sales_invoice_id) as total_attachments'
            ),
            array(
                array('departments','departments.department_id=sales_invoice.department_id','left'),
                array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                array('sales_order','sales_order.sales_order_id=sales_invoice.sales_order_id','left'),

            ),
            'sales_invoice.sales_invoice_id DESC'
        );
    }

    function response_rows_count($filter_value){
        return $this->Sales_invoice_model->list_with_count($filter_value);
    }



    function get_so_status($id){
        //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
        $m_sales_invoice=$this->Sales_invoice_model;
        $m_cash_invoice=$this->Cash_invoice_model;

        if(count($m_sales_invoice->get_list(
                array('sales_invoice.sales_order_id'=>$id,'sales_invoice.is_active'=>TRUE,'sales_invoice.is_deleted'=>FALSE),
                'sales_invoice.sales_invoice_id'))==0  &&

            count($m_cash_invoice->get_list(
                array('cash_invoice.sales_order_id'=>$id,'cash_invoice.is_active'=>TRUE,'cash_invoice.is_deleted'=>FALSE),
                'cash_invoice.cash_invoice_id'))==0 

                ){ //means no SO found on sales invoice that means this so is still open

            return 1;

        }else{
            $m_so=$this->Sales_order_model;
            $row=$m_so->get_so_balance_qty($id);
            return ($row[0]->Balance>0?3:2);
        }

    }


    /*function validate_record($invoice_no){
        $m_invoice=$this->Sales_invoice_model;

        if(count($m_invoice->get_list(array('sales_inv_no'=>$invoice_no)))>0){
            $response['title'] = 'Invalid!';
            $response['stat'] = 'error';
            $response['msg'] = 'Invoice No. already exists. Please contact System Administrator for assistance.';
            die(json_encode($response));
        }

        return true;
    }




    //return current invoice number based on the range provided
    function get_current_invoice_no($user_id){
        try{
            $m_counter=$this->Invoice_counter_model;
            $counter=$m_counter->get_list(array('invoice_counter.user_id'=>$user_id));


            $last_used=$counter[0]->last_invoice;
            $start_no=$counter[0]->counter_start;
            $end_no=$counter[0]->counter_end;

            if($start_no==0&&$end_no==0){
                $response['title'] = 'Invalid Invoice Range!';
                $response['stat'] = 'error';
                $response['msg'] = 'Please call system administrator to set new Invoice No. range to your account.';
                die(json_encode($response));
            }

            $next_no=((float)$last_used)+1;

            //check if $next_no is between start and end
            if($next_no>=$start_no&&$next_no<=$end_no){
                return $next_no;
            }else{
                //the choices are start no TO end no
                //but we need to validate first the start no
                $m_invoice=$this->Sales_invoice_model;
                $invoices=$m_invoice->get_list(
                    'sales_invoice.sales_inv_no BETWEEN '.$start_no.' AND '.$end_no,
                    array(
                        'sales_invoice.sales_inv_no'
                    ),
                    null,
                    'CAST(sales_invoice.sales_inv_no AS UNSIGNED) DESC',
                    null,
                    TRUE,
                    1
                );

                if(count($invoices)>0){
                    $next_no_from_invoice=((float)$invoices[0]->sales_inv_no)+1; //this is the incremented value from invoice

                    if($next_no_from_invoice>=$start_no&&$next_no_from_invoice<=$end_no){ //if still between the valid range, return the incremented value
                        return $next_no_from_invoice;
                    }else{

                        //if "next no. from invoice" is not yet valid
                        //check if "counter start" is valid

                        $invoices=$m_invoice->get_list(array('sales_inv_no'=>$start_no));
                        if(count($invoices)==0){ //if not found, start no. is valid
                            return $start_no;
                        }else{
                            $response['title'] = 'Invoice No. Consumed!';
                            $response['stat'] = 'error';
                            $response['msg'] = 'Please call system administrator to set new Invoice No. range to your account.';
                            die(json_encode($response));
                        }

                    }


                }else{ //no record found, we could safely use start no
                    return $start_no;
                }


            }


        }catch(Exception $e) {
            $response['title'] = 'Error Occurred!';
            $response['stat'] = 'error';
            $response['msg'] = 'Please call system administrator to set new Invoice No. range to your account.';
            die(json_encode($response));
        }





    }*/


//***************************************************************************************





}
