<?php

class DbManager {

  private $dbConnection;
  private string $webHookUrl;
  private bool $useCallback;

  function __construct() {

    $this->dbConnection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
  }

  function __destruct() {

    $this->dbConnection = null;
  }

  public function setWebHookUrl(string $url) {
    $this->webHookUrl = $url;
  }

  public function setCallback(bool $callback) {
    $this->useCallback = $callback;
  }

  public function writeObject(object $object) {

    $tableName = $object->getTableName();

    $columns = array();
    $values = array();

    foreach ($object as $key => $value) {
      $columns[] = "`$key`";
      $values[] = "'$value'";
    }

    $columns = implode(', ', $columns);
    $values = implode(', ', $values);


    $sql = "REPLACE INTO $tableName ($columns) VALUES ($values);";

    $this->dbConnection->exec($sql);
  }


  public function updateObject(object $object, array $replaceColumns) {

    $tableName = $object->getTableName();

    $update = array();
    $replace = array();

    foreach ($object as $key => $value) {

      $update[] = "`$key` = '$value'";
    }
    $update = 'SET ' . implode(', ', $update);

    foreach ($replaceColumns as $replaceColumn) {

      $replace[] = "`$replaceColumn` = '" . $object->$replaceColumn . "' ";
    }
    $where = 'WHERE ' . implode('AND ', $replace);

    $sql = "UPDATE $tableName $update $where;";

    $this->dbConnection->exec($sql);
  }

  public function ifObjectExitst(object $object, array $columns) {

    $tableName = $object->getTableName();
    $search = array();

    foreach ($columns as $column) {

      $search[] = "`$column` = '" . $object->$column . "' ";
    }

    $where = 'WHERE ' . implode('AND ', $search);

    $query = $this->dbConnection->prepare("SELECT * FROM $tableName $where");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result ? true : false;
  }

  public function getAllObjects(string $name) {

    $object = new $name;
    $tableName = $object->getTableName();

    $query = $this->dbConnection->prepare("SELECT * FROM $tableName");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $return = array();

    foreach ($result as $entry) {
      $object = new $name;

      foreach ($entry as $key => $value) {
        $object->$key = $value;
      }

      $return[] = $object;
    }

    return $return;
  }
}
