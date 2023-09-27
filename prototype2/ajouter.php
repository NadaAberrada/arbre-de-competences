<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./UI/Style/style.css">
    <title>Add Stagiaire</title>
    <style>
        .container {
            width: 50%;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Stagiaire</h2>
        <?php
        include "./GestionStagiaire.php";

        $GestionStagiaire = new GestionStagiaire();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $cne = $_POST['cne'];
            $ville = $_POST['ville'];

            // Call the function to add Stagiaire
            $success = $GestionStagiaire->ajouterStagiaire($nom, $cne, $ville);

            if ($success) {
                echo '<p class="message success">Stagiaire added successfully!</p>';
            } else {
                echo '<p class="message error">Failed to add Stagiaire. Please check your input or try again later.</p>';
            }
        }
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="cne">CNE:</label>
            <input type="text" id="cne" name="cne" required>

            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville" required>

            <button type="submit">Add Stagiaire</button>
        </form>
    </div>
</body>

</html>
