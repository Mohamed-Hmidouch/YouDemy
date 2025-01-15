<?php
namespace App\Config;

require_once __DIR__ . '/../../vendor/autoload.php';
use PDOException;
use PDO;
abstract class Database
{
    private static $username = 'root';
    private static $password = 'root_password';
    private static $dns ="mysql:host=192.168.73.1;dbname=YouDemy;charset=utf8mb4";

    public static $affectedRows;

    public static function getConnection(){
        try{
            $pdo = new Pdo(self::$dns,self::$username,self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PdoException $e){
            error_log(date('Y-m-d H:i:s')."Database connection error ".$e->getMessage(),3,"error.log");
            throw new Exception("Database connection failed");
        }
        return $pdo;
    }
}