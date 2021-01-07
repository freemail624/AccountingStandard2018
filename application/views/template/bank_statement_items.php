<?php foreach($items as $item){?>
<tr>
	<td>
	    <input type="text" name="general_ledger_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy" value="<?php echo date('m/d/Y',strtotime($item->general_ledger_date)); ?>">
	</td>
	<td>
	    <input type="text" name="value_date[]" class="date-picker form-control" placeholder="mm/dd/yyyy" value="<?php echo date('m/d/Y',strtotime($item->value_date)); ?>">
	</td>
	<td>
	    <input type="text" name="cheque_no[]" class="form-control" value="<?php echo $item->check_no; ?>">
	</td>
	<td>
	    <input type="text" name="dr_amount[]" class="form-control numeric" value="<?php echo number_format($item->dr_amount,2); ?>">
	</td>
	<td>
	    <input type="text" name="cr_amount[]" class="form-control numeric" value="<?php echo number_format($item->cr_amount,2); ?>">
	</td>
	<td>
	    <input type="text" name="balance_amount[]" class="form-control numeric" readonly value="<?php echo number_format($item->balance_amount,2); ?>">
	</td>
	<td>
	    <input type="text" name="memo[]" class="form-control" value="<?php echo $item->remarks; ?>">
	</td>
    <td>
        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
    </td>
</tr>
<?php }?>