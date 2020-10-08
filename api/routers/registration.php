<?php
function route($data) {
  
  // POST /registration
  if ($data['method'] === 'POST' && count($data['urlData']) === 1 && $data['urlData'][0] === 'registration') {
    if (isset($data['formData']['user'])) {
      $user = \Config\clear($data['formData']['user']);
      if(empty($user)) {
        \Config\throwHttpError('error', 'user', 'Заполните обязательное поле: Login');
        exit;
      }
      if(!preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{6,16}$/', $user)) {
        \Config\throwHttpError('error', 'user', 'Login: латиница - буквы верхнего и нижнего регистра, цифры, от 6 до 16 символов');
        exit;
      }
    }
    if (isset($data['formData']['password'])) {
      $password = $data['formData']['password'];
      if(empty($password)) {
        \Config\throwHttpError('error', 'password', 'Заполните обязательное поле: Password');
        exit;
      }
      if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,16}$/', $password)) {
        \Config\throwHttpError('error', 'password', 'Password: латиница - буквы верхнего и нижнего регистра, цифры, от 6 до 16 символов');
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

    echo json_encode(addUsers($user, $password, $email), JSON_UNESCAPED_UNICODE);
    exit;
  }

  // Если роутер не отработал
  \Config\throwHttpError('error', '', 'Неправильный формат запроса!');
}

// Добавление записи
function addUsers($user, $password, $email) {
  $pdo = \Config\connectDB();

  // Если логин существует, то выбрасываем ошибку
  if (\Config\isExistsUsersByLogin($pdo, $user)) {
    \Config\throwHttpError('error', 'user', 'Такой логин уже существует!');
    exit;
  }
  
  // Если почта существует, то выбрасываем ошибку
  if (\Config\isExistsUsersByEmail($pdo, $email)) {
    \Config\throwHttpError('error', 'email', 'Запись с таким названием почтового ящика уже существует!');
    exit;
  }
  
  $hash = password_hash($password, PASSWORD_DEFAULT);

  // Добавляем запись в базу
  $query = 'INSERT INTO users (login, hash, email) values (:user, :hash, :email)';
  $data = $pdo->prepare($query);
  $data->bindParam(':user', $user);
  $data->bindParam(':hash', $hash);
  $data->bindParam(':email', $email);
  $data->execute();

  // Новый айдишник для добавленной записи
  $newId = (int)$pdo->lastInsertId();
  return array(
    'id' => $newId
  );
}