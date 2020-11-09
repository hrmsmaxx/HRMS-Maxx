<div>
	<form action="<?php echo base_url(); ?>settings/tokbox_settings" id="tokbox_form" class="bs-example form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		<div class="panel panel-white m-b-0">
			<div class="panel-heading">
				<h3 class="panel-title p-5"><?php echo lang('tokbox_settings');?></h3>
			</div>
			<div class="panel-body">
				<input type="hidden" name="settings" value="tokbox_setting">
				<div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('apikey');?> <span class="text-danger">*</span></label>
					<div class="col-lg-3">
						<input type="text" name="apikey_tokbox" id="apikey_tokbox"  class="form-control" value="" placeholder="xxxxxxxxx" readonly>
						<!--<input type="text" name="apikey_tokbox" id="apikey_tokbox"  class="form-control" value="<?php //echo config_item('apikey_tokbox'); ?>" placeholder="TokBox ApiKey" >-->
					</div>
				</div>
			   <div class="form-group">
					<label class="col-lg-3 control-label"><?php echo lang('apiSecret');?> <span class="text-danger">*</span></label>
					<div class="col-lg-6">
						<input type="text" name="apisecret_tokbox" id="apisecret_tokbox" class="form-control" value="<?php //echo config_item('apisecret_tokbox'); ?>" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxx" readonly>
						<!--<input type="text" name="apisecret_tokbox" id="apisecret_tokbox" class="form-control" value="<?php //echo config_item('apisecret_tokbox'); ?>" placeholder="TokBox ApiKeySecret">-->
					</div>
				</div>
				<div class="text-center m-t-30">
					<button id="tokbox_set_btn" type="submit" class="btn btn-primary btn-lg" disabled><?php echo lang('save_changes');?></button>
				</div>
			</div>
		</div>
	</form>
</div>