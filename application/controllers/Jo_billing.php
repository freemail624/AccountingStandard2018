<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jo_billing extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();


        $this->load->model('Sales_order_model');
        $this->load->model('Departments_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Jo_billing_model');
        $this->load->model('Jo_billing_items_model');
        $this->load->model('Jobs_model');
        $this->load->model('Users_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Trans_model');
        $this->load->model('Tax_types_model');
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

        $data['suppliers']=$this->Suppliers_model->get_list(
            null,
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );

        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['jobs'] = $this->Jobs_model->get_list(
            array('jobs.is_active'=>TRUE,'jobs.is_deleted'=>FALSE), 
            array('jobs.*','job_unit.*'),
            array(array('job_unit','job_unit.job_unit_id=jobs.job_unit','left')));
        $data['title'] = 'Job Order Billing';
        // (in_array('13-2',$this->session->user_rights)? 
            $this->load->view('jo_billing_view', $data);
        // :redirect(base_url('dashboard')));

        
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            //******************************************* Datatable when page loads ****************************************************************
            case 'list-invoice' :
                $m_invoice = $this->Jo_billing_model;
                $response['data']= $this->response_rows_jo_billing(
                     'jo_billing.is_active=TRUE AND jo_billing.is_deleted=FALSE'.($id_filter==null?'':' AND jo_billing.jo_billing_id='.$id_filter)
                   
                    );
                echo json_encode($response);

                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items-invoice':
                $m_items=$this->Jo_billing_items_model;
                $response['data']=$m_items->get_list(
                    array('jo_billing_id'=>$id_filter),
                    array(
                        'jo_billing_items.*',
                        'jobs.job_unit',
                        'job_unit.job_unit_id',
                        'job_unit.job_unit_name'
                    ),
                    array(
                        array('jobs','jobs.job_id=jo_billing_items.job_id','left'),
                        array('job_unit','job_unit.job_unit_id=jo_billing_items.job_unit','left')
                    ),
                    'jo_billing_items.jo_billing_item_id ASC'
                );


                echo json_encode($response);

                break;


            //***************************************create new Items************************************************
            case 'create-invoice':
                $m_invoice=$this->Jo_billing_model;
                $m_invoice->set('date_created','NOW()');
                $m_invoice->supplier_id=$this->input->post('supplier',TRUE);
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


                $jo_billing_id=$m_invoice->last_insert_id();


                $m_invoice_items=$this->Jo_billing_items_model;
                //prepare the items with multiple values for looping statement
                $job_id = $this->input->post('job_id');
                $job_qty = $this->input->post('qty');
                $job_price = $this->input->post('job_price');
                $job_code = $this->input->post('job_code');
                $job_desc = $this->input->post('job_desc');
                $job_line_total = $this->input->post('line_total');
                $job_unit = $this->input->post('job_unit');
                $line_total_after_global = $this->input->post('line_total_after_global');
                

                for($i=0;$i<count($job_id);$i++){
                $m_invoice_items->jo_billing_id=$jo_billing_id;
                $m_invoice_items->job_id=$this->get_numeric_value($job_id[$i]);
                $m_invoice_items->job_qty=$this->get_numeric_value($job_qty[$i]);
                $m_invoice_items->job_code=$job_code[$i];
                $m_invoice_items->job_desc=$job_desc[$i];
                $m_invoice_items->job_price=$this->get_numeric_value($job_price[$i]);
                $m_invoice_items->job_line_total=$this->get_numeric_value($job_line_total[$i]);
                $m_invoice_items->job_line_total_after_global=$this->get_numeric_value($line_total_after_global[$i]);
                $m_invoice_items->job_unit=$this->get_numeric_value($job_unit[$i]);

                $m_invoice_items->save();
                }
                $m_invoice->jo_billing_no='JO-BILL-'.date('Ymd').'-'.$jo_billing_id;
                $m_invoice->modify($jo_billing_id);

                if($m_invoice->status()===TRUE){

                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=1; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Created Job Order Billing No: JO-BILL-'.date('Ymd').'-'.$jo_billing_id;
                    $m_trans->save();
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Job Order successfully created.';
                    $response['row_added']=$this->response_rows_jo_billing($jo_billing_id);

                    echo json_encode($response);
                }

                break;
            



            ////***************************************update Items************************************************
            case 'update-invoice':
                $m_invoice=$this->Jo_billing_model;              

                $jo_billing_id=$this->input->post('jo_billing_id',TRUE);
                $m_invoice->set('date_created','NOW()');
                $m_invoice->supplier_id=$this->input->post('supplier',TRUE);
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
                $m_invoice->modify($jo_billing_id);


                $m_invoice_items=$this->Jo_billing_items_model;


                
                $m_invoice_items->delete_via_fk($jo_billing_id); 
                $m_invoice_items=$this->Jo_billing_items_model;
                //prepare the items with multiple values for looping statement
                $job_id = $this->input->post('job_id');
                $job_qty = $this->input->post('qty');
                $job_price = $this->input->post('job_price');
                $job_code = $this->input->post('job_code');
                $job_desc = $this->input->post('job_desc');
                $job_line_total = $this->input->post('line_total');
                $job_unit = $this->input->post('job_unit');
                $line_total_after_global = $this->input->post('line_total_after_global');
                

                for($i=0;$i<count($job_id);$i++){
                $m_invoice_items->jo_billing_id=$jo_billing_id;
                $m_invoice_items->job_id=$this->get_numeric_value($job_id[$i]);
                $m_invoice_items->job_qty=$this->get_numeric_value($job_qty[$i]);
                $m_invoice_items->job_code=$job_code[$i];
                $m_invoice_items->job_desc=$job_desc[$i];
                $m_invoice_items->job_price=$this->get_numeric_value($job_price[$i]);
                $m_invoice_items->job_line_total=$this->get_numeric_value($job_line_total[$i]);
                $m_invoice_items->job_line_total_after_global=$this->get_numeric_value($line_total_after_global[$i]);
                $m_invoice_items->job_unit=$this->get_numeric_value($job_unit[$i]);

                $m_invoice_items->save();
                }
                $m_invoice->modify($jo_billing_id);

                if($m_invoice->status()===TRUE){


                    $jo_info=$m_invoice->get_list($jo_billing_id,'jo_billing_no');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=75; // TRANS TYPE
                    $m_trans->trans_log='Updated Job Order Billing No: '.$jo_info[0]->jo_billing_no;
                    $m_trans->save();

                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Job Order Billing successfully updated.';
                    $response['row_updated']=$this->response_rows_jo_billing($jo_billing_id);

                    echo json_encode($response);
                }

                break;


           

            //***************************************************************************************
            case 'delete':

                $m_invoice=$this->Jo_billing_model;
                $jo_billing_id=$this->input->post('jo_billing_id',TRUE);





                //mark Items as deleted
                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($jo_billing_id);

                $jo_info=$m_invoice->get_list($jo_billing_id,'jo_billing_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=75; // TRANS TYPE
                $m_trans->trans_log='Deleted Job Order Billing No: '.$jo_info[0]->jo_billing_no;
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            // ******************* Service Invoices for review in Service Journal *************************
            
        }

    }



//**************************************user defined*************************************************


function response_rows_jo_billing($filter_value){
          
            return $this->Jo_billing_model->get_list(
                $filter_value,
                array(
                'jo_billing.jo_billing_id',
                'jo_billing.jo_billing_no',
                'jo_billing.department_id',
                'jo_billing.supplier_id',
                'jo_billing.salesperson_id',
                'jo_billing.contact_person',
                'jo_billing.jo_billing_no',
                'jo_billing.address',
                'jo_billing.remarks',
                'jo_billing.total_overall_discount',
                'jo_billing.is_journal_posted',
                'DATE_FORMAT(jo_billing.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(jo_billing.date_due,"%m/%d/%Y") as date_due',
                'suppliers.supplier_name',
                'departments.department_name'),
                array(
                    array('departments','departments.department_id=jo_billing.department_id','left'),
                    array('suppliers','suppliers.supplier_id=jo_billing.supplier_id','left')
                    ),
                'jo_billing.jo_billing_id DESC');
}


}
