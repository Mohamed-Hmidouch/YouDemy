<?php
namespace App\Models;
require_once __DIR__. "/../../vendor/autoload.php";
use PDOException;
use PDO;
use App\Classes\Categorie;
class CategoriesModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct('Categories');
    }


    public function findAll(){
        try{
            $query = $this->connection->prepare("SELECT * FROM $this->table");
            $query->execute();
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            if(!$rows){
                return null;
            }else{
                $categories = [];
                foreach ($rows as $row) {
                    $categories[] = new Categorie($row['id'], $row['titre'], $row['nombre_cours']);
                }
                return $categories;
            }

        }catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
    public function createCategory($title)
    {
        try {
            // Création de la requête SQL
            $query = "INSERT INTO $this->table (titre) VALUES (:title)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->execute();// Assumant que 'nombre_cours' est 0 par défaut
        } catch (PDOException $e) {
            // Journalisation de l'erreur pour débogage
            error_log("Database Error (createCategory): " . $e->getMessage());
            return null;
        }
    }

public function updateCategory($id, $title) {
    try {
        $query = "UPDATE $this->table SET titre = :titre WHERE id = :id";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':titre', $title, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        
        if ($result) {
            return [
                'success' => true,
                'message' => 'Category updated successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update category'
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