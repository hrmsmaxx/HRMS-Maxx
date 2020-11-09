<?php //echo 'dept<pre>'; print_r($dept_id); exit; 
$dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
?>

<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 
  <?php 

  date_default_timezone_set('Asia/Kolkata');
  $punch_in_date = date('Y-m-d');
  $punch_in_time = date('H:i');
  $punch_in_date_time = date('Y-m-d H:i');

  
   $strtotime = strtotime($punch_in_date_time);
   $a_year    = date('Y',$strtotime);
   $a_month   = date('m',$strtotime);
   $a_day     = date('d',$strtotime);
   $a_days     = date('d',$strtotime);
   $a_dayss     = date('d',$strtotime);
   $a_cin     = date('H:i',$strtotime);
  ?>
  <?php 
	  $s_year = '2019';
	  $select_y = date('Y');

	  $s_month = date('m');
	  $e_year = date('Y');



 ?>            
            <!-- <div class="page-wrapper"> -->
            	
                <div class="content container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="page-title"><?php echo lang('timing_sheet');?></h4>
						</div>
					</div>
					<?php $this->load->view('sub_menus');?>
					<div class="card-box">
					<div class="row">
						<div class="col-sm-8">
						</div>
						<?php /* if(($this->session->userdata('role_id') != 1) && ($this->session->userdata('role_id') != 4)){ ?>
						<div class="col-sm-4 text-right m-b-30">
							<a href="#" class="btn btn-primary rounded" data-toggle="modal" data-target="#add_todaywork"><i class="fa fa-plus"></i> <?php echo lang('add_today_work');?></a>
						</div> 
					<?php } */ ?>
					</div>
					<?php 
					$all_employees = $this->timesheet_model->get_all_users();
					?>
					<div class="row filter-row">
							<div class="col-md-7 padding-2p search_date">
						<form id="timesheet_search" method="post" action="<?php echo base_url().'time_sheets/'; ?>">
									<div class="row filter-row">
										<div class="col-sm-6 col-md-4 col-xs-6"> 
										<?php $user_type = $this->session->userdata('role_name'); 
											  	if($user_type != 'employee' || $user_type != 'client') { ?>
													<div class="form-group">
														 <select class="select2-option form-control" name="user_id" id="user_name">
									                        <optgroup label="">
									                        <option value=""><?php echo lang('select_employee');?></option> 
									                            <?php 
									                            if($user_type=='admin') {
									                            	$branch = explode(',', $this->session->userdata('branch_id'));
								                            		$employee = $this->db->select('*')
								                            				->from('users')
								                            				->where_in('branch_id', $branch)
								                            				->or_where(array('teamlead_id'=>$this->session->userdata('user_id'), 'id'=>$this->session->userdata('user_id')))
								                            				->where(array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))
								                            				->get()
								                            				->result();
									                            } else if($user_type == 'supervisor'){
									                            	if($dept_id != 0) {
									                            		$department = explode(',', $dept_id);
									                            		$branch = explode(',', $this->session->userdata('branch_id'));
									                            		$employee = $this->db->select('*')
									                            				->from('users')
									                            				->where_in('branch_id', $branch)
									                            				->where_in('department_id', $department)
									                            				->or_where(array('teamlead_id'=>$this->session->userdata('user_id'), 'id'=>$this->session->userdata('user_id')))
									                            				->where(array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))
									                            				->get()
									                            				->result();
									                            		
									                            	}
									                            	
									                            } else {
									                            	$employee = $this->db->get_where('users',array('role_id'=>3,'activated'=>1,'banned'=>0,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result();
									                            }


									                            foreach ($employee as $c): 
									                            ?>

									                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
									                            <?php endforeach;  ?>
									                        </optgroup>
									                    </select>
														<label id="employee_id_error" class="error display-none" for="employee_id"><?php echo lang('please_select_an_option');?></label>
													</div>
												<?php } ?>
										</div>
										<div class="col-sm-6 col-md-4 col-xs-6 m-b-10">
											 <div class="form-group">							                 
							                  <input type="text" name="range" id="reportrange" class="pull-right form-control" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
							                  
							                </div>
										</div>
										<!-- <div class="col-sm-6 col-md-3 col-xs-6">
											<div class="form-group form-focus">
												<label class="control-label">Date To</label>
												<div class="cal-icon">
													<input class="form-control floating" id="timesheet_date_to" type="text" data-date-format="dd-mm-yyyy" name="search_to_date" id="search_to_date" value="<?php if($this->session->userdata('search_to_date') !=''){ echo $this->session->userdata('search_to_date');  } ?>" size="16">
													<label id="timesheet_date_to_error" class="error display-none" for="timesheet_date_to">To Date Shouldn't be empty</label>
												</div>
											</div>
										</div> -->

										<div class="col-sm-6 col-md-4 col-xs-6">  
										<div class="form-group">
											<button id="timesheet_search_btn" class="btn btn-success form-control m-b-10" > <?php echo lang('search');?> </button>  
										</div>
										</div> 
									 
									</div>
							 
						</form>
										
										
							</div> 
							<div class="col-md-3">  
										<div class="form-group">
											<a id="" href="<?php echo base_url().'time_sheets/manual_timesheets'; ?>" class="btn btn-success form-control m-b-10" > <?php echo lang('manual_timesheets');?> </a>  
										</div>
										</div> 
							<div class="col-md-2">  
											<div class="form-group">
												<input type="hidden" class="form-control range_excel"  value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
                    					<input type="hidden" class="form-control user_id_excel"  value="<?php echo (isset($_POST['user_id']) && !empty($_POST['user_id']))?$_POST['user_id']:'';?>">
										 	<?php  $report_name = lang('project_timesheet_report');?>
                 								<button class="btn btn-success form-control" onclick="timesheet_excel('<?php echo $report_name;?>','attendance_report_excel');" ><span><?=lang('export_file')?></span> </button>

											</div>
										</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables">
									<thead>
										<tr>
											<th><?php echo lang('s_no');?></th>
											<th><?php echo lang('employee_name');?></th>
											<th><?php echo lang('date');?></th>
											<th><?php echo lang('project_name');?></th>
											<th><?php echo lang('work_hours');?></th>
											<!-- <th class="text-center">Hours</th> -->
											<th><?php echo lang('work_description');?></th>
											<th><?php echo lang('project_to_day');?></th>
											
										</tr>
									</thead>
									<tbody>

									<?php	   $user_id = array();
								         if(!empty($_POST['user_id'])  || !empty($_POST['range']))
								        { 
								          // print_r($_POST); exit();
								         
								          if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
								            $user_id[] = $_POST['user_id'];
								          }
								          
								          if(isset($_POST['range']) && !empty($_POST['range'])) {
								           
								            $date_range = explode('-', $_POST['range']);
								            $start_date = $date_range[0];
								            $end_date = $date_range[1];
								            $start_time=strtotime($start_date);
								            $start_day=date("d",$start_time);
								            $start_month=date("m",$start_time);
								            $start_year=date("Y",$start_time);
								            $end_date=strtotime($end_date);
								            $end_day=date("d",$end_date);
								            $end_month=date("m",$end_date);
								            $end_year=date("Y",$end_date);
								           
								            $from_date = date("Y-m-d", $start_time);       
								              $to_date = date("Y-m-d", $end_date);
								              $earlier = new DateTime($from_date);
								              $later = new DateTime($to_date);

								              $col_count = $later->diff($earlier)->format("%a");
								              
								            if(empty($user_id)){
								              // $all_users = $this->db->get_where('users',array('role_id !='=>2,'role_id !='=>1,'activated'=>1,'banned'=>0))->result_array();
								            $branch_id = $this->session->userdata('branch_id');

								              $this->db->where('a_month >=', $start_month);
								              $this->db->where('a_month <=', $end_month);
								              $this->db->where('a_year >=', $start_year);
								              $this->db->where('a_year <=', $end_year);
								              $this->db->where('ad.subdomain_id', $this->session->userdata('subdomain_id'));

								              	if($branch_id != '') {
								            		$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
								            	}

								            	if($dept_id != '') {
								            		$this->db->where("u.department_id IN (".$dept_id.")",NULL, false);
								            	}

								        		$all_users = $this->db->select('*')
									              	->from('attendance_details ad')
									              	->join('users u', 'u.id=ad.user_id', 'LEFT')
									              	->get()
									              	->result_array();
								              //$all_users =  $this->db->get('attendance_details')->result_array();
								                // echo $this->db->last_query();  exit;
								               if(!empty($all_users)){
								                foreach ($all_users as $key => $value) {
								                  $user_id[] = $value['user_id'];
								                }
								              }
								            }
								          } 
								          $user_ids =  array_unique($user_id);
								         $branch_id = $this->session->userdata('branch_id');
								           
								            $this->db->where_in('user_id', $user_ids);
								            $this->db->where('a_month',$start_month);
								            $this->db->where('a_year',$start_year);
								            //$this->db->select('user_id,month_days,month_days_in_out');
								            if($branch_id != '') {
							            		$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
							            	}

							            	if($dept_id != '') {
							            		$this->db->where("u.department_id IN (".$dept_id.")",NULL, false);
							            	}

								            $results  = $this->db->select('user_id,month_days,month_days_in_out')
									              	->from('attendance_details ad')
									              	->join('users u', 'u.id=ad.user_id', 'LEFT')
									              	->get()
									              	->result_array();
								            //$results  = $this->db->get('dgt_attendance_details')->result_array();
								             // echo $this->db->last_query(); 
								              //echo 'wer<pre>';print_r($branch_id); exit;
								        } else{

								          $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
								          	$array = explode(',',$dept_id);
						                    if(is_array($array) && sizeof($array)>1 ){
						                        $dept_id = $array;
						                    }else{
						                        $dept_id = $array[0];
						                    }
						                    // echo "<pre>";print_r($dept_id);
								          if($dept_id !=0){

								          	if(is_array($dept_id)){
						                        $dept_users = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->where_in('department_id',$dept_id)->get('users')->result_array();
						                    }else{
						                        $dept_users= $this->db->get_where('users',array('department_id'=>$dept_id,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
						                    }
						                    // echo "<pre>";print_r($dept_users);
								              if(!empty($dept_users)){
								                foreach ($dept_users as $key => $value) {
								                  $user_id[] = $value['id'];
								                }
								              }
								              $user_ids =  array_unique($user_id);

								              $branch_id = $this->session->userdata('branch_id');
								              //$branch = array_unique($branch_id);

								         $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
								           
								            $this->db->where_in('user_id', $user_ids);     
								            $this->db->where('a_month',$a_month);
								            $this->db->where('a_year',$a_year);

								            if($branch_id != '') {
							            		$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
							            	}

							            	if($dept_id != '') {
							            		$this->db->where("u.department_id IN (".$dept_id.")",NULL, false);
							            	}
							            	
								            $results  = $this->db->select('user_id,month_days,month_days_in_out')
									              	->from('attendance_details ad')
									              	->join('users u', 'u.id=ad.user_id', 'LEFT')
									              	->get()
									              	->result_array();  
									        //echo '<pre>users<pre>'; print_r($branch_id); //exit;           
									        //echo 'test<pre>';print_r($results); exit;  
								            // $this->db->select('user_id,month_days,month_days_in_out');
								            // $results  = $this->db->get('dgt_attendance_details')->result_array();
								          }     
								          if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){  
								            $where = array('a_month'=>$a_month,'a_year'=>$a_year,'subdomain_id'=>$this->session->userdata('subdomain_id'));
								             $this->db->select('user_id,month_days,month_days_in_out');
								             $results  = $this->db->get_where('dgt_attendance_details',$where)->result_array();
								        }

								      } ?>
									<?php 
									$projects = $this->db->get_where('projects',array('subdomain_id' => $this->session->userdata('subdomain_id')))->result_array();
									// echo "<pre>";print_r($projects);
									
                         
		                           	if(isset($_POST['range']) && !empty($_POST['range'])){
			                            $number = $col_count;
			                            $start_val = 0;
			                            $month = $start_month;
			                            $year = $start_year;
			                            $sno = 1;
			                          
			                            	$production_hours = 0;                                	
		                              			   $production_hour = 0;   
		                                   	foreach ($results as $rows) {
												$shist_assigned= 0;
												$production_hours = 0;                                	
		                              			   $production_hour = 0;   
		                                   		foreach ($projects as $key => $project) {
		                                   			 for($d=$start_val; $d<=$number; $d++)
			                           {
			                            	$time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
			                                   
			                              // if (date('m', $time)==$month)       
		                                  	$date=date('d M Y', $time);
		                                  	$schedule_date=date('Y-m-d', $time);
	                                  		$a_day =date('d', $time);

		                                   	$a_day -=1;
		                                   	$shist_assigned= 0;
		                                   			$scheduling_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
		                                   			$shift_scheduling = $this->db->get_where('shift_scheduling',$scheduling_where)->row_array();
		                                   			// $sno = 1;
		                                   			if(!empty($shift_scheduling)){
			                                     	if(!empty($rows['month_days_in_out'])){

					                                     $month_days_in_outs =  unserialize($rows['month_days_in_out']);

					                                      $i =1;   

				                                         $j=1;         
				                                         $production_hour = 0;         
														foreach ($month_days_in_outs[$a_day] as $punch_detailss) 
														{

														  
														   if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
														  	{
														  		if(isset($punch_detailss['project_id'])){
															  		if($punch_detailss['project_id'] == $project['project_id']){
														  				// $sno ++;
															  			$shist_assigned = 1;
															    		$day = $a_day+1;
															    
																       	$today_work_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
																        $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
																          // echo $day.'' .print_r($today_work_hour); exit;
																        if($today_work_hour['free_shift'] == 1 ){
																            if($today_work_hour['start_time'] == '00:00:00'){
																                $later_entry_hours = 0;
																            }else{
																              $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
																            }
																           
																        }else{
																           $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
																           // echo $days; exit;
																          $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
																          $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
																        }
																        $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
																      
																        if($punch_detailss['punch_out'] > $today_work_hour['max_end_time']){
																            $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
																        }else{
																            $between_endto_max_end = 0;
																        }    
																        // }                    
																       $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
															   		}
														   		}
															       // echo $production_hour; exit;                    
														  	}														   

															   $j++;
														}	
														if($production_hour > 0 && $later_entry_hours>0){
											              $production_hour = $production_hour-$end_between;
											            } else{
											              $production_hour = $production_hour-$start_between-$end_between;
											            }
				                                    
				                                    }
				                                
				                                    $user_details= $this->db->get_where('users',array('id'=>$rows['user_id']))->row_array();
					                                $account_details= $this->db->get_where('account_details',array('user_id'=>$rows['user_id']))->row_array();                    
					                                if(!empty($user_details['designation_id'])){
					                                  $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
					                                  $designation_name = $designation['designation'];
					                                  
					                                }else{
					                                  $designation_name = '-';
					                                }
				                                    ?>
				                                    <?php if($shist_assigned == 1){ ?>
				                                    	<tr>
															<td><?php echo $sno++;?></td>
															<td>
															  	<div class="user_det_list" style="margin-bottom: 10px;">
										                            <a href="javascript:void(0)"> <img class="avatar" src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
										                            <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
										                            <span class="userrole-info"> <?php echo $designation_name;?></span>
										                            <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
									                          	</div>																
															</td>															
															<td><?php echo $schedule_date;?></td>
															<td>
																<h2><?php echo $project['project_title']; ?></h2>
															</td>
															<td><?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?> </td>
															<!-- <td class="text-center">7</td> -->
															<td class="col-md-4"><?php echo date('l', $time); ?></td>
															<?php $production_hours += $production_hour; ?>
															<td class="col-md-4"><?php echo !empty($production_hours)?intdiv($production_hours, 60).'.'. ($production_hours % 60).' hrs':'-';?></td>
															
													</tr>

			                                  	<?php }
			                                  		}
		                                  		}

		                            		} 
	                                    } 
		                           	}else{

		                             	$month = $a_month;
			                          	$year = $a_year;

			                          	// $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			                          	$number = date('d');
			                          	$sno = 1;
			                          
		                              			   $production_hours = 0;                                	
		                              			   $production_hour = 0;                                	

	                                    	foreach ($results as $rows) {
												$shist_assigned= 0;
												 $production_hours = 0; 
												 $production_hour = 0; 
		                                   		foreach ($projects as $key => $project) {
		                                   			for($d=1; $d<=$number; $d++)
			                           	{
			                              	$time=mktime(12, 0, 0, $month, $d, $year);          
			                              	if (date('m', $time)==$month)       
			                                  	$date=date('d M Y', $time);
			                                  	$schedule_date=date('Y-m-d', $time);
			                                  	$a_day =date('d', $time);

			                                   	$a_day -=1;		
			                                   	$shist_assigned= 0;
		                                   			$scheduling_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
		                                   			$shift_scheduling = $this->db->get_where('shift_scheduling',$scheduling_where)->row_array();
		                                   			// $sno = 1;
		                                   			if(!empty($shift_scheduling)){
			                                     	if(!empty($rows['month_days_in_out'])){

					                                     $month_days_in_outs =  unserialize($rows['month_days_in_out']);

					                                      $i =1;   

				                                         $j=1;         
				                                         $production_hour = 0;         
														foreach ($month_days_in_outs[$a_day] as $punch_detailss) 
														{

														  
														   if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
														  	{
														  		if(isset($punch_detailss['project_id'])){
															  		if($punch_detailss['project_id'] == $project['project_id']){
														  				// $sno ++;
															  			$shist_assigned = 1;
															    		$day = $a_day+1;
															    
																       	$today_work_where     = array('employee_id'=>$rows['user_id'],'schedule_date'=>$schedule_date);
																        $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
																          // echo $day.'' .print_r($today_work_hour); exit;
																        if($today_work_hour['free_shift'] == 1 ){
																            if($today_work_hour['start_time'] == '00:00:00'){
																                $later_entry_hours = 0;
																            }else{
																              $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
																            }
																          
																           
																         
																           
																        }else{
																           $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
																           // echo $days; exit;
																          $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
																          $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   
																        }
																        $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
																      
																        if($punch_detailss['punch_out'] > $today_work_hour['max_end_time']){
																            $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
																        }else{
																            $between_endto_max_end = 0;
																        }    
																        // }                    
																       $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
															   		}
														   		}
															       // echo $production_hour; exit;                    
														  	}														   

															   $j++;
														}	
														if($production_hour > 0 && $later_entry_hours>0){
											              $production_hour = $production_hour-$end_between;
											            } else{
											              $production_hour = $production_hour-$start_between-$end_between;
											            }
				                                    
				                                    }
				                                
				                                    $user_details= $this->db->get_where('users',array('id'=>$rows['user_id']))->row_array();
					                                $account_details= $this->db->get_where('account_details',array('user_id'=>$rows['user_id']))->row_array();                    
					                                if(!empty($user_details['designation_id'])){
					                                  $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
					                                  $designation_name = $designation['designation'];
					                                  
					                                }else{
					                                  $designation_name = '-';
					                                }
				                                    ?>
				                                    <?php if($shist_assigned == 1){ ?>
				                                    	<tr>
											<td><?php echo $sno++;?></td>
											<td>

												  <div class="user_det_list" style="margin-bottom: 10px;">
						                            <a href="javascript:void(0)"> <img class="avatar" src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
						                            <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
						                            <span class="userrole-info"> <?php echo $designation_name;?></span>
						                            <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
						                          </div>
												
											</td>
											
											<td><?php echo $schedule_date;?></td>
											<td>
												<h2><?php echo $project['project_title']; ?></h2>
											</td>
											<td><?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?> </td>
											<!-- <td class="text-center">7</td> -->
											<td class="col-md-4"><?php echo date('l', $time); ?></td>
											<?php $production_hours += $production_hour;?>
											<td class="col-md-4"><?php echo !empty($production_hours)?intdiv($production_hours, 60).'.'. ($production_hours % 60).' hrs':'-';?></td>
											
										</tr>

			                                  	<?php 
			                                  }
			                                  	}
			                                  }


		                            		} 
			                           	
		                           		}
		                           	}
		                           
		                            ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
                </div>
            <!-- </div> -->

            			<div id="add_todaywork" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('add_today_work_details'); ?></h4>
						</div>
						<div class="modal-body">
							<form method="post" id="add_timeline"> 
								<div class="form-group">
									<label><?php echo lang('project'); ?> <span class="text-danger">*</span></label>
									<select class="select form-control" name="project_name" id="project_name">
										<option value="" selected="selected" disabled=""><?php echo lang('choose_project');?></option>
										<?php foreach($projects as $project){ ?>
										<option value="<?php echo $project['project_id']; ?>"><?php echo $project['project_title']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label><?php echo lang('date'); ?> <span class="text-danger">*</span></label>
										<div class=""><input class="form-control TimeSheetDate" type="text" value="<?php echo date('d-m-Y'); ?>" name="timeline_date" id="timeline_date" data-date-format="dd-mm-yyyy"></div>
										<!-- <input type="hidden" name="user_id" value=""> -->
									</div>
									<div class="form-group col-sm-6">
										<label><?php echo lang('hours'); ?> <span class="text-danger">*</span></label>
										<input class="form-control" type="text" placeholder="00:00" name="timeline_hours" id="timeline_hours">
										<span class="Error-Hours" style="display: none;color:red"><?php echo lang('hour_error'); ?></span>
										<span class="Error-Hours-Exist" style="display: none;color:red"><?php echo lang('hour_error'); ?> </span>
									</div>
								</div>
								<div class="form-group">
									<label><?php echo lang('description'); ?> <span class="text-danger">*</span></label>
									<textarea rows="4" cols="5" class="form-control" name="timeline_desc" id="timeline_desc"></textarea>
								</div>
								<div class="m-t-20 text-center">
									<button class="btn btn-primary" id="new_timesheet_btn"><?php echo lang('save'); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php foreach($all_timesheet as $timesheet){ ?>
				<div id="edit_todaywork<?php echo $timesheet['time_id']; ?>" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('description'); ?> </h4>
						</div>
						<div class="modal-body">
							<form method="post" id="edit_timesheet">
								<div class="form-group">
									<label><?php echo lang('project'); ?>  <span class="text-danger">*</span></label>
									<select class="select form-control" name="project_name" id="project_name<?php echo $timesheet['time_id']; ?>">
										<option value="" selected="selected" disabled=""><?php echo lang('choose_project'); ?> </option>
										<?php foreach($projects as $project){ ?>
										<option value="<?php echo $project['project_id']; ?>" <?php if($timesheet['project_id'] == $project['project_id']){ ?> selected="selected" <?php } ?>><?php echo $project['project_title']; ?></option>
										<?php } ?>
									</select>
									<div class="row">
									<div class="col-md-12">
									<label id="project_name_required" class="error display-none" for="project_name"  style="top:0;font-size:15px;"><?php echo lang('please_select_a_project'); ?> </label>
									</div>
									</div>

								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label><?php echo lang('date'); ?>  <span class="text-danger">*</span></label>
										<div class="cal-icon"><input class="form-control" readonly value="<?php echo $timesheet['timeline_date']; ?>" name="timeline_date" id="timeline_date<?php echo $timesheet['time_id']; ?>" type="text" ></div>
										<div class="row">
										<div class="col-md-12">
										<label id="timeline_date_required" class="error display-none" for="timeline_date" style="top:0;font-size:15px;"><?php echo lang('date_is_required'); ?> </label>
										</div>
									    </div>

									</div>
									<div class="form-group col-sm-6">
										<label><?php echo lang('hours'); ?>  <span class="text-danger">*</span></label>
										<input class="form-control workTimelineHour" type="text" value="<?php echo $timesheet['hours']; ?>" name="timeline_hours" id="timeline_hours<?php echo $timesheet['time_id']; ?>">
										<span class="Error-Hours-edit" style="display: none;color:red"><?php echo lang('hour_error'); ?> </span>
										<span class="Error-Hours-Exist-edit" style="display: none;color:red"><?php echo lang('total_hours_overtime'); ?>  </span>
										<div class="row">
										<div class="col-md-12">
										<label id="timeline_hours_error" class="error display-none" for="timeline_hours" style="top:0;font-size:15px;"><?php echo lang('please_enter_valid_format'); ?> </label>
										<label id="timeline_hours_required" class="error display-none" for="timeline_hours"  style="top:0;font-size:15px;"><?php echo lang('hour_is_required'); ?> </label>
										</div>
									     </div>

									</div>
								</div>
								<div class="form-group">
									<label><?php echo lang('description'); ?>  <span class="text-danger">*</span></label>
									<textarea rows="4" cols="5" class="form-control workTimelineDesc" name="timeline_desc" id="timeline_desc<?php echo $timesheet['time_id']; ?>" ><?php echo $timesheet['timeline_desc']; ?></textarea>
									<div class="row">
									<div class="col-md-12">
									<label id="timeline_desc_error" class="error display-none" for="timeline_desc" style="top:0;font-size:15px;"><?php echo lang('description_is_required'); ?> </label>
									</div>
									</div>
								</div>
								<div class="m-t-20 text-center">
									<button type="button" class="btn btn-primary edit_timesheet_btn" id="timesheet_edit_submit" data-editid="<?php echo $timesheet['time_id']; ?>" ><?php echo lang('save_changes'); ?> </button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_workdetail<?php echo $timesheet['time_id']; ?>" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo lang('delete_work_details'); ?> </h4>
						</div>
						<div class="modal-body card-box">
							<p><?php echo lang('are_you_sure_want_to_delete'); ?> </p>
							<div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?> </a>
								<button type="submit" class="btn btn-danger Delete-Timeline" data-timeid="<?php echo $timesheet['time_id']; ?>"><?php echo lang('delete'); ?> </button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
    <script>
  // var start = moment().subtract(29, 'days');
  var start = moment();
  var end = moment();

  $('#reportrange').daterangepicker({
    // startDate: start,
    // endDate: end,
    ranges: {
       '<?php echo lang('today'); ?>': [moment(), moment()],
       '<?php echo lang('yesterday'); ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       '<?php echo lang('last_7_days'); ?>': [moment().subtract(6, 'days'), moment()],
       '<?php echo lang('last_30_days'); ?>': [moment().subtract(29, 'days'), moment()],
       '<?php echo lang('this_month'); ?>': [moment().startOf('month'), moment().endOf('month')],
       '<?php echo lang('last_month'); ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  });
</script>