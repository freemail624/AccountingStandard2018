<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-crjp-capable" content="yes">
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
            z-index: 4000;
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
            text-transform: uppercase !important;
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

        .select2-container { 
            width: 100% !important; 
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
        #tbl_billing_payment_for_review_filter{display: none;}
        #tbl_cash_invoice_for_review_filter{display: none;}
        #tbl_collection_for_review_filter{display: none;}


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

<div id="div_payable_list">

    <div class="panel-group panel-default" id="accordionA">

        <div class="panel panel-default hidden" style="border-radius:6px;margin-top: 20px;" id="panel_tbl_collection_for_review">

            <div id="collapseTwo" class="collapse in">
                <div class="panel-body">    
                    <h2 class="h2-panel-heading">Review Collection (Pending)</h2><hr>
                    <div >
                        <div style="margin-bottom: 10px;">
                        <input type="text" class="form-control" id="tbl_collection_for_review_searchbox" placeholder="Search Collections">
                        </div>
                        <table id="tbl_collection_for_review" class="table table-striped" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th></th>
                                <th>Receipt #</th>
                                <th>Customer</th>
                                <th width="20%">Remarks</th>
                                <th>Payment</th>
                                <th>Notice</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
        <div class="panel panel-default hidden" style="border-radius:6px;margin-top: 20px;" id="panel_tbl_cash_invoice_for_review">
            <div id="collapseOne" class="collapse in">
                <div class="panel-body" style="">
                <h2 class="h2-panel-heading">Cash Invoice (Pending)</h2><hr>
                    <div >
                        <div style="margin-bottom: 10px;">
                        <input type="text" class="form-control" id="tbl_cash_invoice_for_review_searchbox" placeholder="Search Cash Invoices">
                        </div>
                        <table id="tbl_cash_invoice_for_review" class="table table-striped" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th></th>
                                <th>Cash Invoice No: #</th>
                                <th>Customer Name</th>
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
                <div class="panel-body table-responsive">
                    <h2 class="h2-panel-heading">Review Customer Advances (Billing)</h2><hr>
                    <div class="row-panel">
                        <table id="tbl_billing_review" class="table table-striped" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th width="5%"></th>
                                <th width="10%">Reference No</th>
                                <th width="30%">Customer Name</th>
                                <th width="15%">Transaction Date</th>
                                <th width="40%">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>



        <div class="panel panel-default hidden" style="border-radius:6px;margin-top: 20px;" id="panel_tbl_billing_payment_for_review">
            <div id="collapseOne" class="collapse in">
                <div class="panel-body" style="">
                <h2 class="h2-panel-heading">Billing Payment (Pending)</h2><hr>
                    <div >
                        <div style="margin-bottom: 10px;">
                        <input type="text" class="form-control" id="tbl_billing_payment_for_review_searchbox" placeholder="Search Billing Payments">
                        </div>
                        <table id="tbl_billing_payment_for_review" class="table table-striped" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th width="5%">&nbsp;</th>
                                <th width="15%">Billing Ref No</th>
                                <th width="25%">Customer</th>
                                <th>Transaction Date</th>
                                <th>Notice</th>
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
        <div class="panel panel-default" style="border-radius:6px;margin-top: 20px;">
            <div id="collapseOne" class="collapse in">
                <div class="panel-body" style="">
                <h2 class="h2-panel-heading">Cash Receipt Journal (History)</h2><hr>

                <div class="row">
                    <div class="col-lg-2">&nbsp;<br>
                        <button class="btn btn-primary"  id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Cash Receipt Journal" ><i class="fa fa-plus"></i> New Journal</button>
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
                </div><br>
                    <div >
                        <table id="tbl_accounts_receivable" class="table table-striped" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th></th>
                                <th width="15%">Transaction #</th>
                                <th>Particular</th>
                                <th width="15%">Remarks</th>
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
<br>





    </div>


</div>




<div id="div_payable_fields" style="display: none;">


<div class="row">
<div class="col-sm-12">
    <div class="panel panel-default" style="margin-top:20px;">


            <div class="panel-body" style="min-height: 400px;">
            <h2 class="h2-panel-heading">Cash Receipt Journal</h2><hr />
                <div>


                    <form id="frm_journal" role="form" class="form-horizontal">

                        <div class="row">
                            <div class="col-lg-3">
                                <label> Txn #  :</label><br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-code"></i>
                                    </span>
                                    <input type="text" name="txn_no" class="form-control" placeholder="TXN-YYYYMMDD-XXX" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <b class="required">*</b><label> Date  :</label><br />
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                    <input type="text" name="date_txn" id="date_txn" class="date-picker form-control" data-error-msg="Date is required." required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-lg-offset-2">
                                <b class="required">*</b> <label>Method of Payment  :</label><br />
                                <select id="cbo_payment_method" name="payment_method" class="form-control" data-error-msg="Payment method is required." required>
                                    <?php foreach($methods as $payment_method){ ?>
                                        <option value='<?php echo $payment_method->payment_method_id; ?>'><?php echo $payment_method->payment_method; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-6">
                        <b class="required">*</b> <label>Particular  :</label><br />
                            <select id="cbo_particulars" name="particular_id" class="selectpicker show-tick form-control" data-live-search="true" data-error-msg="Particular is required." required>

                                <optgroup label="Customers">
                                    <option value="create_customer">[Create New Customer]</option>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value='C-<?php echo $customer->customer_id; ?>' data-link_department='<?php echo $customer->link_department_id; ?>'><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </optgroup>

                                <optgroup label="Suppliers">
                                    <option value="create_supplier">[Create New Supplier]</option>
                                    <?php foreach($suppliers as $supplier){ ?>
                                        <option value='S-<?php echo $supplier->supplier_id; ?>' data-link_department='0'><?php echo $supplier->supplier_name; ?></option>
                                    <?php } ?>
                                </optgroup>

                            </select>
                        </div>

                            <div class="col-lg-2 col-lg-offset-2">
                               <label> OR # :</label><br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-code"></i>
                                    </span>
                                    <input type="text" name="or_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label>Check # :</label><br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-code"></i>
                                    </span>
                                    <input type="text" name="check_no" id="check_no" class="form-control" data-error-msg="Check no. is required">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <b class="required">*</b> <label> Department :</label><br />

                                <select id="cbo_departments" name="department_id" class="selectpicker show-tick form-control" data-live-search="true" required="" data-error-msg="Department is required">
                                    <?php foreach($departments as $department){ ?>
                                        <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-lg-offset-2">
                                <label>Check Date :</label><br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" name="check_date" id="check_date" class="date-picker form-control" data-error-msg="Check date is required" value="<?php echo date("m/d/Y"); ?>">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <b class="required">*</b> <label>Amount :</label><br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-code"></i>
                                    </span>
                                    <input type="text" name="amount" class="form-control numeric" required data-error-msg="Amount is required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <b class="required">*</b> <label>Check Type : </label><br />
                                    <select name="check_type_id"  id="cbo_check_types"  data-error-msg="Check Type is required.">
                                        <option value="0">None </option>
                                        <?php foreach($check_types as $check_type){ ?>
                                            <option value='<?php echo $check_type->check_type_id; ?>'><?php echo $check_type->check_type_desc; ?> (<?php echo $check_type->account_title; ?>)</option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-sm-4 col-sm-offset-4 hidden">BIR 2307
                                <br>
                                <span id="file_2307_value">No File.</span><br>
                                 <button type="button" id="btn_browse_bir2307" style="width:150px;" class="btn btn-primary">Browse File</button>
                                 <button type="button" id="btn_remove_bir2307" style="width:150px;" class="btn btn-danger">Remove</button>
                                 <input type="file" name="file_2307" class="hidden">
                            </div>
                        </div>




                        <br /><br />
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
                                    <th style="width: 10%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                                            <?php foreach($accounts as $account){ ?>
                                                <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="memo[]" class="form-control"></td>
                                    <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                                    <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                                    <td>       
                                        <select name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
                                            <option value="0">[ None ]</option>
                                            <?php foreach($departments as $department){ ?>
                                                <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                                            <?php foreach($accounts as $account){ ?>
                                                <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="memo[]" class="form-control"></td>
                                    <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                                    <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                                    <td>       
                                        <select name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
                                            <option value="0">[ None ]</option>
                                            <?php foreach($departments as $department){ ?>
                                                <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
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






        <table id="table_hidden" class="hidden">
            <tr>
                <td>
                    <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                        <?php foreach($accounts as $account){ ?>
                            <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="text" name="memo[]" class="form-control"></td>
                <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                <td>       
                    <select name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
                        <option value="0">[ None ]</option>
                        <?php foreach($departments as $department){ ?>
                            <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                        <?php } ?>
                    </select>
                </td>
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
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-crjrow-up"></i></button>
    </div>
</footer>

</div>
</div>
</div>



    <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
        <div class="modal-dialog modal-sm">
            <div class="modal-content"><!---content-->
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
            </div><!---content-->
        </div>
    </div><!---modal-->

    <div id="modal_confirmation_advances" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
        <div class="modal-dialog modal-sm">
            <div class="modal-content"><!---content-->
                <div class="modal-header ">
                    <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Confirm Cancellation</h4>

                </div>

                <div class="modal-body">
                    <p id="modal-body-message">Are you sure you want to cancel this journal?</p>
                </div>

                <div class="modal-footer">
                    <button id="btn_yes_cancel_advance" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                    <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
                </div>
            </div><!---content-->
        </div>
    </div><!---modal-->    

            <div id="modal_create_suppliers" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"><!--modal-->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>New Supplier Information</h4>
                        </div>

                        <div class="modal-body">
                            <form id="frm_supplier">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b class="required">*</b></font> Company Name :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-users"></i>
                                                    </span>
                                                    <input type="text" name="supplier_name" class="form-control" placeholder="Supplier Name" data-error-msg="Supplier Name is required!" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b class="required">*</b></font> Contact Person :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-users"></i>
                                                    </span>
                                                    <input type="text" name="contact_name" class="form-control" placeholder="Contact Person" data-error-msg="Contact Person is required!" required>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b class="required">*</b></font> Address :</label>
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
                                    
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;">Email Address :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-envelope-o"></i>
                                                    </span>
                                                    <input type="text" name="email_address" class="form-control" placeholder="Email Address">
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
                                                        <i class="fa fa-mobile"></i>
                                                    </span>
                                                    <input type="text" name="contact_no" class="form-control" placeholder="Contact No">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;">TIN # :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-code"></i>
                                                    </span>
                                                    <input type="text" name="tin_no" class="form-control" placeholder="TIN #">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;">Tax Output % :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-code"></i>
                                                    </span>
                                                    <input type="text" name="tax_output" class="form-control" placeholder="Input Percentage Number Only"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b class="required">*</b></font> Tax :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-code"></i>
                                                    </span>
                                                    <select name="tax_type_id" id="cbo_tax_type" data-error-msg="Tax type is required!" required="">
                                                        <option value="">Please select tax type...</option>
                                                        <?php foreach($tax_types as $tax_type){ ?>
                                                            <option value="<?php echo $tax_type->tax_type_id; ?>" data-tax-rate="<?php echo $tax_type->tax_rate; ?>"><?php echo $tax_type->tax_type; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <label class="control-label boldlabel" style="text-align:left;padding-top:10px;"><i class="fa fa-user" aria-hidden="true" style="padding-right:10px;"></i>Supplier's Photo</label>
                                                <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                            </div>
                                            <div style="width:100%;height:350px;border:2px solid #34495e;border-radius:5px;">
                                                <center>
                                                    <img name="img_supplier" id="img_user" src="assets/img/anonymous-icon.png" height="140px;" width="140px;"></img>
                                                </center>
                                                <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                                <center>
                                                     <button type="button" id="btn_browse_supplier_photo" style="width:150px;margin-bottom:5px;" class="btn btn-primary">Browse Photo</button>
                                                     <button type="button" id="btn_remove_photo_supplier" style="width:150px;" class="btn btn-danger">Remove</button>
                                                     <input type="file" name="file_supplier[]" class="hidden">
                                                </center> 
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_save_supplier" type="button" class="btn btn-primary" style="background-color:#2ecc71;color:white;"><span class=""></span> Save</button>
                            <button id="btn_cancel_supplier" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div><!---content---->
                </div>
            </div><!---modal-->

            <div id="modal_create_customer" class="modal fade" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false"><!--modal-->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>New Customer Information</h4>
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
                                                    <input type="text" name="contact_no" class="form-control" placeholder="Contact No" data-error-msg="Contact No  is required." required>
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
                                                    <img name="img_customer" id="img_user" src="assets/img/anonymous-icon.png" height="140px;" width="140px;"></img>
                                                </center>
                                                <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                                <center>
                                                     <button type="button" id="btn_browse_customer_photo" style="width:150px;margin-bottom:5px;" class="btn btn-primary">Browse Photo</button>
                                                     <button type="button" id="btn_remove_photo_customer" style="width:150px;" class="btn btn-danger">Remove</button>
                                                     <input type="file" name="file_upload[]" class="hidden">
                                                </center> 
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_save_customer" type="button" class="btn" style="background-color:#2ecc71;color:white;"><span class=""></span> Save</button>
                            <button id="btn_cancel_customer" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div><!---content-->
                </div>
            </div>






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
    var _txnMode; var _cboParticulars; var _cboMethods; var _selectRowObj; var _selectedID; var _txnMode;
    var dtReview; var _cbo_paymentMethod; var _cbo_departments; var dt; var _cbo_check_types; var _cbo_accounttype;
    var _cboCustomerType;  var _cboTaxGroup; var _selectedDepartment = 0; var _cboDepartmentFilter;
    var _cboArTrans; var dtReviewAdvances; var _selectedParentRow;

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
            "bLengthChange":false,
            "order": [[ 9, "desc" ]],
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Cash_receipt/transaction/list",
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
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm <?php echo ($this->session->user_group_id != 1 ? 'hidden' : '')?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="cancel_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Cancel Journal"><i class="fa fa-times"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        // return '<center>'+btn_trash+'</center>';
                    }
                },
                { targets:[9],data: "journal_id", visible:false },

            ]
        });


        dtReviewAdvances=$('#tbl_billing_review').DataTable({
            "bLengthChange":false,
            "ajax" : "Billing_review/transaction/list-billing-advances-for-review",
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
                { targets:[4],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(50)}
            ],
            "initComplete": function(settings, json) {
                 if(this.api().data().length != 0){
                    $('#panel_tbl_billing_review').removeClass('hidden')
                 }
              } 
        });

        dtReview=$('#tbl_collection_for_review').DataTable({
            "bLengthChange":false,
            "ajax" : "Receivable_payments/transaction/collection-for-review",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "receipt_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(60) },
                { targets:[4],data: "date_paid" },
                {
                    targets:[5],
                    data: "rem_day_for_due",
                    render: function (data, type, full, meta){
                        if(full.payment_method_id==2&&data>0){ //if check and remaining day before due is greater than 0
                            return "<span style='color: red'><b><i class='fa fa-times-circle'></i> "+data+"</b> day(s) before Check is due.</span>";
                        }else{
                            return "";
                        }
                    }
                },
                { targets:[6],data: "total_paid_amount" }
            ],
              "initComplete": function(settings, json) {
                 if(this.api().data().length != 0){
                    $('#panel_tbl_collection_for_review').removeClass('hidden')
                    dtReview.columns.adjust().draw();
                 }
              } 
        });





        dtReviewCash=$('#tbl_cash_invoice_for_review').DataTable({
            "bLengthChange":false,
            "ajax" : "Cash_invoice/transaction/cash-for-review",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "cash_inv_no" },
                { targets:[2],data: "customer_name" },
                { targets:[4],data: "date_invoice" },
                { targets:[3],data: "remarks",render: $.fn.dataTable.render.ellipsis(80) }
            ],
              "initComplete": function(settings, json) {
                 if(this.api().data().length != 0){
                    $('#panel_tbl_cash_invoice_for_review').removeClass('hidden')
                    dtReviewCash.columns.adjust().draw();
                 }
              }            
        });

        dtReviewBilling=$('#tbl_billing_payment_for_review').DataTable({
            "bLengthChange":false,
            "ajax" : "Billing_review/transaction/list-billing-payment-for-review",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "transaction_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "date_txn" },
                {                targets:[4],   data: "rem_day_for_due",
                    render: function (data, type, full, meta){
                        if(data>0){ //if check and remaining day before due is greater than 0
                            return "<span style='color: red'><b><i class='fa fa-times-circle'></i> "+data+"</b> day(s) before Check is due.</span>";
                        }else{
                            return "";
                        }
                    } },
                { targets:[5],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(80)}
            ],
              "initComplete": function(settings, json) {
                 if(this.api().data().length != 0){
                    $('#panel_tbl_billing_payment_for_review').removeClass('hidden')
                    dtReviewBilling.columns.adjust().draw();
                 }
              } 
        });

        $('#mobile_no').keypress(validateNumber);

        $('#landline').keypress(validateNumber);

        $('#cbo_particular').select2();
        $('#cbo_check_types').select2();
        reInitializeNumeric();
        reInitializeDropDownAccounts($('#tbl_entries'),false);


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });



        _cboTaxGroup=$('#cbo_tax_type').select2({
            allowClear: false
        });

        _cboTaxGroup.select2({
            dropdownParent: $('#modal_create_suppliers')
        });

        _cboParticulars=$('#cbo_particulars').select2({
            placeholder: "Please select a Particular.",
            allowClear: true
        });
        _cboParticulars.select2('val',null);

        _cbo_paymentMethod = $('#cbo_payment_method').select2({
            placeholder: "Please select Payment Method.",
            allowClear: true
        });
        _cbo_paymentMethod.select2('val',null);

        _cbo_departments = $('#cbo_departments').select2({
            placeholder: "Please select Department.",
            allowClear: true
        });
        _cbo_departments.select2('val',null);

        _cbo_check_types=$('#cbo_check_types').select2({
            placeholder: "Please select a Check Type.",
            allowClear: false
        });
        _cbo_check_types.select2('val',0);


        // _cboMethods=$('#cbo_methods').select2({
        //placeholder: "Please select method of payment.",
        //allowClear: true
        //});

        //_cboMethods.select2('val',null);
        _cboCustomerType=$("#cbo_customer_type").select2({
            allowClear: false
        });
 

        _cboArTrans=$("#cbo_ar_trans").select2({
            placeholder: "Please select AR Transaction.",
            allowClear: false
        });

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

        $("#tbl_billing_payment_for_review_searchbox").keyup(function(){         
            dtReviewBilling
                .search(this.value)
                .draw();
        });

        $("#tbl_cash_invoice_for_review_searchbox").keyup(function(){         
            dtReviewCash
                .search(this.value)
                .draw();
        });  

        $("#tbl_collection_for_review_searchbox").keyup(function(){         
            dtReview
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
                //console.log(row.data());
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/journal-crj?id="+ d.journal_id,
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


            $('#tbl_billing_review tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtReviewAdvances.row( tr );
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
                        "url":"Templates/layout/billing-advances-for-review?id="+ d.temp_journal_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response,'no-padding' ).show();

                        reInitializeSpecificDropDown($('.cbo_supplier_list'));
                        reInitializeSpecificDropDown($('.cbo_department_list'));

                        reInitializeNumeric();

                        var tbl=$('#tbl_entries_for_review_bill'+ d.temp_journal_id);
                        var parent_tab_pane=$('#journal_review_bill'+ d.temp_journal_id);
                        reInitializeDropDownAccounts(tbl,false);
                        reInitializeChildEntriesTableAdvances(tbl);
                        reInitializeChildElementsAdvances(parent_tab_pane);

                        // Add to the 'open' array
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }


                    });




                }
            } );


        $('#tbl_collection_for_review tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/collection-for-review?id="+ d.payment_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();

                    reInitializeSpecificDropDown($('.cbo_customer_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeSpecificDropDown($('.cbo_payment_method'));


                    reInitializeNumeric();

                    var tbl=$('#tbl_entries_for_review_'+ d.payment_id);
                    var parent_tab_pane=$('#journal_review_'+ d.payment_id);

                    reInitializeDropDownAccounts(tbl,false);
                    reInitializeChildEntriesTable(tbl);
                    reInitializeChildElements(parent_tab_pane);
                    reInitializeUpload(d.payment_id);

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }


                });

            }
        } );

        $('#tbl_cash_invoice_for_review tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dtReviewCash.row( tr );
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
                    "url":"Templates/layout/cash-for-review?id="+ d.cash_invoice_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();

                    reInitializeSpecificDropDown($('.cbo_customer_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeSpecificDropDown($('.cbo_payment_method'));


                    reInitializeNumeric();

                    var tbl=$('#tbl_entries_for_review_cash_'+ d.cash_invoice_id);
                    var parent_tab_pane=$('#journal_review_'+ d.cash_invoice_id);

                    reInitializeDropDownAccounts(tbl,false);
                    reInitializeChildEntriesTable(tbl);
                    reInitializeChildElementsCash(parent_tab_pane);

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }


                });

            }
        } );

        $('#tbl_billing_payment_for_review tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/billing-payment-for-review?id="+ d.temp_journal_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();

                    reInitializeSpecificDropDown($('.cbo_customer_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeSpecificDropDown($('.cbo_payment_method'));


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

            reInitializeDropDownAccounts($('#tbl_entries'),true);
            $('#date_txn').datepicker('setDate','today');
            $('#check_date').datepicker('setDate','today');


            $('#cbo_particulars').select2('val',null);
            $('#cbo_departments').select2('val',null);
            $('#cbo_payment_method').select2('val',null);
            _cbo_check_types.select2('val',0);
            $('input[name="file_2307"]').removeAttr('val');
            $('#file_2307_value').text('No File.');
            clearFields($('#frm_journal'));

            var selectchecktype = $('#cbo_check_types');
            var checkno = $('#check_no');
            var checkdate = $('#check_date');
            selectchecktype.attr('required', false);
            checkno.attr('required', false);
            checkdate.attr('required', false);
            checkno.attr('disabled', true);
            checkdate.attr('disabled', true);
            checkdate.val('');

            showList(false);

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
                "url":"Cash_receipt/transaction/cancel",
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

            if(data.check_date == '01/01/1970') {
                //$('#check_date').datepicker('setDate','today');
                //$('#check_date').val(null);
                //clearFields($('#frm_journal'));

                //alert('data.check_date');
            }

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            if(data.payment_method_id != 2){
                $('input[name="check_no"]').val('');
                $('input[name="check_date"]').val('');
            }

            var selectchecktype = $('#cbo_check_types');
            var checkno = $('#check_no');
            var checkdate = $('#check_date');

            if(data.payment_method_id==2){
                selectchecktype.attr('required', true);
                checkno.attr('required', true);
                checkdate.attr('required', true);
                checkno.attr('disabled', false);
                checkdate.attr('disabled', false);
            }else{
                selectchecktype.attr('required', false);
                checkno.attr('required', false);
                checkdate.attr('required', false);
                checkno.attr('disabled', true);
                checkdate.attr('disabled', true);
            }

            $('#cbo_particulars').select2('val',data.particular_id);
            $('#cbo_departments').select2('val',data.department_id);
            $('#cbo_payment_method').select2('val',data.payment_method_id);
            $('#cbo_check_types').select2('val',data.check_type_id);

            $.ajax({
                url: 'Cash_receipt/transaction/get-entries?id=' + data.journal_id,
                type: "GET",
                cache: false,
                dataType: 'html',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="6"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                }
            }).done(function(response){
                $('#tbl_entries > tbody').html(response);
                reInitializeNumeric();
                reInitializeDropDownAccounts($('#tbl_entries'), false);
                reComputeTotals($('#tbl_entries'));
            });


            showList(false);

        });


        _cboParticulars.on('select2:select',function(){
            var i=$(this).select2('val');
            if (_cboParticulars.val() == 'create_customer') {
                $('input,textarea,select',$('#frm_customer')).val('');
                $('img').attr('src','assets/img/anonymous-icon.png');
                 $('#cbo_customer_type').select2('val', 0);
                $('#cbo_ar_trans').select2('val',null);
                $('#modal_create_customer').modal('show');
            } else if (_cboParticulars.val() == 'create_supplier'){
                clearFields($('#frm_supplier'));
                $('img').attr('src','assets/img/anonymous-icon.png');
                $('#modal_create_suppliers').modal('show');
            }else {
                var obj_customers=$('#cbo_particulars').find('option[value="' + i + '"]');
                _selectedDepartment = obj_customers.data('link_department');
                $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment)});
                if(_selectedDepartment == '0'){
                    _cbo_departments.select2('val',null);
                }else{
                    _cbo_departments.select2('val',_selectedDepartment);
                }

            }

        });

        _cbo_departments.on("select2:select", function (e) {
            _selectedDepartment = $(this).select2('val');
            $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment); });
       });
       
        _cbo_paymentMethod.on("select2:select", function (e) {
            var selectchecktype = $('#cbo_check_types');
            var checkno = $('#check_no');
            var checkdate = $('#check_date');
            var i=$(this).select2('val');
            if(i==2){ //new customer
                selectchecktype.attr('required', true);
                checkno.attr('required', true);
                checkdate.attr('required', true);
                checkno.attr('disabled', false);
                checkdate.attr('disabled', false);
                $('#check_date').datepicker('setDate','today');
            }else{
                selectchecktype.attr('required', false);
                checkno.attr('required', false);
                checkdate.attr('required', false);
                checkno.attr('disabled', true);
                checkdate.attr('disabled', true);
                checkno.val('');
                checkdate.val('');

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

        $('#btn_save_customer').click(function(){
            if(validateRequiredFields($('#frm_customer'))){
                createCustomer().done(function(response){
                    showNotification(response);
                    var _customer = response.row_added[0];
                    _cboParticulars.select2().find('optgroup[label="Customers"]').append('<option value="'+ 'C-'+_customer.customer_id +'" data-link_department = "'+_customer.link_department_id+'">'+ _customer.customer_name +'</option>');
                    _cboParticulars.select2('val','C-'+_customer.customer_id);
                      _selectedDepartment = _customer.link_department_id;
                    $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment)});
                    _cbo_departments.select2('val',_selectedDepartment);
                    $('input,textarea,select',$('#frm_customer')).val('');
                }).always(function(){
                    $('#modal_create_customer').modal('toggle');
                    showSpinningProgress($('#btn_save_customer'));
                });
                return;
            }
        });

        $('#btn_save_supplier').click(function(){
            if(validateRequiredFields($('#frm_supplier'))){
                createSupplier().done(function(response){
                    showNotification(response);
                    var _supplier = response.row_added[0];
                    _cboParticulars.select2().find('optgroup[label="Suppliers"]').append('<option value="'+ 'S-'+_supplier.supplier_id +'">'+ _supplier.supplier_name +'</option>');
                    _cboParticulars.select2('val','S-'+_supplier.supplier_id);
                    clearFields($('#frm_supplier'));
                }).always(function(){
                    $('#modal_create_suppliers').modal('toggle');
                    showSpinningProgress($('#btn_save_supplier'));
                });
                return;
            }
        });


        $('#btn_browse_bir2307').click(function(event){
            event.preventDefault();
            $('input[name="file_2307"]').click();
        });

        $('input[name="file_2307"]').change(function(event){
            var _files=event.target.files;
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            $.ajax({
                url : 'Customers/transaction/upload_2307',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    if(response.stat == 'error'){
                        showNotification(response)
                    }else{
                        $('input[name="file_2307"]').attr('val',response.path);
                        $('#file_2307_value').text('File Uploaded.');
                    }
                }
            });
        });

        $('#btn_remove_bir2307').click(function(event){
            event.preventDefault();
            $('input[name="file_2307"]').removeAttr('val');
            $('#file_2307_value').text('No File.');
        });


        $('#btn_browse_customer_photo').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            $.ajax({
                url : 'Customers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    //console.log(response);
                    //alert(response.path);
                    /*$('#div_img_loader').hide();
                    $('#div_img_user').show();*/
                    $('img[name="img_customer"]').attr('src',response.path);
                }
            });
        });



        $('input[name="file_supplier[]"]').change(function(event){
            var _files=event.target.files;
            
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
            $.ajax({
                url : 'Suppliers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    
                    $('img[name="img_supplier"]').attr('src',response.path);
                }
            });
        });

        $('#btn_remove_photo_customer').click(function(event){
            event.preventDefault();
            $('img[name="img_customer"]').attr('src','assets/img/anonymous-icon.png');
        });

        $('#btn_browse_supplier_photo').click(function(event){
            event.preventDefault();
            $('input[name="file_supplier[]"]').click();
        });

        $('#btn_remove_photo_supplier').click(function(event){
            event.preventDefault();
            $('img[name="img_supplier"]').attr('src','assets/img/anonymous-icon.png');
        });

        $('#btn_cancel_customer').click(function(){
            _cboParticulars.select2('val',null);
            $('#modal_new_customer').modal('hide');
        });

        $('#btn_cancel_supplier').click(function(){
            _cboParticulars.select2('val',null);
            $('#modal_create_suppliers').modal('hide');
        });


    }();











    //*********************************************************************8
    //              user defines

    var createCustomer=function(){
        var _data=$('#frm_customer').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_customer"]').attr('src')});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Customers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save_customer'))
        });
    };


    var createSupplier=function() {
        var _data=$('#frm_supplier').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_supplier"]').attr('src')});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Suppliers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save_supplier'))
        });
    };

    var createJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        _data.push({name : "file_2307" ,value : $('input[name="file_2307"]').attr('val')});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Cash_receipt/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))

        });
    };


    var updateJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Cash_receipt/transaction/update?id="+_selectedID,
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };


    var showList=function(b){
        if(b){
            $('#div_payable_list').show();
            $('#div_payable_fields').hide();
        }else{
            $('#div_payable_list').hide();
            $('#div_payable_fields').show();
        }
    };

    var clearFields=function(f){

        $('input:not(.date-picker),textarea',f).val('');


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

    // function reInitializeDropDownAccounts(tbl){
    //     tbl.find('select.selectpicker').select2({
    //         placeholder: "Please select account.",
    //         allowClear: false
    //     });
    // };

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
            allowClear: false
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
            // reInitializeDropDownAccounts(tbl);
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
    var reInitializeUpload=function(payment_id){
        $('.btn_browse_bir2307_'+payment_id).click(function(event){
            event.preventDefault();
            $('input[name="file_2307_'+payment_id+'"]').click();
        });

        $('input[name="file_2307_'+payment_id+'"]').change(function(event){
            var _files=event.target.files;
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            $.ajax({
                url : 'Customers/transaction/upload_2307',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    if(response.stat == 'error'){
                        showNotification(response)
                    }else{
                        alert();
                        $('input[name="file_2307_'+payment_id+'"]').attr('val',response.path);
                        $('.file_2307_value_'+payment_id).text('File Uploaded.');
                        alert();
                    }
                }
            });
        });

        $('.btn_remove_bir2307_'+payment_id).click(function(event){
            event.preventDefault();
            $('input[name="file_2307_'+payment_id+'"]').removeAttr('val');
            $('input[name="file_2307_'+payment_id+'"]').attr('src','');
            $('.file_2307_value_'+payment_id).text('No File.');
        });


    };

    var reInitializeChildElements=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: true,
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
            _data_review.push({name : "file_2307" ,value : $('input[name="file_2307_'+_dataParentID+'"]').attr('val')});
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_receipt/transaction/create",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };
    var reInitializeChildElementsCash=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: true,
            calendarWeeks: true,
            autoclose: true

        });


        parent.on('click','button[name="btn_finalize_journal_review"]',function(){

            var _curBtn=$(this);
            if(isZero('#tbl_entries_for_review_cash_'+_dataParentID)){
            if(isBalance('#tbl_entries_for_review_cash_'+_dataParentID)){
                finalizeJournalReview().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row.add(response.row_added[0]).draw();
                        var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                        dtReviewCash.row(_parentRow).remove().draw();
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
                "url":"Cash_receipt/transaction/create-from-cash-invoice",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };


    var reInitializeChildElementsBilling=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: true,
            calendarWeeks: true,
            autoclose: true

        });


        parent.on('click','button[name="btn_finalize_journal_review"]',function(){

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
                "url":"Cash_receipt/transaction/create-from-cash-invoice",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };


        var reInitializeChildEntriesTableAdvances=function(tbl){

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

        var reInitializeChildElementsAdvances=function(parent){
            var _dataParentID=parent.data('parent-id');
            var btn=parent.find('button[name="btn_finalize_journal_review"]');
            var btncancel=parent.find('button[name="btn_cancel_journal_review"]');

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

                if(isZero('#tbl_entries_for_review_bill'+_dataParentID)){
                if(isBalance('#tbl_entries_for_review_bill'+_dataParentID)){
                    if(validateRequiredFields('#tbl_entries_for_review_'+_dataParentID)){
                    
                        finalizeJournalReview().done(function(response){
                            showNotification(response);
                            if(response.stat=="success"){
                                dt.row.add(response.row_added[0]).draw();
                                var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                                dtReviewAdvances.row(_parentRow).remove().draw();
                            }


                        }).always(function(){
                            showSpinningProgress(_curBtn);
                        }); 
                    }

                }else{
                    showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                    stat=false;
                }
                }else{
                        showNotification({title:"No Amount!",stat:"error",msg:'Please make sure Debit and Credit does not amount to zero.'});
                        stat=false;
                }// END of ISZERO
            });

            parent.on('click','button[name="btn_cancel_journal_review"]',function(){

                var _curBtn=$(this);
            
                var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                var data=dtReviewAdvances.row(_parentRow).data();
                _selectedID=data.temp_journal_id;
                _selectedParentRow=_parentRow;
                $('#modal_confirmation_advances').modal('show');
            });


            $('#btn_yes_cancel_advance').click(function(){
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Cash_receipt/transaction/cancel-review-advance",
                    "data":{temp_journal_id : _selectedID},
                    "success": function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dtReviewAdvances.row(_selectedParentRow).remove().draw();
                        }

                    }
                });
            });

            var finalizeJournalReview=function(){
                var _data_review=parent.find('form').serializeArray();

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Cash_receipt/transaction/create",
                    "data":_data_review,
                    "beforeSend": showSpinningProgress(btn)

                });
            };



        };    
});


</script>

</body>

</html>