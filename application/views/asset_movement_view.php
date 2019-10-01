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
        #tbl_asset_move_filter{
            display: none;
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
                        <li><a href="Asset_movement">Movement of Assets</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_movement_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading" >Movement of Assets</h2><hr>

                                            <div class="row">
                                                <div class="col-lg-3"><br>
                                                <button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"  title="Record Movement" ><i class="fa fa-plus"></i> Record Movement</button>
                                                </div>
                                                <div class="col-lg-offset-6 col-lg-3" style="text-align: left;">
                                                        Search :<br />
                                                        <input type="text" id="searchbox_fixed" class="form-control">
                                                </div>
                                            </div><br>
                                                <table id="tbl_asset_move" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>

                                                    <tr>
                                                        <th>Asset No</th>
                                                        <th>Asset Code</th>
                                                        <th>Asset Description</th>
                                                        <th>Movement Date</th>
                                                        <th>Status</th>
                                                        <th>Remarks</th>
                                                        <th><center>Action</center></th>
                                                        <th><center>ID</center></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_movement_fields" style="display: none;">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading" >Movement of Assets <small id="heading_title_small"></small></h2> <hr>
                                                <form id="frm_asset_move" role="form" class="form-horizontal">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <b class="required">*</b><label>Asset Code:</label> <br />
                                                        <div class="input-group">
                                                            <input id="asset_code" type="text" name="asset_code" class="form-control"  required="" data-error-msg="Please select an Asset." readonly>
                                                            <input id="fixed_asset_id" type="hidden" name="fixed_asset_id" class="form-control"  required="" data-error-msg="Please select an Asset." readonly>
                                                            <span class="input-group-addon">
                                                                <a href="#" id="link_browse" style="text-decoration: none;color:black;"><b>...</b></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 ">
                                                        <label> Asset Description :</label> <br />
                                                        <input type="text" id="asset_description" name="asset_description" class="form-control" readonly id="asset_description">
                                                    </div>
                                                    <div class="col-sm-3 ">
                                                        <b class="required">*</b> <label>Movement Date :</label> <br />
                                                        <div class="input-group">
                                                            <input type="text" name="date_movement" id="date_movement" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Movement" data-error-msg="Please select a movement date." required>
                                                             <span class="input-group-addon">
                                                                 <i class="fa fa-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <b class="required">*</b><label>Present Location:</label> <br />
                                                            <select id="cbo_location_from" name="location_id_from" class="form-control" style="width: 100% !important;" required data-error-msg="Move from Location is required.">
                                                                <!-- <option value="0">[ Add New Location ]</option> -->
                                                                <?php foreach($locations as $location) { ?>
                                                                    <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                                                                <?php } ?>
                                                            </select><br>   
                                                    </div>                      
                                                    <div class="col-sm-3 ">
                                                        <b class="required">*</b> <label>Move To :</label> <br />
                                                            <select id="cbo_location_to" name="location_id_to" class="form-control" style="width: 100% !important;" required data-error-msg="Move to Location is required.">
                                                                <!-- <option value="0">[ Add New Location ]</option> -->
                                                                <?php foreach($locations as $location) { ?>
                                                                    <option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
                                                                <?php } ?>
                                                            </select><br>   
                                                    </div>
                                                    <div class="col-sm-3 ">
                                                        <b class="required">*</b> <label>Status</label> <br />
                                                            <select id="cbo_status" name="asset_status_id" class="form-control" style="width: 100% !important;" required="" data-error-msg="Status is required">
                                                                <!-- <option value="0">[ Add New Location ]</option> -->
                                                                <?php foreach($statuses as $status) { ?>
                                                                    <option value="<?php echo $status->asset_status_id; ?>"><?php echo $status->asset_property_status; ?></option>
                                                                <?php } ?>
                                                            </select><br>   
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Document No (Auto):</label> <br />
                                                        <input type="text" disabled="" value="AM-YYYYMMDD-XXXX" placeholder="AM-YYYYMMDD-XXXX" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Remarks:</label> <br />
                                                        <textarea class="form-control" name="remarks"></textarea>
                                                    </div>                      

                                                </div>
                                                </form>
                                                </div>

                                                <div class="panel-footer">
                                                    <button id="btn_save" class="btn btn-primary">Save</button>
                                                    <button id="btn_cancel" class="btn btn-default">Cancel</button>
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

            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
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
                    </div>
                </div>
            </div><!---modal-->

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

<div id="modal_asset_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Fixed Assets</h2>
            </div>
            <div class="modal-body">
                <table id="tbl_asset_list" class="table table-striped" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th></th>
                        <th>Asset Code</th>
                        <th>Asset Description</th>
                        <th>Present Location</th>
                        <th>Present Status</th>
                        <th>Date</th>
                        <th>Record</th>
                        <th><center>Action</center></th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button id="cancel_modal" class="btn btn-default" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button> -->
            </div>
        </div>
    </div>
