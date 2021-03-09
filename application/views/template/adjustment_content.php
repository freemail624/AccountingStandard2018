<head>
    <title>Item Adjustment</title>
    <style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .border{
            border: 1px solid black!important; 
        }

        .default-color{
            color:#2d419b;
            font-weight: bold; 
            font-size: 9pt;
        }
        .top{
            border-top: 1px solid black;
        }
        .bottom{
            border-bottom: 1px solid black;
        }
        .left{
            border-left: 1px solid black;
        }
        .right{
            border-right: 1px solid black;
        }
        table{
            border-collapse: collapse;
        }
    </style>
</head>
<body>

    <table width="100%">
        <tr class="">
            <td width="50%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 300px;"> 
                <br/><br/>

                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="50%" style="text-align: right;" valign="top">
                <h1>
                    <b>
                        <?php echo $adjustment_info->adjustment_type; ?>
                    </b>
                </h1><br/>
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                    <tr>
                        <td width="60%">&nbsp;</td>
                        <td width="40%" class="border default-color" align="center">
                            <b>ADJUSTMENT NO</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $adjustment_info->adjustment_code; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><br/></td>
                    </tr>
                    <tr>
                        <td width="60%">&nbsp;</td>
                        <td width="40%" class="border default-color" align="center">
                            <b>DATE</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center">
                            <?php echo date('M d,Y',strtotime($adjustment_info->date_adjusted));?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br/><br/>
    <table width="100%" cellpadding="5" class="table table-striped">
        <tr>
            <td width="50%" valign="top">
                <span class="default-color">DEPARTMENT : </span>
                <span style="font-size: 10pt;"><b><?php echo $adjustment_info->department_name; ?></b></span><br/>
            </td>   
            <td width="50%" valign="top" align="right">
                <?php if($adjustment_info->return_no != null || ""){?>
                    <span class="default-color">RETURN # : </span>
                    <span style="font-size: 10pt;"><b><?php echo $adjustment_info->return_no; ?></b></span><br/>
                <?php }?>
            </td>                       
        </tr>
    </table>
    <br/>
    <table width="100%" cellpadding="6" class="table table-striped">
        <tr>
            <td width="15%" class="default-color border" valign="top">QTY</td>
            <td width="25%" class="default-color border" valign="top">DESCRIPTION</td>
<!--             <td width="15%" class="default-color border" valign="top">EXPIRATION</td>
            <td width="15%" class="default-color border" valign="top">LOT#</td> -->
            <td width="15%" class="default-color border" valign="top" align="right">UNIT PRICE</td>
            <td width="15%" class="default-color border" valign="top" align="right">TOTAL</td>
        </tr>
        <?php 
            $total_tax_amount = 0;
            $total_discount = 0;
            $gross_total = 0;
            foreach($adjustment_items as $item){
            $total_tax_amount+=$item->adjust_tax_amount;
            $total_discount+=$item->adjust_line_total_discount+$item->global_discount_amount;
            $gross_total+=$item->adjust_price*$item->adjust_qty; ?>
        <tr>
            <td class="left right"><?php echo number_format($item->adjust_qty,2); ?></td>
            <td class="left right"><?php echo $item->product_desc; ?></td>
<!--             <td class="left right"><?php echo $item->exp_date; ?></td>
            <td class="left right"><?php echo $item->batch_no; ?></td> -->
            <td class="left right" align="right"><?php echo number_format($item->adjust_price,2); ?></td>
            <td class="left right" align="right"><?php echo number_format($item->adjust_price*$item->adjust_qty,2); ?></td>
        </tr>
        <?php }?>
        <tr>
            <td colspan="2" class="top" rowspan="4" valign="top">
                <table width="100%" style="font-size: 8pt;">
                    <tr>
                        <td valign="top" colspan="2" rowspan="2">
                            Remarks : <br/>
                            <?php echo $adjustment_info->remarks; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="border" colspan="" align="right">SUB TOTAL</td>
            <td class="border" align="right">
                <?php echo number_format($gross_total,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" colspan="" align="right">DISCOUNT</td>
            <td class="border" align="right">
                <?php echo number_format($total_discount,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" colspan="" align="right">TAX AMOUNT</td>
            <td class="border" align="right">
                <?php echo number_format($total_tax_amount,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" colspan="" align="right"><b>TOTAL AMOUNT DUE</b></td>
            <td class="border" align="right">
                <?php echo number_format($adjustment_info->total_after_tax,2); ?>
            </td>
        </tr>
    </table>

    <br/><br/><br/><br/>

    <?php include 'po_report_footer.php'; ?>       
    
</div>


















