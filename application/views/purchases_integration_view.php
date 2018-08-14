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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

    <style>

        .select2-container{
            min-width: 100%;
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

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        #tbl_pos_integration_filter 
        {
            display:none;
        }
        .right-align{ text-align: left; }
                .numeric{
            text-align: right;
            width: 60%;
        }

        .right-align{
            text-align: right;
        }
input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  padding: 10px;
}
    </style>

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Hotel_system">Purchases | Integration Control Panel</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Purchases | <small>Integration Control Panel</small></h2><hr>
                                <div class="row">
                                
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <div id="new-search-area" class="col-sm-3" style=""><br>
                                                <button type="button" id="btn_browse" style="width:200px;margin-bottom:5px;padding: 7px 2px 7px 2px!important;" class="btn btn-success">Upload A Text File</button>
                                                <input type="file" name="file_upload[]" accept=".jdev"  class="hidden" >
                                            </div>
                                            <div class="col-sm-3"><br>
                                             <button id="post_selected" type="button" class="btn-primary btn" style="width : 200px;padding: 7px 2px 7px 2px!important;text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> POST SELECTED</button>
                                                       <!--  <button type="button" id="total_day_transaction" style="width:200px;margin-bottom:5px;padding: 7px 2px 7px 2px!important;" class="btn btn-info">Total Day Transaction</button> -->
                                            </div>
                                            <div class="col-xs-12 col-md-3" style="margin-bottom: 10px;">
                                                <strong>Date :</strong>
                                                <div class="input-group">
                                                    <input id="txt_date" type="text" class="date-picker form-control" value="<?php echo date('m/d/Y'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="new-search-area" class="col-sm-3 col-md-3" style="float: right;">
                                             <strong>Search :</strong><br>
                                                <input type="text" id="searchbox" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                        <div class="col-sm-3">
                                        <input type="checkbox" id="selectall_" class="css-checkbox"><label class="css-label " for="selectall_" style="font-weight: normal;">SELECT ALL</label><br><br>
                                        </div>
                                        <div class="col-sm-3 ">
                                        
                                        </div>
                                         
                                         <form id='form_hotel'>
                                            <table id="tbl_pos_integration" class="table table-striped" width="100%" cellspacing="0">
                                                <thead class="">
                                                    <th style="width: 3%;"></th>
                                                    <th style="width: 5%;"></th>
                                                    <th>Invoice Number</th>
                                                    <th>Terms</th>
                                                    <th>External Ref No</th>
                                                    <th>Invoice Date</th>
                                                    <th>Supplier Name</th>
                                                    <th>Total Amount</th>
                                                    <th style="text-align: center;">Is Balance ?</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </form>

                                        </div>
                                        <i>Note: The System only allows 20 simultaneous journals to be posted at a time. Please be patient and wait for the posting to finish before refreshing the page.</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->
                <table id="table_hidden" class="hidden">
                    <tr>
                        <td>
                            <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Account.">
                                <?php foreach($accounts as $account){ ?>
                                    <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="text" name="memo[]" class="form-control"></td>
                        <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                        <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                        <td>
                            <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                            <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                        </td>
                    </tr>
                </table>

                </div> <!-- #page-content -->
            </div>

            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT Business Solutions</h6></li>
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

<!-- Select2-->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrar-select.min.js"></script>-->





<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>




<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
    var dt; var _cboDepartments; var dt_summary;


    var oTBJournal={
        "dr" : "td:eq(2)",
        "cr" : "td:eq(3)"
    };

    var oTFSummary={
        "dr" : "td:eq(1)",
        "cr" : "td:eq(2)"
    };



    var initializeControl=function(){
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        InitializeDataTable();

    }();

    var bindEventHandlers=function(){


    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };




    
    }();

    function InitializeDataTable() {
        dt=$('#tbl_pos_integration').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength":20,
            "language": {
                searchPlaceholder: "Search..."
            },
            "ajax": {
              "url":"Purchases_integration/transaction/list",
              "type":"GET",
              // "order": [[ 6, "desc" ]],
              "data":function (d) {
                return $.extend( {}, d, {
                    "aod": $('#txt_date').val()

                });
              }
            },
            "columns": [
                {
                    targets:[0],data : null,
                    render: function (data, type, full, meta){
                        return  '<input type="checkbox" name="post_id[]" value="'+data.purchase_integration_id+'">';
                    }
                },
                {
                    "targets": [1],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[2],data: "invoice_no" },
                { targets:[3],data: "terms" },
                { targets:[4],data: "external_ref_no" },
                { targets:[5],data: "date_invoice_format" },
                { targets:[6],data: "pos_supplier_name" },
                {sClass:'right-align', targets:[5],data: "total_amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                {
                    targets:[7],data: null,
                    render: function (data, type, full, meta){
                        var _attribute='';
                        //console.log(data.is_email_sent);
                        if(data.is_balance=="1"){
                            _attribute=' class="fa fa-check-circle" style="color:green;" ';
                        }else{
                            _attribute=' class="fa fa-times-circle" style="color:red;" ';
                        }

                        return '<center><i '+_attribute+'></i></center>';
                    }     
                }                   
                
            ]
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

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var reComputeTotals=function(tbl){
        var oRows=tbl.find('tbody tr');
        var _DR_amount=0.00; var _CR_amount=0.00;

        $.each(oRows,function(i,value){
            _DR_amount+=getFloat($(this).find(oTBJournal.dr).find('input.numeric').val());
            _CR_amount+=getFloat($(this).find(oTBJournal.cr).find('input.numeric').val());


        });



        tbl.find('tfoot tr').find(oTFSummary.dr).html('<b>'+accounting.formatNumber(_DR_amount,2)+'</b>');
        tbl.find('tfoot tr').find(oTFSummary.cr).html('<b>'+accounting.formatNumber(_CR_amount,2)+'</b>');

    };

    var bindEventHandlers=(function(){
        $('#txt_date').change(function(){
        $('#tbl_pos_integration').DataTable().ajax.reload()
        });

            var detailRows = [];


        $('#tbl_pos_integration tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Purchases_integration/transaction/invoice-for-review/"+ d.purchase_integration_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response,'no-padding' ).show();

                    reInitializeSpecificDropDown($('.cbo_supplier_list'));
                    reInitializeSpecificDropDown($('.cbo_department_list'));
                    reInitializeNumeric();

                    var tbl=$('#tbl_entries_for_review_'+ d.purchase_integration_id);
                    var parent_tab_pane=$('#journal_review_'+ d.purchase_integration_id);

                    reInitializeDropDownAccounts(tbl);
                    reInitializeChildEntriesTable(tbl);
                    reInitializeChildElements(parent_tab_pane);

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }


                });




            }
        } );

        $("#searchbox").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#post_selected').click(function(){

            var data=$("#form_hotel").serializeArray();
            showSpinningProgress($(this));
            console.log(data);
                $.ajax({
                    url : 'Purchases_integration/transaction/post_selected',
                    type : "POST",
                    data : data,
                    dataType : 'json',
                    success : function(response){
                        $('#tbl_pos_integration').DataTable().ajax.reload();
                        showNotification(response);
                        $('#selectall_').prop('checked', false);
                        showSpinningProgress($('#post_selected'));

                    }
                });

        });
        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });
        $('input[name="file_upload[]"]').change(function(event){
        var _files=event.target.files;
        var data=new FormData();
        $.each(_files,function(key,value){
            data.append(key,value);
        });
        console.log(_files);
        $.ajax({
            url : 'Purchases_integration/transaction/upload-trial',
            type : "POST",
            data : data,
            cache : false,
            dataType : 'json',
            processData : false,
            contentType : false,
            success : function(response){
                $('#tbl_pos_integration').DataTable().ajax.reload();
                showNotification(response);
            }
        });
    });
        $('#btn_finalize').click(function(){
            var _data= Array();
            _data.push({name : "txt_date" ,value : $('#txt_date').val() });
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Hotel_system/transaction/finalize",
                "data":_data
            }).done(function(response){
                    showNotification(response);
                    dt.clear().destroy();
                    InitializeDataTable();
                });
        });


        $('#total_day_transaction').click(function(){
            $('#total_day_transaction_modal').modal('show');
            $('#date_label').html($('#txt_date').val())
        });


            $('[id=selectall_]').click(function(event) {   
                    var btn=$(this); 
                if(this.checked) {
                    $('input[name="post_id[]"]').each(function() {
                        this.checked = true;                        
                    });
                }
                else {
                    $('input[name="post_id[]"]').each(function() {
                        this.checked = false;                        
                    });
                }
            });


    })();


     function reInitializeNumeric(){
            $('.numeric').autoNumeric('init');
        };


    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };


    function reInitializeDropDownAccounts(tbl){
        tbl.find('select.selectpicker').select2({
            placeholder: "Please select account.",
            allowClear: false
        });
    };


    function reInitializeSpecificDropDown(elem){
        elem.select2({
            placeholder: "Please select item.",
            allowClear: false
        });
    };
    var isBalance=function(opTable=null){
        var oRow; var dr; var cr;

        if(opTable==null){
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr==cr);
    };

    var reInitializeChildEntriesTable=function(tbl){

        var _oTblEntries=tbl.find('tbody');
        _oTblEntries.on('keyup','input.numeric',function(){
            var _oRow=$(this).closest('tr');

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{
                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }
            reComputeTotals(tbl);
        });



        //add account button on table
        tbl.on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter(tbl.find('tbody > tr:last'));

            reInitializeNumeric();
            reInitializeDropDownAccounts(tbl);

        });


        tbl.on('click','button.remove_account',function(){
            var oRow=tbl.find('tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals(tbl);

        });




    };

    var reInitializeChildElements=function(parent){
        var _dataParentID=parent.data('parent-id');
        var btn=parent.find('button[name="btn_finalize_journal_review"]');

        //initialize datepicker
        parent.find('input.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });


        parent.on('click','button[name="btn_finalize_journal_review"]',function(){

            var _curBtn=$(this);
            if(isBalance('#tbl_entries_for_review_'+_dataParentID)){
                finalizeJournalReview().done(function(response){

                    showNotification(response);
                    if(response.stat=="success"){
                        var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                        dt.row(_parentRow).remove().draw();
                    }
                }).always(function(){
                    showSpinningProgress(_curBtn);
                });
            }else{
                showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                stat=false;
            }

        });

        var finalizeJournalReview=function(){
            var _data_review=parent.find('form').serializeArray();
            console.log(_data_review);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Purchases_integration/transaction/create-pos",
                "data":_data_review,
                "beforeSend": showSpinningProgress(btn)

            });
        };



    };


});



</script>

</body>

</html>