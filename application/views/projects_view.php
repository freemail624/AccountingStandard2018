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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <style>
        .select2-container {
            min-width: 100%;
            z-index: 999999999;
        }
    </style>


    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>


    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


    <!-- Date range use moment.js same as full calendar plugin -->
   

    <style>

        .toolbar{
            float: left;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
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
            min-width: 100%;
        }
        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

       /* .container-fluid {
            padding: 0 !important;
        }

        .panel-body {
            padding: 0 !important;
        }*/

        #btn_new {
            text-transform: capitalize !important;
        }

        .modal-body {
            text-transform: bold;
        }

        .boldlabel {
            font-weight: bold;
        }

        .inlinecustomlabel {
            font-weight: bold;
        }


        .numeric{
            text-align: right;
        }

        #is_tax_exempt {
            width:23px;
            height:23px;
        }

        #modal_new_supplier {
            padding-left:0px !important;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        .btn-back {
            float: left; 
            border-radius: 50px; 
            border: 3px solid #9E9E9E!important; 
            background: transparent; 
            margin-right: 10px;
        }

        textarea {
            resize: none;
        }

        #supplier-modal p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
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

                    <ol class="breadcrumb" style="margin:0%;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Projects">Project Management</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_project_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                                <h2 class="h2-panel-heading"> Project Management</h2><hr>
                                            <div class="row-panel">
                                                <button class="btn btn-primary" id="btn_new" style="float: left; text-transform: capitalize;font-family: Tahoma, Georgia, Serif;margin-bottom: 0px !important;" data-toggle="modal" data-target="" data-placement="left" title="Create New Project" ><i class="fa fa-plus"></i> Create New Project</button>
                                                <table id="tbl_projects" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>    
                                                        <th></th>
                                                        <th>Project Code</th>
                                                        <th>Project Name</th>
                                                        <th >Location</th>
                                                        <th style="text-align: right;">Budget Cost Estimate</th>
                                                        <th><center>Action</center></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                                </div>
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

            <div id="modal_confirmation" class="modal fade" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"  style="color:white;"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->

            <div id="modal_create_projects" class="modal fade" role="dialog"><!--modal-->
                <div class="modal-dialog" style="width: 75%;">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Project Information</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frm_projects">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class=""><b class="required">*</b>Project Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-file-code-o"></i>
                                                    </span>
                                                    <input type="text" name="project_name" id="project_name" class="form-control" value="" data-error-msg="Project Name is required." required>
                                                </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:0px;">
                                                <label class=""><b class="required">*</b>Description :</label>
                                                <textarea name="project_desc" id="project_desc" class="form-control" data-error-msg="Project Description is required." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" style="margin:0px;">
                                        <div class="form-group" style="">
                                        <label><b class="required">*</b>Budget Cost Estimate</label>
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-money"></i>
                                                    </span>
                                                    <input type="text" name="budget_cost_estimate" class="form-control numeric" data-error-msg="Project Budget Estimate is required." required>
                                            </div>
                                        </div>
                                    <div >
                                    <label class="">Location :</label>
                                    <select id="cbo_location" name="location_id" class="form-control" style="width: 100% !important;">
                                        <?php foreach($locations as $location) { ?>
                                            <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group" style="">
                                        <label class=""><b class="required">*</b>Start Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="date_start" id="invoice_start" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Start Date" data-error-msg="Please set the start date!" required>
                                        </div>
                                    </div>
                                    <div class="form-group" style="">
                                        <label class=""><b class="required">*</b>End Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                           <input type="text" name="date_due" id="due_default" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Due" data-error-msg="Please set the date this items are issued!" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save" type="button" class="btn btn-primary" style="background-color:#2ecc71;color:white;"><span></span> Save</button>
                            <button id="btn_cancel" type="button" class="btn " data-dismiss="modal">Cancel</button>
                        </div>
                    </div><!---content---->
                </div>
            </div><!---modal-->







                <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
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





</body>
 <script src="assets/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>



    <!-- twitter typehead -->
    <script src="assets/plugins/twittertypehead/handlebars.js"></script>
    <script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

    <!-- touchspin -->
    <script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj;  var _cboLocation;


    var initializeControls=function() {
        _cboLocation=$('#cbo_location').select2({
            placeholder: "Please select Location",
            allowClear: true
        });

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        dt=$('#tbl_projects').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength":15,
                "order": [[ 6, "desc" ]],
            "ajax" : "Projects/transaction/list",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "project_code" },
                { targets:[2],data: "project_name" },
                { targets:[3],data: "location_name" },
                { targets:[4],data: "budget_cost_estimate" ,
                      render: $.fn.dataTable.render.number( ',', '.', 2 )
                },
                {
                    targets:[5],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"   data-toggle="tooltip" data-placement="top" title="Edit" style="margin-left:-5px;"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info"  data-toggle="tooltip" data-placement="top" title="Move to trash" style="margin-right:-5px;"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                },
                { targets:[6],data: "project_id" ,visible:false},
            ],

            language: {
                         searchPlaceholder: "Search"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(4).attr({
                    "align": "right"
                });
            }


        });

        $('.numeric').autoNumeric('init',{mDec:2});

    }();
    


    var bindEventHandlers=(function(){
        var detailRows = [];
            $('#tbl_projects tbody').on( 'click', 'tr td.details-control', function () {
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

                    var d=row.data();

                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Templates/layout/project-details/"+ d.project_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response,'no-padding' ).show();
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });



                }
            } );
        $('#btn_new').click(function(){
            _txnMode="new";
            $('#modal_create_projects').modal('show');
            clearFields($('#frm_projects'));
            _cboLocation.select2('val',null);
            $('.date-picker').datepicker('setDate', 'today');
            $('.numeric').val('0.00');
        });

        $('#tbl_projects tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";

            $('#modal_create_projects').modal('show');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.project_id;

            clearFields('#frm_projects');
             $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

             _cboLocation.select2('val',data.location_id);


        });



        $('input[name="purchase_cost"],input[name="markup_percent"],input[name="sale_price"]').keyup(function(){
            reComputeSRP();
        });

        $('#tbl_projects tbody').on('click','button[name="remove_info"]',function(){
            $('#modal_confirmation').modal('show');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.project_id;

        });
        

        $('#btn_yes').click(function(){
            removeProjects().done(function(response){
                showNotification(response);
                if(response.stat == 'success') {
                    dt.row(_selectRowObj).remove().draw();
                }
            });
        });


        $('#btn_cancel').click(function(){
            $('#modal_create_projects').modal('hide');
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_projects'))){
                if(_txnMode=="new"){
                    createProjects().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                     
                    }).always(function(){
                        $('#modal_create_projects').modal('toggle');
                        showSpinningProgress($('#btn_save'));
                    });
                    return;
                }
                if(_txnMode==="edit"){
                    updateProjects().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                      
                    }).always(function(){
                        $('#modal_create_projects').modal('toggle');
                        showSpinningProgress($('#btn_save'));
                    });
                    return;
                }
            }
        });

    
    })();

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).is('select')){
                    if($(this).val()==null || $(this).val()==""){
                        showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                        $(this).closest('div.form-group').addClass('has-error');
                        $(this).focus();
                        stat=false;
                        return false;
                    }
                }else{
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }
        });

        return stat;
    };

    var createProjects=function(){
        var _data=$('#frm_projects').serializeArray();
       // _data.push({name : "is_tax_exempt" ,value : _isTaxExempt});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Projects/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateProjects=function(){
        var _data=$('#frm_projects').serializeArray();
        //_data.push({name : "is_tax_exempt" ,value : _isTaxExempt});
        _data.push({name : "project_id" ,value : _selectedID});

        return $.ajax({ 
            "dataType":"json",
            "type":"POST",
            "url":"Projects/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeProjects=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Projects/transaction/delete",
            "data":{project_id : _selectedID}
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
        $(e).toggleClass('disabled');
    };



    var clearFields=function(f){
        $('input,textarea,select',f).val('');
        $(f).find('input:first').focus();
    };



    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };



});

</script>


</html>