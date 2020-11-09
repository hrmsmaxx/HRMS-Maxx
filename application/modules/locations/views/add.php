<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>  -->
 
      <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
<script> 

	



// $(document).ready(function(){ 

//     if (navigator.geolocation) { 

//         navigator.geolocation.getCurrentPosition(showLocation); 

//     } else { 

//         $('#location').html('Geolocation is not supported by this browser.'); 

//     } 

//  function showLocation(position) { 

//     var latitude = position.coords.latitude; 

// var longitude = position.coords.longitude; 
// $('#latitude').val(latitude);
// $('#longitude').val(longitude);
     
// } 

</script>
 <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxeoEhkCzN7XtI4rPzuK0LfOiAOLv3-zY&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <script type="text/javascript">
function initMap() {

	var latitude1 = $('#latitude').val();
	var longitude1 = $('#longitude').val();

	if((latitude1 != '') && (longitude1 != '')){
		latitude = parseFloat(latitude1);
		longitude = parseFloat(longitude1);
	}else{
		latitude = 11.127122499999999;
		longitude = 78.6568942;
	}
	// latitude = 11.127122499999999;
	// longitude = 78.6568942;
	// alert(latitude);
	const myLatlng = { lat: latitude, lng: longitude };
       
  // The map, centered at Uluru
  	const map = new google.maps.Map(document.getElementById("map"), {
	    zoom: 4,
	    center: myLatlng,
  	});
  // The marker, positioned at Uluru
  	const marker = new google.maps.Marker({
   	 	position: myLatlng,
    	map: map,
  	});
	google.maps.event.addListener(map, "click", function (e) {

			    //lat and lng is available in e object
			    var latLng = e.latLng;
			    // latLng = latLng.split('(').join("");
			    // latLng = latLng.split(')').join("");
			    // console.log(latLng);
			    $.ajax({ 

type:'POST', 

url: base_url+'locations/geolocation', 

data:'latLng='+latLng, 

success:function(datas){ 
	console.log(datas);
		data = JSON.parse(datas);
            if(data){ 

               $("#address").val(data.address); 
               $("#latitude").val(data.latitude); 
               $("#longitude").val(data.longitude); 

            }else{ 

                $("#address").val(''); 

            } 

} 

}); 

			   

			});
      }
</script> 
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
            <?php 
            $form_type = lang('create');
            if(isset($location['id'])&&!empty($location['id'])) 
            {  
				$form_type = lang('edit'); ?> 
     <?php  }
            ?>
			<h4 class="modal-title"><?php echo $form_type; ?> <?php echo lang('location'); ?></h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<?php 
			$attributes = array('class' => 'bs-example','id'=>'locations'); echo form_open_multipart('locations/add', $attributes); 
			if(isset($location['id'])&&!empty($location['id'])) 
            {    ?>
                <input type = "hidden" name="edit" value="true">
                <input type = "hidden" name="id" value="<?php echo $location['id']; ?>">
     <?php  } ?>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang('location_name')?> <span class="text-danger">*</span></label>
					<input type="text" name="location_name" id="location_name" class="form-control" value="<?php echo isset($location['location_name'])?$location['location_name']:''; ?>" >
				</div>
				<div class="form-group">
					<label><?=lang('country')?> <span class="text-danger">*</span></label>
					<input type="text" name="country" id="country" class="form-control" value="<?php echo isset($location['country'])?$location['country']:''; ?>" >
				</div>
				<div class="form-group">
					<label><?=lang('state')?> <span class="text-danger">*</span></label>
					<input type="text" name="state" id="state" class="form-control" value="<?php echo isset($location['state'])?$location['state']:''; ?>" >
				</div>
				<div class="form-group">
					<label><?=lang('address')?> <span class="text-danger">*</span></label>
					<input type="text" name="address" id="address" class="form-control" value="<?php echo isset($location['address'])?$location['address']:''; ?>" >
				</div>
				<div class="form-group">
					<label><?=lang('radius')?> <span class="text-danger">*</span></label>
					<input type="number" name="radius" id="radius" class="form-control" value="<?php echo isset($location['radius'])?$location['radius']:''; ?>" >
				</div>
				<div class="row">
					<div class="form-group col-md-6 col-xs-6 ">
					<label><?=lang('latitude')?> <span class="text-danger">*</span></label>
					<input type="text" name="latitude" id="latitude" class="form-control" value="<?php echo isset($location['latitude'])?$location['latitude']:''; ?>" >
				</div>
				<div class="form-group col-md-6 col-xs-6 ">
					<label><?=lang('longitude')?> <span class="text-danger">*</span></label>
					<input type="text" name="longitude" id="longitude" class="form-control" value="<?php echo isset($location['longitude'])?$location['longitude']:''; ?>" >
				</div>
				</div>
				

				<div>
					<p><span class="label">Your Location:</span> <span id="location"></span></p> 
				</div>
				<div id="map"></div>
				
				<div class="submit-section">
					<button class="btn btn-primary submit-btn locations_submit"><?php echo lang('submit');?></button>
				</div>
			</div>
		</form>
	</div>
</div>