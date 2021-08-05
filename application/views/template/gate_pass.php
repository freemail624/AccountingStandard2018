<!DOCTYPE html>
<html>
<head>
	<title>Gate Pass</title>
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

        .tbl-gate_pass, .tbl-gate_pass td {
          border-collapse: collapse;
          border: 1px solid black;
        }

        .tbl-gate_pass td {
          padding-left: 5px;
        }
    </style>
</head>
<body>
	<table width="100%">
    <tr>
      <td style="object-fit: cover; width: 50%;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 60px; width: : 350px; text-align: left;"></td>
      <td style="text-align: right" valign="middle"><h2>NO. <?php echo $payment->gate_pass_no; ?> </h2></td>
    </tr>
  </table>
  <table class="tbl-gate_pass" width="100%" cellspacing="0">
    <tbody>
      <tr>
        <td style="width: 20%; height: 35px;">DATE</td>
        <td style="width: 35%;"><?php echo $payment->date_created; ?></td>
        <td style="width: 20%;">PLATE NUMBER</td>
        <td style="width: 25%;"></td>
      </tr>
      <tr>
        <td rowspan="2">NAME OF CLIENT</td>
        <td rowspan="2"></td>
        <td style="height: 35px">UNIT</td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 35px">REFERENCE NUMBER</td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 75px;">DESCRIPTION</td>
        <td colspan="2"></td>
        <td valign="bottom" style="text-align: center">APPROVED BY:</td>
      </tr>
    </tbody>
  </table>
</body>
</html>