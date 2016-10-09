<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="TwitchPlaysPokemon.org for the Twitch.tv stream status, updates, real time data, and so much more!">
		<meta name="author" content="Rayrobdod">
		<link rel="shortcut icon" href="favicon.ico?v2">

		<title>TwitchPlaysPok&eacute;mon / Twitch Plays Pok&eacute;mon - Let's Get Organized!</title><?php
		if(TPP_DEBUG) { ?>

		<link href="css/twitchplayspokemon.css" rel="stylesheet">
		<link href="css/spritesheets.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/grayscale.css" rel="stylesheet">
		<link href="css/jquery-ui.min.css" rel="stylesheet">
		<link href="css/tppdebug.css" rel="stylesheet"><?php
		} else { ?>

		<link href="css/minified.css" rel="stylesheet"><?php
		} ?>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script><?php
		if(TPP_DEBUG) { ?>
		<script src="js/jquery.plugin.min.js"></script>
		<script src="js/jquery.cookie.js"></script>
		<script src="js/jquery.lazyload.min.js"></script>

		<script src="js/jquery-ui.min.js"></script>
		<script src="js/twitchplayspokemon.js"></script><?php
		} else { ?>

		<script src="js/minified.js"></script><?php
		} ?>

	</head>

	<body id="top">
		<div class="container tpp-container">
