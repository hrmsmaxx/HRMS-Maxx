<div class="page-wrapper" style="padding-top:35px;">
    <div class="content container-fluid">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title"><?=lang('edit_invoice')?></h4>
		</div>
        <div class="col-sm-4  text-right m-b-20">     
              <a class="btn btn-outline-primary back-btn" href="<?=base_url()?>subscriber_invoices"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
          </div>
	</div>
	<div class="card">
    <div class="card-body">
	<div class="row">
		<div class="col-sm-3">
			<h4 class="page-title"><?=lang('invoice_details')?> - <?=$i->reference_no?></h4>
		</div>
		<div class="col-sm-9 text-right m-b-0">
			<?php $i = Subscriber_invoice::view_by_id($id); ?>
				<a href="<?=base_url()?>subscriber_invoices/view/<?=$i->inv_id?>" data-original-title="<?=lang('view_details')?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-primary rounded float-right"><i class="fa fa-info-circle"></i> <?=lang('invoice_details')?></a>
		</div>
	</div>
	<!-- Start create invoice -->
				<div class="row">
                    <div class="col-sm-12">
                                <?php
                                $attributes = array('class' => 'bs-example form-horizontal','id'=> 'editInvoiceForm');
                                echo form_open(base_url().'subscriber_invoices/edit',$attributes); ?>
                                <input type="hidden" name="inv_id" value="<?=$i->inv_id?>">
                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('reference_no')?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" readonly value="<?=$i->reference_no?>" name="reference_no">
                                    </div>
                                    <a href="#recurring" class="btn btn-info" data-toggle="class:show"><?=lang('recurring')?></a>
                                </div>
                                <!-- Start discount fields -->
                                <div id="recurring" class="hide">
                                    <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('recur_frequency')?> </label>
                                        <div class="col-lg-4">
                                            <select name="r_freq" class="form-control">
                                                <option value="none"><?=lang('none')?></option>
                                                <option value="7D"<?=($i->recur_frequency == "7D" ? ' selected="selected"' : '')?>><?=lang('week')?></option>
                                                <option value="1M"<?=($i->recur_frequency == "1M" ? ' selected="selected"' : '')?>><?=lang('month')?></option>
                                                <option value="3M"<?=($i->recur_frequency == "3M" ? ' selected="selected"' : '')?>><?=lang('quarter')?></option>
                                                <option value="6M"<?=($i->recur_frequency == "6M" ? ' selected="selected"' : '')?>><?=lang('six_months')?></option>
                                                <option value="1Y"<?=($i->recur_frequency == "1Y" ? ' selected="selected"' : '')?>><?=lang('year')?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('start_date')?> <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <?php if ($i->recurring == 'Yes') {
                                                $recur_start_date = date('d-m-Y',strtotime($i->recur_start_date));
                                                $recur_end_date = date('d-m-Y',strtotime($i->recur_end_date));
                                            }else{
                                                $recur_start_date = date('d-m-Y');
                                                $recur_end_date = date('d-m-Y');
                                            }
                                            ?>
                                            <input class="datepicker-input form-control" type="text" value="<?=strftime(config_item('date_format'), strtotime($recur_start_date));?>" name="recur_start_date" data-date-format="<?=config_item('date_picker_format');?>" >
                                        </div>
                                    </div>
                                    <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('end_date')?> <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input class="datepicker-input form-control" type="text" value="<?=strftime(config_item('date_format'), strtotime($recur_end_date));?>" name="recur_end_date" data-date-format="<?=config_item('date_picker_format');?>" >
                                        </div>
                                    </div>
                                </div>
                                <!-- End discount Fields -->
                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('company')?> <span class="text-danger">*</span> </label>
                                    <div class="col-lg-4">
                                        <select class="select2-option form-control" style="width:100%" name="client" >
                                            <optgroup label="<?=lang('company')?>">
                                                <option value="<?=$i->client?>">
                                                    <?=ucfirst(Subscriber_client::view_by_id($i->client)->company_name)?></option>
                                                <?php foreach ($clients as $client): ?>
                                                    <option value="<?=$client->co_id?>">
                                                        <?=ucfirst($client->company_name)?></option>
                                                <?php endforeach;  ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('due_date')?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <input class="datepicker-input form-control" readonly type="text" value="<?=strftime(config_item('date_format'), strtotime($i->due_date));?>" name="due_date" data-date-format="<?=config_item('date_picker_format');?>" >
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('created')?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                        <input class="form-control" readonly type="text" value="<?=strftime(config_item('date_format'), strtotime($i->date_saved));?>" name="date_saved" data-date-format="<?=config_item('date_picker_format');?>" >
                                    </div>
                                </div>


                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=config_item('tax1')?></label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
											<span class="input-group-text"><?=lang('percentage_symbol')?></span>
										</div>
                                            <input class="form-control money" type="text" value="<?=$i->tax?>" name="tax" id="invoice_edit_tax1">
                                        </div>

                                        <div class="row">
                                        <div class="col-md-12">
                                        <label id="edit_invoice_tax1_error" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="tax"><?=lang('tax_is_invalid')?></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=config_item('tax2')?></label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
											<span class="input-group-text"><?=lang('percentage_symbol')?></span>
										</div>
                                            <input class="form-control money" type="text" value="<?=$i->tax2?>" name="tax2" id="invoice_edit_tax2">
                                        </div>

                                        <div class="row">
                                        <div class="col-md-12">
                                        <label id="edit_invoice_tax2_error" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="tax2"><?=lang('tax_is_invalid')?></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Start discount fields -->
                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('discount')?> </label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
											<span class="input-group-text"><?=lang('percentage_symbol')?></span>
										</div>
                                            <input class="form-control money" type="text" value="<?=$i->discount?>" name="discount" id="invoice_edit_discount">
                                        </div>

                                        <div class="row">
                                        <div class="col-md-12">
                                        <label id="edit_invoice_discount_error" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="discount"><?=lang('discount_is_invalid')?></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End discount Fields -->

                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('extra_fee')?></label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
											<span class="input-group-text"><?=lang('percentage_symbol')?></span>
										</div>
                                            <input class="form-control money" type="text" value="<?=$i->extra_fee?>" name="extra_fee" id="invoice_edit_extrafee">
                                        </div>

                                        <div class="row">
                                        <div class="col-md-12">
                                        <label id="edit_invoice_fee_error" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="fee"><?=lang('fees_is_invalid')?></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('currency')?></label>
                                    <div class="col-lg-4">
                                        <select name="currency" class="form-control">
                                            <?php $cur = App::currencies($i->currency); ?>
                                            <?php foreach ($currencies as $cur) : ?>
                                                <option value="<?=$cur->code?>"<?=($i->currency == $cur->code ? ' selected="selected"' : '')?>><?=$cur->name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>


                                <?php // if(config_item('2checkout_private_key') != '' AND config_item('2checkout_publishable_key') != ''){ ?>

                                    <!-- <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('allow_2checkout')?></label>
                                        <div class="col-lg-4">
                                            <label class="switch">
                                                <input type="checkbox" name="allow_2checkout" <?php if($i->allow_2checkout == 'Yes'){ echo "checked=\"checked\""; }?>>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div> -->
                                <?php // } else{ ?>
                                    <!-- <input type="hidden" name="allow_2checkout" value="off">  -->
                                    <?php // } ?>

                                <?php // if(config_item('paypal_email') != ''){ ?>

                                    <!-- <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('allow_paypal')?></label>
                                        <div class="col-lg-4">
                                            <label class="switch">
                                                <input type="checkbox" name="allow_paypal" <?php // if($i->allow_paypal == 'Yes'){ echo "checked=\"checked\""; }?>>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div> -->

                                <?php // } else{ ?>
                                    <!-- <input type="hidden" name="allow_paypal" value="off">  -->
                                    <?php // } ?>

                                <?php if(config_item('stripe_private_key') != '' AND config_item('stripe_public_key') != ''){ ?>
                                    <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('allow_stripe')?></label>
                                        <div class="col-lg-4">
                                            <label class="">
                                                <input type="checkbox" name="allow_stripe" <?php if($i->allow_stripe == 'Yes'){ echo "checked=\"checked\""; }?>>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                <?php } else{ ?><input type="hidden" name="allow_stripe" value="off"> <?php } ?>

    <?php // if(config_item('braintree_merchant_id') != '' AND config_item('braintree_public_key') != ''){ ?>
                            <!-- <div class="form-group form-row">
                                <label class="col-lg-3"><?=lang('allow_braintree')?></label>
                                <div class="col-lg-4">
                                    <label class="switch">
                                        <input type="checkbox" name="allow_braintree" id="use_braintree"  <?php // if($i->allow_braintree == 'Yes'){ echo "checked=\"checked\""; }?>> 
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                           <div id="braintree_setup" <?php // echo ($i->allow_braintree == 'No') ? 'style="display:none"' : ''; ?>>
                            <div class="form-group form-row">
                                <label class="col-lg-3"><?=lang('braintree_merchant_account')?></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="braintree_merchant_ac" value="<?=$i->braintree_merchant_ac?>">
                                </div>
                                <span class="help-block m-b-none small text-danger">Check Braintree merchant Currency <a href="https://articles.braintreepayments.com/control-panel/important-gateway-credentials" target="_blank">Read More</a></span>
                            </div>
                        </div> -->

    <?php // } else{ ?>
        <!-- <input type="hidden" name="allow_braintree" value="off">  -->
        <?php // } ?>

                                <?php // if(config_item('bitcoin_address') != ''){ ?>
                                    <!-- <div class="form-group form-row">
                                        <label class="col-lg-3"><?=lang('allow_bitcoin')?></label>
                                        <div class="col-lg-4">
                                            <label class="switch">
                                                <input type="checkbox" name="allow_bitcoin" <?php // if($i->allow_bitcoin == 'Yes'){ echo "checked=\"checked\""; }?>>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div> -->
                                <?php // } else{ ?>
                                    <!-- <input type="hidden" name="allow_bitcoin" value="off">  -->
                                    <?php // } ?>

                                <div class="form-group form-row">
                                    <label class="col-lg-3"><?=lang('notes')?> <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <textarea name="notes" class="form-control foeditor-invoice-edit"><?=$i->notes?></textarea>
                                        <div class="row">
                                        <div class="col-md-6">
                                        <label id="edit_invoice_error" class="error display-none" style="position:inherit;top:0;font-size: 15px;" for="notes"><?=lang('notes_not_empty')?></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-lg" id="invoice_edit_submit"> <?=lang('save_changes')?></button>
								</div>
                                </form>
                    </div>
                    </div>
                    <!-- End create invoice -->
</div>
</div>
</div>
</div>
<!-- end -->