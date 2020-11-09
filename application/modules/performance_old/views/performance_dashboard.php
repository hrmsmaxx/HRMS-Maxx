
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title"><?php echo lang('performance_dashboard');?></h4>
						</div>
					</div>
					
	<?php $this->load->view('sub_menus');?>
					
					<div class="row">
						<div class="col-sm-4">
							<div class="card-box text-center">
								<h4 class="card-title"><?php echo lang('completed_performance_review');?></h4>
								<span class="perform-icon bg-success-light"><?php echo ($completed_performance)?$completed_performance:'0'; ?></span>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="card-box text-center">
								<h4 class="card-title"><?php echo lang('outstanding_reviews');?></h4>
								<span class="perform-icon bg-danger-light"><?php echo ($outstanding_performance)?$outstanding_performance:'0';?></span>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table custom-table m-b-0">
									<thead>
										<tr>
											<th style="width:30%;"><?php echo lang('team_members');?></th>
											<th><?php echo lang('self_review');?></th>
											<th><?php echo lang('peer_reviews');?></th>
											<th><?php echo lang('your_reviews');?></th>
											<th><?php echo lang('goals');?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
											
										$rating_count= count($performances_360);
										$peer_rating = 0;

								                foreach ($performances_360 as $value) { 

								                	$peer_rating = $value['peer_ratings']/2;

								                	$employee_details = $this->db->get_where('users',array('id'=>$value['user_id']))->row_array();
													$designation = $this->db->get_where('designation',array('id'=>$employee_details['designation_id']))->row_array();
													$account_details = $this->db->get_where('account_details',array('user_id'=>$value['user_id']))->row_array();

								                	?>
								                    	
								                    
										<tr>
											<td>
												<div class="user_det_list">
								                    <a href="<?php echo base_url().'employees/profile_view/'.$value['user_id'];?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
								                    <h2><a style="color: #ff9800;" href="<?=base_url()?>performance_three_sixty/show_performance_three_sixty/<?php echo $value['user_id'];?>"><span class="username-info"><?php echo ucfirst(user::displayName($value['user_id']));?></span>
								                    <span class="userrole-info"> <?php echo (!empty($designation['designation']))?$designation['designation']:'-';?></span>
								                    <span class="username-info"> <?php echo !empty($employee_details['id_code'])?$employee_details['id_code']:"-";?></span></a></h2>
							                  	</div>
												
											</td>
											<td>
												<div class="rating">
													<?php for ($i=0; $i <5 ; $i++) {

														if($i < $value['self_ratings']){
														echo '<i class="fa fa-star rated"></i>';
														}else{
														echo '<i class="fa fa-star"></i>';
													} 
												}?> 
												</div>
											</td>
											<td>
												<div class="rating">
													<?php for ($i=0; $i <5 ; $i++) {

														if($i < $peer_rating){
														echo '<i class="fa fa-star rated"></i>';
														}else{
														echo '<i class="fa fa-star"></i>';
													} 
												}?> 
												</div>
											</td>
											<td>
												<div class="rating">
													<?php for ($i=0; $i <5 ; $i++) {

														if($i < $value['your_ratings']){
														echo '<i class="fa fa-star rated"></i>';
														}else{
														echo '<i class="fa fa-star"></i>';
													} 
												}?> 
												</div>
											</td>
											<td>
												<div class="progress-wrap">
													<div class="progress progress-xs">
														<div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
															40%
														</div>
													</div>
													<span>40%</span>
												</div>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
                </div>