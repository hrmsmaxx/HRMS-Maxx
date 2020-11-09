<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title"><?=lang('incident_types')?></h4>
		</div>
		<div class="col-sm-4  text-right m-b-20">     
	          <a class="btn back-btn" href="<?=base_url()?>incidents"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
      	</div>
	</div>	
  <?php $this->load->view('sub_menus');?>
          <div class="card-box">
	<div class="card-box">
		<div class="row">
			<div class="col-sm-12 text-right m-b-20">
				<a class="btn add-btn" href="<?=base_url()?>incidents/add_incident_types" data-toggle="ajaxModal"><i class="fa fa-plus"></i> <?php echo lang('add_incident_types'); ?></a>
				<a class="btn add-btn m-r-5" href="<?=base_url()?>incidents"> <?php echo lang('incidents'); ?></a>
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
									<th><?=lang('id_code')?></th>
									<th><?=lang('incident_types')?></th>
									<th><?=lang('upload_to_biometirc')?></th>
									<th><?=lang('no_of_incidents')?></th>
									<th><?=lang('status')?></th>
									<th class="col-options no-sort text-right"><?=lang('action')?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$incident_types = $this -> db ->where('subdomain_id',$this->session->userdata('subdomain_id'))->get('incident_types') -> result();
								if (!empty($incident_types)) {
									$j =1;
									foreach ($incident_types as $key => $d) { ?>
								<tr>
									<td><?php echo $j; ?></td>
									<td><?php echo $d->id_code; ?></td>
									<td><?php echo ucfirst($d->name);?></td>
									<td><?php echo ($d->upload_to_device ==1)?"Active":'In-active';?></td>
									<td><?php echo $d->number_of_incidents_start.' - '.$d->number_of_incidents_end;?></td>
									<td><?php echo ($d->status ==1)?"Active":'In-active';?></td>
									<td class="text-right">										
										<a href="<?=base_url()?>incidents/edit_incident_types/<?=$d->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal">
											<i class="fa fa-edit"></i>
										</a>
										</a>
									</td>
								</tr>
								<?php $j++; } } else{ ?>
									<tr><td colspan="7"><?php echo lang('no_results_found');?></td></tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
			</div>
			<!-- End Project Tasks -->
		</div>
	</div>
</div>