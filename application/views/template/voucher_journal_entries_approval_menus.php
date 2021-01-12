<div class="row">
    <div class="col-sm-12">
        <div style='border-bottom:1px solid gray;'></div>
    </div>
</div><br />

<div class="row" >
    <div class="col-lg-12">
        <div class="title-action" style="margin-left: 3%;">
            <a href="Templates/layout/journal-cdj-voucher?id=<?php echo $voucher_info->cv_id; ?>&type=preview" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Print </a>
            <button name="mark_as_approved_voucher" type="button" class="btn btn-success" style="text-transform: none;"><i class="fa fa-check-circle"></i> <span class=""></span> Approve and Post to Accounting </button>

            <button name="mark_as_disapproved_voucher" type="button" class="btn btn-danger" style="text-transform: none;"><i class="fa fa-times-circle"></i> <span class=""></span> Disapprove</button>

            <button name="mark_as_cancelled_voucher" type="button" class="btn btn-danger" style="text-transform: none;"><i class="fa fa-times-circle"></i> <span class=""></span> Cancel </button>

            <button type="button" class="btn btn-success closing_title hidden" style="text-transform: none;"><i class="fa fa-check-circle"></i> Transaction Completed.</button>
            <p class="closing_title hidden">Voucher will close after a few seconds.</p>
        </div>
    </div>
</div>