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

            .select2-container{
                width: 100% !important;
            }

            @keyframes spin {
                from { transform: scale(1) rotate(0deg); }
                to { transform: scale(1) rotate(360deg); }
            }

            @-webkit-keyframes spin2 {
                from { -webkit-transform: rotate(0deg); }
                to { -webkit-transform: rotate(360deg); }
            }
            #tbl_aging_filter{
                display: none;
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

                    <ol class="breadcrumb" style="margin:0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Aging_receivables">Aging of Receivables</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_tax_list">
                                        <div class="panel panel-default">
                                           <!--  <div class="panel-heading">
                                                <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Aging of Receivables</b>
                                            </div> -->
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Aging of Receivables</h2><hr>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                &nbsp;<br>
                                                    <button class="btn btn-primary" id="btn_print" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Print Aging Receivables" ><i class="fa fa-print"></i> Print Report</button>

                                                    <button class="btn btn-success" id="btn_export" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Export Aging Receivables" >'<i class="fa fa-file-excel-o"></i> Export</button>

                                                    <button class="btn btn-success hidden" id="btn_email" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Email Aging Receivables" ><i class="fa fa-share"></i> Email</button>
                                                </div>
                                                <div class="col-lg-3">
                                                        Department :<br />
                                                        <select id="cbo_departments" class="selectpicker show-tick form-control" data-live-search="true">
                                                                <option value="0"> All Departments</option>
                                                            <?php foreach($departments as $department){ ?>
                                                                <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                </div>
                                                <div class="col-lg-3">
                                                        Search :<br />
                                                         <input type="text" id="searchbox" class="form-control">
                                                </div>
                                            </div><br/>
                                                <table id="tbl_aging" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead class="">
                                                    <tr>
                                                        <th valign="top">Tenant Code</th>
                                                        <th valign="top">Trade Name</th>
                                                        <th valign="top"><center>0-30 <br/>DAYS</center></th>
                                                        <th valign="top"><center>31-60 <br/>DAYS</center></th>
                                                        <th valign="top"><center>61-90 <br/>DAYS</center></th>
                                                        <th valign="top"><center>90 DAYS <br/>AND <br/>ABOVE</center></th>
                                                        <th valign="top"><center>BALANCE</center></th>
                                                        <th valign="top"><center>TOTAL <br/> SECURITY <br/> DEPOSIT</center></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="2" align="right">TOTAL :</td>
                                                        <td id="td_thirty" align="right">0.00</td>
                                                        <td id="td_sixty" align="right">0.00</td>
                                                        <td id="td_ninety" align="right">0.00</td>
                                                        <td id="td_over_ninety" align="right">0.00</td>
                                                        <td id="td_balance" align="right">0.00</td>
                                                        <td id="td_security_deposit" align="right">0.00</td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="panel-footer"></div>
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
                        <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT BUSINESS SOLUTION</h6></li>
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

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script src="assets/plugins/select2/select2.full.min.js"></script>

    <script>

    $(document).ready(function() {
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _taxTypeGroup;
        var _cboDepartment;

        var initializeControls=function() {

            _cboDepartment=$("#cbo_departments").select2({
                placeholder: "Please Select Department.",
                allowClear: false
            });

            dt=$('#tbl_aging').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "order": [[ 1, "asc" ]],
                oLanguage: {
                        sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                },
                processing : true,
                "ajax" : {
                    "url" : "Aging_receivables/transaction/list",
                    "bDestroy": true,            
                    "data": function ( d ) {
                            return $.extend( {}, d, {
                                "id": _cboDepartment.val()
                            });
                        }
                }, 
                "columns": [
                    { targets:[0],data: "tenant_code" },
                    { targets:[1],data: "trade_name" },                    
                    {
                        class: 'text-right',
                        targets:[2],data: "balance_thirty_days",
                        render:function(data,type,full,meta){
                            return (data == 0 ? '' : accounting.formatNumber(data,2));
                        }
                    },
                    { 
                        class: 'text-right',
                        targets:[3],data: "balance_sixty_days",
                        render:function(data,type,full,meta){
                            return (data == 0 ? '' : accounting.formatNumber(data,2));
                        } 
                    },
                    { 
                        class: 'text-right',
                        targets:[4],data: "balance_ninety_days",
                        render:function(data,type,full,meta){
                            return (data == 0 ? '' : accounting.formatNumber(data,2));
                        }
                    },
                    { 
                        class: 'text-right',
                        targets:[5],data: "balance_over_ninetydays",
                        render:function(data,type,full,meta){
                            return (data == 0 ? '' : accounting.formatNumber(data,2));
                        }
                    },
                    { 
                        class: 'text-right',
                        targets:[6],data: "total_tenant_balance",
                        render:function(data,type,full,meta){
                            return (data == 0 ? '' : accounting.formatNumber(data,2));
                        }
                    },
                    { 
                        class: 'text-right',
                        targets:[7],data: "total_security_deposit",
                        render:function(data,type,full,meta){
                            return (data == 0 ? '' : accounting.formatNumber(data,2));
                        }
                    }
                    // ,
                    // {
                    //     visible:false,
                    //     targets:[6],data: "is_sales"
                    // }
                ],
                // "order": [[ 6, 'asc' ]],
                // "drawCallback": function ( settings ) {
                //     var api = this.api();
                //     var rows = api.rows( {page:'current'} ).nodes();
                //     var last=null;
         
                //     api.column(6, {page:'current'} ).data().each( function ( group, i ) {
                //         if ( last !== group ) {
                //             $(rows).eq( i ).before(
                //                 '<tr class="group"><td colspan="6" style="background:#eaeaea;"><strong>'+(group == 1 ? 'PER SALES' : 'PER SERVICES')+'</strong></td></tr>'
                //             );
                            
                //             last = group;
                //         }
                //     } );
                // },
                "footerCallback": function(a,b,c){
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    total_thirty = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_sixty = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_ninety = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_over_ninety = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_balance = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_security_deposit = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $('#td_thirty').html('<b>'+accounting.formatNumber(total_thirty,2)+'</b>');
                    $('#td_sixty').html('<b>'+accounting.formatNumber(total_sixty,2)+'</b>');
                    $('#td_ninety').html('<b>'+accounting.formatNumber(total_ninety,2)+'</b>');
                    $('#td_over_ninety').html('<b>'+accounting.formatNumber(total_over_ninety,2)+'</b>');
                    $('#td_balance').html('<b>'+accounting.formatNumber(total_balance,2)+'</b>');
                    $('#td_security_deposit').html('<b>'+accounting.formatNumber(total_security_deposit,2)+'</b>');
                }
            });
        }();


        var bindEventHandlers=function(){

            _cboDepartment.on("select2:select", function (e) {
                $('#tbl_aging').DataTable().ajax.reload();
           });

            $("#searchbox").keyup(function(){         
                dt
                    .search(this.value)
                    .draw();
            });

            $('#btn_print').click(function(){
                var id = $('#cbo_departments').val();
                window.open('Aging_receivables/transaction/print?id='+id);   
            });

            $('#btn_export').click(function(){
                var id = $('#cbo_departments').val();
                window.open('Aging_receivables/transaction/export?id='+id);   
            });

            $('#btn_email').click(function(){
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":'Aging_receivables/transaction/email',
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });   
            });


        }();

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

    });

    </script>

    </body>

</html>