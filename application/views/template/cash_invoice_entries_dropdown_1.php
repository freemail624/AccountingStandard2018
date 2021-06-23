<style type="text/css">
    .border-left {
        border-left: 1px solid black !important;
    }

    .border-right {
        border-right: 1px solid black !important;
    }

    .border-bottom {
        border-bottom: 1px solid black !important;
    }

    .border-top {
        border-top: 1px solid black !important;
    }
</style>


<table width="100%" cellspacing="5" cellpadding="0">
    <tr>
        <td width="50%">BRANCH : <?php echo $info->customer_name; ?></td>
        <td width="50%" align="right">DR# : <?php echo $info->cash_inv_no; ?></td>
    </tr>
    <tr>
        <td>ADDRESS : <?php echo $info->address; ?></td>
        <td align="right">DATE : <?php echo date_format(new DateTime($info->date_invoice), "m/d/Y"); ?></td>
    </tr>
</table>
<br />
<table width="100%" style="border-collapse: collapse;" cellspacing="5" cellpadding="5">
    <tr>
        <td width="10%" class="border-right border-bottom" align="center">QTY</td>
        <td width="10%" class="border-right border-bottom" align="center">UM</td>
        <td width="40%" class="border-right border-bottom" align="center">DESCRIPTION</td>
        <td width="20%" class="border-right border-bottom" align="right">UNIT PRICE</td>
        <td width="20%" class="border-bottom" align="right">AMOUNT</td>
    </tr>
    <?php
    $subtotal = 0;
    foreach ($items as $item) {

        if ($is_basyo->basyo_product_id != $item->product_id) {
            $subtotal += $item->inv_line_total_after_global;
    ?>
            <tr>
                <td valign="top" class="border-right">
                    <center><?php echo number_format($item->inv_qty, 2); ?></center>
                </td>
                <td valign="top" class="border-right"><?php echo $item->unit_code; ?></td>
                <td valign="top" class="border-right"><?php echo $item->product_desc; ?></td>
                <td valign="top" class="border-right" align="right"><?php echo number_format($item->inv_price - $item->inv_discount, 2); ?></td>
                <td valign="top" align="right"><?php echo number_format($item->inv_line_total_after_global, 2); ?></td>
            </tr>
    <?php }
    } ?>
    <tr>
        <td valign="top"></td>
        <td valign="top"></td>
        <td valign="top"></td>
        <td valign="top" align="right">SUB-TOTAL :</td>
        <td valign="top" align="right" style="font-size: 14pt!important;"><?php echo number_format($subtotal, 2); ?></td>
    </tr>
    <?php foreach ($items as $item) {
        if ($is_basyo->basyo_product_id == $item->product_id) { ?>
            <tr>
                <td valign="top">
                    <center><?php echo number_format($item->inv_qty, 2); ?></center>
                </td>
                <td valign="top"><?php echo $item->unit_code; ?></td>
                <td valign="top"><?php echo $item->product_desc; ?></td>
                <td valign="top" align="right"><?php echo number_format($item->inv_price - $item->inv_discount, 2); ?></td>
                <td valign="top" align="right"><?php echo number_format($item->inv_line_total_after_global, 2); ?></td>
            </tr>
    <?php }
    } ?>
    <tr>
        <td valign="bottom" width="80%" align="right" colspan="4">TOTAL AMOUNT DUE :</td>
        <td valign="bottom" width="20%" align="right" style="font-size: 15pt!important;"><?php echo number_format($info->total_after_tax, 2); ?></td>
    </tr>
    <tr>
        <td valign="top" width="80%" align="right" colspan="4">TENDERED AMOUNT :</td>
        <td valign="top" width="20%" align="right"><?php echo number_format($info->total_tendered, 2); ?></td>
    </tr>
    <tr>
        <td valign="top" width="80%" align="right" colspan="4">CHANGE AMOUNT :</td>
        <td valign="top" width="20%" align="right"><?php echo number_format($info->total_change, 2); ?></td>
    </tr>
</table>