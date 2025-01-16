<?php
namespace App\Models;
require_once __DIR__. "/../../vendor/autoload.php";

use App\Classes\Categorie;
use Exception;
use PDO;
use App\Classes\Course;
use App\Classes\Tag;
class CourseModel extends BaseModel {
    public function __construct() {
        parent::__construct('Courses');
    }

    public function insertCourse($titre, $description, $contenu, $categorie_id, $enseignant_id) {
        try {
            $sql = "INSERT INTO $this->table (titre, description, contenu, categorie_id, enseignant_id) 
                    VALUES (:titre, :description, :contenu, :categorie_id, :enseignant_id)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
            $stmt->bindParam(':categorie_id', $categorie_id, PDO::PARAM_INT);
            $stmt->bindParam(':enseignant_id', $enseignant_id, PDO::PARAM_INT);

            $stmt->execute();

            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'insertion du cours : " . $e->getMessage());
        }
    }

    public function insertCourseTags($courseId, $tagIds) {
        try {
            $sql = "INSERT INTO Courses_Tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
            $stmt = $this->connection->prepare($sql);

            foreach ($tagIds as $tagId) {
                $stmt->execute([
                    ':course_id' => $courseId,
                    ':tag_id' => $tagId,
                ]);
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'insertion des tags : " . $e->getMessage());
        }
    }
    public function findAll()
    {
        try{
            $request = "SELECT 
                        c.id AS course_id, 
                        c.titre AS course_title, 
                        c.description AS course_description, 
                        c.contenu AS course_content, 
                        cat.id AS category_id, 
                        cat.titre AS category_title,
                        GROUP_CONCAT(t.id, ':', t.titre SEPARATOR ',') AS tags
                    FROM 
                        Courses c
                    LEFT JOIN 
                        Categories cat ON c.categorie_id = cat.id
                    LEFT JOIN 
                        Courses_Tags ct ON c.id = ct.course_id
                    LEFT JOIN 
                        Tags t ON ct.tag_id = t.id
                    GROUP BY 
                        c.id";
                $stmt = $this->connection->prepare($request);
                $stmt->execute();
                $Courses = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $tags = [];
                    if(!empty($rows['tags'])){
                        $tagsFetche = explode(',',$row['tags']);
                        foreach($tagsFetche as $tag){
                            list($tagId,$tagTitle) =  explode(':', $tag);
                            $tags[] = new tag($tagId,$tagTitle);
                        }
                    }
                }
                $category = new Categorie($row['category_id'],$row['category_title']);
                $Courses[] = new Course(
                    $row['course_id'],
                    $row['course_title'],
                    $row['course_description'],
                    $row['course_content'],
                    $category,
                    $tags
                );
                return $Courses;
        }catch(Exception $e){
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        }
    }
}
