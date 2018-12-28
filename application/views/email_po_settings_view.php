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

        .control-label{
          text-align: left!important;
        }

        /*table{
            min-width: 700px;
        }

        .dataTables_filter{
            min-width: 700px;
        }

        .dataTables_info{
            min-width: 700px;
        }

        .dataTables_paginate{
            float: left;
            width: 100%;
        }*/

    </style>
</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">
        <?php echo $_side_bar_navigation; ?>
        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb" style="margin-bottom: 0px;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Email_report_settings">Purchase Order Email Settings  </a></li>
                    </ol>
                <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_company_fields">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                            <h2 class="h2-panel-heading">Purchase Order Email Report Settings</h2><hr>
                                               <form id="frm_settings" role="form" class="form-horizontal row-border">
                                                <div class="row" style="margin-left: 0px;"><h5 class="h2-panel-heading">Email Settings (From) </h5></div><hr>
                                                  <div class="form-group">
                                                       <label class="col-md-2  control-label"><strong> Send After PO Create :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-cog"></i>
                                                                </span>
                                                           <select id="enable_email_sending" name="enable_email_sending">
                                                               <option value="1"  <?php echo ($current_from->enable_email_sending==1?'selected':''); ?>>Enable</option>
                                                               <option value="0"  <?php echo ($current_from->enable_email_sending==0?'selected':''); ?>>Disable</option>
                                                           </select>
                                                           </div>
                                                       </div>
                                                   </div>
                                                  <div class="form-group">
                                                       <label class="col-md-2  control-label"><strong> Send After PO Update :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-cog"></i>
                                                                </span>
                                                           <select id="enable_email_sending_update" name="enable_email_sending_update">
                                                               <option value="1"  <?php echo ($current_from->enable_email_sending_update==1?'selected':''); ?>>Enable</option>
                                                               <option value="0"  <?php echo ($current_from->enable_email_sending_update==0?'selected':''); ?>>Disable</option>
                                                           </select>
                                                           </div>
                                                       </div>
                                                   </div>
                                                  <div class="form-group">
                                                       <label class="col-md-2  control-label"><strong> Email Address :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-user"></i>
                                                                </span>
                                                                <input type="text" name="email_address" class="form-control" value="<?php echo $current_from->email_address; ?>" placeholder="Company Name" data-error-msg="Company Name is required!" required>
                                                           </div>
                                                       </div>
                                                       <div class="col-md-1" style="margin-top: 5px;">
                                                           <span><strong id="provider_string"></strong></span>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-2 control-label"><strong> Password :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file"></i>
                                                                </span>
                                                               <input type="password" name="password" class="form-control" value="<?php echo $current_from->password; ?>"  data-error-msg="Password is required!" required>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-2 control-label"> <strong>Name (From) :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-envelope"></i>
                                                                </span>
                                                               <input type="text" name="name_from" class="form-control" value="<?php echo $current_from->name_from; ?>" data-error-msg="Name From is Required!" required>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-2 control-label"> <strong>Company Abbreviation :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-building"></i>
                                                                </span>
                                                               <input type="text" name="email_abbrev" class="form-control" value="<?php echo $current_from->email_abbrev; ?>" data-error-msg="Company Abbreviation is Required!" required>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-2 control-label"> <strong>System Website :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-globe"></i>
                                                                </span>
                                                               <input type="text" name="email_website" class="form-control" value="<?php echo $current_from->email_website; ?>" data-error-msg="Email Website is Required!" required>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group">
                                                       <label class="col-md-2 control-label"> <strong>Default Message :</strong></label>
                                                       <div class="col-md-7">
                                                           <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-send"></i>
                                                                </span>
                                                               <textarea type="text" name="default_message" class="form-control" required data-error-msg="Default Message is Required"><?php echo $current_from->default_message; ?></textarea>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="row" style="margin-left: 0px;">
                                                  <h5 class="h2-panel-heading" style="float: left;">Email Settings (to) </h5>
                                               <button class="btn btn-default" type="button" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;padding: 2px 7px; float: right;"><i class="fa fa-plus-circle" style="color: green;"></i> </button>
                                               </div><hr>
                                                <table id="tbl_entries" class="table-striped table">
                                                    <thead class="">
                                                    <tr>
                                                        <th style="width: 45%;">Name</th>
                                                        <th style="width: 45%;">Email Address</th>
                                                        <th style="width: 10%;">Action</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                      <?php foreach ($current as $cur) { ?>
                                                      <tr>
                                                        <td><input type="text" name="name[]" placeholder="Full Name" class="form-control" required data-error-msg="Full Name is required!" value="<?php echo $cur->po_email_name ?>" ></td>
                                                        <td><input type="text" name="email[]" placeholder="Complete Email Address" class="form-control" required data-error-msg="Complete Email Address is required!" value="<?php echo $cur->po_email_address ?>" ></td>
                                                        <td>
                                                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                                        </td>
                                                      </tr>
                                                      <?php } ?> 
                                                    </tbody>
                                                </table>
                                               </form>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save Changes</button>
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

    <table id="table_hidden" class="hidden">
        <tr>
            <td><input type="text" name="name[]" placeholder="Full Name" class="form-control" required data-error-msg="Full Name is required!"></td>
            <td><input type="text" name="email[]" placeholder="Complete Email Address" class="form-control" required data-error-msg="Complete Email Address is required!"></td>
            <td>
                <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
            </td>
        </tr>
    </table>


            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTIONS</h6></li>
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




<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>





<script>
    $(document).ready(function(){

        var initializeControls=function(){

        _cboSending=$("#enable_email_sending").select2({
            placeholder: "Enable or Disable.",
            minimumResultsForSearch: -1,
            allowClear: false
        });

        _cboSendingUpdate=$("#enable_email_sending_update").select2({
            placeholder: "Enable or Disable.",
            minimumResultsForSearch: -1,
            allowClear: false
        });
        }();

        var bindEventHandlers=function(){
            var detailRows = [];
            $('#tbl_entries').on('click','button.add_account',function(){
              var row=$('#table_hidden').find('tr');
              row.clone().insertAfter('#tbl_entries > tbody > tr:last');
            });

          $('#tbl_entries').on('click','button.remove_account',function(){
              $(this).closest('tr').remove();
          });

          $('#btn_new').click(function(){
            var row=$('#table_hidden').find('tr');
            row.clone().appendTo('#tbl_entries > tbody');
          });


        $('#btn_save').click(function(){
            var btn=$(this);
            var f=$('#frm_settings');
            if(validateRequiredFields(f)){
                updateSettings().done(function(response){
                    showNotification(response);
                }).always(function(){
                    showSpinningProgress($('#btn_save'));
                });
            }

        });




        var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };

        var updateSettings=function(){
            var _data=$('#frm_settings').serializeArray();
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Email_po_settings/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))

            });
        };

        var showSpinningProgress=function(e){
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };





    var validateRequiredFields=function(f){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required]',f).each(function(){
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




    }();

    });




</script>


</body>


</html>