<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Locations extends MX_Controller

{

    public function __construct()

    {   

        parent::__construct();

        User::logged_in();



        $this->load->library(array('form_validation'));

        $this->load->model(array('App', 'Lead' , 'Locations_model'));

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

        $data['sub_page'] = lang('locations');

        $data['form'] = true;

        $data['datatables'] = true;

        $data['leads_plugin'] = true;

        $data['fuelux'] = true;

        $data['list_view'] = $this->session->userdata('lead_view');

        $data['currencies'] = App::currencies();

        $data['languages'] = App::languages();

        $data['locations'] = Locations_model::all();          

        $this->template

                ->set_layout('users')

                ->build('locations/index', isset($data) ? $data : null);

    }

    function geolocation(){
        if(!empty($_POST['latLng'])){ 

              $latLng1 =  ltrim($_POST['latLng'],"(");
              $latLng2 =  rtrim($latLng1,")");

            $latLng = explode(',',$latLng2);
            $latitude = $latLng[0];
            $longitude = $latLng[1];
            // echo $latitude.'<br>';
            // echo $longitude.'<br>'; exit;
    //Send request and receive json data by latitude and longitude 

            $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBxeoEhkCzN7XtI4rPzuK0LfOiAOLv3-zY&latlng='.trim($latitude).','.trim($longitude).'&sensor=true'; 
            // https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyAICmIT7D2cX5KZmS3lc9C91G4sDmOGetc&latlng=9.925201,78.119774&sensor=true
            $json = @file_get_contents($url); 

            $data = json_decode($json); 

            $status = $data->status; 
            // echo $json; exit(); 
             // echo print_r($status);
             // echo "<pre>"; print_r($data); exit;
             $status1 = "OK";
            if(strtolower($status) == strtolower($status1)){ 

                //Get address from json data 

                $location['address'] = $data->results[0]->formatted_address; 
                $location['latitude'] = $latitude; 
                $location['longitude'] = $longitude; 


            }else{ 

                $location =  ''; 

            } 

            //Print address 

           echo json_encode($location);

        }
        die();
    }



    function add($location_id='')

    { 

        if ($_POST||$location_id!='') 

        {  

            if(sizeof(array_filter($_POST))<1&&!empty($location_id))

            { 

                $location = Locations_model::find($location_id);    

                $data = [];

                $location_array = [];

                foreach ($location as $key=>$val)

                {

                    $location_array[$key]=$val;

                }    

                $data['location'] = $location_array;     

                $this->load->view('add',$data);

            }

            if(sizeof(array_filter($_POST))>0)

            {   

                if(isset($_POST['id'])&&!empty($_POST['id']))

                {

                    $location_id = $_POST['id'];

                }

                $current_date_time = date('Y-m-d H:i:s'); 

                if(isset($_POST['edit'])&&$_POST['edit']=="true"&&!empty($location_id))

                {

                    $location_exists = Locations_model::location_name_exists($_POST['location_name'],$_POST['id']); 

                    if(!$location_exists)

                    {

                        $location_id = $_POST['id'];

                        unset($_POST['edit']);

                        unset($_POST['id']);

                        // $_POST['updated_date'] = $current_date_time;
                        $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');

                        App::update('locations',array('id'=>$location_id),$this->input->post());     

                        $this->session->set_flashdata('tokbox_success', lang('location_updated_successfully'));

			            redirect('locations');

                    }

                    else 

                    {

                        $this->session->set_flashdata('tokbox_error', lang('location_exists'));

			            redirect('locations');

                    }

                }

                else 

                {

                    $location_exists = Locations_model::location_name_exists($_POST['location_name']); 

                    if(!$location_exists)

                    {

                        $_POST['created_date'] = $current_date_time;
                        $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');
                        // $punch_group_count = $this->db->order_by('id_code','DESC')->get_where('dgt_punch_groups',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row()->id_code;   
                        // $id_code = $branch_count+1;
                        // $_POST['id_code'] = $id_code;
                        App::save_data('locations',$this->input->post());     

                    }

                    else 

                    {

                        $this->session->set_flashdata('tokbox_error', lang('location_exists'));

			            redirect('locations');

                    }

                }                            

                $this->session->set_flashdata('tokbox_success', lang('location_added_successfully'));

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

            Locations_model::delete($id);  

            $this->session->set_flashdata('tokbox_success', lang('location_deleted_successfully'));

            redirect('locations');

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