<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->
<head>
    <meta charset="utf-8">
    <title>JCORE - <?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">
    <?php echo $_def_css_files; ?>
    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/plugins/datapicker/datetimepicker.min.css">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">
    <style>
        #span_loading_report_no{
            min-width: 50px;
        }
        #span_loading_report_no:focus{
            border: 3px solid orange;
            background-color: yellow;
        }
        .alert {
            border-width: 0;
            border-style: solid;
            padding: 24px;
            margin-bottom: 32px;
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
        .select2-dropdown{
            z-index: 999999;
        }
        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
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
        .numeric, .number{
            text-align: right;
        }
       /* .container-fluid {
            padding: 0 !important;
        }
        .panel-body {
            padding: 0 !important;
        }*/
        #btn_new {
            margin-top: 10px;
            margin-bottom: 10px;
            text-transform: uppercase!important;
        }
        @media screen and (max-width: 480px) {
            table{
                min-width: 800px;
            }
            .dataTables_filter{
                min-width: 800px;
            }
            .dataTables_info{
                min-width: 800px;
            }
            .dataTables_paginate{
                float: left;
                width: 100%;
            }
        }
        .form-group {
            margin-bottom: 15px;
        }
        #tbl_loading_filter    
        { 
            display:none; 
        } 

        .green{
            color: green;
        }
        .red{
            color: red;
        }

        #tbl_si_list_filter    
        { 
            display:none; 
        } 

    </style>
    <link type="text/css" href="assets/css/light-theme.css" rel="stylesheet">
</head>
<body class="animated-content"  style="font-family: tahoma;">
<?php echo $_top_navigation; ?>
<div id="wrapper">
<div id="layout-static">
<?php echo $_side_bar_navigation;
?>
<div class="static-content-wrapper white-bg">
<div class="static-content"  >
<div class="page-content"><!-- #page-content -->
<ol class="breadcrumb"  style="margin-bottom: 0;">
    <li><a href="Dashboard">Dashboard</a></li>
    <li><a href="Loading">Loading Report</a></li>
</ol>
<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_sales_invoice_list">
    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Sales Invoice</b>
        </div> -->
        <div class="panel-body table-responsive">
        <div class="row panel-row">
        <h2 class="h2-panel-heading">Loading Report</h2><hr>
            <div class="row"> 
                <div class="col-lg-3"><br> 
                <button class="btn btn-success" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Record New Loading" ><i class="fa fa-plus"></i> Record New Loading</button> <button id="btn_update_invoice" class="hidden">Update</button>
                </div> 
                <div class="col-lg-3"> 
                        From :<br /> 
                        <div class="input-group"> 
                            <input type="text" id="txt_start_date_sales" name="" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>"> 
                             <span class="input-group-addon"> 
                                    <i class="fa fa-calendar"></i> 
                             </span> 
                        </div>
                </div>
                <div class="col-lg-3"> 
                        To :<br /> 
                        <div class="input-group"> 
                            <input type="text" id="txt_end_date_sales" name="" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>"> 
                             <span class="input-group-addon"> 
                                    <i class="fa fa-calendar"></i> 
                             </span> 
                        </div> 
                </div> 
                <div class="col-lg-3"> 
                        Search :<br /> 
                         <input type="text" id="tbl_loading_search" class="form-control"> 
                </div> 
            </div> 
            <table id="tbl_loading" class="table table-striped" cellspacing="0" width="100%" style="">
                <thead >
                <tr>
                    <th></th>
                    <th width="15%">Loading #</th>
                    <th>Date</th>
                    <th width="10%">Truck</th>
                    <th>Place</th>
                    <th width="20%">Remarks</th>
                    <th>Total</th>
                    <th>Invoices</th>
                    <th width="10%"><center>Action</center></th>
                    <th>Loading ID</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        </div>
        <!-- <div class="panel-footer"></div> -->
    </div>
