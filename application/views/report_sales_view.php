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
        .numericCol {
            text-align: right;
        }

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
        #tbl_pi_summary_filter{
            display: none;
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
                        <li><a href="Report_sales">Sales Report</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_payable_list">

                                        <div class="panel-group panel-default" id="accordionA">
                                            <div class="panel panel-default">
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Sales Report</h2><hr>
                                                        <div>
                                                            <div class="row">

                                                                <div class="col-lg-2">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_from" class="date-picker form-control" value="<?php echo date("m"); ?>/01/<?php echo date("Y"); ?>">
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
                                                                <div class="col-lg-2"><br>
                                                                    <button class="btn btn-success pull-left" id="btn_export_sales" title="Export to Excel" style="padding: 7px 7px!important;">
                                                                    <i class="fa fa-file-excel-o"></i> Product W/ Sales</button>
                                                                </div>
                                                                <div class="col-lg-2"><br>
                                                                    <button class="btn btn-success pull-left" id="btn_export_sales_all" title="Export All Products to Excel" style="padding: 7px 7px!important;">
                                                                    <i class="fa fa-file-excel-o"></i> All Products </button>
                                                                </div>
                                                                <div class="col-lg-2"><br>
                                                                    <button class="btn btn-success pull-left" id="btn_export_sales_suppliers" title="Export All Products to Excel" style="padding: 7px 7px!important;">
                                                                    <i class="fa fa-file-excel-o"></i> Sales By Supplier </button>
                                                                </div>
                                                                <div class="col-lg-2"><br>
                                                                   <input type="text" id="tbl_pi_summary_search" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />

                                                        <div>
                                                            <div class="">
                                                                <div class="tab-content">
                                                                    <div id="summary" class="tab-pane fade in active">
                                                                    <div class="row">
                                                                        <table id="tbl_pi_summary" class="table table-striped" cellspacing="0" width="100%">
                                                                            <thead class="">
                                                                            <tr>
                                                                                <th>Product ID</th>
                                                                                <th>Product</th>
                                                                                <th>Quantity Sold</th>
                                                                                <th>Purchase Cost</th>
                                                                                <th>Sale Price</th>
                                                                                <th>Invoice Amount</th>
                                                                                <th>On Hand</th>
                                                                                <th>Critical</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <td align="right" colspan="5">Current Page Total : </td>
                                                                                    <td id="td_page_total_detailed" align="right"></td>
                                                                                    <td id="" align="right" colspan="2"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="right" colspan="5">Grand Total : </td>
                                                                                    <td id="td_grand_total_detailed" align="right"></td>
                                                                                    <td id="" align="right" colspan="2"></td>
                                                                                </tr>
                                                                            </tfoot>
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
                    <li><h6 style="margin: 0;">&copy; 2016 - Paul Christian Rueda</h6></li>
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
        var cbo_Type = $('#cboType');
        var dtSummary, dtDetailed;
        var tbl_summary = $('#tbl_pi_summary');
        var _cboXReading;
        var _date_from = $('input[name="date_from"]');
        var _date_to = $('input[name="date_to"]');





        var initializeControls=function() {
            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

        _cboXReading=$('#cbo_xreading').select2({
            placeholder: "Please Select an X Reading.",
            allowClear: false
        });

            initializeDataTable();
        }();

        function initializeDataTable(){
                dtSummary=tbl_summary.DataTable({   
                    "dom": '<"toolbar">frtip',
                    "bLengthChange":false,
                    // "bPaginate":false,
                    "pageLength": 15,
                    "language": { searchPlaceholder: "Search" },
                    oLanguage: {
                            sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                    },
                    processing : true,
                    "ajax": {
                        "url":"Report_sales/transaction/list",
                        "type":"GET",
                        "bDestroy":true,
                        "data": function (d) {
                            return $.extend({}, d, {
                                "startDate":_date_from.val(),
                                "endDate":_date_to.val()

                            });
                        }
                    },
                    
                        "columns":[
                            { targets:[0],data: "product_id", visible:false },
                            { targets:[1],data: "product_desc" },
                            {
                                sClass: "numericCol", 
                                targets:[2],data: "product_quantity",
                                render: function(data,type,full,meta){
                                    return accounting.formatNumber(data,0);
                                }
                            },
                            {
                                sClass: "numericCol", 
                                targets:[3],data: "purchase_cost",
                                render: function(data,type,full,meta){
                                    return accounting.formatNumber(data,2);
                                }
                            },
                            {
                                sClass: "numericCol", 
                                targets:[4],data: "sale_price",
                                render: function(data,type,full,meta){
                                    return accounting.formatNumber(data,2);
                                }
                            },
                            {
                                sClass: "numericCol", 
                                targets:[5],data: "item_total",
                                render: function(data,type,full,meta){
                                    return accounting.formatNumber(data,2);
                                }
                            },
                            {
                                sClass: "numericCol", 
                                targets:[6],data: "CurrentQty",
                                render: function(data,type,full,meta){
                                    return accounting.formatNumber(data,0);
                                }
                            },
                            { targets:[7],data: "critical" },


                        ],
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };


                            // Total over all pages
                            total = api
                                .column( 5 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Total over this page
                            pageTotal = api
                                .column( 5, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );


                            $('#td_page_total_detailed').html('<b>'+accounting.formatNumber(pageTotal,2)+'</b>');
                            $('#td_grand_total_detailed').html('<b>'+accounting.formatNumber(total,2)+'</b>');

                        }

                });
        };

                var bindEventControls=function(){

            $('#btn_export_sales').on('click', function(){
                window.open('Report_sales/transaction/export?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            });

            $('#btn_export_sales_suppliers').on('click', function(){
                window.open('Report_sales/transaction/export-with-supplier?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            });

            $('#btn_export_sales_all').on('click', function(){
                window.open('Report_sales/transaction/export-all?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            });
        
            _date_from.on('change', function(){
                $('#tbl_pi_summary').DataTable().ajax.reload()
            });

            _date_to.on('change', function(){
                $('#tbl_pi_summary').DataTable().ajax.reload()
            });
            $("#tbl_pi_summary_search").keyup(function(){         
                dtSummary
                    .search(this.value)
                    .draw();
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

    });
</script>


</body>

</html>