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
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>

    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>


    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/js/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- twitter typehead -->
    <script src="assets/plugins/twittertypehead/handlebars.js"></script>
    <script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

    <!-- touchspin -->
    <script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
    <style>

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


        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .numeric{
            text-align: right;
        }

        #btn_new {
            text-transform: capitalize!important;
        }

        .boldlabel {
            font-weight: bold;
        }

        textarea {
            resize: none;
        }

        #tbl_vehicles_filter{
            display: none;
        }

        .vehicle_panel{
            width: 100%;
            height: 100%; 
            border-radius: .5em;
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

                    <ol class="breadcrumb" style="margin:0%;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Vehicles">Vehicles</a></li>
                    </ol>


                <div class="container-fluid">
                        <div data-widget-group="group1">    
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_vehicle_list">
                                        <div class="panel panel-default">                  
                                            <div class="panel-body table-responsive" style="width: 100%;overflow-x: hidden;">
                                            <h2 class="h2-panel-heading"><i class="fa fa-car"></i> Vehicles Management</h2><hr>

                                            <div class="row">
                                                <div class="col-lg-3"><br>
                                                        <button class="btn btn-primary" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;margin-bottom: 0px !important; float: left;" data-toggle="modal" data-target="" data-placement="left" title=" New product" ><i class="fa fa-plus"></i>  New Vehicle</button>
                                                </div>
                                                <div class="col-lg-3" style="text-align: right;">
                                                &nbsp;<br>
                                                        <button class="btn btn-primary hidden" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print Supplier Masterfile" ><i class="fa fa-print"></i> Print</button> &nbsp;
                                                        <button class="btn btn-success hidden" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Export Supplier Masterfile" ><i class="fa fa-file-excel-o"></i> Export</button>
                                                </div>
                                                <div class="col-lg-3">
                                                    Customer :
                                                    <select class="form-control" id="cbo_customers_tbl">
                                                        <option value="0">All Customers</option>
                                                        <?php foreach($customers as $customer){ ?>
                                                            <option value="<?php echo $customer->customer_id ?>">
                                                                <?php echo $customer->customer_no.' - '.$customer->customer_name; ?>
                                                            </option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    Search :<br />
                                                     <input type="text" id="searchbox_vehicles" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <table id="tbl_vehicles" class="table table-striped" cellspacing="0" width="100%">
                                                <thead class="">
                                                <tr>
                                                    <th>&nbsp;&nbsp;</th>
                                                    <th>Customer</th>
                                                    <th>Model</th>
                                                    <th>Conduction No</th>
                                                    <th>Plate No</th>
                                                    <th><center>Active No</center></th>
                                                    <th><center>Action</center></th>
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
                </div> <!-- .container-fluid -->

                </div> <!-- #page-content -->
            </div>


            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>
                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->

            <div id="modal_create_vehicle" class="modal fade" role="dialog"><!--modal-->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                         <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"></span> Vehicle Information</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frm_vehicle">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="vehicle_panel">
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Customer : </label>
                                                    <select name="customer_id" id="cbo_customers" class="form-control" required data-error-msg="Customer is required!" style="width: 100%;">
                                                        <option value="0">[ Create New Customer ]</option>
                                                        <?php foreach($customers as $customer){?>
                                                            <option value="<?php echo $customer->customer_id; ?>">
                                                                <?php echo $customer->customer_no.' - '.$customer->customer_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                             <div class="form-group">
                                                <h4>Vehicle Information</h4>
                                                <hr>
                                             </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Delivery Date :</label> <br />
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" name="delivery_date" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Delivery Date" data-error-msg="Delivery Date!" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="vehicle_panel">
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Make : </label>
                                                    <select name="make_id" id="cbo_makes" class="form-control" required data-error-msg="Make is required!" style="width: 100%;">
                                                        <option value="0">[ Create New Make ]</option>
                                                        <?php foreach($makes as $make){?>
                                                            <option value="<?php echo $make->make_id; ?>">
                                                                <?php echo $make->make_desc; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Year : </label>
                                                    <select name="vehicle_year_id" id="cbo_years" class="form-control" required data-error-msg="Year is required!" style="width: 100%;">
                                                        <option value="0">[ Create New Vehicle Year ]</option>
                                                        <?php foreach($years as $year){?>
                                                            <option value="<?php echo $year->vehicle_year_id; ?>">
                                                                <?php echo $year->vehicle_year; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Model : </label>
                                                    <select name="model_id" id="cbo_models" class="form-control" required data-error-msg="Model is required!" style="width: 100%;">
                                                        <option value="0">[ Create New Model ]</option>
                                                        <?php foreach($models as $model){?>
                                                            <option value="<?php echo $model->model_id; ?>">
                                                                <?php echo $model->model_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Color : </label>
                                                    <select name="color_id" id="cbo_colors" class="form-control" required data-error-msg="Color is required!" style="width: 100%;">
                                                        <option value="0">[ Create New Color ]</option>
                                                        <?php foreach($colors as $color){?>
                                                            <option value="<?php echo $color->color_id; ?>">
                                                                <?php echo $color->color; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="vehicle_panel">
                                                <div class="form-group">
                                                    <input type="radio" name="crp_no_type" id="cd_no" value="1" data-input="conduction_no" data-required="cd_no_req"> <label for="cd_no"> <b class="required crp_required cd_no_req"></b> Conduction No : </label>
                                                    <input type="text" class="form-control for_crp_input" name="conduction_no" placeholder="Conduction No." data-error-msg="Conduction No is required!"> 
                                                </div>
                                                <div class="form-group">
                                                    <input type="radio" name="crp_no_type" id="pl_no" value="2" data-input="plate_no" data-required="pl_no_req">
                                                    <label for="pl_no"> <b class="required crp_required pl_no_req"></b> Plate No : </label>
                                                    <input type="text" class="form-control for_crp_input" name="plate_no" placeholder="Plate No." data-error-msg="Plate No is required!"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Chassis No : </label>
                                                    <input type="text" class="form-control" name="chassis_no" placeholder="Chassis No." required data-error-msg="Chassis No is required!"> 
                                                </div>
                                                <div class="form-group">
                                                    <label><b class="required">*</b> Engine No : </label>
                                                    <input type="text" class="form-control" name="engine_no" placeholder="Engine No." required data-error-msg="Engine No is required!"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                            <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_create_customer" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"><!--modal-->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Customer Information</h4>
                        </div>

                        <div class="modal-body">
                            <form id="frm_customer">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><b class="required">*</b> Customer Name :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-users"></i>
                                                    </span>
                                                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" data-error-msg="Customer Name is required!" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Contact Person :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-users"></i>
                                                    </span>
                                                    <input type="text" name="contact_name" class="form-control" placeholder="Contact Person">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><b class="required">*</b> Address :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-home"></i>
                                                     </span>
                                                     <textarea name="address" class="form-control" data-error-msg="Supplier address is required!" placeholder="Address" required ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><b class="required">*</b> Email Address :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-envelope-o"></i>
                                                    </span>
                                                    <input type="text" name="email_address" class="form-control" placeholder="Email Address" required data-error-msg="Email Address is required!">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="col-md-12" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;">TIN :</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-file-code-o"></i>
                                                    </span>
                                                    <input type="text" name="tin_no" id="tin_no" class="form-control" placeholder="TIN">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><b class="required">*</b> Mobile No :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-mobile"></i>
                                                    </span>
                                                    <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="Mobile No" required data-error-msg="Contact No is required!">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tel No. (Home) :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </span>
                                                    <input type="text" name="tel_no_home" id="tel_no_home" class="form-control" placeholder="Tel No. (Home)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tel No. (Bus) :</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </span>
                                                    <input type="text" name="tel_no_bus" id="tel_no_bus" class="form-control" placeholder="Tel No. (Bus)">
                                                </div>
                                            </div>
                                        </div>                                     
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_save_customer" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                            <button id="btn_cancel_customer" type="button" class="btn btn-danger">Cancel</button>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->


            <div id="modal_create_make" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <h2 id="makes_title" class="modal-title" style="color:white;">Make Information</h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_makes" role="form">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class=""><b class="required"> * </b> Code :</label>
                                            <input type="text" name="make_code" class="form-control" placeholder="Code" required data-error-msg="Code is required!">
                                        </div>
                                        <div class="form-group">
                                            <label class=""><b class="required"> * </b> Description :</label>
                                            <input type="text" name="make_desc" class="form-control" placeholder="Description" required data-error-msg="Description is required!">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save_make" class="btn btn-primary">Save</button>
                            <button id="btn_cancel_make" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_create_vehicle_year" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <h2 id="vehicle_year_title" class="modal-title" style="color:white;">Vehicle Year Information</h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_vehicle_year">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class=""><b> * </b> Vehicle Year :</label>
                                            <input type="text" placeholder="Vehicle Year" class="form-control" name="vehicle_year" data-error-msg="Vehicle Year is required!" id="vehicle_year" required >
                                        </div>
                                        <div class="form-group">
                                            <label class="">Remarks :</label>
                                            <textarea name="remarks" placeholder="Remarks" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save_vehicle_year" type="button" class="btn btn-primary">Save</button>
                            <button id="btn_cancel_vehicle_year" type="button" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_create_model" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <h2 id="model_title" class="modal-title" style="color:white;">Model Information</h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_model">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label><b class="required">*</b> Model :</label>
                                            <input name="model_name" class="form-control" data-error-msg="Model is required!" placeholder="Model" id="model_text" autofocus required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save_model" class="btn btn-primary">Save</button>
                            <button id="btn_cancel_model" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_create_color" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <h2 id="color_title" class="modal-title" style="color:white;">Color Information</h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_color">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label><b class="required">*</b> Color :</label>
                                            <input type="text" placeholder="Color" class="form-control" name="color" data-error-msg="Color is required!" id="color_text" required >
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save_color" type="button" class="btn btn-primary">Save</button>
                            <button id="btn_cancel_color" type="button" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>




        </div>
    </div>


</div>

    <script>

    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboCustomersTbl;
        var _cboCustomers; var _cboMakes; var _cboYears; var _cboModels; var _cboColors;

        var initializeControls=function() {

            _cboCustomersTbl=$("#cbo_customers_tbl").select2({
                placeholder: "Please select a customer.",
                allowClear: false
            });

            dt=$('#tbl_vehicles').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange": false,
                "pageLength": 15,
                "ajax" : { 
                    "url":"Vehicles/transaction/list", 
                    "bDestroy": true,             
                    "data": function ( d ) { 
                            return $.extend( {}, d, { 
                                "customer_id":_cboCustomersTbl.select2('val')
                            }); 
                        } 
                },  
                "language": {
                    searchPlaceholder: "Search Vehicle"
                },
                oLanguage: { 
                        sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>' 
                }, 
                processing : true,                 
                "columns": [
                    {
                        "visible": false,
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "customer_name" },
                    { targets:[2],data: "model_name" },
                    { targets:[3],data: "conduction_no" },
                    { targets:[4],data: "plate_no" },
                    {
                        targets:[5], data:null,
                        render: function (data, type, full, meta){
                            var status;

                            if(data.crp_no_type == 1){
                                status = '<label class="label label-warning" style="border-radius: 1em;"><i class="fa fa-car"></i> Conduction No</label>';
                            }else{
                                status = '<label class="label label-success" style="border-radius: 1em;"><i class="fa fa-car"></i> Plate No</label>';
                            }

                            return '<center>'+status+'</center>';
                        }
                    },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"   data-toggle="tooltip" data-placement="top" title="Edit" style="margin-left:-5px;"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info"  data-toggle="tooltip" data-placement="top" title="Move to trash" style="margin-right:-5px;"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        }
                    }
                ]
            });
        
            $('.numeric').autoNumeric('init');

            _cboCustomerType=$("#cbo_customer_type").select2({
                allowClear: false
            });

            _cboCustomers=$("#cbo_customers").select2({
                placeholder: "Please select a customer.",
                allowClear: false
            });

            _cboMakes=$("#cbo_makes").select2({
                placeholder: "Please select make",
                allowClear: false
            }); 

            _cboYears=$("#cbo_years").select2({
                placeholder: "Please select a year",
                allowClear: false
            });    

            _cboModels=$("#cbo_models").select2({
                placeholder: "Please select a model",
                allowClear: false
            });  

            _cboColors=$("#cbo_colors").select2({
                placeholder: "Please select a color",
                allowClear: false
            });                                     

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

            _cboCustomersTbl.on("change", function (e) {
                $('#tbl_vehicles').DataTable().ajax.reload();
            });

            /* Customer Modal */
            _cboCustomers.on("select2:select", function (e) {
                var i=$(this).select2('val');
                if(i==0){ 
                    _cboCustomers.select2('val',null);
                    clearFields($('#frm_customer'));
                    $('#modal_create_customer').modal('show');
                    $('#modal_create_vehicle').modal('hide');
                }
            });

            $('#btn_cancel_customer').on('click', function(){
                $('#modal_create_customer').modal('hide');
                $('#modal_create_vehicle').modal('show');
            });

            /* Make Modal */
            _cboMakes.on("select2:select", function (e) {
                var i=$(this).select2('val');
                if(i==0){ 
                    _cboMakes.select2('val',null);
                    clearFields($('#frm_makes'));
                    $('#modal_create_make').modal('show');
                    $('#modal_create_vehicle').modal('hide');
                }
            });

            $('input[name="crp_no_type"]').on("change", function(){

                $('.crp_required').html('');
                $('.for_crp_input').prop('required',false);

                var input = $(this).data('input');
                var required = $(this).data('required');

                $('.'+required).html('*');
                $('input[name="'+input+'"]').prop('required',true);

            });

            $('#btn_cancel_make').on('click', function(){
                $('#modal_create_make').modal('hide');
                $('#modal_create_vehicle').modal('show');
            });

            /* Vehicle Year Modal */
            _cboYears.on("select2:select", function (e) {
                var i=$(this).select2('val');
                if(i==0){ 
                    _cboYears.select2('val',null);
                    clearFields($('#frm_vehicle_year'));
                    $('#modal_create_vehicle_year').modal('show');
                    $('#modal_create_vehicle').modal('hide');
                }
            });

            $('#btn_cancel_vehicle_year').on('click', function(){
                $('#modal_create_vehicle_year').modal('hide');
                $('#modal_create_vehicle').modal('show');
            });

            /* Vehicle Model Modal */
            _cboModels.on("select2:select", function (e) {
                var i=$(this).select2('val');
                if(i==0){ 
                    _cboModels.select2('val',null);
                    clearFields($('#frm_model'));
                    $('#modal_create_model').modal('show');
                    $('#modal_create_vehicle').modal('hide');
                }
            });

            $('#btn_cancel_model').on('click', function(){
                $('#modal_create_model').modal('hide');
                $('#modal_create_vehicle').modal('show');
            });


            /* Color Modal */
            _cboColors.on("select2:select", function (e) {
                var i=$(this).select2('val');
                if(i==0){ 
                    _cboColors.select2('val',null);
                    clearFields($('#frm_color'));
                    $('#modal_create_color').modal('show');
                    $('#modal_create_vehicle').modal('hide');
                }
            });

            $('#btn_cancel_color').on('click', function(){
                $('#modal_create_color').modal('hide');
                $('#modal_create_vehicle').modal('show');
            });            

            $("form input").on("keypress", function (event) {
                var keyPressed = event.keyCode || event.which;
                if (keyPressed === 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $('#tbl_vehicles tbody').on( 'click', 'tr td.details-control', function () {
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
                        "url":"Templates/layout/customer/"+ d.vehicle_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response,'no-padding' ).show();
                        reInitializeDatatable($('#tbl_so_'+ d.vehicle_id));
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });



                }
            } );


            $('#btn_new').click(function(){
                _txnMode="new";
                clearFields($('#frm_vehicle'));

                _cboCustomers.select2('val', null);
                _cboMakes.select2('val', null);
                _cboYears.select2('val', null);
                _cboModels.select2('val', null);
                _cboColors.select2('val', null);
                $("#pl_no").attr('checked', 'checked');
                $("input[name='crp_no_type']").change();
                $('#modal_create_vehicle').modal('show');
            });

            $('#tbl_vehicles tbody').on('click','button[name="edit_info"]',function(){
                    _txnMode="edit";
                    _selectRowObj=$(this).closest('tr');
                    var data=dt.row(_selectRowObj).data();
                    _selectedID=data.vehicle_id;

                    _cboCustomers.select2('val', data.customer_id);
                    _cboMakes.select2('val', data.make_id);
                    _cboYears.select2('val', data.vehicle_year_id);
                    _cboModels.select2('val', data.model_id);
                    _cboColors.select2('val', data.color_id);

                    if(data.crp_no_type == 1){
                        $('#cd_no').trigger('click');
                    }else{
                        $('#pl_no').trigger('click');
                    } 

                    $('input,textarea').each(function(){
                        var _elem=$(this);
                        $.each(data,function(name,value){
                            if(_elem.attr('name')==name){
                                _elem.val(value);
                            }
                        });
                    });

                    $('#modal_create_vehicle').modal('show');
            });

            $('#tbl_vehicles tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.vehicle_id;

                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeVehicle().done(function(response){
                    showNotification(response);
                    if(response.stat == 'success') {
                        dt.row(_selectRowObj).remove().draw();
                    }
                });
            });

            $('#btn_cancel').click(function(){
                showList(true);
            });

            $("#searchbox_vehicles").keyup(function(){         
                dt
                    .search(this.value)
                    .draw();
            });

            $('#btn_print').click(function(){
               window.open('customers/transaction/print-masterfile');
            });  

            $('#btn_export').click(function(){
               window.open('customers/transaction/export-supplier');
            });                

            $('#btn_save_customer').click(function(){
                if(validateRequiredFields($('#frm_customer'))){
                    createCustomer().done(function(response){
                        var customer=response.row_added[0];

                        $('#cbo_customers').append('<option value="'+ customer.customer_id +'">'+ customer.customer_no+' - '+customer.customer_name +'</option>');
                        _cboCustomers.select2('val',customer.customer_id);

                        $('#modal_create_customer').modal('hide');
                        $('#modal_create_vehicle').modal('show');
                        clearFields($('#frm_customer'));
                    });
                }
            }); 

            $('#btn_save_make').click(function(){
                if(validateRequiredFields($('#frm_makes'))){
                    createMake().done(function(response){
                        var make=response.row_added[0];

                        $('#cbo_makes').append('<option value="'+ make.make_id +'">'+make.make_desc +'</option>');
                        _cboMakes.select2('val',make.make_id);

                        $('#modal_create_make').modal('hide');
                        $('#modal_create_vehicle').modal('show');
                        clearFields($('#frm_makes'));
                    });
                }
            }); 

            $('#btn_save_vehicle_year').click(function(){
                if(validateRequiredFields($('#frm_vehicle_year'))){
                    createVehicleYear().done(function(response){
                        var vehicle_year=response.row_added[0];

                        $('#cbo_years').append('<option value="'+ vehicle_year.vehicle_year_id +'">'+vehicle_year.vehicle_year +'</option>');
                        _cboYears.select2('val',vehicle_year.vehicle_year_id);

                        $('#modal_create_vehicle_year').modal('hide');
                        $('#modal_create_vehicle').modal('show');
                        clearFields($('#frm_vehicle_year'));
                    });
                }
            });     

            $('#btn_save_model').click(function(){
                if(validateRequiredFields($('#frm_model'))){
                    createModel().done(function(response){
                        var model=response.row_added[0];

                        $('#cbo_models').append('<option value="'+ model.model_id +'">'+model.model_name +'</option>');
                        _cboModels.select2('val',model.model_id);

                        $('#modal_create_model').modal('hide');
                        $('#modal_create_vehicle').modal('show');
                        clearFields($('#frm_model'));
                    });
                }
            });  

            $('#btn_save_color').click(function(){
                if(validateRequiredFields($('#frm_color'))){
                    createColor().done(function(response){
                        var color=response.row_added[0];

                        $('#cbo_colors').append('<option value="'+ color.color_id +'">'+color.color +'</option>');
                        _cboColors.select2('val',color.color_id);

                        $('#modal_create_color').modal('hide');
                        $('#modal_create_vehicle').modal('show');
                        clearFields($('#frm_color'));
                    });
                }
            });                                     

            $('#btn_save').click(function(){

                if(validateRequiredFields($('#frm_vehicle'))){
                    if(_txnMode=="new"){
                        createVehicle().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_vehicle'));
                        }).always(function(){
                            $('#modal_create_vehicle').modal('toggle');
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                    if(_txnMode==="edit"){
                        updateVehicle().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                            clearFields($('#frm_vehicle'));
                        }).always(function(){
                            $('#modal_create_vehicle').modal('toggle');
                            showSpinningProgress($('#btn_save'));
                        });
                    }

                }

            });

        })();


        var validateRequiredFields=function(f){
            var stat=true;
            $('div.form-group').removeClass('has-error');
            $('select[required],input[required],textarea[required]',f).each(function(){
                    if($(this).is('select')){
                        if($(this).val()==0 || $(this).val() == null){
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

        var createCustomer=function(){
            var _data=$('#frm_customer').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Customers/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_customer'))
            });
        };

        var createMake=function(){
            var _data=$('#frm_makes').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"makes/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_make'))
            });
        };

        var createVehicleYear=function(){
            var _data=$('#frm_vehicle_year').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"vehicle_years/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_vehicle_year'))
            });
        };

        var createModel=function(){
            var _data=$('#frm_model').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"vehicle_models/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_model'))
            });
        };

        var createColor=function(){
            var _data=$('#frm_color').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Colors/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_color'))
            });
        };

        var createVehicle=function(){
            var _data=$('#frm_vehicle').serializeArray();
            _data.push({name : "crp_no_type" ,value : ($('#cd_no').is(':checked')) ? 1 : 2 });

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Vehicles/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateVehicle=function(){
            var _data=$('#frm_vehicle').serializeArray();
            _data.push({name : "vehicle_id" ,value : _selectedID});
            _data.push({name : "crp_no_type" ,value : ($('#cd_no').is(':checked')) ? 1 : 2 });

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Vehicles/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeVehicle=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Vehicles/transaction/delete",
                "data":{vehicle_id : _selectedID}
            });
        };

        var showList=function(b){
            if(b){
                $('#div_vehicle_list').show();
                $('#div_vehicle_fields').hide();
            }else{
                $('#div_vehicle_list').hide();
                $('#div_vehicle_fields').show();
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
            $('input,textarea,select',f).val('');
            // $(f).find('input:first').focus();
            $('#img_user').attr('src','assets/img/anonymous-icon.png');
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


        function format ( d ) {
            // `d` is the original data object for the row
            //alert(d.photo_path);
            return '<br /><table style="margin-left:10%;width: 80%;">' +
                    '<thead>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>' +
                    '<td width="20%">Name : </td><td width="50%"><b>'+ d.customer_name+'</b></td>' +
                    '<td rowspan="5" valign="top"><div class="avatar">'+
                    '<img src="'+ d.photo_path+'" class="img-circle" style="margin-top:0px;height: 100px;width: 100px;">'+
                    '</div></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Address : </td><td><b>'+ d.address+'</b></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Email : </td><td>'+ d.email_address+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Mobile Nos. : </td><td>'+ d.mobile_no+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Landline. : </td><td>'+ d.landline+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Active : </td><td><i class="fa fa-check"></i></td>' +
                    '</tr>' +
                    '</tbody></table><br />';


        };

    });

</script>
</body>
</html>