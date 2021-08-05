<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order Request</title>
	<style type="text/css">
		body {
/*			font-family: 'Calibri',sans-serif;
			font-size: 12px;*/
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

		hr {
			/*border-top: 3px solid #404040;*/
		}

		tr {
            border: none!important;
        }
    table{
        /*border:none!important;*/
    }
	</style>
</head>
<body>
	<div class="">
		<strong>P.R. # :</strong> <?php echo $requests->pr_no; ?></td> <br>
		<strong>Date : </strong><?php echo date_format(new DateTime($requests->date_created),"m/d/Y"); ?>
	</div><br>
	<table width="100%"  class="hidden" cellspacing="-1" style="border:none!important;">
		<tr>
			<td style="padding: 6px;" width="50%" colspan="2"><strong>Supplier / Address:</strong></td>
			<td style="padding: 6px;" width="50%"><strong>Deliver to :</strong></td>
		</tr>
		<tr>
			<td style="padding: 6px;" width="50%" colspan="2"><?php echo $requests->supplier_name; ?></td>
			<td style="padding: 6px;" width="50%"><?php echo $requests->deliver_to_address; ?></td>
		</tr>
		<tr>
			<td style="padding: 6px;" width="25%" colspan="2"><strong>Terms :</strong></td>
			<td style="padding: 6px;" width="25%"><strong>Ref # :</strong></td>
	
		</tr>
		<tr>
			<td style="padding: 6px;" width="25%" colspan="2"><?php echo $requests->terms; ?></td>
			<td style="padding: 6px;" width="25%"></td>
		</tr>
	</table>
	<br>
	<table width="100%" cellpadding="10" cellspacing="-1" class="table table-striped" style="text-align: center;border:none!important;">
		<tr>
			<td width="15%" style="padding: 6px;border-bottom: 1px solid gray;text-align: left;"><strong>Part Number</strong></td>
			<td width="35%" style="padding: 6px;border-bottom: 1px solid gray;text-align: left;"><strong>Description</strong></td>
			<td width="10%" style="padding: 6px;border-bottom: 1px solid gray;text-align: center;"><strong>UM</strong></td>
			<td width="10%" style="padding: 6px;border-bottom: 1px solid gray;text-align: right;"><strong>Qty</strong></td>
			<td width="10%" style="padding: 6px;border-bottom: 1px solid gray;text-align: right;"><strong>Unit Price</strong></td>
            <td width="10%" style="padding: 6px;border-bottom: 1px solid gray;text-align: right;"><strong>Discount</strong></td>
			<td width="10%" style="padding: 6px;border-bottom: 1px solid gray;text-align: right;"><strong>Amount</strong></td>
		</tr>
		<?php foreach($pr_items as $item){ ?>
            <tr>
                <td style="border-bottom: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $item->product_code; ?></td>
                <td style="border-bottom: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                <td style="border-bottom: 1px solid gray;text-align: center;height: 10px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_qty,2); ?></td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_price,2); ?></td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_discount,2); ?></td>
                <td style="border-bottom: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_line_total_after_global,2); ?></td>
            </tr>
        <?php } ?>
 		<tr>
            <td colspan="7" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray;border-right: 1px solid gray;"><b>Remarks:</b></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: left;height: 30px;padding: 6px;border-left: 1px solid gray;border-bottom: 1px solid gray;border-right: 1px solid gray;"><?php echo $requests->remarks; ?></td>
        </tr>
        <tr>
        	<td align="left" colspan="3" style="border-left: 1px solid gray;"><b>Prepared By:</b></td>
        	<td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Global Discount %:</td>
        	<td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px; border-right: 1px solid gray;" align="right"><?php echo number_format($requests->total_overall_discount,2); ?></td>
        </tr>
        <tr>
            <td align="left" colspan="3" style="border-left: 1px solid gray;"></td>
            <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total Discount :</td>
            <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($requests->total_overall_discount_amount +$requests->total_discount ,2); ?></td>
        </tr>
        <tr>
            <td align="left" colspan="3" style="border-bottom: 1px solid gray;border-left: 1px solid gray;"></td>
            <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total Before Tax:</td>
            <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($requests->total_before_tax,2); ?></td>
        </tr>
        <tr>
        	<td align="left" colspan="3" style="border-left: 1px solid gray;"><b>Received By:</b></td>
        	<td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total Tax Amount:</td>
        	<td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($requests->total_tax_amount,2); ?></td>
        </tr>
        <tr>
        	<td align="left" colspan="3" style="border-left: 1px solid gray;" ></td>
        	<td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left">Total After Tax:</td>
        	<td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><?php echo number_format($requests->total_after_tax,2); ?></td>
        </tr>

        <tr>
            <td align="left" colspan="3" style="border-bottom: 1px solid gray;border-left: 1px solid gray;">Date</td>
            <td  colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-left: 1px solid gray;" align="left"><strong>Total:</strong></td>
            <td colspan="2" style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;" align="right"><strong><?php echo number_format($requests->total_after_discount,2); ?></strong></td>
        </tr>
	</table>

</body>
</html>
