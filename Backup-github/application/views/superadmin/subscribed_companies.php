<?php $all_subscribers = $this->db->get('subscribers')->result_array(); ?>
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Subscription</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Subscription</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
			
					<div class="row">
						<div class="col-md-3">
							<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6>Joining</h6>
										<h4><?php echo count($all_subscribers); ?> <span>This Month</span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6>Renewal</h6>
										<h4>0 <span>This Month</span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6>Renewal</h6>
										<h4>0 <span>Next Month</span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
						<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6>Total Companies</h6>
										<h4><?php echo count($all_subscribers); ?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
						
					<!--Plan Details Table-->
					<div class="row">
						<div  class="col-md-12">
							<div class="card">
								<div class="card-body">
								<h3 class="card-title text-left">Plan Transactions</h3>
									<div class="table-responsive">
										<table id="table-subscribers" class="table table-bordered table-striped custom-table m-b-0 AppendDataTables" >
											<thead>
												<tr>
											<th>#</th>
											<th>Client</th>
											<th>Users</th>
											<th>Start Date</th>
											<th>Country</th>
											
											<th>Plan Status</th>
											
										</tr>
											</thead>
											<tbody>
												<?php  

												// echo "<pre>"; print_r($all_subscribers); exit;
												if(count($all_subscribers) != 0){
													$e = 1;
													foreach($all_subscribers as $subscribers){

														// $plan_details = $this->db->get_where('subscription_plans',array('plan_id'=>$subscribers['plan_id']))->row_array();
														if($subscribers['currency'] == 'usd'){
															$currency = '$';
														}else{
															$currency = '€';
														}
												?>
												<tr>
													<td><?php echo $e; ?></td>
													<td>
														<h2 class="table-avatar">
															<a href="#" class="avatar"><img src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-19.jpg" alt=""></a>
															<a href="#"><?php echo ucfirst($subscribers['company_name']); ?></a>
														</h2>
													</td>
													<td><?php echo $subscribers['user_count']; ?></td>
													<td><?php echo date('d M Y',strtotime($subscribers['created_at'])); ?></td>
													<td><?php echo ucfirst($subscribers['country']); ?></td>
													<td><span class="badge bg-inverse-success">Active</span></td>
													
												</tr>
											<?php $e++; } }else{ ?> 
												<tr>
													<td>No Subscribers</td>
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
						  
        