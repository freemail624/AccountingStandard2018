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
            <td width="30%"><strong><?php echo $company_info->registered_to; ?></strong></td>
        </tr>
        <tr>
            <td>
            <?php echo 
                    substr($company_info->tin_no,0, 3).'-'.
                    substr($company_info->tin_no,3, 3).'-'.
                    substr($company_info->tin_no,6, 3).'-'.
                    substr($company_info->tin_no,9, 3);?>
            </td>
        </tr>
        <tr>
            <td>SCHEDULE OF CREDITABLE INPUT TAX</td>
        </tr>        
        <tr>
            <td>FOR THE MONTH OF <span style="text-transform: uppercase; "><?php echo $month->month_name.' '.$_GET['year'];  ?></td>
        </tr>
    </table>
    <br/>
    <table id="tbl_2307" class="table table-striped border-collapse" cellspacing="5" cellpadding="5" width="100%">
        <thead>
            <tr>

                <th class="bordered" valign="top">Date</th>
                <th class="bordered" valign="top">TIN #</th>
                <th class="bordered" valign="top">Supplier Name</th>
                <th class="bordered" valign="top">OR #</th>
                <th class="bordered" valign="top">Address</th>
                <th class="bordered" valign="top">Income Center</th>
                <th class="bordered" valign="top">Description</th>
                <th class="bordered text-right" valign="top">Purchase Subj to Vat</th>
                <th class="bordered text-right" valign="top">Vat Exempt Purchases</th>
                <th class="bordered text-right" valign="top">Input Tax</th>
                <th class="bordered text-right" valign="top">Gross Taxable</th>
                <th class="bordered" valign="top">ATC</th>
                <th class="bordered" valign="top">Nature Income</th>
                <th class="bordered text-right" valign="top">Tax Rate</th>
                <th class="bordered text-right" valign="top">Tax Withheld</th>



<!--                 <th class="bordered" width="5%">Seq. No. <br/> (1)</th>
                <th class="bordered" width="15%">TIN <br/> Including Branch Code <br/> (2) </th>
                <th class="bordered" width="20%">Registered Name <br/> (Alphalist) <br/> (3)</th>
                <th class="bordered" width="10%">Return Period <br/> mm/yy <br/> (4)</th>
                <th class="bordered" width="10%">ATC <br/><br/> (5)</th>
                <th class="bordered" width="15%">Nature <br/> Income Payment <br/> (6)</th>
                <th class="bordered" width="10%">Amount Tax Base <br/> (7)</th>
                <th class="bordered" width="5%">Tax <br/> Rate <br/> (8)</th>
                <th class="bordered" width="10%"><br/> Tax Withheld <br/> (9)</th> -->
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
                <td class="left right" valign="top"><?php echo $item->date_txn; ?></td>
                <td class="left right" valign="top"><center>
                <?php 
                    if($item->tin_no != "" || null){
                        echo 
                            substr($item->tin_no,0, 3).'-'.
                            substr($item->tin_no,3, 3).'-'.
                            substr($item->tin_no,6, 3).'-'.
                            substr($item->tin_no,9, 3);
                }?></center></td>
                <td class="left right" valign="top"><?php echo $item->supplier_name; ?></td>
                <td class="left right" valign="top"><?php echo $item->ref_no; ?></td>
                <td class="left right" valign="top"><?php echo $item->address; ?></td>
                <td class="left right" valign="top"><?php echo $item->department_name; ?></td> 
                <td class="left right" valign="top"><?php echo $item->remarks; ?></td> 
                <td class="left right text-right" valign="top"><?php echo number_format($item->net_vat,2); ?></td>
                <td class="left right text-right" valign="top"><?php echo number_format(0,2); ?></td>
                <td class="left right text-right" valign="top"><?php echo number_format($item->input_tax,2); ?></td>
                <td class="left right text-right" valign="top"><?php echo number_format($item->gross_taxable,2); ?></td>
                <td class="left right text-left" valign="top"><?php echo $item->atc; ?></td>
                <td class="left right text-left" valign="top"><?php echo $item->description; ?></td>
                <td class="left right text-right" valign="top"><?php echo $item->tax_rate; ?></td>
                <td class="left right text-right" valign="top"><?php echo number_format($item->deducted_amount,2); ?></td>
            </tr>
        <?php $i++; } ?>
            <tr>
                <td colspan="15" class="top"></td>
            </tr>
<!--        <tr>
            <td class="bordered"></td>
            <td class="bordered"></td>
            <td class="bordered"></td>
            <td class="bordered"><strong>AMOUNT</strong></td>
            <td class="bordered"></td>
            <td class="bordered"></td>
            <td class="bordered text-right"><?php echo number_format($total_amount_tax_based,2);?></td>
            <td class="bordered"></td>
            <td class="bordered text-right"><?php echo number_format($total_tax_withheld,2);?></td>
        </tr> -->
        </tbody>
    </table>