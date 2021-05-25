<html>
<head>
    <title>Inventory Report</title>
    <style>
        body{
            font-family: tahoma;font-size: 11;
        }

        table{

            font-size: 11;
            font-family: tahoma;
        }

        table thead tr td{
            height: 25px;
            background-color: lightgreen;
            font-weight: bold;
            font-size: 12;

        }


        table tfoot tr td{
            background-color: lightgreen;
            font-weight: 400;
        }

        td{
 
            padding-left: 5px;
            padding-right: 3px;
            height: 20px;
        }


    </style>

    <!-- <script>
        $(document).ready(function(){
            window.print();
        });

        window.onload = function () {
    window.print();
}
    </script> -->

    <script type="text/javascript">
        (function(){
            window.print();
        })();
    </script>




</head>

<body>

<div style="">
    <table width="100%" border="0">
        <tr>
            <td width="10%"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>

    <h3 style="margin-bottom: 0px;">Warehouse Inventory Report - <?php echo $department; ?>
        </h3>
    <i>As of <?php echo $date; ?></i>



    <br /><br />
    <table width="100%" >
        <thead>
            <tr>
                <td valign="top" width="10%">PLU</td>
                <td valign="top" width="30%">Description</td>
                <td valign="top" width="10%">Category</td>
                <td valign="top" width="5%">Unit</td>
                <td valign="top" width="10%" align="right">Quantity In</td>
                <td valign="top" width="10%" align="right">Quantity Out</td>
                <td valign="top" width="10%" align="right">Balance</td>
                <!-- <td valign="top" width="10%" align="right">Bulk Balance</td> -->
                <td valign="top" width="10%" align="right">SRP</td>
                <td valign="top" width="10%" align="right">Total</td>
            </tr>
        </thead>
        <tbody>
            <?php $gtotal = 0; foreach($products as $product){ ?>

            <tr>
                <td valign="top"><?php echo $product->product_code; ?></td>
                <td valign="top"><?php echo $product->product_desc; ?></td>
                <td valign="top"><?php echo $product->category_name; ?></td>
                <td valign="top"><?php echo $product->product_unit_name; ?></td>
                <td valign="top" align="right"><?php echo number_format($product->quantity_in,2); ?></td>
                <td valign="top" align="right"><?php echo number_format($product->quantity_out,2); ?></td>
                <td valign="top" align="right"><?php echo number_format($product->total_qty_balance,2); ?></td>
                <!-- <td valign="top" align="right"><?php echo number_format($product->total_qty_bulk,2); ?></td> -->
                <td valign="top" align="right"><?php echo number_format($product->sale_price,2); ?></td>
                <td valign="top" align="right"><?php echo number_format((round($product->sale_price,2) * round($product->total_qty_bulk,2)),2); ?></td>
            </tr>
            <?php 

            $gtotal += (round($product->sale_price,2) * round($product->total_qty_bulk,2)); } ?>

            <tr>
                <td colspan="8"><strong>Grand Total:</strong></td>
                <td align="right"><strong><?php echo number_format($gtotal,2); ?></strong></td>
            </tr>
            <?php if(count($products)==0){ ?>
                <tr>
                    <td colspan="9" style="height: 40px;"><center>No records found.</center></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9">&nbsp;</td>

            </tr>
        </tfoot>
    </table>



</div>




</body>
</html>