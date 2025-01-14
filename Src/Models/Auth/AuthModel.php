<?php

namespace App\Models\Auth;

use App\Config\Database;

use App\Classes\User;

Use Pdo;
class AuthModel
{
    private $connection;
public function __construct(){
    $this->connection = Database::getConnection();
}
    public function findUser($email, $password){
        $query = "SELECT * FROM Users WHERE email = :email;
";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        if($row['password'] == $password) {
            return new User($row['id'], $row['nom'], $row['email'], $row['password'],$row['role']);
        }else{
            return null;
        }
//        if ($row && password_verify($password, $row["password"])) {
//            return new User($row['id'], $row["name"],$row["email"], $row["password"], $row["role"]);
//        }
    }
}