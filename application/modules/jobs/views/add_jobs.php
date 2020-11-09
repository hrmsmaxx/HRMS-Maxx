
<div class="content">
	<div class="row">
<div class="content">
					<div class="row">
						<div class="col-xs-8">
							<h4 class="page-title m-b-0"><?php echo lang('recruiting_process');?></h4>
			<ul class="breadcrumb m-b-30 p-l-0" style="background:none; border:none;">
						        <li><a href="<?php echo base_url(); ?>"><?php echo lang('home');?></a></li>
						        <li><a href="<?php echo base_url(); ?>jobs"><?php echo lang('recruiting_process');?></a></li>
						        <li><a href="<?php echo base_url(); ?>jobs/manage"><?php echo lang('manage_jobs');?></a></li>
						        <li class="active"><?php echo lang('add_jobs');?></li>
			</ul>
		</div>
						 <div class="col-sm-4  text-right m-b-20">     
				              <a class="btn back-btn" href="<?=base_url()?>jobs/manage"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
				          </div>
					</div>					
	<div class="row">
		
	</div>
	<div class="panel">
		<div class="panel-heading">
			<h6 class="panel-title"><?php echo lang('add_jobs');?></h6>
		</div>
		<div class="panel-body">
			<form name="add_jobs" id="add_jobs" action="<?php echo site_url('add_jobs');?>" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('job_title')?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="job_title" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('department'); ?><span class="text-danger">*</span></label>
							<select class="select required" name="department"  onchange="get_position(this.value)">
								<option value=""><?php echo lang('select_department');?></option>
								<?php 
									foreach($departments as $key => $depart)
									{
										?><option value="<?php echo $depart->deptid;?>"><?php echo $depart->deptname; ?></option><?php 
									}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('position'); ?><span class="text-danger">*</span></label>
							<select class="select required" name="position"  id="positions">
								<option value=""><?php echo lang('select_position');?></option>
								
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('country')?><span class="text-danger">*</span></label>
							<select class="select" name="country_id" >
								<option value=""><?php echo lang('select_country');?></option>
								<?php 
									foreach($countries as $key => $country)
									{
										?><option value="<?php echo $country->id;?>"><?php echo $country->value; ?></option><?php 
									}
								?>
							</select>
						</div>
					</div>
					
					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('job_location');?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="job_location" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('experience_level')?><span class="text-danger">*</span></label>
							<select class="select" name="experience_level" >
								<option value=""><?php echo lang('select_experience_level');?> </option>
								<?php 
									foreach($experience_levels as $key => $level)
									{
										?><option value="<?php echo $level->id;?>"><?php echo $level->experience_level; ?></option><?php 
									}
								?>
							</select>
						</div>
					</div>
					
					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('experiences');?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="experience" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('no_of_vacancy');?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="no_of_vacancy" >
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('age_limit');?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="age" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('salary_from');?><span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="salary_from" >
						</div>
					</div>
				
				</div>
				<div class="row">
						<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('salary_to');?><span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="salary_to" >
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('job_type');?><span class="text-danger">*</span></label>
							<select class="select" name="job_type" >
								<option value=""><?php echo lang('select_job_type');?></option>
								<?php 
									foreach ($job_types as $key => $type) {
										?><option value="<?php echo $type->id;?>"><?php echo $type->job_type;?></option><?php 	
									}
								?>
							</select>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('status');?><span class="text-danger">*</span></label>
							<select class="select" name="status" >
								<option value="0" selected><?php echo lang('open') ?></option>
								<option value="1"><?php echo lang('close');?></option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('start_date');?><span class="text-danger">*</span></label>
							<input type="text" class="form-control datetimepicker" name="start_date" >
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('expire_date');?><span class="text-danger">*</span></label>
							<input type="text" class="form-control datetimepicker" name="expired_date" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('description');?><span class="text-danger">*</span></label>
							<textarea class="form-control" name="description"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo lang('job_image');?></label>
							<input type="file" class="form-control" name="image_file" id="image_file">
						</div>
					</div>
					
				</div>
				<div class="submit-section">
					<a href="<?php echo base_url(); ?>jobs/manage" class="btn btn-danger submit-btn m-b-5" id="btnSave" type="submit"><?php echo lang('cancel');?></a>
					<button class="btn btn-primary submit-btn m-b-5" id="savejobs" type="submit" name="submit" value="submit"><?php echo lang('save');?></button>
				</div>
			</form>
		</div>
	</div>
</div>