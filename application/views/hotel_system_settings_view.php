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

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">



    <style>
        .tab-container .nav-tabs > li > a {
            border-radius: 0;
            padding: 9px 16px;
            font-weight: 100;
        }

        h5{
            margin-left: 20px;
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

/*        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
        }*/

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        label{
            text-align: left!important;
            font-weight: 600!important;
        }
        .asterisk-required{
            color: red;
        }
    </style>
</head>

<body class="animated-content">
<?php echo $_top_navigation; ?>
<div id="wrapper">
<div id="layout-static">
<?php echo $_side_bar_navigation;
?>
<div class="static-content-wrapper white-bg">
<div class="static-content"  >
<div class="page-content"><!-- #page-content -->
<ol class="breadcrumb" style="margin-bottom: 0px;">
    <li><a href="dashboard">Dashboard</a></li>
    <li><a href="Hotel_system_settings">Hotel Integration Settings </a></li>
</ol>
<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-body">
            <h2 class="h2-panel-heading">Prime Asia | <small>Hotel Integration Settings</small></h2><hr>
            <i>Note: All Fields are required.</i>
                    <form id="frm_poleng_villa" role="form" class="form-horizontal row-border">                  
                        <input type="hidden" name="department_id" value="2">
                        <h5><span style="margin-left: 1%"><strong> Asset Integration Account</strong></span></h5>
                                                <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> * Cash Payment :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="cash_id" class="cbo_accounts" data-error-msg="Cash Payment Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Check Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="check_id"  class="cbo_accounts" data-error-msg="Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->check_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Credit Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="card_id"  class="cbo_accounts" data-error-msg="Credit Card Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->card_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Charge Account :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="charge_id"  class="cbo_accounts" data-error-msg="Charge Account Account is required." required>

                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->charge_id==$account->account_id?'selected':''); ?>><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Bank Deposit Account:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bank_dep_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->bank_dep_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h5><span style="margin-left: 1%"><strong> Advances Accounts </strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Advance Cash:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="adv_cash_id" class="cbo_accounts" data-error-msg="Advance Cash Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->adv_cash_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Advance Check :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_check_id" class="cbo_accounts" data-error-msg="Advance Check Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->adv_check_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Advance Card :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_card_id" class="cbo_accounts" data-error-msg="Advance Card Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->adv_card_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Advance Charge :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_charge_id" class="cbo_accounts" data-error-msg="Advance Charge Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->adv_charge_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Advance Bank Deposit:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_bank_dep_id" class="cbo_accounts" data-error-msg="Advance Bank Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->adv_bank_dep_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Advance Sales:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="adv_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->adv_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br>
                        <h5><span style="margin-left: 1%"><strong> Income Integration Accounts</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Room Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="room_sales_id" class="cbo_accounts" data-error-msg="Room Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->room_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Bar Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="bar_sales_id" class="cbo_accounts" data-error-msg="Bar Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->bar_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Other Sales :</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="other_sales_id" class="cbo_accounts" data-error-msg="Other Sales Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->other_sales_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Hotel Transportation: </label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="transpo_hotel_id" class="cbo_accounts" data-error-msg="Hotel Transportation Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->transpo_hotel_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Outsource Transportation: </label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3 col-md-offset-3">
                                <select name="transpo_outsource_id" class="cbo_accounts" data-error-msg="Outsource Transportation Account is required." required>
                                    <?php foreach($accounts as $account){ ?>
                                        <option value="<?php echo $account->account_id; ?>" <?php echo ($prime_hotel_integration->transpo_outsource_id==$account->account_id?'selected':''); ?>  ><?php echo $account->account_title; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h5><span style="margin-left: 1%"><strong> Various Customer Account (Advances)</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Customer:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="customer_id" class="cbo_accounts" data-error-msg="Customer is required." required>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($prime_hotel_integration->customer_id==$customer->customer_id?'selected':''); ?>  ><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <h5><span style="margin-left: 1%"><strong> Department Account</strong></span></h5>
                        <div class="form-group">
                            <label class="col-md-2  col-md-offset-1 control-label"> <b class="asterisk-required">*</b> Department:</label>
                            <div class="col-md-4 col-md-offset-0 col-md-offset-3">
                                <select name="department_id" class="cbo_accounts" data-error-msg="Department is required." required>
                                    <?php foreach($departments as $department){ ?>
                                        <option value="<?php echo $department->department_id; ?>" <?php echo ($prime_hotel_integration->department_id==$department->department_id?'selected':''); ?>  ><?php echo $department->department_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class=" col-lg-offset-3">
                        </div>
                    </form>
                        <div class="col-md-2 " style=" width: 11.666667%;">
                            <button id="btn_save_integration" type="button" class="btn btn-primary " style="padding: 7px 7px 7px 7px!important; font-family: tahoma;text-transform: none;"><span class=""></span> Save Changes</button>
                        </div>
                </div>
            </div> <!-- END OF TAB CONTENT -->
        </div>
</div>
</div>
</div> <!-- .container-fluid -->
</div> <!-- #page-content -->
</div>
<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV OFFICE SOLUTION INC</h6></li>
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
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script>
$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _accounts;
    var initializeControls=function(){
        _accounts=$(".cbo_accounts").select2({
            placeholder: "Please select account.",
            allowClear: false
        });
        var createToolBarButton=function() {
            var _btnNew='<button class="btn btn-primary"  id="btn_close_accounting" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Close Accounting Period" >'+
                '<i class="fa fa-bars"></i> Close Accounting Period</button>';
                $("div.toolbar").html(_btnNew);
        }();
    }();
    var bindEventHandlers=(function(){
    $('#btn_save_integration').click(function(){   
        var _data=$('#frm_poleng_villa').serializeArray();
        console.log(_data);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Hotel_system_settings/transaction/save",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save_integration'))
            }).done(function(response){
                        showNotification(response);
            }).always(function(){
                showSpinningProgress($('#btn_save_integration'));
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
    var saveSettings=function(){
        var _data=$('#frm_poleng_villa').serializeArray();
        console.log(_data);
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Hotel_integration/transaction/save",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save_integration'))
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
    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('select').select2('val',null);
        $(f).find('input:first').focus();
    };
    var showList=function(b){
        if(b){
            $('#div_account_year_list').show();
            $('#div_account_year_fields').hide();
        }else{
            $('#div_account_year_list').hide();
            $('#div_account_year_fields').show();
        }
    };
});
</script>
</body>
</html>