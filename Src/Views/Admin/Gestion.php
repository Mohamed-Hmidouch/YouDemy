<?php
namespace App\Views;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Controllers\TagsController;
use App\Controllers\CategoriesController;

$TagsController = new TagsController();
$CategoriesController = new CategoriesController();
session_start();
// Initial data load
$TagsController->read();
$CategoriesController->read();

if(isset($_SESSION['tags']) || isset($_SESSION['categories'])){
    $tags = $_SESSION['tags'];
    $categories = $_SESSION['categories'];
}

// Category Operations
if(isset($_POST['add_Categorie'])) {
    $categoryName = $_POST['categoryName'];
    $CategoriesController->create($categoryName);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


if(isset($_POST['edit_category'])) {
    $id = $_POST['categoryId'];
    $categoryName = $_POST['categoryName'];
    $CategoriesController->update($id, $categoryName);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_POST['delete_category'])) {
    $id = $_POST['categoryId'];
    $CategoriesController->delete($id);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Tag Operations
if(isset($_POST['add_tag'])) {
    $tagName = $_POST['tagName'];
    $TagsController->create($tagName);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_POST['edit_tag'])) {
    $id = $_POST['tagId'];
    $tagName = $_POST['tagName'];
    $TagsController->update($id, ['titre' => $tagName]);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_POST['delete_tag'])) {
    $id = $_POST['tagId'];
    $TagsController->delete($id);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Tag & Categories</title>
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
                    <a href="./index.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-100">
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
                    <a href="./ConsulterCour.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-300">
                        <i class="fas fa-book"></i>
                        <span class="sidebar-label">Gestion Cours</span>
                    </a>
                </li>
                <li>
                    <a href="./Gestion.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary text-base-100">
                        <i class="fas fa-tags"></i>
                        <span class="sidebar-label">Tags & Catégories</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-secondary">
            <button class="flex items-center space-x-3 text-accent hover:bg-secondary p-3 rounded-lg w-full">
                <i class="fas fa-sign-out-alt"></i>
                <span class="sidebar-label">Déconnexion</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="ml-64 p-8">
        <!-- Tab Buttons -->
        <div class="flex space-x-4 mb-6">
            <button id="categoriesTab" class="px-6 py-3 bg-primary text-white rounded-lg font-medium flex items-center space-x-2 focus:outline-none">
                <i class="fas fa-folder"></i>
                <span>Catégories</span>
            </button>
            <button id="tagsTab" class="px-6 py-3 bg-base-100 text-primary rounded-lg font-medium flex items-center space-x-2 hover:bg-base-300 focus:outline-none">
                <i class="fas fa-tags"></i>
                <span>Tags</span>
            </button>
        </div>

        <!-- Categories Section -->
        <div id="categoriesSection" class="bg-base-100 rounded-lg p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-primary">Gestion des Catégories</h2>
                <button onclick="openModal('addCategoryModal')" class="bg-secondary text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-accent transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter une Catégorie</span>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-base-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-primary">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-primary">Titre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-primary">Nombre de cours</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-primary">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200">
                        <?php if(isset($_SESSION['categories']) && !empty($_SESSION['categories'])): ?>
                            <?php foreach($_SESSION['categories'] as $category): ?>
                                <tr class="hover:bg-base-200">
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($category['id']); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($category['titre']); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($category['nombre_cours']); ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="openEditModal('editCategoryModal', '<?php echo htmlspecialchars($category['id']); ?>', '<?php echo htmlspecialchars($category['titre']); ?>')" 
                                                class="text-secondary hover:text-accent mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="openDeleteModal('deleteCategoryModal', '<?php echo htmlspecialchars($category['id']); ?>')" 
                                                class="text-secondary hover:text-accent">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune catégorie trouvée</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tags Section -->
        <div id="tagsSection" class="bg-base-100 rounded-lg p-6 shadow-sm hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-primary">Gestion des Tags</h2>
                <button onclick="openModal('addTagModal')" class="bg-secondary text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-accent transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un Tag</span>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-base-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-primary">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-primary">Titre</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-primary">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200">
                        <?php if(isset($_SESSION['tags']) && !empty($_SESSION['tags'])): ?>
                            <?php foreach($_SESSION['tags'] as $tag): ?>
                                <tr class="hover:bg-base-200">
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($tag['id']); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($tag['titre']); ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="openEditModal('editTagModal', '<?php echo htmlspecialchars($tag['id']); ?>', '<?php echo htmlspecialchars($tag['titre']); ?>')" 
                                                class="text-secondary hover:text-accent mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="openDeleteModal('deleteTagModal', '<?php echo htmlspecialchars($tag['id']); ?>')" 
                                                class="text-secondary hover:text-accent">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun tag trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-96">
            <h3 class="text-xl font-semibold text-primary mb-4">Ajouter une Catégorie</h3>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                    <input type="text" id="categoryName" name="categoryName" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addCategoryModal')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" name="add_Categorie" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Tag Modal -->
    <div id="addTagModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-96">
            <h3 class="text-xl font-semibold text-primary mb-4">Ajouter un Tag</h3>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="tagName" class="block text-sm font-medium text-gray-700 mb-2">Nom du tag</label>
                    <input type="text" id="tagName" name="tagName" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addTagModal')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" name="add_tag" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-96">
            <h3 class="text-xl font-semibold text-primary mb-4">Modifier la Catégorie</h3>
            <form action="" method="post">
                <input type="hidden" id="editCategoryId" name="categoryId">
                <div class="mb-4">
                    <label for="editCategoryName" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                    <input type="text" id="editCategoryName" name="categoryName" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editCategoryModal')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" name="edit_category" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                        Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    <div id="editTagModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-96">
            <h3 class="text-xl font-semibold text-primary mb-4">Modifier le Tag</h3>
            <form action="" method="post">
                <input type="hidden" id="editTagId" name="tagId">
                <div class="mb-4">
                    <label for="editTagName" class="block text-sm font-medium text-gray-700 mb-2">Nom du tag</label>
                    <input type="text" id="editTagName" name="tagName" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editTagModal')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" name="edit_tag" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                        Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div id="deleteCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-96">
            <h3 class="text-xl font-semibold text-primary mb-4">Supprimer la Catégorie</h3>
            <form action="" method="post">
                <input type="hidden" id="deleteCategoryId" name="categoryId">
                <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir supprimer cette catégorie ?</p>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteCategoryModal')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" name="delete_category" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Tag Modal -->
    <div id="deleteTagModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-96">
            <h3 class="text-xl font-semibold text-primary mb-4">Supprimer le Tag</h3>
            <form action="" method="post">
                <input type="hidden" id="deleteTagId" name="tagId">
                <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir supprimer ce tag ?</p>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteTagModal')"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Annuler
                    </button>
                    <button type="submit" name="delete_tag" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching functionality
        const categoriesTab = document.getElementById('categoriesTab');
        const tagsTab = document.getElementById('tagsTab');
        const categoriesSection = document.getElementById('categoriesSection');
        const tagsSection = document.getElementById('tagsSection');

        function switchToCategories() {
            categoriesTab.classList.remove('bg-base-100', 'text-primary');
            categoriesTab.classList.add('bg-primary', 'text-white');
            tagsTab.classList.remove('bg-primary', 'text-white');
            tagsTab.classList.add('bg-base-100', 'text-primary');
            categoriesSection.classList.remove('hidden');
            tagsSection.classList.add('hidden');
        }

        function switchToTags() {
            tagsTab.classList.remove('bg-base-100', 'text-primary');
            tagsTab.classList.add('bg-primary', 'text-white');
            categoriesTab.classList.remove('bg-primary', 'text-white');
            categoriesTab.classList.add('bg-base-100', 'text-primary');
            tagsSection.classList.remove('hidden');
            categoriesSection.classList.add('hidden');
        }

        categoriesTab.addEventListener('click', switchToCategories);
        tagsTab.addEventListener('click', switchToTags);

        // Modal functionality
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('flex');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('flex');
            document.getElementById(modalId).classList.add('hidden');
        }

        function openEditModal(modalId, id, name) {
            const modal = document.getElementById(modalId);
            const idInput = modal.querySelector(modalId === 'editCategoryModal' ? '#editCategoryId' : '#editTagId');
            const nameInput = modal.querySelector(modalId === 'editCategoryModal' ? '#editCategoryName' : '#editTagName');
            
            idInput.value = id;
            nameInput.value = name;
            
            openModal(modalId);
        }

        function openDeleteModal(modalId, id) {
            const modal = document.getElementById(modalId);
            const idInput = modal.querySelector(modalId === 'deleteCategoryModal' ? '#deleteCategoryId' : '#deleteTagId');
            
            idInput.value = id;
            
            openModal(modalId);
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('[id$="Modal"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        }
    </script>
</body>
</html>