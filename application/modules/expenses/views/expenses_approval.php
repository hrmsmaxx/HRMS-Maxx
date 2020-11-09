<!-- Content -->
                <div class="content container-fluid">
					
					<!-- Title -->
					<div class="row">
						<div class="col-sm-8">
							<h4 class="page-title"><?=lang('offer_approval_process')?></h4>
						</div>
					</div>
					<!-- / Title -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="offer-create">
							
								<!-- Offer Create Wizard -->
								<div class="tabbable">
									<ul class="nav navbar-nav wizard">
										<li class="">
											<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?=lang('offer_created')?></a>
										</li>
										<li>
											<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?=lang('in_progress')?></a>
										</li>
										<li>
											<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?=lang('offer_approved')?></a>
										</li>
										
										<li>
											<a href="javascript:void(0)" ><span class="nmbr"><i class="fa fa-check" aria-hidden="true"></i></span><?=lang('send_offer')?></a>
										</li>
									</ul>
								</div>
								<!-- /Offer Create Wizard -->
								
								<div class="row">
									<div class="col-md-12">
										<h3 class="page-sub-title"><?=lang('create_offer')?></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<form class="form-horizontal" id="create_offers" action="<?=base_url()?>offers/create" method="POST">
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('title')?></label>
												<div class="col-sm-9">
													<input class="form-control" type="text" name="title" id="title">
													<input class="form-control" type="hidden" name="status" value="1">
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('job_type')?></label>
												<div class="col-sm-9">
													<select class="form-control select" name="job_type" id="job_type">
														<?php foreach (User::GetJobType() as $jtype =>$jvalue): ?>
															<option value="<?=$jvalue['id']?>"  >
																<?= ucfirst(trim($jvalue['job_type']));?>
															</option>
														<?php endforeach ?>	
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('base_salary')?></label>
												<div class="col-sm-9">
													<input class="form-control" type="text" name="salary" id="salary">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('annual_incentive_plan')?></label>
												<div class="col-sm-9">
													<select class="select form-control" name="annual_incentive_plan" id="annual_incentive_plan">
														<option><?=lang('selection')?></option>
														<option value="1"><?=lang('1')?></option>
														<option value="2"><?=lang('2')?></option>
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('long_term_incentive_plan')?></label>
												<div class=" col-sm-9">
													<div class="onoffswitch">
														<input type="checkbox" class="onoffswitch-checkbox" id="onoffswitch" name="long_term_incentive_plan" >
														<label class="onoffswitch-label" for="onoffswitch">
															<span class="onoffswitch-inner"></span>
															<span class="onoffswitch-switch"></span>
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('vocation')?></label>
												<div class="col-sm-9">
													<select class="select form-control" name="vacation" id="Vacation">
														<option><?=lang('selection')?></option>
														<option value="1"><?=lang('1')?></option>
														<option value="2"><?=lang('2')?></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('reports_to')?></label>
												<div class="col-sm-9">													
													<select class="select2-option form-control"   style="width:260px" name="reports_to" id="reports_to"> 
														<optgroup><?=lang('select_report_to')?></optgroup> 
														<optgroup label="Staff">
															<?php foreach (User::team() as $user): ?>
																<option value="<?=$user->id?>"  >
																	<?=ucfirst(User::displayName($user->id))?>
																</option>
															<?php endforeach ?>
														</optgroup> 
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3"><?=lang('default_offer_approval')?></label>
												<div class="col-md-9 approval-option">
													<label class="radio-inline">
														<input id="radio-single" value="seq-approver" name="default_offer_approval" type="radio"><?=lang('sequence_approval')?> (<?=lang('chain')?>) <sup> <span class="badge info-badge"><i class="fa fa-info" aria-hidden="true"></i></span></sup>
													</label>
													<label class="radio-inline">
														<input id="radio-multiple" value="sim-approver" name="default_offer_approval"type="radio"><?=lang('simultaneous_approval')?> <sup><span class="badge info-badge"><i class="fa fa-info" aria-hidden="true"></i></span></sup>
													</label>
												</div>
											</div>
											<div class="form-group row approver seq-approver">
												<label class="control-label col-sm-3"><?=lang('offer_approvers')?></label>
												
												<div class="col-sm-9 ">
													<label class="control-label m-b-10" style="padding-left:0"><?=lang('approver')?> <?=lang('1')?></label>
													<div class="row">
														<div class="col-md-10">
															<!-- <select class="select form-control" name="offer_approvers" >
																<option>Recruiter</option>
																<option>Hiring Manager</option>
																<option>Manager</option>
																<option>Manager</option>
																<option>Manager</option>
															</select> -->
															<select class="select2-option form-control"   style="width:260px" name="offer_approvers[]" id="offer_approvers"> 
														<optgroup><?=lang('select_approvers')?></optgroup> 
														<optgroup label="Staff">
															<?php foreach (User::team() as $user): ?>
																<option value="<?=$user->id?>"  >
																	<?=ucfirst(User::displayName($user->id))?>
																</option>
															<?php endforeach ?>
														</optgroup> 
													</select>
														</div>
														<div class="col-md-2">
															<span class="m-t-10 badge btn-success"><?=lang('approved')?></span>
														</div>
													</div>
													<div id="items">
													</div>
												</div>
												<div class="row">
													<input type="hidden" id="count" value="1">
											<div class="col-sm-9 col-md-offset-3 m-t-10">
												<a id="add1" href="javascript:void(0)" class="add-more">+ <?=lang('add_approver')?></a>
											</div>
											</div>
											</div>
											
											<div class="form-group row approver sim-approver">
												<label class="control-label col-sm-3"><?=lang('offer_approvers')?></label>
												<div class="col-sm-9 ">
													<label class="control-label" style="margin-bottom:10px;padding-left:0"><?=lang('simultaneous_approval')?> </label>
													<div class="row">
														<div class="col-md-10">
															<select class="select2-option form-control" multiple="multiple" style="width:260px" name="offer_approvers[]" > 
																<optgroup label="Staff">
																	<?php foreach (User::team() as $user): ?>
																		<option value="<?=$user->id?>">
																			<?=ucfirst(User::displayName($user->id))?>
																		</option>
																	<?php endforeach ?>
																</optgroup> 
															</select>

														</div>
														<div class="col-md-2">
															<span class="m-t-10 badge btn-success"><?=lang('approved')?></span>
														</div>
													</div>
												</div>
											</div>
											
											
											<div class="row m-t-20">
												<div class="col-md-9 col-sm-offset-3">
													<label class="control-label" style="margin-bottom:10px;padding-left:0"><?=lang('message_to_approvers')?></label>
													<div class="row">
														<div class="col-md-12">
															 <textarea class="form-control" rows="5" name="message_to_approvers" id="message_to_approvers"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="m-t-30 text-center">
												<button class="btn btn-primary" type="submit" id="create_offers_submit"><?=lang('cerate_send_offer')?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
				<!-- / Content -->