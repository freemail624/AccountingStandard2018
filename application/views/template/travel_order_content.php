<head>  
    <title>Travel Order - <?php echo $info->travel_order_no; ?> </title>
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
        <tr class="">
            <td width="50%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 300px;"> 
                <br/><br/>

                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="50%" style="text-align: right;" valign="top">
                <h1><b>TRAVEL ORDER</b></h1><br/>
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td width="35%" class="border default-color" align="center">
                            <b>ORDER NO</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $info->travel_order_no; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><br/></td>
                    </tr>
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td width="35%" class="border default-color" align="center">
                            <b>DATE</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center">
                            <?php echo $info->travel_date;?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br/><br/>
    <table width="100%" style="font-size: 10pt;">
        <tr>
            <td width="15%">Employee Name: </td>
            <td width="30%" class="bottom"><?php echo $info->employee_name; ?></td>
            <td width="25%" align="right">Official Designation: </td>
            <td width="25%" class="bottom"><?php echo $info->official_designation; ?></td>
        </tr>
    </table>
    <br/><br/>

    <table width="100%" style="font-size: 10pt;">
        <tr>
            <td class="default-color"><h1><center>TRAVEL DETAILS</center></h1></td>
        </tr>
    </table>
    <br><br>
    <table width="100%" cellpadding="8" cellspacing="5" class="table table-striped" style="font-size: 11pt;">
        <tr>
            <td valign="top" width="35%" class="border default-color-tbl">Date of Travel</td>
            <td valign="top" width="65%" class="border">
                <?php echo $info->travel_date; ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="border default-color-tbl">Destination</td>
            <td valign="top" class="border">
                <?php echo $info->destination; ?>
            </td>
        </tr> 
        <tr>
            <td valign="top" class="border default-color-tbl">Person to Visit</td>
            <td valign="top" class="border">
                <?php echo $info->person_to_visit; ?>
            </td>
        </tr>                
        <tr>
            <td valign="top" class="border default-color-tbl">Designation</td>
            <td valign="top" class="border">
                <?php echo $info->designation; ?>
            </td>
        </tr>                        
        <tr>
            <td valign="top" class="border default-color-tbl" style="height: 100px; min-height: 100px;">Purpose of Travel</td>
            <td valign="top" class="border">
                <?php echo $info->purpose_of_travel; ?>
            </td>
        </tr>                
    </table>
    <br/>

    <br/><br/>

    <?php include 'travel_report_footer.php'; ?>
</div>





















