<head>
  <title>Service Invoice</title>
  <style type="text/css">
    body {
      font-family: 'Calibri', sans-serif;
      font-size: 12px;
    }

    .border {
      border: 1px solid black !important;
    }

    .default-color {
      color: #2d419b;
      font-weight: bold;
      font-size: 9pt;
    }

    .top {
      border-top: 1px solid black;
    }

    .bottom {
      border-bottom: 1px solid black;
    }

    .left {
      border-left: 1px solid black;
    }

    .right {
      border-right: 1px solid black;
    }

    table {
      border-collapse: collapse;
    }
  </style>
</head>

<body>
  <div>
    <table width="100%">
      <tr class="">
        <td width="50%" valign="top">
          <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 300px;">
          <br /><br />

          <p><?php echo $company_info->company_address; ?></p>
          <p><?php echo $company_info->company_address_2; ?></p>
          <span>Email : <?php echo $company_info->email_address; ?></span>
          <p>Tel and Fax no.: <?php echo $company_info->landline . ' &nbsp;' . $company_info->mobile_no; ?></p>
        </td>
        <td width="50%" style="text-align: right;" valign="top">
          <h1><b>SERVICE INVOICE</b></h1><br />
          <table width="100%" class="table table-striped" style="border-collapse: collapse;">
            <tr>
              <td width="60%">&nbsp;</td>
              <td width="40%" class="border default-color" align="center">
                <b>INVOICE NO</b>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $service->service_invoice_no; ?></td>
            </tr>
            <tr>
              <td colspan="2"><br /></td>
            </tr>
            <tr>
              <td width="60%">&nbsp;</td>
              <td width="40%" class="border default-color" align="center">
                <b>DATE</b>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="border" style="padding: 5px 0px 5px 0px;" align="center">
                <?php echo date('M d,Y', strtotime($service->date_invoice)); ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br><br>
    <table width="100%" cellpadding="5" class="table table-striped">
      <!-- <tr>
        <td colspan="2" align="right" style="padding: 5px;">Please supply and deliver in accordance with the terms and conditions set below:</td>
      </tr> -->
      <tr>
        <td width="100%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
          <span class="default-color">BRANCH</span><br /><br />

          <span style="font-size: 12pt;"><b><?php echo $service->customer_name; ?></b></span><br />
          <span>Cel No.:</span> <?php echo $service->contact_no; ?><br />
          <span>Email:</span> <?php echo $service->email_address; ?><br />
          <span>Attention: <b><?php echo $service->contact_person; ?></b></span>
        </td>
        <!-- <td width="50%" class="border" valign="top" style="height: 100px;min-height: 100px;padding: 10px;">
          <span class="default-color">DELIVER TO</span><br /><br />

          <span><?php echo $service->address; ?></span>
        </td> -->
      </tr>
    </table>
    <br />
    <!-- <table width="100%" cellpadding="5" class="table table-striped">
      <tr>
        <td valign="top" width="50%" class="default-color top left right">DELIVERY DATE</td>
        <td valign="top" width="50%" class="default-color top left right">SO NUMBER
        </td>
      </tr>
      <tr>
        <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
          <span><?php echo ($service->date_due != null || $service->date_due != '0000-00-00' ? date('M d,Y', strtotime($service->date_due)) : ""); ?></span>
        </td>
        <td valign="top" class="left right bottom" style="height: 30px;min-height: 30px;" align="center">
          <span><?php echo $service->so_no; ?></span>
        </td>
      </tr>
    </table> -->
    <br />
    <table width="100%" cellpadding="6" class="table table-striped">
      <tr>
        <td width="15%" class="default-color border" valign="top">QTY</td>
        <td width="35%" class="default-color border" valign="top">DESCRIPTION</td>
        <td width="25%" class="default-color border" valign="top" align="right">UNIT PRICE</td>
        <td width="25%" class="default-color border" valign="top" align="right">TOTAL</td>
      </tr>
      <?php
      $total_tax_amount = 0;
      $gross_total = 0;
      $total_discount = 0;
      foreach ($item_info as $item) {
        $total_discount += $item->service_line_total_discount;
        $total_tax_amount += $item->service_tax_amount;
        $gross_total += $item->service_line_total; ?>
        <tr>
          <td class="left right"><?php echo number_format($item->service_qty, 2); ?></td>
          <td class="left right"><?php echo $item->service_desc; ?></td>
          <td class="left right" align="right"><?php echo number_format($item->service_price, 2); ?></td>
          <td class="left right" align="right"><?php echo number_format($item->service_line_total, 2); ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="2" class="top" rowspan="4" valign="top">
          <!-- <table width="100%" style="font-size: 8pt;">
            <tr>
              <td valign="top">1.</td>
              <td valign="top">
                The sales order no. marked above must appear in all invoices and/or delivery receipts of the branch.
              </td>
            </tr>
            <tr>
              <td valign="top">2.</td>
              <td valign="top">
                The original sales invoice and original delivery receipt should be submitted to the accounting parent to process the payment.
              </td>
            </tr>
          </table> -->

        </td>
        <td class="border" align="right">SUB TOTAL</td>
        <td class="border" align="right">
          <?php echo number_format($gross_total, 2); ?>
        </td>
      </tr>
      <tr>
        <td class="border" align="right">DISCOUNT</td>
        <td class="border" align="right">
          <?php echo number_format($total_discount + $service->total_overall_discount_amount, 2); ?>
        </td>
      </tr>
      <tr>
        <td class="border" align="right">TAX AMOUNT</td>
        <td class="border" align="right">
          <?php echo number_format($total_tax_amount, 2); ?>
        </td>
      </tr>
      <tr>
        <td class="border" align="right"><b>TOTAL AMOUNT DUE</b></td>
        <td class="border" align="right">
          <?php echo number_format($service->total_amount_after_discount, 2); ?>
        </td>
      </tr>
    </table>

    <br /><br /><br /><br />

    <?php include 'po_report_footer.php'; ?>
  </div>