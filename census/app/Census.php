<?php

namespace app\Census;

use PDO;

class Census
{
  private $dbh;

  public function __construct(PDO $dbh)
  {
    $this->dbh = $dbh;
  }

  public function updatePerson($name, $age, $id): void
  { 
    $stmt = $this->dbh->prepare("UPDATE `census` SET `name` = :name, `age` = :age WHERE `id` = :id ");
    $stmt->execute(['name' => $name,'age' => $age, 'id' => $id]);
  }

  public function destroyPerson($id): void
  {

    $stmt = $this->dbh->prepare("DELETE FROM `census` WHERE id=?");
    $stmt->execute([$id]);

  }

  public function setPerson($name, $age): void
  { 

    $stmt = $this->dbh->prepare("INSERT INTO `census` (`name`, `age`) VALUES (:namePerson, :agePerson)");
    $stmt->bindParam(':namePerson', $name);
    $stmt->bindParam(':agePerson', $age);

    $stmt->execute();

  }

  public function getList(): array
  {
    $result = $this->dbh->query("SELECT `id`, `name`, `age` from `census`");

    $arrResult = [];

    foreach($result as $row){
      $arrResult[] =  $row;
    }

    return $arrResult;
  }

  public function getStat(): array
  {
    $stmt =  $this->dbh->query("SELECT count(*) AS `count`, SUM(`age`) AS `age` FROM `census`");

    foreach($stmt as $row){
      $ageSum = $row['age'];
      $count = $row['count'];
    }

    return ['ageSum' => $ageSum, 'count' => $count];
  }


  public function getPerson($id)
  {
    $stmt = $this->dbh->prepare("SELECT `name`, `age` FROM `census` WHERE `id` = ?");
    $stmt->execute([$id]);
    foreach ($stmt as $row) {
      $array[] = $row;
    }

    return $array;
  }


}