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
        <td rowspan="2" width="10%">PAYEE:</td>
        <td rowspan="2" width="60%" class="all-caps"><?php echo $journal_info->supplier_name; ?></td>
        <td class="align-right" >CK#</td>
        <td style="padding-left: 5px;" class="bold"><?php echo $journal_info->check_no; ?></td>
    </tr>
    <tr>
        <td class="align-right" >Date:</td>
        <td style="padding-left: 5px;" class="bold"><?php echo date('F d, Y', strtotime($journal_info->check_date)); ?></td>
    </tr>

</table>




<div class="table-wrapper" style="height: 350px"> 
    <table width="100%" style="border-spacing: 0px;" id="table-details" height="100%">
            <thead>
            <tr>
                <td width="15%" style="height: 15px;padding: 3px;" class=" top bottom left bold align-center">ACCOUNT CODE</td>
                <td width="40%" style="height: 15px;padding: 3px;" class=" top bottom left bold align-center" colspan="2">ACCOUNT DESCRIPTION</td>
                <td width="5%" style="height: 15px;padding: 3px;" class=" top bottom left  bold align-center"></td>
                <td width="25%" style="height: 15px;padding: 3px;" class=" top bottom left right bold align-center" colspan="2">AMOUNT</td>

            </tr>
            </thead>
            <tr >
                <td style="text-align: right;" class="left" ></td>
                <td class="left  align-left all-caps" colspan="2" width="40%"></td>
                <td class="left" width="5%" ></td>
                <td class="left bottom align-center bold" >DEBIT</td>
                <td class="left bottom right align-center bold" >CREDIT</td>

            </tr>
            <?php

            $dr_amount=0.00; $cr_amount=0.00;
            foreach($journal_accounts as $account){
                if($account->dr_amount  > 0){ ?>
                <tr >
                    <td class="left"></td>
                    <td class="left align-left all-caps" colspan="2" width="40%"><?php echo $account->account_title; ?></td>
                    <td class="left"></td>
                    <td class="left align-right" ><?php  if($account->dr_amount == 0){echo ''; } else{ echo number_format($account->dr_amount,2);} ?></td>
                    <td class="left right align-right" ><?php if($account->cr_amount == 0){ echo ''; } else{ echo number_format($account->cr_amount,2);} ?></td>
                    
                </tr>

                <?php } else { ?>
                <tr >
                    <td class="left"></td>
                    <td width="5%" class="left"></td>
                    <td class="align-left all-caps" width="35%"><?php echo $account->account_title; ?></td>
                    <td class="left"></td>
                    <td class="left align-right" ><?php  if($account->dr_amount == 0){echo ''; } else{ echo number_format($account->dr_amount,2);} ?></td>
                    <td class="left right align-right" ><?php if($account->cr_amount == 0){ echo ''; } else{ echo number_format($account->cr_amount,2);} ?></td>
                </tr>
                <?php }?>
                <?php $dr_amount+=$account->dr_amount; $cr_amount+=$account->cr_amount; } ?>
                    <tr>
                        <td class="left top bottom">Particulars</td>
                        <td class="left top bottom"></td>
                        <td class="bold top bottom align-right">TOTAL: </td>
                        <td class="left top bottom">P</td>
                        <td class="left top bottom align-right bold"><?php echo number_format($dr_amount,2); ?></td>
                        <td class="left right top bottom align-right bold"><?php echo number_format($cr_amount,2); ?></td>
                    </tr>
                    <tr>
                        <td class="left top right bottom" colspan="6" style="height: 30px;padding: 6px;"><?php  echo $journal_info->remarks;?></td>
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


</body>
</html>
















