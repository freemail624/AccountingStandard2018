<style>
    table.table_dr_journal_entries_review td {
        border: 0px !important;
    }    
    tr {
        border: none!important;
    }    
</style>
<center>
    <table class="table_dr_journal_entries_review"  width="97%" style="font-family: tahoma;border: none!important">
        <tbody>
        <tr class="" >
            <td>
                <br />
                <div class="tab-container tab-default ">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $purchase_info->dr_invoice_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#purchase_review_<?php echo $purchase_info->dr_invoice_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
                        <li style="<?php if($fixed_asset_count <= 0){ echo 'display: none;'; }?>"><a href="#fixed_asset_<?php echo $purchase_info->dr_invoice_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Fixed Asset</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $purchase_info->dr_invoice_id; ?>" data-parent-id="<?php echo $purchase_info->dr_invoice_id; ?>" style="min-height: 300px;">

                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="ti ti-close"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $purchase_info->supplier_name; ?></b>.<br />
                                    <i class="ti ti-close"></i>&nbsp; Please make sure that <b><?php echo $purchase_info->supplier_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                                <br />
                                <input type="hidden" name="dr_invoice_id" value="<?php echo $purchase_info->dr_invoice_id; ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div style="border: 1px solid lightgrey;padding: 2%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    Txn # * :<br />
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name="txn_no" class="form-control" value="TXN-YYYYMMDD-XXX" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    Date * :<br />
                                                    <div class="input-group">
                                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $purchase_info->date_delivered; ?>">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5"> 
                                                    <div style="margin-top: 10px;">
                                                        <input type="checkbox" class="2307_apply" id="2307_apply_<?php echo $purchase_info->dr_invoice_id; ?>" value="1">
                                                        &nbsp;<label for="2307_apply_<?php echo $purchase_info->dr_invoice_id; ?>">Apply 2307 Form</label>
                                                    </div>
                                                </div><br />
                                                <br />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    Supplier * :<br />
                                                    <select name="supplier_id" class="cbo_customer_list">
                                                        <?php foreach($suppliers as $supplier){ ?>
                                                            <option value="<?php echo $supplier->supplier_id; ?>" <?php echo ($purchase_info->supplier_id===$supplier->supplier_id?'selected':''); ?>><?php echo $supplier->supplier_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-5"> 
                                                    ATC :
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-code"></i>
                                                        </span>
                                                        <input type="text" name="2307_atc" class="2307_atc form-control" data-error-msg="ATC is required." style="width: 100%;">
                                                    </div>
                                                </div><br />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    Branch * :<br />
                                                    <select name="department_id" class="cbo_department_list">
                                                        <?php foreach($departments as $department){ ?>
                                                            <option value="<?php echo $department->department_id; ?>" <?php echo ($purchase_info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-5">
                                                    Remarks :<br />
                                                    <textarea class="2307_remarks form-control" name="2307_remarks" data-error-msg="Remarks is required." rows="5" style="width: 90%;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div style="border: 1px solid lightgrey;padding: 4%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b class="required"> * </b> <label>Reference type :</label><br />
                                                    <select class="cbo_customer_list" name="ref_type" data-error-msg="Reference type is required." required>
                                                        <option value="CV">CV</option>
                                                        <option value="JV">JV</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                     <label>Reference # (AUTO):</label><br />
                                                    <div class="input-group">
                                                        <input type="text" maxlength="15" class="form-control"  readonly placeholder="XXXXXXXX">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    Method of Payment * :<br />
                                                    <select name="payment_method" class="cbo_payment_method">
                                                        <?php foreach($methods as $method){ ?>
                                                            <option value="<?php echo $method->payment_method_id; ?>" <?php echo ($purchase_info->payment_method_id==$method->payment_method_id?'selected':''); ?>><?php echo $method->payment_method; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    OR # * :<br />
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-code"></i>
                                                        </span>
                                                        <input type="text" name="or_no" class="form-control" value="<?php echo $purchase_info->external_ref_no; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    Amount* :<br />
                                                    <input type="text" name="amount" class="numeric form-control" value="<?php echo number_format($purchase_info->total_after_discount,2); ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    Check Date :<br />
                                                    <div class="input-group">
                                                        <input type="text" name="check_date" class="date-picker form-control">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    Check # :<br />
                                                    <input type="text" name="check_no" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_delivery_review_<?php echo $purchase_info->dr_invoice_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 30%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th>Action</th>
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
                                            <td>
                                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
<!--                                                 <button type="button" class="btn btn-primary add_account"><i class="fa fa-plus" style="color: white;"></i></button>
                                                <button type="button" class="btn btn-red remove_account"><i class="fa fa-times" style="color: white;"></i></button>
 -->
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
                                    <textarea name="remarks" class="form-control" style="width: 100%;"><?php echo $purchase_info->remarks; ?></textarea>
                                </div>
                                <br /><hr />
                            </form>
                            <br /><br /><hr />
                            <div class="row">
                                <div class="col-lg-12">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary <?php echo (!$valid_particular?'disabled':''); ?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane" id="purchase_review_<?php echo $purchase_info->dr_invoice_id; ?>" >
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Purchase Invoice</strong></span></h4>
                                <hr />
                                <div style="margin-left: 2%;margin-right: 20px;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <i class="fa fa-code"></i> Invoice # : <?php echo $purchase_info->dr_invoice_no; ?><br />
                                            <i class="fa fa-caret-square-o-left"></i> External # : <?php echo $purchase_info->external_ref_no; ?><br />
                                            <i class="fa fa-bookmark"></i> PO # : <?php echo $purchase_info->po_no; ?><br /><br />
                                            <i class="fa fa-calendar"></i> Terms : <?php echo $purchase_info->term_description; ?><br />
                                            <i class="fa fa-calendar-o"></i> Delivery Date : <?php echo $purchase_info->date_delivered; ?><br />
                                            <i class="fa fa-file-o"></i> Remarks : <?php echo $purchase_info->remarks; ?><br />
                                        </div>
                                        <div class="col-lg-6">
                                            <i class="fa fa-users"></i> Supplier : <?php echo $purchase_info->supplier_name; ?><br />
                                            <i class="fa fa-globe"></i> Address : <?php echo $purchase_info->address; ?><br />
                                            <i class="fa fa-send"></i> Email : <?php echo $purchase_info->email_address; ?><br />
                                            <i class="fa fa-phone-square"></i> Telephone : <?php echo $purchase_info->contact_no; ?><br />
                                            <br />
                                            <i class="fa fa-user"></i> Posted by : <?php echo $purchase_info->posted_by; ?><br />
                                            <i class="fa fa-calendar"></i> Date : <?php echo $purchase_info->date_created; ?><br />
                                        </div>
                                    </div>
                                    <br /><br />
                                    <table class="table table-striped" style="width: 100% !important;">
                                        <thead>
                                            <tr style="border-bottom: solid gray;">
                                                <td style="width: 40%;"><strong>Item</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Qty</strong></td>
                                                <td style="width: 12%;"><strong>UM</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Price (RR)</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Price (PO)</strong></td>

                                                <td style="width: 12%;text-align: right;"><strong>Discount</strong></td>

                                                <td style="width: 12%;text-align: right;"><strong>Tax</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $dr_total_price=0.00;
                                                $dr_total_tax=0.00;
                                                foreach($items as $item){
                                                    ?>
                                            <tr style="<?php echo ($purchase_info->po_no != '' && $item->dr_price != $item->po_price ? 'color: #f44336; font-weight: bolder;' : ''); ?>">
                                                <td><?php echo $item->product_desc; ?></td>
                                                <td align="right"><?php echo number_format($item->dr_qty,2); ?></td>
                                                <td><?php echo $item->unit_name; ?></td>
                                                <td align="right"><?php echo number_format($item->dr_price,2); ?></td>
                                                <td align="right"><?php echo number_format($item->po_price,2); ?></td>
                                                <td align="right"><?php echo number_format($item->dr_discount,2); ?></td>
                                                <td align="right"><?php echo number_format($item->dr_tax_amount,2); ?></td>
                                                <td align="right"><?php echo number_format($item->dr_line_total_after_global,2); ?></td>
                                            </tr>
                                            <?php
                                                    $dr_total_price+=$item->dr_line_total_price;
                                                    $dr_total_tax+=$item->dr_tax_amount;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8"> </td>

                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Discount 1:</td>
                                                <td align="right"><?php echo number_format($purchase_info->total_discount,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Total Before Tax:</td>
                                                <td align="right"><?php echo number_format($purchase_info->total_before_tax,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Tax Amount:</td>
                                                <td align="right"><?php echo number_format($purchase_info->total_tax_amount,2); ?></td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Total After Tax:</td>
                                                <td align="right"><?php echo number_format($purchase_info->total_after_tax,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Discount 2: </td>
                                                <td align="right"><?php echo number_format($purchase_info->total_overall_discount_amount,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Shipping Cost: </td>
                                                <td align="right"><?php echo number_format($purchase_info->shipping_cost,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Custom Duties: </td>
                                                <td align="right"><?php echo number_format($purchase_info->custom_duties,2); ?></td>
                                            </tr>  
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right">Other Amount: </td>
                                                <td align="right"><?php echo number_format($purchase_info->other_amount,2); ?></td>
                                            </tr>                  
                                            <tr>
                                                <td></td>
                                                <td colspan="6" align="right"><strong>Total:</strong></td>
                                                <td align="right"><?php echo number_format($purchase_info->grand_total_amount,2); ?></td>
                                        </tfoot>
                                    </table>
                                    <br /><br />
                                </div>
                        </div>

                        <div class="tab-pane" id="fixed_asset_<?php echo $purchase_info->dr_invoice_id; ?>" >
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Fixed Asset</strong></span></h4>
                                <hr />
                                <div style="margin-left: 2%;margin-right: 20px;">
                                    <div class="row">
                                        <table class="tbl_items table-striped table" cellspacing="0" width="100%" id="tbl_items_<?php echo $purchase_info->dr_invoice_id; ?>">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Code</th>
                                                    <th>Item</th>
                                                    <th align="right" style="text-align: right;">Qty</th>
                                                    <th>UM</th>
                                                    <th align="right" style="text-align: right;">Price</th>
                                                    <th><center>Status</center></th>
                                                </tr> 
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</center>