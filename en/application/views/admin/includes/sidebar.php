<?php
	
$active =$this->uri->segment(2);
 ?>
<div class="side-menu">
	<div class="sidebar-inner slimscrollleft">
		<div id="sidebar-menu">
			<ul>
				<li>
					<a href="<?php echo base_url().'admin'; ?>" class="<?php echo (empty ($active))? 'active':''; ?>"><i class="mdi mdi-view-dashboard"></i> <span>Dashboard</span></a>
				</li>
				
				
			

				<?php $active_1 = $this->uri->segment(3);	 ?>

				<li class="has_sub">
					<a href="#" class=""><i class="mdi mdi-cash-multiple"></i> <span>Request</span> <span class="menu-arrow"></span></a>
					<ul class="sub-menu" <?php if($module == 'request'){?> style="display:block" <?php } ?>> 
						<li><a href="<?php echo base_url().'admin/request/demo'; ?>" class="<?php echo  ($active_1 =='demo')? 'active':''; ?>"> Demo </a></li>
						<li><a href="<?php echo base_url().'admin/request/quote'; ?>" class="<?php echo  ($active_1 =='quote')? 'active':''; ?>"> Quote </a></li>
						
					</ul>
				</li>


				<li><a href="<?php echo base_url().'admin/sales'; ?>" class="<?php echo ($active =='sales')? 'active':''; ?>"><i class="mdi mdi-account-multiple"></i> <span>Sales</span> </a></li>

				<li class="has_sub">
					<a href="#" class=""><i class="mdi mdi-settings"></i> <span>Settings</span> <span class="menu-arrow"></span></a>
					<ul class="sub-menu" <?php if($module == 'settings' || $module == 'seo_settings' ||  $module == 'policy_settings' || $module == 'profession'){?> style="display:block" <?php } ?>> 
						<li><a href="<?php echo base_url().'admin/settings'; ?>" class="<?php echo  ($active =='settings' && $active_1 !='smtp_config' && $active_1 !='color')? 'active':''; ?>"> General Settings </a></li>
						<li><a href="<?php echo base_url().'admin/emailsettings';?>" class="<?php echo ($active =='emailsettings')? 'active':''; ?>"> Email Settings </a></li> 
						<li><a href="<?php echo base_url().'admin/settings/smtp_config';?>" class="<?php echo ($active_1 =='smtp_config')? 'active':''; ?>"> Smtp Config </a></li>
						
						
					</ul>
				</li>
				
				
			
				
				<li class="has_sub">
					<a href="#" class=""><i class="mdi mdi-cash-multiple"></i> <span>Payment Settings</span> <span class="menu-arrow"></span></a>
					<ul class="sub-menu" <?php if($module == 'paypal_settings'){?> style="display:block" <?php } ?>> 
						<li><a href="<?php echo base_url().'admin/paypal_settings'; ?>" class="<?php echo  ($active =='paypal_settings')? 'active':''; ?>"> Paypal </a></li>
						
					</ul>
				</li>

				<li>
					<a href="<?php echo base_url().'admin/emailtemplate'; ?>" class="<?php echo ($active == 'emailtemplate')? 'active':''; ?>" ><i class="mdi mdi-email"></i> <span>Email Template</span> </a>
				</li>
				
				
				
			</ul>
		</div>
	</div>
</div>