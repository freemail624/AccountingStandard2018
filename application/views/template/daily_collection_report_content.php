<!DOCTYPE html>
<html>
<head>
	<title>Replenishment Report</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}
		table, th, td { border-color: white; }
		tr { border-bottom: none !important; }

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
            <td width="10%" style="object-fit: cover;"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <center><h3><strong> <br>Daily Collection Report</strong></h3></center>
    </div>
    <?php  $total_collection = 0; $total_carf = 0; $ending_balance = 0; ?>

                    <table style="width:100%" class="table table-striped">
                    <tr>
                        <td style="width:30%;"><strong>Date:</strong></td>
                        <td style="width:20%;"></td>
                        <td></td>
                        <td></td>
                        <td class="right-align"><?php echo $_GET['date']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><strong>Beginning Balance : </strong></td>
                        <td style="width:20%;"></td>
                        <td></td>
                        <td></td>
                        <td class="right-align"><strong><?php echo number_format($balance,2);?></strong></td>
                    </tr>
                    </table>

                    <h4>Add : Collection</h4>
                    <table class="" width="100%" style="border: 1px solid #757575">
                    <thead>
                        <th style="width:30%;text-align: left;">Particular</th>
                        <th style="width:20%;text-align: left;">Receipt No</th>
                        <th style="text-align: left;">Payment Type</th>
                        <th style="text-align: left;">Transaction No</th>
                        <th class="right-align">Amount</th>
                    </thead>
                        <tbody id="">
                        <?php foreach ($collection as $collection) { $total_collection +=$collection->collection_amount; ?>

                        <tr>
                            <td><?php echo $collection->supplier_name; ?></td>
                            <td><?php echo $collection->or_no; ?></td>
                            <td><?php echo $collection->payment_method; ?></td>
                            <td><?php echo $collection->txn_no; ?></td>
                            <td class="right-align"><?php echo number_format($collection->collection_amount,2); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="right-align"><strong><?php echo number_format($total_collection,2); ?></strong></td>
                        </tr>
                        </tbody>
                    </table>


                    <h4>Less (Out)</h4>
                    <table class="" width="100%" style="border: 1px solid #757575">
                    <thead>
                        <th style="width:30%;text-align: left;">Particular</th>
                        <th style="width:20%;text-align: left;">Transaction Type</th>
                        <th style="text-align: left;">Payment Type</th>
                        <th style="text-align: left;">Transaction No</th>
                        <th class="right-align">Amount</th>
                    </thead>
                        <tbody id="tbl_less">
                        <?php foreach ($carf as $carf) { $total_carf +=$carf->carf_amount; ?>
                        <tr>
                            <td><?php echo $carf->supplier_name;?></td>
                            <td><?php echo $carf->carf_trans_name;?></td>
                            <td><?php echo $carf->payment_method;?></td>        
                            <td><?php echo $carf->txn_no;?></td>
                            <td class="right-align"><?php echo number_format($carf->carf_amount,2); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="right-align"><strong><?php echo number_format($total_carf,2); ?></strong></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <?php  $ending_balance = $balance + $total_collection -$total_carf; ?>
                    <table style="width:100%" class="table table-striped">
                        <thead>
                        <th style="width:30%;text-align: left;">Daily Balance:</th>
                        <th style="width:20%;"></th>
                        <th></th>
                        <th></th>
                        <th class="right-align"><?php echo number_format($ending_balance,2);?></th>
                        </thead>
                    </table>

</body>
</html>