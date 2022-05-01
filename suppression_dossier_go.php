<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("location: index.php");
    }
require('connect.php');

$rins = 'DELETE FROM attribution WHERE id_dos = ' . $_GET['id'];
$query = pg_query($rins);

$rins = 'DELETE FROM dossier WHERE id_dos = ' . $_GET['id'];
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
