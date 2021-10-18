<style type="text/css">
    span{
        position: absolute;
        z-index: 200;
        font-size: 10pt;
        text-transform: uppercase;
        font-family: Arial;
        font-weight: bold;
    }

    .panel{
        position: absolute;    
        z-index: 200;  
        width: auto;
        height: auto;   
        top: 245px;      
        left: 45px;   
        font-family: Arial;
        font-weight: bold;
        font-size: 12pt;
    }

    @page {
      margin: default; 
      scale: 100%; 
    }
    
</style>
<!-- <img src="<?php //echo base_url(); ?>/assets/img/po.jpg" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;height: 100%;"> -->

<span style="top: 171px; left: 85px;max-width: 280px;"><?php echo $purchase_info->supplier_name; ?></span>
<span style="top: 186px; left: 77px;"><?php echo $purchase_info->terms; ?></span>

<span style="top: 154px; left: 362px;"><?php echo date('m/d/Y'); ?></span>
<span style="top: 171px; left: 382px;"><?php echo $purchase_info->contact_no; ?></span>
<span style="top: 185px; left: 402px;"><?php echo date('m/d/Y', strtotime($purchase_info->date_invoice)); ?></span>

<div class="panel">

    <table width="100%" style="font-family: Arial; font-weight: bold;font-size: 12pt;">

        <?php 

        $po_line_total_after_global = 0;

        foreach($po_items as $item){

        $po_line_total_after_global += $item->po_line_total_after_global;

        ?>


        <tr>
            <td valign="top" style="width: 30px;max-width: 30px;padding-bottom: 5px;" align="center"><?php echo $item->po_qty * 1; ?></td>
            <td valign="top" style="width: 45px;max-width: 45px;padding-bottom: 5px;text-align: center;text-transform: uppercase;"><?php echo $item->unit_name; ?></td>
            <td valign="top" style="width: 285px;max-width: 285px;padding-bottom: 5px;text-align: left;padding-left: 10px;"><?php echo $item->product_desc; ?> (<?php echo number_format($item->po_price,2); ?>)</td>
            <td valign="top" style="width: 75px;max-width: 75px;padding-bottom: 5px;text-align: right;padding-right: 18px;">
                <?php echo number_format($item->po_line_total_after_global,2); ?>
            </td>
        </tr>

        <?php }?>

        <tr>
            <td valign="top" style="width: 30px;max-width: 30px;padding-bottom: 5px;" align="center">&nbsp;</td>
            <td valign="top" style="width: 45px;max-width: 45px;padding-bottom: 5px;text-align: center;">&nbsp;</td>
            <td valign="top" style="width: 285px;max-width: 285px;padding-bottom: 5px;text-align: left;padding-left: 10px;">&nbsp;</td>
            <td valign="top" style="width: 75px;max-width: 75px;padding-bottom: 5px;text-align: right;padding-right: 18px;">
                <?php echo number_format($po_line_total_after_global,2); ?>
            </td>
        </tr>

        <tr>
            <td valign="top" colspan="4" align="center" style="padding: 20px;padding-top: 50px;width: 428px; max-width: 428px;">
                <?php echo $purchase_info->remarks; ?>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    window.print();
</script>
