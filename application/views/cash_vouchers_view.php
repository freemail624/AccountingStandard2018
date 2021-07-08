<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-cdjp-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--<link href="assets/dropdown-enhance/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">-->
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


        .toolbar{
            float: left;
        }

        body {
            overflow-x: hidden;
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
            z-index: 999999999;
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
        }

        .boldlabel {
            font-weight: bold;
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

        .right_align_items{
        	text-align: right;
        }

        input[type=checkbox] {
          /* Double-sized Checkboxes */
          margin-top: 10px;
          margin-left: 10px;
          -ms-transform: scale(1.5); /* IE */
          -moz-transform: scale(1.5); /* FF */
          -webkit-transform: scale(1.5); /* Safari and Chrome */
          -o-transform: scale(1.5); /* Opera */
        }

        #tbl_temp_vouchers_list_filter{
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
        #tbl_accounts_receivable_filter{
            display: none;
        }
        .centered{
            text-align: center;
        }
        #link_browse_rr:hover{
            background-color: #add8e6!important; 
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

<div id="div_payable_list">
    <div class="panel-group panel-default" id="accordionA">
        <div class="panel panel-default" style="border-radius:6px;margin-top:20px;">
            <div class="panel-body panel-responsive">
            <h2 class="h2-panel-heading">Temporary Vouchers Journal</h2><hr>
                <div id="collapseOne" class="collapse in">
                <div class="row">
                    <div class="col-lg-3">
                    &nbsp;<br>
                        <button class="btn btn-primary" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Journal" ><i class="fa fa-plus"></i> New Temporary Voucher</button>
                    </div>
                    <div class="col-lg-2">
                            From :<br />
                            <div class="input-group">
                                <input type="text" id="txt_start_date_cdj" name="" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
                                 <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                 </span>
                            </div>
                    </div>
                    <div class="col-lg-2">
                            To :<br />
                            <div class="input-group">
                                <input type="text" id="txt_end_date_cdj" name="" class="date-picker form-control" value="<?php echo date("m/t/Y"); ?>">
                                 <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                 </span>
                            </div>
                    </div>
                    <div class="col-lg-3">
                            Filter:<br />
                            <select id="cbo_table_filter" class="form-control">
                                <?php foreach($cv_status as $status){?>
                                    <option value="<?php echo $status->cv_status_id; ?>">
                                        <?php echo $status->status_name; ?>
                                    </option>
                                <?php }?>
                            </select> 
                    </div>
                    <div class="col-lg-2">
                        Search :<br />
                        <input type="text" id="searchbox_cdj" class="form-control">
                    </div>
                </div><br>
                        <div class="">
                            <table id="tbl_temp_vouchers_list" class="table-striped table" cellspacing="0" width="100%">
                                <thead class="">
                                <tr>    
                                    <th></th>
                                    <th style="width: 15%;">Txn #</th>
                                    <th>Type</th>
                                    <th width="10%">Ref Type</th>
                                    <th>Particular</th>
                                    <th>RR #</th>
                                    <th>Method</th>
                                    <th>Txn Date</th>
                                    <th>Prepared By</th>
                                    <th style="width: 20%;"><center>Action</center></th>
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
    </div>

