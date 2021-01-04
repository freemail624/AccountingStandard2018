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
                
            .numeric{
                text-align: right;
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
                                <li><a href="Bank_statement">Bank Statement</a></li>
                            </ol>

                            <div class="container-fluid">
                                <div data-widget-group="group1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="div_bank_statement_list">
                                                <div class="panel panel-default">
                                                    <div class="panel-body table-responsive">
                                                    <h2 class="h2-panel-heading">Bank Statement</h2><hr>
                                                        <table id="tbl_bank_statement" class="table table-striped" cellspacing="0" width="100%">
                                                            <thead class="">
                                                            <tr>
                                                                <th>Account</th>
                                                                <th>Month</th>
                                                                <th>Year</th>
                                                                <th>Opening Balance</th>
                                                                <th>Closing Balance</th>
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
                                            <div id="div_bank_statement_fields" style="display: none;">
                                                <div class="panel panel-default">
                                                    <div class="panel-body table-responsive">
                                                        <h2 class="h2-panel-heading">Bank Statement</h2><hr>
                                                        <form id="frm_bank_statement">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-4">
                                                                    <label><b class="required">*</b> Account: </label><br/>
                                                                    <select class="form-control" name="account_id" required data-error-msg="Account is required!" id="account_id" style="width: 100%;">
                                                                        <?php 
                                                                            foreach($accounts as $account){?>
                                                                            <option value="<?php echo $account->account_id; ?>">
                                                                                <?php echo $account->account_title; ?>
                                                                            </option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 col-md-offset-2">
                                                                    <label><b class="required">*</b> Opening Balance: </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-code"></i>
                                                                        </span>
                                                                        <input type="text" name="opening_balance" id="opening_balance" class="numeric form-control text-right" 
                                                                        required data-error-msg="Opening balance is required!" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label><b class="required">*</b> Closing Balance: </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-code"></i>
                                                                        </span>
                                                                        <input type="text" name="closing_balance" id="closing_balance" class="form-control text-right"
                                                                        required data-error-msg="Closing balance is required!" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-2">
                                                                    <label>Month: </label><br/>
                                                                    <select class="form-control" name="month_id" id="month_id" style="width: 100%;">
                                                                        <?php 
                                                                        $active_month = date("m");
                                                                            foreach($months as $month){?>
                                                                            <option value="<?php echo $month->month_id; ?>" <?php if($month->month_id==$active_month){echo 'selected'; }?>>
                                                                                <?php echo $month->month_name; ?>
                                                                            </option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                             <label>Year: </label><br/>
                                                                    <select class="form-control" name="year_id" id="year_id" style="width: 100%;">
                                                                        <?php 
                                                                        $active_year = date("Y");
                                                                        $minyear=$active_year-10; $maxyear=$active_year+10;
                                                                            while($minyear!=$maxyear){?>
                                                                            <option value="<?php echo $minyear; ?>" <?php if($minyear==$active_year){echo 'selected'; }?>>
                                                                                <?php echo $minyear; ?>
                                                                            </option>
                                                                        <?php $minyear++;}?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="container-fluid">
                                                            <div class="col-xs-12">
                                                            <div>
                                                            <br/>
                                                                <span style="float: left;"><strong><i class="fa fa-bars"></i> Bank Statement Entries</strong></span>

                                                                <a id="btn_refresh" style="float: right;color: green;" class="disable-select">Refresh <i class="fa fa-refresh"></i> </a>

                                                                <a id="btn_clear" style="float: right;margin-right: 20px;color: red;" class="disable-select">Clear <i class="fa fa-times-circle"></i> </a>
                                                                <br />
                                                                <hr />

                                                                <div style="width: 100%;">
                                                                    <table id="tbl_entries" class="table-striped table">
                                                                        <thead class="">
                                                                        <tr>
                                                                            <th width="10%">Date</th>
                                                                            <th width="10%">Value Date</th>
                                                                            <th width="10%">Cheque No.</th>
                                                                            <th width="15%" style="text-align: right;">Withdrawal Amt. (Dr)</th>
                                                                            <th width="15%" style="text-align: right;">Deposit (Cr)</th>
                                                                            <th width="15%" style="text-align: right;">Balance</th>
                                                                            <th width="15%">Narrative</th>
                                                                            <th width="10%">Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                        <td>
                                                                            <input type="text" name="general_ledger_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="value_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="cheque_no[]" class="form-control">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="dr_amount[]" class="form-control numeric">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="cr_amount[]" class="form-control numeric">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="balance_amount[]" class="form-control numeric" readonly>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="memo[]" class="form-control">
                                                                        </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                                                <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
    <!--                                                                     <tfoot>
                                                                        <tr>
                                                                            <td colspan="2" align="right"><strong>Total</strong></td>
                                                                            <td align="right"><strong>0.00</strong></td>
                                                                            <td align="right"><strong>0.00</strong></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        </tfoot> -->
                                                                    </table>

                                                                    <table id="table_hidden" class="hidden">
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" name="general_ledger_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="value_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="cheque_no[]" class="form-control">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="dr_amount[]" class="form-control numeric">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="cr_amount[]" class="form-control numeric">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="balance_amount[]" class="form-control numeric" readonly>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="memo[]" class="form-control">
                                                                        </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                                                <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        </table>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>                                                </form>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;""><span class=""></span>  Save Changes</button>
                                                                <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
                                                            </div>
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
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>
    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script>

    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj;
        var _cboAccounts; var _cboMonths; var _cboYears;

        var oTBJournal={
            "dr" : "td:eq(3)",
            "cr" : "td:eq(4)",
            "bal" : "td:eq(5)"
        };

        var initializeControls=function(){

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            _cboAccounts=$('#account_id').select2({
                allowClear: false,
                placeholder: 'Please Select Account'
            });

            _cboAccounts.select2('val',null);

            _cboMonths=$('#month_id').select2({
                allowClear: false,
                placeholder: 'Please Select Month'
            });

            _cboYears=$('#year_id').select2({
                allowClear: false,
                placeholder: 'Please Select Year'
            });

            dt=$('#tbl_bank_statement').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "ajax" : "Bank_statement/transaction/list",
                "language": {
                    "searchPlaceholder": "Search"
                },
                "columns": [

                    { targets:[0],data: "account_title" },
                    { targets:[1],data: "month_name" },
                    { targets:[2],data: "year" },
                    { sClass:"text-right", targets:[3],data: "opening_balance",
                        render: function (data, type, full, meta){
                            return accounting.formatNumber(parseFloat(data),2);
                        }
                    },
                    { sClass:"text-right", targets:[4],data: "closing_balance",
                        render: function (data, type, full, meta){
                            return accounting.formatNumber(parseFloat(data),2);
                        }
                    },
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
                var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="New Bank Statement" >'+
                    '<i class="fa fa-plus"></i> New Bank Statement</button>';
                $("div.toolbar").html(_btnNew);
            }();

            reInitializeNumeric();
        }();

        var bindEventHandlers=(function(){
            var detailRows = [];

            $('#tbl_bank_statement tbody').on( 'click', 'tr td.details-control', function () {
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
                // $('#category_title').text('New Category');
                // $('#modal_new_category').modal('show');
                showList(false);
            });

            $('#tbl_bank_statement tbody').on('click','button[name="edit_info"]',function(){
                _txnMode="edit";
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.category_id;

                $('input,textarea').each(function(){
                    var _elem=$(this);
                    $.each(data,function(name,value){
                        if(_elem.attr('name')==name){
                            _elem.val(value);
                        }
                    });
                });
                $('#category_title').text('Edit Category');
                $('#modal_new_category').modal('show');
                //showList(false);
            });

            $('#tbl_bank_statement tbody').on('click','button[name="remove_info"]',function(){
                _selectRowObj=$(this).closest('tr');
                var data=dt.row(_selectRowObj).data();
                _selectedID=data.category_id;
                $('#modal_confirmation').modal('show');
            });

            $('#btn_yes').click(function(){
                removeCategory().done(function(response){
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
                // $('#modal_new_category').modal('hide');
                showList(true);
            });

            $('#btn_save').click(function(){
                if(validateRequiredFields($('#frm_bank_statement'))){
                    if(_txnMode=="new"){
                        createCategory().done(function(response){
                            showNotification(response);
                            dt.row.add(response.row_added[0]).draw();
                            clearFields();
                            $('#modal_new_category').modal('hide');

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updateCategory().done(function(response){
                            showNotification(response);
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields();
                            showList(true);
                            $('#modal_new_category').modal('hide');
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                }
            });

            $('#account_id').on('change',function(){
                get_prev_statement();
            });

        var reInitializeDate = function(){

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        };

        $('#tbl_entries').on('click','button.add_account',function(){
            var row=$('#table_hidden').find('tr');
            row.clone().insertBefore($(this).closest('tr'));
            reInitializeNumeric();
            reInitializeDate();
        });

        $('#tbl_entries').on('click','button.remove_account',function(){
            var oRow=$('#tbl_entries > tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
                recomputeStatement();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }
            // reComputeTotals($('#tbl_entries'));
        });

        $('#opening_balance').on("keyup", function(){

            var opening_balance_amt = $(this).val();
            $('#closing_balance').val(accounting.formatNumber(opening_balance_amt,2));

        });

        var prevBankStatement = function(){
            var _data=$('#').serializeArray();
            _data.push({name: "month_id", value: $('#month_id').val() });
            _data.push({name: "account_id", value: $('#account_id').val() });
            _data.push({name: "year_id", value: $('#year_id').val() });

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Bank_reconciliation/transaction/get_previous_balance",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_process'))
            });
        };

        var recomputeStatement = function(){

            var count = $('#tbl_entries > tbody').find('tr');
            var opening_balance = accounting.unformat($('#opening_balance').val());

            $(count.get().reverse()).each(function(index, value){
                var bal = 0;
                var cr = accounting.unformat($(this).find(oTBJournal.cr).find('input.numeric').val());
                var dr = accounting.unformat($(this).find(oTBJournal.dr).find('input.numeric').val());
                
                if (index == 0){

                    if(dr > cr){
                        bal = opening_balance - dr;
                    }else{
                        bal = opening_balance + cr;
                    }

                }else{

                var prev = $(this).next();
                var row_bal = accounting.unformat(prev.find(oTBJournal.bal).find('input.numeric').val());

                    if(dr > cr){
                        bal = row_bal - dr;
                    }else{
                        bal = row_bal + cr;
                    }

                }


                if(dr <= 0){ $(this).find(oTBJournal.dr).find('input.numeric').val(accounting.formatNumber(0,2)) }

                if(cr <= 0){ $(this).find(oTBJournal.cr).find('input.numeric').val(accounting.formatNumber(0,2)) }

                $(this).find(oTBJournal.bal).find('input.numeric').val(accounting.formatNumber(bal,2));

            }); 

            var closing_balance = $('#tbl_entries > tbody > tr:first').find(oTBJournal.bal).find('input.numeric').val();

            $('#closing_balance').val(accounting.formatNumber(closing_balance,2));
            // $('input[name="actual_balance"]').val(accounting.formatNumber(closing_balance,2));

        };

        var clearStatement = function(){
            $('#opening_balance').val(accounting.formatNumber(0,2));
            $('#tbl_entries > tbody').html("");
            

            $.ajax({
                url: 'Bank_reconciliation/transaction/get-statement-entries',
                type: "GET",
                cache: false,
                dataType: 'html',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                }
            }).done(function(response){
                $('#tbl_entries > tbody').html(response);
                reInitializeNumeric();
                reInitializeDate();
            });

            recomputeStatement();
        };


        $('#btn_refresh').on('click', function(){
            recomputeStatement();
        });

        $('#btn_clear').on('click', function(){
            clearStatement();
            get_prev_statement();
        });        

        var _oTblEntries=$('#tbl_entries > tbody');

        _oTblEntries.on('change','input.numeric',function(){
            var _oRow=$(this).closest('tr');
            var opening_balance = accounting.unformat($('#opening_balance').val());

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{

                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }   

            if (opening_balance == 0 || "" || null){
                showNotification({title: 'Error!', msg: 'Opening Balance is required!', stat: 'error'});
                
                _oRow.find(oTBJournal.dr).find('input.numeric').val('');
                _oRow.find(oTBJournal.cr).find('input.numeric').val('');

                return false;

            }else{
                recomputeStatement();    
            }


        }); 

        var get_prev_statement = function(){
            prevBankStatement().done(function(response){
                var opening_balance = 0;

                if (response.data.length > 0){
                    var data = response.data[0];
                    opening_balance = data.closing_balance;
                    load_status = 1;
                }

                $('#opening_balance').val(accounting.formatNumber(opening_balance,2));
            });
        };


        })();

        var validateRequiredFields=function(f){
            var stat=true;
            $('div.form-group').removeClass('has-error');
            $('input[required],select[required],textarea[required]',f).each(function(){

            if($(this).is('select')){
                if($(this).val()==null || $(this).val()==""){
                        showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                        $(this).closest('div.form-group').addClass('has-error');
                        $(this).focus();
                        stat=false;
                        return false;
                    }
                }else{
                if($(this).val()=="" || $(this).val()== '0'){
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

        var createCategory=function(){
            var _data=$('#frm_category').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Categories/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var updateCategory=function(){
            var _data=$('#frm_category').serializeArray();
            _data.push({name : "category_id" ,value : _selectedID});

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Categories/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

        var removeCategory=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Categories/transaction/delete",
                "data":{category_id : _selectedID}
            });
        };

        var showList=function(b){
            if(b){
                $('#div_bank_statement_list').show();
                $('#div_bank_statement_fields').hide();
            }else{
                $('#div_bank_statement_list').hide();
                $('#div_bank_statement_fields').show();
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

        var getFloat=function(f){
            return parseFloat(accounting.unformat(f));
        };

        function reInitializeNumeric(){
            $('.numeric').autoNumeric('init', {mDec:2});
            $('.number').autoNumeric('init', {mDec:0});
        };

        var showSpinningProgress=function(e){
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            $(e).toggleClass('disabled');
        };

        var clearFields=function(f){
            $('input[required],select[required],textarea',f).val('');
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