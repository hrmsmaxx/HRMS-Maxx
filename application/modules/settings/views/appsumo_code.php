<div class="p-0">
    <!-- Start Form -->
    <div class="col-lg-12 p-0">
        <?php
        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');
        echo form_open_multipart('settings/appsumo_code', $attributes); ?>
            <div class="card-box">                        
					<h3 class="card-title"><a>Stacking an AppSumo code</a></h3>

                    <h5>If you're one of the lucky few that purchased more than one AppSumo code, then you've come to the right place. Simply enter your second code in the form below and we'll stack it on top of your existing account</h5>                    
                    <div class="tab-content tab-content-fix">
                        <div class="tab-pane fade in active" id="tab-english">
                            <div class="row">
								<div class="col-sm-6">
									<div class="form-group">										
										<input type="text" name="appsumo_code" id="appsumo_code" class="form-control" placeholder="Enter the code you'd like to stack here..." >
									</div>
								</div>
                            </div>
                        </div>
					<div class="">
                        <button  class="btn btn-primary code_validation">Apply Code</button>
					</div>
				</div>
            </div>
        </form>
    </div>
    <!-- End Form -->
</div>