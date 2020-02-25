<!DOCTYPE html>
<html>
<head>
    <title>Cash Disbursement</title>
    <style type="text/css">
    @media print and (width: 8.5in) and (height: 11in) {
            @page{
          margin-left: 45px;
          margin-right: 45px;      
            }
    }
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
        hr {
            border-top: 3px solid #404040;
        }
        .table{
            border-left: 1px ;
            border-style:dashed;
        }
        .padding-info{
            padding-left:10px;
        }
        .table-header{
            text-align: center;
        }
        #table-details td {
            padding:2px 5px 2px 5px;font-size: 10px;
        }
        .table-wrap {
          height:1650px;
          overflow-y: auto;
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
    </style>
    <script type="text/javascript">

</script>

</head>
<body>
<div width="10%" style="object-fit: cover;position: absolute;top:35px;
    left:50px;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 70px; width: 70px; text-align: left;"></div>
<table width="100%" class="table-header">
    <tr>
        <td width="100%" style="line-height:15px;
"><b><?php echo $company_info->company_name; ?></b><br><?php echo $company_info->company_address; ?><br><b>CHECK VOUCHER</b></td>
    </tr>
</table>

<table width="100%" >
    <tr>
        <td rowspan="4" width="10%">PAYEE:</td>
        <td rowspan="4" width="60%" class="all-caps"><?php echo $journal_info->supplier_name; ?></td>
        <td class="align-right" width="10%">CV#</td>
        <td style="padding-left: 5px;" width="20%" class="bold"><?php echo $journal_info->ref_no; ?></td>
    </tr>
    <tr>
        <td class="align-right" >CK#</td>
        <td style="padding-left: 5px;" class="bold"><?php echo $journal_info->check_no; ?></td>
    </tr>
    <tr>
        <td class="align-right" >CV Date:</td>
        <td style="padding-left: 5px;" class="bold"><?php echo date('F d, Y', strtotime($journal_info->date_txn)); ?></td>
    </tr>
    <tr>
        <td class="align-right" >CK Date:</td>
        <td style="padding-left: 5px;" class="bold"><?php echo date('F d, Y', strtotime($journal_info->check_date)); ?></td>
    </tr>

</table>




<div class="table-wrapper" style="height: 350px"> 
    <table width="100%" style="border-spacing: 0px;" id="table-details" height="100%">
            <thead>
            <tr>
                <td width="40%" style="height: 30px;padding: 6px;" class="bold bottom align-center" colspan="2">ACCOUNT DESCRIPTION</td>
                <td width="25%" style="height: 30px;padding: 6px;" class="bold bottom align-center" colspan="2">AMOUNT</td>
                <td width="35%" style="height: 30px;padding: 6px;" class="bold bottom align-center">PARTICULARS</td>
            </tr>
            </thead>
            <tr >
                <td class="right align-left all-caps" colspan="2" width="40%"></td>
                <td class="right align-center bold" >DEBIT</td>
                <td class="right align-center bold" >CREDIT</td>
                <td style="text-align: right;" class="" ></td>
            </tr>
            <?php

            $dr_amount=0.00; $cr_amount=0.00;
            $total_ja = count($journal_accounts);
            $total_after_ja = 20 - $total_ja;
            $details = 0;
            foreach($journal_accounts as $account){
                if($account->dr_amount  > 0){ ?>
                <tr >
                    <td class="right align-left all-caps" colspan="2" width="40%"><?php echo $account->account_title; ?></td>
                    <td class="right align-right" ><?php  if($account->dr_amount == 0){echo ''; } else{ echo number_format($account->dr_amount,2);} ?></td>
                    <td class="right align-right" ><?php if($account->cr_amount == 0){ echo ''; } else{ echo number_format($account->cr_amount,2);} ?></td>
                    <?php if($details == 0){ ?> <td rowspan="19" style="vertical-align: top; text-align: justify;"><?php  echo $journal_info->remarks;?> </td> <?php } $details++; ?>
                </tr>

                <?php } else { ?>
                <tr >
                    <td width="5%"></td>
                    <td class="right align-left all-caps" width="35%"><?php echo $account->account_title; ?></td>
                    <td class="right align-right" ><?php  if($account->dr_amount == 0){echo ''; } else{ echo number_format($account->dr_amount,2);} ?></td>
                    <td class="right align-right" ><?php if($account->cr_amount == 0){ echo ''; } else{ echo number_format($account->cr_amount,2);} ?></td>
                </tr>
                <?php }?>
                <?php $dr_amount+=$account->dr_amount; $cr_amount+=$account->cr_amount; } ?>
                <?php  for($i=0;$i<$total_after_ja;$i++){ ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"></td>
                    </tr>
                <?php }?>
                    <tr>
                        <td class="bottom"> </td>
                        <td class="bottom right"> </td>
                        <td class="right bottom align-right bold"><?php echo number_format($dr_amount,2); ?></td>
                        <td class="right bottom align-right bold"><?php echo number_format($cr_amount,2); ?></td>
                        <td class="bottom"></td>
                    </tr>

    </table>
    <br>
<table width="100%">
    <tr>
        <td width="25%">Prepared By:</td>
        <td width="25%">Certified Correct:</td>
        <td width="25%">Approved:</td>
        <td width="25%">Payment Received:</td>
    </tr>
    <tr>
        <td><?php echo $voucher_info->posted_by ?></td>
        <td><?php echo $voucher_info->verified_by ?></td>
        <td><?php echo $voucher_info->approved_by ?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="top align-center">Signature Over Printed Name/Date</td>
    </tr>
</table>
    </div>
<p style="margin-left: 2.54cm;position: absolute;top: 834; left: 26;" class="all-caps">***<?php echo $journal_info->supplier_name; ?></p>
<p style="margin-left: 2.54cm;position: absolute; top: 863.7270; left: 07.7539;text-transform:capitalize;">***<?php echo $num_words; ?></p>
<p style="margin-left: 2.54cm;position: absolute; top: 828.6370; left: 507.6250;"><?php echo number_format($journal_info->amount,2); ?></p>
<p style="margin-left: 2.54cm;position: absolute; top: 797.6520; left: 508.7110;"><?php echo date('F d, Y', strtotime($journal_info->date_txn)); ?></p>
<p></p>

</body>
</html>
















