<?php

class Connection
{
  public static $database = "compop";
  public static $address = "localhost";
  public static $user = "root";
  public static $password = "";

  public static function getConnection() {
    $connection = mysqli_connect(Connection::$address, Connection::$user, Connection::$password, Connection::$database);
    return $connection;
  }
}

?>
