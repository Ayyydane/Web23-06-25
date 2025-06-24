<?php
require_once("../includes/fonctions.php");
$departements = getDepartementsAvecManager();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Départements</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container mt-5">
    <h1 class="mb-4">Liste des Departements</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Manager</th>
                <th>Voir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($departements); $i++) {
                echo "<tr>";
                echo "<td>" . $departements[$i]['dept_no'] . "</td>";
                echo "<td>" . $departements[$i]['dept_name'] . "</td>";
                echo "<td>" . $departements[$i]['first_name'] . " " . $departements[$i]['last_name'] . "</td>";
                echo "<td><a href='employes.php?dept=" . $departements[$i]['dept_no'] . "' class='btn btn-primary btn-sm'>Voir</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
        <footer> 4212 et 4352</footer>
</body>
</html>
