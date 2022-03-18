<?php
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="docs/crea_doss.cmd"');
    readfile('docs/crea_doss.cmd');
    header('location: gestion_droit.php');
?>