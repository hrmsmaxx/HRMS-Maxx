
<!-- Content -->
                <div class="content container-fluid">
					
					<!-- Title -->
					<div class="row">
						<div class="col-xs-9 col-md-8 col-sm-9">
							<h4 class="page-title"><?php echo lang('offer_approval_dashboard');?></h4>
						</div>
						<!-- <div class="col-md-4 col-xs-3 col-sm-3">
							<div class="pull-right">
								<a href="<?=base_url()?>offers/create" class="btn btn-white text-center m-b-20">Create Offer</a>
							</div>
						</div> -->
					</div>
					<!-- / Title -->
					<?php $this->load->view('sub_menus');?>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-lg-4">
							<a href="#" class="dash-widget-pro showTable1">
								<div class="dash-widget card-box">
									<div class="dash-widget-info text-center">
										<span class="offer-total dash-color-1"><?=count($offered_candidates) ?></span><br>
										<span class="text-center dash-text"><?php echo lang('offer_approval_inprogress');

										?></span>
									</div>
								</div>
							</a>
						</div>
					<!-- 	<div class="col-md-6 col-sm-6 col-lg-4">
							<a href="#" class="dash-widget-pro showTable2">
								<div class="dash-widget card-box">
									<div class="dash-widget-info text-center">
										<span class="offer-total dash-color-2"><?=count($ready) ?></span><br>
										<span class="text-center dash-text"><?php echo lang('offer_approved_ready_to_be_send');?></span>
									</div>
								</div>
							</a>
						</div> -->
						<!-- <div class="col-md-6 col-sm-6 col-lg-4">
							<a href="#" class="dash-widget-pro showTable3">
								<div class="dash-widget card-box">
									<div class="dash-widget-info text-center">
										<span class="offer-total dash-color-3"><?=count($send) ?></span><br>
										<span class="text-center dash-text"><?php echo lang('offers_send')?></span>
									</div>
								</div>
							</a>
						</div> -->
						<div class="col-md-6 col-sm-6 col-lg-4">
							<a href="#" class="dash-widget-pro showTable4">
								<div class="dash-widget card-box">
									<div class="dash-widget-info text-center">
										<span class="offer-total dash-color-4"><?=count($offered_accepted) ?></span><br>
										<span class="text-center dash-text"><?php echo lang('offers_accepted')?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-4">
							<a href="#" class="dash-widget-pro showTable5">
								<div class="dash-widget card-box">
									<div class="dash-widget-info text-center">
										<span class="offer-total dash-color-5"><?=count($offered_rejected) ?></span><br>
										<span class="text-center dash-text"><?php echo lang('offers_declined');?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-4">
							<a href="#" class="dash-widget-pro showTable6">
								<div class="dash-widget card-box">
									<div class="dash-widget-info text-center">
										<span class="offer-total dash-color-6"><?=count($archived_offers) ?></span><br>
										<span class="text-center dash-text"><?php echo lang('archived_offers')?></span>
									</div>
								</div>
							</a>
						</div>
						
					</div>
					<div class="card-box">
					<div id="table-1">
					<div class="row">
						<div class="col-md-12">
							<h3 class="page-sub-title m-t-0"><?php echo lang('offer_approval_inprogress');?>(<?=count($offered_candidates) ?>)</h3>
							<div class="table-responsive">
								<table class="table custom-table datatable table-bordered">
									<thead>
										<tr>
											<th style="width:20%;"><?php echo lang('name')?></th>
											<th><?php echo lang('position')?></th>
											<th><?php echo lang('action') ?></th>
											<th style="min-width:700px;"><?php echo lang('status');?></th>
										</tr>
									</thead>
									<tbody>

										<?php 
										foreach ($offered_candidates as $key => $value) {
											 
										?>

										<tr>
											<td>
												<a href="#" class="avatar"><img class="img-circle" src="assets/img/user.jpg" alt=""></a>
												<h2><a href="#"><?=ucfirst($value['candidate_name'])?></a></h2>
											<td>
												<span><?=ucfirst($value['job_title'])?></span>
											</td>
											<td  class="text-center">
												<a href="#" class="like-icon m-r-10"><i class="fa fa-file-archive-o" title="Archive" aria-hidden="true" onclick="offer_archive('<?php echo $value['job_id'];?>','<?php echo $value['candidate_id']?>','1')"></i></a>
											</td>
											<td>
												<div class="tabbable">
													<ul class="nav navbar-nav wizard m-b-0">
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_created')?></a>
														</li>
														<li class="active">
															<a href="#" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>

																<?php echo lang('send_offer')?></a>
														</li>
														
														<?php if($value['user_job_status']==9){

															?><li>
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_rejected')?></a>
														</li>
															<?php 
														}?>
														<?php if($value['user_job_status']==10){

															?><li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_declined')?></a>
														</li>
															<?php 
														}?>

														<?php if($value['user_job_status']==8){

															?><li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_accepted')?></a>
														</li>
															<?php 
														}?>
														
														
														
														
													</ul>
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
					<!--<div id="table-2">

					<div class="row">
						<div class="col-md-12">
							<h3 class="page-sub-title m-t-0">Offer Approval & Ready to be Send (<?=count($ready) ?>)</h3>
							<div class="table-responsive">
								<table class="table custom-table datatable table-bordered">
									<thead>
										<tr>
											<th style="width:20%;">Name</th>
											<th>Position</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach ($ready as $rk => $rv) {
											 
										?>
										<tr>
											<td>
												<a href="<?=base_url()?>employees/profile_view/<?php echo $ipv['id']?>" class="avatar"><img class="img-circle" src="assets/img/user.jpg" alt=""></a>
												<h2><a href="<?=base_url()?>employees/profile_view/<?php echo $ipv['id']?>"><?=ucfirst($rv['name'])?></a></h2>
											<td>
												<span><?=ucfirst($rv['title'])?></span>
											</td>
											<td>
												<div class="tabbable">
													<ul class="nav navbar-nav wizard m-b-0">
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Offer Created</a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>In Progress</a>
														</li>
														<li class="active">
															<a href="<?php echo base_url(); ?>offers/offer_view/<?php echo $rv['id']; ?>" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Offer Approved</a>
														</li>
														
														<li>
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Send Offer</a>
														</li>
														<li>
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Offer Accepted</a>
														</li>
														<li>
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Onboard</a>
														</li>
													</ul>
												</div>
											</td>
											<td class="text-center">
												<a href="#" class="like-icon m-r-10"><i class="fa fa-file-archive-o" title="Archive" aria-hidden="true" onclick="app_archive('2','<?=$rv['id']?>')"></i></a>
												<a href="#" onclick="send_Appmails('<?=$rv['id']?>')" class="btn btn-info">Send Offer</a>

											</td>
										</tr><?php } ?> 
										 
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
					<div id="table-3"><hidden value='' id='tab_hide' ></hidden>
					<div class="row">
						<div class="col-md-12">
							<h3 class="page-sub-title m-t-0">Offer Send (<?=count($send) ?>)</h3>
							<div class="table-responsive">
								<table class="table custom-table datatable table-bordered">
									<thead>
										<tr>
											<th style="width:20%;">Name</th>
											<th>Position</th>
											<th>Action</th>
											<th>Status</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach ($send as $ipk => $ipv) {
											 
										?>
										<tr>
											<td>
												
												<h2><a href="<?=base_url()?>employees/profile_view/<?php echo $ipv['id']?>"><?=ucfirst($ipv['name'])?></a></h2>
											<td>
												<span><?=ucfirst($ipv['title'])?></span>
											</td>
											<td class="text-center">
											
												<a href="#" class="like-icon text-danger" data-toggle="modal" data-target="#offer_decline"  onclick="set_appval('<?=$ipv['id']?>')"><i class="fa fa-thumbs-o-down" title='Decline' aria-hidden="true"></i></a>
												<a href="#" class="like-icon m-r-10"><i class="fa fa-file-archive-o" title="Archive" aria-hidden="true" onclick="app_archive('3','<?=$ipv['id']?>')"></i></a>
												<a href="#" class="like-icon  text-success m-r-10"><i class="fa fa-check" title="Accept" aria-hidden="true" onclick="app_accept('<?=$ipv['id']?>')"></i></a>



											</td>
											<td>
												<div class="tabbable">
													<ul class="nav navbar-nav wizard m-b-0">
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Offer Created</a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>In Progress</a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Offer Approved</a>
														</li>
														
														<li class="active">
															<a href="<?php echo base_url(); ?>offers/offer_view/<?=$ipv['id'];?>" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Send Offer</a>
														</li>
														<li>
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Offer Accepted</a>
														</li>
														<li>
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>Onboard</a>
														</li>
													</ul>
												</div>
											</td>
											
										</tr>
										<?php } ?> 
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>-->
					<div id="table-4">
					<div class="row">
						<div class="col-md-12">
							<h3 class="page-sub-title m-t-0"><?php echo lang('offer_accepted');?> (<?=count($offered_accepted) ?>)</h3>
							<div class="table-responsive">
								<table class="table custom-table datatable table-bordered">
									<thead>
										<tr>
											<th style="width:20%;"><?php echo lang('name');?></th>
											<th><?php echo lang('position');?></th>
											<th><?php echo lang('action');?></th>
											<th><?php echo lang('status');?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach ($offered_accepted as $key => $list) {
											 
										?>
										<tr>
											<td>
												<a href="#" class="avatar"><img class="img-circle" src="assets/img/user.jpg" alt=""></a>
												<h2><a href="#"><?=ucfirst($list['candidate_name'])?></a></h2>
											<td>
												<span><?=ucfirst($list['job_title'])?></span>
											</td>
											<td class="text-center">
												<!-- <a href="#" class="like-icon text-success m-r-10"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a> -->
												<a href="#" class="like-icon text-danger" data-toggle="modal" data-target="#offer_decline"  onclick="set_appval_status('<?php echo $list['job_id'];?>','<?php echo $list['candidate_id']; ?>')"><i class="fa fa-thumbs-o-down" title='Decline' aria-hidden="true"></i></a>


												<a href="#" class="like-icon m-r-10"><i class="fa fa-file-archive-o" title="Archive" aria-hidden="true" onclick="offer_archive('<?php echo $list['job_id'];?>','<?php echo $list['candidate_id']?>','1')"></i></a>
												<!-- <a href="<?php echo base_url()?>offers/onboarding/<?=$ipv['id']?>" title="Onboarding" aria-hidden="true" class="m-r-10">Onboarding</a> -->
											</td>
											<td>
												<div class="tabbable">
													<ul class="nav navbar-nav wizard m-b-0">
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php  echo lang('offer_created') ?></a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('send_offer')?></a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_accepted')?></a>
														</li>
														
													</ul>
												</div>
											</td>
											
										</tr>
										 <?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
					<div id="table-5">
					<div class="row">
						<div class="col-md-12">
							<h3 class="page-sub-title m-t-0"><?php echo lang('offer_declined')?> (<?=count($offered_rejected) ?>)</h3>
							<div class="table-responsive">
								<table class="table custom-table datatable table-bordered">
									<thead>
										<tr>
											<th style="width:20%;"><?php echo lang('name');?></th>
											<th><?php echo lang('position');?></th>
											<th><?php echo lang('action');?></th>
											<th><?php echo lang('status');?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach ($offered_rejected as $key => $list) {
											 
										?>
										<tr>
											<td>
												<a href="#" class="avatar"><img class="img-circle" src="assets/img/user.jpg" alt=""></a>
												<h2><a href="#"><?=ucfirst($list['candidate_name'])?></a></h2>
											<td>
												<span><?=ucfirst($list['job_title'])?></span>
											</td>
											<td class="text-center">
												<!-- <a href="#" class="like-icon text-success m-r-10"><i class="fa fa-thumbs-o-up" onclick="send_Appmails('<?=$ipv['caid']?>')" aria-hidden="true"></i></a> -->
												<!-- <a href="#" class="like-icon text-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a> -->
												<a href="#" class="like-icon m-r-10"><i class="fa fa-file-archive-o" title="Archive" aria-hidden="true" onclick="offer_archive('<?php echo $list['job_id'];?>','<?php echo $list['candidate_id']?>','1')"></i></a>
											</td>
											<td>
												<div class="tabbable">
													<ul class="nav navbar-nav wizard m-b-0">
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_created');?></a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('send_offer');?></a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span>
															<?php if($list['user_job_status']==9){ echo lang('offer_rejected');}
															if($list['user_job_status']==10){ echo lang('offer_declined');}


															?>

															</a>
														</li>
														
													
													</ul>
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
					<div id="table-6">
					<div class="row">
						<div class="col-md-12">
							<h3 class="page-sub-title m-t-0"><?php echo lang('archived_offers');?> (<?=count($archived_offers) ?>)</h3>
							<div class="table-responsive">
								<table class="table custom-table datatable table-bordered">
									<thead>
										<tr>
											<th style="width:20%;"><?php echo lang('name');?></th>
											<th><?php echo lang('position');?></th>
											<th><?php echo lang('action');?></th>
											<th><?php echo lang('status')?></th>
											
										</tr>
									</thead>
									<tbody><?php 
										foreach ($archived_offers as $key => $list) {
											 
										?>
										<tr>
											<td>
												<a href="#" class="avatar"><img class="img-circle" src="assets/img/user.jpg" alt=""></a>
												<h2><a href="#"><?=ucfirst($list['candidate_name'])?></a></h2>
											<td>
												<span><?=ucfirst($list['job_title'])?></span>
											</td>
											<td class="text-center">
												<a href="#" class="like-icon text-success m-r-10"><i class="fa fa-thumbs-o-up" title='Accept' aria-hidden="true" onclick="offer_archive('<?php echo $list['job_id'];?>','<?php echo $list['candidate_id'];?>','0')"></i></a>
												<!-- <a href="#" class="like-icon text-danger" data-toggle="modal" data-target="#offer_decline"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a> -->

											</td>
											<td>
												<div class="tabbable">
													<ul class="nav navbar-nav wizard m-b-0">
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_created')?></a>
														</li>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('send_offer');?></a>
														</li>

														<?php if($list['user_job_status'] ==8){
															$status = lang('offer_accepted');
														}
														if($list['user_job_status'] ==9){
															$status = lang('offer_rejected');
														}
														if($list['user_job_status'] ==10){
															$status = lang('offer_declined');
														}

														?>
														<li class="active">
															<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo $status;?></a>
														</li>
														
														
														<li class="active">
															<a href="<?php echo base_url(); ?>offers/offer_view/<?=$ipv['id'];?>" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?php echo lang('offer_archived'); ?></a>
														</li>
														
													</ul>
												</div>
											</td>
											
										</tr><?php } ?>
										 
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
					</div>
                </div>
				<!-- / Content -->
				<!-- Offer Decline Modal -->
				<div class="modal fade" id="offer_decline" role="dialog">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3><?php echo lang('offer_decline'); ?></h3>
									<p><?php echo lang('are_you_sure_want_to_decline'); ?></p>
								</div>
								<div class="modal-btn delete-action">
									<input type="hidden" id="job_id" value="">
									<input type="hidden" id="candidate_id" value="">
									<div class="row">
										<div class="col-xs-6">
											<a href="javascript:void(0);" onclick='offer_decline_confirm()' class="btn btn-primary btn-block continue-btn"><?php echo lang('decline');?></a>
										</div>
										<div class="col-xs-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-default btn-block cancel-btn"><?php echo lang('cancel');?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Offer Decline Modal -->
				
			