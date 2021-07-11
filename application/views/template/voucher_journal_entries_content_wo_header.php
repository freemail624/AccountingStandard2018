<!DOCTYPE html>
<html>
<head>
    <title>Cash Disbursement</title>
    <style type="text/css">
        body {
            /*font-family: 'Calibri',sans-serif;*/
            /*font-size: 12px;*/
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
    </style>
</head>
<body>
    <div class="">
    </div>
    <table width="100%" border="0" cellspacing="-1" style="font-size: 11px;">

        <tr>
            <td width="38%" valign="top">
                <table width="100%" border="0" cellspacing="-1" style="border: 0px solid white!important;font-size: 11px;">
                    <tr>
                        <td><strong>DATE :</strong> <?php echo date_format(new DateTime($voucher_info->date_txn),"m/d/Y"); ?></td>
                    </tr>
                    <tr>
                        <td><strong>DEPARTMENT :</strong> <?php echo $voucher_info->department_name; ?></td>
                    </tr>
                    <tr>
                        <td><strong>TEMPORARY # :</strong> <?php echo $voucher_info->txn_no; ?></td>
                    </tr>
                    <tr>
                        <td><strong>PARTICULAR :</strong> <?php echo $voucher_info->particular; ?></td>
                    </tr>
                    <tr>
                        <td><strong>PREPARED BY:</strong> <?php echo $voucher_info->posted_by; ?></td>
                    </tr>
                    <?php if($voucher_info->verified_by != ''){ ?>
                    <tr>
                        <td> <strong>CERTIFIED CORRECT:</strong> <?php echo $voucher_info->verified_by; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($voucher_info->approved_by != ''){ ?> 
                    <tr>
                        <td><strong>APPROVED BY:</strong> <?php echo $voucher_info->approved_by; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($voucher_info->cancelled_by != ''){ ?>
                    <tr>
                        <td><strong>DISAPPROVED BY:</strong> <?php echo $voucher_info->cancelled_by; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
            <td width="37%" valign="top">
                <table width="100%" border="0" cellspacing="-1" style="border: 0px solid white!important;font-size: 11px;">
                    <tr>
                        <td><strong>REFERENCE TYPE :</strong> <?php echo $voucher_info->ref_type; ?> -  <?php echo $voucher_info->ref_no; ?></td>
                    </tr>
                    <?php if($voucher_info->dr_invoice_no != ""){ ?>
                    <tr>
                        <td><strong>RR #:</strong> <?php echo $voucher_info->dr_invoice_no; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($voucher_info->payment_method_id == 2) { ?>
                    <tr>
                        <td><strong>BANK / CHECK TYPE:</strong> <?php echo $voucher_info->check_type_desc; ?></td>
                    </tr>
                    <tr>
                        <td><strong>CHECK # :</strong> <?php echo $voucher_info->check_no; ?></td>
                    </tr>
                    <tr>
                        <td><strong>CHECK DATE :</strong> <?php if($voucher_info->check_date == '0000-00-00'){ echo ''; }else {  echo date_format(new DateTime($voucher_info->check_date),"m/d/Y"); }?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><strong>AMOUNT :</strong> <?php echo number_format($voucher_info->amount,2); ?></td>
                    </tr>
                    <tr>
                        <td><strong>PAYMENT METHOD :</strong> <?php echo $voucher_info->payment_method; ?></td>
                    </tr>
                </table>
            </td>
            <?php if(count($form_2307) > 0){ ?>
                <td width="25%" valign="top">
                    <table width="100%" border="0" cellspacing="-1" style="border: 0px solid white!important;font-size: 11px;">
                        <tr>
                            <td><strong>Applied for 2307 Form</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>ATC : </strong><?php echo $form_2307[0]->atc; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>NET AMOUNT :</strong> <?php echo number_format($voucher_info->net_amount,2); ?></td>
                        </tr>
                    </table>
                </td>
            <?php }?>
        </tr>
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
        </table>
</body>
</html>




















