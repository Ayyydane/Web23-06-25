<?php
require_once("../includes/connexion.php");
require_once("../includes/fonctions.php");

if (!isset($_GET['dept'])) {
    echo "Aucun departement selectionne.";
    exit();
}

$dept_no = mysqli_real_escape_string($bdd, $_GET['dept']);
$employees = getEmployesParDepartement($dept_no);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Employes du departement</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/style.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Liste des employes du departement <?= htmlspecialchars($dept_no) ?></h2>
    <a href="recherche.php" class="btn btn-primary mb-3">Rechercher des employes</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Sexe</th>
                <th>Date naissance</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td>
                    <a href="fiche_employe.php?emp_no=<?= htmlspecialchars($emp['emp_no']) ?>&dept=<?= htmlspecialchars($dept_no) ?>">
                        <?= htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($emp['gender']) ?></td>
                <td><?= htmlspecialchars($emp['birth_date']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
        <footer> 4212 et 4352</footer>
</body>
</html>