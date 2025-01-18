<?php
require_once "../../../vendor/autoload.php";

use App\Controllers\Auth\RegistreAuth;


if(isset($_POST["submit"]))
{
    if(empty($_POST["email"]) || empty($_POST["password"] ||$_POST["nom"]) || empty($_POST["role"]))
    {
        echo "email or password is empty";
    }
    else{
        $name = $_POST["nom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        
        $authController = new RegistreAuth();
        $authController->register($name, $email,$password,$role);
    }
}else{
    echo "error";
    print_r($_POST);
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
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
<body class="bg-base-200 min-h-screen flex items-center justify-center">
<div class="container mx-auto p-4">
    <div class="bg-base-100 rounded-lg shadow-xl overflow-hidden max-w-md mx-auto">
        <div class="p-8">
            <h2 class="text-3xl font-serif text-primary mb-6 text-center">Create Account</h2>
            <form action="" method="POST">
                <div class="form-control mb-4">
                    <label class="label" for="nom">
                        <span class="label-text">Name</span>
                    </label>
                    <input id="nom" name="nom" type="text" placeholder="name" class="input input-bordered" required />
                </div>
                <div class="form-control mb-4">
                    <label class="label" for="email">
                        <span class="label-text">Email</span>
                    </label>
                    <input id="email" name="email" type="email" placeholder="email" class="input input-bordered" required />
                </div>
                <div class="form-control mb-4">
                    <label class="label" for="password">
                        <span class="label-text">Password</span>
                    </label>
                    <input id="password" name="password" type="password" placeholder="password" class="input input-bordered" required />
                </div>
                <div class="form-control mb-6">
                    <label class="label" for="role">
                        <span class="label-text">Role</span>
                    </label>
                    <div>
                        <label class="block text-sm font-medium text-primary mb-4" for="profile-type">
                            Type de profil
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer">
                                <input
                                    type="radio"
                                    name="role"
                                    value="etudiant"
                                    class="sr-only"
                                    id="etudiant-option"
                                >
                                <div class="flex items-center w-full p-4 bg-light border border-gray-300 rounded-lg hover:border-accent group transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-accent/10 mr-4">
                                            <i class="fas fa-user-graduate text-accent"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-primary">Etudiant</p>
                                            <p class="text-sm text-secondary">Apprentissage en ligne</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex cursor-pointer">
                                <input
                                    type="radio"
                                    name="role"
                                    value="enseignant"
                                    class="sr-only"
                                    id="enseignant-option"
                                >
                                <div class="flex items-center w-full p-4 bg-light border border-gray-300 rounded-lg hover:border-accent group transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-accent/10 mr-4">
                                            <i class="fas fa-chalkboard-teacher text-accent"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-primary">Enseignant</p>
                                            <p class="text-sm text-secondary">Créer des cours</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-full mb-4">Sign Up</button>
            </form>
            <div class="divider my-8">OR</div>
            <div class="text-center">
                <a href="login.php" class="btn btn-outline btn-secondary w-full">Already have an account? Sign In</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

