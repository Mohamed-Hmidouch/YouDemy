<?php

namespace App\Controllers;

use App\Models\TagsModel;
class TagsController
{
    private $TagsModel;
    public function __construct()
    {
        $this->TagsModel = new TagsModel();
    }
    public function read(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        $tags = $this->TagsModel->findAll();
        if ($tags == null) {
            echo "No tags found found";
        } else {
            $_SESSION['tags'] = array_map(function($Tag) {
                return [
                    'id' => $Tag->getId(),
                    'titre' => $Tag->getTitre(),
                ];
            }, $tags);
        }
    }
    public function create($tagName){
        $this->TagsModel->createTag($tagName);
    }
    public function update($id,$tagName){
        $this->TagsModel->updateTag($id, $tagName);
    }
    public function delete($id){
        $this->TagsModel->delete($id);
    }
}