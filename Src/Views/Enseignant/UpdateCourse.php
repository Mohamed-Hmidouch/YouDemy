<?php
namespace App\Views;
use App\Controllers\CourseController;
require_once __DIR__ . '/../../../vendor/autoload.php';
$courseController = new CourseController();
?>
<?php
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
$courseId = $_GET['id'];
$courseContenct = $courseController->fetchbyId($courseId);
if(isset($_POST['update_course'])){
    $titre = $_POST['titre'];
    $categorie_id = $_POST['categorie_id'];
    $tags = $_POST['tags_selected_ids'];
    $contenu = $_POST['contenu'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $user_id = $_SESSION['user']['id'];
    
    $courseController->updateCourse($titre, $categorie_id, $tags, $contenu, $description, $user_id, $courseId, $image_url);
}
if(isset($_POST['deconnexion'])) {
    session_destroy();
    header('Location: /../../src/Views/index.php');
    exit();
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
        let selectedTags = [];
        let selectedTagIds = [];
        document.addEventListener('DOMContentLoaded', function() {
            const tagsContainer = document.getElementById('tagsContainer');
            const selectedTagsContainer = document.getElementById('selectedTagsContainer');
            const hiddenTagsInput = document.getElementById('tags_selected');
            const hiddenTagIdsInput = document.getElementById('tags_selected_ids');

            const existingTagTitles = "<?php echo $courseContenct['tag_titles'] ?? ''; ?>".split(',').filter(Boolean);
            selectedTags = existingTagTitles;
            updateSelectedTags();
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
                hiddenTagIdsInput.value = selectedTagIds.join(',');
            }
                hiddenTagsInput.value = selectedTags.join(',');
            tagsContainer.addEventListener('click', function(event) {
                const tagElement = event.target.closest('.tag');
                if (tagElement) {
                    const tagValue = tagElement.getAttribute('data-value');
                    const tagId = tagElement.getAttribute('data-id');

                    if (!selectedTags.includes(tagValue)) {
                        selectedTags.push(tagValue);
                        selectedTagIds.push(tagId);
                        updateSelectedTags();
                    }
                }
            });
            window.removeTag = function(tagToRemove) {
                const index = selectedTags.indexOf(tagToRemove);
                if (index > -1) {
                    selectedTags.splice(index, 1);
                    selectedTagIds.splice(index, 1);
                }
                updateSelectedTags();
            }
            window.removeTag = function(tagToRemove) {
                selectedTags = selectedTags.filter(tag => tag !== tagToRemove);
                updateSelectedTags();
            }

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


            window.scrollToForm = function() {
                document.getElementById('courseForm').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>
</head>
       <section id="courseForm" class="bg-white rounded-xl shadow-md p-8 mb-8">
                <h3 class="text-2xl font-bold text-primary mb-6 font-serif">Créer un Nouveau Cours</h3>
                <form class="space-y-6" action="" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-neutral font-medium mb-2">Titre du Cours</label>
                            <input type="text" name="titre" value="<?php echo $courseContenct['course_title'] ?>" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" placeholder="Entrez le titre">
                        </div>
                        <div>
                            <label class="block text-neutral font-medium mb-2">Catégorie</label>

                            <select name="categorie_id" value="id" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary">
                                <?php
                                    foreach ($categories as $categorie) { ?>
                                        <option value="<?php echo $categorie['id']; ?>" <?php echo ($categorie['id'] == $courseContenct['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo $categorie['titre']; ?>
                                        </option>
                               <?php } ?>
                            </select>





                        </div>
                    </div>

                    <!-- Système de Tags -->
                    <div>
                        <!-- Tags sélectionnés -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Tags sélectionnés</label>
                            <div id="selectedTagsContainer" class="flex flex-wrap gap-3 mt-2">
                                <!-- Les tags sélectionnés apparaîtront ici -->
                            </div>
                        </div>

                        <!-- Input caché pour transmettre les tags sélectionnés -->
                        <input type="hidden" name="tags_selected" id="tags_selected" value="">
                        <input type="hidden" name="tags_selected_ids" id="tags_selected_ids" value="">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tags disponibles</label>
                        <div id="tagsContainer" class="flex flex-wrap gap-3 mt-2">
                            <?php foreach ($tags as $tag): ?>
                                <span data-value="<?php echo $tag['titre']; ?>" 
                                      data-id="<?php echo $tag['id']; ?>" 
                                      class="tag bg-[#e7f3ff] text-[#0a66c2] px-3 py-1 rounded-full text-sm cursor-pointer">
                                    <i class="fas fa-tag mr-1"></i> <?php echo $tag['titre']; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <small class="text-gray-500 text-sm">Cliquez sur un tag pour le sélectionner</small>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Mark existing tags as selected
                        const tagElements = document.querySelectorAll('#tagsContainer .tag');
                        tagElements.forEach(tag => {
                            if (selectedTags.includes(tag.getAttribute('data-value'))) {
                                tag.classList.add('bg-primary/10', 'text-primary');
                            }
                        });
                    });
                    </script>
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
        <input type="url" name="contenu" value="<?php echo $courseContenct['course_content']; ?>" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" placeholder="https://...">
    </div>

    <div id="text_content" class="hidden">
        <label class="block text-neutral font-medium mb-2">Contenu du Cours</label>
        <textarea name="contenu" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" rows="6" placeholder="Rédigez votre cours..."><?php echo $courseContenct['course_content']; ?></textarea>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const content = "<?php echo $courseContenct['content']; ?>";
        const videoRadio = document.querySelector('input[value="video"]');
        const textRadio = document.querySelector('input[value="text"]');
        const videoContent = document.getElementById('video_content');
        const textContent = document.getElementById('text_content');

        if (content.toLowerCase().startsWith('https://')) {
            videoRadio.checked = true;
            videoContent.classList.remove('hidden');
            textContent.classList.add('hidden');
        } else {
            textRadio.checked = true;
            textContent.classList.remove('hidden');
            videoContent.classList.add('hidden');
        }
    });
    </script>


                    <div>
                        <label class="block text-neutral font-medium mb-2">Description</label>
                        <input value="<?php echo $courseContenct['course_description'] ?>" name="description" class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" rows="4" placeholder="Description du cours..."></input>
                    </div>

                    <div>
                        <label class="block text-neutral font-medium mb-2">Image de Couverture (URL)</label>
                        <input 
                            type="url" 
                            name="image_url"
                            class="w-full border border-base-300 rounded-lg p-3 focus:outline-none focus:border-primary" 
                            placeholder="Entrez l'URL de l'image (https://...)"
                        >
                        <p class="text-sm text-gray-500 mt-1"><?php echo $courseContenct['image_url']?></p>
                    </div>




                    <div class="flex justify-end space-x-4">
                        <button
                            type="button"
                            class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200"
                        >
                            Brouillon
                        </button>
                        <button
                            type="submit" value="submit" name="update_course"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center"
                        >
                            <i class="fas fa-paper-plane mr-2"></i>Update le Cours
                        </button>
                    </div>
                </form>
            </section>