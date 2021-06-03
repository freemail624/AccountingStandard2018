
<table style="font-family: 'Century Gothic', sans-serif;">

	<?php $sal = 0; foreach($receivables as $item){if($item->is_sales == '1'){ $sal ++;} }?>

	<?php if($sal > 0 ){ ?>
	<tr style="background-color: #bcf6ff;">
		<td colspan="7"><strong>SALES</strong></td>
	</tr>
	<?php	} ?>


	<?php foreach($receivables as $item){ ?>
		<?php if ($item->is_sales == '1') { ?>
	    <tr>
	    	<td><button type="button" class="btn_return btn btn-primary" data-sales_invoice_id="<?php echo $item->sales_invoice_id; ?>" data-sales_invoice_no="<?php echo $item->inv_no; ?>">Returns 
		    	<span class="returns_count">
		    		<?php if($item->adjust_qty > 0){ echo '('.$item->adjust_qty.')'; } ?>
		    	</span>
	    	</button></td>
	        <td><?php echo $item->inv_no; ?></td>
	        <td><?php echo $item->date_due; ?></td>
	        <td><?php echo $item->remarks; ?></td>
	        <td align="right"><input type="text" name="receivable_amount[]" style="text-align: right;" class="amount_due form-control" value="<?php echo number_format($item->amount_due,2); ?>" readonly></td>

	        <td class="hidden">
	        	<input type="text" class="receivable_amount form-control" name="original_receivables[]" readonly value="<?php echo $item->amount_due; ?>">
	        	<input type="text" class="return_amount_invoice form-control" name="amount_return[]" readonly>
	        </td>

	        <td><input type="text" name="payment_amount[]" class="payment_amount numeric form-control" />
	        	<input type="hidden" name="journal_id[]" value="<?php echo $item->journal_id; ?>">
				<input type="hidden" name="sales_invoice_id[]" value="<?php echo $item->sales_invoice_id; ?>">
	        	<input type="hidden" name="is_sales[]" value="<?php echo $item->is_sales; ?>" />
	        </td>
	        <td align="center"><button type="button" class="btn btn-success btn_set_amount"><i class="fa fa-check"></i></button></td>
	        
	    </tr>
	    <?php } ?>
	<?php } ?>


	<?php 

	$serv = 0;
	 foreach($receivables as $item){   if ($item->is_sales == '0') {$serv ++;  } } ?> <?php  if($serv != 0){ ?>
	<tr style="background-color: #bcf6ff;">
		<td colspan="6"><strong>SERVICES</strong></td>
	</tr>
	<?php } ?>
	<?php foreach($receivables as $item){ ?>
		<?php if ($item->is_sales == '0') { ?>
	    <tr>
	    	<td></td>
	        <td><?php echo $item->inv_no; ?></td>
	        <td><?php echo $item->date_due; ?></td>
	        <td><?php echo $item->remarks; ?></td>
	        <td align="right"><input type="text" name="receivable_amount[]" style="text-align: right;" class="amount_due form-control" value="<?php echo number_format($item->amount_due,2); ?>" readonly></td>

	        <td class="hidden">
	        	<input type="text" class="receivable_amount form-control" name="original_receivables[]" readonly value="<?php echo $item->amount_due; ?>">
	        	<input type="text" class="return_amount_invoice form-control" name="amount_return[]" readonly>
	        </td>

	        <td><input type="text" name="payment_amount[]" class="payment_amount numeric form-control" />
				<input type="hidden" name="journal_id[]" value="<?php echo $item->journal_id; ?>">
				<input type="hidden" name="sales_invoice_id[]" value="<?php echo $item->sales_invoice_id; ?>">
	        	<input type="hidden" name="is_sales[]" value="<?php echo $item->is_sales; ?>" />
	        </td>
	        <td align="center"><button type="button" class="btn btn-success btn_set_amount"><i class="fa fa-check"></i></button></td>
	    </tr>
	    <?php } ?>
	<?php } ?>


	<?php if($sal == 0 && $serv == 0){ ?>
	<tr>
		<td colspan="7"><i>No receivable records found.</i></td>
	</tr>

	<?php } ?>
</table>