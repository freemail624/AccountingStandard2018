<!DOCTYPE html>
<html>
<head>
	<title>Product List Report</title>
	<style>
		body {
			font-family: 'Segoe UI',sans-serif;
		}
		table, th, td { border-color: white; }
		tr { border-bottom: none !important; }

		.report-header {
			font-size: 22px;
		}
        .right-align{
            text-align: right;
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
<!--             <td width="10%" style="object-fit: cover;"><img src="<?php //echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 90px; text-align: left;"></td> -->
            <td width="100%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3>
            <strong>PRODUCT LIST REPORT</strong>
            <span style="font-weight: normal; float: right;">Category : <?php echo $customer; ?></span>
        </h3>
        <table width="100%">
            <tr>
                <td></td>
            </tr>
        </table>
    </div>

    			
        <?php foreach($categories as $category){?>
            <table width="100%" cellpadding="3" cellspacing="0" border="1" style="font-size: 13px;">
                <thead>
                    <tr>
                        <td colspan="2" width="80%"><strong>CATEGORY : <?php echo $category->category_name; ?></strong></td>
                        <td width="20%" align="right"><strong>Sales Price</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item) {
                        if($category->category_id == $item->category_id){
                    ?>
                    <tr>
                         <td width="60%"><?php echo $item->product_desc; ?></td>
                         <td width="20%"><?php echo $item->category_name; ?></td>
                         <td width="20%" class="right-align"><?php echo number_format($item->sale_price,2);  ?></td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
            <br/><br/>

        <?php }?>

</body>
</html>