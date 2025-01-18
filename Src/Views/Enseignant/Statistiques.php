<?php
namespace App\Views;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\CourseController;
$courseController = new CourseController();
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
    header('Location: ../../Views/index.php');
    exit();
}

$etudiant= $courseController->getEtudiantsInscrits($_SESSION['user']['id']);



if(isset($_POST['deconnexion'])) {
    session_destroy();
    header('Location: /../../src/Views/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#6e0b14',
                        'secondary': '#a4161a',
                        'accent': '#e63946',
                        'neutral': '#4a5568',
                        'base-100': '#ffffff',
                        'base-200': '#f5f5f5',
                        'base-300': '#eeeeee',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                        'serif': ['Playfair Display', 'serif'],
                    },
                }
            },
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6e0b14;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a4161a;
        }

        .text-neutral {
            color: #4a5568 !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="w-64 bg-white shadow-xl fixed h-full custom-scrollbar overflow-y-auto">
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-10">
        <i class="fas fa-graduation-cap text-primary text-2xl"></i>
        <h1 class="text-2xl font-bold text-primary font-serif">Youdemy</h1>
        </div>
        <nav class="space-y-4">
        <div class="group">
            <a href="#" class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
            <i class="fas fa-home text-xl"></i>
            <span class="font-medium">Tableau de Bord</span>
            </a>
        </div>
        <div class="group">
            <a href="./Course.php" class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
            <i class="fas fa-book text-xl"></i>
            <span class="font-medium">Mes Cours</span>
            </a>
        </div>
        <div class="group">
            <a href="./Statistiques.php" class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
                <i class="fas fa-chart-bar text-xl"></i>
                <span class="font-medium">Statistiques</span>
            </a>
            </div>
        <div class="group">
            <form  action="" method="POST"  class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
            <i class="fas fa-sign-out-alt text-xl"></i>
            <button name="deconnexion" type="submit" class="font-medium">Déconnexion</button>
            </form>
        </div>
        </nav>
        <div class="border-t border-base-300 mt-6 pt-6">
        <div class="flex items-center space-x-3">
            <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=teacher" alt="Profil" class="w-10 h-10 rounded-full">
            <div>
            <h4 class="font-semibold text-neutral">Jean Dupont</h4>
            <p class="text-sm text-neutral">Enseignant Expert</p>
            </div>
        </div>
        </div>
    </div>
    </div>
<!-- Main Content -->
<div class="ml-64 p-8">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold text-neutral mb-6">Statistiques Générales</h2>
        
        <!-- Statistics Table -->
        <div class="bg-white rounded-lg shadow-md">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Statistique</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Nombre</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">Nombre d'étudiants inscrits</td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $etudiant['total_etudiants']?></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">Nombre de cours</td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $etudiant['nombre_cours']?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>