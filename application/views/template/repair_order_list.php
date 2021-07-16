<!DOCTYPE html>
<html>
<head>
	<title>Repair Order List</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
			font-size: 12px;
		}
		table, th, td { border-color: white; }
		tr { border: none !important; }

		.report-header {
			font-size: 22px;
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
      <td width="10%"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
      <td width="90%" class="align-center">
        <span class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
        <span><?php echo $company_info->company_address; ?></span><br>
        <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span>
      </td>
    </tr>
  </table><hr>
  <div style="margin: 0 15px">
    <h3><strong>REPAIR ORDER LIST ( <?php echo $date_from. ' - ' .$date_to; ?> )</strong></h3>
    <h4><strong>ADVISOR : <?php echo $advisor; ?></strong></h4>
    <h4><strong>STATUS : <?php echo $status; ?></strong></h4>
  </div>

  <table style="margin: 0 15px" width="100%" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="7">
        <span style="font-size: 14px;"><strong><?php echo $customer->customer_name; ?></strong></span>
      </td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="10%"><strong>Control #</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="12%"><strong>Document Date</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="12%"><strong>Customer No</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="18%"><strong>Customer</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="10%"><strong>Plate No</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="15%"><strong>Date Time Promised</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="10%"><strong>Advisor</strong></td>
      <td style="border-bottom: 1px solid black; text-transform: uppercase;" width="12%"><strong>Status</strong></td>
    </tr>
    <?php foreach($repair_orders as $ro) { ?>
      <tr>
        <td><?php echo $ro->repair_order_no; ?></td>
        <td><?php echo date('Y-m-d', strtotime($ro->document_date)); ?></td>
        <td><?php echo $ro->customer_no; ?></td>
        <td><?php echo $ro->customer_name; ?></td>
        <td><?php echo $ro->crp_no; ?></td>
        <td><?php echo $ro->date_time_promised; ?></td>
        <td><?php echo $ro->advisor_fullname; ?></td>
        <td><?php echo $ro->status; ?></td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>