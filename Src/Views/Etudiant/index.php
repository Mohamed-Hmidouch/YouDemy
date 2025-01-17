<?php
namespace App\Views;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\CourseController;
$courseController = new CourseController();
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
    header('Location: ../../Views/index.php');
    exit();
}
$CourseController->read();
if(isset($_SESSION['courses'])) {
    $courses = $_SESSION['courses'];
} else {
    $courses = [];

}
print_r($courses);
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
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary/10 text-gray-600 hover:text-primary">
                        <i class="fas fa-book"></i>
                        <span>Mes cours</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-primary/10 text-gray-600 hover:text-primary">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
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
                    <!-- Static Course Cards -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="https://via.placeholder.com/300x200" alt="Course" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm">Web Development</span>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="ml-1 text-sm">4.8</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-lg mb-2">React Masterclass</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-primary font-bold">49.99 €</span>
                                <button class="course-details-btn bg-primary text-white px-4 py-2 rounded-full text-sm" data-course-id="1">En savoir plus</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="https://via.placeholder.com/300x200" alt="Course" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm">Programming</span>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="ml-1 text-sm">4.5</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-lg mb-2">JavaScript Basics</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-primary font-bold">29.99 €</span>
                                <button class="course-details-btn bg-primary text-white px-4 py-2 rounded-full text-sm" data-course-id="2">En savoir plus</button>
                            </div>
                        </div>
                    </div>
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
        <div id="modalContent" class="mt-4">
            <p>Voici les détails du cours sélectionné.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mock course data
        const coursesData = {
            1: {
                title: "React Masterclass",
                category: "Web Development",
                tags: ["React", "JavaScript", "Frontend"],
                contentType: "video",
                content: "https://www.youtube.com/embed/sample"
            },
            2: {
                title: "JavaScript Basics",
                category: "Programming",
                tags: ["JavaScript", "Beginner", "Programming"],
                contentType: "text",
                content: "Contenu détaillé du cours JavaScript Basics..."
            }
        };

        function openModal(courseData) {
            const modal = document.getElementById('courseModal');
            modal.classList.remove('hidden');
            
            document.getElementById('modalTitle').textContent = courseData.title;
            document.getElementById('modalCategory').textContent = courseData.category;
            
            const tagsContainer = document.getElementById('modalTags');
            tagsContainer.innerHTML = courseData.tags
                .map(tag => `<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2">${tag}</span>`)
                .join('');
            
            const contentContainer = document.getElementById('modalContent');
            if (courseData.contentType === 'video') {
                contentContainer.innerHTML = `
                    <iframe src="${courseData.content}"
                            class="w-full h-96"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>`;
            } else {
                contentContainer.innerHTML = `
                    <textarea class="w-full h-64 p-4 border rounded-lg"
                              readonly>${courseData.content}</textarea>`;
            }
        }

        function closeModal() {
            document.getElementById('courseModal').classList.add('hidden');
        }

        // Event listeners
        document.querySelectorAll('.course-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.getAttribute('data-course-id');
                openModal(coursesData[courseId]);
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