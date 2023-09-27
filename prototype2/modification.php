
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style.css">
    <title>Modifier : </title>
</head>

<body>

    <h2>Modification de voter profile : </h2>
    <form action="" method="post">
        <div class="container"> 
             <label for="CNE"><b>CNE</b></label>
            <input id="CNE" type="text" placeholder="Enter CNE" name="CNE" >  
            
            <label for="nom"><b>Nom</b></label>
            <input id="nom" type="text" placeholder="Enter Nom" name="nom" >

          

            <label for="ville"><b>Ville</b></label>
            <input id="ville" type="text" placeholder="Enter ville" name="ville" > 

            <button id="edit" type="submit" name="edit"><b>Modifier</b> </button>
        </div>
    </form>



<?php 
include "GestionStagiaire.php";

$gestionStagiaires = new GestionStagiaire();
$Stagiaire = new Stagiaire();





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Stagiaire->setNom($_POST['nom']);
    $Stagiaire->setCNE($_POST['CNE']);
    $Stagiaire->setVilleid($_POST['ville']);
    $gestionStagiaires->ModifierStagiaire($Stagiaire);
}




?>
</body>

</html>
