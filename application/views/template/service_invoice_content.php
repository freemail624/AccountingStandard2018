<!DOCTYPE html>
<html>
<head>
    <title>Service Invoice</title>
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

    <?php 
        $pms_count=0;
        $bpr_count=0;
        $gj_count=0;

        $taxable_sales=0;
        $tax_exempted_sales=0;
        $zero_rated_sales=0;
        $non_taxable_sales=0;
        $grand_sub_total=0;
        $vat_total=0;
        $grand_total=0;

        foreach($item_info as $item){

            $grand_sub_total+=$item->service_non_tax_amount;
            $vat_total+=$item->service_tax_amount;
            $grand_total+=$item->service_line_total_price;

            /* PMS */
            if($item->vehicle_service_id == 1){
                $pms_count++;
            }
            /* BPR */
            if($item->vehicle_service_id == 2){
                $bpr_count++;
            }
            /* GJ */
            if($item->vehicle_service_id == 3){
                $gj_count++;
            }
        }
    ?>

    <table width="100%">
        <tr class="">
            <td width="15%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 100px; width: 100px;"> 
            </td>
            <td width="85%" valign="top">
                <strong style="font-size: 18pt;"><?php echo $company_info->company_name; ?></strong>
                <br/><br/>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
        </tr>
    </table>
    <hr>
    <br/><br/>
    <table width="100%">
        <tr>
            <td align="center">
                <h1>SERVICE INVOICE</h1>
            </td>
        </tr>
    </table> <br/>

    <table width="100%" cellspacing="5" cellspacing="5" border="1">
        <tr>
            <td colspan="7" valign="top"><strong>RO NO.</strong> <?php echo $service->repair_order_no; ?></td>
        </tr>
        <tr>
            <td valign="top" width="15%">
                <strong>CUSTOMER NO.</strong><br/>
                <?php echo $service->customer_no; ?>
            </td>
            <td width="30%" valign="top" colspan="2" rowspan="4">
                <strong>CUSTOMER NAME AND ADDRESS</strong><br/>
                <?php echo $service->customer_name; ?><br/>
                <?php echo $service->address; ?>
            </td>
            <td width="20%" valign="top">
                <strong>TIN NO.</strong><br/>
                <?php echo $service->tin_no; ?>
            </td>
            <td width="20%" valign="top" colspan="2">
                <strong>YEAR / MAKE / MODEL</strong><br/>
                <?php echo $service->year_make_id.' '.$service->model_name; ?>
            </td>
            <td width="15%" valign="top">
                <strong>TEAM</strong><br/>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <strong>TIME RECEIVED</strong><br/>
                <?php echo $service->time_received; ?>
            </td>
            <td valign="top">
                <strong>ADVISOR</strong><br/>
                <?php echo $service->advisor_fullname; ?>
            </td>
            <td valign="top" colspan="2">
                <strong>COLOR</strong><br/>
                <?php echo $service->color_name; ?>
            </td>
            <td valign="top">
                <strong>TAG NO.</strong><br/>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <strong>PLATE NO.</strong><br/>
                <?php echo $service->plate_no; ?>
            </td>
            <td valign="top">
                <strong>MODEL NO.</strong><br/>
            </td>
            <td valign="top" colspan="2">
                <strong>CARLINE</strong><br/>
            </td>
            <td valign="top">
                <strong>ENG./TRANS</strong><br/>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <strong>STOCK NO.</strong><br/>
            </td>
            <td valign="top">
                <strong>CHASSIS NO.</strong><br/>
                <?php echo $service->chassis_no; ?>
            </td>
            <td valign="top">
                <strong>KM</strong><br/>
                <?php echo number_format($service->km_reading,0); ?>

            </td>
            <td valign="top">
                <strong>PROD. DATE</strong><br/>
            </td>
            <td valign="top">
                <strong>DELIVERY DATE</strong><br/>
                <?php echo $service->delivery_date; ?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <strong>HOME PHONE</strong><br/>
                <?php echo $service->tel_no_home; ?>
            </td>
            <td valign="top">
                <strong style="font-size: 8pt;">REPRESENTATIVE</strong><br/>
                <?php echo $service->representative_name; ?>
            </td>
            <td valign="top">
                <strong>SELLING DEALER</strong><br/>
                <?php echo $service->selling_dealer; ?>
            </td>
            <td valign="top">
                <strong>E-MAIL</strong><br/>
                <?php echo $service->email_address; ?>
            </td>
            <td valign="top" colspan="2">
                <strong>ENGINE NO.</strong><br/>
                <?php echo $service->engine_no; ?>
            </td>
            <td valign="top">
                <strong>EXP. DATE</strong><br/>
                <?php echo $service->exp_date; ?>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <strong>BUSINESS PHONE</strong><br/>
                <?php echo $service->tel_no_bus; ?>
            </td>
            <td valign="top">
                <strong>Mobile Number</strong><br/>
                <?php echo $service->mobile_no; ?>
            </td>
            <td valign="top" colspan="2">
                <strong>ESTIMATED DATE AND TIME</strong><br/>
                <?php echo $service->date_time_promised; ?>
            </td>
            <td valign="top" colspan="2">
                <strong>PO NO.</strong><br/>
            </td>
            <td valign="top">
                <strong>QUOTED PRICE</strong>
            </td>
        </tr>        
    </table>
    <table width="100%" cellspacing="5" cellspacing="5">
        <tr>
            <td width="20%" valign="top" class="top bottom left black">
                <strong>Part No.</strong></td>
            <td width="32%" valign="top" class="top bottom black">
                <strong>DESCRIPTION</strong></td>
            <td width="12%" valign="top" class="top bottom black" align="right">
                <strong>QUANTITY</strong></td>
            <td width="12%" valign="top" class="top bottom black" align="left">
                <strong>/ UNIT</strong></td>
            <td width="12%" valign="top" class="top bottom black" align="right">
                <strong>UNIT PRICE</strong></td>
            <td width="12%" valign="top" class="top bottom right black" align="right">
                <strong>AMOUNT</strong></td>
        </tr>
        <?php foreach($vehicle_services as $sv){ 
            if($sv->vehicle_service_id == 1){
                if($pms_count > 0){
        ?>
            <tr>
                <td valign="top" class="left black gray">C</td>
                <td valign="top" colspan="5" class="right black gray">
                    <strong><?php echo $service->pms_desc; ?></strong>
                </td>
            </tr>
            <?php 
                $sub_total=0;
                foreach($item_info as $item){
                if($item->vehicle_service_id == $sv->vehicle_service_id){
                $sub_total+=$item->service_gross;
            ?>
                <tr>
                    <td valign="top" class="left black"><?php echo $item->product_code; ?></td>
                    <td valign="top"><?php echo $item->product_desc; ?></td>
                    <td valign="top" align="right"><?php echo $item->service_qty + 0;?></td>
                    <td valign="top"><?php echo $item->unit_name; ?></td>
                    <td valign="top" align="right"><?php echo number_format($item->service_price,2) ?></td>
                    <td valign="top" class="right black" align="right"><?php echo number_format($item->service_gross,2) ?></td>
                </tr>
            <?php }}?>
            <tr>
                <td valign="top" class="left black" colspan="5" align="right">Sub-Total</td>
                <td valign="top" class="right black" align="right"><hr><?php echo number_format($sub_total,2); ?> <hr><hr></td>
            </tr>
        <?php }}
            if($sv->vehicle_service_id == 2){
                if($bpr_count > 0){
        ?>
             <tr>
                <td valign="top" class="left black gray">C</td>
                <td valign="top" colspan="5" class="right black gray">
                    <strong><?php echo $service->pms_desc; ?></strong>
                </td>
            </tr>
            <?php 
                $sub_total=0;
                foreach($item_info as $item){
                if($item->vehicle_service_id == $sv->vehicle_service_id){
                $sub_total+=$item->service_gross;
            ?>
                <tr>
                    <td valign="top" class="left black"><?php echo $item->product_code; ?></td>
                    <td valign="top"><?php echo $item->product_desc; ?></td>
                    <td valign="top" align="right"><?php echo $item->service_qty + 0;?></td>
                    <td valign="top"><?php echo $item->unit_name; ?></td>
                    <td valign="top" align="right"><?php echo number_format($item->service_price,2) ?></td>
                    <td valign="top" class="right black" align="right"><?php echo number_format($item->service_gross,2) ?></td>
                </tr>
            <?php }}?>
            <tr>
                <td valign="top" class="left black" colspan="5" align="right">Sub-Total</td>
                <td valign="top" class="right black" align="right"><hr><?php echo number_format($sub_total,2); ?> <hr><hr></td>
            </tr>
        <?php }}
            if($sv->vehicle_service_id == 3){
                if($gj_count > 0){
        ?>
             <tr>
                <td valign="top" class="left black gray">C</td>
                <td valign="top" colspan="5" class="right black gray">
                    <strong><?php echo $service->pms_desc; ?></strong>
                </td>
            </tr>
            <?php 
                $sub_total=0;
                foreach($item_info as $item){
                if($item->vehicle_service_id == $sv->vehicle_service_id){
                $sub_total+=$item->service_gross;
            ?>
                <tr>
                    <td valign="top" class="left black"><?php echo $item->product_code; ?></td>
                    <td valign="top"><?php echo $item->product_desc; ?></td>
                    <td valign="top" align="right"><?php echo $item->service_qty + 0;?></td>
                    <td valign="top"><?php echo $item->unit_name; ?></td>
                    <td valign="top" align="right"><?php echo number_format($item->service_price,2) ?></td>
                    <td valign="top" class="right black" align="right"><?php echo number_format($item->service_gross,2) ?></td>
                </tr>
            <?php }}?>
            <tr>
                <td valign="top" class="left black" colspan="5" align="right">Sub-Total</td>
                <td valign="top" class="right black" align="right"><hr><?php echo number_format($sub_total,2); ?> <hr><hr></td>
            </tr>
        <?php }}}?>
        <tr>
            <td colspan="6" class="left right black" style="height: 15px; min-height: 15px;">
                &nbsp;
            </td>
        </tr>
