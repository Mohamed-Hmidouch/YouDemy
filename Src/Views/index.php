<?php
namespace App\Views;
require_once __DIR__ . '/../../vendor/autoload.php';
session_start();
use App\Controllers\CourseController;
$Controller = new CourseController();
$Controller->read();
if(isset($_SESSION['courses'])) {
    $courses = $_SESSION['courses'];
} else {
    $courses = [];
}
$items_per_page = 3;
$total_courses = count($courses);
$total_pages = ceil($total_courses / $items_per_page);
$current_page = isset($_GET['page']) ? max(1, min($total_pages, intval($_GET['page']))) : 1;
$start_index = ($current_page - 1) * $items_per_page;
$current_courses = array_slice($courses, $start_index, $items_per_page);
?>
<!DOCTYPE html>
<html lang="fr" data-theme="custom">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Plateforme d'apprentissage en ligne</title>
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
<body class="bg-base-100 font-sans text-neutral">

<!-- Barre de navigation fixe -->
<nav class="fixed w-full bg-base-100 shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center transition-transform hover:scale-105">
                    <i class="fas fa-graduation-cap text-primary text-2xl mr-2"></i>
                    <span class="text-2xl font-bold text-primary font-serif">Youdemy</span>
                </a>
            </div>

            <!-- Navigation principale -->
            <div class="hidden md:flex items-center flex-1 px-8">
                <div class="relative group">
                    <button class="flex items-center space-x-1 text-neutral hover:text-primary transition-colors duration-200">
                        <span>Catégories</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute hidden group-hover:block w-64 bg-base-100 shadow-lg rounded-lg mt-2 p-2 border border-base-300">
                        <a href="#" class="flex items-center p-3 hover:bg-base-200 rounded-md transition-colors duration-200">
                            <i class="fas fa-code text-primary w-6"></i>
                            <span>Développement Web</span>
                        </a>
                        <a href="#" class="flex items-center p-3 hover:bg-base-200 rounded-md transition-colors duration-200">
                            <i class="fas fa-paint-brush text-primary w-6"></i>
                            <span>Design</span>
                        </a>
                        <a href="#" class="flex items-center p-3 hover:bg-base-200 rounded-md transition-colors duration-200">
                            <i class="fas fa-chart-line text-primary w-6"></i>
                            <span>Marketing</span>
                        </a>
                    </div>
                </div>
                <div class="flex-1 px-8">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher un cours..." class="w-full pl-10 pr-4 py-2 bg-base-200 border border-base-300 rounded-full focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-3 text-neutral/50"></i>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="auth/login.php"class="px-4 py-2 text-neutral hover:text-primary transition-colors duration-200 hover:bg-base-200 rounded-md">Connexion</a>
                <a href="auth/registre.php" class="px-6 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition-colors duration-200 shadow-md hover:shadow-lg">S'inscrire</a>
            </div>

            <!-- Menu mobile -->
            <div class="md:hidden">
                <button class="text-neutral hover:text-primary transition-colors" id="mobile-menu-button">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Menu mobile -->
<div class="hidden md:hidden fixed w-full bg-base-100 shadow-lg z-40 top-16" id="mobile-menu">
    <div class="px-4 py-2">
        <div class="relative mb-4">
            <input type="text" placeholder="Rechercher un cours..." class="w-full pl-10 pr-4 py-2 bg-base-200 border border-base-300 rounded-full focus:outline-none focus:border-primary">
            <i class="fas fa-search absolute left-3 top-3 text-neutral/50"></i>
        </div>
        <a href="#" class="block py-2 text-neutral hover:bg-base-200 rounded-md">Catégories</a>
        <div class="flex flex-col space-y-2 mt-4">
            <a href="./auth/login.php" class="inline-block px-4 py-2 text-neutral hover:bg-base-200 hover:text-primary rounded-md transition duration-300">Connexion</a>
            <a href="./auth/registre.php" class="inline-block px-4 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition duration-300">S'inscrire</a>
        </div>
    </div>
</div>

<!-- Section Hero avec fond dynamique -->
<section class="pt-24 pb-16 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Effet de particules/points -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute h-4 w-4 bg-white rounded-full top-1/4 left-1/4 animate-pulse"></div>
            <div class="absolute h-4 w-4 bg-white rounded-full top-3/4 left-1/2 animate-pulse delay-100"></div>
            <div class="absolute h-4 w-4 bg-white rounded-full top-1/2 right-1/4 animate-pulse delay-200"></div>
        </div>

        <div class="relative text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 font-serif">
                Découvrez votre potentiel avec <br/>
                <span class="bg-gradient-to-r from-white to-base-200 text-transparent bg-clip-text">Youdemy</span>
            </h1>
            <p class="text-lg md:text-xl text-base-200 mb-8 max-w-2xl mx-auto">
                Accédez à plus de 1000 cours de qualité et développez vos compétences avec les meilleurs experts.
            </p>
            <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-4">
                <button class="px-8 py-3 bg-white text-primary rounded-full hover:bg-base-200 transition-colors duration-200 shadow-lg hover:shadow-xl">
                    Commencer gratuitement
                </button>
                <button class="px-8 py-3 border-2 border-white text-white rounded-full hover:bg-white hover:text-primary transition-all duration-200">
                    En savoir plus
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Section Statistiques -->
<section class="py-12 bg-base-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6 hover:bg-base-100 rounded-lg transition-colors">
                <div class="text-3xl font-bold text-primary mb-2">100K+</div>
                <div class="text-neutral">Étudiants actifs</div>
            </div>
            <div class="p-6 hover:bg-base-100 rounded-lg transition-colors">
                <div class="text-3xl font-bold text-primary mb-2">1000+</div>
                <div class="text-neutral">Cours disponibles</div>
            </div>
            <div class="p-6 hover:bg-base-100 rounded-lg transition-colors">
                <div class="text-3xl font-bold text-primary mb-2">4.8/5</div>
                <div class="text-neutral">Note moyenne</div>
            </div>
        </div>
    </div>
