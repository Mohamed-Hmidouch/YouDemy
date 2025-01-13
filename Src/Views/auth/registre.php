<?php
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
            <form>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" placeholder="Name" class="input input-bordered" required />
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" placeholder="Email" class="input input-bordered" required />
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" placeholder="Password" class="input input-bordered" required />
                </div>
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text">Role</span>
                    </label>
                    <select class="select select-bordered w-full">
                        <option disabled selected>Choose your role</option>
                        <option>Étudiant</option>
                        <option>Enseignant</option>
                    </select>
                </div>
                <button class="btn btn-primary w-full mb-4">Sign Up</button>
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

