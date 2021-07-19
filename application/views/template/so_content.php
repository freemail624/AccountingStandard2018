<head>
    <title>Sales Order </title>
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
    </style>
</head>

<body>
    <div style="page-break-after: always;">
        <table width="100%">
            <tr class="">
                <td width="50%" valign="top">
                    <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 300px;">
                    <br /><br />

                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->company_address_2; ?></p>
                    <span>Email : <?php echo $company_info->email_address; ?></span>
                    <p>Tel and Fax no.: <?php echo $company_info->landline . ' &nbsp;' . $company_info->mobile_no; ?></p>
                    Department : <?php echo $sales_order->department_name; ?>
                </td>
                <td width="50%" style="text-align: right;" valign="top">
                    <h1><b>SALES ORDER</b></h1><br />
                    <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                        <tr>
                            <td width="65%">&nbsp;</td>
                            <td width="35%" class="border default-color" align="center">
                                <b>ORDER NO</b>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $sales_order->so_no; ?></td>
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
                                <?php echo date('M d,Y', strtotime($sales_order->date_order)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" cellpadding="5" class="table table-striped">
            <tr>
                <td colspan="2" align="right" style="padding: 5px;">Please supply and deliver in accordance with the terms and conditions set below:</td>
            </tr>
            <tr>
                <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                    <span class="default-color">CUSTOMER</span><br /><br />

                    <span style="font-size: 12pt;"><b><?php echo $sales_order->customer_name; ?></b></span><br />
                    <span>Cel No.:</span> <?php echo $sales_order->contact_no; ?><br />
                    <span>Email:</span> <?php echo $sales_order->email_address; ?><br />
                    <span>Attention: <b><?php echo $sales_order->contact_name; ?></b></span>
                </td>
                <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                    <span class="default-color">DELIVER TO</span><br /><br />

                    <span><?php echo $sales_order->address; ?></span>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellpadding="6" class="table table-striped">
            <tr>
                <td width="15%" class="default-color border" valign="top">QTY</td>
                <td width="35%" class="default-color border" valign="top">DESCRIPTION</td>
                <td width="25%" class="default-color border" valign="top" align="right">UNIT PRICE</td>
                <td width="25%" class="default-color border" valign="top" align="right">TOTAL</td>
            </tr>
            <?php
            $total_tax_amount = 0;
            $gross_total = 0;
            foreach ($sales_order_items as $item) {
                $total_tax_amount += $item->so_tax_amount;
                $gross_total += $item->so_gross; ?>
                <tr>
                    <td class="left right"><?php echo number_format($item->so_qty, 2); ?></td>
                    <td class="left right"><?php echo $item->product_desc; ?></td>
                    <td class="left right" align="right"><?php echo number_format($item->so_price, 2); ?></td>
                    <td class="left right" align="right"><?php echo number_format($item->so_gross, 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2" class="top" rowspan="4" valign="top">
                    <table width="100%" style="font-size: 8pt;">
                        <tr>
                            <td valign="top">1.</td>
                            <td valign="top">
                                The sales order no. marked above must appear in all invoices and/or delivery receipts of the customer.
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">2.</td>
                            <td valign="top">
                                The original sales invoice and original delivery receipt should be submitted to the accounting department to process the payment.
                            </td>
                        </tr>
                    </table>

                </td>
                <td class="border" align="right">SUB TOTAL</td>
                <td class="border" align="right">
                    <?php echo number_format($gross_total, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right">DISCOUNT</td>
                <td class="border" align="right">
                    <?php echo number_format($sales_order->total_discount + $sales_order->total_overall_discount_amount, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right">TAX AMOUNT</td>
                <td class="border" align="right">
                    <?php echo number_format($total_tax_amount, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border" align="right"><b>TOTAL AMOUNT DUE</b></td>
                <td class="border" align="right">
                    <?php echo number_format($sales_order->total_after_discount, 2); ?>
                </td>
            </tr>
        </table> <br />
        <table   style="width: 100%">
            <tr>
                <td class="border" valign="top" style="min-height: 80px;height: 80px;">
                    Remarks: <br/>
                    <?php echo $sales_order->remarks ?>
                </td>
            </tr>
        </table> <br /><br /><br /><br />
        <table cellpadding="6" style="width: 100%">
            <tr>
                <td style="width: 30%;" class="bottom"></td>
                <td></td>
                <td style="width: 30%;" class="bottom"></td>
                <td></td>
                <td style="width: 30%;" class="bottom"></td>
            </tr>
            <tr>
                <td align="center">Approved By</td>
                <td></td>
                <td align="center">Checked & Tested By</td>
                <td></td>
                <td align="center">Received By</td>
            </tr>
        </table> <br />

        <br /><br /><br /><br />

        <?php include 'po_report_footer.php'; ?>
    </div>

    <div>
        <table width="100%">
            <tr>
                <td valign="top" align="right">WAREHOUSE COPY</td>
            </tr>            
        </table><br/>
        <table width="100%">
            <tr>
                <td><strong>Customer Name : </strong><br/> <?php echo $sales_order->customer_name; ?></td>
                <td><strong>SO #: </strong><br/><?php echo $sales_order->so_no; ?></td>
                <td><strong>Date : </strong><br/><?php echo date('M d,Y', strtotime($sales_order->date_order)); ?></td>
            </tr>
        </table>
        <br/>
        <div style="height: 390px!important; min-height: 390px!important;">
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="10%" style="border-bottom: 1px solid black;"></td>
                    <td width="10%" style="border-bottom: 1px solid black;"><strong>QTY</strong></td>
                    <td width="45%" style="border-bottom: 1px solid black;"><strong>Description</strong></td>
                    <td width="35%" style="border-bottom: 1px solid black;"><strong>Remarks</strong></td>
                </tr>
                <?php foreach($sales_order_items as $items){?>
                    <tr>
                        <td align="center">
                            <input type="checkbox" class="form-control" style="width: 100px!important; height: 100px!important;">
                        </td>
                        <td><?php echo $items->so_qty; ?></td>
                        <td><?php echo $items->product_desc; ?></td>
                        <td style="border-bottom: 1px solid gray;">&nbsp;</td>
                    </tr>
                <?php }?>
            </table>
        </div>

        <table width="100%">
            <tr>
                <td>Item Prepared By : </td>
                <td>Date : </td>
            </tr>
        </table>

        <div style="border-bottom: 1px dashed black;">&nbsp;</div>
        <br/><br/>
        <table width="100%">
            <tr>
                <td valign="top" align="right">ACCOUNTING COPY</td>
            </tr>            
        </table><br/>
        <table width="100%">
            <tr>
                <td><strong>Customer Name : </strong><br/> <?php echo $sales_order->customer_name; ?></td>
                <td><strong>SO #: </strong><br/><?php echo $sales_order->so_no; ?></td>
                <td><strong>Date : </strong><br/><?php echo date('M d,Y', strtotime($sales_order->date_order)); ?></td>
            </tr>
        </table>
        <br/>
        <div style="height: 390px!important; min-height: 390px!important;">
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="15%" style="border-bottom: 1px solid black;"><strong>QTY</strong></td>
                    <td width="55%" style="border-bottom: 1px solid black;"><strong>Description</strong></td>
                    <td width="15%" align="right" style="border-bottom: 1px solid black;"><strong>Unit Price</strong></td>
                    <td width="15%" align="right" style="border-bottom: 1px solid black;"><strong>Total</strong></td>
                </tr>
                <?php foreach($sales_order_items as $items){
                    $price = $items->so_price - $items->so_discount;
                    $overall_discount = ($sales_order->total_overall_discount/100);
                    $unit_price = $price - ($price * $overall_discount);
                ?>
                    <tr>
                        <td><?php echo $items->so_qty; ?></td>
                        <td><?php echo $items->product_desc; ?></td>
                        <td align="right"><?php echo number_format($unit_price,2); ?></td>
                        <td align="right"><?php echo number_format($items->so_line_total_price,2); ?></td>
                    </tr>
                <?php }?>
            </table>
        </div>



        <table width="100%">
            <tr>
                <td width="40%">Mode of Payment : </td>
                <td width="40%">Received By: </td>
                <td width="20%">Date : </td>
            </tr>
        </table>
    </div>
