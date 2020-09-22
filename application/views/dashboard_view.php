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

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">


    <style>
    .data-container {
          border-radius: 5px;
        background: rgba(255, 255, 255, .1);
        padding: 10px;
        border:1px solid #d4dbdd;
    }

    .text-container{
      background-color: #45aeda;
      color:white;

    }
    .graph-container{

      
    }
    .toolbar{
        float: left;
    }

    .btn-white {
        background: white none repeat scroll 0 0;
        border: 1px solid #e7eaec;
        color: inherit;
        text-transform: none;
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

    @keyframes spin {
        from { transform: scale(1) rotate(0deg); }
        to { transform: scale(1) rotate(360deg); }
    }

    @-webkit-keyframes spin2 {
        from { -webkit-transform: rotate(0deg); }
        to { -webkit-transform: rotate(360deg); }
    }

    </style>
    <style>

        .page-content {
            overflow-x: hidden!important;
        }

        #tbl_po_list ,#tbl_po_list_review{
/*            color: white!important;
            border: none!important;*/
            font-size: 12px;
        }

        #tbl_po_list_checking,#tbl_po_list_checking .no-padding table, 
        #tbl_po_list .no-padding table,
        #tbl_po_list_review .no-padding table{
          font-size: 12px;
        }
        th {
          background: rgba(255, 255, 255, .2)!important;
          border-bottom: 1px solid #525252;
        }

        @media (min-width: 768px){
          .seven-cols .col-md-1,
          .seven-cols .col-sm-1,
          .seven-cols .col-lg-1  {
            width: 100%;
            *width: 100%;
          }
        }

        @media (min-width: 992px) {
          .seven-cols .col-md-1,
          .seven-cols .col-sm-1,
          .seven-cols .col-lg-1 {
            width: 14.285714285714285714285714285714%;
            *width: 14.285714285714285714285714285714%;
          }
        }
         
        @media (min-width: 1200px) {
          .seven-cols .col-md-1,
          .seven-cols .col-sm-1,
          .seven-cols .col-lg-1 {
            width: 14.285714285714285714285714285714%;
            *width: 14.285714285714285714285714285714%;
          }
        }
    </style>

    <style>
      .v-timeline {
          position: relative;
          padding: 0;
          margin-top: 2em;
          margin-bottom: 2em;
      }
      .vertical-container {
          width: 98%;
          margin: 0 auto;
      }

      .v-timeline::before {
          content: '';
          position: absolute;
          top: 0;
          left: 18px;
          height: 100%;
          width: 4px;
          background: #525252;
      }

      .vertical-timeline-block:first-child {
        margin-top: 0;
      }

      .vertical-timeline-block {
          position: relative;
          margin: 2em 0;
      }

      .vertical-timeline-icon {
          position: absolute;
          top: 0;
          left: 0;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          font-size: 16px;
          border: 1px solid #525252;
          text-align: center;
          background: #525252;
          color: #ffffff;
      }

      .vertical-timeline-icon i {
          display: block;
          width: 24px;
          height: 24px;
          position: relative;
          left: 50%;
          top: 50%;
          margin-left: -12px;
          margin-top: -9px;
      }

      .c-accent {
          color: #f6a821;
      }

      .vertical-timeline-content {
          position: relative;
          margin-left: 60px;
/*          background-color: rgba(68, 70, 79, 0.5);*/
          border-radius: 0.25em;
          border: 1px solid #3d404c;
      }

      .vertical-timeline-content:before {
          border-color: transparent;
          border-right-color: #3d404c;
          border-width: 11px;
          margin-top: -11px;
      }

      .vertical-timeline-content:after, .vertical-timeline-content:before {
          right: 100%;
          top: 20px;
          border: solid transparent;
          content: " ";
          height: 0;
          width: 0;
          position: absolute;
          pointer-events: none;
      }

      .p-sm {
          padding: 15px !important;
      }

      .vertical-timeline-content .vertical-date {
          font-weight: 500;
          text-align: right;
      }

      .vertical-timeline-content p {
          margin: 1em 0 0 0;
          line-height: 1.6;
      }

      .vertical-timeline-content:after {
          border-color: transparent;
          border-right-color: #3d404c;
          border-width: 10px;
          margin-top: -10px;
      }

      .vertical-timeline-content:after, .vertical-timeline-content:before {
          right: 100%;
          top: 20px;
          border: solid transparent;
          content: " ";
          height: 0;
          width: 0;
          position: absolute;
          pointer-events: none;
      }

      .vertical-timeline-content:after {
          content: "";
          display: table;
          clear: both;
      }

      .vertical-timeline-content {
          position: relative;
          margin-left: 60px;
/*          background-color: rgba(68, 70, 79, 0.5);*/
          border-radius: 0.25em;
          border: 1px solid #3d404c;
      }

      .vertical-timeline-block:after {
          content: "";
          display: table;
          clear: both;
      }

      .vertical-container::after {
          content: '';
          display: table;
          clear: both;
      }

      .v-timeline {
          position: relative;
          padding: 0;
          margin-top: 2em;
          margin-bottom: 2em;
      }

      .vertical-container {
          width: 98%;
          margin: 0 auto;
      }

      #style-1::-webkit-scrollbar-track
      {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: transparent;
      }

      #style-1::-webkit-scrollbar
      {
        width: 10px;
        border-radius: 11px;
        background-color: transparent;
      }

      #style-1::-webkit-scrollbar-thumb
      {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
      }
      #tbl_po_list_filter, #tbl_po_list_review_filter, #tbl_vouchers_list_filter , #tbl_po_list_checking_filter{
        display:none;
      }
      #tbl_vouchers_list{
        font-size: 12px;
      }
    </style>

