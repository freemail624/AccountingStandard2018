<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body {
			font-family: 'Calibri',sans-serif;
			font-size: 12px;
		}
		.align-right {
			text-align: right;
		}
		.align-left {
			text-align: left;
		}
		.align-center {
			text-align: center;
		}
		.report-header {
			font-weight: bolder;
		}
		.tab-content {
		    border-left: 1px solid #ddd;
		    border-right: 1px solid #ddd;
		    padding: 10px;
		}

		.nav-tabs {
		    margin-bottom: 0;
		}
		table th {
			text-align: left;
		}
		/*.col-sm-4 {padding:0px;}*/
		.nav-tabs  li:not(active) a {
			color:black;
			opacity: 0.6;
		}
		.nav-tabs  li.active a {
			font-weight: bold;opacity: 1;
		}
		#sub.nav-tabs > li {
		    float:none;
		    display:inline-block;
		    zoom:1;
		}

		#sub.nav-tabs {
		    text-align:center;
		}
		div.child h4 {
			color:#217ea9!important;margin-left: 5px;
		}
	</style>
</head>
<body >


<div class="container-fluid child">
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#<?php echo $contract_info->contract_id; ?>_home">Contract Information</a></li>
	  <li><a data-toggle="tab" href="#<?php echo $contract_info->contract_id; ?>_menu1">Schedule</a></li>
	  <li class=""><a data-toggle="tab" href="#<?php echo $contract_info->contract_id; ?>_menu2">Charges</a></li>
	</ul>
	<div class="tab-content" style="border: 1px solid lightgray; border-top:none;min-height: 400px;">
	  <div id="<?php echo $contract_info->contract_id; ?>_home" class="tab-pane fade in active">
	    <h4>Contract Information</h4>

	    <div class="container-fluid">
		    <div class="row">
			    <div class="col-sm-4">
			    <h5>Tenant Details</h5><hr>
			    <table class="table table-striped " width="100%" style="border:0px!important;">
					<tr>
						<td>Tenant Code:</td>
						<td><?php echo $contract_info->tenant_code; ?></td>
					</tr>
					<tr>
						<td>Lessee/ Tenant:</td>
						<td><?php echo $contract_info->trade_name; ?></td>
					</tr>
					<tr>
						<td>Company Name:</td>
						<td><?php echo $contract_info->company_name; ?></td>
					</tr>
					<tr>
						<td>Signatory:</td>
						<td><?php echo $contract_info->contract_signatory; ?></td>
					</tr>
					<tr>
						<td>Billing Address:</td>
						<td><?php echo $contract_info->contract_billing_address; ?></td>
					</tr>
					<tr>
						<td>Department:</td>
						<td><?php echo $contract_info->department_desc; ?></td>
					</tr>
					<tr>
						<td>Nature of Business:</td>
						<td><?php echo $contract_info->nature_of_business_desc; ?></td>
					</tr>
					<tr>
						<td>Approved Merchandise:</td>
						<td><?php echo $contract_info->contract_approved_merch; ?></td>
					</tr>
					<tr>
						<td>Category:</td>
						<td><?php echo $contract_info->category_desc; ?></td>
					</tr>
					<tr>
						<td>Location:</td>
						<td><?php echo $contract_info->location_desc; ?></td>
					</tr>
					<tr>
						<td>Remarks:</td>
						<td><?php echo $contract_info->contract_remarks; ?></td>
					</tr>
			    </table>
			    </div>
			    <div class="col-sm-4">
			    <h5>Contract Details</h5><hr>
			    <div class="row">
				    <div class="col-sm-12">
			    <table class="table table-striped table-child" width="100%" style="border:0px!important;">
					<tr>
						<td>Contract No:</td>
						<td><?php echo $contract_info->contract_no; ?></td>
					</tr>
					<tr>
						<td>Contract Type:</td>
						<td><?php echo $contract_info->contract_type_desc; ?></td>
					</tr>
					<tr>
						<td>Floor Area:</td>
						<td><b><?php echo number_format($contract_info->contract_floor_area,2); ?> Sq. Meter</b></td>
					</tr>
					<tr>
						<td>Is Renewal?:</td>
						<td><b><?php if($contract_info->is_renewal == 0){ echo 'No'; }else{ echo 'Yes';} ?></b></td>
					</tr>
					<tr>
						<td>Terms:</td>
						<td><b><?php echo $contract_info->contract_terms; ?></b></td>
					</tr>
					<tr>
						<td>Commencement Date:</td>
						<td><?php echo $contract_info->commencement_date; ?></td>
					</tr>
					<tr>
						<td>Termination Date:</td>
						<td><?php echo $contract_info->termination_date; ?></td>
					</tr>
					<tr>
						<td>Start Billing Date:</td>
						<td><?php echo $contract_info->start_billing_date; ?></td>
					</tr>
					<tr>
						<td>Escalation Schedule:</td>
						<td><?php $escalations = array('0'=>'None','1'=>'Annual','2'=>'Every Other Year','3'=>'Every 3 Years','5'=>'Every 5 Years');
						echo $escalations[$contract_info->escalation_type];?></td>
					</tr>
					<tr>
						<td>Escalation %:</td>
						<td class="align-right"><?php echo number_format($contract_info->contract_escalation_percent,2); ?></td>
					</tr>
					<tr>
						<td>Escalation Notes:</td>
						<td><?php echo $contract_info->escalation_notes; ?></td>
					</tr>

				</table>
			    </div>
			    </div>
			    </div>
			    <div class="col-sm-4">
			    <h5>Amount Details</h5><hr>
			    <div class="row">
				 <div class="col-sm-12">
			    <table class="table table-striped table-child" width="100%" style="border:0px!important;">


					<tr>
						<td>Basic Rental:</td>
						<td class="align-right"><b><?php echo number_format($contract_info->contract_fixed_rent,2); ?></b></td>
					</tr>

					<?php foreach ($other_fees as $other_fee) { ?>
						<tr>
							<td><?php echo $other_fee->fee_type_desc; ?>:</td>
							<td class="align-right"><?php echo number_format($other_fee->balance,2); ?></td>
						</tr>
					<?php } ?>
				</table>
				</div>
				</div>
			    </div>
		    </div>
	    </div>

	    <br>


	  </div>
	  <div id="<?php echo $contract_info->contract_id; ?>_menu1" class="tab-pane fade">
	    <h4>Schedule</h4>
			<table class="table table-striped " width="100%">
			    <thead >
			    <tr>
			        <th width="5%"></th>
			        <th>Applicable Month</th>
			        <th>Year</th>
			        <th>Date Due</th>
			        <th class="align-right">Fixed Rent</th>
			        <th class="align-right">Ecalation %</th>
			        <th class="align-right">Amount</th>
			        <th class="align-center">Vatted</th>
			        <th>Note</th>
			    </tr>
			    </thead>
			    <tbody>
			    <?php if(count($schedules) == 0){ ?><tr><td colspan="9"><i>No Schedules found.</i></td></tr><?php } ?>
			    <?php $i=1; foreach ($schedules as $schedule) { ?>
				    <tr>
				        <td><?php echo $i; ?></td>
				        <td><?php echo $schedule->month_name; ?></td>
				        <td><?php echo $schedule->app_year; ?></td>
				        <td><?php?></td>
				        <td class="align-right"><?php echo number_format($schedule->fixed_rent,2); ?></td>
				        <td class="align-right"><?php echo number_format($schedule->escalation_percent,2); ?></td>
				        <td class="align-right"><?php echo number_format($schedule->amount_due,2); ?></td>
				        <td class="align-center"><?php if($schedule->is_vatted == 0){ echo 'No'; }else{ echo 'Yes';} ?></td>
				        <td><?php echo $schedule->contract_schedule_notes; ?></td>
				    </tr>
			    <?php $i++;} ?>
			    </tbody>
			</table>
	  </div>
	  <div id="<?php echo $contract_info->contract_id; ?>_menu2" class="tab-pane fade">
	    <h4>Charges</h4>
			<ul class="nav nav-tabs" id="sub">
			  <li class="active"><a data-toggle="tab" href="#<?php echo $contract_info->contract_id; ?>_home_2">Utility</a></li>
			  <li class=""><a data-toggle="tab" href="#<?php echo $contract_info->contract_id; ?>_menu1_2">Miscellaneous</a></li>
			  <li class=""><a data-toggle="tab" href="#<?php echo $contract_info->contract_id; ?>_menu2_2">Other</a></li>
			</ul>
			<div class="tab-content" style="border: 1px solid lightgray; border-top:none;">
				<div id="<?php echo $contract_info->contract_id; ?>_home_2" class="tab-pane fade in active">
					<h4>Utility</h4>
					<table class="table table-striped" width="100%">
					    <thead >
					    <tr>
					        <th>Description</th>
					        <th class="align-right">Rate</th>
					        <th class="align-right">Default Reading</th>
					        <th class="align-center">is Vatted?</th>
					        <th>Notes</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php if(count($util_charges) == 0){ ?><tr><td colspan="5"><i>No Utility Charges found.</i></td></tr><?php } ?>
						<?php $i=1; foreach ($util_charges as $util_charge) { ?>
						    <tr>
						        <td><?php echo $util_charge->charge_desc; ?></td>
						        <td class="align-right"><?php echo number_format($util_charge->contract_util_rate,2); ?></td>
						        <td class="align-right"><?php echo number_format($util_charge->contract_util_default_reading,2); ?></td>
						        <td class="align-center"><?php if($util_charge->contract_util_is_vatted == 0){ echo 'No'; }else{ echo 'Yes';} ?></td>
						        <td><?php echo $util_charge->contract_util_notes; ?></td>
						    </tr>
						<?php $i++;} ?>
						</tbody>
					</table>

				</div>
				<div id="<?php echo $contract_info->contract_id; ?>_menu1_2" class="tab-pane fade">
					<h4>Miscellaneous</h4>
					<table class="table table-striped" width="100%">
					    <thead >
					    <tr>
					        <th>Description</th>
					        <th class="align-right">Rate</th>
					        <th class="align-right">Default Reading</th>
					        <th class="align-center">is Vatted?</th>
					        <th>Notes</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php if(count($misc_charges) == 0){ ?><tr><td colspan="5"><i>No Miscellaneous Charges found.</i></td></tr><?php } ?>
						<?php $i=1; foreach ($misc_charges as $misc_charge) { ?>
						    <tr>
						        <td><?php echo $misc_charge->charge_desc; ?></td>
						        <td class="align-right"><?php echo number_format($misc_charge->contract_misc_rate,2); ?></td>
						        <td class="align-right"><?php echo number_format($misc_charge->contract_misc_default_reading,2); ?></td>
						        <td class="align-center"><?php if($misc_charge->contract_misc_is_vatted == 0){ echo 'No'; }else{ echo 'Yes';} ?></td>
						        <td><?php echo $misc_charge->contract_misc_notes; ?></td>
						    </tr>
						<?php $i++;} ?>
						</tbody>
					</table>
				</div>
				<div id="<?php echo $contract_info->contract_id; ?>_menu2_2" class="tab-pane fade">
					<h4>Other</h4>
					<table class="table table-striped" width="100%">
					    <thead >
					    <tr>
					        <th>Description</th>
					        <th class="align-right">Rate</th>
					        <th class="align-right">Default Reading</th>
					        <th class="align-center">is Vatted?</th>
					        <th>Notes</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php if(count($othr_charges) == 0){ ?><tr><td colspan="5"><i>No Other Charges found.</i></td></tr><?php } ?>
						<?php $i=1; foreach ($othr_charges as $othr_charge) { ?>
						    <tr>
						        <td><?php echo $othr_charge->charge_desc; ?></td>
						        <td class="align-right"><?php echo number_format($othr_charge->contract_othr_rate,2); ?></td>
						        <td class="align-right"><?php echo number_format($othr_charge->contract_othr_default_reading,2); ?></td>
						        <td class="align-center"><?php if($othr_charge->contract_othr_is_vatted == 0){ echo 'No'; }else{ echo 'Yes';} ?></td>
						        <td><?php echo $othr_charge->contract_othr_notes; ?></td>
						    </tr>
						<?php $i++;} ?>
						</tbody>
					</table>
				</div>
			 </div>
		</div>
	</div>

</body>
</html>
