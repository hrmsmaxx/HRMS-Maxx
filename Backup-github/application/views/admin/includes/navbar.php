<div class="header">
	<div class="header-left">
		<div class="text-center">
			<a id="mobile_btn" class="mobile_btn logo" href="javascript:void(0);"><i class="fa fa-bars" aria-hidden="true"></i></a>
			<a href="<?php  echo base_url().'admin'?>" class="logo web-logo text-ellipsis"><span><?php echo $this->website_name ?></span></a>
		</div>
	</div>
	<div class="navbar navbar-default" role="navigation">
		<div class="">
			<ul class="nav navbar-nav navbar-right pull-right">
				<li class="dropdown">
					<?php 
					$admin_id = $this->session->userdata['id'];
					$query = $this->db->query("SELECT `profile_thumb` FROM `administrators` WHERE `ADMINID` = $admin_id ");
					$result = $query->row_array();
					$image = base_url().'assets/images/avatar.jpg';
					if(!empty($result['profile_thumb'])){ $image = base_url().$result['profile_thumb']; }
					?>
					<a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo $image; ?>" alt="user-img" class="img-circle"> </a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url().'admin/profile' ?>">Profile</a></li>
						<li><a href="<?php echo base_url().'admin/settings' ?>">Settings</a></li>
						<li><a href="<?php echo base_url()."admin/dashboard/logout"; ?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>