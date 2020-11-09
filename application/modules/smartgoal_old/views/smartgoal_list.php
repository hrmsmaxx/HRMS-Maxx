<div class="content">
	<div class="row">
		<div class="col-sm-8 col-xs-3">
			<?php 
			$user_id = $this->uri->segment(3);
			$username = $this->db->get_where('dgt_account_details',array('user_id'=>$user_id))->row_array();
			
			?>
			<h4 class="page-title"><?php echo $username['fullname']?> <?php echo lang('samrtgoal_manager'); ?></h4>
		</div>
		
	</div>
	<?php $this->load->view('sub_menus');?>

	
	
	<?php if (($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') || ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'superadmin')) { 


		
		
		  
		?>

		<div class="row">
		<div class="col-md-12">
		<div class="table-responsive">
			<?php 
			$user_id = $this->uri->segment(3);
			

	  		
			$smartgoal_details = $this->db->select('*')
							->where('subdomain_id',$this->session->userdata('subdomain_id'))
							->from('smartgoal')
							->get()->result_array();
			
	   		?>
			 <table id="table-holidays" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr class="table_heading">
						<th> <?php echo lang('no.'); ?> </th>
						<th> <?php echo lang('name'); ?> </th>
						<th> <?php echo lang('designation'); ?></th>
						<th> <?php echo lang('team_lead'); ?> </th>
						<th> <?php echo lang('duaration'); ?> </th> 
						 
						
					</tr>
				</thead>
				<tbody id="admin_leave_tbl">
					<?php 
					if(!empty($smartgoal_details)){
					 foreach($smartgoal_details as $key => $details){  
					 	$teamlead = $this->db->get_where('account_details',array('user_id'=>$details['lead']))->row_array();
					 	$account_details = $this->db->get_where('account_details',array('user_id'=>$details['user_id']))->row_array();
					 	$employee_details = $this->db->get_where('users',array('id'=>$details['user_id']))->row_array();
					 ?>
					
					<tr>
						<td><?=$key+1?></td>
						
						<td>
							<div class="user_det_list">
			                    <a href="<?php echo base_url().'employees/profile_view/'.$details['user_id'];?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
			                    <h2><a class="text-info" href="<?php echo base_url()?>smartgoal/show_smartgoal/<?=$details['id']?>"><span class="username-info"><?php echo ucfirst(user::displayName($details['user_id']));?></span>
			                    <span class="userrole-info"> <?php echo (!empty($details['position']))?$details['position']:'-';?></span>
			                    <span class="username-info"> <?php echo !empty($employee_details['id_code'])?$employee_details['id_code']:"-";?></span></a></h2>
		                  	</div>

						</td>
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
		<?php } ?>
		

			

		


