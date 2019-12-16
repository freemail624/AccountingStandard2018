<style>
/*    .tab-container .nav.nav-tabs li a {
        background: #414141 !important;
        color: white !important;
    }
    .tab-container .nav.nav-tabs li a:hover {
        background: #414141 !important;
        color: white !important;
    }
    .tab-container .nav.nav-tabs li a:focus {
        background: #414141 !important;
        color: white !important;
    }
*/
    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
    }
/*    tr:nth-child(even){
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
    }
*/
</style>
<center>
<table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
<tbody>
<tr>
<td>
<br />
<div class="tab-container tab-top tab-default">
<ul class="nav nav-tabs">
    <li class="active"><a href="#journal_review_<?php echo $info->temp_journal_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
    <li class=""><a href="#purchase_review_<?php echo $info->temp_journal_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="journal_review_<?php echo $info->temp_journal_id; ?>" data-parent-id="<?php echo $info->temp_journal_id; ?>" style="min-height: 300px;">
    <?php if(!$valid_particular){ ?>
        <div class="alert alert-dismissable alert-danger">
            <i class="ti ti-close"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $info->customer_name; ?></b>.<br />
            <i class="ti ti-close"></i>&nbsp; Please make sure that <b><?php echo $info->customer_name; ?></b> is not deleted or cancelled to your masterfile record.
            <br /><br />
            <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
    <?php } ?>
    <form id="frm_journal_review" role="form" class="form-horizontal row-border">
    <span class="hidden"><input type="text" name="ref_no" value="<?php echo $info->ref_no; ?>"></span>
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Accounts Receivable Journal</strong></span></h4>
        <hr />
        <div style="width: 90%;">
            <input type="hidden" name="temp_journal_id" value="<?php echo $info->temp_journal_id; ?>">
            <label class="col-lg-2"> * Txn # :</label>
            <div class="col-lg-10">
                <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
            </div>
            <br /><br />
            <label class="col-lg-2"> * Date :</label>
            <div class="col-lg-10">
                <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $info->date_txn; ?>">
            </div>
            <br /><br />
            <label class="col-lg-2"> * Customer :</label>
            <div class="col-lg-10">
                <select name="customer_id" class="cbo_customer_list" data-error-msg="Customer is required." required>
                    <?php foreach($customers as $customer){ ?>
                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($info->customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <br /><br />
            <label class="col-lg-2"> * Department :</label>
            <div class="col-lg-10">
                <select name="department_id" class="cbo_department_list" data-error-msg="Branch is required." required>
                    <?php foreach($departments as $department){ ?>
                        <option value="<?php echo $department->department_id; ?>" <?php echo ($info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br /><br /><br />
        <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
        <hr />
        <table id="tbl_entries_for_review_billing_<?php echo $info->temp_journal_id; ?>" class="table table-striped" style="width: 100% !important;">
            <thead>
            <tr style="border-bottom:solid gray;">
                <th style="width: 30%;">Account</th>
                <th style="width: 15%;">Memo</th>
                <th style="width: 15%;text-align: right;">Dr</th>
                <th style="width: 15%;text-align: right;">Cr</th>
                <th style="width: 15%;">Department</th>
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
                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true">
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
                            <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option> 
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
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        <hr />
        <label class="col-lg-2"> Remarks :</label><br />
        <div class="col-lg-12">
            <textarea name="remarks" class="form-control" style="width: 100%;"></textarea>
        </div>
        <br /><hr />
    </form>
    <br /><br /><hr />
    <div class="row">
        <div class="col-lg-12">
            <button name="btn_finalize_billing_journal_review" class="btn btn-primary  <?php if(!$valid_particular){ echo "disabled"; }?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
        </div>
    </div>
</div>
<div class="tab-pane" id="purchase_review_<?php echo $info->temp_journal_id; ?>" >

</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</center>
<style>
    tr {
        border: none!important;
    }
