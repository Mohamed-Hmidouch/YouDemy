<?php

namespace App\Controllers\Auth;

use App\Models\Auth\AuthModel;

ob_start();
class LoginAuth
{

    public function login($email, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $authModel = new authModel();
        $user = $authModel->findUser($email, $password);

        if ($user == null) {
            echo "User not found, please check ...";
        } else {
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'role' => $user->getRole(),
            ];


            if ($user->getRole() == "admin") {
                header("Location: ../../../src/Views/Admin/index.php");
                exit();
            } elseif ($user->getRole() == "etudiant") {
                header("Location: ../../../../src/Views/Etudiant/index.php");
                exit();
            } elseif ($user->getRole() == "enseignant") {
                header("Location: ../../../src/Views/Enseignant/index.php");
                exit();
            }
            ob_end_flush();
        }
    }
}