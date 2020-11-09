<?php
    $invoice_settings = $this->db->get_where('subdomin_invoice_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

    $invoice_settings = unserialize($invoice_settings['invoice_settings']);

    // echo "<pre>";print_r($invoice_settings);die;

    $invoice_color = $invoice_settings['invoice_color']?$invoice_settings['invoice_color']:config_item('invoice_color');
    $invoice_prefix = $invoice_settings['invoice_prefix']?$invoice_settings['invoice_prefix']:config_item('invoice_prefix');
    $invoices_due_after = $invoice_settings['invoices_due_after']?$invoice_settings['invoices_due_after']:config_item('invoices_due_after');
    $invoice_start_no = $invoice_settings['invoice_start_no']?$invoice_settings['invoice_start_no']:config_item('invoice_start_no');
    $pdf_engine = $invoice_settings['pdf_engine']?$invoice_settings['pdf_engine']:config_item('pdf_engine');
    $swap_to_from = $invoice_settings['swap_to_from']?$invoice_settings['swap_to_from']:config_item('swap_to_from');
    $display_invoice_badge = $invoice_settings['display_invoice_badge']?$invoice_settings['display_invoice_badge']:config_item('display_invoice_badge');
    $automatic_email_on_recur = $invoice_settings['automatic_email_on_recur']?$invoice_settings['automatic_email_on_recur']:config_item('automatic_email_on_recur');
    $show_invoice_tax = $invoice_settings['show_invoice_tax']?$invoice_settings['show_invoice_tax']:config_item('show_invoice_tax');
    $tax1 = $invoice_settings['tax1']?$invoice_settings['tax1']:config_item('tax1');
    $tax2 = $invoice_settings['tax2']?$invoice_settings['tax2']:config_item('tax2');
    $default_tax = $invoice_settings['default_tax']?$invoice_settings['default_tax']:config_item('default_tax');
    $default_tax2 = $invoice_settings['default_tax2']?$invoice_settings['default_tax2']:config_item('default_tax2');
    $invoice_logo_height = $invoice_settings['invoice_logo_height']?$invoice_settings['invoice_logo_height']:config_item('invoice_logo_height');
    $invoice_logo_width = $invoice_settings['invoice_logo_width']?$invoice_settings['invoice_logo_width']:config_item('invoice_logo_width');
    $invoice_footer = $invoice_settings['invoice_footer']?$invoice_settings['invoice_footer']:config_item('invoice_footer');
    $default_terms = $invoice_settings['default_terms']?$invoice_settings['default_terms']:config_item('default_terms');
    $invoice_logo = $invoice_settings['invoice_logo']?$invoice_settings['invoice_logo']:config_item('invoice_logo');
?>
<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?php echo lang('sales');?></h4>
		</div>
	</div>
	<?php $this->load->view('sub_menus');?>
	
	
	<!-- Start Form -->
	<div class="card-box m-b-0">
		<ul class="nav nav-tabs nav-tabs-bottom page-sub-tabs m-b-30">
			<li><a href="<?php echo base_url(); ?>invoices/estimate_settings"><?=lang('estimate_settings');?></a></li>
			<li class="active"><a href="<?php echo base_url(); ?>invoices/invoice_settings"><?=lang('invoice_settings');?></a></li>
			<li><a href="<?php echo base_url(); ?>invoices/payment_settings"><?=lang('payment_settings');?></a></li>
		</ul>
		<?php
		$attributes = array('class' => 'bs-example form-horizontal','id'=>'settingsInvoiceForm');
		echo form_open_multipart('invoices/invoice_settings_update', $attributes); ?>
			<h3 class="m-b-20"><?=lang('invoice_settings')?></h3>
			
			<input type="hidden" name="settings" value="<?=$load_setting?>">
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('invoice_color')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" id="invoice_color" readonly name="invoice_color" class="form-control" value="<?=$invoice_color;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('invoice_prefix')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="invoice_prefix" class="form-control" value="<?=$invoice_prefix;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('invoices_due_after')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="invoices_due_after" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title="<?=lang('days')?>" value="<?=$invoices_due_after;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('invoice_start_number')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="invoice_start_no" class="form-control" value="<?=$invoice_start_no;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('pdf_engine')?></label>
				<div class="col-lg-5">
					<select name="pdf_engine" class="form-control">
						<option value="invoicr"<?=($pdf_engine == 'invoicr'? ' selected="selected"': '')?>><?=lang('invoicr')?></option>
						<option value="mpdf"<?=($pdf_engine == 'mpdf'? ' selected="selected"': '')?>><?=lang('mpdf')?></option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('swap_to_from_side')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="swap_to_from" />
						<input type="checkbox" <?php if($swap_to_from == 'TRUE'){ echo "checked=\"checked\""; } ?> name="swap_to_from">
						<span></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('display_invoice_badge')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="display_invoice_badge" />
						<input type="checkbox" <?php if($display_invoice_badge == 'TRUE'){ echo "checked=\"checked\""; } ?> name="display_invoice_badge">
						<span></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('automatic_email_on_recur')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="automatic_email_on_recur" />
						<input type="checkbox" <?php if($automatic_email_on_recur == 'TRUE'){ echo "checked=\"checked\""; } ?> name="automatic_email_on_recur">
						<span></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('show_item_tax')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="show_invoice_tax" />
						<input type="checkbox" <?php if($show_invoice_tax == 'TRUE'){ echo "checked=\"checked\""; } ?> name="show_invoice_tax">
						<span></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('tax')?><?=lang('1')?> <?=lang('label_name')?><span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="tax1" id="tax1" class="form-control" value="<?=$tax1;?>" placeholder="Tax1" onkeyup="tax1_label()">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('tax')?><?=lang('2')?> <?=lang('label_name')?><span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="tax2" id="tax2" class="form-control" value="<?=$tax2;?>" placeholder="Tax2" onkeyup="tax2_label()">
				</div>
			</div>
			 <div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('tax')?> <?=lang('1')?> (<?=lang('percentage_symbol')?>)</label>
				<div class="col-lg-3">
					<input type="text" class="form-control money" value="<?=$default_tax;?>" id="system_settings_tax1" name="default_tax" onkeyup="tax1_val()">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('tax')?> <?=lang('2')?> (<?=lang('percentage_symbol')?>)</label>
				<div class="col-lg-3">
					<input type="text" class="form-control money" value="<?=$default_tax2;?>" id="system_settings_tax2" name="default_tax2" onkeyup="tax2_val()">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('invoice_logo')?></label>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-12">
							<label class="btn btn-default btn-choosef"><?=lang('choose_file')?></label>
							<input type="file" class="form-control" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="invoicelogo">
						</div>
					</div>
					<?php if ($invoice_logo != '') : ?>
						<div class="row">
							<div class="col-lg-6">
								<div id="invoice-logo-slider"></div>
							</div>
							<div class="col-lg-6">
								<div id="invoice-logo-dimensions"><?=$invoice_logo_height;?>px x <?=$invoice_logo_width;?>px</div>
							</div>
						</div>
						<input id="invoice-logo-height" type="hidden" value="<?=$invoice_logo_height;?>" name="invoice_logo_height"/>
						<input id="invoice-logo-width" type="hidden" value="<?=$invoice_logo_width;?>" name="invoice_logo_width"/>
						<div class="row" style="height: 150px; margin-bottom:15px;">
							<div class="col-lg-12">
								<div class="invoice_image" style="height: <?=$invoice_logo_height;?>px"><img src="<?=base_url()?>assets/images/logos/<?=$invoice_logo?>" /></div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group terms">
				<label class="col-lg-3 control-label"><?=lang('invoice_footer')?></label>
				<div class="col-lg-9">
					<textarea class="form-control foeditor" name="invoice_footer"><?=$invoice_footer;?></textarea>
				</div>
			</div>
			<div class="form-group terms">
				<label class="col-lg-3 control-label"><?=lang('default_terms')?></label>
				<div class="col-lg-9">
					<textarea class="form-control foeditor" name="default_terms"><?=$default_terms;?></textarea>
				</div>
			</div>
			<div class="text-center m-t-30">
				<button id="settings_invoice_submit" class="btn btn-primary btn-lg"><?=lang('save_changes')?></button>
			</div>
				
		</form>
	</div>
	<!-- End Form -->
</div>