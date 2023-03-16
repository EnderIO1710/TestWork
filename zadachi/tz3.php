<?php

//Задание 3

class Group
{
  private $dbh;

  public function __construct($HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD)
  {
    $this->dbh = new PDO("mysql:host=$HOST;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
  }

  private function fill(): void
  {
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $arrResult = [
      'normal',
      'illegal',
      'failed',
      'success',
    ];

    $string = '';

    for ($i = 1; $i < 25; $i++) {
      $string .= substr($str, rand(1, strlen($str)) - 1, 1);
    }
    
    $stmt = $this->dbh->prepare("INSERT INTO `tests` (`script_name`, `start_time`, `end_time`, `result`) VALUES (:script_name, :start_time, :end_time, :result)");
    $stmt->bindParam(':script_name', $string);
    $stmt->bindParam(':start_time', rand());
    $stmt->bindParam(':end_time', rand());
    $stmt->bindParam(':result', $arrResult[array_rand($arrResult, 1)]);

    $stmt->execute();
  }

  public function get()
  {
    $sth = $this->dbh->prepare("SELECT * FROM `tests` WHERE `result` = ? OR `result` = ?");
    $sth->execute(array('success', 'normal'));
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $array;
  }
}

//Конфигурация подключения к бд
$HOST = '127.0.0.1:3306';
$DB_NAME = 'test';
$DB_USERNAME = 'root';
$DB_PASSWORD = '';

$obj = new Group($HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD);
echo '<pre>';
var_dump($obj->get());