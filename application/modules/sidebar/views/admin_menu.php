<?php 
    $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    $logo_settings = $this->db->get_where('subdomin_logo_settings',array('user_id'=>$this->session->userdata('user_id'),'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

    $theme_settings = unserialize($theme_settings['theme_settings']);

    $system_settings = $this->db->get_where('subdomin_system_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
    $systems = unserialize(base64_decode($system_settings['system_settings']));

    $logo_or_icon = $theme_settings['logo_or_icon']?$theme_settings['logo_or_icon']:config_item('logo_or_icon');
    $system_font = $theme_settings['system_font']?$theme_settings['system_font']:config_item('system_font');
    $sidebar_theme = $theme_settings['sidebar_theme']?$theme_settings['sidebar_theme']:config_item('sidebar_theme');
    $theme_color = $theme_settings['theme_color']?$theme_settings['theme_color']:config_item('theme_color');
    $top_bar_color = $theme_settings['top_bar_color']?$theme_settings['top_bar_color']:config_item('top_bar_color');
    $login_title = $theme_settings['login_title']?$theme_settings['login_title']:config_item('login_title');

    $site_logo = $logo_settings['company_logo']?$logo_settings['company_logo']:config_item('company_logo');

    $enable_languages = $systems['enable_languages']?$systems['enable_languages']:config_item('enable_languages');
?>
<?php
if($this->uri->segment(1) == 'chats'){
?>

<div class="sidebar sidebar-<?=$sidebar_theme;?>" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div class="sidebar-menu video-wrapper">
			<?php //echo "<pre>"; print_r($group_chat_list); exit; ?>
			<ul class="grp-chat-wrapper">
				<li> 
					<a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> <span><?php echo lang('back_to_home'); ?></span></a>
				</li>
			</ul>

			<ul class="single-chat-wrapper">
				<li class="menu-title">
					<?php echo lang('direct_chats'); ?> <a href="#" data-toggle="modal" data-target="#add_chat_user" class="menu-title-icon" title="Open a direct message"><i class="fa fa-plus"></i></a>
					<?php //echo "<pre>"; print_r($single_chat_list); exit; ?>
				</li>
			</ul> 
			<?php if(empty($single_chat_list)){ ?>
			<ul>
				<li class="text-center"> <span><?php echo lang('no_chat'); ?></span></li> 
			</ul> 
			<?php }else{ ?>

			<ul class="UseRLisT">
				<?php foreach($single_chat_list as $single_chat){ if(!empty($single_chat['avatar'])){
					$pro_pic = $single_chat['avatar'];
				}else{
					$pro_pic = 'default_avatar.jpg';
				}
				?>
				<li> 
					<?php if($single_chat['online_status'] == 0){
						$status = 'offline';
					}else {
						$status = 'online';
					}
					$destination = $this->db->get_where('designation',array('id'=>$single_chat['designation_id']))->row_array();
					?>
					<a class="SingleChatList" data-name="<?php echo ucfirst($single_chat['fullname']); ?>" data-email="<?php echo $single_chat['email']; ?>" data-phone="<?php echo $single_chat['phone']; ?>" data-online="<?php echo $status; ?>" data-propic="<?php echo $pro_pic; ?>" data-username="<?php echo $single_chat['username']; ?>" data-baseurl="<?php echo base_url(); ?>" data-lastlogin="<?php echo $single_chat['last_login']; ?>" data-userid="<?php echo $single_chat['user_id']; ?>" data-destination ="<?php echo $destination['designation']; ?>" >
						<span class="user-img chat-avatar-sm">
							<img class="img-circle" src="<?php echo base_url(); ?>assets/avatar/<?php echo $pro_pic; ?>" width="32" alt="Admin">
							<span class="status <?php echo $status; ?>"></span>
						</span> 
						<span class="member-name-blk"><?php echo ucfirst($single_chat['fullname']); ?></span>
						<span class="badge bg-danger pull-right"></span>
					</a>
				</li>
			<?php } ?>
			</ul>
			<?php }?>
		</div>
	</div>
</div>
<?php }elseif($this->uri->segment(1) == 'candidate_chats'){

    ?>
<div class="sidebar sidebar-<?=$sidebar_theme;?>" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu video-wrapper">
            <?php //echo "<pre>"; print_r($group_chat_list); exit; ?>
            <ul class="grp-chat-wrapper">
                <li> 
                    <a href="<?php if(!$this->session->userdata('candidate_id')){ echo base_url();}else{ echo base_url('candidates/dashboard');} ?>"><i class="fa fa-home"></i> <span><?php echo lang('back_to_home');?></span></a>
                </li>
            </ul>

            <ul class="single-chat-wrapper">
                <!--<li class="menu-title">
                    Direct Chats <a href="#" data-toggle="modal" data-target="#add_chat_user" class="menu-title-icon" title="Open a direct message"><i class="fa fa-plus"></i></a>
                    <?php //echo "<pre>"; print_r($single_chat_list); exit; ?>
                </li>-->
            </ul> 
            <?php if(empty($single_chat_list)){ ?>
            <ul>
                <li> <span>No Chat</span></li> 
            </ul> 
            <?php }else{ ?>

            <ul class="UseRLisT">
                <?php foreach($single_chat_list as $single_chat){

                if(!empty($single_chat['avatar'])){
                    $pro_pic = $single_chat['avatar'];
                }else{
                    $pro_pic = 'default_avatar.jpg';
                }
                ?>
                <li> 
                    <?php if($single_chat['online_status'] == 0){
                        $status = 'offline';
                    }else {
                        $status = 'online';
                    }
                   // $destination = $this->db->get_where('designation',array('id'=>$single_chat['designation_id']))->row_array();
                    ?>
                    <?php if(!$this->session->userdata('candidate_id')){?>
                    <a class="candidateSingleChatList" data-name="<?php echo ucfirst($single_chat['first_name']).' '.$single_chat['last_name']; ?>" data-email="<?php echo $single_chat['email']; ?>" data-phone="<?php echo $single_chat['phone_number']; ?>" data-online="<?php echo $status; ?>" data-propic="<?php echo $pro_pic; ?>" data-username="<?php echo $single_chat['first_name'].' '.$single_chat['last_name']; ?>" data-baseurl="<?php echo base_url(); ?>" data-lastlogin="<?php echo $single_chat['last_login']; ?>" data-userid="<?php echo $single_chat['candidate_id']; ?>" data-destination ="<?php echo ''; ?>" >
                        <span class="user-img chat-avatar-sm">
                            <img class="img-circle" src="<?php echo base_url(); ?>assets/avatar/<?php echo $pro_pic; ?>" width="32" alt="Admin">
                            <span class="status <?php echo $status; ?>"></span>
                        </span> 
                        <span class="member-name-blk"><?php echo ucfirst($single_chat['first_name']).' '.$single_chat['last_name']; ?></span>
                        <span class="badge bg-danger pull-right"></span>
                    </a>
                <?php }?>
                </li>
            <?php } ?>
            </ul>
            <?php }?>
        </div>
    </div>
</div>
    <?php 
}elseif($this->uri->segment(1) =='all_tasks'){ ?>

<div class="sidebar sidebar-<?=$sidebar_theme;?>" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div class="sidebar-menu">
			<ul>
				<li> 
					<a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i><?php echo lang('back_to_home'); ?></a>
				</li>
				<li class="menu-title"><a href="<?php echo base_url(); ?>projects"><?php echo lang('projects'); ?></a> </li>
				<?php $i=1; foreach($all_projects as $project){ ?>
					<li <?php if($this->uri->segment(3) == ''){ if($i == count($all_projects)){ ?> class="active" <?php } }elseif($this->uri->segment(3) == $project['project_id']){ ?> class="active" <?php } ?> > 
						<a href="<?php echo base_url(); ?>all_tasks/view/<?php echo $project['project_id']; ?>"><?php echo $project['project_title']; ?></a>
					</li>
				<?php $i++; } ?>
			</ul>
		</div>
	</div>
</div>
<?php }else{ 
    if(($this->uri->segment(2) !='business_proposals') && ($this->uri->segment(2) !='lead_view') && ($this->uri->segment(1) !='candidates')){
    ?>

<div class="sidebar-<?=$sidebar_theme;?> sidebar" id="nav">
    <div class="slimscroll">    
        <?php if($enable_languages == 'TRUE'){  ?>
        <div class="language-menu">
            <div class="dropdown">
                <button type="button" class="btn btn-sm btn-default dropdown-toggle btn-block hidden-nav-xs" data-toggle="dropdown"><?=lang('languages')?> <span class="caret"></span></button>
                <ul class="dropdown-menu text-left">
                    <?php foreach ($languages as $lang) : if ($lang->active == 1) : ?>
                    <li>
                        <a href="<?=base_url()?>set_language?lang=<?=$lang->name?>" title="<?=ucwords(str_replace("_"," ", $lang->name))?>">
                            <img src="<?=base_url()?>assets/images/flags/<?=$lang->icon?>.gif" alt="<?=ucwords(str_replace("_"," ", $lang->name))?>"  /> <?=ucwords(str_replace("_"," ", $lang->name))?>
                        </a>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
            </div>
        </div>
        <?php  } ?>

        <div id="sidebar-menu" class="sidebar-menu grid-menu">
            <ul class="nav">
                <?php
                $badge = array();
                $timer_on = App::counter('project_timer',array('status'=>'1'));
                if($timer_on > 0){ $badge['menu_projects'] = '<b class="badge bg-danger pull-right">'.$timer_on.'<i class="fa fa-refresh fa-spin"></i></b>'; }
                $unread = App::counter('messages',array('user_to'=>User::get_id(),'status' => 'Unread'));
                $open_tickets = App::counter('tickets',array('status !=' => 'closed'));
                if($unread > 0){ $badge['menu_messages'] = '<b class="badge bg-primary pull-right">'.$unread.'</b>'; }
                if($open_tickets > 0){ $badge['menu_tickets'] = '<b class="badge bg-primary pull-right">'.$open_tickets.'</b>'; }
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
                $subscriber_menu = $this->db->get_where('subscribers',array('subscribers_id'=>$this->session->userdata('subdomain_id')))->row_array();
                 // echo $this->session->userdata('subdomain_id'); exit;
                // echo $subdomain_role; exit;
                if(!empty($subscriber_menu['menus'])){
                    $where_in = explode(',',$subscriber_menu['menus']);

                    $this->db->select('*');
                    $this->db->where_in('id',$where_in);
                    $plan_menus =$this->db->get('plan_menus')->result_array();
                    if(!empty($plan_menus)){
                        foreach ($plan_menus as $key => $value) {
                            # code...
                            if(!empty($value['module'])){                                
                                $plan_menu[] = $value['module'];
                            }
                        }
                        $plan_menu[]= 'menu_home';
                        $plan_menu[]= 'menu_subscriber_invoice';
                        $plan_menu[]= 'menu_geolocation';
                    }
                }
               // $all_menus = $this->db->where('route !=','#')->where('visible',1)->where('hook','main_menu_admin')->where_in('parent',$plan_menu)->order_by('order','ASC')->get('hooks')->result();
               //   //
                   // echo'<pre>';print_r($all_menus); 
               //     echo $this->db->last_query(); exit;
                if($subdomain == 'demo'){
                    $menus = $this->db->where('access',$user_role)->where('visible',1)->where('parent','')->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->result();
                }else{
                    if($user_role == 1){
                         $menus = $this->db->where('access',$user_role)->where('visible',1)->where_in('module',$plan_menu)->where('parent','')->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->result();
                     }else{
                         $menus = $this->db->where('access',$user_role)->where('visible',1)->where_in('module',$plan_menu)->where('parent','')->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->result();
                     }
                   
                     // echo'<pre>';print_r($menus); exit;
                }

                 // echo $this->db->last_query(); exit;
                foreach ($menus as $menu) {
                    $all_menu_routes[] = $menu->route;
                 if($menu->route =="#"){
                    $sub = $this->db->where('access',$user_role)->where('visible',1)->where('parent',$menu->module)->where('hook','main_menu_'.$subdomain_role)->order_by('order','ASC')->get('hooks')->row();
                     $performance_status = $this->db->get('performance_status')->row_array();
                    // echo "<pre>"; print_r($performance_status); exit;
                    if($sub->route =='performance' || $sub->route =='performance_three_sixty' || $sub->route =='smartgoal'){
                       
                        if($performance_status['okr'] == 1 && $menu->module =='menu_performance') {
                           $menu_route = 'performance';
                                
                        }
                        if($performance_status['competency'] == 1 && $menu->module =='menu_performance') {
                            $menu_route = 'performance_three_sixty';
                        }

                        if($performance_status['smart_goals'] == 1 && $menu->module =='menu_performance') {
                            $menu_route = 'smartgoal';
                        }
  // echo "<pre>" ;print_r($menu); exit;
                    } else{
                        $menu_route = $sub->route;
                    }
                    
                    
                 } else {
                     if($menu->route =='performance' || $menu->route =='performance_three_sixty' || $menu->route =='smartgoal'){
                       
                        if($performance_status['okr'] == 1 && $menu->route =='performance') {
                           $menu_route = 'performance';
                                
                        }
                        if($performance_status['competency'] == 1 && $menu->route =='performance') {
                            $menu_route = 'performance_three_sixty';
                        }

                        if($performance_status['smart_goals'] == 1 && $menu->route =='performance') {
                            $menu_route = 'smartgoal';
                        }
                    } else{
                        $menu_route = $menu->route;
                    }
                    

                 }
                   
                ?>
                    
                
                    <li class="<?php if($page == lang($menu->name)){echo  "active"; }?>">
                        <a href="<?=base_url()?><?=$menu_route?>">
                            <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?>
                            <i class="fa <?=$menu->icon?> icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                            <span><?=lang($menu->name)?></span>
                        </a>
                    </li>
                <?php }
                    ?>
                <?php  $all_routes = array_unique(array_merge($all_menu_routes,$all_sun_menu_routes), SORT_REGULAR);
                        $all_routes_name= array_values($all_routes)  ;  
                        $this->session->set_userdata('all_routes',$all_routes_name);
                    ?>
            </ul>
        </div>
    </div>
</div>
<?php }}

if($this->uri->segment(1) =='candidates'){

  ?>

<div class="sidebar-<?=$sidebar_theme;?> sidebar" id="nav">
    <div class="slimscroll">    
        

        <div id="sidebar-menu" class="sidebar-menu grid-menu">
            <ul class="nav">
                <li class="<?php if($this->uri->segment(2) == 'dashboard'){echo  "active"; }?>">
                    <a class="m-b-10" href="<?=base_url()?>candidates/dashboard">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-home icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('dashboard')?></span>
                    </a>
                </li>
                <li class="<?php if($this->uri->segment(2) == 'all_jobs' || $this->uri->segment(2) == 'job_view'){echo  "active"; }?>">
                    <a class="m-b-10" href="<?=base_url()?>candidates/all_jobs">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-home icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('all_jobs')?></span>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2) == 'saved'){echo  "active"; }?>">
                     <a class="m-b-10" href="<?=base_url()?>candidates/saved">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-floppy-o icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('saved')?></span>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2) == 'applied'){echo  "active"; }?>">
                     <a class="m-b-10" href="<?=base_url()?>candidates/applied">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-clipboard icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('applied')?></span>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2) == 'interviewing' || $this->uri->segment(2) == 'aptitude' || $this->uri->segment(2) == 'questions'){echo  "active"; }?>">
                     <a class="m-b-10" href="<?=base_url()?>candidates/interviewing">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-comments icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('interviewing')?></span>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2) == 'offered'){echo  "active"; }?>">
                     <a class="m-b-10" href="<?=base_url()?>candidates/offered">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-file-text-o icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('offered')?></span>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2) == 'visited'){echo  "active"; }?>">
                     <a class="m-b-10" href="<?=base_url()?>candidates/visited">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-retweet icon"> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('visited')?></span>
                    </a>
                </li>
                 <li class="<?php if($this->uri->segment(2) == 'archived'){echo  "active"; }?>">
                     <a class="m-b-10" href="<?=base_url()?>candidates/archived">
                        <!-- <?php if (isset($badge[$menu->module])) { echo $badge[$menu->module]; } ?> -->
                        <i class="fa fa-trash icon"></i> <b class="bg-<?=$theme_color;?>"></b></i>
                        <span><?=lang('archived')?></span>
                    </a>

                </li>
            </ul>
        </div>
    </div>
</div>
<?php  } ?>
