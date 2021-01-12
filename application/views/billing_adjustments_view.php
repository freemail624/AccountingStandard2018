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
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
   <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">
    <style>
        #tbl_items td,#tbl_items tr,#tbl_items th{
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
        }
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
        #tbl_adjustments_filter{
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
        body.modal-open {
            overflow: visible;
        }
        .btn {
            padding: 0px 6px!important;
            
        }
        .btn-sm {
            font-size: 9px!important;
        }
        .right-align{
            text-align: right;
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
    <li><a href="Billing_adjustments">Billing Adjustments</a></li>
</ol>

<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_user_list">
    <div class="panel panel-default">
        <div class="panel-body table-responsive" style="width: 100%;overflow-x: hidden;">
        <h2 class="h2-panel-heading">Billing Adjustments</h2><hr>
        <div class="row">
            <div class="col-sm-2">
                Approval Status: <br>
                <select id="cbo_approval">
                    <option value="1">Approved</option>
                    <option value="0">Pending</option>
                    <option value="2">Disapproved</option>
                </select>
            </div>
            <div class="col-sm-3">
                Department :<br />
                <select id="cbo_departments_review" class="selectpicker show-tick form-control" data-live-search="true">
                        <option value="0"> All Departments</option>
                    <?php foreach($departments as $department){ ?>
                        <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-3">Search:<br><input type="text" class="form-control" id="searchbox_adjustment_table"> </div>
        </div><br>
            <table id="tbl_adjustments" class="table table-striped" cellspacing="0" width="100%">
                <thead class="">
                <tr>
                    <th></th>
                    <th>Adjustment #</th>
                    <th>Adjustment Type</th>
                    <th>Tenant</th>
                    <th>Billing Period</th>
                    <th>Charge</th>
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

      <div id="modal_confirmation_approval" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                      <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Approval Confirmation</h4>

                  </div>

                  <div class="modal-body">
                  <table width="100%" class="table table-striped" style="font-size: 12px;margin-bottom: 0px;">
                      <tbody>
                          <tr>
                              <td style="width: 30%;"><b>Adujstment No: </b></td>
                              <td id="adjustment_no"></td>
                          </tr>
                          <tr>
                              <td style="width: 30%;"><b>Lessee / Tenant: </b></td>
                              <td id="lessee_or_tenant"></td>
                          </tr>
                          <tr>
                              <td><b>Approved By: </b></td>
                              <td id=""><?php echo $this->session->user_fullname; ?></td>
                          </tr>
<!--                           <tr>
                              <td><b>Approval Remarks:</b></td>
                              <td id=""><textarea id="approval_remarks" class="form-control" placeholder="Optional Remarks"></textarea></td>
                          </tr> -->
                      </tbody>
                  </table>
                  </div>
            <div class="modal-footer">
                <button id="btn_yes_approval" type="button" class="btn btn-success" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Approve</button>

            </div>
              </div>
          </div>
      </div>
      <div id="modal_confirmation_disapproval" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                      <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Disapproval Confirmation</h4>

                  </div>

                  <div class="modal-body">
                  <table width="100%" class="table table-striped" style="font-size: 12px;margin-bottom: 0px;">
                      <tbody>
                          <tr>
                              <td style="width: 30%;"><b>Adujstment No: </b></td>
                              <td id="adjustment_no_dis"></td>
                          </tr>
                          <tr>
                              <td style="width: 30%;"><b>Lessee / Tenant: </b></td>
                              <td id="lessee_or_tenant_dis"></td>
                          </tr>
                          <tr>
                              <td><b>Disapproved By: </b></td>
                              <td id=""><?php echo $this->session->user_fullname; ?></td>
                          </tr>
<!--                           <tr>
                              <td><b>Disapproval Remarks:</b></td>
                              <td id=""><textarea id="disapproval_remarks" class="form-control" placeholder="Optional Remarks"></textarea></td>
                          </tr> -->
                      </tbody>
                  </table>
                  </div>
            <div class="modal-footer">
                <button id="btn_yes_disapproval" type="button" class="btn btn-warning" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Disapprove</button>

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
    var dt; var _selectedID; var _selectRowObj;  var _cboApproval; var _cboDepartments;

    var initializeControls=function(){
        _cboApproval=$('#cbo_approval').select2({
            placeholder: "",
            minimumResultsForSearch : -1,
            allowClear: false
        });

        _cboApproval.select2('val',0);

        _cboDepartments=$('#cbo_departments_review').select2({
            placeholder: "Select Department",
            allowClear: false
        });

        dt=$('#tbl_adjustments').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "ajax" : {
                "url":"Billing_adjustments/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                    return $.extend( {}, d, {
                            "is_approved":_cboApproval.val(),
                            "department_id":_cboDepartments.val()

                        });
                    }
            }, 
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "adjustment_no" },
                { targets:[2],data: "adjustment_type" },
                { targets:[3],data: "trade_name" },
                { targets:[4],data: "period_desc" },
                { targets:[5],data: "charge_desc" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        //alert(full.purchase_order_id);

                        var btn_approved='<button class="btn btn-success btn-sm" name="mark_approved" title="Approve"><i class="fa fa-check" style="color: white;font-size:9px;"></i> <span class=""></span></button>';
                        var btn_disapproved='<button class="btn btn-primary btn-sm" name="mark_disapproved" title="Disapprove"><i class="fa fa-times" style="color: white;"></i> <span class=""></span></button>';

                        if(_cboApproval.val() != 0) { // APPROVED
                            return '<center></center>';
                        }else {
                            return '<center>'+btn_approved+'&nbsp;'+btn_disapproved+'</center>';
                        }

                    }
                }
            ]
        });

    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_adjustments tbody').on( 'click', 'tr td.details-control', function () {
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
                    row.child( format( row.data() ),'no-padding' ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }

            }
        } );


        _cboApproval.on("select2:select", function (e) {
            $('#tbl_adjustments').DataTable().ajax.reload()
        });

        _cboDepartments.on("select2:select", function (e) {
            $('#tbl_adjustments').DataTable().ajax.reload()
        });

        $("#searchbox_adjustment_table").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });
        //APPROVAL
        $('#tbl_adjustments > tbody').on('click','button[name="mark_approved"]',function(){ // MAIN TABLE
            _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.adjustment_id;
            $('#lessee_or_tenant').text(data.trade_name);
            $('#adjustment_no').text(data.adjustment_no);
            $('#approval_remarks').val('');
            $('#modal_confirmation_approval').modal('show');


        });

        $('#btn_yes_approval').click(function(){
            approveAdjustment().done(function(response){
            showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                    $('#modal_confirmation_approval').modal('hide');
                }
            });
        });
         // DISAPPROVAL 
        $('#tbl_adjustments > tbody').on('click','button[name="mark_disapproved"]',function(){ // MAIN TABLE
            _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.adjustment_id;
            $('#lessee_or_tenant_dis').text(data.trade_name);
            $('#adjustment_no_dis').text(data.adjustment_no);
            $('#disapproval_remarks').val('');
            $('#modal_confirmation_disapproval').modal('show');
        });


        $('#btn_yes_disapproval').click(function(){
         disapproveAdjustment().done(function(response){
            showNotification(response);
            if(response.stat=="success"){
                dt.row(_selectRowObj).remove().draw();
                $('#modal_confirmation_disapproval').modal('hide');
            }

        });
      });

    })(); // END OF BIND EVENTS


    var approveAdjustment=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Billing_adjustments/transaction/mark-approved",
            "data":{adjustment_id : _selectedID, approval_remarks : $('#approval_remarks').val()}

        });
    };

    var disapproveAdjustment=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Billing_adjustments/transaction/mark-disapproved",
            "data":{adjustment_id : _selectedID, disapproval_remarks : $('#disapproval_remarks').val()}

        });
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


    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };


    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init',{mDec: 2});
        $('.number').autoNumeric('init', {mDec:0});
    };

    function format ( d ) {
        return '<table style="width: 100%;border:none!important;">' +
            '<tbody>' +
                '<tr>' +
                    '<td><b>Tenant :</b></td><td>'+ d.trade_name +'</td>' +
                    '<td></td><td></td>' +
                    '<td></td><td></td>' +
                    '<td><b>Adjustment # :</b></td><td>'+ d.adjustment_no+' - '+ d.adjustment_type +'</td>' +
                '</tr>' +
                '<tr>' +
                    '<td><b>Billing Period :</b></td><td>'+ d.period_desc +'</td>' +
                    '<td></td><td></td>' +
                    '<td></td><td></td>' +
                    '<td><b>Period Date :</b></td><td>'+ d.period_date +'</td>' +
                '</tr>' +
                '<tr>' +
                    '<td><b>Notes :</b></td><td colspan="7">'+ d.notes +'</td>' +
                '</tr>' +
            '</tbody>' +
        '</table><br>'+
        '<table style="width: 100%;border:none!important;">' +
            '<tbody>' +
                '<tr>' +
                    '<td><b>Charge Name</b> </td>' +
                    '<td class="right-align"><b>Rate</b> </td>' +
                    '<td class="right-align"><b>Reading</b> </td>' +
                    '<td class="right-align"><b>Total</b> </td>' +
                '</tr>' +
                '<tr>' +
                    '<td >'+ d.charge_desc +'</td>' +
                    '<td class="right-align">'+ accounting.formatNumber(d.adjustment_rate,2) +'</td>' +
                    '<td class="right-align">'+  accounting.formatNumber(d.adjustment_reading,2)  +'</td>' +
                    '<td class="right-align"><b>'+ accounting.formatNumber(d.amount,2)+'</b></td>' +
                '</tr>' +
            '</tbody>' +
        '</table><br><br><i>End of Adjustment for '+d.trade_name +'</i><hr>'
        ;
    };

});
</script>
</body>
</html>