            <div class="content container-fluid">

					<div class="row">

						<div class="col-xs-4">

							<h4 class="page-title"><?=lang('all_leads')?></h4>

						</div>

					</div>	

					<?php $this->load->view('sub_menus'); ?>				

					

				<div class="card-box m-b-0">

					<div class="row">

						<div class="col-xs-4">

							<h4 class="page-title"><?=lang('all_leads')?></h4>

						</div>

						<div class="col-sm-8 col-9 text-right m-b-20">

							<a class="btn add-btn" data-toggle="modal" data-target="#add_lead" title="" data-placement="bottom" data-original-title="<?php echo lang('add_lead');?>">

										<i class="fa fa-plus"></i><?php echo lang('add_lead');?></a>

							

						</div>

					</div>

					<div class="row">

						<div class="col-md-12">

							<div class="table-responsive">

								<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">

									<thead>

										<tr>

											<th>#</th>

											<th><?php echo lang('lead_name');?></th>

											<th><?php echo lang('project');?></th>

											<th><?php echo lang('amount');?></th>

											<th><?php echo lang('email');?></th>

											<th><?php echo lang('phone');?></th>

											<th><?php echo lang('status');?></th>

											<th><?php echo lang('created');?></th>

											<th><?php echo lang('action');?></th>

										</tr>

									</thead>

									<tbody>

										<?php 											

											// $all_leads = $this->db->get_where('users',array('role_id'=>3,'is_teamlead'=>'yes','activated'=>1,'banned'=>0))->result_array(); 

										$i = 1;

										if(isset($all_leads) && !empty($all_leads)){

											foreach($all_leads as $leads){		

										?>

										<tr>

											<td><?php echo lang($i); ?></td>

											<td><?php echo ucfirst($leads['name']); ?></td>

											<td><?php echo $leads['project_name']; ?></td>

											<td><?php echo $leads['project_amount']; ?></td>

											<td><?php echo $leads['email']; ?></td>

											<td><?php echo $leads['phone_no']; ?></td>

											<td>
												<?php if($leads['status'] == '1') {?>
													<span class="label label-success-border"><?php echo lang('active');?></span>
												<?php }else{?>
													<span class="label label-warning-border"><?php echo lang('inactive'); ?></span>
												<?php }?>
											</td>

											<td><?php echo date('d-M-Y',strtotime($leads['created'])); ?></td>

											<td class="text-right">

												<div class="dropdown">

													<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>

													<ul class="dropdown-menu pull-right">											

														   

														<li>

															<a href="<?php echo base_url(); ?>crm/edit_lead/<?php echo $leads['id']; ?>" data-toggle="ajaxModal"><?php echo lang('edit_lead');?></a>

														</li>																						

																						  

														 

														<li>

															<a href="<?php echo base_url(); ?>crm/delete_lead/<?php echo $leads['id']; ?>" data-toggle="ajaxModal"><?php echo lang('delete_lead');?></a>

														</li>

																					</ul>

												</div>

											</td>

										</tr>

									<?php $i++; } } else{ ?>

										<th><td colspan="8"><?php echo lang('no_records_found');?></td></th>

									<?php } ?>

									</tbody>

								</table>

							</div>

						</div>

					</div>

					</div>

                </div>



                 <!-- Add lead Modal -->

            <div class="modal custom-modal fade" id="add_lead" role="dialog" aria-hidden="true" style="display: none;">

                    <div class="modal-dialog modal-dialog-centered" role="document">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title"><?php echo lang('add_lead');?></h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    <span aria-hidden="true">×</span>

                                </button>

                            </div>

                            <div class="modal-body">

                                <form method="POST" action="<?php echo base_url(); ?>crm/add_lead" id="AddLeadForm" enctype="multipart/form-data" >

                                    <div class="form-group">

                                        <label><?php echo lang('name');?> <span class="text-danger">*</span></label>

                                         <input class="form-control" type="text" name="name" id="lead_name">

                                    </div>

                                    <div class="form-group">

                                        <label><?php echo lang('project_name');?> <span class="text-danger">*</span></label>

                                        <input class="form-control" type="text" name="project_name" id="project_name">

                                    </div>

                                    <div class="form-group">

                                        <label><?php echo lang('amount');?> <span class="text-danger">*</span></label>

                                        <input class="form-control" type="text" name="project_amount" id="project_amount">

                                    </div>

   		                          	<div class="form-group">

                                        <label><?php echo lang('email_address');?> <span class="text-danger">*</span></label>

                                        <input class="form-control" type="email" name="email" id="email">

                                    </div>

                                    <div class="form-group">

                                        <label><?php echo lang('contact_number');?> <span class="text-danger">*</span></label>

                                        <input class="form-control" type="text" name="phone_no" id="phone_no">

                                    </div>

                                     <div class="form-group">

                                        <label><?php echo lang('image');?> </label>

                                        <input class="form-control" type="file" name="avatar" id="file">

                                    </div>

                                    <div class="form-group">

                                        <label class="d-block"><?php echo lang('status');?></label>

                                        <div class="status-toggle">

                                            <input type="checkbox" id="lead_status" name="status" class="check" value="1">

                                            <label for="lead_status" class="checktoggle"><?php echo lang('checkbox');?></label>

                                        </div>

                                    </div>

                                    <div class="submit-section">

                                        <button class="btn btn-primary submit-btn" id="submit_lead_form" ><?php echo lang('submit');?></button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- /Add Lead Modal -->

				