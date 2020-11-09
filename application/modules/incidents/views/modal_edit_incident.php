<!-- Modal Dialog -->
<div class="modal-dialog">
	<!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title"><?=lang('edit_incident')?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php
        if (!empty($incidents)) {
            foreach ($incidents as $key => $d) { ?>
                <?php
                $attributes = array('class' => 'bs-example', 'id' => 'incidentAddForm');
                echo form_open(base_url().'incidents/edit_incident',$attributes); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?=$d->id?>">
                       <div class="form-group">
                    <label><?php echo lang('description_or_name');?> <span class="text-danger">*</span> <span id="already_incident" style="display: none;color:red;">Already Registered Incident</span></label>
                    <input type="text" name="incident_name" id="check_incident_name" class="form-control" value ="<?php echo $d->incident_name?>" required>
                    
                </div>
                <?php $incident_types = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("name", "asc")->get('incident_types')->result(); ?>
                <div class="form-group">
                    <label><?=lang('type')?> <span class="text-danger">*</span><span id="already_id_code" style="display: none;color:red;"><?php echo lang('incident_type_limt_exceeded');?></span></label>
                    
                    <select class="select2-option form-control"  name="type" id="incident_types">
                        <option value="" selected disabled>Select Type</option>
                        <?php
                        if(!empty($incident_types)) {
                        foreach ($incident_types as $incident_type){ ?>
                        <option value="<?=$incident_type->id?>" <?php echo ($d->type == $incident_type->id)?"selected":"";?>><?php echo Ucfirst($incident_type->name)?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-block"><?php echo lang('id_code');?> <span class="text-danger">*</span> </label>
                    <input type="text" name="id_code" value="<?php echo $d->id_code?>" id="check_incident_id_code" placeholder="<?=lang('eg')?> 543219876" class="form-control" required readonly>
                </div>
                <div class="form-group">
                    <label class="d-block"><?php echo lang('limit_time_to_use');?> </label>
                    <div class="status-toggle">
                        <input type="checkbox" id="status" name="limited_time" class="check limited_time" value="1" <?php echo ($d->limited_time == 1)?"checked":"";?>>
                        <label for="status" class="checktoggle"><?php echo lang('checkbox');?></label>
                    </div>
                </div>  
              <div class="form-group limit_time_to_use  <?php echo ($d->limited_time == 1)?"":"hide";?>">
                    <label><?php echo lang('how_much_uses_allowed');?></label>
                    <input type="text" name="count_of_days" value="<?php echo $d->count_of_days;?>" class="form-control" required>             
                </div>
                <div class="form-group limit_time_to_use <?php echo ($d->limited_time == 1)?"":"hide";?>">
                    
                    <div class="radio">
                      <label><input type="radio" name="incident_periods" value="month" <?php echo ($d->incident_periods == "month")?"checked":"";?>><?php echo lang('per_month');?></label>
                    </div>
                    <div class="radio">
                      <label><input type="radio" name="incident_periods" value="year" <?php echo ($d->incident_periods == "year")?"checked":"";?>><?php echo lang('per_year');?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php echo lang('cost');?></label>
                    <input type="text" name="cost"  class="form-control" value="<?php echo $d->cost;?>">              
                </div>
                <div class="form-group">
                    <label class="d-block"><?php echo lang('count_as_work');?> </label>
                    <div class="radio">
                      <label><input type="radio" name="count_as_work" value="1" <?php echo ($d->count_as_work == 1)?"checked":"";?>>Yes</label>
                    </div>
                    <div class="radio">
                      <label><input type="radio" name="count_as_work" value="0" <?php echo ($d->count_as_work == 0)?"checked":"";?>>No</label>
                    </div>
                </div>
                
						<div class="submit-section">
							<button type="submit" class="btn btn-primary submit-btn" id="incident_submit"><?=lang('save_changes')?></button>
						</div>
                    </div>
                </form>
        <?php } } ?>
    </div>
    <!-- /Modal Content -->
</div>
<!-- /Modal Dialog -->
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
                    $('#already_id_code').css('display','');
                    $('#check_incident_id_code').val('');
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