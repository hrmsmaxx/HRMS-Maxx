
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
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title"><?php echo lang('add_incident_types');?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php $attributes = array('class' => 'bs-example','id'=> 'incidentTypeAddForm'); echo form_open_multipart('incidents/add_incident_types', $attributes); ?>
			<div class="modal-body">
				<?php $incident_types = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by('id','DESC')->limit(1)->get('incident_types') -> row_array();
					if(empty($incident_types)){
						$id_code = 1;
					}else{
						$id_code = $incident_types['id_code'] + 1;
					}
				?>
				<div class="form-group">
					<label><?php echo lang('id_code');?> <span class="text-danger">*</span></label>
					<input type="text" name="id_code" class="form-control" value="<?php echo $id_code;?>" required readonly>
					<input type="hidden" name="subdomain_id" class="form-control" value="<?php echo $this->session->userdata('subdomain_id');?>" >
					
				</div>
				<div class="form-group">
					<label><?php echo lang('description_or_name');?> <span class="text-danger">*</span></label>
					<input type="text" name="name" class="form-control" required>
					<input type="hidden" name="created_by" value="<?php echo $this->session->userdata('user_id');?>" class="form-control" required>
				</div>
				<div class="form-group">
                	<label class="d-block"><?php echo lang('upload_to_device');?> </label>
                	<div class="radio">
				      <label><input type="radio" name="upload_to_device" value="1" checked>Yes</label>
				    </div>
				    <div class="radio">
				      <label><input type="radio" name="upload_to_device" value="0">No</label>
				    </div>
                </div>
               <!--  <div class="form-group slidecontainer">
					<label><?php echo lang('no_of_incidents');?> <span class="text-danger">*</span></label>
					<input type="range" name="number_of_incidents" min="1" max="100" value="50" class="slider form-control" id="myRange" required>
					
				</div> -->
				<div class="form-group"> 
					<label><?=lang('no_of_incidents')?></label>
					<section class="range-slider">
					  <span class="rangeValues"></span>
					  <input value="0" min="1" max="100" step="1" type="range" name="number_of_incidents_start" >
					  <input value="100" min="1" max="100" step="1" type="range" name="number_of_incidents_end">
					</section>					
				</div> 
				
				<div class="form-group">
                    <label class="d-block"><?php echo lang('status');?></label>
                    <div class="status-toggle">
                        <input type="checkbox" id="status" name="status" class="check" value="1" checked>
                        <label for="status" class="checktoggle"><?php echo lang('checkbox');?></label>
                    </div>
                </div>	
				<div class="submit-section">
					<button class="btn btn-primary submit-btn" id="incident_type_submit"><?php echo lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>