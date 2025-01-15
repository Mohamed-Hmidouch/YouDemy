<?php

namespace App\Controllers;

use App\Models\TagsModel;
use App\Classes\Tags;
class TagsController
{
    public function read(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $TagsModel = new TagsModel();
        $tags = $TagsModel->findAll();
        if ($tags == null) {
            echo "No Categories found";
        } else {
            $_SESSION['tags'] = array_map(function($Tag) {
                return [
                    'id' => $Tag->getId(),
                    'titre' => $Tag->getTitre(),
                ];
            }, $tags);
        }
    }
}