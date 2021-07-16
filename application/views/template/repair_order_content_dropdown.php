<!DOCTYPE html>
<html>
<head>
	<title>Repair Order</title>
	<style type="text/css">
		.emphasize{
			background: orange; font-size: 10pt;border: 1px solid black;
		}
		.gray{
			/*background: lightgray;*/
		}
	</style>
</head>
<body>

	<?php 

		$grand_total=0;
		$grand_total_discount=0;

		$total_pms_non_vat_amount=0;
		$total_pms_vat_amount=0;
		$total_pms_amount=0;

		$total_bpr_non_vat_amount=0;
		$total_bpr_vat_amount=0;
		$total_bpr_amount=0;

		$total_gj_non_vat_amount=0;
		$total_gj_vat_amount=0;
		$total_gj_amount=0;

		$total_internal_non_vat_amount=0;
		$total_internal_vat_amount=0;
		$total_internal_amount=0;

		$total_warranty_non_vat_amount=0;
		$total_warranty_vat_amount=0;
		$total_warranty_amount=0;

		$total_carwash_non_vat_amount=0;
		$total_carwash_vat_amount=0;
		$total_carwash_amount=0;

		$pms_count=0;
		$bpr_count=0;
		$gj_count=0;
		$internal_count=0;
		$warranty_count=0;
		$carwash_count=0;

		foreach($items as $item){

			$grand_total+=$item->order_line_total_after_global;
			$grand_total_discount+=$item->order_line_total_discount;

			/* PMS */
			if($item->vehicle_service_id == 1){
				$total_pms_non_vat_amount+=$item->order_non_tax_amount;
				$total_pms_vat_amount+=$item->order_tax_amount;
				$total_pms_amount+=$item->order_line_total_after_global;
				$pms_count++;
			}

			/* BPR */
			if($item->vehicle_service_id == 2){
				$total_bpr_non_vat_amount+=$item->order_non_tax_amount;
				$total_bpr_vat_amount+=$item->order_tax_amount;
				$total_bpr_amount+=$item->order_line_total_after_global;
				$bpr_count++;
			}

			/* GJ */
			if($item->vehicle_service_id == 3){
				$total_gj_non_vat_amount+=$item->order_non_tax_amount;
				$total_gj_vat_amount+=$item->order_tax_amount;
				$total_gj_amount+=$item->order_line_total_after_global;
				$gj_count++;
			}

			/* INTERNAL */
			if($item->vehicle_service_id == 4){
				$total_internal_non_vat_amount+=$item->order_non_tax_amount;
				$total_internal_vat_amount+=$item->order_tax_amount;
				$total_internal_amount+=$item->order_line_total_after_global;
				$internal_count++;
			}

			/* WARRANTY */
			if($item->vehicle_service_id == 5){
				$total_warranty_non_vat_amount+=$item->order_non_tax_amount;
				$total_warranty_vat_amount+=$item->order_tax_amount;
				$total_warranty_amount+=$item->order_line_total_after_global;
				$warranty_count++;
			}

			/* CARWASH */
			if($item->vehicle_service_id == 6){
				$total_carwash_non_vat_amount+=$item->order_non_tax_amount;
				$total_carwash_vat_amount+=$item->order_tax_amount;
				$total_carwash_amount+=$item->order_line_total_after_global;
				$carwash_count++;
			}
		}

	?>

	<div style="background: white;padding: 10px;">
		<div class="row">
			<div class="col-md-9">
				<table width="100%" class="table" border="1" cellspacing="0" cellpadding="0" style="font-size: 8pt;">
					<tr>
						<td valign="top" width="16%">
							Customer No. <br/> 
							<strong><?php echo $info->customer_no; ?></strong>
						</td>
						<td valign="top" colspan="4" rowspan="3" width="40%">
							Customer Name and Address <br/>
							<strong style="font-size: 10pt;">
								<?php echo $info->customer_name; ?><br/>
								<?php echo $info->address; ?>
							</strong>
						</td>
						<td valign="top">
							Plate No. <br/>
							<strong><?php echo $info->crp_no; ?></strong>
						</td>
						<td valign="top" colspan="2">
							Advisor <br/>
							<strong><?php echo $info->advisor_fullname; ?></strong>
						</td>
						<td valign="top">
							Doc. Date <br/>
							<strong><?php echo $info->document_date; ?></strong>
						</td>
					</tr>
					<tr>
						<td valign="top">
							Mode of Payment <br/>
						</td>
						<td valign="top">
							Km Reading <br/>
							<strong><?php echo number_format($info->km_reading,0); ?></strong>
						</td>
						<td valign="top" colspan="2">
							Next Svc Date <br/>
							<strong><?php echo $info->next_svc_date; ?></strong>
						</td>
						<td valign="top">
							Next Svc Km <br/>
							<strong><?php echo number_format($info->next_svc_km,0); ?></strong>
						</td>
					</tr>
					<tr>
						<td valign="top">
							Insurer <br/>
							<strong><?php echo $info->insurer_company; ?></strong>
						</td>
						<td valign="top">
							Year/Make <br/>
							<strong><?php echo $info->year_make_id; ?></strong>
						</td>
						<td valign="top" colspan="2">
							Model <br/>
							<strong><?php echo $info->model_name; ?></strong>
						</td>
						<td valign="top">
							Color <br/>
							<strong><?php echo $info->color_name; ?></strong>
						</td>
					</tr>    	
					<tr>
						<td valign="top">
							LOA No. <br/>
						</td>
						<td valign="top">
							Mobile No. <br/>
							<strong><?php echo $info->mobile_no; ?></strong>
						</td>
						<td valign="top" colspan="2">
							Tel No.(Home)<br/>
							<strong><?php echo $info->tel_no_home; ?></strong>
						</td>
						<td valign="top">
							Tel No.(Bus)<br/>
							<strong><?php echo $info->tel_no_bus; ?></strong>
						</td>
						<td valign="top" colspan="2">
							VIN/Chassis No. <br/>
							<strong><?php echo $info->chassis_no; ?></strong>
						</td>
						<td valign="top" colspan="2">
							Engine No. <br/>
							<strong><?php echo $info->engine_no; ?></strong>
						</td>	
					</tr>
					<tr>
						<td valign="top">
							LOA Date <br/>
						</td>
						<td valign="top" colspan="2">
							Representative Name <br/>
							<strong><?php echo $info->representative_name; ?></strong>
						</td>
						<td valign="top" colspan="2">
							Contact No(s) <br/>
							<strong><?php echo $info->representative_no; ?></strong>
						</td>
						<td valign="top">
							Selling Dealer <br/>
							<strong><?php echo $info->selling_dealer; ?></strong>
						</td>    
						<td valign="top" colspan="2">
							Delivery Date <br/>
							<strong><?php echo $info->delivery_date; ?></strong>
						</td>  
						<td valign="top">
							G.V.D. <br/>
						</td>  		
					</tr>
					<tr>
						<td valign="top">
							Policy No <br/>
						</td>
						<td valign="top" colspan="2">
							Time Received <br/>
							<strong><?php echo $info->time_received; ?></strong>
						</td>
						<td valign="top" colspan="2">
							Date/Time Promised <br/>
							<strong><?php echo $info->date_time_promised; ?></strong>
						</td>
						<td valign="top">
							WTY Date <br/>
						</td>    
						<td valign="top" colspan="2">
							Ext. Wty Date <br/>
						</td>  
						<td valign="top">
							Wty Exp Date <br/> 
						</td>  		
					</tr>    	
				</table>
				<br/>
			<?php if(count($histories) > 0){ ?>
				<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;border: 1px solid black;">
					<tr>
						<td valign="top" colspan="4" align="center">
							<strong>HISTORY</strong>
						</td>
					</tr>
					<tr>
						<td valign="top" align="center"><strong>DATE</strong></td>
						<td valign="top" align="center"><strong>REPAIR ORDER NO.</strong></td>
						<td valign="top" align="center"><strong>MILEAGE</strong></td>
						<td valign="top" align="center"><strong>SERVICE ADVISOR</strong></td>
					</tr>
					<?php foreach($histories as $history){ ?>
						<tr>
							<td valign="top" align="center"><?php echo $history->document_date; ?></td>
							<td valign="top" align="center"><?php echo $history->repair_order_no; ?></td>
							<td valign="top" align="center"><?php echo number_format($history->km_reading,0); ?></td>
							<td valign="top" align="center"><?php echo $history->advisor_fullname; ?></td>
						</tr>
					<?php }?>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
				</table>

				<?php } ?>

				<table width="100%" cellspacing="5" cellpadding="5" border="1" style="font-size: 8.5pt;">
					<tr>
						<td valign="top" width="50%" style="height: 80px; min-height: 80px;">
							<strong>CUSTOMER'S REQUEST</strong><br/>
							<?php echo $info->customer_remarks; ?><br/>
						</td>
						<td valign="top" width="50%">
							<strong>ADVISOR'S RECOMMENDATION</strong><br/>
							***<?php echo $info->advisor_remarks; ?>***<br/><br/>
						</td>    		
					</tr>
				</table>
				<br/><br/>
				<div class="tab-container tab-top tab-primary">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#pms_<?php echo $info->repair_order_id; ?>" data-toggle="tab"> PMS
									<span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">
										<?php echo number_format($pms_count,0); ?>
									</span> 
							</a>
						</li>
						<li>
							<a href="#bpr_<?php echo $info->repair_order_id; ?>" data-toggle="tab"> Body Paint Repair
								<span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">
								<?php echo number_format($bpr_count,0); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#gj_<?php echo $info->repair_order_id; ?>" data-toggle="tab"> General Job
								<span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">
									<?php echo number_format($gj_count,0); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#internal_<?php echo $info->repair_order_id; ?>" data-toggle="tab"> Internal
								<span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">
									<?php echo number_format($internal_count,0); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#warranty_<?php echo $info->repair_order_id; ?>" data-toggle="tab"> Warranty
								<span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">
									<?php echo number_format($warranty_count,0); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#carwash_<?php echo $info->repair_order_id; ?>" data-toggle="tab"> Carwash
								<span style="background: gray; color: white; border-radius: 50%;padding: 1px 5px;font-size: 8pt;">
									<?php echo number_format($carwash_count,0); ?>
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="pms_<?php echo $info->repair_order_id; ?>">
						<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;">
							<thead>
								<tr>
									<th valign="top" width="5%"><strong>Line</strong></th>
									<th valign="top" width="9%"><strong>Product</strong></th>
									<th valign="top" width="35%"><strong>Description</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Quantity</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Unit Price</strong></th>
									<th valign="top" width="12%" align="right" style="text-align: right;"><strong>Discount</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Amount</strong></th>
								</tr>
							</thead>
							<?php foreach($tbl_count as $tbl){ 
								if($tbl->vehicle_service_id == 1){
							?>
							<tr>
								<td valign="top" colspan="2" class="gray" style="background: lightgray!important;color: black;">C</td>
								<td valign="top" colspan="5" class="gray" style="background: lightgray!important;color: black;">
									<strong><?php echo $tbl->sdesc; ?></strong>
								</td>
							</tr>
							<?php 
								$sub_total=0;
								foreach($items as $item){
								if($item->tbl_no == $tbl->tbl_no){
								$sub_total+=$item->order_line_total_after_global;
							?>
							<tr>
								<td valign="top"></td>
								<td valign="top"><?php echo $item->unit_code; ?></td>
								<td valign="top"><?php echo $item->product_desc; ?></td>
								<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
							</tr>
							<?php }}?>
							<tr>
								<td valign="top" colspan="6" align="right"><strong>Sub-Total</strong></td>
								<td valign="top" align="right" class=""><strong><?php echo number_format($sub_total,2); ?></strong></td>
							</tr>
							<?php }}?>
						</table>
					</div>
					<div class="tab-pane" id="bpr_<?php echo $info->repair_order_id; ?>">
						<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;">
							<thead>
								<tr>
									<th valign="top" width="5%"><strong>Line</strong></th>
									<th valign="top" width="9%"><strong>Product</strong></th>
									<th valign="top" width="35%"><strong>Description</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Quantity</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Unit Price</strong></th>
									<th valign="top" width="12%" align="right" style="text-align: right;"><strong>Discount</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Amount</strong></th>
								</tr>
							</thead>
							<?php foreach($tbl_count as $tbl){ 
								if($tbl->vehicle_service_id == 2){
							?>
							<tr>
								<td valign="top" colspan="2" class="gray" style="background: lightgray!important;color: black;">C</td>
								<td valign="top" colspan="5" class="gray" style="background: lightgray!important;color: black;">
									<strong><?php echo $tbl->sdesc; ?></strong>
								</td>
							</tr>
							<?php 
								$sub_total=0;
								foreach($items as $item){
								if($item->tbl_no == $tbl->tbl_no){
								$sub_total+=$item->order_line_total_after_global;
							?>
							<tr>
								<td valign="top"></td>
								<td valign="top"><?php echo $item->unit_code; ?></td>
								<td valign="top"><?php echo $item->product_desc; ?></td>
								<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
							</tr>
							<?php }}?>
							<tr>
								<td valign="top" colspan="6" align="right"><strong>Sub-Total</strong></td>
								<td valign="top" align="right" class=""><strong><?php echo number_format($sub_total,2); ?></strong></td>
							</tr>
							<?php }}?>
						</table>
					</div>
					<div class="tab-pane" id="gj_<?php echo $info->repair_order_id; ?>">
						<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;">
							<thead>
								<tr>
									<th valign="top" width="5%"><strong>Line</strong></th>
									<th valign="top" width="9%"><strong>Product</strong></th>
									<th valign="top" width="35%"><strong>Description</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Quantity</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Unit Price</strong></th>
									<th valign="top" width="12%" align="right" style="text-align: right;"><strong>Discount</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Amount</strong></th>
								</tr>
							</thead>
							<?php foreach($tbl_count as $tbl){ 
								if($tbl->vehicle_service_id == 3){
							?>
							<tr>
								<td valign="top" colspan="2" class="gray" style="background: lightgray!important;color: black;">C</td>
								<td valign="top" colspan="5" class="gray" style="background: lightgray!important;color: black;">
									<strong><?php echo $tbl->sdesc; ?></strong>
								</td>
							</tr>
							<?php 
								$sub_total=0;
								foreach($items as $item){
								if($item->tbl_no == $tbl->tbl_no){
								$sub_total+=$item->order_line_total_after_global;
							?>
							<tr>
								<td valign="top"></td>
								<td valign="top"><?php echo $item->unit_code; ?></td>
								<td valign="top"><?php echo $item->product_desc; ?></td>
								<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
							</tr>
							<?php }}?>
							<tr>
								<td valign="top" colspan="6" align="right"><strong>Sub-Total</strong></td>
								<td valign="top" align="right" class=""><strong><?php echo number_format($sub_total,2); ?></strong></td>
							</tr>
							<?php }}?>
						</table>
					</div>
					<div class="tab-pane" id="internal_<?php echo $info->repair_order_id; ?>">
						<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;">
							<thead>
								<tr>
									<th valign="top" width="5%"><strong>Line</strong></th>
									<th valign="top" width="9%"><strong>Product</strong></th>
									<th valign="top" width="35%"><strong>Description</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Quantity</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Unit Price</strong></th>
									<th valign="top" width="12%" align="right" style="text-align: right;"><strong>Discount</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Amount</strong></th>
								</tr>
							</thead>
							<?php foreach($tbl_count as $tbl){ 
								if($tbl->vehicle_service_id == 4){
							?>
							<tr>
								<td valign="top" colspan="2" class="gray" style="background: lightgray!important;color: black;">C</td>
								<td valign="top" colspan="5" class="gray" style="background: lightgray!important;color: black;">
									<strong><?php echo $tbl->sdesc; ?></strong>
								</td>
							</tr>
							<?php 
								$sub_total=0;
								foreach($items as $item){
								if($item->tbl_no == $tbl->tbl_no){
								$sub_total+=$item->order_line_total_after_global;
							?>
							<tr>
								<td valign="top"></td>
								<td valign="top"><?php echo $item->unit_code; ?></td>
								<td valign="top"><?php echo $item->product_desc; ?></td>
								<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
							</tr>
							<?php }}?>
							<tr>
								<td valign="top" colspan="6" align="right"><strong>Sub-Total</strong></td>
								<td valign="top" align="right" class=""><strong><?php echo number_format($sub_total,2); ?></strong></td>
							</tr>
							<?php }}?>
						</table>
					</div>
					<div class="tab-pane" id="warranty_<?php echo $info->repair_order_id; ?>">
						<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;">
							<thead>
								<tr>
									<th valign="top" width="5%"><strong>Line</strong></th>
									<th valign="top" width="9%"><strong>Product</strong></th>
									<th valign="top" width="35%"><strong>Description</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Quantity</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Unit Price</strong></th>
									<th valign="top" width="12%" align="right" style="text-align: right;"><strong>Discount</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Amount</strong></th>
								</tr>
							</thead>
							<?php foreach($tbl_count as $tbl){ 
								if($tbl->vehicle_service_id == 5){
							?>
							<tr>
								<td valign="top" colspan="2" class="gray" style="background: lightgray!important;color: black;">C</td>
								<td valign="top" colspan="5" class="gray" style="background: lightgray!important;color: black;">
									<strong><?php echo $tbl->sdesc; ?></strong>
								</td>
							</tr>
							<?php 
								$sub_total=0;
								foreach($items as $item){
								if($item->tbl_no == $tbl->tbl_no){
								$sub_total+=$item->order_line_total_after_global;
							?>
							<tr>
								<td valign="top"></td>
								<td valign="top"><?php echo $item->unit_code; ?></td>
								<td valign="top"><?php echo $item->product_desc; ?></td>
								<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
							</tr>
							<?php }}?>
							<tr>
								<td valign="top" colspan="6" align="right"><strong>Sub-Total</strong></td>
								<td valign="top" align="right" class=""><strong><?php echo number_format($sub_total,2); ?></strong></td>
							</tr>
							<?php }}?>
						</table>
					</div>
					<div class="tab-pane" id="carwash_<?php echo $info->repair_order_id; ?>">
						<table width="100%" class="table table-striped" cellspacing="0" style="font-size: 8.5pt;">
							<thead>
								<tr>
									<th valign="top" width="5%"><strong>Line</strong></th>
									<th valign="top" width="9%"><strong>Product</strong></th>
									<th valign="top" width="35%"><strong>Description</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Quantity</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Unit Price</strong></th>
									<th valign="top" width="12%" align="right" style="text-align: right;"><strong>Discount</strong></th>
									<th valign="top" width="13%" align="right" style="text-align: right;"><strong>Amount</strong></th>
								</tr>
							</thead>
							<?php foreach($tbl_count as $tbl){ 
								if($tbl->vehicle_service_id == 6){
							?>
							<tr>
								<td valign="top" colspan="2" class="gray" style="background: lightgray!important;color: black;">C</td>
								<td valign="top" colspan="5" class="gray" style="background: lightgray!important;color: black;">
									<strong><?php echo $tbl->sdesc; ?></strong>
								</td>
							</tr>
							<?php 
								$sub_total=0;
								foreach($items as $item){
								if($item->tbl_no == $tbl->tbl_no){
								$sub_total+=$item->order_line_total_after_global;
							?>
							<tr>
								<td valign="top"></td>
								<td valign="top"><?php echo $item->unit_code; ?></td>
								<td valign="top"><?php echo $item->product_desc; ?></td>
								<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
								<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
							</tr>
							<?php }}?>
							<tr>
								<td valign="top" colspan="6" align="right"><strong>Sub-Total</strong></td>
								<td valign="top" align="right" class=""><strong><?php echo number_format($sub_total,2); ?></strong></td>
							</tr>
							<?php }}?>
						</table>
					</div>
			</div>	   	    
		</div>	
		<div class="col-md-3">
			<table width="100%" border="1" cellspacing="5" cellpadding="5" style="font-size: 8.5pt;">
				<tr>
					<td colspan="2" valign="top" align="center">
						<strong><i class="fa fa-file-o"></i> REPAIR ORDER</strong>	
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" align="center" class="emphasize">
						<strong>
							# <?php echo $info->repair_order_no; ?>
						</strong>	
					</td>
				</tr>
				<tr>
					<td width="50%">
						<a href="Templates/layout/repair-order/<?php echo $info->repair_order_id; ?>?type=preview" target="_blank" class="btn btn-success" style="text-transform:none;font-family: tahoma;width: 100%;border-radius: .2em;" ><i class="fa fa-print"></i> Order</a>
					</td>
					<td width="50%">
						<a href="Templates/layout/repair-order/<?php echo $info->repair_order_id; ?>?type=pdf" class="btn btn-danger" style="text-transform:none;font-family: tahoma;width: 100%;border-radius: .2em;" ><i class="fa fa-file-pdf-o"></i> PDF </a>
					</td>
				</tr>
					<tr>
						<td width="50%">
							<a href="Templates/layout/repair-order/<?php echo $info->repair_order_id; ?>?type=tech" target="_blank" class="btn btn-primary" style="text-transform:none;font-family: tahoma;width: 100%;border-radius: .2em;" ><i class="fa fa-cog"></i> Tech (Back) </a>
						</td>
						<td width="50%">
							<a href="Templates/layout/repair-order/<?php echo $info->repair_order_id; ?>?type=sa" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;width: 100%;border-radius: .2em;" ><i class="fa fa-file-o"></i> SA (Back) </a>
						</td>
					</tr>					
				</table>
				<br/>
				<table width="100%" border="1" cellspacing="5" cellpadding="5" style="font-size: 8.5pt;" class="table table-striped" cellspacing="0">
					<tr>
						<td colspan="2" valign="top" align="center" style="background: lightgray;">
							<strong><i class="fa fa-list"></i> Summary Details</strong>	
						</td>
					</tr>
					<!-- PMS -->
					<tr>
						<td colspan="2" valign="top">
							<strong> <i class="fa fa-car"></i> Periodic Maintenance (PMS)</strong>
						</td>
					</tr>
					<tr>
					<td width="55%" align="right">Total : </td>
						<td width="45%" align="right">
							<?php echo number_format($total_pms_non_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right">Vat Amount : </td>
						<td align="right">
							<?php echo number_format($total_pms_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Sub-Total :</strong></td>
						<td align="right">
								<strong><?php echo number_format($total_pms_amount,2); ?></strong>
						</td>
					</tr>
					<!-- BPR -->
					<tr>
						<td colspan="2" valign="top">
							<strong> <i class="fa fa-paint-brush"></i> Body Paint Repair</strong>
						</td>
					</tr>
					<tr>
						<td width="55%" align="right">Total : </td>
						<td width="45%" align="right">
							<?php echo number_format($total_bpr_non_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right">Vat Amount : </td>
						<td align="right">
							<?php echo number_format($total_bpr_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Sub-Total :</strong></td>
						<td align="right">
							<strong><?php echo number_format($total_bpr_amount,2); ?></strong>
						</td>
					</tr>
					<!-- GJ -->
					<tr>
						<td colspan="2" valign="top">
							<strong> <i class="fa fa-car"></i> General Job</strong>
						</td>
					</tr>
					<tr>
						<td width="55%" align="right">Total : </td>
						<td width="45%" align="right">
							<?php echo number_format($total_gj_non_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right">Vat Amount : </td>
						<td align="right">
							<?php echo number_format($total_gj_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Sub-Total :</strong></td>
						<td align="right">
							<strong><?php echo number_format($total_gj_amount,2); ?></strong>
						</td>
					</tr>
					<!-- Internal -->
					<tr>
						<td colspan="2" valign="top">
							<strong> <i class="fa fa-car"></i> Internal</strong>
						</td>
					</tr>
					<tr>
						<td width="55%" align="right">Total : </td>
						<td width="45%" align="right">
							<?php echo number_format($total_internal_non_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right">Vat Amount : </td>
						<td align="right">
							<?php echo number_format($total_internal_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Sub-Total :</strong></td>
						<td align="right">
								<strong><?php echo number_format($total_internal_amount,2); ?></strong>
						</td>
					</tr>
					<!-- Warranty -->
					<tr>
						<td colspan="2" valign="top">
							<strong> <i class="fa fa-car"></i> Warranty</strong>
						</td>
					</tr>
					<tr>
						<td width="55%" align="right">Total : </td>
						<td width="45%" align="right">
							<?php echo number_format($total_warranty_non_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right">Vat Amount : </td>
						<td align="right">
							<?php echo number_format($total_warranty_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Sub-Total :</strong></td>
						<td align="right">
								<strong><?php echo number_format($total_warranty_amount,2); ?></strong>
						</td>
					</tr>
					<!-- Car Wash -->
					<tr>
						<td colspan="2" valign="top">
							<strong> <i class="fa fa-car"></i> Car Wash</strong>
						</td>
					</tr>
					<tr>
						<td width="55%" align="right">Total : </td>
						<td width="45%" align="right">
							<?php echo number_format($total_carwash_non_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right">Vat Amount : </td>
						<td align="right">
							<?php echo number_format($total_carwash_vat_amount,2); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Sub-Total :</strong></td>
						<td align="right">
								<strong><?php echo number_format($total_carwash_amount,2); ?></strong>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Discount :</strong></td>
						<td align="right">
							<strong><?php echo number_format($grand_total_discount,2); ?></strong>
						</td>
					</tr>	
					<tr>
						<td align="right" class="emphasize"><strong>Grand Total :</strong></td>
						<td align="right" class="emphasize">
							<strong><?php echo number_format($grand_total,2); ?></strong>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>