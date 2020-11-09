<?php
ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 2048);
ini_set('xdebug.var_display_max_data', 102400);
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);

$inicio_time = microtime(true);

session_start();
ob_start();

include('server/config.php');
include('functions.php');

$inicio = new Inicio();
$inicio->login();

if (isset($_GET['option']) && !empty($_GET['option'])) {
	$option = $_GET['option'];
} else if (isset($_POST['option']) && !empty($_POST['option'])) {
	$option = $_POST['option'];
} else {
	$option = 'dashboard';
}
if (isset($_GET['action'])) {
	$action = $_GET['action'];
} else if (isset($_POST['action'])) {
	$action = $_POST['action'];
} else {
	$action = '';
}
$isModal = false;
if ((isset($_GET['ajaxenable']) && ($_GET['ajaxenable'] == 'true')) || (isset($_POST['ajaxenable']) && ($_POST['ajaxenable'] == 'true'))) {
	$useajax = true;
	if ((isset($_GET['isModal']) && ($_GET['isModal'] == 'true')) || (isset($_POST['isModal']) && ($_POST['isModal'] == 'true'))) {
		$isModal = true;
	}
} else {
	$useajax = false;
}

if (!file_exists('modules/' . $option . '/index.php')) {
	header("Location: " . ROOT_URL_PANEL . "index.php");
	exit;
}

if (!empty($option)) {
	include('modules/' . $option . '/functions.php');
	$seccion = new Seccion();
	$seccion->modulo = 1;
}

$foot_js = '';

if ($useajax) {
	include('modules/' . $option . '/ajax/' . $action . '.php');
	if ($isModal) {
		echo '<script src="assets/js/javascript.js?v=' . $inicio->getVersion() . '"></script>';
	}
	exit;
}

$seccion->check_forms();
?>

<?php include('header.php'); ?>
<div id="base">
	<div id="content">
		<section>
			<div class="section-body">
				<?php
				if (!empty($option)) {
					$add = false;
					$edit = false;
					$view = true;
					if ($inicio->can_do('ver')) {
						$view = true;
					} else {
						$view = false;
					}
					if ($inicio->can_do('agregar')) {
						$add = true;
					} else {
						$add = false;
					}
					if ($inicio->can_do('agregar')) {
						$edit = true;
					} else {
						$edit = false;
					}
					echo '<script>const option = "' . $option . '";</script>';
					if (file_exists('modules/' . $option . '/header.php')) {
						include('modules/' . $option . '/header.php');
					}
					include('messages.php');
					include('modules/' . $option . '/index.php');
				}
				?>
			</div>
		</section>
	</div>
	<?php include('menu.php'); ?>
</div>
<iframe id="iFrameDescarga" name="iFrameDescarga" style="display: none;"></iframe>
<span ondblclick="$('#divTimeEje').toggle();" style="float: right; margin-right: 30px; width: 10px; height: 10px; background: #D9D9D9; display: block;"></span>

<div id="MenuOpcionesRow" style="position: absolute; z-index: 9999; padding: 10px;"></div>
</body>
<script type="text/javascript">
	$(function() {
		$('#preLoader').hide();
	});
	$(document).on("submit", "form", function(event) {
		$(window).off('beforeunload');
		if ($(this).prop('target') != '_blank') {
			$('#preLoader').show();
		}
	});
	$(window).on('beforeunload', function() {
		if ($("div.modal.fade.in form").length && $('#preLoader').is(":hidden")) {
			return 'Tienes una ventana abierta, seguro que quieres salir?';
		};
		$('#preLoader').show();
	});
	document.body.style.zoom = "90%";
</script>

</html>