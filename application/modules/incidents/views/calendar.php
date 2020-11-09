<script src="<?=base_url()?>assets/js/jquery-2.2.4.min.js"></script>

<div class="content">
	<div class="row">
		<div class="col-xs-8">
			<h4 class="page-title"><?php echo lang('incident_calendar');?></h4>
		</div>
		<div class="col-sm-4 text-right m-b-20">			
           	 <a class="btn back-btn" href="<?=base_url()?>incidents/"><i class="fa fa-chevron-left"></i> <?php echo lang('back');?></a>
        	</div>
	</div>
	
	<?php $this->load->view('sub_menus');?>
	<div class="card-box m-b-0">
		<div class="row">
			<div class="col-sm-4">
				<h4 class="page-title"><?=lang('incidents')?></h4>
			</div>
		<div class="col-sm-8 text-right m-b-20">
			<?php $all_routes = $this->session->userdata('all_routes');
            
            foreach($all_routes as $key => $route){
                if($route == 'calendar'){
                    $routname = calendar;
                } 
                
            }
        // if (!User::is_admin())
        
        if(User::is_admin()) : ?>
			<!-- <a href="<?=base_url()?>calendar/settings" data-toggle="ajaxModal" class="btn btn-primary rounded pull-right"><i class="fa fa-cog"></i> <?=lang('calendar_settings')?></a> -->
			<?php endif; ?>
			<?php if(User::is_admin() || User::is_staff()){
			   // if(!empty($routname)){
			    ?>
			<a id="eventAddCal" href="<?=base_url()?>incidents/add_event" data-toggle="ajaxModal" class="btn btn-primary rounded pull-right m-r-10"><i class="fa fa-calendar-plus-o"></i> <?=lang('add_incidents')?></a>
			<?php  } ?>
		</div>
	</div>
	<?php
	// if(!empty($routname)){ ?>
		 <?php if (($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') || ($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor') || $_SESSION['is_teamlead'] == 'yes') { ?>
		 <!-- Search Filter -->
          <div class="row filter-row">
            <form method="post" action="">
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group ">
                  <label><?=lang('employees_code')?></label>
                  <input type="text" class="form-control" name = "id_code" value="<?php echo (isset($_POST['id_code']) && !empty($_POST['id_code']))?$_POST['id_code']:'';?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                  <label><?=lang('employees')?></label>
                  <select class="select2-option form-control" name="user_id" id="user_name">
                        <optgroup label="">
                        <option value=""><?php echo lang('select_employee');?></option> 
                            <?php 
                            if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
                                    $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                                    
                            }
                             if (($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor') || $_SESSION['is_teamlead'] == 'yes') { 
                                  $this->db->where('role_id', 3);
                                  $this->db->where('activated', 1);
                                  $this->db->where('banned', 0);
                                  $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));

                                  $branch_id = $this->session->userdata('branch_id');
                                  if($branch_id != '') {
                                    $this->db->where("branch_id IN (".$branch_id.")",NULL, false);
                                  }

                                  if($dept_id !=0 && $_SESSION['is_teamlead'] == 'yes'){
                                      if($dept_id !=0){
                                        $depart_id = explode(',', $dept_id);
                                         $this->db->where_in('department_id', $depart_id);
                                      } 
                                      if($_SESSION['is_teamlead'] == 'yes'){
                                          $this->db->or_where('teamlead_id',$this->session->userdata('user_id'));
                                      }
                                  }else{

                                       if($dept_id !=0){
                                        $depart_id = explode(',', $dept_id);
                                         $this->db->where_in('department_id', $depart_id);
                                      } 
                                      if($_SESSION['is_teamlead'] == 'yes'){
                                          $this->db->or_where('teamlead_id',$this->session->userdata('user_id'));
                                      }
                                  }
                                  $employee = $this->db->get('users')->result();
                             }
                             if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){
                                $branch_id = $this->session->userdata('branch_id');
                                if($branch_id != '') {
                                    $this->db->where("branch_id IN (".$branch_id.")",NULL, false);
                                }
                                $employee = $this->db->get_where('users',array('role_id'=>3,'activated'=>1,'banned'=>0,'subdomain_id'  => $this->session->userdata('subdomain_id')))->result();
                             }
                            


                            foreach ($employee as $c): 
                            ?>

                                <option value="<?php echo $c->id;?>" <?php echo(isset($_POST['user_id']) && $_POST['user_id'] == $c->id)?"selected":"";?>><?php echo User::displayName($c->id);?></option>
                            <?php endforeach;  ?>
                        </optgroup>
                    </select>
                </div>
              </div>
              <?php 
if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){
              $departments = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("deptname", "asc")->get('departments')->result(); ?>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="form-group">
                  <label><?=lang('department')?></label>
                  <select class="select2-option form-control" name="department_id" id="department" >
                        <option value="" selected ><?php echo lang('select_department');?></option>
                        <?php
                        if(!empty($departments))  {
                        foreach ($departments as $department){ ?>
                        <option value="<?=$department->deptid?>" <?php echo (isset($_POST['department_id']) && ($_POST['department_id'] == $department->deptid))?"selected":""?>><?=$department->deptname?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                </div>
              </div>
         <?php } ?>

             
             
              <div class="col-md-3 col-sm-3 col-xs-6">  
                <label class="d-block">&nbsp;</label>
                 <button type="submit" class="btn btn-success btn-block"><?=lang('search');?></button> 
              </div> 
            </form>    

          </div>
          <?php } ?>
          <!-- /Search Filter -->
	<div class="row">
	<div class="col-md-12">
	<div class="card-box m-b-0">
			<div id="calendar"></div>
		</div>
		</div>
	</div>
	<?php // } ?>
</div>
</div>



