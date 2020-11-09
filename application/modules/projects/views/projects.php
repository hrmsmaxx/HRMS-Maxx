<?php //echo User::is_admin(); exit; 
//echo '<pre>'; print_r($projects); exit;
?>

<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?php echo lang('work_management');?></h4>
		</div>
	</div>
	<?php $this->load->view('sub_menus');?>
	<!-- <div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li><a href="<?php echo base_url(); ?>work_management/request_approval">Request & Approval</a></li>
			<li><a href="<?php echo base_url(); ?>performance">Performance</a></li>
			<li><a href="<?php echo base_url(); ?>calendar">Calendar</a></li>
			<li  class="active"><a href="<?php echo base_url(); ?>projects">Projects</a></li>
			<li><a href="<?php echo base_url(); ?>all_tasks">Tasks</a></li>
		</ul>
	</div> -->
	<div class="card-box m-b-0">
	<div class="row">
		<div class="col-sm-5">
		
			<h4 class="page-title"><?=($archive ? lang('project_archive') : lang('projects'));?></h4>
		</div>
		<div class="col-sm-7 text-right m-b-20">
			<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'add_projects') || User::login_role_name() == 'client' && config_item('client_create_project') == 'TRUE') { ?>
			<a href="<?=base_url()?>projects/add" class="btn add-btn"><i class="fa fa-plus"></i> <?=lang('create_project')?></a>
			<?php } ?>
			<?php $user_details = $this->db->get_where('users',array('id'=>$this->session->userdata('user_id'),'role_id'=>3,'is_teamlead'=>'yes'))->row_array(); 
			if($user_details != '')
			{ ?>
			<a href="<?=base_url()?>projects/add" class="btn  add-btn"><i class="fa fa-plus"></i> <?=lang('create_project')?></a>
			<?php 
			}
			?>
			<?php if ($archive) : ?>
			<a href="<?=base_url()?>projects" class="btn add-btn m-r-10"><?=lang('view_active')?></a>
			<?php else: ?>
			<a href="<?=base_url()?>projects?view=archive" class="btn add-btn m-r-10">
			<?=lang('view_archive')?></a>
			<?php endif; ?>            
			<div class="btn-group pull-right m-r-10"> 
				<button class="btn btn-default">
				<?php
				$view = isset($_GET['view']) ? $_GET['view'] : NULL;
				switch ($view) {
				case 'on_hold':
				echo lang('on_hold');
				break;
				case 'done':
				echo lang('done');
				break;
				case 'active':
				echo lang('active');
				break;
				default:
				echo lang('filter');
				break;
				}
				?>
				</button> 
				<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button> 
				<ul class="dropdown-menu"> 
					<li><a href="<?=base_url()?>projects?view=active"><?=lang('active')?></a></li> 
					<li><a href="<?=base_url()?>projects?view=on_hold"><?=lang('on_hold')?></a></li> 
					<li><a href="<?=base_url()?>projects?view=done"><?=lang('done')?></a></li>
					<li><a href="<?=base_url()?>projects"><?=lang('all_projects')?></a></li>   
				</ul> 
			</div>
			<div class="view-icons">
				<a href="<?php echo base_url(); ?>projects" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
				<a href="<?php echo base_url(); ?>projects/grid_view" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
			</div>
		</div>
	</div>

	<div class="row filter-row m-t-5">
		<form method="POST" action="<?php echo base_url()?>projects">
			<div class="col-lg-4 col-sm-6 col-xs-12">  
				<div class="form-group form-focus">
				<label class="control-label"><?=lang('project_title');?></label>
				<input type="text" class="form-control floating" id="project_title" name="project_title">
				<label id="project_title_error" class="error display-none" for="project_title"><?=lang('project_title_should_not_empty');?></label>
				</div>
			</div>
			<div class="col-lg-4 col-sm-6 col-xs-12">  
				<div class="form-group form-focus">
					<label class="control-label"><?=lang('client_name');?></label>
					<input type="text" class="form-control floating"  id="client_name" name="client_name">
					<label id="client_name_error" class="error display-none" for="client_name"><?=lang('client_name_shoulr_not_empty');?></label>
				</div>
			</div>
			<div class="col-lg-4 col-sm-6 col-xs-12">  
				<!-- <a href="javascript:void(0)" id="project_search_btn" class="m-b-10 btn btn-success btn-block form-control"> <?php //lang('search');?> </a>   -->
				<button type="submit" class="m-b-10 btn btn-success btn-block form-control p-0" id="project_search_btn"> <?php echo lang('search');?> </button>
			</div>
		</form>     
    </div>

    <div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
		<!-- <table id="table-projects<?=($archive ? '-archive':'')?>" class="table table-striped custom-table m-b-0"> -->
			<table id="table-projects<?=($archive ? '-archive':'')?> table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">
			<thead>
				<tr>
					<th style="width:5px; display:none;"></th>
					<th class="col-title" style="min-width:150px"><?=lang('project_title')?></th>
					
					<?php if ((User::login_role_name() == 'admin') || (User::login_role_name() == 'superadmin')) { ?>
					<th class=""><?=lang('client_name')?></th>
					<?php } ?>

					<!-- <th class="col-title"><?php //echo lang('branch_name')?></th> -->
					
					<?php if (User::login_role_name() != 'client') { ?>
					<th class="col-title "><?=lang('status')?></th>
					<?php } ?>
					
					<th><?=('Lead')?></th>
					
					<th><?=lang('team_members')?></th>
					
					<th class="col-date "><?=lang('used_budget')?></th>
					
					<?php  if ((User::login_role_name() != 'admin') && (User::login_role_name() != 'superadmin')) { ?>
					<th class=""><?=lang('hours_spent')?></th>
					<?php  } ?>
					
					<?php if(User::login_role_name() != 'staff' || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
					<th class="col-currency"><?=lang('amount')?></th>
					<?php } ?>
					
					<th><?php echo lang('chart');?></th>
					
					<th class="text-right"><?php echo lang('action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($projects as $key => $p) { 
				$progress = Project::get_progress($p->project_id); 
				$branch_name = $this->db->select('id, branch_name')->get_where('branches', array('id'=>$p->branch_id, 'subdomain_id'=>$this->session->userdata('subdomain_id')))->row();
				?>
				<tr class="<?php if (Project::timer_status('project',$p->project_id) == 'On') { echo "text-danger"; } ?>">
					<td style="display:none;"><?=$p->project_id?></td>
					<td>
						<?php  $no_of_tasks = App::counter('tasks',array('project' => $p->project_id)); ?>
						<a class="text-info" data-toggle="tooltip" data-original-title="<?=$no_of_tasks?> <?=lang('tasks')?> | <?=$progress?>% <?=lang('done')?>" href="<?=base_url()?>projects/view/<?=$p->project_id?>">
							<?=$p->project_title?>
						</a>
						<?php if (Project::timer_status('project',$p->project_id) == 'On') { ?>
						<i class="fa fa-spin fa-clock-o text-danger"></i>
						<?php } ?>
						<?php 
						if (time() > strtotime($p->due_date) AND $progress < 100){
						$color = (valid_date($p->due_date)) ? 'danger': 'default';
						echo '<span class="label label-'.$color.' pull-right">';
						echo (valid_date($p->due_date)) ? lang('overdue') : lang('ongoing'); 
						echo '</span>'; 
						} ?>
						<div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 100%; margin-right: 5px">
							<div class="progress-bar progress-bar-<?php echo ($progress >= 100 ) ? 'success' : 'danger'; ?>" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%;" data-toggle="tooltip" data-original-title="<?=$progress?>%"></div>
						</div>
					
					</td>
					
					<?php if (User::is_admin()) { ?>
					<td class="">
						<?=($p->client > 0) ? Client::view_by_id($p->client)->company_name : 'N/A'; ?>
					</td>
					<?php } ?>
					<!-- <td><?php //echo $branch_name->branch_name;?></td> -->
					<?php if (User::login_role_name() != 'client') { ?>
					<?php 
						switch ($p->status) {
							case 'Active': $label = 'success'; break;
							case 'On Hold': $label = 'warning'; break;
							case 'Done': $label = 'default'; break;
						}
					?>
					<td>
						<span class="label label-<?=$label?>"><?=lang(str_replace(" ","_",strtolower($p->status)))?></span>
					</td>
					<?php } ?>

					<td class="text-muted">
						<ul class="team-members">
							 
							<li>
								<a>
									<img src="<?php echo User::avatar_url($p->assign_lead); ?>" class="img-circle" data-toggle="tooltip" data-title="<?=User::displayName($p->assign_lead); ?>" data-placement="top">
								</a>
							</li>
							 
						</ul>
					</td>

					<td class="text-muted">
						<ul class="team-members">
							<?php foreach (Project::project_team($p->project_id) as $user) { ?>
							<li>
								<a>
									<img src="<?php echo User::avatar_url($user->assigned_user); ?>" class="img-circle" data-toggle="tooltip" data-title="<?=User::displayName($user->assigned_user); ?>" data-placement="top">
								</a>
							</li>
							<?php } ?>
						</ul>
					</td>
					<?php $hours = Project::total_hours($p->project_id);
						if($p->estimate_hours > 0){
							$used_budget = round(($hours / $p->estimate_hours) * 100,2);
						} else{ $used_budget = NULL; }
					?>
					<td>
						<strong class="<?=($used_budget > 100) ? 'text-danger' : 'text-success'; ?>"><?=($used_budget != NULL) ? $used_budget.' %': 'N/A'?></strong>
					</td>
					<?php if (!User::is_admin()) {  
						$check_task_hours = $this->db->get_where('timesheet',array('project_id'=>$p->project_id))->result_array();    
                            $hrs = 0;
                            foreach($check_task_hours as $h)
                            {
                              $hrs += $h['hours'];
                            }

						?>
					<td class="text-muted"><?=$hrs?> <?=lang('hours')?></td>
					<?php } ?>
					<?php if(User::login_role_name() != 'staff' || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
					<?php $cur = ($p->client > 0) ? Client::client_currency($p->client)->code : $p->currency; ?>
					<td class="col-currency">
						<strong><?=Applib::format_currency($cur, Project::sub_total($p->project_id))?></strong>
						<small class="text-muted" data-toggle="tooltip" data-title="<?=lang('expenses')?>"> (<?=Applib::format_currency($cur, Project::total_expense($p->project_id))?>) </small>
					</td>
					<?php } ?>

					<!-- Gannt Chart -->
					<td><a href="<?php echo base_url(); ?>projects/project_chart/<?php echo $p->project_id; ?>"><i class="fa fa-bar-chart" aria-hidden="true"></i></a></td>


					<td class="text-right">
						<div class="dropdown">
							<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="fa fa-ellipsis-v"></i></a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="<?=base_url()?>projects/view/<?=$p->project_id?>"><?=lang('preview_project')?></a>
								</li>
								<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'edit_all_projects')){ ?>   
								<li>
									<a href="<?=base_url()?>projects/edit/<?=$p->project_id?>"><?=lang('edit_project')?></a>
								</li>
								<?php if ($archive) : ?>
								<li><a href="<?=base_url()?>projects/archive/<?=$p->project_id?>/0"><?=lang('move_to_active')?></a></li>  
								<?php else: ?>
								<li>
									<a href="<?=base_url()?>projects/archive/<?=$p->project_id?>/1"><?=lang('archive_project')?></a>
								</li>        
								<?php endif; ?>
								<?php } ?>  
								<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'delete_projects')){ ?> 
								<li>
									<a href="<?=base_url()?>projects/delete/<?=$p->project_id?>" data-toggle="ajaxModal"><?=lang('delete_project')?></a>
								</li>
								<?php } ?>
							</ul>
						</div>
					</td>
				</tr>
				<?php } ?>

				<?php if(($this->session->userdata('role_id') != 1) && ($this->session->userdata('role_id') != 4)) {
				 $created_check = $this->db->get_where('projects',array('created_by'=>$this->session->userdata('user_id'),'archived '=>'0'))->result(); foreach ($created_check as $key => $p1) { 
				$progress = Project::get_progress($p1->project_id); ?>
				<tr class="<?php if (Project::timer_status('project',$p1->project_id) == 'On') { echo "text-danger"; } ?>">
					<td style="display:none;"><?=$p1->project_id?></td>
					<td>
						<?php  $no_of_tasks = App::counter('tasks',array('project' => $p1->project_id)); ?>
						<a class="text-info" data-toggle="tooltip" data-original-title="<?=$no_of_tasks?> <?=lang('tasks')?> | <?=$progress?>% <?=lang('done')?>" href="<?=base_url()?>projects/view/<?=$p1->project_id?>">
							<?=$p1->project_title?>
						</a>
						<?php if (Project::timer_status('project',$p1->project_id) == 'On') { ?>
						<i class="fa fa-spin fa-clock-o text-danger"></i>
						<?php } ?>
						<?php 
						if (time() > strtotime($p1->due_date) AND $progress < 100){
						$color = (valid_date($p1->due_date)) ? 'danger': 'default';
						echo '<span class="label label-'.$color.' pull-right">';
						echo (valid_date($p1->due_date)) ? lang('overdue') : lang('ongoing'); 
						echo '</span>'; 
						} ?>
						<div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 100%; margin-right: 5px">
							<div class="progress-bar progress-bar-<?php echo ($progress >= 100 ) ? 'success' : 'danger'; ?>" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%;" data-toggle="tooltip" data-original-title="<?=$progress?>%"></div>
						</div>
					
					</td>
					<?php if (User::is_admin()) { ?>
					<td class="">
						<?=($p1->client > 0) ? Client::view_by_id($p1->client)->company_name : 'N/A'; ?>
					</td>
					<?php } ?>

					<?php if (User::login_role_name() != 'client') { ?>
					<?php 
						switch ($p1->status) {
							case 'Active': $label = 'success'; break;
							case 'On Hold': $label = 'warning'; break;
							case 'Done': $label = 'default'; break;
						}
					?>
					<td>
						<span class="label label-<?=$label?>"><?=lang(str_replace(" ","_",strtolower($p1->status)))?></span>
					</td>
					<?php } ?>

					<td class="text-muted">
						<ul class="team-members">
							 
							<li>
								<a>
									<img src="<?php echo User::avatar_url($p1->assign_lead); ?>" class="img-circle" data-toggle="tooltip" data-title="<?=User::displayName($p1->assign_lead); ?>" data-placement="top">
								</a>
							</li>
							 
						</ul>
					</td>

					<td class="text-muted">
						<ul class="team-members">
							<?php foreach (Project::project_team($p1->project_id) as $user) { ?>
							<li>
								<a>
									<img src="<?php echo User::avatar_url($user->assigned_user); ?>" class="img-circle" data-toggle="tooltip" data-title="<?=User::displayName($user->assigned_user); ?>" data-placement="top">
								</a>
							</li>
							<?php } ?>
						</ul>
					</td>
					<?php $hours = Project::total_hours($p1->project_id);
						if($p1->estimate_hours > 0){
							$used_budget = round(($hours / $p1->estimate_hours) * 100,2);
						} else{ $used_budget = NULL; }
					?>
					<td>
						<strong class="<?=($used_budget > 100) ? 'text-danger' : 'text-success'; ?>"><?=($used_budget != NULL) ? $used_budget.' %': 'N/A'?></strong>
					</td>
					<?php if (!User::is_admin()) {  
						$check_task_hours = $this->db->get_where('timesheet',array('project_id'=>$p1->project_id))->result_array();    
                            $hrs = 0;
                            foreach($check_task_hours as $h)
                            {
                              $hrs += $h['hours'];
                            }

						?>
					<td class="text-muted"><?=$hrs?> <?=lang('hours')?></td>
					<?php } ?>
					<?php if(User::login_role_name() != 'staff' || User::perm_allowed(User::get_id(),'view_project_cost')){ ?>
					<?php $cur = ($p1->client > 0) ? Client::client_currency($p1->client)->code : $p1->currency; ?>
					<td class="col-currency">
						<strong><?=Applib::format_currency($cur, Project::sub_total($p1->project_id))?></strong>
						<small class="text-muted" data-toggle="tooltip" data-title="<?=lang('expenses')?>"> (<?=Applib::format_currency($cur, Project::total_expense($p1->project_id))?>) </small>
					</td>
					<?php } ?>
					<td class="text-right">
						<div class="dropdown">
							<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="fa fa-ellipsis-v"></i></a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="<?=base_url()?>projects/view/<?=$p1->project_id?>"><?=lang('preview_project')?></a>
								</li>
								<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'edit_all_projects')){ ?>   
								<li>
									<a href="<?=base_url()?>projects/edit/<?=$p1->project_id?>"><?=lang('edit_project')?></a>
								</li>
								<?php if ($archive) : ?>
								<li><a href="<?=base_url()?>projects/archive/<?=$p1->project_id?>/0"><?=lang('move_to_active')?></a></li>  
								<?php else: ?>
								<li>
									<a href="<?=base_url()?>projects/archive/<?=$p1->project_id?>/1"><?=lang('archive_project')?></a>
								</li>        
								<?php endif; ?>
								<?php } ?>  
								<?php if (User::is_admin() || User::perm_allowed(User::get_id(),'delete_projects')){ ?> 
								<li>
									<a href="<?=base_url()?>projects/delete/<?=$p1->project_id?>" data-toggle="ajaxModal"><?=lang('delete_project')?></a>
								</li>
								<?php } ?>
							</ul>
						</div>
					</td>
				</tr>
				<?php } } ?>
			</tbody>
		</table>
								</div>
								</div>
	</div>
	</div>
</div>