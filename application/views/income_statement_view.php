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
        .select2-container {
            min-width: 100%;
        }


        .select2-dropdown {
            z-index: 9999999999;
        }

        .datepicker-dropdown {
            z-index: 9999999999;
        }

        .dropdown-menu {
            z-index: 9999999999;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        @keyframes spin {
            from {
                transform: scale(1) rotate(0deg);
            }

            to {
                transform: scale(1) rotate(360deg);
            }
        }

        @-webkit-keyframes spin2 {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }
    </style>

</head>

<body class="animated-content">

    <?php echo $_top_navigation; ?>

    <div id="wrapper">
        <div id="layout-static">

            <?php echo $_side_bar_navigation; ?>

            <div class="static-content-wrapper white-bg">
                <div class="static-content">
                    <div class="page-content">
                        <!-- #page-content -->
                        <ol class="breadcrumb" style="margin:0%;">
                            <li><a href="dashboard">Dashboard</a></li>
                            <li><a href="Income_statement">Income Statement</a></li>
                        </ol>
                        <div class="container-fluid">
                            <div data-widget-group="group1">

                                <div id="modal_bsheet" class="modal fade" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" style="color: white;">Income Statement <small style="color: white;"> | <a href="assets/manual/accountingreport/financialstatement/Income_Statement.pdf" target="_blank" style="color:white;"><i class="fa fa-question-circle"></i></a></small></h4>
                                            </div>
                                            <div class="modal-body">


                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <!-- <b class="required">*</b> Choose <b>Admin</b> to use all parents .<br> -->
                                                        Parent : <br />
                                                        <select name="department" id="cbo_departments" data-error-msg="Parent is required." required>
                                                            <option value="0">ALL</option>
                                                            <?php foreach ($departments as $department) { ?>
                                                                <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <!-- <b class="required">*</b> Choose <b>Admin</b> to use all parents .<br> -->
                                                        Branch : <br />
                                                        <select name="branch" id="cbo_customers" disabled data-error-msg="Branch is required." required>
                                                            <option value="0">ALL</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <br />


                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        Start Date : <br />
                                                        <div class="input-group" style="z-index: 99999">

                                                            <input type="text" name="date_start" id="dt_start_date" class="date-picker form-control" value="01/01/<?php echo date("Y"); ?>" placeholder="Start Date" data-error-msg="Start date is required!" required>

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

                                                            <input type="text" name="date_end" id="dt_end_date" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Start Date" data-error-msg="Start date is required!" required>

                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div><br />





                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-xs-12">
                                                    <a id="btn_print" href="#" target="_blank" class="btn btn-green" style="text-transform:none;font-family: tahoma;" title=" Print"><i class="fa fa-print"></i> Print </a>
                                                    <button id="btn_export" class="btn btn-primary" title="All departments"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                                    <!--                                                 <a href="Templates/layout/income-statement?type=&type=pdf" class="btn btn-primary" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-file-pdf-o"></i> Download as PDF </a> -->
                                                    <button class="btn btn-primary" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Send to Email (All departments)">
                                                        <i class="fa fa-share"></i> Email </button>
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
                            <li>
                                <h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION</h6>
                            </li>
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
        $(document).ready(function() {
            var _cboDepartments;
            var _cboCustomers;

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


            _cboDepartments = $('#cbo_departments').select2({
                placeholder: "Please select parent.",
                allowClear: true
            });

            _cboDepartments.change(function(e) {
                if (e.target.value == 0) {
                    _cboCustomers.select2('val', 0);
                    $('#cbo_customers').prop('disabled', true);
                    return
                }
                $('#cbo_customers').prop('disabled', false);
                getCustomers()
            })

            _cboCustomers = $('#cbo_customers').select2({
                placeholder: "Please select branch.",
                allowClear: true
            });
            // _cboDepartments.select2('val',1);

            $('#btn_export').click(function() {
                window.open('Income_statement/transaction/export-excel?start=' + $('#dt_start_date').val() + '&end=' + $('#dt_end_date').val() + "&depid=" + _cboDepartments.select2('val') + "&customer_id=" + _cboCustomers.select2('val'));
            });

            $('#btn_email').on('click', function() {
                showNotification({
                    title: "Sending!",
                    stat: "info",
                    msg: "Please wait for a few seconds."
                });

                var btn = $(this);

                $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": "Income_statement/transaction/email-excel?start=" + $('#dt_start_date').val() + '&end=' + $('#dt_end_date').val() + "&depid=" + _cboDepartments.select2('val') + "&customer_id=" + _cboCustomers.select2('val'),
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response) {
                    showNotification(response);
                    showSpinningProgress(btn);

                });
            });

            var showSpinningProgress = function(e) {
                $(e).toggleClass('disabled');
                $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            };


            var showNotification = function(obj) {
                PNotify.removeAll(); //remove all notifications
                new PNotify({
                    title: obj.title,
                    text: obj.msg,
                    type: obj.stat
                });
            };

            var getCustomers = function() {
                var department_id = $("#cbo_departments").val();
                if (department_id) {
                    $.ajax({
                        url: 'Customers/transaction/getcustomer?department_id=' + department_id,
                        type: "GET",
                        cache: false,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var rows = response.data;
                            $("#cbo_customers option").remove();
                            $("#cbo_customers").append('<option value="0">ALL</option>');
                            $.each(rows, function(i, value) {
                                $("#cbo_customers").append('<option value="' + value.customer_id + '">' + value.customer_name + '</option>');
                            });
                            $('#cbo_customers').val(0).trigger("change");
                        }
                    });
                }
            };

            $('#btn_print').click(function() {
                $(this).attr('href', "Templates/layout/income-statement?type=&type=preview&start=" + $('#dt_start_date').val() + "&end=" + $('#dt_end_date').val() + "&depid=" + _cboDepartments.select2('val') + "&customer_id=" + _cboCustomers.select2('val'));
                //window.open($(this).attr('href')+"?start="+$('#dt_start_date').val()+"&end="+$('#dt_end_date').val()+"&depid="+_cboDepartments.select2('val'));

            });



            // _btnPrint.on('click', function(){
            //     $('#modal_balance').modal('show');
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