<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fomailer extends MX_Controller {

	function __construct()
	{
		parent::__construct();

		
    	
		$email_settings = $this->db->get_where('subdomin_email_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
		$emails = unserialize($email_settings['email_settings']);


	    $general_settings = $this->db->get_where('subdomin_general_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
	    $general = unserialize($general_settings['general_settings']);
	    
	    $this->company_name = $general['company_name']?$general['company_name']:config_item('company_name');
		   
	    $this->company_email = $emails['company_email']?$emails['company_email']:config_item('company_email');
	    $this->use_alternate_emails = $emails['use_alternate_emails']?$emails['use_alternate_emails']:config_item('use_alternate_emails');
	    $billing_email = $emails['billing_email']?$emails['billing_email']:'';
	    $billing_email_name = $emails['billing_email_name']?$emails['billing_email_name']:'';
	    $support_email = $emails['support_email']?$emails['support_email']:'';
	    $support_email_name = $emails['support_email_name']?$emails['support_email_name']:'';
	    $this->postmark_api_key = $emails['postmark_api_key']?$emails['postmark_api_key']:config_item('postmark_api_key');
	    $this->postmark_from_address = $emails['postmark_from_address']?$emails['postmark_from_address']:config_item('postmark_from_address');
	    $this->protocol = $emails['protocol']?$emails['protocol']:config_item('protocol');
	    $this->smtp_host = $emails['smtp_host']?$emails['smtp_host']:config_item('smtp_host');
	    $this->smtp_user = $emails['smtp_user']?$emails['smtp_user']:config_item('smtp_user');
	    $this->smtp_pass = $emails['smtp_pass']?$emails['smtp_pass']:config_item('smtp_pass');
	    $this->smtp_port = $emails['smtp_port']?$emails['smtp_port']:config_item('smtp_port');
	    $smtp_encryption = $emails['smtp_encryption']?$emails['smtp_encryption']:'';
	     
	}

	function send_email($params)
	{
		if(config_item('disable_emails') == 'FALSE'){

		// If postmark API is being used
		if(config_item('use_postmark') == 'TRUE'){
			$config = array('api_key' => $this->postmark_api_key);
        	$this->load->library('postmark',$config);
        	
        	$this->postmark->from($this->postmark_from_address, $this->company_name);
        	
        	if ($this->use_alternate_emails == 'TRUE' && isset($params['alt_email'])) {
                        $alt = $params['alt_email'];
                            if (config_item($alt.'_email') != '') {
                                $this->postmark->from(config_item($alt.'_email'), config_item($alt.'_email_name'));
                            }
                }

			$this->postmark->to($params['recipient']);
			$this->postmark->subject($params['subject']);
			$this->postmark->message_plain($params['message']);
			$this->postmark->message_html($params['message']);

			// Check attached file
			if(isset($params['attachment_url'])){ 
					$this->postmark->attach($params['attached_file']);
				}
        	return $this->postmark->send();

    	}else{
    		// If using SMTP
				if ($this->protocol == 'smtp') {
					
					$this->load->library('encrypt');
					// $raw_smtp_pass =  $this->encrypt->decode($this->smtp_pass);
					$config = array(
							'smtp_host' => $this->smtp_host,
							'smtp_port' => $this->smtp_port,
							'smtp_user' => $this->smtp_user,
							'smtp_pass' => $this->smtp_pass,
							'crlf' 		=> "\r\n",   		
							'SMTPAuth' => true,					
							'protocol'	=> $this->protocol,
					);						
				}

				// print_r($config);die;	

				$this->load->library('email');
				// Send email 
				$config['mailtype'] = "html";
				$config['newline'] = "\r\n";
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				
    			$this->email->initialize($config);

				$this->email->from($this->company_email, $this->company_name);
                                
                if ($this->use_alternate_emails == 'TRUE' && isset($params['alt_email'])) {
                        $alt = $params['alt_email'];
                            if (config_item($alt.'_email') != '') {
                                $this->email->from(config_item($alt.'_email'), config_item($alt.'_email_name'));
                            }
                }
                                
				$this->email->to($params['recipient']);
				
				if (isset($params['cc'])) {
					$this->email->cc($params['cc']);
				}
				$this->email->subject($params['subject']);
				$this->email->message($params['message']);
				// check attachments
				    if($params['attached_file'] != ''){ 
				    	$this->email->attach($params['attached_file']);
				    }

				   
				// Queue emails
				if(!$this->email->send()){
					 // echo $this->email->print_debugger();die;
					// echo "mail send error";die;
					$this->send_later($params['recipient'],$this->company_email,$params['subject'],$params['message']);
				}


    	}

    }else{
    	// Emails disabled
    	return TRUE;
    }
	
	}

	/**
	 * send_later
	 *
	 * Log unsent emails to be completed via CRON
	 *
	 * @access	private
	 * @param	email params
	 * @return	boolean	
	 */
	 
		private function send_later($to,$from,$subject,$message)
		{
			if(is_array($to)){
				$to = explode(',', $to);
			}
			$emails = array(
							'sent_to' 		=> $to,
							'sent_from' 	=> $from,
							'subject'		=> $subject,
							'message'		=> $message
							);
			$this->db->insert('outgoing_emails',$emails);
			return TRUE;
		}
}

/* End of file fomailer.php */