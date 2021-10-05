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

        #tbl_bank_reconciliation_list_filter{
            display: none;
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

                                            <div id="div_bank_reconciliation_list">
                                                <div class="panel panel-default">
                                                    <div class="panel-body table-responsive">
                                                    <h2 class="h2-panel-heading">
                                                        Bank Reconciliation
                                                    </h2><hr>
                                                    <div class="row">
                                                            <div class="col-sm-3"><br>

                                                            <button class="btn btn-primary" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Bank Reconciliation"><i class="fa fa-plus"></i> New Bank Reconciliation</button>

                                                            </div>
                                                            <div class="col-sm-4 col-md-offset-2">
                                                                Account:<br/>
                                                                <select class="form-control" id="tbl_cbo_account_id" style="width: 100%;">
                                                                    <option value="0">All Accounts</option>
                                                                    <?php 
                                                                        foreach($account_titles as $account){?>
                                                                        <option value="<?php echo $account->account_id; ?>">
                                                                            <?php echo $account->account_title; ?>
                                                                        </option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">Search:<br><input type="text" class="form-control" id="searchbox_table" class="searchbox_table"> </div>
                                                            </div><br>

                                                            <table id="tbl_bank_reconciliation_list" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th width="20%">Bank Reconciliation #</th>
                                                                    <th width="20%">Account</th>
                                                                    <th width="20%">Bank Statement Balance</th>
                                                                    <th width="20%">Adjusted Collected Balance</th>
                                                                    <th width="20%"><center>Action</center></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                    </div>
                                                    <!-- <div class="panel-footer"></div> -->
                                                </div>
                                            </div>

                                            <div id="div_bank_reconciliation_fields" style="display: none;">
                                                
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Bank Reconciliation

                            <span style="float: right;">
                                <button type="button" class="btn btn-success" id="btn_save">Save Changes</button>
                                <button type="button" class="btn btn-danger" id="btn_cancel">Cancel</button>
                            </span>

                            </h2>

                            <hr>


                                <div class="row">
                                    <div class="container-fluid">
                                        <ul class="nav nav-tabs">
                                          <li id="btn_step_1" class="text-center active"><a data-toggle="tab" href="#outstanding"><b>Step 1:</b> Outstanding Check</a></li>

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
                                            <form id="frm_bank_statement">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-3">
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
                                                    <div class="col-md-2">
                                                        <label>Year: </label><br/>
                                                        <select class="form-control" name="year" id="year" style="width: 100%;">
                                                            <?php 
                                                            $active_year = date("Y");
                                                            $minyear=$active_year-10; $maxyear=$active_year+10;
                                                                while($minyear!=$maxyear){?>
                                                                <option value="<?php echo $minyear; ?>" <?php if($minyear==$active_year){echo 'selected'; }?>>
                                                                    <?php echo $minyear; ?>
                                                                </option>
                                                            <?php $minyear++;}?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-md-offset-1">
                                                        <label>Opening Balance: </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-code"></i>
                                                            </span>
                                                            <input type="text" name="opening_balance" id="opening_balance" class="numeric form-control text-right" data-error-msg="Opening balance is required!" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
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
                                                                        <th width="10%" class="hidden">Value Date</th>
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
                                                                    <td class="hidden">
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
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <table id="table_hidden" class="hidden">
                                            <tr>
                                                <td>
                                                    <input type="text" name="general_ledger_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                </td>
                                                <td class="hidden">
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
                                                                        <input type="text" class="form-control text-right numeric" name="account_balance" value="0">
                                                                    </div>
                                                                </div><hr>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h5>
                                                                            <b>DEDUCT :</b>
                                                                            <button style="border-radius: 50%;float: right;margin-top: -5px;" class="btn btn-success" id="btn-add-deduct-journal">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button> 
                                                                        </h5>
                                                                    </div>
                                                                </div>
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
                                                                </div>

                                                                <form id="frm_deduction_journal">
                                                                    <div class="row-deduction-journal">
                                                                    </div>
                                                                </form>

                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h5>
                                                                            <b>ADD :</b>
                                                                            <button style="border-radius: 50%;float: right;margin-top: -5px;" class="btn btn-success" id="btn-additional-journal">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button> 
                                                                        </h5>
                                                                    </div>
                                                                </div>

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
                                                                </div>

                                                                <form id="frm_additional_journal">
                                                                    <div class="row-additional-journal">
                                                                    </div>
                                                                </form>

                                                                <hr>
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
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h5>
                                                                            <b>DEDUCT :</b>
                                                                            <button style="border-radius: 50%;float: right;margin-top: -5px;" class="btn btn-success" id="btn-deduction-bank">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button> 
                                                                        </h5>
                                                                    </div>
                                                                </div>
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
                                                                <form id="frm_deduction_bank">
                                                                    <div class="row-deduction-bank">
                                                                    </div>
                                                                </form>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h5>
                                                                            <b>ADD :</b>
                                                                            <button style="border-radius: 50%;float: right;margin-top: -5px;" class="btn btn-success" id="btn-additional-bank">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button> 
                                                                        </h5>
                                                                    </div>
                                                                </div>
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
                                                                <form id="frm_additional_bank">
                                                                    <div class="row-additional-bank">
                                                                    </div>
                                                                </form>
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
 <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content-->
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
        </div><!---content-->
    </div>
</div><!---modal-->

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
    var dt; var dt_bank_reconciliation; var dtHistory;  var _cboAccounts; var _cboAccountTbl;
    var _checkNo; var dtBankReconData; var _cboMonths; var _cboYears; 
    var load_status=0; var _txnMode; var _selectedID=0;;

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

        _cboAccountTbl=$('#tbl_cbo_account_id').select2({
            allowClear: true,
            placeholder: 'Please Select Account',
            allowClear: false
        });

        _cboAccountTbl.select2('val',0);

        _cboMonths=$('#month_id').select2({
            placeholder: 'Please Select Month'
        });

        _cboYears=$('#year').select2({
            placeholder: 'Please Select Year'
        });

        var data = _cboAccounts.select2('data');
        $('input[name="current_bank_account"]').val(data[0].text);
        $('input[name="current_bank_account"]').val('');
        
        _cboAccounts.select2('val',null);

        dt_bank_reconciliation=$('#tbl_bank_reconciliation_list').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : {
                "url":"Bank_reconciliation/transaction/reconciliation-list",
                "bDestroy": true,            
                "data": function ( d ) {
                    return $.extend( {}, d, {
                            "account_id":_cboAccountTbl.val()
                        });
                    }
            }, 
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "columns": [

                { targets:[0],data: "bank_reconciliation_no" },
                { targets:[1],data: "account_title" },
                { sClass:"text-right", targets:[2],data: "adjusted_collected_balance_journal",
                    render: function (data, type, full, meta){
                        return accounting.formatNumber(parseFloat(data),2);
                    }
                },
                { sClass:"text-right", targets:[3],data: "adjusted_collected_balance_bank",
                    render: function (data, type, full, meta){
                        return accounting.formatNumber(parseFloat(data),2);
                    }
                },
                {
                    targets:[4],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                }
            ]
        });


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
            "bPaginate": false,
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
                        "accountid": _cboAccounts.select2('val'),
                        "bank_recon_id":_selectedID

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
                    targets:[3],data: "check_particular" 
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
                        var attr_checked="";
                        if(full.check_status_id==1){
                            attr_checked="checked";
                        }

                        return '<input type="radio" name="outstanding_'+ full.journal_id +'[0]" class="outstanding status" value="1" '+attr_checked+' data-amount="' + full.amount + '"/>'
                    }
                },
                { 
                    class: "text-center",
                    targets:[9],
                    render: function(data,type,full,meta) {
                        var attr_checked="";
                        if(full.check_status_id==2){
                            attr_checked="checked";
                        }

                        if(_txnMode == "new"){
                            attr_checked="checked";
                        }

                        return '<input id="check_no_'+full.check_no+'" type="radio" name="outstanding_'+ full.journal_id +'[0]" class="good-check status " value="2" '+attr_checked+'/>'
                    }
                }
            ]
        });
    };

    var bindEventHandlers=function(){

        $('#tbl_cbo_account_id').on('change', function() {
            $('#tbl_bank_reconciliation_list').DataTable().ajax.reload();
        });

        _cboAccounts.on('change', function(){
            var data = _cboAccounts.select2('data');

            if ($(this).val() != null || ""){
                $('input[name="current_bank_account"]').val(data[0].text);
                $('input[name="account_to_reconcile"]').val(data[0].text);

                var start = $('input[name="start_date"]').val();
                var end = $('input[name="end_date"]').val();

                $.ajax({
                    "dataType":"json",
                    "type":"GET",
                    "url":"Bank_reconciliation/transaction/get-account-balance?account_id="+_cboAccounts.select2('val')+"&start="+start+"&end="+end
                }).done(function(response){
                    $('input[name="account_balance"]').val(response.data);


                    reComputeTotal();
                });

                get_prev_statement();
                clearStatement();
                recomputeStatement();
            }

        });

        $('input[name="end_date"]').on('change', function(){
            var data = _cboAccounts.select2('data');

            if ($(this).val() != null || ""){
            
                var start = $('input[name="start_date"]').val();
                var end = $('input[name="end_date"]').val();

                $.ajax({
                    "dataType":"json",
                    "type":"GET",
                    "url":"Bank_reconciliation/transaction/get-account-balance?account_id="+_cboAccounts.select2('val')+"&start="+start+"&end="+end
                }).done(function(response){
                    $('input[name="account_balance"]').val(response.data);
                    reComputeTotal();
                });
            }

        });

        $('input[name="start_date"]').on('change', function(){
            var data = _cboAccounts.select2('data');

            if ($(this).val() != null || ""){
            
                var start = $('input[name="start_date"]').val();
                var end = $('input[name="end_date"]').val();

                $.ajax({
                    "dataType":"json",
                    "type":"GET",
                    "url":"Bank_reconciliation/transaction/get-account-balance?account_id="+_cboAccounts.select2('val')+"&start="+start+"&end="+end
                }).done(function(response){
                    $('input[name="account_balance"]').val(response.data);
                    reComputeTotal();
                });
            }

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

        $("#searchbox_table").keyup(function(){         
            dt_bank_reconciliation
                .search(this.value)
                .draw();
        });

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

        $('#btn_new').click(function(){
            _txnMode="new";
            $('input[name="start_date"]').datepicker('setDate','today');
            $('input[name="end_date"]').datepicker('setDate','today');
            $('#btn_step_1').click();
            clearFields($('#frm_reconcile'));

            $('.row-additional-journal').html("");
            $('.row-deduction-journal').html("");
            $('.row-additional-bank').html("");
            $('.row-deduction-bank').html("");

            $('#tbl_bank_reconciliation').DataTable().ajax.reload();
            showList(false);
        }); 

        $('#tbl_bank_reconciliation_list tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt_bank_reconciliation.row(_selectRowObj).data();
            _selectedID=data.bank_recon_id;
            _editStatus=1;
            $('#cbo_accounts').select2('val',data.account_id);
            $('#month_id').select2('val',data.month_id);
            $('#year').select2('val',data.year);

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        if(_elem.hasClass('numeric')){
                            _elem.val(accounting.formatNumber(value,2));
                        }else{
                            _elem.val(value);
                        }
                    }
                });
            });

            setTimeout(function(){
                $('#opening_balance').val(accounting.formatNumber(data.opening_balance,2));
                $('#closing_balance').val(accounting.formatNumber(data.closing_balance,2));
            },400);

            $.ajax({
                "dataType":"html",
                "type":"POST",
                "url":"Bank_statement/transaction/items?id="+ data.bank_statement_id,
                "beforeSend" : function(){
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="7"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                }
            }).done(function(response){
                
                $('#tbl_entries > tbody').html("");
                $('#tbl_entries > tbody').html(response);

                reInitializeNumeric();
                reInitializeDate();

            });

                $.ajax({
                    url : 'Bank_reconciliation/transaction/bank-r-items/'+_selectedID,
                    type : "GET",
                    cache : false,
                    dataType : 'json',
                    processData : false,
                    contentType : false,
                    success : function(response){
                        var rows=response.data;

                        $('.row-additional-journal').html("");
                        $('.row-deduction-journal').html("");
                        $('.row-additional-bank').html("");
                        $('.row-deduction-bank').html("");

                        $.each(rows,function(i,value){
                            if(value.class_type_id == 1){
                                if(value.category_type_id == 1){
                                    $('.row-additional-journal').append(addJournalRow(value.description, value.amount));
                                }
                                if(value.category_type_id == 2){
                                    $('.row-deduction-journal').append(deductJournalRow(value.description, value.amount));
                                }
                            }
                            if(value.class_type_id == 2){
                                if(value.category_type_id == 1){
                                    $('.row-additional-bank').append(addBankRow(value.description, value.amount));
                                }
                                if(value.category_type_id == 2){
                                    $('.row-deduction-bank').append(deductBankRow(value.description, value.amount));
                                }
                            }
                        });

                        reInitializeRemoveButtonJournalDeduction();
                        reInitializeRemoveButtonJournalAdditional();
                        reInitializeRemoveButtonBankDeduction();
                        reInitializeRemoveButtonBankAdditional();
                        reComputeTotal();
                    }
                });

            _editStatus=0;

            $('#tbl_bank_reconciliation').DataTable().ajax.reload();

            reInitializeNumeric();
            showList(false);
        });


        $('#btn_yes').click(function(){
            removeBankRecon().done(function(response){
                showNotification(response);
                dt_bank_reconciliation.row(_selectRowObj).remove().draw();
            });
        });        

        $('#btn_cancel').click(function(){
            showList(true);
        });              

        var deductJournalRow = function(desc="", amount=""){
            return '<div class="row"><div class="col-sm-1"><div class="btn-remove-deduct-journal"><i class="fa fa-times" style="color: red;margin-top: 5px;cursor: pointer;"></i></div></div><div class="col-sm-7"><input type="text" name="deduction_journal_desc[]" class="form-control" placeholder="Deduction description" value="'+desc+'" required data-error-msg="Description is required!"></div><div class="col-sm-4"><input type="text" name="deduction_journal_amt[]" class="numeric amount-field form-control" placeholder="Amount" value="'+amount+'" required data-error-msg="Amount is required!"></div></div>';
        };

        var addJournalRow = function(desc="", amount=""){
            return '<div class="row"><div class="col-sm-1"><div class="btn-remove-additional-journal"><i class="fa fa-times" style="color: red;margin-top: 5px;cursor: pointer;"></i></div></div><div class="col-sm-7"><input type="text" name="additional_journal_desc[]" class="form-control" placeholder="Aditional description" value="'+desc+'" required data-error-msg="Description is required!"></div><div class="col-sm-4"><input type="text" name="additional_journal_amt[]" class="numeric amount-field form-control" placeholder="Amount" value="'+amount+'" required data-error-msg="Amount is required!"></div></div>';

        };

        var deductBankRow=function(desc="", amount=""){
            return '<div class="row"><div class="col-sm-1"><div class="btn-remove-deduction-bank"><i class="fa fa-times" style="color: red;margin-top: 5px;cursor: pointer;"></i></div></div><div class="col-sm-7"><input type="text" name="deduction_bank_desc[]" class="form-control" placeholder="Deduction description" value="'+desc+'" required data-error-msg="Description is required!"></div><div class="col-sm-4"><input type="text" name="deduction_bank_amt[]" class="numeric amount-field form-control" placeholder="Amount" value="'+amount+'" required data-error-msg="Amount is required!"></div></div>';
        };

        var addBankRow=function(desc="", amount=""){
            return '<div class="row"><div class="col-sm-1"><div class="btn-remove-additional-bank"><i class="fa fa-times" style="color: red;margin-top: 5px;cursor: pointer;"></i></div></div><div class="col-sm-7"><input type="text" name="additional_bank_desc[]" class="form-control" placeholder="Aditional description" value="'+desc+'" required data-error-msg="Description is required!"></div><div class="col-sm-4"><input type="text" name="additional_bank_amt[]" class="numeric amount-field form-control" placeholder="Amount" value="'+amount+'" required data-error-msg="Amount is required!"></div></div>';
        };

        //add new line of deduction
        $('#btn-add-deduct-journal').on('click',function(){

            var row=$('.row-deduction-journal');
            row.append(deductJournalRow());

            reInitializeNumeric();
            reInitializeRemoveButtonJournalDeduction();
        });

        var reInitializeRemoveButtonJournalDeduction = function(){

            $('.amount-field').on("keyup", function(){
                reComputeTotal();
            });

            $('.btn-remove-deduct-journal').on('click', function(){
                var oRow = $(this).closest('.row');
                oRow.remove();
                reComputeTotal();
            });

        };

        //add new line of deduction
        $('#btn-additional-journal').on('click',function(){

            var row=$('.row-additional-journal');
            row.append(addJournalRow());

            reInitializeNumeric();
            reInitializeRemoveButtonJournalAdditional();
        });

        var reInitializeRemoveButtonJournalAdditional = function(){

            $('.amount-field').on("keyup", function(){
                reComputeTotal();
            });

            $('.btn-remove-additional-journal').on('click', function(){
                var oRow = $(this).closest('.row');
                oRow.remove();
                reComputeTotal();
            });

        };

        //add new line of deduction
        $('#btn-deduction-bank').on('click',function(){

            var row=$('.row-deduction-bank');
            row.append(deductBankRow());

            reInitializeNumeric();
            reInitializeRemoveButtonBankDeduction();
        });

        var reInitializeRemoveButtonBankDeduction = function(){

            $('.amount-field').on("keyup", function(){
                reComputeTotal();
            });

            $('.btn-remove-deduction-bank').on('click', function(){
                var oRow = $(this).closest('.row');
                oRow.remove();
                reComputeTotal();
            });

        };

        //add new line of deduction
        $('#btn-additional-bank').on('click',function(){

            var row=$('.row-additional-bank');
            row.append(addBankRow());

            reInitializeNumeric();
            reInitializeRemoveButtonBankAdditional();
        });

        var reInitializeRemoveButtonBankAdditional = function(){

            $('.amount-field').on("keyup", function(){
                reComputeTotal();
            });

            $('.btn-remove-additional-bank').on('click', function(){
                var oRow = $(this).closest('.row');
                oRow.remove();
                reComputeTotal();
            });

        };




        var showList=function(b){
            if(b){
                $('#div_bank_reconciliation_list').show();
                $('#div_bank_reconciliation_fields').hide();
            }else{
                $('#div_bank_reconciliation_list').hide();
                $('#div_bank_reconciliation_fields').show();
            }
        };

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
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="7"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
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

            // Check Bank Statement if existing
            clearStatement();
            checkBankStatement().done(function(response){

                if (response.data.length > 0){

                    var data = response.data[0];
                    $('#opening_balance').val(accounting.formatNumber(data.opening_balance,2));
                    $('#closing_balance').val(accounting.formatNumber(data.closing_balance,2));

                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Bank_statement/transaction/bank-items?month_id="+ data.month_id +"&account_id="+ data.account_id + "&year_id="+ data.year,
                        "beforeSend" : function(){
                            $('#tbl_entries > tbody').html('<tr><td align="center" colspan="7"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                        }
                    }).done(function(response){
                        
                        $('#tbl_entries > tbody').html("");
                        $('#tbl_entries > tbody').html(response);

                        reInitializeNumeric();
                        reInitializeDate();

                    });

                }else{
                    prevBankStatement().done(function(response){
                        var opening_balance = 0;

                        if (response.data.length > 0){
                            var data = response.data[0];
                            opening_balance = data.closing_balance;
                            load_status = 1;
                        }

                        $('#opening_balance').val(accounting.formatNumber(opening_balance,2));
                    });
                }

            });
        };

        // $('#btn_step_2').click(function(){

        //     if (load_status == 0){
        //         get_prev_statement();
        //     }
    
        // });

        _cboMonths.on('change', function(){
            get_prev_statement();
            clearStatement();
            recomputeStatement();
        });

        _cboYears.on('change', function(){
            get_prev_statement();
            clearStatement();
            recomputeStatement();
        });                

        $('#btn_step_3').click(function(){
            var total = 0;

            $(".outstanding:checked").each(function() {
                total += parseFloat($(this).data('amount'));
            });

            // $('#tbl_bank_reconciliation tbody tr').each(function() {
            //     var _selectRowObj=$(this);
            //     var data=dt.row(_selectRowObj).data();

            //     if (!$('#outstanding_' + data.check_no).is(':checked') && !$('#good_check_' + data.check_no).is(':checked') && !$('#default_' + data.check_no).is(':checked')) {
            //         $('#default_' + data.check_no).prop('checked','checked');
            //     }
            // });

            $('input[name="outstanding_checks"]').val(accounting.formatNumber(total,2));
            $('input[name="actual_balance"]').val(accounting.formatNumber($('#closing_balance').val(),2));

            reComputeTotal();
            reInitializeNumeric();
        });

        $('#startDate').on('change',function(){
            $('#tbl_bank_reconciliation').DataTable().ajax.reload();
        });

        $('#cbo_accounts').on('change',function(){
            get_prev_statement();
            $('#tbl_bank_reconciliation').DataTable().ajax.reload();
        });

        $('#endDate').on('change',function(){
            $('#tbl_bank_reconciliation').DataTable().ajax.reload();
        });

        $('#btn_process').click(function(){
            if(validateRequiredFields()){
                reconcileChecks().done(function(response){
                    showNotification(response);

                    if(response.stat == "success"){
                        clearFields($('#frm_reconcile'));
                        $('#tbl_bank_reconciliation').DataTable().ajax.reload();
                        $('#tbl_history').DataTable().ajax.reload();
                        clearStatement();
                        dt_bank_reconciliation.row(_selectRowObj).remove().draw();
                        showList(true);
                    }

                }).always(function(){
                    showSpinningProgress($('#btn_process'));
                })
            }
        });

        $('#btn_save').click(function(){

            if(validateRequiredFieldsList()){
                if(_txnMode=="new"){
                    createBankRecon().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt_bank_reconciliation.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_reconcile'));
                            showList(true);
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateBankRecon().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt_bank_reconciliation.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields($('#frm_reconcile'));
                            showList(true);
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });

        $('#tbl_bank_reconciliation_list tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_bank_reconciliation.row(_selectRowObj).data();
            _selectedID=data.bank_recon_id;
            $('#modal_confirmation').modal('show');
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

        // if ($('input[name="outstanding_checks"]').val() == '0.00') {
        //     _msg="Outstanding check must not be zero";
        //     showNotification({title: 'Error!', msg: _msg, stat: 'error'});
        //     stat=false;
        //     return false;
        // } else 

        if (_cboAccounts.val() == null) {
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

    var validateRequiredFieldsList=function(){
        var stat=true;
        var _msg="";

        if (_cboAccounts.val() == null) {
            _msg="Account to reconcile is required";
            showNotification({title: 'Error!', msg: _msg, stat: 'error'});
            stat=false;
            return false;
        }

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',$('#frm_deduction_journal, #frm_additional_journal, #frm_deduction_bank, #frm_additional_bank')).each(function(){

            if($(this).is('select')){
                if($(this).select2('val')==0||$(this).select2('val')==null){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }else{
                if($(this).val()==""||$(this).val()==0){
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



    var reconcileChecks=function(){
        // var _journalId;
        // var _status;
        // var _data=[];
        var _data=$('#frm_bank_statement').serializeArray();

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
        _data.push({name: "bank_recon_id", value: _selectedID });
        
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_reconciliation/transaction/reconcile-check",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_process'))
        });
    };

    var createBankRecon=function(){
        var _data=$('#frm_bank_statement, #frm_deduction_journal, #frm_additional_journal, #frm_deduction_bank, #frm_additional_bank').serializeArray();

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

        _data.push({name: "start_date", value: $('input[name="start_date"]').val() });
        _data.push({name: "end_date", value: $('input[name="end_date"]').val() });
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
            "url":"Bank_reconciliation/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    }; 


    var updateBankRecon=function(){
        var _data=$('#frm_bank_statement, #frm_deduction_journal, #frm_additional_journal, #frm_deduction_bank, #frm_additional_bank').serializeArray();

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

        _data.push({name: "start_date", value: $('input[name="start_date"]').val() });
        _data.push({name: "end_date", value: $('input[name="end_date"]').val() });
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
        _data.push({name: "bank_recon_id", value: _selectedID });
        
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_reconciliation/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };        

    var removeBankRecon=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_reconciliation/transaction/delete",
            "data":{bank_recon_id : _selectedID}
        });
    };

    var prevBankStatement = function(){
        var _data=$('#').serializeArray();
        _data.push({name: "month_id", value: $('#month_id').val() });
        _data.push({name: "account_id", value: $('#cbo_accounts').val() });
        _data.push({name: "year_id", value: $('#year').val() });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_reconciliation/transaction/get_previous_balance",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_process'))
        });
    };

    var checkBankStatement = function(){
        var _data=$('#').serializeArray();
        _data.push({name: "month_id", value: $('#month_id').val() });
        _data.push({name: "account_id", value: $('#cbo_accounts').val() });
        _data.push({name: "year_id", value: $('#year').val() });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Bank_statement/transaction/check_bank_statement",
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

        var total_deduction_journal = 0;

        $('input[name="deduction_journal_amt[]"]').each(function(){
            total_deduction_journal += accounting.unformat($(this).val());
        });

        var total_additional_journal = 0;

        $('input[name="additional_journal_amt[]"]').each(function(){
            total_additional_journal += accounting.unformat($(this).val());
        });


        var total_deduction_bank = 0;

        $('input[name="deduction_bank_amt[]"]').each(function(){
            total_deduction_bank += accounting.unformat($(this).val());
        });

        var total_additional_bank = 0;

        $('input[name="additional_bank_amt[]"]').each(function(){
            total_additional_bank += accounting.unformat($(this).val());
        });

        var totalBank = (_actualBalance - _outstandingChecks -_bankDeductions - total_deduction_bank) + _depositInTransit + _bankAdditions + total_additional_bank;

        var totalJournal = _accountBal - (_bankService + _nsfChecks + _checkPrinting + _journalDeductions + total_deduction_journal) + (_interestEarned + _notesReceivable + _journalAdditions + total_additional_journal);

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
        $('input[type="text"]:not(.date-picker),textarea',f).val('0.00');
        $('.numeric').val('0.00');
        $('input[name="current_bank_account"]').val('');
        $('input[name="account_to_reconcile"]').val('');
        _cboAccounts.select2('val',null);
        $(f).find('input:first').focus();
    };
});

</script>

</body>

</html>
               