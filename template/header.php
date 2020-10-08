<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="<?=PATH?>index.css" rel="stylesheet" type="text/css">
<link type="image/x-icon" href="<?=PATH?>/images/favicon.ico" rel="icon">
<link type="image/x-icon" href="<?=PATH?>/images/favicon.ico" rel="shortcut icon">
<title>Телефонная книга</title>
</head>
<body>
  <header class="header">
<?php 
  if($_SESSION['auth']['id']) {
?>
    <nav class="navbar navbar-light navbar-expand-lg indigo fixed-top">
      <a class="navbar-brand" href="/">
        <img height="35px" src="<?=PATH?>images/logo.png" alt="Главная страница">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarToggler">
        <div class="btn btn-sm btn-primary mr-3 rounded" type="button">
          <i class="fas fa-user mr-2"></i><?=$_SESSION['auth']['email']?>
        </div>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
          <li class="nav-item my-2 my-lg-0">
            <a class="btn btn-sm btn-danger mr-3 rounded" type="button" href="<?=PATH?>api/auth/logout" title='Выйти из административной панели'>
              <i class="fas fa-sign-out-alt mr-2 text-white"></i>Выйти
            </a>
          </li>    
        </ul>
      </div>
    </nav>
<?php      
  }
?>
  </header>  