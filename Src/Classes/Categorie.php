<?php
namespace App\Classes;
class Categorie{
    private $id;
    private $titre;
    private $nombre_cours;
    private $created_at;
    private $updated_at;

    public function __construct($id, $titre,$nombre_cours, $created_at='', $updated_at='') {
        $this->id = $id;
        $this->titre = $titre;
        $this->nombre_cours = $nombre_cours;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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

    public function getUpdatedAt(){
        return $this->updated_at;
    }
    public function getNombreCours(){
        return $this->nombre_cours;
    }
}