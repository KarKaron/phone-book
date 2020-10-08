<?php
namespace Config;
use PDO;

function getFormData($method) {
  if ($method === 'GET') {
    $data = $_GET;
  } else if ($method === 'POST') {
    $data = $_POST;
  } else {
    $data = array();
    $exploded = explode('&', file_get_contents('php://input'));

    foreach($exploded as $pair) {
      $item = explode('=', $pair);
      if (count($item) == 2) {
        $data[urldecode($item[0])] = urldecode($item[1]);
      }
    }
  }

  unset($data['q']);
  return $data;
}


function getRequestData() {  
  $method = $_SERVER['REQUEST_METHOD'];

  $url = (isset($_GET['q'])) ? $_GET['q'] : '';
  $url = trim($url, '/');
  $urls = explode('/', $url);

  $urlData = array_slice($urls, 0);

  return array(
    'method' => $method,
    'formData' => getFormData($method),
    'urlData' => $urlData,
    'router' => $urlData[0]
  );
}


function connectDB() {  
  $host = 'localhost';
  $user = 'admin';
  $password = '2t28fMThMr8HeZHh';
  $db = 'phone_book';

  $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  );

  return new PDO($dsn, $user, $password, $options);
}


function isValidRouter($router) {  
  return in_array($router, array(
    'items',
    'auth',
    'registration',
    'loading'
  ));  
}

function clear($var){
  $var = (htmlspecialchars(trim($var)));
  return $var;
}

function isExistsUsersByLogin($pdo, $user) {  
  $query = 'SELECT id FROM users WHERE login=:user';
  $data = $pdo->prepare($query);
  $data->bindParam(':user', $user);
  $data->execute();

  return count($data->fetchAll()) === 1;  
}

function isExistsUsersByEmail($pdo, $email) {  
  $query = 'SELECT id FROM users WHERE email=:email';
  $data = $pdo->prepare($query);
  $data->bindParam(':email', $email);
  $data->execute();

  return count($data->fetchAll()) === 1;  
}

function isExistsItemsById($pdo, $id) {  
  $query = 'SELECT id FROM items WHERE id=:id';
  $data = $pdo->prepare($query);
  $data->bindParam(':id', $id, PDO::PARAM_INT);
  $data->execute();

  return count($data->fetchAll()) === 1;  
}

function isExistsItemsByPhone($pdo, $phone) {  
  $query = 'SELECT id FROM items WHERE phone=:phone';
  $data = $pdo->prepare($query);
  $data->bindParam(':phone', $phone);
  $data->execute();

  return count($data->fetchAll()) === 1;  
}

function isExistsItemsByEmail($pdo, $email) {  
  $query = 'SELECT id FROM items WHERE email=:email';
  $data = $pdo->prepare($query);
  $data->bindParam(':email', $email);
  $data->execute();

  return count($data->fetchAll()) === 1;  
}

function throwHttpError($code, $element, $message) {  
  header('HTTP/1.0 400 Bad Request');
  echo json_encode(array(
    'code' => $code,
    'element' => $element,
    'message' => $message
  ), JSON_UNESCAPED_UNICODE);  
}