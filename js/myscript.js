$(function() {
  "use strict";
  
  var config = {
    api: {
      login: '/api/auth/login',
      reg: '/api/registration',
      items: '/api/items',
      loading: '/api/loading'
    }
  };
  
  $(document).on('click', '#linkReg', function(e) {
    e.preventDefault();
    $('#authForm input').removeClass('is-invalid').val('');
    $('.authError').addClass('d-none');
    $('.authTitle').text('Регистрация');
    $('.authSubmit').attr('id', 'regSubmit').text('Зарегистрироваться');
    $('#authText').text('Уже зарегистрированы?');
    $('.authChange').attr('id', 'linkLogin').text('Войти');
  });

  $(document).on('click', '#linkLogin', function(e) {
    e.preventDefault();
    document.location.reload();
  });
  
  $(document).on('click','#loginSubmit', function(e) {
    e.preventDefault();
    var formData = {
      user: $('#user').val(),
      email: $('#email').val(),
      password: $('#password').val(),
    };
    $.ajax({
      url: config.api.login,
      type: 'POST',
      data: formData,
      success: function() {
        document.location.reload();
      },
      error: function(xhr) {
        var err = JSON.parse(xhr.responseText);
        $('.authError').removeClass('d-none');
        $('.authError span').text(err.message);
        $('#authForm input').removeClass('is-invalid');
        $('#'+err.element).addClass('is-invalid');
        setTimeout(function() {
          $('.authError').addClass('d-none');
        }, 5000);
      }
    });
  });
  
  $(document).on('click', '#regSubmit', function(e) {
    e.preventDefault();
    var formData = {
      user: $('#user').val(),
      email: $('#email').val(),
      password: $('#password').val(),
    };
    $.ajax({
      url: config.api.reg,
      type: 'POST',
      data: formData,
      success: function() {
        $('#authForm input').removeClass('is-invalid');
        $('.authError, .authSubmit').addClass('d-none');
        $('.authSuccess').removeClass('d-none');
        setTimeout(function() {
          $('.authSuccess').addClass('d-none');
          document.location.reload();
        }, 3000);
      },
      error: function(xhr) {
        var err = JSON.parse(xhr.responseText);
        $('.authError').removeClass('d-none');
        $('.authError span').text(err.message);
        $('#authForm input').removeClass('is-invalid');
        $('#'+err.element).addClass('is-invalid');
        setTimeout(function() {
          $('.authError').addClass('d-none');
        }, 5000);
      }
    });
  });

  
  function getItems(urlItems) {
    $('#contentBlock').text('');
    var seacrhItems = document.location.search;
    if (seacrhItems) {
      urlItems = urlItems+seacrhItems;
    }  
    $.getJSON(urlItems, function(data) {
      if(data.records.length > 0) {
        var key = 1;
        data.records.map(function(item) {
          var itemImg = '';
          if (item.image) {
            itemImg = '<i class="fas fa-check text-secondary"></i>';
          }
          $('#contentBlock').append(
            '<div class="row view overlay py-2 border d-flex align-items-center pointer">' +
            ' <div class="col-md-1 d-md-block d-none">'+key+'</div>' +
            ' <div class="col-md-4 col-10 blockName">'+item.firstName+' '+item.lastName+'</div>'+
            ' <div class="col-md-2 d-md-block d-none">'+item.phone+'</div>' +
            ' <div class="col-md-2 d-md-block d-none">'+item.email+'</div>' +
            ' <div class="col-md-2 text-center d-md-block d-none">'+itemImg+'</div>' +
            ' <div class="col-md-1 col-2 text-center editItem">' +
            '   <i class="fas fa-edit text-success pointer editModal mr-3" data-key="'+item.id+'" data-toggle="modal" data-target="#myModal"></i><i class="fas fa-times text-danger pointer deleteModal" data-delete="'+item.id+'" data-toggle="modal" data-target="#itemDelete"></i>' +
            ' </div>' + 
            '</div>'
          );
          key++;  
        });
      } else {
        $('#errorBlock').html(
        '<div class="alert alert-secondary alert-dismissible fade show p-3 mt-3" role="alert">' +
        ' <i class="fas fa-radiation mr-2"></i>Записей не найдено!' +
        ' <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +    
        ' <span aria-hidden="true">&times;</span></button>' +
        '</div>');
      }
    });
  }
  
  var main = parseInt($('#itemsMain').attr('data-id'));
  if(main === 1) {
    getItems(config.api.items);
  }
  
  $(document).on('click', '.addModal', function() {
    $('#modalHeader').removeClass('info-color').addClass('success-color');
    $('#modalTitle').text('Добавить запись');
    $('.modalForm').attr('id', 'addFormItems');
    $('#btnAddItem').removeClass('d-none');
    $('#btnSaveItem').addClass('d-none');
    $('.modalForm').trigger("reset");
    $('.modalForm input').removeClass('is-invalid');
    $('#imageName').text('Выберите файл');
    $('#imageNew').val('');
  });

  $(document).on('click', '.editModal', function() {
    var itemId = $(this).attr('data-key');
    var urlItemsById = config.api.items+"/"+itemId;
    $('#modalHeader').removeClass('success-color').addClass('info-color');
    $('#modalTitle').text('Редактировать запись');
    $('.modalForm').attr('id', 'saveFormItems');
    $('#btnAddItem').addClass('d-none');
    $('#btnSaveItem').removeClass('d-none');
    $('.modalForm input').removeClass('is-invalid');
    $('#imageNew').val('');
    $.getJSON(urlItemsById, function(data) {
      $('#btnSaveItem').attr("data-id",itemId);
      $('#firstName').val(data.firstName);
      $('#lastName').val(data.lastName);
      $('#phone').val(data.phone);
      $('#email').val(data.email);
      $('#imagePrev').attr('src', '/images/items/'+data.image);
      $('#imageName').text('Выберите файл');
    });
  });
  
  $(document).on('click', '.deleteModal', function() {
    var itemId = $(this).attr('data-delete');
    $('#deleteItem').attr('data-delete', itemId);
  });
  
  $(document).on('change', '#image', function() {
    var formData = new FormData();
    var fileData = $('#image').prop('files')[0];
    formData.append('file', fileData);
    $.ajax({
      url: config.api.loading,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: 'POST',
      success: function(xhr){
        var res = JSON.parse(xhr);
        $('#imageNew').val(res.image);
      },
      error: function(xhr) {
        var err = JSON.parse(xhr.responseText);
        $('.modalError').removeClass('d-none');
        $('.modalError span').text(err.message);
        $('#'+err.element).addClass('is-invalid');
        setTimeout(function() {
          $('.modalError').addClass('d-none');
        }, 5000);
      }
    });
  });

  $(document).on('click', '#btnAddItem', function(e) {
    $('.modalForm input').removeClass('is-invalid');
    e.preventDefault();
    var formData = {
      first_name: $('#firstName').val(),
      last_name: $('#lastName').val(),
      phone: $('#phone').val(),
      email: $('#email').val(),
      image: $('#imageNew').val()
    };
    console.log(formData);
    $.ajax({
      url: config.api.items,
      type: "POST",
      data: formData,
      success: function() {
        $('#myModal .modalForm').addClass('d-none');
        $('#myModal #loader').removeClass('d-none').css('height', '300px');
        $('#myModal #loader h2').removeClass('d-none');    
        $('#myModal #loader .preloader-wrapper').addClass('active');
        setTimeout(function() {
          $('#myModal #loader h2').addClass('d-none');    
          $('#myModal #loader .preloader-wrapper').removeClass('active');
          $('#alertAddSuccess, .alertDismiss').removeClass('d-none');
        }, 1500);            
      },
      error: function(xhr) {
        var err = JSON.parse(xhr.responseText);
        $('.modalError').removeClass('d-none');
        $('.modalError span').text(err.message);
        $('#'+err.element).addClass('is-invalid');
        setTimeout(function() {
          $('.modalError').addClass('d-none');
        }, 5000);
      }
    });
  }); 
  
  $('#btnSaveItem').on('click', function(e) {
    $('.modalForm input').removeClass('is-invalid');
    e.preventDefault();
    var itemId = $(this).attr('data-id');
    var formData = {
      first_name: $('#firstName').val(),
      last_name: $('#lastName').val(),
      phone: $('#phone').val(),
      email: $('#email').val(),      
      image: $('#imageNew').val()
    };
    $.ajax({
      url: config.api.items+"/"+itemId,
      type: "PUT",
      data: formData,
      success: function() {
        $('#myModal .modalForm').addClass('d-none');
        $('#myModal #loader').removeClass('d-none').css('height', '300px');
        $('#myModal #loader h2').removeClass('d-none');    
        $('#myModal #loader .preloader-wrapper').addClass('active');
        setTimeout(function() {
          $('#myModal #loader h2').addClass('d-none');    
          $('#myModal #loader .preloader-wrapper').removeClass('active');
          $('#alertEditSuccess, .alertDismiss').removeClass('d-none');
        }, 1500);    
      },
      error: function(xhr) {
        var err = JSON.parse(xhr.responseText);
        $('.modalError').removeClass('d-none');
        $('.modalError span').text(err.message);
        $('#'+err.element).addClass('is-invalid');
        setTimeout(function() {
          $('.modalError').addClass('d-none');
        }, 5000);
      }
    });
  });

  $(".myModal").on('hidden.bs.modal', function() {
    $('#myModal #loader').addClass('d-none').css('height', '');
    $('.alertSuccess, .alertDismiss').addClass('d-none');
    $('#myModal .modalForm').removeClass('d-none');
    getItems(config.api.items);
  });
  
  $('#deleteItem').on('click', function() {
    var itemId = $(this).attr('data-delete');
    $.ajax({
      url: config.api.items+"/"+itemId,
      type: "DELETE",
      success: function() {
        $('#itemDelete #deleteItem, #itemDelete .modal-body').addClass('d-none');
        $('#deleteClose').text('Закрыть');
        $('#alertDeleteSuccess').removeClass('d-none');
      },
      error: function(xhr) {
        var err = JSON.parse(xhr.responseText);
        $('.modalError').removeClass('d-none');
        $('.modalError span').text(err.message);
        setTimeout(function() {
          $('.modalError').addClass('d-none');
        }, 5000);
      }
    });
  });
  
  $("#itemDelete").on('hidden.bs.modal', function() {
    $('#alertDeleteSuccess').addClass('d-none');
    $('#deleteClose').text('Нет');
    $('#itemDelete #deleteItem, #itemDelete .modal-body').removeClass('d-none');
    getItems(config.api.items);
  });
});