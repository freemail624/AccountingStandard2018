<br />


<div class="row">
    <div class="col-sm-12">
        <div style='border-bottom:1px solid gray;'></div>
    </div>
</div><br />

<div class="row" >
    <div class="col-lg-12">
        <div class="title-action" style="margin-left: 3%;">
            <a href="Templates/layout/journal-cdj-voucher?id=<?php echo $voucher_info->cv_id; ?>&type=preview" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Print </a>
            <?php if($voucher_info->payment_method_id == 2){?>
				<a href="Templates/layout/journal-cdj-voucher?id=<?php echo $voucher_info->cv_id; ?>&type=check_voucher" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Check Voucher</a>
                <a href="Check_summary/transaction/export-voucher?id=<?php echo $voucher_info->cv_id; ?>" target="_blank" class="btn btn-success" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-file-excel-o"></i> Export Voucher</a>                
            <?php }?>
        </div>
    </div>

</div>

<br />