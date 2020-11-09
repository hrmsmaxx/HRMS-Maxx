<?php $departments = $this->db->order_by("deptname", "asc")->get('departments')->result(); ?>
<div class="content">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title m-b-0"><?php echo lang('employee_management');?></h4>
			<!-- <ul class="breadcrumb m-b-30 p-l-0" style="background:none; border:none;">
				<li><a href="#">Home</a></li>
				<li><a href="#">Employees</a></li>
				<li><a href="#">Shift Schedule</a></li>
				<li class="active">Daily Schedule</li>
			</ul> -->
		</div>
		<div class="col-sm-4  text-right m-b-20">     
	          <a class="btn back-btn" href="<?=base_url()?>shift_scheduling"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
      	</div>
	</div>
	<?php $this->load->view('sub_menus');?>
	
	
	<div class="card-box">
		<div class="row">
			<div class="col-sm-5">
				<h4 class="page-title"><?php echo lang('shift_list');?></h4>
			</div>
			<div class="col-sm-7 text-right m-b-30">
				<a href="<?php echo base_url(); ?>shift_scheduling/add_schedule" class="btn add-btn"><?php echo lang('assign_shifts');?></a>
				<a href="<?php echo base_url(); ?>shift_scheduling/add_shift" class="btn add-btn m-r-5"><?php echo lang('add_shift');?></a>				
			</div>
		</div>
		<!-- /Page Title -->
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table m-b-0" id="shifts">
						<thead>
							<tr>
								<th><b>#</b></th>							
								<th><b><?php echo lang('shift_id');?></b></th>						
								<th><b><?php echo lang('shift_name');?></b></th>						
								<!-- <th><b><?php echo lang('rotary_group');?></b></th>					 -->
								<th><b><?php echo lang('min_start_time');?></b></th>	
								<th><b><?php echo lang('start_time');?></b></th>				
								<th><b><?php echo lang('max_start_time');?></b></th>					
								<th><b><?php echo lang('min_end_time');?></b></th>						
								<th><b><?php echo lang('end_time');?></b></th>						
								<th><b><?php echo lang('max_end_time');?></b></th>						
								<th><b><?php echo lang('work_time');?></b></th>						
								<th><b><?php echo lang('break_time');?></b></th>						
								<th><b><?php echo lang('note');?></b></th>						
								<th><b><?php echo lang('status');?></b></th>						
								<th><b><?php echo lang('actions');?></b></th>						
								
							</tr>
						</thead>
						<tbody>
						<?php 
						if (count($shifts) > 0) {
							$i=1;
							foreach ($shifts as $shift) { 
								// $rotary_schedule_group = $this->db->get_where('rotary_schedule_group',array('id'=>$shift['group_id']))->row_array();  
								?>
								<td><?php echo $i ;?></td>
								<td><?php echo $shift['id_code']; ;?></td>
								<td><?php echo $shift['shift_name'];?></td>
								<!-- <td><?php echo !empty($rotary_schedule_group)?$rotary_schedule_group['group_name']:"-";?></td> -->
								<td><?php echo ($shift['min_start_time'] !='00:00:00')?date('h:i:s a', strtotime($shift['min_start_time'])):'-';?></td>
								<td><?php echo ($shift['start_time'] !='00:00:00')?date('h:i:s a', strtotime($shift['start_time'])):'-';?></td>
								<td><?php echo ($shift['max_start_time'] !='00:00:00')?date('h:i:s a', strtotime($shift['max_start_time'])):'-';?></td>
								<td><?php echo ($shift['min_end_time'] !='00:00:00')?date('h:i:s a', strtotime($shift['min_end_time'])):'-';?></td>
								<td><?php echo ($shift['end_time'] !='00:00:00')?date('h:i:s a', strtotime($shift['end_time'])):'-';?></td>
								<td><?php echo ($shift['max_end_time'] !='00:00:00')?date('h:i:s a', strtotime($shift['max_end_time'])):'-';?></td>
								<td><?php echo $shift['work_hours'].' HS';?></td>
								<td><?php echo $shift['break_time'].' mins';?></td>
								<td><?php echo $shift['tag'];?></td>
								<td><?php echo ($shift['published'] == 1)?'Active':'In-active';?></td>
								<td class="text-right">									
			                        <div class="dropdown">
										<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#">
											<i class="fa fa-ellipsis-v"></i>
										</a>
			                          <ul class="dropdown-menu pull-right">
			                            <?php if (User::is_admin()) { ?>

			                            <li><a href="<?=base_url()?>shift_scheduling/edit_shift/<?=$shift['id']?>"><?=lang('edit_shift')?></a></li>
			                            <li><a href="<?=base_url()?>shift_scheduling/delete_shift/<?=$shift['id']?>" data-toggle="ajaxModal" title="<?=lang('delete_shift')?>"><?=lang('delete_shift')?></a></li>
			                                
			                            <?php } ?>

			                          </ul>
			                        </div>
								</td>
							</tr>
							<?php $i++; } 
						} else{ ?>
							<tr>
								<td colspan="11"><?php echo lang('no_records_found');?></td>
							</tr>
						<?php } ?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
