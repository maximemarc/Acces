<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("location: index.php");
}

require('entete.php');
require_once('connect.php');
?>
 
<form action="ajout_dossier_go.php" id="form_ajout" method="POST"> 
	<a style="color: #080710;"class="bouton" onclick="window.location.href='gestion_droit.php'">Retour</a>
	<h3>Ajouter un Dossier</h3>
	<label for="dossier">Nom du Dossier</label>
	<input type="text" name="dossier" placeholder="Nom du Dossier"  required="required" />
	<label for="index">index du Dossier</label>
	<input type="text" name="index" placeholder="index du Dossier"  required="required" />
    <label for="id_dos_parent">index du Dossier Parent</label>
	<select name="index_dos_parent" id="index_dos_parent">
	<?php
	$s = "SELECT * FROM dossier order by index";
	$r = pg_query($s);
	$tab = pg_fetch_all($r);
	echo '<option value="">-</option>';
	foreach ($tab as $t) {
		echo '<option value="'.$t['index'].'">'.$t['index']. '-' . $t['dossier'].'</option>';
		}
  

  	?>
	</select>
	<button id="ajout">Ajouter</button>
	<br><br>
</form>