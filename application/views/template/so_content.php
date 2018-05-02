     
     <head>  <title>Sales Order </title></head>
<body> <style type="text/css">
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

        .align-center {
            text-align: center;
        }

        .report-header 
{            font-weight: bolder;
        }
            table{
        border:none!important;
    }
    td.left{
        border-left: 1px solid gray!important;
    }
    td.right{
        border-right: 1px solid gray!important;
    }
    td.bottom{
        border-bottom: 1px solid gray!important;
    }
    td.top{
        border-top: 1px solid gray!important;
    }
</style>
<div>
<table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; text-align: left;"></td>
            <td width="90%" class=''>
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>

    <center>
        <table width="95%" cellpadding="5" style="font-family: tahoma;font-size: 11;">
            <tr class="row_child_tbl_so_list">
                <td width="50%"  style="border: 0px !important;">
                    Sales Order No. &nbsp;<?php echo $sales_order->so_no; ?><br />
                    Customer : &nbsp;<?php echo $sales_order->customer_name; ?>
                </td>
                <td width="45%" valign="top" style="border: 0px !important;"><br />
                    Order date :<?php echo  date_format(new DateTime($sales_order->date_order),"m/d/Y"); ?><br>
                    Discount: &nbsp;<?php echo $sales_order->discount_text; ?>

                </td>


            </tr>
            <tr>
                <td><b>Label :</b> <?php  echo $sales_order->label?></td>
            </tr>
            <tr>
                <td><b>Direct Print :</b> <?php  echo $sales_order->direct_print?></td>
            </tr>
        </table>
    </center>

    <br /><br />

    <center>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <thead>
            <tr>
                <th width="40%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Item</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Qty</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: center;height: 30px;padding: 6px;">UM</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Price</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Discount</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Gross</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($sales_order_items as $item){ ?>
                <tr>
                    <td width="40%" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_qty,2); ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: center;height: 30px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_price,2); ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_discount,2); ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_gross,2); ?></td>

                    <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_line_total_price,2); ?></td>
                </tr>
            <?php } ?>
                <tr>
                <td colspan="7" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;">Remarks:</td>
                </tr>
                <tr>
                <td colspan="7" style="text-align: left;font-weight: bolder; ;height: 30px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $sales_order->remarks; ?></td>
                </tr>
            </tbody>
        </table>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <tr>
                <td class="left"  style="width: 30%; text-align: left;height: 30px;padding: 6px;"><b>Production Time:</b></td>
                <td class="left"   style="width: 30%;text-align: left;height: 30px;padding: 6px;"><b>Delivery Date:</b></td>
                <td class="left bottom"  style="width: 20%;text-align: left;height: 30px;padding: 6px;">Discount 1: </td>
                <td class="left bottom right"   style="width: 20%;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($sales_order->total_discount,2); ?></td>
            </tr>
            <tr>
                <td class="left" style="text-align: left;height: 30px;padding: 6px;"></td>
                 <td class="left" style="text-align: left;height: 30px;padding: 6px;"></td>
                <td class="left bottom" style="text-align: left;height: 30px;padding: 6px;">Total before Tax : </td>
                <td class="left bottom right" style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($sales_order->total_before_tax,2); ?></td>
            </tr>
            <tr>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php  echo $sales_order->production_time ;?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php echo  date_format(new DateTime($sales_order->date_due),"m/d/Y"); ?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;">Tax Amount : </td>
                <td class="left bottom right"  style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($sales_order->total_tax_amount,2); ?></td>
            </tr>
            <tr>
                <td class="left"   style="text-align: left;height: 30px;padding: 6px;"><b>Confirmed Order:</b></td>
                <td class="left"   style="text-align: left;height: 30px;padding: 6px;"><b>Received Po.</b></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;">Total after Tax : </td>
                <td class="left bottom right"  style="text-align: right;height: 30px;padding: 6px;"><?php echo number_format($sales_order->total_after_tax,2); ?></td>
            </tr>
            <tr>
                <td class="left"  style="text-align: left;height: 30px;padding: 6px;"></td>
                <td class="left"  style="text-align: left;height: 30px;padding: 6px;"></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;">Discount 2 : </td>
                <td class="left bottom right" style="text-align: right;height: 30px;padding: 6px;;"><?php echo number_format($sales_order->total_overall_discount_amount,2); ?></td>
            </tr>
            <tr>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php  echo $sales_order->confirmed_order ;?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><?php  echo $sales_order->received_po ;?></td>
                <td class="left bottom"  style="text-align: left;height: 30px;padding: 6px;"><strong>Total : </strong></td>
                <td class="left bottom right" style="text-align: right;height: 30px;padding: 6px;"><strong><?php echo number_format($sales_order->total_after_discount,2); ?></strong></td>
            </tr>
        </table><br /><br />
    </center>
</div>





















