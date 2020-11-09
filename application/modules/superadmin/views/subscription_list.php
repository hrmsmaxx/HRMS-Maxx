

			
			<!-- Page Wrapper -->
            <div class="page-wrapper" style="padding-top:35px">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="page-title"><?php echo lang('subscription'); ?></h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html"><?php echo lang('dashboard'); ?></a></li>
									<li class="breadcrumb-item active"><?php echo lang('subscription'); ?></li>
								</ul>
							</div>
							<?php if((count($monthly_subscription_list) < 3) || (count($yearly_subscription_list) < 3)){ ?>
								<div class="col-sm-6 text-right">
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add_plan"><i class="fa fa-plus"></i><?php echo lang('add_subscription'); ?> </a>
								</div>
							<?php }  ?>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-lg-10 mx-auto">
							<div class="row justify-content-center mb-4">
								<div class="col-auto">
									<nav class="nav btn-group">
										<a href="#monthly" class="btn btn-outline-primary show active" data-toggle="tab"><?php echo lang('semestral_plan'); ?></a>
										<a href="#annual" class="btn btn-outline-primary" data-toggle="tab"><?php echo lang('annual_plan'); ?></a>
									</nav>
								</div>
							</div>
						
					<!-- Plan Tab Content -->
							<div class="tab-content">
							
								<!-- Monthly Tab -->
								<div class="tab-pane fade active show" id="monthly">
									<div class="row mb-30 equal-height-cards">

										<?php if(count($monthly_subscription_list) != 0){
												if(count($monthly_subscription_list) < 4){
													$cls = 4;
												}
												if(count($monthly_subscription_list) == 4){
													$cls = 3;
												}
												foreach($monthly_subscription_list as $subscription){ ?>


										<div class="col-md-<?php echo $cls; ?>  d-flex">
											<div class="card flex-fill">
												<div  class="card-body img-bg-card d-flex flex-column">
													<h2 class="card-title text-center"><?php echo ucfirst($subscription['plan_name']); ?></h2>
													<hr class="hr-text" data-content="&">
													<h2 class="text-center"><span class="plan-amount">$<?php echo $subscription['plan_amount']; ?></span></h2>
													<p class="plan-vali"> <?php echo lang('per_month'); ?></p>
													 
													<div class="box">
														<div class="arrow-top">
															<ul>
																<li><b><span class="text-dark mr-1"><?php echo $subscription['users_count']; ?></span></b> <?php echo lang('employees'); ?></li>
																<li><b><span class="text-dark mr-1"><?php echo $subscription['projects_count']; ?></span></b> <?php echo lang('projects'); ?></li>
																<li><b><span class="text-dark mr-1"><?php echo $subscription['storage_count']; ?>  <?php echo lang('gb'); ?></span></b> <?php echo lang('storage'); ?></li>
																<?php if($subscription['messages'] == '1'){ ?>
																	<li> <?php echo lang('unlimited_messages'); ?></li>
																<?php } ?>
																<?php if($subscription['support'] == '1'){ ?>
																	<li> <?php echo lang('24/7_customer_support'); ?></li>
																<?php } ?>
																<?php if($subscription['video_voice'] == '1'){ ?>
																	<li> <?php echo lang('voice_video_call'); ?></li>
																<?php } ?>
															</ul>
														</div>
														<div class="plan-content-box">
														</div>
													</div>
													<div class="sub-btn text-center mt-auto">
														<a href="#" class="btn btn-primary btn-block  mt-4" data-toggle="modal" data-target="#edit_plan<?php echo $subscription['plan_id']; ?>"><?php echo lang('edit_now'); ?> </a>
														<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
													</div>
												</div>
											</div>
										</div>

										<?php	}
										} ?>

									</div>
								</div>
								<!-- /Monthly Tab -->
							
								<!-- Yearly Tab -->
								<div class="tab-pane fade" id="annual">
									<div class="row mb-30 equal-height-cards">

										<?php if(count($yearly_subscription_list) != 0){
												if(count($yearly_subscription_list) < 4){
													$cls = 4;
												}
												if(count($yearly_subscription_list) == 4){
													$cls = 3;
												}
												foreach($yearly_subscription_list as $subscription_yr){ ?>

												<div class="col-md-<?php echo $cls; ?> d-flex">
													<div class="card flex-fill">
														<div  class="card-body img-bg-card d-flex flex-column">
															<h2 class="card-title text-center"><?php echo ucfirst($subscription_yr['plan_name']); ?></h2>
															<hr class="hr-text" data-content="&">
															<h2 class="text-center"><span class="plan-amount">$<?php echo $subscription_yr['plan_amount']; ?></span></h2>
															<p class="plan-vali"> <?php echo lang('per_annual'); ?></p>
															 
															<div class="box">
																<div class="arrow-top">
																	<ul>
																		<li><b><span class="text-dark mr-1"><?php echo $subscription_yr['users_count']; ?></span></b> <?php echo lang('employees'); ?></li>
																		<li><b><span class="text-dark mr-1"><?php echo $subscription_yr['projects_count']; ?></span></b> <?php echo lang('projects'); ?></li>
																		<li><b><span class="text-dark mr-1"><?php echo $subscription_yr['storage_count']; ?>  GB</span></b> Storage</li>
																		<?php if($subscription_yr['messages'] == '1'){ ?>
																			<li> <?php echo lang('unlimited_message'); ?></li>
																		<?php } ?>
																		<?php if($subscription_yr['support'] == '1'){ ?>
																			<li> <?php echo lang('voice_video_call'); ?></li>
																		<?php } ?>
																		<?php if($subscription_yr['video_voice'] == '1'){ ?>
																			<li> <?php echo lang('24/7_customer_support'); ?></li>
																		<?php } ?>
																	</ul>
																</div>
																<div class="plan-content-box">
																</div>
															</div>
															<div class="sub-btn text-center mt-auto">
																<a href="#" class="btn btn-primary btn-block mt-4" data-toggle="modal" data-target="#edit_plan<?php echo $subscription_yr['plan_id']; ?>"><?php echo lang('edit_now'); ?> </a>
																<span class="float-right"><img width="20" class="img-fluid" alt="" src="<?php echo base_url();?>superadmin_assets/img/ok-img.png"></span>
															</div>
														</div>
													</div>
												</div>

										<?php	}
										} ?>
									</div>
								</div>
								<!-- Yearly Tab -->
								
							</div>
							</div>
					</div>
					<!-- /Plan Tab Content -->
				</div>			
			</div>
			<!-- /Page Wrapper -->
			<!-- Add Plan Modal -->
							<div class="modal custom-modal fade" id="add_plan" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-md modal-dialog-centered">
									<div class="modal-content">
										<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
										<div class="modal-body">
											<h5 class="modal-title text-center mb-3"><?php echo lang('add_plan');?></h5>
											<form method="post" id="AddPlanForm">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('plan_name');?> <span class="text-danger">*</span></label>
															<input type="text" placeholder="Plan Name" name="plan_name" id="plan_name" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('plan_amount');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="plan_amount" id="plan_amount" placeholder="Plan Amount">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('plan_type');?> <span class="text-danger">*</span></label>
															<select class="select" name="plan_type" id="plan_type"> 
																<option value="" selected disabled>Choose Plan</option>
																<option value="month">Semestral</option>
																<option value="year"><?php echo lang('year');?></option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('no_of_users');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_users" id="no_of_users" placeholder="No of Users">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('no_of_projects');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_projects" id="no_of_projects" placeholder="No of Projects">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('addtional_employee_rate');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="addtional_employee_rate" id="addtional_employee_rate" placeholder="Per user">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?php echo lang('no_of_storage_space');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_storage" id="no_of_storage" placeholder="No of Storage Space">
														</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block"><?php echo lang('customer_support');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="support" id="add_customer_support" class="check">
															<label for="add_customer_support" class="checktoggle">checkbox</label>
														</div>
													</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block"><?php echo lang('voice_video_call');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="voice_video_call" id="voice_video_call" class="check">
															<label for="voice_video_call" class="checktoggle">checkbox</label>
														</div>
													</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block"><?php echo lang('unlimited_messages');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="unlimited_messages" id="unlimited_messages" class="check" checked>
															<label for="unlimited_messages" class="checktoggle">checkbox</label>
														</div>
													</div>
												</div>
												</div>
												<div class="form-group">
													<label><?php echo lang('plan_description');?> <span class="text-danger">*</span></label>
													<textarea class="form-control" name="description" rows="4" cols="30"></textarea>
												</div>
												<!-- <div class="form-group">
													<label class="d-block"><?php echo lang('status');?></label>
													<div class="status-toggle">
														<input type="checkbox" name="status" id="add_plan_status" class="check" checked>
														<label for="add_plan_status" class="checktoggle">checkbox</label>
													</div>
												</div> -->
												<div class="m-t-20 text-center">
													<button class="btn btn-primary submit-btn" id="AddPlanBtn"><?php echo lang('submit');?></button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- /Add Plan Modal -->


							<?php foreach($subscription_list as $all_subscription){ ?>



							<!-- Edit Plan Modal -->
							<div class="modal custom-modal fade" id="edit_plan<?php echo $all_subscription['plan_id']; ?>" role="dialog">
								<div class="modal-dialog modal-md modal-dialog-centered">
									<div class="modal-content">
										<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
										<div class="modal-body">
											<h5 class="modal-title text-center mb-3">Edit Plan</h5>
											<form method="post" id="EditPlanForm" action="<?php echo base_url(); ?>superadmin/edit_plan/<?php echo $all_subscription['plan_id']; ?>">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo lang('plan_name');?> <span class="text-danger">*</span></label>
															<input type="text" placeholder="Plan Name" name="plan_name" id="plan_name" class="form-control" value="<?php echo $all_subscription['plan_name']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo lang('plan_amount');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="plan_amount" id="plan_amount" placeholder="Plan Amount" value="<?php echo $all_subscription['plan_amount']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo lang('plan_type');?> <span class="text-danger">*</span></label>
															<select class="select" name="plan_type" id="plan_type"> 
																<option value="" disabled>Choose Plan</option>
																<option value="month" <?php if($all_subscription['plan_type'] == 'month'){ echo "selected"; } ?> >Semestral</option>
																<option value="year" <?php if($all_subscription['plan_type'] == 'year'){ echo "selected"; } ?>><?php echo lang('year'); ?></option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo lang('no_of_users');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_users" id="no_of_users" placeholder="No of Users" value = "<?php echo $all_subscription['users_count']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo lang('no_of_projects');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_projects" id="no_of_projects" placeholder="No of Projects" value="<?php echo $all_subscription['projects_count']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo 'Additional Employee Rate'; ?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="addtional_employee_rate" id="addtional_employee_rate" placeholder="Per user" value="<?php echo $all_subscription['addtional_employee_rate']; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="font-weight-bold"><?php echo lang('no_of_storage_space');?> <span class="text-danger">*</span></label>
															<input type="text" class="form-control" name="no_of_storage" id="no_of_storage" placeholder="No of Storage Space" value="<?php echo $all_subscription['storage_count']; ?>" >
														</div>
													</div>
													<div class="col-md-6">
													<div class="form-group">
														<label class="d-block font-weight-bold"><?php echo lang('customer_support');?></label>
														<div class="status-toggle">
															<input type="checkbox" name="customer_support" id="customer_support" class="check" <?php if($all_subscription['support'] == 1){ echo "checked"; } ?> >
															<label for="customer_support" class="checktoggle">checkbox</label>
														</div>
													</div>
													</div>
													<div class="col-md-12">
													<div class="form-group">
														<label class="d-block font-weight-bold"><?php echo lang('menus');?></label>
													</div>
													</div>

													<?php 
													 $this->db->where("plan_id LIKE '%".$all_subscription['plan_id']."%'");									                
													$menus =$this->db->get('plan_menus')->result_array(); ?>
													<?php $i= 0; foreach ($menus as $menu) {?>
													<div class="col-md-6">
													<div class="form-group">														
														<p><?php echo ucfirst($menu['name']); ?></p>		
														<div class="status-toggle">
															<input type="checkbox" name="menu_name" onclick="menu_function('<?php echo $menu['id'];?>','<?php echo $menu['status'];?>')" data-id="<?php echo $menu['id'];?>" id="add_menu_name_<?php echo $menu['id'];?>" class="check" <?php if($menu['status'] == 1){ echo "checked"; } ?> value="<?php echo $menu['status'];?>">
															<label for="add_menu_name_<?php echo $menu['id'];?>" class="checktoggle">checkbox</label>
														</div>												
													</div>
													</div>
													<?php $i++;} ?>
													<!-- <div class="col-md-6">
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
												</div> -->
												</div>
												<div class="form-group">
													<label class="font-weight-bold"><?php echo lang('plan_description');?> <span class="text-danger">*</span></label>
													<textarea class="form-control" name="description" rows="4" cols="30"><?php echo $all_subscription['description']; ?></textarea>
												</div>
												<div class="form-group">
													<label class="d-block font-weight-bold"><?php echo lang('status');?></label>
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
							</div>
							<!-- /Edit Plan Modal -->
						<?php } ?>

		
		