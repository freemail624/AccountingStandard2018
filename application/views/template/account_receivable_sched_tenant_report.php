<!DOCTYPE html>
<html>
<head>
    <title>Customer Subsidiary Report - Tenant</title>
    <style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
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
            font-size: 10pt;
            font-weight: bolder;
        }

        hr {
            border-top: 3px solid #404040;
        }
    </style>
</head>
<body>
<table width="100%">
    <tr>
        <td width="5%"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td>
        <td width="95%" >
            <h3 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h3>
            <p><?php echo $company_info->company_address; ?></p>
            <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
            <p><?php echo $company_info->email_address; ?></p>
            <p>As of Date <?php echo $date; ?></p><br>
        </td>
    </tr>
</table>
<hr>
<br /><br />
        <center><h3 class="report-header align-center"><strong>Account Receivable Schedule - Tenant</strong></h3></center>
<table width="100%" border="1" cellspacing="-1">
    <thead>
        <tr>
            <th width="20%" style="border: 1px solid black;padding: 3px;text-align: left;padding-left: 5px;">Tenant</th>
            <th width="10%" style="border: 1px solid black;padding: 3px;text-align: left;padding-left: 5px;">Tenant Code</th>
            <th width="10%" style="border: 1px solid black;padding: 3px;text-align: left;padding-left: 5px;">Space Code</th>
            <th width="7%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">
            As of <br/> <?php echo $prev_month; ?>
            </th>
            <th width="7%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">2307</th>
            <th width="7%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">Billed</th>
            <th width="7%" style="border: 1px solid black;padding: 3px;text-align: center;">OR Detail</th>
            <th width="7%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">Payments</th>
            <th width="9%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">Adjustment (Dr)</th>
            <th width="9%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">Adjustment (Cr)</th>
            <th width="7%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">
            As of <br/> <?php echo $current_month; ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $total_previous=0;
            $total_2307=0;
            $total_billing=0;
            $total_payment=0;
            $total_adjustment_dr=0;
            $total_adjustment_cr=0;
            $total=0;

            foreach($ar_accounts as $ar){ ?>
            <tr>
                <td style="padding-left: 5px;"><?php echo $ar->customer_name; ?></td>
                <td style="padding-left: 5px;"><?php echo $ar->tenant_code; ?></td>
                <td style="padding-left: 5px;"><?php echo $ar->space_code; ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->previous,2); ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->wtax_expanded,2); ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->billing,2); ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo $ar->or_details; ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->payment,2); ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->adjustment_dr,2); ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->adjustment_cr,2); ?></td>
                <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->total,2); ?></td>
            </tr>
        <?php 
            $total_previous+=$ar->previous;
            $total_2307+=$ar->wtax_expanded;
            $total_billing+=$ar->billing;
            $total_payment+=$ar->payment;
            $total_adjustment_dr+=$ar->adjustment_dr;
            $total_adjustment_cr+=$ar->adjustment_cr;
            $total+=$ar->total;
        } ?>
    </tbody>
    <tfoot>
    <tr>
        <td align="right" colspan="3"><b>Total : </b></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total_previous,2); ?></b></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total_2307,2); ?></b></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total_billing,2); ?></b></td>
        <td align="right" style="padding-right: 5px;"></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total_payment,2); ?></b></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total_adjustment_dr,2); ?></b></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total_adjustment_cr,2); ?></b></td>
        <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total,2); ?></b></td>
    </tfoot>
</table>
</html>