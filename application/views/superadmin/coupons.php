<?php 
 $otherdb = $this->load->database('otherdb', TRUE); 
$coupons = $otherdb->get('dgt_coupons')->result_array(); ?>
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Coupons</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Coupons</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
			
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-body ">
									<h3 class="card-title text-left">Coupon Import</h3>
									 <?php
        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');
        echo form_open_multipart('appsumo/appsumo/data_import', $attributes); ?>
            <div class="card-box">
                        
                   
                    
                            <div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Choose upload file<span class="text-danger">*</span></label>
										<input type="file" name="data_import" id="data_import" class="form-control" >
									</div>
								</div>
                            </div>
                        
						<div class="submit-section">
	                        <button id="general_settings_save" class="btn btn-primary submit-btn">Import</button>
						</div>
				</div>
            
        </form>
								</div>
							</div>
						</div>
						
					</div>
						
					<!--Plan Details Table-->
					<div class="row">
						<div  class="col-md-12">
							<div class="card">
								<div class="card-body">
								<h3 class="card-title text-left">Coupon List</h3>
									<div class="table-responsive">
										<table id="table-coupons" class="table-bordered table table-striped custom-table m-b-0 AppendDataTables">
											<thead>
												<tr>
											<th>#</th>
											<th>AppSumo Code</th>
											<!-- <th>Plan</th> -->
											<th>Users</th>
											<th>Status</th>
											
										</tr>
											</thead>
											<tbody>
												<?php  

												// echo "<pre>"; print_r($all_subscribers); exit;
												if(count($coupons) != 0){
													$e = 1;
													foreach($coupons as $coupons){
												?>
												<tr>
													<td><?php echo $e; ?></td>
													<td><?php echo $coupons['appsumo_code']; ?></td>
													<td><?php echo $coupons['user_count']; ?></td>
													<td><?php echo ($coupons['status'] ==0)?'<span class="badge bg-inverse-danger">Not Used</span>':'<span class="badge bg-inverse-success">Used</span>'; ?></td>
													
													
												</tr>
											<?php $e++; } }else{ ?> 
												<tr>
													<td>No Coupons Found</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/Plan Details Table-->
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
					<!-- Upgrade Plan Modal -->
					<div class="modal custom-modal fade" id="upgrade_plan" role="dialog">
						<div class="modal-dialog modal-md modal-dialog-centered">
							<div class="modal-content">
								<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
								<div class="modal-body">
									<h5 class="modal-title text-center mb-3">Upgrade Plan</h5>
									<form>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Plan Name</label>
													<input type="text" placeholder="Free Trial" class="form-control" value="Free Trial">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Amount</label>
													<input type="text" class="form-control" value="$500">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Plan Type</label>
													<select class="select"> 
														<option> Monthly </option>
														<option> Yearly </option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>No of Users</label>
													<select class="select"> 
														<option> 5 Users </option>
														<option> 50 Users </option>
														<option> Unlimited </option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>No of Projects</label>
													<select class="select"> 
														<option> 5 Projects </option>
														<option> 50 Projects </option>
														<option> Unlimited </option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>No of Storage Space</label>
													<select class="select"> 
														<option> 5 GB </option>
														<option> 100 GB </option>
														<option> 500 GB </option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Plan Description</label>
											<textarea class="form-control" rows="4" cols="30"></textarea>
										</div>
										<div class="form-group">
											<label class="d-block">Status</label>
											<div class="status-toggle">
												<input type="checkbox" id="upgrade_plan_status" class="check">
												<label for="upgrade_plan_status" class="checktoggle">checkbox</label>
											</div>
										</div>
										<div class="m-t-20 text-center">
											<button class="btn btn-primary submit-btn">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- /Upgrade Plan Modal -->
						  
        