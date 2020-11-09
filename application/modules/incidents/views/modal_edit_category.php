<script type="text/javascript">
$(document).ready(function () {
  // Initialize Sliders
  var sliderSections = document.getElementsByClassName("range-slider");
      for( var x = 0; x < sliderSections.length; x++ ){
        var sliders = sliderSections[x].getElementsByTagName("input");
        for( var y = 0; y < sliders.length; y++ ){
          if( sliders[y].type ==="range" ){
            sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
          }
        }
      }


});
 function getVals(){
  // Get slider values
  var parent = this.parentNode;
  var slides = parent.getElementsByTagName("input");
    var slide1 = parseFloat( slides[0].value );
    var slide2 = parseFloat( slides[1].value );
  // Neither slider will clip the other, so make sure we determine which is larger
  if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }
  
  var displayElement = parent.getElementsByClassName("rangeValues")[0];
      displayElement.innerHTML = slide1 + " - " + slide2;
}
</script>
<!-- Modal Dialog -->
<div class="modal-dialog">
	<!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title"><?=lang('edit_incident_types')?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php
        if (!empty($incident_types)) {
            foreach ($incident_types as $key => $d) { ?>
                <?php
                $attributes = array('class' => 'bs-example');
                echo form_open(base_url().'incidents/edit_incident_types',$attributes); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?=$d->id?>">
                        <div class="form-group">
                            <label><?php echo lang('id_code');?> <span class="text-danger">*</span></label>
                            <input type="text" name="id_code" class="form-control" value="<?php echo $d->id_code;?>" required readonly>
                            
                        </div>
                        <div class="form-group">
                            <label><?php echo lang('description_or_name');?> <span class="text-danger">*</span></label>
							<input type="text" class="form-control" value="<?=$d->name?>" name="name">
                        </div>
                        <div class="form-group">
                            <label class="d-block"><?php echo lang('upload_to_device');?> </label>
                            <div class="radio">
                              <label><input type="radio" name="upload_to_device" value="1" <?php echo ($d->upload_to_device == 1)?"checked":"";?>>Yes</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="upload_to_device" value="0" <?php echo ($d->upload_to_device == 0)?"checked":"";?>>No</label>
                            </div>
                        </div> 
                        <!-- <div class="form-group">
                            <label><?php echo lang('no_of_incidents');?> <span class="text-danger">*</span></label>
                            <input type="text" name="number_of_incidents" class="form-control" value="<?=$d->number_of_incidents?>" required >
                            
                        </div> -->
                        <div class="form-group"> 
                            <label><?=lang('no_of_incidents')?></label>
                            <section class="range-slider">
                              <span class="rangeValues"></span>
                              <input value="<?php echo $d->number_of_incidents_start;?>" min="1" max="100" step="1" type="range" name="number_of_incidents_start" >
                              <input value="<?php echo $d->number_of_incidents_end;?>" min="1" max="100" step="1" type="range" name="number_of_incidents_end">
                            </section>                  
                        </div>

                        <div class="form-group">
                            <label class="d-block"><?php echo lang('status');?></label>
                            <div class="status-toggle">
                                <input type="checkbox" id="status" name="status" class="check" value="1" <?php echo ($d->status == 1)?"checked":"";?>>
                                <label for="status" class="checktoggle"><?php echo lang('checkbox');?></label>
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <label><?php echo lang('delete_types');?></label>
                            <div>
                                <label class="switch">
                                    <input type="checkbox" name="delete_incident_type">
                                    <span></span>
                                </label>
                            </div>
                        </div>
						<div class="submit-section">
							<button type="submit" class="btn btn-primary submit-btn"><?=lang('save_changes')?></button>
						</div>
                    </div>
                </form>
        <?php } } ?>
    </div>
    <!-- /Modal Content -->
</div>
<!-- /Modal Dialog -->