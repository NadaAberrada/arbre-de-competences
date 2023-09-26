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


        public function __construct(){
            
        }
}


?>