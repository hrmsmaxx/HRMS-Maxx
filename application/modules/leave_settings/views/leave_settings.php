<div class="content">
	<div class="row">
		<div class="col-sm-4 col-xs-3">
			<h4 class="page-title"><?=lang('leave_settings')?></h4>
		</div>
		<div class="col-sm-8 col-xs-9 text-right m-b-20">
			<a href="#" class="btn add-btn" data-toggle="modal" data-target="#new_leave_type" >
				<i class="fa fa-plus"></i> <?php echo lang('add_new_type');?>
            </a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
		
			<!-- Annual Leave -->
			<div class="card-box leave-box" id="leave_annual">
				<?php $leave_annual = $this->db->get_where('common_leave_types',array('leave_keys'=>'annual_leaves','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
				<h3 class="card-title with-switch">
					<?php echo lang('annual');?> 											
					
				</h3>
				<div class="form-group form-check">
					<!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
					<label class="form-check-label" for="exampleCheck1"><?php echo lang('adjust_employee_leave_balance');?></label>
					<span class="form-text mt-0">(<?php echo lang('any_updates_to_carry_forward_and_policy_will_effective_from_this_cycle');?>)</span>
				</div>
				<div class="leave-item">
					<!-- Annual Days Leave -->
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<div class="form-group">
									<label><?php echo lang('days');?></label>
									<input type="text" class="form-control Daystext" id="annual_leaves"  value="<?php echo $leave_annual['leave_days']; ?>" disabled>
								</div>
							</div>
						</div>
						<!--<div class="leave-right">
							<div class="UpdateBtn" style="display: none;">
								<button class="btn btn-white CancelBtn" >Cancel</button>
								<button class="btn btn-primary">Save</button>
							</div>
							<div class="EditBtn">
								<button class="leave-edit-btn BtnEdit"><?php //echo lang('edit');?></button>
							</div>
						</div> -->
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="annual"><?php echo lang('edit');?></button>
						</div>
					</div>
					<!-- /Annual Days Leave -->
					
					<!-- Carry Forward -->
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<label class="d-block"><?php echo lang('carry_forward');?></label>
								<div class="leave-inline-form">
									<label class="radio-inline">
									<?php $leave_carry = $this->db->get_where('common_leave_types',array('leave_keys'=>'carry_forward','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
										<input type="radio" name="carryfwd" class="CarryFwd" value="no"  disabled="disabled" <?php if($leave_carry['leave_status']=='no'){ ?> checked <?php } ?>><?php echo lang('no');?>
									</label>
									<label class="radio-inline">
										<input type="radio" name="carryfwd" class="CarryFwd" value="yes" disabled="disabled" <?php if($leave_carry['leave_status']=='yes'){ ?> checked <?php } ?>><?php echo lang('yes');?>
									</label>
									<div class="input-group" id="MaxDays" >
										<span class="input-group-addon">
											<?php echo lang('max');?>
										</span>
										<input type="text" class="form-control" id="carry_max" value="<?php echo $leave_carry['leave_days']; ?>" disabled="disabled" >
									</div>
								</div>
							</div>
						</div>
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="carry_forward"><?php echo lang('edit');?></button>
						</div>
						<!-- <div class="leave-right">
							<div class="UpdateMaxBtn" style="display: none;">
								<button class="btn btn-white CancelMaxBtn" >Cancel</button>
								<button class="btn btn-primary">Save</button>
							</div>
							<button class="leave-edit-btn EditMax">
								Edit
							</button>
						</div> -->
					</div>
					<!-- /Carry Forward -->
					
					<!-- Earned Leave -->
					<div class="leave-row">

					</div>
					<!-- /Earned Leave -->
					
				</div>
				
				<!-- Custom Policy -->
				<div class="custom-policy">
					<div class="leave-header">
						<div class="title"><?php echo lang('custom_policy');?></div>
						<?php $custom_policy = $this->db->get_where('common_leave_types',array('leave_keys'=>'custom_policy_annual','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
						<div class="leave-action">
							<button class="btn btn-sm btn-primary PolicyID" type="button" data-id="<?php echo $custom_policy['leave_id'] ?>" data-toggle="modal" data-target="#add_custom_policy"><i class="fa fa-plus"></i> <?php echo lang('add_custom_policy');?></button>
						</div>
					</div>
					<table class="table table-hover table-nowrap leave-table">
						<thead>
							<tr>
								<th class="l-name"><?php echo lang('name');?></th>
								<th class="l-days"><?php echo lang('days');?></th>
								<th class="l-assignee"><?php echo lang('assignee');?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $all_users = $this->db->get_where('custom_policy',array('leave_id'=>$custom_policy['leave_id']))->result_array(); 
								foreach($all_users as $user){
									$users_all = $this->db->select('*')
													         ->from('assigned_policy_user AU')
													         ->join('account_details AD','AU.user_id = AD.user_id')
													         ->where('AU.policy_id',$user['policy_id'])
													         ->get()->result_array();
									// echo "<pre>"; print_r($users_all); exit;
									foreach($users_all as $al_user)
									{
							?>
							<tr>
								<td><?php echo $user['custom_policy_name']; ?></td>
								<td><?php echo $user['policy_leave_days']; ?></td>
								<td>
									<a href="<?php echo base_url(); ?>employees/profile_view/<?php echo $al_user['user_id']; ?>" class="avatar"><?php echo strtoupper($al_user['fullname'][0]); ?></a>
									<a href="<?php echo base_url(); ?>employees/profile_view/<?php echo $al_user['user_id']; ?>"><?php echo $al_user['fullname']; ?></a>
								</td>
								<td class="text-right">
									<div class="dropdown dropdown-action">
										<a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="fa fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="#" class="dropdown-item EditCustomUser" data-toggle="modal" data-id="<?php echo $al_user['assigned_id']; ?>" data-target="#edit_custom_policy<?php echo $user['policy_id'].$al_user['user_id']; ?>"><i class="fa fa-pencil m-r-5"></i> <?php echo lang('edit');?></a>
											<a href="#" class="dropdown-item" onclick="delete_custom_policy(<?php echo $al_user['assigned_id']; ?>)"><i class="fa fa-trash-o m-r-5"></i> <?php echo lang('delete');?></a>
										</div>
									</div>
								</td>
							</tr>
						<?php } } ?>
						</tbody>
					</table>
				</div>
				<!-- /Custom Policy -->
				
			</div>
			<!-- /Annual Leave -->
			
				<?php $leave_sick = $this->db->get_where('common_leave_types',array('leave_keys'=>'sick','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
			<!-- Sick Leave -->
			<div class="card-box leave-box" id="leave_sick">
				<h3 class="card-title with-switch">
					<?php echo lang('sick'); ?>										
					<div class="onoffswitch">
						<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" data-id="<?php echo $leave_sick['leave_id'] ?>" id="switch_sick" <?php if($leave_sick['status'] == 0 ){ ?>checked <?php } ?>>
						<label class="onoffswitch-label" for="switch_sick">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</h3>
				<div class="form-group form-check">
					<!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
					<label class="form-check-label" for="exampleCheck1"><?php echo lang('adjust_employee_leave_balance');?></label>
					<span class="form-text mt-0">(<?php echo lang('any_updates_to_carry_forward_and_policy_will_effective_from_this_cycle');?>)</span>
				</div>
				<div class="leave-item">
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<div class="form-group">
									<label><?php echo lang('days');?></label>
									<input type="text" class="form-control" id="sick_leave" value="<?php echo $leave_sick['leave_days']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="sick"><?php echo lang('edit');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Sick Leave -->
			
				<?php $leave_hosp = $this->db->get_where('common_leave_types',array('leave_keys'=>'hospitalisation','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
			<!-- Hospitalisation Leave -->
			<div class="card-box leave-box" id="leave_hospitalisation">
				<h3 class="card-title with-switch">
					<?php echo lang('hospitalisation');?> 											
					<div class="onoffswitch">
						<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_hospitalisation" data-id="<?php echo $leave_hosp['leave_id'] ?>"  <?php if($leave_hosp['status'] == 0 ){ ?>checked <?php } ?>>
						<label class="onoffswitch-label" for="switch_hospitalisation">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</h3>
				<div class="form-group form-check">
					<!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
					<label class="form-check-label" for="exampleCheck1"><?php echo lang('adjust_employee_leave_balance');?></label>
					<span class="form-text mt-0">(<?php echo lang('any_updates_to_carry_forward_and_policy_will_effective_from_this_cycle');?>)</span>
				</div>
				<div class="leave-item">
					<!-- Annual Days Leave -->
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<div class="form-group">
									<label><?php echo lang('days');?></label>
									<input type="text" class="form-control" id="hospitalisation_leave" value="<?php echo $leave_hosp['leave_days']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="hospitalisation"><?php echo lang('edit');?></button>
						</div>
					</div>
					<!-- /Annual Days Leave -->
					
				</div>
				
				<!-- Custom Policy -->
				<div class="custom-policy">
					<div class="leave-header">
						<div class="title"><?php echo lang('custom_policy'); ?></div>
						<?php $custom_policys = $this->db->get_where('common_leave_types',array('leave_keys'=>'custom_policy_hospitalisation','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
						<div class="leave-action">
							<button class="btn btn-sm btn-primary PolicyID" type="button" data-id="<?php echo $custom_policys['leave_id'] ?>" data-toggle="modal" data-target="#add_custom_policy"><i class="fa fa-plus"></i> <?php echo lang('add_custom_policy'); ?></button>
						</div>
					</div>
					<table class="table table-hover table-nowrap leave-table">
						<thead>
							<tr>
								<th class="l-name"><?php echo lang('name'); ?></th>
								<th class="l-days"><?php echo lang('days');?></th>
								<th class="l-assignee"><?php echo lang('assignee'); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $all_user = $this->db->get_where('custom_policy',array('leave_id'=>$custom_policys['leave_id']))->result_array(); 
								foreach($all_user as $use){
									$users_al = $this->db->select('*')
													         ->from('assigned_policy_user AU')
													         ->join('account_details AD','AU.user_id = AD.user_id')
													         ->where('AU.policy_id',$use['policy_id'])
													         ->get()->result_array();
									// echo "<pre>"; print_r($users_all); exit;
									foreach($users_al as $a_user)
									{
							?>
							<tr>
								<td><?php echo $use['custom_policy_name']; ?></td>
								<td><?php echo $use['policy_leave_days']; ?></td>
								<td>
									<a href="<?php echo base_url(); ?>employees/profile_view/<?php echo $a_user['user_id']; ?>" class="avatar"><?php echo strtoupper($a_user['fullname'][0]); ?></a>
									<a href="<?php echo base_url(); ?>employees/profile_view/<?php echo $a_user['user_id']; ?>"><?php echo $a_user['fullname']; ?></a>
								</td>
								<td class="text-right">
									<div class="dropdown dropdown-action">
										<a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="fa fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="#" class="dropdown-item" data-toggle="modal" data-target="#edit_custom_policy"><i class="fa fa-pencil m-r-5"></i> <?php echo lang('edit');?></a>
											<a href="#" class="dropdown-item" onclick="delete_custom_policy(<?php echo $a_user['assigned_id']; ?>)"><i class="fa fa-trash-o m-r-5"></i> <?php echo lang('delete'); ?></a>
										</div>
									</div>
								</td>
							</tr>
						<?php } } ?>
						</tbody>
					</table>
				</div>
				<!-- /Custom Policy -->
				
			</div>
			<!-- /Hospitalisation Leave -->
			
				<?php $leave_maternity = $this->db->get_where('common_leave_types',array('leave_keys'=>'maternity','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
			<!-- Maternity Leave -->
			<div class="card-box leave-box" id="leave_maternity">
				<h3 class="card-title with-switch">
					<?php echo lang('maternity'); ?>  <span class="subtitle"><?php echo lang('assigned_to_female_only'); ?></span>
					<div class="onoffswitch">
						<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_maternity" data-id="<?php echo $leave_maternity['leave_id'] ?>"  <?php if($leave_maternity['status'] == 0 ){ ?>checked <?php } ?>>
						<label class="onoffswitch-label" for="switch_maternity">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</h3>
				<div class="form-group form-check">
					<!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
					<label class="form-check-label" for="exampleCheck1"><?php echo lang('adjust_employee_leave_balance');?></label>
					<span class="form-text mt-0">(<?php echo lang('any_updates_to_carry_forward_and_policy_will_effective_from_this_cycle');?>)</span>
				</div>
				<div class="leave-item">
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<div class="form-group">
									<label><?php echo lang('days');?></label>
									<input type="text" class="form-control" id="maternity_leaves" value="<?php echo $leave_maternity['leave_days']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="maternity"><?php echo lang('edit');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Maternity Leave -->
			
				<?php $leave_paternity = $this->db->get_where('common_leave_types',array('leave_keys'=>'paternity','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array(); ?>
			<!-- Paternity Leave -->
			<div class="card-box leave-box" id="leave_paternity">
				<h3 class="card-title with-switch">
					<?php echo lang('paternity'); ?>  <span class="subtitle"><?php echo lang('assigned_to_male_only'); ?></span>
					<div class="onoffswitch">
						<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_paternity" data-id="<?php echo $leave_paternity['leave_id'] ?>"  <?php if($leave_paternity['status'] == 0 ){ ?>checked <?php } ?>>
						<label class="onoffswitch-label" for="switch_paternity">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</h3>
				<div class="form-group form-check">
					<!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
					<label class="form-check-label" for="exampleCheck1"><?php echo lang('adjust_employee_leave_balance');?></label>
					<span class="form-text mt-0">(<?php echo lang('any_updates_to_carry_forward_and_policy_will_effective_from_this_cycle');?>)</span>
				</div>
				<div class="leave-item">
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<div class="form-group">
									<label><?php echo lang('days');?></label>
									<input type="text" class="form-control" id="paternity_leaves" value="<?php echo $leave_paternity['leave_days']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="paternity"><?php echo lang('edit');?></button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Paternity Leave -->

			<?php $extra_leave_types = $this->db->get_where('common_leave_types',array('leave_keys'=>'custom_leave_type','subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array(); 
				if(count($extra_leave_types) != 0){
					foreach($extra_leave_types as $extra_leaves){
			?>
			<!-- Dynamic Leave Types -->


			<div class="card-box leave-box">
				<h3 class="card-title with-switch">
					<?php echo $extra_leaves['leave_type']; ?>  
					<div class="onoffswitch">
						<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox ALLExtraSwitch" id="switch_<?php echo $extra_leaves['leave_type']; ?>" data-id="<?php echo $extra_leaves['leave_id']; ?>" <?php if($extra_leaves['status'] == 0 ){ echo "checked"; } ?> >
						<label class="onoffswitch-label" for="switch_<?php echo $extra_leaves['leave_type']; ?>">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
					<a class="btn btn-danger leave-delete-btn" data-id="<?php echo $extra_leaves['leave_id']; ?>"><?php echo lang('delete');?></a>
				</h3>
				<div class="form-group form-check">
					<label class="form-check-label" for="exampleCheck1"><?php echo lang('adjust_employee_leave_balance');?></label>
					<span class="form-text mt-0">(<?php echo lang('any_updates_to_carry_forward_and_policy_will_effective_from_this_cycle');?>)</span>
				</div>
				<div class="leave-item">
					<div class="leave-row">
						<div class="leave-left">
							<div class="input-box">
								<div class="form-group">
									<label><?php echo lang('days');?></label>
									<input type="text" class="form-control" id="extra_leaves" value="<?php echo $extra_leaves['leave_days']; ?>" disabled>
								</div>
							</div>
						</div>
						<div class="leave-right">
							<button class="leave-edit-btn" type="button" data-typ="extras_leaves"><?php echo lang('edit');?></button>
						</div>
					</div>
				</div>
			</div>


			<!-- Dynamic Leave TYpes -->
		<?php } } ?>
			
		</div>
	</div>


<!-- Add Custom Policy Modal -->
<div id="add_custom_policy" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('add_custom_policy'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="policy_custom_form" method="post" action="<?php echo base_url(); ?>leave_settings/add_custom_policy">
					<div class="form-group">
						<label><?php echo lang('policy_name');?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="policy_name" id="policy_name">
					</div>
					<div class="form-group">
						<label><?php echo lang('days');?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="policy_days" id="policy_days">
					</div>
					<input type="hidden" name="policy_id" id="policy_id" value="">
					<div class="form-group leave-duallist">
						<label><?php echo lang('add_employee');?></label>
						<div class="row">
							<div class="col-lg-5 col-sm-5 col-xs-12">
								<select name="customleave_from" id="customleave_select" class="form-control" size="5" multiple="multiple">
									<?php foreach($all_employees as $employee){ ?>
										<option value="<?php echo $employee['user_id']; ?>"><?php echo $employee['fullname']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="multiselect-controls col-lg-2 col-sm-2 col-xs-12">
								<button type="button" id="customleave_select_rightAll" class="btn btn-block btn-white"><i class="fa fa-forward"></i></button>
								<button type="button" id="customleave_select_rightSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-right"></i></button>
								<button type="button" id="customleave_select_leftSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-left"></i></button>
								<button type="button" id="customleave_select_leftAll" class="btn btn-block btn-white"><i class="fa fa-backward"></i></button>
							</div>
							<div class="col-lg-5 col-sm-5 col-xs-12">
								<select name="customleave_to" id="customleave_select_to" class="form-control" size="8" multiple="multiple"></select>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<a class="btn btn-primary submit-btn PolicyBtn"><?php echo lang('submit');?></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Custom Policy Modal -->
<?php 

$custom_policy = $this->db->get_where('common_leave_types',array('leave_keys'=>'custom_policy_annual','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

$all_users = $this->db->get_where('custom_policy',array('leave_id'=>$custom_policy['leave_id']))->result_array(); 
								foreach($all_users as $user){
									$users_all = $this->db->select('*')
													         ->from('assigned_policy_user AU')
													         ->join('account_details AD','AU.user_id = AD.user_id')
													         ->where('AU.policy_id',$user['policy_id'])
													         ->get()->result_array();
									foreach($users_all as $al_user)
									{
							?>
		<!-- Edit Custom Policy Modal -->
		<div id="edit_custom_policy<?php echo $user['policy_id'].$al_user['user_id']; ?>" class="modal custom-modal fade" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?php echo lang('edit_custom_policy');?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" action="<?php echo base_url(); ?>leave_settings/update_policy_user/<?php echo $al_user['assigned_id']; ?>">
							<div class="form-group">
								<label><?php echo lang('policy_name');?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="policy_name" value="<?php echo $user['custom_policy_name']; ?>" readonly>
							</div>
							<div class="form-group">
								<label><?php echo lang('days');?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="policy_days" value="<?php echo $user['policy_leave_days']; ?>">
							</div>
							<div class="form-group leave-duallist">
								<label><?php echo lang('add_employee');?></label>
								<div class="row">
									<div class="col-lg-5 col-sm-5 col-xs-12">
										<select name="edit_customleave_from" id="edit_customleave_select<?php echo $al_user['assigned_id']; ?>" class="form-control EditSelectEmployee" size="5" multiple="multiple">
											<?php foreach($all_employees as $employee){ ?>
												<option value="<?php echo $employee['user_id']; ?>"><?php echo $employee['fullname']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="multiselect-controls col-lg-2 col-sm-2 col-xs-12">
										<button type="button" id="edit_customleave_select<?php echo $al_user['assigned_id']; ?>_rightAll" class="btn btn-block btn-white"><i class="fa fa-forward"></i></button>
										<button type="button" id="edit_customleave_select<?php echo $al_user['assigned_id']; ?>_rightSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-right"></i></button>
										<button type="button" id="edit_customleave_select<?php echo $al_user['assigned_id']; ?>_leftSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-left"></i></button>
										<button type="button" id="edit_customleave_select<?php echo $al_user['assigned_id']; ?>_leftAll" class="btn btn-block btn-white"><i class="fa fa-backward"></i></button>
									</div>
									<div class="col-lg-5 col-sm-5 col-xs-12">
										<select name="customleave_to" id="edit_customleave_select<?php echo $al_user['assigned_id']; ?>_to" class="form-control EditSelectUsers" size="8" multiple="multiple">
											<option value="<?php echo $al_user['user_id']; ?>"><?php echo $al_user['fullname']; ?></option>
										</select>
									</div>
								</div>
							</div>

							<div class="submit-section">
								<a class="btn btn-primary submit-btn EditAssignee" data-id="<?php echo $al_user['assigned_id']; ?>"><?php echo lang('submit');?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/multiselect.min.js"></script>
		<script type="text/javascript">
			if($('#edit_customleave_select<?php echo $al_user['assigned_id']; ?>').length > 0) {
				$('#edit_customleave_select<?php echo $al_user['assigned_id']; ?>').multiselect();
			}
		</script>
		<!-- /Edit Custom Policy Modal -->

<!-- Delete Custom Policy Modal -->
<div class="modal custom-modal center-modal fade" id="delete_custom_policy" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3><?php echo lang('delete_custom_policy');?></h3>
					<p><?php echo lang('are_you_sure_want_to_delete');?></p>
				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-6">
							<a href="javascript:void(0);" class="btn btn-primary continue-btn DeleteBtn"  id="delete_custom_policys"><?php echo lang('delete');?></a>
						</div>
						<div class="col-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?php echo lang('cancel');?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		<?php } } ?>
<!-- /Delete Custom Policy Modal -->

<!-- New Leave Type Model -->

<div id="new_leave_type" class="modal custom-modal center-modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('new_leave_type');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="newtype_leave_form" method="post" action="<?php echo base_url(); ?>leave_settings/add_new_leave_type">
					<div class="form-group">
						<label><?php echo lang('leave_type_name');?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" name="leave_type_name" id="leave_type_name">
					</div>
					<div class="form-group">
						<label><?php echo lang('days');?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" name="leave_days" id="leave_days">
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn"><?php echo lang('submit');?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



<div id="delete_newpolicy" class="modal custom-modal center-modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('delete_leave_type');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="newtype_leave_form" method="post" action="<?php echo base_url(); ?>leave_settings/add_new_leave_type">
					<div class="form-group">
						<label><?php echo lang('leave_type_name');?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" name="leave_type_name" id="leave_type_name">
					</div>
					<div class="form-group">
						<label><?php echo lang('days');?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" name="leave_days" id="leave_days">
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn"><?php echo lang('submit');?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>