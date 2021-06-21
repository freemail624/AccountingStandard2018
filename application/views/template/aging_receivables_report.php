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
    <h4>
        TENANTS' AGING OF RECEIVABLES REPORT <br/>
        Department : <?php echo $department_name; ?>
    </h4>

    <table width="100%" cellspacing="0" id="table_aging" cellpadding="5">
    	<tr>
            <td width="10%"><b>Tenant Code</b></td>
    		<td width="20%"><b>Tenant Name</b></td>
    		<td width="10%" class="right"><center><b>0-30 <br/> DAYS</b></center></td>
    		<td width="10%" class="right"><center><b>31-60 <br/> DAYS</b></center></td>
    		<td width="10%" class="right"><center><b>61-90 <br/> DAYS</b></center></td>
    		<td width="10%" class="right"><center><b>90 DAYS <br/> AND <br/> ABOVE</b></center></td>
            <td width="10%" class="right"><center><b>BALANCE</b></center></td>
            <td width="10%" class="right"><center><b>TOTAL <br/> SECURITY <br/> DEPOSIT</b></center></td>
            <td width="10%" class="right"><center><b>Status</b></center></td>
    	</tr>
    	<tbody>
            <?php $sum_thirty = 0; $sum_sixty = 0; $sum_ninety = 0; $sum_over_ninety = 0;
                $sum_balance = 0; $sum_security_deposit=0;

             ?>
            <?php foreach($receivables as $receivable) { ?>

                <tr>
                    <td><?php echo $receivable->tenant_code; ?></td>
                    <td><?php echo $receivable->trade_name; ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_thirty_days,2) == 0 ? '' : number_format($receivable->balance_thirty_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_sixty_days,2) == 0 ? '' : number_format($receivable->balance_sixty_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_ninety_days,2) == 0 ? '' : number_format($receivable->balance_ninety_days,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->balance_over_ninetydays,2) == 0 ? '' : number_format($receivable->balance_over_ninetydays,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->total_tenant_balance,2) == 0 ? '' : number_format($receivable->total_tenant_balance,2)); ?></td>
                    <td align="right"><?php echo (number_format($receivable->total_security_deposit,2) == 0 ? '' : number_format($receivable->total_security_deposit,2)); ?></td>
                    <td><?php echo $receivable->status; ?></td>
                </tr>
              <?php $sum_thirty += $receivable->balance_thirty_days;
                    $sum_sixty += $receivable->balance_sixty_days;
                    $sum_ninety += $receivable->balance_ninety_days;
                    $sum_over_ninety += $receivable->balance_over_ninetydays;
                    $sum_balance += $receivable->total_tenant_balance;
                    $sum_security_deposit += $receivable->total_security_deposit;
            ?>
            <?php } ?>
            <tr >
                <td></td>
                <td></td>
                <td align="right"><b><?php echo number_format($sum_thirty,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_sixty,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_ninety,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_over_ninety,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_balance,2); ?></b></td>
                <td align="right"><b><?php echo number_format($sum_security_deposit,2); ?></b></td>
                <td></td>
            </tr>
    	</tbody>
    </table>
   <small> Printed by : <?php echo $this->session->user_fullname; ?> <br>
        Printed Date : <?php echo date('m/d/Y h:i:sa');?>
   </small>
</body>
</html>