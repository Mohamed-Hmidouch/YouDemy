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

    public function __construct($id, $titre,$description,$contenu,$categorie,$tags,$created_at='') {
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
    public function getdescription(){
        return $this->description;
    }
    public function getContenu(){
        return $this->contenu;
    }
    public function getCategorie(){
        return $this->categorie;
    }
    public function getTags(){
        return $this->tags;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

}