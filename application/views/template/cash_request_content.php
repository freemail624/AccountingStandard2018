<head>  
    <title>Cash Request - <?php echo $info->cash_request_no; ?> </title>
    <style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .border{
            border: 1px solid black!important; 
        }

        .default-color{
            color:#2d419b;
            font-weight: bold; 
            font-size: 9pt;
        }
       .default-color-tbl{
            color:#2d419b;
            font-weight: bold; 
            font-size: 11pt;
        }
        .top{
            border-top: 1px solid black;
        }
        .bottom{
            border-bottom: 1px solid black;
        }
        .left{
            border-left: 1px solid black;
        }
        .right{
            border-right: 1px solid black;
        }
        table{
            border-collapse: collapse;
        }
    </style>
</head>
<body> 
<div>

    <table width="100%">
        <tr>
            <td>
                <center>
                    <img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 350px;">
                </center> 
            </td>
        </tr>
        <tr>
            <td>
                <br/>
                <h1><center>CASH REQUEST</center></h1>
            </td>
        </tr>
        <tr>
            <td>
                <h2><center>No. <u><?php echo $info->cash_request_no; ?></u></center></h2>
            </td>
        </tr>
    </table>
    <br/>

    <table width="100%" style="font-size: 12pt;">
        <tr>
            <td width="20%">Requesting Unit: </td>
            <td width="35%" class="bottom"><?php echo $info->requesting_unit; ?></td>
            <td width="10%" align="right">Date: </td>
            <td width="35%" class="bottom"><?php echo $info->request_date; ?></td>
        </tr>
    </table>

    <br><br>
    <table width="100%" cellpadding="8" cellspacing="5" class="table table-striped" style="font-size: 11pt;">
        <tr>
            <td valign="top" width="35%" class="border default-color-tbl">Amount Requested</td>
            <td valign="top" width="65%" class="border">
                <?php echo number_format($info->requested_amount,2); ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="border default-color-tbl">Description of Need</td>
            <td valign="top" class="border" style="height: 150px; min-height: 150px;">
                <?php echo $info->request_description; ?>
            </td>
        </tr> 
        <tr>
            <td valign="top" class="border default-color-tbl">Amount Approved</td>
            <td valign="top" class="border"></td>
        </tr>                
        <tr>
            <td valign="top" class="border default-color-tbl">Date Needed</td>
            <td valign="top" class="border">
                <?php echo $info->date_needed; ?>
            </td>
        </tr>                        
        <tr>
            <td valign="top" class="border default-color-tbl">Account Number</td>
            <td valign="top" class="border">
                <?php echo $info->account_number; ?>
            </td>
        </tr>                
    </table>
    <br/>

    <br/><br/><br/><br/>

    <?php include 'po_report_footer.php'; ?>

    <br/>
    <br/>
    <br/>

    <table width="100%">
        <tr>
            <td class="default-color">
                <center>
                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->company_address_2; ?></p>
                    <span>Email : <?php echo $company_info->email_address; ?></span>
                    <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
                </center>
            </td>
        </tr>
    </table>
</div>





















