<!DOCTYPE html>

<html lang="en">

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
    <style>

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
/*
        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
            color: white;
            font-weight: bolder;
            background: rgba(255, 152, 0, .1);
            border-bottom: none;
        }

        .nav-tabs > li > a {
            border: 1px solid white;
            border-top-width: 1px;
            border-radius: 0;
            color: white;
        }

        .nav-tabs > li > a:hover {
            border: 1px solid white;
            border-top: 1px solid #2196f3; 
            background: transparent;
        }*/

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

        .select2-container--default .select2-selection--single {
            height: 32px;
        }

        input[type='radio']:hover {
            cursor: pointer;
        }

        input[type='radio']:after {
            width: 15px;
            height: 15px;
            border-radius: 15px;
            top: -2px;
            left: -1px;
            position: relative;
            background-color: #404040;
            content: '';
            display: inline-block;
            visibility: visible;
            border: 2px solid white;
        }

        input[type='radio']:checked:after {
            width: 15px;
            height: 15px;
            border-radius: 15px;
            top: -2px;
            left: -1px;
            position: relative;
            background-color: #ff9800;
            content: '';
            display: inline-block;
            visibility: visible;
            border: 2px solid white;
        }

        td.details-control {
            background: url('assets/img/print.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }
        .numeric{
            text-align: right;
        }
        .disable-select {
            user-select: none; /* supported by Chrome and Opera */
           -webkit-user-select: none; /* Safari */
           -khtml-user-select: none; /* Konqueror HTML */
           -moz-user-select: none; /* Firefox */
           -ms-user-select: none; /* Internet Explorer/Edge */
        }
    </style>
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Bank_reconciliation">Bank Reconciliation</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                               <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Bank Reconciliation</b> 
                            </div> -->
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Bank Reconciliation</h2><hr>
                                <div class="row">
                                    <div class="container-fluid">
                                        <ul class="nav nav-tabs">
                                          <li class="text-center active"><a data-toggle="tab" href="#outstanding"><b>Step 1:</b> Outstanding Check</a></li>

                                          <li id="btn_step_2">
                                              <a data-toggle="tab" href="#bank_statement_tab"><b>Step 2:</b> Bank Statement</a>
                                          </li>

                                          <li id="btn_step_3" class="text-center"><a data-toggle="tab" href="#bank_reconciliation_tab"><b>Step 3:</b> Bank Reconciliation</a></li>
                                        </ul>
                                        <div class="tab-content" style="background: transparent!important;">
                                          <div id="outstanding" class="tab-pane fade in active">
                                            <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <div class="col-xs-12 col-sm-4">
                                                        <strong>* Account:</strong><br>
                                                            <select id="cbo_accounts" class="form-control" name="account_id" data-error-msg="Please Select Account to reconcile." required style="width: 100%!important;">
                                                                <?php foreach($account_titles as $account_title) { ?>
                                                                    <option value="<?php echo $account_title->account_id; ?>"><?php echo $account_title->account_title; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4">
                                                            <strong>* Start Date</strong><br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input id="startDate" type="text" class="date-picker form-control" name="start_date" data-error-msg="Start Date is required" value="<?php echo date('m/d/Y'); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4">
                                                            <strong>* End Date</strong><br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input id="endDate" type="text" class="date-picker  form-control" name="end_date" data-error-msg="End Date is required" value="<?php echo date('m/d/Y'); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <div class="container-fluid group-box">
                                                            <span><strong><i class="fa fa-list"></i> ISSUED CHECKS</strong></span><hr>
                                                            <form id="frm_reconcile">
                                                            <table id="tbl_bank_reconciliation" class="table table-striped" width="100%">
                                                                <thead>
                                                                    <th>Check #</th>
                                                                    <th>Txn Date</th>
                                                                    <th>Check Date</th>
                                                                    <th>Particular</th>
                                                                    <th>Book</th>
                                                                    <th>Department</th>
                                                                    <th>Ref #</th>
                                                                    <th align="right">Amount</th>
                                                                    <th width="7%">Outstanding</th>
                                                                    <th width="7%">Good Check / Released</th>
                                                                    <th width="7%">Default</th>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>                                                                
                                                </div>
                                          </div>
                                          <div id="bank_statement_tab" class="tab-pane fade">
                                            <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <label>Month: </label><br/>
                                                        <select class="form-control" name="month_id" id="month_id" style="width: 100%;">
                                                            <?php 
                                                            $active_month = date("m");
                                                                foreach($months as $month){?>
                                                                <option value="<?php echo $month->month_id; ?>" <?php if($month->month_id==$active_month){echo 'selected'; }?>>
                                                                    <?php echo $month->month_name; ?>
                                                                </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Opening Balance: </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-code"></i>
                                                            </span>
                                                            <input type="text" name="opening_balance" id="opening_balance" class="numeric form-control text-right" data-error-msg="Opening balance is required!" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Closing Balance: </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-code"></i>
                                                            </span>
                                                            <input type="text" name="closing_balance" id="closing_balance" class="form-control text-right" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <div class="col-xs-12">
                                                        <div>
                                                        <br/>
                                                            <span style="float: left;"><strong><i class="fa fa-bars"></i> Bank Statement Entries</strong></span>

                                                            <a id="btn_refresh" style="float: right;color: green;" class="disable-select">Refresh <i class="fa fa-refresh"></i> </a>

                                                            <a id="btn_clear" style="float: right;margin-right: 20px;color: red;" class="disable-select">Clear <i class="fa fa-times-circle"></i> </a>
                                                            <br />
                                                            <hr />

                                                            <div style="width: 100%;">
                                                                <table id="tbl_entries" class="table-striped table">
                                                                    <thead class="">
                                                                    <tr>
                                                                        <th width="10%">Date</th>
                                                                        <th width="10%">Value Date</th>
                                                                        <th width="10%">Cheque No.</th>
                                                                        <th width="15%" style="text-align: right;">Withdrawal Amt. (Dr)</th>
                                                                        <th width="15%" style="text-align: right;">Deposit (Cr)</th>
                                                                        <th width="15%" style="text-align: right;">Balance</th>
                                                                        <th width="15%">Narrative</th>
                                                                        <th width="10%">Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                    <td>
                                                                        <input type="text" name="general_ledger_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="value_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="cheque_no[]" class="form-control">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="dr_amount[]" class="form-control numeric">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="cr_amount[]" class="form-control numeric">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="balance_amount[]" class="form-control numeric" readonly>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" name="memo[]" class="form-control">
                                                                    </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                                            <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
<!--                                                                     <tfoot>
                                                                    <tr>
                                                                        <td colspan="2" align="right"><strong>Total</strong></td>
                                                                        <td align="right"><strong>0.00</strong></td>
                                                                        <td align="right"><strong>0.00</strong></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    </tfoot> -->
                                                                </table>

                                                                <table id="table_hidden" class="hidden">
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="general_ledger_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="value_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="cheque_no[]" class="form-control">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="dr_amount[]" class="form-control numeric">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="cr_amount[]" class="form-control numeric">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="balance_amount[]" class="form-control numeric" readonly>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" name="memo[]" class="form-control">
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
                                          <div id="bank_reconciliation_tab" class="tab-pane fade">
                                            <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="container-fluid group-box" style="padding: 15px 15px 0 15px;">
                                                                <b><span class="fa fa-bars"></span> JOURNAL</b><hr>
                                                                <strong>ACCOUNT TO RECONCILE</strong>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                            <input type="text" class="form-control" name="account_to_reconcile" disabled>
<!--                                                                         <select id="cbo_accounts" class="form-control" name="account_id" data-error-msg="Please Select Account to reconcile." required style="width: 100%!important;">
                                                                            <?php foreach($account_titles as $account_title) { ?>
                                                                                <option value="<?php echo $account_title->account_id; ?>"><?php echo $account_title->account_title; ?></option>
                                                                            <?php } ?>
                                                                        </select> -->
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="account_balance" value="0" disabled>
                                                                    </div>
                                                                </div><hr>
                                                                <h5><b>DEDUCT :</b></h5>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>BANK SERVICE CHARGE</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="bank_service_charge" value="0">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>NSF CHECKS</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="nsf_check" value="0" >
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>CHECK PRINTING CHARGE</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="check_printing_charge" value="0" >
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>OTHER DEDUCTIONS</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="journal_other_deductions" value="0" >
                                                                    </div>
                                                                </div><hr>
                                                                <h5><b>ADD :</b></h5>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>INTEREST EARNED</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="interest_earned" value="0" >
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>NOTES RECEIVABLE COLLECTED (BY BANK)</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="notes_receivable" value="0" >
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>OTHER ADDITIONS</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="journal_other_additions" value="0" >
                                                                    </div>
                                                                </div><hr>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>ADJUSTED COLLECTED BALANCE</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="adjusted_collected_balance_journal" value="0" disabled>
                                                                    </div>
                                                                </div><br>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="container-fluid group-box" style="padding: 15px 15px 0 15px;">
                                                                <b><span class="fa fa-bars"></span> BANK STATEMENT</b><hr>
                                                                <strong>CURRENT BANK ACCOUNT</strong>
                                                                <input type="text" class="form-control" name="current_bank_account" disabled>
                                                                <br/>
                                                                <strong>ACTUAL BALANCE</strong>
                                                                <input type="text" class="form-control text-right numeric" name="actual_balance" value="0" readonly><hr>
                                                                <h5><b>DEDUCT :</b></h5>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>OUTSTANDING CHECKS</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="outstanding_checks" value="0" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>OTHER DEDUCTIONS</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="bank_other_deductions" value="0">
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <h5><b>ADD :</b></h5>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>DEPOSIT IN TRANSIT</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="deposit_in_transit" value="0">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>OTHER ADDITIONS</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="bank_other_additions" value="0">
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <br><br/>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <label>ADJUSTED COLLECTED BALANCE</label>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control text-right numeric" name="adjusted_collected_balance_bank" value="0" disabled>
                                                                    </div>
                                                                </div><br>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <button id="btn_process" class="btn btn-primary" style="min-width: 100px; margin-left: 30px;"><i class="fa fa-check"></i> Process</button> 
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Reconciliation History</b> 
                            </div> -->
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Reconciliation History</h2><hr>
                                <table id="tbl_history" class="table table-striped" width="100%">
                                    <thead>
                                        <th></th>
                                        <th>Date Reconciled</th>
                                        <th>Account Title</th>
                                        <th>Reconciled by</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->

                </div> <!-- #page-content -->
            </div>
            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT Business Solutions</h6></li>
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

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>

$(document).ready(function(){
    var dt; var dtHistory;  var _cboAccounts;
    var _checkNo; var dtBankReconData; var _cboMonths;
    var load_status=0;

    var oTBJournal={
        "dr" : "td:eq(3)",
        "cr" : "td:eq(4)",
        "bal" : "td:eq(5)"
    };

    var initializeControls=function(){
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        _cboAccounts=$('#cbo_accounts').select2({
            allowClear: true,
            placeholder: 'Please Select Account'
        });

        _cboMonths=$('#month_id').select2({
            placeholder: 'Please Select Month'
        });

        var data = _cboAccounts.select2('data');
        $('input[name="current_bank_account"]').val(data[0].text);
        $('input[name="current_bank_account"]').val('');
        
        _cboAccounts.select2('val',null);

        reinitializeHistory();
        reinitializeDataTable();
        reInitializeNumeric();

    }();

    function reinitializeHistory() {
        dtHistory=$('#tbl_history').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "language":{
                "searchPlaceholder":"Search History"
            },
            "ajax":{
                "url":"Bank_reconciliation/transaction/get-history",
                "type":"GET",
                "bDestroy":true
            },
            "columns":[
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { 
                    searchable: true,
                    targets:[1],data: "date_reconciled" 
                },
                { 
                    searchable: false,
                    targets:[2],data: "account_title" 
                },
                { 
                    searchable: true,
                    targets:[3],data: "fullname" 
                }
            ]
        });
    };

    function reinitializeDataTable(){
        dt=$('#tbl_bank_reconciliation').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "language":{
                "searchPlaceholder":"Search Checks"
            },            
            "ajax":{
                "url":"Bank_reconciliation/transaction/list",
                "type":"GET",
                "bDestroy":true,
                "data": function (d) {
                    return $.extend({}, d, {
                        "sDate":$('#startDate').val(),
                        "eDate":$('#endDate').val(),
                        "accountid": _cboAccounts.select2('val')

                    });
                }
            },
            "columns":[
                { targets:[0],data: "check_no" },
                { 
                    searchable: false,
                    targets:[1],data: "date_txn" 
                },
                { 
                    searchable: false,
                    targets:[2],data: "check_date" 
                },
                { 
                    searchable: false,
                    targets:[3],data: "particular" 
                },
                { 
                    searchable: false,
                    targets:[4],data: "book_type" 
                },
                { 
                    searchable: false,
                    targets:[5],data: "department_name" 
                },
                { 
                    searchable: false,
                    class: 'ref_no',
                    targets:[6],data: "txn_no"
                },
                { 
                    searchable: false,
                    class: "text-right",
                    targets:[7],data: "amount",
                    render: function(data,type,full,meta) {
                        return accounting.formatNumber(data,2);
                    }
                },
                { 
                    class: "text-center",
                    targets:[8], 
                    render: function(data,type,full,meta) {
                        return '<input id="outstanding_'+full.check_no+'" type="radio" name="outstanding_'+ full.check_no +'[]" class="outstanding status" value="1" data-amount="' + full.amount + '"/>'
                    }
                },
                { 
                    class: "text-center",
                    targets:[9],
                    render: function(data,type,full,meta) {
                        return '<input id="good_check_'+full.check_no+'" type="radio" name="outstanding_'+ full.check_no +'[]" class="good-check status" value="2" />'
                    }
                },
                { 
                    class: "text-center hidden",
                    targets:[10],
                    render: function(data,type,full,meta) {
                        return '<input id="default_'+full.check_no+'" type="radio" name="outstanding_'+ full.check_no +'[]" class="default status" value="0" checked/>'
                    }
                }
            ]
        });
    };

    var bindEventHandlers=function(){
        _cboAccounts.on('change', function(){
            var data = _cboAccounts.select2('data');
            $('input[name="current_bank_account"]').val(data[0].text);
            $('input[name="account_to_reconcile"]').val(data[0].text);

            $.ajax({
                "dataType":"json",
                "type":"GET",
                "url":"Bank_reconciliation/transaction/get-account-balance?account_id="+_cboAccounts.select2('val')
            }).done(function(response){
                $('input[name="account_balance"]').val(response.data);


                reComputeTotal();
            });

        });

        var reInitializeDate = function(){

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        };

        $('.numeric').on('keyup',function(){
            reComputeTotal();
            reInitializeNumeric();
        });

        $('#tbl_entries').on('click','button.add_account',function(){
            var row=$('#table_hidden').find('tr');
            row.clone().insertBefore($(this).closest('tr'));
            reInitializeNumeric();
            reInitializeDate();
        });

        $('#tbl_entries').on('click','button.remove_account',function(){
            var oRow=$('#tbl_entries > tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
                recomputeStatement();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }
            // reComputeTotals($('#tbl_entries'));
        });

        $('#opening_balance').on("keyup", function(){

            var opening_balance_amt = $(this).val();
            $('#closing_balance').val(accounting.formatNumber(opening_balance_amt,2));

        });

        var recomputeStatement = function(){

            var count = $('#tbl_entries > tbody').find('tr');
            var opening_balance = accounting.unformat($('#opening_balance').val());

            $(count.get().reverse()).each(function(index, value){
                var bal = 0;
                var cr = accounting.unformat($(this).find(oTBJournal.cr).find('input.numeric').val());
                var dr = accounting.unformat($(this).find(oTBJournal.dr).find('input.numeric').val());
                
                if (index == 0){

                    if(dr > cr){
                        bal = opening_balance - dr;
                    }else{
                        bal = opening_balance + cr;
                    }

                }else{

                var prev = $(this).next();
                var row_bal = accounting.unformat(prev.find(oTBJournal.bal).find('input.numeric').val());

                    if(dr > cr){
                        bal = row_bal - dr;
                    }else{
                        bal = row_bal + cr;
                    }

                }


                if(dr <= 0){ $(this).find(oTBJournal.dr).find('input.numeric').val(accounting.formatNumber(0,2)) }

                if(cr <= 0){ $(this).find(oTBJournal.cr).find('input.numeric').val(accounting.formatNumber(0,2)) }

                $(this).find(oTBJournal.bal).find('input.numeric').val(accounting.formatNumber(bal,2));

            }); 

            var closing_balance = $('#tbl_entries > tbody > tr:first').find(oTBJournal.bal).find('input.numeric').val();

            $('#closing_balance').val(accounting.formatNumber(closing_balance,2));
            // $('input[name="actual_balance"]').val(accounting.formatNumber(closing_balance,2));

        };

        var clearStatement = function(){
            $('#opening_balance').val(accounting.formatNumber(0,2));
            $('#tbl_entries > tbody').html("");
            

            $.ajax({
                url: 'Bank_reconciliation/transaction/get-statement-entries',
                type: "GET",
                cache: false,
                dataType: 'html',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                }
            }).done(function(response){
                $('#tbl_entries > tbody').html(response);
                reInitializeNumeric();
                reInitializeDate();
            });

            recomputeStatement();
        };


        $('#btn_refresh').on('click', function(){
            recomputeStatement();
        });

        $('#btn_clear').on('click', function(){
            clearStatement();
            get_prev_statement();
        });        

        var _oTblEntries=$('#tbl_entries > tbody');

        _oTblEntries.on('change','input.numeric',function(){
            var _oRow=$(this).closest('tr');
            var opening_balance = accounting.unformat($('#opening_balance').val());

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{

                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }   

            if (opening_balance == 0 || "" || null){
                showNotification({title: 'Error!', msg: 'Opening Balance is required!', stat: 'error'});
                
                _oRow.find(oTBJournal.dr).find('input.numeric').val('');
                _oRow.find(oTBJournal.cr).find('input.numeric').val('');

                return false;

            }else{
                recomputeStatement();    
            }


        }); 

        var get_prev_statement = function(){
            prevBankStatement().done(function(response){
                var opening_balance = 0;

                if (response.data.length > 0){
                    var data = response.data[0];
                    opening_balance = data.closing_balance;
                    load_status = 1;
                }

                $('#opening_balance').val(accounting.formatNumber(opening_balance,2));
            });
        };

        $('#btn_step_2').click(function(){

            if (load_status == 0){
                get_prev_statement();
            }
    
        });

        _cboMonths.on('change', function(){
            get_prev_statement();
            clearStatement();
            recomputeStatement();
        });        

        $('#btn_step_3').click(function(){
            var total = 0;

            $(".outstanding:checked").each(function() {
                total += parseFloat($(this).data('amount'));
            });

            $('#tbl_bank_reconciliation tbody tr').each(function() {
                var _selectRowObj=$(this);
                var data=dt.row(_selectRowObj).data();

                if (!$('#outstanding_' + data.check_no).is(':checked') && !$('#good_check_' + data.check_no).is(':checked') && !$('#default_' + data.check_no).is(':checked')) {
                    $('#default_' + data.check_no).prop('checked','checked');
                }
            });

            $('input[name="outstanding_checks"]').val(accounting.formatNumber(total,2));
            $('input[name="actual_balance"]').val(accounting.formatNumber($('#closing_balance').val(),2));

            reComputeTotal();
            reInitializeNumeric();
        });

        $('#startDate').on('change',function(){
            dt.destroy();
            reinitializeDataTable();
        });

        $('#cbo_accounts').on('change',function(){
            dt.destroy();
            get_prev_statement();
            reinitializeDataTable();
        });

        $('#endDate').on('change',function(){
            dt.destroy();
            reinitializeDataTable();
        });

        $('#btn_process').click(function(){
            if(validateRequiredFields()){
                reconcileChecks().done(function(response){
                    showNotification(response);
                    clearFields();
                    dt.destroy();
                    dtHistory.destroy();
                    reinitializeDataTable();
                }).always(function(){
                    showSpinningProgress($('#btn_process'));
                })
            }
        });

        $('#tbl_history tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dtHistory.row(tr);
            var d=row.data();
            window.open('Bank_reconciliation/transaction/print-history?id='+ d.bank_recon_id+'&type=contentview');
        } );

    }();

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init', {mDec:2});
        $('.number').autoNumeric('init', {mDec:0});
    };

    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var validateRequiredFields=function(){
        var stat=true;
        var _msg="";

        if ($('input[name="outstanding_checks"]').val() == '0.00') {
            _msg="Outstanding check must not be zero";
            showNotification({title: 'Error!', msg: _msg, stat: 'error'});
            stat=false;
            return false;
        } else if (_cboAccounts.val() == null) {
            _msg="Account to reconcile is required";
            showNotification({title: 'Error!', msg: _msg, stat: 'error'});
            stat=false;
            return false;
        } else if ($('input[name="adjusted_collected_balance_journal"]').val() == 0 && $('input[name="adjusted_collected_balance_bank"]').val() == 0) {
            _msg="Adjusted collection cannot be zero.";
            showNotification({title: 'Error!', msg: _msg, stat: 'error'});
            stat=false;
            return false;
        } else if ($('input[name="adjusted_collected_balance_journal"]').val() != $('input[name="adjusted_collected_balance_bank"]').val()) {
            _msg="Adjusted collection is not balance";
            showNotification({title: 'Error!', msg: _msg, stat: 'error'});
            stat=false;
            return false;
        } else if ($('input[name="actual_balance"]').val() == 0) {
            _msg="Actual balance cannot be zero.";
            showNotification({title: 'Error!', msg: _msg, stat: 'error'});
            stat=false;
            return false;
        } else {
            stat=true;
            return true;
        }

        return stat;
    };



    var reconcileChecks=function(){
        // var _journalId;
        // var _status;
        var _data=[];

        $('.status:checked').each(function(){
            var $this = $(this),
            stat = $this.val();

            _data.push({name: "check_status[]", value: stat });
        });

        dt.rows().eq(0).each( function ( index ) {
            var row = dt.row( index );
            var data = row.data();
            
            _data.push({name: "journal_id[]", value: data.journal_id });
        });

        _data.push({name: "account_id", value: _cboAccounts.select2('val') });
        _data.push({name: "account_balance", value: $('input[name="account_balance"]').val() });
        _data.push({name: "bank_service_charge", value: $('input[name="bank_service_charge"]').val() });
        _data.push({name: "nsf_check", value: $('input[name="nsf_check"]').val() });
        _data.push({name: "check_printing_charge", value: $('input[name="check_printing_charge"]').val() });
        _data.push({name: "interest_earned", value: $('input[name="interest_earned"]').val() });
        _data.push({name: "notes_receivable", value: $('input[name="notes_receivable"]').val() });
        _data.push({name: "journal_other_additions", value: $('input[name="journal_other_additions"]').val() });
        _data.push({name: "journal_other_deductions", value: $('input[name="journal_other_deductions"]').val() });
        _data.push({name: "adjusted_collected_balance_journal", value: $('input[name="adjusted_collected_balance_journal"]').val() });
        _data.push({name: "actual_balance", value: $('input[name="actual_balance"]').val() });
        _data.push({name: "outstanding_checks", value: $('input[name="outstanding_checks"]').val() });
        _data.push({name: "deposit_in_transit", value: $('input[name="deposit_in_transit"]').val() });
        _data.push({name: "bank_other_additions", value: $('input[name="bank_other_additions"]').val() });
        _data.push({name: "bank_other_deductions", value: $('input[name="bank_other_deductions"]').val() });
        _data.push({name: "adjusted_collected_balance_bank", value: $('input[name="adjusted_collected_balance_bank"]').val() });
        
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_reconciliation/transaction/reconcile-check",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_process'))
        });
    };

    var prevBankStatement = function(){
        var _data=$('#').serializeArray();
        _data.push({name: "month_id", value: $('#month_id').val() });
        _data.push({name: "account_id", value: $('#cbo_accounts').val() });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_reconciliation/transaction/get_previous_balance",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_process'))
        });
    };

    var reComputeTotal=function(){
        var _accountBal = accounting.unformat($('input[name="account_balance"]').val());
        var _bankService = accounting.unformat($('input[name="bank_service_charge"]').val());
        var _nsfChecks = accounting.unformat($('input[name="nsf_check"]').val());
        var _checkPrinting = accounting.unformat($('input[name="check_printing_charge"]').val());
        var _interestEarned = accounting.unformat($('input[name="interest_earned"]').val());
        var _notesReceivable = accounting.unformat($('input[name="notes_receivable"]').val());
        var _journalAdditions = accounting.unformat($('input[name="journal_other_additions"]').val());
        var _journalDeductions = accounting.unformat($('input[name="journal_other_deductions"]').val());



        var _actualBalance = accounting.unformat($('input[name="actual_balance"]').val());
        var _outstandingChecks = accounting.unformat($('input[name="outstanding_checks"]').val());
        var _depositInTransit = accounting.unformat($('input[name="deposit_in_transit"]').val());
        var _bankDeductions = accounting.unformat($('input[name="bank_other_deductions"]').val());
        var _bankAdditions = accounting.unformat($('input[name="bank_other_additions"]').val());

        var totalBank = (_actualBalance - _outstandingChecks -_bankDeductions) + _depositInTransit + _bankAdditions;

        var totalJournal = _accountBal - (_bankService + _nsfChecks + _checkPrinting + _journalDeductions) + (_interestEarned + _notesReceivable + _journalAdditions);

        $('input[name="adjusted_collected_balance_journal"]').val(accounting.formatNumber(totalJournal,2));
        $('input[name="adjusted_collected_balance_bank"]').val(accounting.formatNumber(totalBank,2));
    };

    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var clearFields=function(f){
        $('input[type="text"],textarea,select',f).val('0.00');
        $('input[name="current_bank_account"]').val('');
        _cboAccounts.select2('val',null);
        $(f).find('input:first').focus();
    };
});

</script>

</body>

</html>
               