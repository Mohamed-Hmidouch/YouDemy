<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

require_once __DIR__ ."/../../vendor/autoload.php";


abstract class BaseModel
{
    protected $connection;
    protected $table;
    public function __construct($table) {
        $this->table = $table;
        $this->connection = Database::getConnection();
    }
     public function findAll(){
     try{
        $query = $this->connection->prepare("SELECT * FROM $this->table");
        $query->execute();
        $result [] = $query->fetchAll(PDO::FETCH_ASSOC);
        if(!$result){
            return null;
        }else{
            return $result;
        }

     }catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function findById($id){
        try{
            $query = $this->connection->prepare("SELECT * FROM $this->table WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if(!$result){
                return null;
            }else{
                return $result;
            }
        }catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
    public function delete($id){
        try{
            $query = $this->connection->prepare("UPDATE $this->table SET deleted_at = NOW() WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            return true;
        }catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
