<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Branches extends MX_Controller

{

    public function __construct()

    {   

        parent::__construct();

        User::logged_in();



        $this->load->library(array('form_validation'));

        $this->load->model(array('App', 'Lead' , 'Branches_model'));

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

        $this->template->title(lang('branches').' - '.config_item('company_name'));

        $data['page'] = lang('employees');

        $data['sub_page'] = lang('branches');

        $data['form'] = true;

        $data['datatables'] = true;

        $data['leads_plugin'] = true;

        $data['fuelux'] = true;

        $data['list_view'] = $this->session->userdata('lead_view');

        $data['currencies'] = App::currencies();

        $data['languages'] = App::languages();

        $data['branches'] = Branches_model::all();          

        $this->template

                ->set_layout('users')

                ->build('branches/index', isset($data) ? $data : null);

    }





    function add($branch_id='')

    { 

        if ($_POST||$branch_id!='') 

        {  

            if(sizeof(array_filter($_POST))<1&&!empty($branch_id))

            { 

                $branch = Branches_model::find($branch_id);    

                $data = [];

                $branch_array = [];

                foreach ($branch as $key=>$val)

                {

                    $branch_array[$key]=$val;

                }    

                $data['branch'] = $branch_array;     

                $this->load->view('add',$data);

            }

            if(sizeof(array_filter($_POST))>0)

            {   

                if(isset($_POST['id'])&&!empty($_POST['id']))

                {

                    $branch_id = $_POST['id'];

                }

                $current_date_time = date('Y-m-d H:i:s'); 

                if(isset($_POST['edit'])&&$_POST['edit']=="true"&&!empty($branch_id))

                {

                    $branch_name_exists = Branches_model::branch_name_exists($_POST['branch_name'],$_POST['id']); 

                    if(!$branch_name)

                    {

                        $branch_id = $_POST['id'];

                        unset($_POST['edit']);

                        unset($_POST['id']);

                        $_POST['updated_date'] = $current_date_time;
                        $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');

                        App::update('branches',array('id'=>$branch_id),$this->input->post());     

                        $this->session->set_flashdata('tokbox_success', lang('branch_updated_successfully'));

			            redirect('branches');

                    }

                    else 

                    {

                        $this->session->set_flashdata('tokbox_error', lang('branche_exists'));

			            redirect('branches');

                    }

                }

                else 

                {

                    $branch_name_exists = Branches_model::branch_name_exists($_POST['branch_name']); 

                    if(!$branch_name_exists)

                    {

                        $_POST['created_date'] = $current_date_time;
                        $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
                        $branch_count = $this->db->order_by('id_code','DESC')->get_where('dgt_branches',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row()->id_code;   
                        $id_code = $branch_count+1;
                        $_POST['id_code'] = $id_code;
                        App::save_data('branches',$this->input->post());     

                    }

                    else 

                    {

                        $this->session->set_flashdata('tokbox_error', lang('branche_exists'));

			            redirect('branches');

                    }

                }                            

                $this->session->set_flashdata('tokbox_success', lang('branch_added_successfully'));

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

            Branches_model::delete($id);  

            $this->session->set_flashdata('tokbox_success', lang('branch_deleted_successfully'));

            redirect('branches');

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