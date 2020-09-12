<?php 
class Settings extends CI_Controller{
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'settings';
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role'))?$this->session->userdata('user_role'):0;
    }
    public function index ()
    {	
	if ($this->input->post('form_submit')) {
		
		if($this->data['admin_id'] > 1){
			$this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');	
			redirect(base_url().'admin/settings');

		}else if($this->user_role == 1){

			$this->load->library('upload');
			$data = $this->input->post();
			if($_FILES['site_logo']['name'])
			{     
				$table_data1=[];
				$configfile['upload_path']   = FCPATH . 'uploads/logo';
				$configfile['allowed_types'] = 'gif|jpg|jpeg|png';
				$configfile['overwrite']     = FALSE;
				$configfile['remove_spaces'] = TRUE;
				$file_name                  = $_FILES['site_logo']['name'];
				$configfile['file_name']    = time().'_'.$file_name;
                                $image_name = $configfile['file_name'];
                                $image_url = 'uploads/logo/'.$image_name;
				$this->upload->initialize($configfile);                                
				if ($this->upload->do_upload('site_logo')) {					
                                $img_uploadurl      = 'uploads/logo'.$_FILES['site_logo']['name'];	    
                                        $key = 'logo_front';  
                                        $val = 'uploads/logo/'.$image_name;   
                                        $this->db->where('key', $key);
                                    }				
        				$this->db->delete('system_settings');
						$table_data1['key']        = $key;
						$table_data1['value']      = $val;
						$table_data1['system']      = 1;
						$table_data1['groups']      = 'config';
						$table_data1['update_date']  = date('Y-m-d');
						$table_data1['status']       = 1;
						$this->db->insert('system_settings', $table_data1);
			}
			if($_FILES['favicon']['name'])
			{  
				$img_uploadurl1 ='';
				$table_data2='';
				$table_data=[];
				$configfile['upload_path']   = FCPATH .'uploads/logo';
				$configfile['allowed_types'] = 'png|ico';
				$configfile['overwrite']     = FALSE;
				$configfile['remove_spaces'] = TRUE;
				$configfile['max_width']     = 50;
                $configfile['max_height']    = 50;
				$file_name                  = $_FILES['favicon']['name'];
				$configfile['file_name']    = $file_name;
			    $this->upload->initialize($configfile);              			
				if ($this->upload->do_upload('favicon')) 
                { 
			
                    $img_uploadurl1      = $_FILES['favicon']['name'];	
                    $key                 = 'favicon';
                    $val                 = $img_uploadurl1;
                    $select_fav_icon     = $this->db->query("SELECT * FROM `system_settings` WHERE `key` = '$key' ");
                    $fav_icon_result     = $select_fav_icon->row_array();
                    
                    if(count($fav_icon_result)>0)
                    {
                        $this->db->where('key',$key);
                        $this->db->update('system_settings',array('value'=>$val));
                    }
                    else 
                    {
                        $table_data['key']        = $key;
                        $table_data['value']      = $val;						
                        $this->db->insert('system_settings', $table_data);
                    }
                        $error = '';
                    }else{
                    	 $error = $this->upload->display_errors();
                   
                        }
			}
			if($data){
				$table_data=array();

				# paypal_option // 1 SandBox, 2 Live 
				# paypal_allow  // 1 Active, 2 Inactive  
				

				foreach ($data AS $key => $val) {

					if($key!='form_submit'){
						$this->db->where('key', $key);
        				$this->db->delete('system_settings');
						$table_data['key']        = $key;
						$table_data['value']      = $val;
						$table_data['system']      = 1;
						$table_data['groups']      = 'config';
						$table_data['update_date']  = date('Y-m-d');
						$table_data['status']       = 1;
						$this->db->insert('system_settings', $table_data);
						
					}
				}
			}                         
			
			$message = '';
			 if (!empty($error)) {
                
           	 $message.='<hr/><div class="alert alert-danger text-center fade in" id="flash_error_message">Image uploading failed '.$error.'</div>';
            }else{

			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Settings saved successfully.</div>';
            }
			 $this->session->set_flashdata('message',$message);
			redirect(base_url('admin/' . $this->data['module']));
		
		}
			}
		$results = $this->admin_panel_model->get_setting_list();
		foreach ($results AS $config) {
			$this->data[$config['key']] = $config['value'];
		}
		 
		$this->data['page'] = 'index';
		$this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    
    
    
      public function image_resize($width=0,$height=0,$image_url,$filename)
{          
    

$source_path = base_url().$image_url;
    

list($source_width, $source_height, $source_type) = getimagesize($source_path);

switch ($source_type) {
    case IMAGETYPE_GIF:
        $source_gdim = imagecreatefromgif($source_path);
        break;
    case IMAGETYPE_JPEG:
        $source_gdim = imagecreatefromjpeg($source_path);
        break;
    case IMAGETYPE_PNG:
        $source_gdim = imagecreatefrompng($source_path);
        break;
}

$source_aspect_ratio = $source_width / $source_height;
$desired_aspect_ratio = $width / $height;

if ($source_aspect_ratio > $desired_aspect_ratio) {
    /*
     * Triggered when source image is wider
     */
    $temp_height = $height;
    $temp_width = ( int ) ($height * $source_aspect_ratio);
} else {
    /*
     * Triggered otherwise (i.e. source image is similar or taller)
     */
    $temp_width = $width;
    $temp_height = ( int ) ($width / $source_aspect_ratio);
}

/*
 * Resize the image into a temporary GD image
 */

$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
imagecopyresampled(
    $temp_gdim,
    $source_gdim,
            0, 0, 
            0, 0, 
    $temp_width, $temp_height,
    $source_width, $source_height
);

/*
 * Copy cropped region from temporary image into the desired GD image
 */

$x0 = ($temp_width - $width) / 2;
$y0 = ($temp_height - $height) / 2;
$desired_gdim = imagecreatetruecolor($width, $height);
imagecopy(
    $desired_gdim,
    $temp_gdim,
    0, 0,
    $x0, $y0,
    $width, $height
);

/*
 * Render the image
 * Alternatively, you can save the image in file-system or database
 */
$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
   $image_url =  "uploads/logo/".$filename_without_extension."_".$width."_".$height.".png";    
imagejpeg($desired_gdim,$image_url);

return $image_url;
}
public function emailsettings ()
    {
		if ($this->input->post('form_submit')) {

		if($this->data['admin_id'] > 1){
			$this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');	
			redirect(base_url().'admin/settings');

		}else if($this->user_role == 1){
		

			$this->load->library('upload');
			$data = $this->input->post();
			if($data){
				$table_data= array();
				foreach ($data AS $key => $val) {
					if($key!='form_submit'){
						$this->db->where('key', $key);
        				$this->db->delete('system_settings');
						$table_data['key']        = $key;
						$table_data['value']      = $val;
						$table_data['system']      = 1;
						$table_data['groups']      = 'config';
						$table_data['update_date']  = date('Y-m-d');
						$table_data['status']       = 1;
						$this->db->insert('system_settings', $table_data);
						
					}
				}
			}                         
			}                         
			
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Settings saved successfully.</div>';
			 $this->session->set_flashdata('message',$message);
			redirect(base_url('admin/emailsettings'));
		}
		
		$results = $this->admin_panel_model->get_setting_list();
		foreach ($results AS $config) {
			$this->data[$config['key']] = $config['value'];
		}
		 
		$this->data['page'] = 'emailsettings';
		$this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
	}
	public function smtp_config()
    {
		if ($this->input->post('form_submit')) {

		if($this->data['admin_id'] > 1){
			$this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');	
			redirect(base_url().'admin/settings');

		}else if($this->user_role == 1){
				
			$this->load->library('upload');
			$data = $this->input->post();
			if($data){
				$table_data= array(); 
				foreach ($data AS $key => $val) {
					if($key!='form_submit'){
						$this->db->where('key', $key);
        				$this->db->delete('system_settings');
						$table_data['key']        = $key;
						$table_data['value']      = $val;
						$table_data['system']      = 1;
						$table_data['groups']      = 'config';
						$table_data['update_date']  = date('Y-m-d');
						$table_data['status']       = 1;
						$this->db->insert('system_settings', $table_data);
						
					}
				} 
			}                         
			}                         
			
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Settings saved successfully.</div>';
			 $this->session->set_flashdata('message',$message);
			redirect(base_url('admin/settings/smtp_config'));
		}
		
		$results = $this->admin_panel_model->smtp_setting();
		foreach ($results AS $config) {
			$this->data[$config['key']] = $config['value'];
		}
		 
		$this->data['page'] = 'smtp_config';
		$this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
	}


}
?>