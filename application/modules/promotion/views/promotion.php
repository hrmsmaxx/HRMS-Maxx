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

							<li>

								<a href="<?php echo base_url(); ?>termination"><?php echo lang('termination');?></a>

							</li>

							<li class="active">

								<a href="<?php echo base_url(); ?>promotion"><?php echo lang('promotion');?></a>

							</li>

						</ul>

						

					<!-- Page Title -->

					<div class="row">

						<div class="col-sm-5">

							<h3><?php echo lang('promotion');?></h3>

						</div>

						<div class="col-sm-7 text-right m-b-30">

							<a href="#" class="btn add-btn" onclick="add_promotion()"><i class="fa fa-plus"></i><?php echo lang('add_promotion');?></a>

						</div>

					</div>

					<!-- /Page Title -->

					

					<div class="row">

						<div class="col-md-12">

							<div class="table-responsive">

								<table class="table table-striped custom-table mb-0 datatable AppendDataTables" id="promotion_table">

									<thead>

										<tr>

											<th style="width: 30px;">#</th>

											<th><?php echo lang('promoted_employee');?></th>

											<th><?php echo lang('department');?></th>

											<th><?php echo lang('promotion_from');?></th>

											<th><?php echo lang('promotion_to');?></th>

											<th><?php echo lang('promotion_date');?></th>

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

				

				<!-- Add Promotion Modal -->

				<div id="add_promotion" class="modal custom-modal fade" role="dialog">

					<div class="modal-dialog modal-dialog-centered" role="document">

						<div class="modal-content">

							<div class="modal-header">

								<h5 class="modal-title"><?php echo lang('add_promotion');?></h5>

								<button type="button" class="close" data-dismiss="modal" aria-label="Close">

									<span aria-hidden="true">&times;</span>

								</button>

							</div>

							<div class="modal-body">

								<form action="#"  id="add_promotions" method="post" enctype="multipart/form-data" data-parsley-validate novalidate > 

									<input type="hidden" name="id">

									<div class="form-group">

										<label><?php echo lang('promotion_for');?> <span class="text-danger">*</span></label>

										<select class="select2-option" style="width:100%;" name="employee" id="employee_id" > 

											<option value="">--<?php echo lang('select');?>--</option>

										<?php foreach (User::employee() as $key => $user) { 
												if($user->subdomain_id == $this->session->userdata('subdomain_id')){
											?>

										<option value="<?php echo $user->id;?>"><?=ucfirst(User::displayName($user->id))?></option>

										<?php } } ?>

									   </select>

									</div>

									<div class="form-group">

										<label><?php echo lang('promotion_from');?> <span class="text-danger">*</span></label>

										<input class="form-control" id="designation" name="designation" type="hidden" readonly>

										<input class="form-control" id="grade" name="grade" type="hidden"  readonly>

										<input class="form-control" id="grade_name" name="grade_name" type="text"  readonly>

									</div>

									<div class="form-group">

										<label><?php echo lang('promotion_to');?> <span class="text-danger">*</span></label>

										<select class="select2-option" id="promotionto" style="width:100%;" name="promotionto" >

											<option value="">--<?php echo lang('select');?>--</option>

										</select>

									</div>

									<div class="form-group">

										<label><?php echo lang('promotion_date');?> <span class="text-danger">*</span></label>

										<div class="cal-icon">

											<input type="text" id="promotiondate" name="promotiondate" class="form-control datetimepicker">

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

				<!-- /Add Promotion Modal -->

				

				

				

				<!-- Delete Promotion Modal -->

				<div class="modal custom-modal fade" id="delete_promotion" role="dialog">

					<div class="modal-dialog modal-dialog-centered">

						<div class="modal-content">

							<div class="modal-body">

								<div class="form-head">

									<h3>Delete Promotion</h3>

									<p>Are you sure want to delete?</p>

								</div>

								<div class="modal-btn delete-action">

									<div class="row">

										<div class="col-xs-6">

											<a href="javascript:void(0);" id="delete_promotions" class="btn btn-primary continue-btn">Delete</a>

										</div>

										<div class="col-xs-6">

											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- /Delete Promotion Modal -->