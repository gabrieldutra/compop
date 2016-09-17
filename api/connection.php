<?php

class Connection
{
  public static $database = "mydb";
  public static $address = "localhost";
  public static $user = "root";
  public static $password = "allods6655";


  public static function getConnection() {
    $connection = mysqli_connect(Connection::$address, Connection::$user, Connection::$password, Connection::$database);
    mysqli_set_charset($connection , 'utf8');
    return $connection;
  }
}
