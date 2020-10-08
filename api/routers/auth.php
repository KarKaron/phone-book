<?php
function route($data) {
  
  // POST /auth/login
  if ($data['method'] === 'POST' && count($data['urlData']) === 2 && $data['urlData'][1] === 'login') {
    if (isset($data['formData']['user'])) {
      $user = \Config\clear($data['formData']['user']);
      if(empty($user)) {
        \Config\throwHttpError('error', 'user', 'Заполните обязательное поле: Login');
        exit;
      }
    }
    if (isset($data['formData']['password'])) {
      $password = $data['formData']['password'];
      if(empty($password)) {
        \Config\throwHttpError('error', 'password', 'Заполните обязательное поле: Password');
        exit;
      }
    }
    if (isset($data['formData']['email'])) {
      $email = \Config\clear($data['formData']['email']);
      if(empty($email)) {
        \Config\throwHttpError('error', 'email', 'Заполните обязательное поле: Электронная почта');
        exit;
      }
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        \Config\throwHttpError('error', 'email', 'Неправильный формат поля: Электронная почта');
        exit;
      }
    }

    $auth = \Auth\login($user, $email, $password);
    if ($auth['code'] !== 'success') {
      header('HTTP/1.0 401 Unauthorized');
    }
    echo json_encode($auth);
    exit;
  }

  // GET /auth/logout
  if ($data['method'] === 'GET' && count($data['urlData']) === 2 && $data['urlData'][1] === 'logout') {
    \Auth\logout();
    header('Location: /');
    exit;
  }

  // Если ни один роутер не отработал
  \Config\throwHttpError('error', '', 'Неправильный формат запроса!');
}
?>