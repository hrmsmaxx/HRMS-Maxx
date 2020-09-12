<?php 
class admin_panel_model extends CI_Model
{
    public function is_valid_login($username,$password)
   {

        $this->db->select('ADMINID,user_role');
        $this->db->from('administrators');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $result = $this->db->get()->row_array();
       
       /* $query = $this->db->query("SELECT ADMINID,user_role FROM `administrators` WHERE `username` = '".$username."' AND `password` = '".md5($password)."'; ");
	   $result = $query->row_array();*/

        return $result;        
            }    
    public function is_valid_password($id,$password){


        $this->db->select('ADMINID,user_role');
        $this->db->from('administrators');
        $this->db->where('ADMINID', $id);
        $this->db->where('password', md5($password));
        $result = $this->db->get()->row_array();
        
        /* $query = $this->db->query("SELECT ADMINID FROM `administrators` WHERE `ADMINID` = '".$id."' AND `password` = md5('".$password."'); ");
        $result = $query->num_rows(); */        
        
        return $result;        
            }

     public function site_name()
    {
        $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'website_name';");
        $result = $query->row_array();
        return $result;              
    } 

    public function get_setting_list() {
        $data = array();
        $stmt = "SELECT a.*"
                . " FROM system_settings AS a"
                . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }  

    public function smtp_setting() {
       $data = array();
       $stmt = "SELECT * FROM system_settings ORDER BY id ASC";
       $query = $this->db->query($stmt);
       if ($query->num_rows()) {
           $data = $query->result_array();
       }
       return $data;
   }

        public function edit_paypal_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `paypal_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;                
    } 

     public function get_admin_profile($id)
    {
        $query = $this->db->query("SELECT * FROM `administrators` WHERE `ADMINID` = $id");
        $result = $query->row_array(); 
        return $result;                            
    } 

    public function get_demo()
    {        
        $query = $this->db->query("SELECT * FROM `contactus` WHERE `type` = 'Demo'");
        $result = $query->result_array();
        return $result;                  
    }

    public function get_quote()
    {        
        $query = $this->db->query("SELECT * FROM `contactus` WHERE `type` = 'Quote'");
        $result = $query->result_array();
        return $result;                  
    }  

    public function get_sales()
    {        
        $query = $this->db->query("SELECT * FROM `sales` WHERE `payment_status` = '1'");
        $result = $query->result_array();
        return $result;                  
    }   
     
            
}
?>