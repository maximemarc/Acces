<?php
session_start();
?>

<html>

<head>
	<title>Attribution de droits</title>
	<meta name="author" content="Maxime">
	<meta name="date" content="2022-01-26T08:30:00">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
	<meta http-equiv="content-style-type" content="text/css">
	<meta http-equiv="expires" content="0">
	<link href="css/index.css" rel="stylesheet" type="text/css">
	<link href="img/logo.png" rel="shortcut icon" type="image/png">
	<link href="css/Roboto.ttf" rel="stylesheet">
	<script src="js/ajax.js"></script>
</head>

<body>
	<header>
		<div id="logo">
		
		<div id="deco">
			<?php
			if (isset($_SESSION['login'])) {
				echo '<img src=img/deco.png onclick="window.location.replace(\'deco.php\')" />	';
			}
			?>
		</div>
	</div>
	</header>