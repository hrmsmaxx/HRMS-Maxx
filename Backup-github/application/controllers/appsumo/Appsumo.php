<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('phpass-0.1/PasswordHash.php');
class Appsumo extends CI_Controller {

	public function __construct(){    
    parent::__construct();
    error_reporting(0);
    $this->load->library('paypal_lib');
    // $this->load->library('phpass-0.1/PasswordHash');
    $this->load->helper('favourites');

    $this->smtp_config           = smtp_mail_config();

    $result = gigs_settings();
		


		$this->email_address='mail@example.com';

		$this->email_tittle='SMART HRMS';

		$this->logo_front=base_url().'assets/images/logo6.png';

		$this->site_name ='SMART HRMS';

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

					$this->site_name = $data['value'];

				}


				if($data['key'] == 'paypal_option'){

					$paypal_option = $data['value'];

				}
	
	 	 

			}


			if($paypal_option == 1){

				$this->paypal_id = $this->db->select('sandbox_email')->get('paypal_details')->row()->sandbox_email;

				

 			}

			if($paypal_option == 2){

				$this->paypal_id = $this->db->select('email')->get('paypal_details')->row()->email;

				

			}


	
		}
    
    $this->data['theme'] = 'appsumo';
    $this->data['module'] = 'home';
    

     }


  	public function index()
	{      
		
		if($_POST){
                $password = $this->input->post('password');
                $hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength'),
					$this->config->item('phpass_hash_portable'));
				$hashed_password = $hasher->HashPassword($password);             
                $result = array(
                    
                    'fullname' =>  $_POST['fullname'],
                    'username' =>  $_POST['username'],
                    'subscriber_email' =>  $_POST['subscriber_email'],
                    'company_name' =>  $_POST['company_name'],
                    'city' =>  $_POST['city'],
                    'country' =>  $_POST['country'],
                    'decode_password' =>  $_POST['password'],
                    'password' =>  $hashed_password,
                    'appsumo_code' =>  $_POST['appsumo_code']
                );
                if(!empty($_POST['appsumo_code'])){       
	                $this->db->insert('subscribers',$result);
	                
                	$coupon['status'] = 1;
					$this->db->where('appsumo_code',$_POST['appsumo_code']);
					$this->db->update('coupons', $coupon);

	                $otherdb = $this->load->database('otherdb', TRUE); 
	                $otherdb->insert('dgt_subscribers',$result);
	                $company_id = $otherdb->insert_id();
	               	$otherdb->where('appsumo_code',$_POST['appsumo_code']);
					$otherdb->update('dgt_coupons', $coupon);
				 	$user_table = array(
                            'username'  => $_POST['username'],
                            'password'  => $hashed_password,
                            'email'     => $_POST['subscriber_email'],
                            'role_id'   => 1,
                            'user_type' => 1,
                            'designation_id'    => 0,
                            'department_id'     => 0,
                            'is_teamlead'       => 'no',
                            'teamlead_id'       => '',
                            'subdomain_id'       => $company_id
                        );


                     	$otherdb->insert('dgt_users',$user_table);
                        $last_user_id =  $otherdb->insert_id();


                        $account_table = array(
                            'user_id'   => $last_user_id,
                            'company'   => '-',
                            'fullname'  => $_POST['fullname'],
                            'gender'    => 'male',
                            'doj'    	=> date('Y-m-d'),
                            'city'      => $_POST['city'],
                            'country'   => $_POST['country'],
                            'state'     => '',
                            'address'   => '',
                            'pincode'   => '',
                            'phone'     => '',
                            'avatar'    => 'default_avatar.jpg',
                            'language'  => config_item('default_language') ? config_item('default_language') : 'english',
                            'locale'    => config_item('locale') ? config_item('locale') : 'en_US'
                        );
                        $otherdb->insert('dgt_account_details',$account_table);
                       	$subscriber_appsumo_code = array(
                            'subscriber_id'   => $company_id,                            
                            'appsumo_code'   => $_POST['appsumo_code'],                            
                            'created'    	=> date('Y-m-d')
                            
                        );
	                	$otherdb->insert('dgt_subscriber_appsumo_code',$subscriber_appsumo_code);
	                $this->session->set_flashdata('tokbox_success', 'Subscribed successfully!');
	                header("Location: http://localhost/lite-hrmsmaxx/");
	            }else{	            	
	            	$this->session->set_flashdata('tokbox_error', 'Please apply your AppSumo Code!');
	            }
            }
		$data['title'] = "Registration Form";
		// $this->load->vars($this->data);
		
		$this->load->view('appsumo/register_form',$data);
	}
	public function dashboard()
	{  		
		if (!empty($this->session->userdata['id'])) 
        {
			$data['title'] = 'Subscribed Companies';
			$data['page'] = 'subscribed_companies';
			$this->load->view('superadmin/layouts/header',$data);
			$this->load->view('superadmin/subscribed_companies',$data);
			$this->load->view('superadmin/layouts/footer',$data);
		}else{
			redirect('admin');
		}
		// $this->load->view('appsumo/includes/footer');
	}
	public function coupon_management()
	{  		
		$data['title'] = 'Coupon Management';
		$data['page'] = 'coupon_management';
		$this->load->view('superadmin/layouts/header',$data);
		$this->load->view('superadmin/coupons',$data);
		$this->load->view('superadmin/layouts/footer',$data);

		// $this->load->view('appsumo/includes/footer');
	}
	public function data_import(){

        //upload folder path defined here 

        $config['upload_path'] =  './uploads/';

    //Only allow this type of extensions 
        $config['allowed_types'] = 'xlsx|csv';

        $this->load->library('upload', $config);

    // if any error occurs 

        if ( ! $this->upload->do_upload('data_import'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->session->set_flashdata('tokbox_error', $error);
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
            $objPHPExcel = $objReader->load('uploads/'.$file_name);
            $sheetnumber = 0;

            foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
            {

                $s = $sheet->getTitle();    // get the sheet name 

                $sheet= str_replace(' ', '', $s); // remove the spaces between sheet name 
                $sheet= strtolower($sheet); 
                $objWorksheet = $objPHPExcel->getSheetByName($s);

                $lastRow = $objPHPExcel->setActiveSheetIndex($sheetnumber)->getHighestRow(); 
                $sheetnumber++;
                //loop from first data until last data
                for($j=1; $j<=$lastRow; $j++)
                {
                    
                    $appsumo_code = $objWorksheet->getCellByColumnAndRow(0,$j)->getValue();
                   

                    
// echo  $email; exit;
                    
                    if($appsumo_code != '')
                    {                  
                        
                        $result = $this->db->get_where('coupons',array('appsumo_code'=>$appsumo_code))->num_rows();     
                        // echo "<pre>";  count($result_email); exit;
                        if($result == 0){
                                  $excel = array(
                                        'appsumo_code'=>$appsumo_code
                                    );      
                                     // echo "<pre>"; print_r($excel); exit();                           
                                $this->db->insert('coupons',$excel); 
                                $otherdb = $this->load->database('otherdb', TRUE); 
                				$otherdb->insert('coupons',$excel);
                                // echo "<pre>"; print_r($this->db->last_query()); exit();
                                $insert_id = $this->db->insert_id();                              
                        }
                    } 

                }// loop ends 

            }
            // exit;
            $this->session->set_flashdata('tokbox_success', 'Imported Successfully');
            redirect('coupon_management');
        }


    }

	public function check_company_name()
    {
        $company_name = strtolower($this->input->post('company_name'));
        $res = $this->db->get_where('subscribers',array('company_name'=>$company_name))->result_array();
        echo count($res); exit;
    }

    public function check_subscriberemail()
    {
        $subscriber_email = $this->input->post('subscriber_email');
        $res = $this->db->get_where('subscribers',array('subscriber_email'=>$subscriber_email))->result_array();
         if(count($res) == 0){ 
        	$otherdb = $this->load->database('otherdb', TRUE); 	       	
        	$res = $otherdb->get_where('dgt_users',array('email'=>$subscriber_email))->result_array();
        }
        echo count($res); exit;
    }

    public function check_subscribe_username()
    {
        $subscribe_username = $this->input->post('subscribe_username');
        $res = $this->db->get_where('subscribers',array('username'=>$subscribe_username))->result_array();
        if(count($res) == 0){ 
        	$otherdb = $this->load->database('otherdb', TRUE); 	       	
        	$res = $otherdb->get_where('dgt_users',array('username'=>$subscribe_username))->result_array();
        }
        echo count($res); exit;
    }
    public function check_appsumo_code()
    {
        $appsumo_code = $this->input->post('appsumo_code');
        $res = $this->db->get_where('dgt_coupons',array('appsumo_code'=>$appsumo_code,'status'=>0))->result_array();
        echo count($res); exit;
    }
	public function services()
	{      
		$this->data['page'] = 'services';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function pricing()
	{      
		$this->data['page'] = 'pricing';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function core_hr_software()
	{      
		$this->data['page'] = 'core_hr_software';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function payroll_software()
	{      
		$this->data['page'] = 'payroll_software';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function leave_management_software()
	{      
		$this->data['page'] = 'leave_management_software';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function attendance_management_software()
	{      
		$this->data['page'] = 'attendance_management_software';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function employee_self_service_portal()
	{      
		$this->data['page'] = 'employee_self_service_portal';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	
	public function mobile_app()
	{      
		$this->data['page'] = 'mobile_app';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function ats()
	{      
		$this->data['page'] = 'ats';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function crm()
	{      
		$this->data['page'] = 'crm';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function projects()
	{      
		$this->data['page'] = 'projects';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function cloud_computing()
	{      
		$this->data['page'] = 'cloud_computing';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function payment()
	{
		date_default_timezone_set('Asia/Kolkata'); 
		$current_time= date('Y-m-d H:i:s');
		$data=array();
		$data['email']=$this->input->post('email');
		$data['name']=$this->input->post('name');
		$data['companyname']=$this->input->post('companyname');
		$data['mobileno']=$this->input->post('phoneno');
		$data['amount']=$this->input->post('price');
		$data['country']=$this->input->post('country');
		$data['created_at']=$current_time;

		$amount=$data['amount'];

		if ($this->db->insert('sales',$data)){

			$id=$this->db->insert_id(); 

			$this->buy($id,$amount);
			
		}


	}

	private function buy($id,$amount){

		//Set variables for paypal form

		$returnURL =base_url('paypal-success'); //payment success url

		$cancelURL = base_url('paypal-cancel'); //payment cancel url

		
		$name = $this->site_name;

		$this->paypal_lib->add_field('return', $returnURL);

		$this->paypal_lib->add_field('cancel_return', $cancelURL);

		$this->paypal_lib->add_field('notify_url', $notifyURL);

		$this->paypal_lib->add_field('item_name', $name);

		$this->paypal_lib->add_field('custom', '');

		$this->paypal_lib->add_field('item_number',  $id);

		$this->paypal_lib->add_field('amount',  $amount);		

		$this->paypal_lib->add_field('currency_code', 'USD');	

		$this->paypal_lib->add_field('business', $this->paypal_id);	
		
		$this->paypal_lib->paypal_auto_form();

	}


	public function paypal_success(){

			    //get the transaction data

	    if(isset($_POST["txn_id"]) && !empty($_POST["txn_id"]))
	    {
	    	$paypalInfo =  $this->input->post();
	    	$txn_id= $paypalInfo['txn_id']; 
	    	$item_number=$paypalInfo['item_number']; 
	    }
	    else
	    {
	    	$paypalInfo =  $this->input->get();
	    	$txn_id= $paypalInfo['tx']; 
	    	$item_number=$paypalInfo['item_number'];
	    }


		$table_data['txn_id'] = $txn_id;

		$table_data['payment_status'] = 1;

		$uid = $item_number;               

		$this->db->where('id',$uid);

		if($this->db->update('sales', $table_data))
		{
			redirect('success');
		}


    }

    public function success()
    {
    	$this->load->view('user/success');
    }


    public function paypal_cancel(){

			redirect(base_url());

		}


		public function contactus_send_mail()
		{
		  
			date_default_timezone_set('Asia/Kolkata'); 
		$current_time= date('Y-m-d H:i:s');
		$data=array();
		$demo_date = date('Y-m-d',strtotime($this->input->post('demo_date')));
		$data['type']=$this->input->post('type');
		$data['demo_date']=$demo_date;
		$data['demo_time']=$this->input->post('demo_time')?$this->input->post('demo_time'):0;
		$data['contactname']=$this->input->post('contactname');
		$data['contactemail']=$this->input->post('contactemail');
		$data['contactcompanyname']=$this->input->post('contactcompanyname');
		$data['contactpincode']=$this->input->post('contactpincode');
		$data['contactphone']=$this->input->post('contactphone');
		$data['contactcountry']=$this->input->post('contactcountry');
		$data['contactmessage']=$this->input->post('contactmessage');
		$data['created_at']=$current_time;
		$data['ip']=$_SERVER['REMOTE_ADDR'];
		if ($this->db->insert('contactus',$data)){


			 $this->load->model('templates_model');

        $message='';
        $message1='';

        $welcomemessage='';

        
        $bodyid1=3;

       	
        $tempbody_details1= $this->templates_model->get_usertemplate_data($bodyid1);		 

       	$body1=$tempbody_details1['template_content'];

       	$body1 = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body1);

        $body1= str_replace('{USER_NAME}', ucfirst($data['contactname']), $body1);

        $body1= str_replace('{COMPANY_NAME}', $data['contactcompanyname'], $body1);
        $body1= str_replace('{DEMO_DATE}', $data['demo_date'], $body1);

        $body1= str_replace('{DEMO_TIME}', $data['demo_time'], $body1);
        $body1= str_replace('{DEMO_EMAIL}', $data['contactemail'], $body1);
        $body1= str_replace('{DEMO_PNONE_NUMBER}', $data['contactphone'], $body1);
        $body1= str_replace('{DEMO_COUNTRY}', $data['contactcountry'], $body1);

        // $body1 = str_replace('{type}', $data['type'], $body);

        $body1 = str_replace('{sitetitle}',$this->site_name, $body1);

        $message1 ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

			<tr>

				<td></td>

				<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">

					<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

						<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">

							<tr>

								<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

									<table width="100%" cellpadding="0" cellspacing="0">

										<tr>

											<td style="text-align:center;">

												<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

											</td>

										</tr>

										<tr>

											<td>'.$body1.'</td>

										</tr>

									</table>

								</td>

							</tr>

						</table>

						<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

							<table width="100%">

								<tr>

									<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

										&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

									</td>

								</tr>

							</table>

						</div>

					</div>

				</td>

			</tr>

		</table>';  

		 $this->load->helper('file');  

         $this->load->library('email');
         $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle); 

        $this->email->to($this->email_address); 

        $this->email->subject('Demo requesting '.$this->site_name);

        $this->email->message($message1);
        $this->email->send();
         // echo"<pre>";print_r($this->smtp_config); exit;
        // if(){            

                // echo "<pre>"; print_r('To -'.$data['contactemail'].'from-'.$this->email_address); exit;

               //  echo 1; exit;

		  // }
		  // else
		  // {

		  	// $error = $this->email->print_debugger();
		   //  var_dump($error);
		   //  echo"<pre>";print_r($error); exit;
		    // echo 2;
		  // }

		$bodyid=1;

 		$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);	

		$body=$tempbody_details['template_content'];

		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{USER_NAME}', ucfirst($data['contactname']), $body);

        $body = str_replace('{type}', $data['type'], $body);

        $body = str_replace('{sitetitle}',$this->site_name, $body);

      
		$message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

			<tr>

				<td></td>

				<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">

					<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

						<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">

							<tr>

								<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

									<table width="100%" cellpadding="0" cellspacing="0">

										<tr>

											<td style="text-align:center;">

												<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

											</td>

										</tr>

										<tr>

											<td>'.$body.'</td>

										</tr>

									</table>

								</td>

							</tr>

						</table>

						<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

							<table width="100%">

								<tr>

									<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

										&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

									</td>

								</tr>

							</table>

						</div>

					</div>

				</td>

			</tr>

		</table>';  				 
 

        $this->load->helper('file');  

         $this->load->library('email');
         $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle); 

        $this->email->to($data['contactemail']); 

        $this->email->subject('Thanks for requesting '.$this->site_name);

        $this->email->message($message);
         // echo"<pre>";print_r($this->smtp_config); exit;
        if($this->email->send()){            

                // echo "<pre>"; print_r('To -'.$data['contactemail'].'from-'.$this->email_address); exit;

                 echo 1; exit;

		  }
		  else
		  {

		  	$error = $this->email->print_debugger();
		    var_dump($error);
		    echo"<pre>";print_r($error); exit;
		    // echo 2;
		  }

			
		}

		}

		function subscribe_mail(){
			$to_email = $this->input->post('email');

			$this->load->model('templates_model');

        $message='';

        $welcomemessage='';

        $bodyid=2;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);		 

        $body=$tempbody_details['template_content'];
        

		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        // $body = str_replace('{USER_NAME}', ucfirst($data['contactname']), $body);

        // $body = str_replace('{type}', $data['type'], $body);

        $body = str_replace('{sitetitle}',$this->site_name, $body);

      
		$message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

			<tr>

				<td></td>

				<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 
						<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">auto;" valign="top">
1; margin: 0 auto; padding: 20px;">


							<tr>

								<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

									<table width="100%" cellpadding="0" cellspacing="0">

										<tr>

											<td style="text-align:center;">

												<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

											</td>

										</tr>

										<tr>

											<td>'.$body.'</td>

										</tr>

									</table>

								</td>

							</tr>

						</table>

						<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

							<table width="100%">

								<tr>

									<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

										&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

									</td>

								</tr>

							</table>

						</div>

					</div>

				</td>

			</tr>

		</table>';  				 
 

        $this->load->helper('file');  

         $this->load->library('email');
         $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle); 

        $this->email->to($to_email); 

        $this->email->subject('Thanks for Subscribing '.$this->site_name);

        $this->email->message($message);
        $this->email->send();
         // echo"<pre>";print_r($this->smtp_config); exit;
    //     if($this->email->send()){            

    //             // echo "<pre>"; print_r('To -'.$data['contactemail'].'from-'.$this->email_address); exit;

    //              echo 1; exit;

		  // }
		  // else
		  // {

		  // 	$error = $this->email->print_debugger();
		  //   var_dump($error);
		  //   echo"<pre>";print_r($error); exit;
		  //   // echo 2;
		  // }


     	$message1='';

        

        $bodyid=4;

        $tempbody_details1= $this->templates_model->get_usertemplate_data($bodyid);		 

        $body1=$tempbody_details1['template_content'];
        

		$body1 = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body1);

        // $body = str_replace('{USER_NAME}', ucfirst($data['contactname']), $body);

        // $body = str_replace('{type}', $data['type'], $body);

        $body1 = str_replace('{sitetitle}',$this->site_name, $body1);
        $body1 = str_replace('{EMAIL}',$to_email, $body1);

      
		$message1 ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

			<tr>

				<td></td>

				<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">

					<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

						<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">

							<tr>

								<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

									<table width="100%" cellpadding="0" cellspacing="0">

										<tr>

											<td style="text-align:center;">

												<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

											</td>

										</tr>

										<tr>

											<td>'.$body1.'</td>

										</tr>

									</table>

								</td>

							</tr>

						</table>

						<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

							<table width="100%">

								<tr>

									<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

										&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

									</td>

								</tr>

							</table>

						</div>

					</div>

				</td>

			</tr>

		</table>';  				 
 

        $this->load->helper('file');  

         $this->load->library('email');
         $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle); 

        $this->email->to($this->email_address); 

        $this->email->subject('Subscribing Request '.$this->site_name);

        $this->email->message($message1);
         // echo"<pre>";print_r($this->smtp_config); exit;
        if($this->email->send()){            

                // echo "<pre>"; print_r('To -'.$data['contactemail'].'from-'.$this->email_address); exit;

                 echo 1; exit;

		  }
		  else
		  {

		  	$error = $this->email->print_debugger();
		    var_dump($error);
		    echo"<pre>";print_r($error); exit;
		    // echo 2;
		  }

		}


		function feature(){
			$this->load->view('feature');
		}
		
		function core_hr(){
			$this->load->view('core_hr');
		}
		
		function payroll(){
			$this->load->view('payroll');
		}
		
		function leave(){
			$this->load->view('leave');
		}
		
		function attendance(){
			$this->load->view('attendance');
		}
		
		function employee_self(){
			$this->load->view('employee_self');
		}
		
		// function mobile_app(){
		// 	$this->load->view('mobile_app');
		// }


}
