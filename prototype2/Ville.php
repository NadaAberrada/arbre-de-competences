<?php
class Villes{
    private $IdVille;
    private $Ville;

    public function getVille()
    {
        return $this->Ville;
    }
    public function setVille($Ville)
    {
        $this->Ville = $Ville;
    }
    public function getIdVille(){
        return $this->IdVille;
    }
    public function setIdVille($IdVille){
        $this->IdVille = $IdVille;
    }

}

?>