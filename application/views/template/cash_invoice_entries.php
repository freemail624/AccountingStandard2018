<head>
    <title>Cash Invoice</title>
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
<div>
    <table width="100%">
        <tr class="">
            <td width="10%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 100px; width: 100px;"> 
            </td>
            <td width="40%" valign="top">
                <h2>Le Mans Stellar Motor Corp.</h2>
                <br/>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="50%" style="text-align: right;" valign="top">
                <h1><b>CASH INVOICE</b></h1><br/>
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                    <tr>
                        <td width="60%">&nbsp;</td>
                        <td width="40%" class="border default-color" align="center">
                            <b>INVOICE NO</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $info->cash_inv_no; ?></td>
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
                            <?php echo date('M d,Y',strtotime($info->date_invoice));?>
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
                <span class="default-color">CUSTOMER</span><br/><br/>

                <span style="font-size: 12pt;"><b><?php echo $info->customer_name; ?></b></span><br/>
                <span>Cel No.:</span> <?php echo $info->contact_no; ?><br/>
                <span>Email:</span> <?php echo $info->email_address; ?><br/>
                <span>Attention: <b><?php echo $info->contact_person; ?></b></span>
            </td>
            <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
                <span class="default-color">DELIVER TO</span><br/><br/>

                <span><?php echo $info->address; ?></span>
            </td>
        </tr>
    </table>
    <br/>    
    <table width="100%" cellpadding="5" class="table table-striped">
        <tr>
            <td valign="top" width="50%" class="default-color top left right">DELIVERY DATE</td>
            <td valign="top" width="50%" class="default-color top left right">SO NUMBER
            </td>
        </tr>
        <tr>
            <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                <span><?php echo ($info->date_due!=null||$info->date_due!='0000-00-00'? date('M d,Y',strtotime($info->date_due)) : ""); ?></span>
            </td>
            <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
                <span><?php echo $info->so_no; ?></span>
            </td>
        </tr>
    </table>
    <br/>  
   <table width="100%" cellpadding="6" class="table table-striped">
        <tr>
            <td width="15%" class="default-color border" valign="top">QTY</td>
            <td width="35%" class="default-color border" valign="top">DESCRIPTION</td>
            <td width="25%" class="default-color border" valign="top" align="right">UNIT PRICE</td>
            <td width="25%" class="default-color border" valign="top" align="right">TOTAL</td>
        </tr>
        <?php 
            $total_tax_amount = 0;
            $gross_total=0;
            foreach($items as $item){
            $total_tax_amount+=$item->inv_tax_amount;
            $gross_total+=$item->inv_gross; ?>
        <tr>
            <td class="left right"><?php echo number_format($item->inv_qty,2); ?></td>
            <td class="left right"><?php echo $item->product_desc; ?></td>
            <td class="left right" align="right"><?php echo number_format($item->inv_price,2); ?></td>
            <td class="left right" align="right"><?php echo number_format($item->inv_gross,2); ?></td>
        </tr>
        <?php }?>
        <tr>
            <td colspan="2" class="top" rowspan="6" valign="top">
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
                <?php echo number_format($gross_total,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" align="right">DISCOUNT</td>
            <td class="border" align="right">
                <?php echo number_format($info->total_discount + $info->total_overall_discount_amount,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" align="right">TAX AMOUNT</td>
            <td class="border" align="right">
                <?php echo number_format($total_tax_amount,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" align="right"><b>TOTAL AMOUNT DUE</b></td>
            <td class="border" align="right">
                <?php echo number_format($info->total_after_discount,2); ?>
            </td>
        </tr>
        <tr>
            <td class="border" align="right"><b>TENDERED</b></td>
            <td class="border" align="right">
                <?php echo number_format($info->total_tendered,2); ?>
            </td>
        </tr>    
        <tr>
            <td class="border" align="right"><b>CHANGE</b></td>
            <td class="border" align="right">
                <?php echo number_format($info->total_change,2); ?>
            </td>
        </tr>                
    </table>
</div>





















