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

		.font-items{
			font-size: 8pt!important;
		}

	</style>
</head>
<body>
	<table width="100%" cellpadding="5" cellspacing="5" class="tbl-info">
		<tr>
			<td width="50%" valign="top">
				<table width="100%" cellpadding="5" cellspacing="5" class="tbl-info">
					<tr>
						<td class="upp" width="50%">
							<strong>Date : </strong><?php echo $info[0]->loading_date; ?> </td>
						<td width="50%" class="font8 upp" align="right">
							<strong>ROUTE :</strong> <?php echo $info[0]->loading_place; ?>
						</td>
					</tr>
					<tr>
						<td class="upp"><strong>Driver : </strong> <?php echo $info[0]->agent_name; ?></td>
						<td class="font8 upp" align="right"><strong>Pahinante : </strong> Joash Noble</td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top">
				<table width="100%" cellpadding="5" cellspacing="5" class="tbl-info" style="margin-left: 30px;">
					<tr>
						<td class="upp" width="50%" valign="top"><strong>Truck # : </strong> <?php echo $info[0]->truck_no; ?></td>
						<td width="50%" class="upp" valign="top" style="font-size: 10pt;" align="right">
							<strong><?php echo $info[0]->loading_no; ?></strong>
						</td>
					</tr>
					<tr>
						<td class="upp"></td>
						<td class="font8 upp" align="right"></td>
					</tr>
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
						<td class="upp border" width="20%"><center><strong>Amount Due</strong></center></td>
						<td class="upp border" width="20%"><center><strong>Basyo Out</strong></center></td>
						<td class="upp border" width="15%"><center><strong>Return Basyo</strong></center></td>
					</tr>
					<?php 
					$i=1;
					foreach($customers as $customer){ ?>
						<tr>
							<td class="border font8" width="5%" align="right"><?php echo $i;?></td>
							<td class="border font8 upp" width="40%"><?php echo $customer->customer_name; ?></td>
							<td class="border font8" width="20%" align="right"><?php echo number_format($customer->total_payment,2); ?></td>
							<td class="border font8" width="20%" align="right"><?php echo number_format($customer->total_qty,2); ?></td>
							<td class="border font8" width="15%"></td>
						</tr>					
					<?php $i++;}?>	

					<?php if(count($customers) < 25){
						$a=$i;
						$total = 25 - count($customers);
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
						<td class="border" style="padding: 30px;padding-bottom: 52px;">&nbsp;</td>
					</tr>
				</table>
				<br/>
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%" style="border: 1px solid black;margin-left: 30px;">
					<tr>
						<td class="border upp strong" colspan="2"><strong><center>Daily Allowance</center></strong></td>
					</tr>
					<tr>
						<td class="border upp strong" colspan="2">Amount: 
						<?php if($info[0]->allowance_amount > 0){
								echo number_format($info[0]->allowance_amount,2);
						} ?></td>
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

	<br/>

	<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%">
		<tr>
			<td width="50%" valign="top">
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%">
					<tr>
						<td colspan="3" class="font-items" width="100%" style="padding-bottom: 20px;">
							<strong>ROUTE :</strong> <?php echo $info[0]->loading_place; ?>
						</td>
					</tr>

					<?php 
						$total_qty = 0;
						foreach($categories as $category){ ?>
						<tr>
							<td class="font-items" colspan="3" width="100%"><strong><?php echo $category->category_name; ?></strong></td>
						</tr>
						<?php if(count($items)>0){
							foreach($items as $item){
								if($category->category_id == $item->category_id){
								$total_qty+=$item->inv_qty;
						?>
							<tr>
								<td class="font-items" width="50%" style="padding-left: 25px;"><?php echo $item->product_desc; ?></td>
								<td class="font-items" width="10%" align="right"><?php echo number_format($item->inv_qty,2); ?></td>
								<td class="font-items" width="40%">&nbsp;</td>
							</tr>
						<?php }}}?>

							<tr>
								<td class="font-items" colspan="3">&nbsp;</td>
							</tr>
					<?php }?>
				</table>
			</td>
			<td width="50%" valign="top">
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%">
					<tr>
						<td class="font-items" width="100%">NOTE : <?php echo $info[0]->remarks; ?></td>
					</tr>
				</table>
				<br/>
			</td>
		</tr>
	</table>

	<div style="position:absolute;bottom:0;width:100%;margin-right: 250px!important;margin-bottom: 80px; font-family: calibri;text-align: right;font-size: 9pt!important;">
			LOADED BY : <br/>
			CHECKED BY : <br/>
	</div>

	
</body>
</html>