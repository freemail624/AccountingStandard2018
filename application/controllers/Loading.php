<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loading extends CORE_Controller
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
        $this->load->model('Account_integration_model');
        $this->load->model('Loading_model');
        $this->load->model('Loading_item_model');
        $this->load->model('Agent_model');


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

        $data['agents']=$this->Agent_model->get_list(array('is_deleted'=>FALSE));
        $data['accounts']=$this->Account_integration_model->get_list(1);
        $data['loadings']=$this->Loading_model->get_list(array("is_deleted"=>FALSE));

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

        $data['invoice_counter']=$this->Invoice_counter_model->get_list(array('user_id'=>$this->session->user_id));
        $data['order_sources'] = $this->Order_source_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));

        $data['title'] = 'Loading Report';
        
        (in_array('3-8',$this->session->user_rights)? 
        $this->load->view('loading_report_view', $data)
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_loading=$this->Loading_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $response['data']=$m_loading->get_loading(null,$tsd,$ted);
                echo json_encode($response);
                break;

            case 'items': 
                $m_items=$this->Loading_item_model;
                $response['data']=$m_items->get_list(
                    array('loading_id'=>$id_filter),
                    array(
                        'loading_items.*',
                        'customers.customer_name',
                        'sales_invoice.sales_inv_no',
                        'sales_invoice.is_journal_posted'
                    ),
                    array(
                        array('customers','customers.customer_id=loading_items.customer_id','left'),
                        array('sales_invoice','sales_invoice.sales_invoice_id=loading_items.invoice_id','left')                    
                    ),
                    'loading_items.loading_item_id ASC'
                );

                echo json_encode($response);
                break;

            case 'check-invoices-posted':
                $m_loading=$this->Loading_model;
                $loading_id = $this->input->get('id');
                $response['data']=$m_loading->check_invoices($loading_id);
                echo json_encode($response);
                break;

            //***************************************create new Items************************************************

            
            case 'create':
                $m_sales_invoice=$this->Sales_invoice_model;
                $m_loading=$this->Loading_model;
                $m_loading_items=$this->Loading_item_model;

                $m_loading->begin();

                $is_switch = $this->input->post('is_switch',TRUE);
                $agent_id = $this->input->post('agent_id',TRUE);
                $transfer_id = $this->input->post('transfer_id',TRUE);
                $loading_date =date('Y-m-d',strtotime($this->input->post('loading_date',TRUE)));

                //treat NOW() as function and not string
                $m_loading->set('date_created','NOW()'); //treat NOW() as function and not string
                $m_loading->agent_id=$agent_id;
                $m_loading->loading_place=$this->input->post('loading_place',TRUE);
                $m_loading->driver_name=$this->input->post('driver_name',TRUE);
                $m_loading->driver_pahinante=$this->input->post('driver_pahinante',TRUE);
                $m_loading->loading_date=date('Y-m-d',strtotime($this->input->post('loading_date',TRUE)));
                // $m_loading->total_amount=$this->get_numeric_value($this->input->post('grand_total_amount',TRUE));
                // $m_loading->total_inv_qty=$this->get_numeric_value($this->input->post('grand_total_inv_qty',TRUE));
                $m_loading->allowance_amount=$this->get_numeric_value($this->input->post('allowance_amount',TRUE));
                $m_loading->remarks = $this->input->post('remarks',TRUE);
                $m_loading->posted_by_user=$this->session->user_id;
                $m_loading->save();

                $loading_id=$m_loading->last_insert_id();

                $invoice_id=$this->input->post('invoice_id',TRUE);
                $customer_id=$this->input->post('customer_id',TRUE);
                $address=$this->input->post('address',TRUE);
                $total_after_discount=$this->input->post('total_after_discount',TRUE);
                $total_inv_qty=$this->input->post('total_inv_qty',TRUE);
            
                if($is_switch == 1){
                    // Update 1st Truck
                    $truck = $this->Sales_invoice_model->get_open_sales_invoice_list($agent_id,$loading_date,1);

                    for ($a=0; $a < count($truck); $a++) { 
                        $m_sales_invoice->agent_id = $transfer_id;
                        $m_sales_invoice->modify($truck[$a]->sales_invoice_id);
                    }
                }

                for($i=0;$i<count($invoice_id);$i++){

                    // For Transfer of product to other loading report
                    $loading = $m_loading->check_invoice_loading($this->get_numeric_value($invoice_id[$i]));
                    if(count($loading) > 0){
                        // Delete loading item in Loading
                        $m_loading_items->delete_via_pk($loading[0]->loading_item_id);
                    }

                    $m_loading_items->invoice_id=$this->get_numeric_value($invoice_id[$i]);
                    $m_loading_items->loading_id=$loading_id;
                    $m_loading_items->invoice_type_id=1; // Sales Invoice Type
                    $m_loading_items->customer_id=$this->get_numeric_value($customer_id[$i]);
                    $m_loading_items->address=$address[$i];
                    $m_loading_items->total_after_discount=$this->get_numeric_value($total_after_discount[$i]);
                    $m_loading_items->total_inv_qty=$this->get_numeric_value($total_inv_qty[$i]);
                    $m_loading_items->save();

                    // Update truck on sales invoice
                    $m_sales_invoice->agent_id = $agent_id;
                    $m_sales_invoice->modify($this->get_numeric_value($invoice_id[$i]));                    

                }

                //update loading number base on formatted last insert id
                $m_loading->loading_no='LOADING-'.date('Ymd').'-'.$loading_id;
                $m_loading->modify($loading_id);

                //******************************************************************************************
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=69; // TRANS TYPE
                $m_trans->trans_log='Created Loading Report No: LOADING-'.date('Ymd').'-'.$loading_id;
                $m_trans->save();

                $m_loading->commit();

                if($m_loading->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Loading Report successfully created.';
                    $response['row_added']=$m_loading->get_loading($loading_id);
                    echo json_encode($response);
                }

                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_sales_invoice=$this->Sales_invoice_model;
                $m_loading=$this->Loading_model;
                $m_loading_items=$this->Loading_item_model;

                $loading_id=$this->input->post('loading_id',TRUE); 

                $m_loading->begin();
                $agent_id = $this->input->post('agent_id',TRUE);
                //treat NOW() as function and not string
                $m_loading->set('date_modified','NOW()'); //treat NOW() as function and not string
                $m_loading->agent_id=$agent_id;
                $m_loading->loading_place=$this->input->post('loading_place',TRUE);
                $m_loading->driver_name=$this->input->post('driver_name',TRUE);
                $m_loading->driver_pahinante=$this->input->post('driver_pahinante',TRUE);
                $m_loading->loading_date=date('Y-m-d',strtotime($this->input->post('loading_date',TRUE)));
                // $m_loading->total_amount=$this->get_numeric_value($this->input->post('grand_total_amount',TRUE));
                // $m_loading->total_inv_qty=$this->get_numeric_value($this->input->post('grand_total_inv_qty',TRUE));
                $m_loading->allowance_amount=$this->get_numeric_value($this->input->post('allowance_amount',TRUE));
                $m_loading->remarks = $this->input->post('remarks',TRUE);
                $m_loading->modified_by_user=$this->session->user_id;
                $m_loading->modify($loading_id);

                $invoice_id=$this->input->post('invoice_id',TRUE);
                $customer_id=$this->input->post('customer_id',TRUE);
                $address=$this->input->post('address',TRUE);
                $total_after_discount=$this->input->post('total_after_discount',TRUE);
                $total_inv_qty=$this->input->post('total_inv_qty',TRUE);
            
                $m_loading_items->delete_via_fk($loading_id); //delete previous items then insert those new

                for($i=0;$i<count($invoice_id);$i++){
                    
                    // For Transfer of product to other loading report
                    $loading = $m_loading->check_invoice_loading($this->get_numeric_value($invoice_id[$i]));
                    if(count($loading) > 0){
                        $m_loading_items->delete_via_pk($loading[0]->loading_item_id);
                    }

                    $m_loading_items->invoice_id=$this->get_numeric_value($invoice_id[$i]);
                    $m_loading_items->loading_id=$loading_id;
                    $m_loading_items->invoice_type_id=1; // Sales Invoice Type
                    $m_loading_items->customer_id=$this->get_numeric_value($customer_id[$i]);
                    $m_loading_items->address=$address[$i];
                    $m_loading_items->total_after_discount=$this->get_numeric_value($total_after_discount[$i]);
                    $m_loading_items->total_inv_qty=$this->get_numeric_value($total_inv_qty[$i]);
                    $m_loading_items->save();

                    // Update truck on sales invoice
                    $m_sales_invoice->agent_id = $agent_id;
                    $m_sales_invoice->modify($this->get_numeric_value($invoice_id[$i])); 
                }

                //******************************************************************************************
                $loading=$m_loading->get_list($loading_id,'loading_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=69; // TRANS TYPE
                $m_trans->trans_log='Updated Loading Report No: '.$loading[0]->loading_no;
                $m_trans->save();

                $m_loading->commit();

                if($m_loading->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Loading Report successfully updated.';
                    $response['row_updated']=$m_loading->get_loading($loading_id);
                    echo json_encode($response);
                }

                break;


            //***************************************************************************************
            case 'delete':
                $m_loading=$this->Loading_model;
                $loading_id=$this->input->post('loading_id',TRUE);

                $m_loading->begin();

                //mark Items as deleted
                $m_loading->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_loading->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_loading->is_deleted=1;//mark as deleted
                $m_loading->modify($loading_id);

                $loading=$m_loading->get_list($loading_id,'loading_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=69; // TRANS TYPE
                $m_trans->trans_log='Deleted Loading No: '.$loading[0]->loading_no;
                $m_trans->save();

                $m_loading->commit();
            
                if($m_loading->status()===TRUE){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Record successfully deleted.';
                }else{
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Record does not successfully deleted.';
                }

                echo json_encode($response);

                break;

        }

    }

}
