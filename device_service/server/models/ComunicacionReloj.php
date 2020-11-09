<?php

/*

Clase destinada a la comunicacion con el reloj de asistencia,
usada para subir datos a la web del reloj y obtener datos de la web al reloj.

*/
require_once ROOT_URL . '/server/models/ControlAccesos.php';
$ClassControlAcceso = new ControlAccesos();

class ComunicacionReloj
{

	//var $private_cert = '';

	function __construct()
	{
		//$this->private_cert = $private_cert;
	}

	function cleanText($string)
	{
		return iconv("utf-8", "ascii//TRANSLIT", $string);
	}

	function getIncidencias()
	{
		global $db;
		$data = $db->get_results("SELECT device_code, name FROM _workcode WHERE device_code != 0 AND status = 1 ORDER BY device_code ASC");

		$o = array();

		if (!empty($data)) {
			foreach ($data as $d) {
				if (is_numeric($d->device_code)) {
					$object = array();
					$object["codigo"] = $d->device_code;
					$object["nombre"] = $this->cleanText($d->name);
					array_push($o, $object);
				}
			}
		}

		return json_encode($o);
	}

	function getTime()
	{
		global $db;
		$object = array();

		date_default_timezone_set('America/Montevideo');
		$tiempoAhora = time();
		$object["year"] = date("Y", $tiempoAhora);
		$object["month"] = date("m", $tiempoAhora);
		$object["day"] = date("d", $tiempoAhora);
		$object["hour"] = date("H", $tiempoAhora);
		$object["minute"] = date("i", $tiempoAhora);
		$object["second"] = date("s", $tiempoAhora);

		return json_encode($object);
	}

	private function creadorAtributo(&$objeto, $nombre, $valor, $defecto = 0)
	{
		$objeto[$nombre] = $valor;
		if (empty($objeto[$nombre])) {
			$objeto[$nombre] = $defecto;
		}
	}

	function getLectores()
	{
		global $db;
		global $inicio;
		$data = $db->get_results("SELECT * FROM _device WHERE status = 1");
		$o = array();
		if (!empty($data)) {
			foreach ($data as $d) {
				$object = array();

				$object["ip"] = $d->ip;
				$object["puerto"] = $d->port;
				$modalidad_consumo = 0;
				if ($d->consume_mode == "time") {
					$modalidad_consumo = 1;
				} else if ($d->consume_mode == "time") {
					$modalidad_consumo = 2;
				}
				$this->creadorAtributo($object, "ultimoConsumo", $inicio->parse_fecha($d->last_consume));
				$this->creadorAtributo($object, "modalidadConsumo", $modalidad_consumo);
				$this->creadorAtributo($object, "horaConsumo", explode(":", $d->consume_time)[0]);
				$this->creadorAtributo($object, "minutoConsumo", explode(":", $d->consume_time)[1]);
				$this->creadorAtributo($object, "intervaloConsumo", explode(":", $d->consume_interval)[1] + explode(":", $d->consume_interval)[0] * 60);


				$modalidadActualizacion = 0;
				if ($d->update_mode == "time") {
					$modalidadActualizacion = 1;
				} else if ($d->update_mode == "time") {
					$modalidadActualizacion = 2;
				}
				$this->creadorAtributo($object, "ultimaActualizacion", $inicio->parse_fecha($d->last_update));
				$this->creadorAtributo($object, "modalidadActualizacion", $modalidadActualizacion);
				$this->creadorAtributo($object, "horaActualizacion", explode(":", $d->update_time)[0]);
				$this->creadorAtributo($object, "minutoActualizacion", explode(":", $d->update_time)[1]);
				$this->creadorAtributo($object, "intervaloActualizacion", explode(":", $d->update_interval)[1] + explode(":", $d->update_interval)[0] * 60);

				$modalidadTiempo = 0;
				if ($d->clock_mode == "time") {
					$modalidadTiempo = 1;
				} else if ($d->clock_mode == "time") {
					$modalidadTiempo = 2;
				}
				$this->creadorAtributo($object, "ultimoTiempo", $inicio->parse_fecha($d->last_clock));
				$this->creadorAtributo($object, "modalidadTiempo", $modalidadTiempo);
				$this->creadorAtributo($object, "horaTiempo", explode(":", $d->clock_time)[0]);
				$this->creadorAtributo($object, "minutoTiempo", explode(":", $d->clock_time)[1]);
				$this->creadorAtributo($object, "intervaloTiempo", explode(":", $d->clock_interval)[1] + explode(":", $d->clock_interval)[0] * 60);

				$this->creadorAtributo($object, "formaTiempo", $d->timezone);
				$this->creadorAtributo($object, "borrarMarcas", $d->clean_attendance);
				$this->creadorAtributo($object, "accion", $d->action);

				array_push($o, $object);
			}
		}

		return json_encode($o);
	}

