<?php
namespace App\Models;
require_once __DIR__ . "/../../../vendor/autoload.php";

use App\Models\BaseModel;
use PDOException;
class RegisterModel extends BaseModel{
    public function __construct() {
        parent::__construct('Users');
    }



    public function registerUser($name, $email, $password, $role) {
        try{
        $query = "INSERT INTO Users (nom, email, password, `role`) VALUES (:nom, :email, :password, :role)";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":nom", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hash);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        }catch(PDOException $e){
            throw new \Exception("Database error: " . $e->getMessage());
        }

    }
}