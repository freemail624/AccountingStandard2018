<!DOCTYPE html>
<html>
<head>
	<title>Profit Report</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}
		table, th, td { border-color: white;}
		tr { border-bottom: none !important; }
		th { border-bottom: 1px solid gray; }

		.report-header {
			font-size: 22px;
		}
		.right-align{

			text-align:right;
		}
		@media print {
      @page { margin: 0; }
      body { margin: 1.0cm; }
}

	h4{
		font-size: 14px;margin-bottom: :5px;
	}
	
	</style>
	<script>
		(function(){
			window.print();
		})();
	</script>
</head>
<body>
	<table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%">
                <span class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong><center>Profit Report By Product</center> </strong></h3>
    </div>

    <?php 
        $summary_grand_qty = 0;
        $summary_grand_gross = 0;
        $summary_grand_net = 0;
        $summary_grand_profit = 0; 
        $summary_grand_return=0;
        $total_net_returned=0;
        $grand_total_net_returned = 0;
        $grand_total_profit=0;
    ?>

    <table cellspacing="0" cellpadding="5">
    	<tr>
    		<td><strong>Period: </strong> <?php echo $_GET['start']  ?> - <?php echo $_GET['end']  ?></td>
    		<td></td>
    		<td></td>
    		<td></td>
    	</tr>
    </table>
    <h4>Profit Report by Invoice (Summary)</h4><br>
    <table style="width:100%" class="table table-striped" id="tbl_summary">
        <thead>
            <th align="left">Invoice No</th>
            <th align="left">Customer Name</th>
            <th align="left">Date</th>
            <th align="right">QTY Sold</th>
            <th align="right">Gross</th>
            <th align="right">Net Cost</th>
            <th align="right">Net Profit</th>
        </thead>
        <tbody>
        <?php foreach ($summary as $value) { ?>
        <tr>
            <td><?php echo $value->inv_no ?></td>
            <td><?php echo $value->customer_name ?></td>
            <td><?php echo $value->date_invoice ?></td>
            <td align="right"><?php echo $value->qty_total ?></td>
            <td align="right"><?php echo number_format($value->gross_total,2) ?></td>
            <td align="right"><?php echo number_format($value->net_cost_total,2) ?></td>
            <td align="right"><?php echo number_format($value->profit_total,2) ?></td>
            </tr>
            <?php 
                $summary_grand_qty+=$value->qty_total;
                $summary_grand_gross+=$value->gross_total;
                $summary_grand_net+=$value->net_cost_total;
                $summary_grand_profit+=$value->profit_total;
            } ?>
            <tr>
                <td colspan="3"><strong>Total : </strong></td>
                <td align="right"><strong><?php echo number_format($summary_grand_qty,2); ?></strong></td>
                <td align="right"><strong><?php echo number_format($summary_grand_gross,2); ?></strong></td>
                <td align="right"><strong><?php echo number_format($summary_grand_net,2); ?></strong></td>
                <td align="right"><strong><?php echo number_format($summary_grand_profit,2); ?></strong></td>
            </tr>
        </tbody>
    </table>
    <br/>

    <?php if(count($returns) > 0){?>
        <h4>
            <span style="float: left;">Returns by Invoice (Summary)</span>
        </h4> 
        <br/><br/>
        <table width="100%" class="table table-striped">
            <thead>
                <tr>
                    <th align="left">Invoice #</th>
                    <th align="left">Customer Name</th>
                    <th align="right">QTY Return</th>
                    <th align="right">Total Return</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($returns as $return){?>
                <tr>
                    <td><?php echo $return->inv_no; ?></td>
                    <td><?php echo $return->customer_name; ?></td>
                    <td align="right"><?php echo number_format($return->returned_qty,2); ?></td>
                    <td align="right"><?php echo number_format($return->total,2); ?></td>
                </tr>
            <?php }?>
            <tbody>
        </table>
    <?php 
        $summary_grand_return += $return->total;
        $total_net_returned += $return->total_net_returned;
    }?>

    <?php 
        $grand_total_profit = ($summary_grand_gross - ($summary_grand_net - $total_net_returned)) - $summary_grand_return;
        $grand_total_net_returned = $summary_grand_profit - $grand_total_profit;
    ?>

    <br><br>
    <table style="width:100%;border:none!important;font-size:12px!important;font-weight:bold;">
        <tr>
            <td width="85%" align="right">Total Quantity Sold: </td>
            <td width="15%" align="right">&nbsp;<?php echo number_format($summary_grand_qty,2);?></td>
        </tr>
        <tr>
            <td align="right">Total Gross: </td>
            <td align="right"><?php echo number_format($summary_grand_gross,2);?></td>
        </tr>
        <tr>
            <td align="right">Total Net: </td>
            <td align="right"><?php echo number_format($summary_grand_net,2);?></td>
        </tr>
        <tr>
            <td align="right">Net Profit: </td>
            <td align="right"><?php echo number_format($summary_grand_profit,2);?></td>
        </tr>
        <tr>
            <td align="right">Total Net Returned: </td>
            <td align="right"><?php echo number_format($grand_total_net_returned,2);?></td>
        </tr>
        <tr>
            <td align="right">Total Profit: </td>
            <td align="right"><?php echo number_format($grand_total_profit,2);?></td>
        </tr>
    </table>

</body>
</html>
