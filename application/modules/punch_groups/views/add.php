
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = lang('create');
            if(isset($punch_group['id'])&&!empty($punch_group['id'])) 
            {  
				$form_type = lang('edit'); ?> 
     <?php  }
            ?>
			<h4 class="modal-title"><?php echo $form_type; ?> <?php echo lang('group'); ?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example','id'=>'punch_groups'); echo form_open_multipart('punch_groups/add', $attributes); 
			if(isset($punch_group['id'])&&!empty($punch_group['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $punch_group['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('punch_group_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="punch_group_name" class="form-control" value="<?php echo isset($punch_group['punch_group_name'])?$punch_group['punch_group_name']:''; ?>" >
				</div>
				
				<?php $locations = $this->db->get_where('dgt_locations', array('subdomain_id'=>$this->session->userdata('subdomain_id')))->result(); ?>
				<div class="form-group">
					<label><?=lang('location_name')?> <span class="text-danger">*</span></label>
					<select class=" form-control"  name="location" id="location" >
						<option value="" disabled selected="selected"><?=lang('select_location')?></option>
						<?php
						if(!empty($locations))	{
							foreach ($locations as $key => $location){ 
								?>
								<option value="<?=$location->id;?>" <?php echo (isset($punch_group['location']) && ($punch_group['location']==$location->id))?'selected':''; ?>><?=$location->location_name;?></option>
							<?php } ?>
						<?php } else { ?>
								<option value=""><?=lang('select_location')?></option>
						<?php } ?>

					</select>
				</div>
				<?php $employees = $this->db->get_where('dgt_users', array('role_id'=>3,'status'=>'1','subdomain_id'=>$this->session->userdata('subdomain_id')))->result(); ?>
				<div class="form-group">
					<label><?=lang('employees')?> <span class="text-danger">*</span></label>
					<select class=" form-control"  multiple="multiple" name="employee_id[]" id="employees" >
						<option value="" disabled ><?=lang('select_employees')?></option>
						<?php
						if(!empty($employees))	{
							$employees_id = explode(',', $punch_group['employee_id']); 
							foreach ($employees as $key => $employee){ 
								?>
								<option value="<?=$employee->id;?>" <?php if(in_array($employee->id, array_values($employees_id))) { echo 'selected'; } ?>><?php echo User::displayName($employee->id);?></option>
							<?php } ?>
						<?php } else { ?>
								<option value=""><?=lang('select_employees')?></option>
						<?php } ?>

					</select>
				</div>

				<div class="submit-section">
					<button class="btn btn-primary submit-btn punch_groups_submit"><?php echo lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>