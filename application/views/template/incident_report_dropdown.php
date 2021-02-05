<head>  
    <title>Incident Report - <?php echo $info->incident_report_no; ?> </title>
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
    <table width="100%" cellpadding="8" cellspacing="5" class="table table-striped" style="font-size: 11pt;">
        <tr>
            <td valign="top" width="35%" class="border" style="height: 100px; min-height: 100px;">
                <span class="default-color-tbl">Date &amp; Time</span> <br/><br/>
                <?php echo $info->incident_date_time; ?>
            </td>
            <td valign="top" rowspan="3" width="65%" class="border">
                <span class="default-color-tbl">Incident Details</span><br/><br/>
                <?php echo $info->incident_details; ?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="border" style="height: 100px; min-height: 100px;">
                <span class="default-color-tbl">Location</span> <br/><br/>
                <?php echo $info->location; ?>
            </td>
        </tr> 
        <tr>
            <td valign="top" class="border" style="height: 100px; min-height: 100px;">Is 
                <span class="default-color-tbl">Dealer Notified?</span> <br/><br/>
                <?php if($info->is_dealer_notified>0){ echo "YES"; }else{ echo "NO"; } ?>
            </td>
        </tr>          
    </table><br/>
    <table width="100%" cellpadding="8" cellspacing="5" class="table table-striped" style="font-size: 11pt;">
        <tr>
            <td valign="top" width="35%" class="border" style="height: 100px; min-height: 100px;">
                <span class="default-color-tbl">Incident Causes</span> <br/><br/>
                <?php echo $info->incident_causes; ?>
            </td>
            <td valign="top" width="65%" class="border">
                <span class="default-color-tbl">Follow up / Recommendations</span><br/><br/>
                <?php echo $info->follow_up; ?>
            </td>
        </tr>        
    </table>
</div>





















