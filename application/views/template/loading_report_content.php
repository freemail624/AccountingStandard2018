<!DOCTYPE html>
<html>
<head>
	<title>LOADING - REPORT</title>
	<style type="text/css">
		.tbl-info{
			border-collapse: collapse;
			font-size: 8pt;
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
			font-size: 8pt!important;
		}

		.font-items{
			font-size: 9pt!important;
		}

	</style>
</head>
<body>

	<?php 
		$c=count($customers)/25;
		$d=ceil($c);
		for($e=0; $e < $d; $e++){ 
	?>

	<table width="100%" cellpadding="4" cellspacing="4" class="tbl-info">
		<tr>
			<td width="50%" valign="top">
				<table width="100%" cellpadding="4" cellspacing="4" class="tbl-info">
					<tr>
						<td class="upp" width="38%">
							<strong>Date : </strong><?php echo $info[0]->loading_date; ?> </td>
						<td width="62%" class="font8 upp">
							<strong>ROUTE :</strong> <?php echo $info[0]->loading_place; ?>
						</td>
					</tr>
					<tr>
						<td class="upp"><strong>Driver : </strong> <?php echo $info[0]->driver_name; ?></td>
						<td class="font8 upp"><strong>Pahinante : </strong> <?php echo $info[0]->driver_pahinante; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top">
				<table width="100%" cellpadding="4" cellspacing="4" class="tbl-info" style="margin-left: 30px;">
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
				<table cellpadding="4" cellspacing="4" class="tbl-info" width="100%" style="border: 1px solid black;">
					<tr>
						<td class="upp border" width="5%"><center><strong>#</strong></center></td>
						<td class="upp border" width="40%"><center><strong>Customer</strong></center></td>
						<td class="upp border" width="20%"><center><strong>Amount Due</strong></center></td>
						<td class="upp border" width="20%"><center><strong>Basyo Out</strong></center></td>
						<td class="upp border" width="15%"><center><strong>Return Basyo</strong></center></td>
					</tr>
					<?php 
					$i=1+($e*25);

						if(count($customers)>0){
							foreach(array_slice($customers,0+($e*25),25) as $customer){
					?>
						<tr>
							<td class="border font8" width="5%" align="right"><?php echo $i;?></td>
							<td class="border font8 upp" width="40%"><?php echo $customer->customer_name; ?></td>
							<td class="border font8" width="20%" align="right"><?php echo number_format($customer->total_payment,2); ?></td>
							<td class="border font8" width="20%" align="right"><?php echo number_format($customer->total_qty,2); ?></td>
							<td class="border font8" width="15%"></td>
						</tr>					
					<?php $i++;}?>	

					<?php if(count(array_slice($customers,0+($e*25),25)) < 25){
						$a=$i;
						$total = 25 - count(array_slice($customers,0+($e*25),25));
						for ($i=0; $i < $total; $i++) { 
					?>
						<tr>
							<td class="border font8" width="5%" align="right"><?php echo $a; ?></td>
							<td class="border font8" width="40%">&nbsp;</td>
							<td class="border font8" width="20%">&nbsp;</td>
							<td class="border font8" width="20%">&nbsp;</td>
							<td class="border font8" width="15%">&nbsp;</td>
						</tr>
					<?php $a++;}}}?>

					<?php 
					$last = $d-1;
					if($e==$last){
					?>

						<tr>
							<td style="padding: 10px;" class="border font8 upp strong" align="right" colspan="2">Total:</td>
							<td style="padding: 10px;" class="border font8 strong" align="right"><?php echo number_format($grandtotal[0]->total_amount,2); ?></td>
							<td style="padding: 10px;" class="border font8 strong" align="right"><?php echo number_format($grandtotal[0]->total_inv_qty,2); ?></td>
							<td style="padding: 10px;" class="border font8">&nbsp;</td>						
						</tr>

					<?php }else{?>


						<tr>
							<td style="padding: 10px;" class="border font8 upp strong" align="right" colspan="2">&nbsp;</td>
							<td style="padding: 10px;" class="border font8 strong" align="right">&nbsp;</td>
							<td style="padding: 10px;" class="border font8 strong" align="right">&nbsp;</td>
							<td style="padding: 10px;" class="border font8">&nbsp;</td>						
						</tr>

					<?php }?>
				</table>
			</td>

			<td width="50%" valign="top">		

			<?php 
			if($e==0){?>

			<br/>
				<table cellspacing="4" cellpadding="4" class="tbl-info" width="100%" style="border: 1px solid black;margin-left: 30px;">
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

				<table cellspacing="4" cellpadding="4" class="tbl-info" width="50%" style="border: 1px solid black;margin-left: 30px;">
					<tr>
						<td class="border"><strong>TOTAL BASYO IN: Basyo na binalik sa Bodega</strong></td>
					</tr>
					<tr>
						<td class="border" style="padding: 25px;padding-bottom: 52px;">&nbsp;</td>
					</tr>
				</table>
				<br/>
				<table cellspacing="4" cellpadding="4" class="tbl-info" width="100%" style="border: 1px solid black;margin-left: 30px;">
					<tr>
						<td class="border upp strong" colspan="2"><strong><center>Daily Allowance</center></strong></td>
					</tr>
					<tr>
						<td class="border upp" colspan="2"><strong>Amount:</strong> 
						<?php if($info[0]->allowance_amount > 0){
								echo number_format($info[0]->allowance_amount,2);
						} ?></td>
					</tr>
					<tr>
						<td class="border upp" colspan="2"><strong>EXPENSES:</strong></td>
					</tr>
					<tr>
						<td class="border" colspan="2"><strong>Parking Fee:</strong></td>
					</tr>
					<tr>
						<td class="border" colspan="2"><strong>Gas Truck:</strong></td>
					</tr>
					<tr>
						<td class="border upp" colspan="2"><strong>Others:</strong></td>
					</tr>
					<tr>
						<td class="border" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td class="border upp strong" width="50%">Total:</td>
						<td class="border" width="50%">&nbsp;</td>
					</tr>
				</table>

				<?php } ?>	
			</td>
		</tr>
	</table>

	<?php }?>

	<br/>

	<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%">
		<?php 
		$a=count($items)/40;
		$b=ceil($a);
		for($x=0; $x < $b; $x++){ 
		?>
		<tr>
			<td width="50%" valign="top">
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%">
					<tr>
						<td colspan="3" valign="top" class="font-items upp" width="100%" style="padding-bottom: 20px;">
							<strong>ROUTE :</strong> <?php echo $info[0]->loading_place; ?><br/>
							<strong>LOADING # :</strong> <?php echo $info[0]->loading_no; ?><br/>
						</td>
					</tr>

						<?php 

							foreach($categories as $category){ 
							if(count(array_filter(array_slice($items,0+($x*40),20), function($p) use($category) {
								return $p->category_id == $category->category_id;
							})) >  0){
							?>

						<tr>
							<td valign="top" class="font-items" colspan="3" width="100%"><strong><?php echo $category->category_name; ?></strong> </td>
						</tr>
						<?php if(count($items)>0){
							foreach(array_slice($items,0+($x*40),20) as $item){
								if($category->category_id == $item->category_id){
						?>
							<tr>
								<td valign="top" class="font-items" width="50%" style="padding-left: 25px;"><?php echo $item->product_desc; ?></td>
								<td valign="top" class="font-items" width="10%" align="right"><?php echo number_format($item->inv_qty,2); ?></td>
								<td valign="top" class="font-items" width="40%">&nbsp;</td>
							</tr>
						<?php }}}?>

							<tr>
								<td valign="top" class="font-items" colspan="3">&nbsp;</td>
							</tr>
					<?php }}?>
				</table>
			</td>
			<td width="50%" valign="top">
				<table cellspacing="5" cellpadding="5" class="tbl-info" width="100%">

						<?php foreach($categories as $category){ 
							if(count(array_filter(array_slice($items,20+($x*40),20), function($p) use($category) {
								return $p->category_id == $category->category_id;
							})) >  0){
							?>
							<tr>
								<td valign="top" class="font-items" colspan="3" width="100%"><strong><?php echo $category->category_name; ?></strong> </td>
							</tr>
						<?php 
						if(count($items)>0){
							foreach(array_slice($items,20+($x*40),20) as $item){
								if($category->category_id == $item->category_id){
						?>
							<tr>
								<td valign="top" class="font-items" width="50%" style="padding-left: 25px;"><?php echo $item->product_desc; ?></td>
								<td valign="top" class="font-items" width="10%" align="right"><?php echo number_format($item->inv_qty,2); ?></td>
								<td valign="top" class="font-items" width="40%">&nbsp;</td>
							</tr>
						<?php }}}?>

							<tr>
								<td valign="top" class="font-items" colspan="3">&nbsp;</td>
							</tr>
					<?php }}?>
					<?php 
					$last = $b-1;
					if($x==$last){ ?>
						<tr>
							<td valign="top" class="font-items" colspan="3" width="100%"><strong>NOTE :</strong> <?php echo $info[0]->remarks; ?></td>
						</tr>
					<?php } ?>
				</table>
				<br/>
			</td>
		</tr>

		<?php if($b > 1){ ?>

		<tr>
			<td></td>
			<td align="right">Page <?php echo $x+1; ?> of <?php echo $b; ?></td>
		</tr>
		<?php }} ?>
	</table>

	<div style="position:absolute;bottom:0;width:100%;margin-right: 250px!important;margin-bottom: 80px; font-family: calibri;text-align: right;font-size: 9pt!important;">
			LOADED BY : <br/>
			CHECKED BY : <br/>
	</div>

</body>
</html>