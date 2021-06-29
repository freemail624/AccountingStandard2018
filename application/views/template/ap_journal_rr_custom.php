<style type="text/css">
    span{
        position: absolute;
        z-index: 200;
        font-size: 11pt;
        text-transform: uppercase;
    }

    .panel{
        position: absolute;    
        z-index: 200;  
        width: auto;
        height: auto;   
        top: 180px;      
        left: 30px;    
    }

    @page { 
      size: A5-L; 
      margin: default; 
      scale: 100%; 

    }
    
</style>
<!-- <img src="<?php //echo base_url(); ?>/assets/img/rr.jpg" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;height: 100%;"> -->

<span style="top: 102px; left: 150px;"><?php echo $purchase_info->supplier_name; ?></span>
<span style="top: 102px; left: 555px;"><?php echo $purchase_info->date_delivered; ?></span>

<div class="panel">

        <table width="100%" style="font-size: 12pt;">

            <?php 
            $dr_amount = 0;
            $cr_amount = 0;

            if(count($entries) <= 0){ ?>

            <tr>
                <td colspan="3"></td>
            </tr>

            <?php }else{?>

            <?php foreach($entries as $entry){

            $dr_amount += $entry->dr_amount;
            $cr_amount += $entry->cr_amount;
            ?>
                <?php if($entry->dr_amount > 0){ ?>
                    <tr>
                        <td style="width: 370px;max-width: 370px;">
                            <?php echo $entry->account_title; ?>
                        </td>
                        <td style="width: 165px;max-width: 165px;padding-left: 10px;">
                            <?php echo number_format($entry->dr_amount,2); ?>
                        </td>
                        <td style="width: 165px;max-width: 165px;padding-right: 10px;">&nbsp;</td>
                    </tr>
                <?php } ?>

                <?php if($entry->cr_amount > 0){ ?>
                    <tr>
                        <td align="right" style="width: 370px;max-width: 370px;padding-right: 10px;">
                            <?php echo $entry->account_title; ?>
                        </td>
                        <td style="width: 165px;max-width: 165px;padding-left: 10px;">&nbsp;</td>
                        <td style="width: 165px;max-width: 165px;padding-right: 20px;" align="right">
                            <?php echo number_format($entry->cr_amount,2); ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php }?>

            <?php } ?>
            <?php if($purchase_info->remarks != null || ""){ ?>
                <tr>
                        <td colspan="3" align="center">
                            <?php echo $purchase_info->remarks; ?>
                        </td>
                </tr>
            <?php }?>
        </table>


</div>


<span style="top: 379px; left: 650px;">
    <strong><?php echo number_format($purchase_info->total_after_discount,2) ?></strong>
</span>
<script type="text/javascript">
    window.print();
</script>
