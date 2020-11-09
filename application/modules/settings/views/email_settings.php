<ul class="nav nav-tabs nav-tabs-bottom m-b-30">

	<li class="active"><a href="<?php echo base_url(); ?>settings/?settings=email"><?=lang('email_settings'); ?></a></li>

	<li><a href="<?php echo base_url(); ?>settings/?settings=templates"><?=lang('email_templates'); ?></a></li>

</ul>


<?php 



// SubDomain Settings...
    
    $email_settings = $this->db->get_where('subdomin_email_settings',array('user_id'=>$this->session->userdata('user_id'),'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
    $emails = unserialize($email_settings['email_settings']);
    
    $company_email = $emails['company_email']?$emails['company_email']:'';
    $use_alternate_emails = $emails['use_alternate_emails']?$emails['use_alternate_emails']:'';
    $billing_email = $emails['billing_email']?$emails['billing_email']:'';
    $billing_email_name = $emails['billing_email_name']?$emails['billing_email_name']:'';
    $support_email = $emails['support_email']?$emails['support_email']:'';
    $support_email_name = $emails['support_email_name']?$emails['support_email_name']:'';
    $postmark_api_key = $emails['postmark_api_key']?$emails['postmark_api_key']:'';
    $postmark_from_address = $emails['postmark_from_address']?$emails['postmark_from_address']:'';
    $protocol = $emails['protocol']?$emails['protocol']:'';
    $smtp_host = $emails['smtp_host']?$emails['smtp_host']:'';
    $smtp_user = $emails['smtp_user']?$emails['smtp_user']:'';
    $smtp_pass = $emails['smtp_pass']?$emails['smtp_pass']:'';
    $smtp_port = $emails['smtp_port']?$emails['smtp_port']:'';
    $smtp_encryption = $emails['smtp_encryption']?$emails['smtp_encryption']:'';



 ?>





	<div>

		<?php

		$attributes = array('class' => 'bs-example form-horizontal','data-validate'=>'parsley','id'=>'settingsEmailForm');

		echo form_open('settings/update', $attributes); ?>

			<div class="panel panel-white">

				<div class="panel-heading font-bold">

					<h3 class="panel-title p-5"><?=lang('email_settings')?></h3>

				</div>

				<div class="panel-body">

					<?php echo validation_errors(); ?>

					<input type="hidden" name="settings" value="<?=$load_setting?>">

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('company_email')?> <span class="text-danger">*</span></label>

						<div class="col-lg-4">

							<input type="email" class="form-control" value="<?=$company_email?>" name="company_email" data-type="email" data-required="true">

						</div>

					</div>

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('use_alternate_emails')?></label>

						<div class="col-lg-4">

							<label class="switch">

								<input type="hidden" value="off" name="use_alternate_emails" />

								<input type="checkbox" <?php if($use_alternate_emails == 'TRUE'){ echo "checked=\"checked\""; } ?> name="use_alternate_emails" id="use_alternate_emails">

								<span></span>

							</label>

						</div>

					</div>

					<div id="alternate_emails" <?php echo ($use_alternate_emails != 'TRUE') ? 'style="display:none"' : ''?>>

						<div class="form-group">

							<label class="col-lg-3 control-label"><?=lang('billing_email')?></label>

							<div class="col-lg-4">

								<input type="email" class="form-control" value="<?=$billing_email?>" name="billing_email" data-type="email">

							</div>

						</div>

						<div class="form-group">

							<label class="col-lg-3 control-label"><?=lang('billing_email_name')?></label>

							<div class="col-lg-4">

								<input type="text" class="form-control" value="<?=$billing_email_name?>" name="billing_email_name">

							</div>

						</div>

						<div class="form-group">

							<label class="col-lg-3 control-label"><?=lang('support_email')?></label>

							<div class="col-lg-4">

								<input type="email" class="form-control" value="<?=$support_email?>" name="support_email" data-type="email">

							</div>

						</div>

						<div class="form-group">

								<label class="col-lg-3 control-label"><?=lang('support_email_name')?></label>

							<div class="col-lg-4">

								<input type="text" class="form-control" value="<?=$support_email_name?>" name="support_email_name">

							</div>

						</div>

					</div>

					<!-- <div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('use_postmark')?></label>

						<div class="col-lg-3">

							<label class="switch">

								<input type="hidden" value="off" name="use_postmark" />

								<input type="checkbox" <?php i//f(config_item('use_postmark') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="use_postmark" id="use_postmark">

								<span></span>

							</label>

						</div>

					</div> -->

					<div id="postmark_config" <?php echo (config_item('use_postmark') != 'TRUE') ? 'style="display:none"' : ''?>>

						<div class="form-group">

							<label class="col-lg-3 control-label"><?=lang('postmark_api_key')?></label>

							<div class="col-lg-4">

								<input type="text" class="form-control" placeholder="xxxxx" name="postmark_api_key" value="<?=config_item('postmark_api_key')?>">

							</div>

						</div>

						<div class="form-group">

							<label class="col-lg-3 control-label"><?=lang('postmark_from_address')?></label>

							<div class="col-lg-4">

								<input type="email" class="form-control" placeholder="xxxxx" name="postmark_from_address" value="<?=config_item('postmark_from_address')?>">

							</div>

						</div>

					</div>

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('email_protocol')?> <span class="text-danger">*</span></label>

						<div class="col-lg-4">

							<select name="protocol" class="form-control">

								<?php $prot = $protocol; ?>

								<option value="mail"<?=($prot == "mail" ? ' selected="selected"' : '')?>><?=lang('php_mail')?></option>

								<option value="smtp"<?=($prot == "smtp" ? ' selected="selected"' : '')?>><?=lang('smtp')?></option>

							</select>

						</div>

					</div>

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('smtp_host')?> <span class="text-danger">*</span></label>

						<div class="col-lg-4">

							<input type="text" class="form-control"  value="<?=$smtp_host?>" name="smtp_host">

							<span class="help-block m-b-0"><?=lang('smtp_host_help'); ?></strong>.</span>

						</div>

					</div>

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('smtp_user')?> <span class="text-danger">*</span></label>

						<div class="col-lg-4">

							<input type="text" class="form-control"  value="<?=$smtp_user?>" name="smtp_user">

						</div>

					</div>

					<div class="form-group">

						<?php //$this->load->library('encrypt'); ?>

						<label class="col-lg-3 control-label"><?=lang('smtp_pass')?> <span class="text-danger">*</span></label>

						<div class="col-lg-4">

							<input type="password" class="form-control" value="<?=$smtp_pass;?>" name="smtp_pass">

						</div>

					</div>

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('smtp_port')?> <span class="text-danger">*</span></label>

						<div class="col-lg-4">

							<input type="text" class="form-control" value="<?=$smtp_port?>" name="smtp_port">

						</div>

					</div>

					<div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('email_encryption')?></label>

						<div class="col-lg-4">

							<select name="smtp_encryption" class="form-control">

								<?php $crypt = $smtp_encryption; ?>

								<option value=""<?=($crypt == "" ? ' selected="selected"' : '')?>><?=lang('none')?></option>

								<option value="ssl"<?=($crypt == "ssl" ? ' selected="selected"' : '')?>>SSL</option>

								<option value="tls"<?=($crypt == "tls" ? ' selected="selected"' : '')?>>TLS</option>

							</select>

						</div>

					</div>

					<div class="text-center m-t-30">

						<button id='settings_email_submit' class="btn btn-primary btn-lg"><?=lang('save_changes')?></button>

					</div>

				</div>

			</div>

		</form>

        <?php

        $attributes = array('class' => 'bs-example form-horizontal','id'=>'settingsEmailPipes');

        echo form_open_multipart('settings/update', $attributes); ?>

            <!-- <div class="panel panel-white m-b-0">

                <div class="panel-heading">

					<h3 class="panel-title"><?=lang('email_piping_settings')?></h3>

				</div>

                <div class="panel-body">

                    <?php echo validation_errors(); ?>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="form-group">

						<label class="col-lg-3 control-label"><?=lang('activate_email_tickets')?></label>

						<div class="col-lg-3">

							<label class="switch">

								<input type="hidden" value="off" name="email_piping" />

								<input type="checkbox" <?php if(config_item('email_piping') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="email_piping">

								<span></span>

							</label>

						</div>

					</div>

                    <div class="form-group">

						<label class="col-lg-3 control-label">IMAP</label>

						<div class="col-lg-3">

							<label class="switch">

								<input type="hidden" value="off" name="mail_imap" />

								<input type="checkbox" <?php if(config_item('mail_imap') == 'TRUE'){ echo "checked=\"checked\""; } ?> id="check_mail_imap" name="mail_imap">

								<span></span>

							</label>

						</div>

					</div>

                    <div class="form-group">

                        <label class="col-lg-3 control-label">IMAP Host</label>

                        <div class="col-lg-5">

                            <input type="text" class="form-control" value="<?=config_item('mail_imap_host')?>" name="mail_imap_host">

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-lg-3 control-label">IMAP Username</label>

                        <div class="col-lg-5">

                            <input type="text" autocomplete="off" class="form-control" value="<?=config_item('mail_username')?>" name="mail_username">

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-lg-3 control-label">IMAP Password</label>

                        <div class="col-lg-5">

                        <?php

                        //$this->load->library('encrypt');

                        //$pass = $this->encrypt->decode(config_item('mail_password'));

                        ?>

                            <input type="password" autocomplete="off" class="form-control" value="<?=config_item('mail_password')?>" name="mail_password">

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-lg-3 control-label">Mail Port</label>

                        <div class="col-lg-5">

                            <input type="text" class="form-control" value="<?=config_item('mail_port')?>" name="mail_port">

                        </div>

                        <span class="help-block m-b-0">Port (143 or 110) (Gmail: 993)</span>

                    </div>

                    <div class="form-group">

                        <label class="col-lg-3 control-label">Mail Flags</label>

                        <div class="col-lg-5">

                            <input type="text" class="form-control" value="<?=config_item('mail_flags')?>" name="mail_flags">

                        </div>

                        <span class="help-block m-b-0">/notls or /novalidate-cert</span>

                    </div>

                    <div class="form-group">

						<label class="col-lg-3 control-label">Mail SSL</label>

						<div class="col-lg-3">

							<label class="switch">

								<input type="hidden" value="off" name="mail_ssl" />

								<input type="checkbox" <?php if(config_item('mail_ssl') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="mail_ssl">

								<span></span>

							</label>

						</div>

					</div>

					<div class="form-group">

                        <label class="col-lg-3 control-label">Mailbox</label>

                        <div class="col-lg-5">

                            <input type="text" class="form-control" value="<?=config_item('mailbox')?>" name="mailbox">

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-lg-3 control-label">IMAP Search</label>

                        <div class="col-lg-5">

                            <input type="text" class="form-control" value="<?=config_item('mail_search')?>" name="mail_search">

                        </div>

                        <span class="help-block m-b-0">UNSEEN</span>

                    </div>

					<div class="text-center m-t-30">

                        <button id="settings_email_piping" class="btn btn-primary btn-lg"><?=lang('save_changes')?></button>

					</div>

                </div>

            </div> -->

        </form>

	<!-- End Form -->

</div>