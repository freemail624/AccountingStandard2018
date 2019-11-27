<html>
<head>
    <title>Comparative Income Statement</title>
    <style>

        table.table{
            border-collapse: collapse;
            font-family: calibri;
            font-size: 12pt;
        }

        @page  {
            size: A4;

        }

        body{
            font-family: 'Times New Roman', serif;

        }

        .top{
            border-top: 1px solid black;
        }

        @media print {
      @page { margin: 0; }
      body { margin: 1.0cm; }
  }
    </style>
</head>
<body>
    <table width="100%">
    <tr>
        <td width="20%" valign="top" style="object-fit: cover;"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 90px; text-align: left;"></td>
        <td width="80%" class="align-center">
            <span style="font-size: 12pt;font-weight: bolder;"><strong><?php echo $company_info->company_name; ?></strong></span><br />
            <span style="font-size: 8pt;"><?php echo $company_info->company_address; ?></span><br />
            <span style="font-size: 8pt;"><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br /><br />
        </td>
    </tr>
</table>
<table width="100%">
    <td width="20%">
        <center>
            <span style="font-size: 12pt;font-family:calibri; font-weight: bolder;text-transform: uppercase;"><?php echo $departments; ?></span><br>
            <span style="font-size: 12pt;font-family:calibri; font-weight: bolder;text-transform: uppercase;">COMPARATIVE INCOME STATEMENT</span><br>
            <span style="font-size: 12pt;font-family:calibri; font-weight: bolder;text-transform: uppercase;"><strong>FOR THE PERIOD ENDED <?php echo date('F d, Y', strtotime($end)); ?> & <?php echo date('F d, Y', strtotime($end.' -1 year')); ?></strong></h3></span> <br /><br />
        </center>
    </td>
</table>
<?php 

    function format_display($balance){
        $balance=(float)$balance;
        if($balance<0){
            $balance=str_replace("-","",$balance);
            return "(".number_format($balance,2).")";
        }else{
            return number_format($balance,2);
        }
    }

    function format_display_percentage($balance){
        $balance=(float)$balance;
        if($balance<0){
            $balance=str_replace("-","",$balance);
            return "(".number_format($balance,2)."%)";
        }else{
            return number_format($balance,2).'%';
        }
    }    

?>

<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-11 col-lg-offset-1">
            <table width="100%" class="table" >
                <thead>
                    <tr>
                        <th width="25%"></th>
                        <th width="15%" style="text-align: right;"><?php echo $selected_year; ?></th>
                        <th width="15%" style="text-align: right;"><?php echo $previous_year; ?></th>
                        <th width="15%" style="text-align: right;">Increase / <br>(Decrease)</th>
                        <th width="10%" style="text-align: right;">%<br>Change</th>
                        <th width="20%">*Explanation of <br> Increase/(Decrease)</th>
                    </tr>
                </thead>                
                <tbody>
<!--                     <tr>
                        <td colspan="6"><b>Income</b></td>
                    </tr> -->
                <?php 

                    $total_income=0; 
                    $total_prev_income=0; 
                    $total_change_amount=0; 
                    $total_percentage_change=0; 

                    foreach($income_accounts as $income){ ?>
                    <tr>
                        <td width="25%"><?php echo $income->account_title; ?></td>
                        <td width="15%" align="right"><?php echo format_display($income->account_balance); ?></td>
                        <td width="15%" align="right"><?php echo format_display($income->prev_account_balance); ?></td>
                        <td width="15%" align="right"><?php echo format_display($income->change_amount); ?></td>
                        <td width="15%" align="right"><?php echo format_display_percentage($income->percentage_change); ?></td>
                        <td width="15%"></td>
                    </tr>
                    <?php 

                    $total_income+=$income->account_balance; 
                    $total_prev_income+=$income->prev_account_balance; 
                    $total_change_amount+=$income->change_amount; 
                    $total_percentage_change =  ($total_change_amount / $total_income) * 100;

                    } ?>
                    <tr>
                        <td width="25%"><b>Total Income</b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_income); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_prev_income); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_change_amount); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display_percentage($total_percentage_change); ?></b></td>
                        <td class="top" width="15%"></td>
                    </tr>
                    <tr>
                        <td colspan="6"><b>Expenses</b></td>
                    </tr>
                    <?php 

                    $total_expense=0; 
                    $total_prev_expense=0; 
                    $total_change_amount_expense=0; 
                    $total_percentage_change_expense=0; 
                    $total_net_percentage_change=0;

                    foreach($expense_accounts as $expense){ ?>
                        <tr>
                            <td width="25%"><?php echo $expense->account_title; ?></td>
                            <td width="15%" align="right"><?php echo format_display($expense->account_balance); ?></td>
                            <td width="15%" align="right"><?php echo format_display($expense->prev_account_balance); ?></td>
                            <td width="15%" align="right"><?php echo format_display($expense->change_amount) ?></td>
                            <td width="15%" align="right"><?php echo format_display_percentage($expense->percentage_change); ?></td>
                            <td width="15%"></td>
                        </tr>
                        <?php 

                        $total_expense+=$expense->account_balance; 
                        $total_prev_expense+=$expense->prev_account_balance; 
                        $total_change_amount_expense+=$expense->change_amount; 
                        $total_percentage_change_expense =  ($total_change_amount_expense / $total_expense) * 100;

                        $total_net_percentage_change = (($total_change_amount-$total_change_amount_expense) / ($total_income-$total_expense)) * 100;

                        } ?>
                    <tr>
                        <td width="25%"><b>Total Expense</b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_expense); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_prev_expense); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_change_amount_expense); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display_percentage($total_percentage_change_expense); ?></b></td>
                        <td class="top" width="15%"></td>
                    </tr>   
                    <tr>
                        
                        <td width="25%"><b>Net Income</b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_income-$total_expense); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_prev_income-$total_prev_expense); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display($total_change_amount-$total_change_amount_expense); ?></b></td>
                        <td class="top" width="15%" align="right"><b><?php echo format_display_percentage($total_net_percentage_change); ?></b></td>
                        <td class="top" width="15%"></td>
                    </tr>      
                    <tr>
                        <td colspan="6">
                            <br>
                            *Explanation of increase/(decrease) shall only be applied to those accounts that increase or decrease by &#8805; <b>P100,000.00 <u>and</u> is equivalent to 10%</b> of the change based on the prior period.
                        </td>
                    </tr>                               
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
<script>
    window.print();
</script>
</html>







