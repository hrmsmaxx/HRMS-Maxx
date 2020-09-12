<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

	public function __construct() {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        $this->load->helper('security');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load session library
        $this->load->library('session');
        
        // Load database
        $this->load->model('login_database');
        
        // if (isset($this->session->userdata['logged_in'])) {
        //     $data['base_url'] = ($this->session->userdata['logged_in']['domain_name']);
        // }
        // else{
        //      $data['base_url']= base_url();
        // }
       $this->load->helper('favourites');
        $this->smtp_config           = smtp_mail_config();

    $result = gigs_settings();
		

		$this->email_address='mail@example.com';

		$this->email_tittle='Sub Domain Login';

		$this->logo_front=base_url().'assets/images/logo.png';

		$this->site_name ='Yvan HRMS';

		$this->base_domain = base_url();

		$this->paypal_id='';
		$paypal_option='';

		if(!empty($result))

		{

			foreach($result as $data){

				if($data['key'] == 'email_address'){

					$this->email_address = !empty($data['value']) ? $data['value'] : 'mail@example.com' ;

				}

				if($data['key'] == 'email_tittle'){

					$this->email_tittle = !empty($data['value']) ? $data['value'] : 'Gigs' ;

				}

				
				if($data['key'] == 'logo_front'){

					$this->logo_front = base_url().$data['value'];

				}

				if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

					$this->site_name = 'Yvan HRMS';

				}
			}
		}
    }

    // Show login page
    public function index() {
        
       // $base = base_url();
       
    //     $info = parse_url(base_url());
    //     $host = $info['host'];
    //      $main = explode('.',$host);
    //      $domain = $main[1].'.'.$main[2];
       // print_r($this->session->userdata()); exit;
        $this->load->view('login_form',isset($data) ? $data : NULL);
    }
    
    // Show registration page
    public function user_registration_show() {
        $this->load->view('registration_form',isset($data) ? $data : NULL);
    }
    
    // Validate and store registration data in database
    public function new_user_registration() {
        $domain = str_replace("www.","", $_SERVER['HTTP_HOST']);
        $u_name=$this->input->post('username');
	    $subdomain =$u_name.'.'.$domain;    
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_value', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registration_form');
        } else {
        	
            $data = array(
            'user_name' => $subdomain,
            'user_email' => $this->input->post('email_value'),
            'user_password' => $this->input->post('password')
            );
            $result = $this->login_database->registration_insert($data);
            if ($result == TRUE) {
                
                	$message ='Hello,<br><br> This is Your Username = <b>'.$u_name.'</b> Password = <b>'.$this->input->post('password').'<b><br> Please click the link <a href="https://'.$u_name.'.newhrms.com/registration/" target="_blank">Login</a>';
           
           $this->load->helper('file');  

         $this->load->library('email');
         $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        
       // print_r($this->input->post('email_value'));exit; 

        $this->email->from($this->email_address,$this->email_tittle); 

        $this->email->to($this->input->post('email_value')); 

        $this->email->subject('Thanks for Subscribe '.$this->site_name);

        $this->email->message($message);
        
        if($this->email->send()){            

               $data['message_display'] = 'Registration Successfully !';
               echo '<script>window.location.href="https://'.$subdomain.'/registration"</script>';
              $this->load->view('login_form', isset($data) ? $data : NULL);

              }
              else
              {
              	$error = $this->email->print_debugger();
                var_dump($error);
              }

           
            } else {
            $data['message_display'] = 'Username already exist!';
            $this->load->view('registration_form', isset($data) ? $data : NULL);
            }
        }
    }
    
    // Check for user login process
    public function user_login_process() {
       // print_r($_SERVER['HTTP_HOST']); exit;
     // $domain = str_replace("www.","", $_SERVER['HTTP_HOST']);
      $base = base_url();
       
        $info = parse_url(base_url());
        $host = $info['host'];
         $main = explode('.',$host);
         $domain = $main[1].'.'.$main[2];
       //print_r($domain); exit;
        $u_name=$this->input->post('username');
	    $subdomain =$u_name.'.'.$domain;   
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
    
        if ($this->form_validation->run() == FALSE) {
            if(isset($this->session->userdata['logged_in'])){
                $this->load->view('admin_page',isset($data) ? $data : NULL);
            }else{
                $this->load->view('login_form',isset($data) ? $data : NULL);
            }
        } else {
             
            $data = array(
            'username' =>  $subdomain,
            'password' => $this->input->post('password')
            );
            //print_r($data); exit;
            $result = $this->login_database->login($data);
            if ($result == TRUE) {
           
                $username =  $subdomain;
                $result = $this->login_database->read_user_information($username);
                if ($result != false) {
                    $session_data = array(
                    'username' => $result[0]->user_name,
                    'domain_name' => $result[0]->user_name,
                    'email' => $result[0]->user_email,
                    );
                    // Add user data in session
                    $this->session->set_userdata('logged_in', $session_data);
                   
                  echo '<script>window.location.href="https://'.$subdomain.'"</script>';
                    //redirect($this->session->userdata['logged_in']['username'].'/admin');
                    $this->load->view('admin_page',$data);
                    
                }
            } else {
            $data = array(
            'error_message' => 'Invalid Username or Password'
            );
            $this->load->view('login_form', $data);
            }
        }
    }
    
    // Logout from admin page
    public function logout() {
    
        // Removing session data
        $sess_array = array(
        'username' => '',
        'domain_name' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $this->session->sess_destroy();
       // print_r($this->session->userdata()); exit;
       $info = parse_url(base_url());
        $host = $info['host'];
         $main = explode('.',$host);
         $domain = $main[1].'.'.$main[2];
   echo '<script>window.location.href="https://www.'.$domain.'"</script>';
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('login_form', isset($data) ? $data : NULL);
    }

}

?>
