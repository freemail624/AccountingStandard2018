<!DOCTYPE html>
<html>
<head>
    <title>Cash Invoice</title>
    <style type="text/css">
        span, table{
            position: absolute;
            z-index: 200;
            font-size: 11pt;
            font-family: calibri;
        }
        @page {
            size: 8.5in 11in!important;
            size: portrait!important;
            margin: 0!important;
            scale: default!important;
        }
    </style>
</head>
<body>
<!-- <img src="<?php echo base_url('assets/img/bir_forms/dr_invoice.jpg'); ?>" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;"> -->

<span style="top: 70px; left: 95px;border: 0px solid red;width: 20p2x;max-width: 220px;height: 20px; max-height: 20px;">
    <?php echo $info->customer_name; ?>
</span>

<span style="top: 70px; left: 350px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <?php echo $info->cash_inv_no; ?>
</span>

<span style="top: 100px; left: 65px;border: 0px solid red;width: 250px;max-width: 250px;height: 20px; max-height: 20px;">
    <?php echo $info->address; ?>
</span>

<span style="top: 100px; left: 350px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <?php echo date_format(new DateTime($info->date_invoice),"m/d/Y"); ?>
</span>

<table width="60%" style="top: 185px;left: 10px;border-collapse: collapse;">
    <?php foreach($items as $item){ ?>
        <tr>
            <td valign="top" style="border: 0px solid red;padding: 5px;width: 10%;max-width: 10%;"><center><?php echo number_format($item->inv_qty,2); ?></center></td>
            <td valign="top" style="border: 0px solid red;padding: 5px;width: 10%;max-width: 10%;"><?php echo $item->unit_code; ?></td>
            <td valign="top" style="border: 0px solid red;padding: 5px;width: 35%;max-width: 35%;"><?php echo $item->product_desc; ?></td>
            <td valign="top" align="right" style="border: 0px solid red;padding: 5px;width: 15%;max-width: 15%;"><?php echo number_format($item->inv_price,2); ?></td>
            <td valign="top" align="right" style="border: 0px solid red;padding: 5px;width: 15%;max-width: 15%;"><?php echo number_format($item->inv_discount,2); ?></td>
            <td valign="top" align="right" style="border: 0px solid red;padding: 5px;width: 15%;max-width: 15%;"><?php echo number_format($item->inv_line_total_after_global,2); ?></td>
        </tr>
    <?php }?>
    <tr>
        <td valign="top" colspan="5" style="padding: 5px;"><br/><?php echo $info->remarks; ?></td>
    </tr>
</table>

<span style="top: 605px; left: 290px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <strong>TENDERED AMOUNT : </strong>
</span>

<span style="top: 605px; left: 435px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <strong><?php echo number_format($info->total_tendered,2); ?></strong>
</span>

<span style="top: 635px; left: 304px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <strong>CHANGE AMOUNT : </strong>
</span>

<span style="top: 635px; left: 435px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <strong><?php echo number_format($info->total_change,2); ?></strong>
</span>

<span style="top: 665px; left: 435px;border: 0px solid red;width: 150px;max-width: 150px;height: 20px; max-height: 20px;">
    <strong><?php echo number_format($info->total_after_tax,2); ?></strong>
</span>


<script type="text/javascript">
    window.print();
    setTimeout(function(){
        window.close();
    },600);
</script>

</body>
</html>