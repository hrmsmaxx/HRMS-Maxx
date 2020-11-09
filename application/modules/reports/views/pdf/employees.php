<link rel="stylesheet" href="<?=base_url()?>assets/css/app.css" type="text/css" />
<style type="text/css">
   .pure-table td, .pure-table th {
   border-bottom: 1px solid #cbcbcb;
   border-width: 0 0 0 1px;
   margin: 0;
   overflow: visible;
   padding: .5em 1em;
   }
   .pure-table .table td {
   vertical-align: middle !important;
   }
</style>
<?php 
   ini_set('memory_limit', '-1');
   $cur = App::currencies(config_item('default_currency')); 
   $company_id = (isset($company_id)) ? $company_id : '';
   $company_details = $this->db->get_where('companies',array('co_id'=>$company_id))->row_array();

   ?> 
<div class="rep-container">
   <div class="page-header text-center">
      <h3 class="reports-headerspacing"><b><?=lang('employee_report')?></b></h3>
      <?php if($role_id != NULL){ ?>
      <h5><b><span><?=lang('company_name')?>:</span>&nbsp;<?=$company_details['company_name']?>&nbsp;</b></h5>
      <?php } ?>
   </div>
   <table class="table pure-table">
      <thead>
         <tr>
            <th><b><?php echo lang('s_no')?></b></th>
            <th><b><?php echo lang('id_code')?></b></th>  
            <th><b><?php echo lang('name')?></b></th>  
            <!-- <th><b><?php echo lang('company')?></b></th> -->
            <th><b><?php echo lang('email')?></b></th>
            <th><b><?php echo lang('department')?></b></th>
            <th><b><?php echo lang('designation')?></b></th>
            <th class="col-title "><b><?=lang('status')?></b></th>
         </tr>
      </thead>
      <tbody>
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
                  <tr >
                    <td><?php echo lang($i)?></td>
                    <td><?php echo $p['id_code']?></td>
                    <td>
                     
                      <a class="text-info" data-toggle="tooltip"  href="<?=base_url()?>employees/profile_view/<?=$p['id']?>">
                        <?=$p['fullname']?>
                      </a>
                    
                    </td>
                    <!-- <td><?php echo $company_name['company_name']?></td> -->
                    <td><?php echo $p['email']?></td>
                    <td><?php echo $p['department']?></td>
                    <td><?php echo $p['designation']?></td>

                    
                    <?php 
                      switch ($p['status']) {
                        case '1': $label = 'success'; break;
                        case '0': $label = 'warning'; break;
                      }
                    ?>
                    <td>
                      <span class="label label-<?=$label?>"><?php echo $btn_actions ?></span>
                    </td>
                   
                  </tr>
                  <?php $i++; } ?>
      </tbody>
   </table>
</div>