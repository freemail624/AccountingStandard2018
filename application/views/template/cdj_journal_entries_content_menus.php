<br />


<div class="row">
    <div class="col-sm-12">
        <div style='border-bottom:1px solid gray;'></div>
    </div>
</div><br />

<div class="row" >
    <div class="col-lg-12">
        <div class="title-action" style="margin-left: 3%;">
            <a href="Templates/layout/journal-cdj?id=<?php echo $journal_info->journal_id; ?>&type=preview" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Print </a>
            <?php if($journal_info->payment_method_id == 2){?>
				<a href="Templates/layout/journal-cdj?id=<?php echo $journal_info->journal_id; ?>&type=check_voucher" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Check Voucher</a>
            <?php }?>            
        </div>
    </div>

</div>

<br />