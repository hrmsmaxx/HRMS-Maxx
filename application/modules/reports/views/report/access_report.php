<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 
<?php 
$branch_id = $this->session->userdata('branch_id');

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
   $subdomain_id     = $this->session->userdata('subdomain_id');

   if($branch_id != '') {
		$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
	}
   $record = $this->db->select('ad.*')
  				->from('attendance_details ad')
  				->join('users u', 'u.id=ad.user_id')
  				->where(array('a_month'=>$a_month,'a_year'=>$a_year, 'ad.subdomain_id'=> $subdomain_id))
  				->get()
  				->result_array();
   /*$where     = array('subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
   // $this->db->select('month_days,month_days_in_out');
   $record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();*/
   ?>
<div class="content">
	<div class="panel panel-white">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-0"><?=lang('access_report')?></h4>
				</div>
				<div class="col-sm-4 text-right">
					<a class="btn btn-white m-r-5" href="javascript: void(0);" id="filter_search">
						<i class="fa fa-filter m-r-0"></i>
					</a>
					 <div class="btn-group">
			            <button class="btn btn-default"><?=lang('export')?></button>
			            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
			            </button>
			            <ul class="dropdown-menu export" style="left:auto; right:0px !important; min-width: 93px !important">  
			              <li>
			                <form method="post" action="">
			                    <input type="hidden" class="form-control" name = "pdf" value="1">
			                    <input type="hidden" class="form-control id_code_excel" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">
			                    <input type="hidden" class="form-control department_id_excel" name = "department_id" value="<?php echo (isset($_POST['department_id']) && !empty($_POST['department_id']))?$_POST['department_id']:'';?>">
			                    <input type="hidden" class="form-control teamlead_id_excel" name = "teamlead_id" value="<?php echo (isset($_POST['teamlead_id']) && !empty($_POST['teamlead_id']))?$_POST['teamlead_id']:'';?>">
			                    <input type="hidden" class="form-control range_excel" name = "range" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
			                    <input type="hidden" class="form-control user_id_excel" name = "user_id" value="<?php echo (isset($_POST['user_id']) && !empty($_POST['user_id']))?$_POST['user_id']:'';?>">
			                    <button class=" btn  btn-block" type="submit" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-pdf-o"></i></span> <span><?=lang('pdf')?></span></button>
			                     <!-- <a href="#" class="pull-right" id="attendance_report_pdf1" type="submit"> -->
			                     
			                      <!-- </a> -->
			                </form>
			               
			              </li>
			              <li>
                <?php  $report_name = lang('access_report');?>
                 <button class="btn  btn-block" onclick="access_report_excel('<?php echo $report_name;?>','access_report');" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span><span><?=lang('excel')?></span> </button>
              </li>
			            </ul>
			          </div>
					<?=$this->load->view('report_header');?>					
				</div>
			</div>

		</div>

		<div class="panel-body">
			<form method="post" action="" class="filter-form" id="filter_inputs" style="display:none;">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('device')?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
						 	<div class="form-group">
				              <label><?=lang('rangeof_time')?></label>
				              <input type="text" name="range" id="reportrange" class="pull-right form-control" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
				              <i class="fa fa-calendar"></i>&nbsp;
				              <span></span> <b class="caret"></b>
				            </div>
						</div>
					</div>
					<div class="col-md-3">
					 	<div class="form-group">
			              <label><?=lang('employees_code')?></label>
			              <input type="text" class="form-control" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">          
			             
			            </div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
			              <label><?=lang('employees')?></label>
			              <select class="select2-option form-control" name="user_id" id="user_name">
			                    <optgroup label="">
			                    <option value=""><?php echo lang('select_employee');?></option> 
			                        <?php 
			                        if($branch_id != '') {
										$this->db->where("branch_id IN (".$branch_id.")",NULL, false);
									}
			                        $employee = $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'role_id'=>3,'activated'=>1,'banned'=>0))->result();


			                        foreach ($employee as $c): 
			                        ?>

			                            <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
			                        <?php endforeach;  ?>
			                    </optgroup>
			                </select>
			            </div>
					</div>
					<?php $departments = $this->db->order_by("deptname", "asc")->get_where('departments',array('subdomain_id'=>$subdomain_id))->result(); ?>
		          	<div class="col-md-3">
			            <div class="form-group">
			              <label><?=lang('department')?></label>
			              <select class="select2-option form-control" name="department_id" id="department" >
			                    <option value="" selected ><?php echo lang('select_department');?></option>
			                    <?php
			                    if(!empty($departments))  {
			                    foreach ($departments as $department){ ?>
			                    <option value="<?=$department->deptid?>" <?php echo (isset($_POST['department_id']) && ($_POST['department_id'] == $department->deptid))?"selected":""?>><?=$department->deptname?></option>
			                    <?php } ?>
			                    <?php } ?>
			                  </select>
			            </div>
		          	</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('office')?></label>
							<input type="text" class="form-control">
						</div>
					</div>
				  	<?php 
				  	if($branch_id != '') {
						$this->db->where("branch_id IN (".$branch_id.")",NULL, false);
					}
				  	$teamlead_id = $this->db->where(array('subdomain_id'=>$subdomain_id,'role_id'=>3,'activated'=>1,'banned'=>0,'is_teamlead'=>'yes')) -> get('users')->result(); ?>
		          	<div class="col-md-3">
			            <div class="form-group">
			              <label><?=lang('employees_boss')?></label>
			              <select class="select2-option form-control" name="teamlead_id" >
			                    <option value="" selected ><?php echo lang('select_boss');?></option>
			                    <?php
			                    if(!empty($teamlead_id))  {
			                    foreach ($teamlead_id as $teamlead){ ?>
			                    <option value="<?=$teamlead->id?>" <?php echo (isset($_POST['teamlead_id']) && ($_POST['teamlead_id'] == $teamlead->id))?"selected":""?>><?php echo User::displayName($teamlead->id);?></option>
			                    <?php } ?>
			                    <?php } ?>
			                  </select>
			            </div>
		          	</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('24_hours_workdays')?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button class="btn btn-success btn-md" type="submit"><?=lang('run_report')?></button>
						</div>
					</div>
				</div>
			</form>
			
			<table id="excel_export_id" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr>
						<th><?=lang('date')?></th>
						<th><?=lang('employee')?></th>
						<th><?=lang('time')?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
				 $user_id = array();
				if(!empty($_POST['id_code']) || !empty($_POST['user_id']) || !empty($_POST['department_id']) || !empty($_POST['teamlead_id']) || !empty($_POST['range']))
                { 
                	  
                 
                  if(isset($_POST['id_code']) && !empty($_POST['id_code'])){

                    $users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id_code'=>$_POST['id_code']))->row_array();
 
                    if(!empty($users)){
                      $user_id[] = $users['id'];
                    }else{
                      $user_id ='';
                    }

                  } 

                  if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
                    $user_id[] = $_POST['user_id'];
                  }
                  if(isset($_POST['department_id']) && !empty($_POST['department_id'])){
                    //$dept_users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'department_id'=>$_POST['department_id']))->result_array();
                    $dept_id = $_POST['department_id'];
                    $dept_users= $this->db->select('*')
                    			->from('users')
                    			->where('subdomain_id',$subdomain_id)
                    			->where("FIND_IN_SET('$dept_id',department_id) !=", 0)
                    			//->where_in('department_id',$_POST['department_id'])
                    			->get()
                    			->result_array();
                    if(!empty($dept_users)){
                      foreach ($dept_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }
                  if(isset($_POST['teamlead_id']) && !empty($_POST['teamlead_id'])){
                    $team_users= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'teamlead_id'=>$_POST['teamlead_id']))->result_array();
                    if(!empty($team_users)){
                      foreach ($team_users as $key => $value) {
                        $user_id[] = $value['id'];
                      }
                    }
                  }

                  if(isset($_POST['range']) && !empty($_POST['range'])){
                   
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
                    	 // echo "<pre>";   print_r($_POST); exit;
                      // $all_users = $this->db->get_where('users',array('role_id !='=>2,'role_id !='=>1,'activated'=>1,'banned'=>0))->result_array();
                      /*$this->db->where('a_month >=', $start_month);
                      $this->db->where('a_month <=', $end_month);
                      $this->db->where('a_year >=', $start_year);
                      $this->db->where('a_year <=', $end_year);
                      $this->db->where('subdomain_id', $subdomain_id);
                      $all_users =  $this->db->get('attendance_details')->result_array();*/

                      if($branch_id != '') {
							$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
						}
                      	$all_users = $this->db->select('ad.*')
                      				->from('attendance_details ad')
                      				->join('users u', 'u.id=ad.user_id')
                      				->where(array('a_month >='=>$start_month, 'a_month <='=>$end_month, 'a_year >='=>$start_year,'a_year <='=>$end_year, 'ad.subdomain_id'=> $subdomain_id))
                      				->get()
                      				->result_array();
                      // echo "<pre>";   print_r($all_users); exit;
                       if(!empty($all_users)){
                        foreach ($all_users as $key => $value) {

                          $user_ids[] = $value['user_id'];
                          
                        }
                        $user_id = $user_ids;
                      }
                    }
                     
                  } 
              } else{              	 
	               if(!empty($record)){
	                foreach ($record as $key => $value) {
	                  $user_id[] = $value['user_id'];
	                }
              	}
          	}
          	$users_id =  array_unique($user_id); 

           	foreach ($users_id as $key => $value) {

           		if($value !=1){                    
	          		$user_id = $value;	                     
	             // print_r($_POST['range']); exit;
	                if(isset($_POST['range']) && !empty($_POST['range'])){
	                  /*$this->db->select('month_days,month_days_in_out');
	                  $this->db->where('user_id', $user_id);
	                  $this->db->where('a_month ', $start_month);
	                  // $this->db->where('a_month <=', $end_month);
	                  // $this->db->where('a_year >=', $start_year);
	                  $this->db->where('a_year ', $start_year);
                      $this->db->where('subdomain_id', $subdomain_id);
	                  $results =  $this->db->get('attendance_details')->result_array();*/
	                  if($branch_id != '') {
							$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
						}
                      	$results = $this->db->select('month_days,month_days_in_out')
                      				->from('attendance_details ad')
                      				->join('users u', 'u.id=ad.user_id')
                      				->where(array('user_id'=>$user_id, 'a_month '=>$start_month, 'a_year '=>$start_year,'ad.subdomain_id'=> $subdomain_id))
                      				->get()
                      				->result_array();

	                } else{
	                  $a_year    = date('Y');
	                  $a_month   = date('m');

	                  	if($branch_id != '') {
							$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
						}
                      	$results = $this->db->select('month_days,month_days_in_out')
                      				->from('attendance_details ad')
                      				->join('users u', 'u.id=ad.user_id')
                      				->where(array('user_id'=>$user_id, 'a_month '=>$a_month, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id,'u.id!='=>$this->session->userdata('user_id')))
                      				->get()
                      				->result_array();
	                /* $where     = array('subdomain_id'=>$subdomain_id,'user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
	                 $this->db->select('month_days,month_days_in_out');
	                 $results  = $this->db->get_where('dgt_attendance_details',$where)->result_array();*/
	                 
	                }
                   
                     
                 	$sno=1;
                     // echo "<pre>";print_r($results); 
                 	foreach ($results as $rows) {

                      	$list=array();
                      	if(isset($_POST['range']) && !empty($_POST['range'])){
	                        $number = $col_count;
	                        $start_val = 0;
                      	}else{
	                        $month = $a_month;
	                        $year = $a_year;

	                        $number = $a_day;
	                        // $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	                        $start_val = $a_day;

                      	}
                          $week_off = 0;
                          $actually_worked = 0;
                          $absent = 0;
                      	for($d=$start_val; $d<=$number; $d++)
                       	{
                            if(isset($_POST['range']) && !empty($_POST['range'])){
                                  $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                            } else{
                               $time=mktime(12, 0, 0, $month, $d, $year);     
                          

                            }

                              // if (date('m', $time)==$month)       
                          	$date=date('d M Y', $time);
                          	$new_date=date('d/m/Y', $time);
                          	$schedule_date=date('Y-m-d', $time);
                          	$a_day =date('d', $time);
                          	$a_month =date('m', $time);
                          	$a_year =date('Y', $time);
	                           // echo print_r($schedule_date) ; exit;   
                          	/*$this->db->select('month_days,month_days_in_out');
                          	$this->db->where('user_id', $user_id);
                          	$this->db->where('a_month ', $a_month);
                          	// $this->db->where('a_month <=', $end_month);
                          	// $this->db->where('a_year >=', $start_year);
                          	$this->db->where('a_year ', $a_year);
                      		$this->db->where('subdomain_id', $subdomain_id);
                          	$rows =  $this->db->get('attendance_details')->row_array(); */

                          	if($branch_id != '') {
								$this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
							}
	                      	$rows = $this->db->select('month_days,month_days_in_out')
	                      				->from('attendance_details ad')
	                      				->join('users u', 'u.id=ad.user_id')
	                      				->where(array('user_id'=>$user_id, 'a_month '=>$a_month, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id,'u.id!='=>$this->session->userdata('user_id')))
	                      				->get()
	                      				->row_array();

	                        if(!empty($rows['month_days'])){


	                        $month_days =  unserialize($rows['month_days']);
	                        $month_days_in_out =  unserialize($rows['month_days_in_out']);
	                        $day = $month_days[$a_day-1];
	                        $day_in_out = $month_days_in_out[$a_day-1];
	                        $latest_inout = end($day_in_out);
                               
                                 
                                 $k = 1;
                               
                        
                             $user_details= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id'=>$user_id))->row_array();
							$account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();                    
							if(!empty($user_details['designation_id'])){
		                      $designation = $this->db->get_where('designation',array('subdomain_id'=>$subdomain_id,'id'=>$user_details['designation_id']))->row_array();
		                      $designation_name = $designation['designation'];
		                      
		                    }else{
		                      $designation_name = '-';
		                    }
                    

                      $production_hour=0;
                                 $break_hour=0;
                                 $k = 1;
                                foreach ($month_days_in_out[$a_day-1] as $punch_detail) 
                                {
                                	 if(!empty($punch_detail['punch_in']) )
                                    { ?>
                                    	<tr>
				                 		<td><?php echo $new_date ;?> <br>
				                        <?php echo date('l', $time)?>
				                      	</td>
				       					<td>
					       					<div class="user_det_list" style="margin-bottom: 10px;">
							                    <a href="<?php echo base_url().'employees/profile_view/'.$user_id;?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
							                    <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
							                    <span class="userrole-info"> <?php echo $designation_name;?></span>
							                    <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
						                  	</div>
								                						
										</td>
										<td><i class="fa fa-arrow-right text-success"></i> <?php echo $punch_detail['punch_in'];?></td>
									</tr>

                                   <?php  }
                                    if(!empty($punch_detail['punch_out'])){?>
                                		<tr>
				                 		<td><?php echo $new_date ;?> <br>
				                        <?php echo date('l', $time)?>
				                      	</td>
				       					<td>
					       					<div class="user_det_list" style="margin-bottom: 10px;">
							                    <a href="<?php echo base_url().'employees/profile_view/'.$user_id;?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
							                    <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
							                    <span class="userrole-info"> <?php echo $designation_name;?></span>
							                    <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
						                  	</div>
								                						
										</td>
										<td><i class="fa fa-arrow-left text-danger"></i> <?php echo $punch_detail['punch_out'];?></td>
									</tr>
									<tr>
										<td><?php echo lang('attendance_time');  ?></td>
										<td><?php  $production_hour = time_difference(date('H:i',strtotime($punch_detail['punch_in'])),date('H:i',strtotime($punch_detail['punch_out'])));?>
											<?php echo !empty($production_hour)?intdiv($production_hour, 60).'.'. ($production_hour % 60).' hrs':'-';?>
										</td>
										<td><?php echo '';?></td>
									<tr>

                                  <?php $production_hour = 0;  }
                                     
                                }?>
                     
                      <?php
 }  } } } } ?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	var start = moment().subtract(29, 'days');
	var end = moment();

	$('#reportrange').daterangepicker({
		// startDate: start,
		// endDate: end,
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		   'This Month': [moment().startOf('month'), moment().endOf('month')],
		   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		}
	});
</script>