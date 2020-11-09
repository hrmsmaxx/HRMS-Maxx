<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title"><?php echo lang('add_incidents');?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $attributes = array('class' => 'bs-example','id'=> 'incidentAddForm'); echo form_open_multipart('incidents/add_incident', $attributes); ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?php echo lang('description_or_name');?> <span class="text-danger">*</span> <span id="already_incident" style="display: none;color:red;">Already Registered Incident</span></label>
					<input type="text" name="incident_name" id="check_incident_name" class="form-control" required>
					<input type="hidden" name="subdomain_id" value="<?php echo $this->session->userdata('subdomain_id');?>" >
					
				</div>
				<?php $incident_types = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("name", "asc")->get('incident_types')->result(); ?>
				<div class="form-group">
					<label><?=lang('type')?> <span class="text-danger">*</span><span id="already_id_code" style="display: none;color:red;"><?php echo lang('incident_type_limt_exceeded');?></span></label>
					
					<select class="select2-option form-control"  name="type" id="incident_types">
						<option value="" selected disabled>Select Type</option>
						<?php
						if(!empty($incident_types))	{
						foreach ($incident_types as $incident_type){ ?>
						<option value="<?=$incident_type->id?>"><?php echo Ucfirst($incident_type->name)?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label class="d-block"><?php echo lang('id_code');?> <span class="text-danger">*</span> </label>
					<input type="text" name="id_code" value="" id="check_incident_id_code" placeholder="<?=lang('eg')?> 543219876" class="form-control" required readonly>
				</div>
				<div class="form-group">
                    <label class="d-block"><?php echo lang('limit_time_to_use');?> </label>
                    <div class="status-toggle">
                        <input type="checkbox" id="status" name="limited_time" class="check limited_time" value="1" >
                        <label for="status" class="checktoggle"><?php echo lang('checkbox');?></label>
                    </div>
                </div>	
                <div class="form-group limit_time_to_use hide">
					<label><?php echo lang('how_much_uses_allowed');?></label>
					<input type="text" name="count_of_days"  class="form-control" >				
				</div>
                <div class="form-group limit_time_to_use hide">
                	
                	<div class="radio">
				      <label><input type="radio" name="incident_periods" value="month" checked><?php echo lang('per_month');?></label>
				    </div>
				    <div class="radio">
				      <label><input type="radio" name="incident_periods" value="year"><?php echo lang('per_year');?></label>
				    </div>
                </div>
                 <div class="form-group">
					<label><?php echo lang('cost');?></label>
					<input type="text" name="cost" id="cost"  class="form-control" >				
				</div>
                <div class="form-group">
                	<label class="d-block"><?php echo lang('count_as_work');?> </label>
                	<div class="radio">
				      <label><input type="radio" name="count_as_work" value="1" checked>Yes</label>
				    </div>
				    <div class="radio">
				      <label><input type="radio" name="count_as_work" value="0">No</label>
				    </div>
                </div>
				<div class="submit-section">
					<button class="btn btn-primary submit-btn" id="incident_submit" ><?php echo lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	 $('#incident_types').change(function(){
        var type_id = $(this).val();
        // alert(type_id);
        if(type_id !=''){
            $.post(base_url+'incidents/check_auto_id_code/',{type_id:type_id},function(data){
                var incident_types = JSON.parse(data);
                if(incident_types.id_code != ""){   
                    $('#check_incident_id_code').val(incident_types.id_code);
                    $('#already_id_code').css('display','none');
                     $('#incident_submit').removeAttr('disabled');
                }else{
            	 	$('#check_incident_id_code').val('');
                	$('#already_id_code').css('display','');
                     $('#incident_submit').attr('disabled','disabled');

                }
            });
        }      
    });

 	// $('#check_incident_name').change(function(){
  //       var incident_name = $(this).val();
  //       if(incident_name !=''){
  //           $.post(base_url+'incidents/check_incident_name/',{incident_name:incident_name},function(res){
  //               if(res == 'yes'){
  //                   $('#already_incident').css('display','');
  //                   $('#incident_submit').attr('disabled','disabled');
  //               }else{
  //                   $('#already_incident').css('display','none');
  //                   $('#incident_submit').removeAttr('disabled');

  //               }
  //           });
  //       }      
  //   });
</script>