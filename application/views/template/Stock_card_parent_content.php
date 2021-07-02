<!DOCTYPE html>
<html>
<head>
    <title>Product History</title>
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
    </style>
</head>
<body>

    <table width="100%">
        <tr class="">
            <td width="50%" valign="top">
                <img src="<?php echo $company_info->logo_path; ?>" style="height: 70px; width: 200px;"> 
                <br/><br/>

                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="50%" valign="top">
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                  <tr>
                    <td width="100%" align="right">
                      <h1>
                          <b>
                            STOCK CARD / BIN CARD
                          </b>
                      </h1><br/>
                    </td>
                  </tr>
                  <tr>
                    <td align="right" style="font-size: 14pt;">
                      <b class="default-color">PRODUCT DESCRIPTION</b> : <br/>
                      <?php echo $info[0]->product_desc; ?>
                    </td> 
                  </tr>
                </table>
            </td>
        </tr>
    </table>
    <br/><br/>

    <table style="width: 100%" class="table table-striped">
        <tr>
            <td style="width: 15%;" class="class-title">Product Code</td>
            <td style="width: 35%;" id="product_code"><?php echo $info[0]->product_code?></td>
            <td  style="width: 15%;" class="class-title">Purchase Cost</td>
            <td  style="width: 35%;" id="purchase_cost"><?php echo number_format($info[0]->purchase_cost,2); ?></td>
        </tr>
        <tr>
            <td style="width: 15%;" class="class-title">Product Description</td>
            <td style="width: 35%;" id="product_desc"><?php echo $info[0]->product_desc?></td>

            <td  style="width: 15%;" class="class-title">Suggested Retail Price</td>
            <td  style="width: 35%;" id="sale_price"><?php echo number_format($info[0]->sale_price,2)  ?></td>
        </tr>
    </table>
<br/>
       <table width="100%"  style="border-collapse: collapse;">
           <thead>
                <tr class="">
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;"><b>Date</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;"><b>Document No</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;"><b>Particular</b></td>
                    <td width="12%" style="border: 1px solid lightgrey;padding: 5px;"><b>Receipt No</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>IN</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>OUT</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;"><b>Location</b></td>
                    <td width="10%" style="border: 1px solid lightgrey;padding: 5px;"><b>Remarks</b></td>
                </tr>
           </thead>
           <tbody>
               <tr>
                     <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($as_of_date)); ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;">System</td>
                     <td style="border: 1px solid lightgrey;padding: 5px;"></td>
                     <td></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($balance_as_of->total_qty_balance,2).' '.$info[0]->bulk_unit_name; ?></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: left;"></td>
                     <td style="border: 1px solid lightgrey;padding: 5px;text-align: left;"><strong>System Generated Balance</strong></td>
                 </tr>

                <?php foreach($products_parent as $product){ ?>
               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->ref_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->receipt_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_in_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_out_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_balance,2).' '.$info[0]->parent_unit_name; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: left;"><?php echo $product->department_name ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: left;"><?php echo $product->remarks; ?></td>
               </tr>
                <?php } ?>
           </tbody>
       </table>

</body>
</html>
















