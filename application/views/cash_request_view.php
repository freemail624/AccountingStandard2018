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
        <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">

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

            .numeric{
                text-align: right;
            }

        </style>

    </head>

    <body class="animated-content">

    <?php echo $_top_navigation; ?>

        <div id="wrapper">
            <div id="layout-static">

            <?php echo $_side_bar_navigation;?>

                <div class="static-content-wrapper white-bg bg-color">
                    <div class="static-content"  >
                        <div class="page-content"><!-- #page-content -->

                            <ol class="breadcrumb" style="margin:0; background: transparent;">
                                <li><a href="dashboard">Dashboard</a></li>
                                <li><a href="Cash_request">Cash Request</a></li>
                            </ol>

                            <div class="container-fluid">
                                <div data-widget-group="group1">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div_cash_request_list">
                                                <div class="panel panel-default">
                                                    <div class="panel-body table-responsive">
                                                    <h2 class="h2-panel-heading">Cash Request<!-- <small> | <a href="assets/manual/references/Category_Management.pdf" target="_blank" style="color:#999999;"><i class="fa fa-question-circle"></i></a></small> --></h2><hr>
                                                        <table id="tbl_cash_request" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead class="">
                                                            <tr>
                                                                <th></th>
                                                                <th>Request #</th>
                                                                <th>Requesting Unit</th>
                                                                <th>Date Requested</th>
                                                                <th>Date Needed</th>
                                                                <th>Amount Requested</th>
                                                                <th><center>Action</center></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- <div class="panel-footer"></div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .container-fluid -->

                    </div> <!-- #page-content -->
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
                <div id="modal_cash_request" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2ecc71;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 id="cash_request_title" class="modal-title" style="color: #ecf0f1;"><span id="modal_mode"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="frm_cash_request" role="form">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label><b class="required">*</b> Requesting Unit :</label> <br/>
                                                <input type="text" name="requesting_unit" class="form-control" placeholder="Requesting Unit" data-error-msg="Requesting Unit is required!" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label><b class="required">*</b> Amount Requested :</label> <br/>
                                                <input type="text" name="requested_amount" class="numeric form-control" placeholder="Amount Requested" data-error-msg="Amount Requested is required!" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label><b class="required">*</b> Date :</label> <br/>
                                                <div class="input-group">
                                                    <input type="text" name="request_date" id="request_date" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Request Date" data-error-msg="Request Date is required!" required>
                                                     <span class="input-group-addon">
                                                         <i class="fa fa-calendar"></i>
                                                    </span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label><b class="required">*</b> Description of Need :</label> <br/>
                                                <textarea class="form-control" name="request_description" placeholder="Description of Need" rows="5"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label><b class="required">*</b> Date Needed :</label> <br/>
                                                <div class="input-group">
                                                    <input type="text" name="date_needed" id="date_needed" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Needed" data-error-msg="Date Needed is required!" required>
                                                     <span class="input-group-addon">
                                                         <i class="fa fa-calendar"></i>
                                                    </span>
                                                </div> 
                                                <label>Account Number :</label> <br/>
                                                <input type="text" name="account_number" class="form-control" placeholder="Account Number" data-error-msg="Account Number is required!">
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btn_save" class="btn btn-primary" name="btn_save"><span></span>Save</button>
                                <button id="btn_cancel" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </div>
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

    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script>

    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj;

        var initializeControls=function(){
            dt=$('#tbl_cash_request').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Cash_request/transaction/list",
                "language": {
                    "searchPlaceholder": "Search Request"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "cash_request_no" },
                    { targets:[2],data: "requesting_unit" },
                    { targets:[3],data: "request_date" },
                    { targets:[4],data: "date_needed" },
                    { sClass:"text-right", targets:[5],data: "requested_amount",
                        render: function (data, type, full, meta){
                            return accounting.formatNumber(data,2);
                        }
                    },
                    {
                        targets:[6],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        }
                    }
                ]
            });

            var createToolBarButton=function(){
                var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Cash Request" >'+
                    '<i class="fa fa-plus"></i> New Cash Request</button>';
                $("div.toolbar").html(_btnNew);
            }();


            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });

            $('.numeric').autoNumeric('init');

        }();

        var bindEventHandlers=(function(){
            var detailRows = [];

            $('#tbl_cash_request tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    //console.log(row.data());
                    var d=row.data();

                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Templates/layout/cash-request/"+ d.cash_request_id +"?type=dropdown",
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response,'no-padding' ).show();
                        // Add to the 'open' array
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });
                }
            });

            $('#btn_new').click(function(){
                _txnMode="new";
                clearFields();
                $('#cash_request_title').text('New Cash Request');
                $('#request_date').datepicker('setDate', 'today');
                $('#date_needed').datepicker('setDate', 'today');
                $('#modal_cash_request').modal('show');
            });

            $('#tbl_cash_request tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.cash_request_id;

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

                reInitializeNumeric();
                $('#cash_request_title').text('Edit Cash Request');
                $('#modal_cash_request').modal('show');
            });

            $('#tbl_cash_request tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.cash_request_id;
                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeCashRequest().done(function(response){
                    showNotification(response);
                    dt.row(_selectRowObj).remove().draw();
                });
            });

            $('input[name="file_upload[]"]').change(function(event){
                var _files=event.target.files;

                $('#div_img_category').hide();
                $('#div_img_loader').show();

                var data=new FormData();
                $.each(_files,function(key,value){
                    data.append(key,value);
                });

                console.log(_files);

                $.ajax({
                    url : 'Categories/transaction/upload',
                    type : "POST",
                    data : data,
                    cache : false,
                    dataType : 'json',
                    processData : false,
                    contentType : false,
                    success : function(response){
                        $('#div_img_loader').hide();
                        $('#div_img_category').show();
                    }
                });
            });

            $('#btn_cancel').click(function(){
                $('#modal_cash_request').modal('hide');
                //showList(true);
            });

            $('#btn_save').click(function(){
                if(validateRequiredFields($('#frm_cash_request'))){
                    if(_txnMode=="new"){
                        createCashRequest().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields();
                            $('#modal_cash_request').modal('hide');

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateCashRequest().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                            showList(true);
                            $('#modal_cash_request').modal('hide');
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                }
            });
        })();

        var reInitializeNumeric=function(){
            $('.numeric').autoNumeric('init',{mDec: 2});
            $('.number').autoNumeric('init', {mDec:0});
        };

        var validateRequiredFields=function(f){
            var stat=true;

            $('div.form-group').removeClass('has-error');
            $('input[required],textarea[required]',f).each(function(){
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            });
            return stat;
        };

        var createCashRequest=function(){
            var _data=$('#frm_cash_request').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_request/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateCashRequest=function(){
            var _data=$('#frm_cash_request').serializeArray();
            _data.push({name : "cash_request_id" ,value : _selectedID});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_request/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeCashRequest=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_request/transaction/delete",
                "data":{cash_request_id : _selectedID}
            });
        };

        var showList=function(b){
            if(b){
                $('#div_cash_request_list').show();
                $('#div_cash_request_fields').hide();
            }else{
                $('#div_cash_request_list').hide();
                $('#div_cash_request_fields').show();
            }
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
            $(e).toggleClass('disabled');
        };

        var clearFields=function(){
            $('input[required],textarea','#frm_cash_request').val('');
            $('form').find('input:first').focus();
        };

    });

    </script>
    </body>
</html>