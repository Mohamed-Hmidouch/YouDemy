<?php
namespace App\Classes;
require_once __DIR__ . "/../../vendor/autoload.php";

class User
{
    private $id;
    private $nom;
    private $email;

    private $password;
    private $role;
    public function __construct($id, $nom, $email, $password, $role){
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    public function getRole(){
        return $this->role;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->nom;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }

}
