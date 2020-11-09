
<style>
.datepicker{ z-index:1151 !important; }

</style>
<div class="modal-dialog" id="edit_incident_cal">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?=lang('edit_incident')?></h4>
		</div><?php
			 $attributes = array('class' => 'bs-example','id'=>'calendarAddIncident');
          echo form_open(base_url().'incidents/edit_incident_cal',$attributes); ?>
          <input type="hidden" name="id" value="<?=$incidents->id?>">
		<div class="modal-body">
				<div class="form-group">
	                <label><?=lang('employees')?> <span class="text-danger">*</span></label>
	                    <select class="select2-option form-control" name="emp_id" >
	                    
	                    <optgroup label="<?=lang('employee')?>">
							<?php  if($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor'){
                                    $dept_id= $this->tank_auth->get_department($this->session->userdata('user_id'));
                                    
                            }
                             if (($this->tank_auth->user_role($this->tank_auth->get_user_type()) == 'supervisor') || $_SESSION['is_teamlead'] == 'yes') { 
                                  $this->db->where('role_id', 3);
                                  $this->db->where('activated', 1);
                                  $this->db->where('banned', 0);
                                  $this->db->where('subdomain_id', $this->session->userdata('subdomain_id'));
                                  if($dept_id !=0 && $_SESSION['is_teamlead'] == 'yes'){
                                      if($dept_id !=0){
                                        $depart_id = explode(',', $dept_id);
                                         $this->db->where_in('department_id', $depart_id);
                                      } 
                                      if($_SESSION['is_teamlead'] == 'yes'){
                                          $this->db->or_where('teamlead_id',$this->session->userdata('user_id'));
                                      }
                                  }else{

                                       if($dept_id !=0){
                                        $depart_id = explode(',', $dept_id);
                                         $this->db->where_in('department_id', $depart_id);
                                      } 
                                      if($_SESSION['is_teamlead'] == 'yes'){
                                          $this->db->where('teamlead_id',$this->session->userdata('user_id'));
                                      }
                                  }
                                  $employees = $this->db->get('users')->result();
                             }
                             if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin'){
                                $employees = $this->db->get_where('users',array('role_id'=>3,'activated'=>1,'banned'=>0,'subdomain_id'  => $this->session->userdata('subdomain_id')))->result();
                             }?>

	                        <?php foreach ($employees as $p){ ?>
	                        <option value="<?=$p->id?>" <?php echo ($incidents->emp_id == $p->id)?"selected":"";?>><?php echo ucfirst(user::displayName($p->id));?></option>
	                        <?php } ?>
	                    </optgroup>
	                    </select>
	            </div>
			 	<div class="form-group">
	                <label><?=lang('incidents')?> <span class="text-danger">*</span></label>
	                    <select class="select2-option form-control" name="incident" >
	                   
	                    <optgroup label="<?=lang('incidents')?>">
							<?php $incident = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->get('incidents')->result();?>

	                        <?php foreach ($incident as $p){ ?>
	                        <option value="<?=$p->id?>" <?php echo ($incidents->incident == $p->id)?"selected":"";?>><?php echo ucfirst($p->incident_name);?></option>
	                        <?php } ?>
	                    </optgroup>
	                    </select>
	            </div>
				


				<div class="form-group">
				<label><?=lang('start_date')?> <span class="text-danger">*</span></label>
					
					
								<div class="cal-icon">
									<input class="form-control" id="add_event_date_from" readonly type="text" value="<?=strftime(config_item('date_format'),strtotime($incidents->start_date));?>" name="start_date" data-date-format="<?=config_item('date_picker_format');?>">
								</div>
					</div>
					

                <div class="form-group">
                                    <label><?=lang('end_date')?> <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control" id="add_event_date_to" type="text" value="<?=strftime(config_item('date_format'),strtotime($incidents->end_date));?>" name="end_date" data-date-format="<?=config_item('date_picker_format');?>">
                                    </div>
                </div>

				

                <div class="form-group">
				<label><?=lang('event_color')?> <span class="text-danger">*</span></label>
					<!-- <input type="text" class="form-control" placeholder="#38354a" name="color"> -->
						<input type="text" id="event_cp" name="color" value="<?php echo $incidents->color;?>" class="form-control" /> 
						
					</div>

		</div>
		<div class="modal-footer"><a href="#" class="btn btn-danger close_modal" data-dismiss="modal"><?=lang('close')?></a>
		<button type="submit" class="btn btn-success" id="calendar_add_incident"><?=lang('edit_incidents')?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    $('#add_event_date_from').datepicker({
    //autoclose: true
    }).on('hide', function(e) {
        console.log($(this).val());
        $(this).val($(this).val());
        if($(this).val() != '')
        {
        $(this).parent().parent().addClass('focused');
        }
        else
        {
        $(this).parent().parent().removeClass('focused');
        }
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#add_event_date_to').datepicker('setStartDate', minDate);
        if($('#add_event_date_from').val() > $('#add_event_date_to').val())
        $('#add_event_date_to').val('');
    });

    $('#add_event_date_to').datepicker({
    //autoclose: true
    }).on('hide', function(e) {
        console.log($(this).val());
        $(this).val($(this).val());
        if($(this).val() != '')
        {
        $(this).parent().parent().addClass('focused');
        }
        else
        {
        $(this).parent().parent().removeClass('focused');
        }
    });

</script>
<script type="text/javascript">
	$(".select2-option").select2();
	$(".event-from-time").select2();
</script>
<script type="text/javascript">
	$('#event_cp').minicolors({
          control: $(this).attr('data-control') || 'hue',
          defaultValue: $(this).attr('data-defaultValue') || '',
          format: $(this).attr('data-format') || 'hex',
          keywords: $(this).attr('data-keywords') || '',
          inline: $(this).attr('data-inline') === 'true',
          letterCase: $(this).attr('data-letterCase') || 'lowercase',
          opacity: $(this).attr('data-opacity'),
          position: $(this).attr('data-position') || 'bottom left',
          swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
          change: function(value, opacity) {
            if( !value ) return;
            if( opacity ) value += ', ' + opacity;
            if( typeof console === 'object' ) {
              console.log(value);
            }
          },
          theme: 'bootstrap'
        });
	$('.close_modal').on('click',function(e){
		location.reload();
	});
</script>
