<html>
<head>
    <title>Operating Expense Report</title>
    <style>
        @page  {
            size: A4;

        }

        body{
            font-family: 'Times New Roman', serif;

        }
        @media print {
      @page { margin: 0; }
      body { margin: 1.0cm; }
  }
    </style>
</head>
<body>
<!--     <table width="100%">
    <tr>
        <td width="20%" valign="top" style="object-fit: cover;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 90px; text-align: left;"></td>
        <td width="80%" class="align-center">
            <span style="font-size: 12pt;font-weight: bolder;"><strong><?php echo $company_info->company_name; ?></strong></span><br />
            <span style="font-size: 8pt;"><?php echo $company_info->company_address; ?></span><br />
            <span style="font-size: 8pt;"><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br /><br />
            <span style="font-size: 12pt;font-weight: bolder;"><strong>Income Statement - <?php echo $departments; ?></strong></h3></span>
            <span style="font-size: 10pt;"><i>Period <?php echo $start; ?> to <?php echo $end; ?></i></span><br /><br /><br />
        </td>
    </tr>
</table> -->
    
    <table width="100%" style="border-collapse: collapse;">
                
<!--         <tr>
            <td width="20%">Departmental Expenses</td>
            <?php foreach($departments as $department){?>
                <td><?php echo $department->department_name; ?></td>
            <?php }?>
        </tr>
 -->
        <?php foreach($items as $item){ ?>
        <tr>
            <td><?php echo $item->account_title; ?></td>

            <?php foreach($departments as $department){?>
                <td><?php echo $item->department_name ?></td>
            <?php }?>

        </tr>
        <?php } ?>
    </table>
    
</body>
<!-- <script>
    window.print();
</script> -->
</html>







