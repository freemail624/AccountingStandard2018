<!DOCTYPE html>
<html>
<head>
	<title>Purchase Request (Form)</title>
	<style type="text/css">
		body {
			font-family: 'Calibiri',sans-serif;
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
        .left{
            border-left: 1px solid black;
        }
        .right{
            border-right: 1px solid black;
        }
        table{
            border-collapse: collapse;
        }
        .top{
            border-top: 1px solid black;
        }
	</style>
</head>
<body>
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
                <h1><b>PURCHASE REQUEST (FORM)</b></h1><br/>
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td width="35%" class="border default-color" align="center">
                            <b>REQUEST NO</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $requests->prf_no; ?></td>
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
                            <?php echo date('M d,Y',strtotime($requests->date_created));?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	<br><br>

    <table width="100%" cellpadding="8" class="table table-striped" style="border: 1px solid black;">
        <tr>
            <td width="15%" class="default-color border" valign="top">QTY</td>
            <td width="85%" class="default-color border" valign="top">DESCRIPTION</td>
        </tr>
        <?php foreach($prf_items as $item){ ?>
            <tr>
                <td class="left right"><?php echo number_format($item->prf_qty,2); ?></td>
                <td class="left right"><?php echo $item->product_desc; ?></td>
            </tr>
        <?php }?>
    </table>

    <br/><br/><br/><br/>

    <?php include 'po_report_footer.php'; ?>

</body>
</html>
