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

}