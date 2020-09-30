 </div>

	<script>
		var locale = 'en';
		var base_url = '<?=base_url()?>';
	</script>

	<!-- jQuery -->
        <script src="<?php echo base_url();?>superadmin_assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url();?>superadmin_assets/js/jquery-ui.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo base_url();?>superadmin_assets/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>superadmin_assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>
       
        <script src="<?=base_url()?>superadmin_assets/plugins/datatables/moment.min.js"></script>
       <!--  <script src="<?=base_url()?>assets/js/datatables/dataTables.bootstrap.min.js"></script> -->

        <!-- <script src="<?=base_url()?>assets/js/datatables/datetime-moment.js"></script> -->
		
		<!-- Slimscroll JS -->
        <script src="<?php echo base_url();?>superadmin_assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Select2 JS -->
		<script src="<?php echo base_url();?>superadmin_assets/js/select2.min.js"></script>
         <script src="<?php echo base_url();?>superadmin_assets/plugins/datatables/datatables.min.js"></script>
       
		  <script src="<?=base_url()?>superadmin_assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="<?=base_url()?>superadmin_assets/plugins/datatables/jquery.datatables.min.js"></script>
		<!-- Custom JS -->
		<script  src="<?php echo base_url();?>superadmin_assets/js/script.js"></script>

		<script src="<?php echo base_url();?>assets/js/libs/toastr.min.js"></script>

		<script>
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-bottom-right",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}          
        $("#table-subscribers").dataTable().fnSort([[0,'desc']]);
        $("#table-coupons").dataTable().fnSort([[0,'asc']]);
	</script>


	<?php if ($this->session->flashdata('tokbox_success')  != ''){ ?>
		<script type="text/javascript">
		    toastr.success("<?php echo $this->session->flashdata('tokbox_success'); ?>");
		</script>
	<?php } ?>

	<?php if ($this->session->flashdata('tokbox_error')  != ''){ ?>
		<script type="text/javascript">
		    toastr.error("<?php echo $this->session->flashdata('tokbox_error'); ?>");
		</script>
	<?php } ?>

	<!-- <?php if($this->uri->segment(2) == ''){?>
		<script>
			var min_slider = document.getElementById("min-slider");
			var min_output = document.getElementById("min-output");
			min_output.innerHTML = min_slider.value;

			min_slider.oninput = function()
			{
				min_output.innerHTML = min_slider.value;
			}

		</script>
	<?php }?> -->
		<script>
			function show2(){
			  document.getElementById('div2').style.display ='flex';
			   document.getElementById('div1').style.display ='none';
			}
			function show1(){
			  document.getElementById('div1').style.display = 'flex';
			  document.getElementById('div2').style.display = 'none';
			}

		</script>
		<script type="text/javascript">
			    /*question category form*/
    $(document).on('click','#AddPlanBtn',function(){
    

        $("#AddPlanForm").validate({
            onsubmit: true,
            rules: {
                plan_name: {
                    required: true
                },
                plan_amount: {
                    required: true,
                    digits: true
                },
                plan_type: {
                    required: true
                },
                no_of_users: {
                    required: true,
                    digits: true
                },
                no_of_projects: {
                    required: true,
                    digits: true
                },
                no_of_storage: {
                    required: true,
                    digits: true
                },
                description: {
                    required: true
                }
               
            },
            messages: {
                plan_name: {
                    required: "Plan Name is Required"
                },
                plan_amount: {
                    required: "Plan amount is Required",
                    digits: "Numbers only Allowed"
                },
                plan_type: {
                    required: "Choose Plan Type"
                },
                no_of_users: {
                    required: "No of Users field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_projects: {
                    required: "No of Projects field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_storage: {
                    required: "No of Storage field is Required",
                    digits: "Numbers only Allowed"
                },
                description: {
                    required: "Description is Required"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
            
           });
        });


    $(document).on('click','.PlansEditBtn',function(){
    	var plan_id = $(this).data('pid');

        $("#edit_plan"+plan_id).validate({
            onsubmit: true,
            rules: {
                plan_name: {
                    required: true
                },
                plan_amount: {
                    required: true,
                    digits: true
                },
                plan_type: {
                    required: true
                },
                no_of_users: {
                    required: true,
                    digits: true
                },
                no_of_projects: {
                    required: true,
                    digits: true
                },
                no_of_storage: {
                    required: true,
                    digits: true
                },
                description: {
                    required: true
                }
               
            },
            messages: {
                plan_name: {
                    required: "Plan Name is Required"
                },
                plan_amount: {
                    required: "Plan amount is Required",
                    digits: "Numbers only Allowed"
                },
                plan_type: {
                    required: "Choose Plan Type"
                },
                no_of_users: {
                    required: "No of Users field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_projects: {
                    required: "No of Projects field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_storage: {
                    required: "No of Storage field is Required",
                    digits: "Numbers only Allowed"
                },
                description: {
                    required: "Description is Required"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
            
           });
        });
		</script>
    </body>
</html>