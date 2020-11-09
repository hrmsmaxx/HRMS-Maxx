

			<?php  

      // $role_id = $this->session->userdata('role_id');

      //           // echo $role_id; exit;
      //           $user_type = $this->session->userdata('user_type');
      //          // echo $role_id; exit;

      //           // echo $this->session->userdata('user_type'); exit;

      //           if(($user_type == 0) && ($role_id == 1)){
      //              $user_role = 1;
      //           }else{
      //              $user_role = $user_type;
      //           }




              $role_id = $this->session->userdata('role_id');

        // echo $role_id; exit;
        $user_type = $this->session->userdata('user_type');
       // echo $role_id; exit;

        // echo $this->session->userdata('user_type'); exit;

        if(($user_type == 0) && ($role_id == 1)){
           $user_role = 1;
        }else{
           $user_role = $user_type;
        }


         // Subdomain ....

        $domain = $this->session->userdata('domain');
        $arr = explode('.', $domain); 
          
        // Get the first element of array 
        $subdomain = $arr[0]; 



        // echo $subdomain_role; exit;

        $role_details = $this->db->get_where('roles',array('r_id'=>$user_role))->row_array();
        if($subdomain == 'demo'){
            $subdomain_role = $role_details['role'];
        }elseif($role_id == '1'){
            $subdomain_role = $role_details['role'];
        }else{
            $subdomain_role = $subdomain.'_'.$role_details['role'];
        }

                // $role_details = $this->db->get_where('roles',array('r_id'=>$user_role))->row_array();
                $menu = $this->db->where('access',$user_role)->where('visible',1)->where('route',$this->uri->segment(1))->where('parent','')->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->row();
                //getting manu_module if its submenu 
                if(empty($menu)){
                  $menu = $this->db->where('access',$user_role)->where('visible',1)->where('route',$this->uri->segment(1))->where('parent !=','')->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->row();
                  if(empty($menu)){
                     $menu = $this->db->where('access',$user_role)->where('visible',1)->where('route',$this->uri->segment(1).'/'.$this->uri->segment(2))->where('parent !=','')->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->row();
                  }
                  $sub = $this->db->where('access',$user_role)->where('visible',1)->where('parent',$menu->parent)->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks');
                  // echo 1;
                } else{

                  $sub = $this->db->where('access',$user_role)->where('visible',1)->where('parent',$menu->module)->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks');
                }
                // echo "<pre>";print_r($menu); exit();
                // foreach ($menus as $menu) {
                    // $all_menu_routes[] = $menu->route;
                    // if ($this->uri->segment(1) == $menu->route){
                    
                ?>

                <?php if ($sub->num_rows() > 0) {

                	$submenus = $sub->result(); ?>
                <div class="card-box">
                  <ul class="nav nav-tabs nav-tabs-solid page-tabs">
                <?php   
                    // echo "<pre>";print_r($submenus); exit();
                 	foreach ($submenus as $submenu) {	?>
          			
                  <?php 
                      $submain_menu = $this->db->where('access',1)->where('visible',1)->where('parent',$submenu->module)->where('hook','main_menu_admin')->order_by('order','ASC')->get('hooks');
                     
                  if($submain_menu->num_rows() > 0){
                                $all_submain = $submain_menu->result();
                                
                             ?>
                            <li class="dropdown submenu <?php if($sub_page == lang($submenu->name)){echo  "active"; }?>">
                                <a href="<?=base_url()?><?=$submenu->route?>" class="dropdown-toggle" data-toggle="dropdown"><span><?=lang($submenu->name)?></span> <span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <?php foreach($all_submain as $all_submains){ ?>
                                    <li class="<?php if($sub_page == lang($all_submains->name)){echo  "active"; }?>">
                                        <a href="<?=base_url()?><?=$all_submains->route?>"><!--  <?php if (isset($badge[$all_submains->module])) { echo $badge[$menu->module]; } ?> -->
                                        <span><?=lang($all_submains->name)?></span></a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </li>


                            <?php }else { 
                               $user_id = $this->session->userdata('user_id');
                                $user_teamlead = $this->db->get_where('users',array('id '=>$this->session->userdata('user_id')))->row_array();

                              $performance_status = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->get('performance_status')->row_array();
                                // echo "<pre>"; print_r($performance_status); exit;
                                if($submenu->route =='performance' || $submenu->route =='performance_three_sixty' || $submenu->route =='smartgoal'){
                                   if($user_teamlead['teamlead_id'] != 0){
                                ?>
                                <?php if($performance_status['okr'] == 1 && $submenu->route =='performance') {?>
                                   <li class="<?php if($sub_page == lang($submenu->name)){echo  "active"; }?>"><a href="<?php echo base_url().$submenu->route; ?>"><?php echo lang($submenu->name);?></a></li>
                                
                            <?php }?>
                            <?php if($performance_status['competency'] == 1 && $submenu->route =='performance_three_sixty') {?>
                                <li class="<?php if($sub_page == lang($submenu->name)){echo  "active"; }?>"><a href="<?php echo base_url().$submenu->route; ?>"><?php echo lang($submenu->name);?></a></li>
                            <?php }?>

                            <?php if($performance_status['smart_goals'] == 1 && $submenu->route =='smartgoal') {?>
                                 <li class="<?php if($sub_page == lang($submenu->name)){echo  "active"; }?>"><a href="<?php echo base_url().$submenu->route; ?>"><?php echo lang($submenu->name);?></a></li>
                            <?php } }?>
                                <?php } else  { ?>
                                    <li class="<?php if($sub_page == lang($submenu->name)){echo  "active"; }?>"><a href="<?php echo base_url().$submenu->route; ?>"><?php echo lang($submenu->name);?></a></li>
                                <?php } ?>
                               
                           <?php } ?>
          		<?php } ?>
               <?php if($page == lang('employees') && ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin')){ ?>
               <?php $favourite_reports = $this->db->get_where('favourite_reports',array('status'=>'1'))->result_array();?>
                <li class="dropdown submenu ">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown"><span><?=lang('reports')?></span> </a>
                  <ul class="dropdown-menu">
                  
                  <?php foreach ($favourite_reports as $reports){ ?>              
                  
                    <li><a href="<?php echo base_url()."reports/view/".$reports['report_name'];?>"><?php echo lang($reports['lang']);?></a></li>
                  <?php } ?>
                  </ul>
                </li>
                 
            <?php } ?>
                </ul>
               
  </div>
            <?php  } //}} ?>

			<!-- <li><a href="<?php echo base_url(); ?>organisation">Org Structure</a></li>
			<li class="active"><a href="<?php echo base_url(); ?>employees">Employees</a></li>
			<li><a href="<?php echo base_url(); ?>attendance">Time & Attendance</a></li>
			<li><a href="<?php echo base_url(); ?>leaves">Leave</a></li>
			<li><a href="<?php echo base_url(); ?>payroll">Payroll</a></li>
			<li><a href="<?php echo base_url(); ?>resignation">Employees Status</a></li>
			<li><a href="<?php echo base_url(); ?>policies">Policies</a></li>
			<li><a href="<?php echo base_url(); ?>employees/employee_category">Categories</a></li>
			<li><a href="<?php echo base_url(); ?>employees/vacancy">Vacancy</a></li>
			<li><a href="<?php echo base_url(); ?>notice_board">Notices</a></li>
			<li><a href="<?php echo base_url(); ?>shift_scheduling"><?php echo lang('shift_scheduling');?></a></li> -->
	