<!-- Start -->
<div class="content">
  <div class="row">
    <div class="col-sm-12">
      <h4 class="page-title"><?php echo lang('support')?></h4>
    </div>
  </div>
  <?php $this->load->view('sub_menus');?>
					<div class="row">
						<div class="col-sm-4 col-xs-3">
              <?php $view = isset($_GET['view']) ? $_GET['view'] : NULL;
              if($view == 'archive'){?>
							  <h4 class="page-title"><?php echo "Archive Tickets"; ?></h4>
              <?php }else{?>
                <h4 class="page-title"><?=lang('all_tickets')?></h4>
              <?php }?>
						</div>
						<div class="col-sm-8 col-xs-9 text-right m-b-0">

              <a href="<?=base_url()?>tickets/add" class="btn btn-success rounded pull-right"><?php echo lang('create_ticket')?></a>

              <?php if(!User::is_client()) { ?>
                  <?php if ($archive) : ?>
                <a href="<?=base_url()?>tickets" class="btn btn-info rounded pull-right m-r-10"><?php echo lang('view_active')?></a></header>
                <?php else: ?>
              <a href="<?=base_url()?>tickets?view=archive" class="btn btn-info rounded pull-right m-r-10"><?php echo lang('view_archive')?></a></header>
              <?php endif; ?>
              <?php } ?>
							<div class="btn-group pull-right m-r-10">

              <button class="btn btn-default">
              <?php
              $view = isset($_GET['view']) ? $_GET['view'] : NULL;
              switch ($view) {
                case 'pending':
                  echo lang('pending');
                  break;
                case 'closed':
                  echo lang('closed');
                  break;
                case 'open':
                  echo lang('open');
                  break;
                case 'resolved':
                  echo lang('resolved');
                  break;

                default:
                  echo lang('filter');
                  break;
              }
              ?></button>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>
              <ul class="dropdown-menu">

              <li><a href="<?=base_url()?>tickets?view=pending"><?php echo lang('pending')?></a></li>
              <li><a href="<?=base_url()?>tickets?view=closed"><?php echo lang('closed')?></a></li>
              <li><a href="<?=base_url()?>tickets?view=open"><?php echo lang('open')?></a></li>
              <li><a href="<?=base_url()?>tickets?view=resolved"><?php echo lang('resolved')?></a></li>
              <li><a href="<?=base_url()?>tickets"><?php echo lang('all_tickets')?></a></li>

              </ul>
              </div>	
					
							
						</div>
					</div>

          <div class="row filter-row">
            <div class="col-sm-3 col-md-2 col-xs-6">  
              <div class="form-group form-focus">
                <label class="control-label"><?php echo lang('reporter')?></label>
                <input type="text" class="form-control floating" id="employee_name" name="employee_name" />
                <label id="employee_name_error" class="error display-none" for="employee_name"><?php echo lang('reporter_should_not_be_empty')?></label>
              </div>
            </div>

            <div class="col-sm-3 col-md-2 col-xs-6"> 
              <div class="form-group form-focus select-focus">
                <label class="control-label"><?php echo lang('status')?></label>
                <select class="select floating form-control" id="ticket_status" name="ticket_status"> 
                  <option value=""> <?php echo lang('all_tickets')?></option>
                  <option value="Pending"> <?php echo lang('pending')?> </option>
                  <option value="Closed"> <?php echo lang('closed')?> </option>
                  <option value="Open"> <?php echo lang('open')?> </option>
                  <option value="Resolved"> <?php echo lang('resolved')?> </option>
                </select>
                <label id="ticket_status_error" class="error display-none" for="ticket_status"><?php echo lang('please_select_a_status')?></label>
              </div>
            </div>
            <?php $priorities = $this->db->where('subdomain_id',$this->session->userdata('subdomain_id'))->order_by('hour','DESC')->get('priorities')->result_array();?>
            <div class="col-sm-3 col-md-2 col-xs-6"> 
              <div class="form-group form-focus select-focus">
                <label class="control-label"><?php echo lang('priority')?></label>
                <select class="select floating form-control" id="ticked_priority" name="ticked_priority"> 
                  <option value="" selected="selected"> <?php echo lang('all_priorities')?> </option>
                  <?php foreach ($priorities as $key => $value) {?>
                   <option value="<?php echo $value['priority'];?>" > <?php echo ucfirst($value['priority']) ?> </option> 
                  <?php } ?>
                </select>
                <label id="ticked_priority_error" class="error display-none" for="ticked_priority"><?php echo lang('please_select_a_priority')?></label>
              </div>
            </div>
            <div class="col-sm-3 col-md-2 col-xs-6">  
              <div class="form-group form-focus">
                <label class="control-label"><?php echo lang('from')?></label>
                <div class="cal-icon"><input class="form-control floating" id="ticket_from" name="ticket_from" type="text"></div>
                <label id="ticket_from_error" class="error display-none" for="ticket_from"><?php echo lang('from_date_should_not_be_empty')?></label>
              </div>
            </div>
            <div class="col-sm-3 col-md-2 col-xs-6">  
              <div class="form-group form-focus">
                <label class="control-label"><?php echo lang('to')?></label>
                <div class="cal-icon">
                  <input class="form-control floating" id="ticket_to" name="ticket_to" type="text"></div>
                  <label id="ticket_to_error" class="error display-none" for="ticket_to"><?php echo lang('to_date_should_not_be_empty')?></label>
              </div>
            </div>
            <div class="col-sm-3 col-md-2 col-xs-6">  
              <a href="javascript:void(0)" id="ticket_search_btn" class="btn btn-success btn-block"> <?php echo lang('search')?> </a>  
            </div>     
         </div>

            <div class="row">
            <div class="col-md-12"> 
              <div class="table-responsive">
                <table id="table-tickets<?=($archive) ? '-archive':''?>" class="table table-striped custom-table m-b-0 AppendDataTables">
                  <thead>
                    <tr>
                    <th style="width:5px; display:none;"></th>
                   <th><?=lang('subject')?></th>
                   <?php if (User::is_admin() || User::is_staff()) { ?>
                   <th><?=lang('reporter')?></th>
                    <?php } ?>
                   <?php if (User::is_admin() || User::is_staff()) { ?>
                   <th><?=lang('assignee')?></th>
                    <?php } ?>
                    <th class="col-date"><?=lang('date')?></th>
                    <th class="col-options no-sort"><?=lang('priority')?></th>

                      <th class="col-lg-1"><?=lang('department')?></th>
                      <th class="col-lg-1"><?=lang('status')?></th>
                      <th style="width:5px; display:none;"></th>
                      <th class="col-lg-1 text-center"><?=lang('action')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $this->load->helper('text');
                        foreach ($tickets as $key => $t) {
                        $s_label = 'default';
                        if($t->status == 'open') $s_label = 'danger';
                        if($t->status == 'closed') $s_label = 'success';
                        if($t->status == 'resolved') $s_label = 'primary';
                    ?>
                    <tr>
                    <td style="display:none;"><?=$t->id?></td>
              <td>
              <?php $rep = $this->db->where('ticketid',$t->id)->get('ticketreplies')->num_rows();
                    if($rep == 0){ ?>
<h2>
                <a class="text-info <?=($t->status == 'closed') ? 'text-lt' : ''; ?>" href="<?=base_url()?>tickets/view/<?=$t->id?>" data-toggle="tooltip" data-title="<?=lang('ticket_not_replied')?>">
                     <?php }else{ ?>
                <h2><a class="text-info <?=($t->status == 'closed') ? 'text-lt' : ''; ?>" href="<?=base_url()?>tickets/view/<?=$t->id?>">
                      <?php } ?>

                     <?=word_limiter($t->subject, 8);?>
                     </a></h2><br>
                     <?php if($rep == 0 && $t->status != 'closed'){ ?>
                     <span class="text-danger"><?php echo lang('pending_for')?> <?=Applib::time_elapsed_string(strtotime($t->created));?></span>
                     <?php } ?>

                      </td>
                      <?php if (User::is_admin() || User::is_staff()) { ?>

                      <td>
                      <?php
                      if($t->reporter != NULL){ 

                        $employee_details = $this->db->get_where('users',array('id'=>$t->reporter))->row_array();
                        $designation = $this->db->get_where('designation',array('id'=>$employee_details['designation_id']))->row_array();
                        $account_details = $this->db->get_where('account_details',array('user_id'=>$t->reporter))->row_array();
                        ?>


                        <div class="user_det_list">
                          <a href="<?php echo base_url().'employees/profile_view/'.$t->reporter;?>"> <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>"></a>
                          <h2><span class="username-info"><?php echo ucfirst(user::displayName($t->reporter));?></span>
                          <span class="userrole-info"> <?php echo (!empty($designation['designation']))?$designation['designation']:'-';?></span>
                          <span class="username-info"> <?php echo !empty($employee_details['id_code'])?$employee_details['id_code']:"-";?></span></h2>
                        </div>
                       
                      <?php } else { echo "NULL"; } ?>

                      </td>

                      <?php } ?>
                       <?php if (User::is_admin() || User::is_staff()) { ?>

                      <td>
                      <?php
                      if($t->assignee != 0){ ?>
                        <a class="pull-left " data-toggle="tooltip" title="<?php echo User::login_info($t->assignee)->email; ?>" data-placement="right">
                                <img src="<?php echo User::avatar_url($t->assignee); ?>" class="img-rounded thumb-sm" width='25' height='25'> <span><?php echo(!empty($t->assignee))?User::displayName($t->assignee):""; ?></span>
                                
                            </a>
                      <?php } else { echo "-"; } ?>

                      </td>

                      <?php } ?>

                       <td class=""><?=date("D, d M g:i:A",strtotime($t->created));?><br/>
                      <span class="text-primary">(<?=Applib::time_elapsed_string(strtotime($t->created));?>)</span>
                       </td>

                      <td>
                      <span class="label label-<?php if($t->priority == 'Urgent') { echo 'danger'; }elseif($t->priority == 'High') { echo 'warning'; }else{ echo 'default'; } ?>"> <?=$t->priority?></span>
                      </td>

                      <td class="">
                      <?php 
                      $department = App::get_dept_by_id($t->department);
                      if(!empty($department)){echo $department;}else{echo '-';} ?>
                      </td>

                      <td>
                       <?php
                                    switch ($t->status) {
                                        case 'open':
                                            $status_lang = 'open';
                                            break;
                                        case 'closed':
                                            $status_lang = 'closed';
                                            break;
                                        case 'pending':
                                            $status_lang = 'pending';
                                            break;
                                        case 'resolved':
                                            $status_lang = 'resolved';
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                    ?>
                                    <span class="label label-<?=$s_label?>"><?=ucfirst(lang($status_lang))?></span> </td>
                   <td style="display:none;"><?=date("m/d/Y",strtotime($t->created));?></td>                  
									<td class="text-center">
									
                        <div class="dropdown">
							<a data-toggle="dropdown" class="action-icon dropdown-toggle" href="#">
								<i class="fa fa-ellipsis-v"></i>
							</a>
                          <ul class="dropdown-menu pull-right">
                            <li><a href="<?=base_url()?>tickets/view/<?=$t->id?>"><?=lang('preview_ticket')?></a></li>

                            <?php if (User::is_admin()) { ?>

                            <li><a href="<?=base_url()?>tickets/edit/<?=$t->id?>"><?=lang('edit_ticket')?></a></li>
                            <li><a href="<?=base_url()?>tickets/delete/<?=$t->id?>" data-toggle="ajaxModal" title="<?=lang('delete_ticket')?>"><?=lang('delete_ticket')?></a></li>
                                <?php if ($archive) : ?>
                                <li><a href="<?=base_url()?>tickets/archive/<?=$t->id?>/0"><?=lang('move_to_active')?></a></li>
                                <?php else: ?>
                                <li><a href="<?=base_url()?>tickets/archive/<?=$t->id?>/1"><?=lang('archive_ticket')?></a></li>
                                <?php endif; ?>
                            <?php } ?>

                          </ul>
                        </div>
									</td>



                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                </div>
                </div>
              </div>

		  </div>