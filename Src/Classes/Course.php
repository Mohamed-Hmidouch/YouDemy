<?php

namespace App\Classes;

class Course
{
    private $id;
    private $titre;
    private $description;
    public $contenu;
    public $categorie;
    public $tags = [];
    private $created_at;

    public function __construct($id, $titre,$description,$categorie,$contenu,$tags,$created_at='') {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->contenu = $contenu;
        $this->categorie = $categorie;
        $this->tags = $tags;
        $this->created_at = $created_at;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitre(){
        return $this->titre;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

}