<?php

class Database {

  public $db = null;

  public function connect() {

    $config = Configuration::db(); 
    
    $host = $config["host"];
    $user = $config["user"];
    $pass = $config["pass"];
    $schema = $config["schema"];
    
    try {
      $connection = new PDO("mysql:host=$host;dbname=$schema", $user, $pass);

      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->db = $connection;
    } catch (PDOException $e) {

      error_log("Unable to connect to the database");
      error_log($e);
      header("HTTP/1.1 500 Internal Server Error");
      exit;
    }

  }

}

?>