	function actualizarFuncionariosTope($id_lector)
	{
	}

	function finalizarActualizacion($id_lector)
	{
		global $db;
		$db->query("UPDATE _employee_device SET updated = 1 WHERE device_id = '$id_lector'");
	}


	function eliminarFuncionariosDeColaActualizacion($id_lector, $funcionarios)
	{
		global $db;
		$codeList = "";
		$deleteCodeList = "";
		foreach ($funcionarios as $f) {
			$info = explode("-", $db->escape($f));
			if (sizeof($info) == 2 && $info[0] == "delete") {
				$deleteCodeList .= $db->escape($info[1]) . ",";
			} else {
				$codeList .= $db->escape($f) . ",";
			}
		}
		if (!empty($deleteCodeList)) {
			$deleteCodeList = substr($deleteCodeList, 0, -1);
			$db->query("DELETE IGNORE FROM _employee_device WHERE device_id = '$id_lector' AND deleted = 1 AND employee_id in (SELECT id FROM _employee WHERE device_code in ($deleteCodeList))");
		}
		if (!empty($codeList)) {
			$codeList = substr($codeList, 0, -1);
			$db->query("UPDATE _employee_device SET updated = 1 WHERE device_id = '$id_lector' AND employee_id in (SELECT id FROM _employee WHERE device_code in ($codeList))");
		}
	}

	function getFuncionariosPaginados($id_lector, $offset = 0, $limit = 500)
	{
		global $db;
		global $ClassControlAcceso;
		set_time_limit(0);
		ini_set('mysql.connect_timeout', '0');
		ini_set('max_execution_time', '0');
		$o = array();
		$o["total"] = 0;
		$o["datos"] = array();
		if (!empty($id_lector)) {
			$modalidadLector = $ClassControlAcceso->getModalidad($id_lector);
			$data = $db->get_results("SELECT e.device_code as codigo, e.first_name as nombre, e.rfid_card as tarjeta, e.last_name as apellido, e.device_password as contrasena_reloj, e.status as funcionario_activo, ed.deleted as eliminado, ed.status as lectorfuncionario_activo, ed.access_limit as topeAcceso, e.id as id_funcionario, ed.privilege_type as privilegio FROM _employee_device as ed LEFT JOIN _device as d ON ed.device_id = d.id LEFT JOIN _employee as e ON ed.employee_id = e.id WHERE ed.device_id = '$id_lector' AND e.device_code <> '' AND ed.updated = 0 GROUP BY ed.employee_id LIMIT $offset,$limit", array("ed"));
			$o["total"] = $db->get_row("SELECT COUNT(*) as total FROM _employee_device as ed LEFT JOIN _employee as e ON ed.employee_id = e.id WHERE ed.device_id = '$id_lector' AND e.device_code <> '' AND ed.updated = 0", array("ed"))->total;
			if (!empty($data)) {
				foreach ($data as $d) {
					$hasAccessType = false;
					$contadorAcceso = $ClassControlAcceso->getAccesos($id_lector, $d->id_funcionario);
					$object = array();
					$object["actualizar_password"] = 1;
					$object["actualizar_huellas"] = 1;
					$object["actualizar_rostro"] = 1;
					$object["actualizar_tarjeta"] = 1;
					$object["codigo"] = $d->codigo;
					if (empty($d->tarjeta)) {
						$object["tarjeta"] = "0";
					} else {
						$object["tarjeta"] = $d->tarjeta;
						$hasAccessType = true;
					}
					$object["contadorAcceso"] = $contadorAcceso;
					$object["topeAcceso"] = $d->topeAcceso;
					$object["modalidadAcceso"] = $modalidadLector;
					$object["nombre"] = substr($this->cleanText($d->nombre . " " . $d->apellido), 0, 23);
					$object["password"] = $d->contrasena_reloj;
					if (!empty($object["password"])) {
						$hasAccessType = true;
					}
					$object["huellas"] = $this->getHuellas($d->id_funcionario);
					if (!empty($object["huellas"])) {
						$hasAccessType = true;
					}
					$dataRostro = $this->getRostro($d->id_funcionario);
					$object["rostro"] = $dataRostro["base64"];
					if (!empty($object["rostro"])) {
						$hasAccessType = true;
					}
					$object["rostroLength"] = $dataRostro["length"];
					$object["privilegio"] = $d->privilegio;
					if ($object["privilegio"] == 'moderator') {
						$object["privilegio"] = 1;
					} else if ($object["privilegio"] == 'administrator') {
						$object["privilegio"] = 2;
					} else if ($object["privilegio"] == 'owner') {
						$object["privilegio"] = 3;
					} else { //'default'
						$object["privilegio"] = 0;
					}

					$activo = 1;
					if ($d->funcionario_activo == false) {
						$activo = 0;
					} else {
						if ($d->lectorfuncionario_activo == false) {
							$activo = 0;
						}
					}
					if ($d->topeAcceso != 0) {
						if ($contadorAcceso >= $d->topeAcceso) {
							$object["activo"] = 0;
						} else {
							$object["activo"] = $activo;
						}
					} else {
						$object["activo"] = $activo;
					}
					$object["eliminar"] = $d->eliminado;
					if (!empty($object["eliminar"]) || empty($object["activo"])) {
						$hasAccessType = true;
					}
					if (!$hasAccessType) {
						//$object["activo"] = 0;
					}
					array_push($o["datos"], $object);
				}
			}
		}
		return json_encode($o, JSON_UNESCAPED_SLASHES);
	}

