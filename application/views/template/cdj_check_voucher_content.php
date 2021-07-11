<!DOCTYPE html>
<html>
<head>
    <title>Check Voucher</title>
    <style type="text/css">
        body {
            font-family: 'Arial',sans-serif;
            font-size: 11px;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .data {
            border-bottom: 1px solid #404040;
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }
        table{
            border:none;
        }


        .right{
            border-right: 1px solid black;
        }
        .left{
            border-left: 1px solid black;
        }
        .bottom{
            border-bottom: 1px solid black;
        }
        .top{
            border-top: 1px solid black;
        }
        .all-caps{
            text-transform: uppercase;
        }
        .bold { font-weight: bold; }
        .red{
            color: red;
        }
        .dashed-bottom{
            border-bottom: 1px dashed black;
        }
        .dashed-left{
            border-left: 1px dashed black;
        }
        .dashed-right{
            border-right: 1px dashed black;
        }
        .account-font{
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <table width="100%" border="0">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 70px; text-align: left;"></td>
            <td width="75%" class="">
                <center>
                    <h3 class="report-header"><strong><?php echo $company_info->registered_to; ?></strong></h3>
                    <p><?php echo $company_info->company_address; ?></p>
                    <p style="font-size: 10pt;"><strong>CHECK VOUCHER</strong></p>
                </center>
            </td>
            <td width="15%">
            <?php if($journal_info->cancelled_by_user > 0){ ?>
                <img src="assets/img/cancelled.png" style="height: 100px;">
                <?php } ?>
            </td>
        </tr>
    </table>

    <br/>

    <table width="100%">
        <tr>
            <td width="15%">PAYEE : </td>
            <td width="50%"><?php echo $journal_info->particular; ?>***</td>
            <td width="10%" align="right">CV #</td>
            <td width="25%"><strong><?php echo $journal_info->ref_no; ?></strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">CK #</td>
            <td><strong><?php echo $journal_info->check_no; ?></strong></td>
        </tr>   
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">CV Date: </td>
            <td><strong><?php echo date_format(new DateTime($journal_info->date_txn),"F d, Y"); ?></strong></td>
        </tr>        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">CK Date: </td>
            <td><strong><?php if($journal_info->check_date == '0000-00-00'){ echo ''; }else {  echo date_format(new DateTime($journal_info->check_date),"F d, Y"); }?></strong></td>
        </tr>                        
    </table>

    <br/>

    <table width="100%" style="border-collapse: collapse;font-size: 9pt;">
        <tr>
            <td width="40%" class="dashed-bottom"><strong><center>ACCOUNT DESCRIPTION<center></strong></td>
            <td width="20%" class="dashed-bottom" colspan="2"><center><strong>AMOUNT</strong></center></td>
            <td width="40%" class="dashed-bottom"><center><strong>PARTICULARS</strong></center></td>
        </tr>
        <tr>
            <td style="padding: 10px;"></td>
            <td class="left right account-font" style="padding: 10px;"><center><strong>DEBIT</strong></center></td>
            <td class="left right account-font" style="padding: 10px;"><center><strong>CREDIT</strong></center></td>
            <td></td>
        </tr>        
        <tr>
            <td style="height: 30px;"></td>
            <td class="left right"></td>
            <td class="left right"></td>
            <?php $total_rows=count($journal_accounts)+1; ?>
            <td valign="top" rowspan="<?php echo $total_rows; ?>" class="account-font" style="padding-left: 5px;padding-top: 30px;">
                <?php echo $journal_info->remarks; ?>
            </td>
        </tr>
        <?php 
            $dr_amount=0;
            $cr_amount=0;
            foreach($journal_accounts as $account){
            $dr_amount+=$account->dr_amount;
            $cr_amount+=$account->cr_amount;
        ?>
        <?php if($account->dr_amount>0){ ?>
        <tr>
                <td valign="top" class="account-font"><?php echo $account->account_title; ?></td>
                <td valign="top" align="right" class="left right account-font" style="padding-right: 5px;"><?php echo number_format($account->dr_amount,2); ?></td>
                <td valign="top" class="left right account-font" style="padding-right: 5px;">&nbsp;</td>
        </tr>
        <?php }}?>
        <tr>
            <td style="height: 80px;min-height: 80px;">&nbsp;</td>
            <td class="left right">&nbsp;</td>
            <td class="left right">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>         
        <?php foreach($journal_accounts as $account){
            if($account->cr_amount>0){?>
            <tr>
                <td class="account-font" style="padding-left: 100px;"><?php echo $account->account_title; ?></td>
                <td class="left right account-font" style="padding-right: 5px;"></td>
                <td class="left right account-font" style="padding-right: 5px;" align="right"><?php echo number_format($account->cr_amount,2); ?></td>
            </tr>        
        <?php }}?>
        <tr>
            <td style="height: 90px;min-height: 90px;">&nbsp;</td>
            <td class="left right">&nbsp;</td>
            <td class="left right">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>          
        <tr>
            <td class="dashed-bottom"></td>
            <td class="dashed-bottom left right account-font" align="right" style="padding: 5px;">
                <strong><?php echo number_format($dr_amount,2); ?></strong>
            </td>
            <td class="dashed-bottom left right account-font" align="right" style="padding: 5px;">
                <strong><?php echo number_format($cr_amount,2); ?></strong>
            </td>
            <td class="dashed-bottom"></td>
        </tr>     
    </table>
    <center>
    <br>
        <table width="100%">
            <tr>
                <td valign="top" width="23%">Prepared By:</td>
                <td valign="top" width="23%">Certified By:</td>

                <?php if($journal_info->cancelled_by_user > 0){  ?>
                    <td valign="top" width="23%">Cancelled By:</td>
                <?php }else{?>
                    <td valign="top" width="23%">Approved:</td>
                <?php }?>

                <td valign="top" width="31%">Payment Received:</td>
            </tr>
            <tr>
                <td valign="top" style="height: 40px;"><?php echo $journal_info->posted_by ?></td>
                <td valign="top"><?php echo $journal_info->verified_by ?></td>
                <td valign="top">
                <?php if($journal_info->cancelled_by_user > 0){ 
                        echo $journal_info->cancelled_by;
                    }else{
                        echo $journal_info->approved_by;
                }?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="top align-center">Signature Over Printed Name/Date</td>
            </tr>
        </table>
    </center>  

    <br/><br/><br/><br/>

    <table width="100%" cellpadding="5" cellspacing="5">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 40px; width: 40px; text-align: left;"></td>
            <td colspan="2" width="80%"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right"><?php if($journal_info->check_date == '0000-00-00'){ echo ''; }else {  echo date_format(new DateTime($journal_info->check_date),"F d, Y"); }?></td>
        </tr>
        <tr>
            <td></td>
            <td>*** <?php echo $journal_info->check_particular; ?> ***</td>
            <td align="right"><?php echo number_format($journal_info->amount,2); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>*** <?php echo $num_words; ?> ***</td>
            <td align="right"></td>
        </tr>        
    </table>
</body>
</html>




















