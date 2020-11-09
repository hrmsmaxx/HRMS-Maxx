<?php
require_once ROOT_URL . "/server/Utilidades.php";
require_once ROOT_URL . "/server/controllers/ControladorEntidadAbstracto.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadFuncionario.php";
class ControladorFuncionario extends ControladorEntidadAbstracto
{
  public function crearInformacion()
  {
    global $db;
    global $inicio;
    global $Utilidades;

    $errores = array();
    $informacion = array();

    $informacion["id"] = $Utilidades->getPost('iddata', "int");
    $informacion["first_name"] = $Utilidades->getPost('nombre', "string");
    $informacion["last_name"] = $Utilidades->getPost('apellido', "string");
    $informacion["device_code"] = $Utilidades->getPost('codigo', "int");
    $informacion["rfid_card"] = $Utilidades->getPost('tarjeta_rfid', "int");
    $informacion["device_password"] = $Utilidades->getPost('contrasena_reloj', "string");
    $informacion["status"] = $Utilidades->getPost('activo', "int");
    $informacion["huella"] = $Utilidades->getPost('huella', "int");
    $informacion["eliminarTodas"] = $Utilidades->getPost('eliminarTodas', "int");

    $informacion["lectores"] = $Utilidades->getPost('lectores', "array");

    if (!is_numeric($informacion["device_code"])) $Utilidades->addError($errores, 'El campo Código debe ser un número.');
    if (!empty($informacion["rfid_card"]) && !is_numeric($informacion["rfid_card"])) $Utilidades->addError($errores, 'El campo Tarjeta RFID debe ser un número.');

    if (strlen($informacion["first_name"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Nombre es 100 caracteres.');
    if (strlen($informacion["last_name"]) > 100) $Utilidades->addError($errores, 'El largo máximo del campo Apellido es 100 caracteres.');
    if (strlen($informacion["device_code"]) > 10) $Utilidades->addError($errores, 'El largo máximo del campo Código es 10 caracteres.');
    if (strlen($informacion["rfid_card"]) > 11) $Utilidades->addError($errores, 'El largo máximo del campo Tarjeta RFID es 11 caracteres.');
    if (strlen($informacion["device_password"]) > 25) $Utilidades->addError($errores, 'El largo máximo del campo Contraseña reloj es 25 caracteres.');

    if (empty($informacion["first_name"]) || empty($informacion["last_name"])) $Utilidades->addError($errores, 'Complete todos los campos para continuar.');

    return array("error" => $errores, "data" => $informacion);
  }
}

$ControladorFuncionario = new ControladorFuncionario($EntidadFuncionario);
