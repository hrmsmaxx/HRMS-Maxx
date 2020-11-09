<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Punch_groups extends MX_Controller

{

    public function __construct()

    {   

        parent::__construct();

        User::logged_in();



        $this->load->library(array('form_validation'));

        $this->load->model(array('App', 'Lead' , 'Punch_groups_model'));

        // if (!User::is_admin()) {

        //     $this->session->set_flashdata('message', lang('access_denied'));

        //     redirect('');

        // }

        $this->load->helper(array('inflector'));

        $this->applib->set_locale();

        $this->lead_view = (isset($_GET['list'])) ? $this->session->set_userdata('lead_view', $_GET['list']) : 'kanban';

    }



    public function index()

    {

        $this->load->module('layouts');

        $this->load->library('template');

        $this->template->title(lang('geolocation').' - '.config_item('company_name'));

        $data['page'] = lang('geolocation');

        $data['sub_page'] = lang('punch_groups');

        $data['form'] = true;

        $data['datatables'] = true;

        $data['leads_plugin'] = true;

        $data['fuelux'] = true;

        $data['list_view'] = $this->session->userdata('lead_view');

        $data['currencies'] = App::currencies();

        $data['languages'] = App::languages();

        $data['punch_groups'] = Punch_groups_model::all();        
       

        $this->template

                ->set_layout('users')

                ->build('punch_groups/index', isset($data) ? $data : null);

    }





    function add($group_id='')

    { 

        if ($_POST||$group_id!='') 

        {  

            if(sizeof(array_filter($_POST))<1&&!empty($group_id))

            { 

                $punch_group = Punch_groups_model::find($group_id);    

                $data = [];

                $punch_group_array = [];

                foreach ($punch_group as $key=>$val)

                {

                    $punch_group_array[$key]=$val;

                }    

                $data['punch_group'] = $punch_group_array;     

                $this->load->view('add',$data);

            }

            if(sizeof(array_filter($_POST))>0)

            {   

                if(isset($_POST['id'])&&!empty($_POST['id']))

                {

                    $group_id = $_POST['id'];

                }

                $current_date_time = date('Y-m-d H:i:s'); 

                if(isset($_POST['edit'])&&$_POST['edit']=="true"&&!empty($group_id))

                {

                    $punch_group_exists = Punch_groups_model::punch_group_name_exists($_POST['punch_group_name'],$_POST['id']); 

                    if(!$punch_group_exists)

                    {

                        $group_id = $_POST['id'];

                        unset($_POST['edit']);

                        unset($_POST['id']);
                        $_POST['employee_id'] = implode(',', $_POST['employee_id']);
                        // $_POST['updated_date'] = $current_date_time;
                        $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');

                        App::update('punch_groups',array('id'=>$group_id),$this->input->post());     

                        $this->session->set_flashdata('tokbox_success', lang('punch_group_updated_successfully'));

			            redirect('punch_groups');

                    }

                    else 

                    {

                        $this->session->set_flashdata('tokbox_error', lang('group_exists'));

			            redirect('punch_groups');

                    }

                }

                else 

                {

                    $punch_group_exists = Punch_groups_model::punch_group_name_exists($_POST['punch_group_name']); 

                    if(!$punch_group_exists)

                    {

                        $_POST['created'] = $current_date_time;
                        $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
                        $_POST['employee_id'] = implode(',', $_POST['employee_id']);
                        // $punch_group_count = $this->db->order_by('id_code','DESC')->get_where('dgt_punch_groups',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row()->id_code;   
                        // $id_code = $branch_count+1;
                        // $_POST['id_code'] = $id_code;
                        // echo print_r($_POST); exit;
                        App::save_data('punch_groups',$this->input->post());     
                        // echo $this->db->last_query(); exit;

                    }

                    else 

                    {

                        $this->session->set_flashdata('tokbox_error', lang('group_exists'));

			            redirect('punch_groups');

                    }

                }                            

                $this->session->set_flashdata('tokbox_success', lang('punch_groups_added_successfully'));

                redirect($_SERVER['HTTP_REFERER']);

            }

        }

        else

        {    

            $this->load->view('add');

        }

    }



    public function delete($id='')

    {

        if ($this->input->post()) 

        {

            $id = $this->input->post('id', true);

            Punch_groups_model::delete($id);  

            $this->session->set_flashdata('tokbox_success', lang('punch_groups_deleted_successfully'));

            redirect('punch_groups');

        } 

        else 

        {

            if($id!='')

            {

                $data['id'] = $id;

                $this->load->view('delete',$data);

            }

        }

    }



    

}