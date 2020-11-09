<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php if (isset($seccion->nombre)) {
				echo $seccion->nombre . ' | ';
			} ?><?php echo SITE_NAME; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="assets/images/logo.png" />
	<link rel="apple-touch-icon" href="assets/images/logo.png" />
	<link rel="apple-touch-icon-precomposed" href="assets/images/logo.png" />
	<meta name="msapplication-TileImage" content="assets/images/logo.png">

	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/bootstrap.css?2" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/materialadmin.css?v=<?php echo $inicio->getVersion(); ?>" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/font-awesome.min.css?1422529194" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/morris/morris.core.css?1420463396" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/jquery.dataTables.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/DataTables/TableTools.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/wizard/wizard.css?1425466601" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/bootstrap-colorpicker/bootstrap-colorpicker.css?1424887860" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/toastr/toastr.css?1425466569" />
	<link type="text/css" rel="stylesheet" href="assets/css/html5imageupload.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
	<link type="text/css" rel="stylesheet" href="assets/js/libs/summernote/summernote.css" />
	<link type="text/css" rel="stylesheet" href="assets/js/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" />

	<link type="text/css" rel="stylesheet" href="assets/css/theme-default/libs/fullcalendar/fullcalendar.css?1425466619" />

	<script src="assets/js/libs/jquery/jquery-1.12.4.js"></script>
	<script src="assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="assets/js/libs/jquery-ui/jquery-ui.js"></script>
	<script src="assets/js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="assets/js/libs/bootstrap-multiselect/bootstrap-multiselect.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="assets/js/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script src="assets/js/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="assets/js/libs/morris.js/morris.min.js"></script>
	<script src="assets/js/libs/raphael/raphael-min.js"></script>
	<script src="assets/js/libs/spin.js/spin.min.js"></script>
	<script src="assets/js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="assets/js/libs/moment/moment.min.js"></script>
	<script src="assets/js/libs/flot/jquery.flot.min.js"></script>
	<script src="assets/js/libs/flot/jquery.flot.time.min.js"></script>
	<script src="assets/js/libs/flot/jquery.flot.resize.min.js"></script>
	<script src="assets/js/libs/flot/jquery.flot.orderBars.js"></script>
	<script src="assets/js/libs/flot/jquery.flot.pie.js"></script>
	<script src="assets/js/libs/flot/curvedLines.js"></script>
	<script src="assets/js/libs/jquery-knob/jquery.knob.min.js"></script>
	<script src="assets/js/libs/sparkline/jquery.sparkline.min.js"></script>
	<script src="assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="assets/js/libs/d3/d3.min.js"></script>
	<script src="assets/js/libs/d3/d3.v3.js"></script>
	<script src="assets/js/libs/jquery.maskMoney.js"></script>
	<script src="assets/js/libs/jquery.number.min.js"></script>
	<script src="assets/js/libs/inputmask/jquery.inputmask.bundle.min.js"></script>
	<script src="assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
	<script src="assets/js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
	<script src="assets/js/libs/summernote/summernote.min.js"></script>
	<script src="assets/js/libs/toastr/toastr.js"></script>
	<script src="assets/js/libs/nestable/jquery.nestable.js"></script>
	<script src="assets/js/libs/fullcalendar/fullcalendar.min.js"></script>


	<script src="assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>


	<script src="assets/js/libs/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/core/source/App.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/core/source/AppNavigation.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/core/source/AppOffcanvas.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/core/source/AppCard.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/core/source/AppForm.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/core/source/AppNavSearch.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/core/source/AppVendor.js?v=<?php echo $inicio->getVersion(); ?>"></script>
	<script src="assets/js/libs/html5imageupload/html5imageupload.js"></script>

	<script src="assets/js/javascript.js?v=<?php echo $inicio->getVersion(); ?>"></script>

	<script type="text/javascript">
		function buscarEnTabla(tabla) {
			var ahora = new Date().getTime();
			var buscar = $('#filtrar_listado input').val();
			if (ahora - tiempoUltimaBusqueda > 150 && buscar != ultimaPalabra && buscar != '') {
				if (buscar.length > ultimaPalabra.length) {
					var contador = 0;
					$('#listado_elementos > tbody > tr:visible').each(function() {
						if ($(this).text().toLowerCase().indexOf(buscar.toLowerCase()) != -1) {
							$(this).show();
							if (contador % 2 == 0) {
								$(this).addClass('par');
							} else {
								$(this).removeClass('par');
							}
							contador++;
						} else {
							$(this).hide();
						}
					});
				} else {
					var contador = 0;
					$('#listado_elementos > tbody > tr').each(function() {
						if ($(this).text().toLowerCase().indexOf(buscar.toLowerCase()) != -1) {
							$(this).show();
							if (contador % 2 == 0) {
								$(this).addClass('par');
							} else {
								$(this).removeClass('par');
							}
							contador++;
						} else {
							$(this).hide();
						}
					});

				}
				tiempoUltimaBusqueda = ahora;
				ultimaPalabra = buscar;
			}


			if (buscar == '') {
				var contador = 0;
				$('#listado_elementos > tbody > tr').each(function() {
					$(this).show();
					if (contador % 2 == 0) {
						$(this).addClass('par');
					} else {
						$(this).removeClass('par');
					}
					contador++;
				});
				ultimaPalabra = buscar;
			}
		}
		var pais = 1;

		var blockFirst = true;
		var coloredRowCount = 0;
		var dataTableConfig = {
			"pageLength": 50,
			"fnDrawCallback": function(oSettings) {
				if (!blockFirst) {
					$('html, body').animate({
						scrollTop: $('#listado_elementos').parents(".card.card-underline").parent().offset().top
					}, 'slow');
				} else {
					blockFirst = false;
				}
			},
			"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				if (nRow == 0) {
					coloredRowCount = 0;
				}
				if (coloredRowCount % 2 === 0) {
					$('td', nRow).css('background-color', '#F2F2F2');
				} else {
					$('td', nRow).css('background-color', '#F9F9F9');
				}
				if ($(nRow).css('display') !== 'none') {
					coloredRowCount++;
				}
			},
			"createdRow": function(row, data, dataIndex) {
				if (row.getAttribute("data-status") === "0") {
					$(row).addClass('row-disabled');
				}
			},
			"oLanguage": traduccionLenguajeTablas
		};
	</script>
	<style>
		.row-disabled {
			color: #BABABA;
		}

		button.multiselect.btn {
			white-space: normal;
		}

		.buttonBox {
			padding: 3px;
		}

		.buttonBox button,
		.buttonBox span {
			width: 100%;
		}
	</style>
