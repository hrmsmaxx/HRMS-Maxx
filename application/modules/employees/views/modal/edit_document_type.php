<!-- Modal Dialog -->
<div class="modal-dialog">
	<!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title"><?=lang('edit_document_types')?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php
        if (!empty($document_types)) {
            foreach ($document_types as $key => $d) { ?>
                <?php
                $attributes = array('class' => 'bs-example', 'id' => 'document_typeAddForm');
                echo form_open(base_url().'employees/edit_document_type',$attributes); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?=$d->id?>">
                        <input type="hidden" name="user_id" value="<?=$d->user_id?>">
                    <div class="form-group">
                      <label><?php echo lang('name');?> <span class="text-danger">*</span></label>
                      <input class="form-control" type="text" name = "type_name" id="type_name" value="<?php echo $d->type_name?>" required>                    
                    </div>
                    

                    <div class="form-group">
                            <label class="d-block"><?php echo lang('status');?></label>
                            <div class="status-toggle">
                                <input type="checkbox" id="status2" name="status" class="check" value="1" <?php echo ($d->status == 1)?"checked":"";?>>
                                <label for="status2" class="checktoggle"><?php echo lang('checkbox');?></label>
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