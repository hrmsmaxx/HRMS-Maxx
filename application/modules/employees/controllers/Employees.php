<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class employees extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        User::logged_in();
        // if($this->session->userdata('role_id') != 1){
        //     redirect();
        // }

        $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');

        $system_settings = $this->db->get_where('subdomin_system_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
        $systems = unserialize(base64_decode($system_settings['system_settings']));
        
        $this->time_zone = $systems['timezone']?$systems['timezone']:config_item('timezone');

        $this->load->helper('security');
        $this->load->model(array('Client','App','Lead','Users'));
        $this->load->model('employees_details','employees');
    }
    function index(){
        $this->active();
    }

    function active()
    {
        //echo 'session<pre>'; print_r($_SESSION); exit;
    $this->load->module('layouts');
    $this->load->library('template');
    $this->template->title(lang('employee_management').' - '.$this->company_name);
    $data['page'] = lang('employees');
    $data['sub_page'] = lang('all employees');
    $data['datatables'] = TRUE;
    $data['datepicker'] = TRUE;
    $data['form'] = TRUE;
    $data['country_code'] = TRUE;
    $subdomain_id = $this->session->userdata('subdomain_id');
    $data['companies'] = Client::get_all_clients($subdomain_id);
    $data['departments'] = Client::get_all_departments($subdomain_id);
    if($this->session->userdata('role_name') != 'supervisor') {
        $data['branches'] = $this->db->get_where('dgt_branches', array('status'=>'1','subdomain_id'=>$subdomain_id))->result();
    } else {
        $branch_id = explode(',', $this->session->userdata('branch_id'));
        $data['branches'] =  $this->db->select('id, branch_name')
                    ->from('branches')
                    ->where_in('id',$branch_id)
                    ->where(array('status'=>'1','subdomain_id'=>$subdomain_id))
                    ->get()
                    ->result();
        //echo 'branch<pre>'; print_r($data['branches']); exit;
    }
    $this->template
    ->set_layout('users')
    ->build('employees',isset($data) ? $data : NULL);
    }

    function permissions()
    {
        if ($_POST) {
             $permissions = json_encode($_POST);
             $data = array('allowed_modules' => $permissions);
             App::update('account_details',array('user_id' => $_POST['user_id']),$data);
             $this->session->set_flashdata('tokbox_success', lang('settings_updated_successfully'));
            redirect(base_url().'employees');

        }else{
            $staff_id = $this->uri->segment(4);

            if (User::login_info($staff_id)->role_id != '3') {
                $this->session->set_flashdata('tokbox_error', lang('operation_failed'));
                redirect($_SERVER['HTTP_REFERRER']);
            }
            $data['user_id'] = $staff_id;
            $this->load->view('modal/edit_permissions',isset($data) ? $data : NULL);
        }
    }


    function update()
    {
        
        if ($this->input->post()) {
            if (config_item('demo_mode') == 'TRUE') {
            $this->session->set_flashdata('tokbox_error', lang('demo_warning'));
            redirect('employees');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('fullname', 'Full Name', 'required');

        if ($this->form_validation->run() == FALSE)
        {
                $this->session->set_flashdata('tokbox_error', lang('operation_failed'));
                redirect('employees');
        }else{
            $user_id =  $this->input->post('user_id');
            $profile_data = array(
                            'fullname' => $this->input->post('fullname'),
                            'phone' => $this->input->post('phone'),
                            'mobile' => $this->input->post('mobile'),
                            'skype' => $this->input->post('skype'),
                            'doj' => $this->input->post('emp_doj'),
                            'language' => $this->input->post('language'),
                            'locale' => $this->input->post('locale'),
                            'hourly_rate' => $this->input->post('hourly_rate')
                        );
            if (isset($_POST['department'])) {
                $profile_data['department'] = json_encode($_POST['department']);
            }
            App::update('account_details',array('user_id'=>$user_id),$profile_data);
            
            $designation_id = (!empty($this->input->post('designations')))?$this->input->post('designations'):'';
            App::update('users',array('id'=>$user_id),array('designation_id'=>$designation_id));

            $data = array(
                'module' => 'users',
                'module_field_id' => $user_id,
                'user' => User::get_id(),
                'activity' => 'activity_updated_system_user',
                'icon' => 'fa-edit',
                'value1' => User::displayName($user_id),
                'value2' => '',
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                );
            App::Log($data);
            $this->session->set_flashdata('tokbox_success', lang('user_edited_successfully'));
            redirect('employees');
        }
        }else{
        
        $data['id'] = $this->uri->segment(3);
        $this->load->view('modal/edit_user',$data);
        }
    }


    function ban()
    {

        if ($_POST) {
            $user_id = $this->input->post('user_id');
            $ban_reason = $this->input->post('ban_reason');
            $action = (User::login_info($user_id)->banned == '1') ? '0' : '1';

             $data = array('banned' => $action,'ban_reason' => $ban_reason);
             App::update('users',array('id' => $user_id),$data);
            $this->session->set_flashdata('tokbox_success', lang('settings_updated_successfully'));
            redirect(base_url().'employees');
        }else{
            $user_id = $this->uri->segment(4);
            $data['user_id'] = $user_id;
            $data['username'] = User::login_info($user_id)->username;
            $this->load->view('modal/ban_user',isset($data) ? $data : NULL);
        }
    }



    function auth()
    {
        if ($this->input->post()) {
            Applib::is_demo();

        $user_password = $this->input->post('password');
        $username = $this->input->post('username');
        $this->config->load('tank_auth',TRUE);

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('username', 'User Name', 'required|trim|xss_clean');

        if(!empty($user_password)) {
                $this->form_validation->set_rules('password', 'Password', "trim|required|xss_clean|min_length[4]|max_length[32]");
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
        }

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('tokbox_error', lang('operation_failed'));
            redirect('employees');
        }else{
                        date_default_timezone_set($this->time_zone);
            $user_id =  $this->input->post('user_id');
            $args = array(
                            'email'     => $this->input->post('email'),
                            'role_id'   => $this->input->post('role_id'),
                            'modified'  => date("Y-m-d H:i:s")
                        );

            $db_debug = $this->db->db_debug; //save setting
            $this->db->db_debug = FALSE; //disable debugging for queries
            $result = $this->db->set('username',$username)
                               ->where('id',$user_id)
                               ->update('users'); //run query
            $this->db->db_debug = $db_debug; //restore setting

            if(!$result){
                $this->session->set_flashdata('tokbox_error', lang('username_not_available'));
                redirect('employees');
            }

            App::update('users',array('id' => $user_id), $args);

            if(!empty($user_password)) {
                $this->tank_auth->set_new_password($user_id,$user_password);
            }

            $data = array(
                'module' => 'users',
                'module_field_id' => $user_id,
                'user' => User::get_id(),
                'activity' => 'activity_updated_system_user',
                'icon' => 'fa-edit',
                'value1' => User::displayName($user_id),
                'value2' => '',
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                );
            App::Log($data);
            $this->session->set_flashdata('tokbox_success', lang('user_edited_successfully'));
            redirect('employees');
        }
        }else{
        $data['id'] = $this->uri->segment(4);
        $this->load->view('modal/edit_login',$data);
        }
    }

    function designations(){
        if($this->input->post()){
            $depart_id = implode(',', $this->input->post('department'));
            //$dept = $this->db->query("SELECT `id`, `designation` FROM `dgt_designation` WHERE find_in_set(`department_id`, '$depart_id')")->result_array();
            //echo '<pre>'; print_r($depart_id); exit;
            $records = $this->db->query("SELECT `id`, `designation` FROM `dgt_designation` WHERE find_in_set(`department_id`, '$depart_id')")->result_array();
            /*$this->db->select('id,designation');
            $this->db->from('designation');
            $this->db->where('department_id', $depart_id); 

            $this->db->order_by("designation", "asc");
            $records = $this->db->get()->result_array();*/
            echo json_encode($records);
            die();
        }
    }



    function delete()
    {
        if ($this->input->post()) {

        Applib::is_demo();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        if ($this->form_validation->run() == FALSE)
        {
                $this->session->set_flashdata('tokbox_error', lang('delete_failed'));
                $this->input->post('r_url');
        }else{
            $user = $this->input->post('user_id',TRUE);
            $deleted_user = User::displayName($user);

            if (User::profile_info($user)->avatar != 'default_avatar.jpg') {
                if(is_file('./assets/avatar/'.User::profile_info($user)->avatar))
                unlink('./assets/avatar/'.User::profile_info($user)->avatar);
            }
            $user_companies = App::get_by_where('companies',array('primary_contact' => $user));
            foreach ($user_companies as $co) {
                $ar = array('primary_contact' => '');
                App::update('companies',array('primary_contact' => $user),$ar);
            }
            $user_tickets = App::get_by_where('tickets',array('reporter' => $user));
            foreach ($user_tickets as $ticket) {
                App::delete('tickets',array('reporter' => $user));
            }
            $user_bugs = App::get_by_where('bugs',array('reporter' => $user));
            foreach ($user_bugs as $bug) {
                App::delete('bugs',array('reporter' => $user));
            }
            $user_comments = App::get_by_where('comments',array('posted_by' => $user));

            foreach ($user_comments as $comment) {
                $replies = App::get_by_where('comment_replies',array('parent_comment' => $comment->comment_id));
                foreach ($replies as $key => $r) {
                    App::delete('comment_replies',array('parent_comment' => $comment->comment_id));
                }

            }

             $profile = array(
                'user_id' =>$user,
                'deleted_by' =>$this->session->userdata('user_id')
            );                
            $this->db->insert('dgt_employee_left',$profile);

            App::delete('attendance_details', array('user_id' => $user));
            App::delete('shift_scheduling', array('employee_id' => $user));
            App::delete('calendar_incident', array('emp_id' => $user));
            App::delete('comments', array('posted_by' => $user));
            App::delete('comments', array('posted_by' => $user));
            App::delete('messages', array('user_to' => $user));
            App::delete('assign_tasks', array('assigned_user' => $user));
            App::delete('assign_projects', array('assigned_user' => $user));
            App::delete('activities', array('user' => $user));

            App::delete('user_leaves', array('user_id' => $user));
            App::delete('account_details', array('user_id' => $user));
            App::delete('users', array('id' => $user));

            // Log activity
            $data = array(
                'module' => 'users',
                'module_field_id' => $user,
                'user' => User::get_id(),
                'activity' => 'activity_deleted_system_user',
                'icon' => 'fa-trash-o',
                'value1' => $deleted_user,
                'value2' => '',
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                );
            App::Log($data);
            $this->session->set_flashdata('tokbox_success', lang('user_deleted_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        }else{
            $user_id = $this->uri->segment(4);
            $user_id = (is_numeric($user_id))?$user_id:'';
            if($user_id==''){
                $user_id = $this->uri->segment(3);
                $user_id = (is_numeric($user_id))?$user_id:'';    
            }
            $data['user_id'] = (!empty($user_id))?$user_id:0;

            $this->load->view('modal/delete_user',$data);
        }
    }
    /* Dreamguys 27/06/2018 Start PHP Developer */

      function employees_list()
    {
        if($this->input->post()){
            
            $inputs  = $this->input->post();
            $limit   = 1000000;
            $inputs['limit']  = $limit;
            $inputs['subdomain_id']  = $this->session->userdata('subdomain_id');
            $inputs['branch_id'] = $this->session->userdata('branch_id');
            if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
                $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                if($dept_id !=0){
                   $inputs['dept_id'] = $dept_id;
                }
            }
            $lists = $this->employees->get_employees_list($inputs,1);
            $records = array();
            if(count($lists) >0){
                $department = array();
                foreach ($lists as $list) {
                    $list = (array)$list;
                    $depart_id = $list['department_id'];
                    $department_id = (!empty($list['id']))?$this->tank_auth->get_department($list['id']):array();
                    $branch_id = (!empty($list['id']))?$this->tank_auth->get_branch($list['id']):array();
                    if(!empty($department_id)){
                        $deptid  = explode(',', $department_id);
                        $department = array();
                        foreach ($deptid as $key => $deptid) {
                            $deptname = $this->db->get_where('departments',array('deptid'=>$deptid))->row_array();
                            $department[] = $deptname['deptname'];
                        }
                        
                        $list['departments'] = implode(',', $department);
                    } else {
                        $list['departments'] = '-';
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

                    $list['designations'] = (!empty($depart_id))?$this->employees->get_designations($depart_id):array();
                    $records[] = $list;
                }

                //echo 'lit<pre>'; print_r($list); exit;
            }
            // echo"<pre>";print_r($records); exit;
            $count   = $this->employees->get_employees_list($inputs,2);
            $total_page = 1;
            if($count > $limit){
                $total_page = ceil($count /$limit);
            }
            $array = array();
            $array['current_page'] = $inputs['page'];
            $array['total_page']   = $total_page;
            $array['list']         = $records;
            $array['table_header']   = array('name'=>lang('name'),'branch'=>lang('branch'),'department'=>lang('department'),'employee_id_code'=>lang('employee_id_code'),'mail'=>lang('email'),'mobile'=>lang('mobile_phone'),'join_date'=>lang('join_date'),'last_login'=>lang('last_login'),'status'=>lang('status'),'action'=>lang('actions'), 'edit'=>lang('edit'), 'delete'=>lang('delete'), 'active'=>lang('active'), 'inactive'=>lang('inactive'));
            echo json_encode($array);
        }
        die();
    }
    function grid_employees()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('employees').' - '.$this->company_name);
        $data['page'] = lang('employees');        
        $data['sub_page'] = lang('all employees');
        $data['datatables'] = true;
        $data['form'] = true;
        $data['currencies'] = App::currencies();
        $data['languages'] = App::languages();
        $limit   = 1000000;
    	if($this->input->post()) {
        	$inputs['username'] = $this->input->post('username');
        }
        $inputs['limit']  = $limit;
        $inputs['subdomain_id']  = $this->session->userdata('subdomain_id');
    	$inputs['branch_id'] = $this->session->userdata('branch_id');
    	if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
               $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
               if($dept_id !=0){
                  $inputs['dept_id'] = $dept_id;
               }
        }
        //$inputs['branch_id'] = $this->session->userdata('branch_id');
        $data['employees'] = $this->employees->get_employees_list($inputs,1);
	
        // echo "<pre>";print_r($data['employees']); exit;

        $data['countries'] = App::countries();
        $this->template
                ->set_layout('users')
                ->build('grid_employees', isset($data) ? $data : null);
    }
    function changedesignation(){
        if($this->input->post()){
            $params = $this->input->post();
            echo $this->employees->changedesignation($params);

        }
        die();
    }

    function change_inactive($user_id){
        $user_det = $this->db->get_where('users',array('id'=>$user_id))->row_array();
        if($user_det['activated'] == 2)
        {
            $stat = 1;
        }else{
            $stat = 2;
        }
        $res = array(
            'activated' =>$stat
        );
        $this->db->where('id',$user_id);
        $this->db->update('dgt_users',$res);
        $this->session->set_flashdata('tokbox_success', lang('status_updated_success'));
        redirect('employees'); exit;
    }

    function check_user_email()
    {
        $user_email = $this->input->post('user_email');
        $check_email = $this->employees->check_useremail($user_email);
        if($check_email > 0)
        {
            echo "yes";
        }else{
            echo "no";
        }
        exit;
    }

    function check_username()
    {
        $user_name = $this->input->post('check_username');
        $check_username = $this->employees->check_username($user_name);
        if($check_username > 0)
        {
            echo "yes";
        }else{
            echo "no";
        }
        exit;
    }

    function check_id_code()
    {
        $id_code = $this->input->post('id_code');
        $check_id_code = $this->employees->check_id_code($id_code);
        if($check_id_code > 0)
        {
            echo "yes";
        }else{
            echo "no";
        }
        exit;
    }
    
    
    public function profile_view($id = NULL)
    {
        $this->load->module('layouts');
        $this->load->library('template');
        
        $this->template->title(lang('view_profile').' - '.$this->company_name);
        $data['page'] = lang('employees');
        $data['datatables'] = TRUE;
        $data['form'] = TRUE;
        $data['country_code'] = TRUE;
        // print_r($_POST['doc_type']); exit;
        $data['document_type'] = $_POST['doc_type'];

        $data['employee_details'] = $this->employees->get_employeedetailById($id);
        // echo "<pre>"; print_r($data['employee_details']); exit();
        $data['personal_details'] = $this->employees->get_employeepersonalById($id);
            $this->template
        ->set_layout('users')
        ->build('employees/profile_view',isset($data) ? $data : NULL);
    }
    
    
    public function employee_category()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('employee_management').' - '.$this->company_name);
        $data['page'] = lang('employee_management');
        // $data['datatables'] = TRUE;
        $data['form'] = TRUE;
        $data['country_code'] = TRUE;
        $data['employee_details'] = $this->employees->get_employeedetailById($id);
        // echo "<pre>"; print_r($data['employee_details']); exit();
        $data['personal_details'] = $this->employees->get_employeepersonalById($id);
            $this->template
        ->set_layout('users')
        ->build('employees/employee_category',isset($data) ? $data : NULL);
    }
    
    
    public function vacancy()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('employee_management').' - '.$this->company_name);
        $data['page'] = lang('employee_management');
        // $data['datatables'] = TRUE;
        $data['form'] = TRUE;
        $data['country_code'] = TRUE;
        $data['employee_details'] = $this->employees->get_employeedetailById($id);
        // echo "<pre>"; print_r($data['employee_details']); exit();
        $data['personal_details'] = $this->employees->get_employeepersonalById($id);
            $this->template
        ->set_layout('users')
        ->build('employees/vacancy',isset($data) ? $data : NULL);
    }
    
    
    public function request_approval()
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('employee_management').' - '.$this->company_name);
        $data['page'] = lang('employee_management');
        // $data['datatables'] = TRUE;
        $data['form'] = TRUE;
        $data['country_code'] = TRUE;
        $data['employee_details'] = $this->employees->get_employeedetailById($id);
        // echo "<pre>"; print_r($data['employee_details']); exit();
        $data['personal_details'] = $this->employees->get_employeepersonalById($id);
            $this->template
        ->set_layout('users')
        ->build('employees/request_approval',isset($data) ? $data : NULL);
    }
    
    
    public function edit_profile($id)
    {
        if(!$_POST){
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('edit_profile').' - '.$this->company_name);
        $data['page'] = lang('all employees');
        $data['form'] = TRUE;
        $data['employee_details'] = $this->employees->get_employeedetailById($id);
        $data['personal_details'] = $this->employees->get_employeepersonalById($id);
        $this->template
             ->set_layout('users')
             ->build('employees/edit_profile',isset($data) ? $data : NULL);
        }else{
            $profile = array(
                'fullname' =>$this->input->post('full_name'),
                'dob' =>date("Y-m-d", strtotime($this->input->post('dob'))),
                'gender' =>$this->input->post('gender'),
                'address' =>$this->input->post('address'),
                'state' =>$this->input->post('state'),
                'country' =>$this->input->post('country'),
                'pincode' =>$this->input->post('pincode'),
                'phone' =>$this->input->post('phone')
            );

            $check_exist = $this->db->get_where('dgt_account_details',array('user_id'=>$id))->num_rows();
            if($check_exist == 0){
                $profile['user_id'] = $id;
                $this->db->insert('dgt_account_details',$profile);
            }else{
                $this->db->where('user_id',$id);
                $this->db->update('dgt_account_details',$profile);
            }

            $institute = $this->input->post('institute');
            $subject = $this->input->post('subject');
            $yoc = $this->input->post('yoc');
            $degree = $this->input->post('degree');
            $past_company = $this->input->post('past_company');
            $past_company_loc = $this->input->post('past_company_loc');
            $job_position = $this->input->post('job_position');
            $period_from = $this->input->post('period_from');
            $period_to = $this->input->post('period_to');
            $education = array();
            $personal = array();
            for($i = 0; $i< count($institute); $i++)
            {
                $edu = array(
                    'institute'=>$institute[$i],
                    'subject'=>$subject[$i],
                    'yoc'=>$yoc[$i],
                    'degree'=>$degree[$i]
                );
                $education[] = $edu;
            }
            
            for($i = 0; $i< count($past_company); $i++)
            {
                $pers = array(
                    'company_name'=>$past_company[$i],
                    'company_location'=>$past_company_loc[$i],
                    'job_position'=>$job_position[$i],
                    'period_from'=>$period_from[$i],
                    'period_to'=>$period_to[$i]
                );
                $personal[] = $pers;
            }

            $result = array(
                'education_details' => json_encode($education),
                'personal_details' => json_encode($personal)
            );
            $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$id))->num_rows();
            if($pers_check == 0)
            {
                $result['user_id'] = $id;
                $this->db->insert('dgt_users_personal_details',$result);
            }else{
                $this->db->where('user_id',$id);
                $this->db->update('dgt_users_personal_details',$result);
            }
            $this->session->set_flashdata('tokbox_success', lang('profile_updated_success'));
            redirect(base_url().'employees/profile_view/'.$id);
        }
    }




    function basic_info_add($user_id)
    {
      // echo "<pre>";print_r($_POST); exit;
        if($this->input->post('password')!=""){
            if($this->input->post('confirm_password') != $this->input->post('password')){
                 $this->session->set_flashdata('tokbox_error', lang('password_mismatch'));
                redirect(base_url().'employees/profile_view/'.$user_id);
            }
            $password = $this->input->post('confirm_password');

            // Hash password using phpass
           $this->tank_auth->set_new_password($user_id,$password);
           // $some_details['password'] = $hashed_password;

        }
        $fullname = ucfirst($this->input->post('first_name')).' '.ucfirst($this->input->post('last_name'));
        $basic_info = array(
                'fullname' =>$fullname,
                'first_name' =>$this->input->post('first_name'),
                'last_name' =>$this->input->post('last_name'),
                'dob' =>date("Y-m-d", strtotime($this->input->post('dob'))),
                'gender' =>$this->input->post('gender'),                
                'address' =>$this->input->post('address'),
                'state' =>$this->input->post('state'),
                'city' =>$this->input->post('city'),
                'pincode' =>$this->input->post('pincode'),
                'phone' =>$this->input->post('phone'),
                'doj' => $this->input->post('emp_doj'),
            );
        $pers_check = $this->db->get_where('account_details',array('user_id'=>$user_id))->num_rows();
        if($pers_check == 0)
        {
            $basic_info['user_id'] = $user_id;
            $this->db->insert('account_details',$basic_info);
        }else{
            $this->db->where('user_id',$user_id);
            $this->db->update('account_details',$basic_info);
        }
        
        $some_details = array(
            'username' =>$this->input->post('username'),
            'id_code' =>$this->input->post('id_code'),
            'branch_id' => implode(',', $this->input->post('branch_id')),
            'department_id' => implode(',', $this->input->post('department_name')),
            'designation_id'=> $this->input->post('designations'),
            'teamlead_id'=> $this->input->post('reporting_to'),
            'user_type'=> $this->input->post('user_type'),
            'email'=> $this->input->post('email'),
        );
        $this->db->where('id',$user_id);
        $this->db->update('users',$some_details);
        $ro = (!empty($this->input->post('reporting_to')))?$this->input->post('reporting_to'):0;
        $res = array(
                'is_teamlead' =>'yes' 
                );
        $this->db->where('id',$ro);
        $this->db->update('users',$res);
        $this->session->set_flashdata('tokbox_success', lang('basic_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }

    function personal_info_add($user_id)
    {
        $personal_info = array(
                'passport_no' =>$this->input->post('passport_no'),
                'passport_expiry' =>$this->input->post('passport_expiry'),
                'tel_number' =>$this->input->post('tel_number'),
                'nationality' =>$this->input->post('nationality'),
                'religion' =>$this->input->post('religion'),
                'marital_status' =>$this->input->post('marital_status'),
                'spouse' =>$this->input->post('spouse'),
                'no_children' =>$this->input->post('no_children')
            );
        $result = array(
                'personal_info' => json_encode($personal_info)
            );
        $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user_id))->num_rows();
        if($pers_check == 0)
        {
            $result['user_id'] = $user_id;
            $this->db->insert('dgt_users_personal_details',$result);
        }else{
           $this->db->where('user_id',$user_id);
           $this->db->update('users_personal_details',$result);
        }
        
        $this->session->set_flashdata('tokbox_success', lang('personal_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }


    function emergency_info_add($user_id)
    {
        $emergency_info = array(
                'contact_name1' =>$this->input->post('contact_name1'),
                'relationship1' =>$this->input->post('relationship1'),
                'contact1_phone1' =>$this->input->post('contact1_phone1'),
                'contact1_phone2' =>$this->input->post('contact1_phone2'),
                'contact_name2' =>$this->input->post('contact_name2'),
                'relationship2' =>$this->input->post('relationship2'),
                'contact2_phone1' =>$this->input->post('contact2_phone1'),
                'contact2_phone2' =>$this->input->post('contact2_phone2')
            );
        $result = array(
                'emergency_info' => json_encode($emergency_info)
            );
        $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user_id))->num_rows();
        if($pers_check == 0)
        {
            $result['user_id'] = $user_id;
            $this->db->insert('dgt_users_personal_details',$result);
        }else{
            $this->db->where('user_id',$user_id);
            $this->db->update('users_personal_details',$result);
        }
        
        $this->session->set_flashdata('tokbox_success', lang('emergency_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }


    function bank_info_add($user_id)
    {
        $bank_info = array(
                'bank_name' =>$this->input->post('bank_name'),
                'bank_ac_no' =>$this->input->post('bank_ac_no'),
                'ifsc_code' =>$this->input->post('ifsc_code'),
                'pan_no' =>$this->input->post('pan_no')
            );
        $result = array(
                'bank_info' => json_encode($bank_info)
            );
        $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user_id))->num_rows();
        if($pers_check == 0)
        {
            $result['user_id'] = $user_id;
            $this->db->insert('dgt_users_personal_details',$result);
        }else{
            $this->db->where('user_id',$user_id);
            $this->db->update('users_personal_details',$result);
        }
        $this->session->set_flashdata('tokbox_success', lang('bank_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }


    function family_info_add($user_id)
    {
        $member_names = $this->input->post('member_name'); 
        $member_relationship = $this->input->post('member_relationship'); 
        $member_dob = $this->input->post('member_dob'); 
        $member_phone = $this->input->post('member_phone'); 
        $family_members = array();
        for($i = 0; $i< count($member_names); $i++)
            {
                $members = array(
                    'member_name'=>$member_names[$i],
                    'member_relationship'=>$member_relationship[$i],
                    'member_dob'=>$member_dob[$i],
                    'member_phone'=>$member_phone[$i]
                );
                $family_members[] = $members;
            }
        $result = array(
                'family_members_info' => json_encode($family_members)
            );
        $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user_id))->num_rows();
        if($pers_check == 0)
        {
            $result['user_id'] = $user_id;
            $this->db->insert('dgt_users_personal_details',$result);
        }else{
           $this->db->where('user_id',$user_id);
           $this->db->update('users_personal_details',$result);
        }
        
        $this->session->set_flashdata('tokbox_success', lang('family_members_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }


    function education_info_add($user_id)
    {
        // echo "<pre>"; print_r($_POST); exit;
        $institute = $this->input->post('institute'); 
        $subject = $this->input->post('subject'); 
        $start_date = $this->input->post('start_date'); 
        $end_date = $this->input->post('end_date'); 
        $degree = $this->input->post('degree'); 
        $grade = $this->input->post('grade'); 
        $educations = array();
        for($i = 0; $i< count($institute); $i++)
            {
                $education = array(
                    'institute'=>$institute[$i],
                    'subject'=>$subject[$i],
                    'start_date'=>$start_date[$i],
                    'end_date'=>$end_date[$i],
                    'degree'=>$degree[$i],
                    'grade'=>$grade[$i]
                );
                $educations[] = $education;
            }
            // echo $user_id; exit;
        $result = array(
                'education_details' => json_encode($educations)
            );
        // print_r($result); exit;
        $check_user = $this->db->get_where('users_personal_details',array('user_id'=>$user_id))->row_array();
        if(count($check_user) != 0)
        {
            $this->db->where('user_id',$user_id);
            $this->db->update('users_personal_details',$result);
        }else{
            $res = array(
                'user_id' =>$user_id,
                'education_details' => json_encode($educations)
            );
            $this->db->insert('users_personal_details',$res);
        }
        // print_r($r); exit;
        $this->session->set_flashdata('tokbox_success', lang('education_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }


    function experience_info_add($user_id)
    {
        // echo "<pre>"; print_r($_POST); exit;
        $company_name = $this->input->post('company_name'); 
        $location = $this->input->post('location'); 
        $job_position = $this->input->post('job_position'); 
        $period_from = $this->input->post('period_from'); 
        $period_to = $this->input->post('period_to');
        $personals = array();
        for($i = 0; $i< count($company_name); $i++)
            {
                $personal = array(
                    'company_name'=>$company_name[$i],
                    'location'=>$location[$i],
                    'job_position'=>$job_position[$i],
                    'period_from'=>$period_from[$i],
                    'period_to'=>$period_to[$i]
                );
                $personals[] = $personal;
            }
            // echo $user_id; exit;
        $result = array(
                'personal_details' => json_encode($personals)
            );
        // print_r($result); exit;
        $check_user = $this->db->get_where('users_personal_details',array('user_id'=>$user_id))->row_array();
        if(count($check_user) != 0)
        {
            $this->db->where('user_id',$user_id);
            $this->db->update('users_personal_details',$result);
        }else{
            $res = array(
                'user_id' =>$user_id,
                'education_details' => json_encode($educations)
            );
            $this->db->insert('users_personal_details',$res);
        }
        // print_r($r); exit;
        $this->session->set_flashdata('tokbox_success', lang('education_info_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
              
    }


    function teamlead_options(){
        $des_id = $this->input->post('des_id');
        $dept_id = $this->input->post('dept_id');
        $branch_id = $this->input->post('branch_id');

        if($branch_id != '') {
            $this->db->where("U.branch_id IN (".$branch_id.")",NULL, false);
        }
       /* if($dept_id != '') {
            $this->db->where("U.department_id IN (".$dept_id.")",NULL, false);
        }*/

        $user_details = $this->db->select('*')
                        ->from('users U')
                        ->join('account_details AD','U.id = AD.user_id')
                        ->where('U.designation_id',$des_id)
                        ->where('U.role_id',3)
                       	->where('U.activated',1)
                        ->where('U.banned',0)
                        ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))
                        ->get()
                        ->result_array();
        //$reporting_to = $this->select('id,username')->get_where('users', array('department_id'=>$dept_id, 'designation'=>$des_id))->result_array();

        /*$r = $this->db->get_where('designation',array('id'=>$des_id))->row_array();
        $grade = $r['grade'];
        $grade_details = $this->db->get_where('grades',array('grade_id'=>$grade))->row_array();
        $all_grades = $this->db->get_where('designation',array('grade <='=>$grade))->result_array();
        $all_users = array();
        foreach ($all_grades as $grades) {
            // $this->db->group_by('designation_id');
            $user_details = $this->db->select('*')
                                     ->from('users U')
                                     ->join('account_details AD','U.id = AD.user_id')
                                     ->where('U.designation_id',$grades['id'])
                                      ->where('U.role_id',3)
                                     ->where('U.activated',1)
                                     ->where('U.banned',0)
                                     ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))
                                     ->get()->result_array();*/
            // $user_details = $this->db->get_where('users',array('designation_id'=>$grades['id'],'role_id'=>3,'activated'=>1,'banned'=>0))->result_array();
            foreach($user_details as $users)
            {
                if(count($user_details) != 0)
                {

                $user = array(
                    'id' => $users['user_id'],
                    'username' => $users['fullname']
                );
                $all_users[] = $user;
                }
            }
        //}

    foreach ($all_users as $key => $row) {
        $id[$key]  = $row['id'];
        $username[$key] = $row['username'];
    }

    $username = array_map('strtolower', $username);

    array_multisort($username, SORT_ASC, SORT_STRING, $all_users);

        echo json_encode($all_users); exit;

    }



    function employee_edit($user_id)
    {
        $this->load->view('modal/create');
    }



    function employee_profile_upload(){
        Applib::is_demo();

        if(file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
            $current_avatar = User::profile_info($this->input->post('user_id'))->avatar;

                            $config['upload_path'] = './assets/avatar/';
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['overwrite'] = FALSE;

                            $this->load->library('upload', $config);

                            if ( ! $this->upload->do_upload('file'))
                                    {
                                        echo $this->upload->display_errors(); exit;
                            }else{
                                        $data = $this->upload->data();
                                        $ar = array('avatar' => $data['file_name']);
                                        App::update('account_details',array('user_id'=>$this->input->post('user_id')),$ar);
                                        
                                if(file_exists('./assets/avatar/'.$current_avatar) 
                                    && $current_avatar != 'default_avatar.jpg'){
                                    unlink('./assets/avatar/'.$current_avatar);
                                }
                            }
                }

                if(isset($_POST['use_gravatar']) && $_POST['use_gravatar'] == 'on'){
                    $ar = array('use_gravatar' => 'Y');
                    App::update('account_details',array('user_id'=>$this->input->post('user_id')),$ar);

                }else{ 
                    $ar = array('use_gravatar' => 'N');
                    App::update('account_details',array('user_id'=>$this->input->post('user_id')),$ar);
                }
                echo 'success'; exit;


    }

    function bank_statutory()
    {
        $user_id = $this->input->post('bankuser_id');
        $salary = $this->input->post('user_salary');
        $payment_type = $this->input->post('payment_type');
        $pf_contribution = $this->input->post('pf_contribution')?$this->input->post('pf_contribution'):'';
        $pf_no = $this->input->post('pf_no')?$this->input->post('pf_no'):'';
        $pf_rates = $this->input->post('pf_rates')?$this->input->post('pf_rates'):'';
        $pf_add_rates = $this->input->post('pf_add_rates')?$this->input->post('pf_add_rates'):'';
        $pf_total_rate = $this->input->post('pf_total_rate')?$this->input->post('pf_total_rate'):'';
        $pf_employer_contribution = $this->input->post('pf_employer_contribution')?$this->input->post('pf_employer_contribution'):'';
        $employer_add_rates = $this->input->post('employer_add_rates')?$this->input->post('employer_add_rates'):'';
        $employer_total_rates = $this->input->post('employer_total_rates')?$this->input->post('employer_total_rates'):'';
        $esi_contribution = $this->input->post('esi_contribution')?$this->input->post('esi_contribution'):'';
        $esi_no = $this->input->post('esi_no')?$this->input->post('esi_no'):'';
        $esi_rate = $this->input->post('esi_rate')?$this->input->post('esi_rate'):'';
        $esi_add_rate = $this->input->post('esi_add_rate')?$this->input->post('esi_add_rate'):'';
        $esi_total_rate = $this->input->post('esi_total_rate')?$this->input->post('esi_total_rate'):'';

        $all_details = array(
            'pf_contribution' =>$pf_contribution,
            'pf_no' =>$pf_no,
            'pf_rates' =>$pf_rates,
            'pf_add_rates' =>$pf_add_rates,
            'pf_total_rate' =>$pf_total_rate,
            'pf_employer_contribution' =>$pf_employer_contribution,
            'employer_add_rates' =>$employer_add_rates,
            'employer_total_rates' =>$employer_total_rates,
            'esi_contribution' =>$esi_contribution,
            'esi_no' =>$esi_no,
            'esi_rate' =>$esi_rate,
            'esi_add_rate' =>$esi_add_rate,
            'esi_total_rate' =>$esi_total_rate
        );

        $result = array(
            'salary'  => $salary,
            'payment_type' => $payment_type,
            'bank_statutory' => json_encode($all_details) 
        );
        $check_status = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        // echo count($check_status); exit;
        if(count($check_status) == 0 )
        {
            $result['user_id'] = $user_id;
            // echo "<pre>"; print_r($result); exit;
            $this->db->insert('dgt_bank_statutory',$result);
        }else{
            // echo "<pre>"; print_r($result); exit;
            $this->db->where('user_id',$user_id);
            $this->db->update('dgt_bank_statutory',$result);
        }
        $this->session->set_flashdata('tokbox_success', lang('bank_statutory_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
    }


    function addtional_pf_details()
    {
        $user_id = $this->input->post('user_id');
        $res = array(
            'addtion_name' => $this->input->post('addtion_name'),
            'category_name' => $this->input->post('category_name'),
            'unit_amount' => $this->input->post('unit_amount')
        );
        $check_status = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        if(count($check_status) == 0 )
        {
            $res['id'] = 1;
            $result =array(
                'pf_addtional' => json_encode(array($res))
            );
            $result['user_id'] = $user_id;
            $this->db->insert('dgt_bank_statutory',$result);
        }else{
            $addtional_details = json_decode($check_status['pf_addtional'],TRUE);
            if(is_array($addtional_details))
            {
                $res['id'] = count($addtional_details) + 1;
                array_push($addtional_details,$res);
                $pf_add = array( 'pf_addtional' => json_encode($addtional_details));
            }else{
                $res['id'] = 1;
                $pf_add = array( 'pf_addtional' => json_encode(array($res)));
            }
            $this->db->where('user_id',$user_id);
            $this->db->update('dgt_bank_statutory',$pf_add);
        }
        $this->session->set_flashdata('tokbox_success', lang('pf_addtional_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);

    }


    function edit_additional($ar_id)
    {
        $user_id = $this->input->post('user_id');
        $get_data = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        $addtional = json_decode($get_data['pf_addtional'],TRUE);
        foreach($addtional as $key => $value)
        {
            if($value['id'] == $ar_id)
            {
              $addtional[$key] =array(
                'addtion_name' => $this->input->post('addtion_name'),
                'category_name' => $this->input->post('category_name'),
                'unit_amount' => $this->input->post('unit_amount'),
                'id' => $ar_id
              );
            }
        }   
        $updated_addtional = array('pf_addtional' => json_encode($addtional));
        $this->db->where('user_id',$user_id);
        $this->db->update('dgt_bank_statutory',$updated_addtional);
        $this->session->set_flashdata('tokbox_success', lang('pf_addtional_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);

    }


    function delete_pfaddtional()
    {
        $ar_id = $this->input->post('arid');
        $user_id = $this->input->post('user_id');
        $keyid = $this->input->post('keyid');

        $get_data = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        $addtional = json_decode($get_data['pf_addtional'],TRUE);
        unset($addtional[$keyid]);
        if(!empty($addtional)){
            $updated_addtional = array('pf_addtional' => json_encode($addtional));
        }else{
            $updated_addtional = array('pf_addtional' =>'');
        }
        $this->db->where('user_id',$user_id);
        $this->db->update('dgt_bank_statutory',$updated_addtional);
        echo "success"; exit;
    }

    function add_deduction()
    {
        $user_id = $this->input->post('user_id');
        $res = array(
            'model_name' => $this->input->post('model_name'),
            'unit_amount' => $this->input->post('unit_amount')
        );
        $check_status = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        if(count($check_status) == 0 )
        {
            $res['id'] = 1;
            $result =array(
                'pf_deduction' => json_encode(array($res))
            );
            $result['user_id'] = $user_id;
            $this->db->insert('dgt_bank_statutory',$result);
        }else{
            $addtional_details = json_decode($check_status['pf_deduction'],TRUE);
            if(is_array($addtional_details))
            {
                $res['id'] = count($addtional_details) + 1;
                array_push($addtional_details,$res);
                $pf_add = array( 'pf_deduction' => json_encode($addtional_details));
            }else{
                $res['id'] = 1;
                $pf_add = array( 'pf_deduction' => json_encode(array($res)));
            }
            $this->db->where('user_id',$user_id);
            $this->db->update('dgt_bank_statutory',$pf_add);
        }
        $this->session->set_flashdata('tokbox_success', lang('pf_deduction_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
    }


    function edit_pfdeduction($ar_id){
        $user_id = $this->input->post('user_id');
        $get_data = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        $deduction = json_decode($get_data['pf_deduction'],TRUE);
        foreach($deduction as $key => $value)
        {
            if($value['id'] == $ar_id)
            {
              $deduction[$key] =array(
                'model_name' => $this->input->post('model_name'),
                'unit_amount' => $this->input->post('unit_amount'),
                'id' => $ar_id
              );
            }
        }   
        $updated_deduction = array('pf_deduction' => json_encode($deduction));
        $this->db->where('user_id',$user_id);
        $this->db->update('dgt_bank_statutory',$updated_deduction);
        $this->session->set_flashdata('tokbox_success', lang('pf_addtional_updated'));
        redirect(base_url().'employees/profile_view/'.$user_id);
    }


    function delete_pfdeduction()
    {
        $ar_id = $this->input->post('arid');
        $user_id = $this->input->post('user_id');
        $keyid = $this->input->post('keyid');

        $get_data = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
        $addtional = json_decode($get_data['pf_deduction'],TRUE);
        unset($addtional[$keyid]);
        if(!empty($addtional)){
            $updated_addtional = array('pf_deduction' => json_encode($addtional));
        }else{
            $updated_addtional = array('pf_deduction' =>'');
        }
        $this->db->where('user_id',$user_id);
        $this->db->update('dgt_bank_statutory',$updated_addtional);
        echo "success"; exit;
    }


    // function add_overtime()
    // {
    //     $user_id = $this->input->post('user_id');
    //     $res = array(
    //         'model_name' => $this->input->post('ot_description'),
    //         'unit_amount' => date('Y-m-d',strtotime($this->input->post('ot_date'))),
    //         'hours' => $this->input->post('ot_hours')
    //     );
    //     $check_status = $this->db->get_where('dgt_bank_statutory',array('user_id'=>$user_id))->row_array();
    //     if(count($check_status) == 0 )
    //     {
    //         $res['id'] = 1;
    //         $result =array(
    //             'overtime' => json_encode(array($res))
    //         );
    //         $result['user_id'] = $user_id;
    //         $this->db->insert('dgt_bank_statutory',$result);
    //     }else{
    //         $addtional_details = json_decode($check_status['overtime'],TRUE);
    //         if(is_array($addtional_details))
    //         {
    //             $res['id'] = count($addtional_details) + 1;
    //             array_push($addtional_details,$res);
    //             $pf_add = array( 'overtime' => json_encode($addtional_details));
    //         }else{
    //             $res['id'] = 1;
    //             $pf_add = array( 'overtime' => json_encode(array($res)));
    //         }
    //         $this->db->where('user_id',$user_id);
    //         $this->db->update('dgt_bank_statutory',$pf_add);
    //     }
    //     $this->session->set_flashdata('tokbox_success', 'Over Time updated');
    //     redirect(base_url().'employees/profile_view/'.$user_id);
    // }


      function add_overtime()
    {
        $user_id = $this->input->post('user_id');
        $res = array(
            'user_id'=>$user_id,
            'teamlead_id'=>$this->input->post('teamlead_id'),
            'ot_description' => $this->input->post('ot_description'),
            'ot_date' => date('Y-m-d',strtotime($this->input->post('ot_date'))),
            'ot_hours' => $this->input->post('ot_hours'),
            'status'=>0,
            'date_posted'=>date('Y-m-d H:i:s'),
            'subdomain_id' => $this->session->userdata('subdomain_id')

        );
        //echo 'ot<pre>'; print_r($res); exit;
        $this->db->insert('overtime',$res);
         $result=($this->db->affected_rows()!= 1)? false:true;

            if($result==true) 
            {
                $this->session->set_flashdata('tokbox_success', lang('overtime_updated'));
                redirect(base_url().'employees/profile_view/'.$user_id);
            }   
            else
            {
                 $this->session->set_flashdata('tokbox_error', lang('overtime_update_fail'));
                 redirect(base_url().'employees/profile_view/'.$user_id);
            }
       
    }

    function overtime_cancel($id,$user_id)
    {
        
           
            $det['status']      = 3; 
            $this->db->update('overtime',$det,array('id'=>$id)); 
             $this->session->set_flashdata('tokbox_success', lang('overtime_cancelled'));
                redirect(base_url().'employees/profile_view/'.$user_id);
      
    
    }

     function overtime_approve($id,$user_id)
    {
        
           
            $det['status']      = 1; 
            $this->db->update('overtime',$det,array('id'=>$id)); 
             $this->session->set_flashdata('tokbox_success', lang('overtime_approved'));
                redirect(base_url().'employees/profile_view/'.$user_id);
      
    
    }

     function overtime_reject($id,$user_id)
    {
        
           
            $det['status']      = 2; 
            $this->db->update('overtime',$det,array('id'=>$id)); 
             $this->session->set_flashdata('tokbox_success', lang('overtime_rejected'));
                redirect(base_url().'employees/profile_view/'.$user_id);
      
    
    }

    function add_depart_role()
    {
        $department = array(
            'deptname' => $this->input->post('department_name')
        );
        $this->db->insert('departments',$department);
        $depart_id = $this->db->insert_id();
        $roles = array(
            'department_id' => $depart_id,
            'grade' => $this->input->post('grade'),
            'designation' => $this->input->post('role_name')
        );
        $this->db->insert('designation',$roles);
        // echo $r; exit;
        $res = $this->db->get('departments')->result_array();
        echo json_encode($res); exit;

    }

     function emp_file_expir_notify()
    {
        $doc_types = $this->db->get_where('user_files')->result_array();
        if(!empty($doc_types)){
            foreach ($doc_types as $doc_type) {
                if($doc_type['expired_date'] !='0000-00-00' || $doc_type['expired_date'] !=null){
                    if(!empty($doc_type['before_expired_day'])){
                        
                        $expired_date = date('d-m-Y', strtotime('-'.$doc_type['before_expired_day'].' days', strtotime($doc_type['expired_date'])));
                        
                        if(strtotime($expired_date) == strtotime(date('d-m-Y'))){
                            // echo $expired_date; exit;
                            $args = array(
                            'user' => User::get_id(),
                            'module' => 'employees/profile_view/'.$doc_type['user_id'],
                            'module_field_id' => $_POST['user_file_id'],
                            'activity' => $doc_type['description'].' '.lang('expired_on').' '.$doc_type['expired_date'],
                            'icon' => 'fa-user',
                            'value1' => $this->input->post('user_file_id', true),
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                        );
                App::Log($args);

                          $args = array(
                            'user' => $doc_type['user_id'],
                            'module' => 'employees/profile_view/'.$doc_type['user_id'],
                            'module_field_id' => $_POST['user_file_id'],
                            'activity' => $doc_type['description'].' '.lang('expired_on').' '.$doc_type['expired_date'],
                            'icon' => 'fa-user',
                            'value1' => $this->input->post('user_file_id', true),
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                        );
                App::Log($args);
                        }   
                    
                    }
                }
            }

        }
    }


    function add_attachment($user_id)
    {
           // echo "<pre>"; print_r($_POST); exit();
        $count = count($_FILES['attach_file']['name']);
        if($count != 0){
        $config['upload_path']          = './assets/uploads/profile_attachments/';
        $config['allowed_types']        = '*';
        $this->load->library('upload', $config);
        $image = array(); 
        $image =$_FILES;

        for ($i=0; $i<$count;$i++) { 

            $_FILES['attach_file']['name'] = $image['attach_file']['name'][$i];
            $_FILES['attach_file']['type'] = $image['attach_file']['type'][$i];
            $_FILES['attach_file']['tmp_name'] = $image['attach_file']['tmp_name'][$i];
            $_FILES['attach_file']['error'] = $image['attach_file']['error'][$i];
            $_FILES['attach_file']['size'] = $image['attach_file']['size'][$i];
             
            if ( ! $this->upload->do_upload('attach_file'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('tokbox_error', lang('attachment_not_uploaded'));
            }
            else
            {
                $data = $this->upload->data();
                // print_r($data); exit;
                $res = array(
                            'user_id' => $user_id,
                            'doc_type' => $_POST['doc_type'],
                            'is_expired' => isset($_POST['is_expired'])?$_POST['is_expired']:'0',
                            'expired_date' => ($_POST['expired_date'] !='')?date('Y-m-d',strtotime($_POST['expired_date'])):'',
                            'before_expired_day' => ($_POST['before_expired_day'] != '')?$_POST['before_expired_day']: '0',
                            'attach_file' => $data['file_name'],
                            'description' => $_POST['description']
                        );
                if($res['is_expired'] == 0){
                    $res['expired_date'] = '';
                    $res['before_expired_day'] = '';
                }
                // echo "<pre>";print_r($res); exit;
                $this->db->insert('user_files',$res);
            }

        }
            $this->session->set_flashdata('tokbox_success', lang('upload_attachments'));
            redirect(base_url().'employees/profile_view/'.$user_id.'/file_attach');
        }else{
            $this->session->set_flashdata('tokbox_error', lang('choose_attachment_files'));
            redirect(base_url().'employees/profile_view/'.$user_id.'/file_attach');
        }

    }


    function edit_attachment($id = NULL)
    {
         // echo "<pre>"; print_r($_POST); exit();
        if ($_POST) {   
            $count = count($_FILES['attach_file']['name']);
            if($count != 0){
            $config['upload_path']          = './assets/uploads/profile_attachments/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|txt|doc|docx';
            $this->load->library('upload', $config);
            $image = array(); 
            $image =$_FILES;

            for ($i=0; $i<$count;$i++) { 

                $_FILES['attach_file']['name'] = $image['attach_file']['name'][$i];
                $_FILES['attach_file']['type'] = $image['attach_file']['type'][$i];
                $_FILES['attach_file']['tmp_name'] = $image['attach_file']['tmp_name'][$i];
                $_FILES['attach_file']['error'] = $image['attach_file']['error'][$i];
                $_FILES['attach_file']['size'] = $image['attach_file']['size'][$i];
                 
                if ( ! $this->upload->do_upload('attach_file'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    if(empty($_POST['image'])){                        
                     $this->session->set_flashdata('tokbox_error', lang('attachment_not_uploaded'));
                    }
                }
                else
                {
                    $data = $this->upload->data();
                    // print_r($data); exit;
                   
                }

            }
            if(empty($data['file_name'])){
                $data['file_name'] = $_POST['image'] ;
            }
             $res = array(
                            'user_id' => $_POST['user_id'],
                            'doc_type' => $_POST['doc_type'],
                            'is_expired' => isset($_POST['is_expired'])?$_POST['is_expired']:'0',
                            'expired_date' => ($_POST['expired_date'] !='')?date('Y-m-d',strtotime($_POST['expired_date'])):'',
                            'before_expired_day' => ($_POST['before_expired_day'] != '')?$_POST['before_expired_day']: '0',
                            'attach_file' => $data['file_name'],
                            'description' => $_POST['description']
                        );
                    // echo "<pre>";print_r($res); exit;
            if($res['is_expired'] == 0){
                $res['expired_date'] = '';
                $res['before_expired_day'] = '';
            }
                    $this->db->where('user_file_id',$_POST['user_file_id']) -> update('user_files',$res);
                $this->session->set_flashdata('tokbox_success', lang('upload_attachments'));
                redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');
            }else{
                $this->session->set_flashdata('tokbox_error', lang('choose_attachment_files'));
                redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');
            }
        }else{
            $data['id'] = $id;
            $data['user_files'] = $this->db ->where(array('user_file_id'=>$id)) -> get('user_files') -> result_array();
            // print_r($data['user_files']); exit();
            $this->load->view('modal/edit_attachment',isset($data) ? $data : NULL);
        }

    }

    public function delete_attachment()
    {
         if ($this->input->post()) {
               
                // echo "<pre>"; print_r( $_POST); exit;
               
               
                $this->db->where('user_file_id',$_POST['id']);
                $this->db->delete('user_files');      
                 // print_r($this->db->last_query()); die();
                $args = array(
                            'user' => User::get_id(),
                            'module' => 'employees',
                            'module_field_id' => $_POST['user_id'],
                            'activity' => lang('delete_document_types'),
                            'icon' => 'fa-user',
                            'value1' => $this->input->post('id', true),
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                        );
                App::Log($args);
               $this->session->set_flashdata('tokbox_success', lang('delete_attachment_successfully'));
                redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');

                        
        }else {
             // print_r($this->uri->segment(3)); exit;
            $data['id'] = $this->uri->segment(3);
            $user_files = $this->db ->where(array('user_file_id'=>$data['id'])) -> get('user_files') -> row_array();
            $data['user_id'] = $user_files['user_id'];
            $this->load->view('modal/delete_attachment',$data);

        }
    }

    function add_document_type($user_id)
    {

        if($_POST){
               // echo "<pre>"; print_r($_POST); exit();
            $_POST['status'] = isset($_POST['status'])?1:0;
             $res = array(
                            'user_id' =>  $_POST['user_id'],
                            'type_name' => $_POST['type_name'],
                            // 'is_expired' => isset($_POST['is_expired'])?$_POST['is_expired']:'0',
                            // 'expired_date' => ($_POST['expired_date'] !='')?date('Y-m-d',strtotime($_POST['expired_date'])):'',
                            // 'before_expired_day' => ($_POST['before_expired_day'] != '')?$_POST['before_expired_day']: '0',
                            'status' => $_POST['status'],
                            'created_by' => $this->session->userdata('user_id'),
                            'created_date' => date('Y-m-d')
                        );
               //   echo "<pre>"; print_r($res); exit();
                $this->db->insert('document_types',$res);
           // echo $this->db->last_query(); exit;
            $this->session->set_flashdata('tokbox_success', lang('category_of_document_created_successfully'));
            redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');
        }                // print_r($data); exit;
               
        else{
            $this->session->set_flashdata('tokbox_error', lang('somthing_went_to_wrong'));
            redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');
        }

    }

     function edit_document_type($id = NULL){
       
        if ($_POST) {               
                  $_POST['status'] = isset($_POST['status'])?1:0;
             $res = array(
                            'user_id' =>  $_POST['user_id'],
                            'type_name' => $_POST['type_name'],
                            // 'is_expired' => isset($_POST['is_expired'])?$_POST['is_expired']:'0',
                            // 'expired_date' => ($_POST['expired_date'] !='')?date('Y-m-d',strtotime(str_replace('/', '-', $_POST['expired_date']))):'',
                            // 'before_expired_day' => ($_POST['before_expired_day'] != '')?$_POST['before_expired_day']: '0',
                            'status' => $_POST['status'],
                            'created_by' => $this->session->userdata('user_id'),
                            'created_date' => date('Y-m-d')
                        );
             // if($res['is_expired'] == 0){
             //    $res['expired_date'] = '';
             //    $res['before_expired_day'] = '';
             // }
             // echo print_r($res); exit;
            $this->db->where('id',$_POST['id']) -> update('document_types',$res);
            $this->session->set_flashdata('tokbox_success', lang('category_of_document_edited_successfully'));
           redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');
            
        }else{
            $data['id'] = $id;
            $data['document_types'] = $this->db ->where(array('id'=>$id)) -> get('document_types') -> result();
            // print_r($data['category_info']); exit();
            $this->load->view('modal/edit_document_type',isset($data) ? $data : NULL);
        }
    }

    public function delete_document_type()
    {
         if ($this->input->post()) {               
                // echo "<pre>"; print_r( $_POST); exit;
            $this->db->where('id',$_POST['id']);
            $this->db->delete('document_types');      
             // print_r($this->db->last_query()); die();
            $args = array(
                        'user' => User::get_id(),
                        'module' => 'employees',
                        'module_field_id' => $_POST['user_id'],
                        'activity' => lang('delete_document_types'),
                        'icon' => 'fa-user',
                        'value1' => $this->input->post('id', true),
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);
            $this->session->set_flashdata('tokbox_success', lang('delete_document_types_successfully'));
            redirect(base_url().'employees/profile_view/'.$_POST['user_id'].'/file_attach');
                        
        }else {
             // print_r($this->uri->segment(3)); exit;
            $data['id'] = $this->uri->segment(3);
            $document_types = $this->db ->where(array('id'=>$data['id'])) -> get('document_types') -> row_array();
            $data['user_id'] =  $document_types['user_id'];
            $this->load->view('modal/delete_document_type',$data);

        }
    }

     function get_document_type_by_id(){
        

        if($this->input->post()){
            $id = $this->input->post('id');           
            $record = $this->db->get_where('document_types',array('id'=>$id))->row_array(); 
            $records['expired_date'] =($record['expired_date'] != '0000-00-00')?date('d-m-Y',strtotime($record['expired_date'])):'' ;           
            $records['before_expired_day'] = $record['before_expired_day'];
            $records['is_expired'] = $record['is_expired'];
            
            echo json_encode($records);
            die();
        }
    }

    public function reset_password($user_id){
        if ($this->input->post()) {
            $password = $this->input->post('new_password');
            $new_password = $this->tank_auth->user_reset_password($password);

            $res = array(
                'password' => $new_password
            );
            $this->db->where('id',$user_id);
            $this->db->update('users',$res);
            $this->session->set_flashdata('tokbox_success', lang('password_changed'));
            redirect('employees');
        }else{
            $user_id = $this->uri->segment(4);
            $user_id = (is_numeric($user_id))?$user_id:'';
            if($user_id==''){
                $user_id = $this->uri->segment(3);
                $user_id = (is_numeric($user_id))?$user_id:'';    
            }
            $data['user_id'] = (!empty($user_id))?$user_id:0;

            $this->load->view('modal/resetpassword_user',$data); 
        }
    }


    public function getDepartment(){

        $records = $this->db->select('deptid,id_code,deptname')
                ->from('departments')
                ->where('subdomain_id',$this->session->userdata('subdomain_id'))
                ->get()
                ->order_by('deptname', 'ASC')
                ->result_array();

        /*if($this->input->post()){
            $branch_id = implode(',', $this->input->post('branch'));
            $records = $this->db->query("SELECT `deptid`, `id_code`, `deptname` FROM `dgt_departments` WHERE find_in_set(`branch_id`, '$branch_id')")->result_array();*/
            //$dept = $this->db->query("SELECT `id`, `designation` FROM `dgt_designation` WHERE find_in_set(`department_id`, '$depart_id')")->result_array();
            //echo '<pre>'; print_r($depart_id); exit;
            /*$this->db->select('id,designation');
            $this->db->from('designation');
            $this->db->where('department_id', $depart_id); 

            $this->db->order_by("designation", "asc");
            $records = $this->db->get()->result_array();*/
        // }
        echo json_encode($records);
        die();
    }


    /* Dreamguys 25/02/2019 End */

}

/* End of file employees.php */
