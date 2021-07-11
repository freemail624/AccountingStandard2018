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
        top: 420px;      
        left: 15px;    
    }

    @page { 
	  size: A4; 
	  margin: default; 
	  scale: 100%; 
	}
    
</style>
<img src="../../assets/img/bir_forms/form_2307_1st_page_1.png" style="top: 0px; left: 0px; width: 100%;position: absolute;z-index: 100;height: 100%;">
<?php foreach($items as $item){ ?>
<span style="top: 0px; left: 0px;"><?php echo $item->reference_no; ?></span>
<?php } ?>

<span style="top: 112px; left: 170px;letter-spacing: 10px;"><?php echo $m; ?></span>
<span style="top: 112px; left: 203px;letter-spacing: 10px;"><?php echo $from_period_day; ?></span>
<span style="top: 112px; left: 235px;letter-spacing: 10px;"><?php echo $y; ?></span>

<span style="top: 112px; left: 476px;letter-spacing: 10px;"><?php echo $m; ?></span>
<span style="top: 112px; left: 509px;letter-spacing: 10px;"><?php echo $to_period_day; ?></span>
<span style="top: 112px; left: 540px;letter-spacing: 10px;"><?php echo $y; ?></span>

<span style="top: 149px; left: 240px;letter-spacing: 7px;"><?php echo $payee_tin_1;?></span>
<span style="top: 149px; left: 303px;letter-spacing: 7.5px;"><?php echo $payee_tin_2;?></span>
<span style="top: 149px; left: 365px;letter-spacing: 9px;"><?php echo $payee_tin_3;?></span>
<span style="top: 149px; left: 430px;letter-spacing: 11.5px;"><?php echo $payee_tin_4;?></span>

<span style="top: 182px; left: 25px;letter-spacing: 1px; width: 680px;max-width:680px;"><?php echo $particular->particular; ?></span>

<span style="top: 215px; left: 25px;letter-spacing: 1px; width: 610px;max-width:610px;"><?php echo $particular->address; ?></span>
<span style="top: 215px; left: 652px;letter-spacing: 8.5px;"><?php echo $particular->zip_code; ?></span>

<span style="top: 195px; left: 130px;letter-spacing: 1px; width: 420px;max-width:420px;"></span>
<span style="top: 195px; left: 635px;letter-spacing: 9px;"></span>

<span style="top: 287px; left: 240px;letter-spacing: 7px;"><?php echo $payor_tin_1; ?></span>
<span style="top: 287px; left: 303px;letter-spacing: 7.5px;"><?php echo $payor_tin_2; ?></span>
<span style="top: 287px; left: 365px;letter-spacing: 9px;"><?php echo $payor_tin_3; ?></span>
<span style="top: 287px; left: 430px;letter-spacing: 11.5px;"><?php echo $payor_tin_4; ?></span>

<span style="top: 320px; left: 25px;letter-spacing: 1px; width: 680px;max-width:680px;"><?php echo $company->registered_to; ?></span>

<span style="top: 354px; left: 25px;letter-spacing: 1px; width: 610px;max-width:610px;display: inline;"><?php echo $company->registered_address; ?></span>
<span style="top: 354px; left: 652px;letter-spacing: 8.5px;"><?php echo $company->zip_code; ?></span>

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
            <td valign="top" style="width: 180px;max-width: 180px;font-size: 9pt;padding-bottom: 10px;"><?php echo $item->remarks; ?></td>
            <td valign="top" style="width: 45px;max-width: 45px;font-size: 9pt;padding-bottom: 10px;text-align: center;"><?php echo $item->atc; ?></td>
            <td valign="top" style="width: 85px;max-width: 85px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php  if ($item->quarter == 1){ echo number_format($item->gross_amount,2); }?>
            </td>
            <td valign="top" style="width: 90px;max-width: 90px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php  if ($item->quarter == 2){ echo number_format($item->gross_amount,2); }?>
            </td>
            <td valign="top" style="width: 90px;max-width: 90px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php  if ($item->quarter == 3){ echo number_format($item->gross_amount,2); }?>
            </td>
            <td valign="top" style="width: 90px;max-width: 90px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php echo number_format($item->gross_amount,2); ?>
            </td>
            <td valign="top" style="width: 110px;max-width: 110px;font-size: 9pt;padding-bottom: 10px;text-align: right;">
                <?php echo number_format($item->deducted_amount,2); ?>
            </td>
        </tr>

        <?php }?>

    </table>
</div>

<?php if ($quarter == 1){?>
<span style="top: 586px; left: 250px;font-size: 9pt;text-align: center;width: 85px;max-width: 85px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<?php }else if ($quarter == 2){?>
<span style="top: 586px; left: 340px;font-size: 9pt;text-align: center;width: 88px;max-width: 88px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<?php }else if($quarter == 3){?>
<span style="top: 586px; left: 430px;font-size: 9pt;text-align: center;width: 86px;max-width: 86px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<?php }?>


<span style="top: 586px; left: 520px;font-size: 9pt;text-align: center;width: 85px;max-width: 85px; text-align: right;"><?php echo number_format($total_gross_amount,2);?></span>
<span style="top: 586px; left: 610px;font-size: 9pt;text-align: center;width: 102px;max-width: 102px; text-align: right;"><?php echo number_format($total_deducted_amount,2); ?></span>

<span style="top: 960px; left: 25px;width: 680px;max-width:680px;font-size: 10pt;"><center><?php echo $particular->particular; ?></center></span>

<!-- <img src="../../assets/img/bir_forms/form_2307_2nd_page.png" style="top: 1050px; left: 0px; width: 100%;position: absolute;z-index: 100;"> -->
<script type="text/javascript">
    window.print();
</script>
