<?php
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="docs/attribution.cmd"');
    readfile('docs/attribution.cmd');
    header('location: gestion_droit.php');
?>