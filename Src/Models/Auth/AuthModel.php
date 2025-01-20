<?php

namespace App\Models\Auth;

use App\Config\Database;

use App\Classes\User;
use PDOException;
Use Pdo;
class AuthModel
{
    private $connection;
public function __construct(){
    $this->connection = Database::getConnection();
}
public function findUser($email, $password){
    try {
        $query = "SELECT u.id, u.nom, u.email, u.password, u.role, u.status
                  FROM Users u
                  WHERE u.email = :email";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row && password_verify($password, $row['password'])) {
            if ($row['role'] === 'enseignant') {
                if ($row['status'] === 'en_attente') {
                    return null;
                }
                if ($row['status'] === 'active') {
                    return new User(
                        $row['id'], 
                        $row['nom'], 
                        $row['email'], 
                        $row['password'], 
                        $row['role']
                    );
                }
            }
            return new User(
                $row['id'], 
                $row['nom'], 
                $row['email'], 
                $row['password'], 
                $row['role']
            );
        }
        return null;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}
public function checkPendingStatus($email) {
    try {
        $query = "SELECT role, status FROM Users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

}