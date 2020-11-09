<?php
class Seccion
{
  var $icono = "glyphicon glyphicon-stats";
  var $nombre = "Información del sistema";
  var $option = 'informacion-sistema';

  var $message = array();
  var $totales = null;

  function check_forms()
  {
    global $inicio;
  }

  var $listaEntidades = array( //Nombre => tabla
    "calendario" => "Fechas de calendarios asignadas",
    "cargo" => "Cargos",
    "centro" => "Sucursales",
    "departamento" => "Departamentos",
    "departamento_responsable" => "Responsables de departamentos",
    "dia" => "Días personalizados",
    "dia_opcion" => "Días genericos",
    "dia_tipo" => "Tipo de día",
    "documento" => "Documentos",
    "documento_tipo" => "Tipos de documentos",
    "estandar" => "Estandares registrados",
    "estandar_dia" => "Días de los estanderes registrados",
    "funcionario" => "Funcionarios",
    "funcionario_cargo" => "Cargos asignados a funcionarios",
    "funcionario_estado" => "Registro de estados de funcionarios",
    "funcionario_documento" => "Documentos de funcionarios",
    "funcionario_reporte" => "Reportes asignados a funcionarios",
    "funcionario_turno" => "Turnos asignados a funcionarios",
    "horario" => "Horarios de turnos",
    "horario_interrupcion" => "Interrupciones de horarios",
    "huella" => "Huellas",
    "incidencia" => "Incidencias",
    "incidencia_tipo" => "Tipos de incidencias",
    "lector" => "Dispositivos",
    "lector_acceso_intervalo" => "Configuraciones de intervalos de accesos",
    "lector_acceso_modalidad" => "Modalidades de acceso",
    "lector_evento" => "Eventos de dispositivo",
    "lector_funcionario" => "Funcionarios en dispositivos",
    "lector_funcionario_estado" => "Registro de estados de funcionarios en dispositivos",
    "lector_info" => "Información adicional de dispositivos",
    "lector_modelo" => "Modelos de dispositivos",
    "marca" => "Marcas",
    "marca_cierre" => "Cierres de marcas hechos",
    "marca_origen" => "Origenes de marcas",
    "menu" => "Menús",
    "menu_opcion" => "Opciones de menús",
    "notificacion" => "Notificaciones",
    "notificacion_hash" => "Hashs de notificaciones",
    "opcion" => "Configuraciones",
    "registro_lector_evento" => "Eventos registrados de dispositivos",
    "reporte" => "Reportes personalizados",
    "reporte_contenido" => "Contenido de reportes personalizados",
    "reporte_opcion" => "Opciones de reportes personalizados",
    "rostro" => "Rostros",
    "turno" => "Turnos",
    "ubicacion" => "Ubicaciones",
    "usuario" => "Usuarios",
    "usuario_rol" => "Roles de usuarios",
    "verificacion" => "Tipos de verificacion"
  );

  function entidades()
  {
    global $db;
    $totalCantidad = 0;
    $totalEspacio = 0;
    $totalCantidadRegistros = 0;
    $totalEspacioRegistros = 0;
    $datos = array();
    foreach ($this->listaEntidades as $key => $value) {
      $o = new stdClass();
      $info = $db->get_row("SELECT DATA_LENGTH, INDEX_LENGTH, TABLE_ROWS FROM information_schema.tables WHERE TABLE_NAME = '$key' AND TABLE_SCHEMA = '" . DB_NAME . "'");
      $o->nombre = $value;
      $o->cantidad = $info->TABLE_ROWS;
      $o->espacio = ($info->INDEX_LENGTH + $info->DATA_LENGTH) / 1000000;
      $infoRegistro = $db->get_row("SELECT DATA_LENGTH, INDEX_LENGTH, TABLE_ROWS FROM information_schema.tables WHERE TABLE_NAME = '_registro_$key' AND TABLE_SCHEMA = '" . DB_NAME . "'");
      if (!empty($infoRegistro)) {
        $o->registros = $infoRegistro->TABLE_ROWS;
        $o->espacio_registros = ($infoRegistro->INDEX_LENGTH + $infoRegistro->DATA_LENGTH) / 1000000;

        $totalCantidadRegistros += $o->registros;
        $totalEspacioRegistros += $o->espacio_registros;
      } else {
        $o->registros = -1;
        $o->espacio_registros = -1;
      }
      $totalCantidad += $o->cantidad;
      $totalEspacio += $o->espacio;
      $datos[$key] = $o;
    }
    $this->totales = new stdClass();
    $this->totales->nombre = "Totales";
    $this->totales->cantidad = $totalCantidad;
    $this->totales->espacio = $totalEspacio;
    $this->totales->registros = $totalCantidadRegistros;
    $this->totales->espacio_registros = $totalEspacioRegistros;
    return $datos;
  }
}
