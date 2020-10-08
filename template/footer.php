  <footer id="footer">&nbsp;</footer>
<?php 
  if($_SESSION['auth']['id']) {
?>
  <div class="modal fade myModal" id="myModal" tabindex="-1" role="dialog"
  aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog cascading-modal" role="document">
      <div class="modal-content">
        <div id="modalHeader" class="modal-header success-color white-text">
          <h4 class="title">
            <i class="fa fa-pencil-alt mr-3"></i>
            <span id="modalTitle">Добавить запись</span>
          </h4>
          <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addFormItems" class="modalForm" enctype="multipart/form-data">
            <label for="firstName">Имя <span class="text-danger">*</span></label>
            <input type="text" id="firstName" name="first_name" class="form-control form-control-sm" required>
            <br>
            <label for="lastName">Фамилия <span class="text-danger">*</span></label>
            <input type="text" id="lastName" name="last_name" class="form-control form-control-sm" required>
            <br>
            <label for="phone">Телефон <span class="text-danger">*</span></label>
            <input type="tel" id="phone" name="phone" class="form-control form-control-sm" required>
            <br>
            <label for="email">Электронная почта <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control form-control-sm" required>
            <div class="row d-flex align-items-center mt-4">
              <div class="col-3 text-center">
                <img style="max-width: 100px;" id="imagePrev" src="" alt="Картинка">
              </div>
              <div class="col-9">
                <div class="custom-file imageBlock">
                  <input type="file" class="custom-file-input" id="image" name="file">
                  <label class="custom-file-label" for="image" id="imageName" data-browse="Обзор">Выберите файл</label>
                  <input type="hidden" id="imageNew" name="imageNew">
                </div>
              </div>
            </div>
            <div class="my-2">
              <span class="text-danger">*</span> - поля обязательные для заполнения
            </div>
            <div class="alert alert-danger d-none modalError">
              <i class="fas fa-exclamation-triangle mr-2"></i>
              <span>Ошибка! Данные заполнены неверно!</span>
            </div>
            <div class="text-center mt-4 mb-2">
              <button type="submit" class="btn btn-success" id="btnAddItem">Сохранить</button>
              <button type="submit" class="btn btn-info" id="btnSaveItem">Сохранить</button>
              <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Отмена</a>
            </div>
          </form>
          <div id="loader" class="text-center d-none">
            <div id="alertAddSuccess" class="text-center d-none alertSuccess">
              <i class="fas fa-check fa-4x my-3 animated rotateIn text-success"></i>
              <div class="alert alert-success my-3">Запись успешно добавлена!</div>
            </div>
            <div id="alertEditSuccess" class="text-center d-none alertSuccess">
              <i class="fas fa-check fa-4x my-3 animated rotateIn text-info"></i>
              <div class="alert alert-info my-3">Запись успешно изменена!</div>
            </div>
            <h2 class="text-primary my-5 d-none">Подождите идёт загрузка!</h2>
            <div class="preloader-wrapper big">
              <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div>
                <div class="gap-patch">
                  <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
            <div class="text-center alertDismiss d-none">
              <button class="btn btn-outline-primary waves-effect" data-dismiss="modal">Закрыть</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="itemDelete" tabindex="-1" role="dialog" aria-labelledby="Удалить запись"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
      <div class="modal-content text-center">
        <div class="modal-header d-flex justify-content-center">
          <p class="heading">Желаете удалить запись?</p>
        </div>
        <div class="modal-body">
          <i class="fas fa-times fa-4x animated rotateIn"></i>
        </div>
        <div class="alert alert-danger d-none modalError">
          <i class="fas fa-exclamation-triangle mr-2"></i>
          <span>Ошибка! Данные заполнены неверно!</span>
        </div>
        <div id="alertDeleteSuccess" class="text-center my-3 d-none">
          <i class="fas fa-check fa-4x my-3 animated rotateIn text-success"></i>
          <div class="alert alert-success my-3">Запись успешно удалена!</div>
        </div>
        <div class="modal-footer flex-center">
          <button class="btn btn-outline-danger" id="deleteItem" data-delete="">Да</button>
          <button class="btn btn-danger waves-effect" id="deleteClose" data-dismiss="modal">Нет</button>
        </div>
      </div>
    </div>
  </div>
<?php      
  }
?>
  <script type="text/javascript" src="<?=PATH?>js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="<?=PATH?>js/popper.min.js"></script>
  <script type="text/javascript" src="<?=PATH?>js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?=PATH?>js/mdb.min.js"></script>
  <script type="text/javascript" src="<?=PATH?>js/myscript.js"></script>
</body>
</html>