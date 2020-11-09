<!-- Modal Dialog -->
<div class="modal-dialog">
	<!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title"><?=lang('edit_file_attachment')?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php
       if(!empty($user_files)){
                      foreach($user_files as $attachment){ 
                       
                        $ext = pathinfo($attachment['attach_file'], PATHINFO_EXTENSION);
                        if(($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'JPEG') || ($ext == 'jpeg') || ($ext == 'png') || ($ext == 'PNG')){
                          $res = '<a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" download><img src="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" style="height:50px;width:50px;"></a>';
                        }else if($ext == 'pdf'){
                          $res = '<a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" download><span><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 50px;"></i></span></a>';
                        }else{
                          $res = '<a href="'.base_url().'assets/uploads/profile_attachments/'.$attachment['attach_file'].'" download><span><i class="fa fa-file-text-o" aria-hidden="true" style="font-size: 50px;"></i></span></a>';
                        }
                $attributes = array('class' => 'bs-example', 'id' => 'document_typeAddForm','enctype'=>'multipart/form-data');
                echo form_open(base_url().'employees/edit_attachment',$attributes); ?>
                    <div class="modal-body">
                        <input type="hidden" name="user_file_id" value="<?php echo $attachment['user_file_id']?>">
                        <input type="hidden" name="user_id" value="<?php echo $attachment['user_id']?>">
                        <?php

                           $doc_types = $this->db->get_where('document_types',array('user_id'=>$attachment['user_id'],'status'=>1))->result();?>
                    <div class="form-group">

                    <label><?php echo lang('category_of_document');?> <span class="text-danger">*</span></label>
                      
                    <select class="select2-option form-control" style="width:100%;" name="doc_type" id="doc_type" >
                        <!-- <option value="" selected disabled><?php echo lang('select_category');?></option> -->
                          <?php

                           if(!empty($doc_types)) {

                           foreach ($doc_types as $type){ ?>

                            <option value="<?=$type->id?>" <?php echo ($type->id == $attachment['doc_type'])?"checked":""?> ><?php echo $type->type_name?></option>

                            <?php } ?>

                            <?php } ?>

                          

                    </select>
                  </div>
                  <div class="form-group">
                    <label><?php echo lang('description');?> <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="description" value="<?php echo $attachment['description']?>" required>
                    
                  </div>
                   
                  <div class="form-group">
                      <label class="d-block"><?php echo lang('document_will_have_an_expiration_date');?> </label>
                      <div class="status-toggle">
                          <input type="checkbox" id="status1" name="is_expired" class="check is_expired_edit" value="1" <?php echo ($attachment['is_expired'] == 1)?"checked":"";?>>
                          <label for="status1" class="checktoggle"><?php echo lang('checkbox');?></label>
                      </div>
                    </div> 
                    <div class="form-group expired <?php echo ($attachment['is_expired'] == 1)?"":"hide";?>">
                      <label><?php echo lang('expiration_date');?></label>
                      <div class="cal-icon">
                        <input class="form-control datetimepicker" id="" readonly type="text" value="<?php echo ($attachment['expired_date'] !='0000-00-00')?date('d-m-Y',strtotime($attachment['expired_date'])):''; ?>" name="expired_date"  data-date-format="<?=config_item('date_picker_format');?>" data-date-start-date="0d" >
                      </div>        
                    </div>
                    <div class="form-group expired <?php echo ($attachment['is_expired'] == 1)?"":"hide";?>">
                      <label><?php echo lang('days_before_expiration_date');?> <span class="text-danger">*</span></label>
                      <input class="form-control" type="text" name = "before_expired_day" id="before_expired_day" value="<?php echo $attachment['before_expired_day'];?>">
                    </div>
                  <div class="form-group">
                    <label><?php echo lang('upload_files');?> <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name = "attach_file[]" id="attach_file" multiple >
                    <?php echo $res?>
                    <input class="form-control" type="hidden" name = "image" id="image" value = <?php echo $attachment['attach_file']?>>
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