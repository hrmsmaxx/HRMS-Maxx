<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title">Employees Management</h4>
		</div>
	</div>
	<div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li><a href="<?php echo base_url(); ?>organisation">Org Structure</a></li>
			<li><a href="<?php echo base_url(); ?>employees">Employees</a></li>
			<li><a href="<?php echo base_url(); ?>attendance">Time & Attendance</a></li>
			<li><a href="<?php echo base_url(); ?>leaves">Leave</a></li>
			<li><a href="<?php echo base_url(); ?>payroll">Payroll</a></li>
			<li><a href="<?php echo base_url(); ?>resignation">Employees Status</a></li>
			<li><a href="<?php echo base_url(); ?>policies">Policies</a></li>
			<li class="active"><a href="<?php echo base_url(); ?>employees/employee_category">Categories</a></li>
			<li><a href="<?php echo base_url(); ?>employees/vacancy">Vacancy</a></li>
			<li><a href="<?php echo base_url(); ?>notice_board">Notices</a></li>
		</ul>
	</div>
	<div class="card-box">
		<div class="row">
			<div class="col-xs-12 message_notifcation" ></div>
			<div class="col-xs-4">
				<h4 class="page-title">Employment Category</h4>
			</div>
			<div class="col-sm-8 col-9 text-right m-b-20">
				<a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_emp_category"><i class="fa fa-plus"></i> Add Category</a>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0 datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Category</th>
								<th>Employees</th>
								<th>Created</th>
								<th class="text-center">Status</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><?php echo lang('full_time');?></td>
								<td>12</td>
								<td>30 Dec 2019</td>
								<td class="text-center">
									<div class="dropdown action-label">
										<a class="btn btn-white btn-sm rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-dot-circle-o text-success"></i> Active <i class="caret"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a></li>
											<li><a href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a></li>
										</ul>
									</div>
								</td>
								<td class="text-right">
									<div class="dropdown">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
											<li><a href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>

</div>

<div id="add_emp_category" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Supplier</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label>Category Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" autocomplete="off">
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>