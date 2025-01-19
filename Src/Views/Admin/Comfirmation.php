<?php
require_once __DIR__ . "/../../../vendor/autoload.php";
use App\Controllers\UsersController;
session_start();
$users = new UsersController();
$users->collectUser();
if(isset($_SESSION['Users'])){
    $UsersData = $_SESSION['Users'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $users->updateUserStatus($id,$status);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs</title>
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
                    <a href="./index.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary text-base-300">
                        <i class="fas fa-chart-pie"></i>
                        <span class="sidebar-label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./Comfirmation.php" class="flex items-center space-x-3 p-3 rounded-lg bg-secondary text-base-100">
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

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-primary">Gestion des Utilisateurs</h2>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead class="bg-base-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
    <?php foreach ($UsersData as $user): ?>
        <tr class="hover:bg-base-200">
            <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($user['nom']); ?></td>
            <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($user['email']); ?></td>
            <td class="px-6 py-4">
                <form action="" method="POST" id="status_form_<?php echo $user['id']; ?>" class="flex gap-4">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <div class="flex items-center">
                        <input type="radio" name="status" value="actif"
                               <?php echo ($user['status'] === 'actif') ? 'checked' : ''; ?>
                               class="w-4 h-4 text-secondary focus:ring-secondary">
                        <label class="ml-2 text-sm">Actif</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="status" value="en_attente"
                            <?php echo ($user['status'] === 'en_attente') ? 'checked' : ''; ?>
                            class="w-4 h-4 text-secondary focus:ring-secondary">
                        <label class="ml-2 text-sm">En attente</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="status" value="suspendu"
                            <?php echo ($user['status'] === 'suspendu') ? 'checked' : ''; ?>
                            class="w-4 h-4 text-secondary focus:ring-secondary">
                        <label class="ml-2 text-sm">Suspendu</label>
                    </div>
                </form>
            </td>
            <td class="px-6 py-4">
                <button type="submit" form="status_form_<?php echo $user['id']; ?>"
                     class="px-3 py-1 text-sm text-white bg-secondary rounded hover:bg-primary">
                    Sauvegarder
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>