<?php

use app\Census\Census;

require_once './config/app.php';   //Подключение конфигов
require_once './app/Census.php';   //Подключение класса переписи
require_once './app/function.php'; //Доп функция

//Подключение к бд
$dbh = new PDO("mysql:host=$HOST;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
//Создание объекта класса для работы с переписью
$census = new Census($dbh);

$personsList = $census->getList();
$stat = $census->getStat();


if(isset($_GET['id']) && !empty($_GET['id']))
{//редактирование
  $person = $census->getPerson($_GET['id']);
  $form['age'] = $person[0]['age'];
  $form['name'] = $person[0]['name'];
  
  if(isset($_POST['name']) && !empty($_POST['name'] &&
     isset($_POST['age'])   && !empty($_POST['age'])))
  {

    $name = clean($_POST['name']);
    $age = clean($_POST['age']);
    $id = clean($_GET['id']);
    
    $census->updatePerson($name, $age, $id);

    header('Location:'.getUrlDomain());
  }

}elseif(isset($_GET['del']) && !empty($_GET['del']))
{//удаление
  $id = clean($_GET['del']);
  
  $census->destroyPerson($id);

  header('Location:'.getUrlDomain());

}else
{//добавление

  if(isset($_POST['name']) && !empty($_POST['name'] &&
   isset($_POST['age'])   && !empty($_POST['age'])))
  {

    $name = clean($_POST['name']);
    $age = clean($_POST['age']);
    
    $census->setPerson($name, $age);

    header('Location:'.getUrlDomain());
  }
  
}


//!Подключение шаблона
require_once './views/census.view.php';