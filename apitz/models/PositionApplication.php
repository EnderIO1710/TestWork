<?php

namespace models;

use PDO;

class PositionApplication
{
  private $dbh, $data;

  public function __construct($HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD)
  {
    $this->dbh = new PDO("mysql:host=$HOST;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
  }

  public function saveData(string $responce, $date): void
  {
    $this->data = $this->preparingData($responce);

    if($this->recordExist($date))
    {
      foreach($this->data as $key => $value)
      {
        $stmt = $this->dbh->prepare("INSERT INTO `position_app` (`date`, `category`, `position`) VALUES (:thisdate, :category, :positionApp)");
        $stmt->bindParam(':thisdate', $date);
        $stmt->bindParam(':category', $key);
        $stmt->bindParam(':positionApp', $value);
    
        $stmt->execute();
      }
    }
  }

  public function getResonce(): string
  {
    $result = [
      'status_code' => 200,
      'message' => 'OK',
      'data' => $this->data,
    ];
   
    return json_encode($result);
  }

  private function preparingData(string $responce): array
  {
    $responce = json_decode($responce, true);

    $result = [];
    foreach($responce['data'] as $key => $value)
    {
      $arrAllValue = [];
      foreach($value as $val){
        $arrAllValue[] = $val[$_GET['date']];
      }
      $result[$key] = min($arrAllValue);
    }
    
    return $result;
  }


  private function recordExist(string $date): bool
  {
    $stmt = $this->dbh->prepare("SELECT * FROM `position_app` WHERE `date` = ?");
    $stmt->execute([$date]);
    foreach ($stmt as $row) {
      $array[] = $row;
    }

    return empty($array);
  }


}