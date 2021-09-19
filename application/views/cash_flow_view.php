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
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <style>
        .select2-container{
            min-width: 100%;
        }


        .select2-dropdown{
            z-index: 9999999999;
        }

        .datepicker-dropdown{
            z-index: 9999999999;
        }

        .dropdown-menu{
            z-index: 9999999999;
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

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb" style="margin:0%;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Cash_flow">Cash Flow</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">

                            <div id="modal_bsheet" class="modal fade" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="color: white;">Cash Flow</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    Start Date : <br />
                                                    <div class="input-group" style="z-index: 99999">

                                                        <input type="text" name="date_start" id="dt_start_date" class="date-picker form-control" value="<?php echo date("m"); ?>/01/<?php echo date("Y"); ?>"  placeholder="Start Date" data-error-msg="Start date is required!" required>

                                                        <span class="input-group-addon">
                                                             <i class="fa fa-calendar"></i>
                                                        </span>

                                                    </div>
                                                </div>
                                            </div><br />

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    End Date : <br />
                                                    <div class="input-group" style="z-index: 99999">

                                                        <input type="text" name="date_end" id="dt_end_date" class="date-picker form-control" value="<?php echo date("m/t/Y"); ?>"  placeholder="Start Date" data-error-msg="Start date is required!" required>

                                                        <span class="input-group-addon">
                                                             <i class="fa fa-calendar"></i>
                                                        </span>

                                                    </div>
                                                </div>
                                            </div><br />





                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-xs-12">
<!--                                                 <a id="btn_print" href="#" target="_blank" class="btn btn-green" style="text-transform:none;font-family: tahoma;" title=" Print" ><i class="fa fa-print"></i> Print </a> -->
                                                <button id="btn_export" class="btn btn-primary" title="Export Report"><i class="fa fa-file-excel-o"></i> Export</button>
<!--                                                 <button class="btn btn-primary" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Send to Email (All departments)" >
                                                <i class="fa fa-share"></i> Email </button> -->
                                                <button class="btn btn-red" data-dismiss="modal" style="text-transform: capitalize;">Close</button>
                                            </div>

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
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>
        </div>
    </div>
</div>


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>


<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        var _modal_filter = $('#modal_bsheet'),
            _modal_balance = $('#modal_balance'),
            _date_from = $('#date_from'),
            _date_to = $('#date_to'),
            _datepicker = $('.date-picker'),
            _btnPrint = $('#btn_print');

        _datepicker.datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $('#btn_export').click(function(){
            window.open('Cash_flow/transaction/export-excel?start='+$('#dt_start_date').val()+'&end='+$('#dt_end_date').val());
        });    

        $('#btn_email').on('click', function() {
        showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

        var btn=$(this);
    
        $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Income_statement/transaction/email-excel?start="+$('#dt_start_date').val()+'&end='+$('#dt_end_date').val(),
            "beforeSend": showSpinningProgress(btn)
        }).done(function(response){
            showNotification(response);
            showSpinningProgress(btn);

        });
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
    
        // $('#btn_print').click(function(){
        //  $(this).attr('href',"Templates/layout/cash-flow-statement?type=&type=preview&start="+$('#dt_start_date').val()+"&end="+$('#dt_end_date').val());

        // });

        _modal_filter.modal('show');
    })();
</script>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


</body>

</html>