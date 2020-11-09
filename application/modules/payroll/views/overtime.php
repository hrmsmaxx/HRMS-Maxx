		 <div class="content container-fluid">

					<div class="row">

						<div class="col-xs-8">

							<h4 class="page-title"><?php echo lang('overtime');?></h4>

						</div>

					</div>
    				<?php $this->load->view('sub_menus');?>

					<div class="payroll-table card-box">
					<div class="table-responsive">
								<table class="table table-hover table-radius">
									<thead>
										<tr>
											<th>#</th>
											<th><?php echo lang('username'); ?></th>
											<th><?php echo lang('ro'); ?></th>
											<th><?php echo lang('description'); ?></th>
											<th><?php echo lang('date'); ?></th>
											<th><?php echo lang('hours'); ?></th>
											<th><?php echo lang('status'); ?></th>
											
										</tr>
									</thead>
									<tbody>
										<?php //print_r($this->session->userdata()); exit;
										$branch_id = $this->session->userdata('branch_id');
		                                if($branch_id != '') {
		                                    $this->db->where("U.branch_id IN (".$branch_id.")",NULL, false);
		                                }
		                                if($this->session->userdata('is_teamlead') == 'yes') {
		                                    $this->db->or_where('O.teamlead_id',$this->session->userdata('user_id'));
		                                }
		                                if($this->session->userdata('role_id') != '1') {
		                                	$this->db->where('O.user_id',$this->session->userdata('user_id'));
		                                }
		                                $overtime = $this->db->select('O.*')
		                                	->from('overtime O')
		                                	->join('users U', 'U.id=O.user_id', 'LEFT')
		                                	->where(array('O.subdomain_id'=>$this->session->userdata('subdomain_id')))
		                                	->get()
		                                	->result_array();

										//$overtime=$this->db->get_where('overtime', array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
										 
										if(!empty($overtime))
										{
											$o=1;
											foreach ($overtime as $o_row) {
												

										?>
										<tr>
											<th><?php echo $o++;?></th>
											<?php  $user_details = $this->db->get_where('account_details',array('user_id'=>$o_row['user_id']))->row_array(); ?>
								            <td><?=$user_details['fullname']?></td> 
								            <?php  $ro_details = $this->db->get_where('account_details',array('user_id'=>$o_row['teamlead_id']))->row_array(); ?>
								            <td><?=$ro_details['fullname']?></td>
											<th><?php echo $o_row['ot_description'];?></th>
											<td><?php echo date('d M Y',strtotime($o_row['ot_date']));?></td>
											<td><?php echo $o_row['ot_hours'];?></td>
											<td>
								<?php
									if($o_row['status'] == 0){
										
										echo '<span class="label" style="background:#D2691E"> '.lang("pending").' </span>';
										
									}else if($o_row['status'] == 1){
										echo '<span class="label label-success"> '.lang("approved").' </span> ';
									}else if($o_row['status'] == 2){
										echo '<span class="label label-danger"> '.lang("rejected").'</span>';
									}else if($o_row['status'] == 3){
										echo '<span class="label label-danger"> '.lang("cancelled").'</span>';
									}
								?>
								</td>
								
										</tr>

									<?php } } ?>
									</tbody>
								</table>
							</div>
							</div>





					
                </div>



                


