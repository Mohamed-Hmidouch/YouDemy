<?php
namespace App\Views;
require_once __DIR__ ."/../../../vendor/autoload.php";
use App\Controllers\CourseController;

use App\Controllers\CategoriesController;
use App\Controllers\TagsController;
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
    header('Location: ../../Views/index.php');
    exit();
}
$categoriesCon = new CategoriesController();
$tagsCon = new TagsController();
if (!isset($_SESSION['categories']) && !isset($_SESSION['tags'])) {
    $tagsCon->read();
    $categoriesCon->read();
}

if (isset($_SESSION['categories']) && isset($_SESSION['tags'])) {
    $categories = $_SESSION['categories'];
    $tags = $_SESSION['tags'];
} else {
    echo "No session.";
}

?>
<?php

use Exception;
if(isset($_POST["submit"])){
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $selectedTags= $_POST['tags_selected'];
    $enseignant_id = $_SESSION['user']['id'];
    $tagsArray = explode(',', $selectedTags);
    $validTagIds = array_map(function ($tagName) {
        foreach ($_SESSION['tags'] as $tag) {
            if (trim($tag['titre']) === trim($tagName)) {
                return $tag['id'];
            }
        }
        return null;
    }, $tagsArray);
    $tagsIdsString = implode(',', $validTagIds);
    $tagsSelectedIds = $_POST['tags_selected_ids'];
    $courseController = new CourseController();
    try {
        $postData = $_POST;
        $courseId = $courseController->createCourse($postData, $_SESSION['tags']);
        echo "Cours créé avec succès. ID : " . $courseId;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="custom">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Interface Enseignant</title>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagsContainer = document.getElementById('tagsContainer');
            const selectedTagsContainer = document.getElementById('selectedTagsContainer');
            const hiddenTagsInput = document.getElementById('tags_selected');

            let selectedTags = [];

            function updateSelectedTags() {
                selectedTagsContainer.innerHTML = selectedTags.map(tag => `
                <span class="tag bg-primary/10 text-primary px-3 py-1 rounded-full text-sm flex items-center">
                    <i class="fas fa-tag mr-1"></i>
                    ${tag}
                    <button onclick="removeTag('${tag}')" class="ml-2 text-red-500">
                        <i class="fas fa-times"></i>
                    </button>
                </span>
            `).join('');

                hiddenTagsInput.value = selectedTags.join(',');
            }

            // Gestion de la sélection des tags disponibles
            tagsContainer.addEventListener('click', function(event) {
                const tagElement = event.target.closest('.tag');
                if (tagElement) {
                    const tagValue = tagElement.getAttribute('data-value');

                    // Vérifier si le tag n'est pas déjà sélectionné
                    if (!selectedTags.includes(tagValue)) {
                        selectedTags.push(tagValue);
                        updateSelectedTags();
                    }
                }
            });

            // Fonction globale pour supprimer un tag
            window.removeTag = function(tagToRemove) {
                selectedTags = selectedTags.filter(tag => tag !== tagToRemove);
                updateSelectedTags();
            }

            // Gestion dynamique du type de contenu
const contentTypeRadios = document.querySelectorAll('input[type="radio"]');
const videoContentDiv = document.getElementById('video_content');
const textContentDiv = document.getElementById('text_content');

contentTypeRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'video') {
            videoContentDiv.classList.remove('hidden');
            textContentDiv.classList.add('hidden');
            videoContentDiv.querySelector('input[name="contenu"]').disabled = false;
            textContentDiv.querySelector('textarea[name="contenu"]').disabled = true;
        } else if (this.value === 'text') {
            textContentDiv.classList.remove('hidden');
            videoContentDiv.classList.add('hidden');
            textContentDiv.querySelector('textarea[name="contenu"]').disabled = false;
            videoContentDiv.querySelector('input[name="contenu"]').disabled = true;
        }
    });
});


            // Fonction pour scroller vers le formulaire
            window.scrollToForm = function() {
                document.getElementById('courseForm').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>
</head>
<body class="bg-base-100 font-sans text-neutral">
<div class="min-h-screen flex">
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
                    <a href="#" class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
                        <i class="fas fa-users text-xl"></i>
                        <span class="font-medium">Étudiants</span>
                    </a>
                </div>
                <div class="group">
                    <a href="#" class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
                        <i class="fas fa-chart-bar text-xl"></i>
                        <span class="font-medium">Statistiques</span>
                    </a>
                </div>
                <div class="group">
                    <a href="./logout.php" class="flex items-center space-x-3 text-neutral hover:text-primary p-3 rounded-lg transition-all duration-300 hover:bg-primary/10">
                        <i class="fas fa-sign-out-alt text-xl"></i>
                        <span class="font-medium">Déconnexion</span>
                    </a>
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

    <!-- Contenu Principal -->
    <main class="ml-64 flex-1 bg-base-200">
        <!-- En-tête -->
        <header class="bg-white shadow-md p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-primary font-serif">Gestion des Cours</h2>
                    <p class="text-neutral">Gérez vos cours et suivez leur progression</p>
                </div>
                <div class="flex space-x-4">
                    <button onclick="scrollToForm()" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i>Nouveau Cours
                    </button>
                </div>
            </div>
        </header>

        <!-- Contenu -->
        <div class="p-8">
            <!-- Statistiques -->
            <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <i class="fas fa-users text-3xl text-primary"></i>
                        <span class="text-green-500 text-sm font-medium">+12%</span>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral">1,254</h3>
                    <p class="text-neutral">Étudiants Inscrits</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <i class="fas fa-book text-3xl text-primary"></i>
                        <span class="text-green-500 text-sm font-medium">+5%</span>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral">23</h3>
                    <p class="text-neutral">Cours Actifs</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <i class="fas fa-star text-3xl text-primary"></i>
                        <span class="text-green-500 text-sm font-medium">+8%</span>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral">4.8</h3>
                    <p class="text-neutral">Note Moyenne</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <i class="fas fa-graduation-cap text-3xl text-primary"></i>
                        <span class="text-green-500 text-sm font-medium">+15%</span>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral">256</h3>
                    <p class="text-neutral">Certifications</p>
                </div>
            </section>

            <!-- Formulaire de Cours -->
            <section id="courseForm" class="bg-white rounded-xl shadow-md p-8 mb-8">
                <h3 class="text-2xl font-bold text-primary mb-6 font-serif">Créer un Nouveau Cours</h3>
                <form class="space-y-6" action="" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-neutral font-medium mb-2">Titre du Cours</label>
                            <input type="text" name="titre" value="titre" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" placeholder="Entrez le titre">
                        </div>
                        <div>
                            <label class="block text-neutral font-medium mb-2">Catégorie</label>

                            <select name="categorie_id" value="id" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary">
                                <?php
                                    foreach ($categories as $categorie) { ?>
                                        <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['titre']; ?></option>

                               <?php } ?>
                            </select>





                        </div>
                    </div>

                    <!-- Système de Tags -->
                    <div>
                        <!-- Tags disponibles -->
                        <!-- Tags sélectionnés -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Tags sélectionnés</label>
                            <div id="selectedTagsContainer" class="flex flex-wrap gap-3 mt-2">
                                <!-- Les tags sélectionnés apparaîtront ici -->
                            </div>
                        </div>

                        <!-- Input caché pour transmettre les tags sélectionnés -->
                        <input type="hidden" name="tags_selected" id="tags_selected" value="">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tags disponibles</label>
                        <div id="tagsContainer" class="flex flex-wrap gap-3 mt-2">
                            <?php
                            // Vérifier si la session contient des tags et si c'est un tableau
                                foreach ($tags as $tag) {
                                        ?>
                                        <span data-value="<?php echo $tag['titre']; ?>" class="tag bg-[#e7f3ff] text-[#0a66c2] px-3 py-1 rounded-full text-sm cursor-pointer">
                                   <i class="fas fa-tag mr-1"></i> <?php echo $tag['titre']; ?>
                                        </span>
                                        <?php

                            }
                            ?>
                        </div>
                        <small class="text-gray-500 text-sm">Cliquez sur un tag pour le sélectionner</small>
                        <input type="hidden" name="tags_selected_ids" value="<?= htmlspecialchars($tagsIdsString ?? '') ?>">
                    </div>
                    <div>
    <label class="block text-neutral font-medium mb-2">Type de Contenu</label>
    <div class="flex space-x-4">
        <label class="flex items-center space-x-2">
            <input type="radio" name="type_contenu" value="video" class="text-primary">
            <span>Vidéo</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" name="type_contenu" value="text" class="text-primary">
            <span>Texte</span>
        </label>
    </div>
</div>

<div id="video_content" class="hidden">
    <label class="block text-neutral font-medium mb-2">URL de la Vidéo</label>
    <input type="url" name="contenu" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" placeholder="https://...">
</div>

<div id="text_content" class="hidden">
    <label class="block text-neutral font-medium mb-2">Contenu du Cours</label>
    <textarea name="contenu" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" rows="6" placeholder="Rédigez votre cours..."></textarea>
</div>


                    <div>
                        <label class="block text-neutral font-medium mb-2">Description</label>
                        <textarea value="description" name="description" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" rows="4" placeholder="Description du cours..."></textarea>
                    </div>

                    <div>
                        <label class="block text-neutral font-medium mb-2">Image de Couverture</label>
                        <div class="border-2 border-dashed border-base-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                            <i class="fas fa-cloud-upload-alt text-4xl text-neutral mb-4"></i>
                            <p class="text-neutral">Glissez et déposez votre image ou <span class="text-primary cursor-pointer">parcourir</span></p>
                            <input type="file" class="hidden" accept="image/*">
                        </div>
                    </div>




                    <div class="flex justify-end space-x-4">
                        <button
                            type="button"
                            class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200"
                        >
                            Brouillon
                        </button>
                        <button
                            type="submit" value="submit" name="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center"
                        >
                            <i class="fas fa-paper-plane mr-2"></i>Publier le Cours
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</div>
</body>
</html>