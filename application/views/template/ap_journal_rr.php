<!DOCTYPE html>
<html>
<head>
	<title>Receiving Receipt</title>
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

        .border-all{
        	border: 1px solid black;
        }
        .border-top{
        	border-top: 1px solid black
        }
        .border-left{
        	border-left: 1px solid black;
        }

		hr {
			/*border-top: 3px solid #404040;*/
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
	<div style="width: 100%;">
	    <table width="100%">
	        <tr>
	            <td width="40%" align="right">
	               <img src="<?php echo $company_info->logo_path; ?>" style="height: 60px; width: 60px;display: inline-block;">
	            </td>
	            <td width="60%" style="padding-right: 100px;">
	                <h3 class="report-header">
	                <strong style=""><?php echo $company_info->company_name; ?></strong></h3>
<!-- 	                    <p><?php echo $company_info->company_address; ?></p>
	                    <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
	                    <span><?php echo $company_info->email_address; ?></span><br> -->
	            </td>
	        </tr>
	    </table>
	    <br/>  
	    <table width="100%">
	    	<tr>
	    		<td align="center">
	    			<h2>RECEIVING REPORT</h2>
	    		</td>
	    	</tr>
	    </table>
		
		<table width="100%">
			<tr>
				<td colspan="2"></td>
				<td>RR:</td>
				<td></td>
			</tr>
			<tr>
				<td width="15%"><strong>Name of Supplier</strong></td>
				<td width="50%" class="border-bottom">
					<?php echo $purchase_info->supplier_name; ?>
				</td>
				<td width="5%"><strong>Date</strong></td>
				<td width="20%" class="border-bottom">
					<?php echo $purchase_info->date_delivered; ?>
				</td>
			</tr>
		</table>
		<br/>

		<table width="100%" cellpadding="5" cellspacing="5" style="border: 1px solid black;border-collapse: collapse;">
			<tr>
				<td align="center" width="50%" class="border-all"><strong>ENTRY</strong></td>
				<td align="center" width="25%" class="border-all"><strong>DEBIT</strong></td>
				<td align="center" width="25%" class="border-all"><strong>CREDIT</strong></td>
			</tr>

			<?php if(count($entries) <= 0){ ?>

			<tr>
				<td colspan="3" style="height: 150px;min-height: 150px;"></td>
			</tr>

			<?php }else{?>

			<?php foreach($entries as $entry){ ?>
				<?php if($entry->dr_amount > 0){ ?>
					<tr>
						<td class="border-left" align="right" style="padding-right: 120px;">
							<?php echo $entry->account_title; ?>
						</td>
						<td class="border-left" align="right">
							<?php echo number_format($entry->dr_amount,2); ?>
						</td>
						<td class="border-left">&nbsp;</td>
					</tr>
				<?php } ?>

				<?php if($entry->cr_amount > 0){ ?>
					<tr>
						<td class="border-left" align="right">
							<?php echo $entry->account_title; ?>
						</td>
						<td class="border-left">&nbsp;</td>
						<td class="border-left" align="right">
							<?php echo number_format($entry->cr_amount,2); ?>
						</td>
					</tr>
				<?php } ?>
			<?php }?>

			<?php } ?>
			<?php if($purchase_info->remarks != null || ""){ ?>
				<tr>
						<td colspan="3" align="center">
							<?php echo $purchase_info->remarks; ?>
						</td>
				</tr>
			<?php }?>
			<tr>
				<td colspan="2" class="border-top">
					<strong>TOTAL AMOUNT</strong>
				</td>
				<td class="border-top" align="right">
					<?php echo number_format($purchase_info->total_after_discount,2) ?>
				</td>
			</tr>
		</table>

		<table width="100%" cellspacing="5">
			<tr>
				<td align="right" width="50%">Received by:</td>
				<td width="40%" class="border-bottom"></td>
				<td width="10%">&nbsp;</td>
			</tr>
		</table>
		<table width="100%" cellspacing="5">
			<tr>
				<td valign="bottom" width="34%">Prepared by:</td>
				<td valign="bottom" width="33%">Certified by:</td>
				<td valign="bottom" width="33%">Noted by:</td>
			</tr>
			<tr>
				<td class="border-bottom">&nbsp;</td>
				<td class="border-bottom">&nbsp;</td>
				<td class="border-bottom">&nbsp;</td>
			</tr>
		</table>
	</div>
</body>
</html>