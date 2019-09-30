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
    table.table_journal_entries_review_jo td {
        border: 0px !important;
    }
    tr {
        border: none!important;
    }
/*    tr:nth-child(even){
        background: #414141 !important;
        border: none!important;
    }
*/
/*
    tr:hover {
        transition: .4s;
        background: transparent !important;
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
    <table class="table_journal_entries_review_jo"  width="100%" style="font-family: tahoma;">
        <tbody>
        <tr>
            <td>
                <br />
                <div class="tab-container tab-top tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_jo_<?php echo $job_order_info->jo_billing_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#purchase_review_<?php echo $job_order_info->jo_billing_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_jo_<?php echo $job_order_info->jo_billing_id; ?>" data-parent-id="<?php echo $job_order_info->jo_billing_id; ?>" style="min-height: 300px;">
                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="ti ti-close"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $job_order_info->supplier_name; ?></b>.<br />
                                    <i class="ti ti-close"></i>&nbsp; Please make sure that <b><?php echo $job_order_info->supplier_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                            <input type="hidden" name="ref_no" value="<?php echo $job_order_info->jo_billing_no; ?>">
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Account Payable Journal</strong></span></h4>
                                <hr />
                                <div style="width: 90%;">
                                    <input type="hidden" name="jo_billing_id" value="<?php echo $job_order_info->jo_billing_id; ?>">
                                    <label class="col-lg-2"> <b class="required">*</b> Txn # :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Date :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $job_order_info->date_invoice; ?>">
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Supplier : </label>
                                    <div class="col-lg-10">
                                        <select name="supplier_id" class="cbo_supplier_list" data-error-msg="Input Tax Account is required." required>
                                            <?php foreach($suppliers as $supplier){ ?>
                                                <option value="<?php echo $supplier->supplier_id; ?>" <?php echo ($job_order_info->supplier_id===$supplier->supplier_id?'selected':''); ?>><?php echo $supplier->supplier_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Branch : </label>
                                    <div class="col-lg-10">
                                        <select name="department_id" class="cbo_department_list" data-error-msg="" required>
                                            <?php foreach($departments as $department){ ?>
                                                <option value="<?php echo $department->department_id; ?>" <?php echo ($job_order_info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <br /><br /><br />
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_review_jo_<?php echo $job_order_info->jo_billing_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 15%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th style="width: 15%;">Department</th>
                                        <th style="width: 10%">Action</th>
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
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr />
                                <label class="col-lg-2"> Remarks :</label><br />
                                <div class="col-lg-12">
                                    <textarea name="remarks" class="form-control" style="width: 100%;">Job Service <?php echo $job_order_info->jo_billing_no ?> for <?php echo $job_order_info->project_name; ?><?php echo $job_order_info->remarks; ?></textarea>
                                </div>
                                <br /><hr />
                            </form>
                            <br /><br /><hr />
                            <div class="row">
                                <div class="col-lg-12">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary <?php if(!$valid_particular){ echo "disabled"; }?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="purchase_review_<?php echo $job_order_info->jo_billing_id; ?>" >
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Job Service Invoice</strong></span></h4>
                                <div style="margin-left: 2%;margin-right: 20px;">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <i class="fa fa-code"></i>  Job Service No : <?php echo $job_order_info->jo_billing_no; ?><br>
                                        <i class="fa fa-users"></i> Supplier : <?php echo $job_order_info->supplier_name?><br>
                                        <i class="fa fa-users"></i> Project : <?php echo $job_order_info->project_name?><br>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <i class="fa fa-calendar-o"></i> Date : <?php echo  date_format(new DateTime($job_order_info->date_invoice ),"m/d/Y"); ?><br>
                                        <i class="fa fa-file-o"></i> Remarks : <?php echo $job_order_info->remarks; ?><br>
                                    </div>
                                    </div>
                                </div>
                                <br>



    <table width="100%"  style="font-family: tahoma;font-size: 11;" >
            <thead>

            <tr>
                <th width="10%" style="text-align: center;height: 30px;" class="left bottom">Item Code</th>
                <th width="30%" style="text-align: left;height: 30px;" class="bottom left">Item Description</th>
                <th width="15%" style="text-align: center;height: 30px;" class="bottom left">UM</th>
                <th width="10%" style="text-align: right;height: 30px;" class="left bottom">Item Qty</th>
                <th width="15%" style="text-align: right;height: 30px;" class="bottom left">Unit Cost</th>
                <th width="15%" style="text-align: right;height: 30px;" class="bottom right left">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($billing_items as $item){ ?>
                <tr>
                    <td  class="left" style="text-align: center;padding: 6px;"><?php echo $item->job_code; ?></td>
                    <td  class="left" style="text-align: left;padding: 6px;"><?php echo $item->job_desc; ?></td>

                    <td  class="left" style="text-align: center;padding: 6px;"><?php echo $item->job_unit_name; ?></td>
                    <td  class="left" style="text-align: right;padding: 6px;"><?php echo $item->job_qty; ?></td>
                    <td  class="left" style="text-align: right;padding: 6px;"><?php echo number_format($item->job_price,2); ?></td>
                    <td class="left right" style="text-align: right;padding: 6px;"><?php echo number_format($item->job_line_total,2); ?></td>
                </tr>
            <?php } ?>
            <tr style="font-weight: bold">
                <td colspan="5" class="text-right"> Gross Total</td>
                <td class="text-right"><?php echo number_format($job_order_info->total_amount,2); ?></td>
            </tr>
            <tr style="font-weight: bold">
                <td colspan="5" class="text-right"> Discount</td>
                <td class="text-right"><?php echo number_format($job_order_info->total_overall_discount_amount,2); ?></td>
            </tr>
            <tr style="font-weight: bold">
                <td colspan="5" class="text-right"> Net Total</td>
                <td class="text-right"><?php echo number_format($job_order_info->total_amount_after_discount,2); ?></td>
            </tr>
            </tbody>

                                    <br /><br />
                                </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</center>
