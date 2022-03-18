<?php
session_start();

require('entete.php');
require('function_utility.php');

$user = $_POST['log'];
$password = $_POST['mdp'];
$host = 'local';
$domain = 'na.local';
$ds = ldap_connect("ldap://{$host}.{$domain}") or die('Could not connect to LDAP server.');
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
if ($password != null && $ldap = ldap_bind($ds, "{$user}@{$domain}", $password)) {
	$_SESSION['login'] = $user;
	header('location: gestion_droit.php');
} else {

	localchek();
}


function localchek()
{
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
				require_once('connect.php');
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
		/*$host = 'srvdc01';
		$domain = 'na.local';
		$basedn = 'dc=na,dc=local';
		$ds = ldap_connect("ldap://{$host}.{$domain}") or die('Could not connect to LDAP server.');
		ldap_bind($ds, "ldapreader@na.local", "Password0");
		$filter = '(&(objectCategory=person)(objectClass=user))';
		$dn = "ou=NAI_Utilisateurs," . $basedn;
		$attr = array("DN", "CN", "sAMAccountName", "mail", "givenName", "sn");
		$ld = ldap_search($ds, $dn, $filter, $attr) or die('une erreur est surevenu');
		$max = intval(pg_fetch_all(pg_query('select count(id_ac) as max from account'))[0]['max']);

		$info = ldap_get_entries($ds, $ld);
		for ($i = 0; $i < $info["count"]; $i++) {

			$rins = 'insert into account (id_ac, ';
			if ($info[$i]["sn"][0] != '') {
				$rins = $rins . 'nom, ';
			}
			if (!($info[$i]["givenname"][0] == '')) {
				$rins = $rins . 'prenom, ';
			}
			if (!($info[$i]["samaccountname"][0] == '')) {
				$rins = $rins . 'login';
			}
			if (!($info[$i]["mail"][0] == '')) {
				$rins = $rins . ', mail';
			}
			$rins = $rins . ') values(' . $max . ', ';
			if (!($info[$i]["sn"][0] == '')) {
				$rins = $rins . '\'' . $info[$i]["sn"][0] . '\', ';
			}
			if (!($info[$i]["givenname"][0] == '')) {
				$rins = $rins . '\'' . $info[$i]["givenname"][0] . '\', ';
			}
			if (!($info[$i]["samaccountname"][0] == '')) {
				$rins = $rins . '\'' . $info[$i]["samaccountname"][0] . '\'';
			}
			if (!($info[$i]["mail"][0] == '')) {
				$rins = $rins . ', \'' . $info[$i]["mail"][0] . '\'';
			}
			$rins = $rins . ')';
			$max = $max + 1;

			$rins = fixMSWord($rins);
			$q = pg_query($rins); // exécution de la requette dans la bdd

			if (!$q) {
				echo 'Erreur d\'enregistrement, consultez un administrateur !';
				echo '<a href="gestion_droit.php">Retour à la Gestion des droits</a>';
				exit();
			}
		}
		*/
		pg_close($c);
		header('location: gestion_droit.php');
	} else {
		header('location: index.php?error=' . $e);
	}
}
