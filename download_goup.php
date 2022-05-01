<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("location: index.php");
    }
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="docs/crea_groupes.cmd"');
    readfile('docs/crea_groupes.cmd');
    header('location: index.php');
?>