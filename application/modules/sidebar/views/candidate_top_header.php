<?php
	$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
	$theme_settings = unserialize($theme_settings['theme_settings']);

	$theme_color = $theme_settings['theme_color']?$theme_settings['theme_color']:config_item('theme_color');
	$top_bar_color = $theme_settings['top_bar_color']?$theme_settings['top_bar_color']:config_item('top_bar_color');
	$logo_or_icon = $theme_settings['logo_or_icon']?$theme_settings['logo_or_icon']:config_item('logo_or_icon');
	$site_logo = $logo_settings['company_logo']?$logo_settings['company_logo']:config_item('company_logo');
	$website_name = $theme_settings['website_name']?$theme_settings['website_name']:'';
?>
<div class="header-<?=$top_bar_color;?> header">
	<div class="header-left">
		<a class="logo" href="<?=base_url()?>">
			<?php $display = $logo_or_icon; ?>
		<?php if ($display == 'logo' || $display == 'logo_title') { ?>
			<img src="<?=base_url()?>assets/images/<?=$site_logo;?>" alt="Logo">
		<?php } ?>
		</a>
	</div>
	
	
	<div class="page-title-box pull-left">
		<h3>
			<?php 
			if ($display == 'logo_title') {
				if ($website_name == '') { echo config_item('company_name'); } else { echo $website_name; }
			} ?>
		</h3>
	</div>
	<a href="#nav" class="mobile_btn pull-left" id="mobile_btn"><i aria-hidden="true" class="fa fa-bars"></i></a>
	<ul class="nav navbar-nav navbar-right nav-user pull-right">
		
		
		<li class="hidden-xs">
			<a href="javascript:;" data-toggle="sidebar-chat" onclick="show_user_sidebar()">
				<i class="fa fa-comment-o"></i>
			</a>
	   </li>
		
		<li class="dropdown main-drop">
			<a href="#" class="dropdown-toggle user-link" data-toggle="dropdown">
				<span class="user-img">
					
					<img src="" class="img-circle" width="40" alt="">
				</span>
				<span><?php echo $this->session->userdata('username');?></span>
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
		
				<li><a href="<?=base_url()?>candidates/candidate_profile"><?=lang('account_settings')?></a></li>
				<li> <a href="<?=base_url()?>candidates/logout" ><?=lang('logout')?></a> </li>
			</ul>
		</li>
	</ul>
	
            <div class="dropdown mobile-user-menu pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?=base_url()?>profile/settings"><?=lang('settings')?></a></li>
				
				<li> <a href="<?=base_url()?>logout" ><?=lang('logout')?></a> </li>
                </ul>
            </div>
	
</div>

