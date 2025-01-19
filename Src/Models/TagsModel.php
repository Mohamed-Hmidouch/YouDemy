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
}