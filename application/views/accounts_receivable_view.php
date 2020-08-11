<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-arp-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--<link href="assets/dropdown-enhance/dist/css/bootstrar-select.min.css" rel="stylesheet" type="text/css">-->
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->

    <style>
        .alert {
            border-width: 0;
            border-style: solid;
            padding: 24px;
            margin-bottom: 32px;
        }
        .alert-danger, .alert-danger h1, .alert-danger h2, .alert-danger h3, .alert-danger h4, .alert-danger h5, .alert-danger h6, .alert-danger small {
            color: white;
        }

        .alert-danger {
            color: #dd191d;
            background-color: #f9bdbb;
            border-color: #e84e40;
        }

        .select2-container { 
            width: 100% !important; 
        } 

        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }
        .select2-container{
            min-width: 100%;
        }
        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }


        .custom_frame{
            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .numeric{
            text-align: right;
            width: 60%;
        }

        #btn_new {
            text-transform: capitalize !important;
        }

        .modal-body {
            text-transform: bold;
        }

        .boldlabel {
            font-weight: bold;
        }

        .inlinecustomlabel {
          
            font-weight: bold;
        }
        .form-group {
            padding-bottom: 3px;
        }

        #is_tax_exempt {
            width:23px;
            height:23px;
        }

        .modal-body {
            padding-left:0px !important;
        }

        #label {
            text-align:left;
        }

        .form-group {
            padding:0;
            margin:5px;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        textarea {
            resize: none;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
        }
        
        #tbl_accounts_receivable_filter{
            display: none;
        }
        div.dataTables_processing{ 
                position: absolute!important; 
                top: 0%!important; 
                right: -45%!important; 
                left: auto!important; 
                width: 100%!important; 
                height: 40px!important; 
                background: none!important; 
                background-color: transparent!important; 
        } 
    </style>

</head>

<body class="animated-content" style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">

<?php echo $_side_bar_navigation;?>

<div class="static-content-wrapper white-bg">
<div class="static-content"  >

<div class="page-content"><!-- #page-content -->

<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">

<div id="div_receivable_list">

    <div class="panel-group panel-default" id="accordionA">

        <div class="panel panel-default hidden" id="panel_tbl_sales_review" style="margin-top: 20px;">

            <div id="" class="">
                <div class="panel-body">
            <!-- <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo" style="text-decoration: none;"> -->
<!--                 <div class="panel-heading">
                    <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Review Sales Journal (Pending)</b>
                </div> -->
            <h2 class="h2-panel-heading">Review Sales Journal (Pending)</h2><hr>
            <!-- </a> -->
                    <div >
                    <table id="tbl_sales_review" class="table table-striped" cellspacing="0" width="100%">
                        <thead class="">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Invoice Date</th>
                            <th width="25%">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default hidden" id="panel_tbl_billing_review" style="margin-top: 20px;">
            <div id="" class="">
                <div class="panel-body">
                    <!-- <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo" style="text-decoration: none;"> -->
                    <h2 class="h2-panel-heading">Review Billing (Pending)</h2><hr>
                    <!-- </a> -->
                    <div >
                    <table id="tbl_billing_review" class="table table-striped" cellspacing="0" width="100%">
                        <thead class="">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Billing Reference No</th>
                            <th>Customer</th>
                            <th>Transaction Date</th>
                            <th width="25%">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" style="border-radius:6px;margin-top: 20px">
                <div class="panel-body" style="">
                            <!-- <a data-toggle="collapse" data-parent="#accordionA" href="#collapseOne" style="text-decoration: none;"> -->
