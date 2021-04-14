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
        top: 366px;      
        left: 15px;    
    }

    @page { 
	  size: A4; 
	  margin: default; 
	  scale: 100%; 
	}
    
</style>
<img src="../../assets/img/bir_forms/form_2307_1st_page.png" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;">
<span style="top: 80px; left: 110px;letter-spacing: 5px;"><?php echo $m; ?></span>
<span style="top: 80px; left: 143px;letter-spacing: 5px;"><?php echo $from_period_day; ?></span>
<span style="top: 80px; left: 175px;letter-spacing: 5px;"><?php echo $y; ?></span>

<span style="top: 80px; left: 382px;letter-spacing: 5px;"><?php echo $m; ?></span>
<span style="top: 80px; left: 418px;letter-spacing: 5px;"><?php echo $to_period_day; ?></span>
<span style="top: 80px; left: 454px;letter-spacing: 5px;"><?php echo $y; ?></span>

<span style="top: 120px; left: 130px;letter-spacing: 5px;"><?php echo $payee_tin_1;?></span>
<span style="top: 120px; left: 185px;letter-spacing: 6px;"><?php echo $payee_tin_2;?></span>
<span style="top: 120px; left: 248px;letter-spacing: 6px;"><?php echo $payee_tin_3;?></span>
<span style="top: 120px; left: 310px;letter-spacing: 6px;"><?php echo $payee_tin_4;?></span>

<span style="top: 143px; left: 130px;letter-spacing: 1px; width: 570px;max-width:570px;"><?php echo $particular->particular; ?></span>

<span style="top: 173px; left: 130px;letter-spacing: 1px; width: 420px;max-width:420px;"><?php echo $particular->address; ?></span>
<span style="top: 173px; left: 635px;letter-spacing: 9px;"><?php echo $particular->zip_code; ?></span>

<span style="top: 195px; left: 130px;letter-spacing: 1px; width: 420px;max-width:420px;"></span>
<span style="top: 195px; left: 635px;letter-spacing: 9px;"></span>

<span style="top: 233px; left: 130px;letter-spacing: 5px;"><?php echo $payor_tin_1; ?></span>
<span style="top: 233px; left: 185px;letter-spacing: 6px;"><?php echo $payor_tin_2; ?></span>
<span style="top: 233px; left: 248px;letter-spacing: 6px;"><?php echo $payor_tin_3; ?></span>
<span style="top: 233px; left: 310px;letter-spacing: 6px;"><?php echo $payor_tin_4; ?></span>

<span style="top: 255px; left: 130px;letter-spacing: 1px; width: 570px;max-width:570px;"><?php echo $company->registered_to; ?></span>

<span style="top: 287px; left: 130px;letter-spacing: 1px; width: 420px;max-width:420px;display: inline;font-size: 9pt;"><?php echo $company->registered_address; ?></span>
<span style="top: 287px; left: 635px;letter-spacing: 9px;"><?php echo $company->zip_code; ?></span>

<div class="panel">

    <table width="100%">

        <?php 

        $total_gross_amount = 0;
        $total_deducted_amount = 0;

        foreach($items as $item){

        $total_gross_amount += $item->gross_amount;
        $total_deducted_amount += $item->deducted_amount;

        ?>


        <tr>
            <td valign="top" style="width: 160px;max-width: 160px;font-size: 9pt;padding-bottom: 10px;"><?php echo $item->remarks; ?></td>
            <td valign="top" style="width: 60px;max-width: 60px;font-size: 9pt;padding-bottom: 10px;text-align: center;"><?php echo $item->atc; ?></td>
            <td valign="top" style="width: 80px;max-width: 80px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php  if ($item->quarter == 1){ echo number_format($item->gross_amount,2); }?>
            </td>
            <td valign="top" style="width: 80px;max-width: 80px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php  if ($item->quarter == 2){ echo number_format($item->gross_amount,2); }?>
            </td>
            <td valign="top" style="width: 80px;max-width: 80px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php  if ($item->quarter == 3){ echo number_format($item->gross_amount,2); }?>
            </td>
            <td valign="top" style="width: 78px;max-width: 78px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php echo number_format($item->gross_amount,2); ?>
            </td>
            <td valign="top" style="width: 120px;max-width: 120px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php echo number_format($item->deducted_amount,2); ?>
            </td>
        </tr>

        <?php }?>

    </table>
</div>

<?php if ($quarter == 1){?>
<span style="top: 558px; left: 250px;font-size: 9pt;text-align: center;width: 80px;max-width: 80px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<?php }else if ($quarter == 2){?>
<span style="top: 558px; left: 333px;font-size: 9pt;text-align: center;width: 80px;max-width: 80px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<?php }else if($quarter == 3){?>
<span style="top: 558px; left: 413px;font-size: 9pt;text-align: center;width: 80px;max-width: 80px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<?php }?>

<span style="top: 558px; left: 496px;font-size: 9pt;text-align: center;width: 80px;max-width: 80px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<span style="top: 558px; left: 580px;font-size: 9pt;text-align: center;width: 120px;max-width: 120px; text-align: right;"><?php echo number_format($total_deducted_amount,2); ?></span>

<!-- <img src="../../assets/img/bir_forms/form_2307_2nd_page.png" style="top: 1050px; left: 0px; width: 100%;position: absolute;z-index: 100;"> -->
<script type="text/javascript">
    window.print();
</script>
