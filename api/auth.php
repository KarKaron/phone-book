<?php
namespace Auth;
 
function isLogged() {
  return isset($_SESSION['auth']['id']) && $_SESSION['auth']['id'] != '';
}

// Логин пользователя
function login($user, $email, $password) {
  $pdo = \Config\connectDB();
  $query = 'SELECT id, email, hash from users WHERE login=:user';
  $data = $pdo->prepare($query);
  $data->bindParam(':user', $user);
  $data->execute();
  $item = $data->fetch();

  if (password_verify($password, $item['hash']) && $email === $item['email']) {
    $_SESSION['auth']['id'] = $item['id'];
    $_SESSION['auth']['email'] = $item['email'];

    return array(
      'code' => 'success'
    );
  } else {
    return array(
      'code' => 'error',
      'message' => 'Неверные данные для входа'
    );
  }
}

// Разлогин
function logout() {
  unset($_SESSION['auth']);
  session_destroy();
}
?>