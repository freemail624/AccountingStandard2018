<style type="text/css">
    span, table{
        position: absolute;
        z-index: 200;
        font-size: 18pt;
    }
    @page {
	  size: A4;
	  margin: default;
	  scale: 100%;
	}
</style>
<img src="<?php echo base_url('assets/img/bir_forms/dr_invoice.jpg'); ?>" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;">

<span style="top: 125px; left: 150px;border: 1px solid red;width: 160px;max-width: 160px;height: 190px; max-height: 190px;">
	<?php echo $sales_info->customer_name; ?>
</span>

<!-- <table width="70%" style="border: 1px solid red;font-size: 18pt;margin-top: 120px;">
	<tr>
		<td>
			<?php echo $sales_info->customer_name; ?>
		</td>
		<td>
			<?php echo $sales_info->sales_inv_no; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $sales_info->address; ?>
		</td>
		<td>
			<?php echo  date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?>
		</td>
	</tr>
</table> -->
<!-- <table width="70%" style="border: 1px solid red;margin-top: 20px;font-size: 18pt;">
    <?php foreach($sales_invoice_items as $item){ ?>
    	<tr>
    		<td><?php echo number_format($item->inv_qty,2); ?></td>
    		<td><?php echo $item->unit_name; ?></td>
    		<td><?php echo $item->product_desc; ?></td>
    		<td><?php echo number_format($item->inv_price,2); ?></td>
    		<td><?php echo number_format($item->inv_gross,2); ?></td>
    	</tr>
    <?php }?>
</table> -->