<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_po_settings extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Email_po_settings_model');
        $this->load->model('Email_settings_model');
        $this->load->model('Users_model');
        $this->load->model('Company_model');
        $this->load->model('Purchases_model');
        $this->load->model('Purchase_items_model');
        $this->load->library('M_pdf');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Purchase Order Email Settings';
        $current_from=$this->Email_settings_model->get_list(3);
        $data['current_from']=$current_from[0];
        $data['current'] = $this->Email_po_settings_model->get_list();
        (in_array('6-15',$this->session->user_rights)? 
        $this->load->view('email_po_settings_view', $data)
        :redirect(base_url('dashboard')));
    }

    function transaction($txn = null, $filter_value = null) {

        switch($txn){

            case 'update':
            $m_settings =$this->Email_po_settings_model;
            $this->db->truncate('po_email_settings');
                $name=$this->input->post('name',TRUE);
                $email=$this->input->post('email',TRUE);

                for($i=0;$i<count($name);$i++){
                    $m_settings->po_email_name = $name[$i];
                    $m_settings->po_email_address = $email[$i];
                    $m_settings->save();
                }

                $m_email=$this->Email_settings_model;
                $m_email->delete(3);
                $enable=$this->input->post('enable_email_sending');
                if($enable == 0){
                $m_email->enable_email_sending = FALSE;
                }else {
                $m_email->enable_email_sending = TRUE;
                }

                $enable_update=$this->input->post('enable_email_sending_update');
                if($enable_update == 0){
                $m_email->enable_email_sending_update = FALSE;
                }else {
                $m_email->enable_email_sending_update = TRUE;
                }
                $m_email->email_id=3;
                $m_email->email_address=$this->input->post('email_address',TRUE);
                $m_email->email_abbrev=$this->input->post('email_abbrev',TRUE);
                $m_email->email_website=$this->input->post('email_website',TRUE);
                $m_email->password=$this->input->post('password',TRUE);
                $m_email->name_from=$this->input->post('name_from',TRUE);
                $m_email->default_message=$this->input->post('default_message',TRUE);
                $m_email->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Settings successfully saved.';
                echo json_encode($response);

                break;
                case 'send-email': //called after creating PO
                    $m_email=$this->Email_settings_model;
                    $email=$m_email->get_list(3);

                    if($email[0]->enable_email_sending == FALSE){
                        exit();
                    }
                    $m_po_settings = $this->Email_po_settings_model;
                    $po_settings = $m_po_settings->get_list();

                    $set = []; foreach ($po_settings as $po) { $set[]=$po->po_email_address; }
                    $sent_names = []; foreach ($po_settings as $po) { $sent_names[]=$po->po_email_name; }
                    $names_to =  implode(", ", $sent_names);

                        $m_purchases=$this->Purchases_model;
                        $m_po_items=$this->Purchase_items_model;
                        $m_company=$this->Company_model;

                        $info=$m_purchases->get_list(
                                $filter_value,
                                'purchase_order.*,CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)as term_description,suppliers.supplier_name,suppliers.address,suppliers.email_address,suppliers.contact_no',
                                array(
                                    array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left')
                                )
                            );
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
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = $set;
                            $subject = ''.$email[0]->email_abbrev.' Purchase Order for Approval: '.$info[0]->po_no;
                          //  $message = 'Type your gmail message here';
                            $message = $email[0]->default_message.'<br>
                            <a href="'.$email[0]->email_website.'" style="align-items: center;border: none;display: inline-flex;justify-content: center;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size: .875rem;letter-spacing: .25px;padding: 6px 5px 6px 5px;color: #1a73e8;font-weight: 500;background-color:white;border: 1px solid #dadada;border-radius: 11px;">Go To Website</a><br>
                             <i>This email was sent to '.$names_to.'</i>'  ;
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
                            $response['msg']='Please check the Email Address or your Internet Connection.';

                            echo json_encode($response);
                            } else {

 
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';
                            echo json_encode($response);
                        
                        }
                    break;


                case 'send-email-update': //called after creating PO
                    $m_email=$this->Email_settings_model;
                    $email=$m_email->get_list(3);

                    if($email[0]->enable_email_sending_update == FALSE){
                        exit();
                    }
                    $m_po_settings = $this->Email_po_settings_model;
                    $po_settings = $m_po_settings->get_list();

                    $set = []; foreach ($po_settings as $po) { $set[]=$po->po_email_address; }
                    $sent_names = []; foreach ($po_settings as $po) { $sent_names[]=$po->po_email_name; }
                    $names_to =  implode(", ", $sent_names);

                        $m_purchases=$this->Purchases_model;
                        $m_po_items=$this->Purchase_items_model;
                        $m_company=$this->Company_model;

                        $info=$m_purchases->get_list(
                                $filter_value,
                                'purchase_order.*,CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)as term_description,suppliers.supplier_name,suppliers.address,suppliers.email_address,suppliers.contact_no',
                                array(
                                    array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left')
                                )
                            );
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
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = $set;
                            $subject = ''.$email[0]->email_abbrev.' Purchase Order for Approval: '.$info[0]->po_no;
                          //  $message = 'Type your gmail message here';
                            $message = 'A Purchase order has been updated. Please review it below.<br>
                            <a href="'.$email[0]->email_website.'" style="align-items: center;border: none;display: inline-flex;justify-content: center;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size: .875rem;letter-spacing: .25px;padding: 6px 5px 6px 5px;color: #1a73e8;font-weight: 500;background-color:white;border: 1px solid #dadada;border-radius: 11px;">Go To Website</a><br>
                             <i>This email was sent to '.$names_to.'</i>'  ;
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
                            $response['msg']='Please check the Email Address or your Internet Connection.';

                            echo json_encode($response);
                            } else {

 
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';
                            echo json_encode($response);
                        
                        }
                    break;

        }


    }
}
