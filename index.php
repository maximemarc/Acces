<?php
session_start();
if (isset($_SESSION['login'])) {
	header("location: gestion_droit.php");
}
require('entete.php');
?>
<form id="form_con" action="connexion.php" method="post">
	<h3>Connection</h3>
	<label for="log">Identifiant</label>
	<input type="text" name="log" placeholder="identifiant" />
	<label for="mdp">Mot de passe</label>
	<input type="password" name="mdp" placeholder="Mot de passe" />
	<button id="con">Connection</button>
	<br><br>
	<span>
		<?php
		$message[0] = "Attention, le couple login/mot de passe que vous avez saisi est incorrect.";
		$message[1] = "Problème d'accès à la base, contactez un administrateur.";
		$message[2] = "Attention, vous devez saisir un login et un mot de passe.";
		$message[3] = "Problème d'accès à une table, contactez un administrateur.";
		if (isset($_GET['error'])) {
			echo $message[$_GET['error']];
		}
		?>
	</span>
</form>