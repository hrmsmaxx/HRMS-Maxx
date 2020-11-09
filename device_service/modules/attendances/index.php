<div class="row">
	<?php if ($add) {
		include('modules/' . $option . '/add.php');
	} ?>
	<?php include('modules/' . $option . '/filtros.php'); ?>
</div>
<div class="row">
	<?php include('modules/' . $option . '/list.php'); ?>
</div>
<script src="<?php echo 'modules/' . $option . '/'; ?>scripts.js?v=<?php echo $inicio->getVersion(); ?>"></script>