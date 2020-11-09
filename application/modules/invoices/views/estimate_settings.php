<?php
	$estimate_settings = $this->db->get_where('subdomin_estimate_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

	$estimate_settings = unserialize($estimate_settings['estimate_settings']);

	// echo "<pre>";print_r($estimate_settings);die;

	$estimate_color = $estimate_settings['estimate_color']?$estimate_settings['estimate_color']:'';
	$estimate_prefix = $estimate_settings['estimate_prefix']?$estimate_settings['estimate_prefix']:'';
	$estimate_start_no = $estimate_settings['estimate_start_no']?$estimate_settings['estimate_start_no']:'';
	$display_estimate_badge = $estimate_settings['display_estimate_badge']?$estimate_settings['display_estimate_badge']:'';
	$show_estimate_tax = $estimate_settings['show_estimate_tax']?$estimate_settings['show_estimate_tax']:'';
	$estimate_to_project = $estimate_settings['estimate_to_project']?$estimate_settings['estimate_to_project']:'';
	$estimate_footer = $estimate_settings['estimate_footer']?$estimate_settings['estimate_footer']:'';
	$estimate_terms = $estimate_settings['estimate_terms']?$estimate_settings['estimate_terms']:'';
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
			<li class="active"><a href="<?php echo base_url(); ?>invoices/estimate_settings"><?=lang('estimate_settings');?></a></li>
			<li><a href="<?php echo base_url(); ?>invoices/invoice_settings"><?=lang('invoice_settings');?></a></li>
			<li><a href="<?php echo base_url(); ?>invoices/payment_settings"><?=lang('payment_settings');?></a></li>
		</ul>
		
		<?php
		$attributes = array('class' => 'bs-example form-horizontal','id'=>'settingsEstimatesForm');
		echo form_open_multipart('settings/update', $attributes); ?>
		
			<h3 class="m-b-20"><?=lang('estimate_settings')?></h3>
			<input type="hidden" name="settings" value="<?=$load_setting?>">
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('estimate_color')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" id="estimate_color" readonly name="estimate_color" class="form-control" value="<?=$estimate_color;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('estimate_prefix')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="estimate_prefix" class="form-control" value="<?=$estimate_prefix;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('estimate_start_number')?> <span class="text-danger">*</span></label>
				<div class="col-lg-5">
					<input type="text" name="estimate_start_no" class="form-control" value="<?=$estimate_start_no;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('display_estimate_badge')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="display_estimate_badge" />
						<input type="checkbox" <?php if($display_estimate_badge == 'TRUE'){ echo "checked=\"checked\""; } ?> name="display_estimate_badge">
						<span></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('show_item_tax')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="show_estimate_tax" />
						<input type="checkbox" <?php if($show_estimate_tax == 'TRUE'){ echo "checked=\"checked\""; } ?> name="show_estimate_tax">
						<span></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('estimate_to_project')?></label>
				<div class="col-lg-5">
					<label class="switch">
						<input type="hidden" value="off" name="estimate_to_project" />
						<input type="checkbox" <?php if($estimate_to_project == 'TRUE'){ echo "checked=\"checked\""; } ?> name="estimate_to_project">
						<span></span>
					</label>
				</div>
				<div class="col-lg-6">
					<span class="help-block m-b-0"><?=lang('convert_accepted_estimate_to_project')?></span>
				</div>
			</div>
			<div class="form-group terms">
				<label class="col-lg-3 control-label"><?=lang('estimate_footer')?></label>
				<div class="col-lg-9">
					<textarea class="form-control foeditor" name="estimate_footer"><?=$estimate_footer;?></textarea>
				</div>
			</div>
			<div class="form-group terms">
				<label class="col-lg-3 control-label"><?=lang('estimate_terms')?></label>
				<div class="col-lg-9">
					<textarea class="form-control foeditor" name="estimate_terms"><?=$estimate_terms;?></textarea>
				</div>
			</div>
			<div class="text-center m-t-30">
				<button id="settings_estimates_submit" class="btn btn-primary btn-lg"><?=lang('save_changes')?></button>
			</div>
		</form>
	</div>
	<!-- End Form -->
</div>