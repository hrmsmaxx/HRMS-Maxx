<?php 

    // SubDomain Settings...
    
    $general_settings = $this->db->get_where('subdomin_general_settings',array('user_id'=>$this->session->userdata('user_id'),'subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
    
    $general = unserialize($general_settings['general_settings']);
    
    $company_name = $general['company_name']?$general['company_name']:'';
    $company_legal_name = $general['company_legal_name']?$general['company_legal_name']:'';
    $contact_person = $general['contact_person']?$general['contact_person']:'';
    $company_address = $general['company_address']?$general['company_address']:'';
    $company_zip_code = $general['company_zip_code']?$general['company_zip_code']:'';
    $company_city = $general['company_city']?$general['company_city']:'';
    $company_state = $general['company_state']?$general['company_state']:'';
    $company_country = $general['company_country']?$general['company_country']:'';
    $company_email = $general['company_email']?$general['company_email']:'';
    $company_phone = $general['company_phone']?$general['company_phone']:'';
    $company_phone_2 = $general['company_phone_2']?$general['company_phone_2']:'';
    $company_mobile = $general['company_mobile']?$general['company_mobile']:'';
    $company_fax = $general['company_fax']?$general['company_fax']:'';
    $company_domain = $general['company_domain']?$general['company_domain']:'';
    $company_registration = $general['company_registration']?$general['company_registration']:'';
    $company_vat = $general['company_vat']?$general['company_vat']:'';
    $company_import_email = $general['company_import_email']?$general['company_import_email']:'';


    ?>




	<div>

        <?php

        $attributes = array('class' => 'bs-example','id'=>'settingsGeneralForm');

        echo form_open_multipart('settings/update', $attributes); ?>

            <div class="card-box m-b-0">

					<h3 class="card-title"><?=lang('company_details')?></h3>

                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <input type="hidden" name="languages" value="<?=implode(",",$translations)?>">



                    <?php if (count($translations) > 0) : ?>



                    <!-- <ul class="nav nav-tabs" role="tablist"> -->

                        <!-- <li><a class="active" data-toggle="tab" href="#tab-english">English</a></li> -->

                        <?php // foreach($translations as $lang) : ?>

                            <!-- <li><a data-toggle="tab" href="#tab-<?=$lang?>"><?=ucfirst($lang);?></a></li> -->

                        <?php // endforeach; ?>

                    <!-- </ul> -->

                    <div class="tab-content tab-content-fix">

                        <div class="tab-pane fade in active" id="tab-english">

                            <?php endif; ?>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_name')?> <span class="text-danger">*</span></label>

										<input type="text" name="company_name" class="form-control" value="<?=$company_name?>">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_legal_name')?> <span class="text-danger">*</span></label>

										<input type="text" name="company_legal_name" class="form-control" value="<?=$company_legal_name?>" >

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('contact_person')?> <span class="text-danger">*</span></label>

										<input type="text" class="form-control"  value="<?=$contact_person?>" name="contact_person">

										<span class="help-block m-b-none"><?=lang('company_representative')?></strong>.</span>

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_address')?> <span class="text-danger">*</span></label>

										<textarea class="form-control ta" name="company_address" required><?=$company_address?></textarea>

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('zip_code')?> <span class="text-danger">*</span></label>

										<input type="text" class="form-control"  value="<?=$company_zip_code?>" name="company_zip_code">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('city')?> <span class="text-danger">*</span></label>

										<input type="text" class="form-control" value="<?=$company_city?>" name="company_city">

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('state_province')?> <span class="text-danger">*</span></label>

										<input type="text" class="form-control" value="<?=$company_state?>" name="company_state">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('country')?> <span class="text-danger">*</span></label>

										<select class="select2-option form-control" style="width:100%;" name="company_country" >

											<optgroup label="<?=lang('selected_country')?>">

												<option value="<?=config_item('company_country')?>"><?=config_item('company_country')?></option>

											</optgroup>

											<optgroup label="Priority">
												<?php foreach ($countries as $country): 

													if($country->value =='Canada' || $country->value =='United States of America' ){?>



													<option value="<?=$country->value?>" <?php if($company_country == $country->value){ echo "selected"; } ?> ><?=$country->value?></option>

												<?php } endforeach; ?>										

											</optgroup>

											<optgroup label="<?=lang('other_countries')?>">

												<?php foreach ($countries as $country): if($country->value !='Canada' && $country->value !='United States of America' ){?>

													<option value="<?=$country->value?>" <?php if($company_country == $country->value){ echo "selected"; } ?>><?=$country->value?></option>

												<?php } endforeach; ?>

											</optgroup>

										</select>

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_email')?> <span class="text-danger">*</span></label>

										<input type="email" class="form-control" value="<?=$company_email?>" name="company_email">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_phone')?> <span class="text-danger">*</span></label>

										<input type="text" class="form-control telephone" value="<?=$company_phone?>" name="company_phone">

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_phone')?> 2</label>

										<input type="text" class="form-control telephone" value="<?=$company_phone_2?>" id="general_settings_phone2" name="company_phone_2">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('mobile_phone')?> <span class="text-danger">*</span></label>

										<input type="text" class="form-control" value="<?=$company_mobile?>" name="company_mobile">

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('fax')?> </label>

										<input type="text" class="form-control" value="<?=$company_fax?>" id="general_settings_fax" name="company_fax">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_domain')?></label>

										<input type="text" class="form-control" value="<?=$company_domain?>" name="company_domain" id="general_settings_domain">

									</div>

								</div>

                            </div>

                            <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_registration')?></label>

										<input type="text" class="form-control" value="<?=$company_registration?>" name="company_registration">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_vat')?></label>

										<input type="text" class="form-control" value="<?=$company_vat?>" name="company_vat" id="general_settings_vat">

									</div>

								</div>

                            </div>

                             <div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label><?=lang('company_import_email')?></label>

										<input type="text" class="form-control" value="<?=$company_import_email?>" name="company_import_email">

									</div>

								</div>
								
							</div>

                            <?php if (count($translations) > 0) : ?>

                        </div>

                        <?php foreach($translations as $lang) : ?>

                            <div class="tab-pane fade" id="tab-<?=$lang?>">



                                <div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_name')?> </label>

											<input type="text" name="company_name_<?=$lang?>" class="form-control" value="<?=config_item('company_name_'.$lang)?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_legal_name')?></label>

											<input type="text" name="company_legal_name_<?=$lang?>" class="form-control" value="<?=config_item('company_legal_name_'.$lang)?>">

										</div>

									</div>

                                </div>

                                <div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('contact_person')?> </label>

											<input type="text" class="form-control"  value="<?=config_item('contact_person_'.$lang)?>" name="contact_person_<?=$lang?>">

											<span class="help-block m-b-none"><?=lang('company_representative')?></strong>.</span>

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_address')?> </label>

											<textarea class="form-control ta" name="company_address_<?=$lang?>"><?=config_item('company_address_'.$lang)?></textarea>

										</div>

									</div>

                                </div>

								<div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('zip_code')?> </label>

											<input type="text" class="form-control"  value="<?=config_item('company_zip_code_'.$lang)?>" name="company_zip_code_<?=$lang?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('city')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_city_'.$lang)?>" name="company_city_<?=$lang?>">

										</div>

									</div>

                                </div>

                                <div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('state_province')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_state_'.$lang)?>" name="company_state_<?=$lang?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('country')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_country_'.$lang)?>" name="company_country_<?=$lang?>">

										</div>

									</div>

                                </div>

								<div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_email')?></label>

											<input type="email" class="form-control" value="<?=config_item('company_email_'.$lang)?>" name="company_email_<?=$lang?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_phone')?></label>

											<input type="text" class="form-control telephone" value="<?=config_item('company_phone_'.$lang)?>" name="company_phone_<?=$lang?>">

										</div>

									</div>

								</div>

								<div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_phone')?> 2</label>

											<input type="text" class="form-control telephone" value="<?=config_item('company_phone_2_'.$lang)?>" name="company_phone_2_<?=$lang?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('mobile_phone')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_mobile_'.$lang)?>" name="company_mobile_<?=$lang?>">

										</div>

									</div>

								</div>

								<div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('fax')?> </label>

											<input type="text" class="form-control" value="<?=config_item('company_fax_'.$lang)?>" name="company_fax_<?=$lang?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_domain')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_domain_'.$lang)?>" name="company_domain_<?=$lang?>">

										</div>

									</div>

								</div>

								<div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_registration')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_registration_'.$lang)?>" name="company_registration_<?=$lang?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label><?=lang('company_vat')?></label>

											<input type="text" class="form-control" value="<?=config_item('company_vat_'.$lang)?>" name="company_vat_<?=$lang?>">

										</div>

									</div>

								</div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

					<div class="submit-section">

                        <button id="general_settings_save" class="btn btn-primary submit-btn"><?=lang('save_changes')?></button>

					</div>

            </div>

        </form>

    </div>