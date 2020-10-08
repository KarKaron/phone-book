<?php
if(!\Auth\isLogged()) {
  header('Location: /');
  exit;
}
function route($data) {
  
  // POST /loading
  if ($data['method'] === 'POST' && count($data['urlData']) === 1 && $data['urlData'][0] === 'loading') {
    
    if(!empty($_FILES['file']['name'])) {
      $imageSize = $_FILES['file']['size'];
      $imageType = $_FILES['file']['type'];
      $imageFormat = explode(".", $_FILES['file']['name']);
      $imageFormat = array_pop($imageFormat);
      $imagePath = $_SERVER['DOCUMENT_ROOT'].'/images/items/';
      $imageName = rand(10000,99999).'.'.$imageFormat;
      $imageInfo = getimagesize($_FILES['file']['tmp_name']);
      if($imageType != 'image/jpeg' && $imageType != 'image/png') {
        \Config\throwHttpError('error', 'image', 'Изображения только jpg, jpeg или png');
        exit;
      } else if($imageSize > 5242880) {
        \Config\throwHttpError('error', 'image', 'Размер файла не должен превышать 5Мб');
        exit;
      } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $imagePath.$imageName);
      }
    } else {
      \Config\throwHttpError('error', 'image', 'Файл не загружен');
      exit;
    }
    echo json_encode(array(
      'image' => $imageName
    ), JSON_UNESCAPED_UNICODE);
  }
}