<?php
class Db
{
  private static $instance = NULL;
  private static $user = 'postgres';
  private static $pass = '9821736';
  private static $host = 'localhost';
  private static $dbname = 'db_gestion_iglesia_arqui';
  private function __construct()
  {
  }

  private function __clone()
  {
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
      $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
      self::$instance = new PDO('pgsql:host=' . self::$host . ';dbname=' . self::$dbname, self::$user, self::$pass, $pdo_options);
    }
    return self::$instance;
  }
}