</section>

<!-- Section Pourquoi choisir Youdemy -->
<section class="py-16 bg-base-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-primary mb-8 text-center font-serif">Pourquoi choisir Youdemy ?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-base-200 p-6 rounded-lg shadow-md">
                <i class="fas fa-graduation-cap text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Expertise reconnue</h3>
                <p>Nos formateurs sont des experts dans leur domaine, garantissant une formation de qualité.</p>
            </div>
            <div class="bg-base-200 p-6 rounded-lg shadow-md">
                <i class="fas fa-clock text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Flexibilité totale</h3>
                <p>Apprenez à votre rythme, où que vous soyez, quand vous le souhaitez.</p>
            </div>
            <div class="bg-base-200 p-6 rounded-lg shadow-md">
                <i class="fas fa-certificate text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Certifications reconnues</h3>
                <p>Obtenez des certifications valorisées par les employeurs du monde entier.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Cours Populaires -->
<section class="py-16 bg-base-200" id="courses-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-primary mb-4 font-serif">Cours les plus populaires</h2>
            <p class="text-neutral">Découvrez nos cours les mieux notés par la communauté</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="courses-grid">
            <?php foreach($current_courses as $course): ?>
            <div class="bg-base-100 rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-105">
                <img 
                    src="<?php echo isset($course['image_url']) ? htmlspecialchars($course['image_url']) : 'https://www.tailwindai.dev/placeholder.svg'; ?>"
                    alt="<?php echo isset($course['titre']) ? htmlspecialchars($course['titre']) : ''; ?>"
                    class="w-full h-48 object-cover"
                >
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm">
                            <?php echo isset($course['category']) ? htmlspecialchars($course['titre']) : 'Non catégorisé'; ?>
                        </span>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="ml-1 text-neutral"><?php echo isset($course['note']) ? number_format($course['note'], 1) : '4.5'; ?></span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-neutral mb-2">
                        <?php echo isset($course['titre']) ? htmlspecialchars($course['titre']) : ''; ?>
                    </h3>
                    <p class="text-neutral text-sm mb-4">
                        <?php echo isset($course['description']) ? htmlspecialchars($course['description']) : 'Description non disponible'; ?>
                    </p>
                    
                    <?php if(isset($course['tags']) && is_array($course['tags'])): ?>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach($course['tags'] as $tag): ?>
                        <span class="text-xs bg-base-200 text-neutral px-2 py-1 rounded-full">
                            <?php echo is_string($tag) ? htmlspecialchars($tag) : ''; ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center justify-between">
                        <a href="auth/login.php" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200">
                            S'inscrire au cours
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($current_courses)): ?>
            <div class="col-span-3 text-center py-8">
                <p class="text-neutral text-lg">Aucun cours disponible pour le moment.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="flex justify-center mt-8 space-x-2">
            <?php if($total_pages > 1): ?>
                <div class="flex space-x-2">
                    <?php if($current_page > 1): ?>
                        <button onclick="changePage(<?php echo $current_page - 1; ?>)" class="px-4 py-2 rounded-lg bg-base-100 text-neutral hover:bg-primary/10">
                            Précédent
                        </button>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <button onclick="changePage(<?php echo $i; ?>)" 
                                class="px-4 py-2 rounded-lg <?php echo $current_page === $i ? 'bg-primary text-white' : 'bg-base-100 text-neutral hover:bg-primary/10'; ?>">
                            <?php echo $i; ?>
                        </button>
                    <?php endfor; ?>

                    <?php if($current_page < $total_pages): ?>
                        <button onclick="changePage(<?php echo $current_page + 1; ?>)" class="px-4 py-2 rounded-lg bg-base-100 text-neutral hover:bg-primary/10">
                            Suivant
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- Section Nos Partenaires -->
<section class="py-16 bg-base-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-primary mb-8 text-center font-serif">Nos Partenaires</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
            <img src="https://www.tailwindai.dev/placeholder.svg" alt="Partenaire 1" class="h-16 object-contain mx-auto filter grayscale hover:grayscale-0 transition-all duration-300">
            <img src="https://www.tailwindai.dev/placeholder.svg" alt="Partenaire 2" class="h-16 object-contain mx-auto filter grayscale hover:grayscale-0 transition-all duration-300">
            <img src="https://www.tailwindai.dev/placeholder.svg" alt="Partenaire 3" class="h-16 object-contain mx-auto filter grayscale hover:grayscale-0 transition-all duration-300">
            <img src="https://www.tailwindai.dev/placeholder.svg" alt="Partenaire 4" class="h-16 object-contain mx-auto filter grayscale hover:grayscale-0 transition-all duration-300">
        </div>
    </div>
