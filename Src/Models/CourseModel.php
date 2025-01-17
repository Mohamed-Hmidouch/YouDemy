<?php

namespace App\Models;

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Classes\Categorie;
use Exception;
use PDOException as DatabaseException;
use PDO;
use App\Classes\Course;
use App\Classes\Tag;

class CourseModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct('Courses');
    }

    public function insertCourse($titre, $description, $contenu, $categorie_id, $enseignant_id)
    {
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

    public function insertCourseTags($courseId, $tagIds)
    {
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
        try {
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
            $courses = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tags = [];
                if (!empty($row['tags'])) {
                    $tagsFetched = explode(',', $row['tags']);
                    foreach ($tagsFetched as $tag) {
                        list($tagId, $tagTitle) = explode(':', $tag);
                        $tags[] = new Tag($tagId, $tagTitle);
                    }
                }

                $category = new Categorie($row['category_id'], $row['category_title']);
                $courses[] = new Course(
                    $row['course_id'],
                    $row['course_title'],
                    $row['course_description'],
                    $row['course_content'],
                    $category,
                    $tags
                );
            }

            return $courses;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        }
    }


    public function getById($courseId) {
        try {
            $sql = "SELECT 
                    c.id AS course_id, 
                    c.titre AS course_title, 
                    c.description AS course_description, 
                    c.contenu AS course_content, 
                    cat.id AS category_id, 
                    cat.titre AS category_title,
                    GROUP_CONCAT(t.id SEPARATOR ',') AS tag_ids,
                    GROUP_CONCAT(t.titre SEPARATOR ',') AS tag_titles
                FROM 
                    Courses c
                LEFT JOIN 
                    Categories cat ON c.categorie_id = cat.id
                LEFT JOIN 
                    Courses_Tags ct ON c.id = ct.course_id
                LEFT JOIN 
                    Tags t ON ct.tag_id = t.id
                WHERE 
                    c.id = :course_id
                GROUP BY 
                    c.id;
            ";
            $stmt = $this->connection->prepare($sql);
            
            $stmt->execute([':course_id' => $courseId]);
     
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du cours : " . $e->getMessage());
        }
    }
    
    public function updateCourse($courseId, $titre, $description, $contenu, $categorie_id, $enseignant_id)
    {
        try {
            $sql = "UPDATE $this->table 
                    SET titre = :titre, description = :description, contenu = :contenu, categorie_id = :categorie_id, enseignant_id = :enseignant_id
                    WHERE id = :courseId";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
            $stmt->bindParam(':categorie_id', $categorie_id, PDO::PARAM_INT);
            $stmt->bindParam(':enseignant_id', $enseignant_id, PDO::PARAM_INT);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour du cours : " . $e->getMessage());
        }
    }
    public function updateCourseTags($courseId, $tagIds)
    {
        try {
          
            $sql = "DELETE FROM Courses_Tags WHERE course_id = :course_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            
            $sql = "INSERT INTO Courses_Tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
            $stmt = $this->connection->prepare($sql);

            
            $tagIdsArray = is_string($tagIds) ? explode(',', $tagIds) : (array)$tagIds;

            foreach ($tagIdsArray as $tagId) {
                $stmt->execute([
                    ':course_id' => $courseId,
                    ':tag_id' => $tagId,
                ]);
            }
        } catch (Exception $e) {
            throw new DatabaseException("Erreur lors de la mise à jour des tags : " . $e->getMessage());
        }
    }
}
