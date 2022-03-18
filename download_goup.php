<?php
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="docs/crea_groupes.cmd"');
    readfile('docs/crea_groupes.cmd');
    header('location: gestion_droit.php');
?>