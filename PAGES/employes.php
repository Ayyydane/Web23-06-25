<?php
require_once("../includes/fonctions.php");

if (isset($_GET['dept'])) {
    $dept_no = $_GET['dept'];
    $employes = getEmployesParDepartement($dept_no);
} else {
    echo "Aucun département sélectionné.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Employés du département</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container mt-5">
    <h2>Employés du département <?= htmlspecialchars($dept_no) ?></h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ Retour</a>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Embauche le</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($j = 0; $j < count($employes); $j++) {
                echo "<tr>";
                echo "<td>" . $employes[$j]['emp_no'] . "</td>";
                echo "<td>" . $employes[$j]['first_name'] . " " . $employes[$j]['last_name'] . "</td>";
                echo "<td>" . $employes[$j]['hire_date'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
