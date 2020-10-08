<?php
if (session_id() == '') {
  session_start();
}
include_once("config.php");
include_once("api/auth.php");
 
$template = \Auth\isLogged() ? 'main' : 'login';
include_once "./template/$template.php";
?>