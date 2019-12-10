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

            if ($balance == 0){
                return number_format(100,2)."%";
            }else{
                return number_format($balance,2)."%";
            }

        }

    }
?>


<html>
<head>
    <title>Balance Sheet</title>
    <style>
        @page  {
            size: A4;

        }

        body{
            font-family: 'Times New Roman', serif;

        }

    table.tbl_balance_sheet{
        font-family: calibri;
        border-collapse: collapse;
    }

    .top{
        border-top: 1px solid black;
    }
    .double-bottom{
        border-bottom: 3px double black; 
    }
  @media print {
  @page { margin: 0; }
  body { margin: 1.0cm; }

    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="20%" valign="top"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 100px; width: 100px; text-align: left;"></td>
            <td width="80%" class="align-center">
                <span style="font-size: 12pt;font-weight: bolder;"><strong><?php echo $company_info->company_name; ?></strong></span><br />
                <span style="font-size: 8pt;"><?php echo $company_info->company_address; ?></span><br />
                <span style="font-size: 8pt;"><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br /><br />
            </td>
        </tr>
    </table>
    <table width="100%" class="tbl_balance_sheet">
        <td width="20%">
            <center>
                <span style="font-size: 12pt;font-family:calibri; font-weight: bolder;text-transform: uppercase;"><?php echo $dep_info->department_name; ?></span><br>
                <span style="font-size: 12pt;font-family:calibri; font-weight: bolder;text-transform: uppercase;">COMPARATIVE STATEMENT OF FINANCIAL POSITION</span><br>
                <span style="font-size: 12pt;font-family:calibri; font-weight: bolder;text-transform: uppercase;"><strong>AS OF <?php echo date('F d, Y', strtotime($as_of_date)); ?> & <?php echo $prev_year; ?></strong></h3></span> <br /><br />
            </center>
        </td>
    </table>
    <table width="100%" class="tbl_balance_sheet">
        <tr>
            <td colspan="6"><center><b>ASSETS</b></center></td>
        </tr>
        <tr>
            <th width="30%"></th>
            <th width="10%" style="text-align: right;" valign="bottom"><?php echo $curr_year; ?></th>
            <th width="10%" style="text-align: right;" valign="bottom"><?php echo $prev_year; ?></th>
            <th width="10%" style="text-align: right;" valign="bottom">Increase/<br/>(Decrease)</th>
            <th width="10%" style="text-align: right;" valign="bottom">% Change</th>
            <th width="20%" valign="bottom">Explanation of <br/> Increase/(Decrease)</th>
        </tr>
                    <?php 

                        $total_curr_assets=0;
                        $total_prev_assets=0; 
                        $total_assets_change_amount=0;
                        $total_assets_percentage_change=0;

                        foreach($acc_classes as $class){ ?>
                        <?php if($class->account_type_id==1){ ?>
                            <tr>
                                <td>
                                     <span>
                                        <b><?php echo $class->account_class; ?>:</b>
                                    </span>
                                </td>
                            </tr>

                            <?php 

                                $total_curr_balance=0;
                                $total_prev_balance=0; 
                                $total_change_amount=0;
                                $total_percentage_change=0;

                                foreach($acc_titles as $account){ ?>
                                <?php if($class->account_class_id==$account->account_class_id){?>
                                    <tr>
                                        <td>
                                             <span>
                                                <?php echo $account->account_title; ?>
                                            </span>
                                        </td>
                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->current_balance); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->previous_balance); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->change_amount); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display_percentage($account->percentage_change); ?></span>
                                        </td>

                                        <td></td>

                                    </tr>
                                    <?php   

                                            $total_curr_balance+=$account->current_balance;
                                            $total_prev_balance+=$account->previous_balance;
                                            $total_change_amount=$total_curr_balance-$total_prev_balance;

                                            if($total_prev_balance == 0){
                                                $total_percentage_change=100;
                                            }else{
                                                $total_percentage_change=(($total_curr_balance-$total_prev_balance)/$total_prev_balance) * 100;
                                            }

                                            $total_curr_assets=$total_curr_balance;
                                            $total_prev_assets=$total_prev_balance; 
                                            $total_assets_change_amount=$total_change_amount;

                                            if($total_prev_assets == 0){
                                                $total_assets_percentage_change=100;
                                            }else{
                                                $total_assets_percentage_change=(($total_curr_assets-$total_prev_assets)/$total_prev_assets)*100;
                                            }

                                            ?>
                                <?php } ?>
                            <?php } ?>                         

                            <tr>
                                <td><b>Total <?php echo $class->account_class; ?></b></td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_curr_balance); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_prev_balance); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_change_amount); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display_percentage($total_percentage_change); ?></b>
                                </td>
                                <td class="top" valign="bottom"></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td><b>TOTAL ASSETS</b></td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_curr_assets); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_prev_assets); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_assets_change_amount); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display_percentage($total_assets_percentage_change); ?></b>
                </td>
                <td class="double-bottom" valign="bottom"></td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>


        <tr>
            <td colspan="6"><center><b>LIABILITIES & SHAREHOLDER'S EQUITY</b></center></td>
        </tr>

                    <?php 
                        $total_curr_liabilities=0;
                        $total_prev_liabilities=0; 
                        $total_liabilities_change_amount=0;
                        $total_liabilities_percentage_change=0;

                        foreach($acc_classes as $class){ ?>
                        <?php if($class->account_type_id==2){ ?>
                            <tr>
                                <td>
                                     <span>
                                        <b><?php echo $class->account_class; ?>:</b>
                                    </span>
                                </td>
                            </tr>

                            <?php 

                                $total_curr_balance=0;
                                $total_prev_balance=0; 
                                $total_change_amount=0;
                                $total_percentage_change=0;

                                foreach($acc_titles as $account){ ?>
                                <?php if($class->account_class_id==$account->account_class_id){?>
                                    <tr>
                                        <td>
                                             <span>
                                                <?php echo $account->account_title; ?>
                                            </span>
                                        </td>
                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->current_balance); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->previous_balance); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->change_amount); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display_percentage($account->percentage_change); ?></span>
                                        </td>

                                        <td valign="bottom"></td>

                                    </tr>
                                    <?php   

                                            $total_curr_balance+=$account->current_balance;
                                            $total_prev_balance+=$account->previous_balance;
                                            $total_change_amount=$total_curr_balance-$total_prev_balance;

                                            if($total_prev_balance == 0){
                                                $total_percentage_change=100;
                                            }else{
                                                $total_percentage_change=(($total_curr_balance-$total_prev_balance)/$total_prev_balance) * 100;
                                            }

                                            $total_curr_liabilities=$total_curr_balance;
                                            $total_prev_liabilities=$total_prev_balance; 
                                            $total_liabilities_change_amount=$total_change_amount;

                                            if($total_prev_liabilities == 0){
                                                $total_liabilities_percentage_change = 100;
                                            }else{
                                                $total_liabilities_percentage_change=(($total_curr_liabilities-$total_prev_liabilities)/$total_prev_liabilities)*100;    
                                            }                                        

                                            ?>
                                <?php } ?>
                            <?php } ?>                         

                            <tr>
                                <td><b>Total <?php echo $class->account_class; ?></b></td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_curr_balance); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_prev_balance); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_change_amount); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display_percentage($total_percentage_change); ?></b>
                                </td>
                                <td class="top" valign="bottom"></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td><b>TOTAL LIABILITIES</b></td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_curr_liabilities); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_prev_liabilities); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_liabilities_change_amount); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display_percentage($total_liabilities_percentage_change); ?></b>
                </td>
                <td class="double-bottom" valign="bottom"></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

                    <?php 

                        $total_curr_equity=0;
                        $total_prev_equity=0; 
                        $total_equity_change_amount=0;
                        $total_equity_percentage_change=0;

                        foreach($acc_classes as $class){ ?>
                        <?php if($class->account_type_id==3){ ?>
                            <tr>
                                <td>
                                     <span>
                                        <b><?php echo $class->account_class; ?>:</b>
                                    </span>
                                </td>
                            </tr>

                            <?php 

                                $total_curr_balance=0;
                                $total_prev_balance=0; 
                                $total_change_amount=0;
                                $total_percentage_change=0;

                                foreach($acc_titles as $account){ ?>
                                <?php if($class->account_class_id==$account->account_class_id){?>
                                    <tr>
                                        <td>
                                             <span>
                                                <?php echo $account->account_title; ?>
                                            </span>
                                        </td>
                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->current_balance); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->previous_balance); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display($account->change_amount); ?></span>
                                        </td>

                                        <td align="right" valign="bottom">
                                             <span><?php echo format_display_percentage($account->percentage_change); ?></span>
                                        </td>

                                        <td></td>

                                    </tr>
                                    <?php   

                                            $total_curr_balance+=$account->current_balance;
                                            $total_prev_balance+=$account->previous_balance;
                                            $total_change_amount=$total_curr_balance-$total_prev_balance;

                                            if($total_prev_balance == 0){
                                                $total_percentage_change=100;
                                            }else{
                                                $total_percentage_change=(($total_curr_balance-$total_prev_balance)/$total_prev_balance) * 100;
                                            }

                                            $total_curr_equity=$total_curr_balance+$total_curr_liabilities;
                                            $total_prev_equity=$total_prev_balance+$total_prev_liabilities; 
                                            $total_equity_change_amount=$total_change_amount+$total_liabilities_change_amount;


                                            if($total_prev_equity == 0){
                                                $total_equity_percentage_change = 100;
                                            }else{
                                                $total_equity_percentage_change = (($total_curr_equity-$total_prev_equity)/$total_prev_equity)*100;
                                            }                                    

                                            ?>
                                <?php } ?>
                            <?php } ?>                         

                            <tr>
                                <td><b>Total <?php echo $class->account_class; ?></b></td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_curr_balance); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_prev_balance); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display($total_change_amount); ?></b>
                                </td>
                                <td align="right" class="top" valign="bottom">
                                   <b><?php echo format_display_percentage($total_percentage_change); ?></b>
                                </td>
                                <td class="top"></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td><b>TOTAL LIABILITIES AND <br>SHAREHOLDERS' EQUITY</b></td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_curr_equity); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_prev_equity); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display($total_equity_change_amount); ?></b>
                </td>
                <td align="right" class="double-bottom" valign="bottom">
                   <b><?php echo format_display_percentage($total_equity_percentage_change); ?></b>
                </td>
                <td class="double-bottom" valign="bottom"></td>
            </tr>

    </table>

</body>

<script>
    window.print();
</script>

</html>