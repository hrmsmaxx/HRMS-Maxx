<div class="p-0">

    <!-- Employee Start Form -->

    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/data_import', $attributes); ?>

            <div class="card-box">

                        <a href="<?php echo base_url(); ?>settings/user_excel" class="btn btn-primary submit-btn" style="float: right;" ><?php echo lang('employee_export')?></a>

					<h3 class="card-title"><?php echo lang('employee_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

										<input type="file" name="data_import" id="data_import" class="form-control" required="required">

									</div>

								</div>

                            </div>

                        </div>

					<div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

					</div>

				</div>

            </div>

        </form>

    </div>

    <!--Employee End Form -->

    <!--Department Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/department_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('department_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Department End-->

    <!--Designation Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/designation_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('designation_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Designation End -->

    <!--Personal Information Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/personal_information_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('personal_information_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Personal Information Start -->

     <!--Emergency Contact Information Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/emergency_contact_information_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('emergency_contact_information_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Emergency Contact Information End -->

     <!--Bank Information Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/bank_information_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('bank_information_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Bank Information End -->

    <!--Family Informations Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/family_informations_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('family_informations_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Famil Informations End -->

    <!--Education Informations Start -->


    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/education_informations_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('education_informations_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
    <!--Education Informations End -->

    <!--Shift Import Start -->

    <div class="col-lg-12 p-0">

        <?php

        $attributes = array('class' => 'bs-example','id'=>'dataimport_form','enctype'=>'multipart/form-data');

        echo form_open_multipart('settings/shift_import', $attributes); ?>

            <div class="card-box">

                       

                    <h3 class="card-title"><?php echo lang('shift_import')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label> <?php echo lang('choose_upload_file');?><span class="text-danger">*</span></label>

                                        <input type="file" name="data_import" id="data_import" class="form-control" required="required">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('import')?></button>

                    </div>

                </div>

            </div>

        </form>

    </div>
   
    <!--Shift Import End -->    

</div>