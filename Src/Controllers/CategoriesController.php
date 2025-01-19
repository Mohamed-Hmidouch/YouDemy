<?php

namespace App\Controllers;
require_once __DIR__ . "/../../vendor/autoload.php";

use App\Models\CategoriesModel;

class CategoriesController
{
    private $categoriesModel;
    public function __construct()
    {
        $this->categoriesModel = new CategoriesModel();
    }
    public function read(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $categories = $this->categoriesModel->findAll();
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
public function create($categoryName){
    $this->categoriesModel->createCategory($categoryName);
}
public function update($id, $categoryName) {
    $result = $this->categoriesModel->updateCategory($id, $categoryName);
}
   public function delete($id){
    $this->categoriesModel->delete($id);
     }
}