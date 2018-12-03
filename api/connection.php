<?php

class Connection
{
  public static $database = "compop";
  public static $address = "localhost";
  public static $user = "root";
  public static $password = "";

  public static function getConnection() {
    $connection = mysqli_connect(getenv("DB_HOST") ?: Connection::$address,
                                 getenv("DB_USER") ?: Connection::$user,
                                 getenv("DB_PASSWORD") ?: Connection::$password,
                                 getenv("DB_NAME") ?: Connection::$database);
    return $connection;
  }
}
?>
