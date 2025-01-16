<?php
namespace App\Controllers;
use App\Models\CourseModel;
use App\Classes\Course;
class CourseController {
    private $courseModel;

    public function __construct() {
        $this->courseModel = new CourseModel();
    }

    public function createCourse($postData, $sessionTags) {
        // Validation des données
        $titre = trim($postData['titre']);
        $description = trim($postData['description']);
        $contenu = trim($postData['contenu']);
        $categorie_id = (int) $postData['categorie_id'];
        $enseignant_id = (int) $_SESSION['user']['id'];

        $selectedTags = explode(',', $postData['tags_selected']);

        // Trouver les IDs des tags correspondants
        $validTagIds = array_map(function ($tagName) use ($sessionTags) {
            foreach ($sessionTags as $tag) {
                if (trim($tag['titre']) === trim($tagName)) {
                    return $tag['id'];
                }
            }
            return null;
        }, $selectedTags);

        $validTagIds = array_filter($validTagIds);

        // Insertion du cours
        $courseId = $this->courseModel->insertCourse($titre, $description, $contenu, $categorie_id, $enseignant_id);

        // Insertion des tags associés
        $this->courseModel->insertCourseTags($courseId, $validTagIds);
        header("Location: ../../Views/Enseignant/index.php");
        return $courseId;
    }
    public function read(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $CourseModel = new CourseModel();
        $Courses = $CourseModel->findAll();
        if ($Courses == null) {
            echo "No Courses found found";
        } else {
            $_SESSION['Courses'] = array_map(function($Courses) {
                return [
                    'id' => $Courses->getId(),
                    'titre' => $Courses->getTitre(),
                ];
            }, $Course);
        }
    }
}
