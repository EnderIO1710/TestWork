<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div id="mess"></div>
    <form class="row g-3" method="post" onsubmit="return false" id="feedback">
      <div class="col-md-6">
        <label for="name" class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>
      <div class="col-md-6">
        <label for="surname" class="form-label">Фамилия</label>
        <input type="text" class="form-control" name="surname" id="surname">
      </div>
      <div class="col-md-12">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email">
      </div>
      <div class="col-md-6">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" name="password" id="password">
      </div>
      <div class="col-md-6">
        <label for="password2" class="form-label">Повторите пароль</label>
        <input type="password" class="form-control" name="password2" id="password2">
      </div>
      <div class="col-12">
        <input type="submit" class="btn btn-primary" value="Зарегистрироваться" />
      </div>
    </form>
  </div>

  <script src="./jquery.js"></script>
  <script src="./script.js"></script>

  <script>

    $("document").ready(function() {

      $("#feedback").on("submit", function(){

        let dataForm = {
          "name": $("#name").val(),
          "surname": $("#surname").val(),
          "email": $("#email").val(),
          "password": $("#password").val(),
          "password2": $("#password2").val(),
        }

        let jsonStr = JSON.stringify(dataForm);

        $.ajax({
          url: './query.php',
          method: 'post',
          dataType: 'html',
          data: {"dataForm": jsonStr},
          success: function(data){
            result = JSON.parse(data);
            if(result.success)
            {
              $( "#feedback" ).replaceWith( '<h2>Успешная регистрация</h2>' );
            }else
            {
              switch(result.error)
              {
                case 'email':
                  $( "#mess" ).text( "Не верный email" );
                  break;
                case 'password2':
                  $( "#mess" ).text( "Пароли не совпадают или не заполнены" );
                  break;
                case 'user':
                  $( "#mess" ).text( "Пользователь с таким email уже существует" );
                  break;
              }
            }
          }
        });

      })
    })

  </script>
</body>
