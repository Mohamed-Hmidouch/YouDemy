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
$Controller->read();
if(isset($_SESSION['courses'])) {
    $courses = $_SESSION['courses'];
} else {
    $courses = [];
}
if(isset($_POST['inscrire'])) {

$inscrie = $Controller->inscrire($_POST['course_id'],$_SESSION['user']['id']);
if($inscrie){
    echo "inscrie avec succes";
}
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
    <title>Youdemy</title>
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
</head>
<body>

<body>
    <div class="min-h-screen bg-base-200 flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg h-screen fixed">
            <div class="p-4">
                <div class="flex items-center mb-6">
                    <i class="fas fa-graduation-cap text-primary text-2xl mr-2"></i>
                    <span class="text-2xl font-bold text-primary">Youdemy</span>
                </div>
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-primary/10 text-primary">
                        <i class="fas fa-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="./CourseEtudiant.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary/10 text-gray-600 hover:text-primary">
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

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Course Catalog -->
            <section>
                <h2 class="text-3xl font-bold text-primary mb-6">Catalogue des Cours</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="coursesContainer">
                <?php foreach($courses as $course): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="<?php echo $course['image_url']; ?>" alt="<?php echo $course['titre']; ?>" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm"><?php echo $course['category']['titre']; ?></span>
                            </div>
                            <h3 class="font-bold text-lg mb-2"><?php echo $course['titre']; ?></h3>
                            <div class="flex justify-end items-center">
                                <button class="course-details-btn bg-primary text-white px-4 py-2 rounded-full text-sm" 
                                        data-course-id="<?php echo $course['id']; ?>"
                                        data-description="<?php echo htmlspecialchars($course['description']); ?>">
                                    En savoir plus
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- Modal for Course Details -->
<div id="courseModal" class="fixed hidden inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-11/12 md:w-3/4 lg:w-1/2 animate-modal-in">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-2xl font-bold text-primary"></h2>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="mb-4">
            <span id="modalCategory" class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm mr-2"></span>
            <div id="modalTags" class="inline-block"></div>
        </div>
        <div id="modalContent" class="mt-4 space-y-4">
            <img id="courseImage" class="w-full h-48 object-cover rounded-lg mb-4" src="" alt="Course Image">
            <p id="courseDescription" class="text-gray-700"></p>
            <form action="" method="POST">
                <input type="hidden" id="courseIdInput" name="course_id">
                <button type="submit" name="inscrire" class="bg-primary text-white px-6 py-2 rounded-full hover:bg-primary/90 transition-colors">
                    S'inscrire au cours
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function openModal(courseId, description, imageUrl, title) {
            const modal = document.getElementById('courseModal');
            modal.classList.remove('hidden');
            
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('courseDescription').textContent = description;
            document.getElementById('courseImage').src = imageUrl;
            document.getElementById('courseIdInput').value = courseId;
        }

        function closeModal() {
            document.getElementById('courseModal').classList.add('hidden');
        }

        // Event listeners
        document.querySelectorAll('.course-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.getAttribute('data-course-id');
                const description = this.getAttribute('data-description');
                const imageUrl = this.closest('.bg-white').querySelector('img').src;
                const title = this.closest('.bg-white').querySelector('h3').textContent;
                openModal(courseId, description, imageUrl, title);
            });
        });

        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('courseModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    });
</script>




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
</body>
</html>