				<!-- Page Content -->
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="page-title"><?php echo lang('all_policies');?></h4>
						</div>
					</div>
    			<?php $this->load->view('sub_menus');?>	
					
					
					<div class="card-box">

						<ul class="nav nav-tabs nav-tabs-bottom page-sub-tabs m-b-30">
							<li>
								<a href="<?php echo base_url(); ?>resignation"><?php echo lang('resignation');?></a>
							</li>
							<li class="active">
								<a href="<?php echo base_url(); ?>termination"><?php echo lang('termination');?></a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>promotion"><?php echo lang('promotion');?></a>
							</li>
						</ul>
						
					<!-- Page Title -->
					<div class="row">
						<div class="col-sm-5">
							<h3><?php echo lang('termination');?></h3>
						</div>
						<div class="col-sm-7 text-right m-b-30">
							<a href="#" class="btn add-btn" onclick="add_termination()"><i class="fa fa-plus"></i> <?php echo lang('add_termination');?></a>
						</div>
					</div>
					<!-- /Page Title -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable" id="termination_table">
									<thead>
										<tr>
											<th style="width: 30px;">#</th>
											<th><?php echo lang('terminated_employee');?></th>
											<th><?php echo lang('department');?></th>
											<th><?php echo lang('termination_type');?> </th>
											<th><?php echo lang('termination_date');?></th>
											<th><?php echo lang('reason');?></th>
											<th><?php echo lang('last_date');?></th>
											<th class="text-right"><?php echo lang('action');?></th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
                </div>
				<!-- /Page Content -->
				
				<!-- Add Termination Modal -->
				<div id="add_termination" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('add_termination');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="#"  id="add_terminations" method="post" enctype="multipart/form-data" data-parsley-validate novalidate > 
									<input type="hidden" name="id">
									<div class="form-group">
										<label><?php echo lang('terminated_employee');?> <span class="text-danger">*</span></label>
										<select class="select2-option" style="width:100%;" name="employee" id="employee_id" > 
										<option value=""><?php echo lang('select_employee'); ?></option>
										<?php foreach (User::employee() as $key => $user) { ?>
										<option value="<?php echo $user->id;?>"><?=ucfirst(User::displayName($user->id))?></option>
										<?php } ?>
									   </select>
									</div>
									<div class="form-group">
										<label><?php echo lang('termination_type');?> <span class="text-danger">*</span></label>
										<div class="add-group-btn">
											<select class="select termination_type" name="termination_type" id="termination_type">
												
											</select>
											<a class="btn btn-primary" href="" data-toggle="modal" data-target="#add_termination_type_modal"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
										</div>
									</div>
									<div class="form-group">
										<label><?php echo lang('termination_date');?> <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input type="text" id="terminationdate" name="terminationdate"  class="form-control datetimepicker">
										</div>
									</div>
									<div class="form-group">
										<label><?php echo lang('reason');?> <span class="text-danger">*</span></label>
										<textarea name="reason" id="reason" class="form-control" rows="4"></textarea>
									</div>
									<div class="form-group">
										<label><?php echo lang('last_date');?><span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input type="text" id="lastdate" name="lastdate" class="form-control datetimepicker">
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="btnSave"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Termination Modal -->
				
				<!-- Edit Termination Modal -->
				<div id="add_termination_type_modal" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('termination_type');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="add_termination_type">
									<div class="form-group">
										<label><?php echo lang('termination_type');?> <span class="text-danger">*</span></label>
										<input class="form-control" id="term_ination_type" name="termination_type" type="text" >
									</div>
									
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="btnSave_t"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Edit Termination Modal -->
				
				<!-- Delete Termination Modal -->
				<div class="modal custom-modal fade" id="delete_termination" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-head">
									<h3><?php echo lang('delete_termination');?></h3>
									<p><?php echo lang('are_you_sure_want_to_delete');?></p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-xs-6">
											<a href="javascript:void(0);" id="delete_terminations" class="btn btn-primary continue-btn"><?php echo lang('delete');?></a>
										</div>
										<div class="col-xs-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?php echo lang('cancel');?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Delete Termination Modal -->