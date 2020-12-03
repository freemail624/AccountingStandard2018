<!DOCTYPE html>
<html>
<head>
	<title>LOADING - REPORT</title>
	<style type="text/css">
		.tbl-info{
			border-collapse: collapse;
			font-size: 7pt;
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

		.font8{
			font-size: 7pt!important;
		}

	</style>
</head>
<body>
	<table width="100%" cellpadding="5" cellspacing="5" class="tbl-info">
		<tr>
			<td width="50%" valign="top">
				<table width="100%" cellpadding="5" cellspacing="5" class="tbl-info">
					<tr>
						<td class="upp" width="15%"><strong>Date :</strong> </td>
						<td width="45%" class="border-bottom font8 upp"><?php echo $info[0]->loading_date; ?></td>
						<td width="40%"></td>
					</tr>
					<tr>
						<td class="upp"><strong>Driver :</strong></td>
						<td class="border-bottom font8 upp"><?php echo $info[0]->agent_name; ?></td>
						<td></td>
					</tr>
					<tr>
						<td class="upp"><strong>Place :</strong></td>
						<td class="border-bottom font8 upp"><?php echo $info[0]->loading_place; ?></td>
						<td></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top">
				<table width="100%" cellpadding="5" cellspacing="5" class="tbl-info" >
					<tr>
						<td width="100%" class="upp" colspan="2" style="font-size: 10pt;" align="right"><strong><?php echo $info[0]->loading_no; ?></strong></td>
					</tr>
<!-- 					<tr>
						<td width="20%" class="upp strong" valign="top">Remarks:</td>
						<td width="80%" class="font8 upp" valign="top"><?php echo $info[0]->remarks; ?></td>
					</tr> -->
				</table>				
			</td>
		</tr>
		<tr>
			<td width="50%" valign="top">
			<br/>
				<table cellpadding="5" cellspacing="5" class="tbl-info" width="100%" style="border: 1px solid black;">
					<tr>
						<td class="upp border" width="5%"><center><strong>#</strong></center></td>
						<td class="upp border" width="40%"><center><strong>Customer</strong></center></td>
						<td class="upp border" width="20%"><center><strong>Total Payment</strong></center></td>
						<td class="upp border" width="20%"><center><strong>Order Oil/Basyo</strong></center></td>
						<td class="upp border" width="15%"><center><strong>Return Basyo</strong></center></td>
					</tr>
					<?php 
					$i=1;
					foreach($items as $item){ ?>
						<tr>
							<td class="border font8" width="5%" align="right"><?php echo $i;?></td>
							<td class="border font8 upp" width="40%"><?php echo $item->customer_name; ?></td>
							<td class="border font8" width="20%" align="right"><?php echo number_format($item->total_payment,2); ?></td>
							<td class="border font8" width="20%" align="right"><?php echo number_format($item->total_qty,2); ?></td>
							<td class="border font8" width="15%"></td>
						</tr>					
					<?php $i++;}?>	

					<?php if(count($items) < 24){
						$a=$i;
						$total = 24 - count($items);
						for ($i=0; $i < $total; $i++) { 
					?>
						<tr>
							<td class="border font8" width="5%" align="right"><?php echo $a; ?></td>
							<td class="border font8" width="40%">&nbsp;</td>
							<td class="border font8" width="20%">&nbsp;</td>
							<td class="border font8" width="20%">&nbsp;</td>
							<td class="border font8" width="15%">&nbsp;</td>
						</tr>
					<?php $a++;}}?>
						<tr>
							<td style="padding: 10px;" class="border font8 upp strong" align="right" colspan="2">Total:</td>
							<td style="padding: 10px;" class="border font8 strong" align="right"><?php echo number_format($info[0]->total_amount,2); ?></td>
							<td style="padding: 10px;" class="border font8 strong" align="right"><?php echo number_format($info[0]->total_inv_qty,2); ?></td>
							<td style="padding: 10px;" class="border font8">&nbsp;</td>						
						</tr>
				</table>
			</td>

			<td width="50%" valign="top">		
			<br/>
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%" style="border: 1px solid black;margin-left: 30px;">
					<tr>
						<td class="upp border" colspan="3"><center><strong>Backload:</strong></center></td>
					</tr>
					<tr>
						<td class="border upp" width="10%"><center><strong>Qty</strong></center></td>
						<td class="border upp" width="35%"><center><strong>Item</strong></center></td>
						<td class="border upp" width="55%"><center><strong>Customer</strong></center></td>
					</tr>
					<?php for ($i=0; $i < 11; $i++) { ?>
						<tr>
							<td class="border">&nbsp;</td>
							<td class="border">&nbsp;</td>
							<td class="border">&nbsp;</td>
						</tr>
					<?php } ?>
				</table>
				<br/>

				<table cellspacing="5" cellpadding="5" class="tbl-info" width="50%" style="border: 1px solid black;margin-left: 30px;">
					<tr>
						<td class="border"><strong>TOTAL BASYO IN: Basyo na binalik sa Bodega</strong></td>
					</tr>
					<tr>
						<td class="border" style="padding: 30px;">&nbsp;</td>
					</tr>
				</table>
				<br/>
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%" style="border: 1px solid black;margin-left: 30px;">
					<tr>
						<td class="border upp strong" colspan="2"><strong><center>Daily Allowance</center></strong></td>
					</tr>
					<tr>
						<td class="border upp strong" colspan="2">Amount:</td>
					</tr>
					<tr>
						<td class="border upp strong" colspan="2">EXPENSES:</td>
					</tr>
					<tr>
						<td class="border strong" colspan="2">Parking Fee:</td>
					</tr>
					<tr>
						<td class="border strong" colspan="2">Gas Truck:</td>
					</tr>
					<tr>
						<td class="border upp strong" colspan="2">Others:</td>
					</tr>
					<tr>
						<td class="border" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td class="border upp strong" width="50%">Total:</td>
						<td class="border" width="50%">&nbsp;</td>
					</tr>
				</table>	
			</td>
		</tr>
	</table>
</body>
</html>