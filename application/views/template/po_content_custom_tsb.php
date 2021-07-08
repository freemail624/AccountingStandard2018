<style type="text/css">
    span{
        position: absolute;
        z-index: 200;
        font-size: 9pt;
        text-transform: uppercase;
        font-family: Arial;
        font-weight: bold;
    }

    .panel{
        position: absolute;    
        z-index: 200;  
        width: auto;
        height: auto;   
        top: 260px;      
        left: 60px;   
        font-family: Arial;
        font-weight: bold; 
    }

    @page { 
      margin: default; 
      scale: 100%; 
    }
    
</style>
<!-- <img src="<?php //echo base_url(); ?>/assets/img/po.jpg" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;height: 100%;"> -->

<span style="top: 161px; left: 118px;"><?php echo $purchase_info->supplier_name; ?></span>
<span style="top: 176px; left: 110px;"><?php echo $purchase_info->terms; ?></span>

<span style="top: 144px; left: 395px;"><?php echo date('m/d/Y'); ?></span>
<span style="top: 161px; left: 415px;"><?php echo $purchase_info->contact_no; ?></span>
<span style="top: 175px; left: 435px;"><?php echo $purchase_info->date_invoice; ?></span>

<div class="panel">

    <table width="100%" style="font-family: Arial; font-weight: bold;font-size: 10pt;">

        <?php 

        $po_line_total_after_global = 0;

        foreach($po_items as $item){

        $po_line_total_after_global += $item->po_line_total_after_global;

        ?>


        <tr>
            <td valign="top" style="width: 30px;max-width: 30px;font-size: 9pt;padding-bottom: 5px;" align="center"><?php echo $item->po_qty * 1; ?></td>
            <td valign="top" style="width: 40px;max-width: 40px;font-size: 9pt;padding-bottom: 5px;text-align: center;"><?php echo $item->unit_name; ?></td>
            <td valign="top" style="width: 283px;max-width: 283px;font-size: 9pt;padding-bottom: 5px;text-align: left;padding-left: 10px;"><?php echo $item->product_desc; ?></td>
            <td valign="top" style="width: 75px;max-width: 75px;font-size: 9pt;padding-bottom: 5px;text-align: right;padding-right: 18px;">
                <?php echo number_format($item->po_line_total_after_global,2); ?>
            </td>
        </tr>

        <?php }?>

        <tr>
            <td valign="top" style="width: 30px;max-width: 30px;font-size: 9pt;padding-bottom: 5px;" align="center">&nbsp;</td>
            <td valign="top" style="width: 40px;max-width: 40px;font-size: 9pt;padding-bottom: 5px;text-align: center;">&nbsp;</td>
            <td valign="top" style="width: 283px;max-width: 283px;font-size: 9pt;padding-bottom: 5px;text-align: left;padding-left: 10px;">&nbsp;</td>
            <td valign="top" style="width: 75px;max-width: 75px;font-size: 9pt;padding-bottom: 5px;text-align: right;padding-right: 18px;">
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
