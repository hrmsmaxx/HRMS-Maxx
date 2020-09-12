<?php 
class Profile extends CI_Controller{
    public function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'profile';
        $this->load->model('admin_panel_model');
        $this->member_id = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role'))?$this->session->userdata('user_role'):0;

    }
    
    public function image_resize($width=0,$height=0,$image_url,$filename){          
        
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
   $image_url =  "uploads/user_images/".$filename_without_extension."_".$width."_".$height.".jpg";    
imagejpeg($desired_gdim,$image_url);

return $image_url;

/*
 * Add clean-up code here
 */
} 

    
    public function password()
	{
		 if ($this->input->post('form_submits')) { 

          if($this->member_id > 1){
            
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
              redirect(base_url($this->data['theme'] . '/' . $this->data['module']));

           }else if($this->user_role == 1){  

            $old_password = trim($this->input->post('old_password'));
            $confirm_password = trim($this->input->post('new_password'));
            if(!empty($old_password))
            {
            $table_data['password'] = md5($confirm_password);            
            }
			 $this->db->update('administrators', $table_data, "ADMINID = " . $this->session->userdata['id']);  
			  $message="<div class='alert alert-danger text-center fade in' id='flash_succ_message'>Password successfully changed.</div>";		 
             $this->session->set_flashdata('message',$message);			 
             redirect(base_url($this->data['theme'] . '/' . $this->data['module']));
            }
	}
	  $this->data['content'] = $this->admin_panel_model->get_admin_profile($this->session->userdata['id']);
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
	}
    public function index()
    {
        if (!isset($this->session->userdata['id'])) {
            redirect(base_url($this->data['theme']));
        }
        if ($this->input->post('form_submit')) {  

            if($this->member_id > 1){
            
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
                redirect(base_url($this->data['theme'] . '/' . $this->data['module']));             

           }else if($this->user_role == 1){ 

            if(!empty($old_password))
            {
            $table_data['password'] = md5($confirm_password);            
            }
            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['admin_profile']['name']) && !empty($_FILES['admin_profile']['name'])) {
                $uploaded_file_name = $_FILES['admin_profile']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/user_images/', 'admin_profile', time().$filename);    
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {             
            $image_url='uploads/user_images/'.$uploaded_file_name;    
            $table_data['profile_picture'] = $image_url;            
            $table_data['profile_thumb'] = $this->image_resize(100,100,$image_url,$filename);
                }
            }
            }
            $table_data['name'] = $this->input->post('name');            
            $table_data['email'] = $this->input->post('email');    
            $this->db->update('administrators', $table_data, "ADMINID = " . $this->session->userdata['id']); 
             $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Profile  successfully changed</div>";
				$this->session->set_flashdata('message',$message);				
				redirect(base_url($this->data['theme'] . '/' . $this->data['module']));				
         }
		}
            
        $this->data['content'] = $this->admin_panel_model->get_admin_profile($this->session->userdata['id']);
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
}
?>