<?php
namespace App\Views;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\StatistiquesController;
use App\Controllers\CourseController;
$courses = new CourseController();
$allcourse = $courses->getCoursesCount();
$UsersStat = new StatistiquesController();
$UsersStat->getAllEtudiant();
$UsersStat->getAllEtudiantInscris();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../Views/index.php');
    exit();
}
if (isset($_SESSION['allEtudiants']) && isset($_SESSION['etudiantsInscrits'])) {
   $totalEtudiants = $_SESSION['allEtudiants'];
    $etudiantsInscrits = $_SESSION['etudiantsInscrits'];
}
if(isset($_POST['deconnexion'])) {
    session_destroy();
    header('Location: /../../src/Views/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YouDemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#6e0b14',
                        'secondary': '#a4161a',
                        'accent': '#e63946',
                        'neutral': '#9e9e9e',
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
</head>
<body class="bg-base-200">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-primary h-screen w-64 fixed transition-all duration-300 flex flex-col">
        <!-- Logo Area -->
        <div class="p-6 border-b border-secondary">
            <a href="../index.php" class="text-2xl font-bold text-base-100 sidebar-label flex items-center">
                <i class="fas fa-graduation-cap mr-2"></i>
                YouDemy
            </a>
        </div>

        <!-- Navigation Items -->
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li>
                    <a href="./index.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary text-base-100">
                        <i class="fas fa-chart-pie"></i>
                        <span class="sidebar-label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./Comfirmation.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-300">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span class="sidebar-label">Validation Enseignants</span>
                    </a>
                </li>
                <li>
                    <a href="./" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-300">
                        <i class="fas fa-users-cog"></i>
                        <span class="sidebar-label">Gestion Utilisateurs</span>
                    </a>
                </li>
                <li>
                    <a href="./ConsulterCour.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-300">
                        <i class="fas fa-book"></i>
                        <span class="sidebar-label">Gestion Cours</span>
                    </a>
                </li>
                <li>
                    <a href="./Gestion.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-300">
                        <i class="fas fa-tags"></i>
                        <span class="sidebar-label">Tags & Catégories</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Button -->
        <div class="group">
                    <form  action="" method="POST"  class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
                        <i class="fas fa-sign-out-alt text-xl"></i>
                        <button name="deconnexion" type="submit" class="font-medium">Déconnexion</button>
                    </form>
                </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="ml-64 p-8">
        <!-- Header Stats -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-base-100 rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-secondary bg-opacity-10 text-secondary">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-neutral text-sm">Total Utilisateurs</h3>
                        <p class="text-2xl font-semibold text-primary"><?php echo count($totalEtudiants); ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-base-100 rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-secondary bg-opacity-10 text-secondary">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-neutral text-sm">Total Cours</h3>
                        <p class="text-2xl font-semibold text-primary"><?php echo count($allcourse)?></p>
                    </div>
                </div>
            </div>
            <div class="bg-base-100 rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-secondary bg-opacity-10 text-secondary">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-neutral text-sm">Étudiants Inscrits</h3>
                        <p class="text-2xl font-semibold text-primary"><?php echo count($etudiantsInscrits); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>