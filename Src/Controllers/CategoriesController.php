<?php

namespace App\Controllers;
require_once __DIR__ . "/../../vendor/autoload.php";
use App\Models\CategoriesModel;
use App\Classes\Categorie;
class CategoriesController
{
    public function read(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $CategoriesModel = new CategoriesModel();
        $categories = $CategoriesModel->findAll();
        if ($categories == null) {
            echo "No Categories found";
        } else {
            $_SESSION['categories'] = array_map(function($category) {
                return [
                    'id' => $category->getId(),
                    'titre' => $category->getTitre(),
                    'nombre_cours' => $category->getNombreCours(),
                ];
            }, $categories);
        }
}
}
