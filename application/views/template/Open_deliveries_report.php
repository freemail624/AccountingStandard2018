<!DOCTYPE html>
<html>
<head>
	<title>Open Deliveries Report</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}
		table, th, td { border-color: white; }
		tr { border-bottom: none !important; }

		.report-header {
			font-size: 22px;
		}
		@media print {
      @page { margin: 0; }
      body { margin: 1.0cm; }
}

	</style>
	<script>
		(function(){
			window.print();
		})();
	</script>
</head>
<body>
	<table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%">
                <span class="report-header"><strong><?php echo $company_info->company_name;  ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong><center>OPEN DELIVERIES</center> </strong></h3>
    </div>


<?php foreach ($suppliers as $supplier) { ?>
<table  width="100%" cellpadding="3" cellspacing="0" border="1">
<thead>
<tr>
<td colspan="7"><strong>Supplier : </strong><?php echo $supplier->supplier_name; ?></strong></td>
</tr>
	<th width="20%" align="left">Purchase Invoice No</th>
	<th width="20%" align="left">Department</th>
	<th width="20%" align="left">PO #</th>
	<th width="10%" align="left">Date Delivered</th>
	<th width="10%" align="right">Total Amount</th>
	<th width="10%" align="right">Paid Amount</th>
	<th width="10%" align="right">Balance</th>
</thead>
<tbody>
<tr></tr>
    <?php foreach ($items as $item) {?>
		<?php if ($item->supplier_id == $supplier->supplier_id) { ?>
	<tr>
		<td width="20%"><?php echo $item->dr_invoice_no; ?> </td>
		<td width="20%"><?php echo $item->department_name; ?></td>
		<td width="20%"><?php echo $item->po_no; ?> </td> 
		<td width="10%"><?php echo $item->date_delivered; ?> </td>
		<td width="10%" align="right"><?php echo number_format($item->total_dr_amount,2); ?></td>
		<td width="10%" align="right"><?php echo number_format($item->total_cv_amount,2); ?> </td>
		<td width="10%" align="right"><?php echo number_format($item->Balance,2); ?> </td>
	</tr>
	<?php } ?>
<?php } ?> 

</tbody>
</table>
<br>
	<?php } ?>
<br>
