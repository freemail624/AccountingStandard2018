<!DOCTYPE html>
<html>

<head>
    <title>Purchase Order</title>
    <style type="text/css">
        body {
            font-family: 'Calibri', sans-serif;
            font-size: 12px;
        }

        .border {
            border: 1px solid black !important;
        }

        .default-color {
            color: #2d419b;
            font-weight: bold;
            font-size: 9pt;
        }

        .top {
            border-top: 1px solid black;
        }

        .bottom {
            border-bottom: 1px solid black;
        }

        .left {
            border-left: 1px solid black;
        }

        .right {
            border-right: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        .td_height {
            height: 30px;
            min-height: 30px;
        }
    </style>
</head>

<body>

    <div class="for_accounting" style="page-break-after: always;">
        <table width="100%">
            <tr class="">
                <td width="50%" valign="top">
                    <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 300px;">
                    <br /><br />

                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->company_address_2; ?></p>
                    <span>Email : <?php echo $company_info->email_address; ?></span>
                    <p>Tel and Fax no.: <?php echo $company_info->landline . ' &nbsp;' . $company_info->mobile_no; ?></p>
                </td>
                <td width="50%" style="text-align: right;" valign="top">
                    <h1><b>PURCHASE ORDER</b></h1><br />
                    <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                        <tr>
                            <td width="65%">&nbsp;</td>
                            <td width="35%" class="border default-color" align="center">
                                <b>ORDER NO</b>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $purchase_info->po_no; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><br /></td>
                        </tr>
                        <tr>
                            <td width="65%">&nbsp;</td>
                            <td width="35%" class="border default-color" align="center">
                                <b>DATE</b>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="border" style="padding: 5px 0px 5px 0px;" align="center">
                                <?php echo date('M d,Y', strtotime($purchase_info->date_created)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" cellpadding="5" class="table table-striped">
            <tr>
                <td colspan="2" align="right" style="padding: 5px;">
                    <span style="font-family: Courier New;font-size: 12pt;">Accounting Copy</span>
                    <br /><br />
                    Please supply and deliver in accordance with the terms and conditions set below:
                </td>
            </tr>
            <tr>
                <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                    <span class="default-color">SUPPLIER</span><br /><br />

                    <span style="font-size: 12pt;"><b><?php echo $purchase_info->supplier_name; ?></b></span><br />
                    <span>Cel No.:</span> <?php echo $purchase_info->contact_no; ?><br />
                    <span>Email:</span> <?php echo $purchase_info->email_address; ?><br />
                    <span>Attention: <b><?php echo $purchase_info->contact_name; ?></b></span>
                </td>
                <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                    <span class="default-color">DELIVER TO</span><br /><br />

                    <span><?php echo $purchase_info->address; ?></span>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="5" class="table table-striped">
            <tr>
                <td valign="top" class="default-color top left right">DELIVERY DATE</td>
                <td valign="top" class="default-color top left right">ARRIVAL DATE</td>
                <td valign="top" class="default-color top left right">PR NUMBER
                </td>
            </tr>
            <tr>
                <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                    <span><?php echo ($purchase_info->delivery_date != null || $purchase_info->delivery_date != '0000-00-00' ? date('M d,Y', strtotime($purchase_info->delivery_date)) : ""); ?></span>
                </td>
                <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                    <span><?php echo $purchase_info->term_description; ?></span>
                </td>
                <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                    <span><?php echo $purchase_info->pr_no; ?></span>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="6" class="table table-striped">
            <tr>
                <td width="15%" class="default-color border" valign="top">QTY</td>
                <td width="30%" class="default-color border" valign="top">DESCRIPTION</td>
                <td width="20%" class="default-color border" valign="top" align="right">RMB PRICE</td>
                <td width="20%" class="default-color border" valign="top" align="right">UNIT PRICE</td>
                <td width="20%" class="default-color border" valign="top" align="right">TOTAL</td>
            </tr>
            <?php $rmbTotal = 0;
            foreach ($po_items as $item) { ?>
                <tr>
                    <td class="left right"><?php echo number_format($item->po_qty, 2); ?></td>
                    <td class="left right"><?php echo $item->product_desc; ?></td>
                    <td class="left right" align="right"><?php echo number_format($item->rmb_price, 2); ?></td>
                    <td class="left right" align="right">P <?php echo number_format($item->po_price, 2); ?></td>
                    <td class="left right" align="right"><?php echo number_format($item->po_line_total_after_global, 2); ?></td>
                </tr>
            <?php $rmbTotal += ($item->po_qty * $item->rmb_price);
            } ?>
            <tr>
                <td colspan="3" class="top" rowspan="6" valign="top">
                    <table width="100%" style="font-size: 8pt;">
                        <tr>
                            <td valign="top">1.</td>
                            <td valign="top">
                                The Purchase Order No. marked above must appear in all invoices and/or delivery receipts of the Supplier.
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">2.</td>
                            <td valign="top">
                                <?php echo $company_info->company_name; ?> reserves the right to inspect the items and to reject the same if found not in accordance with the specifictions or not in good condition.
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">3.</td>
                            <td valign="top">
                                The original sales invoice and original delivery receipt should be submitted to the accounting department to process the payment.
                            </td>
                        </tr>
                    </table>

                </td>
                <td class="border" align="right">SUB-TOTAL RMB</td>
                <td class="border" align="right">
                    <?php echo number_format($rmbTotal, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right">SUB-TOTAL</td>
                <td class="border" align="right">
                    <?php echo number_format($purchase_info->total_after_discount, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right">SHIPPING COST</td>
                <td class="border" align="right">
                    <?php echo number_format($purchase_info->shipping_cost, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right">CUSTOM DUTIES</td>
                <td class="border" align="right">
                    <?php echo number_format($purchase_info->custom_duties, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right">OTHERS</td>
                <td class="border" align="right">
                    <?php echo number_format($purchase_info->other_amount, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right"><b>TOTAL AMOUNT DUE</b></td>
                <td class="border" align="right">
                    <?php echo number_format($purchase_info->grand_total_amount, 2); ?>
                </td>
            </tr>
        </table> <br />
        <table cellpadding="6" style="width: 100%">
            <tr>
                <td class="border" valign="top" style="min-height: 80px;height: 80px;">
                    Remarks: <br/>
                    <?php echo $purchase_info->remarks ?>
                </td>
            </tr>
        </table> <br />
        <table cellpadding="5" width="100%">
            <tr>
                <td width="15%" class="td_height border">Ship-out Date : </td>
                <td width="25%" class="td_height border">
                    <?php echo $purchase_info->ship_out_date == null ? "" : 
                    date('m/d/Y', strtotime($purchase_info->ship_out_date)) ?>
                </td>
                <td width="25%" class="td_height"></td>
                <td width="35%" class="td_height"></td>
            </tr>
            <tr>
                <td class="td_height border">Total Cartons : </td>
                <td class="td_height bottom border"></td>
                <td class="td_height"></td>
                <td class="td_height bottom"></td>
            </tr>
            <tr>
                <td class="td_height border">Total CBM : </td>
                <td class="td_height bottom border"></td>
                <td class="td_height"></td>
                <td valign="top" class="td_height" align="center">Checked By</td>
            </tr>
        </table>

        <br /><br /><br /><br />

        <?php include 'po_report_footer.php'; ?>
    </div>

    <div class="for_warehouse" style="page-break-after: inherit;">
        <table width="100%">
            <tr class="">
                <td width="50%" valign="top">
                    <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 300px;">
                    <br /><br />

                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->company_address_2; ?></p>
                    <span>Email : <?php echo $company_info->email_address; ?></span>
                    <p>Tel and Fax no.: <?php echo $company_info->landline . ' &nbsp;' . $company_info->mobile_no; ?></p>
                </td>
                <td width="50%" style="text-align: right;" valign="top">
                    <h1><b>PURCHASE ORDER</b></h1><br />
                    <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                        <tr>
                            <td width="65%">&nbsp;</td>
                            <td width="35%" class="border default-color" align="center">
                                <b>ORDER NO</b>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $purchase_info->po_no; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><br /></td>
                        </tr>
                        <tr>
                            <td width="65%">&nbsp;</td>
                            <td width="35%" class="border default-color" align="center">
                                <b>DATE</b>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="border" style="padding: 5px 0px 5px 0px;" align="center">
                                <?php echo date('M d,Y', strtotime($purchase_info->date_created)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" cellpadding="5" class="table table-striped">
            <tr>
                <td colspan="2" align="right" style="padding: 5px;">
                    <span style="font-family: Courier New;font-size: 12pt;">Warehouse Copy</span>
                    <br /><br />
                </td>
            </tr>
            <tr>
                <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                    <span class="default-color">SUPPLIER</span><br /><br />

                    <span style="font-size: 12pt;"><b><?php echo $purchase_info->supplier_name; ?></b></span><br />
                    <span>Cel No.:</span> <?php echo $purchase_info->contact_no; ?><br />
                    <span>Email:</span> <?php echo $purchase_info->email_address; ?><br />
                    <span>Attention: <b><?php echo $purchase_info->contact_name; ?></b></span>
                </td>
                <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                    <span class="default-color">DELIVER TO</span><br /><br />

                    <span><?php echo $purchase_info->address; ?></span>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="5" class="table table-striped">
            <tr>
                <td valign="top" class="default-color top left right">DELIVERY DATE</td>
                <td valign="top" class="default-color top left right">ARRIVAL DATE</td>
                <td valign="top" class="default-color top left right">PR NUMBER
                </td>
            </tr>
            <tr>
                <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                    <span><?php echo ($purchase_info->delivery_date != null || $purchase_info->delivery_date != '0000-00-00' ? date('M d,Y', strtotime($purchase_info->delivery_date)) : ""); ?></span>
                </td>
                <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                    <span><?php echo $purchase_info->term_description; ?></span>
                </td>
                <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                    <span><?php echo $purchase_info->pr_no; ?></span>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="6" class="table table-striped">
            <tr>
                <td width="15%" class="default-color border" valign="top">QTY</td>
                <td class="default-color border" valign="top">DESCRIPTION</td>
            </tr>
            <?php foreach ($po_items as $item) { ?>
                <tr>
                    <td class="left right bottom"><?php echo number_format($item->po_qty, 2); ?></td>
                    <td class="left right bottom"><?php echo $item->product_desc; ?></td>
                </tr>
            <?php } ?>
        </table> <br />

        <table width="100%">
            <!-- <tr>
                    <td valign="bottom" width="20%" class="td_height">Date of Arrival : </td>
                    <td valign="bottom" width="25%" class="td_height bottom"></td>
                    <td valign="bottom" width="25%" class="td_height"></td>
                    <td valign="bottom" width="30%" class="td_height"></td>
                </tr> -->
            <tr>
                <td valign="bottom" width="20%" class="td_height">Total Cartons : </td>
                <td valign="bottom" width="25%" class="td_height bottom"></td>
                <td valign="bottom" width="25%" class="td_height"></td>
                <td valign="bottom" width="30%" class="td_height bottom"></td>
            </tr>
            <tr>
                <td valign="bottom" class="td_height">Total CBM : </td>
                <td valign="bottom" class="td_height bottom"></td>
                <td valign="bottom" class="td_height"></td>
                <td valign="top" class="td_height" align="center">Checked By</td>
            </tr>
            <tr>
                <td valign="bottom" class="td_height">Shipping Receipt No. : </td>
                <td valign="bottom" class="td_height bottom"></td>
                <td valign="bottom" class="td_height"></td>
                <td valign="bottom" class="td_height"></td>
            </tr>
        </table>

        <br /><br /><br /><br />

    </div>

</body>

</html>