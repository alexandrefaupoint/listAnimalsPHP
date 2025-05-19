<?php
require_once("Animal.php");
require_once("lib.php");

class AnimalStorageMySQL implements AnimalStorage {
    private $pdo;

    public function __construct(PDO $pdo) {
        // Utilisation de la fonction connecter() pour établir la connexion
        $this->pdo = $pdo;
        
        // Vérification de la connexion
        if ($this->pdo === null) {
            throw new Exception("Connexion à la base de données échouée.");
        }
    }

    public function read($id) {
        $query = "SELECT * FROM animals WHERE id = :id";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                // Créer une instance d'Animal à partir des données récupérées
                return new Animal($row['name'], $row['species'], $row['age']);
            } else {
                // Aucun animal trouvé
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
            throw $e;
        }
    }

    public function readAll() {
        $query = "SELECT * FROM animals";

        try {
            $stmt = $this->pdo->query($query);
            $results = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Créer un objet Animal pour chaque ligne et l'ajouter au tableau des résultats
                $results[$row['id']] = new Animal($row['name'], $row['species'], $row['age']);
            }

            return $results;
        } catch (PDOException $e) {
            // Afficher l'erreur
            echo "Erreur SQL : " . $e->getMessage();
            throw $e;
        }
    }


    public function create(Animal $animal) {
        $query = "INSERT INTO animals (name, species, age) VALUES (:name, :species, :age)";
        
        try {
            $stmt = $this->pdo->prepare($query);
    
            // Associe les valeurs des propriétés de l'objet Animal
            $stmt->bindValue(':name', $animal->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':species', $animal->getSpecies(), PDO::PARAM_STR);
            $stmt->bindValue(':age', $animal->getAge(), PDO::PARAM_INT);
    
            // Exécute la requête
            $stmt->execute();
    
            // Retourne l'ID généré par la base de données
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // Affiche l'erreur
            echo "Erreur SQL : " . $e->getMessage();
            throw $e;
        }
    }

    public function delete($id) {
        throw new Exception("Method 'delete' not yet implemented.");
    }

    public function update($id, Animal $animal) {
        throw new Exception("Method 'update' not yet implemented.");
    }
}
?>
