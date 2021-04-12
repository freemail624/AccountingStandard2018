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
    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <style>
        .select2-container{
            min-width: 100%;
        }


        .select2-dropdown{
            z-index: 9999999999;
        }

        .datepicker-dropdown{
            z-index: 9999999999;
        }

        .dropdown-menu{
            z-index: 9999999999;
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

        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb" style="margin:0%;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Barcode_generator">Barcode Generator</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">

                            <div id="modal_barcode_generator" class="modal fade" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="color: white;">Barcode Generator<!--  <small style="color: white;"> | <a href="assets/manual/accountingreport/financialstatement/Income_Statement.pdf" target="_blank" style="color:white;"><i class="fa fa-question-circle"></i></a></small> --></h4>
                                        </div>
                                        <div class="modal-body">


                                            <div class="row">
                                                <div class="col-sm-12">
                                                    Product : <br />
                                                    <select name="product_id" id="cbo_products" data-error-msg="Branch is required." required>
                                                        <?php foreach($products as $product){ ?>
                                                            <option value="<?php echo $product->product_id; ?>" data-product-code="<?php echo $product->product_code; ?>"><?php echo $product->product_desc; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>                                          

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    PLU : <br />
                                                    <input type="text" id="product_code" class="form-control" placeholder="Product Code" readonly>
                                                </div>
                                            </div>    
                                            

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    QTY <br />
                                                    <input type="text" name="qty" id="qty" class="numeric form-control" value="1">
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <div class="barcode_print">
                                                          <img style="height:80px;" title="Download Barcode" id="barcode1"/>
                                                        </div>
                                                    </center>

                                                    <div id="barcode_panel" class="hidden">
                                                        <span class="barcodes"></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <br />
                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-xs-12">
                                                <button id="donwload_barcode" class="btn btn-primary" style="text-transform:none;font-family: tahoma;" title="Download Barcode" ><i class="fa fa-print"></i> Download </button>
                                                <button id="btn_print" class="btn btn-success" style="text-transform:none;font-family: tahoma;" title="Generate Barcode" ><i class="fa fa-print"></i> Generate </button>
                                                <button class="btn btn-red" data-dismiss="modal" style="text-transform: capitalize;">Close</button>
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
                        <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>
        </div>
    </div>
</div>


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>


<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var _cboProducts;

        var initializeControls=function(){

         $('.numeric').autoNumeric('init',{mDec:0});

            _cboProducts=$('#cbo_products').select2({
                placeholder: "Please select a product.",
                allowClear: false
            });

            _cboProducts.select2('val', null);

            $('#modal_barcode_generator').modal('show');
            JsBarcode("#barcode1", 'BARCODE HERE');
        }();



        var showSpinningProgress=function(e){
            $(e).toggleClass('disabled');
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };


        var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };
        
        $('#btn_print').click(function(){
            var product_code = $('#product_code').val();
            var qty = $('#qty').val();

            if(product_code == null || product_code == ""){
                showNotification({title: 'Error!',stat:"error",msg: "Product Code is required!"});
            }else{

                if(qty > 0){

                    $('.barcodes').html("");
                    for (i = 0; i < qty; i++) {
                        $('.barcodes').append('<img style="height:60px;margin-right: 20px;margin-bottom: 10px;" title="Download Barcode" class="barcode1"/>');
                        JsBarcode(".barcode1", product_code);
                    }

                    var currentURL = window.location.href;
                    var output = currentURL.match(/^(.*)\/[^/]*$/)[1];
                    output = output+"/assets/css/css_special_files.css";
                    $(".barcodes").printThis({
                        debug: false,
                        importCSS: true,
                        importStyle: true,
                        printContainer: false,
                        loadCSS: output,
                        formValues:true
                    });

                }else{
                    showNotification({title: 'Error!',stat:"error",msg: "Qty is required!"});
                }

            }

        });

        $("#cbo_products").change(function() {
        
            var product_code = $(this).find('option:selected').data('product-code');
            $('#product_code').val(product_code);

            JsBarcode("#barcode1", product_code);
        });

        $('#donwload_barcode').click(function() {
            var product_code = $('#product_code').val();

            if(product_code == null || product_code == ""){
                showNotification({title: 'Error!',stat:"error",msg: "Product Code is required!"});
            }else{
                download($('#barcode1').attr('src'),product_code,"image/png");
            }
        });

    });
</script>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

</body>
</html>