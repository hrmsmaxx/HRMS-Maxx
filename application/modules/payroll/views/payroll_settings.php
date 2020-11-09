 <div class="content container-fluid">

					<div class="row">
						<div class="col-xs-8">
							<h4 class="page-title"><?php echo lang('payrollsettings');?></h4>
						</div>
					</div>
    <?php $this->load->view('sub_menus');?>

<!-- <div class="payroll-table card-box">
<form action="<?php echo base_url(); ?>settings/update" id="HaDraForm" class="bs-example" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<?php 
		$settingsalray = array();
		if(!empty($salary_setting)){
			foreach ($salary_setting as  $value) {
				$settingsalray[$value->config_key] = $value->value;
			}
		}

	 ?>
	<div class="settings-widget">
		<input type="hidden" name="settings" value="setting_salary">
		<div class="h3 card-title with-switch">
			<?php echo lang('da_hra'); ?> 											
			<div class="onoffswitch">
				<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_hra" checked>
				<label class="onoffswitch-label" for="switch_hra">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label><?php echo lang('da'); ?> (<?php echo lang('percentage_symbol'); ?>) <span class="text-danger">*</span></label>
					<input type="number" min="0" max="55" name="salary_da"  class="form-control" value="<?php echo (!empty($settingsalray['salary_da']))?$settingsalray['salary_da']:''; ?>" required="" maxlength="2">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label><?php echo lang('hra'); ?> (<?php echo lang('percentage_symbol'); ?>) <span class="text-danger">*</span></label>
					<input type="number" min="0" max="25" name="salary_hra" class="form-control" value="<?php echo (!empty($settingsalray['salary_hra']))?$settingsalray['salary_hra']:''; ?>" required="" maxlength="2">
				</div>
			</div>
		</div>
	</div>

	
	
	<div class="submit-section">
		<button id="ha_dra_submit" class="btn btn-primary submit-btn"><?php echo lang('save_changes'); ?></button>
	</div>
</form>
</div> -->


					<div class="payroll-table card-box m-b-0">
<form action="<?php echo base_url(); ?>payroll/settings"  class="bs-example" enctype="multipart/form-data" method="post" accept-charset="utf-8">

<div class="settings-widget">
		<!-- <div class="h3 card-title with-switch">
			TDS&nbsp; <small class="form-text text-muted">Annual Salary</small>
			<div class="onoffswitch">
				<input type="checkbox" checked="" name="onoffswitch" class="onoffswitch-checkbox" id="switch_tds">
				<label class="onoffswitch-label" for="switch_tds">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div> -->

		<?php

		$tds_settings=$this->db->get('tds_settings')->result_array();

		foreach ($tds_settings as $tds_row) {
		
        ?>

		<div class="row row-sm">
			<div class="col-sm-4">
				<div class="form-group">
					<label><?php echo lang('salary_from'); ?></label>
					<input class="form-control" name="salary_from[]" value="<?php echo $tds_row['salary_from'];?>"   required="" type="text">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label><?php echo lang('salary_to'); ?></label>
					<input class="form-control" name="salary_to[]" value="<?php echo $tds_row['salary_to'];?>"  required="" type="text">
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label><?php echo lang('percentage_symbol'); ?></label>
					<input class="form-control" name="salary_percentage[]" value="<?php echo $tds_row['salary_percentage'];?>"  required="" type="text">
				</div>
			</div>
			<!-- <div class="col-sm-2">
				<div class="form-group">
					<label class="d-none d-sm-block">&nbsp;</label>
					<button class="btn btn-danger btn-block set-btn" type="button"><i class="fa fa-trash-o"></i></button>
				</div>
			</div> -->
		</div>
	<?php } ?>
		
		<!-- <div class="row row-sm">
			<div class="col-sm-2 pull-right">
				<div class="form-group">
					<button class="btn btn-primary btn-block" type="button"><i class="fa fa-plus"></i></button>
				</div>
			</div>
		</div> -->
	</div>

	<div class="submit-section">
		<button id="ha_dra_submit" class="btn btn-primary submit-btn"><?php echo lang('save_changes'); ?></button>
	</div>
</form>
</div>