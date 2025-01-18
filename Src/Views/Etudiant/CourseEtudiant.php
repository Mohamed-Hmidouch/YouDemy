<?php
namespace App\Views;
require_once __DIR__ . '/../../../vendor/autoload.php';

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
    header('Location: ../../Views/index.php');
    exit();
}
use App\Controllers\CourseController;
$Controller = new CourseController();
$Controller->readcourseinscrit();
if(isset($_SESSION['courses'])) {
    $courses = $_SESSION['courses'];
} else {
    $courses = [];
}
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
    <title>Youdemy Courses Inscript</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.9); }
        }
        .animate-modal-in {
            animation: fadeIn 0.3s ease-out;
        }
        .animate-modal-out {
            animation: fadeOut 0.3s ease-in;
        }
    </style>
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
                }
            }
            }
        }
        </script>
    </head>
    <body>
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-lg h-screen fixed">
            <div class="p-4">
            <div class="flex items-center mb-6">
                <i class="fas fa-graduation-cap text-primary text-2xl mr-2"></i>
                <span class="text-2xl font-bold text-primary">Youdemy</span>
            </div>
            <nav class="space-y-2">
                <a href="./index.php" class="flex items-center space-x-3 p-3 rounded-lg  text-primary">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
                </a>
                <a href="./CourseEtudiant.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary/10 text-gray-600 hover:text-primary bg-primary/10">
                <i class="fas fa-book"></i>
                <span>Mes cours</span>
                </a>
                <form action="" method="POST" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary/10 text-gray-600 hover:text-primary">
                <i class="fas fa-sign-out-alt"></i>
                <button name="deconnexion" type="submit">Déconnexion</button>
                </form>
            </nav>
            </div>
        </aside>

        <div class="flex-1 ml-64">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-end h-16">
                <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Rechercher un cours..." class="pl-10 pr-4 py-2 rounded-full border focus:outline-none focus:border-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=student" alt="Profile" class="w-8 h-8 rounded-full">
                    <span class="text-gray-600">John Doe</span>
                </div>
                </div>
            </div>
            </div>
        </nav>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Course Catalog -->
            <section>
            <h2 class="text-3xl font-bold text-primary mb-6">Catalogue de vos Cours</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="coursesContainer">
            <?php foreach($courses as $course): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo $course['image_url']; ?>" alt="<?php echo $course['titre']; ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-2">
                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm"><?php echo $course['category']['titre']; ?></span>
                    </div>
                    <h3 class="font-bold text-lg mb-2"><?php echo $course['titre']; ?></h3>
                    <p class="text-gray-600 mb-4"><?php echo $course['description']; ?></p>
                    
                    <!-- Content Section -->
                    <div class="mt-4">
                    <?php if(strpos($course['contenu'], 'http') === 0): ?>
                        <iframe 
                        width="100%" 
                        height="200" 
                        src="<?php echo str_replace('watch?v=', 'embed/', $course['contenu']); ?>" 
                        frameborder="0" 
                        allowfullscreen
                        class="mb-4"
                        ></iframe>
                    <?php else: ?>
                        <textarea 
                        class="w-full p-2 border rounded-lg" 
                        rows="4" 
                        readonly
                        ><?php echo $course['contenu']; ?></textarea>
                    <?php endif; ?>
                    </div>

                    <!-- Tags Section -->
                    <?php if(!empty($course['tags'])): ?>
                    <div class="flex flex-wrap gap-2 mt-3">
                    <?php foreach($course['tags'] as $tag): ?>
                        <span class="bg-secondary/10 text-secondary px-2 py-1 rounded-full text-xs">
                        <?php echo $tag['titre']; ?>
                        </span>
                    <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
            <?php endforeach; ?>
            </div>
            </section>
        </div>
</body>
</html>