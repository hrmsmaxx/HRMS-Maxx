<?php
require_once ROOT_URL . "/server/models/Registro.php";
require_once ROOT_URL . "/server/models/Entidad/EntidadAbstracta.php";
class EntidadOpcion extends EntidadAbstracta
{
  public function agregar($informacion, $id_usuario = null)
  {
    //// TODO:
    return false;
  }

  public function editar($id, $informacion, $id_usuario = null)
  {
    global $db;
    global $inicio;
    $tiempoAhora = time();
    if (empty($id_usuario)) {
      $id_usuario = $inicio->id;
    }
    if (!empty($informacion)) {
      foreach ($informacion as $key => $value) {
        $id_opcion = $db->get_var("SELECT id_opcion FROM opcion WHERE tipo = '$key'");
        if (!empty($id_opcion)) {
          if (Registro::guardar($this->tabla, $id_opcion, $id_usuario)) {
            $db->put("UPDATE opcion SET valor='$value',registro_usuario='$id_usuario',registro_fecha='$tiempoAhora' WHERE id_opcion = '$id_opcion'");
          }
        }
      }
      return true;
    }
    return false;
  }

  public function borrar($id, $id_usuario = null)
  {
    //// TODO:
    return false;
  }
}
$EntidadOpcion = new EntidadOpcion("opcion", "Opcion");
