<?php
  include_once("header.php");
?>   
  <main id="itemsMain" data-id="1">
    <div class="container-fluid">  
      <h1 class="my-3">Телефонная книга</h1>
      <div class="card mb-2">
        <div class="card-body">  
          <div class="alert alert-warning pb-0 pt-2 pr-2" role="alert">
            <h2 class="alert-heading text-left">Список записей 
              <button type="button" class="btn btn-success btn-sm addModal" data-toggle="modal" data-target="#myModal">
                <i class="fas fa-plus mr-2"></i>Добавить запись
              </button>
            </h2>
          </div>
          <div id="itemsBlock" class="container-fluid border rounded mb-0">
            <div class="row primary-color white-text py-3">
              <div class="col-md-1 d-md-block d-none">№</div>
              <div class="col-md-4 col-10">Имя / Фамилия</div>
              <div class="col-md-2 d-md-block d-none">Номер телефона</div>
              <div class="col-md-2 d-md-block d-none">Электронная почта</div>
              <div class="col-md-2 text-center d-md-block d-none">Изображение</div>
              <div class="col-md-1 col-2 text-center ">Ред.</div>
            </div>
            <div id="contentBlock"></div>
            <div id="errorBlock"></div>
          </div>
<?php
  if($pages_count > 1) {
    pagination($page_link,$page,$pages_count,$pages_search);  
  }
?>
        </div>  
      </div>
    </div>
  </main>  
<?php
  include_once("footer.php");
?>  