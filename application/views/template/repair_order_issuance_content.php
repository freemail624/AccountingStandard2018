<!DOCTYPE html>
<html>
<head>
    <title><?php echo $info->repair_order_no; ?></title>
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
        .gray{
            background: lightgray;
        }
        .double-border-bottom{
            border-bottom: 1px double black;
        }
        hr{
            margin: 1;
            padding: 0;
        }
        .top{
            border-top: 1px solid lightgray;
        }
        .bottom{
            border-bottom: 1px solid lightgray;
        }      
        .left{
            border-left: 1px solid lightgray;
        }   
        .right{
            border-right: 1px solid lightgray;
        }             
        .border{
            border: 1px solid lightgray;
        }
        .black{
            border-color: black;
        }
        .footer{
            font-size: 6pt;
        }
        div {page-break-inside:avoid;}

    </style>
</head>
<body>
    <table width="100%">
        <tr class="">
            <td width="15%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 100px; width: 100px;"> 
            </td>
            <td width="55%" valign="top">
                <strong style="font-size: 18pt;"><?php echo $company_info->company_name; ?></strong>
                <br/><br/>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="30%" valign="top">
                <h3><b>REPAIR ORDER</b></h3><br/>
                <table width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td width="65%">CONTROL NO.</td>
                        <td width="35%"><?php echo $info->repair_order_no; ?></td>
                    </tr>
                    <tr>
                        <td width="65%">CUBE TOPPER NO.</td>
                        <td width="35%"></td>
                    </tr>                    
                </table>
            </td>
        </tr>
    </table>
    <br/>
    <table width="100%" border="1" cellspacing="5" cellpadding="5" style="font-size: 8.5pt;">
        <tr>
            <td valign="top" width="16%">
                Customer No. <br/> 
                <strong><?php echo $info->customer_no; ?></strong>
            </td>
            <td valign="top" colspan="4" rowspan="3" width="40%">
                Customer Name and Address <br/>
                <strong style="font-size: 10pt;">
                    <?php echo $info->customer_name; ?><br/>
                    <?php echo $info->address; ?>
                </strong>
            </td>
            <td valign="top">
                Plate No. <br/>
                <strong><?php echo $info->plate_no; ?></strong>
            </td>
            <td valign="top" colspan="2">
                Advisor <br/>
                <strong><?php echo $info->advisor_fullname; ?></strong>
            </td>
            <td valign="top">
                Doc. Date <br/>
                <strong><?php echo $info->document_date; ?></strong>
            </td>
        </tr>
        <tr>
            <td valign="top">
                Mode of Payment <br/>
            </td>
            <td valign="top">
                Km Reading <br/>
                <strong><?php echo number_format($info->km_reading,0); ?></strong>
            </td>
            <td valign="top" colspan="2">
                Next Svc Date <br/>
                <strong><?php echo $info->next_svc_date; ?></strong>
            </td>
            <td valign="top">
                Next Svc Km <br/>
                <strong><?php echo number_format($info->next_svc_km,0); ?></strong>
            </td>
        </tr>
        <tr>
            <td valign="top">
                Insurer <br/>
            </td>
            <td valign="top">
                Year/Make <br/>
                <strong><?php echo $info->year_make_id; ?></strong>
            </td>
            <td valign="top" colspan="2">
                Model <br/>
                <strong><?php echo $info->model_name; ?></strong>
            </td>
            <td valign="top">
                Color <br/>
                <strong><?php echo $info->color_name; ?></strong>
            </td>
        </tr>       
        <tr>
            <td valign="top">
                LOA No. <br/>
            </td>
            <td valign="top">
                Mobile No. <br/>
                <strong><?php echo $info->mobile_no; ?></strong>
            </td>
            <td valign="top" colspan="2">
                Tel No.(Home)<br/>
                <strong><?php echo $info->tel_no_home; ?></strong>
            </td>
            <td valign="top">
                Tel No.(Bus)<br/>
                <strong><?php echo $info->tel_no_bus; ?></strong>
            </td>
            <td valign="top" colspan="2">
                VIN/Chassis No. <br/>
                <strong><?php echo $info->chassis_no; ?></strong>
            </td>
            <td valign="top" colspan="2">
                Engine No. <br/>
                <strong><?php echo $info->engine_no; ?></strong>
            </td>   
        </tr>
        <tr>
            <td valign="top">
                LOA Date <br/>
            </td>
            <td valign="top" colspan="2">
                Representative Name <br/>
                <strong><?php echo $info->representative_name; ?></strong>
            </td>
            <td valign="top" colspan="2">
                Contact No(s) <br/>
                <strong><?php echo $info->representative_no; ?></strong>
            </td>
            <td valign="top">
                Selling Dealer <br/>
                <strong><?php echo $info->selling_dealer; ?></strong>
            </td>    
            <td valign="top" colspan="2">
                Delivery Date <br/>
                <strong><?php echo $info->delivery_date; ?></strong>
            </td>  
            <td valign="top">
                G.V.D. <br/>
            </td>       
        </tr>
        <tr>
            <td valign="top">
                Policy No <br/>
            </td>
            <td valign="top" colspan="2">
                Time Received <br/>
                <strong><?php echo $info->time_received; ?></strong>
            </td>
            <td valign="top" colspan="2">
                Date/Time Promised <br/>
                <strong><?php echo $info->date_time_promised; ?></strong>
            </td>
            <td valign="top">
                WTY Date <br/>
            </td>    
            <td valign="top" colspan="2">
                Ext. Wty Date <br/>
            </td>  
            <td valign="top">
                Wty Exp Date <br/> 
            </td>       
        </tr>       
    </table>

    <?php if(count($histories) > 0){ ?>

    <table width="100%" cellspacing="2" cellpadding="2" style="font-size: 7pt;border: 1px solid black;">
        <tr>
            <td valign="top" colspan="4">
                <strong>HISTORY</strong>
            </td>
        </tr>
        <tr>
            <td valign="top" align="center"><strong>DATE</strong></td>
            <td valign="top" align="center"><strong>REPAIR ORDER NO.</strong></td>
            <td valign="top" align="center"><strong>MILEAGE</strong></td>
            <td valign="top" align="center"><strong>SERVICE ADVISOR</strong></td>
        </tr>
        <?php foreach($histories as $history){ ?>
            <tr>
                <td valign="top" align="center"><?php echo $history->document_date; ?></td>
                <td valign="top" align="center"><?php echo $history->repair_order_no; ?></td>
                <td valign="top" align="center"><?php echo number_format($history->km_reading,0); ?></td>
                <td valign="top" align="center"><?php echo $history->advisor_fullname; ?></td>
            </tr>
        <?php }?>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>

    <?php } ?>

    <table width="100%" cellspacing="5" cellpadding="5" border="1" style="font-size: 7pt;">
        <tr>
            <td valign="top" width="50%">
                <strong>CUSTOMER'S REQUEST</strong><br/>
                <?php echo $info->customer_remarks; ?><br/>
            </td>
            <td valign="top" width="50%">
                <strong>ADVISOR'S RECOMMENDATION</strong><br/>
                ***<?php echo $info->advisor_remarks; ?>***<br/><br/>
            </td>           
        </tr>
    </table>
    <br/>
    <table width="100%" cellspacing="4" cellpadding="4" style="font-size: 8.5pt;padding: 10px;">
        <thead>
            <tr>
                <th valign="top" width="5%"><strong>Line</strong></th>
                <th valign="top" width="10%"><strong>Product</strong></th>
                <th valign="top" width="40%"><strong>Description</strong></th>
                <th valign="top" width="15%" align="right"><strong>Quantity</strong></th>
                <th valign="top" width="15%" align="right"><strong>Unit Price</strong></th>
                <th valign="top" width="15%" align="right"><strong>Amount</strong></th>
            </tr>
        </thead>
        <?php foreach($tbl_count as $tbl){
        ?>
            <tr>
                <td valign="top" colspan="2" class="gray">C</td>
                <td valign="top" colspan="4" class="gray">
                    <strong><?php echo $tbl->sdesc; ?></strong>
                </td>    
            </tr>
            <?php 

                $sub_total=0;
                    foreach($items as $item){
                    if($item->tbl_no == $tbl->tbl_no){
                    $sub_total+=$item->order_gross;
            ?>
                <tr>
                    <td valign="top"></td>
                    <td valign="top"><?php echo $item->unit_code; ?></td>
                    <td valign="top"><?php echo $item->product_desc; ?></td>
                    <td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
                    <td valign="top" align="right"></td>
                    <td valign="top" align="right"></td>
                </tr>
            <?php }}}?>
    </table>
</body>
</html>