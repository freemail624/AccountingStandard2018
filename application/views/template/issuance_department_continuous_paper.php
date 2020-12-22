<style type="text/css">
    span, table{
    font-size: 12pt;
    font-family: Courier New!important;
    font-weight: 100!important;
    /*color: #696969!important;*/
    color: black!important;
}

@page {
  size: 24.13cm 27.94cm!important;
  /*margin: 0.5in 1in 0.5in 1in!important;*/
  scale: default!important;
}

.border-left{
    border-left: 1px solid black!important;
}
.border-right{
    border-right: 1px solid black!important;
}  
.border-bottom{
    border-bottom: 1px solid black!important;
}   
.border-top{
    border-top: 1px solid black!important; 
}     
</style>

<table width="100%" cellspacing="5" cellspacing="0">
    <tr style="text-align: center;">
        <td width="60%"  class="bottom" >
            <h1 class="report-header" style="margin-bottom: 0;font-weight: 100!important;"><?php echo $company_info->company_name; ?></h1>
            <span><?php echo $company_info->company_address; ?></span><br>
            <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
            <span><?php echo $company_info->email_address; ?></span><br>

        </td>
    </tr>
</table>

<table width="100%" cellspacing="5" cellpadding="0">
    <tr>
        <td width="50%">FROM DEPARTMENT : <?php echo $issuance_info->from_department_name; ?></td>
        <td width="50%" align="right">TRANSFER# : <?php echo $issuance_info->trn_no; ?></td>
    </tr>
    <tr>
        <td>TRANSFER TO : <?php echo $issuance_info->to_department_name; ?></td>
        <td align="right">DATE : <?php echo date_format(new DateTime($issuance_info->date_issued),"m/d/Y"); ?></td>
    </tr>
</table>
<br /> <br />
<table width="100%" style="border-collapse: collapse;" cellspacing="5" cellpadding="5">
    <tr>
        <td width="10%" class="border-right border-bottom" align="center">QTY</td>
        <td width="10%" class="border-right border-bottom" align="center">UM</td>
        <td width="40%" class="border-right border-bottom" align="center">DESCRIPTION</td>
        <td width="20%" class="border-right border-bottom" align="right">UNIT PRICE</td>
        <td width="20%" class="border-bottom" align="right">AMOUNT</td>
    </tr>
    <?php foreach($issue_items as $item){ ?>
        <tr>
            <td valign="top" class="border-right"><center><?php echo number_format($item->issue_qty,2); ?></center></td>
            <td valign="top" class="border-right"><?php echo $item->unit_code; ?></td>
            <td valign="top" class="border-right"><?php echo $item->product_desc; ?></td>
            <td valign="top" class="border-right" align="right"><?php echo number_format($item->issue_price-$item->issue_discount,2); ?></td>
            <!-- <td valign="top" align="right"><?php echo number_format($item->inv_discount,2); ?></td> -->
            <td valign="top" align="right"><?php echo number_format($item->issue_line_total_price,2); ?></td>
        </tr>
    <?php }?>
</table>
<br/><br/>
<table width="100%" style="border-collapse: collapse;" cellspacing="5" cellpadding="5">
    <tr>
        <td width="10%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
    </tr>
    <tr>
        <td width="80%" colspan="4" align="right">TOTAL AMOUNT DUE :</td>
        <td width="20%" align="right" style="font-size: 15pt!important;"><?php echo number_format($issuance_info->total_after_tax,2); ?></td>
    </tr>
    <tr>
        <td width="20%" colspan="2">RECEIVED BY : </td>
        <td width="60%" colspan="2" align="right" style="font-size: 9pt!important;">ENCODED BY : </td>
        <td width="20%" style="font-size: 9pt!important;"><?php echo $issuance_info->encoded_by; ?></td>
    </tr>
    <tr>
        <td width="60%" colspan="3"></td>
        <td width="20%" align="right" style="font-size: 9pt!important;">CHECKED BY : </td>
        <td width="20%"></td>
    </tr>               
</table>
<table width="100%" style="border-collapse: collapse;" cellspacing="5" cellpadding="5">
    <tr>
        <td width="40%">&nbsp;</td>
        <td width="60%"></td>
    </tr>
    <tr>
        <td class="border-top" align="left">SIGNATURE OVER PRINTED NAME</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="height: 20px;"></td>
    </tr>
    <tr>
        <td colspan="2">NOTE : <?php echo $issuance_info->remarks; ?></td>
    </tr>        
</table>

<script type="text/javascript">
window.print();
setTimeout(function(){
    window.close();
},600);
</script>
