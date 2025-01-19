<?php
namespace App\Models;
require_once __DIR__ . "/../../vendor/autoload.php";
use App\Classes\User;
use PDO;
use PDOException;
class UsersModeles extends BaseModel
{
    public function __construct()
    {
        parent::__construct('Users');
    }
    public function findAll(){
        $result = parent::findAll();
        if(!$result){
            return null;
        }
        $Users = [];
        foreach($result[0] as $row){
            $user = new User($row['id'], $row['nom'], $row['email'], $row['password'], $row['role'],$row['status']);
            $Users[] = $user;
        }
        return $Users;
    }

    public function updateById($id,$status)
    {
        $query = "UPDATE $this->table
        SET status = :status 
        WHERE id = :id";
        
try {
  $stmt = $this->connection->prepare($query);
  $stmt->bindParam(':status', $status, PDO::PARAM_STR);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  
  return $stmt->execute();
} catch(PDOException $e) {
  return false;
}
    }
}
