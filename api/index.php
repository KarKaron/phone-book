<?php
if (session_id() == '') {
  session_start();
}
include_once 'config.php';
include_once 'auth.php';

$data = \Config\getRequestData();
$router = $data['router'];

if (\Config\isValidRouter($router)) {
  include_once "routers/$router.php";
  route($data);
} else {
  \Config\throwHttpError('error', '', 'Неправильный формат запроса!');
}
