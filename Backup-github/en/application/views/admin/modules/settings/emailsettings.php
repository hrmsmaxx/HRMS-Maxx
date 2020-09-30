<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					<?php if($this->session->flashdata('message')) { ?>
					<?php echo $this->session->userdata('message'); ?>
					<?php } ?>
                    <h4 class="page-title m-b-20 m-t-0">Email Settings </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card-box">
						<form class="form-horizontal" id="form_emailsetting" action="" method="POST" enctype="multipart/form-data">
							<div id="email_settings" class="tab-pane active">
								<div class="form-group">
									<label class="col-sm-3 control-label">Email From Address</label>
									<div class="col-sm-9">
										<input  type="text" id="website_name" name="email_address" value="<?php if (isset($email_address)) echo $email_address;?>" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Emails From Name</label>
									<div class="col-sm-9">
										<input type="text" id="email_tittle" name="email_tittle" value="<?php if (isset($email_tittle)) echo $email_tittle;?>" class="form-control only_alphabets" >
									</div>
								</div>
							</div>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
							</div>
						</form>
					</div>
                </div>
			</div>
		</div>
		
 <script>
 function subitmorefield()
 {
	var labe=$("#field-1").val();
	var fname= $("#field-2").val();
    var html=''; 
	var html = '<div class="form-group">';
      html = html+' <label class="col-sm-3 control-label">'+labe+'</label>';
	  html = html+' <div class="col-sm-9">'; 
	  html = html+'<input type="text" class="form-control"  name="'+fname+'" placeholder="Type here.." value=""'; 
	  html = html+'</div>';
	  html = html+'</div>';
    $('.hrs_detail_addmore').append(html);
  	$('#con-close-modal').modal('hide');
 }
 </script>
