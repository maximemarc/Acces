<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("location: index.php");
    }
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="docs/attribution.cmd"');
    readfile('docs/attribution.cmd');
    header('location: index.php');
?>