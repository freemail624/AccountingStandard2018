<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_attachments extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Sales_message_model');
        $this->load->model('Sales_attachment_model');
        $this->load->model('Sales_invoice_model');

    }

    public  function index(){
        $sales_invoice_id=$this->input->get('id');

        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        //sales info
        $data['info']=$this->Sales_invoice_model->get_list(
            $sales_invoice_id,

            'sales_invoice.*,DATE_FORMAT(sales_invoice.date_created,"%M %d %Y %r")as date_created,
            CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname) as posted_by,customers.customer_name',

            array(
                array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                array('user_accounts','user_accounts.user_id=sales_invoice.posted_by_user','left')
            )
        );

        //messages
        $data['messages']=$this->Sales_message_model->get_message_list($sales_invoice_id);

        //attachments
        $data['attachments']=$this->get_attachments_list($sales_invoice_id);


        $data['title'] = 'Sales Attachment';
        $this->load->view('sales_attachment_view',$data);
    }


    function transaction($txn=null,$id_filter=null){
        switch($txn){
            case 'post-message':
                $m_message=$this->Sales_message_model;

                $sales_invoice_id=$this->input->post('sales_invoice_id',TRUE);

                $m_message->set('date_posted','NOW()');
                $m_message->sales_invoice_id=$sales_invoice_id;
                $m_message->user_id=$this->session->user_id;
                $m_message->message=$this->input->post('message',TRUE);
                $m_message->save();

                $last_msg_id=$m_message->last_insert_id();
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Your message is successfully posted.';
                $response['new_message']=$m_message->get_message_list($sales_invoice_id,$last_msg_id);
                echo json_encode($response);
                break;

            case 'list-messages':
                $m_message=$this->Sales_message_model;
                $m_files=$this->Sales_attachment_model;

                $response['sales_messages']=$m_message->get_message_list($id_filter); //filtered base on po id, 1st param is po id(optional) 2nd is msg id(optional)
                $response['sales_attachments']=$this->get_attachments_list($id_filter); //get list of attachments

                echo json_encode($response);
                break;

            case 'upload-attachments':
                $data=array();
                $files=array();
                $directory='assets/files/sales/attachments/';
                $m_files=$this->Sales_attachment_model;


                foreach($_FILES as $file){
                    $server_file_name=uniqid('');
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $file_path=$directory.$server_file_name.'.'.$extension;
                    $orig_file_name=$file['name'];

                    if(move_uploaded_file($file['tmp_name'],$file_path)){
                        //echo json_encode(array('msg'=>'success'.$extension));

                        $m_files->server_file_directory=$file_path;
                        $m_files->orig_file_name=$orig_file_name;
                        $m_files->sales_invoice_id=$this->input->get('id');
                        $m_files->added_by_user=$this->session->user_id;
                        $m_files->save();

                    }

                }


                $response['stat']="success";
                $response['msg']="File successfully uploaded.";
                //$response['file_list']=$files;
                echo json_encode($response);

                break;

            case 'delete-message':
                $m_message=$this->Sales_message_model;
                $po_message_id=$id_filter;

                $m_message->set('date_deleted','NOW()');
                $m_message->is_deleted=1;
                $m_message->modify($po_message_id);

                $response['title']="Deleted!";
                $response['stat']="success";
                $response['msg']="Your message is successfully deleted.";
                echo json_encode($response);

                break;

            case 'test':
                $m_message=$this->Sales_message_model;


                $response['sales_messages']=$m_message->get_message_list($id_filter); //filtered base on po id, 1st param is po id(optional) 2nd is msg id(optional)
                echo json_encode($response);
                break;


        }
    }




    function get_attachments_list($sales_invoice_id){
        //attachments
        return $this->Sales_attachment_model->get_list(
            array(
                'sales_attachments.sales_invoice_id'=>$sales_invoice_id,
                'sales_attachments.is_deleted'=>FALSE
            ),
            array(
                'sales_attachments.sales_attachment_id',
                'sales_attachments.sales_invoice_id',
                'sales_attachments.orig_file_name',
                'sales_attachments.server_file_directory',
                'DATE_FORMAT(sales_attachments.date_added,"%M/%d/%Y %r") as date_added',
                'CONCAT_WS(" ",ua.user_fname,ua.user_lname) as added_by'
            ),
            array(
                array('user_accounts as ua','ua.user_id=sales_attachments.added_by_user','left')
            )
        );
    }



}


