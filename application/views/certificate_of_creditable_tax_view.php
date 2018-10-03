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
        #tbl_mptr2 tr,#tbl_mptr2 th,#tbl_mptr2 td{
            table-layout: fixed;
            border: 1px solid black;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .bglabel-color{
            background-color: #ebebe0;
        }

        .left{
            padding-left: 0px;
        }

        .right{
            padding-right: 0px;
        }

        .no-border{
            border: none!important;
        }

        .no-border-tr{
            border-top: none!important;
            border-bottom: none!important;
        }

        .border-tr{
            border-bottom: none!important;
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

        .select2-container {
            min-width: 100%;
            z-index: 999999999;
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

                    <ol class="breadcrumb" style="margin:0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Certificate_of_creditable_tax">Certificate of Creditable Tax</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_bank_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Certificate of Creditable Tax</h2><hr>
                                                <table id="tbl_mptr" class="table" style="border:1px solid black!important;" width="100%">
                                                    <tbody>
                                                        <tr style="height: 100px;">
                                                            <td style="width: 35%">
                                                                Republika ng Pilipinas<br>
                                                                Kagawaran ng Pananalapi<br>
                                                                Kawanihan ng Rentas Internas
                                                            </td>
                                                            <td style="width: 30%">
                                                                <center>
                                                                    <h2>
                                                                        Certificate of Creditable Tax<br>
                                                                        Withheld At Source
                                                                    </h2>
                                                                </center>
                                                            </td>
                                                            <td class="pull-right" style="width: 35%">
                                                                BIR Form No.
                                                                <p><span style="font-size: 40px;"><b>2307</b></span><br>September 2005 (ENCS)</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table id="tbl_mptr2" class="table" width="100%">
                                                    <tbody>
                                                        <tr class="bglabel-color" style="height: 50px;">
                                                            <td colspan="7">
                                                                <div class="col-md-2 left">
                                                                    <b>1</b>&nbsp; For the Period <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-2 left right">
                                                                    <input type="text" name="from" class="form-control">
                                                                </div>
                                                                <div class="col-md-2 left">
                                                                    <br>&nbsp;&nbsp;&nbsp;(MM/DD/YYYY)
                                                                </div>
                                                                <div class="col-md-2 left">
                                                                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-2 left right">
                                                                    <input type="text" name="to" class="form-control">
                                                                </div>
                                                                <div class="col-md-2 left">
                                                                    <br>&nbsp;&nbsp;&nbsp;(MM/DD/YYYY)
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><span style="float: left;">Part I</span><center><span>Payee Information</span></center></b></td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 left right">
                                                                    <b>2</b>&nbsp; Taxpayer <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Identification Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-5 left right">
                                                                    <input type="text" name="tin" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 right left">
                                                                    <b>3 </b>&nbsp;Payee's Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right left">
                                                                    <input type="text" name="payee_name" class="form-control"><center>(Last Name, First Name, Middle Name for Individuals) (Registered Name for Non-Individuals)</center>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 right left">
                                                                    <b>4 </b>&nbsp;Registered Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-6 right left">
                                                                    <input type="text" name="registered_address" class="form-control">
                                                                </div>
                                                                <div class="col-md-2 right">
                                                                    <b>4A </b>&nbsp;Zip Code &nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-2 right left">
                                                                    <input type="text" name="ra_zip_code" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 right left">
                                                                    <b>5 </b>&nbsp;Foreign Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-6 right left">
                                                                    <input type="text" name="foreign_address" class="form-control">
                                                                </div>
                                                                <div class="col-md-2 right">
                                                                    <b>5A </b>&nbsp;Zip Code &nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-2 right left">
                                                                    <input type="text" name="fa_zip_code" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><center><span>Payor Information</span></center></b></td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 left right">
                                                                    <b>6</b>&nbsp; Taxpayer <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Identification Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-5 left right">
                                                                    <input type="text" name="payor_tin" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 right left">
                                                                    <b>7 </b>&nbsp;Payor's Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-10 right left">
                                                                    <input type="text" name="payor_name" class="form-control"><center>(Last Name, First Name, Middle Name for Individuals) (Registered Name for Non-Individuals)</center>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                <div class="col-md-2 right left">
                                                                    <b>8 </b>&nbsp;Registered Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-6 right left">
                                                                    <input type="text" name="payor_registered_address" class="form-control">
                                                                </div>
                                                                <div class="col-md-2 right">
                                                                    <b>8A </b>&nbsp;Zip Code &nbsp;&nbsp;&nbsp;&nbsp;&#x25B6;
                                                                </div>
                                                                <div class="col-md-2 right left">
                                                                    <input type="text" name="ra_zip_code" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><span style="float: left;">Part II</span><center><span>Details of Monthly Income Payments and Tax Withheld for the Quarter</span></center></b></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td style="width: 20%" rowspan="2">
                                                                <center><b>Income Payments Subject to Expanded Withholding Tax</b></center></td>
                                                            <td style="width: 10% "rowspan="2">
                                                                <center><b>ATC</b></center>
                                                            </td>
                                                            <td colspan="4" style="width: 40%">
                                                                <center><b>AMOUNT OF INCOME PAYMENTS</b></center>
                                                            </td>
                                                            <td rowspan="2" style="width: 30%">
                                                                <center><b>Tax Withheld<br>For the Quarter</b></center>
                                                            </td>
                                                        </tr>
                                                        <tr  class="bglabel-color">
                                                            <td>
                                                                <center><b>1st Month of<br> the Quarter</b></center>
                                                            </td>
                                                            <td>
                                                                <center><b>2nd Month of<br> the Quarter</b></center>
                                                            </td>
                                                            <td>
                                                                <center><b>3rd Month of<br> the Quarter</b></center>
                                                            </td>
                                                            <td>
                                                                <center><b>Total</b></center>
                                                            </td>
                                                        </tr>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total1" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld1" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total2" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld2" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total3" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld3" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total4" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld4" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total5" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld5" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total6" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld6" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total7" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld7" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total8" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld8" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total9" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld9" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total10" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld10" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total11" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld11" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total12" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld12" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="income_payments13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total13" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld13" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" style="width: 20%">
                                                                <b>Total</b>
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="atc_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="first_month_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="second_month_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="third_month_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="total_total" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="tax_withheld_total" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td style="width: 25%">
                                                                <center><b>Money Payments Subject to Withholding <br>of Business Tax (Government & Private)</b></center>
                                                            </td>
                                                            <td style="width: 10%">
                                                            </td>
                                                            <td style="width: 10%">
                                                            </td>
                                                            <td style="width: 10%">
                                                            </td>
                                                            <td style="width: 10%">
                                                            </td>
                                                            <td style="width: 10%">
                                                            </td>
                                                            <td style="width: 30%">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month1" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total1" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld1" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month2" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total2" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld2" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month3" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total3" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld3" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month4" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total4" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld4" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month5" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total5" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld5" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month6" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total6" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld6" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month7" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total7" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld7" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month8" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total8" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld8" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month9" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total9" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld9" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month10" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total10" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld10" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month11" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total11" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld11" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month12" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total12" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld12" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month13" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total13" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld13" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments14" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc14" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month14" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month14" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month14" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total14" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld14" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments15" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc15" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month15" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month15" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month15" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total15" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld15" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <input type="text" name="mp_income_payments16" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc16" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month16" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month16" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month16" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total16" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld16" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td style="width: 20%">
                                                                Total
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_atc_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_first_month_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_second_month_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_third_month_total" class="form-control">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <input type="text" name="mp_total_total" class="form-control">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <input type="text" name="mp_tax_withheld_total" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We declare, under the penalties of perjury, that this certificate has been made in good faith, verified by me, and to the best of my knowledge and belief, is true and correct, pursuant to the provisions of the National Internal Revenue Code, as amended, and the regulations issued under authority thereof.
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td colspan="3" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Payor/Payor's Authorized Representative/Accredited Tax Agent<br>(Signature Over Printed Name)</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                TIN of Signatory<br><br></center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Title/Position of Signatory<br><br></center>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-top: none;">
                                                            <td colspan="3" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Tax Agent Accreditation No./Attorney's Roll No. (if applicable)</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Date of Issuance<br></center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Date of Expiry<br></center>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr">
                                                            <td colspan="7" class="no-border">
                                                                Conforme:
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr" style="border-top: none;">
                                                            <td colspan="3" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Payee/Payee's Authorized Representative/Accredited Tax Agent<br>(Signature Over Printed Name)</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                TIN of Signatory<br><br></center>
                                                            </td>
                                                            <td class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Title/Position of Signatory<br><br></center>
                                                            </td>
                                                            <td class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Date Signed<br><br></center>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-top: none;">
                                                            <td colspan="3" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Tax Agent Accreditation No./Attorney's Roll No. (if applicable)</center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Date of Issuance<br></center>
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <center><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                                                                Date of Expiry<br></center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="panel-footer"></div>
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

<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboAccountType;

    var initializeControls=function(){

    }();

    var bindEventHandlers=(function(){
        var detailRows = [];
        
    })();

    var validateRequiredFields=function(){
        var stat=true;
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]').each(function(){
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

    var showList=function(b){
        if(b){
            $('#div_bank_list').show();
            $('#div_bank_fields').hide();
        }else{
            $('#div_bank_list').hide();
            $('#div_bank_fields').show();
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
        $('input[required],textarea','#frm_bank').val('');
        $('form').find('input:first').focus();
    };

    function format ( d ) {
        return '<br /><table style="margin-left:10%;width: 80%;">' +
        '<thead>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td>Unit Name : </td><td><b>'+ d.unit_name+'</b></td>' +
        '</tr>' +
        '<tr>' +
        '<td>Unit Description : </td><td>'+ d.unit_desc+'</td>' +
        '</tr>' +
        '</tbody></table><br />';
    };
});

</script>

</body>

</html>vie