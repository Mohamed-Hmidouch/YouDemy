<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Config\Database;
use PDO;
use Exception;
class StatistiquesModel
{
    private $connection;
    public function __construct()
    {
        $this->connection = Database::getConnection();
    }
 
    public function getAllEtudiant(){
        try {
            $sql = "SELECT (Users.id) FROM Users where deleted_at IS NULL";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $row['id'];
            }
            return $users;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération nombres des cours : " . $e->getMessage());
        }
    }
    public function getAllEtudiantInscris(){
        try {
            $sql = "SELECT COUNT(Inscriptions.id) as Inscriptions FROM Inscriptions";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $inscriptions = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $inscriptions[] = $row['Inscriptions'];
            }
            return $inscriptions;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération nombres des cours : " . $e->getMessage());
        }
    }
    
}