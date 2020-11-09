<!-- Modal Dialog -->
<div class="modal-dialog">
	<!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title"><?=lang('edit_attendance')?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php
        if (!empty($record)) {
            ?>
                <?php
                $attributes = array('class' => 'bs-example', 'id' => 'incidentAddForm');
                echo form_open(base_url().'attendance/edit_attendance_time',$attributes); ?>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                        <input type="hidden" name="day" value="<?php echo $atten_day?>">
                        <input type="hidden" name="month" value="<?php echo $atten_month?>">
                        <input type="hidden" name="year" value="<?php echo $atten_year?>">
                        <input type="hidden" name="key" value="<?php echo $key?>">
                        <input type="hidden" name="punch" value="<?php echo $punch?>">
                        <input type="hidden" name="workcode" value="<?php echo $workcode?>">
                        <?php
                                   

                                     if(!empty($record['month_days_in_out'])){

                                     $month_days_in_outs =  unserialize($record['month_days_in_out']); 

                                     // echo print_r($month_days_in_outs[$atten_day][$key][]);
                                     ?>

                        <div class="form-group">
                            <label><?php echo lang($punch.'_time');?> <span class="text-danger">*</span> </label>
                            <div class='input-group date time_picker'>
                              <input type="text" name="punch_time" id="punch_time" class="form-control" value ="<?php echo $month_days_in_outs[$atten_day][$key][$punch];?>" required> 
                              <span class="input-group-addon" ><span class="glyphicon glyphicon-time"></span></span>                
                            </div>
                        </div>
                        <?php $incidents = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by("id", "asc")->get('incidents')->result(); ?>
                        <div class="form-group">
                            <label><?php echo lang('incidents');?> <span class="text-danger">*</span></label>
                            
                            <select class="select2-option form-control"  name="workcode" id="workcode" required="required">
                                <option value="" selected disabled><?php echo lang('select_incidents');?></option>
                                <?php
                                if(!empty($incidents)) {
                                foreach ($incidents as $incident){ ?>
                                <option value="<?=$incident->id?>" <?php echo ($workcode == $incident->id)?"selected":"";?>><?php echo Ucfirst($incident->incident_name)?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>   
                                              

                                          <?php  }

                                          
                                             ?>
                        
                       
                            <div class="form-group">
                            <label><?php echo lang('description');?>  </label>
                            <div class='input-group'>
                            <textarea name="description" id="description" class="form-control" rows="3" cols="100" ><?php echo $month_days_in_outs[$atten_day][$key][$punch.'_description'];?></textarea>
                                               
                            </div>
                        </div>
						<div class="submit-section">
							<button type="submit" class="btn btn-primary submit-btn" id="incident_submit"><?=lang('save_changes')?></button>
						</div>
                    </div>
                </form>
        <?php  } ?>
    </div>
    <!-- /Modal Content -->
</div>
<script type="text/javascript">
    $('.close').on('click',function(e){
        location.reload();
    });
</script>