<!--         <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>Taxable Sales:</strong>
            </td>
            <td valign="top" align="right" class="right black">
                <strong>
                    <?php echo number_format($taxable_sales,2) ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>Tax-Exempt Sales:</strong>
            </td>
            <td valign="top" align="right" class="right black">
                <strong>
                    <?php echo number_format($tax_exempted_sales,2) ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>Zero-Rated Sales:</strong>
            </td>
            <td valign="top" align="right" class="right black">
                <strong>
                    <?php echo number_format($zero_rated_sales,2) ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>Non-Taxable Sales:</strong>
            </td>
            <td valign="top" align="right" class="right bottom black">
                <strong>
                    <?php echo number_format($non_taxable_sales,2) ?>
                </strong>
            </td>
        </tr> -->
        <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>Sub Total:</strong>
            </td>
            <td valign="top" align="right" class="right black">
                <strong>
                    <?php echo number_format($grand_sub_total,2) ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>VAT:</strong>
            </td>
            <td valign="top" align="right" class="right black">
                <strong>
                    <?php echo number_format($vat_total,2) ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="5" valign="top" align="right" class="left black">
                <strong>Grand Total:</strong>
            </td>
            <td valign="top" align="right" class="right black">
                <strong>
                    <?php echo number_format($grand_total,2) ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="left right bottom black" style="height: 15px; min-height: 15px;">
                &nbsp;
            </td>
        </tr>                                
    </table>
</body>
</html>