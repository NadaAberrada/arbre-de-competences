<?php

include "./GestionStagiaire.php";
$GestionStagiaire = new GestionStagiaire();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Stagiaire Count by Ville</title>
</head>

<body>
    <div style="width: 80%; margin: 0 auto;">
        <h2>Stagiaire Count by Ville</h2>
        <canvas id="stagiaireChart" width="400" height="200"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the chart data from PHP
            var chartData = <?php echo $GestionStagiaire->countstagiaire(); ?>;

            // Prepare data for Chart.js
            const villeNames = chartData.map(entry => entry.Ville);
            const stagiaireCounts = chartData.map(entry => entry.StagiaireCount);

            // Create Chart.js bar chart
            var ctx = document.getElementById('stagiaireChart').getContext('2d');
            var stagiaireChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: villeNames,
                    datasets: [{
                        label: 'Stagiaire Count',
                        data: stagiaireCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
