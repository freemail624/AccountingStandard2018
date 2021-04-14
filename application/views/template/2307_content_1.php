<style type="text/css">
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
    }

@media print {
      @page { size: landscape; }
}
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black!important;}

.fifteen{ width: 15%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
.text-left{text-align: left;}
.bordered{
    border: 1px solid black;
}
.border-collapse{
    border-collapse: collapse;
}
</style>
<!--     <table width="100%">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php //echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <h3 class="report-header"><strong><?php //echo $company_info->company_name; ?></strong></h3>
                <p><?php //echo $company_info->company_address; ?></p>
                <p><?php //echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php //echo $company_info->email_address; ?></p>
            </td>
        </tr>
    </table><hr> -->
    <table width="100%" class="table border-collapse" cellspacing="5">
        <tr>
            <td width="15%">BIR REGISTERED NAME</td>
            <td width="30%" class="bottom">: <strong><?php echo $company_info->registered_to; ?></strong></td>
            <td width="55%"></td>
        </tr>
        <tr>
            <td>TRADE NAME</td>
            <td class="bottom">: <?php echo $company_info->company_name; ?></td>
            <td></td>
        </tr>
        <tr>
            <td>ADDRESS</td>
            <td class="bottom">: <?php echo $company_info->registered_address; ?></td>
            <td></td>
        </tr>
        <tr>
            <td>TIN NUMBER</td>
            <td class="bottom">: 
            <?php echo 
                    substr($company_info->tin_no,0, 3).'-'.
                    substr($company_info->tin_no,3, 3).'-'.
                    substr($company_info->tin_no,6, 3).'-'.
                    substr($company_info->tin_no,9, 3);?>
            </td>
            <td></td>
        </tr>
    </table>
    <br/>
    <table width="100%" cellspacing="5">
        <tr>
            <td>
                <h3 class="report-header">
                    <center>
                        <strong>

                            <?php if($month_id == null){ ?>

                                ALPHALIST OF PAYESS (MAP) <br/>
                                FOR THE YEAR OF <span style="text-transform: uppercase; "><?php echo $_GET['year']; ?>

                            <?php }else{?>

                                MONTHLY ALPHALIST OF PAYESS (MAP) <br/>
                                FOR THE MONTH OF <span style="text-transform: uppercase; "><?php echo $month->month_name.' '.$_GET['year'];  ?>

                            <?php }?>
                        </strong>
                    </center>
                </h3>
            </td>
        </tr>
    </table>
    <br/>
    <table id="tbl_2307" class="table table-striped border-collapse" cellspacing="5" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th class="bordered" width="5%">Seq. No. <br/> (1)</th>
                <th class="bordered" width="15%">TIN <br/> Including Branch Code <br/> (2) </th>
                <th class="bordered" width="20%">Registered Name <br/> (Alphalist) <br/> (3)</th>
                <th class="bordered" width="10%">Return Period <br/> mm/yy <br/> (4)</th>
                <th class="bordered" width="10%">ATC <br/><br/> (5)</th>
                <th class="bordered" width="15%">Nature <br/> Income Payment <br/> (6)</th>
                <th class="bordered" width="10%">Amount Tax Base <br/> (7)</th>
                <th class="bordered" width="5%">Tax <br/> Rate <br/> (8)</th>
                <th class="bordered" width="10%"><br/> Tax Withheld <br/> (9)</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total_amount_tax_based = 0;
        $total_tax_withheld = 0;
        $i=1;

        foreach ($items as $item) { 
            $total_amount_tax_based += $item->gross_amount;
            $total_tax_withheld += $item->deducted_amount;
        ?>
            <tr>

                <td class="bordered"><?php echo $i; ?></td>
                <td class="bordered"><center>
                <?php 
                    if($item->tin_no != "" || null){
                        echo 
                            substr($item->tin_no,0, 3).'-'.
                            substr($item->tin_no,3, 3).'-'.
                            substr($item->tin_no,6, 3).'-'.
                            substr($item->tin_no,9, 3);
                }?></center></td>
                <td class="bordered"><?php echo $item->particular; ?></td>
                <td class="bordered"><center><?php echo  date_format(date_create($item->date_txn),"m/y"); ?></center></td>
                <td class="bordered"><?php echo $item->atc; ?></td>
                <td class="bordered"><?php echo $item->remarks; ?></td> 
                <td class="bordered text-right"><?php echo number_format($item->gross_amount,2); ?></td>
                <td class="bordered text-right"><?php echo number_format($item->tax_rate,2); ?></td>
                <td class="bordered text-right"><?php echo number_format($item->deducted_amount,2); ?></td>
            </tr>
        <?php $i++; } ?>
        <tr>
            <td class="bordered"></td>
            <td class="bordered"></td>
            <td class="bordered"></td>
            <td class="bordered"><strong>AMOUNT</strong></td>
            <td class="bordered"></td>
            <td class="bordered"></td>
            <td class="bordered text-right"><?php echo number_format($total_amount_tax_based,2);?></td>
            <td class="bordered"></td>
            <td class="bordered text-right"><?php echo number_format($total_tax_withheld,2);?></td>
        </tr>
        </tbody>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td width="85%">
                <pre style="font-family: calibri;">
                    I, declare under the penalties of perjury, that this has been made in good faith, verified by me, and to the best of my knowledge and belief, is true &amp; correct pursuant to the provisions of the NIRC, and the regulations issued under the authority thereof, that the information contained herein completeley reflects all income payments with the corresponding taxes withheld from payees are duly remitted to the BIR and proper Certificates of Creditable Withholding Tax at Source (BIR Form No. 2307) have been issued to payees; that the information appearing herein shall be consistent with the total amount remitted and that, inconsistent information appearing herein shall be consistent with the total amount remitted and that, inconsistent information shall result to dental of the claims to expenses. 
                </pre>   
            </td>
            <td width="15%;"></td>
        </tr>
    </table>
