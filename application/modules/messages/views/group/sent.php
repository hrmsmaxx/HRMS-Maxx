<?php foreach ($messages as $key => $msg) { 
	$employee_details = $this->db->get_where('users',array('id'=>$msg->user_to))->row_array();
$designation = $this->db->get_where('designation',array('id'=>$employee_details['designation_id']))->row_array();
$account_details = $this->db->get_where('account_details',array('user_id'=>$msg->user_to))->row_array();

	?>
<li class="<?php if($msg->status == 'Unread'){echo  "unread"; }?>">
	<a href="<?=base_url()?>messages/view/<?=$msg->user_to?>" class="clear">
		<!-- <div class="thumb-xs pull-left m-r-sm">
			<img src="<?php echo User::avatar_url($msg->user_to); ?>" class="img-circle">
		</div> -->
		<span class="mail-date">
			<?php echo Applib::time_elapsed_string(strtotime($msg->date_received),'UTC'); ?>
		</span>
		<span class="name">
			<div class="user_det_list">
                 <img class="avatar"  src="<?php echo base_url();?>assets/avatar/<?php echo $account_details['avatar']?>">
                <h2><?php echo ucfirst(user::displayName($msg->user_to));?></span>
                <span class="userrole-info"> <?php echo (!empty($designation['designation']))?$designation['designation']:'-';?></span>
                <span class="username-info"> <?php echo User::login_info($msg->user_to)->id_code; ?></span></h2>
          	</div>
          </span>
		<span class="subject">
			<?php $longmsg = strip_tags($msg->message); $message = word_limiter($longmsg, 6); echo $message; ?>
		</span> 
	</a> 
</li>
<?php } ?>
<?php if(count($messages) == 0 ){ ?>
<li class="no-messages">
	<i class="fa fa-envelope fa-5x"></i>
	<h4 class="no-msg-title"><?=lang('nothing_to_display')?></h4>
</li>
<?php } ?>