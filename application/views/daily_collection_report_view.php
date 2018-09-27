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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

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
        .right-align{
            text-align: right;
        }

    </style>

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
                        <li><a href="Daily_collection_report">Revolving Fund Monitor </a></li>
                    </ol>

                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Revolving Fund Monitor </h2><hr>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-4" style="margin-bottom: 10px;">
                                                <strong>Department:</strong><br>
                                                <select id="cbo_departments" style="width: 100%;">
                                                    <?php foreach($departments as $department){ ?>
                                                        <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-12 col-md-2" style="margin-bottom: 10px;">
                                                <strong>Report Date:</strong>
                                                <div class="input-group">
                                                    <input id="txt_date" type="text" class="date-picker form-control" value="<?php echo date('m/d/Y'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2" style="margin-bottom: 10px;">
                                                <strong>To:</strong>
                                                <div class="input-group">
                                                    <input id="txt_date_end" type="text" class="date-picker form-control" value="<?php echo date('m/d/Y'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2" style="margin-bottom: 10px;">
                                                <strong></strong><br>
                                                <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;padding:5px 12px!important" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                    <i class="fa fa-print"></i> Print Report
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-md-2" style="margin-bottom: 10px;">
                                                <strong></strong><br>
                                                <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;padding:5px 12px!important" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                    <i class="fa fa-file-excel-o"></i> Export to Excel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                        <div class="row" style="display: none;">
                                            <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;display: none;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                <i class="fa fa-share"></i> Email
                                            </button>
                                        </div>
                                            <div id="tbl_daily_report" class="table table-striped" width="100%" cellspacing="0">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
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

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dtReplenish; var _cboDepartments;


    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var initializeControl=function(){
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
    _cboDepartments=$("#cbo_departments").select2({
        placeholder: "Please select Department.",
        allowClear: false
    });

        InitializeDataTable();
    }();

    var bindEventHandlers=function(){
        $('#txt_date').change(function(){
            InitializeDataTable();
        });

        $('#txt_date_end').change(function(){
            InitializeDataTable();
        });

        _cboDepartments.on('select2:select', function(){
            InitializeDataTable();
        });

        $('#btn_print').click(function(){
            window.open('Daily_collection_report/transaction/report?date='+$('#txt_date').val()+'&dep='+_cboDepartments.val()+'&date_to='+$('#txt_date_end').val());
        });

        $('#btn_export').click(function(){
            window.open('Daily_collection_report/transaction/export-daily-collection?date='+$('#txt_date').val()+'&dep='+_cboDepartments.val()+'&date_to='+$('#txt_date_end').val());
        });

        
    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };


    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };
    


    }();

    function InitializeDataTable() {
        $('#tbl_daily_report').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
        var data = [];
            data.push({name : "date" ,value : $('#txt_date').val()});
            data.push({name : "date_to" ,value : $('#txt_date_end').val()});
            data.push({name : "dep" ,value : _cboDepartments.val()});


        $.ajax({
            url : 'Daily_collection_report/transaction/list',
            type : "GET",
            cache : false,
            dataType : 'json',
            "data":data,
            success : function(response){
                beginning_balance = 0;
                total_collection = 0;
                total_carf = 0;
                ending_balance = 0;
                $('#tbl_daily_report').html('');
                $('#tbl_daily_report').append(
                     '<center><h4><strong>Revolving Fund Monitor</strong></h4><hr></center>'
                );

                beginning_balance =getFloat(response.balance);

                $('#tbl_daily_report').append(
                    '<table style="width:100%" class="table table-striped">'+
                    '<tr>'+
                    '<td style="width:30%;"><strong>Date:</strong></td>'+
                    '<td style="width:20%;"></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td class="right-align">'+$('#txt_date').val()+'-'+$('#txt_date_end').val()+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td style="width:30%;"><strong>Beginning Balance : </strong></td>'+
                    '<td style="width:20%;"></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td class="right-align">'+accounting.formatNumber(beginning_balance,2)+'</td>'+
                    '</tr>'+
                    '</table>'
                );

                $('#tbl_daily_report').append(
                    '<h4>Add : Collection</h4>'+
                    '<table style="width:100%" class="table table-striped">'+
                    '<thead>'+
                    '<th style="width:30%;">Particular</th>'+
                    '<th style="width:20%;">Receipt No</th>'+
                    '<th>Payment Type</th>'+
                    '<th>Transaction No</th>'+
                    '<th class="right-align">Amount</th>'+
                    '</thead>'+
                        '<tbody id="tbl_add">'+
                        '</tbody>'+
                         '</table>'
                );

                 $.each(response.collection, function(index,value){
                    total_collection +=getFloat(value.collection_amount);
                     $('#tbl_add').append(
                        '<tr>'+
                        '<td>'+value.supplier_name+'</td>'+
                        '<td>'+value.or_no+'</td>'+
                        '<td>'+value.payment_method+'</td>'+
                        '<td>'+value.txn_no+'</td>'+
                        '<td class="right-align">'+accounting.formatNumber(value.collection_amount,2)+'</td>'+
                        '</tr>'
                    );
                 });

                 $('#tbl_add').append(
                    '<tr>'+
                    '<td><strong>Total:</strong></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td class="right-align"><strong>'+accounting.formatNumber(total_collection,2)+'</strong<</td>'+
                    '</tr>'
                );

                $('#tbl_daily_report').append(
                    '<h4>Less (Out)</h4>'+
                    '<table style="width:100%" class="table table-striped">'+
                    '<thead>'+
                    '<th style="width:30%;">Particular</th>'+
                    '<th style="width:20%;">Transaction Type</th>'+
                    '<th>Payment Type</th>'+
                    '<th>Transaction No</th>'+
                    '<th class="right-align">Amount</th>'+
                    '</thead>'+
                        '<tbody id="tbl_less">'+
                        '</tbody>'+
                         '</table>'
                );

                 $.each(response.carf, function(index,value){
                    total_carf += getFloat(value.carf_amount);
                     $('#tbl_less').append(
                        '<tr>'+
                        '<td>'+value.supplier_name+'</td>'+
                        '<td>'+value.carf_trans_name+'</td>'+
                        '<td>'+value.payment_method+'</td>'+
                        '<td>'+value.txn_no+'</td>'+
                        '<td class="right-align">'+accounting.formatNumber(value.carf_amount,2)+'</td>'+
                        '</tr>'
                    );
                 });

                     $('#tbl_less').append(
                        '<tr>'+
                        '<td><strong>Total:</strong></td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td class="right-align"><strong>'+accounting.formatNumber(total_carf,2)+'</strong></td>'+
                        '</tr>'
                    );

                ending_balance = beginning_balance + total_collection  - total_carf;
                $('#tbl_daily_report').append(
                    '<table style="width:100%" class="table table-striped">'+
                    '<thead>'+
                    '<th style="width:30%;">Daily Balance:</th>'+
                    '<th style="width:20%;"></th>'+
                    '<th></th>'+
                    '<th></th>'+
                    '<th class="right-align">'+accounting.formatNumber(ending_balance,2)+'</th>'+
                    '</thead>'+
                    '</table>'
                );

            } // END OF RESPONSE
        });


    };
});

</script>

</body>

</html>