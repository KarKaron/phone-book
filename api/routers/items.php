<?php
if(!\Auth\isLogged()) {
  header('Location: /');
  exit;
}
function route($data) {
  
  // GET /items
  if ($data['method'] === 'GET' && count($data['urlData']) === 1) {
    $options = $data['formData'];

    echo json_encode(getItems($options), JSON_UNESCAPED_UNICODE);
    exit;
  }

  // GET /items/item
  if ($data['method'] === 'GET' && count($data['urlData']) === 2) {
    $id = (int)$data['urlData'][1];

    echo json_encode(getItemsById($id), JSON_UNESCAPED_UNICODE);
    exit;
  }

  // POST /items
  if ($data['method'] === 'POST' && count($data['urlData']) === 1) {
    if (isset($data['formData']['first_name'])) {
      $first_name = \Config\clear($data['formData']['first_name']);
      if(empty($first_name)) {
        \Config\throwHttpError('error', 'firstName', 'Заполните обязательное поле: Имя');
        exit;
      }
    }
    if (isset($data['formData']['last_name'])) {
      $last_name = \Config\clear($data['formData']['last_name']);
      if(empty($last_name)) {
        \Config\throwHttpError('error', 'lastName', 'Заполните обязательное поле: Фамилия');
        exit;
      }
    }
    if (isset($data['formData']['phone'])) {
      $phone = \Config\clear($data['formData']['phone']);
      if(empty($phone)) {
        \Config\throwHttpError('error', 'phone', 'Заполните обязательное поле: Телефон');
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

    if(isset($data['formData']['image'])) {
      $image = \Config\clear($data['formData']['image']);
    } else {
      $image = '';
    }
    
    echo json_encode(addItems($first_name, $last_name, $phone, $email, $image), JSON_UNESCAPED_UNICODE);
    exit;
  }

  // PUT /items/item
  if ($data['method'] === 'PUT' && count($data['urlData']) === 2) {
    $id = (int)$data['urlData'][1];
    if (isset($data['formData']['first_name'])) {
      $first_name = \Config\clear($data['formData']['first_name']);
      if(empty($first_name)) {
        \Config\throwHttpError('error', 'firstName', 'Заполните обязательное поле: Имя');
        exit;
      }
    }
    if (isset($data['formData']['last_name'])) {
      $last_name = \Config\clear($data['formData']['last_name']);
      if(empty($last_name)) {
        \Config\throwHttpError('error', 'lastName', 'Заполните обязательное поле: Фамилия');
        exit;
      }
    }
    if (isset($data['formData']['phone'])) {
      $phone = \Config\clear($data['formData']['phone']);
      if(empty($phone)) {
        \Config\throwHttpError('error', 'phone', 'Заполните обязательное поле: Телефон');
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

    if(isset($data['formData']['image'])) {
      $image = \Config\clear($data['formData']['image']);
    } else {
      $image = '';
    }

    echo json_encode(updateItems($id, $first_name, $last_name, $email, $phone, $image), JSON_UNESCAPED_UNICODE);
    exit;
  }

  // DELETE /items/item
  if ($data['method'] === 'DELETE' && count($data['urlData']) === 2) {
    $id = (int)$data['urlData'][1];

    echo json_encode(deleteItems($id));
    exit;
  }

  // Если ни один роутер не отработал
  \Config\throwHttpError('error', '', 'Неправильный формат запроса!');
}

// Возвращаем все записи
function getItems($options) {
  $pdo = \Config\connectDB();
  $meta = array();
  $query = 'SELECT id, first_name, last_name, phone, email, image FROM items WHERE user=:user ORDER BY first_name';

  // Пагинация
  if (isset($options['start']) && abs((int)$options['start']) && isset($options['limit']) && abs((int)$options['limit'])) {
    $query .= ' LIMIT :start, :limit';
    $meta['start'] = $options['start'];
    $meta['limit'] = $options['limit'];
  }

  $data = $pdo->prepare($query);
  $data->bindValue(':user', $_SESSION['auth']['id'], PDO::PARAM_INT);
  foreach ($meta as $key => $value) {
    $data->bindValue(':' . $key, $value, PDO::PARAM_INT);
  }
  $data->execute();

  return array(
    'meta' => $meta,
    'records' => __::map($data->fetchAll(), function($item) {
      return array(
        'id' => (int)$item['id'],
        'firstName' => $item['first_name'],
        'lastName' => $item['last_name'],
        'phone' => $item['phone'],
        'email' => $item['email'],
        'image' => $item['image']
      );
    })
  );
}


// Возвращаем информацию по одной записи
function getItemsById($id) {
  $pdo = \Config\connectDB();

  // Если запись не существует, то выбрасываем ошибку
  if (!\Config\isExistsItemsById($pdo, $id)) {
    \Config\throwHttpError('error', '' ,'Запись не существует');
    exit;
  }

  $query = 'SELECT id, first_name, last_name, phone, email, image FROM items WHERE id=:id AND user=:user';
  $data = $pdo->prepare($query);
  $data->bindParam(':id', $id, PDO::PARAM_INT);
  $data->bindParam(':user', $_SESSION['auth']['id'], PDO::PARAM_INT);
  $data->execute();

  $item = $data->fetch();
  return array(
    'id' => $id,
    'firstName' => $item['first_name'],
    'lastName' => $item['last_name'],
    'phone' => $item['phone'],
    'email' => $item['email'],
    'image' => $item['image']
  );
}


// Добавление записи
function addItems($first_name, $last_name, $phone, $email, $image) {
  $pdo = \Config\connectDB();

  // Если телефон существует, то выбрасываем ошибку
  if (\Config\isExistsItemsByPhone($pdo, $phone)) {
    \Config\throwHttpError('error', 'phone', 'Запись с таким номером телефона уже существует!');
    exit;
  }
  
  // Если почта существует, то выбрасываем ошибку
  if (\Config\isExistsItemsByEmail($pdo, $email)) {
    \Config\throwHttpError('error', 'email', 'Запись с таким названием почтового ящика уже существует!');
    exit;
  }

  // Добавляем запись в базу
  $query = 'INSERT INTO items (first_name, last_name, phone, email, image, user) values (:first_name, :last_name, :phone, :email, :image, :user)';
  $data = $pdo->prepare($query);
  $data->bindParam(':first_name', $first_name);
  $data->bindParam(':last_name', $last_name);
  $data->bindParam(':phone', $phone);
  $data->bindParam(':email', $email);
  $data->bindParam(':image', $image);
  $data->bindParam(':user', $_SESSION['auth']['id'], PDO::PARAM_INT);
  $data->execute();

  // Новый айдишник для добавленной записи
  $newId = (int)$pdo->lastInsertId();
  return getItems($newId);
}


// Обновление записи
function updateItems($id, $first_name, $last_name, $email, $phone, $image) {
  $pdo = \Config\connectDB();

  // Если запись не существует, то выбрасываем ошибку
  if (!\Config\isExistsItemsById($pdo, $id)) {
    \Config\throwHttpError('error', '' ,'Запись не существует');
    exit;
  }

  $query = 'UPDATE items SET first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, image=:image WHERE id=:id AND user=:user';
  $data = $pdo->prepare($query);
  $data->bindParam(':id', $id, PDO::PARAM_INT);
  $data->bindParam(':user', $_SESSION['auth']['id'], PDO::PARAM_INT);
  $data->bindParam(':first_name', $first_name);
  $data->bindParam(':last_name', $last_name);
  $data->bindParam(':email', $email);
  $data->bindParam(':phone', $phone);
  $data->bindParam(':image', $image);
  $data->execute();

  return getItems($id);
}


// Удаление записи
function deleteItems($id) {
  $pdo = \Config\connectDB();

  // Если запись не существует, то выбрасываем ошибку
  if (!\Config\isExistsItemsById($pdo, $id)) {
    \Config\throwHttpError('error', '' ,'Запись не существует');
    exit;
  }

  // Удаляем запись из базы
  $query = 'DELETE FROM items WHERE id=:id AND user=:user';
  $data = $pdo->prepare($query);
  $data->bindParam(':id', $id, PDO::PARAM_INT);
  $data->bindParam(':user', $_SESSION['auth']['id'], PDO::PARAM_INT);
  $data->execute();

  return array(
    'id' => $id
  );
}
