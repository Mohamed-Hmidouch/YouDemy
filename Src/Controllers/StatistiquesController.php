<?php
namespace App\Controllers;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\StatistiquesModel;

class StatistiquesController
{
    private $model;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new StatistiquesModel();
    }
    public function getAllEtudiant(){
        $_SESSION['allEtudiants'] = $this->model->getAllEtudiant();
        return $_SESSION['allEtudiants'];
    }

    public function getAllEtudiantInscris(){
        $_SESSION['etudiantsInscrits'] = $this->model->getAllEtudiantInscris();
        return $_SESSION['etudiantsInscrits'];
    }
}
