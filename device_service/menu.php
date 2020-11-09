<div id="menubar" class="menubar-inverse ">
	<div class="menubar-fixed-panel">
		<div>
			<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
				<i class="fa fa-bars"></i>
			</a>
		</div>
		<div class="expanded" id="headerLogo">
			<span class="text-lg text-bold " style="color:rgba(255,255,255,0.8);"><img width="20" src="assets/images/logo.png" style="margin:7px;margin-bottom:10px;" /><?php echo SITE_NAME; ?></span>
		</div>
	</div>
	<div class="menubar-scroll-panel">
		<?php $inicio->crearMenu(); ?>
	</div>
</div>