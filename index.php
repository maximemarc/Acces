<?php
require('entete.php');
if (!isset($_SESSION['login'])) {
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

<?php
} else {
?>

	<body>
		<div class="global">
			<div id="gauche">
				<?php
				require('connect.php');

				$vis = pg_fetch_all(pg_query('select modif from modifs where id_modifs = 0'))[0]['modif'];
				if (isset($_SESSION['admin'])) {
				?>
					<div id="bu">

						<?php
						if ($vis == 'f') {
							echo '<button class="bouton" onclick="window.location.href=\'generer_code.php\'">Générer Code</button>';
						} else {
							echo '<button class="bouton2" onclick="window.location.href=\'download_goup.php\'">Script de Création des groupes
							<p style="color:black;">(execution dans le controleur de Domaine)</p></button>';
							echo '<button class="bouton2" onclick="window.location.href=\'download_ad.php\'">Script d\'attribution des droits
							<p style="color:black;">(execution dans le controleur de Domaine)</p></button>';
							echo '<button class="bouton2" onclick="window.location.href=\'download_dos.php\'" >Script de Création de Dossier
							<p style="color:black;">(execution dans le serveur de fichier)</p></button>';
						}
						?>
					</div>
				<?php
				}
				?>
				<H1> Utilisateur :</H1>

				<?php

				if ($c) {
					$s = "SELECT * FROM account order by nom";
					$r = pg_query($s);
					$tab = pg_fetch_all($r);
					echo '<script type="text/javascript">';
					if ($_GET['id']) {
						echo   'ajax(\'gestion_droit_table.php?id=' . $_GET['id'] . '\', \'droit\');';
					} else {
						echo   'ajax(\'gestion_droit_table.php?id=' . $tab[0]['id_ac'] . '\', \'droit\');';
					}

					echo '</script>';
					if ($vis == 'f' || !isset($_SESSION['admin'])) {
						echo  '<div id ="scroll2"> ';
					} else {
						echo  '<div id ="scroll"> ';
					}
					foreach ($tab as $t) {
						if ($t['nom'] != null && $t['prenom'] != null) {
							echo '<div class="name" onclick="ajax(\'gestion_droit_table.php?id=' . $t['id_ac'] . '\', \'droit\')">';

							echo '<p >' . $t['nom'] . ' ' . $t['prenom'] . '</p>';

							echo '</div>';
						}
					}
				}
				?>
			</div>
		</div>
		<div id="droit">

		</div>

	</body>
<?php
}
?>