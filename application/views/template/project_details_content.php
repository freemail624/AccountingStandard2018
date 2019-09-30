        <style type="text/css">
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 11px;
    }
    @page {
                    size: auto;   /* auto is the initial value */
                    margin: .5in .5in 1in .5in; 
    }
/*    tr:hover {
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
/*.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black!important;}*/

/*.fifteen{ width: 15%; }*/
.text-center{text-align: center;}
.text-right{text-align: right;}
th{
    text-align: left
}
</style>
    <table width="100%" class="noborder">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <h3 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h3>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
            </td>
        </tr>
    </table><hr>
        <table width="100%" cellpadding="5" cellspacing="0">
        <tr>
                <td class="left bottom top"><span>Project Name:</span></td>
                <td class="bottom top"><?php echo $project_info->project_name; ?></td>
                <td class="left bottom fifteen top">Start Date:</td>
                <td class="bottom right top"><?php echo  date_format(new DateTime($project_info->date_start ),"m/d/Y"); ?></td>
        </tr>
        <tr>
                <td class="left bottom fifteen" ><span>Description:</span></td>
                <td class="bottom "><?php echo $project_info->project_desc?></td>
                <td class="left bottom fifteen top">End Date:</td>
                <td class="bottom right top"><?php echo  date_format(new DateTime($project_info->date_due ),"m/d/Y"); ?></td>
        </tr>
        <tr>

                <td class="left bottom ">Budget Cost Estimate:</td>
                <td  class="bottom  " style="font-weight: bold;"><?php echo number_format($project_info->budget_cost_estimate,2) ?></td>
                <td class="left bottom ">Location:</td>
                <td  class="bottom right "><?php echo $project_info->location_name ?></td>
        </tr>
    </table><br>
    <table width="100%" cellpadding="2">
        <tr>
            <td colspan="7" style="font-weight: bold"><center> Job Service Posting History</center></td>
        </tr>
        <tr style="font-weight: bold;">
            <th>Date</th>
            <th>Job Service No</th>
            <th>Code</th>
            <th>Description</th>
            <th style="text-align: right;">Quantity</th>
            <th>Unit</th>
            <th style="text-align: right">Total</th>
        </tr>
        <?php $total = 0; foreach ($items as $item) { $total += $item->job_line_total_after_global; ?>
           <tr>
               <td><?php echo $item->date_invoice ?></td>
               <td><?php echo $item->jo_billing_no ?></td>
               <td><?php echo $item->job_code ?></td>
               <td><?php echo $item->job_desc ?></td>
               <td style="text-align: right;"><?php echo $item->job_qty ?></td>
               <td><?php echo $item->job_unit_name ?></td>
               <td style="text-align: right;"><?php echo number_format($item->job_line_total_after_global,2) ?></td>


           </tr>
        <?php } ?>
        <tr>
            <td colspan="6" style="font-weight: bold; text-align: right;"> Total</td>
            <td style="font-weight: bold ;text-align: right;"><?php echo number_format($total,2); ?></td>
        </tr>
    </table>

