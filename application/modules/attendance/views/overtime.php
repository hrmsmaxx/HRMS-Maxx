 if($today_work_hour['accept_extras'] == 0){
	  $work_hours = work_hours($today_work_hour['schedule_date'].' '.$today_work_hour['start_time'],$today_work_hour['schedule_date'].' '.$today_work_hour['end_time'],$today_work_hour['break_time']);

	  if($today_prodution > $today_work_hour){
	     $minus_production = $today_prodution - $today_work_hour;

	  }else{
	    $month_production_hour += time_difference(date('H:i',strtotime($['punch_in'])),date('H:i',strtotime($punch_detail_month['punch_out'])));
	  }
	} else{
	    $month_production_hour += time_difference(date('H:i',strtotime($['punch_in'])),date('H:i',strtotime($punch_detail_month['punch_out'])));
	}