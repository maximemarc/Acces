<?php
require('connect.php');
session_start();
if (!isset($_SESSION['login'])) {
    header("location: index.php");
}
$dossier = pg_escape_literal($_POST['dossier']);
$index = pg_escape_literal($_POST['index']);
$index_dos_parent = $_POST['index_dos_parent'];
$max = intval(pg_fetch_all(pg_query('select count(id_dos) as max from dossier'))[0]['max']);
if (!($index_dos_parent == '' || $index_dos_parent == null)) {
    $r = 'select id_dos from dossier where index =\'' . $index_dos_parent.'\'';
    $req = pg_query($r);
    $tab = pg_fetch_all($req);
    $id_dos_parent = $tab[0]['id_dos'];
}
echo $id_dos_parent;
$rins = 'insert into dossier(id_dos, dossier, index';
if (!($id_dos_parent == '' || $id_dos_parent == null)) {
    $rins = $rins . ', id_dos_parent';
}
$rins = $rins . ') values (' . $max . ',' . $dossier . ',' . $index;
if (!($id_dos_parent == '' || $id_dos_parent == null)) {
    $rins = $rins . ', ' . $id_dos_parent;
}
$rins = $rins . ')';

$query = pg_query($rins);
if ($query) {
    $rins = 'update modifs set modif = false where id_modifs = 0';
    $query = pg_query($rins);
} else {
    echo 'Erreur d\'enregistrement, consultez un administrateur !';
    echo '<a href="index.php">Retour à la Gestion des droits</a>';
    exit();
}
header('Location: index.php');
