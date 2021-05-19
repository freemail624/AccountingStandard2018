<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
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

		.align-center {
			text-align: center;
		}

		.report-header {
			font-weight: bolder;
		}
        .border-bottom{
            border-bottom: 1px solid black;
        }

		hr {
			/*border-top: 3px solid #404040;*/
		}

		tr {
            border: none!important;
        }
/*
        tr:nth-child(even){
            background: #414141 !important;
            border: none!important;
            color: white !important;
        }

        tr:nth-child(odd){
            background: #414141 !important;
            border: none!important;
            color: white !important;
        }*/

/*        tr:hover {
            transition: .4s;
            background: #414141 !important;
            color: white;
        }

        tr:hover .btn {
            border-color: #494949!important;
            border-radius: 0!important;
            -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        }
*/
        table{
            border:none!important;
        }
	</style>
</head>
<body>

<div style="width: 50%;">
    
    <table width="100%">
        <tr class="row_child_tbl_sales_order">
            <td width="20%" align="right">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 60px; width: 60px;">
            </td>
            <td width="80%" style="padding-right: 100px;">
                <center>
                    <h3 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h3>
                    <p><?php echo $company_info->company_address; ?></p>
                    <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
                    <span><?php echo $company_info->email_address; ?></span><br>
                </center>
            </td>
        </tr>
    </table>
    <br/>
    <table width="100%">
        <tr class="row_child_tbl_sales_order">
            <td width="100%" style="text-align: center;"><h3>PURCHASE ORDER</h3> </td>
        </tr>
    </table><br>
    <table width="100%"  cellspacing="-1">
        <tr>
            <td style="padding: 3px;" width="15%" valign="top"></td>
            <td style="padding: 3px;" width="50%" valign="top"></td>
            <td style="padding: 3px;" width="20%" valign="top"><strong>Date:</strong></td>
            <td style="padding: 3px;" width="20%" valign="top"><?php echo $purchase_info->date_invoice; ?></td>
        </tr>
        <tr>
            <td style="padding: 3px;" width="15%" valign="top"><strong>Supplier:</strong></td>
            <td style="padding: 3px;" width="50%" valign="top"><?php echo $purchase_info->supplier_name; ?></td>
            <td style="padding: 3px;" width="20%" valign="top"><strong>Contact #:</strong></td>
            <td style="padding: 3px;" width="20%" valign="top"><?php echo $purchase_info->contact_no; ?></td>
        </tr>
        <tr>
            <td style="padding: 3px;" width="15%" valign="top"><strong>Terms:</strong></td>
            <td style="padding: 3px;" width="50%" valign="top"><?php echo $purchase_info->terms; ?></td>
            <td style="padding: 3px;" width="20%" valign="top"><strong>Delivery Date:</strong></td>
            <td style="padding: 3px;" width="20%" valign="top"><?php echo $purchase_info->date_delivery; ?></td>
        </tr>
    </table>
    <table width="100%" cellpadding="10" cellspacing="-1" class="table table-striped" style="text-align: center;margin-top: 5px;">
        <thead>
            <tr>
                <th style="padding: 6px;border: 1px solid gray;"><strong>Qty</strong></th>
                <th style="padding: 6px;border: 1px solid gray;"><strong>Unit</strong></th>
                <th style="padding: 6px;border: 1px solid gray;"><strong>Items Description</strong></th>
                <th style="padding: 6px;border: 1px solid gray;"><strong>Amount</strong></th>   
            </tr>
        </thead>
        <?php foreach($po_items as $item){ ?>
            <tr>
                <td width="10%" style="border-left: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $item->po_qty * 1; ?></td>
                <td width="10%" style="border-left: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                <td width="55%" style="border-left: 1px solid gray;text-align: left;height: 10px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                <td width="15%" style="border-left: 1px solid gray;border-right: 1px solid gray;text-align: right;height: 10px;padding: 6px;"><?php echo number_format($item->po_line_total_after_global,2); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td  colspan="3"  style="padding: 6px;border-bottom: 1px solid gray;border-left: 1px solid gray;border-top: 1px solid gray;height: 30px;" align="left"><strong>Total:</strong></td>
            <td style="padding: 6px;border-bottom: 1px solid gray;height: 30px;border-right: 1px solid gray;border-top: 1px solid gray;" align="right"><strong><?php echo number_format($purchase_info->total_after_discount,2); ?></strong></td>
        </tr>
    </table><br>

    <table width="100%">
        <tr>
            <td align="center">
                <?php echo $purchase_info->remarks; ?>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td style="padding: 3px;" width="20%"><strong>Prepared By:</strong></td>
            <td style="padding: 3px;" width="30%" class="border-bottom">&nbsp;</td>
            <td style="padding: 3px;" width="20%"><strong>Approved By:</strong></td>
            <td style="padding: 3px;" width="30%" class="border-bottom">&nbsp;</td>
        </tr>
    </table><br>
</div>
    
</body>
</html>
