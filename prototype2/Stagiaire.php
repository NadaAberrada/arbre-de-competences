<?php 

class Stagiaire{
    private $Id;
    private $Nom;
    private $CNE;
    private $Villeid;
    
    public function getId()
    {
        return $this->Id;
    }
    public function setId($id)
    {
        $this->Id = $id;
    }
    public function getNom()
    {
        return $this->Nom;
    }
    public function setNom($nom)
    {
        $this->Nom = $nom;
    }
    public function getCNE()
    {
        return $this->CNE;
    }
    public function setCNE($CNE)
    {
        $this->CNE = $CNE;
    }
    public function getVilleid(){
        return $this->Villeid;
    }
    public function setVilleid($villeid){
        $this->Villeid = $villeid;
    }

}



?>