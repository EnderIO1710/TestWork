<?php

$users = [
  ['id' => 1, 'name' => 'Костя', 'email' => 'kostya@gmail.com',],
  ['id' => 2, 'name' => 'Петя', 'email' => 'Petr@mail.ru',],
  ['id' => 3, 'name' => 'Вася', 'email' => 'Vasya@yandex.ru',],
  ['id' => 4, 'name' => 'Маша', 'email' => 'Maria@mail.ru',],
];


if(isset($_POST['dataForm']) && !empty($_POST['dataForm']))
{
  $jsonData = json_decode($_POST['dataForm'], true);

  if(!filter_var($jsonData['email'], FILTER_VALIDATE_EMAIL))
  {
    $log = date('Y-m-d H:i:s') . ' Ошшибка регистрации. Неверный email. ';
    file_put_contents(__DIR__ . '/log.log', $log . PHP_EOL, FILE_APPEND);
    echo json_encode(['error' => 'email']);


    exit;
  }

  if($jsonData['password'] != $jsonData['password2'] || empty($jsonData['password']))
  {
    $log = date('Y-m-d H:i:s') . ' Ошшибка регистрации. Пароли не совпадают или незаполнены. ';
    file_put_contents(__DIR__ . '/log.log', $log . PHP_EOL, FILE_APPEND);
    echo json_encode(['error' => 'password2']);


    exit;
  }

  foreach($users as $val)
  {
    if($jsonData['email'] == $val['email'])
    {
      $log = date('Y-m-d H:i:s') . ' Ошшибка регистрации. Данный email уже зарегестрирован. ';
      file_put_contents(__DIR__ . '/log.log', $log . PHP_EOL, FILE_APPEND);
      echo json_encode(['error' => 'user']);

      exit;
    }
  }

  $log = date('Y-m-d H:i:s') . ' Успешная регистрация пользователя: '. "Имя: {$jsonData['name']} Фамилия: {$jsonData['surname']} Email: {$jsonData['email']} ";
  file_put_contents(__DIR__ . '/log.log', $log . PHP_EOL, FILE_APPEND);
  echo json_encode(['success' => true]);

}