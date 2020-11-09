  $dt_min = new DateTime("last saturday"); // Edit
                      $dt_min->modify('+1 day'); // Edit
                      $dt_max = clone($dt_min);
                      $dt_max->modify('+6 days');
                      $week_start_date = $dt_min->format('d');
                      $week_end_date = $dt_max->format('d');
                      $week_start_month = $dt_min->format('m');
                      $week_end_month = $dt_max->format('m');
                      $week_start_year = $dt_min->format('Y');
                      $week_end_year = $dt_max->format('Y');
                      $months = explode(',', $week_start_month.','.$week_end_month);
                      $years = explode(',', $week_start_year.','.$week_end_year);
                      // echo $week_start_month.'end date : '.$week_end_month; exit;
                      if($week_start_month != $week_end_month){
                        $where     = array('user_id'=>$user_id,'a_year'=>$a_year);
                         $this->db->select('month_days,month_days_in_out');
                         $this->db->where_in('a_month',$months);
                         $record  = $this->db->get_where('dgt_attendance_details',$where)->result_array();
                         // echo $this->db->last_query(  ); exit;
                         // echo "<pre>";print_r($record); exit;
                         if(!empty($record['month_days_in_out'])){

                             $month_days_in_out_week =  unserialize($record['month_days_in_out']);
                             // echo $month_days_in_out_week; exit;
                          }
                      }elseif($week_start_year != $week_end_year){
                        $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                         $this->db->select('month_days,month_days_in_out');
                         $this->db->where_in('a_month',$months);
                         $this->db->where_in('a_year',$$years);
                         $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();

                      }else{
                          $where     = array('user_id'=>$user_id,'a_month'=>$a_month,'a_year'=>$a_year);
                         $this->db->select('month_days,month_days_in_out');
                         $record  = $this->db->get_where('dgt_attendance_details',$where)->row_array();
                      }