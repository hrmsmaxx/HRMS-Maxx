<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$this->db->select('s.*');
// $this->db->select('s.*,ac.avatar as profile_pic,ac.id as user_id');
$this->db->from('subscribers s');
$all_subscribers = $this->db->get()->result_array();
?>

<script type="text/javascript">
	function change_status(id,status){
		$.ajax({
			url:'<?php echo base_url(); ?>superadmin/status_change',
			type:'POST',
			data:{'subscribers_id':id,'status':status},
			success:function(response){
				if(response == 'success'){
					toastr.success('Status Upate Success');
				}else{
					toastr.error('Status Upate Faileds');
				}
			}
		});
	}
</script>
			
			<!-- Page Wrapper -->
            <div class="page-wrapper" style="padding-top:35px">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title"><?php echo lang('subscription'); ?></h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a><?php echo lang('dashboard'); ?></a></li>
									<li class="breadcrumb-item active"><?php echo lang('subscription'); ?></li>
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
										<h6><?php echo lang('joining'); ?></h6>
										<h4><?php echo count($all_subscribers); ?> <span><?php echo lang('this_month'); ?></span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6><?php echo lang('renewal'); ?></h6>
										<h4><?php echo lang('0'); ?> <span><?php echo lang('this_month'); ?></span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6><?php echo lang('renewal'); ?></h6>
										<h4><?php echo lang('0'); ?> <span><?php echo lang('next_month'); ?></span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
						<div class="card">
								<div class="card-body text-center">
									<div class="stats-info">
										<h6><?php echo lang('subscription'); ?></h6>
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
								<h3 class="card-title text-left"><?php echo lang('subscription'); ?><?php echo lang('plan_transaction'); ?></h3>
									<div class="table-responsive">
										<table class="table table-bordered datatable AppendDataTables">
											<thead>
												<tr>
											<th>#</th>
											<th><?php echo lang('client'); ?></th>
											<th><?php echo lang('name'); ?></th>
											<th><?php echo lang('username'); ?></th>
											<th><?php echo lang('email'); ?></th>
											<th><?php echo lang('plan'); ?></th>
											<th><?php echo lang('users'); ?></th>
											<th><?php echo lang('plan_duration'); ?></th>
											<th><?php echo lang('start_date'); ?></th>
											<th><?php echo lang('amount'); ?></th>
											<th><?php echo lang('plan_status'); ?></th>
											<!-- <th class="text-center">Update Plan</th> -->
											<th class="text-center"><?php echo lang('status'); ?></th>
											<th class="text-center"><?php echo lang('action'); ?></th>
										</tr>
											</thead>
											<tbody>
												<?php  

												// echo "<pre>"; print_r($all_subscribers); exit;
												if(count($all_subscribers) != 0){
													$e = 1;
													foreach($all_subscribers as $subscribers){

														$plan_details = $this->db->get_where('subscription_plans',array('plan_id'=>$subscribers['plan_id']))->row_array();
														if($subscribers['currency'] == 'usd'){
															$currency = '$';
														}else{
															$currency = '€';
														}
														$user_details = $this->db->get_where('users',array('subdomain_id'=>$subscribers['subscribers_id']))->row_array();
														$user_id = $user_details['id'];
														$acc_details = $this->db->get_where('account_details',array('user_id'=>$user_details['id']))->row_array();
														$acc_id = $acc_details['id'];
														$profile_pic = 'default_avatar.jpg';
														if($acc_details['avatar'] !=''){
															$profile_pic = $acc_details['avatar'];
														}
														// echo "<pre>"; print_r($acc_id);

														// $this->db->join('users u','s.subscribers_id = u.subdomain_id','right');
														// $this->db->join('account_details ac','ac.user_id = u.id','left');
												?>
												<tr>
													<td><?php echo $e; ?></td>
													<td>
														<h2 class="table-avatar">
															<a href="#" class="avatar"><img src="<?php echo base_url();?>assets/avatar/<?php echo $profile_pic; ?>" alt=""></a>
															<a href="#"><?php echo ucfirst($subscribers['company_name']); ?></a>
														</h2>
													</td>
													<td><?php echo $subscribers['fullname']; ?></td>
													<td><?php echo $subscribers['username']; ?></td>
													<td><?php echo $subscribers['subscriber_email']; ?></td>
													<td><?php echo $plan_details['plan_name']; ?></td>
													<td><?php echo $subscribers['user_count']; ?></td>
													<td><?php echo ucfirst($plan_details['plan_type']); ?></td>
													<td><?php echo date('d M Y',strtotime($subscribers['created_at'])); ?></td>
													<td><?php echo $currency.' '.$subscribers['amount']; ?></td>
													<td><span class="badge bg-inverse-success"><?php echo lang('active');?></span></td>
													<!-- <td class="text-center"><a class="btn btn-primary btn-sm" href="javascript:void(0);" data-toggle="modal" data-target="#upgrade_plan">Change Plan</a></td> -->
													<?php 
													$status = '';
													if($subscribers['status'] == 1) $status = 0; else $status =1; 
													
													?>
													<td class="text-center">
														<div class="status-toggle">
															<input type="checkbox" class="check" id="status_ch_<?=$e?>" onclick="change_status(<?=$subscribers['subscribers_id']?>,<?=$status?>)" <?php if($subscribers['status'] == 1) echo "checked";?>>
															<label class="checktoggle" for="status_ch_<?=$e?>">checkbox</label>
														</div>
													</td>
													<td class="text-center">
														<div class="dropdown">
															<a data-toggle="dropdown" class="action-icon text-dark" href="#"><i class="fa fa-ellipsis-v"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
																<li class="dropdown-item">
																	<a class="text-dark" href="javascript:void(0);" data-toggle="modal" data-target="#profile_pic" onclick="profile_pic(<?=$acc_id; ?>)">
																		<?php echo lang('upload_picture'); ?>
																	</a>
																</li>
																<li class="dropdown-item">
																	<a class="text-dark" href="javascript:void(0);" data-toggle="modal" data-target="#reset_password" onclick="reset_password(<?php echo $subscribers['subscribers_id']; ?>)">
																		<?php echo lang('reset_password'); ?>
																	</a>
																</li>
																<li class="dropdown-item">
																	<a class="text-dark" href="javascript:void(0);" data-toggle="modal" data-target="#delete_subscription" onclick="delete_subscription(<?php echo $subscribers['subscribers_id']; ?>)">
																		<?php echo lang('delete'); ?>
																	</a>
																</li>
															</ul>
														</div>
													</td>
												</tr>
											<?php $e++; }}else{ ?> 
												<tr>
													<td><?php echo lang('no_subscribers'); ?></td>
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
									<h5 class="modal-title text-center mb-3"><?php echo lang('upgrade_plan'); ?></h5>
									<form>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('plan_name'); ?></label>
													<input type="text" placeholder="Free Trial" class="form-control" value="Free Trial">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('amount'); ?></label>
													<input type="text" class="form-control" value="$500">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('plan_type'); ?></label>
													<select class="select"> 
														<option> <?php echo lang('monthly'); ?> </option>
														<option> <?php echo lang('yearly'); ?> </option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('no_of_users'); ?></label>
													<select class="select"> 
														<option> <?php echo lang('5_users'); ?> </option>
														<option> <?php echo lang('50_users'); ?> </option>
														<option> <?php echo lang('unlimited'); ?> </option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('no_of_projects'); ?></label>
													<select class="select"> 
														<option> <?php echo lang('5_projects'); ?> </option>
														<option> <?php echo lang('50_projects'); ?> </option>
														<option> <?php echo lang('unlimited'); ?> </option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('no_of_storage_space'); ?></label>
													<select class="select"> 
														<option> <?php echo lang('5_GB'); ?> </option>
														<option> <?php echo lang('100_GB'); ?> </option>
														<option> <?php echo lang('500_GB'); ?> </option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label><?php echo lang('plan_description'); ?></label>
											<textarea class="form-control" rows="4" cols="30"></textarea>
										</div>
										<div class="form-group">
											<label class="d-block"><?php echo lang('status'); ?></label>
											<div class="status-toggle">
												<input type="checkbox" id="upgrade_plan_status" class="check">
												<label for="upgrade_plan_status" class="checktoggle">checkbox</label>
											</div>
										</div>
										<div class="m-t-20 text-center">
											<button class="btn btn-primary submit-btn"><?php echo lang('save'); ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- /Upgrade Plan Modal -->

					<div class="modal custom-modal fade" id="delete_subscription" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header bg-danger">
								
									<h4 class="modal-title"><?php echo lang('delete_subscription'); ?></h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button> 
								</div>
								<?php echo form_open(base_url().'superadmin/delete_subscription'); ?>
									<div class="modal-body">
										<p><?php echo lang('confirm_to_delete_this_operation'); ?></p>
										<input type="hidden" name="subscription" id="subscription">
										<div class="col-md-12">
											<div class="form-group">
												<label><?php echo lang('superadmin_password'); ?></label>
												<input type="password" name="password" placeholder="<?php echo lang('enter_password'); ?>" class="form-control" required="required">
											</div>
										</div>
									</div>
									<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
										<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
									</div>
								</form>
							</div>
						</div>
					</div>


					<div class="modal custom-modal fade" id="profile_pic" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header bg-danger">
								
									<h4 class="modal-title"><?php echo lang('upload_picture'); ?></h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button> 
								</div>
								<?php echo form_open_multipart(base_url().'superadmin/profile_pic'); ?>
									<div class="modal-body">
										<input type="hidden" name="acc_id" id="acc_id">
										<div class="col-md-12">
											<div class="form-group">
												<label><?php echo lang('upload_profile_picture'); ?></label>
												<input type="file" name="profile_pic" placeholder="Enter Password" class="form-control" required="required">
											</div>
										</div>
									</div>
									<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
										<button type="submit" class="btn btn-danger"><?php echo lang('save'); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Upgrade Plan Modal -->
					<div class="modal custom-modal fade" id="reset_password" role="dialog">
						<div class="modal-dialog modal-md modal-dialog-centered">
							<div class="modal-content">
								<button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
								<div class="modal-body">
									<h5 class="modal-title text-center mb-3"><?php echo lang('reset_password'); ?></h5>
									<form method="post" action="<?php echo base_url('superadmin/reset_password'); ?>">
										<input type="hidden" name="subscribers_id" id='subscribers_id'>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('new_password'); ?></label>
													<input type="password" name="password" placeholder="<?php echo lang('enter_password'); ?>" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?php echo lang('confirm_password'); ?></label>
													<input type="password" name="confirm_password" placeholder="<?php echo lang('confirm_password'); ?>" class="form-control">
												</div>
											</div>
										</div>
										<div class="m-t-20 text-center">
										<button class="btn btn-primary submit-btn" type="submit"><?php echo lang('reset'); ?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- /Upgrade Plan Modal -->

					<script type="text/javascript">
						function reset_password(id){
							document.getElementById("subscribers_id").value = id;
						}
						function delete_subscription(id){
							document.getElementById("subscription").value = id;
						}
						function profile_pic(id){
							document.getElementById("acc_id").value = id;
						}
					</script>

					
						  
        