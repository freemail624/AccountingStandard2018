<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_invoice extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();


        $this->load->model('Sales_order_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Service_invoice_model');
        $this->load->model('Service_invoice_item_model');
        $this->load->model('Services_model');
        $this->load->model('Users_model');
        $this->load->model('Customer_vehicles_model');
        $this->load->model('Advisor_model');
        $this->load->model('Makes_model');
        $this->load->model('Vehicle_year_model');
        $this->load->model('Vehicle_model');
        $this->load->model('Colors_model');
        $this->load->model('Repair_order_model');
        $this->load->model('Repair_order_item_model');
        $this->load->model('Products_model');
        $this->load->model('Insurance_model');

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
        // $data['customers']=$this->Customers_model->get_list(
        //     array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE)
        // );

        $data['insurances']=$this->Insurance_model->get_list(
            'is_deleted=FALSE'
        );

        $data['services'] = $this->Services_model->get_list(
            array('services.is_active'=>TRUE,'services.is_deleted'=>FALSE), 
            array(
                
                'services.*',
                'service_unit.*'

                ),

            array(
                array('service_unit','service_unit.service_unit_id=services.service_unit','left')
                )   
            );
        $data['vehicles'] = $this->Customer_vehicles_model->get_vehicles();
        $data['advisors'] = $this->Advisor_model->get_advisors_list();
        $data['makes'] = $this->Makes_model->get_makes_list();
        $data['years'] = $this->Vehicle_year_model->get_vehicle_year_list();
        $data['models'] = $this->Vehicle_model->get_models_list();
        $data['colors'] = $this->Colors_model->get_colors_list();

        $data['title'] = 'Service Invoice';
        $this->load->view('service_invoice_ro_view', $data);
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_invoice=$this->Service_invoice_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $response['data']=$m_invoice->get_service_invoice_list(null,$tsd,$ted);
                echo json_encode($response);
                break;

            case 'list-invoice' :
                $m_invoice = $this->Service_invoice_model;
                $response['data']= $this->response_rows_invoice(
                     'service_invoice.is_active=TRUE AND service_invoice.is_deleted=FALSE'.($id_filter==null?'':' AND service_invoice.service_invoice_id='.$id_filter)
                   
                    );
                echo json_encode($response);

                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items-invoice':
                $m_items=$this->Service_invoice_item_model;
                $response['data']=$m_items->get_list(
                    array('service_invoice_id'=>$id_filter),
                    array(
                        'service_invoice_items.*',
                        'services`.service_code',
                        'services.service_desc',
                        'services.service_unit',
                        'service_unit.service_unit_id',
                        'service_unit.service_unit_name'
                    ),
                    array(
                        array('services','services.service_id=service_invoice_items.service_id','left'),
                        array('service_unit','service_unit.service_unit_id=service_invoice_items.service_unit','left')
                    ),
                    'service_invoice_items.service_item_id ASC'
                );


                echo json_encode($response);

                break;

           case 'items': //items on the specific PO, loads when edit button is called
                $m_invoice_item=$this->Service_invoice_item_model;
                $response['data']=$m_invoice_item->get_service_invoice_items($id_filter);
                echo json_encode($response);
                break;

            case 'create':
                $m_invoice=$this->Service_invoice_model;
                $m_invoice_item=$this->Service_invoice_item_model;
                $m_order=$this->Repair_order_model;

                $repair_order_id = $this->get_numeric_value($this->input->post('repair_order_id',TRUE));
                $customer_id = $this->get_numeric_value($this->input->post('customer_id',TRUE));
                $address = $this->input->post('address',TRUE);
                $mobile_no = $this->input->post('mobile_no',TRUE);
                $tel_no_home = $this->input->post('tel_no_home',TRUE);
                $tel_no_bus = $this->input->post('tel_no_bus',TRUE);

                $m_invoice->begin();

                /* Customers Info */

                $m_invoice->repair_order_id= $repair_order_id;
                $m_invoice->customer_id= $customer_id;
                $m_invoice->address = $address;
                $m_invoice->mobile_no = $mobile_no;
                $m_invoice->tel_no_home = $tel_no_home;
                $m_invoice->tel_no_bus = $tel_no_bus;
                $m_invoice->representative_name = $this->input->post('representative_name',TRUE);
                $m_invoice->representative_no = $this->input->post('representative_no',TRUE);

                /* Vehicle Information */

                $m_invoice->vehicle_id = $this->get_numeric_value($this->input->post('vehicle_id', TRUE));
                $m_invoice->year_make_id = $this->input->post('year_make_id', TRUE);
                $m_invoice->model_name = $this->input->post('model_name', TRUE);
                $m_invoice->color_name = $this->input->post('color_name', TRUE);
                $m_invoice->chassis_no = $this->input->post('chassis_no', TRUE);
                $m_invoice->engine_no = $this->input->post('engine_no', TRUE);
                $m_invoice->km_reading = $this->get_numeric_value($this->input->post('km_reading', TRUE));
                $m_invoice->next_svc_date = date('Y-m-d',strtotime($this->input->post('next_svc_date', TRUE)));
                $m_invoice->next_svc_km = $this->get_numeric_value($this->input->post('next_svc_km', TRUE));
                $m_invoice->crp_no = $this->input->post('crp_no', TRUE);
                $m_invoice->crp_no_type = $this->input->post('crp_no_type', TRUE);

                /* Repair Order Information */

                $m_invoice->set('date_created','NOW()');
                $m_invoice->set('date_due','NOW()');
                $m_invoice->set('document_date','NOW()');
                $m_invoice->set('date_invoice','NOW()');
                $m_invoice->pms_desc = $this->input->post('pms_desc', TRUE);
                $m_invoice->bpr_desc = $this->input->post('bpr_desc', TRUE);
                $m_invoice->gj_desc = $this->input->post('gj_desc', TRUE);
                $m_invoice->date_time_promised = date('Y-m-d h:i:s',strtotime($this->input->post('date_time_promised', TRUE)));
                $m_invoice->selling_dealer=$this->input->post('selling_dealer',TRUE);
                $m_invoice->advisor_id=$this->input->post('advisor_id',TRUE);
                $m_invoice->insurance_id=$this->input->post('insurance_id',TRUE);
                $m_invoice->advisor_remarks=$this->input->post('advisor_remarks',TRUE);
                $m_invoice->customer_remarks=$this->input->post('customer_remarks',TRUE);

                // $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                // $m_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                // $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                // $m_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                // $m_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                // $m_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                // $m_invoice->total_after_discount=$this->get_numeric_value($this->input->post('total_after_discount',TRUE));

                $m_invoice->sdesc_1=$this->input->post('sdesc_1',TRUE);
                $m_invoice->sdesc_2=$this->input->post('sdesc_2',TRUE);
                $m_invoice->sdesc_3=$this->input->post('sdesc_3',TRUE);
                $m_invoice->sdesc_4=$this->input->post('sdesc_4',TRUE);
                $m_invoice->sdesc_5=$this->input->post('sdesc_5',TRUE);
                $m_invoice->sdesc_6=$this->input->post('sdesc_6',TRUE);
                $m_invoice->sdesc_7=$this->input->post('sdesc_7',TRUE);
                $m_invoice->sdesc_8=$this->input->post('sdesc_8',TRUE);
                $m_invoice->sdesc_9=$this->input->post('sdesc_9',TRUE);
                $m_invoice->sdesc_10=$this->input->post('sdesc_10',TRUE);
                $m_invoice->sdesc_11=$this->input->post('sdesc_11',TRUE);
                $m_invoice->sdesc_12=$this->input->post('sdesc_12',TRUE);
                $m_invoice->sdesc_13=$this->input->post('sdesc_13',TRUE);
                $m_invoice->sdesc_14=$this->input->post('sdesc_14',TRUE);
                $m_invoice->sdesc_15=$this->input->post('sdesc_15',TRUE);
                $m_invoice->sdesc_16=$this->input->post('sdesc_16',TRUE);
                $m_invoice->sdesc_17=$this->input->post('sdesc_17',TRUE);
                $m_invoice->sdesc_18=$this->input->post('sdesc_18',TRUE);
                $m_invoice->sdesc_19=$this->input->post('sdesc_19',TRUE);
                $m_invoice->sdesc_20=$this->input->post('sdesc_20',TRUE);
                $m_invoice->sdesc_21=$this->input->post('sdesc_21',TRUE);
                $m_invoice->sdesc_22=$this->input->post('sdesc_22',TRUE);
                $m_invoice->sdesc_23=$this->input->post('sdesc_23',TRUE);
                $m_invoice->sdesc_24=$this->input->post('sdesc_24',TRUE);
                $m_invoice->sdesc_25=$this->input->post('sdesc_25',TRUE);
                $m_invoice->sdesc_26=$this->input->post('sdesc_26',TRUE);
                $m_invoice->sdesc_27=$this->input->post('sdesc_27',TRUE);
                $m_invoice->sdesc_28=$this->input->post('sdesc_28',TRUE);
                $m_invoice->sdesc_29=$this->input->post('sdesc_29',TRUE);
                $m_invoice->sdesc_30=$this->input->post('sdesc_30',TRUE);

                $m_invoice->posted_by_user=$this->session->user_id;
                $m_invoice->save();

                $service_invoice_id=$m_invoice->last_insert_id();

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
                $tbl_no=$this->input->post('tbl_no',TRUE);                
                $is_parent=$this->input->post('is_parent',TRUE);
            
                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_item->service_invoice_id=$service_invoice_id;
                    $m_invoice_item->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_item->service_line_total_after_global=$this->get_numeric_value($order_line_total_after_global[$i]);
                    $m_invoice_item->service_qty=$this->get_numeric_value($order_qty[$i]);
                    $m_invoice_item->service_price=$this->get_numeric_value($order_price[$i]);
                    $m_invoice_item->service_gross=$this->get_numeric_value($order_gross[$i]);
                    $m_invoice_item->service_discount=$this->get_numeric_value($order_discount[$i]);
                    $m_invoice_item->service_line_total_discount=$this->get_numeric_value($order_line_total_discount[$i]);
                    $m_invoice_item->service_tax_rate=$this->get_numeric_value($order_tax_rate[$i]);
                    $m_invoice_item->service_line_total_price=$this->get_numeric_value($order_line_total_price[$i]);
                    $m_invoice_item->service_tax_amount=$this->get_numeric_value($order_tax_amount[$i]);
                    $m_invoice_item->service_non_tax_amount=$this->get_numeric_value($order_non_tax_amount[$i]);
                    $m_invoice_item->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_invoice_item->batch_no=$batch_no[$i];
                    $m_invoice_item->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);
                    $m_invoice_item->vehicle_service_id=$this->get_numeric_value($vehicle_service_id[$i]);
                    $m_invoice_item->tbl_no=$this->get_numeric_value($tbl_no[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $m_invoice_item->is_parent=$this->get_numeric_value($is_parent[$i]);

                    if($is_parent[$i] == '1'){

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_invoice_item->unit_id=$unit_id[0]->bulk_unit_id;

                    }else{

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_invoice_item->unit_id=$unit_id[0]->parent_unit_id;

                    }   

                    $m_invoice_item->save();
                    $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }

                //update repair order on formatted last insert id
                $m_invoice->service_invoice_no='SER-INV-'.date('Ymd').'-'.$service_invoice_id;
                $m_invoice->modify($service_invoice_id);

                $m_order->ro_status_id=TRUE;
                $m_order->modify($repair_order_id);

                // Update Customer Information
                $m_customer = $this->Customers_model;

                if($address != null || $address == ""){
                    $m_customer->address = $address;
                }
                if($mobile_no != null || $mobile_no == ""){
                    $m_customer->contact_no = $mobile_no;
                }
                if($tel_no_home != null || $tel_no_home == ""){
                    $m_customer->tel_no_home = $tel_no_home;
                }
                if($tel_no_bus != null || $tel_no_bus == ""){
                    $m_customer->tel_no_bus = $tel_no_bus;
                }

                $m_customer->modify($customer_id);
                //update status of so
                // $m_so->order_status_id=$this->get_so_status($sales_order_id);
                // $m_so->modify($sales_order_id);

                $m_invoice->commit();

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Repair order successfully created.';
                    $response['row_added']=$m_invoice->get_service_invoice_list($service_invoice_id);
                    // $response['is_auto_print']=$this->input->post('is_auto_print',TRUE);

                    echo json_encode($response);
                }

                break;

            //***************************************create new Items************************************************
            case 'create-invoice':
                $m_invoice=$this->Service_invoice_model;
                
                $m_invoice->set('date_created','NOW()');
                $m_invoice->customer_id=$this->input->post('customer',TRUE);
                $m_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_invoice->department_id=$this->input->post('department',TRUE);
                $m_invoice->contact_person=$this->input->post('contact_person',TRUE);
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->total_amount=$this->get_numeric_value($this->input->post('summary_total_amount',TRUE));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_invoice->total_amount_after_discount=$this->get_numeric_value($this->input->post('summary_total_amount_after_discount',TRUE));

                

                
                $m_invoice->posted_by_user=$this->session->user_id;
                $m_invoice->save();


                $service_invoice_id=$m_invoice->last_insert_id();


                $m_invoice_items=$this->Service_invoice_item_model;
                //prepare the items with multiple values for looping statement
                $service_id = $this->input->post('service_id');
                $service_qty = $this->input->post('qty');
                $service_price = $this->input->post('service_price');
                $service_line_total = $this->input->post('line_total');
                $service_unit = $this->input->post('service_unit');
                $line_total_after_global = $this->input->post('line_total_after_global');
                

                for($i=0;$i<count($service_id);$i++){
                $m_invoice_items->service_invoice_id=$service_invoice_id;
                $m_invoice_items->service_id=$this->get_numeric_value($service_id[$i]);
                $m_invoice_items->service_qty=$this->get_numeric_value($service_qty[$i]);
                $m_invoice_items->service_price=$this->get_numeric_value($service_price[$i]);
                $m_invoice_items->service_line_total=$this->get_numeric_value($service_line_total[$i]);
                $m_invoice_items->service_line_total_after_global=$this->get_numeric_value($line_total_after_global[$i]);
                $m_invoice_items->service_unit=$this->get_numeric_value($service_unit[$i]);

                $m_invoice_items->save();
                }
                $m_invoice->service_invoice_no='SER-INV-'.date('Ymd').'-'.$service_invoice_id;
                $m_invoice->modify($service_invoice_id);

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Service invoice successfully created.';
                    $response['row_added']=$this->response_rows_invoice($service_invoice_id);

                    echo json_encode($response);
                }

                break;
            
            case 'update':
                $m_invoice=$this->Service_invoice_model;
                $m_invoice_item=$this->Service_invoice_item_model;

                $service_invoice_id=$this->input->post('service_invoice_id',TRUE);
                $repair_order_id=$this->input->post('repair_order_id',TRUE);

                $check_inv=$m_invoice->get_list($service_invoice_id);
                
                if(count($check_inv) > 0){

                    if($check_inv[0]->is_journal_posted == TRUE){

                        $response['stat']='error';
                        $response['title']='<b>Warning</b>';
                        $response['msg']='This service invoice was already posted!';
                        die(json_encode($response));

                    }

                }

                $customer_id = $this->get_numeric_value($this->input->post('customer_id',TRUE));
                $address = $this->input->post('address',TRUE);
                $mobile_no = $this->input->post('mobile_no',TRUE);
                $tel_no_home = $this->input->post('tel_no_home',TRUE);
                $tel_no_bus = $this->input->post('tel_no_bus',TRUE);

                $m_invoice->begin();

                /* Customers Info */

                $m_invoice->repair_order_id= $repair_order_id;
                $m_invoice->customer_id= $customer_id;
                $m_invoice->address = $address;
                $m_invoice->mobile_no = $mobile_no;
                $m_invoice->tel_no_home = $tel_no_home;
                $m_invoice->tel_no_bus = $tel_no_bus;
                $m_invoice->representative_name = $this->input->post('representative_name',TRUE);
                $m_invoice->representative_no = $this->input->post('representative_no',TRUE);

                /* Vehicle Information */

                $m_invoice->vehicle_id = $this->get_numeric_value($this->input->post('vehicle_id', TRUE));
                $m_invoice->year_make_id = $this->input->post('year_make_id', TRUE);
                $m_invoice->model_name = $this->input->post('model_name', TRUE);
                $m_invoice->color_name = $this->input->post('color_name', TRUE);
                $m_invoice->chassis_no = $this->input->post('chassis_no', TRUE);
                $m_invoice->engine_no = $this->input->post('engine_no', TRUE);
                $m_invoice->km_reading = $this->get_numeric_value($this->input->post('km_reading', TRUE));
                $m_invoice->next_svc_date = date('Y-m-d',strtotime($this->input->post('next_svc_date', TRUE)));
                $m_invoice->next_svc_km = $this->get_numeric_value($this->input->post('next_svc_km', TRUE));
                $m_invoice->crp_no = $this->input->post('crp_no', TRUE);
                $m_invoice->crp_no_type = $this->input->post('crp_no_type', TRUE);

                /* Repair Order Information */

                $m_invoice->pms_desc = $this->input->post('pms_desc', TRUE);
                $m_invoice->bpr_desc = $this->input->post('bpr_desc', TRUE);
                $m_invoice->gj_desc = $this->input->post('gj_desc', TRUE);
                $m_invoice->date_time_promised = date('Y-m-d h:i:s',strtotime($this->input->post('date_time_promised', TRUE)));
                $m_invoice->selling_dealer=$this->input->post('selling_dealer',TRUE);
                $m_invoice->advisor_id=$this->input->post('advisor_id',TRUE);
                $m_invoice->insurance_id=$this->input->post('insurance_id',TRUE);
                $m_invoice->advisor_remarks=$this->input->post('advisor_remarks',TRUE);
                $m_invoice->customer_remarks=$this->input->post('customer_remarks',TRUE);

                $m_invoice->sdesc_1=$this->input->post('sdesc_1',TRUE);
                $m_invoice->sdesc_2=$this->input->post('sdesc_2',TRUE);
                $m_invoice->sdesc_3=$this->input->post('sdesc_3',TRUE);
                $m_invoice->sdesc_4=$this->input->post('sdesc_4',TRUE);
                $m_invoice->sdesc_5=$this->input->post('sdesc_5',TRUE);
                $m_invoice->sdesc_6=$this->input->post('sdesc_6',TRUE);
                $m_invoice->sdesc_7=$this->input->post('sdesc_7',TRUE);
                $m_invoice->sdesc_8=$this->input->post('sdesc_8',TRUE);
                $m_invoice->sdesc_9=$this->input->post('sdesc_9',TRUE);
                $m_invoice->sdesc_10=$this->input->post('sdesc_10',TRUE);
                $m_invoice->sdesc_11=$this->input->post('sdesc_11',TRUE);
                $m_invoice->sdesc_12=$this->input->post('sdesc_12',TRUE);
                $m_invoice->sdesc_13=$this->input->post('sdesc_13',TRUE);
                $m_invoice->sdesc_14=$this->input->post('sdesc_14',TRUE);
                $m_invoice->sdesc_15=$this->input->post('sdesc_15',TRUE);
                $m_invoice->sdesc_16=$this->input->post('sdesc_16',TRUE);
                $m_invoice->sdesc_17=$this->input->post('sdesc_17',TRUE);
                $m_invoice->sdesc_18=$this->input->post('sdesc_18',TRUE);
                $m_invoice->sdesc_19=$this->input->post('sdesc_19',TRUE);
                $m_invoice->sdesc_20=$this->input->post('sdesc_20',TRUE);
                $m_invoice->sdesc_21=$this->input->post('sdesc_21',TRUE);
                $m_invoice->sdesc_22=$this->input->post('sdesc_22',TRUE);
                $m_invoice->sdesc_23=$this->input->post('sdesc_23',TRUE);
                $m_invoice->sdesc_24=$this->input->post('sdesc_24',TRUE);
                $m_invoice->sdesc_25=$this->input->post('sdesc_25',TRUE);
                $m_invoice->sdesc_26=$this->input->post('sdesc_26',TRUE);
                $m_invoice->sdesc_27=$this->input->post('sdesc_27',TRUE);
                $m_invoice->sdesc_28=$this->input->post('sdesc_28',TRUE);
                $m_invoice->sdesc_29=$this->input->post('sdesc_29',TRUE);
                $m_invoice->sdesc_30=$this->input->post('sdesc_30',TRUE);

                $m_invoice->modify($service_invoice_id);

                $m_invoice_item->delete_via_fk($service_invoice_id); //delete previous items then insert those new

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
                $tbl_no=$this->input->post('tbl_no',TRUE);                
                $is_parent=$this->input->post('is_parent',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_item->service_invoice_id=$service_invoice_id;
                    $m_invoice_item->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_item->service_line_total_after_global=$this->get_numeric_value($order_line_total_after_global[$i]);
                    $m_invoice_item->service_qty=$this->get_numeric_value($order_qty[$i]);
                    $m_invoice_item->service_price=$this->get_numeric_value($order_price[$i]);
                    $m_invoice_item->service_gross=$this->get_numeric_value($order_gross[$i]);
                    $m_invoice_item->service_discount=$this->get_numeric_value($order_discount[$i]);
                    $m_invoice_item->service_line_total_discount=$this->get_numeric_value($order_line_total_discount[$i]);
                    $m_invoice_item->service_tax_rate=$this->get_numeric_value($order_tax_rate[$i]);
                    $m_invoice_item->service_line_total_price=$this->get_numeric_value($order_line_total_price[$i]);
                    $m_invoice_item->service_tax_amount=$this->get_numeric_value($order_tax_amount[$i]);
                    $m_invoice_item->service_non_tax_amount=$this->get_numeric_value($order_non_tax_amount[$i]);
                    $m_invoice_item->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_invoice_item->batch_no=$batch_no[$i];
                    $m_invoice_item->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);
                    $m_invoice_item->vehicle_service_id=$this->get_numeric_value($vehicle_service_id[$i]);
                    $m_invoice_item->tbl_no=$this->get_numeric_value($tbl_no[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $m_invoice_item->is_parent=$this->get_numeric_value($is_parent[$i]);

                    if($is_parent[$i] == '1'){

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_invoice_item->unit_id=$unit_id[0]->bulk_unit_id;

                    }else{

                        $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                        $m_invoice_item->unit_id=$unit_id[0]->parent_unit_id;

                    }   

                    $m_invoice_item->save();
                    $m_products->on_hand=$m_products->get_product_qty($this->get_numeric_value($prod_id[$i]));
                    $m_products->modify($this->get_numeric_value($prod_id[$i]));
                }

                // Update Customer Information
                $m_customer = $this->Customers_model;

                if($address != null || $address == ""){
                    $m_customer->address = $address;
                }
                if($mobile_no != null || $mobile_no == ""){
                    $m_customer->contact_no = $mobile_no;
                }
                if($tel_no_home != null || $tel_no_home == ""){
                    $m_customer->tel_no_home = $tel_no_home;
                }
                if($tel_no_bus != null || $tel_no_bus == ""){
                    $m_customer->tel_no_bus = $tel_no_bus;
                }

                $m_customer->modify($customer_id);

                $m_invoice->commit();

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Service Invoice successfully updated.';
                    $response['row_updated']=$m_invoice->get_service_invoice_list($service_invoice_id);
                    echo json_encode($response);
                }

                break;


            ////***************************************update Items************************************************
            case 'update-invoice':
                $m_invoice=$this->Service_invoice_model;
                
                $service_invoice_id=$this->input->post('service_invoice_id',TRUE);

                $m_invoice->set('date_created','NOW()');
                $m_invoice->customer_id=$this->input->post('customer',TRUE);
                $m_invoice->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_invoice->contact_person=$this->input->post('contact_person',TRUE);
                $m_invoice->department_id=$this->input->post('department',TRUE);
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->total_amount=$this->get_numeric_value($this->input->post('summary_total_amount',TRUE));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_invoice->total_amount_after_discount=$this->get_numeric_value($this->input->post('summary_total_amount_after_discount',TRUE));
                $m_invoice->modified_by_user=$this->session->user_id;
                $m_invoice->modify($service_invoice_id);


                $m_invoice_items=$this->Service_invoice_item_model;


                
                $m_invoice_items->delete_via_fk($service_invoice_id); 
                //prepare the items with multiple values for looping statement
                $service_id = $this->input->post('service_id');
                $service_qty = $this->input->post('qty');
                $service_price = $this->input->post('service_price');
                $service_line_total = $this->input->post('line_total');
                $service_unit = $this->input->post('service_unit');
                $line_total_after_global = $this->input->post('line_total_after_global');
                

                for($i=0;$i<count($service_id);$i++){
                $m_invoice_items->service_invoice_id=$service_invoice_id;
                $m_invoice_items->service_id=$this->get_numeric_value($service_id[$i]);
                $m_invoice_items->service_qty=$this->get_numeric_value($service_qty[$i]);
                $m_invoice_items->service_price=$this->get_numeric_value($service_price[$i]);
                $m_invoice_items->service_line_total=$this->get_numeric_value($service_line_total[$i]);
                $m_invoice_items->service_line_total_after_global=$this->get_numeric_value($line_total_after_global[$i]);
                $m_invoice_items->service_unit=$this->get_numeric_value($service_unit[$i]);

                $m_invoice_items->save();
                }
                $m_invoice->modify($service_invoice_id);

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Service invoice successfully updated.';
                    $response['row_updated']=$this->response_rows_invoice($service_invoice_id);

                    echo json_encode($response);
                }

                break;


           

            //***************************************************************************************
            case 'delete':

                $m_invoice=$this->Service_invoice_model;
                $service_invoice_id=$this->input->post('service_invoice_id',TRUE);

                $m_order = $this->Repair_order_model;

                $check_inv=$m_invoice->get_list($service_invoice_id);
                
                if(count($check_inv) > 0){

                    if($check_inv[0]->is_journal_posted == TRUE){

                        $response['stat']='error';
                        $response['title']='<b>Warning</b>';
                        $response['msg']='This service invoice was already posted!';
                        die(json_encode($response));

                    }

                }

                //mark Items as deleted
                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($service_invoice_id);

                $service = $m_invoice->get_list($service_invoice_id);
                $m_order->ro_status_id = FALSE;
                $m_order->modify($service[0]->repair_order_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            // ******************* Service Invoices for review in Service Journal *************************

            case 'service-for-review' :

            $m_invoice=$this->Service_invoice_model;
            $response['data']=$m_invoice->get_list(

                    array(
                        'service_invoice.is_active'=>TRUE,
                        'service_invoice.is_deleted'=>FALSE,
                        'service_invoice.is_journal_posted'=>FALSE
                    ),

                    array(
                        'service_invoice.service_invoice_id',
                        'service_invoice.service_invoice_no',
                        'service_invoice.remarks',
                        'DATE_FORMAT(service_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                        'customers.customer_name'
                    ), 
                    array(
                        array('customers','customers.customer_id=service_invoice.customer_id','left')
                    ),

                     'service_invoice.service_invoice_id DESC'

                );
            echo json_encode($response);
            break;

            
        }

    }



//**************************************user defined*************************************************


function response_rows_invoice($filter_value){
          
            return $this->Service_invoice_model->get_list(
                    $filter_value,

                    array(
                    'service_invoice.service_invoice_id',
                    'service_invoice.service_invoice_no',
                    'service_invoice.department_id',
                    'service_invoice.customer_id',
                    'service_invoice.salesperson_id',
                    'service_invoice.contact_person',
                    'service_invoice.service_invoice_no',
                    'service_invoice.address',
                    'service_invoice.remarks',
                    'service_invoice.total_overall_discount',
                    'service_invoice.is_journal_posted',
                    'DATE_FORMAT(service_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                   'DATE_FORMAT(service_invoice.date_due,"%m/%d/%Y") as date_due',
                    'customers.customer_name',
                    'departments.department_name'
)

                    ,
                    array(
                array('departments','departments.department_id=service_invoice.department_id','left'),
                array('customers','customers.customer_id=service_invoice.customer_id','left')
                        ),
                    'service_invoice.service_invoice_id DESC'


                    );


}





}
