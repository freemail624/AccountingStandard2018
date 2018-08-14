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
    <table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
        <tbody>
        <tr>
            <td>
                <br />
                <div class="tab-container tab-top tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $ap_info->purchase_integration_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#purchase_review_<?php echo $ap_info->purchase_integration_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $ap_info->purchase_integration_id; ?>" data-parent-id="<?php echo $ap_info->purchase_integration_id; ?>" style="min-height: 300px;">
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                            <input type="hidden" name="ref_no" value="<?php echo $ap_info->invoice_no; ?>">
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Account Payable Journal</strong></span></h4>
                                <hr />
                                <div style="width: 100%;">
                                    <input type="hidden" name="purchase_integration_id" value="<?php echo $ap_info->purchase_integration_id; ?>">
                                    <label class="col-lg-2"> <b class="required">*</b> Txn # :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Date :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $ap_info->date_invoice; ?>">
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Supplier : </label>
                                    <div class="col-lg-10">
                                        <select name="supplier_id" class="cbo_supplier_list" data-error-msg="Input Tax Account is required." required>
                                            <?php foreach($suppliers as $supplier){ ?>
                                                <option value="<?php echo $supplier->supplier_id; ?>" <?php echo ($supplier_id===$supplier->supplier_id?'selected':''); ?>><?php echo $supplier->supplier_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Department : </label>
                                    <div class="col-lg-10">
                                        <select name="department_id" class="cbo_department_list" data-error-msg="" required>
                                            <?php foreach($departments as $department){ ?>
                                                <option value="<?php echo $department->department_id; ?>" <?php echo ($department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2">  </label>
                                    <div class="col-lg-10">
                                        <i>Note: You can change the default Department in the General Configuration Settings</i>
                                    </div>                                        
                                </div>
                                <br /><br /><br />
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_review_<?php echo $ap_info->purchase_integration_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 15%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
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
                                    <textarea name="remarks" class="form-control" style="width: 100%;"><?php echo "(RR No :".$ap_info->invoice_no.")" ?> <?php echo ($ap_info->terms==null ||$ap_info->terms==0?" ": "Terms : ".$ap_info->terms) ?> <?php echo ($ap_info->external_ref_no==null ?" ": "External Reference No : ".$ap_info->external_ref_no) ?> <?php echo ($ap_info->remarks==null?" ":"Remarks: ".$ap_info->remarks) ?>  </textarea>
                                </div>
                                <br /><hr />
                            </form>
                            <br /><br /><hr />
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" name="btn_finalize_journal_review" class="btn btn-primary "><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="purchase_review_<?php echo $ap_info->purchase_integration_id; ?>" >
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <i class="fa fa-code"></i> Invoice # : <?php echo $ap_info->invoice_no; ?><br />
                                            <i class="fa fa-caret-square-o-left"></i> External # : <?php echo $ap_info->external_ref_no; ?><br />
                                            <i class="fa fa-calendar-o"></i> Delivery Date : <?php echo $ap_info->date_invoice; ?><br />
                                            <i class="fa fa-file-o"></i> Remarks : <?php echo $ap_info->remarks; ?><br />
                                        </div>
                                        <div class="col-lg-6">
                                            <i class="fa fa-users"></i> Supplier : <?php echo $ap_info->pos_supplier_name; ?><br />
                                            <i class="fa fa-file-o"></i> Terms : <?php echo $ap_info->terms; ?><br />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <i class="fa fa-money"></i> Total Amount: <b><?php echo number_format($ap_info->total_amount,2); ?></b><br />
                                            <i class="fa fa-money"></i> Total Tax Amount: <b><?php echo number_format($ap_info->total_tax_amount,2); ?></b><br />
                                            <i class="fa fa-money"></i> Total Amount Before Tax : <b><?php echo number_format($ap_info->total_before_tax_amount,2); ?></b><br />
    
                                        </div>
                                        <div class="col-lg-6">
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
