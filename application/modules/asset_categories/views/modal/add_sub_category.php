<div class="modal-dialog">

	<div class="modal-content">

		<div class="modal-header">

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<h4 class="modal-title"><?php echo lang('add_sub_category'); ?></h4>

		</div>

		<?php $attributes = array('class' => 'bs-example','id'=>'settingsDesignationForm');

        echo form_open_multipart('asset_categories/sub_categories', $attributes); ?>

			<div class="modal-body">

				<div class="form-group">

					<label><?php echo lang('category_name'); ?> <span class="text-danger">*</span></label>

					<select name="cat_id" id="cat_id" required="required" class="form-control" >

						<option value="" selected disabled><?php echo lang('categories'); ?></option>

						<?php

						$categories = $this -> db -> get_where('asset_category',array('subdomain_id'=>$this->session->userdata('subdomain_id'))) -> result();

						if (!empty($categories)) { 

						foreach ($categories as $key => $d) { ?>

						<option value="<?php echo $d->cat_id; ?>" <?php if($category_id == $d->cat_id){ ?> selected <?php } ?>><?=$d->category_name?></option>

						<?php } }else{ ?>

						<option value=""><?php echo lang('no_results_found'); ?></option>

						<?php } ?>

					</select>

				</div>

				<div class="form-group">

					<label><?php echo lang('sub_category_name'); ?> <span class="text-danger">*</span></label>

					<input type="text" name="sub_category" class="form-control" required>

				</div>

				<div class="submit-section">

					<button id="settings_designation_submit" class="btn btn-primary submit-btn"><?php echo lang('submit'); ?></button>

				</div>

			</div>

		</form>

	</div>

</div>