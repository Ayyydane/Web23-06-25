<?php
session_start();
session_destroy();
header("Location: ../PAGES/inscription.php");
exit();
?>
