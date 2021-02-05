<head>  
    <title>Travel Order - <?php echo $info->travel_order_no; ?> </title>
    <style type="text/css">
        body {
/*            font-family: 'Calibri',sans-serif;
            font-size: 12px;*/
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
    <br/>
    <table width="100%" cellpadding="8" cellspacing="5" class="table table-striped" style="font-size: 11pt;">
        <tr>
            <td valign="top" class="border" width="35%"><span class="default-color-tbl">Employee Name:</span> <?php echo $info->employee_name; ?></td>
            <td valign="top" width="65%" class="border">
                <span class="default-color-tbl">Official Designation:</span> <?php echo $info->official_designation; ?>
            </td>
        </tr>

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
</div>





















