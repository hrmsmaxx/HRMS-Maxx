<div class="content">
	<div class="row">
		<div class="col-sm-8 col-xs-3">
			
			<h4 class="page-title"><?php echo lang('360_performance'); ?></h4>
		</div>		
	</div>
	<?php $this->load->view('sub_menus');?>
	

		<div class="row">
		<div class="col-md-12">
		<div class="table-responsive">
			<?php 
			// $user_id = $this->uri->segment(3);
				  		
			
					
			
	   		?>
			 <table id="table-holidays" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr class="table_heading">
						<th> <?php echo lang('no.'); ?></th>
						<th> <?php echo lang('name'); ?></th>
						<th> <?php echo lang('designation'); ?></th>
						<th> <?php echo lang('team_lead'); ?></th>
						<th> <?php echo lang('goal_duration'); ?></th> 
						 
						
					</tr>
				</thead>
				<tbody id="admin_leave_tbl">
					<?php 
					if(!empty($performances_360)){
					 foreach($performances_360 as $key => $details){

					 	$employee_details = $this->db->get_where('users',array('id'=>$details['user_id']))->row_array();
$designation = $this->db->get_where('designation',array('id'=>$employee_details['designation_id']))->row_array();
$account_details = $this->db->get_where('account_details',array('user_id'=>$details['user_id']))->row_array();
$team_lead = $this->db->get_where('account_details',array('user_id'=>$employee_details['teamlead_id']))->row_array();
$teamlead = $this->db->get_where('account_details',array('user_id'=>$team_lead['user_id']))->row_array();
					   ?>
					
					<tr>
						<td><?=$key+1?></td>
						
						<td><a class="text-info" href="<?php echo base_url()?>performance_three_sixty/show_performance_three_sixty/<?=$details['user_id']?>"><?=$account_details['fullname']?></a></td>
						<td><?php echo $designation['designation']?></td>
						<td><?=$teamlead['fullname']?></td>
						<td>
							<?php if($details['goal_duration'] == 1){
								echo '90 Days';
							} elseif($details['goal_duration'] == 2){
								echo "6 Months";
							} else {
								echo "1 Year";
							}?>
								
						</td>
											
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
		

			

		


