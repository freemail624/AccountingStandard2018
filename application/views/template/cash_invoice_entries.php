<head>
    <title>Cash Invoice</title>
    </head>
    <body><style type="text/css" media="print">
  @page { size: portrait; }
</style>

<style>
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .data {
      /*      border-bottom: 1px solid #404040;*/
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

        hr {
     /*       border-top: 3px solid #404040;*/
        }
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black;}

.fifteen{ width: 20%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
</style>

<div>
    <table width="100%" cellspacing="5" cellspacing="0">
        <tr>
            <td width="10%"  class="bottom" style="object-fit: cover;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; height: 90px; text-align: left;"></td>
            <td width="60%"  class="bottom" >
                <h1 class="report-header" style="margin-bottom: 0"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
            <td width="30%" class="top left right bottom">
                <center><h2>INVOICE NO.</h2></center>
                <hr style="color:black!important">
                <?php echo $info->cash_inv_no; ?>
            </td>
        </tr>
    </table>


    <table cellspacing="0" cellpadding="5" width="100%">
    <tr>
        <td class="bottom left  fifteen">Customer:</td>
        <td class="bottom"><?php echo $info->customer_name; ?></td>
        <td class="bottom left  fifteen">Invoice Date:</td>
        <td class="bottom right"><?php echo  date_format(new DateTime($info->date_invoice),"m/d/Y"); ?></td>
    </tr>
    <tr>
        <td class="bottom left ">Contact Person:</td>
        <td class="bottom"><?php echo $info->contact_person; ?></td>
        <td class="bottom left ">Delivery (Due) Date:</td>
        <td class="bottom right"><?php echo  date_format(new DateTime($info->date_due),"m/d/Y"); ?></td>
    </tr>
    <tr>
        <td class="bottom left ">Discount: </td>
        <td class="bottom"><?php echo $info->discount_text; ?></td>
        <td class="bottom left ">Department:</td>
        <td class="bottom right"><?php echo $info->department_name; ?></td>
    </tr>
    </table>
    <center>
        <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <thead>
            <tr>
                <th width="50%" class="bottom left " style="text-align: left;height: 30px;padding: 6px;">Item</th>
                <th width="12%" class="bottom left" style="text-align: center;height: 30px;padding: 6px;">Qty</th>
                <th width="12%" class="bottom left" style="text-align: center;height: 30px;padding: 6px;">UM</th>
                <th width="12%" class="bottom left" style="text-align: right;height: 30px;padding: 6px;">Price</th>
                <th width="12%" class="bottom left" style="text-align: right;height: 30px;padding: 6px;">Discount</th>
                <th width="12%" class="bottom left" style="text-align: right;height: 30px;padding: 6px;">Gross</th>
                <th width="12%" class="bottom left right" style="text-align: right;height: 30px;padding: 6px;">Net Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($items as $item){ ?>
                <tr>
                    <td width="50%" class="left" style="text-align: left;height: 30px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td width="12%" class="left" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->inv_qty,2); ?></td>
                    <td width="12%" class="left" style="text-align: center;height: 30px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td width="12%" class="left" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->inv_price,2); ?></td>
                    <td width="12%" class="left" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->inv_discount,2); ?></td>
                    <td width="12%" class="left" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->inv_gross,2); ?></td>
                    <td width="12%" class="left right" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->inv_line_total_price,2); ?></td>
                </tr>
            <?php } ?>
<!--             <tr>
            <td colspan="6" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-right: 1px solid gray!important;">Remarks:</td>
            </tr>
            <tr>
            <td colspan="6" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-right: 1px solid gray!important;"><?php echo $sales_info->remarks; ?></td>
            </tr> -->
            </tbody>
</table>
   <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <tr>
                <td class="left right bottom top" colspan="4" style="width: 30%; text-align: left;height: 30px;padding: 6px;"><b>Remarks</b>: <?php echo $info->remarks; ?></td>

            </tr>
            <tr>
                <td class="left"  style="width: 30%; text-align: left;height: 30px;padding: 6px;"><b>Production Time:</b></td>
                <td class="left"   style="width: 30%;text-align: left;height: 30px;padding: 6px;"><b>Delivery Date:</b></td>
                <td class="left bottom"  style="width: 20%;text-align: left;height: 30px;padding: 6px;">Discount 1: </td>
                <td class="left bottom right"   style="width: 20%;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($info->total_discount,2); ?></td>
            </tr>
            <tr>
                <td class="left" style="text-align: left;height: 30px;padding: 6px;"></td>
                 <td class="left" style="text-align: left;height: 30px;padding: 6px;"></td>
                <td class="left bottom" style="text-align: left;height: 30px;padding: 6px;">Total before Tax : </td>
                <td class="left bottom right" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($info->total_before_tax,2); ?></td>
            </tr>
            <tr>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php  echo $info->production_time ;?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php echo  date_format(new DateTime($info->date_due),"m/d/Y"); ?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;">Tax Amount : </td>
                <td class="left bottom right"  style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($info->total_tax_amount,2); ?></td>
            </tr>
            <tr>
                <td class="left"   style="text-align: left;height: 30px;padding: 6px;"><b>Confirmed Order:</b></td>
                <td class="left"   style="text-align: left;height: 30px;padding: 6px;"><b>Received Po.</b></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;">Total after Tax : </td>
                <td class="left bottom right"  style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($info->total_after_tax,2); ?></td>
            </tr>
            <tr>
                <td class="left"  style="text-align: left;height: 30px;padding: 6px;"></td>
                <td class="left"  style="text-align: left;height: 30px;padding: 6px;"></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;">Discount 2 : </td>
                <td class="left bottom right" style="text-align: right;height: 30px;padding: 6px;;"><?php echo number_format($info->total_overall_discount_amount,2); ?></td>
            </tr>
            <tr>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php  echo $info->confirmed_order ;?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php  echo $info->received_po ;?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><strong>Total : </strong></td>
                <td class="left bottom right" style="text-align: right;height: 30px;padding: 6px;"><strong><?php echo number_format($info->total_after_discount,2); ?></strong></td>
            </tr>
        </table><br /><br />   
    </center>
</div>





