</section>

<!-- Section Avis des Étudiants -->
<section class="py-16 bg-base-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-primary mb-8 text-center font-serif">Ce que disent nos étudiants</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-base-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=John" alt="John" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-bold">John Doe</h3>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-neutral">"Les cours sur Youdemy ont vraiment boosté ma carrière. Je recommande à 100% !"</p>
            </div>
            <div class="bg-base-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=Jane" alt="Jane" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-bold">Jane Smith</h3>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-neutral">"La qualité des cours et le support sont exceptionnels. J'ai appris énormément en peu de temps."</p>
            </div>
            <div class="bg-base-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=Mike" alt="Mike" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h3 class="font-bold">Mike Johnson</h3>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-neutral">"Youdemy m'a permis de me reconvertir dans le développement web. Une expérience incroyable !"</p>
            </div>
        </div>
    </div>
</section>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-secondary mb-12">Votre parcours d'apprentissage</h2>
        <div class="relative">
            <div class="absolute left-1/2 w-1 h-full bg-primary transform -translate-x-1/2"></div>
            <div class="space-y-12">
                <div class="flex items-center">
                    <div class="w-1/2 pr-8 text-right">
                        <h3 class="text-xl font-semibold text-secondary mb-2">Choisissez votre domaine</h3>
                        <p class="text-gray-600">Explorez notre vaste catalogue de cours dans divers domaines</p>
                    </div>
                    <div class="w-4 h-4 bg-primary rounded-full border-4 border-white z-10"></div>
                    <div class="w-1/2 pl-8"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-1/2 pr-8"></div>
                    <div class="w-4 h-4 bg-primary rounded-full border-4 border-white z-10"></div>
                    <div class="w-1/2 pl-8">
                        <h3 class="text-xl font-semibold text-secondary mb-2">Suivez les cours à votre rythme</h3>
                        <p class="text-gray-600">Apprenez quand vous voulez, où vous voulez</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-1/2 pr-8 text-right">
                        <h3 class="text-xl font-semibold text-secondary mb-2">Pratiquez avec des projets réels</h3>
                        <p class="text-gray-600">Appliquez vos connaissances sur des cas concrets</p>
                    </div>
                    <div class="w-4 h-4 bg-primary rounded-full border-4 border-white z-10"></div>
                    <div class="w-1/2 pl-8"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-1/2 pr-8"></div>
                    <div class="w-4 h-4 bg-primary rounded-full border-4 border-white z-10"></div>
                    <div class="w-1/2 pl-8">
                        <h3 class="text-xl font-semibold text-secondary mb-2">Obtenez votre certification</h3>
                        <p class="text-gray-600">Validez vos compétences avec un certificat reconnu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<footer class="bg-neutral text-base-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4 font-serif">À propos de Youdemy</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary transition-colors">Qui sommes-nous</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Carrières</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Presse</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 font-serif">Ressources</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Tutoriels</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 font-serif">Communauté</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary transition-colors">Forum</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Événements</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Partenaires</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 font-serif">Suivez-nous</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-2xl hover:text-primary transition-colors"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-2xl hover:text-primary transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-2xl hover:text-primary transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-2xl hover:text-primary transition-colors"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-base-300 text-center">
            <p>&copy; 2023 Youdemy. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<script>
    // Script pour le menu mobile
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
    // Function to change page
function changePage(newPage) {
    // Create a new URL with the updated page parameter
    const url = new URL(window.location.href);
    url.searchParams.set('page', newPage);
    
    // Update the URL without refreshing the page
    window.history.pushState({}, '', url);
    
    // Fetch new content
    fetch(url)
        .then(response => response.text())
        .then(html => {
            // Create a temporary container
            const temp = document.createElement('div');
            temp.innerHTML = html;
            
            // Extract the courses grid content
            const newCoursesGrid = temp.querySelector('#courses-grid');
            const newPagination = temp.querySelector('#pagination-container');
            
            // Update the content
            if(newCoursesGrid) {
                document.querySelector('#courses-grid').innerHTML = newCoursesGrid.innerHTML;
            }
            if(newPagination) {
                document.querySelector('#pagination-container').innerHTML = newPagination.innerHTML;
            }
            
            // Scroll to courses section smoothly
            document.querySelector('#courses-section').scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => {
            console.error('Error fetching page:', error);
        });
}

// Add event listener for browser back/forward buttons
window.addEventListener('popstate', () => {
    const url = new URL(window.location.href);
    const page = url.searchParams.get('page') || 1;
    changePage(page);
});
</script>

</body>
</html>
