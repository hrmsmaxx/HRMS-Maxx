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
							<li class="active">
								<a href="<?php echo base_url(); ?>resignation"><?php echo lang('resignation');?></a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>termination"><?php echo lang('termination');?></a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>promotion"><?php echo lang('promotion');?></a>
							</li>
						</ul>
						
					<!-- Page Title -->
					<div class="row">
						<div class="col-sm-8">
							<h3><?php echo lang('resignation');?></h3>
						</div>
						<div class="col-sm-4 text-right m-b-30">
							<a href="#" class="btn add-btn" onclick="add_resignation()"><i class="fa fa-plus"></i> <?php echo lang('add_resignation');?></a>
						</div>
					</div>
					<!-- /Page Title -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable" id="resignation_table">
									<thead>
										<tr>
											<th style="width: 30px;">#</th>
											<th><?php echo lang('resigning_employee');?></th>
											<th><?php echo lang('department');?></th>
											<th><?php echo lang('reason');?></th>
											<th><?php echo lang('notice_date');?></th>
											<th><?php echo lang('resignation_date');?> </th>
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
				
				<!-- Add Resignation Modal -->
				<div id="add_resignation" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('add_resignation');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="#"  id="add_resignations" method="post" enctype="multipart/form-data" data-parsley-validate novalidate > 
									<input type="hidden" name="id">
									<div class="form-group">
										<label><?php echo lang('resigning_employee');?><span class="text-danger">*</span></label>
										<select class="select2-option" style="width:100%;" name="employee" id="employee_id" > 
										<?php foreach (User::employee() as $key => $user) { ?>
										<option value="<?php echo $user->id;?>"><?=ucfirst(User::displayName($user->id))?></option>
										<?php } ?>
									   </select>
									</div>
									<div class="form-group">
										<label><?php echo lang('notice_date');?><span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input type="text" name="noticedate" id="noticedate" class="form-control datetimepicker">
										</div>
									</div>
									<div class="form-group">
										<label><?php echo lang('resignation_date');?> <span class="text-danger">*</span></label>
										<div class="cal-icon">
											<input type="text" name="resignationdate" id="resignationdate" class="form-control datetimepicker">
										</div>
									</div>
									<div class="form-group">
										<label><?php echo lang('reason');?> <span class="text-danger">*</span></label>
										<textarea class="form-control" name="reason" id="reason" rows="4"></textarea>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="btnSave"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Resignation Modal -->
				
				
				
				<!-- Delete Resignation Modal -->
				<div class="modal custom-modal fade" id="delete_resignation" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-head">
									<h3><?php echo lang('delete_resignation');?></h3>
									<p><?php echo lang('are_you_sure_want_to_delete');?></p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-xs-6">
											<a href="javascript:void(0);" id="delete_resignations" class="btn btn-primary continue-btn"><?php echo lang('delete');?></a>
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
				<!-- /Delete Resignation Modal -->