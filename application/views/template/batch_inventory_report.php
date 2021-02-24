<head>  
    <title>Inventory Report</title>
</head>
<body>
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
        .bold{
            font-weight: bold;
        }
        table{
            border-collapse: collapse;
        }
    </style>
<div>
    <table width="100%">
        <tr class="">
            <td width="50%" valign="top">
                <img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 70px; width: 300px;"> 
                <br/><br/>

                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="50%" style="text-align: right;" valign="top">
                <h1><b>INVENTORY REPORT</b></h1><br/>
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 5px 0px 5px 0px;" align="right">
                            <strong>As of Date :</strong> <br/>
                            <?php echo date('M d,Y',strtotime($date));?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br><br>
    <table width="100%">
        <tr>
            <td width="15%"><strong>DEPARTMENT</strong> : </td>
            <td width="85%"><?php echo $department; ?></td>
        </tr>
    </table>
    <br/>
    <table width="100%" >
        <thead>
            <tr>
                <td class="bottom bold" width="20%">PLU</td>
                <td class="bottom bold" width="30%">Description</td>
                <td class="bottom bold" width="15%" align="right">Quantity In</td>
                <td class="bottom bold" width="15%" align="right">Quantity Out</td>
                <td class="bottom bold" width="20%" align="right">On Hand</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product){ ?>
            <tr>
                <td><?php echo $product->product_code; ?></td>
                <td><?php echo $product->product_desc; ?></td>
                <td align="right"><?php echo number_format($product->quantity_in,2); ?></td>
                <td align="right"><?php echo number_format($product->quantity_out,2); ?></td>
                <td align="right"><?php echo number_format($product->total_qty_balance,2).' '.$product->parent_unit_name; ?></td>
            </tr>
            <?php } ?>


            <?php if(count($products)==0){ ?>
                <tr>
                    <td colspan="5" style="height: 40px;"><center>No records found.</center></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">&nbsp;</td>

            </tr>
        </tfoot>
    </table>

    
</div>





















