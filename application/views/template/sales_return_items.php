<?php foreach($items as $item){ ?>
	<tr>
		<td width="15%">
			<input type="text" class="return_qty numeric form-control" name="return_qty[]"
			value="<?php echo $item->adjust_qty > 0 ? $item->adjust_qty : ''?>">
		</td>
		<td width="5%" align="right">
			<?php echo number_format($item->inv_qty,2); ?>
			<input type="text" class="hidden form-control" name="sales_qty[]" value="<?php echo $item->inv_qty; ?>">
		</td>
		<td width="35%">
			<?php echo $item->product_desc; ?>
			<input type="text" class="hidden form-control" name="product_id[]" value="<?php echo $item->product_id; ?>">
		</td>
		<td width="15%" align="right">
			<?php echo number_format($item->inv_price-$item->inv_discount,2); ?>
			<input type="text" class="hidden form-control" name="unit_price[]" value="<?php echo $item->inv_price-$item->inv_discount; ?>">
		</td>
		<td width="20%">
			<input type="text" class="numeric form-control" name="return_amount[]" readonly>
		</td>
	</tr>
<?php }?>