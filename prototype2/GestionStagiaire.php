<?php
include "./Stagiaire.php";
include "./Ville.php";

class GestionStagiaire
{
    private $serverName = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname  = "prototype2";
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
    public function ajouterStagiaire($nom, $cne, $ville)
{
    try {
        // Check if the intern with the same CNE already exists
        $checkSql = "SELECT personne.Id FROM personne INNER JOIN ville ON personne.villeid = ville.id WHERE personne.CNE = :CNE";
        $checkResult = $this->pdo->prepare($checkSql);
        $checkResult->bindParam(':CNE', $cne, PDO::PARAM_STR);
        $checkResult->execute();
        $existingIntern = $checkResult->fetch(PDO::FETCH_ASSOC);

        if ($existingIntern) {
            // Intern with the same CNE already exists, you might want to handle this case
            return false;
        }

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
        return false;
    }
}

}