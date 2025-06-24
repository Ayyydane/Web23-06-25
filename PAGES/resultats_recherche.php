<?php
require_once("../includes/fonctions.php");

$limit = 20;
$page = 0;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 0) {
    $page = (int)$_GET['page'];
}
$offset = $page * $limit;
$conditions = [];
$debug_info = [];
$error = '';

if (isset($_GET['nom']) && $_GET['nom'] !== '') {
    $nom = mysqli_real_escape_string($bdd, $_GET['nom']);
    if ($nom === '') {
        $error = "vide io sady tsisy espace lty e.";
    } else {
        $conditions[] = "(LOWER(first_name) LIKE LOWER('%$nom%') OR LOWER(last_name) LIKE LOWER('%$nom%'))";
        $debug_info[] = "Nom: $nom";
    }
}

if (isset($_GET['dept']) && $_GET['dept'] !== '') {
    $dept = mysqli_real_escape_string($bdd, $_GET['dept']);
    $conditions[] = "emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no = '$dept' AND to_date = '9999-01-01')";
    $debug_info[] = "Departement: $dept";
}

if (isset($_GET['age_min']) && $_GET['age_min'] !== '' || isset($_GET['age_max']) && $_GET['age_max'] !== '') {
    if (isset($_GET['age_min']) && $_GET['age_min'] !== '' && isset($_GET['age_max']) && $_GET['age_max'] !== '' && $_GET['age_min'] > $_GET['age_max']) {
        $error = "tsy afaka mihotra ny max io e aza daika.";
    } else {
        if (isset($_GET['age_min']) && $_GET['age_min'] !== '') {
            $min = mysqli_real_escape_string($bdd, $_GET['age_min']);
            $conditions[] = "TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= $min";
            $debug_info[] = "Âge minimum: $min";
        }
        if (isset($_GET['age_max']) && $_GET['age_max'] !== '') {
            $max = mysqli_real_escape_string($bdd, $_GET['age_max']);
            $conditions[] = "TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= $max";
            $debug_info[] = "Âge maximum: $max";
        }
    }
}

$where = "";
if ($conditions) {
    $where = "WHERE " . implode(" AND ", $conditions);
}
$sql = "SELECT emp_no, first_name, last_name, gender, birth_date, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age
        FROM employees
        $where
        ORDER BY age ASC
        LIMIT $offset, $limit";

$res = mysqli_query($bdd, $sql);
$sqlCount = "SELECT COUNT(*) as total FROM employees $where";
$resCount = mysqli_query($bdd, $sqlCount);
$totalRows = mysqli_fetch_assoc($resCount)['total'];
$hasNext = ($offset + $limit) < $totalRows;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de la recherche</title>
    <link href="../assets/style.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Résultats de la recherche</h2>
    <a href="recherche.php" class="btn btn-primary mb-3">Nouvelle recherche</a>

    <?php
    if ($error !== '') {
    ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php
    }
    ?>

    <?php
    if ($debug_info) {
    ?>
        <div class="alert alert-secondary">
            <strong>Critères de recherche :</strong>
            <ul>
                <?php
                foreach ($debug_info as $info) {
                ?>
                    <li><?php echo htmlspecialchars($info); ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
    <?php
    }
    ?>

    <?php
    if (mysqli_num_rows($res) == 0) {
    ?>
        <p class="alert alert-info">tsisy an'izany ato.</p>
    <?php
    } else {
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Sexe</th>
                    <th>Date naissance</th>
                    <th>Âge</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($employee = mysqli_fetch_assoc($res)) {
                ?>
                <tr>
                    <td>
                        <a href="fiche_employe.php?emp_no=<?php echo htmlspecialchars($employee['emp_no']); ?>">
                            <?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($employee['gender']); ?></td>
                    <td><?php echo htmlspecialchars($employee['birth_date']); ?></td>
                    <td><?php echo htmlspecialchars($employee['age']); ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <?php
            if ($page > 0) {
            ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="btn btn-outline-secondary">Précédent</a>
            <?php
            } else {
            ?>
                <span></span>
            <?php
            }
            ?>
            <?php
            if ($hasNext) {
            ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="btn btn-outline-primary">Suivant</a>
            <?php
            } else {
            ?>
                <span></span>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
    <a href="index.php" class="btn btn-secondary mt-3">Retour à l'accueil</a>
     <footer> 4212 et 4352</footer>
</body>
</html>