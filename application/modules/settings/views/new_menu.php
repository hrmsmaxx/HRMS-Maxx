<div class="panel panel-white">

	<div class="panel-heading font-bold">

		<h3 class="panel-title"><?php echo lang('add_new_role');?></h3>

	</div>

	<form id="NewRoleForm" method="post" >

		<div class="panel-body">

            <form id="RoleaddForm" method="post" action="<?php echo base_url(); ?>settings/new_menu_role">

            	<div class="form-group">

					<label><?php echo lang('new_role');?> <span class="text-danger">*</span></label>

					<input type="text" class="form-control" value="" name="role_name" placeholder="<?php echo lang('role_name');?>" required="required">

				</div>
				<?php 
									 $domain = $this->session->userdata('domain');
					                $arr = explode('.', $domain); 
					                  
					                // Get the first element of array 
					                $subdomain = $arr[0];
								   	$subscriber_menu = $this->db->get_where('subscribers',array('subscribers_id'=>$this->session->userdata('subdomain_id')))->row_array();
					                if(!empty($subscriber_menu['menus'])){
					                    $where_in = explode(',',$subscriber_menu['menus']);

					                    $this->db->select('*');
					                    $this->db->where_in('id',$where_in);
					                    $plan_menus =$this->db->get('plan_menus')->result_array();
					                    if(!empty($plan_menus)){
					                        foreach ($plan_menus as $key => $value) {
					                            # code...
					                             if(!empty($value['module'])){                                
					                                $plan_menu[] = $value['module'];
					                            }
					                        }
					                        // $plan_menu[]= 'menu_home';
					                        $plan_menu[]= 'menu_subscriber_invoice';
                        					$plan_menu[]= 'menu_geolocation';
					                    }
					                }
					                if($subdomain == 'demo'){
				                	 $all_menus = $this->db->where('route !=','#')->where('visible',1)->where('hook','main_menu_admin')->order_by('order','ASC')->get('hooks')->result();
				                	}else{
											$all_menus1 = $this->db->where('route !=','#')->where('visible',1)->where_in('module',$plan_menu)->where('hook','main_menu_admin')->order_by('order','ASC')->get('hooks')->result();
											$all_menus2 = $this->db->where('route !=','#')->where('visible',1)->where('hook','main_menu_admin')->where_in('parent',$plan_menu)->order_by('order','ASC')->get('hooks')->result();
											$all_menus3 = $this->db->where('route','#')->where('visible',1)->where_in('module',$plan_menu)->where('hook','main_menu_admin')->order_by('order','ASC')->get('hooks')->result();
											$all_menus4 = $this->db->where('module','menu_home')->where('hook','main_menu_admin')->where('visible',1)->get('hooks')->result();
											// echo $this->db->last_query(); exit;
											$all_menus = array_unique(array_merge($all_menus1, $all_menus2,$all_menus3,$all_menus4), SORT_REGULAR);
				                	}
				                	  ?>
				<div class="form-group leave-duallist">

					<label><?php echo lang('add_menu');?></label>

					<div class="row">

						<div class="col-lg-5 col-sm-5 col-xs-12">

							<select name="role_menu_from[]" id="role_menu_select" class="form-control" size="5" multiple="multiple">

								
									<?php
									// $all_menus = $this->db->get_where('hooks',array('hook'=>'main_menu_admin','route !='=>'#'))->result();

								   foreach($all_menus as $adm){ ?>

									<option value="<?php echo $adm->name; ?>"><?=lang($adm->name)?></option>

								<?php } ?>

							</select>

						</div>

						<div class="multiselect-controls col-lg-2 col-sm-2 col-xs-12">

							<button type="button" id="role_menu_select_rightAll" class="btn btn-block btn-white"><i class="fa fa-forward"></i></button>

							<button type="button" id="role_menu_select_rightSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-right"></i></button>

							<button type="button" id="role_menu_select_leftSelected" class="btn btn-block btn-white"><i class="fa fa-chevron-left"></i></button>

							<button type="button" id="role_menu_select_leftAll" class="btn btn-block btn-white"><i class="fa fa-backward"></i></button>

						</div>

						<div class="col-lg-5 col-sm-5 col-xs-12">

							<select name="role_menu_to[]" id="role_menu_select_to" class="form-control" size="8" multiple="multiple" required="required"></select>

						</div>

					</div>

				</div>



				<div class="submit-section">

					<button class="btn btn-primary submit-btn"><?php echo lang('submit');?></button>

				</div>

			</form>

</div>