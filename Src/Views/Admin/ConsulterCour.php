<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<body>
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
                    <a href="./ConsulterCour.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary text-base-300">
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
        <div class="p-4 border-t border-secondary">
            <button class="flex items-center space-x-3 text-accent hover:bg-secondary p-3 rounded-lg w-full">
                <i class="fas fa-sign-out-alt"></i>
                <span class="sidebar-label">Déconnexion</span>
            </button>
        </div>
    </div>
</body>
</html>