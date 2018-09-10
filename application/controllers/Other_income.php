<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Other_income extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();


        $this->load->model('Sales_order_model');
        $this->load->model('Departments_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Other_income_model');
        $this->load->model('Other_invoice_items_model');
        $this->load->model('Items_model');
        $this->load->model('Users_model');
        $this->load->model('Suppliers_model');
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

        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        $data['salespersons']=$this->Salesperson_model->get_list(
            array('salesperson.is_active'=>TRUE,'salesperson.is_deleted'=>FALSE),
            'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
        );

        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['suppliers']=$this->Suppliers_model->get_list(
            array('suppliers.is_active'=>TRUE,'suppliers.is_deleted'=>FALSE)
        );
        $data['items']=$this->Items_model->get_list(
            array('items.is_active'=>TRUE,'items.is_deleted'=>FALSE),
            'items.*,item_unit.item_unit_name',
            array(array('item_unit','item_unit.item_unit_id=items.item_unit_id','left'))
            );

        $data['title'] = 'Other Income Invoice';        
        (in_array('16-3',$this->session->user_rights)? 
        $this->load->view('other_income_view', $data)       
        :redirect(base_url('dashboard')));
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            //******************************************* Datatable when page loads ****************************************************************
            case 'list-invoice' :
                $response['data']= $this->response_rows_other_invoice(
                     'other_invoice.is_active=TRUE AND other_invoice.is_deleted=FALSE'.($id_filter==null?'':' AND other_invoice.other_invoice_id='.$id_filter)
                   
                    );
                echo json_encode($response);

                break;

            case 'list-invoice-for-review' :
                $response['data']= $this->response_rows_other_invoice(
                     'other_invoice.is_active=TRUE AND other_invoice.is_deleted=FALSE AND other_invoice.is_journal_posted = FALSE');
                echo json_encode($response);

                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items-invoice':
                $m_items=$this->Other_invoice_items_model;
                $response['data']=$m_items->get_list(
                    array('other_invoice_id'=>$id_filter),
                    array(
                        'other_invoice_items.*',
                        'item_unit.item_unit_name'
                    ),
                    array(
                        array('item_unit','item_unit.item_unit_id=other_invoice_items.item_unit_id','left')
                    ),
                    'other_invoice_items.other_invoice_item_id ASC'
                );
                echo json_encode($response);
                break;

            //***************************************create new Items************************************************
            case 'create-invoice':
                $m_invoice=$this->Other_income_model;
                $m_invoice->set('date_created','NOW()');
                $m_invoice->supplier_id=$this->input->post('supplier_id',TRUE);
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

                $other_invoice_id=$m_invoice->last_insert_id();
                $m_invoice_items=$this->Other_invoice_items_model;
                //prepare the items with multiple values for looping statement
                $item_id = $this->input->post('item_id');
                $oi_qty = $this->input->post('qty');
                $oi_price = $this->input->post('oi_price');
                $item_desc = $this->input->post('item_desc');
                $oi_line_total = $this->input->post('line_total');
                $item_unit_id = $this->input->post('item_unit_id');
                $line_total_after_global = $this->input->post('line_total_after_global');

                for($i=0;$i<count($item_id);$i++){
                    $m_invoice_items->other_invoice_id=$other_invoice_id;
                    $m_invoice_items->item_id=$this->get_numeric_value($item_id[$i]);
                    $m_invoice_items->oi_qty=$this->get_numeric_value($oi_qty[$i]);
                    $m_invoice_items->item_desc=$item_desc[$i];
                    $m_invoice_items->oi_price=$this->get_numeric_value($oi_price[$i]);
                    $m_invoice_items->oi_line_total=$this->get_numeric_value($oi_line_total[$i]);
                    $m_invoice_items->oi_line_total_after_global=$this->get_numeric_value($line_total_after_global[$i]);
                    $m_invoice_items->item_unit_id=$this->get_numeric_value($item_unit_id[$i]);
                    $m_invoice_items->save();
                }

                $m_invoice->other_invoice_no='OTH-INV-'.date('Ymd').'-'.$other_invoice_id;
                $m_invoice->modify($other_invoice_id);
                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Other Invoice successfully created.';
                    $response['row_added']=$this->response_rows_other_invoice($other_invoice_id);
                    echo json_encode($response);
                }
                break;
            


            ////***************************************update Items************************************************
            case 'update-invoice':
                $m_invoice=$this->Other_income_model;
                
                $other_invoice_id=$this->input->post('other_invoice_id',TRUE);

                $m_invoice->set('date_created','NOW()');
                $m_invoice->supplier_id=$this->input->post('supplier_id',TRUE);
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
                $m_invoice->modify($other_invoice_id);


                $m_invoice_items=$this->Other_invoice_items_model;


                
                $m_invoice_items->delete_via_fk($other_invoice_id); 
                //prepare the items with multiple values for looping statement
                $item_id = $this->input->post('item_id');
                $oi_qty = $this->input->post('qty');
                $oi_price = $this->input->post('oi_price');
                $item_desc = $this->input->post('item_desc');
                $oi_line_total = $this->input->post('line_total');
                $item_unit_id = $this->input->post('item_unit_id');
                $line_total_after_global = $this->input->post('line_total_after_global');
                

                for($i=0;$i<count($item_id);$i++){
                $m_invoice_items->other_invoice_id=$other_invoice_id;
                $m_invoice_items->item_id=$this->get_numeric_value($item_id[$i]);
                $m_invoice_items->oi_qty=$this->get_numeric_value($oi_qty[$i]);
                $m_invoice_items->item_desc=$item_desc[$i];
                $m_invoice_items->oi_price=$this->get_numeric_value($oi_price[$i]);
                $m_invoice_items->oi_line_total=$this->get_numeric_value($oi_line_total[$i]);
                $m_invoice_items->oi_line_total_after_global=$this->get_numeric_value($line_total_after_global[$i]);
                $m_invoice_items->item_unit_id=$this->get_numeric_value($item_unit_id[$i]);

                $m_invoice_items->save();
                }
                $m_invoice->modify($other_invoice_id);

                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Other Invoice successfully updated.';
                    $response['row_updated']=$this->response_rows_other_invoice($other_invoice_id);

                    echo json_encode($response);
                }

                break;


           

            //***************************************************************************************
            case 'delete':

                $m_invoice=$this->Other_income_model;
                $other_invoice_id=$this->input->post('other_invoice_id',TRUE);

                //mark Items as deleted
                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($other_invoice_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            
        }

    }



//**************************************user defined*************************************************


function response_rows_other_invoice($filter_value){
            return $this->Other_income_model->get_list(
                    $filter_value,
                    array(
                    'other_invoice.other_invoice_id',
                    'other_invoice.other_invoice_no',
                    'other_invoice.department_id',
                    'other_invoice.supplier_id',
                    'other_invoice.salesperson_id',
                    'other_invoice.contact_person',
                    'other_invoice.other_invoice_no',
                    'other_invoice.address',
                    'other_invoice.remarks',
                    'other_invoice.total_overall_discount',
                    'other_invoice.is_journal_posted',
                    'DATE_FORMAT(other_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                    'DATE_FORMAT(other_invoice.date_due,"%m/%d/%Y") as date_due',
                    'suppliers.supplier_name',
                    'departments.department_name'),
                    array(
                        array('departments','departments.department_id=other_invoice.department_id','left'),
                        array('suppliers','suppliers.supplier_id=other_invoice.supplier_id','left')
                        ),
                    'other_invoice.other_invoice_id DESC'


                    );


}





}