<!--                 <div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;">
                    <b style="font-size: 11pt;color:white;"><i class="fa fa-bars"></i> Sales / AR Journal</b>
                </div> -->
                <h2 class="h2-panel-heading"> Sales / AR Journal</h2>
            <!-- </a> -->

                <div class="row">
                    <div class="col-lg-2">&nbsp;<br>
                        <button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Sales Journal" ><i class="fa fa-plus"></i> New Sales Journal</button>
                    </div>
                    <div class="col-lg-2">
                            From :<br />
                            <div class="input-group">
                                <input type="text" id="txt_start_date_ar" name="" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
                                 <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                 </span>
                            </div>
                    </div>
                    <div class="col-lg-2">
                            To :<br />
                            <div class="input-group">
                                <input type="text" id="txt_end_date_ar" name="" class="date-picker form-control" value="<?php echo date("m/t/Y"); ?>">
                                 <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                 </span>
                            </div>
                    </div>
                    <div class="col-lg-3">
                            Department :<br />
                            <select id="cbo_departments_filter" class="selectpicker show-tick form-control" data-live-search="true">
                                    <option value="0"> All Departments</option>
                                <?php foreach($departments as $department){ ?>
                                    <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                <?php } ?>
                            </select>
                    </div>
                    <div class="col-lg-3">
                            Search :<br />
                             <input type="text" id="searchbox_ar" class="form-control">
                    </div>
                </div>
                <br>
                            <div >
                    <table id="tbl_accounts_receivable" class="table table-striped" cellspacing="0" width="100%">
                        <thead class="">
                        <tr>
                            <th></th>
                            <th width="15%">Txn #</th>
                            <th>Particular</th>
                            <th width="20%">Remarks</th>
                            <th>Txn Date</th>
                            <th>Posted</th>
                            <th>Department</th>
                            <th width="5%">Status</th>
                            <th width="10%"><center>Action</center></th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </div>

                </div>
        </div>

    </div>


</div>




<div id="div_receivable_fields" style="display: none;">


    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default" style="border-top: 3px solid #2196f3; margin-top: 20px;">
                <!-- <div class="panel-heading">
                    <h2>Sales Journal</h2>
                    <div class="panel-ctrls" data-actions-container=""></div>
                </div> -->


                <div class="panel-body">
