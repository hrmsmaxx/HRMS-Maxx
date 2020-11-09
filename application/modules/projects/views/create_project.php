<?php //echo 'emp_view<pre>'; print_r($employee); exit;
?>
<div class="content">
	<div class="row">
		<div class="col-md-8">
			<h4 class="page-title"><?php echo lang('project');?></h4>
		</div>
		<div class="col-sm-4 text-right m-b-20">			
            <a class="btn back-btn" href="<?=base_url()?>projects"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
        </div>
	</div>
<div class="card-box">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h4 class="page-title"><?php echo lang('create_project');?></h4>
		</div>

	</div>
	<!-- Start Project Form -->
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<?php
			$attributes = array('class' => 'bs-example','id'=>'projectAddForm');
			echo form_open(base_url().'projects/add',$attributes); ?>
			<?=$this->session->flashdata('form_error') ?>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('project_code')?> <span class="text-danger">*</span></label>
							<?php $this->load->helper('string'); ?>
							<input type="text" class="form-control" value="<?=config_item('project_prefix')?><?=random_string('nozero', 5);?>" name="project_code" readonly style="cursor: not-allowed;">
							<input type="hidden" name="created_by" id="created_by" value="<?php echo $this->session->userdata('user_id'); ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('project_title')?> <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="<?=lang('project_title')?>" name="project_title" value="<?=set_value('project_title')?>">
						</div>	
					</div>	
				</div>	
				<?php // if (User::is_admin() || User::perm_allowed(User::get_id(),'add_projects')) { ?>
				<div class="row">
					<?php /* <div class="col-md-6">
						<div class="form-group">
							<label><?=lang('branch_name')?><span class="text-danger">*</span> </label>
							<div class="row">
								<div class="col-md-12">
									<select class="select2-option form-control" name="branch_id" id="branch_name"> 
									<option value=""><?php echo lang('select_branch'); ?></option>
										<?php foreach ($branches as $branch) { ?>
											<option value="<?=$branch->id?>"><?=$branch->branch_name;?></option>
										<?php } ?>
									</select> 
								</div>
							</div>	
						</div>	
					</div> */ ?>

					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('company'); ?></span> </label>
							<div class="row">
								<div class="col-md-12">
									<select class="select2-option form-control" name="client" id="client"> 
										<option value="" ><?=lang('select_company'); ?></option>
										<?php foreach (Client::get_all_clients() as $key => $c) { 
											if($c->subdomain_id == $this->session->userdata('subdomain_id')){
											?>
										<option value="<?=$c->co_id?>"><?=ucfirst($c->company_name)?></option>
										<?php } } ?>
									</select> 
								</div>
								<!-- <div class="col-md-4 new-client-btn">
									<a href="<?=base_url()?>companies/create" class="btn btn-success" data-toggle="ajaxModal" title="<?=lang('new_company')?>" data-placement="bottom"><i class="fa fa-plus"></i> <?=lang('new_client')?></a>
								</div> -->
							</div>	
						</div>	
					</div>
					<!-- <div class="col-md-6">
						<div class="form-group"> 
							<label><?=lang('progress')?></label>
							<div class="pro-progress"> 
								<div id="progress-slider"></div>
								<input id="progress" type="hidden" value="0" name="progress"/>
							</div>
						</div> 
					</div> --> 

					<div class="col-md-6">
						<?php // if (User::is_admin() || User::perm_allowed(User::get_id(),'add_projects')) { ?>
						<?php // if (User::is_admin()) { ?>
						<div class="form-group">
							<label><?=lang('lead_name'); ?> <span class="text-danger">*</span></label>
							<!-- <select class="select2-option form-control" name="assign_lead" id="lead"> 
									<option value="" disabled>Select Lead</option>
							</select> -->
							<!-- Build your select: -->
							<select class="select2-option" style="width:100%;" name="assign_lead" > 
								<optgroup label="<?=lang('admin_staff')?>"> 
								<?php foreach (User::teamlead() as $key => $user) { 
										if($user->subdomain_id == $this->session->userdata('subdomain_id')){
									?>
								<option value="<?=$user->id?>"><?=ucfirst(User::displayName($user->id))?></option>
								<?php } } ?>	
								</optgroup> 
							</select>
						</div>
						<?php // } ?>
						<?php // } ?>
					</div>
				<!-- </div>  -->
				<?php // } ?>
				<!-- <div class="row"> -->
					
					<div class="col-md-6">
						<?php // if (User::is_admin() || User::perm_allowed(User::get_id(),'add_projects')) { ?>
						<?php // if (User::is_admin()) { ?>
						<div class="form-group">
							<label><?=lang('assigned_to')?> <span class="text-danger">*</span></label>
							<select class="select2-option form-control" multiple="multiple" style="width:260px" name="assign_to[]" id="assign_to">
			                        <optgroup label="">
			                        <option value=""><?php echo lang('admin_staff');?></option> 
			                   <?php foreach ($employee as $c): ?>

		                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
		                            <?php endforeach;  ?>
		                        </optgroup>
		                    </select>

							<!-- Build your select: -->
							<?php /* <select class="select2-option" multiple="multiple" required style="width:100%;" name="assign_to[]" id="assign_to"> 
								<optgroup label="<?=lang('admin_staff')?>"> 
								<?php foreach (User::user_team() as $key => $user) { 
										if($user->subdomain_id == $this->session->userdata('subdomain_id')){
									?>
								<option value="<?=$user->id?>"><?=ucfirst(User::displayName($user->id))?></option>
								<?php } } ?>	
								</optgroup> 
								<!-- <option value="" disabled>Select Assign Employee</option> -->
							</select> */ ?>
						</div>
						<?php // } ?>
						<?php // } ?>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('fixed_rate')?></label>
							<div>
								<label class="switch">
									<input type="checkbox" id="fixed_rate" name="fixed_rate">
									<span></span>
								</label>
							</div>
						</div>
					</div>
				<!-- </div>
				<div class="row"> -->
					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('start_date')?> <span class="text-danger">*</span></label> 
							<input class="datepicker-input form-control" type="text" value="<?=strftime(config_item('date_format'), time());?>" name="start_date" data-date-format="<?=config_item('date_picker_format');?>" >
						</div> 
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('due_date')?> <span class="text-danger">*</span></label>
							<input class="datepicker-input form-control" type="text" value="<?=strftime(config_item('date_format'), time());?>" name="due_date" data-date-format="<?=config_item('date_picker_format');?>" >
						</div> 
					</div> 
				<!-- </div>
				<div class="row"> -->
					<div id="hourly_rate" class="col-md-6">
						<div class="form-group">
							<label><?=lang('hourly_rate')?>  (<?=lang('eg')?> 50.00) <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="hourly_rate" value="<?=config_item('hourly_rate')?>">
						</div>
					</div>
					<div id="fixed_price" class="col-md-6" style="display:none">
						<div class="form-group">
							<label><?=lang('fixed_price')?> (<?=lang('eg')?> 300 ) <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="300" name="fixed_price" value="<?=set_value('fixed_price')?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?=lang('estimated_hours')?> <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="300" name="estimate_hours" value="<?=set_value('estimate_hours')?>">
						</div>
					</div>
				<!-- </div>
				<div class="row"> -->
					<div class="col-md-12">
						<div class="form-group">
							<label><?=lang('description')?> <span class="text-danger">*</span></label>
							<textarea name="description" class="form-control foeditor-project-add" placeholder="<?=lang('description')?>" required value="<?=set_value('description')?>"></textarea>
							<div class="row">
							<div class="col-md-6">
							<label id="addproject_description_error" class="error display-none" style="position:inherit;top:0"><?=lang('description_must_not_empty'); ?></label>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="m-t-20 text-center">
					<button id="project_add_submit" class="btn btn-primary"><i class="fa fa-plus"></i> <?=lang('create_project')?></button>
				</div>
			</form>
		</div>
	</div>
	<!-- End Project Form -->
</div>
</div>