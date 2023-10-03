<?php
include "../application/GestionStagiaire.php";

// Assuming you have the selectedStagiaireId from the URL
$selectedStagiaireId = $_GET['id'] ?? null;

// Create an instance of GestionStagiaire
$GestionStagiaire = new GestionStagiaire();

// Call the function to delete the Stagiaire
$success = $GestionStagiaire->supprimerStagiaire($selectedStagiaireId);

if ($success) {
    echo "<p>Deletion successful!</p>";
} else {
    echo "<p>Deletion failed. Please check your input or try again later.</p>";
}

// You can add a link to redirect back to the main page or any other page
echo '<a href="home.php">Back to Main Page</a>';
?>
