<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		User::logged_in();

		$this->load->module('layouts');
		$this->load->library(array('template','form_validation'));
		$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');
		$this->template->title(lang('reports').' - '.$this->company_name);
		$this->load->model(array('Report','App','Invoice','Client','Expense','Project','User','Attendance_model'));

// 		App::module_access('menu_reports');
		if(isset($_GET['setyear'])){ $this->session->set_userdata('chart_year', $_GET['setyear']); }
	}

	function index()
	{
		$data = array(
			'page' => lang('reports'),
		);
		$this->template
		->set_layout('users')
		->build('dashboard',isset($data) ? $data : NULL);
	}


	function view($report_view = NULL){
			switch ($report_view) {
				case 'invoicesreport':
					$this->_invoicesreport();
					break;
				case 'invoicesbyclient':
					$this->_invoicesbyclient();
					break;
				case 'paymentsreport':
					$this->_paymentsreport();
					break;
				case 'expensesreport':
					$this->_expensesreport();
					break;
				case 'expensesbyclient':
					$this->_expensesbyclient();
					break;
				case 'ticketsreport':
					$this->_ticketsreport();
					break;
				case 'projectreport':
					$this->_projectreport();
					break;
				case 'taskreport':
				$this->_taskreport();
				break;
				case 'user_report':
				$this->_user_report();
				break;
				case 'employee_report':
				$this->_employee_report();
				break;
				case 'payslip_report':
				$this->_payslip_report();
				break;
				case 'attendance_report':
				$this->_attendance_report();
				break;
				case 'daily_report':
				$this->_daily_report();
				break;
				case 'access_report':
				$this->_access_report();
				break;
				case 'absences_report':
				$this->_absences_report();
				break;
				case 'late_arrival_report':
				$this->_late_arrival_report();
				break;
				case 'work_code_report':
				$this->_work_code_report();
				break;
				case 'extraordinary_events_report':
				$this->_extraordinary_events_report();
				break;
				case 'department_workday_report':
				$this->_department_workday_report();
				break;
				case 'attendance_period_closing':
				$this->_attendance_period_closing();
				break;
				case 'standard_report':
				$this->_standard_report();
				break;
				case 'horizontal_attendance_report':
				$this->_horizontal_attendance_report();
				break;
				case 'employee_used_workcodes_report':
				$this->_employee_used_workcodes_report();
				break;
				case 'access_statistics_dashboard':
				$this->_access_statistics_dashboard();
				break;
				case 'device_events_report':
				$this->_device_events_report();
				break;
				case 'automatically_sending_reports':
				$this->_automatically_sending_reports();
				break;
				case 'monthly_report':
				$this->_monthly_report();
				break;

				default:
					# code...
					break;
			}
	}

	function _invoicesreport(){
		$data = array('page' => lang('reports'),'form' => TRUE);
		if($this->input->post()){
			$range = explode('-', $this->input->post('range'));
			$start_date = date('Y-m-d', strtotime($range[0]));
			$end_date = date('Y-m-d', strtotime($range[1]));
			$data['report_by'] = $this->input->post('report_by');
			$data['invoices'] = Invoice::by_range($start_date,$end_date,$data['report_by']);
			$data['range'] = array($start_date,$end_date);
		}else{
			$data['invoices'] = Invoice::by_range(date('Y-m').'-01',date('Y-m-d'));
			$data['range'] = array(date('Y-m').'-01',date('Y-m-d'));
		}
		$this->template
			->set_layout('users')
			->build('report/invoicesreport',isset($data) ? $data : NULL);
	}

	function _invoicesbyclient(){
		$data = array('page' => lang('reports'),'form' => TRUE);
		if($this->input->post()){
			$client = $this->input->post('client');
			$data['invoices'] = Invoice::get_client_invoices($client);
			$data['client'] = $client;
		}else{
			$data['invoices'] = array();
			$data['client'] = NULL;
		}
		$this->template
			->set_layout('users')
			->build('report/invoicesbyclient',isset($data) ? $data : NULL);
	}

	function _paymentsreport(){
		$this->load->model('Payment');
		$data = array('page' => lang('reports'),'form' => TRUE);
		if($this->input->post()){
			$range = explode('-', $this->input->post('range'));
			$start_date = date('Y-m-d', strtotime($range[0]));
			$end_date = date('Y-m-d', strtotime($range[1]));
			$data['payments'] = Payment::by_range($start_date,$end_date);
			$data['range'] = array($start_date,$end_date);
		}else{
			$data['payments'] = Payment::by_range(date('Y-m').'-01',date('Y-m-d'));
			$data['range'] = array(date('Y-m').'-01',date('Y-m-d'));
		}
		$this->template
			->set_layout('users')
			->build('report/paymentsreport',isset($data) ? $data : NULL);
	}

	function _expensesreport(){
		$data = array('page' => lang('reports'),'form' => TRUE);
		if($this->input->post()){
			$range = explode('-', $this->input->post('range'));
			$start_date = date('Y-m-d', strtotime($range[0]));
			$end_date = date('Y-m-d', strtotime($range[1]));
			$data['report_by'] = $this->input->post('report_by');
			$data['expenses'] = Expense::by_range($start_date,$end_date,$data['report_by']);
			$data['range'] = array($start_date,$end_date);
		}else{
			$data['expenses'] = Expense::by_range(date('Y-m').'-01',date('Y-m-d'));
			$data['range'] = array(date('Y-m').'-01',date('Y-m-d'));
		}
		$this->template
			->set_layout('users')
			->build('report/expensesreport',isset($data) ? $data : NULL);
	}


	function _expensesbyclient(){
		$data = array('page' => lang('reports'),'form' => TRUE);
		if($this->input->post()){
			$client = $this->input->post('client');
			$data['report_by'] = $this->input->post('report_by');
			$data['expenses'] = Expense::expenses_by_client($client,$data['report_by']);
			$data['client'] = $client;
		}else{
			$data['expenses'] = array();
			$data['client'] = NULL;
		}
		$this->template
			->set_layout('users')
			->build('report/expensesbyclient',isset($data) ? $data : NULL);
	}


	function _projectreport(){
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			// $project_id = $this->input->post('project_title');
			$data['project_id'] = $this->input->post('project_title');
			$data['status'] = $this->input->post('status');
			   
			if(!empty($data['project_id']) && !empty($data['status'])){
  // echo "<pre>";print_r($data); exit;
				$data['projects'] = Project::by_where(array('project_id'=>$data['project_id'],'status' => $data['status']));
				 
			} else if (!empty($data['project_id']) && $data['status'] === '') {
   // echo "<pre>";print_r($data); exit;
				$data['projects'] = Project::by_where(array('project_id'=>$data['project_id']));
			} else if ($data['project_id'] ==='' && !empty($data['status'])) {
				  
				$data['projects'] = Project::by_where(array('status' => $data['status']));
			} else {
				  
				$data['projects'] = Project::all();
			}
			
			// echo "<pre>";print_r($data['projects']); exit;
			
		}else{
			$data['projects'] = array();
			$data['project_id'] = NULL;
		}
		$this->template
			->set_layout('users')
			->build('report/projectreport',isset($data) ? $data : NULL);
	}

	function _taskreport(){
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			// $project_id = $this->input->post('project_title');
			$data['task_id'] = $this->input->post('task_id');
			$data['task_progress'] = $this->input->post('task_progress');
			  


			if(!empty($data['task_id']) && !empty($data['task_progress'])){
				$data['tasks'] = $this->db->get_where('tasks',array('t_id'=>$data['task_id'],'task_progress' => $data['task_progress']))->result_array(); 
  

			} else if (!empty($data['task_id']) && $data['task_progress'] === '') {
   
				$data['tasks'] = $this->db->get_where('tasks',array('t_id'=>$data['task_id']))->result_array();
				// echo "<pre>";print_r($data['tasks']); exit;
				
			} else if (!empty($data['task_progress']) && $data['task_id'] === '0') {
				  
				$data['tasks'] = $this->db->get_where('tasks',array('task_progress' => $data['task_progress']))->result_array();

			} 
			else if ($data['task_progress'] === '' && $data['task_id'] === '0'){
				  
				$data['tasks'] = $this->db->get_where('tasks')->result_array();
			}

			else if ($data['task_progress'] == '0' && $data['task_id'] === '0') {
				  
				$data['tasks'] = $this->db->get_where('tasks',array('task_progress' => 0))->result_array();

			} 

			else if(!empty($data['task_id']) && $data['task_progress'] == '0') {
				$data['tasks'] = $this->db->get_where('tasks',array('t_id'=>$data['task_id'],'task_progress' => 0))->result_array(); 
  

			}
			
			
		}else{
			$data['tasks'] = array();
			$data['task_id'] = NULL;
		}
		$this->template
			->set_layout('users')
			->build('report/taskreport',isset($data) ? $data : NULL);
	}

	function _user_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);
		$branch_id = $this->session->userdata('branch_id');
		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
			
			if($branch_id != '') {
				$this->db->where("branch_id IN (".$branch_id.")",NULL, false);
			}
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array(); 
				//echo 'role<pre>'; print_r($data['role_id']); exit;
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users', array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/user_report',isset($data) ? $data : NULL);
	}

	function _employee_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		$branch_id = $this->session->userdata('branch_id');
		if($this->input->post()){
			
			
			$data['user_id'] = $this->input->post('user_id');
			$data['department_id'] = $this->input->post('department_id');
			$data['designation_id'] = $this->input->post('designation_id');
		
		$this->db->select('U.*,DATE_FORMAT(U.created,"%d %M %Y") as created,AD.fullname,AD.phone,AD.avatar,AD.doj,IF(D.designation IS NOT NULL,D.designation,"-") AS designation,D.department_id');
		//IF(DE.deptname IS NOT NULL,DE.deptname,"-") AS department,
		$this->db->from('users U');
		$this->db->join('account_details AD','AD.user_id=U.id','LEFT');
		//self::$db->join('companies C','C.co_id=AD.company','LEFT');
		$this->db->join('designation D','D.id=U.designation_id','LEFT');
		$this->db->join('departments DE','DE.deptid=D.department_id','LEFT');
		$this->db->where('U.subdomain_id', $this->session->userdata('subdomain_id'));
		$this->db->where('U.role_id', 3);
		
		if($branch_id != '') {
			$this->db->where("U.branch_id IN(".$branch_id.")",NULL, false);
		}
		if(!empty($data['department_id'])){
			$dept_id = $data['department_id'];
			$this->db->where("FIND_IN_SET('$dept_id',U.department_id) !=", 0);
			//$this->db->where_in('U.department_id', $data['department_id']);
		}
				
		if(!empty($data['user_id'])){
			$this->db->where('U.id', $data['user_id']);
		}
		if(!empty($data['designation_id'])){
			$this->db->where('U.designation_id', $data['designation_id']);
		}
		$this->db->order_by('U.id', 'ASC');
 	 	$lists = $this->db->get()->result_array();
//
 	 	$records = array();
            if(count($lists) >0){
                $department = array();
                foreach ($lists as $list) {
                    $list = (array)$list;
                    $depart_id = $list['department_id'];
                    $department_id = (!empty($list['id']))?$this->tank_auth->get_department($list['id']):array();
                    if(!empty($department_id)){
                        $deptid  = explode(',', $department_id);
                        $department = array();
                        foreach ($deptid as $key => $deptid) {
                            $deptname = $this->db->get_where('departments',array('deptid'=>$deptid))->row_array();
                            $department[] = $deptname['deptname'];
                        }
                        
                        $list['department'] = implode(',', $department);
                    } else {
                    	$list['department'] = '-';
                    }

                    if(!empty($branch_id)) {
                        $branchid  = explode(',', $branch_id);
                        $branch = array();
                        foreach ($branchid as $key => $branches) {
                            $branch_name = $this->db->get_where('branches',array('id'=>$branches))->row_array();
                            $branch[] = $branch_name['branch_name'];
                        }
                        
                        $list['branches'] = implode(',', $branch);
                    } else {
                        $list['branches'] = '-';
                    }
                    $records[] = $list;
                    //
                }
            }
            $data['employees'] = $records;
         	if($_POST['pdf']){
 				$html = $this->load->view('pdf/employees',$data,true);
	   			$file_name = lang('employee_report').'.pdf';
	

				$pdf = array(
					"html"      => $html,
					"title"     => lang('employee_report'),
					"author"    => $this->company_name,
					"creator"   => $this->company_name,
					"badge"     => 'FALSE',
					"filename"  => $file_name
				);
				$this->applib->create_pdf($pdf);
			}
            //echo 'emplsdsd<pre>'; print_r($data['employees']); exit;
			 // echo "<pre>";print_r($this->db->last_query()); exit;		
			
		}else{
			$data['employees'] = array();
			$data['user_id'] = NULL;

		}

		$this->template
			->set_layout('users')
			->build('report/employee_report',isset($data) ? $data : NULL);
	}

	function employee_report_excel(){
		if(!empty($_POST)){
			if($this->input->post()){
			
			$branch_id = $this->session->userdata('branch_id');

			$data['user_id'] = $this->input->post('user_id');
			$data['department_id'] = $this->input->post('department_id');
			$data['designation_id'] = $this->input->post('designation_id');
		
			$this->db->select('U.*,DATE_FORMAT(U.created,"%d %M %Y") as created,AD.fullname,AD.phone,AD.avatar,AD.doj,IF(D.designation IS NOT NULL,D.designation,"-") AS designation,D.department_id');
			//IF(DE.deptname IS NOT NULL,DE.deptname,"-") AS department,
			$this->db->from('users U');
			$this->db->join('account_details AD','AD.user_id=U.id','LEFT');
			//self::$db->join('companies C','C.co_id=AD.company','LEFT');
			$this->db->join('designation D','D.id=U.designation_id','LEFT');
			$this->db->join('departments DE','DE.deptid=D.department_id','LEFT');
			$this->db->where('U.subdomain_id', $this->session->userdata('subdomain_id'));
			$this->db->where('U.role_id', 3);

			if($branch_id != '') {
				$this->db->where("U.branch_id IN(".$branch_id.")",NULL, false);
			}

			if(!empty($data['department_id'])){
				$dept_id = $data['department_id'];
				$this->db->where("FIND_IN_SET('$dept_id',U.department_id) !=", 0);
				//$this->db->where_in('U.department_id', $data['department_id']);
			}
					
			if(!empty($data['user_id'])){
				$this->db->where('U.id', $data['user_id']);
			}
			if(!empty($data['designation_id'])){
				$this->db->where('U.designation_id', $data['designation_id']);
			}
			$this->db->order_by('U.id', 'ASC');
			 	$lists = $this->db->get()->result_array();
		//
			 	$records = array();
		        if(count($lists) >0){
		            $department = array();
		            foreach ($lists as $list) {
		                $list = (array)$list;
		                $depart_id = $list['department_id'];
		                $department_id = (!empty($list['id']))?$this->tank_auth->get_department($list['id']):array();
		                if(!empty($department_id)){
		                    $deptid  = explode(',', $department_id);
		                    $department = array();
		                    foreach ($deptid as $key => $deptid) {
		                        $deptname = $this->db->get_where('departments',array('deptid'=>$deptid))->row_array();
		                        $department[] = $deptname['deptname'];
		                    }
		                    
		                    $list['department'] = implode(',', $department);
		                }
		                $records[] = $list;
		                //
		            }
		        }
		        $data['employees'] = $records;
			$html = $this->load->view('excel/employee_report_excel',$data,true);
			  
			   	
				echo $html; exit;
			}else{
				echo 'error'; exit();
			}
		}
	}

	function _payslip_report(){
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			// $data['company_id'] = $this->input->post('company_id');
			$data['user_id'] = $this->input->post('user_id');
			$data['month'] = $this->input->post('month');
			$data['year'] = $this->input->post('year');

			// print_r($data);exit;

			if($data['user_id'] == '' && $data['month'] =='0' && $data['year'] == '0')
			{
				$data['payslip'] = $this->db->get('payslip')->result_array(); 
  

			} 	

  		
			elseif($data['user_id'] == '' && $data['month'] !='0' && $data['year'] == '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('p_month'=>$data['month']))->result_array();
  				 				

			}
			elseif($data['user_id'] =='' && $data['month'] =='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('p_year'=>$data['year']))->result_array();
  				 				

			}
			elseif($data['user_id'] != ''  && $data['month'] =='0' && $data['year'] == '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id']))->result_array();
			}
			elseif($data['user_id'] != ''  && $data['month'] !='0' && $data['year'] == '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id'],'p_month'=>$data['month']))->result_array();
			}
			elseif($data['user_id'] != '' && $data['month'] !='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id'],'p_month'=>$data['month'],'p_year'=>$data['year']))->result_array();
			}
			elseif($data['user_id'] != '' && $data['month'] =='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id'],'p_year'=>$data['year']))->result_array();
			}
			elseif($data['user_id'] == '' && $data['month'] !='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('p_month'=>$data['month'],'p_year'=>$data['year']))->result_array();
			}else{

			  $data['payslip'] = $this->db->get_where('payslip',array('p_month'=>$data['month'],'p_year'=>$data['year']))->result_array();
			}
			
			
		}else{
			$data['payslip'] = array();
			$data['company_id'] = NULL;
		}
		$this->template
			->set_layout('users')
			->build('report/payslip_report',isset($data) ? $data : NULL);
	}

	function _attendance_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		if($_POST['pdf']){
			 $html = $this->load->view('pdf/attendancereport',$data,true);
		  
		   $file_name = lang('attendance_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('attendance_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
		}

		
		 	
		  

		$this->template
			->set_layout('users')
			->build('report/attendance_report',isset($data) ? $data : NULL);
	}

	function attendance_report_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/attendance_report_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}
	

	function _daily_report(){
		// print_r($_POST); exit();

		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			$branch_id = $this->session->userdata('branch_id');
			//echo $branch_id; exit;
			/*if($branch_id != '') {
				$this->db->where("branch_id IN (".$branch_id.")",NULL, false);
			}
*/
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		if($_POST['pdf']){
			 $html = $this->load->view('pdf/dailyreport',$data,true);
		  
		   $file_name = lang('daily_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('dailyreport'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
		}

		$this->template
			->set_layout('users')
			->build('report/daily_report',isset($data) ? $data : NULL);
	}
	function daily_report_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/daily_report_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}

	function _access_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}
		if($_POST['pdf']){
		 	$html = $this->load->view('pdf/access_report',$data,true);
	  
	   		$file_name = lang('access_report').'.pdf';


			$pdf = array(
				"html"      => $html,
				"title"     => lang('access_report'),
				"author"    => $this->company_name,
				"creator"   => $this->company_name,
				"badge"     => 'FALSE',
				"filename"  => $file_name
			);
			$this->applib->create_pdf($pdf);
		}
		$this->template
			->set_layout('users')
			->build('report/access_report',isset($data) ? $data : NULL);
	}
	function access_report_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/access_report_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}
	function _absences_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			if($_POST['absenses_order'] !=''){
				$data['absenses_order'] = $_POST['absenses_order'];
			}

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}
		if($_POST['pdf']){
		 	$html = $this->load->view('pdf/absences_report',$data,true);
	  
	   		$file_name = lang('absences_report').'.pdf';


			$pdf = array(
				"html"      => $html,
				"title"     => lang('absences_report'),
				"author"    => $this->company_name,
				"creator"   => $this->company_name,
				"badge"     => 'FALSE',
				"filename"  => $file_name
			);
			$this->applib->create_pdf($pdf);
		}
		$this->template
			->set_layout('users')
			->build('report/absences_report',isset($data) ? $data : NULL);
	}
	function absences_report_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/absences_report_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}

	function _late_arrival_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}
			if($_POST['absenses_order'] !=''){
				$data['absenses_order'] = $_POST['absenses_order'];
			}
			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}
		if($_POST['pdf']){
		 	$html = $this->load->view('pdf/late_arrival_report',$data,true);
	  
	   		$file_name = lang('late_arrival_report').'.pdf';


			$pdf = array(
				"html"      => $html,
				"title"     => lang('late_arrival_report'),
				"author"    => $this->company_name,
				"creator"   => $this->company_name,
				"badge"     => 'FALSE',
				"filename"  => $file_name
			);
			$this->applib->create_pdf($pdf);
		}
		$this->template
			->set_layout('users')
			->build('report/late_arrival_report',isset($data) ? $data : NULL);
	}
	function late_arrival_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/late_arrival_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}
	function _work_code_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			if($_POST['workcode_order'] !=''){
				$data['workcode_order'] = $_POST['workcode_order'];
			}

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}
			if($_POST['pdf']){
		 	$html = $this->load->view('pdf/work_code_report',$data,true);
	  
	   		$file_name = lang('work_code_report').'.pdf';


			$pdf = array(
				"html"      => $html,
				"title"     => lang('work_code_report'),
				"author"    => $this->company_name,
				"creator"   => $this->company_name,
				"badge"     => 'FALSE',
				"filename"  => $file_name
			);
			$this->applib->create_pdf($pdf);
		}
		$this->template
			->set_layout('users')
			->build('report/work_code_report',isset($data) ? $data : NULL);
	}
	function work_code_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/work_code_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}
	function _extraordinary_events_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}
		if($_POST['pdf']){
		 	$html = $this->load->view('pdf/extraordinary_events_report',$data,true);
	  
	   		$file_name = lang('extraordinary_events_report').'.pdf';


			$pdf = array(
				"html"      => $html,
				"title"     => lang('extraordinary_events_report'),
				"author"    => $this->company_name,
				"creator"   => $this->company_name,
				"badge"     => 'FALSE',
				"filename"  => $file_name
			);
			$this->applib->create_pdf($pdf);
		}
		$this->template
			->set_layout('users')
			->build('report/extraordinary_events_report',isset($data) ? $data : NULL);
	}

	function extraordinary_events_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/extraordinary_events_report_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}

	function _department_workday_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}
		if($_POST['pdf']){
		 	$html = $this->load->view('pdf/department_workday_report',$data,true);
	  
	   		$file_name = lang('department_workday_report').'.pdf';


			$pdf = array(
				"html"      => $html,
				"title"     => lang('department_workday_report'),
				"author"    => $this->company_name,
				"creator"   => $this->company_name,
				"badge"     => 'FALSE',
				"filename"  => $file_name
			);
			$this->applib->create_pdf($pdf);
		}
		$this->template
			->set_layout('users')
			->build('report/department_workday_report',isset($data) ? $data : NULL);
	}

	function department_workday_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/department_workday_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}

	function _attendance_period_closing(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			
         
            $params = $this->input->post();
            $params['branch_id'] = $this->session->userdata('branch_id');

            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
              // echo "<pre>"; print_r($params); exit;
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
            $data['username']      = $params['username'];
            $data['id_code']            = isset($params['id_code'])?$params['id_code']:"";
            $data['employee_email']     = isset($params['employee_email'])?$params['employee_email']:"";
            $data['department_id']      = isset($params['department_id'])?$params['department_id']:"";
            $data['manully_made']       = isset($params['manully_made'])?$params['manully_made']:"";
            $data['branch_id']       = isset($params['branch_id'])?$params['branch_id']:"";

            // $data['current_page']       = 1;
            $attendance_list = Attendance_model::attendance_list($params); 

            // echo "<pre>"; print_r($data['manully_made']); exit;

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  
			
            if($_POST['pdf']){
		 		$html = $this->load->view('pdf/attendanceperiodclosing',$data,true);
		  
		   		$file_name = lang('attendance_period_closing').'.pdf';
	

				$pdf = array(
					"html"      => $html,
					"title"     => lang('attendance_period_closing'),
					"author"    => $this->company_name,
					"creator"   => $this->company_name,
					"badge"     => 'FALSE',
					"filename"  => $file_name
				);
				$this->applib->create_pdf($pdf);
			}
			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;

			$params = array();
            
            // $params['page'] = 1;           
            $month = date('m');
            $year  = date('Y');
            $last_day = $year.'-'.$month.'-1';
            $params['attendance_month'] = date('m');
            $params['attendance_year'] = date('Y');
            $data['attendance_month'] = date('m');
            $data['attendance_year'] = date('Y');
            $params['branch_id'] = $this->session->userdata('branch_id');
            $data['branch_id'] = ($params['branch_id'])?$params['branch_id']:'';
           
            $data['current_page']     = $params['page'];
            $attendance_list = Attendance_model::attendance_list($params); 

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  
		}
 
		$this->template
			->set_layout('users')
			->build('report/attendance_period_closing',isset($data) ? $data : NULL);
	}

	function attendance_period_closing_excel(){
		if(!empty($_POST)){

			$params = $this->input->post();
			$params['branch_id'] = $this->session->userdata('branch_id');

            if(isset($params['attendance_month'])){
              $month = $params['attendance_month'];
            }else{              
             
              $month = date('m');
              $params['attendance_month'] =  date('m');
            }

            if(isset($params['attendance_year'])){              
              $year = $params['attendance_year'];

            }else{              
              $year = date('Y');
              $params['attendance_year'] =  date('Y');
            }
              // echo "<pre>"; print_r($params); exit;
            $month  = $params['attendance_month'];
            $year  = $params['attendance_year'];
            $data['attendance_month'] = $params['attendance_month'];
            $data['attendance_year'] = $params['attendance_year'];
            $last_day = $year.'-'.$month.'-1';
           
            
            $data['employee_name']      = $params['employee_name'];
            $data['id_code']            = isset($params['id_code'])?$params['id_code']:"";
            $data['department_id']      = isset($params['department_id'])?$params['department_id']:"";
            $data['branch_id']       = isset($params['branch_id'])?$params['branch_id']:"";
            // $data['current_page']       = 1;
            $attendance_list = Attendance_model::attendance_list($params); 

            // echo "<pre>"; print_r($data['manully_made']); exit;

            $data['attendance_list']  =  $attendance_list[1];
            $data['total_page']       =  $attendance_list[0];
            $data['last_day']         = date('t',strtotime($last_day));  

		$html = $this->load->view('excel/period_closing_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}

	function _standard_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/standard_report',isset($data) ? $data : NULL);
	}

	function _horizontal_attendance_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/horizontal_attendance_report',isset($data) ? $data : NULL);
	}

	function _employee_used_workcodes_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/employee_used_workcodes_report',isset($data) ? $data : NULL);
	}
	function _access_statistics_dashboard(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/access_statistics_dashboard',isset($data) ? $data : NULL);
	}

	function _device_events_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/device_events_report',isset($data) ? $data : NULL);
	}

	function _automatically_sending_reports(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		$this->template
			->set_layout('users')
			->build('report/automatically_sending_reports',isset($data) ? $data : NULL);
	}

	function _monthly_report(){
		
		$data = array('page' => lang('reports'),'form' => TRUE,'datatables' => TRUE);

		if($this->input->post()){
			$data['role_id'] = $this->input->post('role_id');
				  
			// print_r($data['role_id']);exit;

			if(!empty($data['role_id'])){
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id']))->result_array(); 
  

			} 
			else if ($data['role_id'] == '0'){
				  
				$data['users'] = $this->db->get_where('users')->result_array();
			}

			

			
		}else{
			$data['users'] = array();
			$data['role_id'] = NULL;
		}

		if($_POST['pdf']){
			 $html = $this->load->view('pdf/monthly_report_pdf',$data,true);
		  
		   $file_name = lang('monthly_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('monthly_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
		}

		
		 	
		  

		$this->template
			->set_layout('users')
			->build('report/monthly_report',isset($data) ? $data : NULL);
	}

	function monthly_report_excel(){
		if(!empty($_POST)){

		$html = $this->load->view('excel/monthly_report_excel',$data,true);
		  
		   	
			echo $html; exit;
		}else{
			echo 'error'; exit();
		}
	}
	
	function invoicespdf(){
		if($this->uri->segment(4)){

		$start_date = date('Y-m-d',$this->uri->segment(3));
		$end_date = date('Y-m-d',$this->uri->segment(4));
		$data['report_by'] = $this->uri->segment(5);
		$data['invoices'] = Invoice::by_range($start_date,$end_date,$data['report_by']);
		$data['range'] = array($start_date,$end_date);
		$data['page'] = lang('reports');
		$html = $this->load->view('pdf/invoices',$data,true);
		$file_name = lang('reports')."_".$start_date.'To'.$end_date.'.pdf';
	}else{
		$data['client'] = $this->uri->segment(3);
		$data['invoices'] = Invoice::get_client_invoices($data['client']);
		$data['page'] = lang('reports');
		$html = $this->load->view('pdf/clientinvoices',$data,true);
		$file_name = lang('reports')."_".Client::view_by_id($data['client'])->company_name.'.pdf';
	}

		

		$pdf = array(
			"html"      => $html,
			"title"     => lang('invoices_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}

	function paymentspdf(){
		$this->load->model('Payment');
		$start_date = date('Y-m-d',$this->uri->segment(3));
		$end_date = date('Y-m-d',$this->uri->segment(4));
		$data['payments'] = Payment::by_range($start_date,$end_date);
		$data['range'] = array($start_date,$end_date);
		$data['page'] = lang('reports');
		$html = $this->load->view('pdf/payments',$data,true);
		$file_name = lang('payments')."_".$start_date.'To'.$end_date.'.pdf';
		
		$pdf = array(
			"html"      => $html,
			"title"     => lang('payments_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}


	function expensespdf(){
	
	if($this->uri->segment(5)){
		$start_date = date('Y-m-d',$this->uri->segment(3));
		$end_date = date('Y-m-d',$this->uri->segment(4));
		$data['report_by'] = $this->uri->segment(5);
		$data['expenses'] = Expense::by_range($start_date,$end_date,$data['report_by']);
		$data['range'] = array($start_date,$end_date);
		$html = $this->load->view('pdf/expenses',$data,true);
		$file_name = lang('expenses_report')."_".$start_date.'To'.$end_date.'.pdf';
	}else{
		$data['client'] = $this->uri->segment(3);
		$data['report_by'] = $this->uri->segment(4);
		$data['expenses'] = Expense::expenses_by_client($data['client'],$data['report_by']);
		$html = $this->load->view('pdf/clientexpenses',$data,true);
		$file_name = lang('expenses_report')."_".Client::view_by_id($data['client'])->company_name.'.pdf';
	}

		$pdf = array(
			"html"      => $html,
			"title"     => lang('expenses_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}

	function projectpdf(){
		
	
	
		$data['project_id'] = $this->uri->segment(3);
		$data['status'] =$this->uri->segment(4);
 
		if(!empty($data['project_id']) && !empty($data['status'])){

				$data['projects'] = Project::by_where(array('project_id'=>$data['project_id'],'status' => $data['status']));
			
				 
			} else if (!empty($data['project_id']) && $data['status'] === '') {

				$data['projects'] = Project::by_where(array('project_id'=>$data['project_id']));

				
			} else if ($data['project_id'] ==='' && !empty($data['status'])) {
				  
				$data['projects'] = Project::by_where(array('status' => $data['status']));
			
			} else {
				  
				$data['projects'] = Project::all();
				$file_name = lang('project_report').'.pdf';
			}
			
			$html = $this->load->view('pdf/projects',$data,true);
		 	$file_name = lang('project_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('project_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}

	function taskpdf(){
		
	
		
		$data['task_id'] = $this->uri->segment(3);
		$data['task_progress'] =$this->uri->segment(4);

		
		 if(!empty($data['task_id']) && !empty($data['task_progress']))
		 {
				$data['tasks'] = $this->db->get_where('tasks',array('t_id'=>$data['task_id'],'task_progress' => $data['task_progress']))->result_array(); 
  

			} else if (!empty($data['task_id']) && $data['task_progress'] == '') {
   
				$data['tasks'] = $this->db->get_where('tasks',array('t_id'=>$data['task_id']))->result_array();
								
			} else if (!empty($data['task_progress']) && $data['task_id'] == '0') {
				  
				$data['tasks'] = $this->db->get_where('tasks',array('task_progress' => $data['task_progress']))->result_array();

			} 
			else if ($data['task_progress'] == '' && $data['task_id'] == '0'){
				  
				$data['tasks'] = $this->db->get_where('tasks')->result_array();
				
			}
			else if(!empty($data['task_id']) && $data['task_progress'] == '0') {
				$data['tasks'] = $this->db->get_where('tasks',array('t_id'=>$data['task_id'],'task_progress' => 0))->result_array(); 
  

			}

			
						
			else {
				  
				$data['tasks'] = $this->db->get_where('tasks',array('task_progress' => 0))->result_array();
				$file_name = lang('task_report').'.pdf';
			} 
		   
		   $html = $this->load->view('pdf/tasks',$data,true);
		   $file_name = lang('task_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('task_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}


	function userpdf(){
		
	
		
		$data['role_id'] = $this->uri->segment(3);
		
			$branch_id = $this->session->userdata('branch_id');
			
			if($branch_id != '') {
				$this->db->where("branch_id IN (".$branch_id.")",NULL, false);
			}

		 	if(!empty($data['role_id']))
		 	{
				$data['users'] = $this->db->get_where('users',array('role_id'=>$data['role_id'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array(); 
  

			} else if ($data['role_id'] == '0') {
   
				$data['users'] = $this->db->get_where('users', array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
								
			} 
									
			else {
				  
				$data['users'] = $this->db->get_where('users', array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
				$file_name = lang('user_report').'.pdf';
			} 
		   
		   $html = $this->load->view('pdf/users',$data,true);
		   $file_name = lang('user_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('user_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}

	function payslippdf(){
		
	
		    $data['company_id'] = $this->uri->segment(3);
			$data['user_id'] = $this->uri->segment(4);
			$data['month'] = $this->uri->segment(5);
			$data['year'] = $this->uri->segment(6);

			

			if($data['company_id'] =='0' && $data['user_id'] == '0' && $data['month'] =='0' && $data['year'] == '0')
			{
				$data['payslip'] = $this->db->get('payslip')->result_array(); 
  

			} 
			elseif($data['company_id'] !='0'  && $data['user_id'] == '0' && $data['month'] =='0' && $data['year'] == '0')
			{
				$account_details = $this->db->get_where('account_details',array('company'=>$data['company_id']))->result_array();
				foreach ($account_details as $key => $g) {
					$user = $g['user_id'];
												
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$user))->result_array();
  				}
  			}

  		
			elseif($data['user_id'] == '0'  && $data['company_id'] == '0' && $data['month'] !='0' && $data['year'] == '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('p_month'=>$data['month']))->result_array();
  				 				

			}
			elseif($data['user_id'] =='0'  && $data['company_id'] == '0' && $data['month'] =='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('p_year'=>$data['year']))->result_array();
  				 				

			}
			elseif($data['user_id'] != '0'  && $data['company_id'] != '0' && $data['month'] =='0' && $data['year'] == '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id']))->result_array();
			}
			elseif($data['user_id'] != '0'  && $data['company_id'] != '0' && $data['month'] !='0' && $data['year'] == '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id'],'p_month'=>$data['month']))->result_array();
			}
			elseif($data['user_id'] != '0'  && $data['company_id'] != '0' && $data['month'] !='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id'],'p_month'=>$data['month'],'p_year'=>$data['year']))->result_array();
			}
			elseif($data['user_id'] != '0'  && $data['company_id'] != '0' && $data['month'] =='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('user_id'=>$data['user_id'],'p_year'=>$data['year']))->result_array();
			}
			elseif($data['user_id'] == '0'  && $data['company_id'] == '0' && $data['month'] !='0' && $data['year'] != '0')
			{
																
  				$data['payslip'] = $this->db->get_where('payslip',array('p_month'=>$data['month'],'p_year'=>$data['year']))->result_array();
			}
			
			
		   $html = $this->load->view('pdf/payslip',$data,true);
		   $file_name = lang('payslip_report').'.pdf';
	

		   $pdf = array(
			"html"      => $html,
			"title"     => lang('user_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}



	function employeepdf(){
		
	
		
		$data['company_id'] = $this->uri->segment(3);
		// print_r($data['company_id']);exit;
		
			$branch_id = $this->session->userdata('branch_id');

			if($branch_id != '') {
				$this->db->where("branch_id IN (".$branch_id.")",NULL, false);
			}

		 	if(!empty($data['company_id'])){
		 		$data['employees'] = $this->db->get_where('users',array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
				// $data['employees'] = $this->db->get_where('account_details',array('company'=>$data['company_id']))->result_array(); 
			} 
			elseif($data['company_id'] == '0')
			{
				$data['employees'] = $this->db->get_where('users',array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
				// $data['employees'] = $this->db->get('account_details')->result_array(); 
			}
									
			else {
				  
				$data['employees'] = $this->db->get_where('users',array('role_id'=>3,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
				$file_name = lang('user_report').'.pdf';
			} 
		   
		   $html = $this->load->view('pdf/employees',$data,true);
		   $file_name = lang('employee_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('user_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);
	}

	function attendance_report_pdf(){		
		$data= array();
		 	
		   $html = $this->load->view('pdf/attendance_report',$data,true);
		  
		   $file_name = lang('attendance_report').'.pdf';
	

		$pdf = array(
			"html"      => $html,
			"title"     => lang('attendance_report'),
			"author"    => $this->company_name,
			"creator"   => $this->company_name,
			"badge"     => 'FALSE',
			"filename"  => $file_name
		);
		$this->applib->create_pdf($pdf);

		  // exit;
	}




	function _filter_by(){

		$filter = isset($_GET['view']) ? $_GET['view'] : '';

		return $filter;
	}

	function employees(){
        if($this->input->post()){
            $company_id = $this->input->post('company');
            $this->db->select('company,fullname,user_id');
            $this->db->from('account_details');
            $this->db->where('company', $company_id);
            $records = $this->db->get()->result_array();
            echo json_encode($records);
            die();
        }
    }

    function favourite_reports(){

    	if($this->input->post('status') == 1){
    		$status = 0;
    		$status_name = lang('removed_from_favourite');
    	} else{
    		$status = 1;
    		$status_name = lang('added_to_favourite');
    	}

    	$data = array(        
            'status' => $status
         );

        $this->db->where('id',$this->input->post('id'));
        $this->db->update('favourite_reports',$data);         
        $report_name = $this->db->get_where('favourite_reports',array('id'=>$this->input->post('id')))->row()->lang;
        $args = array(
                    'user' => User::get_id(),
                    'module' => 'reports',
                    'module_field_id' => $this->input->post('id'),
                    'activity' => lang($report_name).' '.$status_name,
                    'icon' => 'fa-user',
                    'value1' => $this->input->post('status', true),
                );
        App::Log($args);
        echo 'yes'; exit;
    }



}

/* End of file invoices.php */
