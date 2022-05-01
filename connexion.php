<?php
$user = $_POST['log'];
$password = $_POST['mdp'];

$b = false;
if (empty($_POST['log']) || empty($_POST['mdp'])) {
	$e = 2; // pas de saisie
} else {
	$login = $_POST['log'];
	$mdp = md5($_POST['mdp']);
	// vérifier que le login ne fait pas plus de 10 caractères 
	if (strlen($login) <= 10) {
		$recherche = array(';', ' ', ',');
		$remp = array('_', '_', '_');
		if (str_replace($recherche, $remp, $login) == $login) {
			// connexion à la base et vérification 
			require('connect.php');
			if ($c) {
				$s = "SELECT count(*) FROM administrateur WHERE login = '" . $login . "' and password = '" . $mdp . "'";
				if ($r = pg_query($s)) {
					if (pg_fetch_row($r)[0] != 0) {
						$b = true;
					} else {
						$e = 0; // mauvais couple d'identification
					}
				} else {
					$e = 3;  // pas d'accès à la requete
				}
			} else {
				$e = 1;
			}
		}
	}
}
if ($b) {
	// Créer les variables de session
	// Attention, vérifier dans la base qu'un seul login existe		
	$_SESSION['login'] = $login;
	$_SESSION['admin'] = true;
	pg_close($c);
	header('location: index.php');
} else {
	header('location: index.php?error=' . $e);
}
