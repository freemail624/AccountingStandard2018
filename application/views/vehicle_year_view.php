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
                        <li><a href="vehicle_years">Vehicle Year</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_vehicle_year_list">
                                        <div class="panel panel-default">
<!--                                             <div class="panel-heading">
                                     
                                                <b style="color: white; font-size: 12pt;"><i style="color: #ffce3a;" class="ti ti-layout-accordion-merged"></i>&nbsp; Departments</b>
                                            </div> -->
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Vehicle Year</h2><hr>
                                                <table id="tbl_vehicle_year" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Vehicle Year</th>
                                                        <th>Remarks</th>
                                                        <th><center>Action</center></th>
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

            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
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
            <div id="modal_new_vehicle_year" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #2ecc71">
                             <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                             <h2 id="vehicle_year_title" class="modal-title" style="color:white;"></h2>
                        </div>
                        <div class="modal-body">
                            <form id="frm_vehicle_year" role="form" class="form-horizontal">
                                <div class="row" style="margin: 1%;">
                                    <div class="col-lg-12">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class=""><b> * </b> Vehicle Year :</label>
                                            <input type="text" placeholder="Vehicle Year" class="form-control" name="vehicle_year" data-error-msg="Vehicle Year is required!" id="vehicle_year" required >
                                        </div>
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="">Remarks :</label>
                                            <textarea name="remarks" placeholder="Remarks" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_save" type="button" class="btn btn-primary">Save</button>
                            <button id="btn_cancel" type="button" class="btn btn-default">Cancel</button>
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


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj;

    var initializeControls=function(){
        dt=$('#tbl_vehicle_year').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : "vehicle_years/transaction/list",
            "language" : {
                "searchPlaceholder": "Search Year"
            },
            "columns": [
                { targets:[0],data: "vehicle_year" },
                { targets:[1],data: "remarks" },
                {
                    targets:[2],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                }
            ]
        });

        var createToolBarButton=function(){

            var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Vehicle Year" >'+

                '<i class="fa fa-plus"></i> New Vehicle Year</button>';
            $("div.toolbar").html(_btnNew);
        }();
    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#frm_vehicle_year'));
            $('#vehicle_year_title').text('New Vehicle Year');
            $('#modal_new_vehicle_year').modal('show');
        });

        $('#tbl_vehicle_year tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.vehicle_year_id;

            $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });
            $('#vehicle_year_title').text('Edit Vehicle Year');
            $('#modal_new_vehicle_year').modal('show');
            setTimeout(function (){
                $('form').find('input:first').focus();
            }, 500);            
        });

        $('#tbl_vehicle_year tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.vehicle_year_id;

            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            removeVehicleYear().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('#btn_cancel').click(function(){
            clearFields();
            $('#modal_new_vehicle_year').modal('hide');
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields()){
                if(_txnMode=="new"){
                    createVehicleYear().done(function(response){
                        showNotification(response);

                        if(response.stat == 'success'){
                            dt.row.add(response.row_added[0]).draw();
                            clearFields();
                            $('#modal_new_vehicle_year').modal('hide');
                        }

                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateVehicleYear().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                            $('#modal_new_vehicle_year').modal('hide');
                        }

                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }
            }
        });

        $('form').on('keypress','input',function(evt){
            if(evt.keyCode==13){
                evt.preventDefault();
                $('#btn_save').trigger('click');
            }
        });        

    })();

    var validateRequiredFields=function(){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required]','#frm_vehicle_year').each(function(){
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

    var createVehicleYear=function(){
        var _data=$('#frm_vehicle_year').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"vehicle_years/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateVehicleYear=function(){
        var _data=$('#frm_vehicle_year').serializeArray();
        _data.push({name : "vehicle_year_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"vehicle_years/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeVehicleYear=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"vehicle_years/transaction/delete",
            "data":{vehicle_year_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_vehicle_year_list').show();
            $('#div_vehicle_year_fields').hide();
        }else{
            $('#div_vehicle_year_list').hide();
            $('#div_vehicle_year_fields').show();
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
        $('input[required],textarea','#frm_vehicle_year').val('');
        setTimeout(function (){
            $('form').find('input:first').focus();
        }, 500);
    };

});

</script>
</body>
</html>