<?php
  include_once("header.php");
?>   
  <main>
    <div class="container d-flex justify-content-center align-items-center" style="height: 80vh">  
      <div class="card">
        <h5 class="card-header info-color white-text text-center py-4 mb-3 authTitle">
          Войдите чтобы начать
        </h5>
        <div class="card-body px-lg-5 pt-0">
          <form id="authForm" class="text-center" style="color: #757575;">
            <div class="mb-2">
              <label for="user">Логин <span class="text-danger">*</span></label>
              <input type="text" id="user" name="user" minlength="6" maxlength="16" class="form-control">
            </div>
            <div class="mb-2">
              <label for="password">Пароль <span class="text-danger">*</span></label>
              <input type="password" id="password" name="password" minlength="6" maxlength="16" class="form-control">
            </div>
            <div class="mb-2">
              <label for="email">Электронная почта <span class="text-danger">*</span></label>
              <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="d-flex justify-content-around">
              <div class="alert alert-danger d-none authError">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span>Ошибка! Данные заполнены неверно!</span>
              </div>  
            </div>
            <div class="d-flex justify-content-around">
              <div class="alert alert-success d-none authSuccess">
                <i class="fas fa-check mr-2"></i>
                <span>Регистрация успешно завершена! Используйте данные для входа</span>
              </div>  
            </div>
            <button id="loginSubmit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0 authSubmit" type="submit">Войти</button>
            <p>
              <span id="authText">Не зарегистрированы?</span>
              <a id="linkReg" class="authChange" href="">Регистрация</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </main>  
<?php
  include_once("footer.php");
?>  