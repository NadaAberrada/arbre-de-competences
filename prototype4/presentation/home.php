<?php
include "../application/GestionStagiaire.php";

// Trouver tous les stagiaire depuis la base de données 
$GestionStagiaire = new GestionStagiaire();
$StagiaresData = $GestionStagiaire->getStagiaires();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Arbre Competences</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .action-column {
            width: 20%;
        }
        .ajouter-button {
            margin-bottom: 20px;
            padding: 10px 20px; /* Adjust padding as needed */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Arbre des Competences</h2>

        <a href="ajouter.php" class="btn btn-primary ajouter-button pb-3">Ajouter Stagiaire</a>
        <table>
            <tr>
                <th>Nom</th>
                <th>CNE</th>
                <th>Ville</th>
                <th class="action-column">Modification</th>
                <th class="action-column">Supprimer</th>
        
            </tr>
            <?php
            foreach ($StagiaresData as $Stagiaire) {
            ?>
                <tr>
                    <td><?= $Stagiaire->getNom() ? $Stagiaire->getNom() : "null" ?></td>
                    <td><?= $Stagiaire->getCNE() ? $Stagiaire->getCNE() : "null"; ?></td>
                    <td><?= $Stagiaire->getVille() ? $Stagiaire->getVille() : "null"; ?></td>
                    <td><a href="modification.php?id=<?= $Stagiaire->getId() ?>">Modifier</a></td>
                    <td><a href="delete_stagiaire.php?id=<?= $Stagiaire->getId() ?>">Supprimer</a></td>
                    

                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
