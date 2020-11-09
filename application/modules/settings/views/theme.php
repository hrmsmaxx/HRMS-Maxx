<?php 
	$theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
	$favicon_settings = $this->db->get_where('subdomin_favicon_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
	$appleicon_settings = $this->db->get_where('subdomin_appleicon_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
	$logo_settings = $this->db->get_where('subdomin_logo_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

	$theme_settings = unserialize($theme_settings['theme_settings']);

	$website_name = $theme_settings['website_name']?$theme_settings['website_name']:'';
	$logo_or_icon = $theme_settings['logo_or_icon']?$theme_settings['logo_or_icon']:'';
	$system_font = $theme_settings['system_font']?$theme_settings['system_font']:'';
	$sidebar_theme = $theme_settings['sidebar_theme']?$theme_settings['sidebar_theme']:'';
	$theme_color = $theme_settings['theme_color']?$theme_settings['theme_color']:'';
	$top_bar_color = $theme_settings['top_bar_color']?$theme_settings['top_bar_color']:'';
	$login_title = $theme_settings['login_title']?$theme_settings['login_title']:'';

	$site_favicon = $favicon_settings['fav_icon']?$favicon_settings['fav_icon']:'logo2.png';
	$site_appleicon = $appleicon_settings['fav_icon']?$appleicon_settings['fav_icon']:'logo2.png';
	$site_logo = $logo_settings['company_logo']?$logo_settings['company_logo']:'logo2.png';
?>
<div class="p-0">
	<!-- Start Form -->
	<div class="col-lg-12 p-0">
		<?php
		$attributes = array('class' => 'bs-example form-horizontal','id'=>'settingsThemeForm');
		echo form_open_multipart('settings/update', $attributes); ?>
			<div class="panel panel-white m-b-0">
				<div class="panel-heading">
					<h3 class="panel-title p-5"><?=lang('theme_settings')?></h3>
				</div>
				<div class="panel-body">
					<?php echo validation_errors(); ?>
					<input type="hidden" name="settings" value="<?=$load_setting?>">
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('site_name')?></label>
						<div class="col-lg-4">
							<input type="text" name="website_name" class="form-control" value="<?=$website_name; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('logo')?></label>
						<div class="col-lg-4">
							<select name="logo_or_icon" class="form-control">
								<?php $logoicon = $logo_or_icon; ?>
								<option value="logo_title"<?=($logoicon == "logo_title" ? ' selected="selected"' : '')?>><?=lang('logo')?> & <?=lang('site_name')?></option>
								<option value="logo"<?=($logoicon == "logo" ? ' selected="selected"' : '')?>><?=lang('logo')?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('company_logo')?></label>
						<div class="col-lg-4">
							<label class="btn btn-default btn-choose">Choose File</label>
							<input type="file" class="form-control" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="logofile">
							
						</div>
						<div class="col-lg-5">
							<?php if ($site_logo != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>assets/images/<?=$site_logo; ?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('favicon')?></label>
						<div class="col-lg-4">
							<label class="btn btn-default btn-choose">Choose File</label>
							<input type="file" class="form-control" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="iconfile">
							
						</div>
						<div class="col-lg-5">
							<?php if ($site_favicon != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>assets/images/<?=$site_favicon;?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('apple_icon')?></label>
						<div class="col-lg-4">
							<label class="btn btn-default btn-choose">Choose File</label>
							<input type="file" class="form-control" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="appleicon">
							
						</div>
						<div class="col-lg-5">
							<?php if ($site_appleicon != '') : ?>
							<div class="settings-image"><img src="<?=base_url()?>assets/images/<?=$site_appleicon; ?>" /></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('system_font')?> </label>
						<div class="col-lg-4">
							<?php $font = $system_font; ?>
							<select name="system_font" class="form-control">
								<option value="open_sans"<?=($font == "open_sans" ? ' selected="selected"' : '')?>>Open Sans</option>
								<option value="open_sans_condensed"<?=($font == "open_sans_condensed" ? ' selected="selected"' : '')?>>Open Sans Condensed</option>
								<option value="roboto"<?=($font == "roboto" ? ' selected="selected"' : '')?>>Roboto</option>
								<option value="roboto_condensed"<?=($font == "roboto_condensed" ? ' selected="selected"' : '')?>>Roboto Condensed</option>
								<option value="ubuntu"<?=($font == "ubuntu" ? ' selected="selected"' : '')?>>Ubuntu</option>
								<option value="lato"<?=($font == "lato" ? ' selected="selected"' : '')?>>Lato</option>
								<option value="oxygen"<?=($font == "oxygen" ? ' selected="selected"' : '')?>>Oxygen</option>
								<option value="pt_sans"<?=($font == "pt_sans" ? ' selected="selected"' : '')?>>PT Sans</option>
								<option value="source_sans"<?=($font == "source_sans" ? ' selected="selected"' : '')?>>Source Sans Pro</option>
								<option value="montserrat"<?=($font == "montserrat" ? ' selected="selected"' : '')?>>Montserrat</option>
								<option value="fira_sans"<?=($font == "fira_sans" ? ' selected="selected"' : '')?>>Fira Sans</option>
								<option value="circularstd"<?=($font == "circularstd" ? ' selected="selected"' : '')?>>CircularStd</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('sidebar_theme')?></label>
						<div class="col-lg-4">
							<?php $theme = $sidebar_theme; ?>
							<select name="sidebar_theme" class="form-control">
								<option value="light lter"<?=($theme == "light lter" ? ' selected="selected"' : '')?>>Light</option>
								<option value="dark"<?=($theme == "dark" ? ' selected="selected"' : '')?>>Dark</option>
								<option value="black"<?=($theme == "black" ? ' selected="selected"' : '')?>>Black</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('theme_color')?></label>
						<div class="col-lg-4">
							<?php $theme = $theme_color; ?>
							<select name="theme_color" class="form-control">
								<option value="success" <?=($theme == "success" ? ' selected="selected"' : '')?>>Success</option>
								<option value="info" <?=($theme == "info" ? ' selected="selected"' : '')?>>Info</option>
								<option value="danger" <?=($theme == "danger" ? ' selected="selected"' : '')?>>Danger</option>
								<option value="warning" <?=($theme == "warning" ? ' selected="selected"' : '')?>>Warning</option>
								<option value="dark" <?=($theme == "dark" ? ' selected="selected"' : '')?>>Dark</option>
								<option value="primary" <?=($theme == "primary" ? ' selected="selected"' : '')?>>Primary</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('top_bar_color')?></label>
						<div class="col-lg-4">
							<?php $theme = $top_bar_color; ?>
							<select name="top_bar_color" class="form-control">
								<option value="white" <?=($theme == "white" ? ' selected="selected"' : '')?>>White</option>
								<option value="blue" <?=($theme == "blue" ? ' selected="selected"' : '')?>>Blue</option>
								<option value="maroon" <?=($theme == "maroon" ? ' selected="selected"' : '')?>>Maroon</option>
								<option value="purple" <?=($theme == "purple" ? ' selected="selected"' : '')?>>Purple</option>
								<option value="dark" <?=($theme == "dark" ? ' selected="selected"' : '')?>>Dark</option>
								<option value="orange" <?=($theme == "orange" ? ' selected="selected"' : '')?>>Orange</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('login_title')?></label>
						<div class="col-lg-4">
							<input type="text" name="login_title" class="form-control" value="<?=$login_title?>">
						</div>
					</div>
					<div class="text-center m-t-30">
						<button id="settings_theme_submit" class="btn btn-primary btn-lg"><?=lang('save_changes')?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- End Form -->
</div>