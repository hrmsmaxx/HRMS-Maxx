<?php
if (isset($_GET["lector"])) {
  $handle = fopen("user.dat", "w");
  $funcionarios = $seccion->listar();
  $text = "";
  $nullChar = chr(0);
  $startHeading = 1;
  foreach ($funcionarios as $f) {
    $name = substr(normalizer_normalize($f->funcionario_nombre . " " . $f->funcionario_apellido), 0, 23);
    $code = $f->funcionario_codigo;
    $name = str_pad($name, 23, $nullChar, STR_PAD_RIGHT);
    $code = str_pad($code, 9, $nullChar, STR_PAD_RIGHT);
    $text .= chr($startHeading);
    for ($i = 0; $i < 10; $i++) {
      $text .= $nullChar;
    }
    $text .= $name;
    for ($i = 0; $i < 5; $i++) {
      $text .= $nullChar;
    }
    $text .= $startHeading;
    for ($i = 0; $i < 8; $i++) {
      $text .= $nullChar;
    }
    $text .= $code;
    for ($i = 0; $i < 15; $i++) {
      $text .= $nullChar;
    }
  }
  fwrite($handle, $text);
  fclose($handle);
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=' . basename('user.dat'));
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize('user.dat'));
  readfile('user.dat');
  exit;
}
