<?php
namespace App\Controllers;
require_once __DIR__ ."/../../vendor/autoload.php";
use App\Models\UsersModeles;
class UsersController{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new UsersModeles();
    }

    public function collectUser(){
            if(session_status() === PHP_SESSION_NONE){
            session_start();
               }

        $users =$this->userModel->findAll();
        if(!$users){
           echo 'users not found in model';
        }else{
            $_SESSION['Users'] = array_map(function($user) {
                return [
                    'id' => $user->getId(),
                    'nom' => $user->getName(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole(),
                    'status' => $user->getStatus()
                ];
            }, $users);
        }
    }

    public function updateUserStatus($id,$status){
        if ($this->userModel->updateById($id,$status)) {
        } else {
            return false;
        }
    }
    
}