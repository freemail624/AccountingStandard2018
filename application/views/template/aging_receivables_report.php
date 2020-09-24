<!DOCTYPE html>
<html>
<head>
	<title>Aging of Receivables Report</title>
	<style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .align-right, .right {
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
      
        }
        p{
            padding: 0px 0px 0px 0px;
        }

        @media print{@page {size: landscape}}
        @media print {
        @page { margin: 0; }
        body { margin: 1.0cm; }

        table#table_aging {
            border-collapse:collapse;

        }
        table#table_aging td {
            border: 1px solid black;
        }  
    </style>
    <script type="text/javascript">
    	(function(){
    		window.print();
    	})();
    </script>
</head>
<body>
    <table width="100%" border="0">
        <tr>
            <td width="10%" style="object-fit: cover;"><img src="<?php echo $company_info->logo_path; ?>" style="height: 90px;width: 90px;  text-align: left;"></td>
            <td width="90%" class="">
                <h3 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h3>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                <p><?php echo $company_info->email_address; ?></p>
            </td>
        </tr>
    </table><hr>
    <td><h4>TENANTS' AGING OF RECEIVABLES REPORT</h4></td>
    <table width="100%" cellspacing="0" id="table_aging" cellpadding="5">
    	<tr>
            <td width="15%"><b>Tenant Code</b></td>
    		<td width="30%"><b>Trade Name</b></td>
    		<td width="15%" class="right"><b>Current</b></td>
    		<td width="15%" class="right"><b>30 Days</b></td>
    		<td width="15%" class="right"><b>45 Days</b></td>
    		<td width="15%" class="right"><b>60 Days</b></td>
    		<td width="15%" class="right"><b>Over 90 Days</b></td>
    	</tr>
    	<tbody>
            <?php $sum_current = 0; $sum_thirty = 0; $sum_fortyfive = 0; $sum_sixty = 0; $sum_ninety = 0; ?>
            <?php foreach($receivables as $receivable) { ?>

                <tr>
                    <td><?php echo $receivable->tenant_code; ?></td>
                    <td><?php echo $receivable->trade_name; ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_current,2) == 0 ? '' : number_format($receivable->balance_current,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_thirty_days,2) == 0 ? '' : number_format($receivable->balance_thirty_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_fortyfive_days,2) == 0 ? '' : number_format($receivable->balance_fortyfive_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_sixty_days,2) == 0 ? '' : number_format($receivable->balance_sixty_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_over_ninetydays,2) == 0 ? '' : number_format($receivable->balance_over_ninetydays,2)); ?></td>
                </tr>
              <?php $sum_current += $receivable->balance_current; 
                    $sum_thirty += $receivable->balance_thirty_days;
                    $sum_fortyfive += $receivable->balance_fortyfive_days;
                    $sum_sixty += $receivable->balance_sixty_days;
                    $sum_ninety += $receivable->balance_over_ninetydays;
            ?>
            <?php } ?>
            <tr >
                <td></td>
                <td></td>
                <td align="right"><b><?php echo number_format($sum_current,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_thirty,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_fortyfive,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_sixty,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_ninety,2); ?></b></td>
            </tr>
    	</tbody>
    </table>
   <small> Printed by : <?php echo $this->session->user_fullname; ?> <br>
        Printed Date : <?php echo date('m/d/Y h:i:sa');?>
   </small>
</body>
</html>