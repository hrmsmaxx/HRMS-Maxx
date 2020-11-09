<?php
class Registro
{
  static public function guardar($tabla, $id_objeto, $id_usuario)
  {
    global $db;
    global $inicio;
    if (empty($id_usuario)) {
      $id_usuario = $inicio->id;
    }
    $identificador = $db->get_row("SHOW KEYS FROM $tabla WHERE Key_name = 'PRIMARY'");
    if (!empty($identificador) && !empty($identificador->Column_name)) {
      $identificador = $identificador->Column_name;
      $identificadores = $id_objeto;
      if (!is_array($id_objeto)) {
        $identificadores = array($id_objeto);
      }
      $tablaRegistro = "__log_" . $tabla;

      $columns_table = $db->get_results("SELECT COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '$tabla' AND TABLE_SCHEMA = '" . DB_NAME . "'", null);
      $table_structure = "";
      if (!empty($columns_table)) {
        foreach ($columns_table as $column) {
          $table_structure .= $column->COLUMN_NAME . " " . $column->COLUMN_TYPE . ",";
        }
      }
      $db->put("CREATE TABLE IF NOT EXISTS " . $tablaRegistro . " (
        `log_id` int(11) NOT NULL AUTO_INCREMENT,
        " . $table_structure . "
        PRIMARY KEY (`log_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

      $columnas = $db->get_results("SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_NAME = '$tablaRegistro' AND TABLE_SCHEMA = '" . DB_NAME . "'", null);
      if (!empty($columnas)) {
        foreach ($identificadores as $id) {
          $row = $db->get_row("SELECT * FROM $tabla WHERE $identificador = '$id'");
          $arrayKeys = array();
          $arrayValues = array();
          if (!empty($row)) {
            foreach ($row as $key => $value) {
              array_push($arrayKeys, $key);
              if (is_null($row->$key)) {
                array_push($arrayValues, "NULL");
              } else {
                $k = $db->escape(strip_tags($row->$key));
                array_push($arrayValues, "'$k'");
              }
            }
          } else {
            $informacion = array();
            foreach ($columnas as $value) {
              if ($value->COLUMN_NAME == "registro_id") {
                continue;
              }
              array_push($arrayKeys, $value->COLUMN_NAME);
              if (array_key_exists($value->COLUMN_NAME, $informacion)) {
                $k = $db->escape(strip_tags($informacion[$value->COLUMN_NAME]));
                array_push($arrayValues, "'$k'");
              } else if ($value->IS_NULLABLE == "YES") {
                array_push($arrayValues, "NULL");
              } else {
                array_push($arrayValues, $value->COLUMN_DEFAULT);
              }
            }
          }
          $sql = "INSERT INTO $tablaRegistro ";
          $sql .= "(";
          $sql .= implode(",", $arrayKeys);
          $sql .= ") VALUES(";
          $sql .= implode(",", $arrayValues);
          $sql .= ")";
          $db->put($sql, null);
        }
        return true;
      }
    }
    return false;
  }
}
