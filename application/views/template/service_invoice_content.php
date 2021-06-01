<!DOCTYPE html>
<html>

<head>
    <title>Service Invoice</title>
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

        .gray {
            background: lightgray;
        }

        .double-border-bottom {
            border-bottom: 1px double black;
        }

        hr {
            margin: 1;
            padding: 0;
        }

        .top {
            border-top: 1px solid lightgray;
        }

        .bottom {
            border-bottom: 1px solid lightgray;
        }

        .left {
            border-left: 1px solid lightgray;
        }

        .right {
            border-right: 1px solid lightgray;
        }

        .border {
            border: 1px solid lightgray;
        }

        .black {
            border-color: black;
        }

        .footer {
            font-size: 6pt;
        }

        div {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <?php
    $pms_count = 0;
    $bpr_count = 0;
    $gj_count = 0;

    $taxable_sales = 0;
    $tax_exempted_sales = 0;
    $zero_rated_sales = 0;
    $non_taxable_sales = 0;
    $grand_sub_total = 0;
    $vat_total = 0;
    $grand_total = 0;

    $insured_taxable_sales = 0;
    $insured_tax_exempted_sales = 0;
    $insured_zero_rated_sales = 0;
    $insured_non_taxable_sales = 0;
    $insured_grand_sub_total = 0;
    $insured_vat_total = 0;
    $insured_grand_total = 0;
    ?>
    <div>
        <table width="100%">
            <tr class="">
                <td width="25%" valign="top">
                    <img src="<?php echo $company_info->logo_path; ?>" style="height: 100px; width: 150px;">
                </td>
                <td width="75%" valign="top">
                    <strong style="font-size: 18pt;"><?php echo $company_info->company_name; ?></strong>
                    <br /><br />
                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->company_address_2; ?></p>
                    <span>Email : <?php echo $company_info->email_address; ?></span>
                    <p>Tel and Fax no.: <?php echo $company_info->landline . ' &nbsp;' . $company_info->mobile_no; ?></p>
                </td>
            </tr>
        </table>
        <hr>
        <br /><br />
        <table width="100%">
            <tr>
                <td align="center">
                    <h1>SERVICE INVOICE</h1>
                </td>
            </tr>
        </table> <br />
        <table width="100%" cellspacing="5" cellspacing="5" border="1">
            <tr>
                <td colspan="7" valign="top"><strong>RO NO.</strong> <?php echo $service->repair_order_no; ?></td>
            </tr>
            <tr>
                <td valign="top" width="15%">
                    <strong>CUSTOMER NO.</strong><br />
                    <?php echo $service->customer_no; ?>
                </td>
                <td width="30%" valign="top" colspan="2" rowspan="4">
                    <strong>CUSTOMER NAME AND ADDRESS</strong><br />
                    <?php echo $service->customer_name; ?><br />
                    <?php echo $service->address; ?>
                </td>
                <td width="20%" valign="top">
                    <strong>TIN NO.</strong><br />
                    <?php echo $service->tin_no; ?>
                </td>
                <td width="20%" valign="top" colspan="2">
                    <strong>YEAR / MAKE / MODEL</strong><br />
                    <?php echo $service->year_make_id . ' ' . $service->model_name; ?>
                </td>
                <td width="15%" valign="top">
                    <strong>TEAM</strong><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>TIME RECEIVED</strong><br />
                    <?php echo $service->time_received; ?>
                </td>
                <td valign="top">
                    <strong>ADVISOR</strong><br />
                    <?php echo $service->advisor_fullname; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>COLOR</strong><br />
                    <?php echo $service->color_name; ?>
                </td>
                <td valign="top">
                    <strong>TAG NO.</strong><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>PLATE NO.</strong><br />
                    <?php echo $service->crp_no; ?>
                </td>
                <td valign="top">
                    <strong>MODEL NO.</strong><br />
                </td>
                <td valign="top" colspan="2">
                    <strong>CARLINE</strong><br />
                </td>
                <td valign="top">
                    <strong>ENG./TRANS</strong><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>STOCK NO.</strong><br />
                </td>
                <td valign="top">
                    <strong>CHASSIS NO.</strong><br />
                    <?php echo $service->chassis_no; ?>
                </td>
                <td valign="top">
                    <strong>KM</strong><br />
                    <?php echo number_format($service->km_reading, 0); ?>

                </td>
                <td valign="top">
                    <strong>PROD. DATE</strong><br />
                </td>
                <td valign="top">
                    <strong>DELIVERY DATE</strong><br />
                    <?php echo $service->delivery_date; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>HOME PHONE</strong><br />
                    <?php echo $service->tel_no_home; ?>
                </td>
                <td valign="top">
                    <strong style="font-size: 8pt;">REPRESENTATIVE</strong><br />
                    <?php echo $service->representative_name; ?>
                </td>
                <td valign="top">
                    <strong>SELLING DEALER</strong><br />
                    <?php echo $service->selling_dealer; ?>
                </td>
                <td valign="top">
                    <strong>E-MAIL</strong><br />
                    <?php echo $service->email_address; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>ENGINE NO.</strong><br />
                    <?php echo $service->engine_no; ?>
                </td>
                <td valign="top">
                    <strong>EXP. DATE</strong><br />
                    <?php echo $service->exp_date; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>BUSINESS PHONE</strong><br />
                    <?php echo $service->tel_no_bus; ?>
                </td>
                <td valign="top">
                    <strong>Mobile Number</strong><br />
                    <?php echo $service->mobile_no; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>ESTIMATED DATE AND TIME</strong><br />
                    <?php echo $service->date_time_promised; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>PO NO.</strong><br />
                </td>
                <td valign="top">
                    <strong>QUOTED PRICE</strong>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellspacing="5" cellspacing="5">
            <!-- <thead> -->
                <tr>
                    <th width="20%" valign="top" align="left" class="bottom black">
                        <strong>Part No.</strong>
                    </th>
                    <th width="32%" valign="top" align="left" class="bottom black">
                        <strong>DESCRIPTION</strong>
                    </th>
                    <th width="12%" valign="top" align="right" class="bottom black">
                        <strong>QUANTITY</strong>
                    </th>
                    <th width="12%" valign="top" align="left" class="bottom black">
                        <strong>/ UNIT</strong>
                    </th>
                    <th width="12%" valign="top" align="right" class="bottom black">
                        <strong>UNIT PRICE</strong>
                    </th>
                    <th width="12%" valign="top" align="right" class="bottom black">
                        <strong>AMOUNT</strong>
                    </th>
                </tr>
            <!-- </thead> -->
            <tbody>
                <?php foreach ($tbl_count as $tbl) { ?>
                    <tr>
                        <td valign="top" class="gray">C</td>
                        <td valign="top" class="gray" colspan="5">
                            <strong><?php echo $tbl->sdesc; ?></strong>
                        </td>
                    </tr>
                    <?php
                    $sub_total = 0;
                    foreach ($item_info as $item) {
                        if ($item->tbl_no == $tbl->tbl_no) {
                            $grand_sub_total += $item->service_non_tax_amount;
                            $vat_total += $item->service_tax_amount;
                            $grand_total += $item->service_line_total_price;

                            /* PMS */
                            if ($item->vehicle_service_id == 1) {
                                $pms_count++;
                            }
                            /* BPR */
                            if ($item->vehicle_service_id == 2) {
                                $bpr_count++;
                            }
                            /* GJ */
                            if ($item->vehicle_service_id == 3) {
                                $gj_count++;
                            }
                            $sub_total += $item->service_gross - $item->service_line_total_discount;
                    ?>
                            <tr>
                                <td valign="top"><?php echo $item->product_code; ?></td>
                                <td valign="top"><?php echo $item->product_desc; ?></td>
                                <td valign="top" align="right"><?php echo $item->service_qty + 0; ?></td>
                                <td valign="top"><?php echo $item->unit_name; ?></td>
                                <td valign="top" align="right"><?php echo number_format($item->service_price - ($item->service_line_total_discount / $item->service_qty), 2) ?></td>
                                <td valign="top" align="right"><?php echo number_format($item->service_gross - $item->service_line_total_discount, 2) ?></td>
                            </tr>
                    <?php }
                    } ?>
                    <tr>
                        <td valign="top" colspan="5" align="right">Sub-Total</td>
                        <td valign="top" align="right">
                            <hr><?php echo number_format($sub_total, 2); ?>
                            <hr>
                            <hr>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="height: 15px; min-height: 15px;">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" align="right">
                        <strong>Sub Total:</strong>
                    </td>
                    <td valign="top" align="right">
                        <strong>
                            <?php echo number_format($grand_sub_total, 2) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" align="right">
                        <strong>VAT:</strong>
                    </td>
                    <td valign="top" align="right">
                        <strong>
                            <?php echo number_format($vat_total, 2) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" align="right">
                        <strong>Grand Total:</strong>
                    </td>
                    <td valign="top" align="right">
                        <strong>
                            <?php echo number_format($grand_total, 2) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 15px; min-height: 15px;">
                        &nbsp;
                    </td>
                </tr>
            </tfoot>
        </table>
        <br />
        <table width="100%" style="margin-top: 3px;">
            <tr>
                <td valign="top" style="padding:0;font-size: 5pt;">
                    <strong>THIS IS NOT AN OFFICIAL RECEIPT. NOT VALID FOR CLAIMING INPUT TAX</strong>
                </td>
                <td valign="top" align="right" style="padding:0;font-size: 5pt;">
                    <?php echo date('m/d/Y h:i A') ?>
                </td>
            </tr>
        </table>
    </div>
    <?php if (count($insured_item_info) > 0) { ?>
    <div>
        <table width="100%">
            <tr class="">
                <td width="25%" valign="top">
                    <img src="<?php echo $company_info->logo_path; ?>" style="height: 100px; width: 150px;">
                </td>
                <td width="75%" valign="top">
                    <strong style="font-size: 18pt;"><?php echo $company_info->company_name; ?></strong>
                    <br /><br />
                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->company_address_2; ?></p>
                    <span>Email : <?php echo $company_info->email_address; ?></span>
                    <p>Tel and Fax no.: <?php echo $company_info->landline . ' &nbsp;' . $company_info->mobile_no; ?></p>
                </td>
            </tr>
        </table>
        <hr>
        <br /><br />
        <table width="100%">
            <tr>
                <td align="center">
                    <h1>SERVICE INVOICE</h1>
                </td>
            </tr>
        </table> <br />
        <table width="100%" cellspacing="5" cellspacing="5" border="1">
            <tr>
                <td colspan="7" valign="top"><strong>RO NO.</strong> <?php echo $service->repair_order_no; ?></td>
            </tr>
            <tr>
                <td valign="top" width="15%">
                    <strong>CONTACT</strong><br />
                    <?php echo $service->insurance_contact_person; ?>
                </td>
                <td width="30%" valign="top" colspan="2" rowspan="4">
                    <strong>INSURANCE AND ADDRESS</strong><br />
                    <?php echo $service->insurer_company; ?><br />
                    <?php echo $service->insurance_address; ?>
                </td>
                <td width="20%" valign="top">
                    <strong>TIN NO.</strong><br />
                    <?php echo $service->tin_no; ?>
                </td>
                <td width="20%" valign="top" colspan="2">
                    <strong>YEAR / MAKE / MODEL</strong><br />
                    <?php echo $service->year_make_id . ' ' . $service->model_name; ?>
                </td>
                <td width="15%" valign="top">
                    <strong>TEAM</strong><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>TIME RECEIVED</strong><br />
                    <?php echo $service->time_received; ?>
                </td>
                <td valign="top">
                    <strong>ADVISOR</strong><br />
                    <?php echo $service->advisor_fullname; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>COLOR</strong><br />
                    <?php echo $service->color_name; ?>
                </td>
                <td valign="top">
                    <strong>TAG NO.</strong><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>PLATE NO.</strong><br />
                    <?php echo $service->crp_no; ?>
                </td>
                <td valign="top">
                    <strong>MODEL NO.</strong><br />
                </td>
                <td valign="top" colspan="2">
                    <strong>CARLINE</strong><br />
                </td>
                <td valign="top">
                    <strong>ENG./TRANS</strong><br />
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>STOCK NO.</strong><br />
                </td>
                <td valign="top">
                    <strong>CHASSIS NO.</strong><br />
                    <?php echo $service->chassis_no; ?>
                </td>
                <td valign="top">
                    <strong>KM</strong><br />
                    <?php echo number_format($service->km_reading, 0); ?>

                </td>
                <td valign="top">
                    <strong>PROD. DATE</strong><br />
                </td>
                <td valign="top">
                    <strong>DELIVERY DATE</strong><br />
                    <?php echo $service->delivery_date; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>HOME PHONE</strong><br />
                </td>
                <td valign="top">
                    <strong style="font-size: 8pt;">REPRESENTATIVE</strong><br />
                    <?php echo $service->representative_name; ?>
                </td>
                <td valign="top">
                    <strong>SELLING DEALER</strong><br />
                    <?php echo $service->selling_dealer; ?>
                </td>
                <td valign="top">
                    <strong>E-MAIL</strong><br />
                    <?php echo $service->insurance_email_address; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>ENGINE NO.</strong><br />
                    <?php echo $service->engine_no; ?>
                </td>
                <td valign="top">
                    <strong>EXP. DATE</strong><br />
                    <?php echo $service->exp_date; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <strong>BUSINESS PHONE</strong><br />
                </td>
                <td valign="top">
                    <strong>Mobile Number</strong><br />
                    <?php echo $service->insurance_contact_no; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>ESTIMATED DATE AND TIME</strong><br />
                    <?php echo $service->date_time_promised; ?>
                </td>
                <td valign="top" colspan="2">
                    <strong>PO NO.</strong><br />
                </td>
                <td valign="top">
                    <strong>QUOTED PRICE</strong>
                </td>
            </tr>
        </table>
        <br />
        <table width="100%" cellspacing="5" cellspacing="5">
            <!-- <thead> -->
                <tr>
                    <th width="20%" valign="top" align="left" class="bottom black">
                        <strong>Part No.</strong>
                    </th>
                    <th width="32%" valign="top" align="left" class="bottom black">
                        <strong>DESCRIPTION</strong>
                    </th>
                    <th width="12%" valign="top" align="right" class="bottom black">
                        <strong>QUANTITY</strong>
                    </th>
                    <th width="12%" valign="top" align="left" class="bottom black">
                        <strong>/ UNIT</strong>
                    </th>
                    <th width="12%" valign="top" align="right" class="bottom black">
                        <strong>UNIT PRICE</strong>
                    </th>
                    <th width="12%" valign="top" align="right" class="bottom black">
                        <strong>AMOUNT</strong>
                    </th>
                </tr>
            <!-- </thead> -->
            <tbody>
                <?php foreach ($insured_tbl_count as $tbl) { ?>
                    <tr>
                        <td valign="top" class="gray">C</td>
                        <td valign="top" class="gray" colspan="5">
                            <strong><?php echo $tbl->sdesc; ?></strong>
                        </td>
                    </tr>
                    <?php
                    $sub_total = 0;
                    foreach ($insured_item_info as $item) {
                        if ($item->tbl_no == $tbl->tbl_no) {
                            $insured_grand_sub_total += $item->service_non_tax_amount;
                            $insured_vat_total += $item->service_tax_amount;
                            $insured_grand_total += $item->service_line_total_price;

                            /* PMS */
                            if ($item->vehicle_service_id == 1) {
                                $pms_count++;
                            }
                            /* BPR */
                            if ($item->vehicle_service_id == 2) {
                                $bpr_count++;
                            }
                            /* GJ */
                            if ($item->vehicle_service_id == 3) {
                                $gj_count++;
                            }
                            $insured_sub_total += $item->service_gross - $item->service_line_total_discount;
                    ?>
                            <tr>
                                <td valign="top"><?php echo $item->product_code; ?></td>
                                <td valign="top"><?php echo $item->product_desc; ?></td>
                                <td valign="top" align="right"><?php echo $item->service_qty + 0; ?></td>
                                <td valign="top"><?php echo $item->unit_name; ?></td>
                                <td valign="top" align="right"><?php echo number_format($item->service_price - ($item->service_line_total_discount / $item->service_qty), 2) ?></td>
                                <td valign="top" align="right"><?php echo number_format($item->service_gross - $item->service_line_total_discount, 2) ?></td>
                            </tr>
                    <?php }
                    } ?>
                    <tr>
                        <td valign="top" colspan="5" align="right">Sub-Total</td>
                        <td valign="top" align="right">
                            <hr><?php echo number_format($insured_sub_total, 2); ?>
                            <hr>
                            <hr>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="height: 15px; min-height: 15px;">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" align="right">
                        <strong>Sub Total:</strong>
                    </td>
                    <td valign="top" align="right">
                        <strong>
                            <?php echo number_format($insured_grand_sub_total, 2) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" align="right">
                        <strong>VAT:</strong>
                    </td>
                    <td valign="top" align="right">
                        <strong>
                            <?php echo number_format($insured_vat_total, 2) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" align="right">
                        <strong>Grand Total:</strong>
                    </td>
                    <td valign="top" align="right">
                        <strong>
                            <?php echo number_format($insured_grand_total, 2) ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="height: 15px; min-height: 15px;">
                        &nbsp;
                    </td>
                </tr>
            </tfoot>
        </table>
        <br />
        <table width="100%" style="margin-top: 3px;">
            <tr>
                <td valign="top" style="padding:0;font-size: 5pt;">
                    <strong>THIS IS NOT AN OFFICIAL RECEIPT. NOT VALID FOR CLAIMING INPUT TAX</strong>
                </td>
                <td valign="top" align="right" style="padding:0;font-size: 5pt;">
                    <?php echo date('m/d/Y h:i A') ?>
                </td>
            </tr>
        </table>
    </div>
    <?php } ?>
</body>

</html>