<div id="div_payable_fields" style="display: none;">
    <div class="panel panel-default" style="border-radius:6px;margin-top:20px;"  >
    <div class="panel-body panel-responsive">
    <h2 class="h2-panel-heading"> Temporary Vouchers Journal</h2><hr>
        <form id="frm_journal" role="form" class="form-horizontal">
            <div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                       <b class="required"> * </b> <label>Date  :</label><br />
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="date_txn" class="date-picker form-control" data-error-msg="Date is required." required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <b class="required"> * </b> <label>Txn #  :</label><br />
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
                                        <b class="required"> * </b> <label>Reference type :</label><br />
                                        <select id="cbo_refType" class="form-control" name="ref_type" data-error-msg="Reference type is required." required>
                                            <option value="CV" selected>CV</option>
                                            <option value="JV">JV</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                         <label>Reference #:</label><br />
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-code"></i>
                                            </span>
                                            <input type="text" maxlength="15" class="form-control" name="ref_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <b class="required"> * </b> <label>Particular  :</label><br />
                                        <select id="cbo_particulars" name="particular_id" class="selectpicker show-tick form-control" data-live-search="true" data-error-msg="Particular is required." required>
                                            <optgroup label="Customers">
                                                <!-- <option value="create_customer">[Create New Customer]</option> -->
                                                <?php foreach($customers as $customer){ ?>
                                                    <option value='C-<?php echo $customer->customer_id; ?>' data-link_department='<?php echo $customer->link_department_id; ?>'><?php echo $customer->customer_name; ?></option>
                                                <?php } ?>
                                            </optgroup>

                                            <optgroup label="Suppliers">
                                                <!-- <option value="create_supplier">[Create New Supplier]</option> -->
                                                <?php foreach($suppliers as $supplier){ ?>
                                                    <option value='S-<?php echo $supplier->supplier_id; ?>' data-link_department='0'><?php echo $supplier->supplier_name; ?></option>
                                                <?php } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                       <b class="required"> * </b> <label>Department  :</label><br />
                                        <select id="cbo_branch" name="department_id" class="selectpicker show-tick form-control" data-live-search="true" data-error-msg="Department is required." required>
                                            <?php foreach($departments as $department){ ?>
                                                <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <label>RR #: </label>
                                        <div class="input-group">
                                            <input type="text" name="dr_invoice_no" id="dr_invoice_no" class="form-control" placeholder="RR #" readonly>
                                             <span class="input-group-addon" id="link_browse_rr" style="cursor: pointer;">
                                                <a href="#" style="text-decoration: none;"><b>
                                                    <span id="btn_rr"></span>
                                                </b></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div style="margin-top: 25px;">
                                            <input type="checkbox" id="is_2307" value="1" style="cursor: pointer;">
                                            &nbsp;<label for="is_2307" style="cursor: pointer;">Apply 2307</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div style="margin-top: 5px;">
                                            <label>ATC :</label><br />
                                            <select id="cbo_tax_code" class="form-control" name="atc_id">
                                                <option value=""></option>
                                                <?php foreach($tax_codes as $tax_code){ ?>
                                                    <option value="<?php echo $tax_code->atc_id; ?>" data-description="<?php echo $tax_code->description; ?>">
                                                        <?php echo $tax_code->atc.' - '.$tax_code->description; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                            <label>Nature Income Payment :</label><br />
                                            <textarea class="form-control" name="remarks_2307" id="remarks_2307" data-error-msg="Remarks is required." rows="5" readonly placeholder="Nature Income Payment"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <b class="required"> * </b> <label>Method of Payment  :</label><br />
                                        <select id="cbo_pay_type" name="payment_method" class="form-control" data-error-msg="Payment method is required." required>
                                            <?php foreach($payment_methods as $payment_method){ ?>
                                                <option value='<?php echo $payment_method->payment_method_id; ?>'><?php echo $payment_method->payment_method; ?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="row for_check">
                                    <div class="col-sm-12">
                                        <b class="required"> * </b> <label>Check Type :</label><br />
                                        <select id="cbo_check_type" class="form-control" name="check_type_id">
                                        <option value="0">None </option>
                                        <?php foreach($check_types as $check_type){ ?>
                                             <option value='<?php echo $check_type->check_type_id; ?>'><?php echo $check_type->check_type_desc; ?> (<?php echo $check_type->account_title; ?>) </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row for_check">
                                    <div class="col-sm-6">
                                        <b class="required"> * </b> <label>Check Date :</label><br />
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="check_date" id="check_date" class="date-picker form-control" data-error-msg="Check date is required!" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <b class="required"> * </b> <label>Check # :</label><br />
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-list-alt"></i>
                                            </span>
                                            <input type="text" name="check_no" id="check_no" maxlength="15" class="form-control" data-error-msg="Check number is required!">
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <b class="required"> * </b>  <label>Amount  :</label><br />
                                        <input class="form-control text-center numeric" id="cash_amount" type="text" maxlength="12" value="0.00" name="amount" required data-error-msg="Amount is Required!">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label> <b id="net_amount_label" class="required"></b> Net Amount  :</label><br />
                                        <input class="form-control text-center numeric" id="net_amount" type="text" value="0.00" name="net_amount" data-error-msg="Net Amount is Required!">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div>
                <span><strong><i class="fa fa-bars"></i> Journal Entries</strong></span>
                <hr />

                <div style="width: 100%;">
                    <table id="tbl_entries" class="table-striped table">
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
                                    <?php $i=0; foreach($accounts as $account){ ?>
                                        <option value='<?php echo $account->account_id; ?>' <?php echo ($i==0?'':''); ?> data-cib="<?php echo $account->for_cib; ?>"><?php echo $account->account_title; ?></option>
                                        <?php $i++; } ?>
                                </select>
                            </td>
                            <td><input type="text" name="memo[]" class="form-control"></td>
                            <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                            <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                            <td>       
                                <select  name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
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
                                <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true">
                                    <?php $i=0; foreach($accounts as $account){ ?>
                                        <option value='<?php echo $account->account_id; ?>' <?php echo ($i==0?'':''); ?> data-cib="<?php echo $account->for_cib; ?>"> <?php echo $account->account_title; ?> </option>
                                        <?php $i++; } ?>
                                </select>
                            </td>
                            <td><input type="text" name="memo[]" class="form-control"></td>
                            <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                            <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                            <td>       
                                <select  name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
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
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <label>Remarks :</label><br />
                    <textarea name="remarks" class="form-control"></textarea>
                </div>
            </div>
        </form>
        <div id="div_check">
        </div>
        <div id="div_no_check">
        </div>

        <br />
        <div class="row">
            <div class="col-sm-12">
                <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save and Post</button>
                <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
            </div>
        </div>
    </div>
    </div>


    <table id="table_hidden" class="hidden">
        <tr>
            <td width="30%">
                <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                    <?php $i=0; foreach($accounts as $account){ ?>
                        <option value='<?php echo $account->account_id; ?>' <?php echo ($i==0?'':''); ?> data-cib="<?php echo $account->for_cib; ?>"><?php echo $account->account_title; ?></option>
                        <?php $i++; } ?>
                </select>
            </td>
            <td><input type="text" name="memo[]" class="form-control"></td>
            <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
            <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
            <td>       
                <select  name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
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
</div> <!-- .container-fluid -->
</div> <!-- #page-content -->
</div>

<!-- <footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer> -->

</div>
</div>
</div>


<div id="modal_recurring" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color: white;"><i class="fa fa-folder-open-o"></i>  Browse Recurring Templates</h4>
            </div>
            <div class="modal-body">
                <table id="tbl_recurring" class="table table-striped" width="100%">
                    <thead>
                        <th>Template Code</th>
                        <th>Template Description</th>
                        <th>Payee / Particular</th>
                        <th><center>Action</center></th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="btn_cancel_browsing" class="btn btn-default">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Confirm Deletion</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to delete this voucher?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_confirmation_verified" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Confirm Verification</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to mark this as verified?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes_verified" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_check_layout" class="modal fade" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>Select Check Layout</h4>

            </div>

            <div class="modal-body" style="padding-right: 20px;">

                <div class="row">
                        <div class="container-fluid">
                            <div class="col-xs-12">
                                <select name="check_layout" class="form-control" id="cbo_layouts">
                                    <?php foreach($layouts as $layout){ ?>
                                        <option value="<?php echo $layout->check_layout_id; ?>"><?php echo $layout->check_layout; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                </div>


            </div>

            <div class="modal-footer">
                <button id="btn_preview_check" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Preview Check</button>
                <button id="btn_close_check" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_rr_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content"><!---content-->
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Receiving Receipt</h4>

            </div>

            <div class="modal-body">
                <table id="tbl_rr_list" class="table table-striped" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th></th>
                        <th>RR#</th>
                        <th>Vendor</th>
                        <th>Terms</th>
                        <th>Delivered</th>
                        <th>Status</th>
                        <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->


<div id="modal_create_suppliers" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"><!--modal-->
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

<div id="modal_create_customer" class="modal fade" role="dialog"  data-backdrop="static" data-keyboard="false"><!--modal-->
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
                                     <label class="control-label boldlabel" style="text-align:right;"> <b class="required">*</b> Customer Name :</label>
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
                                     <label class="control-label boldlabel" style="text-align:right;"> <b class="required">*</b> Contact Person :</label>
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
                                     <label class="control-label boldlabel" style="text-align:right;"><b class="required">*</b> Address :</label>
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
                                     <label class="control-label boldlabel" style="text-align:right;"> Email Address :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>
                                        </span>
                                        <input type="text" name="email_address" class="form-control" placeholder="Email Address" data-error-msg="Email Address is required.">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"> Contact No :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input type="text" name="contact_no" class="form-control" placeholder="Contact No" data-error-msg="Contact No  is required.">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"> TIN :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-file-code-o"></i>
                                        </span>
                                        <input type="text" name="tin_no" id="tin_no" class="form-control" placeholder="TIN" data-error-msg="TIN is required.">
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
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>-->



<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>



<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>



<script>
$(document).ready(function(){
    var _txnMode; var _cboParticulars; var _cboMethods; var _selectRowObj; var _selectedID; var _txnMode, _cbo_departments, _cboPaymentMethod, _cboCheckTypes;
     var cbo_refType; var _cboLayouts; var dtRecurring; var _attribute; var _TableFilter; var _selectedDepartment = 0;
     var _cboTaxCode; var dt_rr; var btn_rr_status; var _cboCustomerType; var _cboArTrans; var _cboLinkDepartment; var _cboTaxGroup;

    var oTBJournal={
        "account" : "td:eq(0)",
        "dr" : "td:eq(2)",
        "cr" : "td:eq(3)"
    };

    var oTFSummary={
        "dr" : "td:eq(1)",
        "cr" : "td:eq(2)"
    };


    var initializeControls=function(){
        _TableFilter=$('#cbo_table_filter').select2({
            placeholder: "Please select Filter.",
            minimumResultsForSearch: -1
        });

        dt=$('#tbl_temp_vouchers_list').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 10, "desc" ]],
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Cash_vouchers/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "tsd":$('#txt_start_date_cdj').val(),
                            "ted":$('#txt_end_date_cdj').val(),
                            "fil":$('#cbo_table_filter').val()

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
                { targets:[2],data: "ref_type" },
                { targets:[3],data:null,
                    render: function (data, type, full, meta){
                        return data.ref_type+'-'+data.ref_no
                    }
                },
                { targets:[4],data: "particular" },
                { targets:[5],data: "dr_invoice_no" },
                { targets:[6],data: "payment_method" },
                { targets:[7],data: "date_txn" },
                { targets:[8],data: "posted_by" },
                { sClass: "right_align_items","orderable":false,
                    targets:[9],data:null,
                    render: function (data, type, full, meta){
                        var btn_verified='<button class="btn btn-warning btn-sm" name="mark_verified" title="Mark as Verified">Verify</button>';
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_cancel='<button class="btn btn-red btn-sm" name="delete_info" title="Delete Temporary Voucher"><i class="fa fa-trash"></i> </button>';
                        var btn_for_approval='<button class="btn btn-info btn-sm" style="width: 123px;" disabled>For Approval</button>';
                        var btn_approved='<button class="btn btn-light btn-sm" disabled>Approved</button>';
                        var btn_cancelled='<button class="btn btn-light btn-sm" disabled>Cancelled</button>';
                        var btn_check_print = "";

                        if(data.payment_method_id == 2){
                            btn_check_print='<button class="btn btn-success btn-sm" name="print_check" style="text-transform: none;" data-toggle="tooltip" data-placement="top" title="Cheque"><img src="assets/img/facheque.png"></button>'
                        }

                        if(data.cv_status_id == 1) { // Pending / For Verification
                            return btn_check_print+"&nbsp;"+btn_verified+"&nbsp;"+btn_edit+"&nbsp;"+btn_cancel+'';
                        }else if(data.cv_status_id == 2){ // Approved
                            return btn_approved;
                        }else if (data.cv_status_id == 3){ // Disapproved
                            return btn_edit+"&nbsp;"+btn_cancel;
                        }else if (data.cv_status_id == 4){ // Cancelled
                            return btn_cancelled;
                        }else if (data.cv_status_id == 5){ // Verified
                            return btn_check_print+"&nbsp;"+btn_for_approval;
                        }
                        	
                    }
                },
                { targets:[10],data: "cv_id",visible:false },


            ]
        });

        reInitializeNumeric();
        reInitializeDropDownAccounts($('#tbl_entries'),false);

        dt_rr=$('#tbl_rr_list').DataTable({
            "bLengthChange":false,
            "ajax" : "Deliveries/transaction/open",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "dr_invoice_no" },
                { targets:[2],data: "supplier_name" },
                { targets:[3],data: "term_description" },
                { targets:[4],data: "date_delivered" },
                { targets:[5],data: "order_status" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_rr"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Receive this RR"><i class="fa fa-check"></i> Accept RR</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                }

            ]
        });

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });

        _cboCheckTypes=$('#cbo_check_type').select2({
            placeholder: "Please Select Check Type",
            allowClear:false
        });

        _cboParticulars=$('#cbo_particulars').select2({
            placeholder: "Please select a particular.",
            allowClear: false
        });
        _cboParticulars.select2('val',null);

        _cboPaymentMethod = $('#cbo_pay_type').select2({
            placeholder: "Please select Payment Type.",
            allowClear: false
        });
        _cboPaymentMethod.select2('val',null);

        _cbo_departments=$('#cbo_branch').select2({
            placeholder: "Please select department.",
            allowClear: false
        });
        _cbo_departments.select2('val',null);

        _cboCustomerType=$("#cbo_customer_type").select2({
            allowClear: false
        });

        _cboArTrans=$("#cbo_ar_trans").select2({
            placeholder: "Please select AR Transaction.",
            allowClear: false
        });

        _cboLayouts=$('#cbo_layouts').select2({
            placeholder: "Please select check layout.",
            allowClear: false
        });
        _cboLayouts.select2('val',null);
        _cboCheckTypes.select2('val',null);

        cbo_refType=$('#cbo_refType').select2({
            placeholder: "Please select reference type.",
            allowClear: false
        });

        _cboTaxCode=$('#cbo_tax_code').select2({
            placeholder: "Please select atc.",
            allowClear: false
        });
        _cboTaxCode.select2('val',null);

        _cboLinkDepartment=$("#cbo_link_department_id").select2({
            placeholder: "Please Select Default Department.",
            allowClear: false
        });

        _cboTaxGroup=$('#cbo_tax_type').select2({
            allowClear: false
        });

        _cboTaxGroup.select2({
            dropdownParent: $('#modal_create_suppliers')
        });

    }();



    var bindEventHandlers=function(){

        $("#txt_start_date_cdj").on("change", function () {        
            $('#tbl_temp_vouchers_list').DataTable().ajax.reload()
        });

        $("#txt_end_date_cdj").on("change", function () {        
            $('#tbl_temp_vouchers_list').DataTable().ajax.reload()
        });
        $("#searchbox_cdj").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        var detailRows = [];

        $('#tbl_temp_vouchers_list tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/journal-cdj-voucher?id="+ d.cv_id,
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

        $('#tbl_rr_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt_rr.row( tr );
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
                _selectRowObj=$(this).closest('tr');
                var d=dt_rr.row(_selectRowObj).data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/dr/"+ d.dr_invoice_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });



            }
        } );

        $('#tbl_rr_list > tbody').on('click','button[name="accept_rr"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_rr.row(_selectRowObj).data();

            $('textarea[name="remarks"]').val(data.remarks);
            $('#cbo_particulars').select2('val','S-'+data.supplier_id);
            $('#cbo_branch').select2('val',data.department_id);
            get_button_rr(1);

            get_dr_balance_qty(data.dr_invoice_id).done(function(response){
                data = response.data[0];
                $('#cash_amount').val(accounting.formatNumber(data.Balance,2));
            });

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });


            $('#modal_rr_list').modal('hide');


            $.ajax({
                url: 'Cash_vouchers/transaction/get-rr-entries?id=' + data.dr_invoice_id,
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
                reInitializeDropDownAccounts($('#tbl_entries'),false); //do not clear dropdown accounts
                reComputeTotals($('#tbl_entries'));
            });

            // resetSummary();
            // $.ajax({
            //     url : 'Purchases/transaction/item-balance/'+data.purchase_order_id,
            //     type : "GET",
            //     cache : false,
            //     dataType : 'json',
            //     processData : false,
            //     contentType : false,
            //     beforeSend : function(){
            //         $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
            //     },
            //     success : function(response){
            //         var rows=response.data;
            //         $('#tbl_items > tbody').html('');
                     
            //         var total_discount=0;
            //         var total_tax_amount=0;
            //         var total_non_tax_amount=0;
            //         var gross_amount=0;
            //         var a = 0;
            //         $.each(rows,function(i,value){
            //             bulk_price = value.purchase_cost;
            //             var retail_price = 0;
            //             if(value.is_bulk == 1){
            //                 retail_price = getFloat(value.purchase_cost) / getFloat(value.child_unit_desc);

            //             }else if (value.is_bulk== 0){
            //                 retail_price = 0;
            //             }
            //             changetxn ='inactive';
            //             $('#tbl_items > tbody').append(newRowItem({
            //                 dr_qty : value.po_qty,
            //                 product_code : value.product_code,
            //                 product_id: value.product_id,
            //                 product_desc : value.product_desc,
            //                 dr_line_total_discount : value.po_line_total_discount,
            //                 tax_exempt : false,
            //                 dr_tax_rate : value.po_tax_rate,
            //                 dr_price : value.po_price,
            //                 dr_discount : value.po_discount,
            //                 tax_type_id : null,
            //                 dr_line_total_price : value.po_line_total,
            //                 dr_non_tax_amount: value.non_tax_amount,
            //                 dr_tax_amount: value.tax_amount,
            //                 bulk_price : bulk_price,
            //                 retail_price : retail_price,
            //                 is_bulk: value.is_bulk,
            //                 is_parent : value.is_parent,
            //                 parent_unit_name: value.parent_unit_name,
            //                 child_unit_name:value.child_unit_name,
            //                 parent_unit_id : value.parent_unit_id,
            //                 child_unit_id : value.child_unit_id,
            //                 // exp_date: exp_date,
            //                 total_after_global : value.po_line_total_after_global,
            //                 batch_no:"",
            //                 a:a
            //             }));
            //             _line_unit=$('.line_unit'+a).select2({
         
            //             });
            //             _line_unit.select2('val',value.unit_id);
            //             a++;
            //             //sum up all footer details
            //             // total_discount+=getFloat(value.po_line_total_discount);
            //             // total_tax_amount+=getFloat(value.tax_amount);
            //             // total_non_tax_amount+=getFloat(value.non_tax_amount);
            //             // gross_amount+=getFloat(value.po_line_total);

            //         });
            //         changetxn = 'active';
            //         $('#txt_overall_discount').val(accounting.formatNumber($('#txt_overall_discount').val(),2));
            //         reInitializeNumeric();
            //         reComputeTotal();
                   
            //     }

            // });
        });

        _cboParticulars.on('select2:select',function(){
            var i=$(this).select2('val');

            if (i == 'create_customer') {

                $('input,textarea,select',$('#frm_customer')).val('');
                $('img').attr('src','assets/img/anonymous-icon.png');
                $('#cbo_customer_type').select2('val', 0);
                $('#cbo_link_department_id').select2('val', 0);
                $('#cbo_ar_trans').select2('val',null);
                _cboParticulars.select2('val', null);
                $('#modal_create_customer').modal('show');

            } else if (i == 'create_supplier'){

                clearFields($('#frm_supplier'));
                $('img').attr('src','assets/img/anonymous-icon.png');
                _cboParticulars.select2('val', null);
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

        $('#btn_preview_check').click(function(){
            if ($('#cbo_layouts').select2('val') != null || $('#cbo_layouts').select2('val') != undefined)
                window.open('Templates/layout/print-check-voucher?id='+$('#cbo_layouts').val()+'&cv_id='+_selectedID);
            else
                showNotification({ title: 'Error', msg: 'Please select check layout!', stat: 'error' });
        });

        var apply_2307 = function(){
            if ($('#is_2307').is(":checked") == false){
                _cboTaxCode.select2('val',null);
                $('#remarks_2307').val("");
                $('#net_amount_label').html('');
                $('#net_amount').prop('required',false);
            }else{
                $('#net_amount_label').html('*');
                $('#net_amount').prop('required',true);
            }
        }

        $('#is_2307').click(function(){
            apply_2307();
        });

        $('#cbo_tax_code').on("change", function (e) {
            var i=$(this).select2('val');
            var remarks = $("#cbo_tax_code").find(":selected").data("description");

            if(i==null || i==""){
                $('#is_2307').prop('checked', false);
                $('#remarks_2307').val("");
            }else{
                $('#is_2307').prop('checked', true);
                $('#remarks_2307').val(remarks);
            } 

        });

        $('#remarks_2307').on('keyup',function(){
            if($(this).val() != null || ""){
                $('#is_2307').prop('checked', true);
            }
        });

        $('#btn_new').click(function(){
            _txnMode="new";
            $('#div_check').show();
            $('#div_no_check').hide();
            var _currentDate=<?php echo json_encode(date("m/d/Y")); ?>;
            get_button_rr(2);

            reInitializeDropDownAccounts($('#tbl_entries'),true);
            clearFields($('#frm_journal'));

            $('#cbo_branch').select2('val',null);
            $('#cbo_pay_type').select2('val',1);
            $('#cbo_particulars').select2('val',null);
            $('#cbo_refType').select2('val',"CV");
            $('#is_2307').prop('checked', false);
            $('#cbo_tax_code').select2('val',null);

            //set defaults
            _cboPaymentMethod.select2('val',1);//set cash as default
            _cboCheckTypes.select2('val',0);//set cash as default
            $('input[name="date_txn"]').val(_currentDate);
            apply_2307();
            showList(false);

        });

        $('#link_browse_rr').click(function(){
            if(btn_rr_status==1){
                $('#dr_invoice_no').val("");
                get_button_rr(2);
            }else if(btn_rr_status==2){
                $('#tbl_rr_list tbody').html('<tr><td colspan="7"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                dt_rr.ajax.reload( null, false );
                $('#modal_rr_list').modal('show');
            }else if(btn_rr_status==3){
                return;
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

            recomputeCheckAmount($('#tbl_entries'));
            reComputeTotals($('#tbl_entries'));
        });

        $('#tbl_temp_vouchers_list').on('click','button[name="print_check"]',function(){

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.cv_id;

            $('#modal_check_layout').modal('show');
        });

        $('#tbl_temp_vouchers_list').on('click','button[name="delete_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.cv_id;
            $('#modal_confirmation').modal('show');
        });

        $('#tbl_temp_vouchers_list').on('click','button[name="mark_verified"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.cv_id;
            $('#modal_confirmation_verified').modal('show');
        });

        $('#btn_yes').click(function(){
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_vouchers/transaction/delete",
                "data":{cv_id : _selectedID},
                "success": function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).remove().draw();
                    }

                }
            });
        });

        $('#btn_yes_verified').click(function(){
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_vouchers/transaction/verify",
                "data":{cv_id : _selectedID},
                "success": function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }

                }
            });
        });

        $('#tbl_temp_vouchers_list').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";

            $('#div_check').hide();
            $('#div_no_check').show();

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.cv_id;

            $('input,textarea, select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            $('#cbo_pay_type').select2('val',data.payment_method_id);
            $('#cbo_particulars').select2('val',data.particular_id);
            $('#cbo_branch').select2('val',data.department_id);
            $('#cbo_refType').select2('val',data.ref_type);
            $('#cbo_check_type').select2('val',data.check_type_id);
            $('#cbo_tax_code').val(data.atc_id).trigger("change");

            if(data.dr_invoice_id > 0){
                get_button_rr(3);
            }else{
                get_button_rr(2);
            }

            $('#check_date').val(data.check_date);
            $('#check_no').val(data.check_no);

            if(data.check_date == '00/00/0000'){
                $('input[name="check_date"]').val('');
            }

            if(data.is_2307 == true){
                $('#is_2307').prop('checked', true);
            }else{
                $('#is_2307').prop('checked', false);
            }
            apply_2307();

            $.ajax({
                url: 'Cash_vouchers/transaction/get-entries?id=' + data.cv_id,
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
                reInitializeDropDownAccounts($('#tbl_entries'),false); //do not clear dropdown accounts
                reComputeTotals($('#tbl_entries'));
            });

            showList(false);

        });


        $('#tbl_entries').on('click','button.remove_account',function(){
            var oRow=$('#tbl_entries > tbody tr');
            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }
            recomputeCheckAmount($('#tbl_entries'));
            reComputeTotals($('#tbl_entries'));
        });

        $('#btn_save_customer').click(function(){
            if(validateRequiredFields($('#frm_customer'),false)){
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
            if(validateRequiredFields($('#frm_supplier'), false)){
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


        $('#btn_save').click(function(){
            var btn=$(this);
            var f=$('#frm_journal');
            if(validateAccounts(f)){
            if(validateRequiredFields(f, true)){
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
                            setTimeout(function(){
                                showList(true);
                            },200);
                        }
                    }).always(function(){
                        showSpinningProgress(btn);
                    });
                }
            }
            } else {
                showNotification({title:"Journal Entries!",stat:"error",msg:'Incomplete assignment of Account Titles in the table.'});
                stat=false;
            } // ELSE OF VALIDATE ACCOUNTS
        });

        $('#btn_cancel').click(function(){
            showList(true);
        });

        $("#cbo_pay_type").change(function(){
            initializePaymentMethod($(this).val());
        });

        _TableFilter.on("select2:select", function (e) {
            $('#tbl_temp_vouchers_list').DataTable().ajax.reload()
        });

        _cbo_departments.on("select2:select", function (e) {
            _selectedDepartment = $(this).select2('val'); 
            $('#tbl_entries select.dept').each(function(){ $(this).select2('val',_selectedDepartment)}); 
        });


        $('#tbl_entries tbody').on('change','select.selectpicker_accounts',function(){
            recomputeCheckAmount($('#tbl_entries'));
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

    var initializePaymentMethod = function(id){
        /* if payment method is check */

        $('#cbo_check_type').val(0).trigger("change");
        $('#check_date').val('');
        $('#check_no').val('');

        if(id == 2) { 
            $('.for_check').removeClass('hidden');
            $('#check_date').prop('required',true);
            $('#check_no').prop('required',true);
        } else {
            $('.for_check').addClass('hidden');
            $('#check_date').prop('required',false);
            $('#check_no').prop('required',false);
        }
    };

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
        if($('#is_2307').is(':checked')==true){
        _data.push({name : "is_2307" ,value : 1}); }else{ 
        _data.push({name : "is_2307" ,value : 0}); }

        console.log(_data);
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Cash_vouchers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))

        });
    };

    var updateJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        if($('#is_2307').is(':checked')==true){
        _data.push({name : "is_2307" ,value : 1}); }else{ 
        _data.push({name : "is_2307" ,value : 0}); }
        console.log(_data)
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Cash_vouchers/transaction/update?id="+_selectedID,
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var get_dr_balance_qty=function(id){
        var _data=$('#').serializeArray();
        _data.push({name : "dr_invoice_id" ,value : id});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Cash_vouchers/transaction/get_dr_balance",
            "data":_data
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
        $('input,textarea',f).val('');
        $('#tbl_entries > tbody tr').slice(2).remove();
        $('#tbl_entries > tfoot tr').find(oTFSummary.dr).html('<b>0.00</b>');
        $('#tbl_entries > tfoot tr').find(oTFSummary.cr).html('<b>0.00</b>');
    };

    function get_button_rr(b){
        if(b == 1){
            $('#btn_rr').html('X');
            btn_rr_status = 1;
        }else if(b == 2){
            $('#btn_rr').html('...');
            btn_rr_status = 2;
        }else if(b == 3){
            $('#btn_rr').html('<i class="fa fa-code"></i>');
            btn_rr_status = 3;
        }
    }   

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

    var recomputeCheckAmount=function(tbl){
        var oRows=tbl.find('tbody tr');
        var totalAmount = 0; var _DR_amount=0; var _CR_amount;

        $.each(oRows,function(i,value){

            var for_cib = accounting.unformat($(this).find(oTBJournal.account).find('select').find('option:selected').data('cib'));

            _DR_amount=getFloat($(this).find(oTBJournal.dr).find('input.numeric').val());
            _CR_amount=getFloat($(this).find(oTBJournal.cr).find('input.numeric').val());

            if (for_cib == 1){
                totalAmount += (_DR_amount + _CR_amount);
            }

        });

        $('#cash_amount').val(accounting.formatNumber(totalAmount,2));

    }

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
    
    var validateRequiredFields=function(f, status=false){
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
                if($(this).val()=="" || $(this).val() <= 0){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }



        });

        if(status){

            if(!isBalance()){
                showNotification({title:"Error!",stat:"error",msg:'Please make sure Debit and Credit is balance.'});
                stat=false;
            }

            if(!isZero()){
                showNotification({title:"Error!",stat:"error",msg:'Please make sure Debit and Credit does not amount to zero.'});
                stat=false;
            }

        }

        return stat;
    };

    var isZero=function(opTable=null){
        reComputeTotals($('#tbl_entries'));
        var oRow; var dr; var cr;

        if(opTable==null){
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr!=0 || cr!=0);
    };

    var isBalance=function(opTable=null){
        reComputeTotals($('#tbl_entries'));
        var oRow; var dr; var cr;

        if(opTable==null){
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr==cr);
    };


});


</script>

</body>

</html>