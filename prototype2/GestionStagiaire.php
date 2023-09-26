<?php
include "./Stagiaire.php";
include "./Ville.php";

class GestionStagiaire{
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

}


?>