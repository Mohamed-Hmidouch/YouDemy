<?php
namespace App\Controllers\Auth;
require_once __DIR__ . "/../../../vendor/autoload.php";
use App\Models\RegisterModel;
require __DIR__ . "/../../Models/Auth/RegisterModel.php";
class RegistreAuth
{
    public function register($name,$email,$password,$role){
        
        $registerModel = new RegisterModel();
        $user =  $registerModel->registerUser($name,$email,$password,$role);
        if($user == null)
        {
            header("Location: /../../../src/Views/index.php");
            exit();
        }else{
            echo "User already exists";
        }
    }
}