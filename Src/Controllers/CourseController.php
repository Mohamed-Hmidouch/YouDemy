<?php
namespace App\Controllers;
use App\Models\CourseModel;
use App\Classes\Course;
use Exception;

class CourseController {
    private $courseModel;

    public function __construct() {
        $this->courseModel = new CourseModel();
    }

    public function createCourse($postData, $sessionTags) {
        $titre = trim($postData['titre']);
        $description = trim($postData['description']);
        $contenu = trim($postData['contenu']);
        $categorie_id = (int) $postData['categorie_id'];
        $enseignant_id = (int) $_SESSION['user']['id'];

        $selectedTags = explode(',', $postData['tags_selected']);

        $validTagIds = array_map(function ($tagName) use ($sessionTags) {
            foreach ($sessionTags as $tag) {
                if (trim($tag['titre']) === trim($tagName)) {
                    return $tag['id'];
                }
            }
            return null;
        }, $selectedTags);

        $validTagIds = array_filter($validTagIds);

        $courseId = $this->courseModel->insertCourse($titre, $description, $contenu, $categorie_id, $enseignant_id);

        $this->courseModel->insertCourseTags($courseId, $validTagIds);
        header("Location: ../../Views/Enseignant/index.php");
        return $courseId;
    }
    public function read(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
      try{
        $courses = $this->courseModel->findAll();
        if($courses == null){
            echo "no courses in dtabase ajmi sir inser les donnes";
        }else{
            $_SESSION['courses'] = array_map(function($course){
                $tagsArray = array_map(function($tag){
                    return [
                        'id'=>$tag->getId(),
                        'titre'=>$tag->getTitre()
                    ];
                },$course->getTags());
                $category = [
                    'id'=> $course->getCategorie()->getId(),
                    'titre'=>$course->getCategorie()->getTitre()
                ];
                return [
                    'id' => $course->getId(),
                    'titre' => $course->getTitre(),
                    'description' => $course->getDescription(),
                    'contenu' => $course->getContenu(),
                    'category' => $category,
                    'tags' => $tagsArray
                ];
            },$courses);
        }
      }catch(Exception $e){
        echo "erreur de repeuper de donnes a jmi :".$e->getMessage();
      }
    }
    public function fetchbyId($courseId){
        return $this->courseModel->getbyId($courseId);
        
    }
    
        public function updateCourse($titre, $categorie_id, $tags_selected_ids, $contenu, $description, $enseignant_id, $courseId) {
            $this->courseModel->updateCourse($courseId, $titre, $description, $contenu, $categorie_id, $enseignant_id);
            
            $this->courseModel->updateCourseTags($courseId, $tags_selected_ids);
        }
    }
