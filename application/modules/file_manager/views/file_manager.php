<!-- Page Content -->

                <div class="content container-fluid">

				

					<div class="row">

						<div class="col-sm-12">

							<div class="file-wrap">

								<div class="file-sidebar">

									<div class="file-header justify-content-center">

										<span><?php echo lang('projects'); ?></span>

										<a href="javascript:void(0);" class="file-side-close"><i class="fa fa-times"></i></a>

									</div>

									<form class="file-search">

										<div class="input-group">

											<div class="input-group-prepend">

												<i class="fa fa-search"></i>

											</div>

											<input type="text" class="form-control" placeholder="<?php echo lang('search'); ?>" id="SearchProject">

										</div>

									</form>

									<div class="file-pro-list">

										<div class="file-scroll">

											<ul class="file-menu AllProjectsList">

												<li class="active">

													<a href="javascript:void(0);" class="FileLiSt" data-id="0" data-project="All Projects"><?php echo lang('all_projects'); ?></a>

												</li>

												<?php 

													$all_projects = $this->db->get_where('projects',array('archived'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();

													if(!empty($all_projects)){

														foreach($all_projects as $project){ ?>

														<li>

															<a href="javascript:void(0);" class="FileLiSt" data-id="<?php echo $project['project_id']; ?>" data-project="<?php echo $project['project_title']; ?>"><?php echo $project['project_title']; ?></a>

														</li>



												<?php

														}

													}

												?>

											</ul>

										</div>

									</div>

								</div>

								<div class="file-cont-wrap">

									<div class="file-cont-inner">

										<div class="file-cont-header" style="width: 660px;">

											<div class="file-options">

												<a href="javascript:void(0)" id="file_sidebar_toggle" class="file-sidebar-toggle">

													<i class="fa fa-bars"></i>

												</a>

											</div>

											<span><?php echo lang('file_manager'); ?></span>

											<div class="file-options">

												<span class="btn-file"><input type="hidden" class="upload"></span>

											</div>

										</div>

										<div class="file-content">

											<div class="file-body">

												<div class="file-scroll">

													<div class="file-content-inner">

														<h4><span id="title_project"><?php echo lang('all_projects'); ?> -</span>&nbsp;<?php echo lang('files'); ?></h4>

														<div class="row row-sm AllProjectFileS">

															<?php 

																$all_task_files = $this->db->query("SELECT * FROM dgt_tasks AS t JOIN  dgt_task_files AS tf ON tf.task=t.t_id  ORDER BY tf.date_posted ASC")->result_array();

																if(count($all_task_files) != 0){ 

																	foreach($all_task_files as $task_file){

																		if($task_file['subdomain_id'] == $this->session->userdata('subdomain_id')){



																		if($task_file['file_ext']=='.png' || $task_file['file_ext']=='.jpg' || $task_file['file_ext']=='.jpeg' || $task_file['file_ext']=='.PNG' || $task_file['file_ext']=='.JPG' || $task_file['file_ext']=='.JPEG')

												                        {

												                        	$imgs = '<img src="'.base_url().'assets/project-files/'.$task_file['path'].'/'.$task_file['file_name'].'" style="height:100px;">';

												                        }else{

												                        	$imgs = '<i class="fa fa-file-word-o"></i>';

												                        }





																		?>

																		<div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">

																			<div class="card card-file">

																				<div class="dropdown-file">

																					<a href="" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>

																					<div class="dropdown-menu dropdown-menu-right">

																						<a href="<?php echo base_url().'assets/project-files/'.$task_file['path'].'/'.$task_file['file_name']; ?>" class="dropdown-item" download><?php echo lang('download'); ?></a>

																						<a href="<?php echo base_url(); ?>file_manager/task_file_delete/<?php echo $task_file['file_id']; ?>" class="dropdown-item" data-toggle="ajaxModal"><?php echo lang('delete'); ?></a>

																					</div>

																				</div>

																				<div class="card-file-thumb">

																					<?php echo $imgs; ?>

																				</div>

																				<div class="card-body">

																					<h6><a href=""><?php echo $task_file['file_name']; ?></a></h6>

																					<span><?php echo $task_file['size'].'KB'; ?></span>

																				</div>

																				<div class="card-footer"><?php echo date('d M Y',strtotime($task_file['date_posted'])); ?></div>

																			</div>

																		</div>

															<?php

																	} }

																}else{ ?>

																	<div class="col-6 col-sm-4 col-md-3 col-lg-12 col-xl-3">

																		<div class="card card-file text-center">

																			<p><?php echo lang('no_files_found'); ?></p>

																		</div>

																	</div>

															<?php }

															?>



														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

					

                </div>

				<!-- /Page Content -->