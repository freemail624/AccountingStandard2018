<!DOCTYPE html>
<html>
<head>
    <title>Parts Requisition & Issuance Slip</title>
    <style type="text/css">
        table.pris{
            border-collapse: collapse;
            border-radius: 1em;
            font-size: 9pt;
            font-family: calibri;
        }
        .top{
            border-top: 1px solid black;
        }
        .left{
            border-left: 1px solid black;
        }
        .right{
            border-right: 1px solid black;
        }   
        .bottom{
            border-bottom: 1px solid black;
        }   
        
        table.pris tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        table.pris tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

    </style>
</head>
<body>
    <table width="100%">
        <tr class="">
            <td width="25%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 100px; width: 150px;"> 
            </td>
            <td width="75%" valign="top">
                <strong style="font-size: 18pt;"><?php echo $company_info->company_name; ?></strong>
                <br/><br/>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
        </tr>
    </table>
    <br/>

    <table width="100%" cellspacing="5" cellpadding="5" class="pris">
        <tr>
            <td colspan="8" align="center" valign="top" class="top left right bottom">
                <strong>
                    <h2>Parts Requisition &amp; Issuance Slip # <?php echo $issuance_info->repair_order_no; ?></h2>
                </strong>
            </td>
        </tr>
        <tr>
            <td width="90%" colspan="6" class="left right bottom" valign="top" style="height: 100px;min-height: 100px;font-size: 11pt;">
                <?php echo $issuance_info->customer_no; ?><br/>
                <strong><?php echo $issuance_info->customer_name; ?></strong>
            </td>
            <td width="10%" colspan="2" class="right bottom" valign="top">
                RO NUMBER <br/>
                <?php echo $issuance_info->repair_order_no; ?>
            </td>
        </tr>
        <tr>
            <td width="20%" valign="middle" align="center" class="left bottom">
                <strong>Part Number</strong>
            </td>
            <td class="left bottom" width="30%"></td>
            <td valign="middle" align="center" class="left bottom" width="10%">
                <strong>BIN</strong>
            </td>
            <td valign="middle" align="center" class="left bottom" width="10%">
                <strong>CURR <br/> SOH</strong>
            </td>
            <td valign="middle" align="center" class="left bottom" width="10%">
                <strong>QTY <br/> ORD</strong>
            </td>
            <td valign="middle" align="center" class="left bottom" width="10%">
                <strong>QTY <br/> BO</strong>
            </td>
            <td valign="middle" align="center" class="left bottom" width="10%">
                <strong>QTY <br/> SUPP</strong>
            </td>
            <td valign="middle" align="center" class="left right bottom" width="10%">
                <strong>QTY <br/> PICKED</strong>
            </td>
        </tr>
        <?php foreach($issue_items as $item){ ?>
            <tr>
                <td class="left"><?php echo $item->product_code; ?></td>
                <td><?php echo $item->product_desc; ?></td>
                <td align="center"><?php echo $item->bin_code; ?></td>
                <td align="center"><?php echo number_format(0,0); ?></td>
                <td align="center"><?php echo number_format($item->issue_qty,0); ?></td>
                <td align="center"><?php echo number_format(0,0); ?></td>
                <td align="center"><?php echo number_format($item->issue_qty,0); ?></td>
                <td class="right" align="center" valign="bottom">________</td>
            </tr>
        <?php }?>
        <tr>
            <td class="left bottom"></td>
            <td class="bottom" style="font-size: 9pt;">***NOTHING FOLLOWS***</td>
            <td class="right bottom" colspan="6"></td>
        </tr>
    </table>
    <br/>
    <table width="100%">
        <tr>
            <td width="34%" style="padding-right: 20px;">
                <table width="100%" style="border-collapse: collapse;font-size: 7pt!important;">
                    <tr>
                        <td valign="top" class="top left right" style="font-size: 7pt!important;">Salesman/Date:</td>
                    </tr>
                    <tr>
                        <td class="left right" style="height: 50px;min-height: 50px;"></td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" class="top bottom right left" style="font-size: 10pt;">
                            Signtaure Over Printed Name
                        </td>
                    </tr>
                </table>
            </td>
            <td width="33%">
                <table width="100%" style="border-collapse: collapse;font-size: 7pt!important;">
                    <tr>
                        <td valign="top" class="top left right" style="font-size: 7pt!important;">Picker&amp;Issuer/Date:</td>
                    </tr>
                    <tr>
                        <td class="left right" style="height: 50px;min-height: 50px;"></td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" class="top bottom right left" style="font-size: 10pt;">
                            Signtaure Over Printed Name
                        </td>
                    </tr>
                </table>
            </td>
            <td width="33%" style="padding-left: 20px;">
                <table width="100%" style="border-collapse: collapse;font-size: 7pt!important;">
                    <tr>
                        <td valign="top" class="top left right" style="font-size: 7pt!important;">Received(Technician) Date:</td>
                    </tr>
                    <tr>
                        <td class="left right" style="height: 50px;min-height: 50px;"></td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" class="top bottom right left" style="font-size: 10pt;">
                            Signtaure Over Printed Name
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <span style="font-size: 8pt;margin-top: 10px;">Pick Slip Date/Time Printed: <?php echo date('m/d/Y h:i A'); ?></span>
</body>
</html>