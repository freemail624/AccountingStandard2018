<!DOCTYPE html>
<html>
<head>
	<title>Revolving Fund Monitor</title>
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
        <center><strong> <br>Revolving Fund Monitor</strong><br><i>As of <?php echo $_GET['date']; ?></i></center>
    </div>
    <?php  $total_collection = 0; $total_carf = 0; $ending_balance = 0; ?>
        <table style="width:100%" class="table table-striped">
        <tr>
            <td style="width:30%;"><strong>Department:</strong></td>
            <td style="width:20%;"></td>
            <td></td>
            <td></td>
            <td class="right-align"><?php  if($_GET['dep'] == 1){ echo 'All Departments';}else { echo $department_name; }?></td>
        </tr>
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
            <?php if(empty($collection)){ ?>
                <tr>
                    <td colspan="5"><i>No data available in table.</i></td>
                </tr>
            <?php  } else { ?>
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
            <?php } ?>
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
            <?php if(empty($carf)){ ?>
                <tr>
                    <td colspan="5"><i>No data available in table.</i></td>
                </tr>
            <?php  } else { ?>
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
            <?php } ?>
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

<br>

    <center><strong> <br>Revolving Fund Monitor Summary</strong><br><i>As of <?php echo $_GET['date']; ?></i></center>
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


<?php $in_summary_total = 0; $summary_balance = 0?>
        <h4>Add : Collection</h4>
        <table class="" width="100%" style="border: 1px solid #757575">
        <thead>
            <th style="text-align: left;" >Payment Method</th>
            <th style="text-align: right;" >Amount</th>
        </thead>
            <tbody id="">
            <?php if(empty($in_summary)){ ?>
                <tr>
                    <td colspan="5"><i>No data available in table.</i></td>
                </tr>
            <?php  } else { ?>

            <?php foreach ($in_summary as $in_summary) {  $in_summary_total+= $in_summary->dr_amount;?>
            <tr>
                <td><?php echo $in_summary->payment_method;?></td>
                <td class="right-align"><?php echo number_format($in_summary->dr_amount,2); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td><strong>Total:</strong></td>
                <td class="right-align"><strong><?php echo number_format($in_summary_total,2); ?></strong></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

<br>
        <?php $out_summary_total = 0; ?>
        <h4>Less (Out)</h4>
        <table class="" width="100%" style="border: 1px solid #757575">
        <thead>
            <th style="text-align: left;" >Payment Method</th>
            <th style="text-align: right;" >Amount</th>
        </thead>
            <tbody id="">
            <?php if(empty($out_summary)){ ?>
                <tr>
                    <td colspan="5"><i>No data available in table.</i></td>
                </tr>
            <?php  } else { ?>
            <?php foreach ($out_summary as $out_summary) {  $out_summary_total+= $out_summary->cr_amount;?>
            <tr>
                <td><?php echo $out_summary->payment_method;?></td>
                <td class="right-align"><?php echo number_format($out_summary->cr_amount,2); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td><strong>Total:</strong></td>
                <td class="right-align"><strong><?php echo number_format($out_summary_total,2); ?></strong></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php  $ending_balance_summary = $balance + $in_summary_total -$out_summary_total; ?>
<br>
        <table style="width:100%" class="table table-striped">
            <thead>
            <th style="width:30%;text-align: left;">Daily Balance:</th>
            <th style="width:20%;"></th>
            <th></th>
            <th></th>
            <th class="right-align"><?php echo number_format($ending_balance_summary,2);?></th>
            </thead>
        </table>

</body>
</html>