<?php 

  if(!function_exists('gigs_settings')){
  
  function gigs_settings(){
      $ci =& get_instance();
      $query = $ci->db->query("select * from system_settings WHERE status = 1");
      return  $query->result_array();
     }
}


if(!function_exists('gigs_admin_email')){
  
  function gigs_admin_email(){
      $ci =& get_instance();
       $ci->load->database();
      return $ci->db->select('email')->get('administrators')->row()->email;
     }
}

if(!function_exists('smtp_mail_config')){

  function smtp_mail_config(){ 
      $config = array(
         'protocol'  => 'smtp',
           'mailtype'  => 'html',
           'charset'   => 'utf-8'
         );
     $ci =& get_instance();
     $ci->load->database();
     $ci->db->select('key,value,system,groups');
     $ci->db->from('system_settings');
     $query = $ci->db->get();
     $results = $query->result();

      $smtp_host = '';
      $smtp_port = '';
      $smtp_user = '';
      $smtp_pass = '';
     if(!empty($results)){
      foreach ($results as $result) {
        $result = (array)$result;
        if($result['key'] == 'smtp_host'){
          $smtp_host = $result['value'];
        }
        if($result['key'] == 'smtp_port'){
          $smtp_port = $result['value'];
        }
        if($result['key'] == 'smtp_user'){
          $smtp_user = $result['value'];
        }
        if($result['key'] == 'smtp_pass'){
          $smtp_pass = $result['value'];
        }
      }

      if(!empty($smtp_host) && !empty($smtp_port) && !empty($smtp_user) && !empty($smtp_pass)){
         $config = array(
           'protocol'  => 'smtp',
           'smtp_host' => 'ssl://'.$smtp_host,
           'smtp_port' => $smtp_port,
           'smtp_user' => "$smtp_user",
           'smtp_pass' => "$smtp_pass",
           'mailtype'  => 'html',
           'charset'   => 'utf-8'
         );
      }
      }
      return  $config;    
    }

 }





?>