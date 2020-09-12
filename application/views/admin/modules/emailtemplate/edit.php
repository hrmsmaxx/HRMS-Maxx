<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					<h4 class="page-title m-b-20 m-t-0">Edit Email Template</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">                        

                        <form class="form-horizontal" action="<?php echo base_url('admin/emailtemplate/edit/'.$edit_data['template_id']); ?>" method="POST" enctype="multipart/form-data" >
							<div class="form-group">
								<label class="col-sm-3 control-label">Email Title</label>
								<div class="col-sm-9">
									<?php if($edit_data['template_title']) echo $edit_data['template_title']; ?>                             
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Reference ID</label>
								<div class="col-sm-9">
									#<?php if($edit_data['template_type']) echo $edit_data['template_type']; ?>                             
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Template Content</label>
								<div class="col-sm-9">
									<?php
									if (!empty($edit_data['template_content'])) {
										echo  "<textarea class='form-control' id='ck_editor_textarea_id' rows='6' name='template_content'>" . $edit_data['template_content'] ."</textarea>";
										echo display_ckeditor($ckeditor_editor1);
									}
									else {
										echo "<textarea class='form-control' id='ck_editor_textarea_id' rows='6' name='template_content'> </textarea>";
										echo display_ckeditor($ckeditor_editor1);
									}
									?>
								</div>
							</div>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
								<a href="<?php echo base_url().'admin/emailtemplate' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>                          
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>