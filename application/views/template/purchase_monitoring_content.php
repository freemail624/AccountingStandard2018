<!DOCTYPE html>
<html>
<head>
	<title>Purchase Monitoring</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}

		.report-header {
			font-size: 22px;
		}
        .right-align{
            text-align: right;
        }

	</style>
</head>
<body>
       <table width="100%">
        <tr>
<!--             <td width="10%"><img src="<?php //echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td> -->
            <td width="100%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><br/>

    <h3><strong>Purchase Monitoring</strong></h3>
    <span style="font-weight: bolder;">Product: </span>   <?php echo $product_name;?> <br>
    <span style="font-weight: bolder;">Date Range: </span>   <?php echo date( "F d, Y", strtotime($start_date) );?> - <?php echo date( "F d, Y", strtotime($end_date) );?>
    <br/><br/>

     <table width="100%" cellpadding="3" cellspacing="0">
    	<thead>
            <tr>
                <th style="text-align: left;width: 15%;border-bottom: 1px solid black;">Date Invoice</th>
                <th style="text-align: left;width: 25%;border-bottom: 1px solid black;">Product Description</th>
                <th style="text-align: right;width: 10%;border-bottom: 1px solid black;">Qty</th>
                <th style="text-align: right;width: 10%;border-bottom: 1px solid black;">Price</th>
                <th style="text-align: left;width: 25%;border-bottom: 1px solid black;">Supplier</th>
                <th style="text-align: left;width: 15%;border-bottom: 1px solid black;">Reference No</th>
            </tr>
    	</thead>
    	<tbody>
         <?php 
         foreach ($data as $data) { ?>
         <tr>
             <td><?php echo $data->date_delivered;  ?></td>
             <td><?php echo $data->product_desc; ?></td>
             <td align="right"><?php echo $data->dr_qty; ?></td>             
             <td align="right"><?php echo $data->dr_price; ?></td>
             <td><?php echo $data->supplier_name; ?></td>
             <td><?php echo $data->dr_invoice_no; ?></td>
         </tr>
        
        <?php } ?>   
        </tbody>
    </table>


</body>
</html>