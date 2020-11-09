<?php
class Inicio
{
  var $version = '1.16.6';
  var $debug = true;
  var $dias = array();
  var $filtro = null;
  var $parameters = array();

  function getVersion()
  {
    if ($this->debug === true) {
      return time();
    } else {
      return $this->version;
    }
  }

  function login()
  {
    global $db;
    global $testLoginFin;
    if (!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
      $usuario = $_SESSION['username'];
      $pass = $_SESSION['password'];
    } else {
      session_destroy();
      header("Location: " . ROOT_URL_PANEL . "login.php");
      exit;
    }

    $userdata = $db->get_row("SELECT u.*, ur.menu_id, ur.name as role_name, ur.permissions  FROM _user as u INNER JOIN _user_role as ur ON u.user_role_id = ur.id WHERE u.username = '$usuario' AND u.hashed_password = '" . md5($pass) . "' AND u.status = 1", array("u"));
    $testLoginFin = microtime(true);
    if (!empty($userdata)) {
      $this->id = $userdata->id;
      $this->usuario = $userdata->username;
      $this->rango = $userdata->user_role_id;
      $this->nombrerango = $userdata->role_name;
      $this->permisos = json_decode($userdata->permissions, true);
      $this->nombre = $userdata->first_name;
      $this->apellido = $userdata->last_name;
      $this->menu = $userdata->menu_id;
      $this->fecha = time();
      $this->fechaHoy = mktime(0, 0, 0, date('n'), date('d'), date('Y'));
      $this->actualURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      return $this->id;
    } else {
      $msg = 1;
      unset($_SESSION['username']);
      unset($_SESSION['password']);
      session_destroy();
      header("Location: " . ROOT_URL_PANEL . "login.php?msg=" . $msg);
      exit;
    }
  }

  function can_do($action, $modulo = null, $force = true)
  {
    global $seccion;

    if ($modulo == null) $modulo = $seccion->modulo;

    if ($this->rango == 1 || ($force && $modulo == 1)) {
      return true;
    } else {
      if (isset($this->permisos[$modulo][$action])) return $this->permisos[$modulo][$action];
      return false;
    }
  }

  function esLinkActual($link)
  {
    return (!empty($link) && strpos($_SERVER['REQUEST_URI'], $link) !== false && strpos($_SERVER['REQUEST_URI'], $link . '-') === false);
  }

  function crearMenu()
  {
    global $db;

    $items = $db->get_results("SELECT name, link, icon, permissions FROM _menu_item WHERE menu_id = " . $this->menu, null);
    echo '<ul id="main-menu" class="gui-controls">';
    if (!empty($items)) {
      foreach ($items as $item) {
        echo '<li><a href="' . $item->link . '"><div class="gui-icon"><i class="' . $item->icon . '"></i></div><span class="title">' . $item->name . '</span></a></li>';
      }
    }
    echo '</ul>';
  }

  function unparse_fecha_corto($sqlformat, $exactitud = true)
  {
    if ($exactitud) {
      $fecha = date("d/m \a \l\a\s H:i", $sqlformat);
    } else {
      $fecha = date("d/m", $sqlformat);
    }
    return $fecha;
  }

  function unparse_fecha($sqlformat, $exactitud = true)
  {
    if ($exactitud) {
      $fecha = date("d/m/Y H:i", $sqlformat);
    } else {
      $fecha = date("d/m/Y", $sqlformat);
    }
    return $fecha;
  }

  function parse_fecha($myformat)
  {
    if (@!strpos($myformat, ' ')) {
      @list($dia, $mes, $ano) = @explode("/", $myformat);
      $time = @mktime('00', '00', '00', $mes, $dia, $ano);
    } else {
      @list($fecha, $hora) = @explode(" ", $myformat);
      @list($dia, $mes, $ano) = @explode("/", $fecha);
      @list($horas, $min, $seg) = @explode(":", $hora);
      $time = @mktime($horas, $min, $seg, $mes, $dia, $ano);
    }
    return $time;
  }

  function numero($numero, $decimales = true, $numDecimales = 2)
  {
    if ($decimales) {
      return number_format($numero, $numDecimales, ',', '.');
    } else {
      return number_format($numero, 0, ',', '.');
    }
  }

  function agregarCampoForm($nombre, $valor = '', $placeholder = '', $clase = '', $obligatorio = false)
  {
    $label = str_replace(' ', '-', $nombre);
    if ($placeholder == '') $plh = $nombre;
    else $plh = $placeholder;

    $ob = "";
    if ($obligatorio) {
      $ob = '<span style="color:red;">(*)</span>';
    }

    echo '<div class="form-group">
    <div class="col-xs-3 col-sm-3 col-lg-3">
    <label for="' . $label . '" class="control-label">' . $nombre . ' ' . $ob . '</label>
    </div>
    <div class="col-xs-9 col-sm-9 col-lg-6">
    <input type="text" name="' . $label . '" id="' . $label . '" class="form-control ' . $clase . '" value="' . $valor . '" placeholder="' . $plh . '" autocomplete="off">
    </div>
    </div>';
  }