</head>

<body class="header-fixed menubar-first menubar-pin option-<?php echo $option; ?>">
	<div id="preLoader" style="position: fixed;background: #FFF;width: 100%;height: 100%;z-index: 9999;opacity: 0.9; padding-top: 200px;">
		<img src="assets/images/loader.gif" style="margin: auto;display: block;" />
	</div>
	<header id="header">
		<div class="headerbar">
			<div class="headerbar-left">
				<ul class="header-nav header-nav-options">
					<li class="header-nav-brand">
						<div class="brand-holder">
							<span class="text-lg text-bold text-primary"><img width="20" src="assets/images/logo.png" style="margin:7px;margin-bottom:10px;" />Biocloud | <?php echo $company->name; ?></span>
						</div>
					</li>
					<li>
						<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</li>
				</ul>
			</div>
			<div class="headerbar-right">
				<ul class="header-nav header-nav-profile">
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
							<span class="profile-info">
								<?php
								if (!empty($inicio->foto)) {
									echo "<img style='border-radius: 50%;margin-right:10px;' width='50' height='50' src='" . $inicio->foto . "' />";
								} else {
									echo "<p data-letters-user='" . $inicio->nombre[0] . $inicio->apellido[0] . "'>";
								}
								echo $inicio->nombre . ' ' . $inicio->apellido . " 	(" . $inicio->nombrerango . ")</p>"; ?>

							</span>
						</a>
						<ul class="dropdown-menu animation-dock">
							<li><a href="logout.php"><i class="fa fa-fw fa-power-off text-danger"></i> Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</header>