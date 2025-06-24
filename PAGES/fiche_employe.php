<?php
require_once("../includes/fonctions.php");

if (!isset($_GET['emp_no'])) {
    echo "Aucun employe selectionne.";
    exit();
}

$emp_no = mysqli_real_escape_string($bdd, $_GET['emp_no']);


$sqlEmp = "SELECT * FROM employees WHERE emp_no = '$emp_no'";
$resEmp = mysqli_query($bdd, $sqlEmp);
$employe = mysqli_fetch_assoc($resEmp);

$sqlSal = "SELECT salary, from_date, to_date FROM salaries WHERE emp_no = '$emp_no' ORDER BY from_date DESC";
$resSal = mysqli_query($bdd, $sqlSal);

$sqlTit = "SELECT title, from_date, to_date FROM titles WHERE emp_no = '$emp_no' ORDER BY from_date DESC";
$resTit = mysqli_query($bdd, $sqlTit);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche employe</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/style.css" rel="stylesheet">
</head>
<body class="container">
    <h2 class="mt-4">Fiche de l'employé : <?= htmlspecialchars($employe['first_name'] . " " . $employe['last_name']) ?></h2>
    <a href="recherche.php" class="btn btn-primary mb-3">Rechercher des employes</a>

    <p><strong>Sexe :</strong> <?= htmlspecialchars($employe['gender']) ?></p>
    <p><strong>Date de naissance :</strong> <?= htmlspecialchars($employe['birth_date']) ?></p>
    <p><strong>Date d'embauche :</strong> <?= htmlspecialchars($employe['hire_date']) ?></p>

    <h4>Historique des salaires</h4>
    <ul>
        <?php while ($sal = mysqli_fetch_assoc($resSal)): ?>
            <li><?= htmlspecialchars($sal['salary']) ?> Ar (<?= htmlspecialchars($sal['from_date']) ?> - <?= htmlspecialchars($sal['to_date'] == '9999-01-01' ? 'Present' : $sal['to_date']) ?>)</li>
        <?php endwhile; ?>
    </ul>

    <h4>Historique des postes</h4>
    <ul>
        <?php while ($tit = mysqli_fetch_assoc($resTit)): ?>
            <li><?= htmlspecialchars($tit['title']) ?> (<?= htmlspecialchars($tit['from_date']) ?> - <?= htmlspecialchars($tit['to_date'] == '9999-01-01' ? 'Present' : $tit['to_date']) ?>)</li>
        <?php endwhile; ?>
    </ul>

    <a href="employes.php?dept=<?= htmlspecialchars($_GET['dept'] ?? '') ?>" class="btn btn-secondary">Retour</a>
            <footer> 4212 et 4352</footer>

</body>
</html>