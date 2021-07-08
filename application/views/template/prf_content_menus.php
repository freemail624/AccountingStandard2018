<br />


<div class="row">
    <div class="col-sm-12">
        <div style='border-bottom:1px solid gray;'></div>
    </div>
</div><br />

<div class="row" >
    <div class="col-lg-12">
        <div class="title-action" style="margin-left: 3%;">
            <a href="Templates/layout/prf/<?php echo $requests->purchase_request_form_id; ?>?type=preview" target="_blank" class="btn btn-default <?php echo ($requests->approval_id!=3?'disabled':''); ?>" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Print PRF </a>
            <a href="Templates/layout/prf/<?php echo $requests->purchase_request_form_id; ?>?type=pdf" class="btn btn-default <?php echo ($requests->approval_id!=3?'disabled':''); ?>" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-file-pdf-o"></i> Download as PDF </a>

        </div>
    </div>

</div>

<br />