  function crearFieldsSelect($data)
  {
    $array = array();
    if (!empty($data)) {
      foreach ($data as $row) :
        $array[$row->value] = $row->name;
      endforeach;
    }
    return $array;
  }

  private function transformInputName($text)
  {
    return str_replace(' ', '_', preg_replace("/[^A-Za-z0-9 ]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', mb_strtolower($text))));
  }

  /*
  $config = {
  "name":text,
  "value":text,
  "label":text,
  "placeholder":text,
  "type":text,
  "class":text,
  "fields":array,
  "mandatory":bool
};
*/
  function agregarCampoForm2($config)
  {
    $label = $config["label"];
    $type = "text";
    if (isset($config["type"])) {
      $type = $config["type"];
    }
    if (isset($config["placeholder"])) {
      $placeholder = $config["placeholder"];
    } else {
      if ($type == "select") {
        $placeholder = "Seleccionar";
      } else {
        $placeholder = $label;
      }
    }
    if (isset($config["name"])) {
      $name = $config["name"];
    } else {
      $name = $this->transformInputName($label);
    }
    $ob = "";
    if (isset($config["mandatory"]) && $config["mandatory"]) {
      $ob = '<span style="color:red;">(*)</span>';
    }
    $value = "";
    if (isset($config["value"])) {
      $value = $config["value"];
    }
    $className = "";
    if (isset($config["class"])) {
      $className = " " . $config["class"];
    }
    if (isset($config["id"])) {
      $id = 'id="' . $config["id"] . '"';
    } else {
      $id = "";
    }

    echo '<div class="form-group">
  <div class="col-xs-3 col-sm-3 col-lg-3">
  <label for="' . $name . '" class="control-label">' . $label . ' ' . $ob . '</label>
  </div>
  <div class="col-xs-9 col-sm-9 col-lg-6">';
    switch ($type) {
      case "fecha_dia":
        echo '<input type="text" name="' . $name . '" ' . $id . ' class="form-control fecha_dia' . $className . '" value="' . $value . '" placeholder="' . $placeholder . '" autocomplete="off">';
        break;
      case "radio":
        $fields = $config["fields"];
        foreach ($fields as $radioValue => $radioTexto) {
          //radio-inline
          echo '<div class="radio radio-styled"><label><input class="' . $className . '" type="radio" value="' . $radioValue . '" name="' . $name . '" ';
          if ($value == $radioValue) {
            echo 'checked';
          }
          echo '><span>' . $radioTexto . '</span></label></div>';
        }
        break;
      case "select":
        $fields = null;
        if (isset($config["fields"])) {
          $fields = $this->crearFieldsSelect($config["fields"]);
        }
        $multiple = "";
        if (isset($config["multiple"]) && $config["multiple"]) {
          echo '<select ' . $id . ' name="' . $name . '[]" class="multiselect' . $className . '" multiple>';
        } else {
          echo '<select ' . $id . ' name="' . $name . '" class="multiselect' . $className . '">';
        }
        echo '<option value="">' . $placeholder . '</option>';
        if (!empty($fields)) {
          foreach ($fields as $selectValue => $selectText) {
            //radio-inline
            echo '<option value="' . $selectValue . '" ';
            if (is_array($value)) {
              if (in_array($selectValue, $value)) {
                echo 'selected';
              }
            } else if ($value == $selectValue) {
              echo 'selected';
            }
            echo '>' . $selectText . '</option>';
          }
        }
        echo '</select>';
        break;
      case "file":
        echo '<input ' . $id . ' type="file" class="input disabled' . $className . '" name="' . $name . '" style="width: 290px;" readonly>';
        break;
      default:
        echo '<input type="' . $type . '" name="' . $name . '" ' . $id . ' class="form-control' . $className . '" value="' . $value . '" placeholder="' . $placeholder . '" autocomplete="off">';
    }
    echo '</div></div>';
  }

  function mostrarCampo($label, $valor)
  {
    echo '<div class="mostrarInfo">
  <label class="control-label">' . $label . '</label>
  <div class="dato">' . $valor . '</div>
  </div>';
  }

  function cargarDias()
  {
    global $db;
    if (empty($this->dias)) $this->dias = $db->get_results("SELECT * FROM dia_opcion", true);
    return $this->dias;
  }
}
