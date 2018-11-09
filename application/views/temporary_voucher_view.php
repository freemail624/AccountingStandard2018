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
            background: url('assets/img/print.png') no-repeat center center;
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
        .center-align{
            text-align: center;
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

        <div class="static-content-wrapper white-bg custom-background">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->

                    <ol class="breadcrumb transparent-background" style="margin: 0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Temporary_voucher">Temporary Voucher</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_temporary_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Temporary Voucher</h2><hr>
                                                <table id="tbl_temporary" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Temporary Voucher No</th>
                                                        <th>Receipt No</th>
                                                        <th>Journal Transaction No</th>
                                                        <th>Particular</th>
                                                        <th style="text-align: center;">Check Date<br> (MM/DD/YYYY)</th>
                                                        <th>Check No</th>
                                                        <th>Amount</th>
                                                        <th><center>Action</center></th>
                                                        <th></th>
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
<div id="modal_check_layout_temporary" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>Select Check Layout</h4>

            </div>

            <div class="modal-body" style="padding-right: 20px;">

                <div class="row">
                        <div class="container-fluid">
                            <div class="col-xs-12">
                                <select class="form-control" id="cbo_check_layout" style="width: 100%;">
                                    <?php foreach($layouts as $layout){ ?>
                                        <option value="<?php echo $layout->check_layout_id; ?>"><?php echo $layout->check_layout; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                </div>


            </div>

            <div class="modal-footer">
                <button id="btn_print_check_temp" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Print Check</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboCheckLayout; var _selectedpaymentID;

    var initializeControls=function(){
        dt=$('#tbl_temporary').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 9, "desc" ]],
            "ajax" : "Temporary_voucher/transaction/list",
            "language" : {
                "searchPlaceholder": "Search Temporary Voucher"
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "temp_voucher_no" },
                { targets:[2],data: "receipt_no" },
                { targets:[3],data: "txn_no" },
                { targets:[4],data: "supplier_name" },
                { sClass:"center-align", targets:[5],data: "check_date" },
                { targets:[6],data: "check_no" },
                { sClass:"right-align", targets:[7],data: "amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                {
                    targets:[8],
                    render: function (data, type, full, meta){
                        var btn_print='<button class="btn btn-success btn-sm" name="print_check"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Prict Check"><i class="fa fa-print"></i> Print Check </button>';

                        return '<center>'+btn_print+'</center>';
                    }
                },
                { targets:[9],data: "temp_voucher_id" ,visible:false}
            ]
        });

        _cboCheckLayout=$('#cbo_check_layout').select2({
            placeholder: "Please select check layout.",
            allowClear: true
        });
        _cboCheckLayout.select2('val',null);
    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_temporary tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );
            var d=row.data();
             window.open('Templates/layout/temp-voucher?id='+d.temp_voucher_id+'&type=voucher');
            // if ( row.child.isShown() ) {
            //     tr.removeClass( 'details' );
            //     row.child.hide();

            //     detailRows.splice( idx, 1 );
            // }
            // else {
            //     tr.addClass( 'details' );

            //     row.child( format( row.data() ) ).show();

            //     if ( idx === -1 ) {
            //         detailRows.push( tr.attr('id') );
            //     }
            // }
        } );

        $('#tbl_temporary tbody').on('click','button[name="print_check"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.temp_voucher_id;
            _selectedpaymentID=data.payment_id;
            $('#modal_check_layout_temporary').modal('show');
        });



        $('#btn_print_check_temp').click(function(){
            if ($('#cbo_check_layout').select2('val') != null || $('#cbo_check_layout').select2('val') != undefined)
                window.open('Templates/layout/print-check-temp?layout='+$('#cbo_check_layout').val()+'&id='+_selectedpaymentID);
            else
                showNotification({ title: 'Error', msg: 'Please select check layout!', stat: 'error' });

        });


     
    })();


});

</script>

</body>

</html>