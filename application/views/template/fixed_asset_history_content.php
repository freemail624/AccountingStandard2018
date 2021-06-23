<head>
    <title>Movement of Asset</title>
</head>

<body>
    <style type="text/css" media="print">
        @page {
            size: portrait;
        }
    </style>

    <style>
        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .data {
            /*      border-bottom: 1px solid #404040;*/
        }

        .align-center {
            text-align: center;
        }

        .report-header {}

        hr {
            /*       border-top: 3px solid #404040;*/
        }

        table thead tr th,
        table tbody tr td {
            padding: 5px;
        }

        .left {
            border-left: 1px solid gray;
        }

        .right {
            border-right: 1px solid gray;
        }

        .bottom {
            border-bottom: 1px solid gray;
        }

        .top {
            border-top: 1px solid gray;
        }

        .fifteen {
            width: 15%;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
    <?php if ($_GET['type'] == 'print') { ?>
        <table width="100%" cellspacing="5" cellspacing="0" class="child">
            <tr>
                <td width="10%" class="bottom"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
                <td width="90%" class="bottom">
                    <h1 class="report-header" style="margin-bottom: 0;font-size:18px;"><strong><?php echo $company_info->company_name; ?></strong></h1>
                    <span><?php echo $company_info->company_address; ?></span><br>
                    <span><?php echo $company_info->landline . '/' . $company_info->mobile_no; ?></span><br>
                    <span><?php echo $company_info->email_address; ?></span><br>

                </td>

            </tr>
        </table>
    <?php   } ?>
    <div>
        <h4>Movement of Asset
            <hr>
        </h4>
        <center>
            <table cellspacing="0" cellpadding="3" width="100%" style="font-size: 9pt;" class="child">
                <tr>
                    <td style="width: 20%;"><strong>Asset Code:</strong></td>
                    <td style="width: 30%;"><?php echo $info->asset_code; ?></td>
                    <td style="width: 20%;"><strong>Life in Years:</strong></td>
                    <td style="width: 30%;"><?php echo $info->life_years; ?></td>
                </tr>
                <tr>
                    <td><strong>Asset Description:</strong></td>
                    <td><?php echo $info->asset_description; ?></td>
                    <td><strong>Salvage Value:</strong></td>
                    <td><?php echo $info->salvage_value; ?></td>
                </tr>
                <tr>
                    <td><strong>Acquisition Cost:</strong></td>
                    <td><?php echo $info->acquisition_cost; ?></td>
                    <td><strong>Parent:</strong></td>
                    <td><?php echo $info->department_name; ?></td>
                </tr>
                <tr>
                    <td><strong>Serial Number:</strong></td>
                    <td><?php echo $info->serial_no; ?></td>
                    <td><strong>Category:</strong></td>
                    <td><?php echo $info->category_name; ?></td>
                </tr>
            </table> <br>
            <table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11" class="child">
                <thead>
                    <tr>
                        <th width="20%" class="bottom left top ">Reference No</th>
                        <th width="15%" class="bottom left top">Date</th>
                        <th width="15%" class="bottom left top">Present Location</th>
                        <th width="15%" class="bottom left top">Status</th>
                        <th width="35%" class="bottom left top right">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td class="left" style=""><?php echo $item->asset_no; ?></td>
                            <td class="left" style=""><?php echo $item->date; ?></td>
                            <td class="left" style=""><?php echo $item->location_name; ?></td>
                            <td class="left" style=""><?php echo $item->asset_property_status; ?></td>
                            <td class="left right" style=""><?php echo $item->remarks; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="" colspan="5" class="top"></td>
                    </tr>
            </table><br /><br />
        </center>
    </div>