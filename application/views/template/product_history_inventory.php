

<div style="padding:1%;" >

   <center>
       <table width="100%"  style="border-collapse: collapse;">
           <thead>
                <tr class="">
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Date</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Reference</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Type</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Description</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Package</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>In</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Out</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Bulk Balance</b></td>
                </tr>

           </thead>
           <tbody>

               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($as_of_date . "-1 days")); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;">Balance</td>
                   <td style="border: 1px solid lightgrey;padding: 5px;">System</td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><strong>System Generated Balance</strong></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($balance_as_of->total_qty_bulk,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;">
                    <?php 
                        echo number_format($balance_as_of->total_qty_bulk,2);
                     ?></td>
               </tr>


                <?php foreach($products_parent as $product){ ?>
               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->ref_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->type; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->identifier; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_in_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->parent_out_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($product->parent_balance,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;">
                    <?php 
                        echo number_format($product->parent_bulk_balance,2);
                     ?></td>
               </tr>
                <?php } ?>

           </tbody>
       </table>
       <br /><br />

   </center>


</div>

<style>
  tr {
      border: none!important;
  }

/*  tr:nth-child(even){
      background: #414141 !important;
      border: none!important;
  }

  tr:hover {
      transition: .4s;
      background: #414141 !important;
      color: white;
  }

  tr:hover .btn {
      border-color: #494949!important;
      border-radius: 0!important;
      -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
      -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
      box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
  }*/
</style>


















