<script src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css"/> 

<div class="content">
	<div class="row"> 
    <div class="col-sm-12  text-right m-b-20">     
      <a class="btn back-btn" href="<?=base_url()?>attendance"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
    </div>
  </div>
	<div class="panel panel-white">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-0"><?=lang('attendance_period_closing')?></h4>
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
			                    <input type="hidden" class="form-control attendance_month_excel" name = "attendance_month" value="<?php echo (isset($_POST['attendance_month']) && !empty($_POST['attendance_month']))?$_POST['attendance_month']:date('m');?>">
			                    <input type="hidden" class="form-control attendance_year_excel" name = "attendance_year" value="<?php echo (isset($_POST['attendance_year']) && !empty($_POST['attendance_year']))?$_POST['attendance_year']:date('Y');?>">
			                    <input type="hidden" class="form-control employee_name_excel" name = "employee_name" value="<?php echo (isset($_POST['employee_name']) && !empty($_POST['employee_name']))?$_POST['employee_name']:'';?>">
			                    <button class=" btn  btn-block" type="submit" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-pdf-o"></i></span> <span><?=lang('pdf')?></span></button>
			                     
			                </form>
			               
			              </li>
			              <li>
			                <?php  $report_name = lang('attendance_period_closing');?>
			                 <button class="btn  btn-block" onclick="attendance_period_closing_excel('<?php echo $report_name;?>','table-attendance');" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span><span><?=lang('excel')?></span> </button>
			              </li>
			            </ul>
			          </div>
					<?=$this->load->view('report_header');?>
					<?php if($this->uri->segment(3) && count($employees)> 0 ){ ?>
					<a href="<?=base_url()?>reports/employeepdf/<?=$company_id;?>" class="btn btn-primary pull-right">
						<i class="fa fa-file-pdf-o"></i> <?=lang('pdf')?>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<form method="post" class="filter-form" id="filter_inputs" style="display:none;">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('employees_code')?></label>
							<input type="text" class="form-control floating" id="employee_id" name="id_code" value="<?php echo (isset($id_code))?$id_code:'';?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('employee')?></label>
							 <input type="text" class="form-control floating" id="username" name="employee_name" value="<?php echo (isset($employee_name))?$employee_name:'';?>">
						</div>
					</div>
					<?php //$departments = $this->db->order_by("deptname", "asc")->get('departments')->result();
                        $departments = $this->db->order_by("deptname", "asc")->get_where('departments', array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result();
                    ?>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('department')?></label>
							<select class="select floating form-control" id="department_id" name="department_id" style="padding: 14px 9px 0px;"> 
                    <option value="" selected="selected"><?php echo lang('all_departments');?></option>
                    <?php if(!empty($departments)){ ?>
                    <?php foreach ($departments as $department) { ?>
                    <option value="<?php echo $department->deptid; ?>" <?php echo (isset($department_id) && $department_id== $department->deptid)?"selected":"";?>><?php echo $department->deptname; ?></option>
                    <?php  } ?>
                    <?php } ?>
                  </select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('turn')?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<?php 
							$s_year = '2019';
							$select_y = date('Y');

							$s_month = date('m');
							$e_year = date('Y');
						 ?>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('year')?></label>
							<select class="select floating form-control" id="attendance_year" name="attendance_year"> 
									<option value="" selected="selected" disabled><?php echo lang('select year');?></option>
									<?php for($k =$e_year;$k>=$s_year;$k--){ ?>
									<option value="<?php echo $k; ?>" <?php echo ($attendance_year==$k)?'selected':''; ?> ><?php echo $k; ?></option>
									<?php } ?>
								</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('month')?></label>
							<select class="select floating form-control" id="attendance_month" name="attendance_month">  
								<option value="" selected="selected" disabled><?php echo lang('select_month');?></option>
								<?php 
									for ($ji=1; $ji <=12 ; $ji++) {  ?>
									<option value="<?php echo $ji; ?>" <?php echo ($attendance_month==$ji)?'selected':''; ?>><?php echo date('F',strtotime($select_y.'-'.$ji)); ?></option>		
									<?php } ?>
								
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="d-block">&nbsp;</label>
							<button class="btn btn-success btn-md" type="submit"><?=lang('run_report')?></button>
						</div>
					</div>
				</div>
			</form>
							<div class="table-responsive">
							<?php $attendance_footer = '';
       $attendance_body = '';
       $attendance_head = '';

        // datas = JSON.parse(datas);
        $last_day = $last_day;
        $current_page = $current_page;
        $total_page = $total_page;
        $attendance_list = $attendance_list;
        $recordscount = count($attendance_list);
        $attendance_head = '<table id="table-templates-1" class="table table-striped custom-table m-b-0 AppendDataTables"><thead><tr><th>'.lang("team_member").'</th>';
        for ($ik = 1; $ik <= $last_day; $ik++) {
          $date = $attendance_year.'-'.$attendance_month.'-'.$ik;
            $attendance_head .= '<th>' . lang(date('M',strtotime($date))).' '.lang($ik) . '</th>';
        }
        $attendance_head .= '</tr></thead>';
        $attendance_body .= '<tbody>';

        $overtimes  = 0;
        $production_hour_achived  = 0;
        $later_entry_hours  =  0;
        $missing_work  =  0;
        $total_scheduled_minutes  =  0;
        $user_id = '';
        if ($recordscount > 0) {
            for ($i = 0; $i < $recordscount; $i++) {

               $record = $attendance_list[$i];

                $name = $record->fullname;
                $attendance = $record->attendance;
               $shift_details;

               $user = $this->db->get_where('users',array('id'=>$record->user_id))->row_array();
            
              if(!empty($user['designation_id'])){
                $designation = $this->db->get_where('designation',array('id'=>$user['designation_id']))->row_array();
                $designation_name = $designation['designation'];
                
              }else{
                $designation_name = '-';
              }
            $imgs = '';
                    if($record->avatar != 'default_avatar.jpg'){
                        $imgs = $record->avatar;
                        
                    }else{
                        $imgs = "default_avatar.jpg";
                    }
                  $id_code = ($user['id_code'] !=0)?$user['id_code']:"-";

                $attendance_body .= '<tr><td><div class="user_det_list">
                        <a href="'.base_url().'employees/profile_view/'.$record->user_id.'"> <img class="avatar" src="'.base_url().'assets/avatar/'.$imgs.'"></a><a class="text-info" href="'.base_url().'attendance/details/'.$record->user_id.'"><h2><span class="username-info">'.user::displayName($record->user_id).'</span>
                        <span class="userrole-info"> '.$designation_name.'</span>
                        <span class="username-info"> '.$id_code.'</span></h2></a>
                        </div></td>';


               // console.log(attendance);
          $overtimes  = 0;
          $production_hour_achived  = 0;
          $later_entry_hours  =  0;
          $missing_work  =  0;
          $total_scheduled_minutes  =  0;
          $user_id = $record->user_id;
               $j=1;
                // $.each(attendance, function (key, rec) {
                  foreach ($attendance as $key => $rec) {
                    # code...
                  // }
                    // console.log(parseInt(key) + 1);
                $user_html = "";
                    //if(record.user_id == 320){
                       
                        $status = $rec['day'];
                        $punchin = $rec['punch_in'];
                        $punch_out = $rec['punch_out'];
                        // $user_id = $record->user_id;
                        $day = $key + 1;
                    //     attendance_day: parseInt(key) + 1,
                    //     attendance_month: attendance_month,
                    //     attendance_year: attendance_year,
                    //     punch_in: rec.punch_in,
                    //     punch_out: rec.punch_out

      
        $day = $key + 1;
        $month = $attendance_month;
        $year  = $attendance_year;
        $punch_in  = $rec['punch_in'];
        $punch_out  = $rec['punch_out'];
        $punch_in_manually_made  = isset($rec['punch_in_manually_made'])?$rec['punch_in_manually_made']:'';
        $punch_out_manually_made  = isset($rec['punch_out_manually_made'])?$rec['punch_out_manually_made']:'';
        $schedule_date = $year.'-'.$month.'-'.$day;
        // if($user_id == 3502 && $day == 01){
        $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>$schedule_date);
        $all_user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->result_array(); 
        //   print_r(count($all_user_schedule)); exit;
        
        if(count($all_user_schedule) == 1){
          $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>$schedule_date);
          $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
         
          if(!empty($user_schedule)){
              $total_scheduled_hour = hours_to_mins($user_schedule['work_hours']);

              $total_scheduled_minutes = $total_scheduled_hour;                                     
              
          } else{
            $total_scheduled_minutes = 0;
          }
          // production_hour
          if(!empty($punch_in) && !empty($punch_out)){
            $production_hour = time_difference(date('H:i',strtotime($punch_in)),date('H:i',strtotime($punch_out)));
          }
                
            // overtimes                    
          if($user_schedule['accept_extras'] == 1){
            $overtimes=($production_hour)-($total_scheduled_minutes);
            if($overtimes > 0)
            {
              $overtimes=$overtimes;
              if($production_hour >= $total_scheduled_minutes){
                  $production_hour_achived=  $production_hour;
              }else{
                  $production_hour_achived=  0;
              }
            }
            else
            {
              if($production_hour >= $total_scheduled_minutes){
                  $production_hour_achived=  $production_hour;
              }else{
                  $production_hour_achived=  0;
              }
              $overtimes=0;
            }
          } else{

            if($production_hour >= $total_scheduled_minutes){
              $production_hour_achived=  $production_hour;
            }else{
              $production_hour_achived=  0;
            }
            $overtimes=0;
          }

          // later_entry_hours

          if(!empty($punch_in))
          {
            if($user_schedule['free_shift'] != 1){
             $later_entry_hours = later_entry_minutes($user_schedule['schedule_date'].' '.$user_schedule['max_start_time'],$schedule_date.' '.$punch_in);
            }else{
              $later_entry_hours = 0;
            }
          } else {
            $later_entry_hours = 0;
          }

          // Missing worke

          $missing_work=($total_scheduled_minutes)-($production_hour);
                              // echo $missing_work; exit;
          if($missing_work > 0)
          {
            $missing_work=$missing_work;
           
          }
          else
          {
            $missing_work=0;
            
          }


          $overtimes  =  $overtimes;
          $production_hour_achived  =  $production_hour_achived;
          $later_entry_hours  =  $later_entry_hours;
          $missing_work  =  $missing_work;
        }else{

          foreach ($all_user_schedule as $value) {
            $work_hours = hours_to_mins($value['work_hours']);
            $total_scheduled_minutes += $work_hours;
            # code...
          }
          
          $where     = array('user_id'=>$user_id,'a_month'=>$month,'a_year'=>$year);
          $this->db->select('month_days,month_days_in_out');
          $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
          $a_dayss =$key;
          $production_hour=0;
          if(!empty($record['month_days_in_out'])){

         $month_days_in_outss =  unserialize($record['month_days_in_out']);
  // echo "<pre>";print_r($a_dayss); exit;
            $j=1;                  
          foreach ($month_days_in_outss[$a_dayss] as $punch_detailss) 
          {

              if(!empty($punch_detailss['punch_in']) && !empty($punch_detailss['punch_out']))
              {
                $day = $a_dayss+1;                
                $schedule_date = date('Y-m-'.$day);
                $today_work_hour = $this->db->query('select * from dgt_shift_scheduling where employee_id ="'.$user_id.'" and schedule_date ="'.$schedule_date.'" AND ((start_time <= "'.$punch_detailss['punch_in'].'" and end_time >="'.$punch_detailss['punch_in'].'") or (start_time >= "'.$punch_detailss['punch_in'].'")) limit 1')->row_array();
                   // $today_work_where     = array('employee_id'=>$user_id,'schedule_date'=>date('Y-m-'.$day));
                   //  $today_work_hour = $this->db->get_where('shift_scheduling',$today_work_where)->row_array();
                      // echo $day.'' .print_r($today_work_hour); exit;
                 if(!empty($today_work_hour)){
                    if($today_work_hour['free_shift'] == 1 ){
                        
                       $later_entry_hours = 0;                      
                       
                    }else{
                      $later_entry_hours = later_entry_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['max_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);   

                      $extra_hours = extra_minutes($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in']);     
                       // echo $days; exit;
                      $start_between = start_between($today_work_hour['schedule_date'].' '.$today_work_hour['min_start_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_in'],$today_work_hour['schedule_date'].' '.$today_work_hour['start_time']); 
                      $end_between = end_between($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],date('Y-m-'.$day).' '.$punch_detailss['punch_out'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']); 
                  
                      if($punch_detailss['punch_out'] > $today_work_hour['max_end_time']){
                          $between_endto_max_end = between_endto_max_end($today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['max_end_time']);
                      }else{
                          $between_endto_max_end = 0;
                      }    
                    }
                  }
                    // }                    
                   $production_hour += time_difference(date('H:i',strtotime($punch_detailss['punch_in'])),date('H:i',strtotime($punch_detailss['punch_out']))); 
                   // echo $production_hour; exit;                    
              }
              $j++;
            }
                  // overtimes     
                  // echo $total_scheduled_minutes.' production_hour';               
                  // echo $production_hour.'later_entry_hours';            
                  // echo $later_entry_hours;exit;               
            if($user_schedule['accept_extras'] == 1){
              $overtimes=($production_hour)-($total_scheduled_minutes);
              if($overtimes > 0)
              {
                $overtimes=$overtimes;
                if($production_hour >= $total_scheduled_minutes){
                    $production_hour_achived=  $production_hour;
                }else{
                    $production_hour_achived=  0;
                }
              }
              else
              {
                if($production_hour >= $total_scheduled_minutes){
                    $production_hour_achived=  $production_hour;
                }else{
                    $production_hour_achived=  0;
                }
                $overtimes=0;
              }
            } else{

              if($production_hour >= $total_scheduled_minutes){
                $production_hour_achived=  $production_hour;
              }else{
                $production_hour_achived=  0;
              }
              $overtimes=0;
            }
            $missing_work=($total_scheduled_minutes)-($production_hour);
                              // echo $missing_work; exit;
            if($missing_work > 0)
            {
              $missing_work=$missing_work;
             
            }
            else
            {
              $missing_work=0;
              
            }

          }
        }
        // echo  $overtime; exit;
         
                    // $.post(base_url + 'attendance/employee_shift_per_day', {
                        
                    //     user_id: user_id,
                    //     attendance_day: parseInt(key) + 1,
                    //     attendance_month: attendance_month,
                    //     attendance_year: attendance_year,
                    //     punch_in: rec.punch_in,
                    //     punch_out: rec.punch_out
                    // }, function (shift_details) {
                        // shift_details = JSON.parse(shift_details);
                        //  $('#overtimes').val(shift_details.overtimes);
                        //  $('#production_hour_achived').val(shift_details.production_hour_achived);
                        //  $('#later_entry_hours').val(shift_details.later_entry_hours);
                        //  $('#missing_work').val(shift_details.missing_work);
                        //  var overtimes = shift_details.overtimes;
                        //  var production_hour_achived = shift_details.production_hour_achived;
                        //  var later_entry_hours = shift_details.later_entry_hours;
                        //  var missing_work = shift_details.missing_work;
                   
                    // console.log(punch_out);
                    // if($punch_out != ''){
                    //     $start = moment.duration(punchin, "HH:mm");
                    //     $end = moment.duration(punch_out, "HH:mm");
                    //     $diff = end.subtract(start);
                    //     $hr =  diff.hours(); // return hours
                    //     $mins = diff.minutes(); // return minutes   
                    // }
                  if(isset($manully_made) && !empty($manully_made)){
                    $attendance_body .= '<td >';
                    if($manully_made == $punch_in_manually_made || $manully_made == $punch_out_manually_made){
                      
                    if ($status == '0') {
                        if($punchin == '' && $punch_out == ''){
                            $attendance_body .= '-';
                        }
                    } else if ($status == '1') {
                        if(($punchin != ''  && $punch_out != '')){
                            if($overtimes!= 0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" data-toggle="tooltip" title="Extra Time Worked"><i class="fa fa-check text-warning"></i></a>';
                            }
                            if($production_hour_achived !=0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-check text-success" data-toggle="tooltip" title="Workday Complete"></i></a>';
                            }if($later_entry_hours !=0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-check text-yellow1" data-toggle="tooltip" title="Late Arrival"></i></a>';
                            }
                            if($missing_work !=0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-close text-danger" data-toggle="tooltip" title="Incomplete Workday Time"></i></a>';
                            }
                            // user_html += '<a href="'+base_url + 'attendance/attendance_details/'+record.user_id+'/'+j+'/'+attendance_month+'/'+attendance_year+'" data-toggle="ajaxModal" ><i class="fa fa-check text-success"></i></a>';
                            
                        }else{
                            $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-close text-danger" data-toggle="tooltip" title="Incomplete Workday Time"></i></a>';
                        }
                    } else if ($status == '2') {
                        $attendance_body .= '<i class="text-success" data-toggle="tooltip" title="Worked Hours"></i>';
                    } else if ($status == '0') {
                        $attendance_body .= '<i class="fa fa-exclamation-triangle text-danger" data-toggle="tooltip" title="No Record for Punch in"></i>';
                    } else if ($status == '') {
                        $attendance_body .= '-';
                    }
                    
                    }else{
                      $attendance_body .= '-';
                    }
                    $attendance_body .= '</td>';
                  } else {
                    $attendance_body .= '<td >';
                    if ($status == '0') {
                        if($punchin == '' && $punch_out == ''){
                            $attendance_body .= '-';
                        }
                    } else if ($status == '1') {
                        if(($punchin != ''  && $punch_out != '')){
                            if($overtimes!= 0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" data-toggle="tooltip" title="Extra Time Worked"><i class="fa fa-check text-warning"></i></a>';
                            }
                            if($production_hour_achived !=0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-check text-success" data-toggle="tooltip" title="Workday Complete"></i></a>';
                            }if($later_entry_hours !=0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-check text-yellow1" data-toggle="tooltip" title="Late Arrival"></i></a>';
                            }
                            if($missing_work !=0){
                                $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-close text-danger" data-toggle="tooltip" title="Incomplete Workday Time"></i></a>';
                            }
                            // user_html += '<a href="'+base_url + 'attendance/attendance_details/'+record.user_id+'/'+j+'/'+attendance_month+'/'+attendance_year+'" data-toggle="ajaxModal" ><i class="fa fa-check text-success"></i></a>';
                            
                        }else{
                            $attendance_body .= '<a href="'.base_url() . 'attendance/attendance_details/'.$user_id.'/'.$day.'/'.$attendance_month.'/'.$attendance_year.'" data-toggle="ajaxModal" ><i class="fa fa-close text-danger" data-toggle="tooltip" title="Incomplete Workday Time"></i></a>';
                        }
                    } else if ($status == '2') {
                        $attendance_body .= '<i class="text-success" data-toggle="tooltip" title="Worked Hours"></i>';
                    } else if ($status == '0') {
                        $attendance_body .= '<i class="fa fa-exclamation-triangle text-danger" data-toggle="tooltip" title="No Record for Punch in"></i>';
                    } else if ($status == '') {
                        $attendance_body .= '-';
                    }
                    $attendance_body .= '</td>';
                  }
                    
                    // $("#user_"+user_id + " td:last").after(user_html);
                    // });
                    
                    ++$j;
               // }
                
                }
                $attendance_body .= '</tr>';
            }
        } else {
            $attendance_body .= '<tr><td></td></tr>';
        }
        $attendance_body .= '</tbody>';

        $attendance_body .= '</table></div>';

        // $total_page = parseInt($total_page);

        // if ($total_page > 1) {

        //     $attendance_footer = '<div class="row"><div class="col-sm-12">' .
        //         '' .
        //         '<div class="dataTables_paginate paging_simple_numbers" id="table-projects_paginate">' .
        //         '<ul class="pagination m-r-15">';

        //     // $total_page = parseInt($total_page);

        //     for ($k = 1; $k <= $total_page; $k++) {
        //         if ($current_page == k) {
        //             $classpage = 'active';
        //         } else { $classpage = ''; }
        //         $attendance_footer .= '<li class="paginate_button ' . $classpage . '"><a href="javascript:void(0)" onclick="attendance_next_filter_page(' . $k . ')">' . $k . '</a></li>';
        //     }
        //     $attendance_footer .= '</ul></div></div></div>';
        // }

        // $attendance_footer .= '<div class="row"><div class="col-md-12"><div class="pagination"></div></div></div>';
        $attendance_html = $attendance_head .''. $attendance_body;
        echo $attendance_html ; ?>
							</div>
		</div>
	</div>
</div>

<script>
	var start = moment().subtract(29, 'days');
	var end = moment();

	$('#reportrange').daterangepicker({
		startDate: start,
		endDate: end,
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