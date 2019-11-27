<!DOCTYPE html>
<html>
<head>
	<title>Supplier Subsidiary Report</title>
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
            font-weight: bolder;
        }

        hr {
            border-top: 3px solid #404040;
        }
        @media print {
/*      @page { margin: 0; }
      body { margin: 1.0cm; }*/
}
    </style>
    <script type="text/javascript">
        (function(){
            window.print();
        })();
    </script>
</head>
<body>
	<table width="100%">
        <tr>
            <td width="5%"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="95%">
                <span class="report-header" style="font-size:20px;"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table><hr>
    <div class="">
    
        <table width="100%">
            <tr>
                <td colspan="2"><center><strong>SUPPLIER DETAILED SUBSIDIARY REPORT</strong></center></td>
            </tr>
            <tr>
                <td width="50%">ACCOUNT: <b><?php  echo $account->account_no ?> - <?php  echo $account->account_title ?> </b></td>
                <td width="50%" style="text-align: right;">PERIOD : <?php echo '<strong>'.$_GET['startDate'].'</strong> to <strong>'.$_GET['endDate'].'</strong>'; ?></td>
            </tr>
        </table>
    </div>

        <?php $count = 0; foreach ($suppliers as $supplier) { if(!empty($responses[$supplier->supplier_id])){ ?>
                    
    <table width="100%" border="0" cellspacing="0">
        <thead>
        <tr><th colspan="8" style="border: 1px solid gray;text-align: left;padding: 6px;"><?php echo $supplier->supplier_name; ?></th></tr>
            <tr>
                <th style="border: 1px solid gray;text-align: center;padding: 6px;">Txn Date</th>
                <th style="border: 1px solid gray;text-align: center;padding: 6px;">Txn #</th>
                <th style="border: 1px solid gray;text-align: left;padding: 6px;">Memo</th>
                <th style="border: 1px solid gray;text-align: left;padding: 6px;">Remarks</th>
                <th style="border: 1px solid gray;text-align: left;padding: 6px;">Posted by</th>
                <th style="border: 1px solid gray;text-align: right;padding: 6px;">Debit</th>
                <th style="border: 1px solid gray;text-align: right;padding: 6px;">Credit</th> 
                <th style="border: 1px solid gray;text-align: right;padding: 6px;">Balance</th>
            </tr>
        </thead>
        <tbody>
             <?php foreach($responses[$supplier->supplier_id] as $items) { ?>
            <tr>
                <td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->date_txn; ?></td>
                <td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->txn_no; ?></td>
                <td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->memo; ?></td>
                <td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->remarks; ?></td>
                <td style="border: 1px solid gray;text-align: left;height: 20px;padding: 6px;"><?php echo $items->posted_by; ?></td>
                <td style="border: 1px solid gray;text-align: right;height: 20px;padding: 6px;"><?php echo number_format($items->debit,2); ?></td>
                <td style="border: 1px solid gray;text-align: right;height: 20px;padding: 6px;"><?php echo number_format($items->credit,2); ?></td>
                <td style="border: 1px solid gray;text-align: right;height: 20px;padding: 6px;"><?php echo number_format($items->balance,2); ?></td>
            </tr>
             <?php $count++; }  // END OF FOREACH RESPONSE SUPPLIER ID?>
        </tbody>
    </table><br>
        
        <?php  } // END OF CHECKING IF EMPTY
    }  // END OF FOREACH SUPPLIER  ?>
    <?php if($count == 0){ echo 'No Records Found.'; } ; ?>

</html>