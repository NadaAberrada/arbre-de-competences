<?php
include "./Stagiaire.php";
include "./Ville.php";

class GestionStagiaire
{
    private $serverName = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname  = "prototype1";
    private $charset = "utf8mb4";
    protected $pdo;


    public function __construct()
    {
        $this->serverName = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "prototype1";
        $this->charset = "utf8mb4";
        try {
            $DB_con = "mysql:host=" . $this->serverName . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
            $this->pdo = new PDO($DB_con, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->pdo;
        } catch (PDOException $e) {
            echo "Failed to connect with MySQL: " . $e->getMessage();
        }
    }
    public function getStagiaires()
    {
        $sql = "SELECT personne.id, personne.Nom, personne.CNE, ville.Ville FROM personne LEFT JOIN ville ON personne.villeid = ville.id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $StagiairesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $Stagiaires = array();

        foreach ($StagiairesData as $StagiaireData) {
            $Stagiaire = new Stagiaire();
            $Ville = new Ville();
            $Stagiaire->setId($StagiaireData['id']);
            $Stagiaire->setNom($StagiaireData['Nom']);
            $Stagiaire->setCNE($StagiaireData['CNE']);
            $Ville->setVille($StagiaireData['Ville']);
            $Stagiaire->setVille($Ville->getVille());
            array_push($Stagiaires, $Stagiaire);
        }
        return $Stagiaires;
    }
    public function getStagiaireById($id)
    {
        $sql = "SELECT personne.id, personne.Nom, personne.CNE, ville.Ville 
            FROM personne 
            LEFT JOIN ville ON personne.villeid = ville.id 
            WHERE personne.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stagiaireData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$stagiaireData) {
            return null; // Stagiaire with the given ID not found
        }

        $stagiaire = new Stagiaire();
        $ville = new Ville();

        $stagiaire->setId($stagiaireData['id']);
        $stagiaire->setNom($stagiaireData['Nom']);
        $stagiaire->setCNE($stagiaireData['CNE']);      
        $ville->setVille($stagiaireData['Ville']);
        $stagiaire->setVille($ville->getVille());

        return $stagiaire;
    }
    public function ajouterStagiaire($nom, $cne, $ville)
    {
        try {
            // Validate input
            if (empty($nom) || empty($cne) || empty($ville)) {
                return false; // Input values are not valid
            }
             // Check if the ville exists or add it if it doesn't
            $queryVille = "SELECT id FROM ville WHERE Ville = :nom_ville";
            $stmtVille = $this->pdo->prepare($queryVille);
            $stmtVille->bindParam(':nom_ville', $ville);
            $stmtVille->execute();
    
            $id_ville = $stmtVille->fetch(PDO::FETCH_ASSOC);
    
            if (!$id_ville) {
                return false; // Ville doesn't exist
            }
    
            // Insert the new intern
            $queryPersonne = "INSERT INTO personne (nom, CNE, villeid) VALUES (:nom, :cne, :idville)";
            $stmtPersonne = $this->pdo->prepare($queryPersonne);
            $stmtPersonne->bindParam(':nom', $nom);
            $stmtPersonne->bindParam(':cne', $cne);
            $stmtPersonne->bindParam(':idville', $id_ville['id']);
            $stmtPersonne->execute();
    
            // Get the ID of the newly inserted intern
            $personneId = $this->pdo->lastInsertId();
    
            return $personneId;
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    



    public function ModifierStagiaire($id, $nom, $cne, $ville)
    {
        try {

            $id = $id;
            $nom =  $nom;
            $cne = $cne;
            $ville = $ville;
            // Check if the ville exists or add it if it doesn't
            $queryVille = "SELECT id FROM ville WHERE Ville = :nom_ville";
            $stmtVille = $this->pdo->prepare($queryVille);
            $stmtVille->bindParam(':nom_ville', $ville);
            $stmtVille->execute();

            $id_ville = $stmtVille->fetch(PDO::FETCH_ASSOC);

            if (!$id_ville) {
                // Ville doesn't exist, you might want to handle this case
                return false;
            }
            // Update the intern's details
            $updateSql = "UPDATE personne SET nom = :nom, CNE = :cne, villeid = :idville WHERE id = :id";
            $updateResult = $this->pdo->prepare($updateSql);
            $updateResult->bindParam(':id', $id, PDO::PARAM_INT);
            $updateResult->bindParam(':nom', $nom);
            $updateResult->bindParam(':cne', $cne);
            $updateResult->bindParam(':idville', $id_ville['id']);
            $updateResult->execute();

            return true; // Intern details updated successfully
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return false;
        }
    }




    public function supprimerStagiaire($id)
    {
        try {
            // Check if the intern with the given ID exists 
            $checkSql = "SELECT * FROM personne WHERE id = :id";
            $checkResult = $this->pdo->prepare($checkSql);
            $checkResult->bindParam(':id', $id, PDO::PARAM_INT);
            $checkResult->execute();
            $existingIntern = $checkResult->fetch(PDO::FETCH_ASSOC);

            if (!$existingIntern) {
                // Intern with the given ID does not exist, you might want to handle this case
                return false;
            }

            // Delete the intern
            $deleteSql = "DELETE FROM personne WHERE id = :id";
            $deleteResult = $this->pdo->prepare($deleteSql);
            $deleteResult->bindParam(':id', $id, PDO::PARAM_INT);
            $deleteResult->execute();

            // Check if any rows were affected
            if ($deleteResult->rowCount() > 0) {
                return true; // Intern deleted successfully
            } else {
                // No rows affected, deletion might have failed
                return false;
            }
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