</head>

<body class="animated-content" style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
        <div id="layout-static">
        <?php echo $_side_bar_navigation; ?>
        <div class="static-content-wrapper" >
            <div class="static-content">
                    <div class="page-content"  style="overflow-y:hidden;overflow-x:hidden;"><!-- #page-content -->
                            <div data-widget-group="group1">
                                <div class="row">
                                    <div class="col-md-12" >
                                        <div class="panel panel-default" style="overflow-x: hidden!important;"> 
                                            <div class="panel-body table-responsive" style="border-top-color: white!important;">

                                                <div class="col-sm-6" style="word-wrap: break-word;">
                                                <h1 ><b class="ti ti-bar-chart-alt"  style="color:#067cb2;"></b> <strong style="color:#067cb2;">JCORE</strong> Standard Accounting</h1>
                                                <div id="intro">
                                                    <h4 class="welcome-msg" style="word-wrap: break-word;padding-left: 0px;padding-right: 0px;">Hi
                                                        <b style="color:#067cb2;" >
                                                            <?php echo $this->session->user_fullname; ?>
                                                        </b> here is a rundown of your business' <br>performance and how your collections are doing individually. 
                                                    </h4>
                                                </div>
                                                </div>
                                                <div class="col-sm-6" style="word-wrap: break-word;padding-left: 0px;padding-right: 0px;">
                                                <div id="intro">
                                                    <h1 class="welcome-msg">
                                                        <?php echo $company_info[0]->company_name; ?>
                                                    </h1>
                                                </div>
                                                  <h4 class="welcome-msg" style=""><?php echo $company_info[0]->company_address; ?></h4><br>
                                                </div>                                                    
                                                </div>
                                                <hr style="border-color:#067cb2;!important;border-top:5px solid #03a9f4;margin-top: 0px;">
                                                <h3><b   style="color: #067cb2;" class="fa fa-dashboard"></b> DASHBOARD</h3>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <div class="data-container text-center text-container">
                                                            <h2><strong><?php echo ($this->session->user_group_id != 1 ? '0.00' : number_format($receivables->Balance,2)); ?></strong></h2>
                                                            <h4><b>Accounts Receivables</b></h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <div class="data-container text-center text-container">
                                                            <h2><strong><?php echo ($this->session->user_group_id != 1 ? '0.00' : number_format($payables->Balance,2)); ?></strong></h2>
                                                            <h4><b>Accounts Payables</b></h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <div class="data-container text-center text-container">
                                                            <h2><strong><?php echo ($this->session->user_group_id != 1 ? '0' : $customer_count); ?></strong></h2>
                                                            <h4><b>Customers</b></h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-3">
                                                        <div class="data-container text-center text-container">
                                                            <h2><strong><?php echo ($this->session->user_group_id != 1 ? '0' : $suppliers_count); ?></strong></h2>
                                                            <h4><b>Suppliers</b></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <div class="data-container text-center graph-container">
                                                            <canvas id="salesChart"></canvas>
                                                            <span>Income (Last Year) vs Income (Current Year)</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6">
                                                        <div class="data-container text-center graph-container">
                                                            <canvas id="testChart"></canvas>
                                                            <span>Income vs Expense (Current Year)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <div class="data-container text-center graph-container">
                                                        <label style="font-weight: normal;" class="pull-left"><i><b>Expense Graph</b></i></label>
                                         
                                                        <label style="font-weight: normal;" class="pull-right">Based on Disbursement Report</label>
                                                            <canvas id="ExpenseChart"></canvas>
                                                            <span>Month</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-6">
                                                        <div class="data-container text-center graph-container">
                                                        <label style="font-weight: normal;" class="pull-left"><i><b>Sales Report</b></i></label>
                                         
                                                        <label style="font-weight: normal;" class="pull-right">In terms of Sales and Cash Invoice</label>
                                                            <canvas id="SalesInvoiceChart"></canvas>
                                                            <span style="font-weight: bolder;">Month</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 col-sm-12 <?php echo (in_array('7-3',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="min-height: 300px; max-height: 700px;overflow-x: hidden;">
                                                      <div class="row">
                                                        <div class="col-sm-9"><h3 class="po_title" style=""><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >VOUCHERS FOR APPROVAL</span></h3>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="search_tbl_vouchers_list" class="form-control">
                                                        </div>
                                                      <div class="col-sm-12">
                                                            <table id="tbl_vouchers_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th width="5%"></th>
                                                                    <th width="15%">TXN #</th>
                                                                    <th width="15%">TYPE</th>
                                                                    <th>Particular</th>
                                                                    <th width="7%">Method</th>
                                                                    <th width="40%">Remarks </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                      </div>

                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 col-sm-12 <?php echo (in_array('7-2',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="min-height: 300px; max-height: 700px;overflow-x: hidden;">
                                                      <div class="row">
                                                        <div class="col-sm-9"><h3 class="po_title" style=""><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE ORDER <small>| FOR VERIFICATION</small></span></h3>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="search_tbl_po_list_review" class="form-control">
                                                        </div>
                                                      <div class="col-sm-12">
                                                            <table id="tbl_po_list_review" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PO #</th>
                                                                    <th>Vendor</th>
                                                                    <th width="20%">Remarks </th>
                                                                    <th>Posted by </th>
                                                                    <th style="text-align: center;"> <i class="fa fa-paperclip"></i></th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                      </div>

                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 col-sm-12 <?php echo (in_array('7-4',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="min-height: 300px; max-height: 700px;overflow-x: hidden;">
                                                      <div class="row">
                                                        <div class="col-sm-9"><h3 class="po_title" style=""><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE ORDER  <small>| FOR ACCOUNTING APPROVAL</small> </span></h3>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="search_tbl_po_list_checking" class="form-control">
                                                        </div>
                                                      <div class="col-sm-12">
                                                            <table id="tbl_po_list_checking" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PO #</th>
                                                                    <th>Vendor</th>
                                                                    <th width="20%">Remarks </th>
                                                                    <th>Posted by </th>
                                                                    <th style="text-align: center;"> <i class="fa fa-paperclip"></i></th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                      </div>

                                                      </div>
                                                    </div>
                                                </div>                                                
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 col-sm-12 <?php echo (in_array('7-1',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="min-height: 300px; max-height: 700px;overflow-x: hidden;">
                                                      <div class="row">
                                                        <div class="col-sm-9"><h3 class="po_title" style=""><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE ORDER <small>| FOR FINAL APPROVAL</small></span></h3>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="search_tbl_po_list" class="form-control">
                                                        </div>
                                                      <div class="col-sm-12">
                                                            <table id="tbl_po_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PO #</th>
                                                                    <th>Vendor</th>
                                                                    <th width="20%">Remarks </th>
                                                                    <th>Posted by </th>
                                                                    <th style="text-align: center;"> <i class="fa fa-paperclip"></i></th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div> <!-- #page-content -->
            </div>

      <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                      <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Disapproval Confirmation</h4>

                  </div>

                  <div class="modal-body">
                  <table width="100%" class="table table-striped" style="font-size: 12px;margin-bottom: 0px;">
                      <tbody>
                          <tr>
                              <td style="width: 30%;"><b>Purchase Order No: </b></td>
                              <td id="disapproved_po_no"></td>
                          </tr>
                          <tr>
                              <td><b>Disapproved By: </b></td>
                              <td id=""><?php echo $this->session->user_fullname; ?></td>
                          </tr>
                          <tr>
                              <td><b>Optional Remarks:</b></td>
                              <td id=""><textarea id="disapproval_remarks" class="form-control" placeholder="Disapproval Remarks"></textarea></td>
                          </tr>
                      </tbody>
                  </table>
                  </div>
            <div class="modal-footer">
                <button id="btn_yes_disapprove" type="button" class="btn btn-danger" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Accept</button>

            </div>
              </div>
          </div>
      </div>

      <div id="modal_confirmation_review" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                      <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Review Confirmation</h4>

                  </div>

                  <div class="modal-body">
                  <table width="100%" class="table table-striped" style="font-size: 12px;margin-bottom: 0px;">
                      <tbody>
                          <tr>
                              <td style="width: 30%;"><b>Purchase Order No: </b></td>
                              <td id="review_po_no"></td>
                          </tr>
                          <tr>
                              <td><b>Reviewed By: </b></td>
                              <td id=""><?php echo $this->session->user_fullname; ?></td>
                          </tr>
                          <tr>
                              <td><b>Optional Remarks:</b></td>
                              <td id=""><textarea id="review_remarks" class="form-control" placeholder="Optional Remarks"></textarea></td>
                          </tr>
                      </tbody>
                  </table>
                  </div>
            <div class="modal-footer">
                <button id="btn_yes_review" type="button" class="btn btn-danger" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Accept</button>

            </div>
              </div>
          </div>
      </div>

      <div id="modal_confirmation_check" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                      <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Accounting Checking Confirmation</h4>

                  </div>

                  <div class="modal-body">
                  <table width="100%" class="table table-striped" style="font-size: 12px;margin-bottom: 0px;">
                      <tbody>
                          <tr>
                              <td style="width: 30%;"><b>Purchase Order No: </b></td>
                              <td id="check_po_no"></td>
                          </tr>
                          <tr>
                              <td><b>Confirmed By: </b></td>
                              <td id=""><?php echo $this->session->user_fullname; ?></td>
                          </tr>
                          <tr>
                              <td><b>Optional Remarks:</b></td>
                              <td id=""><textarea id="checking_remarks" class="form-control" placeholder="Optional Remarks"></textarea></td>
                          </tr>
                      </tbody>
                  </table>
                  </div>
            <div class="modal-footer">
                <button id="btn_yes_check" type="button" class="btn btn-danger" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Accept</button>

            </div>
              </div>
          </div>
      </div>      
      <div id="modal_confirmation_approval" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                      <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Approval Confirmation</h4>

                  </div>

                  <div class="modal-body">
                  <table width="100%" class="table table-striped" style="font-size: 12px;margin-bottom: 0px;">
                      <tbody>
                          <tr>
                              <td style="width: 30%;"><b>Purchase Order No: </b></td>
                              <td id="approval_po_no"></td>
                          </tr>
                          <tr>
                              <td><b>Approved By: </b></td>
                              <td id=""><?php echo $this->session->user_fullname; ?></td>
                          </tr>
                          <tr>
                              <td><b>Approval Remarks:</b></td>
                              <td id=""><textarea id="approval_remarks" class="form-control" placeholder="Optional Remarks"></textarea></td>
                          </tr>
                      </tbody>
                  </table>
                  </div>
            <div class="modal-footer">
                <button id="btn_yes_approval" type="button" class="btn btn-danger" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Accept</button>

            </div>
              </div>
          </div>
      </div>
            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; <a href='Truncate' style="text-decoration: none;color:black;"> 2017</a> - JDEV IT BUSINESS SOLUTION</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>




        </div>
        </div>


</div>


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>



<!-- Sparkline -->
<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- CHART -->
<script src="assets/plugins/chartJs/Chart.min.js"></script>

<!-- DATATABLE -->
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>

<script>
var ctx = document.getElementById("salesChart").getContext('2d');
var ctxIE = document.getElementById("testChart").getContext('2d');
var ctxSalesInvoice = document.getElementById("SalesInvoiceChart").getContext('2d');
var ctxExpenseChart = document.getElementById("ExpenseChart").getContext('2d');

Chart.defaults.global.defaultFontColor = "#000000";

  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: ["Jan","Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: 'Income (Last Year)',
              data: <?php echo ($this->session->user_group_id != 1 ? 0 : json_encode($previous_year_income_monthly)); ?>,
              backgroundColor: [
                  'rgba(255, 255, 255, .1)'
              ],
              borderColor: [
                  '#0b77a8'
              ],
              borderWidth: 2
            },
            {
              label: 'Income (Current Year)',
              data: <?php echo ($this->session->user_group_id != 1 ? 0 : json_encode($current_year_income_monthly)); ?>,
              backgroundColor: [
                  'rgba(255, 255, 255, .1)'
              ],
              borderColor: [
                  '#03a9f4'
              ],
              borderWidth: 2
            }
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });

  var iEChart = new Chart(ctxIE, {
      type: 'bar',
      data: {
          labels: ["Jan","Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: 'Income (Current Year)',
              data: <?php echo ($this->session->user_group_id != 1 ? 0 : json_encode($current_year_income_monthly)); ?>,
              backgroundColor: [
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)',
                  'rgba(255, 152, 0, .2)'
              ],
              borderColor: [
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)',
                  'rgb(255, 152, 0)'              
              ],
              borderWidth: 2
            },
            {
              label: 'Expense (Current Year)',
              data: <?php echo ($this->session->user_group_id != 1 ? 0 : json_encode($expense_monthly)); ?>,
              backgroundColor: [
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)'

              ],
              borderColor: [
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)'
              ],
              borderWidth: 2
            }
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });

  var salesinvoiceChart = new Chart(ctxSalesInvoice, {
      type: 'bar',
      data: {
          labels: ["Jan","Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: "Sales Income (Current Year)",
              data: <?php echo ($this->session->user_group_id != 1 ? 0 : json_encode($current_year_sales_invoice)); ?>,
              backgroundColor: [
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)'

              ],
              borderColor: [
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)'
              ],
              borderWidth: 2
            }
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });

  var ExpenseChart = new Chart(ctxExpenseChart, {
      type: 'bar',
      data: {
          labels: ["Jan","Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: "Expense (Current Year)",
              data: <?php echo ($this->session->user_group_id != 1 ? 0 : json_encode($expense_monthly)); ?>,
              backgroundColor: [
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)',
              'rgb(168, 227, 255)'

              ],
              borderColor: [
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)',
              'rgb(3, 169, 244)'
              ],
              borderWidth: 2
            }
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });
</script>

<script>
    var sparklineCharts = function(){
            $("#sparkline1").sparkline([10,30,20,20,30,40,50], {
                type: 'line',
                width: '100%',
                height: '40',
                lineColor: '#ff9800',
                fillColor: 'rgba(255, 152, 0, .1)',
                lineWidth: '3',
                spotColor: '#f44336',
                maxSpotColor: '#f44336',
                minSpotColor: '#f44336',
                highlightSpotColor: '#00007f',
                highlightLineColor: '#7f007f',
                normalRangeColor: '#0000bf',
                spotRadius: '0'
            });
    };

    var sparkResize;

    $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineCharts, 500);
    });

    sparklineCharts();
