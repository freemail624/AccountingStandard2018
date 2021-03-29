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
        #span_repair_order_no{
            min-width: 50px;
        }
        #span_repair_order_no:focus{
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
        .numeric{
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
        #tbl_sales_invoice_filter    
        { 
            display:none; 
        } 

        .fieldset {
            background: #F8F8F8;
            position: relative;
            border: 2px solid #9a9a9a ;
            border-radius: .5em;
            padding: 15px;
            -webkit-box-shadow: 0px 0px 10px -5px rgba(184,184,184,1);
            -moz-box-shadow: 0px 0px 10px -5px rgba(184,184,184,1);
            box-shadow: 0px 0px 10px -5px rgba(184,184,184,1);   
        }

        .fieldset h1 {
            position: absolute;
            top: 0;
            font-size: 15px;
            line-height: 1;
            margin: -15px 0 0; /* half of font-size */
            background: #2780e3;
            padding: 5px 5px;
            color: white;
            border-radius: .3em;
        }    
        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .tab-content {
            border-radius: 0 2px 2px 2px;
            border: 1px solid #e0e0e0;
            padding: 16px;
            background-color: #ffffff;
            margin-bottom: 0px!important;             
        }

        .tab-container {
            margin-bottom: 0px;
        }

        .tab-primary.tab-container > .nav-tabs > li.active > a {
            border-top-color: white;
        }

        .not-active{
            background: #E8E8E8;
        }

    </style>
    <link type="text/css" href="assets/css/light-theme.css" rel="stylesheet">
</head>
<body class="animated-content sidebar-collapsed"  style="font-family: tahoma;">
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
    <li><a href="Repair_order">Repair Order</a></li>
</ol>
<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_sales_invoice_list">
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
        <div class="row panel-row">
        <h2 class="h2-panel-heading">Repair Order</h2><hr>
            <div class="row"> 
                <div class="col-lg-3"><br> 
                <button class="btn btn-success" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Record Repair Order" ><i class="fa fa-plus"></i> Record Repair Order</button> 
                </div> 
                <div class="col-lg-3"> 
                        From :<br /> 
                        <div class="input-group"> 
                            <input type="text" id="txt_start_date_sales" name="" class="date-picker form-control" value="<?php echo date("m"); ?>/01/<?php echo date("Y"); ?>"> 
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
                         <input type="text" id="tbl_sales_invoice_search" class="form-control"> 
                </div> 
            </div> 
            <table id="tbl_sales_invoice" class="table table-striped" cellspacing="0" width="100%" style="">
                <thead >
                <tr>
                    <th></th>
                    <th>Invoice #</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Customer</th>
                    <th>Department</th>
                    <th style="width: 20%">Remarks</th>
                    <th width="20%"><center>Action</center></th>
                    <th>Invoice #</th>
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
                <strong><a id="btn_receive_so" href="#" style="text-decoration: none; color: white;">Create from Sales Order</a></strong>
            </div>
        </div>
        <div class="panel-body" >
        <div class="row panel-row">
            <form id="frm_sales_invoice" role="form" class="form-horizontal">
                <h2 class="h2-panel-heading">Control No : <span id="span_repair_order_no">RAXXXX</span></h4>
                <div>
                <hr>
                <br/>
                <div class="row">
                    <div class="col-md-4">
                        <div class="fieldset">
                          <h1><i class="fa fa-user"></i> Customer Information</h1>
                            <div class="row">
                                <div class="col-md-4">
                                    <label> Customer No :</label> <br />
                                    <input type="text" name="customer_no" class="form-control" readonly>
                                </div>
                                <div class="col-md-8">
                                    <label><b class="required">*</b> Customer :</label> <br />
                                    <select name="customer_id" id="cbo_customers" data-error-msg="Customer is required." required>
                                        <option value="0">[ Create New Customer ]</option>
                                        <?php foreach($customers as $customer){ ?>
                                            <option data-customer-no="<?php echo $customer->customer_no; ?>" data-address="<?php echo $customer->address; ?>" data-contact="<?php echo $customer->contact_name; ?>" value="<?php echo $customer->customer_id; ?>" data-term-default="<?php echo ($customer->term=="none"?"":$customer->term); ?>" data-customer_type="<?php echo $customer->customer_type_id; ?>" data-contact-no="<?php echo $customer->contact_no; ?>" data-tel-no-home="<?php echo $customer->tel_no_home; ?>" data-tel-no-bus="<?php echo $customer->tel_no_bus; ?>"><?php echo $customer->customer_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Address :</label><br>
                                    <textarea class="form-control" id="txt_address" type="text" name="address" placeholder="Customer Address" rows="5"></textarea>       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label style="font-size: 7pt;">Mobile No. : </label>
                                    <input type="text" name="mobile_no" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label style="font-size: 7pt;">Tel No.(Home) : </label>
                                    <input type="text" name="tel_no_home" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label style="font-size: 7pt;">Tel No.(Bus) : </label>
                                    <input type="text" name="tel_no_bus" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="fieldset">
                          <h1><i class="fa fa-user"></i> Representative Information</h1>
                          <div class="row">
                              <div class="col-md-8">
                                    <label>Representative : </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text" name="representative_name" class="form-control">
                                    </div>
                              </div>
                              <div class="col-md-4">
                                    <label>Contact No. : </label>
                                    <input type="text" name="representative_no" class="form-control">
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="fieldset">
                          <h1><i class="fa fa-car"></i> Vehicle Information</h1>
                          <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label><b class="required">*</b> Plate No. : </label>
                                        <select name="vehicle_id" id="cbo_vehicles" data-error-msg="Vehicle is required." required disabled>
                                            <option value="0">[ Create New Vehicle ]</option>
                                            <?php foreach($vehicles as $vehicle){ ?>
                                                <option value="<?php echo $vehicle->vehicle_id; ?>" data-vehicle-year-make="<?php echo $vehicle->vehicle_year.'/'.$vehicle->make_desc; ?>" data-model-name="<?php echo $vehicle->model_name; ?>" data-color-name="<?php echo $vehicle->color; ?>" data-chassis-no="<?php echo $vehicle->chassis_no; ?>" data-engine-no="<?php echo $vehicle->engine_no; ?>">
                                                    <?php echo $vehicle->plate_no; ?>
                                                </option>
                                            <?php } ?>
                                        </select>    
                                    </div>                                
                                </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="col-md-6">
                                    <div class="row">
                                        <label>Year/Make</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-car"></i>
                                            </span>
                                            <input type="text" name="year_make_id" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label>Model</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-car"></i>
                                            </span>
                                            <input type="text" name="model_name" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label>Color</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-car"></i>
                                            </span>
                                            <input type="text" name="color_name" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label>VIN/Chassis No.</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-car"></i>
                                            </span>
                                            <input type="text" name="chassis_no" class="form-control" readonly>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <label>Engine No.</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-car"></i>
                                            </span>
                                            <input type="text" name="engine_no" class="form-control" readonly>
                                        </div>                                        
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label>Km Reading : </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-car"></i>
                                                    </span>
                                                    <input type="text" name="km_reading" class="form-control">
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label>Next Svc Date : </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" name="next_svc_date" class="date-picker form-control">
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label>Next Svc Km : </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-car"></i>
                                                    </span>
                                                    <input type="text" name="next_svc_km" class="form-control">
                                                </div>  
                                            </div>
                                        </div>
                                    </div> 

                                  </div>
                              </div>
                          </div>
                          <br/><br/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="fieldset">
                          <h1><i class="fa fa-info"></i> Order Details</h1>
                          <div class="row">
                              <div class="col-md-12">
                                <b class="required">*</b> <label>Document Date :</label> <br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" name="document_date" class="datetime-picker form-control" value="<?php echo date("m/d/Y h:i:s"); ?>" placeholder="Document Date" data-error-msg="Please set the date this repair order was issued!" required readonly>
                                </div>   
                              </div>
                              <div class="col-md-12">
                                <b class="required">*</b> <label>Date/Time Promised :</label> <br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" name="date_invoice" class="datetime-picker form-control" value="<?php echo date("m/d/Y h:i:s"); ?>" placeholder="Date Invoice" data-error-msg="Please set the date this items are issued!" required>
                                </div>   
                              </div>
                              <div class="col-md-12">
                                <b class="required">*</b> <label>Delivery Date :</label> <br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" name="delivery_date" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Delivery Date" data-error-msg="Delivery Date!" required>
                                </div>   
                              </div>
                              <div class="col-md-12">
                                <b class="required">*</b> <label>Advisor :</label> <br />
                                <select class="form-control" name="advisor_id" id="cbo_advisors">
                                    <option value="0">[ Create New Advisor ]</option>
                                    <?php foreach($advisors as $advisor){ ?>
                                        <option value="<?php echo $advisor->advisor_id; ?>">
                                            <?php echo $advisor->fullname; ?>
                                        </option>
                                    <?php }?>
                                </select>
                              </div>
                              <div class="col-md-12">
                                <label>Selling Dealer :</label> <br />
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" name="selling_dealer" class="form-control" placeholder="Selling Dealer">
                                </div>   
                              </div>
                              <div class="col-md-12">
                                  <hr/>
                                  <center>
                                  <label>Mode of Payment</label><br/>
                                      <input type="checkbox" name="payment_mode_id" value="1" id="cash"> <label for="cash">Cash</label> 
                                      <input type="checkbox" name="payment_mode_id" value="2" id="card" style="margin-left: 10px;"> <label for="card">Card</label> 
                                  </center>
                              </div>
                          </div>
                          <br/>
                        </div>
                    </div>
                </div>

                </div>
            </form>
        </div>
        <div>
        <hr>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="tab-container tab-top tab-primary">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#pms" data-toggle="tab" class="nav_button" data-active-color="#2780e3" style="font-family: tahoma;background: #2780e3; color: white;border-top-left-radius: 1em;border-top-right-radius: 1em;"> Periodic Maintenance (PMS)
                            <span style="background: white; color: #2780e3; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">0</span> </a>
                        </li>
                        <li>
                            <a href="#body" data-toggle="tab" class="nav_button" data-active-color="#B20000" style="font-family: tahoma;background: #E8E8E8; color: gray;border-top-left-radius: 1em;border-top-right-radius: 1em;"> Body Paint Repair
                            <span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">10</span></a>
                        </li>
                        <li>
                            <a href="#general_jobs" data-toggle="tab" class="nav_button" data-active-color="#e69500 " style="font-family: tahoma;background: #E8E8E8 ; color: gray;border-top-left-radius: 1em;border-top-right-radius: 1em;"> General Job
                            <span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">150</span></a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="pms">
                        <label>Description :</label> 
                        <textarea class="form-control" name="pms_desc" placeholder="Periodic Maintenance Description"></textarea>

                        <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
                        <button id="refreshproducts" class="btn-primary btn pull-right" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Refresh</button>
                        <div id="custom-templates">
                            <input class="typeahead" id="typeaheadsearch" type="text" placeholder="Enter PLU or Search Item">
                        </div><br />
                        <form id="frm_items_pms">
                            <div class="table-responsive">
                                <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                    <thead class="">    
                                        <tr>
                                            <th width="9%">Qty</th>
                                            <th width="8%">UM</th>
                                            <th width="15%">Description</th>
                                            <th width="10%" style="text-align: right;">Unit Price</th>
                                            <th width="8%" style="text-align: right;">Discount</th>
                                            <!-- DISPLAY NONE  -->
                                            <th class="hidden">Total Discount</th>
                                            <th class="hidden">Tax %</th>
                                            <!-- DISPLAY -->
                                            <th width="10%" style="text-align: right;">Gross</th>
                                            <th width="10%" style="text-align: right;">Net Total</th>
                                            <!-- Expiration and LOT# -->
                                            <th width="10%">Expiration</th>
                                            <th width="10%">LOT#</th>
                                            <th class="hidden">Cost Upon Invoice</th>
                                            <!-- DISPLAY NONE  -->
                                            <th class="hidden">Vat Input(Total Line Tax)</th>
                                            <th class="hidden">Net of Vat (Price w/out Tax)</th>
                                            <td class="hidden">Item ID</td>
                                            <th class="hidden">Total after Global</th> 
                                            <th width="10%"><center>Action</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="10" style="height: 50px;">&nbsp;</td>
                                        </tr>
                                        <tr class="">
                                            <td style="text-align: right;">Discount:</td>
                                            <td align="right" color="red">
                                                <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00" />
                                                <input type="hidden" id="txt_overall_discount_amount" name="total_overall_discount_amount" class="numeric form-control" value="0.00" readonly>
                                            </td>

                                            <td style="text-align: right;" class="hidden">Total After Discount:</td>
                                            <td id="td_total_after_discount" style="text-align: right" class="hidden">0.00</td>

                                            <td style="text-align: right;" colspan="7">Total before tax:</td>
                                            <td id="td_total_before_tax" style="text-align: right">0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="" style="text-align: right;">
                                                <strong><i class="glyph-icon icon-star"></i> Tax :</strong>
                                            </td>
                                            <td align="right" id="td_tax" color="red">0.00</td>
                                            <td colspan="7" style="text-align: right;">
                                                <strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong>
                                            </td>
                                            <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="body">
                    <label>Description :</label> 
                    <textarea class="form-control" name="bpr_desc" placeholder="Body Paint Repair Description"></textarea>
                        <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
                        <button id="refreshproducts" class="btn-primary btn pull-right" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Refresh</button>
                        <div id="custom-templates">
                            <input class="typeahead" id="typeaheadsearch" type="text" placeholder="Enter PLU or Search Item">
                            <i class="pull-right hidden">Note: Unit Price will depend on chosen Customer Type</i>
                        </div><br />
                        <form id="frm_items_bpr">
                            <div class="table-responsive">
                                <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                    <thead class="">    
                                        <tr>
                                            <th width="9%">Qty</th>
                                            <th width="8%">UM</th>
                                            <th width="15%">Description</th>
                                            <th width="10%" style="text-align: right;">Unit Price</th>
                                            <th width="8%" style="text-align: right;">Discount</th>
                                            <!-- DISPLAY NONE  -->
                                            <th class="hidden">Total Discount</th>
                                            <th class="hidden">Tax %</th>
                                            <!-- DISPLAY -->
                                            <th width="10%" style="text-align: right;">Gross</th>
                                            <th width="10%" style="text-align: right;">Net Total</th>
                                            <!-- Expiration and LOT# -->
                                            <th width="10%">Expiration</th>
                                            <th width="10%">LOT#</th>
                                            <th class="hidden">Cost Upon Invoice</th>
                                            <!-- DISPLAY NONE  -->
                                            <th class="hidden">Vat Input(Total Line Tax)</th>
                                            <th class="hidden">Net of Vat (Price w/out Tax)</th>
                                            <td class="hidden">Item ID</td>
                                            <th class="hidden">Total after Global</th> 
                                            <th width="10%"><center>Action</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="10" style="height: 50px;">&nbsp;</td>
                                        </tr>
                                        <tr class="">
                                            <td style="text-align: right;">Discount:</td>
                                            <td align="right" color="red">
                                                <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00" />
                                                <input type="hidden" id="txt_overall_discount_amount" name="total_overall_discount_amount" class="numeric form-control" value="0.00" readonly>
                                            </td>

                                            <td style="text-align: right;" class="hidden">Total After Discount:</td>
                                            <td id="td_total_after_discount" style="text-align: right" class="hidden">0.00</td>

                                            <td style="text-align: right;" colspan="7">Total before tax:</td>
                                            <td id="td_total_before_tax" style="text-align: right">0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="" style="text-align: right;">
                                                <strong><i class="glyph-icon icon-star"></i> Tax :</strong>
                                            </td>
                                            <td align="right" id="td_tax" color="red">0.00</td>
                                            <td colspan="7" style="text-align: right;">
                                                <strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong>
                                            </td>
                                            <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="general_jobs">
                    <label>Description :</label> 
                    <textarea class="form-control" name="gb_desc" placeholder="General Job Description"></textarea>
                        <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
                        <button id="refreshproducts" class="btn-primary btn pull-right" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Refresh</button>
                        <div id="custom-templates">
                            <input class="typeahead" id="typeaheadsearch" type="text" placeholder="Enter PLU or Search Item">
                            <i class="pull-right hidden">Note: Unit Price will depend on chosen Customer Type</i>
                        </div><br />
                        <form id="frm_items_gb">
                            <div class="table-responsive">
                                <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                    <thead class="">    
                                        <tr>
                                            <th width="9%">Qty</th>
                                            <th width="8%">UM</th>
                                            <th width="15%">Description</th>
                                            <th width="10%" style="text-align: right;">Unit Price</th>
                                            <th width="8%" style="text-align: right;">Discount</th>
                                            <!-- DISPLAY NONE  -->
                                            <th class="hidden">Total Discount</th>
                                            <th class="hidden">Tax %</th>
                                            <!-- DISPLAY -->
                                            <th width="10%" style="text-align: right;">Gross</th>
                                            <th width="10%" style="text-align: right;">Net Total</th>
                                            <!-- Expiration and LOT# -->
                                            <th width="10%">Expiration</th>
                                            <th width="10%">LOT#</th>
                                            <th class="hidden">Cost Upon Invoice</th>
                                            <!-- DISPLAY NONE  -->
                                            <th class="hidden">Vat Input(Total Line Tax)</th>
                                            <th class="hidden">Net of Vat (Price w/out Tax)</th>
                                            <td class="hidden">Item ID</td>
                                            <th class="hidden">Total after Global</th> 
                                            <th width="10%"><center>Action</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="10" style="height: 50px;">&nbsp;</td>
                                        </tr>
                                        <tr class="">
                                            <td style="text-align: right;">Discount:</td>
                                            <td align="right" color="red">
                                                <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00" />
                                                <input type="hidden" id="txt_overall_discount_amount" name="total_overall_discount_amount" class="numeric form-control" value="0.00" readonly>
                                            </td>

                                            <td style="text-align: right;" class="hidden">Total After Discount:</td>
                                            <td id="td_total_after_discount" style="text-align: right" class="hidden">0.00</td>

                                            <td style="text-align: right;" colspan="7">Total before tax:</td>
                                            <td id="td_total_before_tax" style="text-align: right">0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="" style="text-align: right;">
                                                <strong><i class="glyph-icon icon-star"></i> Tax :</strong>
                                            </td>
                                            <td align="right" id="td_tax" color="red">0.00</td>
                                            <td colspan="7" style="text-align: right;">
                                                <strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong>
                                            </td>
                                            <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br />
                <div class="row"><hr>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label ><strong>Remarks :</strong></label>
                        <div class="col-lg-12" style="padding: 0%;">
                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" data-default="<?php echo $company->sales_remarks; ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-lg-4 col-lg-offset-8">
                        <div class="table-responsive">
                            <table id="tbl_sales_invoice_summary" class="table invoice-total" style="font-family: tahoma;">
                                <tbody>
                                <tr>
                                    <td>Discount :</td>
                                    <td align="right">0.00</td>
                                </tr>
                                <tr>
                                    <td>Total before Tax :</td>
                                    <td align="right">0.00</td>
                                </tr>
                                <tr>
                                    <td>Tax :</td>
                                    <td align="right">0.00</td>
                                </tr>
                                <tr>
                                    <td><strong>Total After Tax :</strong></td>
                                    <td align="right"><b>0.00</b></td>
                                </tr>
                                </tbody>
                            </table>
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

            <label class="control-label hidden" id="is_auto_print"> 
                <strong> 
                   <input type="checkbox" name="is_auto_print" for="is_auto_print" <?php if($company->is_print_auto == 1){ echo 'checked'; } ?>>
                        Print after saving?
                </strong>
            </label>

            <label class="control-label hidden" id="checkcheck" style="margin-left: 10px;"> 
                <strong> 
                   <input type="checkbox" name="chk_dispatching" for="checkcheck">
                    For Dispatching ?
                </strong>
            </label>

            <br>
            <input type="hidden" name="for_dispatching" id="for_dispatching" class="form-control"><br>
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
<div id="modal_so_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Sales Order</h2>
            </div>
            <div class="modal-body">
                <table id="tbl_so_list" class="table table-striped" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th></th>
                        <th>SO#</th>
                        <th>Customer</th>
                        <th>Remarks</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Sales Order Content -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
      <!--           <button id="btn_accept" type="button" class="btn btn-green" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Receive this Order</button> -->
                <button id="cancel_modal" class="btn btn-default" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content---->
    </div>
<div class="clearfix"></div>
</div><!---modal-->
<div id="modal_sales_invoice" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="padding: 5px !important;">
                <h2 style="color:white; padding-left: 10px;">Sales Invoice</h2>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="overflow: scroll; width: 100%;">
                    <salesInvoice id="sales_invoice">
                    </salesInvoice>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_new_customer" class="modal fade" role="dialog"><!--modal-->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Customer Information</h4>
            </div>

            <div class="modal-body">
                <form id="frm_customer">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="col-md-12" id="label">
                                     <label class="control-label boldlabel"><font color="red"><b>*</b></font> Customer Name :</label>
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
                                <div class="col-md-12" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"><font color="red"></font> Contact Person :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="contact_name" class="form-control" placeholder="Contact Person">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="col-md-12" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Address :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                         </span>
                                         <textarea name="address" class="form-control" data-error-msg="Customer address is required!" placeholder="Address" required ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12" id="label">
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
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12" id="label">
                                         <label class="control-label boldlabel">Mobile No :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-mobile"></i>
                                            </span>
                                            <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="Mobile No">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12" id="label">
                                         <label class="control-label boldlabel">Tel No. (Home) :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                            <input type="text" name="tel_no_home" id="tel_no_home" class="form-control" placeholder="Tel No. (Home)">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12" id="label">
                                         <label class="control-label boldlabel">Tel No. (Bus) :</label>
                                    </div>
                                    <div class="form-group">
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
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_save_customer" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_new_vehicle" class="modal fade" role="dialog"><!--modal-->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"></span> New Vehicle for <span class="customer_name"></span></h4>
            </div>
            <div class="modal-body">
                <form id="frm_vehicle">
                    <div class="row">
                        <div class="col-md-12">
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
                                        <label><b class="required">*</b> Plate No : </label>
                                        <input type="text" class="form-control" name="plate_no" placeholder="Plate No." required data-error-msg="Plate No is required!"> 
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
                <button id="btn_save_vehicle" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                <button id="btn_cancel_vehicle" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_new_make" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
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

<div id="modal_new_vehicle_year" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
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

<div id="modal_new_model" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
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

<div id="modal_new_color" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
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

<div id="modal_search_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Choose Item</h2>
            </div>

            <div class="modal-body">
            <div class="row">
                <table id="tbl_search_list" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th>PLU</th>
                        <th>Description</th>
                        <th>Batch</th>
                        <th>Expiration</th>
                        <th style="text-align: right;">On Hand</th>
                        <th style="text-align: right;">SRP</th>
                        <th style="text-align: right;">Cost</th>
                        <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Sales Order Content -->
                    </tbody>
                </table>
            </div>
            </div>
            <div class="modal-footer">
                <!-- <button id="btn_accept" type="button" class="btn btn-green" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Receive this Order</button> -->
                <button id="cancel_modal" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->


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

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
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
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboDepartments; var _cboDepartments; var _cboCustomers; var dt_so; var products; var changetxn;
    var _cboCustomerType; var prodstat;
    var _cboCustomerTypeCreate; var _cboSource; var _cboVehicles; var _cboAdvisors;
    var _line_unit; var global_item_desc = ''; var _selectRowTblItems; var _cboMakes; var _cboYears; var _cboModels; var _cboColors;

    var oTableItems={
        qty : 'td:eq(0)',
        unit_value: 'td:eq(1)',
        unit_identifier : 'td:eq(2)',
        unit_price : 'td:eq(3)',
        discount : 'td:eq(4)',
        total_line_discount : 'td:eq(5)',
        tax : 'td:eq(6)',
        gross : 'td:eq(7)',
        total : 'td:eq(8)',
        exp_date : 'td:eq(9)',
        batch_no : 'td:eq(10)',
        cost_upon_invoice : 'td:eq(11)',
        vat_input : 'td:eq(12)',
        net_vat : 'td:eq(13)',
        item_id : 'td:eq(14)',
        total_after_global :' td:eq(15)',
        bulk_price : 'td:eq(17)',
        retail_price : 'td:eq(18)'
    };
    var oTableSearch={
        sBatch : 'td:eq(2)',
        sExpDate : 'td:eq(3)',
        sCost : 'td:eq(6)',
    };
    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        inv_tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };
    var initializeControls=function(){
        dt=$('#tbl_sales_invoice').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 8, "desc" ]],
            "ajax" : { 
                "url":"Sales_invoice/transaction/list", 
                "bDestroy": true,             
                "data": function ( d ) { 
                        return $.extend( {}, d, { 
                            "tsd":$('#txt_start_date_sales').val(), 
                            "ted":$('#txt_end_date_sales').val() 
                        }); 
                    } 
            }, 
            "language": {
                "searchPlaceholder":"Search Invoice"
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
                { targets:[2],data: "date_invoice" },
                { targets:[3],data: "date_due" ,visible:false},
                { targets:[4],data: "customer_name" },
                { targets:[5],data: "department_name" },
                { targets:[6],data: "remarks"  ,render: $.fn.dataTable.render.ellipsis(60)},
                {
                    targets:[7],data:null,
                    render: function (data, type, full, meta){
                        var btn_attachments='<a href="Sales_attachments?id='+data.sales_invoice_id+'" target="_blank" class="btn btn-default btn-sm" name="attachment_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Attachments"><i class="fa fa-paperclip"></i> '+data.total_attachments+'</a>';
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-right:0" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                        return '<center>'+btn_attachments+"&nbsp;"+btn_edit+"&nbsp;"+btn_trash+'</center>';
                    }
                },
                { targets:[8],data: "sales_invoice_id", visible:false }
            ]
        });
        dt_so=$('#tbl_so_list').DataTable({
            "bLengthChange":false,
            "ajax" : "Sales_order/transaction/open",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "so_no" },
                { targets:[2],data: "customer_name" },
                { targets:[3],data: "remarks" },
                { targets:[4],data: "date_order" },
                { targets:[5],data: "order_status" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_so"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Create Sales Invoice on SO"><i class="fa fa-check"></i> Accept SO</button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                }
            ]
        });
        $('.numeric').autoNumeric('init');
        $('#contact_no').keypress(validateNumber);

        _cboDepartment=$("#cbo_department").select2({
            placeholder: "Please select Department.",
            allowClear: false
        });

        _cboCustomers=$("#cbo_customers").select2({
            placeholder: "Please select customer.",
            allowClear: false
        });
        
        _cboVehicles=$("#cbo_vehicles").select2({
            placeholder: "Please select vehicle.",
            allowClear: false
        });

        _cboAdvisors=$("#cbo_advisors").select2({
            placeholder: "Please select an advisor.",
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

        $('.datetime-picker').datetimepicker();

        $('#custom-templates .typeahead').keypress(function(event){
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
            }
        });

        products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('product_code','product_desc','product_desc1','product_unit_name','unq_id'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local : products
        });
        var _objTypeHead=$('#custom-templates .typeahead');
        _objTypeHead.typeahead(null, {
        name: 'products',
        display: 'product_code',
        source: products,
        templates: {
            header: [
                '<table class="tt-head"><tr>'+
                '<td width=15%" style="padding-left: 1%;"><b>PLU</b></td>'+
                '<td class="hidden"><b>UniqID</b></td>'+
                '<td width="25%" align="left"><b>Description</b></td>'+
                '<td width="20%" align="left"><b>Expiration</b></td>'+
                '<td width="10%" align="left"><b>LOT#</b></td>'+
                '<td width="17%" align="right"><b>On Hand</b></td>'+
                '<td width="13%" align="right" style="padding-right: 1%;"><b>SRP</b></td>'+
                '</tr></table>'
            ].join('\n'),
            suggestion: Handlebars.compile('<table class="tt-items"><tr>'+
                '<td width="15%" style="padding-left: 1%;">{{product_code}}</td>'+
                '<td class="hidden">{{unq_id}}</td>'+
                '<td width="25%" align="left">{{product_desc}}</td>'+
                '<td width="20%" align="left">{{exp_date}}</td>'+
                '<td width="10%" align="left">{{batch_no}}</td>'+
                '<td width="17%" align="right">{{on_hand_per_batch}}</td>'+
                '<td width="13%" align="right" style="padding-right: 1%;">{{srp}}</td>'+
                '</tr></table>')
        }
        }).on('keyup', this, function (event) {
            if (_objTypeHead.typeahead('val') == '') {
                return false;
            }
            if (event.keyCode == 13) {
             
                // $('.tt-suggestion:first').click();
    _objTypeHead.typeahead('close');           //     -- changed due to barcode scan not working
    _objTypeHead.typeahead('val','');         //  -- changed due to barcode scan not working
            }
        }).bind('typeahead:select', function(ev, suggestion) {


            // if(!(checkProduct(suggestion.product_id))){ // Checks if item is already existing in the Table of Items for invoice
            //     showNotification({title: suggestion.product_desc,stat:"error",msg: "Item is Already Added."});
            //     return;
            // }

            var product_id = 0;
            var conversion_rate = 0;

            if(suggestion.is_parent == 1 || (suggestion.is_parent <= 0 && suggestion.parent_id <= 0)){
                product_id = suggestion.product_id;
            }else{
                product_id = suggestion.parent_id;
            }

            // getInvetory(product_id).done(function(response){
            //     data = response.data[0];
            //     var CurrentQty = data.CurrentQty;
            //     var CurrentQtyTotal = 0;

            //     if(suggestion.is_parent == 1){
            //         CurrentQtyTotal = (CurrentQty / suggestion.bulk_conversion_rate);
            //     }
            //     else if(suggestion.is_parent <= 0 && suggestion.parent_id <= 0){
            //         CurrentQtyTotal = CurrentQty;
            //     }
            //     else{
            //         CurrentQtyTotal = (CurrentQty / suggestion.conversion_rate);
            //     }

            //     if(getFloat(CurrentQtyTotal) <= 0){
            //         showNotification({title: suggestion.product_desc,stat:"info",msg: "This item is currently out of stock.<br>Continuing will result to negative inventory."});
            //     }else if(getFloat(CurrentQtyTotal) <= getFloat(suggestion.product_warn) ){
            //         showNotification({title: suggestion.product_desc ,stat:"info",msg:"This item has low stock remaining.<br>It might result to negative inventory."});
            //     }

            // });


            var tax_rate=suggestion.tax_rate; //base on the tax rate set to current product
            //choose what purchase cost to be use
            _customer_type_ = _cboCustomerType.val();
            var sale_price=0.00;

            if(_customer_type_ == '' || _customer_type_ == 0){
                sale_price=suggestion.sale_price;
            }else if(_customer_type_ == '1' ){ // DISCOUNTED CUSTOMER TYPE
                sale_price=suggestion.discounted_price;
            }else if(_customer_type_ == '2' ){ // DEALER CUSTOMER TYPE
                sale_price=suggestion.dealer_price;
            }else if(_customer_type_ == '3' ){ // DISTRIBUTOR CUSTOMER TYPE
                sale_price=suggestion.distributor_price;
            }else if(_customer_type_ == '4' ){ // PUBLIC CUSTOMER TYPE
                sale_price=suggestion.public_price;
            }else{
                sale_price=suggestion.sale_price;
            }
            var total=getFloat(sale_price);
            var net_vat=0;
            var vat_input=0;
            var bulk_price = 0;
            var retail_price = 0;
            if(suggestion.is_tax_exempt=="0"){ //not tax excempt
                net_vat=total/(1+(getFloat(tax_rate)/100));
                vat_input=total-net_vat;
            }else{
                tax_rate=0;
                net_vat=total;
                vat_input=0;
            }

                a = '';
                bulk_price = sale_price;

                // if(suggestion.is_bulk == 1){
                //     retail_price = getFloat(sale_price) / getFloat(suggestion.child_unit_desc);
                // }else if (suggestion.is_bulk== 0){
                //     retail_price = 0;
                // }
                retail_price = sale_price;
                suggis_parent = suggestion.is_parent;
                temp_inv_price = sale_price;                

                // if(suggestion.primary_unit == 1){ 
                //         suggis_parent = 1; 
                //         temp_inv_price = sale_price;
                // }else{ 
                //     suggis_parent = 0; 
                //     temp_inv_price = retail_price;
                //     net_vat = getFloat(net_vat) / getFloat(suggestion.child_unit_desc);
                //     vat_input = getFloat(vat_input) / getFloat(suggestion.child_unit_desc);
                // }
            var qty = 1;
            if (suggestion.is_product_basyo == 1){
                qty = TotalBasyo();
            }

            changetxn = 'active';
            $('#tbl_items > tbody').append(newRowItem({
                inv_qty : qty,
                inv_gross : temp_inv_price,
                product_code : suggestion.product_code,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                inv_line_total_discount : "0.00",
                tax_exempt : false,
                inv_tax_rate : tax_rate,
                inv_price : temp_inv_price,
                inv_discount : "0.00",
                tax_type_id : null,
                inv_line_total_price : temp_inv_price,
                inv_non_tax_amount: net_vat,
                inv_tax_amount:vat_input,
                inv_line_total_after_global:0.00,
                bulk_price: bulk_price,
                retail_price: retail_price,
                is_bulk: suggestion.is_bulk,
                parent_unit_id : suggestion.product_unit_id,
                child_unit_id : suggestion.child_unit_id,
                child_unit_name : suggestion.child_unit_name,
                parent_unit_name : suggestion.product_unit_name,
                is_parent: suggis_parent ,// INITIALLY , UNIT USED IS THE PARENT , 1 for PARENT 0 for CHILD
                a:a,
                primary_unit:suggestion.primary_unit,
                is_basyo:suggestion.is_basyo,
                is_product_basyo:suggestion.is_product_basyo,
                exp_date : suggestion.exp_date,
                batch_no : suggestion.batch_no,
                cost_upon_invoice : suggestion.srp_cost

            }));

            _line_unit=$('.line_unit'+a).select2({
                 minimumResultsForSearch: -1
            });
 
            reInitializeNumeric();
            reComputeTotal();
                
            $('.qty').focus();


            return prodstat;   

        });
        $('div.tt-menu').on('click','table.tt-suggestion',function(){
            _objTypeHead.typeahead('val','');
        });
        $("input#touchspin4").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-fw fa-plus',
            verticaldownclass: 'fa fa-fw fa-minus'
        });
    }();
    var bindEventHandlers=(function(){


        $('.nav_button').click(function(){

            var active_color = $(this).data('active-color');

            $('.nav_button').removeClass('active');
            $(this).addClass('active');

            $('.nav_button').not('.active').css('background','#E8E8E8');
            $('.nav_button').not('.active').css('color','gray');

            $('.nav_button').not('.active').each(function() {
                $(this).find('span').css('background','gray');
                $(this).find('span').css('color','white');
            });

            $(this).css('background',active_color);
            $(this).css('color','white');
            $(this).find('span').css('background','white');
            $(this).find('span').css('color',active_color);

        });


            $('[id=checkcheck]').click(function(event) {
                if(this.checked == true) {
                    $('#for_dispatching').val('1');
                }else{
                     $('#for_dispatching').val('0');
                }
            });


        var detailRows = [];

        $('#tbl_sales_invoice tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/sales-invoice/"+ d.sales_invoice_id +"?type=dropdown",
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

        $('#link_browse').click(function(){
            $('#btn_receive_so').click();
        });

        $('#tbl_so_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt_so.row( tr );
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
                //console.log(tr);
                _selectRowObj=$(this).closest('tr');
                var d=dt_so.row(_selectRowObj).data();
                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/sales-order/"+ d.sales_order_id+'/contentview',
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    tr.addClass( 'details' );
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );

        $("#tbl_sales_invoice_search").keyup(function(){          
                dt 
                    .search(this.value) 
                    .draw(); 
        }); 

        $("#txt_start_date_sales").on("change", function () {         
            $('#tbl_sales_invoice').DataTable().ajax.reload() 
        }); 

        $("#txt_end_date_sales").on("change", function () {
            $('#tbl_sales_invoice').DataTable().ajax.reload()
        });

        var getCustomerVehicles = function(i,open=false){

            var _data=$('#').serializeArray();
            _data.push({name : "customer_id" ,value : i});

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"vehicles/transaction/get-customer-vehicles",
                "data":_data
            }).done(function(response){

                var rows=response.data;
                $("#cbo_vehicles option").remove();
                $("#cbo_vehicles").append('<option value="0">[ Create New Vehicle ]</option>');

                $.each(rows,function(i,value){
                   $("#cbo_vehicles").append('<option value="'+ value.vehicle_id +'" data-vehicle-year-make="'+value.vehicle_year+'/'+value.make_desc+'" data-model-name="'+value.model_name+'" data-color-name="'+value.color+'" data-chassis-no="'+value.chassis_no+'" data-engine-no="'+value.engine_no+'">'+ value.plate_no +'</option>');
                });

                _cboVehicles.select2('val', null);
                
            }).always(function(){
                if(open){
                    $('#cbo_vehicles').select2('open');
                }

            });
        };

        _cboCustomers.on("change", function (e) {
            var i=$(this).val();
            var _modelVehicleOpen = false;

            $('#cbo_vehicles').select2('val', null);

            if(i==null || i==0){
                $('#cbo_vehicles').attr('disabled', true);
                _modelVehicleOpen = false;
            }else{
                $('#cbo_vehicles').attr('disabled', false);
                _modelVehicleOpen = true;
            }

            if(i==0){ //new customer
                clearFields($('#frm_customer'));
                _cboCustomers.select2('val',null);
                $('#modal_new_customer').modal('show');
            }else{
                var obj_customers=$('#cbo_customers').find('option[value="' + i + '"]');

                $('.customer_name').html(obj_customers.text());
                $('input[name="customer_no"]').val(obj_customers.data('customer-no'));
                $('textarea[name="address"]').val(obj_customers.data('address'));
                $('input[name="mobile_no"]').val(obj_customers.data('contact-no'));
                $('input[name="tel_no_home"]').val(obj_customers.data('tel-no-home'));
                $('input[name="tel_no_bus"]').val(obj_customers.data('tel-no-bus'));
            }

            getCustomerVehicles(i,_modelVehicleOpen);
        });   

        _cboVehicles.on("change", function (e) {
            var i=$(this).val();

            if(i==0){ //new vehicle
                clearFields($('#frm_vehicle'));
                _cboVehicles.select2('val',null);

                _cboMakes.select2('val', null);
                _cboYears.select2('val', null);
                _cboModels.select2('val', null);
                _cboColors.select2('val', null);

                $('#modal_new_vehicle').modal('show');

            }else{
                var obj_vehicle=$('#cbo_vehicles').find('option[value="' + i + '"]');

                $('input[name="year_make_id"]').val(obj_vehicle.data('vehicle-year-make'));
                $('input[name="model_name"]').val(obj_vehicle.data('model-name'));
                $('input[name="color_name"]').val(obj_vehicle.data('color-name'));
                $('input[name="chassis_no"]').val(obj_vehicle.data('chassis-no'));
                $('input[name="engine_no"]').val(obj_vehicle.data('engine-no'));

            }
        });         

        /* Make Modal */
        _cboMakes.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ 
                _cboMakes.select2('val',null);
                clearFields($('#frm_makes'));
                $('#modal_new_make').modal('show');
                $('#modal_new_vehicle').modal('hide');
            }
        });

        $('#btn_cancel_make').on('click', function(){
            $('#modal_new_make').modal('hide');
            $('#modal_new_vehicle').modal('show');
        });

        /* Vehicle Year Modal */
        _cboYears.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ 
                _cboYears.select2('val',null);
                clearFields($('#frm_vehicle_year'));
                $('#modal_new_vehicle_year').modal('show');
                $('#modal_new_vehicle').modal('hide');
            }
        });

        $('#btn_cancel_vehicle_year').on('click', function(){
            $('#modal_new_vehicle_year').modal('hide');
            $('#modal_new_vehicle').modal('show');
        });

        /* Vehicle Model Modal */
        _cboModels.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ 
                _cboModels.select2('val',null);
                clearFields($('#frm_model'));
                $('#modal_new_model').modal('show');
                $('#modal_new_vehicle').modal('hide');
            }
        });

        $('#btn_cancel_model').on('click', function(){
            $('#modal_new_model').modal('hide');
            $('#modal_new_vehicle').modal('show');
        });


        /* Color Modal */
        _cboColors.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ 
                _cboColors.select2('val',null);
                clearFields($('#frm_color'));
                $('#modal_new_color').modal('show');
                $('#modal_new_vehicle').modal('hide');
            }
        });

        $('#btn_cancel_color').on('click', function(){
            $('#modal_new_color').modal('hide');
            $('#modal_new_vehicle').modal('show');
        });

        $('#refreshproducts').click(function(){
            getproduct().done(function(data){
                products.clear();
                products.local = data.data;
                products.initialize(true);
                    showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
            }).always(function(){
                $('#typeaheadsearch').val('');
            });
        });

        $('#btn_save_customer').click(function(){
            var btn=$(this);
            if(validateRequiredFields($('#frm_customer'))){
                var data=$('#frm_customer').serializeArray();
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Customers/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);

                    if(response.stat == 'success'){

                        $('#modal_new_customer').modal('hide');
                        var _customer=response.row_added[0];

                        $('#cbo_customers').append('<option value="'+_customer.customer_id+'" data-customer-no="'+_customer.customer_no+'" data-address="'+_customer.address+'" data-contact-no="'+_customer.contact_no+'" data-contact="'+_customer.contact_name+'" data-tel-no-home="'+_customer.tel_no_home+'" data-tel-no-bus="'+_customer.tel_no_bus+'">'+ _customer.customer_name + '</option>');

                        _cboCustomers.select2('val', _customer.customer_id);
                    }

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#btn_save_make').click(function(){
            if(validateRequiredFields($('#frm_makes'))){
                createMake().done(function(response){
                    var make=response.row_added[0];

                    $('#cbo_makes').append('<option value="'+ make.make_id +'">'+make.make_desc +'</option>');
                    _cboMakes.select2('val',make.make_id);

                    $('#modal_new_make').modal('hide');
                    $('#modal_new_vehicle').modal('show');
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

                    $('#modal_new_vehicle_year').modal('hide');
                    $('#modal_new_vehicle').modal('show');
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

                    $('#modal_new_model').modal('hide');
                    $('#modal_new_vehicle').modal('show');
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

                    $('#modal_new_color').modal('hide');
                    $('#modal_new_vehicle').modal('show');
                    clearFields($('#frm_color'));
                });
            }
        });                                     

        $('#btn_save_vehicle').click(function(){
            if(validateRequiredFields($('#frm_vehicle'))){
                createVehicle().done(function(response){
                    var vehicle=response.row_added[0];

                    $("#cbo_vehicles").append('<option value="'+ vehicle.vehicle_id +'" data-vehicle-year-make="'+vehicle.vehicle_year+'/'+vehicle.make_desc+'" data-model-name="'+vehicle.model_name+'" data-color-name="'+vehicle.color+'" data-chassis-no="'+vehicle.chassis_no+'" data-engine-no="'+vehicle.engine_no+'">'+ vehicle.plate_no +'</option>');

                    _cboVehicles.select2('val', vehicle.vehicle_id);

                    $('#modal_new_vehicle').modal('hide');
                    clearFields($('#frm_vehicle'));
                });
            }
        });                                     


        $('#btn_receive_so').click(function(){
            $('#tbl_so_list tbody').html('<tr><td colspan="7"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_so.ajax.reload( null, false );
            $('#modal_so_list').modal('show');
        });

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#div_sales_invoice_fields'));
            $('#span_repair_order_no').html('RAXXXX');
            showList(false);
            $('#cbo_customers').select2('open');
            $('#tbl_items > tbody').html('');
            $('#cbo_customers').select2('val', null);
            $('#cbo_vehicles').select2('val', null);
            $('#cbo_advisors').select2('val', null);

            $('.date-picker').datepicker('setDate', 'today');
            $('.datetime-picker').val(getCurrentDatetime());

            $('#td_discount').html('0.00');
            $('#td_total_before_tax').html('0.00');
            $('#td_tax').html('0.00');
            $('#td_total_after_tax').html('0.00');
            $('#txt_overall_discount').val('0.00'); 
            $('#txt_overall_discount_amount').val('0.00'); 

            $('input[id="checkcheck"]').prop('checked', false);
            $('#for_dispatching').val('0');
            $('textarea[name="remarks"]').val($('textarea[name="remarks"]').data('default'));

            getproduct().done(function(data){
                products.clear();
                products.local = data.data;
                products.initialize(true);
                countproducts = data.data.length;
                if(countproducts > 100){
                showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
                }
            }).always(function(){ 
                $('#typeaheadsearch').val('');
            });


            /*$('#cbo_prodType').select2('val', 3);
            $('#cboLookupPrice').select2('val', 1);*/
            reComputeTotal(); //this is to make sure, display summary are recomputed as 0
        });
        $('#tbl_so_list > tbody').on('click','button[name="accept_so"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_so.row(_selectRowObj).data();
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
                $('#cbo_customers').select2('val',data.customer_id);
                $('#cbo_departments').select2('val',data.department_id);
                $('#cbo_department').select2('val',data.department_id);
                $('#cbo_salesperson').select2('val',data.salesperson_id);
                $('#cbo_customer_type').select2('val',data.customer_type_id);
                $('#cbo_order_source').select2('val', $('#cbo_order_source').data('default'));

                var obj_customers=$('#cbo_customers').find('option[value="' + data.customer_id + '"]');
                $('#txt_address').val(obj_customers.data('address'));
                $('#contact_person').val(obj_customers.data('contact'));

            });
            $('#modal_so_list').modal('hide');
            resetSummary();
            $.ajax({
                url : 'Sales_order/transaction/item-balance/'+data.sales_order_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');
                    //var rowCount = $('#tbl-items .row-item');
                    //console.log(rowCount);
                    var a = 0; 


                        changetxn ='inactive';
                    $.each(rows,function(i,value){

                    _customer_type_ = _cboCustomerType.val();
                    var temp_sale_price=0.00;

                        if(_customer_type_ == '' || _customer_type_ == 0){
                            temp_sale_price=value.sale_price;
                        }else if(_customer_type_ == '1' ){ // DISCOUNTED CUSTOMER TYPE
                            temp_sale_price=value.discounted_price;
                        }else if(_customer_type_ == '2' ){ // DEALER CUSTOMER TYPE
                            temp_sale_price=value.dealer_price;
                        }else if(_customer_type_ == '3' ){ // DISTRIBUTOR CUSTOMER TYPE
                            temp_sale_price=value.distributor_price;
                        }else if(_customer_type_ == '4' ){ // PUBLIC CUSTOMER TYPE
                            temp_sale_price=value.public_price;
                        }else{
                            temp_sale_price=value.sale_price;
                        }
                        bulk_price = temp_sale_price;

                        var retail_price = 0;
                        if(value.is_bulk == 1){
                            retail_price = getFloat(temp_sale_price) / getFloat(value.child_unit_desc);

                        }else if (value.is_bulk== 0){
                            retail_price = 0;
                        }
                        
                        $('#tbl_items > tbody').append(newRowItem({
                            inv_gross : value.inv_gross,
                            inv_qty : value.so_qty, 
                            product_code : value.product_code,
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            inv_line_total_discount : value.so_line_total_discount,
                            tax_exempt : false,
                            inv_tax_rate : value.so_tax_rate,
                            inv_price : value.so_price,
                            inv_discount : value.so_discount,
                            tax_type_id : null,
                            inv_line_total_price : value.so_line_total,
                            inv_non_tax_amount: value.non_tax_amount,
                            inv_tax_amount:value.tax_amount,
                            orig_so_price : value.so_price,
                            inv_line_total_after_global: 0.00,
                            child_unit_id : value.child_unit_id,
                            child_unit_name : value.child_unit_name,
                            parent_unit_name : value.product_unit_name,
                            parent_unit_id : getFloat(value.product_unit_id),
                            is_bulk: value.is_bulk,
                            is_parent : value.is_parent,
                            bulk_price: temp_sale_price,
                            retail_price: retail_price,
                            a:a,
                            is_basyo:value.is_basyo,
                            is_product_basyo:value.is_product_basyo,
                            exp_date : '',
                            batch_no : '',
                            cost_upon_invoice : value.purchase_cost

                        }));
                        _line_unit=$('.line_unit'+a).select2({
                            minimumResultsForSearch: -1
                        });
                        _line_unit.select2('val',value.unit_id);
                        a++;
                    });

                    changetxn = 'active';
                    $('#txt_overall_discount').val(accounting.formatNumber($('#txt_overall_discount').val(),2));
                    reInitializeNumeric();
                    reComputeTotal();
                
                }
            });

        });
        $('#tbl_sales_invoice tbody').on('click','button[name="edit_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.sales_invoice_id;
            _is_journal_posted=data.is_journal_posted;

            if(_is_journal_posted > 0){
                showNotification({title:"<b style='color:white;'> Error!</b>",stat:"error",msg:"Cannot Edit: Invoice is already Posted in Sales Journal."});
                return;
            }

            getproduct().done(function(data){
                products.clear();
                products.local = data.data;
                products.initialize(true);
                countproducts = data.data.length;
                if(countproducts > 100){
                showNotification({title:"Success !",stat:"success",msg:"Products List successfully updated."});
                }
            }).always(function(){ 
                $('#typeaheadsearch').val('');
            });

            _txnMode="edit";
            $('.sales_invoice_title').html('Edit Sales Invoice');                

            if(data.for_dispatching == 1){
                $('input[id="checkcheck"]').prop('checked', true);
                $('#for_dispatching').val('1');
            }else{
                $('input[id="checkcheck"]').prop('checked', false);
                $('#for_dispatching').val('0');
            }
            
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });
            
            $('#cbo_order_source').select2('val',data.order_source_id);
            $('#cbo_customer_type').select2('val',data.customer_type_id);
            $('#cbo_departments').select2('val',data.department_id);
            $('#cbo_department').select2('val',data.department_id);
            $('#cbo_customers').select2('val',data.customer_id);
            $('#cbo_salesperson').select2('val',data.salesperson_id);

            $.ajax({
                url : 'Sales_invoice/transaction/items/'+data.sales_invoice_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');
                     a=0;
                    $.each(rows,function(i,value){

                    _customer_type_ = _cboCustomerType.val();
                    var temp_sale_price=0.00;

                        if(_customer_type_ == '' || _customer_type_ == 0){
                            temp_sale_price=value.sale_price;
                        }else if(_customer_type_ == '1' ){ // DISCOUNTED CUSTOMER TYPE
                            temp_sale_price=value.discounted_price;
                        }else if(_customer_type_ == '2' ){ // DEALER CUSTOMER TYPE
                            temp_sale_price=value.dealer_price;
                        }else if(_customer_type_ == '3' ){ // DISTRIBUTOR CUSTOMER TYPE
                            temp_sale_price=value.distributor_price;
                        }else if(_customer_type_ == '4' ){ // PUBLIC CUSTOMER TYPE
                            temp_sale_price=value.public_price;
                        }else{
                            temp_sale_price=value.sale_price;
                        }
                        var retail_price;
                            if(value.is_bulk == 1){
                                retail_price = getFloat(temp_sale_price) / getFloat(value.child_unit_desc);

                            }else if (value.is_bulk == 0){
                                retail_price = 0;
                            }

                        $('#tbl_items > tbody').append(newRowItem({
                            inv_qty : value.inv_qty,
                            product_code : value.product_code,
                            unit_id : value.unit_id,
                            inv_gross : value.inv_gross,
                            unit_name : value.unit_name,
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            inv_line_total_discount : value.inv_line_total_discount,
                            tax_exempt : false,
                            inv_tax_rate : value.inv_tax_rate,
                            inv_price : value.inv_price,
                            inv_discount : value.inv_discount,
                            tax_type_id : null,
                            inv_line_total_price : value.inv_line_total_price,
                            inv_non_tax_amount: value.inv_non_tax_amount,
                            inv_tax_amount:value.inv_tax_amount,
                            inv_line_total_after_global : 0.00,
                            child_unit_id : value.child_unit_id,
                            child_unit_name : value.child_unit_name,
                            parent_unit_name : value.product_unit_name,
                            parent_unit_id : getFloat(value.product_unit_id),
                            is_bulk: value.is_bulk,
                            is_parent : value.is_parent,
                            bulk_price: temp_sale_price,
                            retail_price: retail_price,
                            a:a,
                            is_basyo:value.is_basyo,
                            is_product_basyo:value.is_product_basyo,
                            exp_date : value.exp_date,
                            batch_no : value.batch_no,
                            cost_upon_invoice : value.cost_upon_invoice

                        }));
                        changetxn = 'inactive';
                          _line_unit=$('.line_unit'+a).select2({
                            minimumResultsForSearch: -1
                            });
                            _line_unit.select2('val',value.unit_id);
                            a++;
                    });
                    changetxn = 'active';
                    reComputeTotal();
                    reInitializeNumeric();
                }
            });
            $('#span_repair_order_no').html(data.sales_inv_no);
            showList(false);          
            
        });
        $('#tbl_sales_invoice tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.sales_invoice_id;

            _is_journal_posted=data.is_journal_posted;

                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.sales_invoice_id;
                $.ajax({
                    "url":"Adjustments/transaction/check-invoice-for-returns?id="+_selectedID,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                }).done(function(response){
                    var row = response.data;
                    if(row.length > 0){
                        showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Cannot Delete: Sales Return exists on this invoice."});
                    return;
                    }
                    if(_is_journal_posted > 0){
                        showNotification({title:"<b style='color:white;'> Error!</b> ",stat:"error",msg:"Cannot Delete: Invoice is already Posted in Sales Journal."});
                    }else {

                        checkInvoice().done(function(response){

                            if (response.invoice.length  > 0){
                                showNotification({title:"<b style='color:white;'> Error!</b>",stat:"error",msg:"Cannot Edit: Invoice is already placed in Loading Report."});
                                return;
                            }else{
                                $('#modal_confirmation').modal('show');
                            }
                        });
                        
                    }
                });





        });
        //track every changes on numeric fields
        $('#txt_overall_discount').on('keyup',function(){
            $('.trigger-keyup').keyup();
            reComputeTotal();
        });

        $('#tbl_items tbody').on('change','select',function(){
        if(changetxn == 'active'){
        var row=$(this).closest('tr');
        var unit_value=row.find(oTableItems.unit_value).find('option:selected').attr("data-unit-identifier"); 
        if(getFloat(unit_value) == 1 ){
            var price=parseFloat(accounting.unformat(row.find(oTableItems.bulk_price).find('input.numeric').val()));
        }else{
            var price=parseFloat(accounting.unformat(row.find(oTableItems.retail_price).find('input.numeric').val()));
        }
        $(oTableItems.unit_price,row).find('input').val(accounting.formatNumber(price,2));  
        $(oTableItems.unit_identifier,row).find('input').val(accounting.formatNumber(unit_value,2)); 
        $('.trigger-keyup').keyup();
        
        }   
        });

        $('#tbl_items tbody').on('keyup','input.numeric',function(){
            var row=$(this).closest('tr');
            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.numeric').val()));
            var tax_rate=parseFloat(accounting.unformat(row.find(oTableItems.tax).find('input.numeric').val()))/100;
            // var gross=parseFloat(accounting.unformat(row.find(oTableItems.gross).find('input.numeric').val()));
            
            if(discount>price){
                showNotification({title:"Invalid",stat:"error",msg:"Discount must not greater than unit price."});
                row.find(oTableItems.discount).find('input.numeric').val('0.00');
                row.find(oTableItems.discount).find('input.numeric').select();
                $(this).trigger('keyup');
                return;
            }
            // var discounted_price=price-discount;
            // var line_total_discount=discount*qty;
            // var line_total=discounted_price*qty;

            var global_discount = $('#txt_overall_discount').val();
            var line_total = price*qty; //ok not included in the output (view) and not saved in the database
            var line_total_discount=discount*qty; 
            // var line_total_discount=line_total*(discount/100);
            var new_line_total=line_total-line_total_discount; 
            var total_after_global = new_line_total-(new_line_total*(global_discount/100));
            var net_vat=total_after_global/(1+tax_rate);
            var vat_input=total_after_global-net_vat;

            $(oTableItems.gross,row).find('input.numeric').val(accounting.formatNumber(line_total,2)); //gross
            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(total_after_global,2)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(line_total_discount); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(net_vat); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(vat_input); //vat input
            $(oTableItems.total_after_global,row).find('input.numeric').val(accounting.formatNumber(total_after_global,2));
            //console.log(net_vat);

            if(accounting.unformat(row.find('.is_basyo').val()) == 1){
                reComputeTotalBasyo();
            }

            reComputeTotal();
        });

        $('#tbl_items tbody').on('keypress','input.qty',function(){
            var row=$(this).closest('tr');
            row.find(oTableItems.discount).find('input.numeric').focus();
            row.find(oTableItems.discount).find('input.numeric').select();
        });
        
        $('#tbl_items tbody').on('keypress','input.discount',function(evt){
            if(evt.keyCode==13){
                evt.preventDefault();
                $('#typeaheadsearch').focus();
            }
        });        

        $('#tbl_items tbody').on('focus','input.numeric',function(){
            $(this).select();
        });

        $('#btn_yes').click(function(){
            //var d=dt.row(_selectRowObj).data();
            //if(getFloat(d.order_status_id)>1){
            //showNotification({title:"Error!",stat:"error",msg:"Sorry, you cannot delete purchase order that is already been recorded on purchase invoice."});
            //}else{
            removeIssuanceRecord().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }
            });
            //}
        });
        $('#btn_cancel').click(function(){
            //$('#modal_so_list').modal('hide');
            showList(true);
        });
        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_sales_invoice'))){
                if(_txnMode=="new"){
                    createSalesInvoice().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_sales_invoice'));
                            showList(true);
                            if(response.is_auto_print == 1){
                                window.open('Templates/layout/sales-invoice/'+ response.row_added[0].sales_invoice_id +'?type=direct');
                            }
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateSalesInvoice().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields($('#frm_sales_invoice'));
                            showList(true);
                             if(response.is_auto_print == 1){
                                window.open('Templates/layout/sales-invoice/'+ response.row_updated[0].sales_invoice_id +'?type=direct');
                            }
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });
        /*$('#btn_save').click(function(){
                if(validateRequiredFields($('#frm_sales_invoice'))){
                    if(_txnMode=="new"){
                        createSalesInvoice().done(function(response){
                            showNotification(response);
                            if(response.stat=="success"){
                                dt.row.add(response.row_added[0]).draw();
                                clearFields($('#frmSO @#_sales_invoice'));
                                showList(true);
                            }
                            if (response.current_row_index != undefined) {
                                var rowObj=$('#tbl_items > tbody tr:eq('+response.current_row_index+')');
                                rowHighlight(rowObj);
                            }
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateSalesInvoice().done(function(response){
                            showNotification(response);
                            if(response.stat=="success"){
                                dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                                clearFields($('#frm_sales_invoice'));
                                showList(true);
                            }
                            if (response.current_row_index != undefined) {
                                var rowObj=$('#tbl_items > tbody tr:eq('+response.current_row_index+')');
                                rowHighlight(rowObj);
                            }
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                    //$('#cbo_prodType').select2('val',null);
                }
            });*/
        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotalBasyo();
            reComputeTotal();
        });

        $('#tbl_items > tbody').on('click','button[name="search_item"]',function(){
            _selectRowTblItems=$(this).closest('tr');
            global_item_desc=_selectRowTblItems.find(oTableItems.unit_identifier).find($('.product_desc')).val();

            var _data=[];
            _data.push({name : "description", value : global_item_desc });


            $.ajax({
                url : 'Sales_invoice/transaction/current-items-search',
                "dataType":"json",
                "type":"POST",
                cache : false,
                dataType : 'json',
                "data":_data,
                beforeSend : function(){
                    $('#tbl_search_list > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    if(rows.length == 0){
                        showNotification({
                            title: "<b style='color:white;display: inline;'>No Stocks!</b>",
                            stat : "error",
                            msg : "There are no stocks available for the item."
                        });

                    }else{
                        $('#tbl_search_list > tbody').html('');
                        $.each(rows,function(i,value){
                            $('#tbl_search_list > tbody').append('<tr class="row-item">'+
                            '<td >'+value.product_code+'</td>'+
                            '<td >'+value.product_desc+'</td>'+
                            '<td >'+value.batch_no+'</td>'+
                            '<td >'+value.exp_date+'</td>'+
                            '<td align="right">'+value.on_hand_per_batch+'</td>'+
                            '<td align="right">'+value.srp+'</td>'+
                            '<td align="right">'+value.srp_cost+'</td>'+
                            '<td><center><button type="button" name="accept_search" class="btn btn-success"><i class="fa fa-check"></i></button></center></td>'+
                            '<tr></tr>'
                            );
                        });
                        $("#modal_search_list").modal('show');
                    }


                }
            });
        });        

        $('#tbl_search_list > tbody').on('click','button[name="accept_search"]',function(){
            var row=$(this).closest('tr');
            _selectRowTblItems.find(oTableItems.exp_date).find('input').val(row.find(oTableSearch.sExpDate).text());
            _selectRowTblItems.find(oTableItems.batch_no).find('input').val(row.find(oTableSearch.sBatch).text());
            _selectRowTblItems.find(oTableItems.cost_upon_invoice).find('input').val(row.find(oTableSearch.sCost).text());

            showNotification({title:"Success!",stat:"success",msg:'The item you selected was updated.'});

            $('#modal_search_list').modal('hide');
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

    var getCurrentDatetime=function(){
        var timestamp = new Date();
        var formattedDate = moment(timestamp).format('MM/DD/YYYY hh:mm A');
        return formattedDate;
    };

    var getproduct=function(){
       return $.ajax({
           "dataType":"json",
           "type":"POST",
           "url":"products/transaction/current-items",
           "beforeSend": function(){
                countproducts = products.local.length;
                if(countproducts > 100){
                    showNotification({title:"Please Wait !",stat:"info",msg:"Refreshing your Products List."});
                }
           }
      });
    };

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
        _data.push({name : "customer_id", value : $('#cbo_customers').val()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Vehicles/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var createSalesInvoice=function(){
        var _data=$('#frm_sales_invoice,#frm_items_pms').serializeArray();
        var tbl_summary=$('#tbl_sales_invoice_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "for_dispatching", value : $('#for_dispatching').val()});

        _data.push({name : "total_after_discount", value: $('#td_total_after_discount').text()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.inv_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});

        $('input[name="is_auto_print"]').prop("checked") ?  _data.push({name : "is_auto_print" , value : '1'   }) : _data.push({name : "is_auto_print" , value : '0'   });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_invoice/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var updateSalesInvoice=function(){
        var _data=$('#frm_sales_invoice,#frm_items_pms').serializeArray();
        var tbl_summary=$('#tbl_sales_invoice_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "for_dispatching", value : $('#for_dispatching').val()});
        _data.push({name : "total_after_discount", value: $('#td_total_after_discount').text()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.inv_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "sales_invoice_id" ,value : _selectedID});

        $('input[name="is_auto_print"]').prop("checked") ?  _data.push({name : "is_auto_print" , value : '1'   }) : _data.push({name : "is_auto_print" , value : '0'   });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_invoice/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var checkInvoice=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_invoice/transaction/check-invoice-loading",
            "data":{sales_invoice_id : _selectedID}
        });
    };

    var getInvetory=function(product_id){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Products/transaction/product-inventory",
            "data":{product_id : product_id}
        });
    }

    var removeIssuanceRecord=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_invoice/transaction/delete",
            "data":{sales_invoice_id : _selectedID}
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
    $('#cancel_modal').on('click',function(){
        $('#modal_so_list').modal('hide');
    });
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
        if(d.primary_unit == 1){ parent = ' selected'; child = ' '; }else{ parent = ' '; child = ' selected'; }
        if(d.is_bulk == '1'){ 
            unit = '<td ><select class="line_unit'+d.a+'" name="unit_id[]"><option value="'+d.parent_unit_id+'" data-unit-identifier="1" '+parent+'>'+d.parent_unit_name+'</option><option value="'+d.child_unit_id+'" data-unit-identifier="0" '+child+'>'+d.child_unit_name+'</option></select></td>';
        }else{ 
            unit  = '<td ><select class="line_unit'+d.a+'" name="unit_id[]" ><option value="'+d.parent_unit_id+'" data-unit-identifier="1" '+parent+'>'+d.parent_unit_name+'</option></select></td>';
        }
        return '<tr>'+
            // [0] QTY
            '<td>'+
                '<input name="inv_qty[]" type="text" class="numeric form-control trigger-keyup qty" value="'+accounting.formatNumber(d.inv_qty,2)+'">'+
            '</td>'+
            // [1] Unit
            unit+
            // [2] Item
            '<td>'+
                d.product_desc+
                '<input type="text" class="hidden product_desc" value="'+d.product_desc+'">'+
                '<input type="text" class="hidden" class="form-control" name="is_parent[]" value="'+d.is_parent+'">'+
                '<input type="text" class="hidden is_basyo" value="'+d.is_basyo+'">'+
                '<input type="text" class="hidden is_product_basyo" value="'+d.is_product_basyo+'">'+
            '</td>'+
            // [3] Unit Price
            '<td>'+
                '<input name="inv_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.inv_price,2)+'" style="text-align:right;">'+
            '</td>'+
            // [4] Discount
            '<td  style=""><input name="inv_discount[]" type="text" class="numeric form-control discount" value="'+ accounting.formatNumber(d.inv_discount,2)+'" style="text-align:right;">'+
            '</td>'+
            // [5] Total Discount
            '<td class="hidden">'+
                '<input name="inv_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_line_total_discount,2)+'" readonly>'+
            '</td>'+
            // [6] Tax Rate
            '<td class="hidden"><input name="inv_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_tax_rate,2)+'">'+
            '</td>'+
            // [7] Gross
            '<td><input name="inv_gross[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_gross,2)+'" readonly>'+
            '</td>'+
            // [8] Net Total
            '<td  align="right"><input name="inv_line_total_price[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.inv_line_total_price,2)+'" readonly>'+
            '</td>'+
            // [9] Expiration
            '<td>'+
                '<input name="exp_date[]" type="text" class="form-control" value="'+ d.exp_date +'" readonly>'+
            '</td>'+
            // [10] Batch #
            '<td>'+
                '<input name="batch_no[]" type="text" class="form-control" value="'+ d.batch_no +'" readonly>'+
            '</td>'+
            // [11] Cost Upon Invoice
            '<td class="hidden"><input name="cost_upon_invoice[]" type="text" class="numeric form-control" value="'+ d.cost_upon_invoice+'" readonly>'+
            '</td>'+
            // [12] Vat Input
            '<td class="hidden">'+
                '<input name="inv_tax_amount[]" type="text" class="numeric form-control" value="'+ d.inv_tax_amount+'" readonly>'+
            '</td>'+
            // [13] Net of Vat
            '<td class="hidden">'+
                '<input name="inv_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.inv_non_tax_amount+'" readonly>'+
            '</td>'+
            // [14] Product ID
            '<td class="hidden">'+
                '<input name="product_id[]" type="text" class="numeric form-control" value="'+ d.product_id+'" readonly>'+
            '</td>'+
            // [15] Total After Global
            '<td class="hidden"><input name="inv_line_total_after_global[]" type="text" class="numeric form-control" value="'+ d.inv_line_total_after_global+'" readonly>'+
            '</td>'+
            // [16] Action
            '<td align="center">'+
                '<button type="button" name="search_item" class="btn btn-warning" style="margin-right: 5px;"><i class="fa fa-search"></i></button>'+
                '<button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button>'+
            '</td>'+
            // [17] Bulk Price
            '<td class="hidden">'+
                '<input type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.bulk_price,2)+'" readonly>'+
            '</td>'+
            // [18] Retail Price
            '<td class="hidden">'+
                '<input type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.retail_price,2)+'" readonly>'+
            '</td>'+
        '</tr>';
    };
    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');
        var discounts=0; var before_tax=0; var after_tax=0; var inv_tax_amount=0; var gross=0;
        var global_discount = parseFloat(accounting.unformat($('#txt_overall_discount').val()/100));

        $.each(rows,function(){
            //console.log($(oTableItems.net_vat,$(this)));
            total=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
            total_after_global = (total - (total*global_discount));
            $(oTableItems.total_after_global,$(this)).find('input.numeric').val(accounting.formatNumber(total_after_global,2));

            gross+=parseFloat(accounting.unformat($(oTableItems.gross,$(this)).find('input.numeric').val()));
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            inv_tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        });

        var tbl_summary=$('#tbl_sales_invoice_summary');
        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts,2));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,2));
        tbl_summary.find(oTableDetails.inv_tax_amount).html(accounting.formatNumber(inv_tax_amount,2));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');

        $('#txt_overall_discount_amount').val(accounting.formatNumber((gross-discounts) * ($('#txt_overall_discount').val() / 100),2));
        $('#td_total_before_tax').html(accounting.formatNumber(before_tax,2));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');
        $('#td_total_after_discount').html(accounting.formatNumber(after_tax - (after_tax * ($('#txt_overall_discount').val() / 100)),2));
        $('#td_tax').html(accounting.formatNumber(inv_tax_amount,2));
        $('#td_discount').html(accounting.formatNumber(discounts,2)); // unknown - must be referring to table summary but not on id given
    };

    var TotalBasyo=function(){
        var rows=$('#tbl_items > tbody tr');
        var total_basyo = 0;
        var qty = 0;

        $.each(rows,function(){
            var is_basyo = $(this).find('.is_basyo').val();
            if(is_basyo == 1){
                qty=parseFloat(accounting.unformat($(oTableItems.qty,$(this)).find('input.numeric').val()));
                total_basyo += qty;
            }
        });

        return accounting.formatNumber(total_basyo,2);
    };

    var reComputeTotalBasyo=function(){
        var total_basyo = TotalBasyo();

        var basyo_rows=$('#tbl_items > tbody tr');
        $.each(basyo_rows,function(){
            var is_product_basyo = $(this).find('.is_product_basyo').val();
            if(is_product_basyo == 1){
                $(this).find('.qty').val(total_basyo);
                $(this).find('.qty').trigger('keyup');
            }
        });
    };

    var resetSummary=function(){
        var tbl_summary=$('#tbl_sales_invoice_summary');
        tbl_summary.find(oTableDetails.discount).html('0.00');
        tbl_summary.find(oTableDetails.before_tax).html('0.00');
        tbl_summary.find(oTableDetails.inv_tax_amount).html('0.00');
        tbl_summary.find(oTableDetails.after_tax).html('<b>0.00</b>');
    };
    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
    };


    var checkProduct= function(check_id){
        var prodstat=true;
        var rowcheck=$('#tbl_items > tbody tr');
        $.each(rowcheck,function(){
            item = parseFloat(accounting.unformat($(oTableItems.item_id,$(this)).find('input.numeric').val()));
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