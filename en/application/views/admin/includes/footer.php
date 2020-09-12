                <footer class="footer text-right">
                  &copy; <?php echo date('Y'); ?> <div class="version">Version <?php echo $this->session->userdata('version');?></div>
                </footer>

            </div>
        </div>
    	<script>var resizefunc = []; </script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
       <script src="<?php echo base_url(); ?>assets/js/bootstrap-switch.js"></script> 
       
		
		<script>
            var BASE_URL = "<?php echo base_url(); ?>";     
			$(".switch").bootstrapSwitch(); 
      //$(".bootstrap_switch").bootstrapSwitch();      
        </script>
        <script>setTimeout(function(){ $('#flash_succ_message, #flash_error_message').hide(); }, 5000);</script>
        
        <script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/admin_validation.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
       
		<!-- REQUIRED FOR FETCHING USER TIME ZONE -->
	


<script type="text/javascript">
  $(document).ready(function(){

    $('#data_tables').datatable();

  });
</script>





    <?php 
      if($module=='settings')
      {
        
      }
      else
      {
    ?>

    <script type="text/javascript">
       $(document).ready(function(){
    $('input[type=text], input[type=number], textarea').keyup(function()
                {
                       var yourInput = $(this).val();
                       re = /[`~!#%^&*()|+\=?;"<>\{\}\[\]\\\\]/gi;
                    var isSplChar = re.test(yourInput);
                       if(isSplChar)
                       {
                           var no_spl_char = yourInput.replace(/[`~!#%^&*()|+\=?;"<>\{\}\[\]\\\\]/gi, '');
                           $(this).val(no_spl_char);
                    }
                 });

         $('input[type=text], input[type=number], textarea').blur(function()
                {
                       var yourInput = $(this).val();
                       re = /[`~!#%^&*()|+\=?;"<>\{\}\[\]\\\\]/gi;
                    var isSplChar = re.test(yourInput);
                       if(isSplChar)
                       {
                           var no_spl_char = yourInput.replace(/[`~!#%^&*()|+\=?;"<>\{\}\[\]\\\\]/gi, '');
                           $(this).val(no_spl_char);
                    }
                 });
  });
    </script>
  <?php } ?>


</body>
</html>