<?php
require_once ROOT_URL . "/server/models/Registro.php";
class Entidad
{
  static public function agregar($tabla, $informacion, $id_usuario = null)
  {
    global $db;
    global $inicio;
    if (empty($id_usuario)) {
      $id_usuario = $inicio->id;
    }
    if (!empty($informacion)) {
      $columnas = $db->get_results("SELECT COLUMN_NAME, COLUMN_DEFAULT FROM information_schema.COLUMNS WHERE TABLE_NAME = '$tabla' AND TABLE_SCHEMA = '" . DB_NAME . "'", null);
      if (!empty($columnas)) {
        $arrayKeys = array();
        $arrayValues = array();
        $informacion["modification_user"] = $id_usuario;
        foreach ($columnas as $value) {
          if (array_key_exists($value->COLUMN_NAME, $informacion)) {
            array_push($arrayKeys, $value->COLUMN_NAME);
            if (is_null($informacion[$value->COLUMN_NAME])) {
              if (is_null($value->COLUMN_DEFAULT)) {
                array_push($arrayValues, "NULL");
              } else {
                array_push($arrayValues, $value->COLUMN_DEFAULT);
              }
            } else {
              $k = strip_tags($informacion[$value->COLUMN_NAME]);
              array_push($arrayValues, "'$k'");
            }
          }
        }
        $sql = "INSERT INTO " . $tabla . " ";
        $sql .= "(";
        $sql .= implode(",", $arrayKeys);
        $sql .= ") VALUES(";
        $sql .= implode(",", $arrayValues);
        $sql .= ")";
        if (!$db->put($sql)) {
          return null;
        }
        return $db->insert_id;
      }
    }
    return null;
  }

  static public function editar($tabla, $id, $informacion, $id_usuario = null)
  {
    global $db;
    global $inicio;
    if (empty($id_usuario)) {
      $id_usuario = $inicio->id;
    }
    if (!empty($informacion)) {
      $identificador = $db->get_row("SHOW KEYS FROM $tabla WHERE Key_name = 'PRIMARY'");
      if (!empty($identificador)) {
        $identificador = $identificador->Column_name;

        $columnas = $db->get_results("SELECT COLUMN_NAME, COLUMN_DEFAULT FROM information_schema.COLUMNS WHERE TABLE_NAME = '$tabla' AND TABLE_SCHEMA = '" . DB_NAME . "'", null);
        if (!empty($columnas)) {
          $pairs = array();
          $informacion["modification_user"] = $id_usuario;
          foreach ($columnas as $value) {
            if ($value->COLUMN_NAME == $identificador) {
              continue;
            } else {
              if (array_key_exists($value->COLUMN_NAME, $informacion)) {
                $data = "";
                if (is_null($informacion[$value->COLUMN_NAME])) {
                  if (is_null($value->COLUMN_DEFAULT)) {
                    $data = "NULL";
                  } else {
                    $data = $value->COLUMN_DEFAULT;
                  }
                } else {
                  $k = strip_tags($informacion[$value->COLUMN_NAME]);
                  $data = "'$k'";
                }
                array_push($pairs, $value->COLUMN_NAME . "=" . $data);
              }
            }
          }
          $sql = "UPDATE " . $tabla . " SET ";
          $sql .= implode(",", $pairs);
          $condicion = "";
          if (is_array($id)) {
            $condicion = "in (" . implode(",", $id) . ")";
          } else {
            $condicion = "= '$id'";
          }
          $sql .= " WHERE $identificador $condicion";
          if (Registro::guardar($tabla, $id, $id_usuario)) {
            if (!$db->put($sql)) {
              return null;
            }
            return $id;
          }
        }
      }
    }
    return null;
  }

  static public function borrar($tabla, $id, $id_usuario = null)
  {
    global $db;
    global $inicio;
    if (empty($id_usuario)) {
      $id_usuario = $inicio->id;
    }
    $identificador = $db->get_row("SHOW KEYS FROM $tabla WHERE Key_name = 'PRIMARY'");
    if (!empty($identificador)) {
      $identificador = $identificador->Column_name;
      $condicion = "";
      if (is_array($id)) {
        $condicion = "in (" . implode(",", $id) . ")";
      } else {
        $condicion = "= '$id'";
      }
      $sql = "DELETE FROM " . $tabla . " WHERE $identificador $condicion";
      if (Registro::guardar($tabla, $id, $id_usuario)) {
        if (!$db->put($sql)) {
          return null;
        }
        Registro::guardar($tabla, $id, $id_usuario);
        return $id;
      }
    }
    return null;
  }
}
