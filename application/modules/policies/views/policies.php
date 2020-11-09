				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Title -->
					<div class="row">
						<div class="col-xs-12">
							<h4 class="page-title"><?php echo lang('all_policies');?></h4>
						</div>
					</div>
    				<?php $this->load->view('sub_menus');?>					
					
					<div class="card-box">
					<div class="row">
						<div class="col-sm-5 col-5">
							<h4 class="page-title"><?php echo lang('all_policies');?></h4>
						</div>
						<?php
						if($role!=3)
						{?>
							<div class="col-sm-7 col-7 text-right m-b-30">
							<a href="#" class="btn add-btn"  onclick="add_policies()"  ><i class="fa fa-plus"></i> <?php echo lang('add_policy');?></a>
						</div>

						<?php }
						
						?>
						
					</div>
					<!-- /Page Title -->
					
					<div class="row">
						<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped custom-table m-b-0" id="policies_table">
								<thead>
									<tr>
										<th style="width: 30px;"><b>#</b></th>
										<th><b><?php echo lang('policy_name');?> </b></th>
										<th><b><?php echo lang('department');?></b></th>
										<th><b><?php echo lang('description');?> </b></th>
										<th><b><?php echo lang('created');?> </b></th>
										<th class="text-right no-sort"><b><?php echo lang('cction');?></b></th>
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
				<div id="view_policy" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-titleview"><?php echo lang('full_policy_view');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label id="full_view"></label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Add Policy Modal -->
				<div id="add_policy" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('add_policy');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="#"  id="add_policies" method="post" enctype="multipart/form-data" data-parsley-validate novalidate > 
									 <input type="hidden" value="" name="id"/> 
									<div class="form-group">
										<label><?php echo lang('policy_name');?> <span class="text-danger">*</span></label>
										<input class="form-control" name="policyname" id="policyname" type="text">
									</div>
									<div class="form-group">
										<label><?php echo lang('description');?> <span class="text-danger">*</span></label>
										<textarea class="form-control" name="description" id="description" rows="4"></textarea>
									</div>
									<div class="form-group">
										<label class="col-form-label"><?php echo lang('department');?> <span class="text-danger">*</span></label>
										<select class="select2-option" multiple style="width:100%;" name="department[]" id="department" >
										<option value="00"><?php echo lang('all_department');?></option> 
										<?php foreach (Client::get_all_departments() as $department) { ?>
										<option value="<?php echo $department->deptid; ?>"><?php echo $department->deptname; ?></option>
										<?php } ?>
									   </select>
									</div>
									<div class="form-group">
										<label><?php echo lang('upload_policy');?> </label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="policy_upload" id="policy_upload">
											<input type="hidden" name="policy_files" id="policy_files">
											<label class="custom-file-label" for="policy_upload"><?php echo lang('choose_file');?> </label>
										</div>
									</div>
									<div class="form-group">
										 <div class="upload_details"></div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="btnSave" type="submit"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Policy Modal -->
				
		
				
				<!-- Delete Policy Modal -->
				<div class="modal custom-modal fade" id="delete_policy" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3><?php echo lang('all_department');?></h3>
									<p><?php echo lang('are_you_sure_want_to_delete');?></p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-sm-6">
											<a href="javascript:void(0);" id="delete_policies" class="btn btn-primary continue-btn"><?php echo lang('delete');?></a>
										</div>
										<div class="col-sm-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?php echo lang('cancel');?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Delete Policy Modal -->