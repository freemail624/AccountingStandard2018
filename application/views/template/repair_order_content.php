<!DOCTYPE html>
<html>
<head>
	<title><?php echo $info->repair_order_no; ?></title>
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
        .gray{
        	background: lightgray;
        }
        .double-border-bottom{
        	border-bottom: 1px double black;
        }
        hr{
        	margin: 1;
        	padding: 0;
        }
        .top{
        	border-top: 1px solid lightgray;
        }
        .bottom{
        	border-bottom: 1px solid lightgray;
        }      
        .left{
        	border-left: 1px solid lightgray;
        }   
        .right{
        	border-right: 1px solid lightgray;
        }             
        .border{
        	border: 1px solid lightgray;
        }
        .black{
        	border-color: black;
        }
        .footer{
        	font-size: 6pt;
        }
		div {page-break-inside:avoid;}

    </style>
</head>
<body>
    <table width="100%">
        <tr class="">
        	<td width="25%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 90px; width: 130px;"> 
        	</td>
            <td width="45%" valign="top">
            	<strong style="font-size: 15pt;"><?php echo $company_info->company_name; ?></strong>
            	<br/><br/>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="30%" valign="top">
                <h3><b>REPAIR ORDER</b></h3><br/>
                <table width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td width="65%">CONTROL NO.</td>
                        <td width="35%"><?php echo $info->repair_order_no; ?></td>
                    </tr>
                    <tr>
                        <td width="65%">CUBE TOPPER NO.</td>
                        <td width="35%"></td>
                    </tr>                    
                </table>
            </td>
        </tr>
    </table>
    <br/>
    <table width="100%" border="1" cellspacing="5" cellpadding="5" style="font-size: 7pt;">
    	<tr>
    		<td valign="top" width="16%">
    			Customer No. <br/> 
    			<strong><?php echo $info->customer_no; ?></strong>
    		</td>
    		<td valign="top" colspan="4" rowspan="3" width="40%">
    			Customer Name and Address <br/>
    			<strong style="font-size: 10pt;">
    				<?php echo $info->customer_name; ?><br/>
    				<?php echo $info->address; ?>
    			</strong>
    		</td>
    		<td valign="top">
    			Plate No. <br/>
    			<strong><?php echo $info->crp_no; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Advisor <br/>
    			<strong><?php echo $info->advisor_fullname; ?></strong>
    		</td>
    		<td valign="top">
    			Doc. Date <br/>
    			<strong><?php echo $info->document_date; ?></strong>
    		</td>
    	</tr>
    	<tr>
    		<td valign="top">
    			Mode of Payment <br/>
    		</td>
    		<td valign="top">
    			Km Reading <br/>
    			<strong><?php echo number_format($info->km_reading,0); ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Next Svc Date <br/>
    			<strong><?php echo $info->next_svc_date; ?></strong>
    		</td>
    		<td valign="top">
    			Next Svc Km <br/>
    			<strong><?php echo number_format($info->next_svc_km,0); ?></strong>
    		</td>
    	</tr>
    	<tr>
    		<td valign="top">
    			Insurer <br/>
                <strong><?php echo $info->insurer_company; ?></strong>
    		</td>
    		<td valign="top">
    			Year/Make <br/>
    			<strong><?php echo $info->year_make_id; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Model <br/>
    			<strong><?php echo $info->model_name; ?></strong>
    		</td>
    		<td valign="top">
    			Color <br/>
    			<strong><?php echo $info->color_name; ?></strong>
    		</td>
    	</tr>    	
    	<tr>
    		<td valign="top">
    			LOA No. <br/>
                <strong><?php echo $info->loa_no; ?></strong>
    		</td>
    		<td valign="top">
    			Mobile No. <br/>
    			<strong><?php echo $info->mobile_no; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Tel No.(Home)<br/>
    			<strong><?php echo $info->tel_no_home; ?></strong>
    		</td>
    		<td valign="top">
    			Tel No.(Bus)<br/>
    			<strong><?php echo $info->tel_no_bus; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			VIN/Chassis No. <br/>
    			<strong><?php echo $info->chassis_no; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Engine No. <br/>
    			<strong><?php echo $info->engine_no; ?></strong>
    		</td>	
    	</tr>
    	<tr>
    		<td valign="top">
    			LOA Date <br/>
                <strong><?php echo date_format(date_create($info->loa_date),"m/d/Y"); ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Representative Name <br/>
    			<strong><?php echo $info->representative_name; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Contact No(s) <br/>
    			<strong><?php echo $info->representative_no; ?></strong>
    		</td>
    		<td valign="top">
    			Selling Dealer <br/>
    			<strong><?php echo $info->selling_dealer; ?></strong>
    		</td>    
    		<td valign="top" colspan="2">
    			Delivery Date <br/>
    			<strong><?php echo $info->delivery_date; ?></strong>
    		</td>  
    		<td valign="top">
    			G.V.D. <br/>
    		</td>  		
    	</tr>
    	<tr>
    		<td valign="top">
    			Policy No <br/>
                <strong><?php echo $info->policy_no; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Time Received <br/>
    			<strong><?php echo $info->time_received; ?></strong>
    		</td>
    		<td valign="top" colspan="2">
    			Date/Time Promised <br/>
    			<strong><?php echo $info->date_time_promised; ?></strong>
    		</td>
    		<td valign="top">
    			WTY Date <br/>
    		</td>    
    		<td valign="top" colspan="2">
    			Ext. Wty Date <br/>
    		</td>  
    		<td valign="top">
    			Wty Exp Date <br/> 
    		</td>  		
    	</tr>    	
    </table>

    <?php if(count($histories) > 0){ ?>

    <table width="100%" cellspacing="2" cellpadding="2" style="font-size: 7pt;border: 1px solid black;">
    	<tr>
    		<td valign="top" colspan="4">
    			<strong>HISTORY</strong>
    		</td>
    	</tr>
    	<tr>
    		<td valign="top" align="center"><strong>DATE</strong></td>
    		<td valign="top" align="center"><strong>REPAIR ORDER NO.</strong></td>
    		<td valign="top" align="center"><strong>MILEAGE</strong></td>
    		<td valign="top" align="center"><strong>SERVICE ADVISOR</strong></td>
    	</tr>
    	<?php foreach($histories as $history){ ?>
    		<tr>
    			<td valign="top" align="center"><?php echo $history->document_date; ?></td>
    			<td valign="top" align="center"><?php echo $history->repair_order_no; ?></td>
    			<td valign="top" align="center"><?php echo number_format($history->km_reading,0); ?></td>
    			<td valign="top" align="center"><?php echo $history->advisor_fullname; ?></td>
    		</tr>
    	<?php }?>
    	<tr>
    		<td colspan="4">&nbsp;</td>
    	</tr>
    </table>

    <?php } ?>

    <table width="100%" cellspacing="5" cellpadding="5" border="1" style="font-size: 7pt;">
    	<tr>
    		<td valign="top">
    			<strong>ADVISOR'S RECOMMENDATION</strong><br/>
    			***<?php echo $info->advisor_remarks; ?>***<br/><br/>
    		</td>    		
    	</tr>
    </table>
    <br/>
	<table width="100%" cellspacing="4" cellpadding="4" style="font-size: 7pt;padding: 10px;">
		<thead>
	    	<tr>
	    		<th valign="top" width="5%"><strong>Line</strong></th>
	    		<th valign="top" width="10%"><strong>Product</strong></th>
	    		<th valign="top" width="30%"><strong>Description</strong></th>
	    		<th valign="top" width="15%" align="right"><strong>Quantity</strong></th>
	    		<th valign="top" width="15%" align="right"><strong>Unit Price</strong></th>
	    		<th valign="top" width="10%" align="right"><strong>Discount</strong></th>
	    		<th valign="top" width="15%" align="right"><strong>Amount</strong></th>
	    	</tr>
		</thead>
    	<?php foreach($tbl_count as $tbl){
    	?>
    		<tr>
    			<td valign="top" colspan="2" class="gray">C</td>
    			<td valign="top" colspan="5" class="gray">
    				<strong><?php echo $tbl->sdesc; ?></strong>
    			</td>    
    		</tr>
            <?php if($tbl->instruction != ""){ ?>
                <tr>
                    <td valign="top" colspan="2"></td>
                    <td valign="top" colspan="5">
                        <?php echo $tbl->instruction; ?>
                    </td>    
                </tr>
            <?php } ?>
    		<?php 

    			$sub_total=0;
        			foreach($items as $item){
        			if($item->tbl_no == $tbl->tbl_no){
        			$sub_total+=$item->order_line_total_after_global;
    		?>
    			<tr>
    				<td valign="top"><?php echo $item->unit_code; ?></td>
    				<td valign="top"><?php echo $item->product_code; ?></td>
    				<td valign="top"><?php echo $item->product_desc; ?></td>
    				<td valign="top" align="right"><?php echo $item->order_qty + 0;?></td>
    				<td valign="top" align="right"><?php echo number_format($item->order_price,2) ?></td>
    				<td valign="top" align="right"><?php echo number_format($item->order_line_total_discount,2) ?></td>
    				<td valign="top" align="right"><?php echo number_format($item->order_line_total_after_global,2) ?></td>
    			</tr>
    		<?php }}?>
    		<tr>
    			<td valign="top" colspan="6" align="right">Sub-Total</td>
    			<td valign="top" align="right" class=""><hr><?php echo number_format($sub_total,2); ?> <hr><hr></td>
    		</tr>
    	<?php }?>
    </table>
    <div>
	    <table width="100%" cellpadding="1" cellspacing="1" style="font-size: 7pt;">
	    	<tr>
	    		<td  valign="top" rowspan="5" width="70%" style="font-size: 5.5pt;">
	    			
	    		<strong>Customer's Acknowledgement:</strong> <br/><br/>

	    		I/We hereby authorize the above repair jobs to be carried along with the use of necessary parts and materials and pay the corresponding amount upon completion. <br/><br/>

	    		I/We hereby bind myself to pay interest at 3% per month on all overdue accounts and in the event, that the same is endorsed to an attorney for collection, to pay interest additional 25% of the amount due but in no case, be less that ten thousand pesos (P10,000.00) as attorney's fee and litigation cost. <br/><br/>

	    		I/We also bind myself to the additional terms and conditions stated at the back of this document.


	    		</td>
	    	</tr>
	    	<tr>
	    		<td width="30%" valign="top">
	    			<table width="100%">
	    				<?php  
	    					$grand_total=0;
	    					$i=0;

	    					foreach($categories as $category){ 
	    						$grand_total+=$category->total_amount;
	    					?>
					    	<tr>
					    		<td valign="top" width="38%" class="border" style="padding-left: 5px; padding-right: 5px;">
					    			<strong>
					    				<?php echo $category->category_desc; ?>
					    			</strong>
					    		</td>
					    		<td valign="top" class="top bottom" style="padding-left: 5px; padding-right: 5px;">
					    			<strong>
					    				<?php  if($i == 0){echo 'Php';} ?>
					    			</strong>
					    		</td>
					    		<td valign="top" align="right" class="top bottom right" style="padding-left: 5px; padding-right: 5px;">
					    			<strong><?php echo number_format($category->total_amount,2); ?></strong>
					    		</td>
					    	</tr>
	    				<?php $i++; } ?>
				    	<tr>
				    		<td valign="top" class="border" style="padding-left: 5px; padding-right: 5px;"><strong>Total</strong></td>
				    		<td valign="top" class="top bottom" style="padding-left: 5px; padding-right: 5px;"><strong>Php</strong></td>
				    		<td align="right" valign="top" class="top bottom right" style="padding-left: 5px; padding-right: 5px;">
				    			<strong><?php echo number_format($grand_total,2); ?></strong>
				    		</td>
				    	</tr>
	    			</table>
	    		</td>
	    	</tr>
	    </table>
	    <table width="100%" cellpadding="3" cellspacing="3" style="font-size: 7pt;">
	    	<tr>
	    		<td width="30%" valign="top" class="top left black footer">Prepared/Date:</td>
	    		<td width="20%" valign="top" class="top left black footer">Checked/Date:</td>
	    		<td width="20%" valign="top" class="top left black footer">Approved/Date:</td>
	    		<td width="30%" valign="top" class="top left right black footer">Acknowledged &amp; Conformed/Date:</td>
	    	</tr>
	    	<tr>
	    		<td valign="top" class="left bottom black" align="center">
	    			<strong><?php echo $info->advisor_fullname; ?></strong>
	    		</td>
	    		<td valign="top" class="left bottom black" align="center">
	    		</td>
	    		<td valign="top" class="left bottom black" align="center">
	    		</td>
	    		<td valign="top" class="left bottom right black" align="center">
	    			<strong><?php echo $info->customer_name; ?></strong>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td width="30%" valign="middle" class="bottom left black footer" align="center">
	    			SA/Insurance Coordinator
	    		</td>
	    		<td width="20%" valign="middle" class="bottom left black footer" align="center" style="padding: 0;">
	    			Signature over printed name <br/> 
	    			Warranty Processor (for waranty)
	    		</td>
	    		<td width="20%" valign="middle" class="bottom left black footer" align="center">
	    			Service Head
	    		</td>
	    		<td width="30%" valign="middle" class="bottom left right black footer" align="center">
	    			Customer's signature over printed name
	    		</td>
	    	</tr>
	    </table>
	    <table width="100%" style="margin-top: 3px;">
	    	<tr>
	    		<td valign="top" colspan="2" style="padding:0;font-size: 5pt;">
	    			<strong>Reminders to customer: Please present this Repair Order when claiming your vehicle.</strong>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td valign="top" style="padding:0;font-size: 5pt;">
	    			<strong>NOT VALID FOR CLAIMING INPUT TAX</strong>
	    		</td>
	    		<td valign="top" align="right" style="padding:0;font-size: 5pt;">
	    			<?php echo date('m/d/Y h:i A') ?>
	    		</td>
	    	</tr>
	    </table>
    </div>
</body>
</html>