</script>

<script>

    $(document).ready(function(){
        var dt; var _selectedID; var _selectRowObj; var _selectedIDvoucher; var dtchecking;

        var initializeControls=(function(){
            dt=$('#tbl_po_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchases/transaction/po-for-approved",
                "language": {
                  "searchPlaceholder":"Search Purchase Order"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "po_no" },
                    { targets:[2],data: "supplier_name" },
                    { targets:[3],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(60)},
                    { targets:[4],data: "posted_by" },
                    {
                        targets:[5],data: "attachment",
                        render: function (data, type, full, meta){

                            return '<center>'+ data +' <i class="fa fa-paperclip"></i></classenter>';
                        }

                    },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_order_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_po"  data-toggle="tooltip" data-placement="top" title="Approve this PO"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';
                            var btn_conversation='<a id="link_conversation" href="Po_messages?id='+full.purchase_order_id+'" target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Open Conversation"><i class="fa fa-envelope"></i> </a>';
                            var btn_disapproved='<button class="btn btn-danger btn-sm" name="disapprove_po" data-toggle="tooltip" data-placement="top" title="Disapprove this PO"><i class="fa fa-times" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'&nbsp;'+btn_conversation+'&nbsp;'+btn_disapproved+'</center>';
                        }
                    }
                ]
            });

            dtreview=$('#tbl_po_list_review').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchases/transaction/po-for-review",
                "language": {
                  "searchPlaceholder":"Search Purchase Order"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "po_no" },
                    { targets:[2],data: "supplier_name" },
                    { targets:[3],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(60)},
                    { targets:[4],data: "posted_by" },
                    {
                        targets:[5],data: "attachment",
                        render: function (data, type, full, meta){

                            return '<center>'+ data +' <i class="fa fa-paperclip"></i></classenter>';
                        }

                    },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_order_id);

                            var btn_approved='<button class="btn btn-primary btn-sm" name="reviewed_po"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Mark this PO as reviewed"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';
                            var btn_conversation='<a id="link_conversation" href="Po_messages?id='+full.purchase_order_id+'" target="_blank" class="btn btn-info btn-sm"  style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Open Conversation"><i class="fa fa-envelope"></i> </a>';

                            return '<center>'+btn_approved+'&nbsp;'+btn_conversation+'</center>';
                        }
                    }
                ]
            });

            dtchecking=$('#tbl_po_list_checking').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchases/transaction/po-for-checking",
                "language": {
                  "searchPlaceholder":"Search Purchase Order"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "po_no" },
                    { targets:[2],data: "supplier_name" },
                    { targets:[3],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(60)},
                    { targets:[4],data: "posted_by" },
                    {
                        targets:[5],data: "attachment",
                        render: function (data, type, full, meta){

                            return '<center>'+ data +' <i class="fa fa-paperclip"></i></classenter>';
                        }

                    },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_order_id);

                            var btn_approved='<button class="btn btn-primary btn-sm" name="checked_po"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Mark this PO as reviewed"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';
                            var btn_conversation='<a id="link_conversation" href="Po_messages?id='+full.purchase_order_id+'" target="_blank" class="btn btn-info btn-sm"  style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Open Conversation"><i class="fa fa-envelope"></i> </a>';

                            return '<center>'+btn_approved+'&nbsp;'+btn_conversation+'</center>';
                        }
                    }
                ]
            });
            dtvoucher=$('#tbl_vouchers_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Cash_vouchers/transaction/list-for-approval",
                "language": {
                  "searchPlaceholder":"Search "
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
                    { targets:[3],data: "particular" },
                    { targets:[4],data: "payment_method" },
                    { targets:[5],data: "remarks" ,render: $.fn.dataTable.render.ellipsis(60)},

                    { visible:false,
                        targets:[6],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_order_id);

                            var btn_approved='<button class="btn btn-primary btn-sm" name="approve_voucher"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve and Post in Cash Disbursement"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';
                            return '<center>'+btn_approved;
                        }
                    }
                ]
            });
             $('div.dataTables_filter input').addClass('dash_search_field');
        })();


        var bindEventHandlers=(function(){


            var detailRows = [];

           
            $('#tbl_po_list tbody').on( 'click', 'tr td.details-control', function () {
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
                        "url":"Templates/layout/po/"+ d.purchase_order_id+'?type=approval',
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

            $('#tbl_po_list_review tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtreview.row( tr );
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
                        "url":"Templates/layout/po/"+ d.purchase_order_id+'?type=reviewed',
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

            $('#tbl_po_list_checking tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtchecking.row( tr );
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
                        "url":"Templates/layout/po/"+ d.purchase_order_id+'?type=checking',
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


            $('#tbl_vouchers_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtvoucher.row( tr );
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
                        "url":"Templates/layout/journal-cdj-voucher?id="+ d.cv_id+"&type=review",
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
            //*****************************************************************************************
            $('#tbl_po_list > tbody').on('click','button[name="approve_po"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt.row(_selectRowObj).data();
                _selectedID=data.purchase_order_id;
                $('#modal_confirmation_approval').modal('show');
                $('#approval_po_no').text(data.po_no);
                $('#approval_remarks').val('');

            });

              $('#btn_yes_approval').click(function(){
                 approvePurchaseOrder().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).remove().draw();
                        $('#modal_confirmation_approval').modal('hide');
                    }

                });
              });

            $('#tbl_po_list > tbody').on('click','button[name="disapprove_po"]',function(){
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.purchase_order_id;
                $('#modal_confirmation').modal('show');
                $('#disapproved_po_no').text(data.po_no);
                $('#disapproval_remarks').val('');

            });

              $('#btn_yes_disapprove').click(function(){
                 disapprovePurchaseOrder().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).remove().draw();
                        $('#modal_confirmation').modal('hide');
                    }
                });
              });

            $('#tbl_po_list_review > tbody').on('click','button[name="reviewed_po"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected
                var data=dtreview.row(_selectRowObj).data();
                _selectedIDreviewed=data.purchase_order_id;
                $('#modal_confirmation_review').modal('show');
                $('#review_po_no').text(data.po_no);
                $('#review_remarks').val('');

            });       

              $('#btn_yes_review').click(function(){
                 reviewPurchaseOrder().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dtreview.row(_selectRowObj).remove().draw();
                        dtchecking.row.add(response.data).draw();
                        $('#modal_confirmation_review').modal('hide');
                    }

                });
              });

            $('#tbl_po_list_checking > tbody').on('click','button[name="checked_po"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected
                var data=dtchecking.row(_selectRowObj).data();
                _selectedIDchecked=data.purchase_order_id;
                $('#modal_confirmation_check').modal('show');
                $('#check_po_no').text(data.po_no);
                $('#checking_remarks').val('');

            });           

              $('#btn_yes_check').click(function(){
                 checkPurchaseOrder().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dtchecking.row(_selectRowObj).remove().draw();
                        dt.row.add(response.data).draw();
                        $('#modal_confirmation_check').modal('hide');
                    }

                });
              });                   

            //****************************************************************************************
            $('#tbl_po_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_po"]').click();
                showSpinningProgress($(this));
            });

            $('#tbl_po_list_review > tbody').on('click','button[name="mark_as_reviewed"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="reviewed_po"]').click();
                showSpinningProgress($(this));
            });

            $('#tbl_po_list_checking > tbody').on('click','button[name="mark_as_checked"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="checked_po"]').click();
                showSpinningProgress($(this));
            });            

            $('#tbl_vouchers_list > tbody').on('click','button[name="mark_as_approved_voucher"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                var data=dtvoucher.row(_selectRowObj).data();
                _selectedIDvoucher = data.cv_id;
                // alert(_selectedIDvoucher);
                console.log(data);
                btn = $(this);
                showSpinningProgress($(this));
                $('button[name="mark_as_cancelled_voucher"]').addClass('disabled');
                $('button[name="mark_as_approved_voucher"]').addClass('disabled');

                 approveVoucher().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                      setTimeout(function(){  showSpinningProgress(btn); 
                        btn.closest('div').find('.closing_title').removeClass('hidden');
                        btn.closest('div').find('button[name="mark_as_approved_voucher"]').addClass('hidden');
                        btn.closest('div').find('button[name="mark_as_cancelled_voucher"]').addClass('hidden');
                      }, 1000);
                      setTimeout(function(){ dtvoucher.row(_selectRowObj).remove().draw(); }, 4000);
                    }

                });

            });

            $('#tbl_vouchers_list > tbody').on('click','button[name="mark_as_cancelled_voucher"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                var data=dtvoucher.row(_selectRowObj).data();
                _selectedIDvoucher = data.cv_id;
                // alert(_selectedIDvoucher);
                console.log(data);
                btn = $(this);
                showSpinningProgress($(this));
                $('button[name="mark_as_cancelled_voucher"]').addClass('disabled');
                $('button[name="mark_as_approved_voucher"]').addClass('disabled');

                 disapproveVoucher().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                      setTimeout(function(){  showSpinningProgress(btn); 
                        btn.closest('div').find('.closing_title').removeClass('hidden');
                        btn.closest('div').find('button[name="mark_as_approved_voucher"]').addClass('hidden');
                        btn.closest('div').find('button[name="mark_as_cancelled_voucher"]').addClass('hidden');
                      }, 1000);
                      setTimeout(function(){ dtvoucher.row(_selectRowObj).remove().draw(); }, 4000);
                    }

                });

            });


            //****************************************************************************************
            $('#tbl_po_list > tbody').on('click','button[name="external_link_conversation"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('#link_conversation').trigger("click");
                //alert(_selectRowObj.find('a[id="link_conversation"]').length);
            });

            $("#search_tbl_po_list_review").keyup(function(){         
                dtreview
                    .search(this.value)
                    .draw();
            });

            $("#search_tbl_po_list_checking").keyup(function(){         
                dtchecking
                    .search(this.value)
                    .draw();
            });
            $("#search_tbl_po_list").keyup(function(){         
                dt
                    .search(this.value)
                    .draw();
            });

            $("#search_tbl_vouchers_list").keyup(function(){         
                dtvoucher
                    .search(this.value)
                    .draw();
            });


        })();






        //functions called on bindEventHandlers
        var approvePurchaseOrder=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchases/transaction/mark-approved",
                "data":{purchase_order_id : _selectedID, approval_remarks : $('#approval_remarks').val()}

            });
        };

        var disapprovePurchaseOrder=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchases/transaction/mark-disapproved",
                "data":{purchase_order_id : _selectedID, disapproval_remarks : $('#disapproval_remarks').val()}

            });
        };

        var reviewPurchaseOrder=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchases/transaction/mark-reviewed",
                "data":{purchase_order_id : _selectedIDreviewed, review_remarks : $('#review_remarks').val()}

            });
        };


        var checkPurchaseOrder=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchases/transaction/mark-checked",
                "data":{purchase_order_id : _selectedIDchecked, checking_remarks : $('#checking_remarks').val()}

            });
        };        

        var approveVoucher=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_Disbursement/transaction/post-voucher",
                "data":{cv_id : _selectedIDvoucher}

            });
        };

        var disapproveVoucher=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_Disbursement/transaction/cancel-voucher",
                "data":{cv_id : _selectedIDvoucher}

            });
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



    });


</script>



</body>

</html>