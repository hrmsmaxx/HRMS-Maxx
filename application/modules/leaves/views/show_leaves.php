<div class="content">
	<div class="row">
		<div class="col-sm-4 col-xs-3">
			<?php 
			$user_id = $this->uri->segment(3);
			$username = $this->db->get_where('dgt_account_details',array('user_id'=>$user_id))->row_array();
			
			?>
			<h4 class="page-title"><?php echo $username['fullname']?> <?php echo lang('leaves');?></h4>
		</div>
		<div class="col-sm-4 col-xs-6 text-right m-b-30">
			<?php if (($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin') && ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'superadmin')) { ?>
			<a href="javascript:;" class="btn btn-primary rounded pull-right New-Leave" onclick="$('.new_leave_reqst').show();$('#date_alert_msg').hide();" data-loginid="<?php echo $this->session->userdata('user_id'); ?>" ><i class="fa fa-plus"></i> <?php echo lang('new_leave_request');?></a>
			<?php } ?>
		</div>
		<div class="col-sm-4 col-xs-6 text-right m-b-20">			
            <a class="btn back-btn" href="<?=base_url()?>leaves/"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
        </div>
	</div>
	<?php  if($this->session->flashdata('alert_message')){?>
	<div class="panel panel-default" id="date_alert_msg">
		<div class="panel-heading font-bold" style="color:white; background:#FF0000">
			<i class="fa fa-info-circle"></i> <?php echo lang('alert_details')?>
			<i class="fa fa-times pull-right" style="cursor:pointer" onclick="$('#date_alert_msg').hide();"></i>
		</div>
		<div class="panel-body">
			<p style="color:red"> <?php echo lang('already_requested_leave_date')?></p>
		</div>
	</div>
	<?php  }  ?>  
	
	<?php $leav_types =  $this->db->query("SELECT * FROM `dgt_common_leave_types` where status = 0 and subdomain_id = ".$this->session->userdata('subdomain_id'))->result_array(); 
			$check_teamlead = $this->db->get_where('dgt_users',array('id'=>$this->session->userdata('user_id')))->row_array(); 

	 ?> 

	
	<?php if (($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') || ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'superadmin') || ($check_teamlead['is_teamlead'] =='yes')) { 


		
		$annual_leave = $this->db->get_where('dgt_common_leave_types',array('leave_keys'=> 'annual_leaves','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
		$sick_leave = $this->db->get_where('dgt_common_leave_types',array('leave_keys'=> 'sick','subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
		$this->db->select_sum('leave_days');
		$this->db->where('leave_keys !=','annual_leaves');
		$this->db->where('leave_keys !=','sick');
		if($username['gender'] =='male'){
			$this->db->where('leave_keys !=','maternity');
		}
		if($username['gender'] =='female'){
			$this->db->where('leave_keys !=','paternity');
		}
		$this->db->where('status','0');
		$this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
		$other_leave = $this->db->get('dgt_common_leave_types')->row_array();	

		 // echo "<pre>";	print($other_leave); exit;


		$this->db->select_sum('leave_days');
		if($username['gender'] =='male'){
			$this->db->where('leave_keys !=','maternity');
		}
		if($username['gender'] =='female'){
			$this->db->where('leave_keys !=','paternity');
		}
		$this->db->where('status','0');		
		$this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
		$total_leave = $this->db->get('dgt_common_leave_types')->row_array();


		$this->db->select_sum('leave_days');
		$annual_leave_count = $this->db->get_where('user_leaves',array('leave_type'=> 'annual_leaves','user_id'=>$user_id,'status'=>1,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

		$this->db->select_sum('leave_days');
		$sick_leave_count = $this->db->get_where('user_leaves',array('leave_type'=> 'sick','user_id'=>$user_id,'status'=>1,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

		$this->db->select_sum('leave_days');
		$this->db->where('leave_type !=','annual_leaves');
		$this->db->where('leave_type !=','sick');
		$other_leave_count = $this->db->get_where('user_leaves',array('user_id'=>$user_id,'status'=>1,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
		

		$this->db->select_sum('leave_days');
		$leave_count = $this->db->get_where('user_leaves',array('user_id'=> $user_id,'status'=>1,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();  

		$this->db->select_sum('leave_days');
		$this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
		$leave_dayss = $this->db->get('common_leave_types')->row_array();

		$sk_lops = ($sick_leave['leave_days'] - $sick_leave_count['leave_days']);
				if($sk_lops < 0 )
				{
					$sick_lop = abs($sk_lops);
				}else{
					$sick_lop = 0;
				}
				$tot_anu_count = ($annual_leave['leave_days'] - $annual_leave_count['leave_days']);
				if($tot_anu_count < 0 )
				{
					$anu_lop = abs($tot_anu_count);
				}else{
					$anu_lop = 0;
				}
				// $tot_hosp_count = ($hospiatality_leaves['leave_days'] - $total_hosp_leave);
				// if($tot_hosp_count < 0 )
				// {
				// 	$hosp_lop = abs($tot_hosp_count);
				// }else{
				// 	$hosp_lop = 0;
				// }

				$tot_other_count = ($other_leave['leave_days'] - $other_leave_count['leave_days']);
				if($tot_other_count < 0 )
				{
					$other_lop = abs($tot_other_count);
				}else{
					$other_lop = 0;
				}


				$total_lop = ($anu_lop + $sick_lop + $other_lop);
		  
		?>

		<!-- Leave Statistics -->
					<div class="row">
						<div class="col-md-3">
							<div class="stats-info">
								<h6><?php echo lang('annual_leave');?></h6>
								<h4> 
									<?php if($annual_leave_count['leave_days'] != '') { echo $annual_leave_count['leave_days']; } elseif($annual_leave_count['leave_days'] == '') { echo '0'; } ?> / <?php echo $annual_leave['leave_days'];?>
								</h4>
							</div>
						</div>
						<div class="col-md-3">
							<div class="stats-info">
								<h6><?php echo lang('sick_leave');?></h6>
								<h4><?php if($sick_leave_count['leave_days'] != '') { echo $sick_leave_count['leave_days']; } elseif($sick_leave_count['leave_days'] == '') { echo '0'; } ?> / <?php echo $sick_leave['leave_days'];?></h4>
							</div>
						</div>
						<div class="col-md-3">
							<div class="stats-info">
								<h6><?php echo lang('other_leaves');?></h6>
								<h4><?php if($other_leave_count['leave_days'] != '') { echo $other_leave_count['leave_days']; } elseif($other_leave_count['leave_days'] == '') { echo '0'; } ?> / <?php echo $other_leave['leave_days'];?></h4>
							</div>
						</div>
						<div class="col-md-3">
							<div class="stats-info">
								<h6><?php echo lang('total_leaves');?></h6>
								<h4><?php echo $leave_count['leave_days']?>/<?php echo($total_leave['leave_days'] != 0)?$total_leave['leave_days']:0;?></h4> 
								
							</div>
						</div>
						<div class="col-md-3">
							<div class="stats-info">
								<h6><?php echo lang('loss_of_pay');?></h6>
								<h4>
								<!-- <?php
								if($leave_count['leave_days'] > $leave_dayss['leave_days'])
								{
									$lop = $leave_count['leave_days'] - $leave_dayss['leave_days'];
								} 
								else
								{
									$lop = 0;
									
								}
								?><?php echo $lop?> -->
								<?php  echo $total_lop;?>
								</h4>
							</div>
						</div>
					</div>
					<!-- /Leave Statistics -->






	

		<div class="row">
		<div class="col-md-12">
		<div class="table-responsive">
			<?php 
			$user_id = $this->uri->segment(3);
			

	  		
			$leave_details = $this->db->query("SELECT DISTINCT ul.*,lt.leave_type as l_type,ad.fullname
										FROM `dgt_user_leaves` ul
										left join dgt_common_leave_types lt on lt.leave_keys = ul.leave_type
										left join dgt_account_details ad on ad.user_id = ul.user_id 
										where ul.user_id='".$user_id."' ")->result_array();
			 // print_r($leave_details); exit;
	   		?>
			 <table id="table-holidays" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr class="table_heading">						  
						<th> <?php echo lang('no');?> </th>
						<th> <?php echo lang('leave_type');?> </th>
						<th> <?php echo lang('from');?> </th>
						<th> <?php echo lang('to');?> </th>
						<th> <?php echo lang('reason');?> </th> 
						<th> <?php echo lang('no_of_days');?> </th>
						<th> <?php echo lang('status');?> </th>    
						<th> <?php echo lang('approval_reason');?> </th>  
					</tr>
				</thead>
				<tbody id="admin_leave_tbl">
					<?php 
					if(!empty($leave_details)){
					 foreach($leave_details as $key => $details){  ?>
					
					<tr>
						<td><?=$key+1?></td>
						
						<td><?php echo (!empty($details['l_type']))?$details['l_type']:'Incident'?></td>
						<td><?=date('d-m-Y',strtotime($details['leave_from']))?></td>
						<td><?=date('d-m-Y',strtotime($details['leave_to']))?></td>
						<td width="30%"><?=$details['leave_reason']?></td>
						<td>
							<?php 
							echo $details['leave_days'];
							if($details['leave_day_type'] == 1){
								echo ' ( '.lang('full_day').' )';
							}else if($details['leave_day_type'] == 2){
								echo ' ( '.lang('first_half').' )';
							}else if($details['leave_day_type'] == 3){
								echo ' (  '.lang('second_half').' )';
							}?>
						  </td>
						<td>
						<?php
						if($details['status'] == 4){
								echo '<span class="label label-info"> '.lang('tl_approved').'</span><br>';
								echo '<span class="label label-danger"> '.lang('management_pending').'</span>';
							}else if($details['status'] == 7){
										echo '<span class="label label-danger"> '.lang('deleted').' </span>';
									}
							if($details['status'] == 0){
								echo ' <span class="label" style="background:#D2691E"> '.lang('pending').' </span>';
							}else if($details['status'] == 1){
								echo '<span class="label label-success"> '.lang('approved').' </span> ';
							}else if($details['status'] == 2){
								echo '<span class="label label-danger"> '.lang('rejected').'</span>';
							}else if($details['status'] == 3){
								echo '<span class="label label-danger"> '.lang('cancelled').'</span>';
							}
							?>
						</td>
						<td><?php echo $details['reason']?$details['reason']:'-'; ?></td>
					</tr>
				 <?php  } ?>  
				 <?php  }else{ ?>
						 <tr><td class="text-center" colspan="9"><?php echo lang('no_records_found');?></td></tr>
						 <?php } ?>  
				</tbody>
		   </table>    
	    </div>
		</div>
		</div>
		<!-- user leave end -->
		<?php } ?>
		

			

		


