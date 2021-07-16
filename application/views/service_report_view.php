<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-cdjp-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--<link href="assets/dropdown-enhance/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">-->
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->

    <style>
        .toolbar{
            float: left;
        }

        td:nth-child(6),td:nth-child(7){
            text-align: right;
        }

        td:nth-child(8){
            text-align: right;
            font-weight: bolder;
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

                    <ol class="breadcrumb" style="margin-bottom: 0px;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Service_report">Service Report</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_payable_list">

                                        <div class="panel-group panel-default" id="accordionA">


                                            <div class="panel panel-default">
                                                <!-- <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo"><div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;;"><b style="color:white;font-size: 12pt;"><i class="fa fa-bars"></i> Customer Subsidiary</b></div></a> -->
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Service Report<small> | <a href="assets/manual/accountingreport/client/Customer_Subsidiary.pdf" target="_blank" style="color:#999999;"><i class="fa fa-question-circle"></i></a></small></h2><hr>
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    Service Type : <br />
                                                                    <select id="cbo_service_type" class="form-control">
                                                                        <?php foreach($vehicle_services as $vs){ ?>
                                                                            <option value="<?php echo $vs->vehicle_service_id; ?>" ?><?php echo $vs->service_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div class="col-lg-4">
                                                                <div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_from" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    Period End * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_to" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <br />

                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <table id="tbl_service_report" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th>RO #</th>
                                                                    <th>Document Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Plate No</th>
                                                                    <th>Advisor</th>
                                                                    <th>Total Amount</th>
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


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- Select2-->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>-->

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        var _cboAccounts; var dt; var _cboVehicleService;
        var _date_from = $('input[name="date_from"]');
        var _date_to = $('input[name="date_to"]');


        var initializeControls=function(){

            _cboVehicleService=$("#cbo_service_type").select2({
                placeholder: 'Please select service type',
            });
            // _cboVehicleService.select2('val', 0)

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            reloadList();

            createToolBarButton();
        }();

        var bindEventControls=function(){
            _cboVehicleService.on("select2:select", function (e) {
                dt.destroy();
                reloadList();
                createToolBarButton();
            });

            $('.date-picker').on('change',function(){
                dt.destroy();
                reloadList();
                createToolBarButton();
            });

            $(document).on('click','#btn_print',function(){
                window.open('Service_report/transaction/preview?vehicle_service_id='+_cboVehicleService.val()+'&start_date='+_date_from.val()+'&end_date='+_date_to.val());
            });

            $(document).on('click','#btn_export',function(){
                window.open('Service_report/transaction/excel?vehicle_service_id='+_cboVehicleService.val()+'&start_date='+_date_from.val()+'&end_date='+_date_to.val());

            });

            $(document).on('click','#btn_email',function(){
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Service_report/transaction/email?vehicle_service_id="+_cboVehicleService.val()+"&start_date="+_date_from.val()+"&end_date="+_date_to.val(),
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });
            });

            $(document).on('click','#btn_refresh',function(){
                dt.destroy();
                reloadList();
                createToolBarButton();
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



        function createToolBarButton(){
            var _btnPrint='<button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >'+
                '<i class="fa fa-print"></i> Print Report</button>';

            var _btnExport='<button class="btn btn-green" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Export" >'+
                '<i class="fa fa-file-excel-o"></i> Export</button>';

            var _btnEmail='<button class="btn btn-green" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Email" >'+
                '<i class="fa fa-share"></i> Email</button>';

            var _btnRefresh='<button class="btn btn-success" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Reload" >'+
                '<i class="fa fa-refresh"></i></button>';

            $("div.toolbar").html(_btnPrint+"&nbsp;"+_btnExport+"&nbsp;"+_btnEmail+"&nbsp;"+_btnRefresh);
        };





        function reloadList(){

            dt=$('#tbl_service_report').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "bPaginate":false,
                "ajax": {
                    "url": "Service_report/transaction/list",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "vehicle_service_id" : _cboVehicleService.select2('val'),
                            "start_date":_date_from.val(),
                            "end_date":_date_to.val()
                        });
                    }
                },
                "columns": [
                    { targets:[0],data: "repair_order_no" },
                    { targets:[1],data: "document_date" },
                    { targets:[2],data: "customer_name" },
                    { targets:[3],data: "plate_no" },
                    { targets:[4],data: "advisor" },
                    { targets:[5],data: "total_amount", 
                        render: function(data, type, full, meta){
                            return accounting.formatNumber(data,2);
                        } 
                    },
                    
                ]

                ,
                "rowCallBack": function(a,b,c){
                    console.log(b);
                }

            });
        };



    });
</script>


</body>

</html>