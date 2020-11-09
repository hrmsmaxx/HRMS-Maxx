<div class="content">
	<div class="row">
		<div class="col-sm-8 col-xs-3">
			<?php 
			$user_id = $this->uri->segment(3);
			$username = $this->db->get_where('dgt_account_details',array('user_id'=>$user_id))->row_array();
			 $check_report_to = $this->db->get_where('users',array('id '=>$this->session->userdata('user_id')))->row_array();
			?>
			<h4 class="page-title"><?php echo $username['fullname']?><?php echo lang('okr_manager'); ?></h4>
		</div>
		<div class="col-sm-4 col-xs-9 text-right m-b-30">
			<?php if ($check_report_to['teamlead_id'] != 0) { ?>
				<a href="<?php echo base_url()?>performance/manager_performance" class="btn btn-primary rounded pull-right New-Leave" ><i class="fa fa-plus"></i> <?php echo lang('manager_performance');?></a>
			<?php } ?>
		</div>
	</div>
	<?php  if($this->session->flashdata('alert_message')){?>
	<div class="panel panel-default" id="date_alert_msg">
		<div class="panel-heading font-bold" style="color:white; background:#FF0000">
			<i class="fa fa-info-circle"></i> <?php echo lang('alert_details'); ?> 
			<i class="fa fa-times pull-right" style="cursor:pointer" onclick="$('#date_alert_msg').hide();"></i>
		</div>
		<div class="panel-body">
			<p style="color:red"> <?php echo lang('already_requested_leave_date'); ?></p>
		</div>
	</div>
	<?php  }  ?>  
	
	<?php $leav_types =  $this->db->query("SELECT * FROM `dgt_common_leave_types` where status = 0")->result_array();  ?> 

	
	
		<div class="row">
		<div class="col-md-12">
		<div class="table-responsive">
			<?php 
			$user_id = $this->uri->segment(3);
			

	  		
			$okr_details = $this->db->where('lead',$this->session->userdata('user_id'))->group_by('user_id')->order_by('id','ASC')->get('okrdetails')->result_array();
			
	   		?>
			 <table id="table-holidays" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr class="table_heading">
						<th> <?php echo lang('no.'); ?> </th>
						<th> <?php echo lang('name'); ?> </th>
						<th> <?php echo lang('designation'); ?></th>
						<th> <?php echo lang('team_lead'); ?></th>
						<th> <?php echo lang('goal_duration'); ?></th> 
						 
						
					</tr>
				</thead>
				<tbody id="admin_leave_tbl">
					<?php 
					if(!empty($okr_details)){
					 foreach($okr_details as $key => $details){  
					 $teamlead = $this->db->get_where('account_details',array('user_id'=>$details['lead']))->row_array();

					 ?>
					
					<tr>
						<td><?=$key+1?></td>
						
						<td><a class="text-info" href="<?php echo base_url()?>performance/show_okrdetails/<?=$details['id']?>"><?=$details['emp_name']?></a></td>
						<td><?=$details['position']?></td>
						<td><?=$teamlead['fullname']?></td>
						<td><?=$details['goal_duration']?></td>
											
					</tr>
				 <?php  } ?>  
				 <?php  }else{ ?>
						 <tr><td class="text-center" colspan="9"><?php echo lang('details_not_found'); ?></td></tr>
						 <?php } ?>  
				</tbody>
		   </table>    
	    </div>
		</div>
		</div>
		<!-- user leave end -->
		
		

			

		


