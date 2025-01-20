<?php

namespace App\Controllers\Auth;
use PDO;
use PDOException;
use App\Models\Auth\AuthModel;

ob_start();
class LoginAuth
{

    public function login($email, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $authModel = new AuthModel();
        $user = $authModel->findUser($email, $password);
    
        // Create styled message templates
        $errorStyle = 'p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400';
        $warningStyle = 'p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300';
    
        if ($user === null) {
            $pendingUser = $authModel->checkPendingStatus($email);
            if ($pendingUser && $pendingUser['role'] === 'enseignant' && $pendingUser['status'] === 'en_attente') {
                echo "<div class='{$warningStyle}' role='alert'>
                        <span class='font-medium'>Attention!</span> 
                        Votre compte enseignant est en cours de validation. Veuillez patienter jusqu'à l'activation de votre compte.
                      </div>";
            } else {
                echo "<div class='{$errorStyle}' role='alert'>
                        <span class='font-medium'>Erreur!</span> 
                        Email ou mot de passe incorrect.
                      </div>";
            }
            return;
        }
    
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'role' => $user->getRole(),
        ];
            switch ($user->getRole()) {
            case 'admin':
                header("Location: ../../../src/Views/Admin/index.php");
                break;
            case 'etudiant':
                header("Location: ../../../../src/Views/Etudiant/index.php");
                break;
            case 'enseignant':
                header("Location: ../../../src/Views/Enseignant/index.php");
                break;
        }
        exit();
    }
}