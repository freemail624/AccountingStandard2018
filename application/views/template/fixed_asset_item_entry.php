<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>

<body>
	<form id="frm_fixed_asset_<?php echo $items->dr_invoice_item_id; ?>">
		<div class="row" style="margin: 0px;">
			<div class="col-md-12" style="border-top: 1px solid lightgray;padding-top: 10px;">
				<div class="col-md-4">
					<span style="color: red;"><b>*</b></span>Asset Code :<br />
					<div class="input-group fixed_asset">
						<input class="form-control" type="text" name="asset_code" id="asset_code" value="<?php echo $items->product_code; ?>" data-error-msg="Asset Code is required." required>
						<span class="input-group-addon" style="padding-left: 0px; padding-right: 0px;">
							- X X X
						</span>

					</div>
				</div>
				<div class="col-md-4">
					Salvage Value :<br />
					<div class="input-group fixed_asset">
						<span class="input-group-addon">
							<i class="fa fa-credit-card"></i>
						</span>
						<input id="txtSalvageValue" class="form-control numeric fixed_asset" type="text" name="salvage_value" value="0.00">
					</div>
				</div>
				<div class="col-md-4">
					Location : <br>
					<select name="location_id" class="form-control fixed_asset cbo_item_location" data-error-msg="Location is required.">
						<?php foreach ($location as $location) { ?>
							<option value="<?php echo $location->location_id; ?>"><?php echo $location->location_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="col-md-4">
					<span style="color: red;"><b>*</b></span> Asset Description : <br />
					<div class="input-group fixed_asset">
						<span class="input-group-addon">
							<i class="fa fa-file-text-o"></i>
						</span>
						<input class="form-control" type="text" name="asset_description" value="<?php echo $items->product_desc; ?>" data-error-msg="Asset Description is required." required>
					</div>
				</div>
				<div class="col-md-4">
					Acquisition Date : <br />
					<div class="input-group fixed_asset">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input class="date-picker form-control" id="date_acquired_format" value="<?php echo $items->date_delivered; ?>" type="text" name="date_acquired">
					</div>
				</div>
				<div class="col-md-4">
					Category : <br>
					<select name="category_id" class="form-control fixed_asset cbo_item_category" id="cbo_item_category_<?php echo $items->dr_invoice_item_id; ?>" data-error-msg="Category is required.">
						<?php foreach ($categories as $category) { ?>
							<option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="col-md-4">
					<span style="color: red;"><b>*</b></span> Acquisition Cost : <br>
					<div class="input-group fixed_asset">
						<span class="input-group-addon">
							<i class="fa fa-credit-card"></i>
						</span>
						<input id="txtAcquisitionCost" class="form-control numeric" type="text" name="acquisition_cost" value="<?php echo number_format($items->dr_price, 2); ?>" data-error-msg="Acquisition Cost is required." required>
					</div>
				</div>
				<div class="col-md-4">
					Life (<i>in Years</i>) :<br />
					<div class="input-group fixed_asset">
						<span class="input-group-addon">
							<i class="fa fa-line-chart"></i>
						</span>
						<input class="form-control numeric" type="text" name="life_years" data-error-msg="Life Years is required.">
					</div>
				</div>
				<div class="col-md-4">
					Parent : <br>
					<select name="department_id" class="form-control fixed_asset cbo_item_departments" id="cbo_item_departments_<?php echo $items->dr_invoice_item_id; ?>" data-error-msg="Parent is required.">
						<?php foreach ($departments as $department) { ?>
							<option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-12" style="border-bottom: 1px solid lightgray;padding-bottom: 20px;">
				<div class="col-sm-4 col-sm-offset-8">
					<button type="button" class="btn btn-primary" name="save_fixed_asset" class="btn_save_fixed_asset" style="width: 100%;margin-top: 10px;">Save Fixed Asset</button>
				</div>
			</div>
		</div>
	</form>

</body>

</html>