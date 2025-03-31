<?php

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');

class Database
{
    public static $connection;

    public static function setUpConnection()
    {
        global $dbHost, $dbUser, $dbPass, $dbName;

        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName, "3306");
        }
    }

    public static function iud($q)
    {
        Database::setUpConnection();
        Database::$connection->query($q);
    }

    public static function search($q)
    {
        Database::setUpConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }
}
?>
