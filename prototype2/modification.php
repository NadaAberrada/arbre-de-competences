<?php
include "./GestionStagiaire.php";
$GestionStagiaire = new GestionStagiaire();
$Stagiaire = new Stagiaire();

// Assuming you have the selectedStagiaireId from the URL
$selectedStagiaireId = $_GET['id'] ?? null;

// Fetch the selected stagiaire's data
$selectedStagiaire = $GestionStagiaire->getStagiaireById($selectedStagiaireId);
?>

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

    <h2>Modification de votre profil :</h2>
    <form action="" method="post">
        <div class="container"> 
            <label for="CNE"><b>CNE</b></label>
            <input id="CNE" type="text" placeholder="Enter CNE" name="CNE" value="<?= $selectedStagiaire ? $selectedStagiaire->getCNE() : '' ?>" required>  
            
            <label for="nom"><b>Nom</b></label>
            <input id="nom" type="text" placeholder="Enter Nom" name="nom" value="<?= $selectedStagiaire ? $selectedStagiaire->getNom() : '' ?>" required>

            <label for="ville"><b>Ville</b></label>
            <input id="ville" type="text" placeholder="Enter Ville" name="ville" value="<?= $selectedStagiaire ? $selectedStagiaire->getVille() : '' ?>" required>

            <button id="edit" type="submit" name="edit"><b>Modifier</b> </button>
        </div>
    </form>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $selectedStagiaireId; // Use the ID from the URL
        $nom = $_POST['nom'];
        $cne = $_POST['CNE'];
        $ville = $_POST['ville'];
 
        $stagaiaire = new Stagiaire($id, $nom, $cne, $ville);
      
        // Call the function to modify the Stagiaire
        $success = $GestionStagiaire->ModifierStagiaire($stagaiaire);

        if ($success) {
            echo "<p>Modification successful!</p>";
        } else {
            echo "<p>Modification failed. Please check your input or try again later.</p>";
        }
    }
    
    ?>
</body>

</html>
