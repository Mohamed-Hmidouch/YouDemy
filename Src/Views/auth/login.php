<?php
namespace App\Auth\login;
require_once '../../../vendor/autoload.php';
use App\Controllers\Auth\LoginAuth;
session_start();
if(isset($_POST["submit"])){
    $donnees = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_DEFAULT,
    ]);
    if(empty($donnees["email"]) && empty($donnees["password"]))
    {
        echo "email or password is empty";
    }else{
        $email = $donnees["email"];
        $password = $donnees["password"];
        $authController = new LoginAuth();
        $authController->login($email, $password);
    }



}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <h2 class="text-3xl font-serif text-primary mb-6 text-center">Sign In</h2>
            <form action="" method="post">
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input value="email" name="email" type="email" placeholder="Email" class="input input-bordered" required />
                </div>
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input value="password" name="password" type="password" placeholder="Password" class="input input-bordered" required />
                </div>
                <button class="btn btn-primary w-full mb-4" type="submit" value="submit" name="submit">Sign In</button>
                <div class="text-center">
                    <a href="#" class="link link-accent">Forgot your password?</a>
                </div>
            </form>
            <div class="divider my-8">OR</div>
            <div class="text-center">
                <a href="registre.php" class="btn btn-outline btn-secondary w-full">Create an Account</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

