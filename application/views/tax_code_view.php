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
                                <li><a href="Tax_code">Tax Code</a></li>
                            </ol>

                            <div class="container-fluid">
                                <div data-widget-group="group1">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div_category_list">
                                                <div class="panel panel-default">
                                                    <div class="panel-body table-responsive">
                                                    <h2 class="h2-panel-heading">Tax Code</h2><hr>
                                                        <table id="tbl_tax_code" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead class="">
                                                                <tr>
                                                                    <th width="5%">Tax Type</th>
                                                                    <th>Description</th>
                                                                    <th>ATC</th>
                                                                    <th>Tax Rate</th>
                                                                    <th>Type</th>
                                                                    <th width="10%"><center>Action</center></th>
                                                                    <th>ID</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- <div class="panel-footer"></div> -->
                                                </div>
                                            </div>

                                            <!-- <div id="div_tax_code_fields" style="display: none;">
                                                <div class="panel panel-default" style="border-top: 3px solid #2196f3;">
                                                   <!--  <div class="panel-heading">
                                                        <h2>Category Information</h2>
                                                        <div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body"}'></div>
                                                    </div> -->

                                                    <!-- <div class="panel-body">
                                                    <h2>Categories</h2>
                                                        <form id="frm_tax_code" role="form" class="form-horizontal row-border">
                                                            <div class="form-group">
                                                                <label class="col-md-2 col-md-offset-2 control-label"><strong>* Category Name :</strong></label>
                                                                <div class="col-md-4">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-users"></i>
                                                                        </span>
                                                                        <input type="text" name="category_name" class="form-control" placeholder="Category Name" data-error-msg="category name is required!" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 col-md-offset-1 control-label"><strong>* Category Description :</strong></label>
                                                                <div class="col-md-4">
                                                                    <textarea name="category_desc" class="form-control" data-error-msg="Category Description is required!" placeholder="Description" required></textarea>
                                                                </div>
                                                            </div><br/>
                                                        </form>
                                                    </div>

                                                    <div class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-sm-offset-4">
                                                                <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;""><span class=""></span>  Save Changes</button>
                                                                <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .container-fluid -->

                    </div> <!-- #page-content -->
                </div>

                <div id="modal_new_taxcode" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2ecc71;">
                                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 id="tax_code_title" class="modal-title" style="color: #ecf0f1;"><span id="modal_mode"></span></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="frm_tax_code" role="form">
                                        <div class="">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 control-label">
                                                        <strong><B> * </B> Tax Type :</strong>
                                                    </label>
                                                    <div class="col-xs-12 col-md-8">
                                                        <select name="tax_type_id" id="tax_type_id" placeholder="Tax Type" style="width: 100%;">
                                                            <option value="">Select Tax Type</option>
                                                            <?php foreach ($tax_types as $tax_type) { ?>
                                                                <option value="<?php echo $tax_type->tax_type_id; ?>"><?php echo $tax_type->tax_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 control-label">
                                                        <strong><B> * </B> Business Type :</strong>
                                                    </label>
                                                    <div class="col-xs-12 col-md-8">
                                                        <select name="business_type_id" id="business_type_id" placeholder="Business Type" style="width: 100%;">
                                                            <option value="">Select Business Type</option>
                                                            <?php foreach ($business_types as $business_type) { ?>
                                                                <option value="<?php echo $business_type->business_type_id; ?>"><?php echo $business_type->business_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><strong><B> * </B> Description :</strong></label>
                                                    <div class="col-md-8">
                                                        <textarea name="description" class="form-control" data-error-msg="Description is required!" placeholder="Description" required rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><strong><B> * </B> Tax Rate :</strong></label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="numeric form-control" name="tax_rate" data-error-msg="Tax Rate is required!" placeholder="Tax Rate" required style="width: 50%;">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><strong><B> * </B> ATC :</strong></label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="atc" data-error-msg="ATC Code is required!" placeholder="ATC Code" required style="width: 50%;">
                                                    </div>
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

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>

    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script>

    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboTaxType; var _cboBusinessType;

        var initializeControls=function(){
            dt=$('#tbl_tax_code').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "order": [[ 6, "asc" ]],
                "ajax" : "Tax_code/transaction/list",
                "language": {
                    "searchPlaceholder": "Search"
                },
                "columns": [

                    { targets:[0],data: "tax_type" },
                    { targets:[1],data: "description" },
                    { targets:[2],data: "atc" },
                    { targets:[3],data: "tax_rate" },
                    { targets:[4],data: "business_type" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                        }
                    },
                    {  visible:false,targets:[6],data: "atc_id" }
                ]
            });

            var createToolBarButton=function(){
                var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Tax Code" >'+
                    '<i class="fa fa-plus"></i> New Tax Code</button>';
                $("div.toolbar").html(_btnNew);
            }();

            $('.numeric').autoNumeric('init');

            _cboTaxType = $('#tax_type_id').select2({
                placeholder: "Please select tax type.",
                allowClear: true
            });

            _cboTaxType.select2('val',null);

            _cboBusinessType = $('#business_type_id').select2({
                placeholder: "Please select business type.",
                allowClear: true
            });

            _cboBusinessType.select2('val',null);            

        }();

        var bindEventHandlers=(function(){
            var detailRows = [];

            $('#tbl_tax_code tbody').on( 'click', 'tr td.details-control', function () {
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
                clearFields();
                $('#tax_code_title').text('New Tax Code');
                $('#modal_new_taxcode').modal('show');
                //showList(false);
            });

            $('#tbl_tax_code tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.atc_id;

                $('input,textarea').each(function(){
                    var _elem=$(this);
                    $.each(data,function(name,value){
                        if(_elem.attr('name')==name){
                            _elem.val(value);
                        }
                    });
                });

                _cboTaxType.select2('val',data.tax_type_id);
                _cboBusinessType.select2('val',data.business_type_id);       

                $('#tax_code_title').text('Edit Tax Code');
                $('#modal_new_taxcode').modal('show');
                //showList(false);
            });

            $('#tbl_tax_code tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.atc_id;
                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeTaxCode().done(function(response){
                    showNotification(response);
                    dt.row(_selectRowObj).remove().draw();
                });
            });

            $('#btn_cancel').click(function(){
                $('#modal_new_taxcode').modal('hide');
            });

            $('#btn_save').click(function(){
                if(validateRequiredFields()){
                    if(_txnMode=="new"){
                        createTaxCode().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields();
                            $('#modal_new_taxcode').modal('hide');

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateTaxCode().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                            showList(true);
                            $('#modal_new_taxcode').modal('hide');
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                }
            });
        })();

        var validateRequiredFields=function(){
            var stat=true;

            $('div.form-group').removeClass('has-error');
            $('input[required],textarea','#frm_tax_code').each(function(){
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    stat=false;
                    return false;
                }
            });
            return stat;
        };

        var createTaxCode=function(){
            var _data=$('#frm_tax_code').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Tax_code/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateTaxCode=function(){
            var _data=$('#frm_tax_code').serializeArray();
            _data.push({name : "atc_id" ,value : _selectedID});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Tax_code/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeTaxCode=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Tax_code/transaction/delete",
                "data":{atc_id : _selectedID}
            });
        };

        var showList=function(b){
            if(b){
                $('#div_category_list').show();
                $('#div_tax_code_fields').hide();
            }else{
                $('#div_category_list').hide();
                $('#div_tax_code_fields').show();
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
            $('input[required],textarea','#frm_tax_code').val('');
            $('form').find('input:first').focus();
        };

        function format ( d ) {
            return '<br /><table style="margin-left:10%;width: 80%;">' +
            '<thead>' +
            '</thead>' +
            '<tbody>' +
            '<tr>' +
            '<td>Category Name : </td><td><b>'+ d.category_name+'</b></td>' +
            '</tr>' +
            '<tr>' +
            '<td>Category Description : </td><td>'+ d.category_desc+'</td>' +
            '</tr>' +
            '</tbody></table><br />';
        };
    });

    </script>

    </body>

</html>