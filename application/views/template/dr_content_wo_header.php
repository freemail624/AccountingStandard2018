<head>  <title>Purchase Invoice</title></head>
<body>
<style>
        body {
            /*font-family: 'Calibri',sans-serif;*/
            /*font-size: 12px;*/
        }
              .bottom-only{
      border:none!important;
      }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }
    tr {
/*        border: none!important;*/
    }

    tr:nth-child(even){
   /*     background: #414141 !important;*/
 /*       border: none!important;*/
    }

        table{
        /*border:none!important;*/
    }
</style>

<div>
    <center><table width="95%" cellpadding="5" style="font-family: tahoma;font-size: 11;border:none!important;" border="0">
            <tr>
                <td width="45%" valign="top" style="border: none;">
                    <span>Supplier :</span><br /><br />
                    <address>
                        <strong><?php echo $delivery_info->supplier_name; ?></strong><br>
                        <?php echo $delivery_info->address; ?><br>
                        <?php echo $delivery_info->email_address; ?><br>
                        <abbr title="Phone">P:</abbr> <?php echo $delivery_info->contact_no; ?>
                    </address>

                    <br />
                    <span>Contact Person :</span><br />
                    <strong><?php echo $delivery_info->contact_person; ?></strong><br>
                </td>

                <td width="50%" align="right" style="border: none;">
                    <h4>Purchase Invoice No.</h4>
                    <h4 class="text-navy"><?php echo $delivery_info->dr_invoice_no; ?></h4>

                    <span>Company :</span>
                    <address>
                        <strong><?php echo $company_info->company_name; ?></strong><br>
                        <strong><?php echo $company_info->company_address; ?></strong><br>
                        <abbr title="Phone">P:</abbr> <?php echo $company_info->landline; ?>
                    </address>
                    <br />

                    <p>

                        <span><strong>PO # : </strong> <?php echo  $delivery_info->po_no; ?></span><br />
                        <span><strong>Reference : </strong> <?php echo  $delivery_info->external_ref_no; ?></span><br />
                        <span><strong>Delivery Date : </strong> <?php echo  date_format(new DateTime($delivery_info->date_created),"m/d/Y"); ?></span><br />
                        <span><strong>Due Date : </strong> <?php echo  date_format(new DateTime($delivery_info->date_due),"m/d/Y"); ?></span><br />
                        <span><strong>Terms : </strong> <?php echo $delivery_info->term_description; ?></span>
                    </p>
                </td>
            </tr>
        </table></center>

    <br /><br />

    <center>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11;border:none!important;" >
            <thead>
            <tr>
                <th width="15%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Part Number</th>
                <th width="45%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Description</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Qty</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: center;height: 30px;padding: 6px;">UM</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Price</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($dr_items as $item){ ?>
                <tr>
                    <td style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;"><?php echo $item->product_code; ?></td>
                    <td style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;"><?php echo number_format($item->dr_qty,2); ?></td>
                    <td style="border-bottom: 1px solid gray;text-align: center;height: 15px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;"><?php echo number_format($item->dr_price,2); ?></td>
                    <td style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;"><?php echo number_format($item->dr_price*$item->dr_qty,2); ?></td>
                </tr>
            <?php } ?>
            <tr>
            <td colspan="6" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;"><b>Remarks:</b></td>
            </tr>
            <tr>
            <td colspan="6" style="text-align: left;font-weight: normal;height: 30px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $delivery_info->remarks; ?></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td align="left" colspan="2" style="border-left: 1px solid gray;padding: 6px;"><b>Prepared By:</b></td>
                <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 15px;border-left: 1px solid gray;" align="left">Total Gross:</td>
                <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 15px;border-right: 1px solid gray;" align="right"><?php echo number_format($delivery_info->total_overall_discount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;height: 15px;padding: 6px;border-left: 1px solid gray;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Discounts : </td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($delivery_info->total_overall_discount_amount+$delivery_info->total_discount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;height: 15px;padding: 6px;border-bottom: 1px solid gray;border-left: 1px solid gray;"></td>
                <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 15px;border-left: 1px solid gray;" align="left">Total Before Tax:</td>
                <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 15px;border-right: 1px solid gray;" align="right"><?php echo number_format($delivery_info->total_before_tax,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;"><b>Received By:</b></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Tax Amount : </td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($delivery_info->total_tax_amount,2); ?></td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="border-left: 1px solid gray;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Total After Tax : </td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($delivery_info->total_after_tax,2); ?></td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="border-left: 1px solid gray;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Shipping Cost : </td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($delivery_info->shipping_cost,2); ?></td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="border-left: 1px solid gray;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Custom Duties : </td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($delivery_info->custom_duties,2); ?></td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="border-left: 1px solid gray;"></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;">Other Amount : </td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><?php echo number_format($delivery_info->other_amount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;height: 15px;padding: 6px;border-bottom: 1px solid gray;border-left: 1px solid gray;">Date:</td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 15px;padding: 6px;border-left: 1px solid gray;"><strong>Total: </strong></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: right;height: 15px;padding: 6px;border-right: 1px solid gray;"><strong><?php echo number_format($delivery_info->grand_total_amount,2); ?></strong></td>
            </tr>
            </tfoot>
        </table><br /><br />
    </center>
</div>





















