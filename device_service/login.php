<!DOCTYPE html>
<?php
include_once "server/env.php";

$subdomain =  explode('.', $_SERVER['HTTP_HOST'])[0];
if (substr($subdomain, 0, 6) === "device") {
	define("SUBDOMAIN_NAME", substr($subdomain, 6, strlen($subdomain)));
} else {
	exit;
}

?>
<html lang="en">

<head>
	<title><?php echo SITE_NAME; ?> - Acceso</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="">
	<meta name="description" content="Acceso al sistema">


	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/bootstrap.css?1422792965" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/font-awesome.min.css?1422529194" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/morris/morris.core.css?1420463396" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/jquery.dataTables.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/TableTools.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/wizard/wizard.css?1425466601" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/toastr/toastr.css?1425466569" />
	<link type="text/css" rel="stylesheet" href="assets/css/html5imageupload.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
	<link type="text/css" rel="stylesheet" href="assets/js/libs/summernote/summernote.css" />
	<!-- END STYLESHEETS -->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="assets/js/libs/utils/respond.min.js?1403934956"></script>
	<![endif]-->
	<script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="assets/js/libs/bootstrap-multiselect/bootstrap-multiselect.js?v=1.2"></script>
</head>

<body class="menubar-hoverable header-fixed" style="background: url(images/login.jpg) no-repeat; background-size: cover;">
	<section class="section-account">
		<div class="card contain-sm style-transparent">
			<div class="card-body">
				<?php if (isset($_GET['msg']) && $_GET['msg'] == 1) { ?>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-8">
							<div class="alert alert-danger" role="alert" style="text-align: center;">
								El usuario y contraseña ingresados no coinciden.
							</div>
						</div>
						<div class="col-sm-2"></div>
					</div>
				<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 3) { ?>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-8">
							<div class="alert alert-danger" role="alert">
								Complete todos los datos correctamente.
							</div>
						</div>
						<div class="col-sm-2"></div>
					</div>
				<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 4) { ?>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-8">
							<div class="alert alert-danger" role="alert">
								La empresa tiene bloqueado el acceso al sistema.
							</div>
						</div>
						<div class="col-sm-2"></div>
					</div>
				<?php } ?>
				<div class="row" style="margin-top: 50px;">
					<div class="col-sm-2"></div>
					<div class="col-sm-8" style="border: 1px solid #0aa89e; border-radius: 5px; padding: 10px 30px; background-color:#F9FFF6;">
						<img src="assets/images/logo_texto.png" style="display: block; margin: 20px auto 0; width: 200px;" />
						<br />
						<span class="text-lg text-bold text-primary" style="text-align: center; display: block;">Sistema de control de funcionarios</span>
						<br />
						<span class="text-lg text-bold text-primary" style="text-align: center; display: block;">Acceso a sistema</span>
						<br /><br />
						<div id="contenedorForm">
							<form class="floating-label" action="index.php" accept-charset="utf-8" method="post">
								<div id="accesos">
									<div class="form-group">
										<input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" id="password" name="password" placeholder="Clave">
									</div>
								</div>
								<br />
								<button class="btn btn-biocloud-yellow" type="submit" style="margin: 0 auto 20px;display: block;">Acceder</button>
						</div>
						</form>
					</div>
				</div>
			</div>
	</section>
	<script>
		$(document).ready(function() {
			inicializarMulti();
			$('button.multiselect').click();
		});

		function inicializarMulti() {
			$('#empresa').multiselect();
			var typingTimer;
			var doneTypingInterval = 1100;
			var input = $('#empresa').parent().find('.multiselect-search');

			//on keyup, start the countdown
			input.on('keyup', function() {
				clearTimeout(typingTimer);
				typingTimer = setTimeout(buscarEmpresa, doneTypingInterval);
			});

			//on keydown, clear the countdown
			input.on('keydown', function() {
				clearTimeout(typingTimer);
			});

			function buscarEmpresa() {
				var nombre = $('#empresa').parent().find('.multiselect-search').val();
				opeajax = $.ajax({
					type: "GET",
					url: "login_empresas.php",
					data: {
						nombre: nombre
					},
					cache: false
				}).done(function(repuesta) {
					if (repuesta != 'null') {
						var jsonRepuesta = JSON.parse(repuesta);
						if (jsonRepuesta.length != 1) {
							jsonRepuesta.unshift({
								value: "0",
								label: "Seleccionar"
							});
						}

						$("#empresa").multiselect('dataprovider', jsonRepuesta);
						$('#empresa').parent().find('.multiselect-search').val(nombre);
						$('#empresa').parent().find('.multiselect-search').focus();
						if (jsonRepuesta.length == 1) {
							$(document).click();
							$('#username').focus();
						}
						inicializarMulti();
					}
				});
			}
		}

		function msieversion() {
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");

			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
			{
				$('#contenedorForm').html("Lo sentimos, pero no puedes utilizar el sistema con Internet Explorer. Usa Google Chrome, Firefox, Opera o Safari.")
			}

			return false;
		}

		msieversion();
	</script>
	<style type="text/css">
		#accesos .form .form-group {
			padding-top: 16px;
		}

		.floating-label .form-control~label {
			top: -15px;
		}

		.floating-label .form-control:focus~label,
		.floating-label .form-control.dirty~label {
			top: -15px;
		}
	</style>
</body>

</html>