</div>
<div id="div_sales_invoice_fields" style="display: none;">
    <div class="panel panel-default">
        <div class="pull-right">
            <h4 class="sales_invoice_title" style="margin-top: 0%;"></h4>
            <div class="btn btn-green" style="margin-left: 10px;">
                <strong><a id="btn_receive_si" href="#" style="text-decoration: none; color: white;">Create from Sales Order</a></strong>
            </div>
        </div>
        <div class="panel-body" >
        <div class="row panel-row">
            <form id="frm_loading" role="form" class="form-horizontal">
                <h2 class="h2-panel-heading">Loading # : <span id="span_loading_report_no">INV-XXXX</span></h4>
                <div>
                <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <b class="required">*</b> <label> Truck :</label> <br />
                            <select name="agent_id" id="cbo_agents" data-error-msg="Agent is required." required>
                                <option value="0">[ Create New Agent ]</option>
                                <?php foreach($agents as $agent){ ?>
                                    <option value="<?php echo $agent->agent_id; ?>"><?php echo $agent->agent_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>              

                        <div class="col-sm-5">
                            <b class="required">*</b> <label> Route :</label><br>
                            <input class="form-control" id="txt_route" type="text" name="loading_place" placeholder="Route" required data-error-msg="Route is required.">
                        </div>        
                        <div class="col-sm-1">
                            <label>Invoices #</label> <br />
                            <center>
                                <button type="button" class="btn btn-default" id="link_browse" style="padding: 5px!important;width: 100%;">...</button>
                            </center>
                        </div>
                        <div class="col-sm-2">                        
                            <b class="required">*</b> <label>Loading Date :</label> <br />
                            <div class="input-group">
                                <input type="text" name="loading_date" id="invoice_default" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Invoice" data-error-msg="Please set the date!" required>
                                 <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label> Driver :</label><br>
                            <input class="form-control" id="driver_name" type="text" name="driver_name" placeholder="Driver Name" data-error-msg="Driver is required.">
                        </div>
                        <div class="col-sm-3">
                            <label> Pahinante :</label><br>
                            <input class="form-control" id="driver_pahinante" type="text" name="driver_pahinante" placeholder="Pahinante" data-error-msg="Pahinante is required.">
                        </div>
                        <div class="col-sm-2">
                            <label> Total Invoices :</label><br>
                            <input class="form-control number" id="total_invoices" type="text" name="total_invoices" placeholder="Total Invoices" readonly>
                        </div>
                        <div class="col-sm-1">
                            <div class="switch_button_panel">
                                <label>Switch <i id="switch_icon"></i></label> <br />
                                <center>
                                    <button type="button" class="btn btn-default" id="link_transfer" style="padding: 5px!important;width: 100%;">...</button>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>Loading Time : </label> <br/>
                            <div class="input-group">
                                <input type="text" name="invoice_time" class="time-picker form-control" placeholder="Delivery Time">
                                <span class="input-group-addon">
                                         <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10">
                            <label> Daily Allowance :</label><br>
                            <input type="text" class="numeric form-control" id="allowance_amount" name="allowance_amount" placeholder="Daily Allowance" data-error-msg="Daily Allowance is required." data-default="<?php echo $accounts[0]->daily_allowance; ?>">
                        </div>
                    </div>
                    
                    <div class="row" id="transfer-details-panel" style="display: none;">
                        <div class="col-sm-4">
                            <input type="text" class="hidden" name="transfer_id" id="transfer_id">
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <span id="switch_details" style="float: right;"></span>
                        </div>
                        <div class="col-sm-2">
                            <br>
                            <button type="button" class="btn btn-danger" id="btn_cancel_switch" style="width: 100%;">Cancel Switch</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div>
        <br/>
        <form id="frm_items">
            <div class="table-responsive">
                <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                    <thead class="">    
                    <tr>
                        <th>SI#</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th class="text-right">Order OIL/ BASYO QTY</th>
                        <th class="text-right">Invoice Amount</th>
                        <th width="20%"><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="height: 20px;color: gray;letter-spacing: 1px;"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total :</strong></td>
                            <td class="text-right" style="font-weight: bold;" id="td_grand_total_inv_qty">0.00</td>
                            <td class="text-right" style="font-weight: bold;" id="td_grand_total_amount">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
        </div>
        <div class="row">
            <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row"><hr>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label ><strong>Remarks :</strong></label>
                        <div class="col-lg-12" style="padding: 0%;">
                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <br />
    </div>
    <div class="panel-footer" >
        <div class="row">
            <div class="col-sm-12">
                <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>Save Changes</button>
                <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
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
<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_si_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Sales Invoice</h2>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-lg-3"> 
                            From :<br /> 
                            <div class="input-group"> 
                                <input type="text" id="txt_start_date_si" name="" class="date-picker form-control date_filter" value="<?php echo date("m/d/Y"); ?>"> 
                                 <span class="input-group-addon"> 
                                        <i class="fa fa-calendar"></i> 
                                 </span> 
                            </div> 
                    </div> 
                    <div class="col-lg-3"> 
                            To :<br /> 
                            <div class="input-group"> 
                                <input type="text" id="txt_end_date_si" name="" class="date-picker form-control date_filter" value="<?php echo date("m/d/Y"); ?>"> 
                                 <span class="input-group-addon"> 
                                        <i class="fa fa-calendar"></i> 
                                 </span> 
                            </div> 
                    </div> 
                    <div class="col-lg-3 col-lg-offset-3"> 
                            Search :<br /> 
                             <input type="text" id="tbl_sales_invoice_search" class="form-control"> 
                    </div> 
                </div> <br>
                <table id="tbl_si_list" class="table table-striped" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th></th>
                        <th>SI#</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Loading#</th>
                        <th>Truck</th>
                        <th>Amount</th>
                        <th><center>Action</center></th>
                        <th>Sales Invoice ID</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Sales Invoice Content -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="cancel_modal" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
<div class="clearfix"></div>
</div><!---modal-->

<div id="modal_new_agent" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="department_title" class="modal-title" style="color:white;">Create New Agent</h2>
            </div>
            <div class="modal-body">
                <form id="frm_agent_new" role="form" class="form-horizontal">
                    <div class="row" style="margin: 1%;">
                        <div class="col-lg-12">
                            <div class="form-group" style="margin-bottom:0px;">
                                <label class=""><b>*</b>Agent Code :</label>
                                <input type="text" class="form-control" name="agent_code" id="agent_code" data-error-msg="Agent Code is required." placeholder="Agent Code" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 1%;">
                        <div class="col-lg-12">
                            <div class="form-group" style="margin-bottom:0px;">
                                <label class="">Agent Name :</label>
                                <input type="text" class="form-control" name="agent_name" id="agent_name" data-error-msg="Agent Name is required." placeholder="Agent Name" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_save_agent" class="btn btn-primary">Save</button>
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_transfer_invoice" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="department_title" class="modal-title" style="color:white;">Switch Invoices</h2>
            </div>
            <div class="modal-body">
                <form id="frm_transfer" role="form" class="form-horizontal">
                    <div class="row" style="margin: 1%;">
                        <div class="col-lg-12">
                            <b class="required">*</b> <label> Switch to Truck :</label> <br />
                            <select name="agent_id_transfer" id="cbo_agents_transfer" data-error-msg="Agent is required." required>
                                <?php foreach($agents as $agent){ ?>
                                    <option value="<?php echo $agent->agent_id; ?>"><?php echo $agent->agent_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_switch_invoice" class="btn btn-primary">Switch</button>
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_transfer_invoice_items" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #2ecc71">
                 <h2 id="department_title" class="modal-title" style="color:white;">Transfer Invoice</h2>
            </div>
            <div class="modal-body">
                <form id="frm_transfer" role="form" class="form-horizontal">
                    <div class="row" style="margin: 1%;">
                        <div class="col-lg-12">
                            <b class="required">*</b> <label> Loading # :</label> <br />
                            <select name="transfer_loading_id" id="transfer_loading_id" data-error-msg="Loading No is required!" required>
                                <?php foreach($loadings as $loading){ ?>
                                    <option value="<?php echo $loading->loading_id; ?>" data-loading-no="<?php echo $loading->loading_no; ?>">
                                        <?php echo $loading->loading_no.' - '.$loading->agent_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_transfer_invoice" class="btn btn-primary">Transfer</button>
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

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
<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/datapicker/moment.min.js"></script> 
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="assets/plugins/datapicker/datetimepicker.min.js"></script>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!-- twitter typehead -->
<script src="assets/plugins/twittertypehead/handlebars.js"></script>
<script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.bundle.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>
<!-- touchspin -->
<script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _selectRowObjSI; 
    var dt_si; var products; var changetxn; var invoice_id;
    var prodstat; var is_switch; var _cboLoadingNo;
    var _line_unit; var _cboAgents; var _cboAgentsTransfer;

    var reInitializeTime = function(){
        $('.time-picker').datetimepicker({
            format: 'LT'
        });
    };

    var oTableItems={
        invoice_id : 'td:eq(0)',
        sales_inv_no : 'td:eq(1)',
        customer: 'td:eq(2)',
        address : 'td:eq(3)',
        total_inv_qty : 'td:eq(4)',
        total_amount : 'td:eq(5)',
        action : 'td:eq(6)'
 
    };
    var oTableDetails={
        grand_total_inv_qty : 'td:eq(1)',
        grand_total_amount : 'td:eq(2)'
    };
    var initializeControls=function(){

        dt=$('#tbl_loading').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 9, "desc" ]],
            "ajax" : { 
                "url":"Loading/transaction/list", 
                "bDestroy": true,             
                "data": function ( d ) { 
                        return $.extend( {}, d, { 
                            "tsd":$('#txt_start_date_sales').val(), 
                            "ted":$('#txt_end_date_sales').val() 
                        }); 
                    } 
            }, 
            "language": {
                "searchPlaceholder":"Search Loading"
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "loading_no" },
                { targets:[2],data: "loading_date" },
                { targets:[3],data: "agent_name" },
                { targets:[4],data: "loading_place" },
                { targets:[5],data: "remarks"  ,render: $.fn.dataTable.render.ellipsis(30)},
                { sClass:"text-right", targets:[6],data: null,
                    render: function (data, type, full, meta){
                        return accounting.formatNumber(data.grand_total_amount,2);
                    }
                },
                { targets:[7],data: null,
                    render: function (data, type, full, meta){
                        return accounting.formatNumber(data.total,0);
                    }
                },                
                {
                    targets:[8],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                        return '<center>'+btn_edit+"&nbsp;"+btn_trash+'</center>';
                    }
                },
                { targets:[9],data: "loading_id", visible:false }
            ]
        });

        dt_si=$('#tbl_si_list').DataTable({
            "bLengthChange":false,
            "order": [[ 8, "asc" ]],
            "ajax" : { 
                "url":"Sales_invoice/transaction/open", 
                "bDestroy": true,             
                "data": function ( d ) { 
                        return $.extend( {}, d, { 
                            "start_date":$('#txt_start_date_si').val(),
                            "end_date":$('#txt_end_date_si').val()                            
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
                { targets:[1],data: "sales_inv_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "address" },
                { targets:[4],data: "loading_no",
                    render: function (data, type, full, meta){
                        return '<span style="color: red;">'+data+'</span>';
                    }
                },
                { targets:[5],data: "agent_name",
                    render: function (data, type, full, meta){
                        return '<span style="color: red;">'+data+'</span>';
                    }
                },
                { sClass:"text-right", targets:[6],data: null,
                    render: function (data, type, full, meta){
                        return accounting.formatNumber(data.total_after_discount,2);
                    }
                },
                {
                    targets:[7],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_si"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Accrpt SI"><i class="fa fa-check"></i> Accept SI</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                },
                { visible:false,targets:[8],data: "sales_invoice_id" }
            ]
        });

        $('.numeric').autoNumeric('init');
        $('.number').autoNumeric('init', {"mDec": '0'});

        _cboLoadingNo=$("#transfer_loading_id").select2({
            placeholder: "Please select Loading No.",
            allowClear: false
        });

        _cboLoadingNo.select2('val', null);

        _cboAgents=$("#cbo_agents").select2({
            placeholder: "Please select truck.",
            allowClear: false
        });

        _cboAgents.select2('val', null);

        _cboAgentsTransfer=$("#cbo_agents_transfer").select2({
            placeholder: "Please select truck.",
            allowClear: false
        });

        _cboAgentsTransfer.select2('val', null);        

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

    }();

    var bindEventHandlers=(function(){

        var detailRows = [];

        $('#tbl_loading tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/loading-report/"+ d.loading_id+'?type=dropdown',
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
        });


        $('#link_browse').click(function(){

            if($('#cbo_agents').val() == 0 || $('#cbo_agents').val() == null || "" ){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Please select a truck."});
                return;
            }

            $('#btn_receive_si').click();
        });


        $('#link_transfer').click(function(){

            if($('#cbo_agents').val() == 0 || $('#cbo_agents').val() == null || "" ){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Please select a truck."});
                return;
            }

            _cboAgentsTransfer.select2('val',null);
            $('#btn_switch_invoice').prop('disabled', false);
            $('#modal_transfer_invoice').modal('show');
        });


        $('#tbl_si_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt_si.row( tr );
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
                    "url":"Templates/layout/sales-invoice/"+ d.sales_invoice_id+'?type=dropdown',
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
        });

        $("#tbl_loading_search").keyup(function(){          
                dt 
                .search(this.value) 
                .draw(); 
        }); 

        $("#tbl_sales_invoice_search").keyup(function(){          
                dt_si 
                .search(this.value) 
                .draw(); 
        }); 

        $("#txt_start_date_sales").on("change", function () {         
            $('#tbl_loading').DataTable().ajax.reload() 
        }); 

        $("#txt_end_date_sales").on("change", function () {         
            $('#tbl_loading').DataTable().ajax.reload() 
        }); 

        var getInvoices=function(switch_id){

            $('#tbl_si_list tbody').html('<tr><td colspan="8"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_si.ajax.reload( null, false ); 

            var loading_date = $('input[name="loading_date"]').val();
            var agent_id;

            if(switch_id==1){
                agent_id = $('#transfer_id').val();
                is_switch=1;
            }else{
                agent_id = $('#cbo_agents').val();
                is_switch=0;
            }

            var formattedDate = new Date(loading_date);
            var d = formattedDate.getDate();
            var m =  formattedDate.getMonth();
            m += 1;  // JavaScript months are 0-11
            var y = formattedDate.getFullYear();

            var date = d+'-'+m+'-'+y;
            
            $.ajax({
                url : 'Sales_invoice/transaction/open-si/'+agent_id+'/'+date,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="6"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');
                    $.each(rows,function(i,value){
                        var classhidden="hidden";
                        if(_txnMode=="edit"){
                            classhidden = "";
                        }

                        $('#tbl_items > tbody').prepend(newRowItem({
                            invoice_id : value.sales_invoice_id,
                            sales_inv_no : value.sales_inv_no,
                            customer_id : value.customer_id,
                            customer_name : value.customer_name,
                            address: value.address,
                            total_after_discount : value.total_after_discount,
                            total_inv_qty : value.total_inv_qty,
                            btnclass : "",
                            btnclasshidden : classhidden
                        })); 

                    });

                    reComputeTotal();
                    recomputeTotalInvoices();
                }
            });
        };

        //loads modal to create new agent
        _cboAgents.on('select2:select', function(){
            if (_cboAgents.val() == 0) {
                clearFields($('#frm_agent_new'));
                _cboAgents.select2('val',null)
                $('#modal_new_agent').modal('show');
            }else{
                if(_txnMode == "new"){
                    getInvoices(0);
                }
                $('#txt_route').focus();
            }
        });

        //loads modal to create new agent
        _cboAgentsTransfer.on('select2:select', function(){

            var agent_id = _cboAgents.val();
            var transfer_id = $(this).val();

            if(agent_id == transfer_id){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Truck must not be the same with the truck you will transfer."});
                $('#btn_switch_invoice').prop('disabled', true);
                return;
            }else{
                $('#btn_switch_invoice').prop('disabled', false);
            }

        });       

        _cboLoadingNo.on('select2:select', function(){

            var loading_id = $(this).val();

            if(_selectedID == loading_id){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Loading # must not be the same with the loading you will transfer."});
                $('#btn_transfer_invoice').prop('disabled', true);
                return;
            }else{
                $('#btn_transfer_invoice').prop('disabled', false);
            }

        });                

        $('#btn_switch_invoice').on('click', function(){

            var transfer_id = $('#cbo_agents_transfer').val();

            if(transfer_id==null){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Please select a truck to switch invoices."});
                    return;
            }

            $('#cbo_agents').prop('disabled', true);
            $("#switch_icon").removeAttr('class');
            $('#switch_icon').addClass('fa fa-check-circle green');
            $('#transfer_id').val(transfer_id);

            var truck_from = $('#cbo_agents option:selected').text();
            var truck_to = $('#cbo_agents_transfer option:selected').text();
            var details = 'Switching Invoices from <b>'+ truck_to +'</b> to <b>'+truck_from+'</b>';
            $('#switch_details').html(details);
            $('#transfer-details-panel').show();
            $('#modal_transfer_invoice').modal('hide');
            getInvoices(1);
        });

        $('#btn_transfer_invoice').on('click', function(){

            var transfer_id = $('#transfer_loading_id').val();
            var loading_no = $('#transfer_loading_id option:selected').data('loading-no');

            if(transfer_id==null){
                showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Please select a loading no to transfer invoice."});
                    return;
            }   

            _selectRowObjTransfer.find('input.transfer_id').val(transfer_id);
            _selectRowObjTransfer.find('input.for_transfer').val(1);
            _selectRowObjTransfer.find('.btn_for_transfer').removeClass('btn-orange');
            _selectRowObjTransfer.find('.btn_for_transfer').addClass('btn-green');
            _selectRowObjTransfer.find('.btn_for_transfer').find('i').removeClass();
            _selectRowObjTransfer.find('.btn_for_transfer').find('i').addClass('fa fa-times-circle');
            _selectRowObjTransfer.find('.btn-red').hide();
            _selectRowObjTransfer.find('.for_transfer_panel').html('(TRANSFER TO <b>'+loading_no+'</b>)');

            $('#modal_transfer_invoice_items').modal('hide');
        });

        $('#btn_cancel_switch').on('click', function(){

            $('#cbo_agents').prop('disabled', false);
            $("#switch_icon").removeAttr('class');
            $('#transfer-details-panel').hide();
            getInvoices(0);
        });

        $('#txt_route').on('keypress',function(evt){
            if(evt.keyCode==13){
                evt.preventDefault();
                $('#driver_pahinante').focus();
            }
        });       

        $('input[name="loading_date"]').on('change',function(){
            if(_txnMode == "new"){
                getInvoices(0);
            }
        });

        //create new agent
        $('#btn_save_agent').click(function(){
            var btn=$(this);
            if(validateRequiredFields($('#frm_agent_new'))){
                var data=$('#frm_agent_new').serializeArray();
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Agent/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_new_agent').modal('hide');
                    var _agent=response.row_added[0];
                    $('#cbo_agents').append('<option value="'+_agent.agent_id+'" selected>'+_agent.agent_name+'</option>');
                    $('#cbo_agents').select2('val',_agent.agent_id);
                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#btn_receive_si').click(function(){

            var loading_date = $('#invoice_default').val();
            $('.date_filter').val(loading_date);

            $('#tbl_si_list tbody').html('<tr><td colspan="8"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_si.ajax.reload( null, false );
            $('#modal_si_list').modal('show');
        });

        $('.date_filter').on("change", function(){
            $('#tbl_si_list tbody').html('<tr><td colspan="8"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_si.ajax.reload( null, false );
        }); 

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#div_sales_invoice_fields'));
            $('#span_loading_report_no').html('LOADING-YYYYMMDD-XX');
            $('#cbo_agents').select2('val',null);
            $('#allowance_amount').val(accounting.formatNumber($('#allowance_amount').data('default'),2));
            $("#switch_icon").removeAttr('class');
            $('#transfer-details-panel').hide();
            $('.switch_button_panel').show();
            $('#cbo_agents').prop('disabled', false);
            showList(false);

            $('#cbo_agents').select2('open');
            $('#tbl_items > tbody').html('');
            $('#invoice_default').datepicker('setDate', 'today');

            reInitializeTime();

            var current_time = "<?php echo date("h:i A"); ?>";
            $('.time-picker').val(current_time);

            reComputeTotal(); //this is to make sure, display summary are recomputed as 0
        });
        $('#tbl_si_list > tbody').on('click','button[name="accept_si"]',function(){
            _selectRowObjSI=$(this).closest('tr');
            var data=dt_si.row(_selectRowObjSI).data();

            if(!(checkInvoice(data.sales_invoice_id))){ // Checks if item is already existing in the Table of Items for invoice
                showNotification({title: data.sales_inv_no,stat:"error",msg: "Invoice is Already Added."});
                return;
            }

            var classhidden="hidden";
            if(_txnMode=="edit"){
                classhidden = "";
            }

            $('#tbl_items > tbody').prepend(newRowItem({
                invoice_id : data.sales_invoice_id,
                sales_inv_no : data.sales_inv_no,
                customer_id : data.customer_id,
                customer_name : data.customer_name,
                address: data.address,
                total_after_discount : data.total_after_discount,
                total_inv_qty : data.total_inv_qty,
                btnclass : "",
                btnclasshidden : classhidden
            }));

            _selectRowObjSI.remove();
            recomputeTotalInvoices();
            reComputeTotal();
        });

        $('#tbl_loading tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.loading_id;

            $("#switch_icon").removeAttr('class');
            $('#transfer-details-panel').hide();
            $('.switch_button_panel').hide();
            $('#cbo_agents').prop('disabled', false);

            $('#span_loading_report_no').html(data.loading_no);
            
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });

            $('#cbo_agents').select2('val',data.agent_id);

            $.ajax({
                url : 'Loading/transaction/items/'+data.loading_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="6"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');

                    $.each(rows,function(i,value){
                        attr = "";

                         // if (value.is_journal_posted == 1){
                         //    attr = "hidden";
                         // }

                        var classhidden="hidden";
                        if(_txnMode=="edit"){
                            classhidden = "";
                        }

                        $('#tbl_items > tbody').append(newRowItem({
                            invoice_id : value.invoice_id,
                            sales_inv_no : value.sales_inv_no,
                            customer_id : value.customer_id,
                            customer_name : value.customer_name,
                            address: value.address,
                            total_after_discount : value.total_after_discount,
                            total_inv_qty : value.total_inv_qty,
                            btnclass : attr,
                            btnclasshidden : classhidden

                        }));
                    });

                    recomputeTotalInvoices();
                    reComputeTotal();
                    reInitializeNumeric();
                }
            });

            reInitializeTime();
            showList(false);

        });

        $('#tbl_loading tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.loading_id;

            // $.ajax({
            //     "url":"Loading/transaction/check-invoices-posted?id="+_selectedID,
            //     type : "GET",
            //     cache : false,
            //     dataType : 'json',
            //     processData : false,
            //     contentType : false,
            //     }).done(function(response){
            //         var row = response.data[0];

            //         if(row.total_posted > 0){
            //             showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Cannot Delete: Invoices is already Posted in Sales Journal."});
            //         }else {
            //             $('#modal_confirmation').modal('show');
            //         }
            // });
            
            $('#modal_confirmation').modal('show');
        });

    
        $('#btn_yes').click(function(){
            removeLoading().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }
            });
        });

        $('#btn_cancel').click(function(){
            showList(true);
        });

        $('#btn_update_invoice').click(function(){
            updateInvoices().done(function(response){
                showNotification(response);
            });
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_loading'))){
                if(validateTableItems()){
                    if(_txnMode=="new"){
                        createLoading().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_loading'));
                            showList(true);
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateLoading().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields($('#frm_loading'));
                            showList(true);
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                }
            }
        });
       
        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotal();
            recomputeTotalInvoices();
        });

        $('#tbl_items > tbody').on('click','button[name="transfer_item"]',function(){
            invoice_id = $(this).closest('tr').find('input.invoice_id').val();
            var for_transfer = $(this).closest('tr').find('input.for_transfer').val();
            _cboLoadingNo.select2('val', null);
            _selectRowObjTransfer=$(this).closest('tr');

            if (for_transfer <= 0){
                $('#modal_transfer_invoice_items').modal('show');

            }else{
                $(this).closest('tr').find('input.transfer_id').val(0);
                $(this).closest('tr').find('input.for_transfer').val(0);
                $(this).closest('tr').find('.btn_for_transfer').removeClass('btn-green');
                $(this).closest('tr').find('.btn_for_transfer').addClass('btn-orange');
                $(this).closest('tr').find('.btn_for_transfer').find('i').removeClass();
                $(this).closest('tr').find('.btn_for_transfer').find('i').addClass('fa fa-share-square-o');
                $(this).closest('tr').find('.btn-red').show();
                $(this).closest('tr').find('.for_transfer_panel').html('');
            }

            // reComputeTotal();
            // recomputeTotalInvoices();

        });

    })();

    var validateRequiredFields=function(f){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){
                if($(this).is('select')){
                    if($(this).val()==0 || $(this).val()==null || $(this).val()==undefined || $(this).val()==""){
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

    var validateTableItems=function(){
        var stat=true;

        var total_item_rows = $('#tbl_items > tbody tr').length;
        
        if(total_item_rows<=0){
            showNotification({title:"Error!",stat:"error",msg:"Please select atleast 1 invoice to proceed."});
            stat=false;
            return false;
        }

        return stat;
    };

    var updateInvoices=function(){
        var _data=$('#').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Loading/transaction/update_invoices",
            "data":_data
        });        
    };

    var createLoading=function(){
        var _data=$('#frm_loading,#frm_items').serializeArray();
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "grand_total_amount", value: $('#td_grand_total_amount').text()});
        _data.push({name : "grand_total_inv_qty", value: $('#td_grand_total_inv_qty').text()});
        _data.push({name : "is_switch", value: is_switch});
        _data.push({name : "agent_id", value: $('#cbo_agents').val()});

        // $('input[name="is_auto_print"]').prop("checked") ?  _data.push({name : "is_auto_print" , value : '1'   }) : _data.push({name : "is_auto_print" , value : '0'   });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Loading/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateLoading=function(){
        var _data=$('#frm_loading,#frm_items').serializeArray();
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "grand_total_amount", value: $('#td_grand_total_amount').text()});
        _data.push({name : "grand_total_inv_qty", value: $('#td_grand_total_inv_qty').text()});
        _data.push({name : "loading_id" ,value : _selectedID});

        // $('input[name="is_auto_print"]').prop("checked") ?  _data.push({name : "is_auto_print" , value : '1'   }) : _data.push({name : "is_auto_print" , value : '0'   });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Loading/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeLoading=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Loading/transaction/delete",
            "data":{loading_id : _selectedID}
        });
    };
    var showList=function(b){
        if(b){
            $('#div_sales_invoice_list').show();
            $('#div_sales_invoice_fields').hide();
            $('.datepicker.dropdown-menu').hide();
        }else{
            $('#div_sales_invoice_list').hide();
            $('#div_sales_invoice_fields').show();
        }
    };
    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };
    var clearFields=function(f){
        $('input,textarea,select,input:not(.date-picker)',f).val('');
        $('#remarks').val('');
        $(f).find('input:first').focus();
    };
    function format ( d ) {
        //return
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
    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };
    var newRowItem=function(d){

        return '<tr>'+
        //DISPLAY
        '<td class="hidden"><input name="transfer_id[]" type="text" class="form-control transfer_id" value=""><input name="for_transfer[]" type="text" class="form-control for_transfer" value=""><input name="invoice_id[]" type="text" class="form-control invoice_id" value="'+d.invoice_id+'"></td>'+
        '<td width="15%">'+d.sales_inv_no+'</td>'+
        '<td width="20%">'+d.customer_name+' <span style="color: red;" class="for_transfer_panel"></span></td>'+
        '<td width="20%">'+d.address+'</td>'+
        '<td width="15%" class="text-right"><input type="text" name="total_inv_qty[]" class="form-control numeric text-right" readonly value="'+accounting.formatNumber(d.total_inv_qty,2)+'"></td>'+
        '<td width="15%" class="text-right"><input type="text" name="total_after_discount[]" class="form-control numeric text-right" readonly value="'+accounting.formatNumber(d.total_after_discount,2)+'"></td>'+
        '<td width="15%" align="center"><button type="button" name="transfer_item" class="btn btn-orange btn-sm btn_for_transfer '+d.btnclasshidden+'" style="margin-right: 10px;"><i class="fa fa-share-square-o"></i></button><button type="button" name="remove_item" class="btn btn-red btn-sm '+d.btnclass+'"><i class="fa fa-trash"></i></button></td>'+
        '<td class="hidden"><input name="customer_id[]" type="text" class="form-control" value="'+d.customer_id+'" readonly></td>'+
        '<td class="hidden"><input name="address[]" type="text" class="form-control" value="'+d.address+'" readonly></td>'+
        '</tr>';
    };
    var reComputeTotal=function(){

        var rows=$('#tbl_items > tbody tr');
        var grand_total_inv_qty = 0;
        var grand_total_amount = 0;

        $.each(rows,function(){
            grand_total_inv_qty+=parseFloat(accounting.unformat($(oTableItems.total_inv_qty,$(this)).find('input.numeric').val()));
            grand_total_amount+=parseFloat(accounting.unformat($(oTableItems.total_amount,$(this)).find('input.numeric').val()));
        });

        $('#td_grand_total_inv_qty').html(accounting.formatNumber(grand_total_inv_qty,2));
        $('#td_grand_total_amount').html(accounting.formatNumber(grand_total_amount,2));
    };

    var recomputeTotalInvoices=function(){
        var rowCount = $('#tbl_items > tbody > tr').length;
        $('#total_invoices').val(rowCount);
    };
               
    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
        $('.number').autoNumeric('init', {"mDec": '0'});
    };


    var checkInvoice= function(check_id){
        var prodstat=true;
        var rowcheck=$('#tbl_items > tbody tr');

        $.each(rowcheck,function(){
            item = parseFloat(accounting.unformat($(oTableItems.invoice_id,$(this)).find('input.invoice_id').val()));
            if(check_id == item){
                prodstat=false;
                return false;
            }
        });
         return prodstat;    
    };

    setInterval(function(){
    //console.log('test');
      if(!$("body").hasClass("modal-open")) return;
      var modalDialog = $(".modal.in > .modal-dialog");
      var backdrop = $(".modal.in > .modal-backdrop");
      var backdropHeight = backdrop.height();
      var modalDialogHeight = modalDialog.height();
      if(modalDialogHeight > backdropHeight) backdrop.height(modalDialogHeight+100);
    }, 500)
});
</script>
</body>
</html>