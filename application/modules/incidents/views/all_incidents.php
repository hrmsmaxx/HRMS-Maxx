<div class="content">
	<div class="row">
		<div class="col-sm-12">
			<h4 class="page-title"><?=lang('incidents')?></h4>
		</div>
	</div>	
  <?php $this->load->view('sub_menus');?>
          <div class="card-box">
	<div class="card-box">
		<div class="row">
			<div class="col-sm-12 text-right m-b-20">
				<a class="btn add-btn" href="<?=base_url()?>incidents/add_incident" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('add_incidents'); ?></a>
				<a class="btn add-btn m-r-5" href="<?=base_url()?>incidents/incident_types"> <?php echo lang('incident_types'); ?></a>
				<a class="btn add-btn m-r-5" href="<?=base_url()?>incidents/calendar"><i class="fa fa-calendar-plus-o"></i> <?php echo lang('incident_calendar'); ?></a>
			</div>

		</div>
		<div class="row">
			<!-- Project Tasks -->
			<div class="col-lg-12">
					<div class="table-responsive">
						<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">
							<thead>
								<tr>
									<th>#</th>
									<th><?=lang('name')?></th>
									<th><?=lang('type')?></th>
									<th><?=lang('id_code')?></th>
									<th><?=lang('limit_time_to_use')?></th>
									<th><?=lang('count_as_work')?></th>
									<th class="col-options no-sort text-right"><?=lang('action')?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								
								if (!empty($incidents)) {
									$j =1;
									foreach ($incidents as $key => $d) { ?>
								<tr>
									<td><?php echo $j; ?></td>
									<td><?php echo ucfirst($d->incident_name);?></td>
									<td><?php echo ucfirst($d->name);?></td>
									<td><?=$d->id_code?></td>
									<td><?php echo ($d->limited_time ==1)?"Yes":'No';?></td>
									<td><?php echo ($d->count_as_work ==1)?"Yes":'No';?></td>
									<td class="text-right">		
										<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
											<ul class="dropdown-menu pull-right">											
												   
												<li>
													<a href="<?=base_url()?>incidents/edit_incident/<?=$d->id?>"  data-toggle="ajaxModal"><?php echo lang('edit_incidents');?></a>
												</li> 
												<li>
													<a href="<?=base_url()?>incidents/delete_incident/<?=$d->id?>"  data-toggle="ajaxModal"><?php echo lang('delete_incidents');?></a>
												</li>
											</ul>
										</div>										
									</td>
								</tr>
								<?php $j++; } } else{ ?>
									<tr><td colspan="8"><?php echo lang('no_results_found');?></td></tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
			</div>
			<!-- End Project Tasks -->
		</div>
	</div>
</div>