<style>

    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
}
.align-right{
    text-align: right;
}
</style>
<center>
    <table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
        <tbody style="border: none!important;">
        <tr>
            <td>
                <br />
                <div class="tab-container tab-default" >
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $info->temp_journal_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class="hidden"><a href="#payment_review_<?php echo $info->temp_journal_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Payment</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $info->temp_journal_id; ?>" data-parent-id="<?php echo $info->temp_journal_id; ?>" style="min-height: 300px;">
                            <?php
                            $is_check_not_due=$info->payment_method_id==2 && $info->rem_day_for_due>0;
                            if($is_check_not_due){
                                ?>
                                <div class="alert alert-dismissable alert-danger" style="color:white!important;background-color: red!important; ">
                                    <i class="ti ti-close"></i>&nbsp; <strong>Ooopss!</strong> Looks like the check on this transaction is not yet <b>Due</b>. Please see details below. 
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>

                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $info->customer_name; ?></b>.<br />
                                    <i class="fa fa-exclamation-circle"></i>&nbsp; Please make sure that <b><?php echo $info->customer_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" class="frm_billing_payment_<?php echo $info->temp_journal_id; ?>" role="form" class="form-horizontal row-border">
                                <br />
                                <input type="hidden" name="temp_journal_id" value="<?php echo $info->temp_journal_id; ?>">
                                <input type="hidden" name="ref_no" value="<?php echo $info->ref_no;?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div style="border: 1px solid lightgrey;padding: 2%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <b class="required">*</b> Txn # :<br />
                                                    <input type="text" name="txn_no" class="form-control" value="TXN-YYYYMMDD-XXX" readonly>
                                                </div>
                                                <div class="col-lg-4 col-lg-offset-1">
                                                    OR # :<br />
                                                    <input type="text" name="or_no" id="or_no" class="form-control" value="<?php echo $info->reference_no; ?>" readonly>
                                                </div>
                                                <br />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <b class="required">*</b> Customer :<br />
                                                    <select name="customer_id" class="cbo_customer_list" required data-error-msg="Customer is required!">
                                                        <?php foreach($customers as $customer){ ?>
                                                            <option value="<?php echo $customer->customer_id; ?>" <?php echo ($info->customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-lg-offset-1">
                                                    <b class="required">*</b> Date :<br />
                                                    <div class="input-group">
                                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $info->payment_date; ?>" required data-error-msg="Date is required!">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div><br />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <b class="required">*</b> Branch :<br />
                                                    <select name="department_id" class="cbo_department_list" required data-error-msg="Branch is required!">
                                                        <?php foreach($departments as $department){ ?>
                                                            <option value="<?php echo $department->department_id; ?>" <?php echo ($info->link_department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div style="border: 1px solid lightgrey;padding: 4%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <b class="required">*</b> Method of Payment :<br />
                                                    <select name="payment_method" class="cbo_payment_method pay_type_<?php echo $info->temp_journal_id; ?>">
                                                        <?php foreach($methods as $method){ ?>
                                                            <option value="<?php echo $method->payment_method_id; ?>" <?php echo ($info->payment_method_id===$method->payment_method_id?'selected':''); ?>><?php echo $method->payment_method; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                            <div class="row for_check_billing_payment_<?php echo $info->temp_journal_id; ?> <?php if($info->payment_method_id != 2){ echo 'hidden'; } ?>">
                                                <div class="col-lg-6">
                                                    <b class="required">*</b> Check Date :<br />
                                                    <div class="input-group">
                                                        <input type="text" name="check_date" class="date-picker form-control check_date_<?php echo $info->temp_journal_id; ?>" value="<?php if($info->check_date != '00/00/0000'){ echo $info->check_date; } ?>" data-error-msg="Check date is required!">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <b class="required">*</b> Check # :<br />
                                                    <input type="text" name="check_no" class="form-control check_no_<?php echo $info->temp_journal_id; ?>" value="<?php echo $info->check_no ?>" data-error-msg="Check # is required!">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    Amount :<br />
                                                    <input type="text" name="amount" class="form-control numeric" data-error-msg="Amount is required" value="<?php echo $info->amount_paid; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_review_billing_<?php echo $info->temp_journal_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 15%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th style="width: 15%;text-align: left;">Department</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $dr_total=0.00; $cr_total=0.00;
                                    foreach($entries as $entry){
                                        ?>
                                        <tr>
                                            <td>
                                                <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                                                    <?php foreach($accounts as $account){ ?>
                                                        <option value='<?php echo $account->account_id; ?>' <?php echo ($entry->account_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="memo[]" class="form-control"  value="<?php echo $entry->memo; ?>"></td>
                                            <td><input type="text" name="dr_amount[]" class="form-control numeric" value="<?php echo number_format($entry->dr_amount,2); ?>"></td>
                                            <td><input type="text" name="cr_amount[]" class="form-control numeric"  value="<?php echo number_format($entry->cr_amount,2);?>"></td>
                                            <td><select  name="department_id_line[]" class="dept show-tick form-control selectpicker" data-live-search="true" > 
                                                <option value="0">[ None ]</option> 
                                                <?php foreach($departments as $department){ ?> 
                                                    <option value='<?php echo $department->department_id; ?>' <?php echo ($info->link_department_id==$department->department_id?'selected':''); ?> ><?php echo $department->department_name; ?></option> 
                                                <?php } ?> 
                                            </select></td> 
                                            <td>
                                                <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                        $dr_total+=$entry->dr_amount;
                                        $cr_total+=$entry->cr_amount;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong><?php echo number_format($dr_total,2); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($cr_total,2); ?></strong></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr />
                                <label class="col-lg-2"> Remarks :</label><br />
                                <div class="col-lg-12">
                                    <textarea name="remarks" class="form-control" style="width: 100%;"><?php echo $info->remarks; ?></textarea>
                                </div>
                                <br /><hr />
                            </form>
                            <br /><br /><hr />
                            <div class="row">
                                <div class="col-lg-12">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary "><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="payment_review_<?php echo $info->temp_journal_id; ?>" >
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</center>