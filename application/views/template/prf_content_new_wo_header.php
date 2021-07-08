<!DOCTYPE html>
<html>
<head>
	<title>Purchase Request (Form)</title>
	<style type="text/css">

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
	</style>
</head>
<body>
	<div class="">
		<strong>P.R.F. # :</strong> <?php echo $requests->prf_no; ?></td> <br>
		<strong>Department :</strong> <?php echo $requests->department_name; ?></td> <br>
		<strong>Date : </strong><?php echo date_format(new DateTime($requests->date_created),"m/d/Y"); ?>
	</div>
	<br>
	<table width="100%" cellpadding="10" cellspacing="-1" class="table table-striped" style="border:none!important;">
		<tr>
			<td style="padding: 6px;border-bottom: 1px solid gray;" align="left"><strong>Qty <?php echo count($prf_items); ?></strong></td>
			<td style="padding: 6px;border-bottom: 1px solid gray;" align="left"><strong>Description</strong></td>
		</tr>

		<?php foreach($prf_items as $items){ ?>
            <tr>
                <td width="20%" style="border-bottom: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $items->prf_qty; ?></td>
                <td width="80%" style="border-bottom: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $items->product_desc; ?></td>
            </tr>
        <?php } ?>


		<tr>
            <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;"><b>Remarks:</b></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $requests->remarks; ?></td>
        </tr>
	</table>

</body>
</html>
