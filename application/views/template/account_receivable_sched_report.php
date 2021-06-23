<!DOCTYPE html>
<html>

<head>
    <title>Branch Subsidiary Report</title>
    <style type="text/css">
        body {
            font-family: 'Calibri', sans-serif;
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
            <td width="5%"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 200px; text-align: left;"></td>
            <td width="95%">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline . '/' . $company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
                <p>As of Date <?php echo $date; ?></p><br>
            </td>
        </tr>
    </table>
    <hr>
    <br /><br />
    <center>
        <h3 class="report-header align-center"><strong>Account Receivable Schedule</strong></h3>
    </center>
    <table width="100%" border="1" cellspacing="-1">
        <thead>
            <tr>
                <th width="50%" style="border: 1px solid black;padding: 3px;text-align: left;padding-left: 5px;">Branch</th>
                <th width="15%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">Previous</th>
                <th width="15%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">This Month</th>
                <th width="15%" style="border: 1px solid black;padding: 3px;text-align: right;padding-right: 5px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0.00;
            foreach ($ar_accounts as $ar) { ?>
                <tr>
                    <td style="padding-left: 5px;"><?php echo $ar->customer_name; ?></td>
                    <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->previous, 2); ?></td>
                    <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->current, 2); ?></td>
                    <td align="right" style="padding-right: 5px;"><?php echo number_format($ar->total, 2); ?></td>
                </tr>
            <?php $total += $ar->total;
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" align="right"><b>Total : </b></td>
                <td align="right" style="padding-right: 5px;"><b><?php echo number_format($total, 2); ?></b></td>
        </tfoot>
    </table>

</html>