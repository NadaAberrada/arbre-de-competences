<?php

class StudentDAO{
    private $db;
    private $databaseConnectionObj;

    public function __construct(){
        $this->databaseConnectionObj = new DatabaseConnection();
        $this->db = $this->databaseConnectionObj->connect();
    }
    
}
?>