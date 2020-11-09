<?php

$subscription_details = $this->db->get_where('subscribers',array('subscribers_id'=>$this->session->userdata('subdomain_id')))->row_array();

$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

$logo_settings = $this->db->get_where('subdomin_logo_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

$theme_settings = unserialize($theme_settings['theme_settings']);

$logo_or_icon = $theme_settings['logo_or_icon']?$theme_settings['logo_or_icon']:config_item('logo_or_icon');

$site_logo = $logo_settings['company_logo']?$logo_settings['company_logo']:config_item('login_logo');

$login_title = $theme_settings['login_title']?$theme_settings['login_title']:config_item('login_title');

// echo "<pre";print_r($logo_settings);die;

$today = date("Y-m-d");
$expiredate = $subscription_details['expired_date'];

$login = array(
	'name'	=> 'login',
	'class'	=> 'form-control',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or Username';
} else if ($login_by_username) {
	$login_label = 'Username';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'inputPassword',
	'size'	=> 30,
	'class' => 'form-control'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'class'	=> 'form-control',
	'maxlength'	=> 10,
);
?>
<div class="account-content">
		<a href="<?php echo base_url(); ?>candidates/all_jobs_user" class="btn btn-primary apply-btn"><?php echo lang('apply_job'); ?></a>	 
	<div id="login-form" class="container">
<!-- 
		<ul class="nav navbar-nav navbar-right user-menu pull-right">
			<li>
				<a href="<?=base_url()?>jobs">Career</a>
			</li>				 
		</ul>
	
 -->
					
		<div class="account-box">
					<!-- Account Logo -->
					<div class="account-logo">
						<?php $display = $logo_or_icon; ?>
						<?php if ($display == 'logo' || $display == 'logo_title') { ?>
						<img src="<?=base_url()?>assets/images/<?=$site_logo?>" class="<?=($display == 'logo' ? "" : "login-logo")?>">
						<?php } ?>
					</div>
					<!-- /Account Logo -->
			<h3 class="account-title"><?php echo lang('login'); ?></h3>
			<p class="account-subtitle"><?php echo lang('access_to_our_dashboard'); ?></p>
			<?php 
			if (!empty($expiredate) && ($expiredate < $today)) { ?>
				<div class="alert alert-warning" role="alert">
					<?php echo lang('expired_your_account'); ?>
				</div>
			<?php } ?>
			<?php echo modules::run('sidebar/flash_msg');?>
			<?php if(config_item('enable_languages') == 'TRUE'){/* ?>
			<div class="langage-menu2 text-right clearfix">
				<div class="btn-group dropdown">
					<button type="button" class="btn btn-sm dropdown-toggle btn-default" data-toggle="dropdown" btn-icon="" title="<?=lang('languages')?>"><i class="fa fa-globe"></i></button>
					<button type="button" class="btn btn-sm btn-default dropdown-toggle  hidden-nav-xs" data-toggle="dropdown"><?=lang('languages')?> <span class="caret"></span></button>
					<!-- Load Languages -->
					<ul class="dropdown-menu text-left">
						<?php $languages = App::languages(); foreach ($languages as $lang) : if ($lang->active == 1) : ?>
						<li>
							<a href="<?=base_url()?>set_language?lang=<?=$lang->name?>" title="<?=ucwords(str_replace("_"," ", $lang->name))?>">
								<img src="<?=base_url()?>assets/images/flags/<?=$lang->icon?>.gif" alt="<?=ucwords(str_replace("_"," ", $lang->name))?>"  /> <?=ucwords(str_replace("_"," ", $lang->name))?>
							</a>
						</li>
						<?php endif; endforeach; ?>
					</ul>
				</div>
			</div>
			<?php */} ?>
			<div class="langage-menu2 clearfix">

				  <div class="form-group">

				      <label for="login_user_type"><?php echo lang('users'); ?>:</label>

				      <select class="form-control" id="login_user_type">

				        <option selected disabled><?php echo lang('choose'); ?></option>

				        <option value="admin"><?php echo lang('admin'); ?></option>

				        <option value="client"><?php echo lang('client'); ?></option>

				        <option value="user"><?php echo lang('employee'); ?></option>

				      </select>

				  </div>

				</div>
			<!-- Account Form -->
			<?php $attributes = array('class' => ''); echo form_open($this->uri->uri_string(),$attributes); ?>
				<div class="form-group">
					<label class="control-label"><?=lang('email_user')?></label>
					<?php echo form_input($login); ?>
					<span class="error"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></span>
				</div>
				<div class="form-group">
					<label class="control-label"><?=lang('password')?></label>
					<?php echo form_password($password); ?>
					<span class="error"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></span>
				</div>
				<div class="form-group">
					<table>
						<?php if ($captcha_registration == 'TRUE') {
							if ($use_recaptcha) { ?>
						<?php echo $this->recaptcha->render(); ?>
						<?php } else { ?>
						<tr><td colspan="4"><p><?=lang('enter_the_code_exactly')?></p></td></tr>
						<tr>
							<td colspan="3"><?php echo $captcha_html; ?></td>
							<td style="padding-left: 5px;"><?php echo form_input($captcha); ?></td>
						</tr>
						<?php }
						} ?>
					</table>
							<span class="error"><?php echo form_error($captcha['name']); ?></span>
				</div>
				<div class="form-group clearfix">
					<div class="pull-left">
						<label>
							<?php echo form_checkbox($remember); ?> <?=lang('this_is_my_computer')?>
						</label>
					</div>
					<a href="<?=base_url()?>auth/forgot_password" class="pull-right text-muted"><?=lang('forgot_password')?></a>
				</div>
				<div class="form-group m-b-0">
					<button type="submit" class="btn account-btn"><?=lang('sign_in')?></button>
				</div>
				<div class="account-footer">
					<p><?php echo lang('do_not_have_account_yet'); ?> <a href="<?=base_url()?>auth/subscribers_price" class=""><?=lang('subscribe')?></a></p>
				</div>

			<?php echo form_close(); ?>
			<!-- /Account Form -->
			
		</div>
	</div>
</div>