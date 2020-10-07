<!DOCTYPE html>
<html>
<head>
    <title>Temporary Voucher</title>
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

        hr {
            /*border-top: 3px solid #404040;*/
        }

        tr {
  /*          border: none!important;*/
        }

        tr:nth-child(even){
          
       /*     border: none!important;*/
        }
/*
        tr:hover {
            transition: .4s;
            background: #414141 !important;
            color: white;
        }

        tr:hover .btn {
            border-color: #494949!important;
            border-radius: 0!important;
            -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        }*/
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
    </style>
</head>
<body>
    <table width="100%" border="0">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="70%" class="">
                <h3 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h3>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
            </td>
            <td width="20%">
            <?php if($voucher_info->cancelled_by_user > 0){ ?>
                <img src="assets/img/cancelled.png" style="height: 100px;">
                <?php } ?>
            </td>
        </tr>
    </table><hr>
    <div class="">
        <h3 class="report-header"><strong>TEMPORARY VOUCHER</strong></h3>
    </div>    
    <table width="100%" border="0" cellspacing="-1" style="font-size: 11px;">
        <tr>
            <td style="padding: 4px;" width="50%"><strong>DATE :</strong> <?php echo date_format(new DateTime($voucher_info->date_txn),"m/d/Y"); ?></td>
            <td style="padding: 4px;" width="50%"><strong>REFERENCE TYPE :</strong> <?php echo $voucher_info->ref_type; ?> -  <?php echo $voucher_info->ref_no; ?></td>
        </tr>
        <tr>
            <td style="padding: 4px;" width="50%"><strong>DEPARTMENT :</strong> <?php echo $voucher_info->department_name; ?></td>
            <td style="padding: 4px;" width="50%"><strong>RR #:</strong> <?php echo $voucher_info->dr_invoice_no; ?></td>
        </tr>
        <?php if ($voucher_info->payment_method_id == 2) { ?>
            <tr> 
                <td style="padding: 4px;" width="50%"><strong>CHECK # :</strong> <?php echo $voucher_info->check_no; ?></td>
                <td style="padding: 4px;" width="50%"><strong>CHECK DATE :</strong> <?php if($voucher_info->check_date == '0000-00-00'){ echo ''; }else {  echo date_format(new DateTime($voucher_info->check_date),"m/d/Y"); }?></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="padding: 4px;" width="50%"><strong>TEMPORARY # :</strong> <?php echo $voucher_info->txn_no; ?></td>
            <td style="padding: 4px;" width="50%"><strong>BANK / CHECK TYPE:</strong> <?php echo $voucher_info->check_type_desc; ?></td>
        </tr>
        <tr>
            <td style="padding: 4px;"><strong>PARTICULAR :</strong> <?php echo $voucher_info->particular; ?></td>
            <td style="padding: 4px;" width="50%"><strong>AMOUNT :</strong> <?php echo number_format($voucher_info->amount,2); ?></td>
        </tr>
        <tr>
            <td style="padding: 4px;" width="50%"><strong>PREPARED BY:</strong> <?php echo $voucher_info->posted_by; ?></td>
            <td style="padding: 4px;"><strong>PAYMENT METHOD :</strong> <?php echo $voucher_info->payment_method; ?></td>
        </tr>

        <tr>
            <td style="padding: 4px;" width="50%"> <?php if($voucher_info->verified_by != ''){ ?>  <strong>CERTIFIED CORRECT:</strong> <?php echo $voucher_info->verified_by; ?><?php } ?></td>
            <td style="padding: 4px;" width="50%"></td>
        </tr>

         <?php if($voucher_info->approved_by != ''){ ?> 
        <tr>
            <td style="padding: 4px;" width="50%"> <strong>APPROVED BY:</strong> <?php echo $voucher_info->approved_by; ?></td>
            <td style="padding: 4px;" width="50%"></td>
        </tr>
        <?php } ?>
        <?php if($voucher_info->cancelled_by != ''){ ?>
        <tr>
            <td style="padding: 4px;" width="50%">   <strong>DISAPPROVED BY:</strong> <?php echo $voucher_info->cancelled_by; ?></td>
            <td style="padding: 4px;" width="50%"></td>
        </tr>
        <?php } ?>
    </table><br>
    <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11" border="0">
            <thead>
            <tr>
                <th width="10%" style="border: 1px solid black;text-align: left;height: 30px;padding: 6px;">Account #</th>
                <th width="30%" style="border: 1px solid black;text-align: left;height: 30px;padding: 6px;">Account</th>
                <th width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;">Memo</th>
                <th width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;">Debit</th>
                <th width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;">Credit</th>
                <th width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;">Department</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $dr_amount=0.00; $cr_amount=0.00;

            foreach($journal_accounts as $account){

                ?>
                <tr>
                    <td width="30%" style="border: 1px solid black;text-align: left;height: 30px;padding: 6px;"><?php echo $account->account_no; ?></td>
                    <td width="30%" style="border: 1px solid black;text-align: left;height: 30px;padding: 6px;"><?php echo $account->account_title; ?></td>
                    <td width="30%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;"><?php echo $account->memo; ?></td>
                    <td width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($account->dr_amount,2); ?></td>
                    <td width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($account->cr_amount,2); ?></td>
                    <td width="15%" style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;"><?php echo $account->department_name ?></td>
                </tr>
                <?php

                $dr_amount+=$account->dr_amount;
                $cr_amount+=$account->cr_amount;

            }

            ?>

            </tbody>
                <tfoot>
                    <tr style="border: 1px solid black;">
                        <td colspan="5"></td>
                    </tr>
                    <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;text-align: left;height: 30px;padding: 6px;" colspan="2"><strong>Remarks :</strong></td>
                        <td style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;" align="right"><strong>Total : </strong></td>
                        <td style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;" align="right"><strong><?php echo number_format($dr_amount,2); ?></strong></td>
                        <td style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;" align="right"><strong><?php echo number_format($cr_amount,2); ?></strong></td>
                        <td style="border: 1px solid black;text-align: right;height: 30px;padding: 6px;" align="right"></td>
                    </tr>
                    <tr style="border: 1px solid black;">
                        <td colspan="6" style="border: 1px solid black;text-align: left;height: 30px;padding: 6px;"><?php echo $voucher_info->remarks; ?></td>
                    </tr>
                </tfoot>    
        </table><br/><br/>
        <center>
        <br>
            <table width="100%">
                <tr>
                    <td width="25%">Prepared By:</td>
                    <td width="25%">Verified By:</td>

                    <?php if($voucher_info->cancelled_by_user > 0){  ?>
                        <td width="25%">Cancelled By:</td>
                    <?php }else{?>
                        <td width="25%">Approved:</td>
                    <?php }?>

                    <!-- <td width="25%">Payment Received:</td> -->
                    <td width="25%"></td>
                </tr>
                <tr>
                    <td><?php echo $voucher_info->posted_by ?></td>
                    <td><?php echo $voucher_info->verified_by ?></td>
                    <td>
                    <?php if($voucher_info->cancelled_by_user > 0){ 
                            echo $voucher_info->cancelled_by;
                        }else{
                            echo $voucher_info->approved_by;
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
</body>
</html>




















