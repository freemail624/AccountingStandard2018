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
                                <li><a href="Travel_order">Travel Order</a></li>
                            </ol>

                            <div class="container-fluid">
                                <div data-widget-group="group1">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div_travel_order_list">
                                                <div class="panel panel-default">
                                                    <div class="panel-body table-responsive">
                                                    <h2 class="h2-panel-heading">Travel Order<!-- <small> | <a href="assets/manual/references/Category_Management.pdf" target="_blank" style="color:#999999;"><i class="fa fa-question-circle"></i></a></small> --></h2><hr>
                                                        <table id="tbl_travel_order" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead class="">
                                                            <tr>
                                                                <th></th>
                                                                <th>Order #</th>
                                                                <th>Employee Name</th>
                                                                <th>Date of Travel</th>
                                                                <th>Destination</th>
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
                <div id="modal_travel_order" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2ecc71;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 id="travel_order_title" class="modal-title" style="color: #ecf0f1;"><span id="modal_mode"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="frm_travel_order" role="form">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label><b class="required">*</b> Employee Name :</label> <br/>
                                                <input type="text" name="employee_name" class="form-control" placeholder="Employee Name" data-error-msg="Employee Name is required!" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label><b class="required">*</b> Official Designation :</label> <br/>
                                                <input type="text" name="official_designation" class="form-control" placeholder="Official Designation" data-error-msg="Official Designation is required!" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label><b class="required">*</b> Travel Date :</label> <br/>
                                                <div class="input-group">
                                                    <input type="text" name="travel_date" id="travel_date" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Travel Date" data-error-msg="Travel Date is required!" required>
                                                     <span class="input-group-addon">
                                                         <i class="fa fa-calendar"></i>
                                                    </span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label><b class="required">*</b> Destination :</label> <br/>
                                                <textarea class="form-control" name="destination" placeholder="Destination" rows="5" data-error-msg="Destination is required!" required></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label><b class="required">*</b> Person to visit :</label> <br/>
                                                <input type="text" name="person_to_visit" id="person_to_visit" class="form-control" placeholder="Person to visit" data-error-msg="Person to visit is required!" required>
                                                <label>Designation :</label> <br/>
                                                <input type="text" name="designation" class="form-control" placeholder="Designation" data-error-msg="Designation is required!">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Purpose of Travel :</label> <br/>
                                                <textarea class="form-control" name="purpose_of_travel" placeholder="Purpose of Travel" rows="5"></textarea>
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
            dt=$('#tbl_travel_order').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Travel_order/transaction/list",
                "language": {
                    "searchPlaceholder": "Search Travel Order"
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "travel_order_no" },
                    { targets:[2],data: "employee_name" },
                    { targets:[3],data: "travel_date" },
                    { targets:[4],data: "destination" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        }
                    }
                ]
            });

            var createToolBarButton=function(){
                var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Travel Order" >'+
                    '<i class="fa fa-plus"></i> New Travel Order</button>';
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

            $('#tbl_travel_order tbody').on( 'click', 'tr td.details-control', function () {
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
                        "url":"Templates/layout/travel-order/"+ d.travel_order_id +"?type=dropdown",
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
                $('#travel_order_title').text('New Travel Order');
                $('#travel_date').datepicker('setDate', 'today');
                $('#modal_travel_order').modal('show');
            });

            $('#tbl_travel_order tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.travel_order_id;

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
                $('#travel_order_title').text('Edit Travel Order');
                $('#modal_travel_order').modal('show');
            });

            $('#tbl_travel_order tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.travel_order_id;
                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeTravelOrder().done(function(response){
                    showNotification(response);
                    dt.row(_selectRowObj).remove().draw();
                });
            });

            $('#btn_cancel').click(function(){
                $('#modal_travel_order').modal('hide');
            });

            $('#btn_save').click(function(){
                if(validateRequiredFields($('#frm_travel_order'))){
                    if(_txnMode=="new"){
                        createTravelOrder().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields();
                            $('#modal_travel_order').modal('hide');

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateTravelOrder().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                            showList(true);
                            $('#modal_travel_order').modal('hide');
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

        var createTravelOrder=function(){
            var _data=$('#frm_travel_order').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Travel_order/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateTravelOrder=function(){
            var _data=$('#frm_travel_order').serializeArray();
            _data.push({name : "travel_order_id" ,value : _selectedID});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Travel_order/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeTravelOrder=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Travel_order/transaction/delete",
                "data":{travel_order_id : _selectedID}
            });
        };

        var showList=function(b){
            if(b){
                $('#div_travel_order_list').show();
                $('#div_travel_order_fields').hide();
            }else{
                $('#div_travel_order_list').hide();
                $('#div_travel_order_fields').show();
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
            $('input,textarea','#frm_travel_order').val('');
            $('form').find('input:first').focus();
        };

    });

    </script>
    </body>
</html>