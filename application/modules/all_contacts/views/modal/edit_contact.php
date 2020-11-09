
<?php $contacts = $this->db->get_where('contacts',array('id'=>$id))->row_array();
$this->db->where('subdomain_id',$this->session->userdata('subdomain_id'));
$roles = $this->db->get('roles')->result();
?>

<!-- <div class="modal custom-modal fade" id="edit_contact" role="dialog"> -->
                    <div class="modal-dialog modal-dialog-centered" role="document" id="edit_contact">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?=lang('edit_contact')?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="EditContacForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label><?=lang('role_name')?> <span class="text-danger">*</span></label>
                                         <select name="roles" class="form-control" id="roles_edit">
                                            <option value=""><?=lang('select_role')?></option>>
                                          <?php
                                          if (!empty($roles)) {
                                          foreach ($roles as $r) { ?>
                                             <option value="<?=$r->r_id?>" <?php echo ($contacts['roles'] == $r->r_id)?"selected":"";?>><?=ucfirst($r->role)?></option>
                                          <?php } } ?>
                                          </select>
                                    </div>
                                    <div class="form-group">
                                        <label><?=lang('name')?> <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact_name" id="contact_name_edit" value="<?php echo $contacts['contact_name'];?>">
                                        <input class="form-control" type="hidden" name="id" id="id" value="<?php echo $contacts['id'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?=lang('email_address')?></label>
                                        <input class="form-control" type="email" name="email" id="email_edit" value="<?php echo $contacts['email'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?=lang('contact_number')?> <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact_number" id="contact_number_edit" value="<?php echo $contacts['contact_number'];?>">
                                    </div>
                                     <div class="form-group">
                                        <label><?=lang('image')?> <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file" id="file_edit" >
                                        <input class="form-control" type="hidden" name="image"  id= "image_edit" value="<?php echo $contacts['avatar'];?>">
                                        <?php  if(!empty($contacts['avatar'])){ ?>
                                        <img class="rounded-circle img-responsive" alt="" src="<?php echo base_url()?>assets/uploads/<?php echo $contacts['avatar'];?>">
                                        <?php  } ?>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="d-block"><?=lang('status')?></label>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="contact_status_edit" name="status" class="check" <?php echo ($contacts['status'] == 1)?"checked":"";?> value="<?php echo $contacts['status']?>">
                                            <label for="contact_status" class="checktoggle"><?=lang('checkbox')?></label>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn" id="submit_edit_contact_form" ><?=lang('submit')?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->