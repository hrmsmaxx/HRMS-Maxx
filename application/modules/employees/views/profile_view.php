<?php if(!empty($this->uri->segment(4))){

    $active_tab = $this->uri->segment(4);

} else {
  $active_tab = 'profile';
}?>


<?php 
// echo $document_type; exit;
$check_teamlead = $this->db->get_where('dgt_users',array('id'=>$employee_details['user_id']))->row_array();
//echo "<pre>"; echo $personal_details['education_details']; exit; ?>
<div class="content container-fluid">
	<!-- Page Title -->
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title"><?php echo lang('profile');?></h4>
		</div>
		<div class="col-sm-4 text-right m-b-20">			
            <a class="btn back-btn" href="<?=base_url()?>employees/"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
        </div>
	</div>
	<!-- /Page Title -->

	<div class="card-box m-b-0">
		<div class="row">
			<div class="col-md-12">
				<div class="profile-view">
					<div class="profile-img-wrap">
						<div class="profile-img">
							<a href="#"><img class="avatar" src="<?php echo base_url(); ?>assets/avatar/<?php echo $employee_details['avatar']; ?>" alt=""></a>
						</div>
					</div>
					<div class="profile-basic">
						<div class="row">
							<div class="col-md-5">
								<div class="profile-info-left">
									<h3 class="user-name m-t-0 m-b-0"><?php echo $employee_details['fullname']; ?></h3>
									<?php $des = $this->db->get_where('designation',array('id'=>$employee_details['designation_id']))->row_array(); ?>
									<?php $dept = $this->db->get_where('departments',array('deptid'=>$employee_details['department_id']))->row_array(); ?>
									<small class="text-muted"><?php echo $des['designation']; ?></small>
									<!-- <div class="staff-id">Employee ID : <?php echo 'FT-00'.$employee_details['user_id']; ?></div> -->
									<div class="staff-id"><?=lang('employee_id_code'); ?> : <?php echo $employee_details['id_code']; ?></div>
									<div class="small text-muted"><?=lang('started'); ?> : <?php echo date('d-M-Y',strtotime($employee_details['doj'])); ?></div>
									<?php if($this->session->userdata('role_id') == 1){ ?>
									<!-- <div class="staff-msg"><a href="<?php echo base_url(); ?>chats" class="btn btn-custom">Send Message</a></div> -->
								<?php } ?>
								</div>
							</div>
							<div class="col-md-7">
								<ul class="personal-info">
									<li>
										<span class="title"><?php echo lang('phone');?>:</span>
										<span class="text"><a href=""><?php echo $employee_details['phone']; ?></a></span>
									</li>
									<li>
										<span class="title"><?php echo lang('email');?>:</span>
										<span class="text"><a href=""><?php echo $employee_details['email']; ?></a></span>
									</li>
									<li>
										<span class="title"><?php echo lang('birthday');?>:</span>
										<span class="text"><?php echo $employee_details['dob']?date('d-M-Y',strtotime($employee_details['dob'])):'-'; ?></span>
									</li>
									<li>
										<span class="title"><?php echo lang('address');?>:</span>
										<span class="text"><?php echo $employee_details['address']?$employee_details['address'].' '.$employee_details['city'].' '.$employee_details['state'].' '.$employee_details['country']:''; ?></span>
									</li>
									<li>
										<span class="title"><?php echo lang('gender');?>:</span>
										<span class="text"><?php echo $employee_details['gender']; ?></span>
									</li>
									<li>
										<span class="title"><?php echo lang('reporting_to');?>:</span>
										<span class="text">
										   <div class="avatar-box">
										   	<?php
										   	if($employee_details['teamlead_id'] != 0){
										   	 $reporting_to = $this->db->get_where('account_details',array('user_id'=>$employee_details['teamlead_id']))->row_array(); 
										   	
										   	if(count($reporting_to) != 0 ){
												   	if($reporting_to['avatar'] == '')
												   	{
												   		$pro_pic = base_url().'assets/avatar/default_avatar.jpg';
												   	}else{
												   		$pro_pic = base_url().'assets/avatar/'.$reporting_to['avatar'];
												   	}
										   	?>
											  <div class="avatar avatar-xs">
												 <img src="<?php echo $pro_pic;?>" alt="">
											  </div>
										   </div>
										   <!-- <a href="<?php echo base_url().'employees/profile_view/'.$employee_details['teamlead_id']?>"> -->
												<h4 class="user-name"><?php echo $reporting_to['fullname']; ?></h4>
											<!-- </a> -->
										<?php }
									}else{ ?>
											<div class="avatar avatar-xs">
												 <img src="<?php echo base_url().'assets/avatar/default_avatar.jpg'; ?>" alt="">
											  </div>
										   </div>
										   <a href="">
												-
											</a>
										<?php } ?>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="pro-edit"><a href="#" class="edit-icon" data-toggle="modal" data-target="#profile_info"><i class="fa fa-pencil"></i></a></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="card-box tab-box">
		<div class="row user-tabs">
			<div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
				<ul class="nav nav-tabs nav-tabs-bottom">
					<li class="active"><a href="#emp_profile" data-toggle="tab"><?php echo lang('profile');?></a></li>
					<?php if(($this->session->userdata('role_id') != 2) && ($this->session->userdata('role_id') != 3)){ ?>
					<li><a href="#bank_statutory" data-toggle="tab"><?php echo lang('bank_statutory');?></a></li>
					<li><a href="#tab_additions" data-toggle="tab"><?php echo lang('payroll_addition');?></a></li>
					<li><a href="#tab_deductions" data-toggle="tab"><?php echo lang('payroll_deduction');?></a></li>
					<?php } ?>
					<?php if($this->session->userdata('role_id') == 3){ ?>
						<li><a href="#tab_overtime" data-toggle="tab"><?php echo lang('overtime');?></a></li>
					<?php } ?>
					<?php if($check_teamlead['is_teamlead'] == 'yes'){ ?>
						<li><a href="#tab_teamovertime" data-toggle="tab"><?php echo lang('team_overtime');?></a></li>
					<?php } ?>
					<li><a href="#tab_leaves" data-toggle="tab"><?php echo lang('leaves');?></a></li>					
					<li class="<?php echo ($active_tab == 'file_attach' )?'active':'';?>"><a href="#file_attach" data-toggle="tab"><?php echo lang('file_attachments');?></a></li>
				</ul>
			</div>
		</div>
	</div>
	
					<div class="tab-content">
					
						<!-- Profile Info Tab -->
						<?php $personal_info = json_decode($personal_details['personal_info']); ?>
						<div id="emp_profile" class="pro-overview tab-pane fade in <?php echo ($active_tab != 'file_attach' )?'active':'';?>">
							<div class="row">
								<div class="col-md-6">
									<div class="card-box profile-box">
										<h3 class="card-title"><?php echo lang('personal_informations');?> <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
										<ul class="personal-info">
											<li>
												<span class="title"><?=lang('passport_no'); ?>.</span>
												<span class="text"><?php echo $personal_info->passport_no; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('passport_exp_date'); ?>. <?php echo $personal_info->passport_expiry; ?></span>
												<span class="text"><?php if($personal_info->passport_expiry !='') echo date('d M Y',strtotime($personal_info->passport_expiry));else echo lang('nil'); ?></span>
											</li>
											<li>
												<span class="title"><?=lang('tel'); ?></span>
												<span class="text"><a href=""><?php echo $personal_info->tel_number; ?></a></span>
											</li>
											<li>
												<span class="title"><?=lang('nationality'); ?></span>
												<span class="text"><?php echo $personal_info->nationality; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('religion'); ?></span>
												<span class="text"><?php echo $personal_info->religion; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('marital_status'); ?></span>
												<span class="text"><?php echo $personal_info->marital_status; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('employement_of_spouse'); ?></span>
												<span class="text"><?php echo $personal_info->spouse; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('no_of_children'); ?></span>
												<span class="text"><?php echo $personal_info->no_children; ?></span>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-6">
									<?php $emergency_info = json_decode($personal_details['emergency_info']); ?>
									<div class="card-box profile-box">
										<h3 class="card-title"><?=lang('emergency_contact'); ?> <a href="#" class="edit-icon" data-toggle="modal" data-target="#emergency_contact_modal"><i class="fa fa-pencil"></i></a></h3>
										<h5 class="section-title">Primary</h5>
										<ul class="personal-info">
											<li>
												<span class="title"><?=lang('name'); ?></span>
												<span class="text"><?php echo $emergency_info->contact_name1; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('relationship'); ?></span>
												<span class="text"><?php echo $emergency_info->relationship1; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('phone'); ?> </span>
												<span class="text"><?php echo $emergency_info->contact1_phone1; ?> <?php echo $emergency_info->contact1_phone2; ?></span>
											</li>
										</ul>
										
										<h5 class="section-title"><?=lang('secondary'); ?></h5>
										<ul class="personal-info">
											<li>
												<span class="title"><?=lang('name'); ?></span>
												<span class="text"><?php echo $emergency_info->contact_name2; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('relationship'); ?></span>
												<span class="text"><?php echo $emergency_info->relationship2; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('phone'); ?> </span>
												<span class="text"><?php echo $emergency_info->contact2_phone1; ?> <?php echo $emergency_info->contact2_phone2; ?></span>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="card-box profile-box">
										<?php $bank_info = json_decode($personal_details['bank_info']); ?>
										<h3 class="card-title"><?=lang('bank_information'); ?> <?php if($this->session->userdata('role_id') != 3){ ?><a href="#" class="edit-icon" data-toggle="modal" data-target="#bank_iformation_modal"><i class="fa fa-pencil"></i></a> <?php } ?></h3>
										<ul class="personal-info">
											<li>
												<span class="title"><?=lang('bank_name'); ?></span>
												<span class="text"><?php echo $bank_info->bank_name; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('bank_acc_no'); ?></span>
												<span class="text"><?php echo $bank_info->bank_ac_no; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('ifsc_code'); ?></span>
												<span class="text"><?php echo $bank_info->ifsc_code; ?></span>
											</li>
											<li>
												<span class="title"><?=lang('pan_no'); ?></span>
												<span class="text"><?php echo $bank_info->pan_no; ?></span>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-box profile-box">
										<h3 class="card-title"><?=lang('family_informations'); ?> <a href="#" class="edit-icon" data-toggle="modal" data-target="#family_info_modal"><i class="fa fa-pencil"></i></a></h3>
										<div class="table-responsive">
									<table class="table table-nowrap">
											<thead>
												<tr>
													<th><?=lang('name'); ?></th>
													<th><?=lang('relationship'); ?></th>
													<th><?=lang('dob'); ?></th>
													<th><?=lang('phone'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php $personal_info = json_decode($personal_details['family_members_info']); 
														// echo "<pre>"; print_r($personal_info); exit;
														if(count($personal_info) != 0)
														{
														foreach ($personal_info as $per) {
												?>
												<tr>
													<td><?php echo $per->member_name; ?></td>
													<td><?php echo $per->member_relationship; ?></td>
													<td><?php echo $per->member_dob; ?></td>
													<td><?php echo $per->member_phone; ?></td>
												</tr>
											<?php } }else{ ?>
												<tr><td colspan="4"><div class="no-results"><?=lang('no_data_found'); ?></div></td></tr>
											<?php } ?>
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="card-box user-box">
										<h3 class="card-title"><?=lang('education_information'); ?> <a href="#" class="edit-icon" data-toggle="modal" data-target="#education_info"><i class="fa fa-pencil"></i></a></h3>
										<?php $education_details = json_decode($personal_details['education_details']); 
										// echo "<pre>"; print_r($education_details); exit;
										?>
										<div class="experience-box">
											<ul class="experience-list">
												<?php if($education_details != ''){ 
													foreach ($education_details as $education_detail) {
													?>
													<li>
														<div class="experience-user">
															<div class="before-circle"></div>
														</div>
														<div class="experience-content">
															<div class="timeline-content">
																<a href="#/" class="name"><?php echo $education_detail->institute; ?></a>
																<div><?php echo $education_detail->degree; ?></div>
																<span class="time"><?php echo $education_detail->start_date; ?> - <?php echo $education_detail->end_date; ?></span>
															</div>
														</div>
													</li>
												<?php } }else{ ?>
													<li><div class="no-results"><?=lang('not_updated'); ?></div></li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card-box user-box">
										<h3 class="card-title"><?=lang('experience'); ?> <a href="#" class="edit-icon" data-toggle="modal" data-target="#experience_info"><i class="fa fa-pencil"></i></a></h3>
										<div class="experience-box">
											<ul class="experience-list">
											    <?php $personal_detailss = json_decode($personal_details['personal_details']);
											        foreach($personal_detailss as $personal_detail){
            										?>
												<li>
													<div class="experience-user">
														<div class="before-circle"></div>
													</div>
													<div class="experience-content">
														<div class="timeline-content">
															<a href="#/" class="name"><?php echo $personal_detail->job_position; ?> at <?php echo $personal_detail->company_name; ?></a>
															<span class="time"><?php echo date('d M Y',strtotime($personal_detail->period_from)); ?> - <?php echo date('d M Y',strtotime($personal_detail->period_from)); ?></span>
														</div>
													</div>
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Profile Info Tab -->


						<?php 
							$bank_statutories = $this->db->get_where('bank_statutory',array('user_id'=>$employee_details['user_id']))->row_array(); 
							$in_bank_statutories = json_decode($bank_statutories['bank_statutory']);
							// echo $in_bank_statutories->pf_contribution; exit;
							// print_r($in_bank_statutories); exit;
						?>

						<!-- Bank Statutory Tab -->
						<div class="tab-pane fade" id="bank_statutory">
							<div class="card">
								<div class="card-body">
									<h3 class="card-title"> <?=lang('basic_salary_information'); ?> </h3>
									<form method="post" id="bank_statutory_form" action="<?php echo base_url(); ?>employees/bank_statutory">
										<div class="row">
											<!-- <div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label">Salary basis <span class="text-danger">*</span></label>
													<select class="form-control" >
														<option value="" disabled>Select salary basis type</option>
														<option value="HOURLY">Hourly</option>
														<option value="DAILY">Daily</option>
														<option value="WEEKLY">Weekly</option>
														<option value="MONTHLY">Monthly</option>
													</select>
											   </div>
											</div> -->
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('salary_amt'); ?> <small class="text-muted"><?=lang('per_month'); ?></small></label>
													<div class="input-group">
														<div class="input-group-addon">
															<span class="input-group-text">$</span>
														</div>
														<input type="text" class="form-control" name="user_salary" id="user_salary" placeholder="<?=lang('type_your_salary_amt'); ?>" value="<?php echo $bank_statutories['salary']; ?>" >
														<input type="hidden" name="bankuser_id" id="bankuser_id" value="<?php echo $employee_details['user_id']; ?>">
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?= lang('payment_type'); ?></label>
													<select class="form-control" name="payment_type" id="payment_type">
														<option value="" disabled><?= lang('select_payment_type')?></option>
														<option value="bank" <?php if($bank_statutories['payment_type'] == 'bank'){ echo "selected"; } ?>><?= lang('bank_transfer')?></option>
														<option value="cheque" <?php if($bank_statutories['payment_type'] == 'cheque'){ echo "selected"; } ?>><?= lang('cheque')?></option>
														<option value="cash" <?php if($bank_statutories['payment_type'] == 'cash'){ echo "selected"; } ?>><?= lang('cash')?></option>
													</select>
											   </div>
											</div>
										</div>
										<hr>
										<h3 class="card-title"> <?=lang('pf_information'); ?></h3>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('pf_contribution'); ?></label>
													<select class="form-control " name="pf_contribution" id="pf_contribution">
														<option value="" disabled><?=lang('select_pf_contribution'); ?></option>
														<option value="yes" <?php if($in_bank_statutories->pf_contribution == 'yes'){ echo "selected"; } ?>><?=lang('yes'); ?></option>
														<option value="no" <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "selected"; } ?>><?=lang('no'); ?></option>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('pf_no'); ?>. <span class="text-danger">*</span></label>
													<input type="text" class="form-control PFrecords" name="pf_no" id="pf_no" placeholder="<?=lang('type_your_pf_no'); ?>" value="<?php echo $in_bank_statutories->pf_no; ?>" <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('emp_pf_rate'); ?></label>
													<select class="form-control PFrecords" name="pf_rates" id="pf_rates" <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
														<option value="" disabled><?=lang('select_pf_contribution'); ?></option>
														<option value="yes" <?php if($in_bank_statutories->pf_rates == 'yes'){ echo "selected"; } ?>><?=lang('yes'); ?></option>
														<option value="no" <?php if($in_bank_statutories->pf_rates == 'no'){ echo "selected"; } ?>><?=lang('no'); ?></option>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('additional_rate'); ?>(%) <span class="text-danger">*</span></label>
													<input type="text" class="form-control PFrecords EMprate" name="pf_add_rates" id="pf_add_rates" placeholder="N/A" value="<?php echo $in_bank_statutories->pf_add_rates; ?>" <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('total_rate'); ?></label>
													<input type="text" class="form-control PFrecords EMprate" name="pf_total_rate" id="pf_total_rate" placeholder="<?=lang('amount'); ?>"  value="<?php echo $in_bank_statutories->pf_total_rate; ?>" readonly <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('emp_pf_rate'); ?></label>
													<select class="form-control PFrecords" name="pf_employer_contribution" id="pf_employer_contribution" <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
														<option value="" disabled><?=lang('select_pf_contribution'); ?></option>
														<option value="yes" <?php if($in_bank_statutories->pf_employer_contribution == 'yes'){ echo "selected"; } ?>><?=lang('yes'); ?></option>
														<option value="no" <?php if($in_bank_statutories->pf_employer_contribution == 'no'){ echo "selected"; } ?>><?=lang('no'); ?></option>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('additional_rate'); ?>(%) <span class="text-danger">*</span></label>
													<input type="text" class="form-control PFrecords EmprRate" name="employer_add_rates" id="employer_add_rates" placeholder="N/A"  value="<?php echo $in_bank_statutories->employer_add_rates; ?>" <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('total_rate'); ?></label>
													<input type="text" class="form-control PFrecords EmprRate" name="employer_total_rates" id="employer_total_rates" placeholder="<?=lang('amount'); ?>"  value="<?php echo $in_bank_statutories->employer_total_rates; ?>" readonly <?php if($in_bank_statutories->pf_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
										</div>
										
										<hr>
										<h3 class="card-title"> <?=lang('esi_information'); ?></h3>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('esi_contribution'); ?>ESI contribution</label>
													<select class="form-control" name="esi_contribution" id="esi_contribution">
														<option value="" disabled><?=lang('select_esi_information'); ?></option>
														<option value="yes" <?php if($in_bank_statutories->esi_contribution == 'yes'){ echo "selected"; } ?>><?=lang('yes'); ?></option>
														<option value="no" <?php if($in_bank_statutories->esi_contribution == 'no'){ echo "selected"; } ?>><?=lang('no'); ?></option>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('esi_no'); ?>. <span class="text-danger">*</span></label>
													<input type="text" class="form-control ESIrecords" name="esi_no" id="esi_no" placeholder="<?=lang('type_your_esi_no'); ?>"  value="<?php echo $in_bank_statutories->esi_no; ?>" <?php if($in_bank_statutories->esi_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('emp_esi_rate'); ?></label>
													<select class="form-control ESIrecords" name="esi_rate" id="esi_rate" <?php if($in_bank_statutories->esi_contribution == 'no'){ echo "disabled"; } ?>>
														<option value="" disabled><?=lang('select_esi_rate'); ?></option>
														<option value="yes" <?php if($in_bank_statutories->esi_rate == 'yes'){ echo "selected"; } ?> ><?=lang('yes'); ?></option>
														<option value="no" <?php if($in_bank_statutories->esi_rate == 'no'){ echo "selected"; } ?> ><?=lang('no'); ?></option>
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('additional_rate'); ?>(%) <span class="text-danger">*</span></label>
													<input type="text" class="form-control ESIrecords ESIRates" name="esi_add_rate" id="esi_add_rate" placeholder="<?=lang('rates');?>(%)"  value="<?php echo $in_bank_statutories->esi_add_rate; ?>" <?php if($in_bank_statutories->esi_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label"><?=lang('total_rate'); ?></label>
													<input type="text" class="form-control ESIrecords ESIRates" name="esi_total_rate" id="esi_total_rate" placeholder="<?=lang('total_rate'); ?>"  value="<?php echo $in_bank_statutories->esi_total_rate; ?>" readonly <?php if($in_bank_statutories->esi_contribution == 'no'){ echo "disabled"; } ?>>
												</div>
											</div>
									   </div>
										<div class="submit-section">
											<button class="btn btn-primary submit-btn" type="submit" ><?=lang('save'); ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- /Bank Statutory Tab -->
						
						<!-- Additions Tab -->
						<div class="tab-pane" id="tab_additions">
						
							<!-- Add Addition Button -->
							<div class="text-right m-b-30 clearfix">
								<button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_addition"><i class="fa fa-plus"></i> <?=lang('add_addition'); ?></button>
							</div>
							<!-- /Add Addition Button -->

							<div class="payroll-table card">
							<div class="table-responsive">
								<table class="table table-hover table-radius">
									<thead>
										<tr>
											<th>#</th>
											<th><?=lang('name'); ?></th>
											<th><?=lang('category'); ?></th>
											<th><?=lang('default_unit_amt'); ?></th>
											<th class="text-right"><?=lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $all_addtional = $this->db->get_where('bank_statutory',array('user_id'=>$employee_details['user_id']))->row_array(); 

											$addtional_ar = json_decode($all_addtional['pf_addtional'],TRUE);
											$i=1;
											// foreach ($addtional_ar as $add_ar) {
											if(is_array($addtional_ar)){
											foreach ($addtional_ar as $key => $value) {
										?>
											<tr>
												<th><?php echo $i; ?></th>
												<th><?php echo $value['addtion_name']; ?></th>
												<th><?php if($value['category_name'] == 'monthly'){ echo "Monthly remuneration"; }
														  if($value['category_name'] == 'addtional'){ echo "Additional remuneration"; } ?>
												</th>
												<th><?php echo $value['unit_amount']; ?></th>
												<td class="text-right">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<ul class="dropdown-menu pull-right">
														<li>	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_addition<?php echo $value['id']; ?>"><i class="fa fa-pencil m-r-5"></i><?=lang('edit');?></a></li>
															<li><a class="dropdown-item DeleteAddtion" style="cursor: pointer;" data-arid="<?php echo $value['id']; ?>" data-keyid="<?php echo $key; ?>" data-user="<?php echo $employee_details['user_id']; ?>"><i class="fa fa-trash-o m-r-5"></i> <?=lang('delete');?></a></li>
														</ul>
													</div>
												</td>
											</tr>
										<?php $i++; } } ?>
									</tbody>
								</table>
								</div>
							</div>
						</div>
						<!-- Additions Tab -->
						
						<!-- Overtime Tab -->
						<div class="tab-pane" id="tab_overtime">
						
							<!-- Add Overtime Button -->
							<div class="text-right m-b-30 clearfix">
								<button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_overtime"><i class="fa fa-plus"></i> <?=lang('add_overtime');?></button>
							</div>
							<!-- /Add Overtime Button -->

							<div class="payroll-table card">
							<div class="table-responsive">
								<table class="table table-hover table-radius">
									<thead>
										<tr>
											<th>#</th>
											<th><?=lang('description');?></th>
											<th><?=lang('date');?></th>
											<th><?=lang('hours');?></th>
											<th><?=lang('status');?></th>
											<th><?=lang('options');?></th>
										</tr>
									</thead>
									<tbody>
										<?php

										$overtime=$this->db->where(array('user_id'=>$employee_details['user_id'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->get('overtime')->result_array();
										 
										if(!empty($overtime))
										{
											$o=1;
											foreach ($overtime as $o_row) {
												

										?>
										<tr>
											<th><?php echo $o++;?></th>
											<th><?php echo $o_row['ot_description'];?></th>
											<td><?php echo date('d M Y',strtotime($o_row['ot_date']));?></td>
											<td><?php echo $o_row['ot_hours'];?></td>
											<td>
								<?php
									if($o_row['status'] == 0){
										if($check_teamlead['is_teamlead'] == 'no')
										echo '<span class="label" style="background:#D2691E"> Pending </span>';
										if($check_teamlead['is_teamlead'] == 'yes')
										echo '<span class="label" style="background:#D2691E"> Requested </span>';
									}else if($o_row['status'] == 1){
										echo '<span class="label label-success"> Approved </span> ';
									}else if($o_row['status'] == 2){
										echo '<span class="label label-danger"> Rejected</span>';
									}else if($o_row['status'] == 3){
										echo '<span class="label label-danger"> Cancelled</span>';
									}
								?>
								</td>
								<td> 
									<?php if($check_teamlead['is_teamlead'] == 'no'){ ?>
								<?php if($o_row['status'] == 0){ ?> 
									 <a class="btn btn-danger btn-xs"  
									  href="<?=base_url()?>employees/overtime_cancel/<?=$o_row['id']?>/<?php echo $o_row['user_id'];?>" title="Cancel" data-original-title="Cancel">
										<i class="fa fa-times"></i> 
									 </a>
								<?php } }
								if($check_teamlead['is_teamlead'] == 'yes'){ 
									if(($o_row['status'] != 3) &&  ($o_row['status'] != 1)){
								 ?>
									 <a  class="btn btn-success btn-xs"  
									  href="<?=base_url()?>employees/overtime_approve/<?=$o_row['id']?>/<?php echo $o_row['user_id'];?>" title="Approve" data-original-title="<?=lang('approve'); ?>" >
										<i class="fa fa-thumbs-o-up"></i> 
									 </a> 
									 <a class="btn btn-danger btn-xs"  
									  href="<?=base_url()?>employees/overtime_reject/<?=$o_row['id']?>/<?php echo $o_row['user_id'];?>" title="Reject" data-original-title="<?=lang('reject'); ?>">
										<i class="fa fa-thumbs-o-down"></i> 
									 </a>
								 <?php } } ?>
									 <!--<a class="btn btn-danger btn-xs"  
									 data-toggle="ajaxModal" href="<?=base_url()?>leaves/delete/<?=$levs['id']?>" title="Delete" data-original-title="Delete">
										<i class="fa fa-trash-o"></i> 
									 </a>-->
								</td>
										</tr>

									<?php } } ?>
									</tbody>
								</table>
								</div>
							</div>
							
						</div>
						<!-- /Overtime Tab -->


						<div class="tab-pane" id="tab_teamovertime">
						
							<!-- Add Overtime Button -->
							<div class="text-right m-b-30 clearfix">
								<button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_overtime"><i class="fa fa-plus"></i> <?=lang('add_overtime'); ?></button>
							</div>
							<!-- /Add Overtime Button -->

							<div class="payroll-table card">
							<div class="table-responsive">
								<table class="table table-hover table-radius">
									<thead>
										<tr>
											<th>#</th>
											<th><?=lang('username'); ?></th>
											<th><?=lang('description'); ?></th>
											<th><?=lang('date'); ?></th>
											<th><?=lang('hours'); ?></th>
											<th><?=lang('status'); ?></th>
											<th><?=lang('options'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php

										//$overtime=$this->db->where('teamlead_id',$check_teamlead['id'])->get('overtime')->result_array();
											$overtime=$this->db->where(array('teamlead_id'=>$check_teamlead['id'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->get('overtime')->result_array();
										 
										if(!empty($overtime))
										{
											$o=1;
											foreach ($overtime as $o_row) {
												

										?>
										<tr>
											<th><?php echo $o++;?></th>
											<?php if($check_teamlead['is_teamlead'] == 'yes') { $user_details = $this->db->get_where('account_details',array('user_id'=>$o_row['user_id']))->row_array(); ?>
								<td><?=$user_details['fullname']?></td> <?php } ?>
											<th><?php echo $o_row['ot_description'];?></th>
											<td><?php echo date('d M Y',strtotime($o_row['ot_date']));?></td>
											<td><?php echo $o_row['ot_hours'];?></td>
											<td>
								<?php
									if($o_row['status'] == 0){
										if($check_teamlead['is_teamlead'] == 'no')
										echo '<span class="label" style="background:#D2691E"> Pending </span>';
										if($check_teamlead['is_teamlead'] == 'yes')
										echo '<span class="label" style="background:#D2691E"> Requested </span>';
									}else if($o_row['status'] == 1){
										echo '<span class="label label-success"> Approved </span> ';
									}else if($o_row['status'] == 2){
										echo '<span class="label label-danger"> Rejected</span>';
									}else if($o_row['status'] == 3){
										echo '<span class="label label-danger"> Cancelled</span>';
									}
								?>
								</td>
								<td> 
									<?php if($check_teamlead['is_teamlead'] == 'no'){ ?>
								<?php if($o_row['status'] == 0){ ?> 
									 <a class="btn btn-danger btn-xs"  
									  href="<?=base_url()?>employees/overtime_cancel/<?=$o_row['id']?>/<?php echo $o_row['user_id'];?>" title="Cancel" data-original-title="<?=lang('cancel'); ?>">
										<i class="fa fa-times"></i> 
									 </a>
								<?php } }
								if($check_teamlead['is_teamlead'] == 'yes'){ 
									if(($o_row['status'] != 3) &&  ($o_row['status'] != 1)){
								 ?>
									 <a  class="btn btn-success btn-xs"  
									  href="<?=base_url()?>employees/overtime_approve/<?=$o_row['id']?>/<?php echo $o_row['teamlead_id'];?>" title="Approve" data-original-title="<?=lang('approve'); ?>" >
										<i class="fa fa-thumbs-o-up"></i> 
									 </a> 
									 <a class="btn btn-danger btn-xs"  
									  href="<?=base_url()?>employees/overtime_reject/<?=$o_row['id']?>/<?php echo $o_row['teamlead_id'];?>" title="Reject" data-original-title="<?=lang('reject'); ?>">
										<i class="fa fa-thumbs-o-down"></i> 
									 </a>
								 <?php } } ?>
									 <!--<a class="btn btn-danger btn-xs"  
									 data-toggle="ajaxModal" href="<?=base_url()?>leaves/delete/<?=$levs['id']?>" title="Delete" data-original-title="Delete">
										<i class="fa fa-trash-o"></i> 
									 </a>-->
								</td>
										</tr>

									<?php } } ?>
									</tbody>
								</table>
							</div>
							</div>
						</div>
						
						<!-- Deductions Tab -->
						<div class="tab-pane" id="tab_deductions">
						
							<!-- Add Deductions Button -->
							<div class="text-right m-b-30 clearfix">
								<button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_deduction"><i class="fa fa-plus"></i> <?=lang('add_deduction'); ?></button>
							</div>
							<!-- /Add Deductions Button -->

							<div class="payroll-table card">
							<div class="table-responsive">
								<table class="table table-hover table-radius">
									<thead>
										<tr>
											<th>#</th>
											<th><?=lang('name'); ?></th>
											<th><?=lang('default_unit_amt'); ?></th>
											<th class="text-right"><?=lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php $all_addtional = $this->db->get_where('bank_statutory',array('user_id'=>$employee_details['user_id']))->row_array(); 

											$deduction_ar = json_decode($all_addtional['pf_deduction'],TRUE);
											$i=1;
											if(is_array($deduction_ar)){
											foreach ($deduction_ar as $key => $value) {
										?>
										<tr>
											<th><?php echo $i; ?></th>
											<th><?php echo $value['model_name']; ?></th>
											<td>$<?php echo $value['unit_amount']; ?></td>
											<td class="text-right">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
													<ul class="dropdown-menu pull-right">
														<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_deduction<?php echo $value['id']; ?>"><i class="fa fa-pencil m-r-5"></i> <?=lang('edit'); ?></a></li>
														<li><a class="dropdown-item DeleteDeduction" style="cursor: pointer;" data-arid="<?php echo $value['id']; ?>" data-keyid="<?php echo $key; ?>" data-user="<?php echo $employee_details['user_id']; ?>" ><i class="fa fa-trash-o m-r-5"></i> <?=lang('delete'); ?></a></li>
													</ul>
												</div>
											</td>
										</tr>
										<?php $i++; } } ?>
									</tbody>
								</table>
							</div>
							</div>
						</div>
						<!-- /Deductions Tab -->
						
						<!-- Leaves Tab -->
						<div class="tab-pane" id="tab_leaves">
						
							
						<?php 
			$user_id = $this->uri->segment(3);
			

	  		
			$leave_details = $this->db->query("SELECT ul.*,lt.leave_type as l_type,ad.fullname
										FROM `dgt_user_leaves` ul
										left join dgt_common_leave_types lt on lt.leave_id = ul.leave_type
										left join dgt_account_details ad on ad.user_id = ul.user_id 
										where ul.user_id='".$user_id."' ")->result_array();
			 // print_r($leave_details); exit;
	   		?>
			<div class="table-responsive">
			 <table id="table-holidays" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr>
						<th> <?=lang('no.'); ?> </th>
						<th> <?=lang('leave_type'); ?> </th>
						<th><?=lang('date_from'); ?> </th>
						<th> <?=lang('date_to'); ?> </th>
						<th> <?=lang('reason'); ?> </th> 
						<th> <?=lang('no_of_days'); ?> </th>  
						<th> <?=lang('status'); ?> </th>  
						
					</tr>
				</thead>
				<tbody id="admin_leave_tbl">
					<?php 
					if(!empty($leave_details)){
					 foreach($leave_details as $key => $details){  ?>
					
					<tr>
						<td><?=$key+1?></td>
						
						<td><?=$details['l_type']?></td>
						<td><?=date('d-m-Y',strtotime($details['leave_from']))?></td>
						<td><?=date('d-m-Y',strtotime($details['leave_to']))?></td>
						<td width="30%"><?=$details['leave_reason']?></td>
						<td>
							<?php 
							echo $details['leave_days'];
							if($details['leave_day_type'] == 1){
								echo ' ( Full Day )';
							}else if($details['leave_day_type'] == 2){
								echo ' ( First Half )';
							}else if($details['leave_day_type'] == 3){
								echo ' ( Second Half )';
							}?>
						  </td>
						<td>
						<?php
						if($details['status'] == 4){
								echo '<span class="label label-info"> TL - Approved</span><br>';
								echo '<span class="label label-danger"> Management - Pending</span>';
							}else if($details['status'] == 7){
										echo '<span class="label label-danger"> Deleted </span>';
									}
							if($details['status'] == 0){
								echo ' <span class="label" style="background:#D2691E"> Pending </span>';
							}else if($details['status'] == 1){
								echo '<span class="label label-success"> Approved </span> ';
							}else if($details['status'] == 2){
								echo '<span class="label label-danger"> Rejected</span>';
							}else if($details['status'] == 3){
								echo '<span class="label label-danger"> Cancelled</span>';
							}
							?>
						</td>
						
					</tr>
				 <?php  } ?>  
				 <?php  }else{ ?>
						 <tr><td class="text-center" colspan="9"><?=lang('details_not_found'); ?></td></tr>
						 <?php } ?>  
				</tbody>
		   </table>    
				</div>			
						</div>
						<!-- /Leaves Tab -->
									<!-- File Attachment Tab -->
						<div class="tab-pane <?php echo ($active_tab == 'file_attach' )?'active in':'';?>" id="file_attach" >
							<h3 class="card-title"> <?=lang('file_attachments'); ?> </h3>
							<!-- <div class="text-right m-b-30 clearfix">
								<button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_fileattachment"><i class="fa fa-plus"></i> Files Upload</button>
							</div>
							<div class="text-right m-b-30 clearfix">
								<button class="btn btn-primary add-btn" type="button" ><?php echo lang('category_of_document');?></button>
							</div> -->
							<div class="row">
								<div class="col-sm-12 text-right m-b-20">									
									<button class="btn add-btn m-r-5 category_document"> <?php echo lang('category_of_document');?></button>
									<a class="btn btn-success add-btn m-r-5" type="button" data-toggle="modal" data-target="#add_document_type"><i class="fa fa-plus"></i> <?php echo lang('add_category_of_document');?></a>
									
									
										<a class="btn btn-primary add-btn employee_file_upload file_upload_list hide  m-r-5" type="button" data-toggle="modal" > <?php echo lang('attachment_list');?></a>
									
									
								</div>
							</div>
							

							<div class="row filter-row file_attachent_search">
								<div class="col-lg-4 col-sm-6">  
									<div class="form-group form-focus">
											<!-- <label class="control-label">Category</label>							 -->
										<select class="select2-option" style="width:100%;" name="doc_type" id="doc_type" >
											<option value="" selected disabled><?php echo lang('select_category');?></option>
												<?php

												$doc_types = $this->db->get_where('document_types',array('user_id'=>$employee_details['user_id'],'status'=>1))->result();


												 if(!empty($doc_types))	{

												 foreach ($doc_types as $type){ ?>

													<option value="<?php echo $type->type_name?>"><?php echo $type->type_name?></option>

													<?php } ?>

													<?php } ?>

												

									</select>
									<label id="category_name_error" class="error display-none" for="category_name"><?=lang('category_should_not_empty'); ?></label>
								</div>
							</div>
									
							<div class="col-lg-4 col-sm-6">  
								<a href="javascript:void(0)" id="file_attachent_search" class="btn btn-success btn-block form-control"> <?php echo lang('search');?> </a>  
							</div>     
	                    </div>
							<div class="row">
								<div class="col-sm-12 text-right m-b-20">
									<a class="btn btn-primary add-btn employee_file_upload add_file_upload" type="button" data-toggle="modal" data-target="#add_fileattachment"><i class="fa fa-plus"></i> <?php echo lang('files_upload');?></a>
									
								</div>
							</div>
							<div class="table-responsive file_upload_employee">
								 <table id="table-file_attachment" class="table table-striped custom-table m-b-0 AppendDataTables">
									<thead>
										<tr>
											<th>#</th>
											<th><?php echo lang('attachment_file');?></th>
											<th><?php echo lang('description');?></th>
											<th><?php echo lang('category_of_document');?></th>
											<th><?php echo lang('is_expired');?></th>
											<th><?php echo lang('expiration_date');?></th>
											<th><?php echo lang('days_before_expiration_date');?></th>
											<th><?php echo lang('uploaded_date');?></th>
											<th class="col-options no-sort text-right"><?=lang('action')?></th>
										</tr>	
									</thead>
									<tbody>	
										<a href="/images/myw3schoolsimage.jpg" download></a>
										<?php 
										// if(!empty($document_type)){
										// 	$all_file_attachments = $this->db->get_where('user_files',array('user_id'=>$employee_details['user_id'],'doc_type'=>$document_type))->result_array();
										// }else{
											$all_file_attachments = $this->db->get_where('user_files',array('user_id'=>$employee_details['user_id']))->result_array();
										// }
										
										$re =1;
										if(!empty($all_file_attachments)){
											foreach($all_file_attachments as $attachment){ 
												$doc_type = $this->db->get_where('document_types',array('id'=>$attachment['doc_type']))->row_array();
												$ext = pathinfo($attachment['attach_file'], PATHINFO_EXTENSION);
												if(($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'JPEG') || ($ext == 'jpeg') || ($ext == 'png') || ($ext == 'PNG')){
													$res = '<div class="hover-mask"><img src="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" style="height:50px;width:50px;"><h5><a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" class="mask-icon m-r-5" target="_blank"><i class="fa fa-eye fa_icon" aria-hidden="true"></i></a><a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" class="mask-icon" download><i class="fa fa-download fa_icon" aria-hidden="true"></i></a></h5></div>';
												}else if($ext == 'pdf'){
													$res = '<div class="hover-mask"><span class="pdf-icon"><i class="fa fa-file-pdf-o " aria-hidden="true" style="font-size: 50px;"></i></span><h5><a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'"class="mask-icon m-r-5" target="_blank"><i class="fa fa-eye fa_icon" aria-hidden="true"></i></a><a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" class="mask-icon" download><i class="fa fa-download fa_icon" aria-hidden="true"></i></a></h5></div>';
												}else{
													$res = '<div class="hover-mask"><span class="pdf-icon"><i class="fa fa-file-text-o" aria-hidden="true" style="font-size: 50px;"></i></span></a><h5><a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'"class="mask-icon m-r-5" target="_blank"><i class="fa fa-eye fa_icon" aria-hidden="true"></i></a><a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" class="mask-icon" download><i class="fa fa-download fa_icon" aria-hidden="true"></i></a></h5></div>';
												}
												?>
												<tr>
													<td><?php echo $re; ?></td>
													<td><?php echo $res; ?></td>
													<td><?php echo $attachment['description']; ?></td>
													<td><?php echo $doc_type['type_name']; ?></td>
													<td><?php echo ($attachment['is_expired'] == 1)?"Yes":"No"; ?></td>											<td><?php echo ($attachment['expired_date'] !='0000-00-00')?date('d M Y',strtotime($attachment['expired_date'])):'-'; ?></td>
													<td><?php echo ($attachment['before_expired_day']!=0)?$attachment['before_expired_day'].' days':'-'; ?></td>
													<td><?php echo date('d M Y',strtotime($attachment['created_at'])); ?></td>
													<td class="text-right">		
														<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
															<ul class="dropdown-menu pull-right">											
																   
																<li>
																	<a href="<?=base_url()?>employees/edit_attachment/<?php echo $attachment['user_file_id'];?>"  data-toggle="ajaxModal"><?php echo lang('edit');?></a>
																</li> 
																<li>
																	<a href="<?=base_url()?>employees/delete_attachment/<?php echo $attachment['user_file_id'];?>"  data-toggle="ajaxModal"><?php echo lang('delete');?></a>
																</li>
															</ul>
														</div>										
													</td>
												</tr>
											<?php 	
												$re++;
											}
										}else{
										?>	
											<tr>
												<td colspan="4" style="text-align: center;"><?php echo lang('no_attachment');?></td>
											</tr>
										<?php } ?>						
									</tbody>
							   </table>   
						   </div>

						   <div class="table-responsive category_of_document hide">
								 <table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">
									<thead>
										<tr>
											<th>#</th>
											<th><?php echo lang('name');?></th>
											<th><?php echo lang('status');?></th>
											<th class="col-options no-sort text-right"><?=lang('action')?></th>
										</tr>
									</thead>
									<tbody>	
										<?php 
										$document_types = $this->db->get_where('document_types',array('user_id'=>$employee_details['user_id']))->result_array();
										$re =1;
										if(!empty($document_types)){
											foreach($document_types as $document_type){ ?>
												
												<tr>
													<td><?php echo $re; ?></td>
													<td><?php echo $document_type['type_name']; ?></td>
													
													<td><?php echo ($document_type['status'] == 1)?"Active":"In-active"; ?></td>
													<td class="text-right">		
														<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
															<ul class="dropdown-menu pull-right">											
																   
																<li>
																	<a href="<?=base_url()?>employees/edit_document_type/<?php echo $document_type['id'];?>"  data-toggle="ajaxModal"><?php echo lang('edit');?></a>
																</li> 
																<li>
																	<a href="<?=base_url()?>employees/delete_document_type/<?php echo $document_type['id'];?>"  data-toggle="ajaxModal"><?php echo lang('delete');?></a>
																</li>
															</ul>
														</div>										
													</td>
												</tr>
											<?php 	
												$re++;
											}
										}else{
										?>	
											<tr>
												<td colspan="5" style="text-align: center;"><?php lang('no_category_found')?></td>
											</tr>
										<?php } ?>						
									</tbody>
							   </table>   
						   </div>  
							
						</div>
						<!-- /File Attachment Tab -->
						
					</div>
				</div>

				<!-- Profile Modal -->
				<div id="profile_info" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php lang('profile_informations')?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="basic_info_form1" method="post" action="<?php echo base_url(); ?>employees/basic_info_add/<?php echo $employee_details['user_id']; ?>" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-12">
											<div class="profile-img-wrap edit-img">
												<?php if($employee_details['avatar'] != ''){
													$pro_pict = $employee_details['avatar'];
												}else{
													$pro_pict = 'default_avatar.jpg';
												} ?>
												<img class="inline-block" src="<?php echo base_url(); ?>assets/avatar/<?php echo $pro_pict; ?>" alt="user">
												<div class="fileupload btn">
													<span class="btn-text"><?=lang('edit'); ?></span>
													<input class="upload" type="file" id="employee_pro_pics" name="userfile">
													<input type="hidden" id="employee_user_id" name="users_id" value="<?php echo $employee_details['user_id']; ?>">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('first_name')?> <span class="text-danger">*</span></label>
												<input type="text" class="form-control" value="<?php echo $employee_details['first_name']; ?>" placeholder="<?=lang('eg')?> <?=lang('placeholder_first_name')?>" name="first_name" autocomplete="off">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('last_name')?> <span class="text-danger">*</span></label>
												<input type="text" class="form-control" value="<?php echo $employee_details['last_name']; ?>" placeholder="<?=lang('eg')?> <?=lang('placeholder_last_name')?>" name="last_name" autocomplete="off" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">  
											<div class="form-group">
												<label><?=lang('dob')?><span class="text-danger">*</span></label>
												<input class="form-control datetimepicker" type="text" value="<?php  echo date('Y-m-d',strtotime($employee_details['dob']));?>" name="dob" data-date-format="yyyy-mm-dd" >
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label><?=lang('id_code')?> <span class="text-danger">*</span> <span id="already_id_code" style="display: none;color:red;"><?=lang('already_registered_id_code'); ?></span></label>
												<input type="text" name="id_code" placeholder="<?=lang('eg')?> 543219876" id="check_id_code" value="<?php echo $employee_details['id_code']; ?>" class="form-control only-numeric" autocomplete="off" readonly style="cursor: not-allowed;">
											</div>
										</div>
									</div>
									<div class="row">												
											<?php $departments = $this->db->order_by("deptname", "asc")->get_where('departments',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result(); 
										$get_department = $this->db->get_where('departments',array('deptid'=>$employee_details['department_id']))->row_array();
										$branches = $this->db->get_where('dgt_branches', array('status'=>'1','subdomain_id'=>$this->session->userdata('subdomain_id')))->result();

									?>
									<?php if($this->session->userdata('user_id') == $employee_details['user_id']){?>
										<input type="hidden" name="department_name" value="<?php echo $get_department['deptid']?>">																								
									<?php }?>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?=lang('branch_name')?> <span class="text-danger">*</span></label>
											<select class="select2-option" multiple="multiple" name="branch_id[]" id="branch_id" <?php echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"disabled":"";?>>
												<option value="" disabled><?=lang('select_branch')?></option>
												<?php
												if(!empty($branches))	{
													$branch_id = explode(',', $employee_details['branch_id']); 
													foreach ($branches as $key => $branch){ 
														?>
														<option value="<?=$branch->id;?>" <?php if(in_array($branch->id, array_values($branch_id))) { echo 'selected'; } ?>><?=$branch->branch_name;?></option>
													<?php } ?>
												<?php } else { ?>
														<option value=""><?=lang('select_branch')?></option>
												<?php } ?>

											</select>
										</div>
									</div> 

									<div class="col-md-6">
										<div class="form-group">
											<label><?=lang('department')?> <span class="text-danger">*</span></label>
											<input type="hidden" name="role" value="3">	
											<select class="select2-option" multiple="multiple" style="width:100%;" name="department_name[]" id="department_name" <?php echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"disabled":"";?>>
											<option value="" disabled><?php echo lang('department')?></option>
												<?php $dept_id = explode(',', $employee_details['department_id']);
													foreach ($departments as $key => $value) { 

														 ?>
															<option value="<?=$value->deptid?>" <?php if(in_array($value->deptid, array_values($dept_id))) { echo 'selected'; } ?>><?=$value->deptname?></option>
														<?php	
														} ?>												
											</select>
											<!-- <select class="<?php //echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"form-control":"select2-option";?>" style="width:100%;" name="department_name" id="department_name" <?php //echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"disabled":"";?>>
													<option value="<?php //echo $get_department['deptid']?$get_department['deptid']:''; ?>" selected ><?php //echo $get_department['deptname']?$get_department['deptname']:'Select'; ?></option>
														<?php
														 //if(!empty($departments))	{
														 //foreach ($departments as $department){ ?>
															<option value="<?=$department->deptid?>"><?=$department->deptname?></option>
														<?php //} ?>
														<?php //} ?>

											</select> -->
										</div>
									</div>
									<div class="col-sm-6">

										<div class="form-group">
											<?php $get_designation = $this->db->get_where('designation',array('id'=>$employee_details['designation_id']))->row_array(); ?>
											
											<?php if($this->session->userdata('user_id') == $employee_details['user_id']){?>
										
												<input type="hidden" name="designations" value="<?php echo $get_designation['id'];?>">	
										
											
											<?php }?>

											<label><?php echo lang('position'); ?> <span class="text-danger">*</span></label>

										<select class="form-control" style="width:100%;" name="designations" id="designations" <?php echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"disabled":"";?>>
											<option value="<?php echo $get_designation['id']?$get_designation['id']:'';?>" selected ><?php echo $get_designation['designation']?$get_designation['designation']:'Select';?></option>
											</select>

										</div>

									</div>

									<div class="col-sm-6 TeamDiv">
										<?php
											if(!empty($employee_details['teamlead_id'])){
												$get_users = $this->db->get_where('account_details',array('user_id'=>$employee_details['teamlead_id']))->row_array();
											}
										  ?>
										<?php if($this->session->userdata('user_id') == $employee_details['user_id']){?>
										
										<input type="hidden" name="reporting_to" value="<?php echo !empty($get_users)?$get_users['user_id']:'';?>">	
											
									<?php }?>
											<div class="form-group">
												<label><?=lang('reporting_to'); ?> </label>
												<select class="form-control" style="width:100%;" name="reporting_to" id="reporting_to" <?php echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"disabled":"";?>>
													<option value="<?php echo !empty($get_users)?$get_users['user_id']:''; ?>"  selected><?php echo !empty($get_users)?$get_users['fullname']:lang('select'); ?></option>
												</select>
											</div>
										</div>


										<!-- <div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('user_type')?> <span class="text-danger">*</span></label>
												
											<select class="select2-option" style="width:100%;" name="user_type" id="user_type">
													<option value="" selected disabled>User Type</option>
														<?php

														$user_type = $this->db->get('roles')->result();


														 if(!empty($user_type))	{

														 foreach ($user_type as $type){ ?>

															<option value="<?=$type->r_id?>"><?=$type->role?></option>

															<?php } ?>

															<?php } ?>

														

											</select>
										</div>

									</div>
-->

										<div class="col-sm-6">

											<div class="form-group">
												<?php 
												$user_type = $this->db->order_by("role", "asc")->get_where('roles',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result(); 
												$get_usertype = $this->db->get_where('roles',array('r_id'=>$employee_details['user_type']))->row_array(); ?>
												<?php if($this->session->userdata('user_id') == $employee_details['user_id']){?>
											
											<input type="hidden" name="user_type" value="<?php echo $get_usertype['r_id'];?>">	
												
										<?php }?>

												<label><?=lang('user_type'); ?> <span class="text-danger">*</span></label>

											<select class="form-control" style="width:100%;" name="user_type" id="user_type" <?php echo ($this->session->userdata('user_id') == $employee_details['user_id'])?"disabled":"";?>>
												<option value="<?php echo $get_usertype['r_id']?$get_usertype['r_id']:'';?>" selected ><?php echo $get_usertype['r_id']?$get_usertype['role']:'Select';?></option>
												<?php
															 if(!empty($user_type))	{
															 foreach ($user_type as $usertype){ ?>
																<option value="<?=$usertype->r_id?>"><?=$usertype->role?></option>
															<?php } ?>
															<?php } ?>
												</select>

											</div>

										</div>
									</div>
									<div class="row">
										<!-- <div class="col-md-6">
											<div class="form-group">
												<label>Full Name</label>
												<input type="text" class="form-control" name="full_name" value="<?php echo $employee_details['fullname']; ?>">
											</div>
										</div> -->		
										<div class="col-sm-6">
											<div class="form-group">
												<label><?=lang('username')?> <span class="text-danger">*</span> <span id="already_username" style="display: none;color:red;"><?=lang('already_registered_username'); ?></span></label>
												<input type="text" name="username" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_username')?>" id="check_username" value="<?php  echo $employee_details['username'];?>" class="form-control" autocomplete="off">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('email'); ?></label>
												<input type="text"  class="form-control" value="<?php echo $employee_details['email']; ?>" name="email" id="email">
											</div>
										</div>										
									</div>
										
									<div class="row">						
										<div class="col-sm-6">
											<div class="form-group">
												<label><?=lang('password')?> <span class="text-danger">*</span></label>
												<input type="password" placeholder="<?=lang('password')?>" value="<?=set_value('password')?>" name="password" id="password" class="form-control" autocomplete="off">
											</div>
										</div>

										<div class="col-sm-6">  
											<div class="form-group">
												<label><?=lang('confirm_password')?> <span class="text-danger">*</span></label>
												<input type="password" placeholder="<?=lang('confirm_password')?>" value="<?=set_value('confirm_password')?>" name="confirm_password"  class="form-control" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('gender'); ?></label><span class="text-danger">*</span>
												<select class="select2-option form-control" name="gender" style="width:100%;">
													<option value="male" <?php echo ($employee_details['gender'] =='male')?"selected":""?>><?=lang('male'); ?></option>
													<option value="female" <?php echo ($employee_details['gender'] =='female')?"selected":""?>><?=lang('female'); ?></option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="display:block;"><?=lang('phone_number'); ?></label>
												<input type="text" class="form-control telephone" name="phone" id="phone" value="<?php echo $employee_details['phone']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label><?=lang('address'); ?> </label><span><a href="javascript:void(0)" class="office_address"> <?=lang('head_office'); ?></a></span>
												<input type="text" class="form-control" name="address" id="address" value="<?php echo $employee_details['address'];?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('city'); ?></label>
												<input type="text" class="form-control" name="city" id="city" value="<?php echo $employee_details['city'];?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('state_province'); ?></label>
												<input type="text" class="form-control" name="state" id="state" value="<?php echo $employee_details['state'];?>">
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('postal_or_zip_code'); ?>Postal or Zip Code</label>
												<input type="text" class="form-control" name="pincode" id="pincode" value="<?php echo $employee_details['pincode'];?>">
											</div>
										</div>
										
										
										<div class="col-sm-6">  
											<div class="form-group">
												<label><?=lang('start_date')?><span class="text-danger">*</span></label>
												<input class="form-control" size="16" type="text" value="<?php  echo date('Y-m-d',strtotime($employee_details['doj']));?>" name="emp_doj" id="emp_doj" data-date-format="yyyy-mm-dd" >
											</div>
										</div>

										</div>


									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="basic_info_btn"><?=lang('submit')?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Profile Modal -->

				<!-- Bank Modal -->
				<div id="bank_iformation_modal" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?= lang('bank_information'); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="bank_info_form" method="post" action="<?php echo base_url(); ?>employees/bank_info_add/<?php echo $employee_details['user_id']; ?>">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label><?= lang('bank_name'); ?></label>
														<input type="text" class="form-control" name="bank_name" value="<?php echo $bank_info->bank_name; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label><?= lang('bank_acc_no'); ?></label>
														<input type="text" name="bank_ac_no" id="bank_ac_no" class="form-control" value="<?php echo $bank_info->bank_ac_no; ?>" >
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label><?= lang('ifsc_code'); ?></label>
														<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?php echo $bank_info->ifsc_code; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label><?= lang('pan_no'); ?></label>
														<input type="text" name="pan_no" id="pan_no" class="form-control" value="<?php echo $bank_info->pan_no; ?>" >
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" id="basic_info_btn"><?= lang('submit'); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Bank Modal -->

				<!-- Personal Info Modal -->
				<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?= lang('personal_informations'); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<?php $personal_info = json_decode($personal_details['personal_info']); ?>
								<form id="personal_info_form" method="post" action="<?php echo base_url(); ?>employees/personal_info_add/<?php echo $employee_details['user_id']; ?>">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label><?= lang('passport_no'); ?> <span class="text-danger">*</span></label>
												<input type="text" class="form-control" name="passport_no" id="passport_no" value="<?php echo $personal_info->passport_no; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('passport_exp_date'); ?> <span class="text-danger">*</span></label>
												<div class="cal-icon">
													<input class="form-control datetimepicker" type="text" name="passport_expiry" id="passport_expiry" data-date-format="dd-mm-yyyy" value="<?php echo $personal_info->passport_expiry; ?>">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('tel'); ?> <span class="text-danger">*</span></label>
												<input class="form-control" type="text" name="tel_number" id="tel_number" value="<?php echo $personal_info->tel_number; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('nationality'); ?> <span class="text-danger">*</span></label>
												<input class="form-control" type="text" name="nationality" id="nationality" value="<?php echo $personal_info->nationality; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('religion'); ?> <span class="text-danger">*</span></label>
													<input class="form-control" type="text" name="religion" id="religion" value="<?php echo $personal_info->religion; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('marital_status'); ?> <span class="text-danger">*</span></label>
												<select class="select form-control" name="marital_status" id="marital_status" >
													<option value="" disabled>-</option>
													<option value="single" <?php if($personal_info->religion == 'single'){ echo "selected"; } ?> ><?=lang('single'); ?></option>
													<option value="married" <?php if($personal_info->religion == 'married'){ echo "selected"; } ?>><?=lang('married'); ?></option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('employement_of_spouse'); ?></label>
												<input class="form-control" type="text" name="spouse" id="spouse" value="<?php echo $personal_info->spouse; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label><?=lang('no_of_children'); ?></label>
												<input class="form-control" type="text" name="no_children" id="no_children" value="<?php echo $personal_info->no_children; ?>">
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit'); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Personal Info Modal -->
				
				<!-- Family Info Modal -->
				<div id="family_info_modal" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"> <?=lang('family_informations'); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="family_info_form" action="<?php echo base_url(); ?>employees/family_info_add/<?php echo $employee_details['user_id']; ?>">
									<div class="form-scroll">
										<div class="card-box AllFamilyMembers">
											<?php $personal_info = json_decode($personal_details['family_members_info']); 
														// echo "<pre>"; print_r($personal_info); exit;
														if(count($personal_info) != 0)
														{
															$i = 1; 
														foreach ($personal_info as $per) {
												?>
											<div class="FamilyMembers">
												<h3 class="card-title"><?=lang('family_member'); ?> </h3><?php if($i != 1) { ?> <a href="#" class="remove_family_div"><i class="fa fa-trash-o"></i></a> <?php } ?>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('name'); ?> <span class="text-danger">*</span></label>
															<input class="form-control" type="text" name="member_name[]" value="<?php echo $per->member_name; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('relationship'); ?> <span class="text-danger">*</span></label>
															<input class="form-control" type="text" name="member_relationship[]" value="<?php echo $per->member_relationship; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('dob'); ?> <span class="text-danger">*</span></label>
															<input class="form-control ALlmembers" type="text" name="member_dob[]" value="<?php echo $per->member_dob; ?>" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('phone'); ?> <span class="text-danger">*</span></label>
															<input class="form-control" type="text" name="member_phone[]" value="<?php echo $per->member_phone; ?>"> 
														</div>
													</div>
												</div>
											</div>
										<?php $i++; } }else{ ?>
											<div class="FamilyMembers">
												<h3 class="card-title"><?=lang('family_member'); ?> </h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('name'); ?> <span class="text-danger">*</span></label>
															<input class="form-control" type="text" name="member_name[]">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('relationship'); ?> <span class="text-danger">*</span></label>
															<input class="form-control" type="text" name="member_relationship[]">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('dob'); ?> <span class="text-danger">*</span></label>
															<input class="form-control ALlmembers" type="text" name="member_dob[]" >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><?=lang('phone'); ?> <span class="text-danger">*</span></label>
															<input class="form-control" type="text" name="member_phone[]"> 
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
											<div class="add-more">
												<a href="#" id="add_more_family"><i class="fa fa-plus-circle"></i> <?=lang('add_more'); ?></a>
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit'); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Family Info Modal -->
				
				<!-- Emergency Contact Modal -->
				<div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('emergency_contact_info'); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="emergency_form" method="post" action="<?php echo base_url(); ?>employees/emergency_info_add/<?php echo $employee_details['user_id']; ?>"> 
									<div class="card-box">
										<h3 class="card-title"><?=lang('primary_contact'); ?></h3>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('name'); ?> <span class="text-danger">*</span></label>
													<input type="text" class="form-control" name="contact_name1" id="contact_name1" value="<?php echo $emergency_info->contact_name1; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('relationship'); ?> <span class="text-danger">*</span></label>
													<select class="select form-control" name="relationship1" id="relationship1">
													<option value="" disabled>-</option>
													<option value="father" <?php if($emergency_info->relationship1 == 'father'){ echo "selected"; }  ?> ><?=lang('father'); ?></option>
													<option value="mother" <?php if($emergency_info->relationship1 == 'mother'){ echo "selected"; }  ?> ><?=lang('mother'); ?></option>
													<option value="sister" <?php if($emergency_info->relationship1 == 'sister'){ echo "selected"; }  ?>><?=lang('sister'); ?></option>
													<option value="brother" <?php if($emergency_info->relationship1 == 'brother'){ echo "selected"; }  ?> ><?=lang('brother'); ?></option>
													<option value="others" <?php if($emergency_info->relationship1 == 'others'){ echo "selected"; }  ?>><?=lang('others'); ?></option>
												</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('phone'); ?> <span class="text-danger">*</span></label>
													<input class="form-control" type="text" name="contact1_phone1" id="contact1_phone1" value="<?php echo $emergency_info->contact1_phone1;  ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('phone_2'); ?></label>
													<input class="form-control" type="text" name="contact1_phone2" id="contact1_phone2" value="<?php echo $emergency_info->contact1_phone2;  ?>">
												</div>
											</div>
										</div>
									</div>
									<div class="card-box">
										<h3 class="card-title"><?=lang('secondary_contact'); ?></h3>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('name'); ?> <span class="text-danger">*</span></label>
													<input type="text" class="form-control" name="contact_name2" id="contact_name2" value="<?php echo $emergency_info->contact_name2;  ?>">
												</div>
											</div>
											<div class="col-md-6">
													<div class="form-group">
													<label><?=lang('relationship'); ?> <span class="text-danger">*</span></label>
													<select class="select form-control" name="relationship2" id="relationship2">
													<option value="" disabled>-</option>
													<option value="father" <?php if($emergency_info->relationship2 == 'father'){ echo "selected"; }  ?> ><?=lang('father'); ?></option>
													<option value="mother" <?php if($emergency_info->relationship2 == 'mother'){ echo "selected"; }  ?> ><?=lang('mother'); ?></option>
													<option value="sister" <?php if($emergency_info->relationship2 == 'sister'){ echo "selected"; }  ?>><?=lang('sister'); ?></option>
													<option value="brother" <?php if($emergency_info->relationship2 == 'brother'){ echo "selected"; }  ?> ><?=lang('brother'); ?></option>
													<option value="others" <?php if($emergency_info->relationship2 == 'others'){ echo "selected"; }  ?>><?=lang('others'); ?></option>
												</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('phone'); ?> <span class="text-danger">*</span></label>
													<input class="form-control" type="text" name="contact2_phone1" id="contact2_phone1" value="<?php echo $emergency_info->contact2_phone1;  ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><?=lang('phone_2'); ?></label>
													<input class="form-control" type="text" name="contact2_phone2" id="contact2_phone2" value="<?php echo $emergency_info->contact2_phone2;  ?>">
												</div>
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit'); ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Emergency Contact Modal -->

				<!-- Education Modal -->
				<div id="education_info" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('education_information'); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="education_info_form" action="<?php echo base_url(); ?>employees/education_info_add/<?php echo $employee_details['user_id']; ?>">
									<div class="form-scroll AllInstitute">
										<?php $i =1; 
												 // print_r($personal_details); exit;
												if(!empty($education_details)){
												 // $pers = json_decode($personal_details['education_details']);
												 foreach($education_details as $p){ ?>
										<div class="card-box MultipleInstitutions">
											<h3 class="card-title"><?=lang('education_information'); ?></h3> <?php if($i != 1) { ?> <a href="#" class="remove_div"><i class="fa fa-trash-o"></i></a> <?php } ?>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" class="form-control floating" name="institute[]" value="<?php echo $p->institute; ?>">
														<label class="control-label"><?=lang('institution'); ?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" class="form-control floating" name="subject[]" value="<?php echo $p->subject; ?>">
														<label class="control-label"><?=lang('subject'); ?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" name="start_date[]" class="form-control floating datetimepicker" value="<?php echo $p->start_date; ?>">
														</div>
														<label class="control-label"><?=lang('starting_date'); ?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" name="end_date[]" class="form-control floating datetimepicker" value="<?php echo $p->end_date; ?>">
														</div>
														<label class="control-label"><?=lang('complete_date'); ?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" name="degree[]" class="form-control floating" value="<?php echo $p->degree; ?>">
														<label class="control-label"><?=lang('degree'); ?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" name="grade[]" class="form-control floating" value="<?php echo $p->grade; ?>">
														<label class="control-label"><?=lang('grade'); ?></label>
													</div>
												</div>
											</div>
										</div>
									<?php $i++; } }else{ ?>
										<div class="card-box MultipleInstitutions">
											<h3 class="card-title"><?=lang('education_information');?> </h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="" class="form-control floating" name="institute[]">
														<label class="control-label"><?=lang('institution');?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" class="form-control floating" name="subject[]">
														<label class="control-label"><?=lang('subject');?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" name="start_date[]" class="form-control floating datetimepicker">
														</div>
														<label class="control-label"><?=lang('starting_date');?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" name="end_date[]" class="form-control floating datetimepicker">
														</div>
														<label class="control-label"><?=lang('complete_date');?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" name="degree[]" class="form-control floating">
														<label class="control-label"><?=lang('degree');?></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" name="grade[]" class="form-control floating">
														<label class="control-label"><?=lang('grade');?></label>
													</div>
												</div>
											</div>
										</div>
									<?php }  ?>
										<div class="add-more">
											<a href="#" id="Add_more_institution"><i class="fa fa-plus-circle"></i> <?=lang('add_more_institution');?></a>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Education Modal -->

<!-- Experience Modal -->

<div id="experience_info" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=lang('experience_information');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="experience_info_form" action="<?php echo base_url(); ?>employees/experience_info_add/<?php echo $employee_details['user_id']; ?>">
					<div class="form-scroll">
						<div class="card-box AllExperience">
						    <?php $i =1; 
												
								 $pers = json_decode($personal_details['personal_details']);
								 // echo "<pre>"; print_r($pers); exit;
								 if(!empty($pers)){
								 foreach($pers as $p){ ?>
						    <div class="MultipleExperience">
							<h3 class="card-title"><?=lang('experience_information');?> </h3> <?php if($i != 1){ ?> <a href="#" class="remove_exp_div"><i class="fa fa-trash-o"></i></a><?php } ?>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-focus">
										<input type="text" class="form-control floating" value="<?php echo $p->company_name; ?>" name="company_name[]">
										<label class="control-label"><?=lang('company_name');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<input type="text" class="form-control floating" value="<?php echo $p->location; ?>" name="location[]" >
										<label class="control-label"><?=lang('location');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<input type="text" class="form-control floating" value="<?php echo $p->job_position; ?>" name="job_position[]">
										<label class="control-label"><?=lang('job_position');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<div class="cal-icon">
											<input type="text" class="form-control floating datetimepicker" value="<?php echo $p->period_from; ?>" name="period_from[]">
										</div>
										<label class="control-label"><?=lang('period_from');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<div class="cal-icon">
											<input type="text" class="form-control floating datetimepicker" value="<?php echo $p->period_to; ?>" name="period_to[]">
										</div>
										<label class="control-label"><?=lang('period_to');?></label>
									</div>
								</div>
							</div>
							</div>
							<?php $i++; } }else{ ?>
							    <div class="MultipleExperience">
							<h3 class="card-title"><?=lang('experience_information');?> </h3>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-focus">
										<input type="text" class="form-control floating" value="" name="company_name[]">
										<label class="control-label"><?=lang('company_name');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<input type="text" class="form-control floating" value="" name="location[]">
										<label class="control-label"><?=lang('location');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<input type="text" class="form-control floating" value="" name="job_position[]">
										<label class="control-label"><?=lang('job_position');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<div class="cal-icon">
											<input type="text" class="form-control floating datetimepicker" value="" name="period_from[]">
										</div>
										<label class="control-label"><?=lang('period_from');?></label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-focus">
										<div class="cal-icon">
											<input type="text" class="form-control floating datetimepicker" value="" name="period_to[]">
										</div>
										<label class="control-label"><?=lang('period_to');?></label>
									</div>
								</div>
							</div>
							</div>
							<?php } ?>
						</div>
						<div class="add-more">
								<a href="#" id="Add_experience"><i class="fa fa-plus-circle"></i> <?=lang('add_more');?></a>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn"><?=lang('submit');?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Experience Modal -->

				<!-- Add Addition Modal -->
				<div id="add_addition" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('add_addition');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="addtional_form" action="<?php echo base_url(); ?>employees/addtional_pf_details">
									<div class="form-group">
										<label><?=lang('name');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="addtion_name" id="addtion_name" value="" placeholder="<?=lang('name');?>" required="required"> 
										<input type="hidden" name="user_id" id="user_id" value="<?php echo $employee_details['user_id']; ?>">
									</div>
									<div class="form-group">
										<label><?=lang('category');?> <span class="text-danger">*</span></label>
										<select class="select" name="category_name" id="category_name" required="required">
											<option value="" selected disabled><?=lang('select_category');?></option>
											<option value="monthly" ><?=lang('monthly_remuneration');?></option>
											<option value="addtional"><?=lang('addtional_remuneration');?></option>
										</select>
									</div>
									<div class="form-group">
										<label><?=lang('unit_amount');?> <span class="text-danger">*</span></label>
										<div class="input-group">
											<span class="input-group-addon">
												$
											</span>
											<input type="text" class="form-control" name="unit_amount" id="unit_amount" value="" placeholder="<?=lang('unit_amount');?>" required="required">
											<span class="input-group-addon">
												.00
											</span>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Addition Modal -->

				<?php foreach ($addtional_ar as $add_ar) { ?>
				
				<!-- Edit Addition Modal -->
				<div id="edit_addition<?php echo $add_ar['id']; ?>" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('edit_addition');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="edit_addtional_form" action="<?php echo base_url(); ?>employees/edit_additional/<?php echo $add_ar['id']; ?>">
									<div class="form-group">
										<label><?=lang('name');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="addtion_name" value="<?php echo $add_ar['addtion_name']; ?>" required>
										<input type="hidden" name="user_id" value="<?php echo $employee_details['user_id']; ?>">
									</div>
									<div class="form-group">
										<label><?=lang('category');?> <span class="text-danger">*</span></label>
										<select class="select" name="category_name" required>
											<option value="" disabled><?=lang('select_category');?></option>
											<option value="monthly" <?php if($add_ar['category_name'] == 'monthly'){ echo "selected"; } ?>><?=lang('monthly_remuneration');?></option>
											<option value="addtional" <?php if($add_ar['category_name'] == 'addtional'){ echo "selected"; } ?>><?=lang('addtional_remuneration');?></option>
										</select>
									</div>
									<div class="form-group">
										<label><?=lang('unit_amount');?> <span class="text-danger">*</span></label>
										<div class="input-group">
											<span class="input-group-addon">
												$
											</span>
											<input type="text" class="form-control" name="unit_amount" value="<?php echo $add_ar['unit_amount']; ?>" required>
											<span class="input-group-addon">
												.00
											</span>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('save');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Edit Addition Modal -->
				
				<!-- Delete Addition Modal -->
				<div class="modal center-modal fade" id="delete_addition<?php echo $add_ar['id']; ?>" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3><?=lang('delete_addition');?></h3>
									<p><?=lang('are_you_sure_want_to_delete?');?></p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-6">
											<a href="javascript:void(0);" class="btn btn-primary continue-btn"><?=lang('delete');?></a>
										</div>
										<div class="col-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?=lang('cancel');?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Delete Addition Modal -->
				<?php } ?>
				
				<!-- Add Overtime Modal -->
				<div id="add_overtime" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('add_overtime');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="<?php echo base_url();?>employees/add_overtime"  id="add_overtimes" method="post" enctype="multipart/form-data" data-parsley-validate novalidate > 
									<div class="form-group">
										<label><?=lang('description');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="ot_description" required value="" >
										<input class="form-control" type="hidden" name="user_id"  value="<?php echo $employee_details['user_id']; ?>" >
									</div>
									<div class="form-group">
										<label><?=lang('date');?><span class="text-danger">*</span></label>
										<input class="form-control datetimepicker" type="text" name="ot_date" required id="ot_date">
										<?php $teamlead_details = $this->db->get_where('dgt_users',array('id'=>$employee_details['user_id']))->row_array(); 
										//echo '<pre>'; print_r($teamlead_details); exit;
										?>
						                 <input type="hidden" name="teamlead_id" id="teamlead_id" value="<?php echo $teamlead_details['teamlead_id']; ?>">
									</div>
									<div class="form-group">
										<label><?=lang('hours');?><span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="ot_hours" id="ot_hours" required="" placeholder="HH:MM">
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Overtime Modal -->
				
				<!-- Edit Overtime Modal -->
				<div id="edit_overtime" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('edit_overtime');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form>
									<div class="form-group">
										<label><?=lang('name');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="ot_description" value="" placeholder="OT Description">
									</div>
									<div class="form-group">
										<label><?=lang('date');?><span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="ot_date" id="ot_date">
									</div>
									<div class="form-group">
										<label><?=lang('hours');?><span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="ot_hours" id="ot_hours" placeholder="HH:MM">
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('save');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Edit Overtime Modal -->
				
				<!-- Delete Overtime Modal -->
				<div class="modal center-modal fade" id="delete_overtime" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3><?=lang('delete_overtime');?></h3>
									<p><?=lang('are_you_sure_want_to_delete?');?></p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-6">
											<a href="javascript:void(0);" class="btn btn-primary continue-btn"><?=lang('delete');?></a>
										</div>
										<div class="col-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?=lang('cancel');?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Delete Overtime Modal -->
				
				<!-- Add Deduction Modal -->
				<div id="add_deduction" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=lang('add_deduction');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" action="<?php echo base_url(); ?>employees/add_deduction/">
									<div class="form-group">
										<label><?=lang('name');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name = "model_name" id="model_name" value="" required="required">
										<input class="form-control" type="hidden" name = "user_id" value="<?php echo $employee_details['user_id']; ?>" required>
									</div>
									<div class="form-group">
										<label><?=lang('unit_amount');?></label>
										<div class="input-group">
											<span class="input-group-addon">
												$
											</span>
											<input type="text" class="form-control" name="unit_amount" value="" required="required">
											<span class="input-group-addon">
												.00
											</span>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?=lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Deduction Modal -->

				<!-- Add File Attachment Modal -->
				<div id="add_document_type" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('category_of_document');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" action="<?php echo base_url(); ?>employees/add_document_type/<?php echo $employee_details['user_id']; ?>" enctype="multipart/form-data">
									<div class="form-group">
										<label><?php echo lang('name');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name = "type_name" id="type_name" value="" required autocomplete="off">
										<input class="form-control" type="hidden" name = "user_id" value="<?php echo $employee_details['user_id']; ?>">
									</div>
									
					                	<div class="form-group">
						                    <label class="d-block"><?php echo lang('status');?></label>
						                    <div class="status-toggle">
						                        <input type="checkbox" id="status3" name="status" class="check" value="1" checked>
						                        <label for="status3" class="checktoggle"><?php echo lang('checkbox');?></label>
						                    </div>
						                </div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Add File Attachment Modal -->
				<?php $doc_types = $this->db->get_where('document_types',array('user_id'=>$employee_details['user_id'],'status'=>1))->result();?>
				<div id="add_fileattachment" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('files_upload');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" action="<?php echo base_url(); ?>employees/add_attachment/<?php echo $employee_details['user_id']; ?>" enctype="multipart/form-data">
									<div class="form-group">

										<label><?php echo lang('category_of_document');?> <span class="text-danger">*</span></label>
											
										<select class="select2-option" style="width:100%;" name="doc_type" id="doc_type" >
												<option value="" selected disabled><?php echo lang('select_category');?></option>
													<?php

													


													 if(!empty($doc_types))	{

													 foreach ($doc_types as $type){ ?>

														<option value="<?=$type->id?>"><?php echo $type->type_name?></option>

														<?php } ?>

														<?php } ?>

													

										</select>
									</div>
									<div class="form-group">
										<label><?php echo lang('description');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="description" value="" required>
										
									</div>
									<div class="form-group">
					                    <label class="d-block"><?php echo lang('document_will_have_an_expiration_date');?> </label>
					                    <div class="status-toggle">
					                        <input type="checkbox" id="status" name="is_expired" class="check is_expired" value="1" >
					                        <label for="status" class="checktoggle"><?php echo lang('checkbox');?></label>
					                    </div>
					                </div>	
					                <div class="form-group expired hide">
										<label><?php echo lang('expiration_date');?></label>
										<div class="cal-icon">
											<input class="form-control datetimepicker" id="" readonly type="text" value="" name="expired_date" data-date-format="<?=config_item('date_picker_format');?>" data-date-start-date="0d" >
										</div>				
									</div>
					                <div class="form-group expired hide">
					                	<label><?php echo lang('days_before_expiration_date');?> </label>
					                	<input class="form-control" type="text" name = "before_expired_day" id="before_expired_day" value="">
					                </div>
									<div class="form-group">
										<label><?php echo lang('upload_files');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="file" name = "attach_file[]" id="attach_file" multiple >
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?php echo lang('submit');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Deduction Modal -->
				<?php foreach ($deduction_ar as $dec_ar) { ?>
				
				<!-- Edit Deduction Modal -->
				<div id="edit_deduction<?php echo $dec_ar['id']; ?>" class="modal center-modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo lang('edit_deduction');?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="edit_addition_form" action="<?php echo base_url(); ?>employees/edit_pfdeduction/<?php echo $dec_ar['id']; ?>">
									<div class="form-group">
										<label><?php echo lang('name');?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="model_name" value="<?php echo $dec_ar['model_name']; ?>" required>
										<input class="form-control" type="hidden" name="user_id" value="<?php echo $employee_details['user_id']; ?>" required>
									</div>
									<div class="form-group">
										<label><?php echo lang('unit_amount');?></label>
										<div class="input-group">
											<span class="input-group-addon">
												$
											</span>
											<input type="text" class="form-control" name="unit_amount" value="<?php echo $dec_ar['unit_amount']; ?>" required>
											<span class="input-group-addon">
												.00
											</span>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn"><?php echo lang('save');?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Edit Addition Modal -->
				<?php } ?>
				
				<!-- Delete Deduction Modal -->
				<div class="modal center-modal fade" id="delete_deduction" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3><?php echo lang('delete_deduction');?></h3>
									<p><?php echo lang('are_you_sure_want_to_delete?');?></p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-6">
											<a href="javascript:void(0);" class="btn btn-primary continue-btn"><?php echo lang('delete');?></a>
										</div>
										<div class="col-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn"><?php echo lang('cancel');?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Delete Deduction Modal -->
<script type="text/javascript">
	var office_address = "<?=config_item('company_address')?>";
	var office_city = "<?=config_item('company_city')?>";
	var office_state = "<?=config_item('company_state')?>";
	var office_zip_code = "<?=config_item('company_zip_code')?>";

</script>