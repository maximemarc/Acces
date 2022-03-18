<?php
if (isset($_SESSION['admin'])) {
    header("location: index.php");
}
require('connect.php');
$taille = count($_POST['dos']);
$max = intval(pg_fetch_all(pg_query('select max(id_a) as max from attribution'))[0]['max']);
$id_ac = $_POST['id_ac'];

for ($i = 0; $i < $taille; $i++) {
	$idl = $_POST['id_l'][$i];
	$ide = $_POST['id_e'][$i];
	$dos = $_POST['dos'][$i];
	$rins = 'select id_a from attribution where id_ac =' . $id_ac . 'and id_dos =' . $dos;
	$query = pg_query($rins);
	$tab = pg_fetch_all($query);
	foreach ($tab as $t) {
		$ta[] = $t['id_a'];
	}
	if(intval($_POST['id_e'][$i]) == 1)
		{
		$_POST['id_l'][$i] = 1;
		$idl = $_POST['id_l'][$i];
		}
	if ($tab == false) {
		$max = $max + 1;

		$rins = 'insert into attribution(id_a, id_ac, id_dos, id_l, id_e) values (' . $max . ',' . $id_ac . ',' . $dos . ',' . $idl . ',' . $ide . ')';
	} else {
		$rins = 'update attribution set id_l = ' . $idl . ', id_e = ' . $ide . ' where id_ac =' . $id_ac . ' and id_dos =' . $dos;
	}
	$query = pg_query($rins);


	if ($query) {
		$rins = 'update modifs set modif = false where id_modifs = 0';
		$query = pg_query($rins);
		header('Location: gestion_droit.php?id='.$id_ac);
	} else {
		
		echo 'Erreur d\'enregistrement, consultez un administrateur !';
		echo '<a href="gestion_droit.php?id='.$id_ac.'">Retour à la Gestion des droits</a>';
		exit();
	}
}

