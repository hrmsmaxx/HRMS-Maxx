<div class="content">

	<div class="row">

		<div class="col-xs-4">

			<h4 class="page-title"><?php echo lang('performance');?></h4>

		</div>

	</div>

	<?php $this->load->view('sub_menus');?>

	<!-- <div class="card-box">

		<ul class="nav nav-tabs nav-tabs-solid page-tabs">

			<li><a href="<?php echo base_url(); ?>work_management/request_approval">Request & Approval</a></li>

			<li  class="active"><a href="<?php echo base_url(); ?>performance">Performance</a></li>

			<li><a href="<?php echo base_url(); ?>calendar">Calendar</a></li>

			<li><a href="<?php echo base_url(); ?>projects">Projects</a></li>

			<li><a href="<?php echo base_url(); ?>all_tasks">Tasks</a></li>

		</ul>

	</div> -->

	

	<div class="card-box">

		<div class="row">

			<div class="col-sm-8 col-xs-3">

				<?php 

				$user_id = $this->uri->segment(3);

				$username = $this->db->get_where('dgt_account_details',array('user_id'=>$user_id))->row_array();

				

				?>

				<h4 class="card-title"><?php echo $username['fullname']?> OKR Manager</h4>

			</div>

			<div class="col-sm-4 col-xs-9 text-right m-b-30">

				<?php if (($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin') && ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'superadmin')) { ?>

				

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

	

		



	

	

		<div class="row">

			<div class="col-md-12">

				<div class="table-responsive">

					<?php 

					$user_id = $this->uri->segment(3);

					



					

					$okr_details = $this->db->select('*')

									->where('subdomain_id',$this->session->userdata('subdomain_id'))
									->from('okrdetails')

									->get()->result_array();

					

					?>

					<table id="table-holidays" class="table table-hover custom-table m-b-0 AppendDataTables">

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

							<?php } ?>  

							<?php }else{ ?>

							<tr><td class="text-center" colspan="9"><?php echo lang('details_not_found'); ?></td></tr>

							<?php } ?>  

						</tbody>

				   </table>    

				</div>

			</div>

		</div>

	</div>

</div>