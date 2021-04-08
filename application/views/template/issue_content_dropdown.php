<!DOCTYPE html>
<html>
<head>
	<title>Parts Requisition & Issuance Slip</title>
	<style type="text/css">
		table.pris{
			border-collapse: collapse;
			border-radius: 1em;
			font-size: 9pt;
			font-family: calibri;
		}
		.top{
			border-top: 1px solid black;
		}
		.left{
			border-left: 1px solid black;
		}
		.right{
			border-right: 1px solid black;
		}	
		.bottom{
			border-bottom: 1px solid black;
		}	

		table.pris tr:last-child td:first-child {
		    border-bottom-left-radius: 10px;
		}

		table.pris tr:last-child td:last-child {
		    border-bottom-right-radius: 10px;
		}

	</style>
</head>
<body>
	<table width="100%" cellspacing="5" cellpadding="5" class="table table-striped pris">
		<tr>
			<td colspan="8" align="center" valign="top" class="top left right bottom">
				<strong>
					<h2>Parts Requisition &amp; Issuance Slip # <?php echo $issuance_info->repair_order_no; ?></h2>
				</strong>
			</td>
		</tr>
		<tr>
			<td width="90%" colspan="6" class="left right bottom" valign="top" style="height: 100px;min-height: 100px;font-size: 11pt;">
				<?php echo $issuance_info->customer_no; ?><br/>
				<strong><?php echo $issuance_info->customer_name; ?></strong>
			</td>
			<td width="10%" colspan="2" class="right bottom" valign="top">
				RO NUMBER <br/>
				<?php echo $issuance_info->repair_order_no; ?>
			</td>
		</tr>
		<tr>
			<td width="10%" valign="middle" align="center" class="left bottom">
				<strong>Part Number</strong>
			</td>
			<td class="left bottom" width="30%"></td>
			<td valign="middle" align="center" class="left bottom" width="10%">
				<strong>BIN</strong>
			</td>
			<td valign="middle" align="center" class="left bottom" width="10%">
				<strong>CURR <br/> SOH</strong>
			</td>
			<td valign="middle" align="center" class="left bottom" width="10%">
				<strong>QTY <br/> ORD</strong>
			</td>
			<td valign="middle" align="center" class="left bottom" width="10%">
				<strong>QTY <br/> BO</strong>
			</td>
			<td valign="middle" align="center" class="left bottom" width="10%">
				<strong>QTY <br/> SUPP</strong>
			</td>
			<td valign="middle" align="center" class="left right bottom" width="10%">
				<strong>QTY <br/> PICKED</strong>
			</td>
		</tr>
		<?php foreach($issue_items as $item){ ?>
			<tr>
				<td class="left"><?php echo $item->product_code; ?></td>
				<td class=""><?php echo $item->product_desc; ?></td>
				<td class="" align="center"><?php echo $item->bin_code; ?></td>
				<td class="" align="center"><?php echo number_format(0,0); ?></td>
				<td class="" align="center"><?php echo number_format($item->issue_qty,0); ?></td>
				<td class="" align="center"><?php echo number_format(0,0); ?></td>
				<td class="" align="center"><?php echo number_format($item->issue_qty,0); ?></td>
				<td class="right" align="center" valign="bottom">________</td>
			</tr>
		<?php }?>
		<tr>
			<td class="left bottom"></td>
			<td class="bottom" style="font-size: 9pt;">***NOTHING FOLLOWS***</td>
			<td class="right bottom" colspan="6"></td>
		</tr>
	</table>
</body>
</html>