<!--                 <b><i class="fa fa-bars"></i> Sales Journal</b><hr /> -->
                <h2 class="h2-panel-heading">Sales / AR Journal</h2> <hr>


                                <form id="frm_journal" role="form" class="form-horizontal">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label> <b class="required">*</b> Customer :</label>
                                        <select id="cbo_customers" name="customer_id" class="selectpicker show-tick form-control" data-live-search="true" data-error-msg="Customer is required." required>
                                            <option value="0">[ Create New Customer ]</option>
                                            <?php foreach($customers as $customer){ ?>
                                                <option value='<?php echo $customer->customer_id; ?>' data-link_department='<?php echo $customer->link_department_id; ?>'><?php echo $customer->customer_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-offset-1  col-sm-2">
                                    <label> <b class="required">*</b> Date :</label> <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="date_txn" id="date_txn" class="date-picker form-control" data-error-msg="Date is required." required>
                                        </div>
                                    </div> 
                                    <div class="col-sm-3">
                                    <label>Txn #</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-code"></i>
                                            </span>
                                            <input type="text" name="txn_no" class="form-control" placeholder="TXN-YYYYMMDD-XXX" readonly>
                                        </div>
                                    </div>
  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label> <b class="required">*</b> Department :</label>
                                        <select id="cbo_departments" name="department_id" class="selectpicker show-tick form-control" data-live-search="true" data-error-msg="Department is required." required>
                                            <option value="0">[ Create New Department ]</option>
                                            <?php foreach($departments as $department){ ?>
                                                <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-offset-1 col-sm-5">
                                        <label> Reference # / Billing # :</label> <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-code"></i>
                                            </span>
                                            <input type="text" name="ref_no" class="form-control" >
                                        </div>
                                    </div>  
                                </div>
                                    <span><strong><i class="fa fa-bars"></i> Journal Entries</strong></span>
                                    <hr />

                                    <div style="width: 100%;">
                                        <table id="tbl_entries" class="table table-striped">
                                            <thead class="">
                                            <tr>
                                                <th style="width: 30%;">Account</th>
                                                <th style="width: 15%;">Memo</th>
                                                <th style="width: 15%;text-align: right;">Dr</th>
                                                <th style="width: 15%;text-align: right;">Cr</th>
                                                <th style="width: 15%;text-align: left;">Department</th>
                                                <th style="width: 10%;"">Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Account.">
                                                            <?php foreach($accounts as $account){ ?>
                                                                <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="memo[]" class="form-control"></td>
                                                    <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                                                    <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                                                    <td><select  name="department_id_line[]" class="dept show-tick form-control selectpicker" data-live-search="true" > 
                                                        <option value="0">[ None ]</option> 
                                                        <?php foreach($departments as $department){ ?> 
                                                            <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option> 
                                                        <?php } ?> 
                                                    </select></td> 
                                                    <td>
                                                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Account.">
                                                            <?php foreach($accounts as $account){ ?>
                                                                <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="memo[]" class="form-control"></td>
                                                    <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                                                    <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                                                    <td><select  name="department_id_line[]" class="dept show-tick form-control selectpicker" data-live-search="true" > 
                                                        <option value="0">[ None ]</option> 
                                                        <?php foreach($departments as $department){ ?> 
                                                            <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option> 
                                                        <?php } ?> 
                                                    </select></td> 
                                                    <td>
                                                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                                    </td>
                                                </tr>

                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <td colspan="2" align="right"><strong>Total</strong></td>
                                                <td align="right"><strong>0.00</strong></td>
                                                <td align="right"><strong>0.00</strong></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            </tfoot>


                                        </table>

                                    </div>


                                    <hr />
                                    <label>Remarks :</label><br />
                                    <textarea name="remarks" class="form-control col-lg-12"></textarea>

                                </form>

                                <br /><br /><hr />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save and Post</button>
                                        <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
                                    </div>
                                </div>







                </div>


                <table id="table_hidden" class="hidden">
                    <tr>
                        <td>
                            <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Account.">
                            
                                <?php foreach($accounts as $account){ ?>
                                    <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="text" name="memo[]" class="form-control"></td>
                        <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                        <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                        <td><select  name="department_id_line[]" class="dept show-tick form-control selectpicker" data-live-search="true" > 
                            <option value="0">[ None ]</option> 
                            <?php foreach($departments as $department){ ?> 
                                <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option> 
                            <?php } ?> 
                        </select></td> 
                        <td>
                            <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                            <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                        </td>
                    </tr>
                </table>



            </div>
        </div>
    </div>







</div>




</div>
</div>
</div>
</div> <!-- .container-fluid -->
</div> <!-- #page-content -->
</div>

<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV OFFICE SOLUTIONS</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer>

</div>
</div>
</div>


<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content--->
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Confirm Cancellation</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to cancel this journal?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->





<div id="modal_new_customer" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>New Customer</h4>

            </div>

            <div class="modal-body">
                <form id="frm_customer">
                    <div class="row">
                        <div class="col-md-8">
                                <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;"> Customer Name :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </span>
                                            <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" data-error-msg="Customer Name is required!" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;"> Contact Person :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </span>
                                            <input type="text" name="contact_name" class="form-control" placeholder="Contact Person" required data-error-msg="Contact Person is required.">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;">Address :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home"></i>
                                             </span>
                                             <textarea name="address" class="form-control" data-error-msg="Supplier address is required!" placeholder="Address" required ></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;"> Term :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-file-code-o"></i>
                                            </span>
                                            <input type="text" name="term" id="term" class="form-control" placeholder="Term in days">
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;"> Credit Limit :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-file-code-o"></i>
                                            </span>
                                            <input type="text" name="credit_limit" id="credit_limit" class="form-control" placeholder="Credit Limit">
                                        </div>
                                    </div>
                                </div> -->
                            
                                <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;">Email Address :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope-o"></i>
                                            </span>
                                            <input type="text" name="email_address" class="form-control" placeholder="Email Address" data-error-msg="Email Address is required." required>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;">Contact No :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                            <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="Contact No" data-error-msg="Contact No  is required." required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4" id="label">
                                         <label class="control-label boldlabel" style="text-align:right;">TIN :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-file-code-o"></i>
                                            </span>
                                            <input type="text" name="tin_no" id="tin_no" class="form-control" placeholder="TIN" data-error-msg="TIN is required." required>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-12"><br>
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;margin-bottom:0px;">Department:</label><br>
                                     <small><i>Used in Journal Entries</i> </small>
                                </div>
                                <div class="col-md-8" style="padding: 0px;">
                                <select name="link_department_id" id="cbo_link_department_id" style="width: 100%">
                                    <option value="0">None</option>
                                    <?php foreach($departments as $department){ ?>
                                        <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-12 hidden">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Business Organization :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="business_organization" id="business_organization" class="form-control" placeholder="Business Organization" data-error-msg="Business Organization is required.">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 hidden">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Office Fax Number :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="office_fax_number" id="office_fax_number" class="form-control" placeholder="Office Fax Number" data-error-msg="Office Fax Number is required." >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 hidden">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">AR Transaction :</label>
                                </div>
                                <div class="col-md-8" style="padding: 0px;">
                                <select name="ar_trans_id" id="cbo_ar_trans" style="width: 100%" data-error-msg="Type of Accounts Receivable Transaction is required." >
                                    <?php foreach($ar_trans as $ar_tran){ ?>
                                        <option value="<?php echo $ar_tran->ar_trans_id; ?>"><?php echo $ar_tran->ar_trans_name?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-12 hidden"><br>
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;" >Terms and Conditions :</label>
                                </div>
                                <div class="col-md-8" style="padding: 0px;">
                                <input type="text" name="payment_term_desc" class="form-control" data-error-msg="Payment Terms and Condition is required." >
                                </div>
                            </div>
                            <div class="col-md-12 hidden"><br>
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Customer Type :</label>
                                </div>
                                <div class="col-md-8" style="padding: 0px;">
                                <select name="customer_type_id" id="cbo_customer_type" style="width: 100%">
                                    <option value="0">None</option>
                                    <?php foreach($customer_type as $customer_type){ ?>
                                        <option value="<?php echo $customer_type->customer_type_id; ?>"><?php echo $customer_type->customer_type_name?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="control-label boldlabel" style="text-align:left;padding-top:10px;"><i class="fa fa-user" aria-hidden="true" style="padding-right:10px;"></i>Customer's Photo</label>
                                    <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                </div>
                                <div style="width:100%;height:350px;border:2px solid #34495e;border-radius:5px;">
                                    <center>
                                        <img name="img_user" id="img_user" src="assets/img/anonymous-icon.png" height="140px;" width="140px;"></img>
                                    </center>
                                    <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                    <center>
                                         <button type="button" id="btn_browse" style="width:150px;margin-bottom:5px;" class="btn btn-primary">Browse Photo</button>
                                         <button type="button" id="btn_remove_photo" style="width:150px;" class="btn btn-danger">Remove</button>
                                         <input type="file" name="file_upload[]" class="hidden">
                                    </center> 
                                </div>
                            </div>   
                        </div>
                    </div>
                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_customer" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_customer" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->

<div id="modal_new_department" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header ">

                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>New Department</h4>

            </div>

            <div class="modal-body">
                <form id="frm_department_new">
                    <div class="row">

                        <div class="col-md-12" style="padding-left: 30px;">
                            <div class="form-group">
                                <label><b class="required">*</b> Department :</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-users"></i>
                                    </span>
                                    <input type="text" name="department_name" class="form-control" placeholder="Department" data-error-msg="Department name is required." required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="padding-left: 30px;">
                            <div class="form-group">
                                <label>Department Description :</label>
                                <textarea name="department_desc" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_department" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_close_department" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->










<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
<!-- Select2-->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrar-select.min.js"></script>-->





<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>




<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>



<script>
$(document).ready(function(){
    var _txnMode; var _cboCustomers; var _cboMethods; var _selectRowObj; var _selectedID; var _txnMode;
    var dtReview; var _cboDepartments; var _selectedDepartment = 0; var _cboDepartmentFilter;
    var _cboCustomerType;
    var _cboArTrans;

    var oTBJournal={
        "dr" : "td:eq(2)",
        "cr" : "td:eq(3)"
    };

    var oTFSummary={
        "dr" : "td:eq(1)",
        "cr" : "td:eq(2)"
    };






    var initializeControls=function(){
        _cboDepartmentFilter=$("#cbo_departments_filter").select2({
            placeholder: "Please Select Default Department.",
            allowClear: false
        });

        dt=$('#tbl_accounts_receivable').DataTable({
            "dom": '<"toolbar">frtip',
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "bLengthChange":false,
            "order": [[ 9, "desc" ]],
            "ajax" : {
                "url" :  "Accounts_receivable/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "tsd":$('#txt_start_date_ar').val(),
                            "ted":$('#txt_end_date_ar').val(),
                            "dfilter": _cboDepartmentFilter.val()

                        });
                    }
            }, 
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "txn_no" },
                { targets:[2],data: "particular" },
                { targets:[3],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(40)},
                { targets:[4],data: "date_txn" },
                { targets:[5],data: "posted_by" },
                { targets:[6],data: "department_name" },
                {
                    targets:[7],data: null,
                    "orderable":      false,
                    render: function (data, type, full, meta){
                        var _attribute='';
                        //console.log(data.is_email_sent);
                        if(data.is_active=="1"){
                            _attribute=' class="fa fa-check-circle" style="color:green;" ';
                        }else{
                            _attribute=' class="fa fa-times-circle" style="color:red;" ';
                        }

                        return '<center><i '+_attribute+'></i></center>';
                    }


                },
                {
                    targets:[8],
                    "orderable":      false,
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm <?php echo ($this->session->user_group_id != 1 ? 'hidden' : '')?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_cancel='<button class="btn btn-red btn-sm" name="cancel_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Cancel Journal"><i class="fa fa-times"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_cancel+'</center>';
                    }
                },
                 { targets:[9],data: "journal_id" ,visible:false},
            ]
        });


        dtReview=$('#tbl_sales_review').DataTable({
            "bLengthChange":false,
            "ajax" : "Sales_invoice/transaction/sales-for-review",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "sales_inv_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "date_invoice" },
                { targets:[4],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(80)}
            ],
              "initComplete": function(settings, json) {
                 if(this.api().data().length != 0){
                    $('#panel_tbl_sales_review').removeClass('hidden')
                 }
              } 
        });

        dtReviewBilling=$('#tbl_billing_review').DataTable({
            "bLengthChange":false,
            "ajax" : "Billing_review/transaction/list-billing-for-review",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "ref_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "date_txn" },
                { targets:[4],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(80)}
            ],
              "initComplete": function(settings, json) {
                 if(this.api().data().length != 0){
                    $('#panel_tbl_billing_review').removeClass('hidden')
                 }
              } 
        });

        $('.numeric').autoNumeric('init');

        $('#mobile_no').keypress(validateNumber);

        $('#landline').keypress(validateNumber);

        $('#cbo_particular').select2();

        reInitializeNumeric();
        reInitializeDropDownAccounts($('#tbl_entries'),false);


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });






        _cboCustomers=$('#cbo_customers').select2({
            placeholder: "Please select customer.",
            allowClear: true
        });
        _cboCustomers.select2('val',null);


        _cboDepartments=$('#cbo_departments').select2({
            placeholder: "Please select department.",
            allowClear: true
        });
        _cboDepartments.select2('val',null);

        _cboCustomerType=$("#cbo_customer_type").select2({
            allowClear: false
        });
 


        _cboArTrans=$("#cbo_ar_trans").select2({
            placeholder: "Please select AR Transaction.",
            allowClear: false
        });

        // _cboMethods=$('#cbo_methods').select2({
        //placeholder: "Please select method of payment.",
        //allowClear: true
        //});

        //_cboMethods.select2('val',null);

        _cboLinkDepartment=$("#cbo_link_department_id").select2({ 
            placeholder: "Please Select Default Department.", 
            allowClear: false 
        }); 




    }();



    var bindEventHandlers=function(){
        var detailRows = [];
        $("#txt_start_date_ar").on("change", function () {        
            $('#tbl_accounts_receivable').DataTable().ajax.reload()
        });

        $("#txt_end_date_ar").on("change", function () {        
            $('#tbl_accounts_receivable').DataTable().ajax.reload()
        });

        _cboDepartmentFilter.on("select2:select", function (e) {
            $('#tbl_accounts_receivable').DataTable().ajax.reload()
       });

        $("#searchbox_ar").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#tbl_accounts_receivable tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/journal-ar?id="+ d.journal_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });




            }
        } );



        $('#tbl_sales_review tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dtReview.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                //console.log(row.data());
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/ar-journal-for-review?id="+ d.sales_invoice_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();

                    reInitializeSpecificDropDown($('.cbo_customer_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeNumeric();

                    var tbl=$('#tbl_entries_for_review_'+ d.sales_invoice_id);
                    var parent_tab_pane=$('#journal_review_'+ d.sales_invoice_id);

                    reInitializeDropDownAccounts(tbl,false);
                    reInitializeChildEntriesTable(tbl);
                    reInitializeChildElements(parent_tab_pane);

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }


                });




            }
        } );

        $('#tbl_billing_review tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dtReviewBilling.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                //console.log(row.data());
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/billing-journal-for-review?id="+ d.temp_journal_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();

                    reInitializeSpecificDropDown($('.cbo_customer_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeNumeric();

                    var tbl=$('#tbl_entries_for_review_billing_'+ d.temp_journal_id);
                    var parent_tab_pane=$('#journal_review_'+ d.temp_journal_id);

                    reInitializeDropDownAccounts(tbl,false);
                    reInitializeChildEntriesTable(tbl);
                    reInitializeChildElementsBilling(parent_tab_pane);

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }


                });




            }
        } );

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#div_receivable_fields'));
            reInitializeDropDownAccounts($('#tbl_entries'),true);
            _cboCustomers.select2('val',null);
            _cboDepartments.select2('val',null);
            $('#date_txn').datepicker('setDate','today');
            showList(false);
            //$('#modal_journal_entry').modal('show');
        });



        //loads modal to create new department
        // _cboDepartments.on("select2:select", function (e) {

        //     var i=$(this).select2('val');
        //     if(i==0){ //new department
        //         _cboDepartments.select2('val',null);
        //         $('#modal_new_department').modal('show');
        //     }
        // });



        //create new department
        $('#btn_create_department').click(function(){
            var btn=$(this);

            if(validateRequiredFields($('#frm_department_new'))){
                var data=$('#frm_department_new').serializeArray();

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Departments/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_new_department').modal('hide');

                    var _department=response.row_added[0];
                    $('#cbo_departments').append('<option value="'+_department.department_id+'" selected>'+_department.department_name+'</option>');
                    $('#cbo_departments').select2('val',_department.department_id);
                    clearFields($('#modal_new_department'));

                    clearFields($('#modal_new_department'));

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }


        });





        //add account button on table
        $('#tbl_entries').on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter('#tbl_entries > tbody > tr:last');

            reInitializeNumeric();
            reInitializeDropDownAccounts($('#tbl_entries'),false);
            $('#tbl_entries > tbody > tr:last select.dept').each(function(){ $(this).select2('val',_selectedDepartment)});

        });

        var _oTblEntries=$('#tbl_entries > tbody');
        _oTblEntries.on('keyup','input.numeric',function(){
            var _oRow=$(this).closest('tr');

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{

                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }


            reComputeTotals($('#tbl_entries'));
        });


        $('#tbl_accounts_receivable').on('click','button[name="cancel_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            $('#modal_confirmation').modal('show');
        });


        $('#btn_yes').click(function(){
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Accounts_receivable/transaction/cancel",
                "data":{journal_id : _selectedID},
                "success": function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }

                }
            });
        });




        $('#tbl_accounts_receivable').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;


            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            $('#cbo_customers').select2('val',data.customer_id);
            $('#cbo_departments').select2('val',data.department_id);

            $.ajax({
                url: 'Accounts_receivable/transaction/get-entries?id=' + data.journal_id,
                type: "GET",
                cache: false,
                dataType: 'html',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="4"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                }
            }).done(function(response){
                $('#tbl_entries > tbody').html(response);
                reInitializeNumeric();
                reInitializeDropDownAccounts($('#tbl_entries'),false);
                reComputeTotals($('#tbl_entries'));
            });




            showList(false);

        });

        //loads modal to create new department
        _cboDepartments.on("select2:select", function (e) {

            var i=$(this).select2('val');
            if(i==0){ //new department
                //clearFields($('#modal_new_department'));
                _cboDepartments.select2('val',null);
                $('#modal_new_department').modal('show');
            }else{
                _selectedDepartment = $(this).select2('val'); 
                $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment)}); 
            }
            
        });

        _cboCustomers.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ //new customer
                _cboCustomers.select2('val',null);
                $('#modal_new_customer').modal('show');
                $('#cbo_customer_type').select2('val', 0);

                $('#cbo_ar_trans').select2('val',null);

            }else{
                var obj_customers=$('#cbo_customers').find('option[value="' + i + '"]'); 
                _selectedDepartment = obj_customers.data('link_department'); 
                $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment)}); 
                if(_selectedDepartment == '0'){ 
                    _cboDepartments.select2('val',null); 
                }else{ 
                    _cboDepartments.select2('val',_selectedDepartment); 
                } 
            }

        });



        $('#tbl_entries').on('click','button.remove_account',function(){
            var oRow=$('#tbl_entries > tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals($('#tbl_entries'));

        });


        $('#btn_save').click(function(){
            var btn=$(this);
            var f=$('#frm_journal');
            if(isZero()){
            if(isBalance()){
            if(validateAccounts(f)){
            if(validateRequiredFields(f)){
                if(_txnMode=="new"){
                    createJournal().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row.add(response.row_added[0]).draw();
                            clearFields(f);
                            showList(true);
                        }

                    }).always(function(){
                        showSpinningProgress(btn);
                    });
                }else{
                    updateJournal().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields(f);
                            showList(true);
                        }

                    }).always(function(){
                        showSpinningProgress(btn);
                    });
                }

            }
            } else {
                showNotification({title:"Journal Entries Etries!",stat:"error",msg:'Incomplete assignment of Account Titles in the table.'});
                stat=false;
            } // ELSE OF VALIDATE ACCOUNTS
            }else{
                showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                stat=false;
            }
            }else{
                    showNotification({title:"No Amount!",stat:"error",msg:'Please make sure Debit and Credit does not amount to zero.'});
                    stat=false;
            }// END of ISZERO
        });


        $('#btn_cancel').click(function(){
            showList(true);
        });


        $('#btn_create_customer').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_customer'))){
                var data=$('#frm_customer').serializeArray();
                createCustomer().done(function(response){
                    showNotification(response);

                    //$('#btn_create_customer').attr('disabled',true);
                    if(response.stat=="success"){
                        $('#modal_new_customer').modal('hide');
                        var _customers=response.row_added[0];
                        $('#cbo_customers').append('<option value="'+_customers.customer_id+'"  data-link_department = "'+_customers.link_department_id+'" selected>'+_customers.customer_name+'</option>');

                        _cboCustomers.select2('val',_customers.customer_id);
                        clearFields($('#modal_new_customer'));
                        _selectedDepartment = _customers.link_department_id; 
                        $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment)}); 
                        _cboDepartments.select2('val',_selectedDepartment); 
                        //showList(true);
                        //$('#btn_create_customer').attr('disabled',false);
                    }

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            /*$('#div_img_product').hide();
            $('#div_img_loader').show();*/
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
            console.log(_files);
            $.ajax({
                url : 'Customers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('img[name="img_user"]').attr('src',response.path);
                }
            });
        });

        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });




    }();











    //*********************************************************************8
    //              user defines

    var createCustomer=function(){
        var _data=$('#frm_customer').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Customers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_customer'))
        });
    };

    var createJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Accounts_receivable/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))

        });
    };


    var updateJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Accounts_receivable/transaction/update?id="+_selectedID,
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };


    var showList=function(b){
        if(b){
            $('#div_receivable_list').show();
            $('#div_receivable_fields').hide();
        }else{
            $('#div_receivable_list').hide();
            $('#div_receivable_fields').show();
        }
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        //$(f).find('select').select2('val',null);


        // $(f).find('input:first').focus();
        $('#tbl_entries > tbody tr').slice(2).remove();
        $('#tbl_entries > tfoot tr').find(oTFSummary.dr).html('<b>0.00</b>');
        $('#tbl_entries > tfoot tr').find(oTFSummary.cr).html('<b>0.00</b>');
        $('#img_user').attr('src','assets/img/anonymous-icon.png');
    };

    //initialize numeric text
    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init');
    };

    function reInitializeDropDownAccounts(tbl,bClear=false){
        var obj=tbl.find('select.selectpicker');
        var objdept=tbl.find('select.dept');

        obj.select2({
            placeholder: "Please Select an Account.",
            allowClear: false
        });


        if(bClear){
            $.each(obj,function(){
                $(this).select2('val',null);
            });

            $.each(objdept,function(){
                $(this).select2('val',0);
            });
        }

    };


    function reInitializeSpecificDropDown(elem){
        elem.select2({
            placeholder: "Please select item.",
            allowClear: true
        });
    };

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode === 8 || event.keyCode === 46
            || event.keyCode === 37 || event.keyCode === 39) {
            return true;
        }
        else if ( key < 48 || key > 57 ) {
            return false;
        }
        else return true;
    };

    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };


    var reComputeTotals=function(tbl){
        var oRows=tbl.find('tbody tr');
        var _DR_amount=0.00; var _CR_amount=0.00;

        $.each(oRows,function(i,value){
            _DR_amount+=getFloat($(this).find(oTBJournal.dr).find('input.numeric').val());
            _CR_amount+=getFloat($(this).find(oTBJournal.cr).find('input.numeric').val());


        });



        tbl.find('tfoot tr').find(oTFSummary.dr).html('<b>'+accounting.formatNumber(_DR_amount,2)+'</b>');
        tbl.find('tfoot tr').find(oTFSummary.cr).html('<b>'+accounting.formatNumber(_CR_amount,2)+'</b>');

    };

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };


    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var validateAccounts=function(f){
        var stat=true;

        $('#tbl_entries > tbody tr select.selectpicker_accounts').each(function(){ 
            if($(this).select2('val') == null || $(this).select2('val') == 0){
                stat=false;
                return false;
            }
        });
        return stat;
    };

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

            if($(this).is('select')){
                if($(this).select2('val')==0||$(this).select2('val')==null){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }else{
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }
        });


        return stat;
    };

    var isZero=function(opTable=null){
        var oRow; var dr; var cr;

        if(opTable==null){
            reComputeTotals($('#tbl_entries'));
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            reComputeTotals($(opTable));
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr!=0 || cr!=0);
    };

    var isBalance=function(opTable=null){
        var oRow; var dr; var cr;

        if(opTable==null){
            reComputeTotals($('#tbl_entries'));
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            reComputeTotals($(opTable));
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr==cr);
    };

    var reInitializeChildEntriesTable=function(tbl){

        var _oTblEntries=tbl.find('tbody');
        _oTblEntries.on('keyup','input.numeric',function(){
            var _oRow=$(this).closest('tr');

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{
                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }
            reComputeTotals(tbl);
        });



        //add account button on table
        tbl.on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter(tbl.find('tbody > tr:last'));

            reInitializeNumeric();
            reInitializeDropDownAccounts(tbl,false);

        });


        tbl.on('click','button.remove_account',function(){
            var oRow=tbl.find('tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals(tbl);

        });




    };
    //***************************************************************************************************************88


    var reInitializeChildElements=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });


        parent.on('click','button[name="btn_finalize_journal_review"]',function(){

            var _curBtn=$(this);
            if(isZero('#tbl_entries_for_review_'+_dataParentID)){
            if(isBalance('#tbl_entries_for_review_'+_dataParentID)){
                finalizeJournalReview().done(function(response){

                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row.add(response.row_added[0]).draw();
                        var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                        dtReview.row(_parentRow).remove().draw();
                    }
                }).always(function(){
                    showSpinningProgress(_curBtn);
                });
            }else{
                showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                stat=false;
            }
            }else{
                    showNotification({title:"No Amount!",stat:"error",msg:'Please make sure Debit and Credit does not amount to zero.'});
                    stat=false;
            }// END of ISZERO

        });

        var finalizeJournalReview=function(){
            var _data_review=parent.find('form').serializeArray();
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Accounts_receivable/transaction/create",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };
    var reInitializeChildElementsBilling=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_billing_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });


        parent.on('click','button[name="btn_finalize_billing_journal_review"]',function(){

            var _curBtn=$(this);
            if(isZero('#tbl_entries_for_review_billing_'+_dataParentID)){
            if(isBalance('#tbl_entries_for_review_billing_'+_dataParentID)){
                finalizeJournalReview().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row.add(response.row_added[0]).draw();
                        var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                        dtReviewBilling.row(_parentRow).remove().draw();
                    }
                }).always(function(){
                    showSpinningProgress(_curBtn);
                });
            }else{
                showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                stat=false;
            }
            }else{
                    showNotification({title:"No Amount!",stat:"error",msg:'Please make sure Debit and Credit does not amount to zero.'});
                    stat=false;
            }// END of ISZERO

        });

        var finalizeJournalReview=function(){
            var _data_review=parent.find('form').serializeArray();
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Accounts_receivable/transaction/create",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };



});


</script>

</body>

</html>