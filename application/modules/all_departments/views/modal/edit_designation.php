

<div class="modal-dialog">

	<div class="modal-content">

		<div class="modal-header">

			<h4 class="modal-title"><?php echo lang('edit_position');?></h4>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

		</div>

		<div class="modal-body">

			<?php $attributes = array('class' => 'bs-example','id'=>'settingsDesignationForm'); echo form_open_multipart('all_departments/edit_designation/'.$des_details['id'], $attributes); ?>

				<div class="form-group">

					<label><?php echo lang('department');?> <span class="text-danger">*</span></label>

					<!-- <input type="hidden" name="des_id" id="des_id" value="<?php //echo $des_details['id']; ?>"> -->

					<input type="hidden" name="created" id="created" value="<?php echo date('Y-m-d H:i:s'); ?>">

					<select name="department_id" id="department_id" required="required" class="form-control" >

						<option value="" selected disabled><?php echo lang('department');?></option>

						<?php
						$subdomain_id = $this->session->userdata('subdomain_id');
						$departments = $this -> db -> get_where('departments',array('subdomain_id'=>$subdomain_id)) -> result();

						if (!empty($departments)) { 

						foreach ($departments as $key => $d) { ?>

						<option value="<?php echo $d->deptid; ?>" <?php if($d->deptid == $des_details['department_id']){ echo "selected"; } ?>><?=$d->deptname?></option>

						<?php } }else{ ?>

						<option value=""><?php echo lang('no_results_found');?></option>

						<?php } ?>

					</select>

				</div>

				<div class="form-group">

					<label><?php echo lang('position_name');?> <span class="text-danger">*</span></label>

					<input type="text" name="designation" class="form-control" value="<?php echo $des_details['designation']; ?>" required>

				</div>

				<div class="form-group">

                            <label ><?php echo lang('level');?> <span class="text-danger">*</span></label><sup> <span class="badge info-badge" data-toggle="tooltip" title="Level"><i class="fa fa-info" aria-hidden="true"></i></span></sup>

                            <select name="grade" id="grade" required="required" class="form-control" >

                                <option value="" selected disabled><?php echo lang('level');?></option>

                                <?php

                                $grades = $this -> db -> get('grades') -> result();

                                if (!empty($grades)) { 

                                foreach ($grades as $key => $d1) { ?>

                                <option value="<?php echo $d1->grade_id; ?>" <?php if($des_details['grade'] == $d1->grade_id){ ?> selected <?php } ?>><?=$d1->grade_name?></option>

                                <?php } }else{ ?>

                                <option value=""><?php echo lang('no_results_found');?></option>

                                <?php } ?>

                            </select>

                        </div>

				<div class="submit-section"> 

					<button id="settings_designation_submit" class="btn btn-primary submit-btn"><?php echo lang('save');?></button>

				</div>

			</form>

		</div>

	</div>

</div>

 <script type="text/javascript"> $('.modal [data-toggle="tooltip"]').tooltip({trigger: 'hover'}); </script> 