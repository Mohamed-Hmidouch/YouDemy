<?php

namespace App\Classes;

class Role {
    public $id;
    private $name;
    public $created_at;
    public $updated_at;
    
    
    public function __construct($id, $name, $created_at='', $updated_at='') {
            $this->id = $id;
            $this->name = $name;
            $this->created_at = $created_at;
            $this->updated_at = $updated_at;
    }

    public function getTitle(){
        return $this->name;
    }
    
}