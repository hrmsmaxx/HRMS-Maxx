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
   // $where     = array('a_month'=>$a_month,'a_year'=>$a_year);
   // $this->db->select('month_days,month_days_in_out');
   ?>
<div class="content">
	<div class="panel panel-white">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-0"><?php echo lang('late_arrival_report')?></h4>
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
			                   
			                    <input type="hidden" class="form-control range_excel" name = "range" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">                    
			                    <button class=" btn  btn-block" type="submit" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-pdf-o"></i></span> <span><?=lang('pdf')?></span></button>
			                     <!-- <a href="#" class="pull-right" id="attendance_report_pdf1" type="submit"> -->
			                     
			                      <!-- </a> -->
			                </form>
			               
			              </li>

			            
			              <li>
			                <?php  $report_name = lang('late_arrival_report');?>
			                 <button class="btn  btn-block" onclick="late_arrival_excel('<?php echo $report_name;?>','late_arrival_report_excel');" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span><span><?=lang('excel')?></span> </button>
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
			<form method="post" action="" class="filter-form" id="filter_inputs" style="display:none;">
				<div class="row">
					<div class="col-md-3">
			            <div class="form-group">
			              <label><?=lang('rangeof_time')?></label>
			              <input type="text" name="range" id="reportrange" class="pull-right form-control" value="<?php echo (isset($_POST['range']) && !empty($_POST['range']))?$_POST['range']:'';?>">
			              <i class="fa fa-calendar"></i>&nbsp;
			              <span></span> <b class="caret"></b>
			            </div>
		          	</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('typeof_order')?></label>
							<select class="select form-control" name="absenses_order">
								<option value="">-</option>
								<option value="desc"  <?php echo (isset($_POST['absenses_order']) && ($_POST['absenses_order'] == 'desc'))?"selected":""?>><?=lang('most_absenses')?></option>
								<option value="asc" <?php echo (isset($_POST['absenses_order']) && ($_POST['absenses_order'] == 'asc'))?"selected":""?>><?=lang('least_absenses')?></option>
							<select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label><?=lang('24_hours_workdays')?></label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-md-2"> 
						<label class="d-block">&nbsp;</label>
						<button class="btn btn-success btn-md" type="submit"><?=lang('run_report')?></button>
					</div>
				</div>
			</form>
			
            <table id="table-late_arrival_report" class="table table-striped custom-table m-b-0 AppendDataTables">
				<thead>
					<tr>						
						<th><?=lang('employee')?></th>
						<th><?=lang('late_arrivals')?></th>
						<th><?=lang('accumulated_time')?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
				 $user_id = array();
				if(!empty($_POST['range']))
                { 
                	  
                 
                  
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
                    $where     = array('ad.subdomain_id'=>$subdomain_id,'a_month'=>$a_month,'a_year'=>$a_year);
                    if($branch_id != '') {
                        $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                    }
                    $record = $this->db->select('ad.*')
                                ->from('attendance_details ad')
                                ->join('users u', 'u.id=ad.user_id')
                                ->where($where)
                                ->get()
                                ->result_array();
                
                  //$record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();   	 
	                if(!empty($record)){
                    foreach ($record as $key => $value) {
	                  $user_id[] = $value['user_id'];
	                }
              	}
          	}
            $users_id =  array_unique($user_id);

             // echo "<pre>";   print_r($users_id);             
            $later_entry_hours = 0;
            $user_absent = array();
            $user_time = array();
 
            foreach ($users_id as $key => $value) {
              if($value !=1){                    
                $user_id = $value;
                $user_details= $this->db->get_where('users',array('subdomain_id'=>$subdomain_id,'id'=>$user_id))->row_array();
                $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();
                          
                if(isset($_POST['range']) && !empty($_POST['range'])){                            
                  $month_start = $start_month ;
                  $month_end =  $end_month;
                  $a_year = $start_year;

                }else{
                  $month_start = 1;
                  $month_end =date('m');
                  $a_year    = date('Y');
                }
                for ($m=$month_start; $m <=$month_end ; $m++) {
                  if(isset($_POST['range']) && !empty($_POST['range'])){
                    $number = $col_count;
                      
                  }else{
                    $number = cal_days_in_month(CAL_GREGORIAN, $m, $a_year);
                  }

                  /*$this->db->select('month_days,month_days_in_out');
                  $this->db->where('user_id', $user_id);
                  $this->db->where('a_month ', $m);
                  // $this->db->where('a_month <=', $end_month);
                  // $this->db->where('a_year >=', $start_year);
                  $this->db->where('a_year ', $a_year);
                  $rows =  $this->db->get('attendance_details')->row_array(); */

                    if($branch_id != '') {
                        $this->db->where("u.branch_id IN (".$branch_id.")",NULL, false);
                    }
                    $rows = $this->db->select('month_days,month_days_in_out')
                                ->from('attendance_details ad')
                                ->join('users u', 'u.id=ad.user_id')
                                ->where(array('user_id'=>$user_id, 'a_month '=>$m, 'a_year '=>$a_year,'ad.subdomain_id'=> $subdomain_id))
                                ->get()
                                ->row_array();

                  for($d=0; $d<=$number; $d++)
                  {
                    if(isset($_POST['range']) && !empty($_POST['range'])){
                      $time =   date(strtotime('+'.$d.' days', strtotime($date_range[0])));
                    } else{
                       $time= $time=mktime(12, 0, 0, $m, $d+1, $a_year);       
                    }
                    
                  // if (date('m', $time)==$month)       
                    $date=date('d M Y', $time);
                    $new_date=date('d/m/Y', $time);
                    $schedule_date=date('Y-m-d', $time);
                    $a_day =date('d', $time);
                    $a_month =date('m', $time);
                    $a_year =date('Y', $time);
                     // echo $schedule_date. '<br>'; 
                   
                    $user_schedule_where     = array('employee_id'=>$user_id,'schedule_date'=>$schedule_date);
                    $user_schedule = $this->db->get_where('shift_scheduling',$user_schedule_where)->row_array(); 
                    // echo $this->db->last_query();
                    
                    if(!empty($rows['month_days'])){

                      $month_days =  unserialize($rows['month_days']);
                      $month_days_in_out =  unserialize($rows['month_days_in_out']);
                      $day = $month_days[$a_day-1];
                      $day_in_out = $month_days_in_out[$a_day-1];
                      $latest_inout = end($day_in_out);                             
                       
                      if(!empty($user_schedule)){
                       

                        if(!empty($day['punch_in'])){    
                                            
                          $later_entry_hours = later_entry_minutes($user_schedule['schedule_date'].' '.$user_schedule['max_start_time'],$user_schedule['schedule_date'].' '.$day['punch_in']);
                          if($later_entry_hours > 0){
                          	$user_absent[$user_id][] = $user_id;
                           	$user_time[$user_id][] = $later_entry_hours ; 
                          }
                    		
                        }                        
                           
                         
                      } 
                    }  
                  } 
                }
                if(isset($user_absent[$user_id])){
              $user_details= $this->db->get_where('users',array('id'=>$user_id))->row_array();
              $account_details= $this->db->get_where('account_details',array('user_id'=>$user_id))->row_array();                    
              if(!empty($user_details['designation_id'])){
                $designation = $this->db->get_where('designation',array('id'=>$user_details['designation_id']))->row_array();
                $designation_name = $designation['designation'];
                
              }else{
                $designation_name = '-';
              }?>
              <tr>
                <td>
                  <div class="user_det_list" style="margin-bottom: 10px;">
                    <a href="<?php echo base_url().'employees/profile_view/'.$user_id;?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
                    <h2><span class="username-info"><?php echo ucfirst(user::displayName($user_details['id']));?></span>
                      <span class="userrole-info"> <?php echo $designation_name;?></span>
                      <span class="username-info"> <?php echo !empty($user_details['id_code'])?$user_details['id_code']:"-";?></span></h2>
                  </div>
                </td>
                <td><?php echo count($user_absent[$user_id]); ?></td>
                <td><?php echo !empty(array_sum($user_time[$user_id]))?intdiv(array_sum($user_time[$user_id]), 60).'.'. (array_sum($user_time[$user_id]) % 60):''
                ?></td>
              </tr>


              <?php  
            }
              // echo'<pre>';print_r($user_absent);   exit;           
               }
            }
          // echo'<pre>';print_r($user_absent);
         ?>
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