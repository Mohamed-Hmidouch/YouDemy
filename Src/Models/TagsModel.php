<?php
namespace App\Models;
require_once __DIR__. "/../../vendor/autoload.php";
use App\Classes\Tag;
use PDO;
use PDOException;


class TagsModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct('Tags');
    }
    public function findAll(){
        try{
            $query = $this->connection->prepare("SELECT * FROM $this->table where deleted_at is null");
            $query->execute();
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            if(!$rows){
                return null;
            }else{
                $Tags = [];
                foreach ($rows as $row) {
                    $Tags[] = new Tag($row['id'], $row['titre']);
                }
                return $Tags;
            }

        }catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
    public function createTag($title)
    {
        try {
            // Création de la requête SQL
            $query = "INSERT INTO $this->table (titre) VALUES (:titre)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':titre', $title, PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Database Error (createCategory): " . $e->getMessage());
            return null;
        }
    }
    public function updateTag($id, $title) {
        try {
            $query = "UPDATE $this->table SET titre = :titre WHERE id = :id";
            
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':titre', $title, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'tag updated successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to update tag'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}