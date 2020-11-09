<div class="content">  
	<div class="row">
		<div class="col-xs-4">
			<h4 class="page-title"><?php echo lang('payroll');?></h4>
		</div>
	</div>
    <?php $this->load->view('sub_menus');?>
	
	<!-- <div class="card-box">
		<ul class="nav nav-tabs nav-tabs-solid page-tabs">
			<li><a href="<?php echo base_url(); ?>organisation">Org Structure</a></li>
			<li><a href="<?php echo base_url(); ?>employees">Employees</a></li>
			<li><a href="<?php echo base_url(); ?>attendance">Time & Attendance</a></li>
			<li><a href="<?php echo base_url(); ?>leaves">Leave</a></li>
			<li class="active"><a href="<?php echo base_url(); ?>payroll">Payroll</a></li>
			<li><a href="<?php echo base_url(); ?>resignation">Employees Status</a></li>
			<li><a href="<?php echo base_url(); ?>policies">Policies</a></li>
			<li><a href="<?php echo base_url(); ?>employees/employee_category">Categories</a></li>
			<li><a href="<?php echo base_url(); ?>employees/vacancy">Vacancy</a></li>
			<li><a href="<?php echo base_url(); ?>notice_board">Notices</a></li>
		</ul>
	</div> -->

	<div class="card-box">
	<div class="row">
		<div class="col-xs-4">
			<h4 class="page-title"><?=lang('pay_slip');?></h4>
		</div>
		<div class="col-xs-8 text-right m-b-30">
			<a class="btn btn-primary rounded pull-right" href="#" data-toggle="modal" data-target="#run_payroll"><?php echo lang('run_payroll'); ?></a>
		</div>
	</div>
	<?php  
//	if (($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') || ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'superadmin')) { ?>
	<div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
	   <?php $branch_id = $this->session->userdata('branch_id');

	    if($branch_id != '') {
	    	$users_list = $this->db->query("SELECT u.*,ad.*,d.designation,(select concat(amount,'[^]',date_created) from dgt_salary where user_id = u.id order by id desc limit 1) as salary_det
									FROM `dgt_users` u  
									left join dgt_account_details ad on ad.user_id = u.id 
									left join dgt_designation d on d.id=u.designation_id
									where u.activated = 1 and u.role_id = 3 and u.branch_id IN(".$branch_id.") and u.subdomain_id = '".$this->session->userdata('subdomain_id')."' order by u.created desc")->result_array();
	    } else {
	    	$users_list = $this->db->query("SELECT u.*,ad.*,d.designation,(select concat(amount,'[^]',date_created) from dgt_salary where user_id = u.id order by id desc limit 1) as salary_det
									FROM `dgt_users` u  
									left join dgt_account_details ad on ad.user_id = u.id 
									left join dgt_designation d on d.id=u.designation_id
									where u.activated = 1 and u.role_id = 3 and u.subdomain_id = '".$this->session->userdata('subdomain_id')."' order by u.created desc")->result_array();
	    }  ?>
	   <table id="table-users" class="table table-hover custom-table m-b-0 AppendDataTables">
			<thead>
				<tr>
					<th> # </th> 
					<th> <?php echo lang('fullname'); ?> </th> 
					<th> <?php echo lang('current_salary'); ?> </th>
					<th> <?php echo lang('designation'); ?> </th>
					<th class="hidden-sm"><?php echo lang('joining_date'); ?></th>
					<th class="text-right"><?php echo lang('payroll_status'); ?></th>
					<th class="col-options no-sort text-right"><?php echo lang('options'); ?></th>
				</tr>
			 </thead>
			 <tbody>
				<?php  foreach($users_list as $key => $usrs){  ?>
				<tr>
					<td><?=$key+1?></td>
					<td>

						<div class="user_det_list">
		                    <a href="<?php echo base_url().'employees/profile_view/'.$usrs['user_id'];?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $usrs['avatar']?>"></a>
		                    <h2><span class="username-info"><?php echo ucfirst(user::displayName($usrs['user_id']));?></span>
		                    <span class="userrole-info"> <?php echo $usrs['designation'];?></span>
		                    <span class="username-info"> <?php echo !empty($usrs['id_code'])?$usrs['id_code']:"-";?></span></h2>
	                  	</div>	
						
					</td> 
					
					<td>  
					<?php
						$salary = ''; 
						if(isset($usrs['salary_det'])&& $usrs['salary_det'] != ''){
							$exp = explode('[^]',$usrs['salary_det']);
							if($exp[0] != 0){ $salary = $exp[0]; }
						} 

						$user_details = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$usrs['user_id']))->row_array();
						?>
						<strong> <?php echo  $user_details['salary']?$user_details['salary']:'N/A'; ?> </strong> 
					</td>
					<td>
						<span class="label label-info"><?php echo $usrs['designation'];?></span>
					</td>
					<td>
						<?=strftime(config_item('date_format'), strtotime($usrs['doj']));?>
					</td> 
					<td> 
						<span class="status-toggle pull-right">
							<input type="checkbox" value="1" class="check" onchange="user_status_change(<?php echo $usrs['user_id'];?>)" id="payroll_user_status<?php echo $usrs['user_id'];?>" <?php if($usrs['status']=='1') echo'checked' ;?>>
							<label class="checktoggle" for="payroll_user_status<?php echo $usrs['user_id'];?>"><?php echo lang('checkbox'); ?></label>
						</span>
					</td> 
					<td class="text-right">
						<!-- <a class="btn btn-success btn-xs" data-toggle="ajaxModal" href="<?=base_url()?>payroll/edit_salary/<?=$usrs['user_id']?>" title="Edit Salary" data-original-title="Edit Salary">
							<i title="Edit Salary" class="fa fa-suitcase"></i>
						</a>
						<a class="btn btn-danger btn-xs" data-toggle="ajaxModal" href="<?=base_url()?>payroll/create/<?=$usrs['user_id']?>" title="Create Pay Slip" data-original-title="Create Pay Slip">
							<i title="Create Pay Slip" class="fa fa-money"></i>
						</a>     -->

						<a class="btn btn-danger btn-xs"  href="<?=base_url()?>payroll/payslip/<?=$usrs['user_id']?>" title="<?php echo lang('view_pay_slip') ?>" >
							<i title="<?php echo lang('view_pay_slip') ?>" class="fa fa-money"></i>
					</td>
				</tr>
				<?php } ?>  
			</tbody>
	   </table>   
		</div>
		</div> 
   </div>
   </div>
   <?php // } ?>
</div>

<!-- Run Payroll Modal -->
<div class="modal custom-modal center-modal fade" id="run_payroll" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-head">
					<h3><?php echo lang('run_payroll'); ?></h3>
					<p><?php echo lang('are_you_sure_want_to_run_payroll'); ?></p>

				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-xs-6">
							<a href="<?php echo base_url();?>payroll/run_payroll" class="btn btn-primary continue-btn"><?php echo lang('yes'); ?></a>
						</div>
						<div class="col-xs-6">
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?php echo lang('no'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Run Payroll Modal -->