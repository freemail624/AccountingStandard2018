<!DOCTYPE html>
<html>
<head>
	<title>LOADING - REPORT</title>
	<style type="text/css">
		.tbl-info{
			border-collapse: collapse;
			font-family: calibri;
		}

		.upp{
			text-transform: uppercase;
		}

		.border{
			border: 1px solid black;
		}

		.border-bottom{
			border-bottom: 1px solid black;
		}

		.strong{
			font-weight: bold;
		}

	</style>
</head>
<body>
	<div style="padding: 20px;">
		<table cellpadding="5" cellspacing="5" class="tbl-info" width="100%" style="border: 1px solid black!important;">
			<tr>
				<td class="upp border" width="5%"><center><strong>#</strong></center></td>
				<td class="upp border" width="40%"><center><strong>Customer</strong></center></td>
				<td class="upp border" width="20%"><center><strong>Total Payment</strong></center></td>
				<td class="upp border" width="20%"><center><strong>Order Oil/Basyo</strong></center></td>
				<td class="upp border" width="15%"><center><strong>Return Basyo</strong></center></td>
			</tr>
			<?php 
			$i=1;
			$grand_total=0;
			$grand_total_qty=0;
			foreach($customers as $customer){
				$grand_total += $customer->total_payment;
				$grand_total_qty += $customer->total_qty;

			 	?>
				<tr>
					<td class="border" width="5%" align="right"><?php echo $i;?></td>
					<td class="border" width="40%"><?php echo $customer->customer_name; ?></td>
					<td class="border" width="20%" align="right"><?php echo number_format($customer->total_payment,2); ?></td>
					<td class="border" width="20%" align="right"><?php echo number_format($customer->total_qty,2); ?></td>
					<td class="border" width="15%"></td>
				</tr>					
			<?php $i++;}?>	
				<tr>
					<td class="border upp strong" align="right" colspan="2">Total:</td>
					<td class="border strong" align="right"><?php echo number_format($grand_total,2); ?></td>
					<td class="border strong" align="right"><?php echo number_format($grand_total_qty,2); ?></td>
					<td class="border">&nbsp;</td>						
				</tr>
		</table>
	</div>
</body>
</html>