<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH.'/libraries/Requests.php';
class Settings extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        User::logged_in();
       // if(!User::is_admin()) redirect('');
        $this->load->model(array('App','Client','Expense','Project','Performance','Offer'));
        $this->load->model('settings_model');
        $all_routes = $this->session->userdata('all_routes');
        foreach($all_routes as $key => $route){
            if($route == 'settings'){
                $routname = 'settings';
            } 
        }
        //if(empty($routname)){
        //     $this->session->set_flashdata('message', lang('access_denied'));
        //    redirect('');
       // }  



        if (User::is_admin() || User::perm_allowed(User::get_id(),'view_all_expenses')) 
        {
            if(isset($_GET['project']))
            {
                $this->expenses = App::get_by_where('expenses',array('id !='=>'0','project' => $_GET['project']));          
            }
            else
            {
                 $this->expenses = App::get_by_where('expenses',array('id !='=>'0'));
            }
        }

        // $performance_status = $this->db->get('performance_status')->row_array();
        // if($performance_status['okr'] == 1){
        //     $active_performance = 'okr';
        // }
        // if($performance_status['competency'] == 1){
        //     $active_performance = 'competency';
        // }
        // if($performance_status['smart_goals'] == 1){
        //     $active_performance = 'okr';
        // }

        $this -> invoice_logo_height = 0;
        $this -> invoice_logo_width = 0;
        $this->load->library(array('form_validation'));

        Requests::register_autoloader();
        $this->auth_key = config_item('api_key'); // Set our API KEY

        $this->load->module('layouts');
        $this->load->config('rest');
        $this->load->library('template');
        $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');
        $this->template->title(lang('settings').' - '.$this->company_name);

        $this->load->model(array('Setting','Project','App'));

        $this->general_setting = '?settings=general';
        $this->invoice_setting = '?settings=invoice';
        $this->estimate_setting = '?settings=estimate';
        $this->system_setting = '?settings=system';
        $this->theme_setting = '?settings=theme';
        $this->email_setting = '?settings=email';
        // $this->approval_setting = '?settings=approval';
        $this->performance_setting = '?settings=performance';
        $this->leave_setting = '?settings=leave_settings';
        $this->language_files = array(
            'fx_lang.php' => './application/',
            'tank_auth_lang.php' => './application/',
            'calendar_lang.php' => './system/',
            'date_lang.php' => './system/',
            'db_lang.php' => './system/',
            'email_lang.php' => './system/',
            'form_validation_lang.php' => './system/',
            'ftp_lang.php' => './system/',
            'imglib_lang.php' => './system/',
            'migration_lang.php' => './system/',
            'number_lang.php' => './system/',
            'profiler_lang.php' => './system/',
            'unit_test_lang.php' => './system/',
            'upload_lang.php' => './system/',
        );

        $this->applib->set_locale();
    }

    function index()
    {
        $settings = $this->input->get('settings', TRUE)?$this->input->get('settings', TRUE):'general';
        $exp = $this->db->get('expenses')->result_array();
    

        $expenses = $this->db->select('*')
                    ->from('expenses')
                    ->like('expense_approvers',$this->session->userdata('user_id'))
                    ->get()->result();
                   
        foreach ($expenses as $key => $e) {
            $unserialize = unserialize($e->expense_approvers);
            $approvers = $unserialize;
            if(in_array($this->session->userdata('user_id'), $approvers))
            {
                $expenses_approvers = $expenses;
               
            }
        }

         if(User::is_staff() && !empty($expenses_approvers))
         {
            $expense_details = $expenses;
         }
         else
         {
            $expense_details = $this->expenses;
         }
       
        $data['page'] = lang('settings');
        $data['form'] = TRUE;
        $data['editor'] = TRUE;
        $data['fuelux'] = TRUE;
        $data['datatables'] = TRUE;
        $data['nouislider'] = TRUE;
        $data['postmark_config'] = TRUE;
        $data['translations'] = $this->applib->translations();
        $data['available'] = $this->available_translations();
        $data['languages'] = App::languages();
        $data['load_setting'] = $settings;
        $data['locale_name'] = App::get_locale()->name;
        $data['expenses'] = $expense_details;
        $data['okr_description'] = Performance::okr_description();
        $data['kpi_desc'] = Performance::kpi_desc();
        $data['competencies_desc'] = Performance::kpi_desc();
        $data['competencies_desc'] = Performance::performance_competencies();
        $data['all_employees']       = App::GetAllEmployees();
        $data['datepicker'] = TRUE;
        $data['form']       = TRUE; 
        $data['datatables'] = TRUE;
        $data['country_code'] = TRUE;
        // $data['page']       = 'leaves';
        $data['role']       = $this->tank_auth->get_role_id();
        if ($settings == 'system') {
            $data['countries'] = App::countries();
            $data['locales'] = App::locales();
            $data['currencies'] = App::currencies();
            $data['timezones'] = Setting::timezones();
        }
        if ($settings == 'approval') {

            $auto_select = NULL;
            if(isset($_GET['project'])){ $auto_select = $_GET['project']; }else{ $auto_select = NULL; }

            $user_id = $this->session->userdata['user_id'];
            $data['candi_list'] = Offer::approve_candidate($user_id);
            $data['offer_jobtype'] = Offer::job_where();
             
            
            $data['categories'] = App::get_by_where('categories',array('module'=>'expenses'));
            $data['projects'] = $this->get_staff_projects(User::get_id()); 
            $data['auto_select_project'] = $auto_select;
            $data['form'] = TRUE;


        }
            // if ($settings == 'offer') {
            //         if(User::is_admin())
            //         {
            //             $user_id = $this->session->userdata['user_id'];
            //             $data['candi_list'] = Offer::approve_candidate($user_id);
            //          //   $data['offer_jobtype'] = $this->_getOfferjob();
            //             print_r($data['candi_list']);
            //         }
            //         else
            //         {
            //             $user_id = $this->session->userdata['user_id'];
            //             $data['candi_list'] = Offer::approve_candidate($user_id);
            //            // $data['offer_jobtype'] = $this->_getOfferjob();
            //         }
            //         exit();
            //     }

        if ($settings == 'menu') {
            $data['iconpicker'] = TRUE;
            $data['sortable'] = TRUE;
            $data['admin'] = $this->db->where('hook','main_menu_admin')-> where('parent','')-> where('access',1)-> order_by('order','ASC')->get('hooks')->result();   
             
            $data['client'] = $this->db->where('hook','main_menu_client')-> where('parent','')-> where('access',2)-> order_by('order','ASC')->get('hooks')->result();
            $data['staff'] = $this->db->where('hook','main_menu_staff')-> where('parent','')-> where('access',3)-> order_by('order','ASC')->get('hooks')->result();
        }
        if ($settings == 'crons') {
            $data['crons'] = $this->db->where('hook','cron_job_admin')-> where('access',1)-> order_by('name','ASC')->get('hooks')->result();
        }
        if($settings == 'general') {
            $data['countries'] = App::countries();
        }
        if($settings == 'setting_salary') {
            $data['salary_setting'] = App::salary_setting();

        }
        if ($settings == 'theme') {
            $data['iconpicker'] = TRUE;
        }
        if ($settings == 'translations') {
            $action = $this->uri->segment(3);
            $data['translation_stats'] = $this->Setting->translation_stats($this->language_files);
            if ($action == 'view') {
                $data['language'] = $this->uri->segment(4);
                $data['language_files'] = $this ->language_files;
            }
            if ($action == 'edit') {
                $language = $this->uri->segment(4);
                $file = $this->uri->segment(5);
                $path = $this->language_files[$file.'_lang.php'];
                $data['language'] = $language;
                $data['english'] = $this->lang->load($file, 'english', TRUE, TRUE, $path);
                if ($language == 'english') {
                    $data['translation'] = $data['english'];
                } else {
                    $data['translation'] = $this->lang->load($file, $language, TRUE, TRUE);
                }
                $data['language_file'] = $file;
            }
        }
        if(User::is_admin()) {
        $user_id = $this->session->userdata['user_id'];
        $data['candi_list'] = Offer::approve_candidate($user_id);
        $data['offer_jobtype'] = Offer::job_where(array('user_id'=>'1'));
        // print_r($data['candi_list']);exit();
        $this->template
            ->set_layout('users')
            ->build('settings',isset($data) ? $data : NULL);
        }
        else
        {
          $this->template
            ->set_layout('users')
            ->build('approval',isset($data) ? $data : NULL);
  
        }
    }

    function vE(){
        Settings::_vP();
    }

    function templates(){
        if ($_POST) {
            Applib::is_demo();
            $group = $this->input->post('email_group',TRUE);
            $data = array('subject' => $this->input->post('subject'),
                'template_body' => $this->input->post('email_template'),
            );
            Setting::update_template($group,$data);

            $return_url = $_POST['return_url'];

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect($return_url);
        }else{
            $this->index();
        }
    }

    function customize(){
        $this->load->helper('file');
        if($_POST){
            $data = $_POST['css-area'];
            if(write_file('./assets/css/style.css', $data)){
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('settings_updated_successfully'));
                redirect('settings/?settings=customize');
            }else{
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('operation_failed'));
                redirect('settings/?settings=customize');
            }
        }else{
            $this->index();
        }
    }

    function add_currency(){
        if ($_POST) {
            if($this->db->where('code',$this->input->post('code'))->get('currencies')->num_rows() == '0'){
                App::save_data('currencies',$this->input->post());
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('currency_added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('currency_code_exists'));
                redirect($_SERVER['HTTP_REFERER']);
            }

        }else{

            $this->load->view('modal_add_currency',isset($data) ? $data : NULL);
        }
    }

    function xrates(){
        if ($_POST) {
            $this->db->where('config_key','xrates_app_id')->update('config', array('value' => $this->input->post('xrates_app_id')));
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->load->view('modal_open_xrates',isset($data) ? $data : NULL);
        }
    }




    function edit_currency($code = NULL){
        if ($_POST) {
            $prev_code = $this->input->post('oldcode');
            unset($_POST['oldcode']);
            $this->db->where('code',$prev_code)->update('currencies',$this->input->post());
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('currency_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);

        }else{
            $data['code'] = $code;
            $this->load->view('modal_edit_currency',isset($data) ? $data : NULL);
        }
    }

    function add_category(){
        if ($_POST) {
            if($this->db->where('cat_name',$this->input->post('cat_name'))->get('categories')->num_rows() == '0'){
                App::save_data('categories',$this->input->post());

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('category_added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('category_exists'));
                redirect($_SERVER['HTTP_REFERER']);
            }

        }else{

            $this->load->view('modal_add_category',isset($data) ? $data : NULL);
        }
    }

    function edit_category($id = NULL){
        if ($_POST) {
            $id = $this->input->post('id');
            switch ($this->input->post('delete_cat')) {
                case 'on':
                    $this->db->where('id',$id)->delete('categories');
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', lang('operation_successful'));
                    break;

                default:
                    unset($_POST['delete_cat']);
                    $this -> db -> where('id',$id)->update('categories',$this->input->post());
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', lang('category_updated_successfully'));

                    break;
            }
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $data['cat'] = $id;
            $this->load->view('modal_edit_category',isset($data) ? $data : NULL);
        }
    }

    function _vP(){
        Applib::pData();
        $data = array('value' => 'TRUE');
        Applib::update('config',array('config_key' => 'valid_license'),$data);
        // Applib::make_flashdata(array(
        //         'response_status' => 'success',
        //         'message' => 'Software validated successfully')
        // );
        $this->session->set_flashdata('tokbox_success', lang('software_validated_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function departments(){
        if ($_POST) {
            $settings = $_POST['settings'];
            unset($_POST['settings']);
            App::save_data('departments',$this->input->post());

            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('department_added_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('department_added_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->index();
        }
    }

        function designations(){
        if ($_POST) {
            $settings = $_POST['settings'];
            unset($_POST['settings']);
            App::save_data('designation',$this->input->post());

            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', 'Designation Added successfully... ');
            $this->session->set_flashdata('tokbox_success', lang('designation_added_successfully'));
        }else{
            $this->index();
        }
    }

    function add_custom_field(){
        if ($_POST) {
            if (isset($_POST['targetdept'])) {
                // select department and redirect to creating field
                // Applib::go_to('settings/?settings=fields&dept='.$_POST['targetdept'],'success','Department selected');
                $this->session->set_flashdata('tokbox_success', lang('department_selected'));
                redirect('settings/?settings=fields&dept='.$_POST['targetdept']);
            }else{
                $_POST['uniqid'] = $this->_GenerateUniqueFieldValue();
                App::save_data('fields',$this->input->post());

                $this->session->set_flashdata('tokbox_success', lang('custom_field_added_successfully'));
                redirect('settings/?settings=fields&dept='.$_POST['deptid']);
                // Applib::go_to('settings/?settings=fields&dept='.$_POST['deptid'],'success','Custom field added');
                // Insert to database additional fields

            }

        }else{

        }
    }

    function edit_custom_field($field = NULL){
        if ($_POST) {
            if(isset($_POST['delete_field']) AND $_POST['delete_field'] == 'on'){
                $this->db->where('id',$_POST['id'])->delete('fields');
                $this->session->set_flashdata('tokbox_error', lang('custom_field_deleted'));
                redirect($_SERVER['HTTP_REFERER']);
                // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('custom_field_deleted'));
            }else{
                $this->db->where('id',$_POST['id'])->update('fields',$this->input->post());
                // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('custom_field_updated'));
                $this->session->set_flashdata('tokbox_success', lang('custom_field_updated'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $data['field_info'] = $this->db->where(array('id'=>$field))->get('fields')->result();
            $this->load->view('fields/modal_edit_field',isset($data) ? $data : NULL);
        }
    }



    function edit_dept($deptid = NULL){
        if ($_POST) {
            if(isset($_POST['delete_dept']) AND $_POST['delete_dept'] == 'on'){
                $this->db->where('deptid',$_POST['deptid']) -> delete('departments');
                // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('department_deleted'));
                $this->session->set_flashdata('tokbox_error', lang('department_deleted'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->where('deptid',$_POST['deptid']) -> update('departments',$this->input->post());
                // Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('department_updated'));
                $this->session->set_flashdata('tokbox_success', lang('department_updated'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $data['deptid'] = $deptid;
            $data['dept_info'] = $this->db ->where(array('deptid'=>$deptid)) -> get('departments') -> result();
            $this->load->view('modal_edit_department',isset($data) ? $data : NULL);
        }
    }


    function translations(){

        $action = $this->uri->segment(3);

        if ($_POST) {
            if ($action == 'save')
            {
                $jpost = array();
                $jsondata = json_decode(html_entity_decode($_POST['json']));
                foreach($jsondata as $jdata) {
                    $jpost[$jdata->name] = $jdata->value;
                }
                $jpost['_path'] = $this->language_files[$jpost['_file'].'_lang.php'];
                $data['json'] = $this->Setting->save_translation($jpost);
                $this->load->view('json',isset($data) ? $data : NULL);
                return;
            }
            if ($action == 'active')
            {
                $language = $this->uri->segment(4);
                return $this->db->where('name',$language)->update('languages',$this->input->post());
            }
        }else{
            if ($action == 'add')
            {
                $language = $this->uri->segment(4);
                $this->Setting->add_translation($language, $this->language_files);
                // $this->session->set_flashdata('response_status', 'success');
                // $this->session->set_flashdata('message', lang('translation_added_successfully'));
                $this->session->set_flashdata('tokbox_success', lang('translation_added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
            if ($action == 'backup')
            {
                $language = $this->uri->segment(4);
                return $this->Setting->backup_translation($language, $this->language_files);
            }
            if ($action == 'restore')
            {
                $language = $this->uri->segment(4);
                return $this->Setting->restore_translation($language, $this->language_files);
            }
            if ($action == 'submit')
            {
                $language = $this->uri->segment(4);
                $path = "./application/language/".$language."/".$language."-backup.json";
                if (!file_exists($path)) {
                    $this->Setting->backup_translation($language, $this->language_files);
                }
                $params['recipient'] = 'dreamguystech@gmail.com';
                $params['subject'] = 'User submitted translation: '.ucwords(str_replace("_"," ", $language));
                $params['message'] = 'The .json language file is attached';
                $params['attached_file'] = $path;
                return modules::run('fomailer/send_email',$params);
            }
            $this->index();
        }
    }

    function available_translations()
    {
        $available = array();
        $ex =  App::languages();
        foreach ($ex as $e) { $existing[] = $e->name; }
        $ln = $this->db->group_by('language')->get('locales')->result();
        foreach ($ln as $l) { if (!in_array($l->language, $existing)) { $available[] = $l; } }
        return $available;

    }

    function update(){
        // print_r($_POST); exit;
        if ($_POST) {
            Applib::is_demo();
            switch ($_POST['settings'])
            {
                case 'general':
                    $this->_update_general_settings($this->general_setting);
                    break;
                case 'email':
                    $this->_update_email_settings();
                    break;
                case 'payments':
                    $this->_update_payment_settings();
                    break;
                case 'setting_salary':
                    $this->_update_salary_settings();
                    break;
                case 'system':
                    $this->_update_system_settings('system');
                    break;
                case 'theme':
                    if(file_exists($_FILES['iconfile']['tmp_name']) || is_uploaded_file($_FILES['iconfile']['tmp_name'])) {
                        $this->upload_favicon($this->input->post());
                    }
                    if(file_exists($_FILES['appleicon']['tmp_name']) || is_uploaded_file($_FILES['appleicon']['tmp_name'])) {
                        $this->upload_appleicon($this->input->post());
                    }
                    if(file_exists($_FILES['logofile']['tmp_name']) || is_uploaded_file($_FILES['logofile']['tmp_name'])) {
                        $this->upload_logo($this->input->post());
                    }
                    $this->_update_theme_settings('theme');
                    break;
                case 'estimate':
                    $this->_update_estimate_settings('estimate');
                    break;
                case 'crons':
                    $this->_update_cron_settings();
                    break;
                case 'invoice':
                    if(file_exists($_FILES['invoicelogo']['tmp_name']) || is_uploaded_file($_FILES['invoicelogo']['tmp_name'])) {
                        $this->upload_invoice_logo($this->input->post());
                    }
                    $this->_update_invoice_settings('invoice');
                    break;
            }

        }else{
            $this->index();
        }
    }

    function _update_general_settings($setting){
        Applib::is_demo();

        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('company_address', 'Company Address', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            redirect('settings/'.$this->general_setting);
        }else{
            $where = array(
                'user_id' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id')
            );
            $res = array(
                'general_settings' => serialize($_POST)
            );

            $check_general = $this->db->get_where('subdomin_general_settings',$where);
            if($check_general->num_rows() == 0)
            {
                $e = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                    'general_settings' => serialize($_POST)
                );
                $this->db->insert('subdomin_general_settings',$e);
            }else{
                $this->db->where($where);
                $this->db->update('subdomin_general_settings',$res);
            }
            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('general_settings_updated_successfully'));
            redirect('settings/'.$this->general_setting);
        }

    }

    function _update_cron_settings(){
        Applib::is_demo();

        $this->form_validation->set_rules('cron_key', 'Cron Key', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->load->library('encrypt');
            $_POST['mail_password'] = $this->encrypt->encode($this->input->post('mail_password'));

            foreach ($_POST as $key => $value) {
                if(strtolower($value) == 'on') {
                    $value = 'TRUE';
                } elseif(strtolower($value) == 'off') {
                    $value = 'FALSE';
                }
                $data = array('value' => $value);

                $this->db->where('config_key', $key)->update('config', $data);
            }
            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('cron_settings_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function project_settings(){
        
        $data = array('value' => json_encode($_POST));
        $this->db->where('config_key', 'default_project_settings')->update('config', $data);
        // $this->session->set_flashdata('response_status', 'success');
        // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
        $this->session->set_flashdata('tokbox_success', lang('project_settings_updated_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function slack_conf(){
        foreach ($_POST as $key => $value) {
            if(strtolower($value) == 'on') {
                $value = 'TRUE';
            } elseif(strtolower($value) == 'off') {
                $value = 'FALSE';
            }
            $data = array('value' => $value);
            $this->db->where('config_key', $key)->update('config', $data);
        }
        $this->session->set_flashdata('tokbox_success', lang('slack_config_updated_successfully'));
        // $this->session->set_flashdata('response_status', 'success');
        // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function _update_system_settings($setting){
        Applib::is_demo();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('file_max_size', 'File Max Size', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // echo "string";die;
            // $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', validation_errors());
            // $this->session->set_flashdata('form_error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            foreach ($_POST as $key => $value) {
                if(strtolower($value) == 'on') {
                    $value = 'TRUE';
                } elseif(strtolower($value) == 'off') {
                    $value = 'FALSE';
                }
                $_POST[$key] = $value;
                // $this->db->where('config_key', $key)->update('config', $data);
            }

            // //Set date format for date picker
            // switch($_POST['date_format']) {
            //     case "%d-%m-%Y": $picker = "dd-mm-yyyy"; $phptime = "d-m-Y"; break;
            //     case "%m-%d-%Y": $picker = "mm-dd-yyyy"; $phptime = "m-d-Y"; break;
            //     case "%Y-%m-%d": $picker = "yyyy-mm-dd"; $phptime = "Y-m-d"; break;
            //     case "%d.%m.%Y": $picker = "dd.mm.yyyy"; $phptime = "d.m.Y"; break;
            //     case "%m.%d.%Y": $picker = "mm.dd.yyyy"; $phptime = "m.d.Y"; break;
            //     case "%Y.%m.%d": $picker = "yyyy.mm.dd"; $phptime = "Y.m.d"; break;
            // }
            // $this->db->where('config_key', 'date_picker_format')->update('config', array("value" => $picker));
            // $this->db->where('config_key', 'date_php_format')->update('config', array("value" => $phptime));

            $where = array(
                'user_id' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id')
            );
            $res = array(
                'system_settings' => base64_encode(serialize($_POST))
            );
            $check_system = $this->db->get_where('subdomin_system_settings',$where);
            if($check_system->num_rows() == 0)
            {
                $e = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                    'system_settings' => base64_encode(serialize($_POST))
                );
                // echo "<pre>";print_r($e);die;
                $this->db->insert('subdomin_system_settings',$e);
            }else{
                $this->db->where($where);
                $this->db->update('subdomin_system_settings',$res);
            }

            $this->session->set_flashdata('tokbox_success', lang('system_settings_updated_successfully'));
            redirect('settings/'.$this->system_setting);
        }

    }

    function _update_theme_settings($setting){
        Applib::is_demo();
        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'subdomain_id' => $this->session->userdata('subdomain_id')
        );
        $res = array(
            'theme_settings' => serialize($_POST)
        );
        $check_theme = $this->db->get_where('subdomin_theme_settings',$where);
        if($check_theme->num_rows() == 0)
        {
            $e = array(
                'user_id' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id'),
                'theme_settings' => serialize($_POST)
            );
            $this->db->insert('subdomin_theme_settings',$e);
        }else{
            $this->db->where($where);
            $this->db->update('subdomin_theme_settings',$res);
        }
        $this->session->set_flashdata('tokbox_success', lang('theme_settings_updated_successfully'));
        // $this->session->set_flashdata('response_status', 'success');
        // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
        redirect('settings/'.$this->theme_setting);
    }

    function _update_invoice_settings($setting){
        Applib::is_demo();

        $this->form_validation->set_rules('invoice_color', 'Invoice Color', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            redirect('settings/'.$this->invoice_setting);
        }else{
            foreach ($_POST as $key => $value) {
                if(strtolower($value) == 'on') {
                    $value = 'TRUE';
                } elseif(strtolower($value) == 'off') {
                    $value = 'FALSE';
                }
                if ($key == 'invoice_logo_height' && $this->invoice_logo_height > 0) { $value = $this->invoice_logo_height; }
                if ($key == 'invoice_logo_width' && $this->invoice_logo_width > 0) { $value = $this->invoice_logo_width; }
                $_POST[$key] = $value;
                // $data = array('value' => $value);
                // $this->db->where('config_key', $key)->update('config', $data);
            }
            // echo "<pre>";print_r($_POST);die;
            $where = array(
                'user_id' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id')
            );
            // echo "<pre>";print_r($_POST);die;
            $check_theme = $this->db->get_where('subdomin_invoice_settings',$where);
            $logo_details = $this->db->get_where('subdomin_invoice_settings',$where)->row_array();
            // echo "<pre>";print_r($logo_details);die;
            if(!isset($_POST['invoice_logo']) || $_POST['invoice_logo'] == ''){
                $logo_details = unserialize($logo_details['invoice_settings']);
                $_POST['invoice_logo'] = $logo_details['invoice_logo']?$logo_details['invoice_logo']:'';
                $_POST['invoice_logo_height'] = $logo_details['invoice_logo_height']?$logo_details['invoice_logo_height']:'';
                $_POST['invoice_logo_width'] = $logo_details['invoice_logo_width']?$logo_details['invoice_logo_width']:'';
            }
            // echo "<pre>";print_r($_POST);die;
            $res = array(
                'invoice_settings' => serialize($_POST)
            );
            if($check_theme->num_rows() == 0)
            {
                $e = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                    'invoice_settings' => serialize($_POST)
                );
                $this->db->insert('subdomin_invoice_settings',$e);
            }else{
                $this->db->where($where);
                $this->db->update('subdomin_invoice_settings',$res);
            }
            $this->session->set_flashdata('tokbox_success', lang('invoice_settings_updated_successfully'));
            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('settings/'.$this->invoice_setting);
        }

    }

    function _update_estimate_settings($setting){
        Applib::is_demo();
        $this->form_validation->set_rules('estimate_color', 'Estimate Color', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            redirect('settings/'.$this->estimate_setting);
        }else{

            foreach ($_POST as $key => $value) {
                if(strtolower($value) == 'on') {
                    $value = 'TRUE';
                } elseif(strtolower($value) == 'off') {
                    $value = 'FALSE';
                }
                 $_POST[$key] = $value;
                // $data = array('value' => $value);
                // $this->db->where('config_key', $key)->update('config', $data);
            }
            // echo "<pre>";print_r($_POST);die;
            $where = array(
                'user_id' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id')
            );
            $res = array(
                'estimate_settings' => serialize($_POST)
            );
            $check_theme = $this->db->get_where('subdomin_estimate_settings',$where);
            if($check_theme->num_rows() == 0)
            {
                $e = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                    'estimate_settings' => serialize($_POST)
                );
                $this->db->insert('subdomin_estimate_settings',$e);
            }else{
                $this->db->where($where);
                $this->db->update('subdomin_estimate_settings',$res);
            }
            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('estimate_settings_updated_successfully'));
            redirect('settings/'.$this->estimate_setting);
        }

    }

    function _update_email_settings(){
        Applib::is_demo();

        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('settings', 'Settings', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('form_error', validation_errors());
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            // $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }else{

            $where = array(
                'user_id' => $this->session->userdata('user_id'),
                'subdomain_id' => $this->session->userdata('subdomain_id')
            );
            $res = array(
                'email_settings' => serialize($_POST)
            );
            $check_system = $this->db->get_where('subdomin_email_settings',$where);
            if($check_system->num_rows() == 0)
            {
                $e = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                    'email_settings' => serialize($_POST)
                );
                $this->db->insert('subdomin_email_settings',$e);
            }else{
                $this->db->where($where);
                $this->db->update('subdomin_email_settings',$res);
            }


            $this->session->set_flashdata('tokbox_success', lang('email_settings_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }

    }
    function _update_salary_settings(){

        if ($this->input->post()) {
            Applib::is_demo();


            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('salary_da', 'Salary DA', 'required');
            $this->form_validation->set_rules('salary_hra', 'Salary HRA', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('form_error', validation_errors());
                // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                
                unset($_POST['settings']);
                
                foreach ($_POST as $key => $value) {                    
                    $data = array('config_key' => $key);
                               $this->db->where($data); 
                      $count = $this->db->count_all_results('config');
                      
                    if($count == 0){
                        $data['value'] = $value;
                        $this->db->insert('config', $data);
                    }else{
                        $data['value'] = $value;
                        $this->db->where('config_key', $key)->update('config', $data);
                    }
                }


                // $this->session->set_flashdata('response_status', 'success');
                // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
                $this->session->set_flashdata('tokbox_success', lang('salary_settings_updated_successfully'));
                redirect('payroll/settings');
            }
        }else{
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            redirect('payroll/settings');
        }

       
    }
    function _update_payment_settings(){
        if ($this->input->post()) {
            Applib::is_demo();


            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('paypal_email', 'Paypal Email', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('form_error', validation_errors());
                // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{

                foreach ($_POST as $key => $value) {
                    if(strtolower($value) == 'on') {
                        $value = 'TRUE';
                    } elseif(strtolower($value) == 'off') {
                        $value = 'FALSE';
                    }
                    $_POST[$key] = $value;
                    // $data = array('value' => $value);
                    // $this->db->where('config_key', $key)->update('config', $data);
                }

                $where = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id')
                );
                $res = array(
                    'payment_settings' => serialize($_POST)
                );
                $check_system = $this->db->get_where('subdomin_payment_settings',$where);
                if($check_system->num_rows() == 0)
                {
                    $e = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                        'payment_settings' => serialize($_POST)
                    );
                    $this->db->insert('subdomin_payment_settings',$e);
                }else{
                    $this->db->where($where);
                    $this->db->update('subdomin_payment_settings',$res);
                }

                // $this->session->set_flashdata('response_status', 'success');
                // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
                $this->session->set_flashdata('tokbox_success', lang('payment_settings_updated_successfully'));
                redirect('settings/?settings=payments');
            }
        }else{
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            redirect('settings/?settings=payments');
        }

    }

    function update_email_templates(){
        if ($this->input->post()) {
            Applib::is_demo();

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('email_estimate_message', 'Estimate Message', 'required');
            $this->form_validation->set_rules('email_invoice_message', 'Invoice Message', 'required');
            $this->form_validation->set_rules('reminder_message', 'Reminder Message', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
                $_POST = '';
                $this->update('email');
            }else{
                foreach ($_POST as $key => $value) {
                    $data = array('value' => $value);
                    $this->db->where('config_key', $key)->update('config', $data);
                }

                // $this->session->set_flashdata('response_status', 'success');
                // $this->session->set_flashdata('message', lang('settings_updated_successfully'));
                $this->session->set_flashdata('tokbox_success', lang('email_settings_updated_successfully'));
                redirect('settings/update/email');
            }
        }else{
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('tokbox_error', lang('settings_update_failed'));
            redirect('settings/update/email');
        }

    }

    function upload_favicon($files){
        Applib::is_demo();

        if ($files) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = '*';
            $config['max_width']  = '300';
            $config['max_height']  = '300';
            $config['overwrite']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('iconfile'))
            {
                $data = $this->upload->data();
                $file_name = $data['file_name'];
                $where = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id')
                );
                $res = array(
                    'fav_icon' => $file_name
                );
                $check_favicon = $this->db->get_where('subdomin_favicon_settings',$where);
                if($check_favicon->num_rows() == 0)
                {
                    $e = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                        'fav_icon' => $file_name
                        );
                    $this->db->insert('subdomin_favicon_settings',$e);
                    return TRUE;
                }else{
                    $this->db->where($where);
                    $this->db->update('subdomin_favicon_settings',$res);
                    return TRUE;
                }
            }else{
                $this->session->set_flashdata('tokbox_error', lang('logo_upload_error'));
                redirect('settings/'.$this->theme_setting);
            }
        }else{
            return FALSE;
        }
    }

    function upload_appleicon($files){
        Applib::is_demo();        
        if ($files) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['overwrite']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('appleicon'))
            {
                $data = $this->upload->data();
                $file_name = $data['file_name'];
                $where = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id')
                );
                $res = array(
                    'appleicon' => $file_name
                );
                $check_favicon = $this->db->get_where('subdomin_appleicon_settings',$where);
                if($check_favicon->num_rows() == 0)
                {
                    $e = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                        'appleicon' => $file_name
                        );
                    $this->db->insert('subdomin_appleicon_settings',$e);
                    return TRUE;
                }else{
                    $this->db->where($where);
                    $this->db->update('subdomin_appleicon_settings',$res);
                    return TRUE;
                }
            }else{
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('message', lang('logo_upload_error'));
                echo $this->upload->display_errors();die;
                $this->session->set_flashdata('tokbox_error', lang('logo_upload_error'));
                redirect('settings/'.$this->theme_setting);
            }
        }else{
            return FALSE;
        }
    }

    function upload_logo($files){
        Applib::is_demo();

        if ($files) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = TRUE;

            $config['overwrite']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('logofile'))
            {
                $filedata = $this->upload->data();
                $file_name = $filedata['file_name'];
                $where = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id')
                );
                $res = array(
                    'company_logo' => $file_name
                );
                $check_favicon = $this->db->get_where('subdomin_logo_settings',$where);
                if($check_favicon->num_rows() == 0)
                {
                    $e = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                        'company_logo' => $file_name
                        );
                    $this->db->insert('subdomin_logo_settings',$e);
                    return TRUE;
                }else{
                    $this->db->where($where);
                    $this->db->update('subdomin_logo_settings',$res);
                    return TRUE;
                }
            }else{
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('message', lang('logo_upload_error'));
                $this->session->set_flashdata('tokbox_error', lang('logo_upload_error'));
                redirect('settings/'.$this->theme_setting);
            }
        }else{
            return FALSE;
        }
    }

    function upload_loginlogo($files){
        Applib::is_demo();

        if ($files) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;

            $config['overwrite']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('loginlogo'))
            {
                $filedata = $this->upload->data();
                $file_name = $filedata['file_name'];
                $where = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'subdomain_id' => $this->session->userdata('subdomain_id')
                );
                $res = array(
                    'login_logo' => $file_name
                );
                $check_favicon = $this->db->get_where('subdomin_loginlogo_settings',$where);
                if($check_favicon->num_rows() == 0)
                {
                    $e = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                        'login_logo' => $file_name
                        );
                    $this->db->insert('subdomin_loginlogo_settings',$e);
                    return TRUE;
                }else{
                    $this->db->where($where);
                    $this->db->update('subdomin_loginlogo_settings',$res);
                    return TRUE;
                }
            }else{
                $this->session->set_flashdata('tokbox_error', lang('logo_upload_error'));
                redirect('settings/'.$this->theme_setting);
            }
        }else{
            return FALSE;
        }
    }

    function upload_invoice_logo($files){
        Applib::is_demo();

        if ($files) {
            $config['upload_path']   = './assets/images/logos/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_width']  = '800';
            $config['max_height']  = '300';
            $config['remove_spaces'] = TRUE;
            $config['overwrite']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('invoicelogo'))
            {
                $filedata = $this->upload->data();
                $file_name = $filedata['file_name'];
                $size = getimagesize ('./assets/images/logos/'.$file_name);
                $ratio = $size[1] / $size[0];
                $height = 60;
                if ($size[1] < $height) { $height = $size[1]; }
                $width = intval($height / $ratio);
                $this->invoice_logo_height = $height;
                $this->invoice_logo_width = $width;

                $_POST['invoice_logo'] = $file_name;
                $_POST['invoice_logo_height'] = $height;
                $_POST['invoice_logo_width'] = $width;
                // $this->db->where('config_key', 'invoice_logo')->update('config', array('value' => $file_name));
                return TRUE;
            }else{
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('message', lang('logo_upload_error'));
                $this->session->set_flashdata('tokbox_error', lang('logo_upload_error'));
                redirect('settings/'.$this->invoice_setting);
            }
        }else{
            return FALSE;
        }
    }


    function _GenerateUniqueFieldValue()
    {
        $uniqid = uniqid('f');
        // Id should start with an character other than digit

        $this->db->where('uniqid', $uniqid)->get('fields');

        if ($this->db->affected_rows() > 0)
        {
            $this->GetUniqueFieldValue();
            // Recursion
        }
        else
        {
            return $uniqid;
        }

    }

    function database()
    {
        Applib::is_demo();
        $this->load->helper('file');
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'zip',             // gzip, zip, txt
            'filename'    => 'database-full-backup_'.date('Y-m-d').'.zip',
            'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
            'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
            'newline'     => "\n"               // Newline character used in backup file
        );
        $backup =& $this->dbutil->backup($prefs);

        if ( ! write_file('./assets/backup/database-full-backup_'.date('Y-m-d').'.zip', $backup))
        {
            // $this->session->set_flashdata('response_status', 'error');
            // $this->session->set_flashdata('message', 'The assets/backup folder is not writable.');
            $this->session->set_flashdata('tokbox_error', lang('asset_folder_not_writable'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->helper('download');
        force_download('database-full-backup_'.date('Y-m-d').'.zip', $backup);


    }

    function hook($action, $item)
    {
        switch ($action) {
            case "visible":
                $role = $this->input->post('access');
                $visible = $this->input->post('visible');
                return $this->db->where('module',$item)->where('access',$role)->update('hooks', array('visible' => $visible));
            case "enabled":
                $role = $this->input->post('access');
                $enabled = $this->input->post('enabled');
                return $this->db->where('module',$item)->where('access',$role)->update('hooks', array('enabled' => $enabled));
            case "icon":
                $role = $this->input->post('access');
                $icon = $this->input->post('icon');
                return $this->db->where('module',$item)->where('access',$role)->update('hooks', array('icon' => $icon));
            case "reorder":
                $items = $this->input->post('json', TRUE);
                $items = json_decode($items);
                foreach ($items[0] as $i => $mod) {
                    $this->db->where('module',$mod->module)->where('access',$mod->access)->update('hooks', array('order' => $i+1));
                }
                return TRUE;
        }
        return false;
    }
    function leave_types(){
        if ($this->input->post()) {
            
            $tbl_id               = $this->input->post('leave_type_tbl_id');
            $det['leave_type']    = $this->input->post('leave_type'); 
            $det['leave_days']    = $this->input->post('leave_days'); 
            if($tbl_id == ''){
                $this->db->insert('dgt_leave_types',$det);
                $this->session->set_flashdata('tokbox_success', lang('leave_type_added_successfully'));
            }else{ 
                $this->db->update('dgt_leave_types',$det,array('id'=>$tbl_id));
            $this->session->set_flashdata('tokbox_success', 'leave_type_updated_successfully');
            } 
            redirect('settings/?settings=leaves');
        }
    }
    function delete_leave_types(){
        if ($this->input->post()) {
            $det['status']   = 1;
            $this->db->update('dgt_leave_types',$det,array('id'=>$this->input->post('leave_type_id'))); 
            $this->session->set_flashdata('tokbox_error', lang('leave_type_deleted_successfully'));
            redirect('settings/?settings=leaves');
        }else{
            $data['leave_type_id'] = $this->uri->segment(3);
            $this->load->view('modal/delete_leave_type',$data);
        } 
    }
    
    
    function lead_reporter_add()
    {
        if($_POST){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('reporter_name', 'Reporter Name', 'required');
            $this->form_validation->set_rules('reporter_email', 'Reporter Email', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('form_error', validation_errors());
                // $this->session->set_flashdata('message', lang('settings_update_failed'));
                $this->session->set_flashdata('tokbox_error', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $res = array(
                    'reporter_name' => $this->input->post('reporter_name'),
                    'reporter_email' => $this->input->post('reporter_email')
                );
                $this->db->insert('dgt_lead_reporter',$res);
                // $this->session->set_flashdata('lead_reporter_add', 'success');
                $this->session->set_flashdata('tokbox_success', lang('leader_reporter_added_successfully'));
                redirect('settings/?settings=lead_reporter');
            }
        }else{
            $this->load->view('modal/add_reporter');
        }
    }

    function lead_reporter_edit($r_id)
    {
        if($_POST){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('reporter_name', 'Reporter Name', 'required');
            $this->form_validation->set_rules('reporter_email', 'Reporter Email', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                // $this->session->set_flashdata('response_status', 'error');
                // $this->session->set_flashdata('form_error', validation_errors());
                // $this->session->set_flashdata('message', lang('settings_update_failed'));
                $this->session->set_flashdata('tokbox_error', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $res = array(
                    'reporter_name' => $this->input->post('reporter_name'),
                    'reporter_email' => $this->input->post('reporter_email')
                );
                $this->db->where('reporter_id',$r_id);
                $this->db->update('dgt_lead_reporter',$res);
                // $this->session->set_flashdata('lead_reporter_edit', 'success');
                $this->session->set_flashdata('tokbox_success', lang('lead_reporter_updated_successfully'));
                redirect('settings/?settings=lead_reporter');
            }
        }else{

        $data['reporter_details'] = $this->Setting->GetReporterById($r_id);
        // echo "<pre>"; print_r($reporter_details); exit;
        $this->load->view('modal/edit_reporter',$data);
    }
    }

    function lead_reporter_delete($r_id)
    {
        if($_POST){
            $this->db->where('reporter_id',$r_id);
            $this->db->delete('dgt_lead_reporter');
                $this->session->set_flashdata('tokbox_error', lang('lead_reporter_deleted_successfully'));
            // $this->session->set_flashdata('lead_reporter_delete', 'success');
            redirect('settings/?settings=lead_reporter');
        }else{
            $data['r_id'] = $r_id;
            $this->load->view('modal/delete_reporter',$data);
        }
    }

    public function check_reporter_mail(){
        $user_email = $this->input->post('user_email');
        $check_email_exist = $this->db->get_where('dgt_users',array('email'=>$user_email))->num_rows();
        if($check_email_exist == 0)
        {
            echo "new";
            exit;
        }else{
            echo "exists";
            exit;
        }
    }

    function new_role()
    {
        $this->load->view('modal/new_role');
    }

    function tokbox_settings()
    {
        $this->db->where('config_key', 'apikey_tokbox')->update('config', array('value' => $this->input->post('apikey_tokbox')));
        $this->db->where('config_key', 'apisecret_tokbox')->update('config', array('value' => $this->input->post('apisecret_tokbox')));
        $this->session->set_flashdata('tokbox_success', lang('tokbox_settings_updated_successfully'));
        redirect('settings/?settings=tokbox_settings');
        // $where = array(
        //     'user_id' => $this->session->userdata('user_id'),
        //     'subdomain_id' => $this->session->userdata('subdomain_id')
        // );
        // $res = array(
        //     'tokbox_settings' => serialize($_POST)
        // );
        // $check_tokbox = $this->db->get_where('subdomin_tokbox_settings',$where);
        // if($check_tokbox->num_rows() == 0)
        // {
        //     $e = array(
        //         'user_id' => $this->session->userdata('user_id'),
        //         'subdomain_id' => $this->session->userdata('subdomain_id'),
        //         'tokbox_settings' => serialize($_POST)
        //     );
        //     $this->db->insert('subdomin_tokbox_settings',$e);
        // }else{
        //     $this->db->where($where);
        //     $this->db->update('subdomin_tokbox_settings',$res);
        // }
        // $this->session->set_flashdata('tokbox_success', 'TokBox Settings Update Successfully');
        // redirect('settings/?settings=tokbox_settings');
    } 

    function offer_approval_settings()
    {
        // echo "<pre>";print_r($this->input->post());exit;
        if ($this->input->post()) {
             $this->db->where('id !=', 0);
            $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
            $this->db->delete('offer_approver_settings');

             $approvers_details = array(
                                'default_offer_approval' => $this->input->post('default_offer_approval'),
                                'created_by'=>$this->session->userdata('user_id'),
                                'subdomain_id' =>$this->session->userdata('subdomain_id')
                                );//print_r($approvers_details);exit;
            $offer_approver_settings_id = Offer::save_offer_approver_settings($approvers_details);
            
                            $args = array(
                        'user' => User::get_id(),
                        'module' => 'settings',
                        'module_field_id' => $offer_approver_settings_id,
                        'activity' => 'offer_approval_settings',
                        'icon' => 'fa-user',
                        'value1' => $this->input->post('default_offer_approval', true),
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);
            $this->session->set_flashdata('tokbox_success', lang('offer_approvers_added_successfully'));
            redirect('settings/?settings=approval&key=offer_approval');
        } else{
            $this->session->set_flashdata('tokbox_error', lang('please_select_approvers'));
            redirect('settings/?settings=approval&key=offer_approval');
        }
    }
    //  function offer_approval_settings()
    // {
    //    // echo "<pre>";print_r($this->input->post());exit;
    //     if ($this->input->post()) {
    //         $this->db->where('id !=', 0);
    //         $this->db->delete('offer_approver_settings');
    //        if ($this->input->post('default_offer_approval') == 'seq-approver') {
    //          $offer_approvers = $this->input->post('offer_approvers');
    //        } else{
    //             $offer_approvers = $this->input->post('offer_approvers_sim');
    //         }
    //                 if (count($offer_approvers) > 0) {
    //                     foreach ($offer_approvers as $key => $value) {
    //                         if(!empty($value)){
    //                             $approvers_details = array(
    //                             'approvers' => $value,
    //                             'default_offer_approval' => $this->input->post('default_offer_approval'),
    //                             'created_by'=>$this->session->userdata('user_id'),
    //                             //'lt_incentive_plan' => ($this->input->post('long_term_incentive_plan')?1:0),

    //                             );//print_r($approvers_details);exit;
    //                         Offer::save_offer_approver_settings($approvers_details);
    //                         }
                            
    //                     }
    //                 }
    //         $this->session->set_flashdata('tokbox_success', lang('offer_approvers_added_successfully'));
    //         redirect('settings/?settings=offer_approval_settings');
    //     } else{
    //         $this->session->set_flashdata('tokbox_error', 'Please select approvers');
    //         redirect('settings/?settings=offer_approval_settings');
    //     }
    // }
    public function get_designation()
    {
         $designations = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by('designation','ASC')->get('designation')->result();

        

         $data=array();
            foreach($designations as $r)
            {
                $data['value']=$r->id;
                // $data['label']=ucfirst($r->username);
                $data['label']=ucfirst($r->designation);
                $json[]=$data;
                
                
            }
        echo json_encode($json);
        exit;
    }
    function leave_approval_settings()
    {
        // echo "<pre>";print_r($this->input->post());exit;
        if ($this->input->post()) {
            $this->db->where('id !=', 0);
            $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
            $this->db->delete('leave_approver_settings');

             if ($this->input->post('default_leave_approval') == 'seq-approver') {
             $leave_approvers = $this->input->post('leave_approvers');
            } else{
                $leave_approvers = $this->input->post('leave_approvers_sim');
            }
            if (count($leave_approvers) > 0) {
                foreach ($leave_approvers as $key => $value) {
                    if(!empty($value)){
                        $approvers_details = array(
                        'approvers' => $value,
                        'default_leave_approval' => $this->input->post('default_leave_approval'),
                        'created_by'=>$this->session->userdata('user_id'),
                        'subdomain_id'=>$this->session->userdata('subdomain_id')
                        //'lt_incentive_plan' => ($this->input->post('long_term_incentive_plan')?1:0),

                        );//print_r($approvers_details);exit;
                     $leave_approver_settings_id = $this->settings_model->save_leave_approver_settings($approvers_details);
                   
                     $args = array(
                'user' => $value,
                'module' => 'settings',
                'module_field_id' => $leave_approver_settings_id,
                'activity' => 'Leave approval settings',
                'icon' => 'fa-user',
                'value1' => $this->input->post('default_leave_approval', true),
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
            );
            App::Log($args);
                    }
                    
                }
            }
             $args = array(
                'user' => User::get_id(),
                'module' => 'settings',
                'module_field_id' => $leave_approver_settings_id,
                'activity' => 'Leave approval settings',
                'icon' => 'fa-user',
                'value1' => $this->input->post('default_leave_approval', true),
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
            );
            App::Log($args);
            // $approvers_details = array(
            //                     'default_leave_approval' => $this->input->post('default_leave_approval'),
            //                     'created_by'=>$this->session->userdata('user_id')
            //                     );
            // $leave_approver_settings_id = $this->settings_model->save_leave_approver_settings($approvers_details);

            // $args = array(
            //             'user' => User::get_id(),
            //             'module' => 'settings',
            //             'module_field_id' => $leave_approver_settings_id,
            //             'activity' => 'Leave approval settings',
            //             'icon' => 'fa-user',
            //             'value1' => $this->input->post('default_leave_approval', true),
            // 'subdomain_id' =>$this->session->userdata('subdomain_id'),
            //         );
            // App::Log($args);
           
            $this->session->set_flashdata('tokbox_success', lang('leave_approvers_added_successfully'));
            redirect('settings/?settings=approval&key=leave_approval');
        } else{
            $this->session->set_flashdata('tokbox_error', lang('please_select_approval'));
            redirect('settings/?settings=approval&key=leave_approval');
        }
    }
    function expense_approval_settings()
    {
         // echo "<pre>";print_r($this->input->post());exit;
        if ($this->input->post()) {
            $this->db->where('id !=', 0);
            $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
            $this->db->delete('expense_approver_settings');
            //  $approvers_details = array(
            //                     'default_expense_approval' => $this->input->post('default_expense_approval'),
            //                     'created_by'=>$this->session->userdata('user_id')
            //                     );
            // $expense_approver_settings_id = $this->settings_model->save_expense_approver_settings($approvers_details);


            if ($this->input->post('default_expense_approval') == 'seq-approver') {
             $expense_approvers = $this->input->post('expense_approvers');
            } else{
                $expense_approvers = $this->input->post('expense_approvers_sim');
            }
            if (count($expense_approvers) > 0) {
                foreach ($expense_approvers as $key => $value) {
                    if(!empty($value)){
                        $approvers_details = array(
                        'approvers' => $value,
                        'default_expense_approval' => $this->input->post('default_expense_approval'),
                        'created_by'=>$this->session->userdata('user_id'),
                        'subdomain_id'=>$this->session->userdata('subdomain_id')
                        //'lt_incentive_plan' => ($this->input->post('long_term_incentive_plan')?1:0),

                        );//print_r($approvers_details);exit;
                     $expense_approver_settings_id = $this->settings_model->save_expense_approver_settings($approvers_details);
                   
                     $args = array(
                'user' => User::get_id(),
                'module' => 'settings',
                'module_field_id' => $expense_approver_settings_id,
                'activity' => 'Expense approval settings',
                'icon' => 'fa-user',
                'value1' => $this->input->post('default_expense_approval', true),
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
            );
            App::Log($args);
                    }
                    
                }
            }

            
            $args = array(
                'user' => $value,
                'module' => 'settings',
                'module_field_id' => $expense_approver_settings_id,
                'activity' => 'Expense approval settings',
                'icon' => 'fa-user',
                'value1' => $this->input->post('default_expense_approval', true),
                'subdomain_id' =>$this->session->userdata('subdomain_id'),
            );
            App::Log($args);
           
            $this->session->set_flashdata('tokbox_success', lang('expense_approvers_added_successfully'));
            redirect('settings/?settings=approval&key=expense_approval');
        } else{
            $this->session->set_flashdata('tokbox_error', lang('please_select_approval'));
            redirect('settings/?settings=approval&key=expense_approval');
        }
    }
    function update_weekend()
    {
        $days = $this->input->post('days');
        if(!empty($days)){
                $weekend_days = implode(',', $days);   
        } else {
            $weekend_days ='';
        }
        $res =array(
            'days' => $weekend_days
            );
        $this->db->where('id',1);
        $this->db->update('leave_weekend',$res);
        echo $this->db->last_query(); exit;
    }
    function new_menu_role()
    {
        if(!$_POST){
            $data['page'] = lang('settings');
            $data['form'] = TRUE;
            $data['editor'] = TRUE;
            $data['fuelux'] = TRUE;
            $data['datatables'] = TRUE;
            $data['nouislider'] = TRUE;
            $data['postmark_config'] = TRUE;
            $data['translations'] = $this->applib->translations();
            $data['available'] = $this->available_translations();
            $data['languages'] = App::languages();
            $data['load_setting'] = $settings;
            $data['locale_name'] = App::get_locale()->name;
            $data['iconpicker'] = TRUE;
            $data['sortable'] = TRUE;
            $this->template
                ->set_layout('users')
                ->build('new_menu',isset($data) ? $data : NULL);
        }else{

            $role_name = $this->input->post('role_name');
            $checkp_role = $this->db->get_where('roles',array('role'=>$role_name,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
            if(count($checkp_role) != 0){
                $this->session->set_flashdata('tokbox_error', 'Role Already Exists');
                redirect('settings/new_menu_role');
            }
            $role = str_replace(' ','_',$role_name);
            $check_role = $this->db->get_where('roles',array('role'=>strtolower($role),'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();
            $this->db->order_by('r_id',DESC);
            $last_role = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->get('roles')->row_array();
            $get_id_code = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by('id_code',DESC)->get('roles')->row()->id_code;
            $id_code = $get_id_code +1;
            if(count($check_role) == 0 )
            {
                $role_ar = array(
                    'role'    => strtolower($role),
                    'default' => ($last_role['default'] + 1),
                    'id_code' => $id_code,
                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                    'permissions' => '{"settings":"permissions","role":"'.strtolower($role).'","view_all_invoices":"on","edit_invoices":"on","pay_invoice_offline":"on","view_all_payments":"on","email_invoices":"on","send_email_reminders":"on"}'
                );
                // echo "<pre>"; print_r($role_ar); exit;
                // Role Insert...

                $this->db->insert('roles',$role_ar);
                $insert_id = $this->db->insert_id();

                // Menu Added based on Role....

                $all_menus = $this->input->post('role_menu_to');

                 // Subdomain...

                $domain = $this->session->userdata('domain');
                $arr = explode('.', $domain); 
                  
                // Get the first element of array 
                $subdomain = $arr[0];

                $e = 1;
                for($i=0;$i<count($all_menus);$i++)
                {
                    $get_menu_details = $this->db->get_where('hooks',array('hook'=>'main_menu_admin','name'=>$all_menus[$i]))->row_array();
                    if($get_menu_details['parent'] != ''){

                        $get_parent_details = $this->db->get_where('hooks',array('hook'=>'main_menu_admin','module'=>$get_menu_details['parent']))->row_array();
                        $check_count = $this->db->get_where('hooks',array('hook'=>'main_menu_'.strtolower($role),'module'=>$get_parent_details['module']))->result_array();
                        if(count($check_count) == 0 )
                        {
                            $ress = array(
                                'module' => $get_parent_details['module'],
                                'parent' => $get_parent_details['parent'],
                                'hook' => 'main_menu_'.$subdomain.'_'.strtolower($role),
                                'icon' => $get_parent_details['icon'],
                                'name' => $get_parent_details['name'],
                                'route' => $get_parent_details['route'],
                                'order' => $get_parent_details['order'],
                                'access' => $insert_id,
                                'core' => $get_parent_details['core'],
                                'visible' => $get_parent_details['visible'],
                                'permission' => $get_parent_details['permission'],
                                'enabled' => $get_parent_details['enabled']
                            );
                            $this->db->insert('hooks',$ress);
                            $e = ($e + 1);
                        }
                    }
                    $res = array(
                        'module' => $get_menu_details['module'],
                        'parent' => $get_menu_details['parent'],
                        'hook' => 'main_menu_'.$subdomain.'_'.strtolower($role),
                        'icon' => $get_menu_details['icon'],
                        'name' => $get_menu_details['name'],
                        'route' => $get_menu_details['route'],
                        'order' =>$get_menu_details['order'],
                        'access' => $insert_id,
                        'core' => $get_menu_details['core'],
                        'visible' => $get_menu_details['visible'],
                        'permission' => $get_menu_details['permission'],
                        'enabled' => $get_menu_details['enabled']
                    );
                        $this->db->insert('hooks',$res);
                        $e++;
                }
                $this->session->set_flashdata('tokbox_success', lang('role_added_successfully'));
                redirect('settings/?settings=menu');
            }else{
                $this->session->set_flashdata('tokbox_error', lang('role_already_exists'));
                redirect('settings/new_menu_role');
            }
        }
    }


    function getMenu_role()
    {
        $role = $this->input->post('role');
        $all_menus = $this->db->get_where('hooks',array('hook'=>'main_menu_'.$role,'enabled'=>1,'route !='=>'#'))->result_array();
        echo json_encode($all_menus); exit;
    }

    public function get_approvers()
    {
        $approvers = User::team();

        

         $data=array();
            foreach($approvers as $r)
            {
                $data['value']=$r->id;
                $data['label']=ucfirst($r->username);
                $json[]=$data;
                
                
            }
        echo json_encode($json);
        exit;
    }

    public function create_expense()
    {

        $data = array(
        'reports_to' => $this->input->post('reports_to'),
        'default_expense_approval' => $this->input->post('default_expense_approval'),
        'expense_approvers' => serialize($this->input->post('expense_approvers')),
        'message_to_approvers' => $this->input->post('message_to_approvers')

        );

        $result = $this->db->insert('expense_approvers',$data);
        $this->session->set_flashdata('tokbox_success', lang('added_successfully'));
        redirect('settings');
    }

    function get_staff_projects($staff_id)
    {
        return Project::staff_project($staff_id);
    }


    public function create_smart_goal()
    {
        if ($this->input->post()) {
             // echo "<pre>"; print_r($_POST); exit;
            
            if($_POST['rating_scale'] == "rating_1_5"){
                $rating_no = implode('|', $this->input->post('rating_no'));
                $rating_value = implode('|', $this->input->post('rating_value'));
                $definition = implode('|', $this->input->post('definition')); 
            }elseif ($_POST['rating_scale'] == "rating_1_10") {
                $rating_value = implode('|', $this->input->post('rating_value_ten'));
                $definition = implode('|', $this->input->post('definition_ten'));
                unset($_POST['rating_value_ten']);
                unset($_POST['definition_ten']);
               
            }else {
                $rating_value = implode('|', $this->input->post('rating_value_custom'));
                $definition = implode('|', $this->input->post('definition_custom'));
                unset($_POST['rating_value_custom']);
                unset($_POST['definition_custom']);
            }

            $_POST['created_by'] = $this->session->userdata('user_id');
            $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
            $rating_no = implode('|', $this->input->post('rating_no'));
            $_POST['rating_no'] = $rating_no;
            $_POST['rating_value'] = $rating_value;
            $_POST['definition'] = $definition;

            $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
            $this->db->delete('dgt_smart_goal_configuration');
           
            $smart_goal_id = Performance::save($this->input->post(null, true));

            $args = array(
                        'user' => User::get_id(),
                        'module' => 'Performance Configuration',
                        'module_field_id' => $smart_goal_id,
                        'activity' => 'Smart goal Rating created',
                        'icon' => 'fa-user',
                        'value1' => $this->input->post('rating_scale', true),
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);

            $this->session->set_flashdata('tokbox_success', lang('smart_goal_rating_created_successfully'));
            redirect('settings/?settings=performance&key=smart_goals');
            
        } 
    }
    public function create_performance_competency()
    {
           // echo "<pre>";print_r($_POST); exit;

        if ($this->input->post()) {           

                $user_id = $this->session->userdata('user_id');
                // $competencies = Performance::get_performance_competency($user_id);                  
                   for ($i=0; $i < count($_POST['competency']) ; $i++) { 

                         $data = array(
                            
                            'created_by' => $user_id,
                            'competency' => $_POST['competency'][$i],
                            'definition' => $_POST['definition'][$i],
                            'subdomain_id' =>$this->session->userdata('subdomain_id')
                            // 'rating' => $_POST['rating'][$i]
                        );
                        // echo "<pre>";print_r(count($_POST['competencies'])); exit;
                        $competency_id = Performance::save_performance_competency($data);

                        $args = array(
                        'user' => User::get_id(),
                        'module' => 'Performance Configuration',
                        'module_field_id' => $competency_id,
                        'activity' => 'Performance Competency creayted',
                        'icon' => 'fa-user',
                        'value1' => $_POST['competency'][$i],
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);

                       
                   }
               
                $this->session->set_flashdata('tokbox_success', lang('competencie_created_successfully'));
                              
                redirect('settings/?settings=performance&key=competency');
            // }
        } 
    }
    public function competency_definition_update()
    {

        $this->db->where('id',$this->input->post('id'));
        if($this->db->update('performance_competency', array('definition' =>$this->input->post('definition'))))
        {
            $data['success'] = true;
             $data['message'] = 'Success!';
            echo json_encode($data);

              exit;
        }
      


    }
    public function delete_performance_competency()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id', true);

           Performance::delete_performance_competencies($id);     

            // $this->session->set_flashdata('response_status', 'success');
            // $this->session->set_flashdata('message', lang('company_deleted_successfully'));
            $this->session->set_flashdata('tokbox_success', lang('competency_deleted_successfully'));
            redirect('settings/?settings=performance&key=competency');
        } else {
            $data['id'] = $this->uri->segment(3);
            $this->load->view('modal/delete_competency', $data);
        }
    }
    public function create_okr_ratings()
    {
        if ($this->input->post()) {
              // echo "<pre>"; print_r($_POST); exit;
            
            if($_POST['rating_scale'] == "rating_1_5"){
                $rating_no = implode('|', $this->input->post('rating_no'));
                $rating_value = implode('|', $this->input->post('rating_value'));
                $definition = implode('|', $this->input->post('definition')); 
            }elseif ($_POST['rating_scale'] == "rating_1_10") {
                $rating_value = implode('|', $this->input->post('rating_value_ten'));
                $definition = implode('|', $this->input->post('definition_ten'));
                unset($_POST['rating_value_ten']);
                unset($_POST['definition_ten']);
               
            }elseif($_POST['rating_scale'] == "rating_01_010"){

                $rating_value = implode('|', $this->input->post('rating_value_ten'));
                $definition = implode('|', $this->input->post('definition_ten'));
                unset($_POST['rating_value_ten']);
                unset($_POST['definition_ten']);
            } else {
                $rating_value = implode('|', $this->input->post('rating_value_custom'));
                $definition = implode('|', $this->input->post('definition_custom'));
                unset($_POST['rating_value_custom']);
                unset($_POST['definition_custom']);
            }

            $_POST['created_by'] = $this->session->userdata('user_id');
            $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
            $rating_no = implode('|', $this->input->post('rating_no'));
            $_POST['rating_no'] = $rating_no;
            $_POST['rating_value'] = $rating_value;
            $_POST['definition'] = $definition;
            // echo "<pre>"; print_r($_POST); exit;
            $this->db->where('subdomain_id ', $this->session->userdata('subdomain_id'));
            $this->db->delete('dgt_okr_ratings');
           
            $okr_rating_id = Performance::okr_ratings_save($this->input->post(null, true));

            $args = array(
                        'user' => User::get_id(),
                        'module' => 'Performance Configuration',
                        'module_field_id' => $okr_rating_id,
                        'activity' => lang('okr_rating_created'),
                        'icon' => 'fa-user',
                        'value1' => $this->input->post('rating_scale', true),
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);

            $this->session->set_flashdata('tokbox_success', lang('okr_rating_created_successfully'));
            redirect('settings/?settings=performance&key=okr');
            
        } 
    }
    public function create_competency_ratings()
    {
        if ($this->input->post()) {
               // echo "<pre>"; print_r($_POST); exit;
            
            if($_POST['rating_scale'] == "rating_1_5"){
                $rating_no = implode('|', $this->input->post('rating_no'));
                $rating_value = implode('|', $this->input->post('rating_value'));
                $definition = implode('|', $this->input->post('definition')); 
            }elseif ($_POST['rating_scale'] == "rating_1_10") {
                $rating_value = implode('|', $this->input->post('rating_value_ten'));
                $definition = implode('|', $this->input->post('definition_ten'));
                unset($_POST['rating_value_ten']);
                unset($_POST['definition_ten']);
               
            }else {
                $rating_value = implode('|', $this->input->post('rating_value_custom'));
                $definition = implode('|', $this->input->post('definition_custom'));
                unset($_POST['rating_value_custom']);
                unset($_POST['definition_custom']);
            }

            $_POST['created_by'] = $this->session->userdata('user_id');
            $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
            $rating_no = implode('|', $this->input->post('rating_no'));
            $_POST['rating_no'] = $rating_no;
            $_POST['rating_value'] = $rating_value;
            $_POST['definition'] = $definition;

            $this->db->where('subdomain_id ', $this->session->userdata('subdomain_id'));
            $this->db->delete('dgt_competency_ratings');
           
            $okr_rating_id = Performance::competency_ratings_save($this->input->post(null, true));

            $args = array(
                        'user' => User::get_id(),
                        'module' => 'Performance Configuration',
                        'module_field_id' => $okr_rating_id,
                        'activity' => 'Competency Ratings Created',
                        'icon' => 'fa-user',
                        'value1' => $this->input->post('rating_scale', true),
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);

            $this->session->set_flashdata('tokbox_success', lang('competency_ratings_created_successfully'));
            redirect('settings/?settings=performance&key=competency');
            
        } 
    }
    public function okr_description()
    {
       if($this->input->post()){

            $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
            $this->db->delete('dgt_okr_description');
            

            $_POST['user_id'] = $this->session->userdata('user_id');
            $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
            $okr_description_id = Performance::okr_description_save($this->input->post(null, true));
           
            // echo "<pre>"; print_r($_POST); 

            
           

            $args = array(
                        'user' => User::get_id(),
                        'module' => 'Performance Configuration',
                        'module_field_id' => $okr_description_id,
                        'activity' => 'activity_added_okr_description',
                        'icon' => 'fa-user',
                        'value1' => $this->input->post('description', true),
                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                    );
            App::Log($args);

            $this->session->set_flashdata('tokbox_success', lang('description_added_successfully'));
            redirect('settings/?settings=performance&key=okr');
       } 
    }

    public function insert_kpi()
    {

        $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
        $this->db->delete('dgt_kpi');
       $data = array(
       'description' => $this->input->post('kpi_desc'),
       'subdomain_id' =>$this->session->userdata('subdomain_id'),
       'status'   => 'active'
       );

       $result = $this->db->insert('dgt_kpi',$data);
       $this->session->set_flashdata('tokbox_success', lang('description_added_successfully'));
       redirect('settings/?settings=performance');
    }

    public function insert_competencies()
    {

        $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
        $this->db->delete('dgt_performance_competencies');
        $data = array(
        'description' => $this->input->post('competencies_desc'),
        'subdomain_id' =>$this->session->userdata('subdomain_id'),
        'status'      => 'active'

        );

        $result = $this->db->insert('performance_competencies',$data);
        $this->session->set_flashdata('tokbox_success', lang('description_added_successfully'));
        redirect('settings/?settings=performance&key=competency');
    }

    public function role_view($role_name){
        $data['page'] = lang('settings');
        $data['form'] = TRUE;
        $data['editor'] = TRUE;
        $data['fuelux'] = TRUE;
        $data['datatables'] = TRUE;
        $data['nouislider'] = TRUE;
        $data['postmark_config'] = TRUE;
        $data['translations'] = $this->applib->translations();
        $data['available'] = $this->available_translations();
        $data['languages'] = App::languages();
        $data['load_setting'] = $settings;
        $data['locale_name'] = App::get_locale()->name;
        $data['iconpicker'] = TRUE;
        $data['sortable'] = TRUE;
        $data['role_name'] = $role_name;
        $role_id = $this->session->userdata('role_id');

        // echo $role_id; exit;
        $user_type = $this->session->userdata('user_type');
       // echo $role_id; exit;

        // echo $this->session->userdata('user_type'); exit;

        if(($user_type == 0) && ($role_id == 1)){
           $user_role = 1;
        }else{
           $user_role = $user_type;
        }


         // Subdomain ....

        $domain = $this->session->userdata('domain');
        $arr = explode('.', $domain); 
          
        // Get the first element of array 
        $subdomain = $arr[0]; 



        // echo $subdomain_role; exit;

        $role_details = $this->db->get_where('roles',array('role'=>$role_name,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        if($role_details['r_id'] == 1){
            $subdomain_role = $role_name;
        // }
        // if($subdomain == 'demo'){
        //     $subdomain_role = $role_details['role'];
        // }elseif($role_id == '1'){
        //     $subdomain_role = $role_details['role'];
        }else{
            $subdomain_role = $subdomain.'_'.$role_name;
        }
        // echo $subdomain_role; exit;
        $data['menus'] = $this->db->get_where('hooks',array('hook'=>'main_menu_'.$subdomain_role,'route !='=>'#'))->result_array();
        // echo "<pre>";print_r($data['menus']);die;
        $this->template
            ->set_layout('users')
            ->build('role_view',isset($data) ? $data : NULL);
    }

    public function roles_delete(){
        $domain = $this->session->userdata('domain');
        $arr = explode('.', $domain); 
          
        // Get the first element of array 
        $subdomain = $arr[0]; 
        if ($this->input->post()) {
            $role_detail = $this->db->get_where('roles',array('r_id'=>$this->input->post('role_id')))->row_array();
            $this->db->where('hook','main_menu_'.$subdomain.'_'.$role_detail['role']);
            $this->db->delete('hooks');
            $this->db->where('r_id',$role_detail['r_id']);
            $this->db->delete('roles');
            $this->session->set_flashdata('tokbox_success', lang('role_deleted_successfully'));
            redirect('settings/?settings=menu');
        }else{
            $data['role_id'] = $this->uri->segment(3);
            $this->load->view('modal/delete_role',$data);
        } 
    }

     public function performance_status(){

        $performance_status = $this->input->post('performance_status');
        if($performance_status == 'okr'){
            $data =  array('okr' => 1,
                            'competency' => 0,    
                            'smart_goals' => 0,  
                            'subdomain_id' => $this->session->userdata('subdomain_id')  
                        );
        } elseif ($performance_status == 'competency') {
             $data =  array('okr' => 0,
                            'competency' => 1,    
                            'smart_goals' => 0,
                            'subdomain_id' => $this->session->userdata('subdomain_id')     
                        );
        } else{
            $data =  array('okr' => 0,
                            'competency' => 0,    
                            'smart_goals' => 1,
                            'subdomain_id' => $this->session->userdata('subdomain_id')  
                        );
        }
        $performance_status = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->get('performance_status')->row_array();
        if(!empty($performance_status)){
            $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
            $this->db->update('performance_status',$data);
            $this->db->affected_rows();
        }else{            
            $this->db->insert('performance_status',$data);
        }
        

                   // echo "<pre>";print_r($_POST); exit;

        
        // echo print_r($this->db->last_query()); exit;
        $args = array(
                    'user' => User::get_id(),
                    'module' => 'performance',
                    'module_field_id' => 1,
                    'activity' => lang('performance_changed'),
                    'icon' => 'fa-user',
                    'value1' => $this->input->post('performance_status', true),
                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                );
        App::Log($args);
        echo 'yes'; exit;

    }


    public function data_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                if($this->session->userdata('subdomain_id') != 0){
                    $plan_user_count = $this->db->get_where('subscribers',array('subscribers_id'=>$this->session->userdata('subdomain_id')))->row()->user_count;
                }else{
                    $plan_user_count = 1000;
                }
                
                // echo "<pre>";print_r($user_count); exit();
                //loop from first data until last data
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $username = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $first_name = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $last_name = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();
                    $email = $objWorksheet->getCellByColumnAndRow(4,$j)->getValue();
                    $shift_id = $objWorksheet->getCellByColumnAndRow(5,$j)->getValue();
                    $department_id_code = $objWorksheet->getCellByColumnAndRow(6,$j)->getValue();
                    $designation_id_code = $objWorksheet->getCellByColumnAndRow(7,$j)->getValue();
                    $is_teamlead = $objWorksheet->getCellByColumnAndRow(8,$j)->getValue();
                    $user_type = $objWorksheet->getCellByColumnAndRow(9,$j)->getValue();
                    $teamlead_id = $objWorksheet->getCellByColumnAndRow(10,$j)->getValue();
                    $date_of_birth = $objWorksheet->getCellByColumnAndRow(11,$j)->getValue();
                    $password = $objWorksheet->getCellByColumnAndRow(12,$j)->getValue();
                    $gender = $objWorksheet->getCellByColumnAndRow(13,$j)->getValue();
                    $phone = $objWorksheet->getCellByColumnAndRow(14,$j)->getValue();
                    $date_of_join = $objWorksheet->getCellByColumnAndRow(15,$j)->getValue();
                    $branch_id = $objWorksheet->getCellByColumnAndRow(16,$j)->getValue();
                    $fullname = $first_name.' '.$last_name;
                     if(!empty($date_of_birth)){
                        $date_of_birth1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_of_birth));     
                        $dob = date('Y-m-d',strtotime($date_of_birth1));        
                    }                    
                    if(!empty($date_of_join)){
                        $date_of_join1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_of_join));   
                        $doj = date('Y-m-d',strtotime($date_of_join1));                 
                    }                    

                    // $dob = str_replace('/', '-',  $dob);
                    // $doj = str_replace('/', '-',  $doj);
                    $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'),
                    $this->config->item('phpass_hash_portable', 'tank_auth'));
                    $hashed_password = $hasher->HashPassword($password);
                    $reporting_to = $this->db->get_where('dgt_users',array('id_code'=>$teamlead_id,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row()->id;

                    $array = explode(',',$department_id_code);
                    if(is_array($array) && sizeof($array)>1 ){
                        $department_id_code = $array;
                    }else{
                        $department_id_code = $array[0];
                    }
                    if(is_array($department_id_code)){
                        $departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->where_in('id_code',$department_id_code)->get('dgt_departments')->result_array();
                        $departments = array_column($departments, 'deptid');
                        $departments = implode(",", $departments);
                    }else{
                        $departments = $this->db->get_where('dgt_departments',array('id_code'=>$department_id_code,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                        $departments = $departments['deptid'];
                    }
                    if(!empty($branch_id)){
                        $branch_array = explode(',',$branch_id);
                        if(is_array($branch_array) && sizeof($branch_array)>1 ){
                            $branch_id = $branch_array;
                        }else{
                            $branch_id = $branch_array[0];
                        }
                        if(is_array($branch_id)){
                            $branches = $this->db->where(array('subdomain_id'=>$this->session->userdata('subdomain_id'),'status'=>'1'))->where_in('id',$branch_id)->get('dgt_branches')->result_array();
                            $branches = array_column($branches, 'id');
                            $branches = implode(",", $branches);
                        }else{
                            $branches = $this->db->get_where('dgt_branches',array('id'=>$branch_id,'subdomain_id'=>$this->session->userdata('subdomain_id'),'status'=>'1'))->row_array();
                            $branches = $branches['id'];
                        }
                    }else{
                        $branches ='';
                    }

                    // echo "<pre>";print_r($departments);die;
                    // print_r($this->db->last_query()); exit();
                    $designation_ids = $this->db->get_where('dgt_designation',array('id_code'=>$designation_id_code,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                    $role_id = $this->db->get_where('dgt_roles',array('id_code'=>$user_type,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row()->r_id;
                    $department = $departments;
                    $designation_id = $designation_ids['id'];
                    $total_users = $this->db->get_where('users',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->num_rows();
                    $branch = $branches;
                    if($total_users <=  $plan_user_count){

                    if($fullname != '' && $username != '' && $email != '')
                    {                  
                        $username = strtolower($username);
                        $result = $this->db->get_where('users',array('username'=>$username,'subdomain_id'=>$this->session->userdata('subdomain_id')))->num_rows();      
                        $result_email = $this->db->get_where('users',array('email'=>$email,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();      
                        $result_id_code = $this->db->get_where('users',array('id_code'=>$id_code,'subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();      
                        
                        if($result == 0){
                            // echo "sdfsd"; exit;
                            if(count($result_email) == 0){
                                if(count($result_id_code) == 0){
                                // echo "hi"; exit;
                                    $excel = array(
                                        'id_code'=>$id_code,
                                        'username'=>$username,
                                        'email'=>$email,
                                        // 'password'=>'$P$BZPDSyYH3BYnhUQSKo61.MJgyEGWCt1',
                                        'password'  => $hashed_password,
                                        'role_id'   => 3,
                                        'designation_id'    => $designation_id,
                                        'department_id' => $department,
                                        'is_teamlead'   => !empty($is_teamlead)?$is_teamlead:'no',
                                        'teamlead_id'   => !empty($reporting_to)?$reporting_to:0,
                                        'subdomain_id'  => $this->session->userdata('subdomain_id'),
                                        'user_type'     => $role_id,
                                        'branch_id'     => $branch
                                    );      
                                    // echo "<pre>"; print_r($excel); exit();                           
                                    $this->db->insert('users',$excel); 
                                    // echo "<pre>"; print_r($this->db->last_query()); exit();
                                    $insert_id = $this->db->insert_id();                   
                                
                                    $profile = array(
                                        'fullname' => $fullname,
                                        'first_name' => $first_name,
                                        'last_name' => $last_name,
                                        'user_id' => $insert_id,
                                        'dob'       => ($dob)?date('Y-m-d', strtotime($dob)):'0000-00-00',
                                        'gender'    => $gender,
                                        'phone'     => $phone,
                                        'doj'       => ($doj)?date('Y-m-d', strtotime($doj)):'0000-00-00',
                                        'avatar'    => 'default_avatar.jpg',
                                        'language'  => config_item('default_language') ? config_item('default_language') : 'english',
                                        'locale'    => config_item('locale') ? config_item('locale') : 'en_US'
                                    );

                                    // echo "<pre>"; print_r($profile); exit;
                                    // echo "<pre>"; print_r($this->db->last_query()); exit();
                                    $this->db->insert('account_details',$profile);
                                 
                                    // Start Assign shift
                                    if(!empty($shift_id)){
                                    $shift_ids = explode(',', $shift_id);
                                    $shifts = array();
                                    // print_r($shift_ids); exit;
                                    foreach ($shift_ids as $key => $shift_id_code) {
                                        # code...
                                    
                                      $shifts = $this->db->get_where('shifts',array('subdomain_id'=>$this->session->userdata('subdomain_id'),'id_code'=>$shift_id_code))->row_array(); 
                                       
                                      if(!empty($shifts['indefinite'])){

                                        $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                                      } else {

                                            $end_schedulde_date= $shifts['end_date'];
                                            $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($shifts['end_date'])));
                                      }
                         
                           // echo $end_schedulde_date; exit();
                          
                                        // $shifts['end_date'] = ($shifts['end_date'] !='0000-00-00')?date('Y-m-d',strtotime($shifts['end_date'])):'';
                                         // echo "<pre>"; print_r($shifts);
                                        // $repeat_time = $_POST['repeat_time'] * 7;
                                         // echo $start_date .' '.$maxDays; exit;
                                    if(!empty($shifts)){
                                        if((isset($shifts["recurring_shift"]) && !empty($shifts["recurring_shift"])) || (isset($_POST["free_shift"]) && !empty($_POST["free_shift"])))  {
                                            
                                            $begin = new DateTime($shifts['start_date']);
                                            $end = new DateTime($end_schedulde_date);

                                            $interval = DateInterval::createFromDateString('1 day');
                                            $period = new DatePeriod($begin, $interval, $end);
                                            $k=0;
                                             $week_days = isset($shifts['week_days'])?$shifts['week_days']:'';
                                            if(!empty($week_days)){
                                                $week_days = explode(',',$week_days);
                                            }
                                           // echo "<pre>";print_r($period); exit;       
                                            foreach ($period as $dt) {
                                                if(in_array(lcfirst($dt->format("l")), $week_days)){
                                                    // echo $dt->format("l Y-m-d H:i:s\n");
                                                    // echo "<pre>";print_r($_POST); exit;
                                               
                                                    // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$insert_id,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                                                   
                                                    
                                                    // if(empty($employee_shifts)){
                                                         $shift_details = array(
                                                        'dept_id' => $department,
                                                        'employee_id' => $insert_id,
                                                        'project_id' => !empty($shifts['project_id'])?$shifts['project_id']:'',
                                                        'schedule_date' => $dt->format("Y-m-d"),
                                                        'min_start_time' => date("H:i", strtotime($shifts['min_start_time'])),
                                                        'start_time' => date("H:i", strtotime($shifts['start_time'])),
                                                        'max_start_time' => date("H:i", strtotime($shifts['max_start_time'])),
                                                        'min_end_time' => date("H:i", strtotime($shifts['min_end_time'])),
                                                        'end_time' => date("H:i", strtotime($shifts['end_time'])),
                                                        'max_end_time' => date("H:i", strtotime($shifts['max_end_time'])),
                                                        'break_time' => $shifts['break_time'],
                                                        'break_start' => !empty($shifts['break_start'])?date("H:i", strtotime($shifts['break_start'])):'',
                                                        'break_end' => !empty($shifts['break_end'])?date("H:i", strtotime($shifts['break_end'])):'',
                                                        'work_hours' => !empty($shifts['work_hours'])?$shifts['work_hours']:'',
                                                        'shift_id' => $shifts['id'],
                                                        'color' => '#1EB53A',
                                                        'accept_extras' => 1,
                                                        'free_shift' => isset($shifts['free_shift'])?$shifts['free_shift']:0,
                                                        'recurring_shift' => isset($shifts['recurring_shift'])?$shifts['recurring_shift']:0,
                                                        'week_days' => $shifts['week_days'],                                    
                                                        'end_date' =>$shifts['end_date'],
                                                        'indefinite' => isset($shifts['indefinite'])?$shifts['indefinite']:0,
                                                        // 'break_start' => date("H:i", strtotime($_POST['break_start'])),
                                                        // 'break_end' => date("H:i", strtotime($_POST['break_end'])),
                                                        // 'schedule_repeat' => $_POST['repeat_time'],
                                                        // 'tag' => $_POST['tag'],
                                                        // 'note' => $_POST['note'],
                                                        'created_by' => $this->session->userdata('user_id'),
                                                        'subdomain_id' => $this->session->userdata('subdomain_id'),
                                                        'published' => 1                           

                                                        );

                                                         // echo "<pre>";print_r($shift_details); exit();
                                                        
                                                        $this->db->insert('shift_scheduling',$shift_details);
                                                        $shift_id =$this->db->insert_id();
                                                    // }
                                                    // else {
                                                        
                                                    //     $exist_date = $_POST['schedule_date'];
                                                    //     $exist_count += $exist_schedule_count;
                                                    // }
                                                }
                                                
                                            // echo "<pre>";print_r($shift_details); exit();
                                                $k++;

                                    
                                            }
                                         
                                        } else if(isset($shifts["cyclic_shift"]) && !empty($shifts["cyclic_shift"])){
                                            
                                             $workdays = isset($shifts['workday'])?$shifts['workday']:'';
                                            if(!empty($workdays)){
                                                $workday = $workdays;
                                            }
                                            if(isset($shifts['cyclic_shift'])){
                                                $no_of_days_in_cycle = isset($shifts['no_of_days_in_cycle'])?$shifts['no_of_days_in_cycle']:0;
                                            } else{
                                                $no_of_days_in_cycle = 0;
                                            }
                                            $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                                             
                                          
                                            
                                                for($i=1; $i<=120; $i++){
                                                   
                                                    // $workdays = 5;
                                                    // echo $i%$no_of_days_in_cycle;
                                                    if($i%$no_of_days_in_cycle > $workday || $i%$no_of_days_in_cycle == 0){
                                                        echo "Leave";
                                                    }else {
                                                        
                                                        $day =$i-1;

                                                        // $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$insert_id,'schedule_date'=>date('Y-m-d', strtotime('+'.$day.' days', strtotime($shifts['schedule_date'])))))->row_array();                                   
                                                        // if(empty($employee_shifts)){
                                                             $shift_details = array(
                                                            'dept_id' => $department,
                                                            'employee_id' => $insert_id,
                                                            'project_id' => !empty($shifts['project_id'])?$shifts['project_id']:'',
                                                            'schedule_date' => date('Y-m-d', strtotime('+'.$day.' days', strtotime($shifts['start_date']))),
                                                            'min_start_time' => date("H:i", strtotime($shifts['min_start_time'])),
                                                            'start_time' => date("H:i", strtotime($shifts['start_time'])),
                                                            'max_start_time' => date("H:i", strtotime($shifts['max_start_time'])),
                                                            'min_end_time' => date("H:i", strtotime($shifts['min_end_time'])),
                                                            'end_time' => date("H:i", strtotime($shifts['end_time'])),
                                                            'max_end_time' => date("H:i", strtotime($shifts['max_end_time'])),
                                                            'break_time' => $shifts['break_time'],
                                                            'break_start' => !empty($shifts['break_start'])?date("H:i", strtotime($shifts['break_start'])):'',
                                                            'break_end' => !empty($shifts['break_end'])?date("H:i", strtotime($shifts['break_end'])):'',
                                                            'work_hours' => !empty($shifts['work_hours'])?$shifts['work_hours']:'',
                                                            'shift_id' => $shifts['id'],
                                                            'color' => '#1EB53A',
                                                            'accept_extras' => 1,
                                                            'free_shift' => isset($shifts['free_shift'])?$shifts['free_shift']:0,
                                                            'recurring_shift' => isset($shifts['recurring_shift'])?$shifts['recurring_shift']:0,
                                                            'cyclic_shift' => isset($shifts['cyclic_shift'])?$shifts['cyclic_shift']:0,
                                                            'no_of_days_in_cycle' => $no_of_days_in_cycle,
                                                            'workday' => isset($workday)?$workday:0,                                            
                                                            // 'week_days' => $week_days,                                    
                                                            'end_date' =>date('Y-m-d', strtotime('+'.$day.' days', strtotime($shifts['start_date']))),
                                                            'indefinite' => isset($shifts['indefinite'])?$shifts['indefinite']:0,
                                                            // 'break_start' => date("H:i", strtotime($_POST['break_start'])),
                                                            // 'break_end' => date("H:i", strtotime($_POST['break_end'])),
                                                            // 'schedule_repeat' => $_POST['repeat_time'],
                                                            // 'tag' => $_POST['tag'],
                                                            // 'note' => $_POST['note'],
                                                            'created_by' => $this->session->userdata('user_id'),
                                                            'subdomain_id' => $this->session->userdata('subdomain_id'),
                                                            'published' => 1                           

                                                            );

                                                              // echo "<pre>";print_r($shift_details); exit();
                                                            
                                                            $this->db->insert('shift_scheduling',$shift_details);
                                                            $shift_id =$this->db->insert_id();
                                                             // echo "<pre>"; print_r($this->db->last_query()); exit();
                                                        // }
                                                    }
                                                    

                                                }
                                                             
                                                   
                                                    // else {
                                                        
                                                    //     $exist_date = $_POST['schedule_date'];
                                                    //     $exist_count += $exist_schedule_count;
                                                    // }
                                                
                                           
                                              
                                        }
                                        else{

                                            $begin = new DateTime($shifts['schedule_date']);
                                            $end = new DateTime($end_schedulde_date);

                                              if(!empty($shifts['indefinite'])){
                                                   
                                                $end_schedulde_date= date('Y-m-d',strtotime('+120 day'));
                                              } else {
                                                 $end_schedulde_date= $shifts['end_date'];
                                                    $end_schedulde_date= date('Y-m-d',strtotime('+1 day', strtotime($shifts['end_date'])));
                                              }
                                            // echo "<pre>";print_r($_POST); exit();
                                            $interval = DateInterval::createFromDateString('1 day');
                                            $period = new DatePeriod($begin, $interval, $end);
                                             // echo $employee_shifts; exit;
                                             // echo "<pre>";
                                            // echo "<pre>";print_r($period); exit();
                                            foreach ($period as $dt) {

                                               
                                               //  $employee_shifts = $this->db->get_where('shift_scheduling',array('employee_id'=>$insert_id,'schedule_date'=>$dt->format("Y-m-d")))->row_array();
                                               
                                               // if(empty($employee_shifts)){
                                                     $shift_details = array(
                                                    'dept_id' => $department,
                                                    'employee_id' => $insert_id,
                                                    'project_id' => !empty($shifts['project_id'])?$shifts['project_id']:'',
                                                    'schedule_date' => $dt->format("Y-m-d"),
                                                    'min_start_time' => date("H:i", strtotime($shifts['min_start_time'])),
                                                    'start_time' => date("H:i", strtotime($shifts['start_time'])),
                                                    'max_start_time' => date("H:i", strtotime($shifts['max_start_time'])),
                                                    'min_end_time' => date("H:i", strtotime($shifts['min_end_time'])),
                                                    'end_time' => date("H:i", strtotime($shifts['end_time'])),
                                                    'max_end_time' => date("H:i", strtotime($shifts['max_end_time'])),
                                                    'break_time' => $shifts['break_time'],
                                                    'break_start' => !empty($shifts['break_start'])?date("H:i", strtotime($shifts['break_start'])):'',
                                                    'break_end' => !empty($shifts['break_end'])?date("H:i", strtotime($shifts['break_end'])):'',
                                                    'work_hours' => !empty($shifts['work_hours'])?$shifts['work_hours']:'',
                                                    'shift_id' => $shifts['id'],
                                                    'color' => '#1EB53A',
                                                    'accept_extras' => 1,
                                                    'free_shift' => isset($shifts['free_shift'])?$shifts['free_shift']:0,
                                                    'recurring_shift' => isset($shifts['recurring_shift'])?$shifts['recurring_shift']:0,
                                                    'cyclic_shift' => isset($shifts['cyclic_shift'])?$shifts['cyclic_shift']:0,
                                                    // 'week_days' => $week_days,
                                                    // 'break_start' => date("H:i", strtotime($_POST['break_start'])),
                                                    // 'break_end' => date("H:i", strtotime($_POST['break_end'])),
                                                    // 'schedule_repeat' => $_POST['repeat_time'],
                                                    // 'tag' => $_POST['tag'],
                                                    // 'note' => $_POST['note'],
                                                    'created_by' => $this->session->userdata('user_id'),
                                                    'subdomain_id' => $this->session->userdata('subdomain_id'),
                                                    'published' => 1                           

                                                    );


                                                    
                                                    $this->db->insert('shift_scheduling',$shift_details);
                                                    $shift_id =$this->db->insert_id();
                                                // }
                                            // }else {
                                                
                                            //     $exist_date = $_POST['schedule_date'];
                                            //     $exist_count += $exist_schedule_count;
                                            // }
                                            // echo "<pre>";print_r($shift_details); exit();
                                            // $j++;

                                            }
                                        }
                                    }
                                }
                            }
                        // end shift
                            }else{
                                $log_msg .= $n.'. User Id Code Already Exist'.PHP_EOL;
                            }

                            }else{
                                $log_msg .= $n.'. User Email Already Exist.'.PHP_EOL;
                            }
                        }else{
                            $log_msg .= $n.'. Username Already Exist.'.PHP_EOL;
                        }
                    }else{
                        $log_msg .= $n.'. Some fields missing.'.PHP_EOL;
                    }
                    }else{
                        $log_msg .= $n.'. Users count error.'.PHP_EOL;
                    }

                }// loop ends 
                if($log_msg !='')
                {
                    $file_names = 'employee_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }

            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

     public function department_import(){

        //upload folder path defined here 

        // error_reporting(E_ALL);

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);
        // echo "<pre>"; print_r($config);
    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                $department = array();
                $check_id_code = array();
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $department_name = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();

// echo  $email; exit;
                    if($id_code !='' && $department_name !='')
                    {
                        $department = $this->db->get_where('dgt_departments',array('deptname'=>$department_name,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                        $check_id_code = $this->db->get_where('dgt_departments',array('id_code'=>$id_code,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                        // $dept_count = $this->db->order_by('id_code','DESC')->get_where('dgt_departments',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row()->id_code;  
                        // echo   $dept_count; exit();             
                        // $id_code = $dept_count+1;
                        if(empty($department) && empty($check_id_code)){   

                            $departments = array(
                                    'deptname' =>$department_name,
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    'id_code'=> $id_code
                                );
                           $this->db->insert('dgt_departments',$departments);
                           // echo $this->db->last_query(); exit;
                                $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$departments['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => $department_name.' '.lang('department_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. '.$department_name.' Inserted.'.PHP_EOL;
                                // print_r($data).'<br/>';
                            
                        }else{

                            $a = FALSE;

                            // echo "<script> var a = confirm('Do you want to overwrite the existing data?');if (r == true) { ".$a = TRUE." }else{ ".$a = FALSE." }</script>";
                            // echo $a.'<br/>';

                             $departments = array(
                                    'deptname' =>$department_name,
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    'id_code'=> $id_code
                                );
                            $this->db->where('id_code',$id_code);
                            $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
                            $this->db->update('dgt_departments',$departments);
                           // echo $this->db->last_query(); exit;
                                $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$departments['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => $department_name.' '.lang('department_edited'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. '.$department_name.' Updated.'.PHP_EOL;
                            $this->session->set_flashdata('tokbox_error', $department_name.' already exists');
                        }
                    }else{

                        if($id_code =='')
                        {
                            $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$departments['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Id code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Id code required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
                        }

                        if($department_name =='')
                        {
                            $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$departments['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Department name is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Department name required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('department_name_is_required'));
                        }


                    }
                   
                }// loop ends 
                if($log_msg !='')
                {
                    $file_names = 'dept_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }
                // echo $log_msg;
                // die;

            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('department_import_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

    public function designation_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);
        // echo "<pre>"; print_r($config);
    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            echo 'error'; exit;
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {

            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
// echo $file_name; exit;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                $check_designation = array();
                $check_id_code = array();
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $dept_id_code = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $designation_name = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $grade = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();

                    if($id_code !='' && $dept_id_code !='' && $designation_name !='' && $grade !='')
                    {

                        $department = $this->db->get_where('dgt_departments',array('id_code'=>$dept_id_code,'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    // echo  $email; exit;
                        $check_designation = $this->db->get_where('dgt_designation',array('designation'=>$designation_name,'department_id'=>$department['deptid'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                        $check_id_code = $this->db->get_where('dgt_designation',array('id_code'=>$id_code,'department_id'=>$department['deptid'],'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                        // $desi_count = $this->db->order_by('id_code','DESC')->get_where('dgt_designation',array('subdomain_id'=>$this->session->userdata('subdomain_id'),'department_id'=>$department['deptid']))->row()->id_code;                 
                        // $id_code = $desi_count+1;
                        if(empty($check_designation) && empty($check_id_code)){   

                            $designations = array(
                                    'department_id' =>$department['deptid'],
                                    'designation' =>$designation_name,
                                    'grade' =>$grade,
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    'id_code'=> $id_code
                                );
                            // echo print_r($designations); exit();
                           $this->db->insert('dgt_designation',$designations);
                                $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$designations['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => $designation_name.' '.lang('designation_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. '.$designation_name.' Inserted'.PHP_EOL;
                            
                        }else{
                             $designations = array(
                                    'department_id' =>$department['deptid'],
                                    'designation' =>$designation_name,
                                    'grade' =>$grade,
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    'id_code'=> $id_code
                                );
                            $this->db->where('id_code',$id_code);
                            $this->db->where('department_id',$department['deptid']);
                            $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
                            $this->db->update('dgt_designation',$designations);
                               $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' => $designations['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => $designation_name.' '.lang('designation_edited'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                               App::Log($data);
                               $log_msg .= $n.'. '.$designation_name.' Updated.'.PHP_EOL;
                            $this->session->set_flashdata('tokbox_error', lang('designation_name_already_exist'));
                        }
                    }else{

                        if($id_code =='')
                        {
                            $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$designations['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Id code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Id code required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
                        }

                        if($dept_id_code =='')
                        {
                            $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$designations['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Dept Id code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Dept Id code is required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('dept_id_code_is_required'));
                        }

                        if($designation_name =='')
                        {
                            $data = array(
                                    'module' => 'all_departments',
                                    'module_field_id' =>$designations['id_code'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Designation name is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Designation name is required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('designation_is_required'));
                        }
                    }
                   
                }// loop ends 

                if($log_msg !='')
                {
                    $file_names = 'designation_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }
                // echo $log_msg;
                // die;

            }
            // exit;
            if($this->db->affected_rows()>0) {
                $this->session->set_flashdata('tokbox_success', lang('designation_import_successfully'));
            }
            redirect('settings/?settings=data_import');
        }


    }

    function _log_email($file_path){

        $general_settings = $this->db->get_where('subdomin_general_settings',array('user_id'=>$this->session->userdata('user_id'),'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
        $general = unserialize($general_settings['general_settings']);

        $company_name = $general['company_name']?$general['company_name']:config_item('company_name');
        $company_email = $general['company_email']?$general['company_email']:config_item('company_email');
        $company_import_email = $general['company_import_email']?$general['company_import_email']:$company_email;

        $message = App::email_template('email_log','template_body');
        $subject = App::email_template('email_log','subject');

        $logo_link = create_email_logo();

        $message = str_replace("{INVOICE_LOGO}",$logo_link,$message);

        $message = str_replace("{SITE_URL}",base_url().'auth/login',$message);

        $message = str_replace("{SITE_NAME}",$company_name,$message);

        $params['recipient'] = $company_import_email;

        $params['subject'] = $subject;
        $params['message'] = $message;

        $params['attached_file'] = base_url().$file_path;

        modules::run('fomailer/send_email',$params);

    }

    public function shift_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                $exist_shift = array();
                $$exist_id_code = array();
                $project = array();
                // echo $lastRow;die;
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j;
                    $shift_name = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();

                    $id_code = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $start_date = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $min_start_time = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(3,$j)->getValue());
                    $start_time = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(4,$j)->getValue());
                    $max_start_time = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(5,$j)->getValue());
                    $min_end_time = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(6,$j)->getValue());
                    $end_time = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(7,$j)->getValue());
                    $max_end_time = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(8,$j)->getValue());

                    $break_time = $objWorksheet->getCellByColumnAndRow(9,$j)->getValue();
                    $break_start = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(10,$j)->getValue());

                    $break_end = exceltime_to_normal($objWorksheet->getCellByColumnAndRow(11,$j)->getValue());                   
                    $free_shift = $objWorksheet->getCellByColumnAndRow(12,$j)->getValue();
                    $work_hours = $objWorksheet->getCellByColumnAndRow(13,$j)->getValue();
                    $recurring_shift = $objWorksheet->getCellByColumnAndRow(14,$j)->getValue();
                    $cyclic_shift = $objWorksheet->getCellByColumnAndRow(15,$j)->getValue();
                    $week_days = $objWorksheet->getCellByColumnAndRow(16,$j)->getValue();
                    $no_of_days_in_cycle = $objWorksheet->getCellByColumnAndRow(17,$j)->getValue();
                    $workday = $objWorksheet->getCellByColumnAndRow(18,$j)->getValue();
                    $indefinite = $objWorksheet->getCellByColumnAndRow(19,$j)->getValue();
                    $end_date = $objWorksheet->getCellByColumnAndRow(20,$j)->getValue();
                    $tag = $objWorksheet->getCellByColumnAndRow(21,$j)->getValue();
                    $note = $objWorksheet->getCellByColumnAndRow(22,$j)->getValue();
                    $published = $objWorksheet->getCellByColumnAndRow(23,$j)->getValue();
                    $project_code = $objWorksheet->getCellByColumnAndRow(24,$j)->getValue();

                    if($id_code != '')
                    {
                    
                        if(!empty($start_date)){
                            $start_date1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($start_date));     
                            $start_date = date('Y-m-d',strtotime('+1 day', strtotime($start_date1)));        
                        }                    
                        if(!empty($end_date)){
                            $end_date1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($end_date));   
                            $end_date = date('Y-m-d',strtotime('+1 day', strtotime($end_date1)));                 
                        }

                         $start_time = date("H:i",strtotime($start_time));
                            $end_time =     date("H:i",strtotime($end_time));
                            
                             if(empty($free_shift)){
                                if(preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $start_time)){
                                    if(preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $end_time)){
                                        $work_hours = work_time($start_date.' '.$start_time,$start_date.' '.$end_time,$break_time);
                                        // echo $work_hours; exit;
                                        $time_format = 1;
                                    }else{
                                        $time_format = 0;
                                        $data = array(
                                    'module' => 'shift_scheduling/shift_list',
                                    'module_field_id' => $shift_id,
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('shift_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. End time format is wrong line no.'.PHP_EOL;
                                    }
                                }else{
                                    $time_format = 0;
                                     $data = array(
                                    'module' => 'shift_scheduling/shift_list',
                                    'module_field_id' => $shift_id,
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('shift_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Start time format is wrong line no.'.PHP_EOL;
                                }
                                                           
                               // echo "<pre>"; print_r($work_hours); exit;
                            }else{
                                $time_format = 1;
                            }
     
                        
                        if($shift_name != '' && $start_date != '' && $time_format == 1)
                        { 
                            $week_days = !empty($week_days)?strtolower($week_days):'';                        
                            $workdays = !empty($workday)?$workday:'';                            
                           
                            $start_date = !empty($start_date)?date('Y-m-d',strtotime($start_date)):'';
                            $end_date = !empty($end_date)?date('Y-m-d',strtotime($end_date)):'';
                            if(!empty($project_code)){
                                 $project = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->where('project_code',$project_code)->get('projects')->row_array();
                                if(!empty($project)){
                                    $project_id= $project['project_id'];
                                }else{
                                    $project_id = '';
                                }
                            }else{
                                $project_id = '';
                            }
                           
                            
                            // $get_id_code = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by('id_code',DESC)->get('shifts')->row()->id_code;
                            // $id_code = $get_id_code +1;
                            $exist_shift = $this->db->get_where('shifts',array('subdomain_id'=>$this->session->userdata('subdomain_id'),'shift_name'=>$shift_name))->num_rows();
                             $exist_id_code = $this->db->get_where('shifts',array('subdomain_id'=>$this->session->userdata('subdomain_id'),'id_code'=>$id_code))->num_rows();
                             // echo $start_date; exit;
                            
                           
                            // echo $start_time; 
                            //  echo $end_time; exit;
                            if(empty($exist_shift) && empty($exist_id_code)){
                                $shift_details = array(            
                                'shift_name' => $shift_name,
                                'id_code' => $id_code,
                                'project_id' => $project_id,
                                'start_date' => $start_date,
                                'min_start_time' => date("H:i", strtotime($min_start_time)),
                                'start_time' => date("H:i", strtotime($start_time)),
                                'max_start_time' => date("H:i", strtotime($max_start_time)),
                                'min_end_time' => date("H:i", strtotime($min_end_time)),
                                'end_time' => date("H:i", strtotime($end_time)),
                                'max_end_time' => date("H:i", strtotime($max_end_time)),
                                'break_time' => !empty($break_time)?$break_time:0,
                                'break_start' => !empty($break_start)?date("H:i", strtotime($break_start)):'',
                                'break_end' => !empty($break_end)?date("H:i", strtotime($break_end)):'',
                                'work_hours' => !empty($work_hours)?$work_hours:'',
                                'free_shift' => !empty($free_shift)?$free_shift:0,
                                'recurring_shift' => !empty($recurring_shift)?$recurring_shift:0,
                                'cyclic_shift' => !empty($cyclic_shift)?$cyclic_shift:0,
                                'no_of_days_in_cycle' => !empty($no_of_days_in_cycle)?$no_of_days_in_cycle:0,
                                'week_days' => $week_days, 
                                'workday' => !empty($workday)?$workday:0,
                                'end_date' =>$end_date,
                                'indefinite' => !empty($indefinite)?$indefinite:0,
                                'tag' => $tag,
                                'note' => $note,
                                'created_by' => $this->session->userdata('user_id'),
                                'subdomain_id' => $this->session->userdata('subdomain_id'),
                                'published' => !empty($published)?$published:0

                                );
                                // echo "<pre>";print_r($shift_details); exit();
                                $this->db->insert('shifts',$shift_details);
                                // echo $this->db->last_query(); exit;
                                $shift_id =$this->db->insert_id();
                                $data = array(
                                    'module' => 'shift_scheduling/shift_list',
                                    'module_field_id' => $shift_id,
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('shift_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Shift is inserted.'.PHP_EOL;
                            }else{
                                $shift_details = array(            
                                'shift_name' => $shift_name,
                                'id_code' => $id_code,
                                'project_id' => $project_id,
                                'start_date' => $start_date,
                                'min_start_time' => date("H:i", strtotime($min_start_time)),
                                'start_time' => date("H:i", strtotime($start_time)),
                                'max_start_time' => date("H:i", strtotime($max_start_time)),
                                'min_end_time' => date("H:i", strtotime($min_end_time)),
                                'end_time' => date("H:i", strtotime($end_time)),
                                'max_end_time' => date("H:i", strtotime($max_end_time)),
                                'break_time' => !empty($break_time)?$break_time:0,
                                'break_start' => !empty($break_start)?date("H:i", strtotime($break_start)):'',
                                'break_end' => !empty($break_end)?date("H:i", strtotime($break_end)):'',
                                'work_hours' => !empty($work_hours)?$work_hours:'',
                                'free_shift' => !empty($free_shift)?$free_shift:0,
                                'recurring_shift' => !empty($recurring_shift)?$recurring_shift:0,
                                'cyclic_shift' => !empty($cyclic_shift)?$cyclic_shift:0,
                                'no_of_days_in_cycle' => !empty($no_of_days_in_cycle)?$no_of_days_in_cycle:0,
                                'week_days' => $week_days, 
                                'workday' => !empty($workday)?$workday:0,
                                'end_date' =>$end_date,
                                'indefinite' => !empty($indefinite)?$indefinite:0,
                                'tag' => $tag,
                                'note' => $note,
                                'created_by' => $this->session->userdata('user_id'),
                                'subdomain_id' => $this->session->userdata('subdomain_id'),
                                'published' => !empty($published)?$published:0

                                );
                                // echo "<pre>";print_r($shift_details); exit();
                                $this->db->where('shift_name',$shift_name);
                                $this->db->update('shifts',$shift_details);
                                // echo $this->db->last_query(); exit;
                                $shift_id =$this->db->insert_id();
                                $data = array(
                                    'module' => 'shift_scheduling/shift_list',
                                    'module_field_id' => $shift_id,
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => $shift_name.' '.lang('shift_updated'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Shift is updated.'.PHP_EOL;
                            }
                        }else{
                            if($shift_name =='')
                            {
                                $data = array(
                                        'module' => 'shift_scheduling/shift_list',
                                        'module_field_id' => $shift_id,
                                        'user' => $this->session->userdata('user_id'),
                                        'activity' => 'Shift name is required',
                                        'icon' => 'fa-plus',
                                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                        // 'value1' => $cur.' '.$this->input->post('shift_name')
                                        );
                                    App::Log($data);
                                    // print_r($data).'<br/>';
                                    $log_msg .= $n.'. Shift name is required.'.PHP_EOL;
                                    $this->session->set_flashdata('tokbox_error', lang('shift_name_is_required'));
                            }

                            if($start_date =='')
                            {
                                $data = array(
                                        'module' => 'shift_scheduling/shift_list',
                                        'module_field_id' => $shift_id,
                                        'user' => $this->session->userdata('user_id'),
                                        'activity' => 'Shift start date is required',
                                        'icon' => 'fa-plus',
                                        'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                        // 'value1' => $cur.' '.$this->input->post('shift_name')
                                        );
                                    App::Log($data);
                                    // print_r($data).'<br/>';
                                    $log_msg .= $n.'. Shift start date is required.'.PHP_EOL;
                                    $this->session->set_flashdata('tokbox_error', lang('shift_start_date_is_required'));
                            }
                        }
                    }else{
                        $data = array(
                                'module' => 'shift_scheduling/shift_list',
                                'module_field_id' => $shift_id,
                                'user' => $this->session->userdata('user_id'),
                                'activity' => 'Id code is required',
                                'icon' => 'fa-plus',
                                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                // 'value1' => $cur.' '.$this->input->post('shift_name')
                                );
                            App::Log($data);
                            // print_r($data).'<br/>';
                            $log_msg .= $n.'. Id code is required.'.PHP_EOL;
                            $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
                    } 

                }// loop ends 

                if($log_msg !='')
                {
                    $file_names = 'shift_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }

            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }
      
    public function personal_information_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $passport_no = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $passport_expiry = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $tel_number = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();
                    $nationality = $objWorksheet->getCellByColumnAndRow(4,$j)->getValue();
                    $religion = $objWorksheet->getCellByColumnAndRow(5,$j)->getValue();
                    $marital_status = $objWorksheet->getCellByColumnAndRow(6,$j)->getValue();
                    $spouse = $objWorksheet->getCellByColumnAndRow(7,$j)->getValue();
                    $no_children = $objWorksheet->getCellByColumnAndRow(8,$j)->getValue();                 
                    if(!empty($passport_expiry)){
                        $passport_expiry1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($passport_expiry));     
                        $passport_expiry = date('Y-m-d',strtotime('+1 day', strtotime($passport_expiry1)));        
                    }                    
                    
                    if($id_code !='')
                    {
                        $user = $this->db->get_where('dgt_users',array('id_code'=>$id_code))->row_array();
                        if(!empty($user)){                        
                            $personal_info = array(                            
                                'passport_no' =>$passport_no,
                                'passport_expiry' =>$passport_expiry,
                                'tel_number' =>$tel_number,
                                'nationality' =>$nationality,
                                'religion' =>$religion,
                                'marital_status' =>$marital_status,
                                'spouse' =>$spouse,
                                'no_children' =>$no_children
                            );
                            $result = array(
                                    'personal_info' => json_encode($personal_info)
                                );
                            $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user['id']))->num_rows();
                            if($pers_check == 0)
                            {
                                $result['user_id'] = $user['id'];
                                $result['id_code'] = $id_code;
                                $this->db->insert('dgt_users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('personal_information_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Personal Information inserted.'.PHP_EOL;
                            }else{
                                $this->db->where('user_id',$user['id']);
                                $this->db->update('users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' => $user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('personal_information_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Personal Information updated.'.PHP_EOL;
                            }
                        }else{
                            $data = array(
                                'module' => 'employees',
                                'module_field_id' => $user['id'],
                                'user' => $this->session->userdata('user_id'),
                                'activity' => 'User not available',
                                'icon' => 'fa-plus',
                                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                // 'value1' => $cur.' '.$this->input->post('shift_name')
                                );
                            App::Log($data);
                            $log_msg .= $n.'. User not available.'.PHP_EOL;
                        }
                    }else{
                        $data = array(
                            'module' => 'employees',
                            'module_field_id' => $user['id'],
                            'user' => $this->session->userdata('user_id'),
                            'activity' => 'Id code not available',
                            'icon' => 'fa-plus',
                            'subdomain_id' =>$this->session->userdata('subdomain_id'),
                            // 'value1' => $cur.' '.$this->input->post('shift_name')
                            );
                        App::Log($data);
                        $log_msg .= $n.'. Id code is not available.'.PHP_EOL;
                    }
                   
                }// loop ends 

                if($log_msg !='')
                {
                    $file_names = 'personal_info_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }

            }
            if($id_code != '') {
                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

    public function emergency_contact_information_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {
                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $contact_name1 = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $relationship1 = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $contact1_phone1 = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();
                    $contact1_phone2 = $objWorksheet->getCellByColumnAndRow(4,$j)->getValue();
                    $contact_name2 = $objWorksheet->getCellByColumnAndRow(5,$j)->getValue();
                    $relationship2 = $objWorksheet->getCellByColumnAndRow(6,$j)->getValue();
                    $contact2_phone1 = $objWorksheet->getCellByColumnAndRow(7,$j)->getValue();
                    $contact2_phone2 = $objWorksheet->getCellByColumnAndRow(8,$j)->getValue();                 
                                    
                    


// echo  $email; exit;
                    if($id_code !=''){
                        $user = $this->db->get_where('dgt_users',array('id_code'=>$id_code))->row_array();
                        if(!empty($user)){   

                            $emergency_info = array(
                                'contact_name1' =>$contact_name1,
                                'relationship1' =>$relationship1,
                                'contact1_phone1' =>$contact1_phone1,
                                'contact1_phone2' =>$contact1_phone2,
                                'contact_name2' =>$contact_name2,
                                'relationship2' =>$relationship2,
                                'contact2_phone1' =>$contact2_phone1,
                                'contact2_phone2' =>$contact2_phone2
                            );
                            $result = array(
                                    'emergency_info' => json_encode($emergency_info)
                                );
                            $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user['id']))->num_rows();
                            if($pers_check == 0)
                            {
                                $result['user_id'] = $user['id'];
                                $result['id_code'] = $id_code;
                                $this->db->insert('dgt_users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('emergency_contact_information_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Emergency contact information inserted.'.PHP_EOL;
                            }else{
                                $this->db->where('user_id',$user['id']);
                                $this->db->update('users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('emergency_contact_information_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Emergency contact information updated.'.PHP_EOL;
                            }
                            
                        }
                    }else{
                        if($id_code =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Id code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Id code required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
                        }
                    }
                   
                }// loop ends

                if($log_msg !='')
                {
                    $file_names = 'emg_contact_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }

            }
            // exit;
            if($id_code =='') {
                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
            }
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

    public function bank_information_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $bank_name = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $bank_ac_no = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $ifsc_code = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();
                    $pan_no = $objWorksheet->getCellByColumnAndRow(4,$j)->getValue();

// echo  $email; exit;

                    if($id_code !='' && $bank_name !='' && $bank_ac_no !='' && $ifsc_code !='' && $pan_no !='')
                    {

                        $user = $this->db->get_where('dgt_users',array('id_code'=>$id_code))->row_array();
                        if(!empty($user)){   

                            $bank_info = array(
                                    'bank_name' =>$bank_name,
                                    'bank_ac_no' =>$bank_ac_no,
                                    'ifsc_code' =>$ifsc_code,
                                    'pan_no' =>$pan_no
                                );
                            $result = array(
                                    'bank_info' => json_encode($bank_info)
                                );
                            $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user['id']))->num_rows();
                            if($pers_check == 0)
                            {
                                $result['user_id'] = $user['id'];
                                $result['id_code'] = $id_code;
                                $this->db->insert('dgt_users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('bank_information_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Bank Information Inserted.'.PHP_EOL;
                            }else{
                                $this->db->where('user_id',$user['id']);
                                $this->db->update('users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Bank Information Updated',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Bank Information Updated.'.PHP_EOL;
                            }
                            
                        }
                    }else{
                        if($id_code =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Id code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Id code required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
                        }

                        if($bank_name =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Bank name is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Bank name required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('bank_name_is_required'));
                        }

                        if($bank_ac_no =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Bank acc no is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Bank acc no required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('bank_acc_no_is_required'));
                        }

                        if($ifsc_code =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Bank ifsc code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Bank ifsc code required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', 'bank_ifsc_code_is_required');
                        }

                        if($pan_no =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Pan no is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Pan no required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('pan_no_is_required'));
                        }
                    }
                   
                }// loop ends 

                if($log_msg !='')
                {
                    $file_names = 'bank_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }
            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

    public function family_informations_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                $family_members = array();
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n = $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $member_name = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $member_relationship = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $member_dob = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();
                    $member_phone = $objWorksheet->getCellByColumnAndRow(4,$j)->getValue();
                    $member_name1 = $objWorksheet->getCellByColumnAndRow(5,$j)->getValue();
                    $member_relationship1 = $objWorksheet->getCellByColumnAndRow(6,$j)->getValue();
                    $member_dob1 = $objWorksheet->getCellByColumnAndRow(7,$j)->getValue();
                    $member_phone1 = $objWorksheet->getCellByColumnAndRow(8,$j)->getValue();
                    $member_name2 = $objWorksheet->getCellByColumnAndRow(9,$j)->getValue();
                    $member_relationship2 = $objWorksheet->getCellByColumnAndRow(10,$j)->getValue();
                    $member_dob2 = $objWorksheet->getCellByColumnAndRow(11,$j)->getValue();
                    $member_phone2 = $objWorksheet->getCellByColumnAndRow(12,$j)->getValue();
                    $member_name3 = $objWorksheet->getCellByColumnAndRow(13,$j)->getValue();
                    $member_relationship3 = $objWorksheet->getCellByColumnAndRow(14,$j)->getValue();
                    $member_dob3 = $objWorksheet->getCellByColumnAndRow(15,$j)->getValue();
                    $member_phone3 = $objWorksheet->getCellByColumnAndRow(16,$j)->getValue();
                    $member_name4 = $objWorksheet->getCellByColumnAndRow(17,$j)->getValue();
                    $member_relationship4 = $objWorksheet->getCellByColumnAndRow(18,$j)->getValue();
                    $member_dob4 = $objWorksheet->getCellByColumnAndRow(19,$j)->getValue();
                    $member_phone4 = $objWorksheet->getCellByColumnAndRow(20,$j)->getValue();
                    $member_name5 = $objWorksheet->getCellByColumnAndRow(21,$j)->getValue();
                    $member_relationship5 = $objWorksheet->getCellByColumnAndRow(22,$j)->getValue();
                    $member_dob5 = $objWorksheet->getCellByColumnAndRow(23,$j)->getValue();
                    $member_phone5 = $objWorksheet->getCellByColumnAndRow(24,$j)->getValue();

                    if($id_code !='' && $member_name !='' && $member_relationship !='' && $member_phone !='')
                    {
                        // echo $member_dob; exit;
                        if(!empty($member_dob)){
                            $member_dob = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($member_dob));     
                            $member_dob = date('Y-m-d',strtotime('+1 day', strtotime($member_dob)));        
                        }  
                        if(!empty($member_dob1)){
                            $member_dob1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($member_dob1));     
                            $member_dob1 = date('Y-m-d',strtotime('+1 day', strtotime($member_dob1)));        
                        }    
                        if(!empty($member_dob2)){
                            $member_dob2 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($member_dob2));     
                            $member_dob2 = date('Y-m-d',strtotime('+1 day', strtotime($member_dob2)));        
                        }  
                        if(!empty($member_dob3)){
                            $member_dob3 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($member_dob3));     
                            $member_dob3 = date('Y-m-d',strtotime('+1 day', strtotime($member_dob3)));        
                        }  
                        if(!empty($member_dob4)){
                            $member_dob4 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($member_dob4));     
                            $member_dob4 = date('Y-m-d',strtotime('+1 day', strtotime($member_dob4)));        
                        }  
                        if(!empty($member_dob5)){
                            $member_dob5 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($member_dob5));     
                            $member_dob5 = date('Y-m-d',strtotime('+1 day', strtotime($member_dob5)));        
                        }  
                        $user = $this->db->get_where('dgt_users',array('id_code'=>$id_code))->row_array();
                        $family_members = array();
                        if(!empty($user)){  

                            if(!empty($member_name)){
                                $members = array(
                                    'member_name'=>$member_name,
                                    'member_relationship'=>$member_relationship,
                                    'member_dob'=>$member_dob,
                                    'member_phone'=>$member_phone
                                );
                                $family_members[] = $members;
                            }
                            if(!empty($member_name1)){
                                $members = array(
                                    'member_name'=>$member_name1,
                                    'member_relationship'=>$member_relationship1,
                                    'member_dob'=>$member_dob1,
                                    'member_phone'=>$member_phone1
                                );
                                $family_members[] = $members;
                            }
                            
                            if(!empty($member_name2)){
                                $members = array(
                                    'member_name'=>$member_name2,
                                    'member_relationship'=>$member_relationship2,
                                    'member_dob'=>$member_dob2,
                                    'member_phone'=>$member_phone2
                                );
                                $family_members[] = $members;
                            }
                            if(!empty($member_name3)){
                                $members = array(
                                    'member_name'=>$member_name3,
                                    'member_relationship'=>$member_relationship3,
                                    'member_dob'=>$member_dob3,
                                    'member_phone'=>$member_phone3
                                );
                                $family_members[] = $members;
                            }
                            if(!empty($member_name4)){
                                $members = array(
                                    'member_name'=>$member_name4,
                                    'member_relationship'=>$member_relationship4,
                                    'member_dob'=>$member_dob4,
                                    'member_phone'=>$member_phone4
                                );
                                $family_members[] = $members;
                            }    
                            if(!empty($member_name5)){
                                $members5 = array(
                                    'member_name'=>$member_name5,
                                    'member_relationship'=>$member_relationship5,
                                    'member_dob'=>$member_dob5,
                                    'member_phone'=>$member_phone5
                                );
                                $family_members[] = $members;
                            }
                            
                            
                             // echo "<pre>"; print_r($family_members); exit;   
                            $result = array(
                                    'family_members_info' => json_encode($family_members)
                                );
                            $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user['id']))->num_rows();
                            if($pers_check == 0)
                            {
                                $result['user_id'] = $user['id'];
                                $result['id_code'] = $id_code;
                                $this->db->insert('dgt_users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('family_informations_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Family Information Inserted.'.PHP_EOL;
                            }else{
                                $this->db->where('user_id',$user['id']);
                                $this->db->update('users_personal_details',$result);
                                $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => lang('family_informations_imported'),
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                $log_msg .= $n.'. Family Information Updated.'.PHP_EOL;
                            }
                            
                        }
                    }else{
                        if($id_code =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Id code is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Id code required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('id_code_is_required'));
                        }

                        if($member_name =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Member name is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Member name required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('member_name_is_required'));
                        }

                        if($member_relationship =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Member relationship is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Member relationship required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('member_relationship_is_required'));
                        }

                        if($member_phone =='')
                        {
                            $data = array(
                                    'module' => 'employees',
                                    'module_field_id' =>$user['id'],
                                    'user' => $this->session->userdata('user_id'),
                                    'activity' => 'Member phone is required',
                                    'icon' => 'fa-plus',
                                    'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                    // 'value1' => $cur.' '.$this->input->post('shift_name')
                                    );
                                App::Log($data);
                                // print_r($data).'<br/>';
                                $log_msg .= $n.'. Member phone required.'.PHP_EOL;
                                $this->session->set_flashdata('tokbox_error', lang('member_phone_is_required'));
                        }
                    }
                   
                }// loop ends 
                if($log_msg !='')
                {
                    $file_names = 'family_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }
            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

     public function education_informations_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './upload/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error['error']);
            redirect('settings/?settings=data_import');
        }
//if successfully uploaded the file 
        else
        {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];


    //load library phpExcel
            $this->load->library("Excel");


//here i used microsoft excel 2007
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

//set to read only
            $objReader->setReadDataOnly(true);
//load excel file
            $objPHPExcel = $objReader->load('upload/'.$file_name);
            $sheetnumber = 0;
            $log_msg = '';
            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                $educations = array();
                for($j=2; $j<=$lastRow; $j++)
                {
                    $n= $j-1;
                    $id_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                    $institute = $objWorksheet->getCellByColumnAndRow(1,$j)->getValue();
                    $subject = $objWorksheet->getCellByColumnAndRow(2,$j)->getValue();
                    $start_date = $objWorksheet->getCellByColumnAndRow(3,$j)->getValue();
                    $end_date = $objWorksheet->getCellByColumnAndRow(4,$j)->getValue();
                    $degree = $objWorksheet->getCellByColumnAndRow(5,$j)->getValue();
                    $grade = $objWorksheet->getCellByColumnAndRow(6,$j)->getValue();
                    $institute1 = $objWorksheet->getCellByColumnAndRow(7,$j)->getValue();
                    $subject1 = $objWorksheet->getCellByColumnAndRow(8,$j)->getValue();
                    $start_date1 = $objWorksheet->getCellByColumnAndRow(9,$j)->getValue();
                    $end_date1 = $objWorksheet->getCellByColumnAndRow(10,$j)->getValue();
                    $degree1 = $objWorksheet->getCellByColumnAndRow(11,$j)->getValue();
                    $grade1 = $objWorksheet->getCellByColumnAndRow(12,$j)->getValue();
                    $institute2 = $objWorksheet->getCellByColumnAndRow(13,$j)->getValue();
                    $subject2 = $objWorksheet->getCellByColumnAndRow(14,$j)->getValue();
                    $start_date2 = $objWorksheet->getCellByColumnAndRow(15,$j)->getValue();
                    $end_date2 = $objWorksheet->getCellByColumnAndRow(16,$j)->getValue();
                    $degree2 = $objWorksheet->getCellByColumnAndRow(17,$j)->getValue();
                    $grade2 = $objWorksheet->getCellByColumnAndRow(18,$j)->getValue();
                    $institute3 = $objWorksheet->getCellByColumnAndRow(19,$j)->getValue();
                    $subject3 = $objWorksheet->getCellByColumnAndRow(20,$j)->getValue();
                    $start_date3 = $objWorksheet->getCellByColumnAndRow(21,$j)->getValue();
                    $end_date3 = $objWorksheet->getCellByColumnAndRow(22,$j)->getValue();
                    $degree3 = $objWorksheet->getCellByColumnAndRow(23,$j)->getValue();
                    $grade3 = $objWorksheet->getCellByColumnAndRow(24,$j)->getValue();
                    $institute4 = $objWorksheet->getCellByColumnAndRow(25,$j)->getValue();
                    $subject4 = $objWorksheet->getCellByColumnAndRow(26,$j)->getValue();
                    $start_date4 = $objWorksheet->getCellByColumnAndRow(27,$j)->getValue();
                    $end_date4 = $objWorksheet->getCellByColumnAndRow(28,$j)->getValue();
                    $degree4 = $objWorksheet->getCellByColumnAndRow(29,$j)->getValue();
                    $grade4 = $objWorksheet->getCellByColumnAndRow(30,$j)->getValue();
                    // echo $member_dob; exit;
                    if(!empty($start_date)){
                        $start_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($start_date));     
                        $start_date = date('Y-m-d',strtotime('+1 day', strtotime($start_date)));        
                    }  
                    if(!empty($start_date1)){
                        $start_date1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($start_date1));     
                        $start_date1 = date('Y-m-d',strtotime('+1 day', strtotime($start_date1)));        
                    }    
                    if(!empty($start_date2)){
                        $start_date2 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($start_date2));     
                        $start_date2 = date('Y-m-d',strtotime('+1 day', strtotime($start_date2)));        
                    }  
                    if(!empty($start_date3)){
                        $start_date3 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($start_date3));     
                        $start_date3 = date('Y-m-d',strtotime('+1 day', strtotime($start_date3)));        
                    }  
                    if(!empty($start_date4)){
                        $start_date4 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($start_date4));     
                        $start_date4 = date('Y-m-d',strtotime('+1 day', strtotime($start_date4)));        
                    }  
                    if(!empty($end_date)){
                        $end_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($end_date));     
                        $end_date = date('Y-m-d',strtotime('+1 day', strtotime($end_date)));        
                    }  
                    if(!empty($end_date1)){
                        $end_date1 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($end_date1));     
                        $end_date1 = date('Y-m-d',strtotime('+1 day', strtotime($end_date1)));        
                    }  
                    if(!empty($end_date2)){
                        $end_date2 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($end_date2));     
                        $end_date2 = date('Y-m-d',strtotime('+1 day', strtotime($end_date2)));        
                    }  
                    if(!empty($end_date3)){
                        $end_date3 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($end_date3));     
                        $end_date3 = date('Y-m-d',strtotime('+1 day', strtotime($end_date3)));        
                    }  
                    if(!empty($end_date4)){
                        $end_date4 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($end_date4));     
                        $end_date4 = date('Y-m-d',strtotime('+1 day', strtotime($end_date4)));        
                    }  
                    $user = $this->db->get_where('dgt_users',array('id_code'=>$id_code))->row_array();
                    $educations = array();
                    if(!empty($user)){                         
                        
                        if(!empty($institute)){
                            $education = array(
                                'institute'=>$institute,
                                'subject'=>$subject,
                                'start_date'=>$start_date,
                                'end_date'=>$end_date,
                                'degree'=>$degree,
                                'grade'=>$grade
                            );
                            $educations[] = $education;
                        }else{
                            $log_msg .= $n.'. institute not inserted.'.PHP_EOL;
                        }

                        if(!empty($institute1)){
                            $education = array(
                                'institute'=>$institute1,
                                'subject'=>$subject1,
                                'start_date'=>$start_date1,
                                'end_date'=>$end_date1,
                                'degree'=>$degree1,
                                'grade'=>$grade1
                            );
                            $educations[] = $education;
                        }else{
                            $log_msg .= $n.'. institute1 not inserted.'.PHP_EOL;
                        }
                        
                        if(!empty($institute2)){
                            $education = array(
                                'institute'=>$institute2,
                                'subject'=>$subject2,
                                'start_date'=>$start_date2,
                                'end_date'=>$end_date2,
                                'degree'=>$degree2,
                                'grade'=>$grade2
                            );
                            $educations[] = $education;
                        }else{
                            $log_msg .= $n.'. institute2 not inserted.'.PHP_EOL;
                        }

                        if(!empty($institute3)){
                            $education = array(
                                'institute'=>$institute3,
                                'subject'=>$subject3,
                                'start_date'=>$start_date3,
                                'end_date'=>$end_date3,
                                'degree'=>$degree3,
                                'grade'=>$grade3
                            );
                            $educations[] = $education;
                        }else{
                            $log_msg .= $n.'. institute3 not inserted.'.PHP_EOL;
                        }

                        if(!empty($institute4)){
                            $education = array(
                                'institute'=>$institute4,
                                'subject'=>$subject4,
                                'start_date'=>$start_date4,
                                'end_date'=>$end_date4,
                                'degree'=>$degree4,
                                'grade'=>$grade4
                            );
                            $educations[] = $education;
                        }else{
                            $log_msg .= $n.'. institute4 not inserted.'.PHP_EOL;
                        }
                        
                        
                         // echo "<pre>"; print_r($family_members); exit;                        
            // echo $user_id; exit;
                        $result = array(
                                'education_details' => json_encode($educations)
                            );
                        $pers_check = $this->db->get_where('dgt_users_personal_details',array('user_id'=>$user['id']))->num_rows();
                        if($pers_check == 0)
                        {
                            $result['user_id'] = $user['id'];
                            $result['id_code'] = $id_code;
                            $this->db->insert('dgt_users_personal_details',$result);
                            $data = array(
                                'module' => 'employees',
                                'module_field_id' =>$user['id'],
                                'user' => $this->session->userdata('user_id'),
                                'activity' => lang('education_informations_imported'),
                                'icon' => 'fa-plus',
                                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                // 'value1' => $cur.' '.$this->input->post('shift_name')
                                );
                            App::Log($data);
                            $log_msg .= $n.'. education information inserted.'.PHP_EOL;
                        }else{
                            $this->db->where('user_id',$user['id']);
                            $this->db->update('users_personal_details',$result);
                            $data = array(
                                'module' => 'employees',
                                'module_field_id' =>$user['id'],
                                'user' => $this->session->userdata('user_id'),
                                'activity' => lang('education_informations_imported'),
                                'icon' => 'fa-plus',
                                'subdomain_id' =>$this->session->userdata('subdomain_id'),
                                // 'value1' => $cur.' '.$this->input->post('shift_name')
                                );
                            App::Log($data);
                            $log_msg .= $n.'. education information updated.'.PHP_EOL;
                        }
                        
                    }
                   
                }// loop ends 
                if($log_msg !='')
                {
                    $file_names = 'education_log_msg.txt';
                    $file_path = 'assets/uploads/'.$file_names;
                    $handle = fopen($file_path, "w");
                    fwrite($handle, $log_msg);
                    fclose($handle);

                    $this->_log_email($file_path);

                    // $this->load->helper('download');
                    // ob_end_clean();
                    // force_download($file_names, file_get_contents($file_path));
                }
            }
            // exit;
            $this->session->set_flashdata('tokbox_success', lang('imported_successfully'));
            redirect('settings/?settings=data_import');
        }


    }

    public function user_excel()
    {

        // date_default_timezone_set('Asia/calcutta');
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Employees');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', lang('employee_list_generated'));

        $this->excel->getActiveSheet()->setCellValue('A2', lang('user_id'));
        $this->excel->getActiveSheet()->setCellValue('B2', lang('name'));
        $this->excel->getActiveSheet()->setCellValue('C2', lang('email'));
        $this->excel->getActiveSheet()->setCellValue('D2', lang('username'));
        $this->excel->getActiveSheet()->setCellValue('E2', lang('user_type'));
        $this->excel->getActiveSheet()->setCellValue('F2', lang('designation_name'));
        $this->excel->getActiveSheet()->setCellValue('G2', lang('department_name'));
        $this->excel->getActiveSheet()->setCellValue('H2', lang('branch_name'));

        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

        for($col = ord('A'); $col <= ord('G'); $col++){
                //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
         //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        //retrive Users table data
        if($this->session->userdata('branch_id') != '') {
            $this->db->where("U.branch_id IN (".$this->session->userdata('branch_id').")",NULL, false);
        }
        $results = $this->db->select('U.id,AD.fullname,U.email,U.username,R.role,DS.designation')
                            ->from('users U')
                            ->join('account_details AD','AD.user_id = U.id')
                            ->join('roles R','R.default = U.role_id')
                            //->join('departments DP','DP.deptid = U.department_id',LEFT)
                            ->join('designation DS','DS.id = U.designation_id',LEFT)
                            ->where('U.role_id','3')
                            ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))
                            ->group_by('U.id')
                            ->get()
                            ->result_array();

        $records = array();
        if(count($results) >0){

            $department = array();
            foreach ($results as $list) {
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

                //$list['designations'] = (!empty($depart_id))?$this->employees->get_designations($depart_id):array();
                //echo 'litere<pre>'; print_r($list); exit;
                $records[] = $list;
            }

            //echo 'lit<pre>'; print_r($records); exit;
        }
        //echo 'res<pre>'; print_r($results); exit;
        $exceldata = array();
        foreach ($records as $row){
            $exceldata[] = $row;
        }
                //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');

        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objWriter  =   new PHPExcel_Writer_Excel2007($this->excel);

        $filename='Employee-List'.time().'.xlsx'; //save our workbook as this file name
        // echo $filename; exit;
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        ob_end_clean();
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        $this->session->set_flashdata('tokbox_success', lang('exported_successfully'));
    }


   

}

/* End of file settings.php */