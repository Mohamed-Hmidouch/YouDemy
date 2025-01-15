<?php

namespace App\Classes;

class Tag
{
    private $id;
    private $titre;
    private $created_at;
    private $updated_at;

    public function __construct($id, $titre,$created_at='', $updated_at='') {
        $this->id = $id;
        $this->titre = $titre;
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
}