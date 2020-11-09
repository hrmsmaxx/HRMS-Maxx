<div class="modal-dialog modal-md modal-dialog-centered">
									<div class="modal-content">
										<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
										<div class="modal-body">
											<h5 class="modal-title text-center mb-3">Edit Plan</h5>
											<form method="post" id="EditPlanForm" action="<?php echo base_url(); ?>superadmin/edit_plan/<?php echo $all_subscription['plan_id']; ?>">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('plan_name');?> <span class="text-danger">*</span></label>
															<input type="text" placeholder="Plan Name" name="plan_name" id="plan_name" class="form-control" value="<?php echo $all_subscription['plan_name']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('plan_amount');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="plan_amount" id="plan_amount" placeholder="Plan Amount" value="<?php echo $all_subscription['plan_amount']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('plan_type');?> <span class="text-danger">*</span></label>
															<select class="select" name="plan_type" id="plan_type"> 
																<option value="" disabled>Choose Plan</option>
																<option value="month" <?php if($all_subscription['plan_type'] == 'month'){ echo "selected"; } ?> ><?php echo lang('month');?></option>
																<option value="year" <?php if($all_subscription['plan_type'] == 'year'){ echo "selected"; } ?>><?php echo lang('year'); ?></option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('no_of_users');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_users" id="no_of_users" placeholder="No of Users" value = "<?php echo $all_subscription['users_count']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('no_of_projects');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_projects" id="no_of_projects" placeholder="No of Projects" value="<?php echo $all_subscription['projects_count']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('addtional_employee_rate');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="addtional_employee_rate" id="addtional_employee_rate" placeholder="Per user" value="<?php echo $all_subscription['addtional_employee_rate']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('no_of_storage_space');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_storage" id="no_of_storage" placeholder="No of Storage Space" value="<?php echo $all_subscription['storage_count']; ?>" >
														</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block"><?php echo lang('customer_support');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="support" id="add_customer_support" class="check" <?php if($all_subscription['support'] == 1){ echo "checked"; } ?> >
															<label for="add_customer_support" class="checktoggle">checkbox</label>
														</div>
													</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block"><?php echo lang('voice_video_call');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="voice_video_call" id="voice_video_call" class="check" <?php if($all_subscription['video_voice'] == 1){ echo "checked"; } ?>>
															<label for="voice_video_call" class="checktoggle">checkbox</label>
														</div>
													</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block"><?php echo lang('unlimited_messages');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="unlimited_messages" id="unlimited_messages" class="check" <?php if($all_subscription['messages'] == 1){ echo "checked"; } ?> >
															<label for="unlimited_messages" class="checktoggle">checkbox</label>
														</div>
													</div>
												</div>
												</div>
												<div class="form-group">
													<label><?php echo lang('plan_description');?> <span class="text-danger">*</span></label>
													<textarea class="form-control" name="description" rows="4" cols="30"><?php echo $all_subscription['description']; ?></textarea>
												</div>
												<div class="form-group">
													<label class="d-block"><?php echo lang('status');?></label>
													<div class="status-toggle">
														<input type="checkbox" name="status" id="add_plan_status" class="check" <?php if($all_subscription['status'] == 1){ echo "checked"; } ?>>
														<label for="add_plan_status" class="checktoggle">checkbox</label>
													</div>
												</div>
												<div class="m-t-20 text-center">
													<button class="btn btn-primary submit-btn PlansEditBtn" data-pid="<?php echo $all_subscription['plan_id']; ?>">Save</button>
												</div>
											</form>
										</div>
									</div>
								</div>