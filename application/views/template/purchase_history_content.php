<!DOCTYPE html>
<html>
<head>
	<title>Purchase History</title>
	<style type="text/css">
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}
		.border-bottom{
			border-bottom: 1px solid black;
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
    <table width="100%">
    	<tr>
    		<td colspan="2">
    			<h3>Purchase History</h3>
    		</td>
    	</tr>
    	<tr>
    		<td width="15%">Supplier : </td>
    		<td width="85%"><?php echo $supplier_name; ?></td>
    	</tr>
    	<tr>
    		<td>Department : </td>
    		<td><?php echo $department_name; ?></td>
    	</tr>
			<tr>
    		<td>Receipt Type : </td>
    		<td><?php echo $inv_receipt_type; ?></td>
    	</tr>
    	<tr>
    		<td colspan="2"><?php echo 'From '.$from.' to '.$to; ?></td>
    	</tr>
    </table><br/>

    <table width="100%" style="border-collapse: collapse;" cellpadding="3" cellspacing="3">
    	<tr>
    		<td width="16%" class="border-bottom"><strong>Invoice #</strong></td>
				<td width="14%" class="border-bottom"><strong>Receipt Type</strong></td>
				<td width="10%" class="border-bottom"><strong>Receipt No</strong></td>
    		<td width="19%" class="border-bottom"><strong>Supplier</strong></td>
    		<td width="12%" class="border-bottom"><strong>Department</strong></td>
    		<td width="11%" class="border-bottom"><strong>PO#</strong></td>
    		<td width="8%" class="border-bottom"><strong>Terms</strong></td>
    		<td width="10%" class="border-bottom"><strong>Delivered</strong></td>
    	</tr>
    	<?php foreach($data as $data){ ?>
    		<tr>
    			<td><?php echo $data->dr_invoice_no; ?></td>
					<td><?php echo $data->inv_receipt_type; ?></td>
					<td><?php echo $data->external_ref_no; ?></td>
    			<td><?php echo $data->supplier_name; ?></td>
    			<td><?php echo $data->department_name; ?></td>
    			<td><?php echo $data->po_no; ?></td>
    			<td><?php echo $data->term_description; ?></td>
    			<td><?php echo $data->date_delivered; ?></td>
    		</tr>
    	<?php }?>
    </table>
</body>
</html>