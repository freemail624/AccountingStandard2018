<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->
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


    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
   <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">


    <style>

        .add_item, .remove_item{
            font-size: 18px!important;
            padding: 4px 8px!important;
        }

        #tbl_items td,#tbl_items tr,#tbl_items th{
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
        }


        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/print.png') no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url('assets/img/print.png') no-repeat center center;
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

        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .custom_frame{

            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .numeric{
            text-align: right;
        }



        @media screen and (max-width: 480px) {

            table{
                min-width: 800px;
            }

            .dataTables_filter{
                min-width: 800px;
            }

            .dataTables_info{
                min-width: 800px;
            }

            .dataTables_paginate{
                float: left;
                width: 100%;
            }
        }

        .boldlabel {
            font-weight: bold;
        }

        .modal-body {
            /*padding-left:0px !important;*/
        }

        .form-group {
            padding:0;
            margin:5px;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        textarea {
            resize: none;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

    </style>
</head>

<body class="animated-content"  style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">


<?php echo $_side_bar_navigation;

?>


<div class="static-content-wrapper white-bg">


<div class="static-content">
<div class="page-content"><!-- #page-content -->

<ol class="breadcrumb"  style="margin-bottom: 10px;">
    <li><a href="Dashboard">Dashboard</a> </li>
    <li><a href="Purchase_request_form">Purchase Request (Forms)</a></li>
</ol>


<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_user_list">
    <div class="panel panel-default">
<!-- 
        <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo"><div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;"><b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i> Purchase Request</b></div></a> -->


        <div class="panel-body table-responsive">
        <h2 class="h2-panel-heading">Purchase Request (Forms)<!-- <small> | <a href="assets/manual/purchasing/Purchase_Order_form.pdf" target="_blank" style="color:#999999;"><i class="fa fa-question-circle"></i></a></small> --></h2><hr>
            <table id="tbl_purchase_request_form" class="table table-striped" cellspacing="0" width="100%">
                <thead class="">
                <tr>
                    <th style="width: 5%;"></th>
                    <th style="width: 30%;">PRF#</th>
                    <th style="width: 25%;">Department</th>
                    <th style="width: 20%;">Approval Status</th>
                    <th style="width: 15%;"><center>Action</center></th>
                    <th style="width: 5%;"></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>

<div id="div_user_fields" style="display: none;">
    <div class="panel panel-default" >

    <div class="panel-body" >

        <div class="row" style="padding: 1%;margin-top: 0%;font-family: "Source Sans Pro", "Segoe UI", "Droid Sans", Tahoma, Arial, sans-serif">
        <form id="frm_purchase_request_form" role="form" class="form-horizontal">
            <h2 class="h2-panel-heading">PRF # : <span id="span_prf_no">PRF-XXXX</span></h2><hr>
            <div >
                <div class="row">
                    <div class="col-sm-5" >
                        <label><b class="required">*</b> Department :</label> <br />
                        <select name="department_id" id="cbo_departments" data-default="<?php echo $accounts[0]->default_department_id; ?>" data-error-msg="Department is required." required>
                            <option value="0">[ Create New Department ]</option>
                            <?php foreach($departments as $department){ ?>
                                <option value="<?php echo $department->department_id; ?>" data-default-cost="<?php echo $department->default_cost; ?>" data-delivery-address="<?php echo $department->delivery_address;  ?>"><?php echo $department->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3 col-sm-offset-4">
                        <label>PRF # :</label> <br />
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-code"></i>
                            </span>
                            <input type="text" name="prf_no" class="form-control" placeholder="PRF-YYYYMMDD-XXX" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div>
    <form id="frm_items">
        <div class="table-responsive">
            <table id="tbl_items" class="table-striped table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Qty</th>
                        <th style="width: 65%;">Description</th>
                        <th style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="prf_qty[]" class="form-control numeric" value="1"></td>
                        <td><input type="text" name="product_desc[]" class="form-control" required data-error-msg="Description is required."></td>
                        <td align="center">
                            <button type="button" class="btn btn-default add_item"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                            <button type="button" class="btn btn-default remove_item"><i class="fa fa-times-circle" style="color: red;"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    </div>

    <hr>

    <br />
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label control-label><strong>Remarks:</strong></label>
            <div class="col-lg-12" style="padding: 0%;">
                <textarea name="remarks" class="form-control" placeholder="Remarks" data-default="<?php echo $company->purchase_remarks; ?>"></textarea>
            </div>

        </div>
    </div>

</div>



<br />
<div class="panel-footer">
    <div class="row">
        <div class="col-sm-12">
            <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save Changes</button>
            <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
        </div>
    </div>
</div>


    <table id="table_hidden" class="hidden">
        <tr>
            <td><input type="text" name="prf_qty[]" class="form-control numeric" value="1"></td>
            <td><input type="text" name="product_desc[]" class="form-control" required data-error-msg="Description is required."></td>
            <td align="center">
                <button type="button" class="btn btn-default add_item"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                <button type="button" class="btn btn-default remove_item"><i class="fa fa-times-circle" style="color: red;"></i></button>
            </td>
        </tr>
    </table>


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
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_new_department" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>New Department</h4>

            </div>


            <div class="modal-body">

                <form id="frm_department">
                    <div class="row">
                        <div class="col-md-12" style="margin-left: 10px;">

                            <div class="form-group">
                                <label>* Department :</label>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                    <input type="text" name="department_name" class="form-control" placeholder="Department" data-error-msg="Department name is required." required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Department Description :</label>
                                <textarea name="department_desc" class="form-control" placeholder="Department Description"></textarea>
                            </div>

                        </div>
                    </div>
                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_new_department" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>

                <button id="btn_close_new_department" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>

            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_confirmation_close" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>Confirm closing of PRF</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes_close" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_purchase_order_form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="padding: 5px !important;">
                <h2 style="color:white; padding-left: 10px;">Purchase Request (Form)</h2>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="overflow: scroll; width: 100%;">
                    <div id="purchase_order_form">
                    </div>
                </div>
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


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>




<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>




<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>



<!-- twitter typehead -->
<script src="assets/plugins/twittertypehead/handlebars.js"></script>
<script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

<!-- touchspin -->
<script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>


<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>




$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj;
    var _cboDepartments; var _defCostType; var products; var _line_unit; var changetxn;

    var oTableItems={
        qty : 'td:eq(0)',
        product: 'td:eq(1)',
        action : 'td:eq(2)'
    };

    var initializeControls=function(){

        dt=$('#tbl_purchase_request_form').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 5, "desc" ]],
            "ajax" : "Purchase_request_form/transaction/list",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "prf_no" },
                { targets:[2],data: "department_name" },
                { targets:[3],data: "approval_status" },
                {
                    sClass:"text-left", targets:[4],data: null,
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                        var btn_mark_as_closed='<button class="btn btn-warning btn-sm" name="mark_as_closed" style="" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-times"></i> </button>';

                        // if (data.order_status_id == 1  || data.order_status_id == 3){
                        //     return btn_edit+'&nbsp;&nbsp;'+btn_trash+'&nbsp;&nbsp;';
                        // }else{
                            return '<center>'+btn_edit+'&nbsp;&nbsp;'+btn_trash+'</center>';
                        // }

                    }
                },
                { targets:[5],data: "purchase_request_form_id",visible:false }
            ]
        });

        var createToolBarButton=function(){
            var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Request (Form)" >'+
                '<i class="fa fa-plus"></i> New Request (Form)</button>';
            $("div.toolbar").html(_btnNew);
        }();

        $('.numeric').autoNumeric('init');

        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Please select department.",
            allowClear: false
        });

        _cboDepartments.select2('val',null);

    }();




    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_purchase_request_form tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/prf/"+ d.purchase_request_form_id,
                }).done(function(response){
                    $("#purchase_order_form").html(response);
                    $("#modal_purchase_order_form").modal('show');
                });
            }
        } );

        $('#btn_new').click(function(){
            _txnMode="new";
            $('#span_prf_no').html("PRF-XXXX");
            clearFields($('#frm_purchase_request_form'));
            $('#cbo_departments').select2('val', $('#cbo_departments').data('default') );
            $('textarea[name="remarks"]').val($('textarea[name="remarks"]').data('default'));

            $('#tbl_items > tbody').html('');
            $('#tbl_items > tbody').append(newRowItem({
                prf_qty : '1.00',
                product_desc : ''
            }));
            reInitializeNumeric();
            showList(false);
        });

        $('#btn_create_new_department').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_department'))){
                var data=$('#frm_department').serializeArray();
                createDepartment().done(function(response){
                    showNotification(response);
                    $('#modal_new_department').modal('hide');

                    var _department=response.row_added[0];
                    $('#cbo_departments').append('<option value="'+_department.department_id+'" data-tax-type="'+_department.department_id+'" selected>'+_department.department_name+'</option>');
                    $('#cbo_departments').select2('val',_department.department_id);
                    $('#cbo_tax_type').select2('val',_department.tax_type_id);
                    clearFields($('#modal_new_department'));

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#tbl_purchase_request_form tbody').on('click','button[name="edit_info"]',function(){

            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.purchase_request_form_id;

                $('#span_prf_no').html(data.prf_no);

                if(getFloat(data.order_status_id)>1){
                    showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot edit purchase request (Form) that is already been received."});
                    return;
                }

                $('input,textarea').each(function(){
                    var _elem=$(this);
                    $.each(data,function(name,value){
                        if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                            _elem.val(value);
                        }
                    });
                });

                $('#cbo_departments').select2('val',data.department_id);

                $.ajax({
                    url : 'Purchase_request_form/transaction/items/'+data.purchase_request_form_id,
                    type : "GET",
                    cache : false,
                    dataType : 'json',
                    processData : false,
                    contentType : false,
                    beforeSend : function(){
                        $('#tbl_items > tbody').html('<tr><td align="center" colspan="3"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                    },
                    success : function(response) {
                        var rows=response.data;
                        $('#tbl_items > tbody').html('');

                        $.each(rows,function(i,value){
                        
                            $('#tbl_items > tbody').append(newRowItem({
                                prf_qty : value.prf_qty,
                                product_desc : value.product_desc
                            }));
                        });
                        reInitializeNumeric();

                    }
                });

                showList(false);

        });

        $('#tbl_items tbody').on('click','button.add_item',function(){
            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter($('#tbl_items').find('tbody > tr:last'));
            reInitializeNumeric();
        });

        $('#tbl_items tbody').on('click','button.remove_item',function(){
            var oRow=$('#tbl_items').find('tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals();

        });

        $('#tbl_purchase_request_form tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();

            if(data.order_status_id != '1' ){
                showNotification({title:"Invalid",stat:"error",msg:"Only Open Purchase Request (Form) can be Deleted."});
            }else {
                _selectedID=data.purchase_request_form_id;
                $('#modal_confirmation').modal('show');
            }

        });

        $('#tbl_purchase_request_form tbody').on('click','button[name="mark_as_closed"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.purchase_request_form_id;

            $('#modal_confirmation_close').modal('show');
        });


        $('#btn_yes').click(function(){
            removePurchaseRequestForm().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }

            });
        });

        $('#btn_yes_close').click(function(){
            MarkRecordAsClosed().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                }

            });
        });

        $('#btn_cancel').click(function(){
            showList(true);
        });

        $('#btn_close_new_department').click(function() {
            $('#modal_new_department').modal('hide');
        });


        $('#btn_save').click(function(){

            if(validateRequiredFields($('#frm_purchase_request_form'))){
                if(validateRequiredFields($('#frm_items'))){
                    if(_txnMode=="new"){
                        createPurchaseRequestForm().done(function(response){
                            showNotification(response);

                            if(response.stat == 'success'){
                                dt.row.add(response.row_added[0]).draw();
                                clearFields($('#frm_purchase_request_form'));
                                showList(true);
                                showSpinningProgress($('#btn_save'));
                            }

                        }).always(function(){
                        });
                    }else{
                        updatePurchaseRequestForm().done(function(response){
                            showNotification(response);

                            if(response.stat == 'success'){
                                dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                                clearFields($('#frm_purchase_request_form'));
                                showList(true);
                                showSpinningProgress($('#btn_save'));
                            }

                        }).always(function(){
                        });
                    }
                }
            }

        });


        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotal();
        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });

        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            /*$('#div_img_product').hide();
             $('#div_img_loader').show();*/
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
            console.log(_files);
            $.ajax({
                url : 'Suppliers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('img[name="img_user"]').attr('src',response.path);
                }
            });
        });


    })();


    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

            if($(this).is('select')){
                if($(this).select2('val')==0||$(this).select2('val')==null){
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

    var getproduct=function(){
       return $.ajax({
           "dataType":"json",
           "type":"POST",
           "url":"products/transaction/parent-list",
           "beforeSend": function(){
                countproducts = products.local.length;
                if(countproducts > 100){
                    showNotification({title:"Please Wait !",stat:"info",msg:"Refreshing your Products List."});
                }
           }
      });
    };


    var createDepartment=function(){
        var _data=$('#frm_department').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Departments/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_new_department'))
        });
    };

    var createSupplier=function() {
        var _data=$('#frm_suppliers_new').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Suppliers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_new_supplier'))
        });
    };

    var createPurchaseRequestForm=function(){
        var _data=$('#frm_purchase_request_form,#frm_items').serializeArray();
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val() });
        
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchase_request_form/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updatePurchaseRequestForm=function(){
        var _data=$('#frm_purchase_request_form,#frm_items').serializeArray();
        _data.push({name : "purchase_request_form_id" ,value : _selectedID});
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val() });

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchase_request_form/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var MarkRecordAsClosed=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchase_request_form/transaction/close",
            "data":{purchase_request_form_id : _selectedID}
        });
    };    

    var removePurchaseRequestForm=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchase_request_form/transaction/delete",
            "data":{purchase_request_form_id : _selectedID}
        });
    };


    var showList=function(b){
        if(b){
            $('#div_user_list').show();
            $('#div_user_fields').hide();
        }else{
            $('#div_user_list').hide();
            $('#div_user_fields').show();
        }
    };

    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };



    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('input:first').focus();
    };


    function format ( d ) {
    };

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode === 8 || event.keyCode === 46
            || event.keyCode === 37 || event.keyCode === 39) {
            return true;
        }
        else if ( key < 48 || key > 57 ) {
            return false;
        }
        else return true;
    };

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var newRowItem=function(d){
        return '<tr>'+
        '<td><input type="text" name="prf_qty[]" class="form-control numeric" value="'+ accounting.formatNumber(d.prf_qty,2) +'"></td>'+
        '<td ><input name="product_desc[]" type="text" class="form-control" value="'+ d.product_desc +'" required data-error-msg="Description is required."></td>'+
        '<td align="center">'+
            '<button type="button" class="btn btn-default add_item"><i class="fa fa-plus-circle" style="color: green;"></i></button>'+
            '<button type="button" class="btn btn-default remove_item"><i class="fa fa-times-circle" style="color: red;"></i></button>'
        '</td>'+
        '</tr>';
    };

    _cboDepartments.on("select2:select", function (e) {

        var i=$(this).select2('val');

        if(i==0){
            _cboDepartments.select2('val',null)
            $('#modal_new_department').modal('show');
        }else{
            var obj_department=$('#cbo_departments').find('option[value="'+i+'"]');
            _defCostType=obj_department.data('default-cost');
        }

    });

    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init',{mDec: 2});
        $('.number').autoNumeric('init', {mDec:0});
    };

});


</script>
</body>
</html>