<div class="clearfix"></div>
</div><!---modal-->
<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>
<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!-- twitter typehead -->
<script src="assets/plugins/twittertypehead/handlebars.js"></script>
<script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.bundle.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>
<!-- touchspin -->
<script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboLocationFrom; var _cboLocationTo; var _cboStatus;

    var initializeControls=function(){
        dt=$('#tbl_asset_move').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
             "order": [[ 7, "desc" ]],
            "ajax" : "Asset_movement/transaction/list",
            "language" : {
                "searchPlaceholder": "Search"
            },
            "columns": [
                { targets:[0],data: "asset_no" },
                { targets:[1],data: "asset_code" },
                { targets:[2],data: "asset_description" },
                { targets:[3],data: "date_movement" },
                { targets:[4],data: "asset_property_status" },
                { targets:[5],data: "remarks" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                },
                { targets:[7],data: "asset_movement_id", visible:false },

            ]
        });

        dtlist=$('#tbl_asset_list').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
                "order": [[ 8, "ASC" ]],
            "ajax" : {
                "url" : "Asset_movement/transaction/list-with-status",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {

                        });
                    }
            }, 
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "asset_code" },
                { targets:[2],data: "asset_description" },
                { targets:[3],data: "location_name" },
                { targets:[4],data: "asset_property_status" },
                { targets:[5],data: "date_movement" },
                {  targets:[6],data: null,
                    render: function (data, type, full, meta){
                        var _attribute='';
                        //console.log(data.is_email_sent);
                        if(data.is_acquired=="1"){
                            _attribute='Acquired';
                        }else{
                            _attribute='Moved';
                        }

                        return _attribute;
                    }
                },
                {
                    targets:7,
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="choose_asset" style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Choose Asset"><i class="fa fa-check"></i></button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                },
                { targets:[8],data: "fixed_asset_id", visible:false }
            ]
        });


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
        _cboLocationFrom=$('#cbo_location_from').select2({
            placeholder: "Please select Location",
            // allowClear: true
        });

        _cboLocationTo=$('#cbo_location_to').select2({
            placeholder: "Please select Location",
            // allowClear: true
        });

        _cboStatus=$('#cbo_status').select2({
            placeholder: "Please select a status",
            // allowClear: true
        });

    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#link_browse').click(function(){
            $('#tbl_asset_list tbody').html('<tr><td colspan="7"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dtlist.ajax.reload( null, false );
            $('#modal_asset_list').modal('show');
        });

        $("#searchbox_fixed").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#tbl_asset_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dtlist.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                detailRows.splice( idx, 1 );
            }
            else {
                _selectRowObj=$(this).closest('tr');
                var d=dtlist.row(_selectRowObj).data();
                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Fixed_asset_management/transaction/asset-history?id="+ d.fixed_asset_id+'&type=preview',
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();
                    tr.addClass( 'details' );
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );





        $('#tbl_asset_move tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );

                row.child( format( row.data() ) ).show();

                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        $('#btn_new').click(function(){
            _txnMode="new";
            showList(false);
            clearFields($('#frm_asset_move'));
            _cboLocationFrom.select2('val',null);
            _cboLocationTo.select2('val',null);
            _cboStatus.select2('val',null);
            $('#heading_title_small').text('| Record New');
        });

        $('#tbl_asset_move tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.asset_movement_id;

            $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            _cboLocationFrom.select2('val',data.location_id_from);
            _cboLocationTo.select2('val',data.location_id_to);
            _cboStatus.select2('val',data.asset_status_id);
            $('#heading_title_small').text('| '+data.asset_no);
            showList(false);
        });

        $('#tbl_asset_move tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.asset_movement_id;

            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            removeMovement().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('#tbl_asset_list > tbody').on('click','button[name="choose_asset"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dtlist.row(_selectRowObj).data();
            _cboLocationFrom.select2('val',data.current_location_id);
            _cboLocationTo.select2('val',null);
            $('#asset_code').val(data.asset_code);
            $('#asset_description').val(data.asset_description);
            $('#fixed_asset_id').val(data.fixed_asset_id);
            _cboStatus.select2('val',data.current_status_id);
            $('#modal_asset_list').modal('hide');

        });

        $('#btn_cancel').click(function(){
            clearFields();
            showList(true);
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_asset_move'))){
                if(_txnMode=="new"){
                    createMovement().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields();
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    }); 
                }else{
                    updateMovement().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                        clearFields();
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });
    })();

    var validateRequiredFields=function(f){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){
                if($(this).is('select')){
                    if($(this).val()==0 || $(this).val()==null || $(this).val()==undefined || $(this).val()==""){
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
    var createMovement=function(){
        var _data=$('#frm_asset_move').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Asset_movement/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateMovement=function(){
        var _data=$('#frm_asset_move').serializeArray();
        _data.push({name : "asset_movement_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Asset_movement/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeMovement=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Asset_movement/transaction/delete",
            "data":{asset_movement_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_movement_list').show();
            $('#div_movement_fields').hide();
        }else{
            $('#div_movement_list').hide();
            $('#div_movement_fields').show();
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
    };

    var clearFields=function(){
        $('textarea,input:not(.date-picker)','#frm_asset_move').val('');
    };


});

</script>

</body>

</html>