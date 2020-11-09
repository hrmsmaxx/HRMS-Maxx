<?php
include_once "preconfig.php";

$subdomain =  $db->escape(explode('.', $_SERVER['HTTP_HOST'])[0]);
if (substr($subdomain, 0, 6) === "device") {
  define("SUBDOMAIN_NAME", substr($subdomain, 6, strlen($subdomain)));
} else {
  exit;
}



$company = $db->get_row("SELECT * FROM _subdomain WHERE subdomain = '" . SUBDOMAIN_NAME . "'");

if (empty($company)) {
  header("Location: login.php?msg=3");
  exit;
} else if ($company->status == 0) {
  header("Location: login.php?msg=4");
  exit;
}

if (isset($_POST['username']) && !empty($_POST['username'])) {
  $_SESSION['username'] = $db->escape($_POST['username']);
}
if (isset($_POST['password']) && !empty($_POST['password'])) {
  $_SESSION['password'] = $db->escape($_POST['password']);
}
