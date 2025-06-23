<?php
require_once("connexion.php");

function getDepartementsAvecManager() {
    global $bdd;
    $sql = "
        SELECT d.dept_no, d.dept_name, e.first_name, e.last_name
        FROM departments d
        JOIN dept_manager dm ON d.dept_no = dm.dept_no
        JOIN employees e ON dm.emp_no = e.emp_no
        WHERE dm.to_date = '9999-01-01'
    ";
    $resultat = mysqli_query($bdd, $sql);
    $donnees = array();

    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $donnees[] = $ligne;
    }

    return $donnees;
}


function getEmployesParDepartement($dept_no) {
    global $bdd;
    $dept_no = mysqli_real_escape_string($bdd, $dept_no);
    $sql = "
        SELECT e.emp_no, e.first_name, e.last_name, e.hire_date
        FROM dept_emp de
        JOIN employees e ON de.emp_no = e.emp_no
        WHERE de.dept_no = '$dept_no'
        AND de.to_date = '9999-01-01'
    ";
    $resultat = mysqli_query($bdd, $sql);
    $donnees = array();
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $donnees[] = $ligne;
    }
    return $donnees;
}
?>