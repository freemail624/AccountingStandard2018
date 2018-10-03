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
        #tbl_qptr4 tr,#tbl_qptr4 th,#tbl_qptr4 td{
            table-layout: fixed;
            border: 1px solid black;
            border-collapse: collapse;
            border-spacing: 0;
        }

        #tbl_qptr3 tr,#tbl_qptr3 th,#tbl_qptr3 td{
            table-layout: fixed;
            border: 1px solid black;
            border-collapse: collapse;
            border-spacing: 0;
        }
        #tbl_qptr2 tr,#tbl_qptr2 th,#tbl_qptr2 td{
            table-layout: fixed;
            border: 1px solid black;
            border-collapse: collapse;
            border-spacing: 0;
        }
        #tbl_qptr tr,#tbl_qptr th,#tbl_qptr td{
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
                        <li><a href="Quarterly_percentage_tax_return">Quarterly Percentage Tax Return</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_bank_list">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Quarterly Percentage Tax Return</h2><hr>
                                                <table id="tbl_qptr" class="table" style="border:1px solid black!important;" width="100%">
                                                    <tbody>
                                                        <tr style="height: 100px;">
                                                            <td style="width: 10%;">
                                                                <center>
                                                                    BIR Form No.
                                                                    <p><span style="font-size: 40px;"><b>2551Q</b></span><br>January 2018 (ENCS)<br><b>Page 1</b></p>
                                                                </center>
                                                            </td>
                                                            <td colspan="5" style="width: 65%">
                                                                <center>
                                                                    <h2>
                                                                        <b>Quarterly Percentage Tax Return</b>
                                                                    </h2>
                                                                    <i>Enter all required information in CAPITAL LETTERS using BLACK ink. Mark applicable boxes with an "X". Two copies MUST be filed with tthe BIR and one held by the Taxpayer.</i>
                                                                </center>
                                                            </td>
                                                            <td style="width: 25%">
                                                                Republika ng Pilipinas<br>
                                                                Kagawaran ng Pananalapi<br>
                                                                Kawanihan ng Rentas Internas
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 50px;">
                                                            <td class="bglabel-color" style="width: 30%" colspan="2">
                                                                <b>1</b> For the&nbsp;
                                                                <input type="checkbox" name="calendar" id="calendar">
                                                                <label for='calendar' style="vertical-align: text-bottom!important;">Calendar </label> 
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="checkbox" name="fiscal" id="fiscal">
                                                                <label for='fiscal' style="vertical-align: text-bottom!important;">Fiscal </label><br>
                                                                <div class="col-md-4 left">
                                                                    <b>2</b>  <span>Year ended<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(MM/YYYY)</span>
                                                                </div>
                                                                <div class="col-md-8 right">
                                                                    <input type="text" name="year_ended" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" colspan="3" style="width: 25%">
                                                                <b>3</b> Quarter<br>
                                                                &nbsp;&nbsp;&nbsp;<input type="checkbox" name="first_quarter" id="first_quarter">
                                                                <label for='first_quarter' style="vertical-align: text-bottom!important;">1st</label> 
                                                                &nbsp;&nbsp;&nbsp;
                                                                <input type="checkbox" name="second_quarter" id="second_quarter">
                                                                <label for='second_quarter' style="vertical-align: text-bottom!important;">2nd</label>
                                                                &nbsp;&nbsp;&nbsp;<input type="checkbox" name="third_quarter" id="third_quarter">
                                                                <label for='third_quarter' style="vertical-align: text-bottom!important;">3rd</label> 
                                                                &nbsp;&nbsp;&nbsp;
                                                                <input type="checkbox" name="fourth_quarter" id="fourth_quarter">
                                                                <label for='fourth_quarter' style="vertical-align: text-bottom!important;">4th</label>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 20%">
                                                                <b>4</b> Amended Return<br><br>
                                                                 &nbsp;&nbsp;&nbsp;<input type="checkbox" name="amended_return_yes" id="amended_return_yes">
                                                                <label for='amended_return_yes' style="vertical-align: text-bottom!important;">Yes </label> 
                                                                &nbsp;&nbsp;&nbsp;
                                                                <input type="checkbox" name="amended_return_no" id="amended_return_no">
                                                                <label for='amended_return_no' style="vertical-align: text-bottom!important;">No </label>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 25%">
                                                                <b>5</b> Number of sheets attached<br>
                                                                <input type="text" name="no_of_sheets_attached" style="width: 30%!important;" class="form-control pull-right">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table id="tbl_qptr2" class="table" style="margin-top: 3px;" width="100%">
                                                    <tbody>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><center>Part I - <span>Background Information</span></center></b></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="6">
                                                                <div class="col-md-3 left">
                                                                    <b>6 </b>Taxpayer Identification Number (TIN)<br>&nbsp;&nbsp;&nbsp;
                                                                </div>
                                                                <div class="col-md-9 right">
                                                                    <input type="text" name="tin" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 20%;">
                                                                <div class="col-md-5 left">
                                                                    <b>7</b> RDO Code<br>&nbsp;&nbsp;&nbsp;
                                                                </div>
                                                                <div class="col-md-7 right">
                                                                    <input type="text" name="rdo_code" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                <b>8 </b>&nbsp;Taxpayer's Name <i>(Last Name, First Name, Middle Name for Individual OR Registered Name for Non-individual)</i><br>
                                                                <div class="col-md-12 right left">
                                                                    <input type="text" name="taxpayer_name" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="6">
                                                                <b>9 </b>&nbsp;Registered Address <i>(Indicate complete address. If branch, indicate the branch address. If the registered address is different from the current address, go to the RDO to update registered address by using BIR Form No. 1905)</i><br>
                                                                <div class="col-md-12 right left">
                                                                    <input type="text" name="registered_address" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-7 left" style="text-align: right;">
                                                                    <b>9A </b>&nbsp;Zip Code<br>
                                                                </div>
                                                                <div class="col-md-5 right" style>
                                                                    <input type="text" name="zip_code" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2">
                                                                <b>10 </b>&nbsp;Contact Number <i>(Landline/Cellphone No.)</i><br>
                                                                <div class="col-md-12 right left">
                                                                    <input type="text" name="contact_number" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="5">
                                                                <b>11 </b>&nbsp;Email Address</i><br>
                                                                <div class="col-md-12 right left">
                                                                    <input type="text" name="email_address" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                <b>12 </b>&nbsp;Are you availling of tax relief under Special Law<br>
                                                                <div class="col-md-7">&nbsp;or International Tax Treaty
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" name="special_yes" id="special_yes">
                                                                    <label for='special_yes' style="vertical-align: text-bottom!important;">Yes </label> 
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" name="special_no" id="special_no">
                                                                    <label for='special_no' style="vertical-align: text-bottom!important;">No </label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <b>12A </b>&nbsp;If yes, specify
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text" name="special_specify" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                <b>13 </b>&nbsp;Only for individual taxpayers whose sales/receipts are subject to Percentage Tax under Section 116 of the Tax Code, as amended:<br>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What income tax rates are you availing? <i>(choose one)</i><br>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <i>(To be filled out only on the initial quarter of the taxable year)</i>
                                                                &nbsp;&nbsp;&nbsp;<input type="checkbox" name="graduated_income" id="graduated_income">
                                                                <label for='graduated_income' style="vertical-align: text-bottom!important;">Graduated income tax rate on net taxable income</label> 
                                                                &nbsp;&nbsp;&nbsp;
                                                                <input type="checkbox" name="eight_percent" id="eight_percent">
                                                                <label for='eight_percent' style="vertical-align: text-bottom!important;">8% income tax rate on gross sales/receipts/others</label>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7"><b><center>Part II - <span> Computation of Tax</span></center></b></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                <b>14 </b>Total Tax Due <i>(From Schedule 1 Item 7)</i>
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="total_tax_due" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less: Tax Credit/Payment <i>(attach proof)</i>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <b>15 </b>Creditable Percentage Tax Withheld per BIR Form No. 2307
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="creditable_percentage" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <b>16 </b>Tax Paid in Return Previously Filed, if this is an Amended Return
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="creditable_percentage" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                <div class="col-md-5">
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>17 </b>Other Tax Credit/Payment (specify)
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="specify_
                                                                    other_tax_credit" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="other_tax_credit" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                <b>18 </b>Total Tax Credits/Payments <i>(Sum of Items 15 to 17)</i>
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="total_tax_credit" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                <b>19 </b>Tax Still Payable/(Overpayment) <i>(Item 14 Less Item 18)</i>
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="tax_still_payable" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add: Penalties</i>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <b>20 </b>Surcharge
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="surcharge" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <b>21 </b>Interest
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="interest" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <b>22 </b>Compromise
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="compromise" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="5" class="no-border">
                                                                <b>23 </b>Total Penalties <i>(Sum of Items 20 to 22)</i>
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="tax_still_payable" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="no-border-tr bglabel-color">
                                                            <td colspan="5" class="no-border"> 
                                                                <b>24 &nbsp;&nbsp;&nbsp;Total Amount Payable/(Overpayment) (Sum of items 19 and 23)</b>
                                                            </td>
                                                            <td colspan="2" style="border-left: none;">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="total_amount_payable" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2" class="no-border">
                                                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If overpayment, mark one box only:
                                                            </td>
                                                            <td colspan="2" class="no-border">
                                                                <input type="checkbox" name="refunded" id="refunded">
                                                                <label for='refunded' style="vertical-align: text-bottom!important;">To be Refunded </label> 
                                                            </td>
                                                            <td colspan="3" style="border-left: none;">
                                                                <input type="checkbox" name="tax_credit" id="tax_credit">
                                                                <label for='tax_credit' style="vertical-align: text-bottom!important;">To be issued a Tax Credit Certificate </label><br>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I/We declare under the penalties of perjury that this return, and all its attachments, have been made in good fatith, verified by me/us, and to the best of my/our knowledge and belief, is true and correct pursuant to the provisions of the National Internal Revenue Code as amended, and the regulations issued under authority thereof. Further, I give my consent to the processing of my information as contemplated under the *Data Privacy Act of 2012 (R.A. No. 10173) for legitimate and lawful purposes. <i>(If Authorized Representative, attach authorization letter)</i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">For Individual:<br><br><br><br></td>
                                                            <td colspan="4">For Non-Individual:<br><br><br><br></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="3"><center>Signature over Printed Name of Taxpayer/Authorized Representative/Tax Agent<br><i>(Indicate title/designation and TIN)</i></center></td>
                                                            <td colspan="4"><center>Signature over Printed Name of President/Vice President/Authorized Officer or Representative/Tax Agent<i><br>(Indicate title/designation and TIN)</i></center></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="3">
                                                                <div class="col-md-5 left"> 
                                                                    Tax Agent Accreditation No./<br>Attorney's Roll No. <i>(If applicable)</i>
                                                                </div>
                                                                <div class="col-md-7 right">
                                                                    <input type="text" name="accreditation_no" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-5 left"> 
                                                                    Date of Issue<br><i>(MM/DD/YYYY)</i>
                                                                </div>
                                                                <div class="col-md-7 right">
                                                                    <input type="text" name="date_of_issue" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-5 left"> 
                                                                    Expiry Date<br><i>(MM/DD/YYYY)</i>
                                                                </div>
                                                                <div class="col-md-7 right">
                                                                    <input type="text" name="expiry_date" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7">
                                                                <b><center>Part III - <span>Details of Payment</span></center></b>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td><center>Particulars</center></td>
                                                            <td><center>Drawee Bank/Agency</center></td>
                                                            <td><center>Number</center></td>
                                                            <td><center>Date<br><i>(MM-DD-YYYY)</i></center></td>
                                                            <td colspan="3" style="width: 35%"><center>Amount</center></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td style="width: 15%;"><b>25 </b>Cash/Bank Debit Memo</td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="cash_bank_dba" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="cash_bank_number" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="cash_bank_date" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="cash_bank_amount" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td style="width: 15%;"><b>26 </b>Check</td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="check_dba" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="check_number" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="check_date" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="check_amount" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2" style="width: 15%;"><b>27 </b>Tax Debit Memo</td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="tax_debit_number" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="tax_debit_date" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="tax_debit_amount" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="7" style="width: 15%;"><b>28 </b>Others <i>(Specify below)</i></td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="others_particulars" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="others_dba" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="others_number" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="others_date" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div class="col-md-12 right">
                                                                    <input type="text" name="others_amount" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="no-border">
                                                                Machine Validation/Revenue Official Receipt Details (If not filed with an Authorized Agent Bank)<br><br><br><br>
                                                            </td>
                                                            <td colspan="3">
                                                                <center>Stamp of receiving Office/AAB and Date of Receipt<br><i>(RO's Signature/Bank Teller's Initial)</i></center><br><br>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <br>
                                                <table id="tbl_qptr3" class="table" style="border:1px solid black!important;" width="100%">
                                                    <tbody>
                                                        <tr style="height: 100px;">
                                                            <td style="width: 10%;">
                                                                <center>
                                                                    BIR Form No.
                                                                    <p><span style="font-size: 40px;"><b>2551Q</b></span><br>January 2018 (ENCS)<br><b>Page 2</b></p>
                                                                </center>
                                                            </td>
                                                            <td colspan="5" style="width: 65%">
                                                                <center>
                                                                    <h2>
                                                                        <b>Quarterly Percentage Tax Return</b>
                                                                    </h2>
                                                                </center>
                                                            </td>
                                                            <td style="width: 25%">
                                                                Republika ng Pilipinas<br>
                                                                Kagawaran ng Pananalapi<br>
                                                                Kawanihan ng Rentas Internas
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2">TIN</td>
                                                            <td colspan="5">Taxpayer's Last Name <i>(if individual)</i> / Registered Name <i>(if Non-Individual)</i>
                                                        </tr>
                                                        <tr style="height: 50px;">
                                                            <td style="width: 30%" colspan="2">
                                                                <div class="col-md-12 right left">
                                                                    <input type="text" name="tin" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td colspan="5">
                                                                <div class="col-md-12 right left">
                                                                    <input type="text" name="taxpayer" class="form-control">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table id="tbl_qptr4" class="table" style="border:1px solid black!important; margin-top: 3px;" width="100%">
                                                    <tbody>
                                                        <tr class="bglabel-color">
                                                            <td colspan="8">
                                                                <b>Schedule 1 - Computatation of Tax </b><i>(Attach additional sheet/s, if necessary)</i>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2" style="width: 14%">
                                                                <center>Alphanumeric Tax Code <i>(ATC)</i></center>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <center>Taxable Amount</center>
                                                            </td>
                                                            <td colspan="2" style="width: 10%">
                                                                <center>Tax Rate</center>
                                                            </td>
                                                            <td colspan="2">
                                                                <center>Tax Due</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 2%" class="bglabel-color">
                                                                <b>1</b>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="atc1" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="taxable_amount1" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td style="width: 11%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_rate1" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>%</b>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_due1" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>2</b>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="atc2" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="taxable_amount2" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td style="width: 11%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_rate2" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>%</b>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_due2" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>3</b>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="atc3" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="taxable_amount3" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td style="width: 11%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_rate3" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>%</b>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_due3" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>4</b>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="atc4" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="taxable_amount4" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td style="width: 11%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_rate4" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>%</b>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_due4" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>5</b>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="atc5" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="taxable_amount5" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td style="width: 11%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_rate5" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>%</b>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_due5" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>6</b>
                                                            </td>
                                                            <td style="width: 12%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="atc6" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td colspan="2" style="width: 30%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="taxable_amount6" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td style="width: 13%">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_rate6" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                            <td class="bglabel-color" style="width: 2%">
                                                                <b>%</b>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="tax_due6" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bglabel-color" colspan="6">
                                                                <b>7 Total Tax Due</b><i>(Sum of items 1 to 6)(To Part II Item 14)</i>
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="col-md-12 left right">
                                                                    <input type="text" name="total_tax_due" class="form-control numeric">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="8">
                                                                <b>Table 1 - Alphanumeric Tax Code (ATC)</b>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="2" style="width: 14%;">
                                                                <center><b>ATC</b></center>
                                                            </td>
                                                            <td colspan="5">
                                                                <center><b>Percentage Tax On</b></center>
                                                            </td>
                                                            <td style="width: 10%;">
                                                                <center><b>Tax Rate</b></center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 010</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Persons exempt from VAT under Sec. 109(BB) <i>(Sec. 116)</i>
                                                            </td>
                                                            <td>
                                                                <center>3%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 040</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Domestic carriers and keepers of garages <i>(Sec. 117)</i>
                                                            </td>
                                                            <td>
                                                                <center>3%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 041</center>
                                                            </td>
                                                            <td colspan="5">
                                                                International Carriers <i>(Sec. 118)</i>
                                                            </td>
                                                            <td>
                                                                <center>3%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 060</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Franchises on gas and water utilities <i>(Sec. 119)</i>
                                                            </td>
                                                            <td>
                                                                <center>2%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 070</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Franchises on radio/TV broadcasting companies whose annual gross receipts do not exceed P10 M <i>(Sec. 119)</i>
                                                            </td>
                                                            <td>
                                                                <center>3%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 090</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Overseas dispatch, message or conversation originating from the Philippines <i>(Sec. 120)</i>
                                                            </td>
                                                            <td>
                                                                <center>10%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 140</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Cockpits <i>(Sec. 125)</i>
                                                            </td>
                                                            <td>
                                                                <center>18%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 150</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Tax on amusement places, such as cabarets, night and day clubs, videoke bars, karaoke bars, karaoke television, karaoke boxes, music lounges and other similar establishments <i>(Sec. 125)</i>
                                                            </td>
                                                            <td>
                                                                <center>18%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 160</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Boxing Exhibition <i>(Sec. 125)</i>
                                                            </td>
                                                            <td>
                                                                <center>10%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 170</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Professional Basketball Games <i>(Sec. 125)</i>
                                                            </td>
                                                            <td>
                                                                <center>15%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 180</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Jai-alai and Race Tracks <i>(Sec. 125)</i>
                                                            </td>
                                                            <td>
                                                                <center>30%</center>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="8">
                                                                <b>Tax on Banks and Non-Bank Financial Intermediaries Performing Quasi-Banking Functions </b><i>(Sec. 121)</i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                            </td>
                                                            <td colspan="5" class="no-border">
                                                                1) On interest, commissions and discounts from lending activities as well as income from financial leasing, on the basis of remaining maturities of instruments from which such receipts are derived
                                                            </td>
                                                            <td style="border-left: none;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 105</center>
                                                            </td>
                                                            <td colspan="5">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;- Maturity period is five (5) years or less
                                                            </td>
                                                            <td>
                                                                <center>5%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 101</center>
                                                            </td>
                                                            <td colspan="5">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;- Maturity period is more than five (5) years
                                                            </td>
                                                            <td>
                                                                <center>1%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 102</center>
                                                            </td>
                                                            <td colspan="5">
                                                                2) On dividends and equity shares and net income of subsidiaries
                                                            </td>
                                                            <td>
                                                                <center>0%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 103</center>
                                                            </td>
                                                            <td colspan="5">
                                                                3) On royalties, rentals of property, real or personal, profits from exchange and all other gross income
                                                            </td>
                                                            <td>
                                                                <center>7%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 104</center>
                                                            </td>
                                                            <td colspan="5">
                                                                4) On net trading gains within the taxable year on foreign currency, debt securities, derivatives and other financial instruments
                                                            </td>
                                                            <td>
                                                                <center>7%</center>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="8">
                                                                <b>Tax on Other Non-Bank Financial Intermediaries not Performing Quasi-Banking Functions </b><i>(Sec. 122)</i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                            </td>
                                                            <td class="no-border" colspan="5">
                                                                1) On interest, commissions and discounts from lending activities as well as income from financial leasing, on the basis of remaining maturities of instruments from which such receipts are derived
                                                            </td>
                                                            <td style="border-left: none;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 113</center>
                                                            </td>
                                                            <td colspan="5">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;- Maturity period is five (5) years or less
                                                            </td>
                                                            <td>
                                                                <center>5%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 114</center>
                                                            </td>
                                                            <td colspan="5">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;- Maturity period is more than five (5) years
                                                            </td>
                                                            <td>
                                                                <center>1%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 115</center>
                                                            </td>
                                                            <td colspan="5">
                                                                2) From all other items treated as gross income under the code
                                                            </td>
                                                            <td>
                                                                <center>5%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 120</center>
                                                            </td>
                                                            <td colspan="5">
                                                                Life Insurance Premiums <i>(Sec. 123)</i>
                                                            </td>
                                                            <td>
                                                                <center>2%</center>
                                                            </td>
                                                        </tr>
                                                        <tr class="bglabel-color">
                                                            <td colspan="8">
                                                                <b>Agents of Foreign Insurance Companies </b><i>(Sec. 124)</i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 130</center>
                                                            </td>
                                                            <td colspan="5">
                                                                1) Insurance Agents</i>
                                                            </td>
                                                            <td>
                                                                <center>4%</center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <center>PT 132</center>
                                                            </td>
                                                            <td colspan="5">
                                                                1) Owners of property obtaining insurance directly with foreign insurance companies</i>
                                                            </td>
                                                            <td>
                                                                <center>5%</center>
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