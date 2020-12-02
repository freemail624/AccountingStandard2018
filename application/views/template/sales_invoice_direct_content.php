<style type="text/css">
    span, table{
        position: absolute;
        z-index: 200;
        font-size: 11pt;
        font-family: calibri;
    }
    @page {
      size: portrait!important;
	  margin: none!important;
	  scale: default!important;
	}
</style>
<!-- <img src="<?php echo base_url('assets/img/bir_forms/dr_invoice.jpg'); ?>" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;"> -->

<span style="top: 70px; left: 95px;border: 0px solid red;width: 220px;max-width: 220px;height: 20px; max-height: 20px;">
	<?php echo $sales_info->customer_name; ?>
</span>

<span style="top: 70px; left: 350px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
	<?php echo $sales_info->sales_inv_no; ?>
</span>

<span style="top: 100px; left: 65px;border: 0px solid red;width: 250px;max-width: 250px;height: 20px; max-height: 20px;">
	<?php echo $sales_info->address; ?>
</span>

<span style="top: 100px; left: 350px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
	<?php echo date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?>
</span>

<table width="60%" style="top: 185px;left: 10px;border-collapse: collapse;">
    <?php foreach($sales_invoice_items as $item){ ?>
    	<tr>
    		<td valign="top" style="border: 0px solid red;padding: 5px;width: 15px;"><center><?php echo number_format($item->inv_qty,2); ?></center></td>
    		<td valign="top" style="border: 0px solid red;padding: 5px;"><?php echo $item->unit_name; ?></td>
    		<td valign="top" style="border: 0px solid red;padding: 5px;"><?php echo $item->product_desc; ?></td>
    		<td valign="top" align="right" style="border: 0px solid red;padding: 5px;"><?php echo number_format($item->inv_price,2); ?></td>
    		<td valign="top" align="right" style="border: 0px solid red;padding: 5px;"><?php echo number_format($item->inv_gross,2); ?></td>
    	</tr>
    <?php }?>
</table>

<span style="top: 690px; left: 430px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
	<strong><?php echo number_format($sales_info->total_after_tax,2); ?></strong>
</span>
<script type="text/javascript">
    window.print();
    setTimeout(function(){
        window.close();
    },600);
</script>
