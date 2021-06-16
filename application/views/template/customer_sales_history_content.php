<!DOCTYPE html>
<html>
<head>
	<title>Customer Sales History</title>
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

    <h3><strong>Customer Sales History</strong></h3>
    <span style="font-weight: bolder;">Customer : </span> <?php echo $customer_name;?> <br>
    <span style="font-weight: bolder;">Product : </span> <?php echo $product_name;?> <br>

    <br/><br/>

     <table width="100%" cellpadding="5" cellspacing="3" style="border-collapse: collapse;">
    	<thead>
            <tr>
            	<th style="width:15%; border-bottom: 1px solid black;text-align: left;">Invoice Date</th>
            	<th style="width:15%; border-bottom: 1px solid black;text-align: left;">Receipt No</th>
            	<th style="width:10%; border-bottom: 1px solid black;text-align: right;">Qty</th>
            	<th style="width:20%; border-bottom: 1px solid black;text-align: left;">Product Description</th>
            	<th style="width:10%; border-bottom: 1px solid black;text-align: right;">Price</th>
            	<th style="width:10%; border-bottom: 1px solid black;text-align: right;">Gross</th>
            	<th style="width:20%; border-bottom: 1px solid black;text-align: left;">Remarks</th>
            </tr>
    	</thead>
    	<tbody>
         <?php 
         foreach ($data as $data) { ?>
         <tr>
             <td valign="top"><?php echo $data->date_invoice;  ?></td>
             <td valign="top"><?php echo $data->receipt_no; ?></td>
             <td valign="top" align="right"><?php echo number_format($data->inv_qty,2); ?></td>             
             <td valign="top"><?php echo $data->product_desc; ?></td>
             <td valign="top" align="right"><?php echo number_format($data->inv_price,2); ?></td>
             <td valign="top" align="right"><?php echo number_format($data->inv_gross,2); ?></td>
             <td valign="top"><?php echo $data->remarks; ?></td>
         </tr>
        
        <?php } ?>   
        </tbody>
    </table>


</body>
</html>