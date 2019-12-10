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
        .select2-container{
            min-width: 100%;

        }
        .select2-dropdown{
            z-index: 999999;
        }
        .select2-selection__rendered {
            line-height: 26px !important;
        }
        .select2-container .select2-selection--single {
            height: 30px !important;
        }
        .select2-selection__arrow {
            height: 29px !important;
        }
    .table td {
         padding: 3px 10px 3px 10px!important; 
    }
    </style>

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg custom-background">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->

                    <ol class="breadcrumb transparent-background" style="margin: 0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Cash_flow_settings">Cash Flow Configuration</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body table-responsive">
                                        <h2 class="h2-panel-heading">Cash Flow Configuration</h2><hr>
                                        <b>Note:</b> Please set up the appropriate classifications for the accounts needed in the Comparative Cash Flow report. Classifications include: <i>
                                        Depreciation and Amortization, Receivables, Advances, Prepayments, Other current assets, Accounts Payable and Other Current Liabilities, Interest received, Income Taxes Paid, Creditable Withholding Taxes, Addition of Property and Equipment, Withdrawals, and Provision For Income Tax.</i><b> Each classification need atleast one account.</b>
                                        <form id="frm_cash_flow_settings" role="form" class="form-horizontal">
                                            <table class="table table-striped" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Account #</th>
                                                        <th width="35%">Account</th>
                                                        <th width="12%">Type</th>
                                                        <th width="20%">Classification</th>
                                                        <th width="17%">Cash Flow Classification</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($accounts as $account){ ?>
                                                    <tr>
                                                        <td><?php echo $account->account_no; ?></td>
                                                        <td><?php echo $account->account_title; ?></td>
                                                        <td><?php echo $account->account_type; ?></td>
                                                        <td><?php echo $account->account_class; ?></td>
                                                        <td><input type="hidden" name="account_id[]" value="<?php echo $account->account_id; ?>">
                                                            <select class="cbo_accounts" name="ref_id[]">
                                                                <option value="0">None</option>
                                                                <?php foreach($cash_flow_references as $cash_flow_reference){ ?>
                                                                    <option value="<?php echo $cash_flow_reference->cash_flow_ref_id; ?>" <?php if($account->cash_flow_ref_id == $cash_flow_reference->cash_flow_ref_id){echo ' selected'; } ?>><?php echo $cash_flow_reference->cash_flow_desc; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table><br /><br />
                                        </form>
                                        <button id="btn_save" class="btn btn-primary"><span></span> Save Cash Flow Configuration</button>
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
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC</h6></li>
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
<script src="assets/plugins/select2/select2.full.min.js"></script>

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
 var _cboAccounts;
    var initializeControls=function(){
        _cboAccounts=$(".cbo_accounts").select2({
            placeholder: "Please Select a Cash Flow Category.",
            allowClear: false
        });
    }();

    var bindEventHandlers=(function(){
       
        $('#btn_save').click(function(){
              console.log($('#frm_cash_flow_settings').serializeArray());

            saveCashFlow().done(function(response){
                showNotification(response);
            }).always(function(){
                showSpinningProgress($('#btn_save'));
            });

        });
    })();

     var saveCashFlow=function(){
        var _data=$('#frm_cash_flow_settings').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Cash_flow_settings/transaction/save-cash-flow-configuration",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var showNotification=function(obj){
        PNotify.removeAll();
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