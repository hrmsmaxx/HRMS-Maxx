<style>
#excel_table {
  
  border-collapse: collapse;
  width: 100%;
}

#excel_table td, #excel_table th {
  border: 1px solid #3a3a3a;
  padding: 8px;
}

/*#excel_table tr:nth-child(even){background-color: #f2f2f2;}

#excel_table tr:hover {background-color: #ddd;}*/

#excel_table th {
  padding-top: 12px;
  padding-bottom: 12px;
 
}
</style>
<?php 
 $system_settings = $this->db->get_where('subdomin_system_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
  $systems = unserialize(base64_decode($system_settings['system_settings']));
  $time_zone = $systems['timezone']?$systems['timezone']:config_item('timezone');
date_default_timezone_set($time_zone);
?>
<table style="vertical-align: middle !important;text-align: center; border-collapse: collapse;width: 100%; padding: 8px;">

  <tr style="background-color:#c6e0b3">
    <td><?php echo lang('employee');?></td>
    <td><?php echo (isset($user_id) && !empty($user_id))?ucfirst(user::displayName($user_id)):"All"?></td>
    <td><?php echo lang('department');?></td>
    <td style="text-align: left;"><?php echo (isset($department_id) && !empty($department_id))?ucfirst(user::GetDepartmentNameById($department_id)):"All"?></td>
    <td colspan="3"></td>
    
  </tr>
  <tr style="background-color:#c6e0b3">
    
    <td><?php echo lang('designation');?></td>
    <td style="text-align: left;"><?php echo (isset($designation_id) && !empty($designation_id))?ucfirst(user::GetDesignationNameById($designation_id)):"All"?></td>
    <td><?php echo lang('export_date');?></td>
    <td style="text-align: left;"><?php echo date('Y-m-d H:i');?></td>
    <td colspan="3"></td>
  </tr>
  
</table>
<table id="table-absences_report" class="" style="vertical-align: middle !important;text-align: center; border-collapse: collapse;width: 100%;border: 1px solid #3a3a3a; padding: 8px;">
           <!--  <thead>
              
            </thead> -->
<tbody>
  <tr class="" style="vertical-align: middle !important;background-color:#24b23c">    
    <th><b><?php echo lang('s_no')?></b></th>
    <th><b><?php echo lang('id_code')?></b></th>  
    <th><b><?php echo lang('name')?></b></th>  
    <!-- <th><b><?php echo lang('company')?></b></th> -->
    <th><b><?php echo lang('email')?></b></th>
    <th><b><?php echo lang('department')?></b></th>
    <th><b><?php echo lang('designation')?></b></th>
    <th class="col-title "><b><?=lang('status')?></b></th>         
  </tr>   
 


                    
 <?php $i =1 ; 
  foreach ($employees as $key => $p) { 

     // $company_name = $this->db->get_where('companies',array('co_id'=>$p['company']))->row_array(); 
     // $users = $this->db->get_where('account_details',array('user_id'=>$p['user_id']))->row_array();
     // $designation = $this->db->get_where('designation',array('id'=>$p['designation_id']))->row_array();
     // $department = $this->db->get_where('departments',array('deptid'=>$p['department_id']))->row_array();

   if($p['status'] == 1)
    {
      $cls = 'active';
      $btn_actions=lang('active');
    }else{
      $cls = 'inactive';
      $btn_actions=lang('inactive');
    }
   
  
                           
  ?> 
  <tr style="vertical-align: middle !important;">
    <td style="vertical-align: middle !important;text-align: center;"><?php echo lang($i)?></td>
    <td style="vertical-align: middle !important;text-align: center;"><?php echo $p['id_code']?></td>
    <td style="vertical-align: middle !important;text-align: center;">
     
      <a class="text-info" data-toggle="tooltip"  href="<?=base_url()?>employees/profile_view/<?=$p['id']?>">
        <?=$p['fullname']?>
      </a>
    
    </td>
    <!-- <td><?php echo $company_name['company_name']?></td> -->
    <td style="vertical-align: middle !important;text-align: center;"><?php echo $p['email']?></td>
    <td style="vertical-align: middle !important;text-align: center;"><?php echo $p['department']?></td>
    <td style="vertical-align: middle !important;text-align: center;"><?php echo $p['designation']?></td>

    
    <?php 
      switch ($p['status']) {
        case '1': $label = 'success'; break;
        case '0': $label = 'warning'; break;
      }
    ?>
    <td style="vertical-align: middle !important;text-align: center;">
      <span class="label label-<?=$label?>"><?php echo $btn_actions ?></span>
    </td>
   
  </tr>
  <?php $i++; } ?>
  </tbody>
</table>