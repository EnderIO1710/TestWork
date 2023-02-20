<?php
//Типа контроллер

use models\PositionApplication;

//инициализация приложения
require_once __DIR__ . '/models/PositionApplication.php';
require_once __DIR__ . '/config/app.php';

$PositionApplication = new PositionApplication($HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD);

//валидация запроса
if(
  !isset($_GET['date']) ||
  empty($_GET['date'])  ||
  !preg_match("/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/", $_GET['date'])
  )
{
  require_once __DIR__ . '/views/error.php';
  exit();
}

$date = strtotime($_GET['date']);

//проверка на разницу в 30 дней
if($date > time() || $date < (time() - 60*60*24*30))
{
  require_once __DIR__ . '/views/error.php';
  exit();
}

//делаем api запрос по текущей дате
$responce = file_get_contents("https://api.apptica.com/package/top_history/1421444/1?date_from={$_GET['date']}&date_to={$_GET['date']}&B4NKGg=fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l");

$PositionApplication->saveData($responce, $_GET['date']);
echo $PositionApplication->getResonce();

