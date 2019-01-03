        <style type="text/css">
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
    }
    @page {
                    size: auto;   /* auto is the initial value */
                    margin: .5in .5in 1in .5in; 
    }
/*    tr:hover {
        transition: .4s;
        background: #414141 !important;
        color: white;
    }

    tr:hover .btn {
        border-color: #494949!important;
        border-radius: 0!important;
        -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
    }*/
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black;}

.fifteen{ width: 20%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
        </style>
    <table width="100%" cellspacing="5" cellspacing="0">
        <tr>
            <td width="10%"  class=""><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%"  class="" >
                <h1 class="report-header" style="margin-bottom: 0"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>

        </tr>
    </table>
    <table width="100%" cellpadding="5" cellspacing="0">
        <tr>
                <td class="left bottom top"><span>Job Order Billing No:</span></td>
                <td class="bottom top"><?php echo $billing->jo_billing_no; ?></td>
                <td class="left bottom fifteen top">Invoice Date:</td>
                <td class="bottom right top"><?php echo  date_format(new DateTime($billing->date_invoice ),"m/d/Y"); ?></td>
        </tr>
        <tr>
                <td class="left bottom fifteen" ><span>Start Date:</span></td>
                <td class="bottom "><?php echo  date_format(new DateTime($billing->date_start ),"m/d/Y"); ?></td>
            <td class="left bottom "><span>End Date</span></td>
            <td class="bottom right"><?php echo  date_format(new DateTime($billing->date_due),"m/d/Y"); ?></td>
        </tr>

        <tr>
                <td class="left bottom fifteen" ><span>Supplier:</span></td>
                <td class="bottom "><?php echo $billing->supplier_name?></td>
                <td class="left bottom ">Department:</td>
                <td  class="bottom right "><?php echo $billing->department_name ?></td>
        </tr>
        <tr>

                <td class="left bottom ">Requested By:</td>
                <td  class="bottom  "><?php echo $billing->requested_by ?></td>
                <td class="left bottom "></td>
                <td  class="bottom right "></td>
        </tr>
    </table>
    <table width="100%"  style="font-family: tahoma;font-size: 11;" cellspacing="0" cellpadding="5">
            <thead>

            <tr>
                <th width="10%" style="text-align: center;height: 30px;padding: 6px;" class="left bottom">Item Code</th>
                <th width="30%" style="text-align: left;height: 30px;padding: 6px;" class="bottom left">Item Description</th>
                <th width="15%" style="text-align: center;height: 30px;padding: 6px;" class="bottom left">UM</th>
                <th width="10%" style="text-align: right;height: 30px;padding: 6px;" class="left bottom">Item Qty</th>
                <th width="15%" style="text-align: right;height: 30px;padding: 6px;" class="bottom left">Unit Cost</th>
                <th width="15%" style="text-align: right;height: 30px;padding: 6px;" class="bottom right left">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($billing_items as $item){ ?>
                <tr>
                    <td  class="left" style="text-align: center;padding: 6px;"><?php echo $item->job_code; ?></td>
                    <td  class="left" style="text-align: left;padding: 6px;"><?php echo $item->job_desc; ?></td>

                    <td  class="left" style="text-align: center;padding: 6px;"><?php echo $item->job_unit_name; ?></td>
                    <td  class="left" style="text-align: right;padding: 6px;"><?php echo $item->job_qty; ?></td>
                    <td  class="left" style="text-align: right;padding: 6px;"><?php echo number_format($item->job_price,2); ?></td>
                    <td class="left right" style="text-align: right;padding: 6px;"><?php echo number_format($item->job_line_total,2); ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
            <table width="100%" cellspacing="0" cellpadding="5">
                <tr>
                    <td colspan="2" class="left bottom top "></td>
                    <td style="width: 15%:height:40px;" class="text-left left bottom top "><strong>Gross Total:</strong></td>
                    <td style="width: 20%" class="bottom text-right top "><?php echo number_format($billing->total_amount,2); ?></td>
                    <td style="width: 10%" class="text-right left bottom top "><strong>Discount:</strong></td>
                    <td style="width: 20%" class="bottom text-right top "><?php echo number_format($billing->total_overall_discount_amount,2); ?></td>
                    <td style="width: 15%" class="text-left left bottom top "><strong>Net Total:</strong></td>
                    <td style="width: 20%" class="right bottom text-right top"><?php echo number_format($billing->total_amount_after_discount,2); ?></td>
                </tr>
            <tr>
            <td colspan="8" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;" class="left right"><b>Remarks</b> </td>
            </tr>
            <tr>
            <td colspan="8" style="text-align: left;;height: 30px;padding: 6px;" class="right left bottom"><?php echo $billing->remarks; ?></td>
            </tr>
                <tr>
                <td colspan="2" class="left ">Prepared By:</td>
                <td colspan="2" class="left">Approved By::</td>
                <td colspan="2" class="left">Date Received:</td>

                <td colspan="2" class="left right">Received By:</td>
                </tr>
                <tr style="">
                    <td style="width: 15%" class="text-left left bottom"> <br><br><br></td>
                    <td style="width: 20%" class="bottom"></td>
                    <td style="width: 10%" class="text-right left bottom"> </td>
                    <td style="width: 10%" class="text-right  bottom"> </td>
                    <td style="width: 10%" class="text-right left bottom"> </td>
                    <td style="width: 20%" class="bottom"> </td>
                    <td style="width: 15%" class="text-left left bottom"></td>
                    <td style="width: 20%" class="right bottom"></td>
                </tr>

            </table>
</table>
