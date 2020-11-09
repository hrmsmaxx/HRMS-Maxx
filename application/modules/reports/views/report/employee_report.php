<?php 


                        /*$this->db->select('*');
                        $this->db->join('account_details','account_details.user_id = users.id');   
                        $this->db->where('users.role_id', 3);
                        $this->db->where('users.subdomain_id', $this->session->userdata('subdomain_id'));
                        if($branch_id != '') {
                            $this->db->where("users.branch_id IN(".$branch_id.")",NULL, false);
                        }
                        $users = $this->db->get('users')->result(); */
//exit;
$cur = App::currencies(config_item('default_currency')); 
// $task = ($task_id > 0) ? $this->db->get_where('tasks',array('t_id'=>$data['task_id'])) : array();
// $project_id = (isset($task_id)) ? $task_id : '';
// $task_progress = (isset($task_progress)) ? $task_progress : '';
$user_id = (isset($user_id)) ? $user_id : '';

?>

<div class="content">
	<section class="panel panel-white">
            
    <div class="panel-heading">
    	 <div class="row">
	        <div class="col-sm-8">
	        	<h4 class="page-title m-b-0 m-r-10" style="display: inline-block;"><?php echo lang('employee_report')?></h4>
	            <!-- <?=$this->load->view('report_header');?> -->
			</div>
		
             <div class="col-sm-4 text-right">
         	
          <div class="btn-group">
            <button class="btn btn-default"><?=lang('export')?></button>
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
            </button>
            <ul class="dropdown-menu export" style="left:auto; right:0px !important; min-width: 93px !important">  
              <li>
                <form method="post" action="">
                    <input type="hidden" class="form-control" name = "pdf" value="1">
                   
                    <input type="hidden" class="form-control department_id_excel" name = "department_id" value="<?php echo (isset($_POST['department_id']) && !empty($_POST['department_id']))?$_POST['department_id']:'';?>">
                    <input type="hidden" class="form-control designation_id_excel" name = "designation_id" value="<?php echo (isset($_POST['designation_id']) && !empty($_POST['designation_id']))?$_POST['designation_id']:'';?>">                   
                    <input type="hidden" class="form-control user_id_excel" name = "user_id" value="<?php echo (isset($_POST['user_id']) && !empty($_POST['user_id']))?$_POST['user_id']:'';?>">
                    <button class=" btn  btn-block" type="submit" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-pdf-o"></i></span> <span><?=lang('pdf')?></span></button>
                     <!-- <a href="#" class="pull-right" id="attendance_report_pdf1" type="submit"> -->
                     
                      <!-- </a> -->
                </form>
               
              </li>

            
              <li>
                <?php  $report_name = lang('employee_report');?>
                 <button class="btn  btn-block" onclick="employee_report_excel('<?php echo $report_name;?>','attendance_report_excel');" style="text-align: left;"> <span style="font-size: 18px;text-align: left;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span><span><?=lang('excel')?></span> </button>
              </li>
            </ul>
          </div>
          <?=$this->load->view('report_header');?>
        </div>

           
    </div>
    </div>

    <div class="panel-body">

            <!-- <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="fa fa-info-sign"></i><?=lang('amount_displayed_in_your_cur')?>&nbsp;<span class="label label-success"><?=config_item('default_currency')?></span>
            </div> -->

      <div class="fill body reports-top rep-new-band">
        <div class="criteria-container fill-container hidden-print">
          <div class="criteria-band">
            <address class="row">
           <form method="post" action="" >
          
              <div class="col-md-3">
                <label><?=lang('name')?> </label>
                <select class="select2-option form-control" style="width:280px" name="user_id" >
                    <optgroup label="<?=lang('name')?>">
                      <option value="0"><?php echo lang('all')?></option>
                        <?php 
                        $branch_id = $this->session->userdata('branch_id');
                        if($branch_id != '') {
                            $this->db->where("u.branch_id IN(".$branch_id.")",NULL, false);
                        }
                        $users = $this->db->select('*')
                                    ->from('users u')
                                    ->join('account_details','account_details.user_id = u.id')
                                    ->where(array('u.role_id'=>3, 'u.subdomain_id'=>$this->session->userdata('subdomain_id')))
                                    ->get()
                                    ->result();
                                    
                        /*$branch_id = $this->session->userdata('branch_id');

                        $this->db->select('*');
                        $this->db->join('account_details','account_details.user_id = users.id');   
                        $this->db->where('users.role_id', 3);
                        $this->db->where('users.subdomain_id', $this->session->userdata('subdomain_id'));
                        if($branch_id != '') {
                             $this->db->where("users.branch_id IN (".$branch_id.")",NULL, false);
                        }
                        $users = $this->db->get('users')->result(); */

                        foreach ($users as $c): ?>
                            <option value="<?=$c->user_id?>" <?=($user_id == $c->user_id) ? 'selected="selected"' : '';?>>
                            <?=ucfirst($c->fullname)?></option>
                        <?php endforeach;  ?>
                    </optgroup>
                </select>
              </div>

              <div class="col-md-3">
                <label><?=lang('department')?> </label>
                <select class="select2-option form-control" style="width:280px" name="department_id" >
                    <optgroup label="<?=lang('department')?>">
                      <option value="0"><?=lang('all')?></option>
                        <?php 
                        $department = $this->db->get_where('departments',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result();

                        foreach ($department as $c): ?>
                            <option value="<?=$c->deptid?>" <?=($department_id == $c->deptid) ? 'selected="selected"' : '';?>>
                            <?=ucfirst($c->deptname)?></option>
                        <?php endforeach;  ?>
                    </optgroup>
                </select>
              </div>

              <div class="col-md-3">
                <label><?=lang('designation')?> </label>
                <select class="select2-option form-control" style="width:280px" name="designation_id" >
                    <optgroup label="<?=lang('designation')?>">
                      <option value="0"><?=lang('all')?></option>
                        <?php 
                        $designation = $this->db->get_where('designation',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result();

                        foreach ($designation as $c): ?>
                            <option value="<?=$c->id?>" <?=($designation_id == $c->id) ? 'selected="selected"' : '';?>>
                            <?=ucfirst($c->designation)?></option>
                        <?php endforeach;  ?>
                    </optgroup>
                </select>
              </div>
                


              <div class="col-md-2">  
                <button class="btn btn-success" type="submit">
                  <?=lang('run_report')?>
                </button>
              </div>



            </address>
          </div>
        </div>


        <?php  form_close(); ?>

        <div class="rep-container">
          <div class="page-header text-center">
            <h3 class="reports-headerspacing"><?=lang('employee_report')?></h3>
            <!-- <?php if($task->t_id != NULL){ ?>
            <h5><span><?=lang('project_name')?>:</span>&nbsp;<?=$task->task_name?>&nbsp;</h5>
            <?php } ?> -->
        </div>

        <div class="fill-container">


          <div class="col-md-12">
                  
              <table id="table-templates-1 task_report" class="table table-striped custom-table m-b-0 AppendDataTables">
                <thead>
                  <tr>
                    <th style="width:5px; display:none;"></th>
                    <th><b><?php echo lang('id_code')?></b></th>  
                    <th><b><?php echo lang('name')?></b></th>  
                    <!-- <th><b><?=lang('company')?></b></th> -->
                    <th><b><?php echo lang('email')?></b></th>
                    <!-- <th><b><?php //echo lang('branch')?></b></th> -->
                    <th><b><?php echo lang('department')?></b></th>
                    <th><b><?php echo lang('designation')?></b></th>
                    <th class="col-title "><b><?php echo lang('status')?></b></th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($employees as $key => $p) { 

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
                    <td><?php echo $p['id_code']?></td>
                    <td>
                     
                      <a class="text-info" data-toggle="tooltip"  href="<?=base_url()?>employees/profile_view/<?=$p['id']?>">
                        <?=$p['fullname']?>
                      </a>
                    
                    </td>
                    <!-- <td><?php echo $company_name['company_name']?></td> -->
                    <td><?php echo $p['email']?></td>
                     <!-- <td><?php //echo $p['branches']?></td> -->
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
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


     