	function getHuellas($id_funcionario)
	{
		global $db;
		$data = $db->get_results("SELECT e.device_code as codigo, ef.finger_number as dedo, ef.base64 as base64 FROM _employee as e JOIN _employee_fingerprint as ef ON e.id = ef.employee_id WHERE ef.employee_id = '$id_funcionario'", array("e"));

		$o = array();
		if (!empty($data)) {
			foreach ($data as $d) {
				$object = array();
				$object["base64"] = join('+', explode(" ", $d->base64));
				array_push($o, $object);
				//break;
			}
		}
		return $o;
	}

	function getRostro($id_funcionario)
	{
		global $db;
		$data = $db->get_results("SELECT e.device_code as codigo, ef.length as length, ef.base64 as base64 FROM _employee as e JOIN _employee_face as ef ON e.id = ef.employee_id WHERE ef.employee_id = '$id_funcionario'", array("e"));

		$o = array();
		if (!empty($data)) {
			$o["length"] = $data->length;
			$o["base64"] = $data->base64;
		} else {
			$o["length"] = 0;
			$o["base64"] = "";
		}
		return $o;
	}

	function sendAction($id_lector, $accion)
	{
		global $db;
		global $inicio;
		if ($accion == "forzaractualizarfuncionarios") {
			$accion = "actualizarfuncionarios";
			$db->query("UPDATE _employee_device SET updated = 0 WHERE device_id = '$id_lector'");
		}
		if ($accion == "timeout") {
			$db->query("UPDATE _device SET action='',answer='' WHERE id = '$id_lector'");
		} else {
			$db->query("UPDATE _device SET action='$accion',answer='' WHERE id = '$id_lector'");
		}
	}

	function getResponse($id_lector)
	{
		global $db;
		$data = $db->get_row("SELECT answer FROM _device WHERE id = '$id_lector'");
		if (!empty($data)) {
			return $data->answer;
		}
		return '{}';
	}

	function getLector($ip, $puerto)
	{
		global $db;
		$data = $db->get_row("SELECT id FROM _device WHERE ip = '" . $ip . "' AND port = '" . $puerto . "'");
		if (!empty($data)) {
			return $data->id;
		}
		return 0;
	}

	function getAction($id_lector)
	{
		global $db;
		if (!empty($id_lector)) {
			$data = $db->get_row("SELECT action FROM _device WHERE id = '$id_lector'");
			if (!empty($data)) {
				return $data->action;
			} else {
				return "";
			}
		} else {
			return "";
		}
	}

	function forceDownload($id_lector)
	{
		global $db;
		if (!empty($id_lector)) {
			$db->query("UPDATE _employee_device SET updated = 0 WHERE device_id = '" . $id_lector . "'");
		}
	}

	function setResponse($id_lector, $mensaje)
	{
		global $db;
		if (!empty($id_lector)) {
			$db->query("UPDATE _device SET action='',answer='$mensaje' WHERE id = '" . $id_lector . "'");
		}
	}
}

$ComunicacionReloj = new ComunicacionReloj();
