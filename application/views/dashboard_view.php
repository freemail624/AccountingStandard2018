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

        #tbl_pr_pending_list {
/*            color: white!important;
            border: none!important;*/
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
      table, table.table-striped{
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
                                                  <h4 class="welcome-msg" style=""><?php echo $company_info[0]->company_address; ?></h4>
                                                  <h4 class="welcome-msg" style=""><?php echo $company_info[0]->company_address_2; ?></h4><br>
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
                                                    <div class="col-xs-12 <?php echo (in_array('2-11',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >PURCHASE REQUEST (FORMS) PENDING</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE REQUEST (FORMS) PENDING</span></h3>
                                                            <table id="tbl_prf_pending_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PRF #</th>
                                                                    <th>Department</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>

                                                </div>

                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('2-12',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >PURCHASE REQUEST (FORMS) FOR FINAL APPROVAL</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE REQUEST (FORMS) FOR FINAL APPROVAL</span></h3>
                                                            <table id="tbl_prf_final_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PRF #</th>
                                                                    <th>Department</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>

                                                </div>

                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('7-1',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >PURCHASE REQUEST PENDING</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE REQUEST PENDING</span></h3>
                                                            <table id="tbl_pr_pending_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PR #</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('2-13',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >PURCHASE REQUEST FOR FINAL APPROVAL</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >PURCHASE REQUEST FOR FINAL APPROVAL</span></h3>
                                                            <table id="tbl_pr_final_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>PR #</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>
                                                </div>


                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('3-9',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >SALES ORDER PENDING</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >SALES ORDER PENDING</span></h3>
                                                            <table id="tbl_so_pending_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>SO #</th>
                                                                    <th>Order Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>

                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('3-10',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >SALES ORDER FOR FINAL APPROVAL</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >SALES ORDER FOR FINAL APPROVAL</span></h3>
                                                            <table id="tbl_so_final_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>SO #</th>
                                                                    <th>Order Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>

                                                </div>


                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('15-9',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >ITEM ADJUSTMENT PENDING</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >ITEM ADJUSTMENT PENDING</span></h3>
                                                            <table id="tbl_ai_pending_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>ADJ #</th>
                                                                    <th>Date</th>
                                                                    <th>Transaction Type</th>
                                                                    <th>Invoice #</th>
                                                                    <th>Posted by </th>
                                                                    <th style="width: 15%!important;"><center>Action</center></th>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-xs-12 <?php echo (in_array('15-10',$this->session->user_rights)?'':'hidden'); ?>">
                                                      <div class="data-container table-responsive" style="padding: 20px 15px 20px 15px;">
                                                            <h6 class="visible-xs hidden-sm hidden-md hidden-lg " style="position: absolute; top: 5px;background-color: white;"><i class="fa fa-file-text-o"></i> <span >ITEM ADJUSTMENT FOR FINAL APPROVAL</span></h6>
                                                            <h3 class="hidden-xs " style="position: absolute; top: 5px; background-color: white;"><i class="fa fa-file-text-o"  style="color: #067cb2;"></i> <span >ITEM ADJUSTMENT FOR FINAL APPROVAL</span></h3>
                                                            <table id="tbl_ai_final_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <th></th>
                                                                    <th>ADJ #</th>
                                                                    <th>Date</th>
                                                                    <th>Transaction Type</th>
                                                                    <th>Invoice #</th>
                                                                    <th>Posted by </th>
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
                    </div> <!-- #page-content -->
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
        var dt; var dt_so_pending; var dt_ai_pending; var dt_prf_pending;
        var dt_prf_final; var dt_pr_final; var dt_so_final; var dt_ai_final;
        var _selectedID; var _selectRowObj;

        var initializeControls=(function(){

            dt_prf_pending=$('#tbl_prf_pending_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchase_request_form/transaction/prf-pending",
                "language": {
                  "searchPlaceholder":"Search Purchase Request (Form)"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "prf_no" },
                    { targets:[2],data: "department_name" },
                    { targets:[3],data: "posted_by" },
                    {
                        targets:[4],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_pending_prf"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this PRF"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt_prf_final=$('#tbl_prf_final_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchase_request_form/transaction/prf-for-final-approval",
                "language": {
                  "searchPlaceholder":"Search Purchase Request (Form)"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "prf_no" },
                    { targets:[2],data: "department_name" },
                    { targets:[3],data: "posted_by" },
                    {
                        targets:[4],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_final_prf"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this PRF"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt=$('#tbl_pr_pending_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchase_request/transaction/pr-pending",
                "language": {
                  "searchPlaceholder":"Search Purchase Request"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "pr_no" },
                    { targets:[2],data: "posted_by" },
                    {
                        targets:[3],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_pr"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this PR"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt_pr_final=$('#tbl_pr_final_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Purchase_request/transaction/pr-for-final-approval",
                "language": {
                  "searchPlaceholder":"Search Purchase Request"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "pr_no" },
                    { targets:[2],data: "posted_by" },
                    {
                        targets:[3],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_pr"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this PR"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt_so_pending=$('#tbl_so_pending_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Sales_order/transaction/so-pending",
                "language": {
                  "searchPlaceholder":"Search Order"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "so_no" },
                    { targets:[2],data: "date_order" },
                    { targets:[3],data: "customer_name" },
                    { targets:[4],data: "posted_by" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_so"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this Sales Order"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt_so_final=$('#tbl_so_final_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Sales_order/transaction/so-for-final-approval",
                "language": {
                  "searchPlaceholder":"Search Order"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "so_no" },
                    { targets:[2],data: "date_order" },
                    { targets:[3],data: "customer_name" },
                    { targets:[4],data: "posted_by" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_so"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this Sales Order"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt_ai_pending=$('#tbl_ai_pending_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Adjustments/transaction/ai-pending",
                "language": {
                  "searchPlaceholder":"Search Adjustment"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "adjustment_code" },
                    { targets:[2],data: "date_adjusted" },
                    { targets:[3],data: "transaction_type" },
                    { targets:[4],data: "inv_no" },
                    { targets:[5],data: "posted_by" },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_ai"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this adjustment"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

            dt_ai_final=$('#tbl_ai_final_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Adjustments/transaction/ai-for-final-approval",
                "language": {
                  "searchPlaceholder":"Search Adjustment"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "adjustment_code" },
                    { targets:[2],data: "date_adjusted" },
                    { targets:[3],data: "transaction_type" },
                    { targets:[4],data: "inv_no" },
                    { targets:[5],data: "posted_by" },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            //alert(full.purchase_request_id);

                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_ai"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approve this adjustment"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    }
                ]
            });

             $('div.dataTables_filter input').addClass('dash_search_field');
        })();


        var bindEventHandlers=(function(){


            var detailRows = [];


            $('#tbl_prf_final_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_prf_final.row( tr );
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
                        "url":"Templates/layout/prf/"+ d.purchase_request_form_id+'?type=approval',
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

            $('#tbl_prf_pending_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_prf_pending.row( tr );
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
                        "url":"Templates/layout/prf/"+ d.purchase_request_form_id+'?type=approval',
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


            $('#tbl_pr_pending_list tbody').on( 'click', 'tr td.details-control', function () {
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
                        "url":"Templates/layout/pr/"+ d.purchase_request_id+'?type=approval',
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

            $('#tbl_pr_final_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_pr_final.row( tr );
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
                        "url":"Templates/layout/pr/"+ d.purchase_request_id+'?type=approval',
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

            $('#tbl_so_pending_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_so_pending.row( tr );
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
                        "url":"Templates/layout/sales-order/"+ d.sales_order_id+'?type=approval',
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

            $('#tbl_so_final_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_so_final.row( tr );
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
                        "url":"Templates/layout/sales-order/"+ d.sales_order_id+'?type=approval',
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


            $('#tbl_ai_pending_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_ai_pending.row( tr );
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
                        "url":"Templates/layout/adjustments/"+ d.adjustment_id+'?type=approval',
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

            $('#tbl_ai_final_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt_ai_final.row( tr );
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
                        "url":"Templates/layout/adjustments/"+ d.adjustment_id+'?type=approval',
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

            //*****************************************************************************************
            $('#tbl_prf_pending_list > tbody').on('click','button[name="approve_pending_prf"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_prf_pending.row(_selectRowObj).data();
                _selectedID=data.purchase_request_form_id;

                 approvePurchaseRequestFormPending().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_prf_pending.row(_selectRowObj).remove().draw();
                        dt_prf_final.ajax.reload( null, false );
                    }

                });
            });

            $('#tbl_prf_pending_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_pending_prf"]').click();
                showSpinningProgress($(this));
            });


            //*****************************************************************************************
            $('#tbl_prf_final_list > tbody').on('click','button[name="approve_final_prf"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_prf_final.row(_selectRowObj).data();
                _selectedID=data.purchase_request_form_id;

                 approvePurchaseRequestFormFinal().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_prf_final.row(_selectRowObj).remove().draw();
                    }

                });
            });

            $('#tbl_prf_final_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_final_prf"]').click();
                showSpinningProgress($(this));
            });


            //*****************************************************************************************
            $('#tbl_pr_pending_list > tbody').on('click','button[name="approve_pr"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt.row(_selectRowObj).data();
                _selectedID=data.purchase_request_id;

                 approvePurchaseRequestPending().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).remove().draw();
                        dt_pr_final.ajax.reload( null, false );
                    }

                });
            });

            $('#tbl_pr_pending_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_pr"]').click();
                showSpinningProgress($(this));
            });



            //*****************************************************************************************
            $('#tbl_pr_final_list > tbody').on('click','button[name="approve_pr"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_pr_final.row(_selectRowObj).data();
                _selectedID=data.purchase_request_id;

                 approvePurchaseRequestFinal().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_pr_final.row(_selectRowObj).remove().draw();
                    }

                });
            });

            $('#tbl_pr_final_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_pr"]').click();
                showSpinningProgress($(this));
            });


            //*****************************************************************************************
            $('#tbl_so_pending_list > tbody').on('click','button[name="approve_so"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_so_pending.row(_selectRowObj).data();
                _selectedID=data.sales_order_id;

                 approveSalesOrderPending().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_so_pending.row(_selectRowObj).remove().draw();
                        dt_so_final.ajax.reload( null, false );
                    }

                });
            });

            $('#tbl_so_pending_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_so"]').click();
                showSpinningProgress($(this));
            });


            //*****************************************************************************************
            $('#tbl_so_final_list > tbody').on('click','button[name="approve_so"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_so_final.row(_selectRowObj).data();
                _selectedID=data.sales_order_id;

                 approveSalesOrderFinal().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_so_final.row(_selectRowObj).remove().draw();
                    }

                });
            });

            $('#tbl_so_final_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_so"]').click();
                showSpinningProgress($(this));
            });            


            //*****************************************************************************************
            $('#tbl_ai_pending_list > tbody').on('click','button[name="approve_ai"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_ai_pending.row(_selectRowObj).data();
                _selectedID=data.adjustment_id;

                 approveItemAdjustmentPending().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_ai_pending.row(_selectRowObj).remove().draw();
                        dt_ai_final.ajax.reload( null, false );
                    }

                });
            });

            $('#tbl_ai_pending_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_ai"]').click();
                showSpinningProgress($(this));
            });


            //*****************************************************************************************
            $('#tbl_ai_final_list > tbody').on('click','button[name="approve_ai"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dt_ai_final.row(_selectRowObj).data();
                _selectedID=data.adjustment_id;

                 approveItemAdjustmentFinal().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt_ai_final.row(_selectRowObj).remove().draw();
                    }

                });
            });

            $('#tbl_ai_final_list > tbody').on('click','button[name="mark_as_approved"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('button[name="approve_ai"]').click();
                showSpinningProgress($(this));
            });


            //****************************************************************************************
            $('#tbl_pr_pending_list > tbody').on('click','button[name="external_link_conversation"]',function(){
                _selectRowObj=$(this).parents('tr').prev();
                _selectRowObj.find('#link_conversation').trigger("click");
                //alert(_selectRowObj.find('a[id="link_conversation"]').length);
            });




        })();


        //functions called on bindEventHandlers
        var approvePurchaseRequestFormPending=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchase_request_form/transaction/mark-pending-approved",
                "data":{purchase_request_form_id : _selectedID}

            });
        };
        var approvePurchaseRequestFormFinal=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchase_request_form/transaction/mark-final-approved",
                "data":{purchase_request_form_id : _selectedID}

            });
        };        

        var approvePurchaseRequestPending=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchase_request/transaction/mark-pending-approved",
                "data":{purchase_request_id : _selectedID}

            });
        };

        var approvePurchaseRequestFinal=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchase_request/transaction/mark-final-approved",
                "data":{purchase_request_id : _selectedID}

            });
        };


        var approveSalesOrderPending=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Sales_order/transaction/mark-pending-approved",
                "data":{sales_order_id : _selectedID}

            });
        };

        var approveSalesOrderFinal=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Sales_order/transaction/mark-final-approved",
                "data":{sales_order_id : _selectedID}

            });
        };

        var approveItemAdjustmentPending=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Adjustments/transaction/mark-pending-approved",
                "data":{adjustment_id : _selectedID}

            });
        };

        var approveItemAdjustmentFinal=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Adjustments/transaction/mark-final-approved",
                "data":{adjustment_id : _selectedID}

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