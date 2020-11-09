<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class All_assets extends MX_Controller

{

    public function __construct()

    {

        parent::__construct();

        User::logged_in();



        $this->load->library(array('form_validation'));

        $this->load->model(array('Client', 'App', 'Lead'));

        // if (!User::is_admin()) {

        //     $this->session->set_flashdata('message', lang('access_denied'));

        //     redirect('');

        // }

        $all_routes = $this->session->userdata('all_routes');

        foreach($all_routes as $key => $route){

            if($route == 'all_assets'){

                $routname = all_assets;

            } 

        }

        //if(empty($routname)){

        //     $this->session->set_flashdata('message', lang('access_denied'));

        //    redirect('');

       // }

        $this->load->helper(array('inflector'));

        $this->applib->set_locale();

        $this->lead_view = (isset($_GET['list'])) ? $this->session->set_userdata('lead_view', $_GET['list']) : 'kanban';

    }



    public function index()

    {

        $this->load->module('layouts');

        $this->load->library('template');

        $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

        $theme_settings = unserialize($theme_settings['theme_settings']);

        $this->company_name = $theme_settings['website_name']?$theme_settings['website_name']:config_item('company_name');

        $this->template->title(lang('logistics').' - '.$this->company_name);

        $data['page'] = lang('all_assets');

        $data['sub_page'] = lang('all_assets');

        $data['categories'] = $this->db->get_where('asset_category',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result_array();

        $data['form'] = true;

        $data['datatables'] = true;

        $user_assets = $this->db->select('*')

                                     ->from('user_assets U')

                                     ->join('asset_category AD','U.category = AD.cat_id','LEFT')

                                     ->where('U.subdomain_id',$this->session->userdata('subdomain_id'))

                                     ->get()->result_array();

        $data['all_assets'] = $user_assets;

        // echo "<pre>"; print_r($user_assets); exit;

        $this->template

                ->set_layout('users')

                ->build('all_assets', isset($data) ? $data : null);

    }



    public function add()

    {
        if($_POST)

        {

             if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {



                            $config['upload_path'] = './assets/uploads/';

                            $config['allowed_types'] = 'gif|jpg|png|jpeg';

                            $config['overwrite'] = true;



                            $this->load->library('upload', $config);



                            if ( ! $this->upload->do_upload('image')){

                                        echo $this->upload->display_errors(); exit;

                            }else{

                                $data = $this->upload->data();

                                $_POST['image'] = $data['file_name'];

                               

                            }

                }

                $_POST['subdomain_id'] = $this->session->userdata('subdomain_id');

                // echo "<pre>";print_r($_POST);die;
            // echo print_r($_POST); exit();

            $this->db->insert('user_assets',$this->input->post());

            $this->session->set_flashdata('tokbox_success', 'Asset Added Successfully');

            redirect('all_assets');

        }

    }

    public function edit($id)

    {

       // echo print_r($_FILES); exit();



       if($_POST)

        {    

         if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {

                



                            $config['upload_path'] = './assets/uploads/';

                            $config['allowed_types'] = 'gif|jpg|png|jpeg';

                            $config['overwrite'] = true;



                            $this->load->library('upload', $config);



                            if ( ! $this->upload->do_upload('image')){

                                        echo $this->upload->display_errors(); exit;

                            }else{

                                $data = $this->upload->data();

                                // print_r($data); exit;

                                $_POST['image'] = $data['file_name'];

                               

                            }

                } else {



                    $_POST['image'] = $_POST['avatar'];

                }

                unset($_POST['avatar']);

            $this->db->where('assets_id',$id);

            $this->db->update('user_assets',$this->input->post());

             // echo $this->db->last_query(); exit; 

            $this->session->set_flashdata('tokbox_success', 'Asset Updated Successfully');

            redirect('all_assets');

        }

    }



    public function delete($id)

    {

        $this->db->where('assets_id',$id);

        $this->db->delete('user_assets');

        $this->session->set_flashdata('tokbox_success', 'Asset deleted Successfully');

        redirect('all_assets');

    }

    public function check_subcategories()

    {

        $category_id = $this->input->post('category_id');

        $sub_category = $this->db->get_where('asset_subcategory',array('cat_id'=>$category_id))->result_array();

        echo json_encode($sub_category); exit;

    }

}

/* End of file all_assets.php */

