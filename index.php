<?php

define("IN_MAIN", true);

session_start();

include("config.php");
include("database.php");
include("functions.php");

if(logged_in()) {
	$pages = $pages["logged_in"];
} else {
	$pages = $pages["anonymous"];
}

if(!isset($_GET["page"]) || !in_array($_GET["page"], $pages)) {
	redirect("home", "Invalid page");
}


?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>CodeGolf (beta)</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="<?php echo $cdn["recaptcha_js"]; ?>"></script>
	<link rel="stylesheet" href="<?php echo $cdn["bootstrap_css"]; ?>">
	<script src="<?php echo $cdn["jquery_js"]; ?>"></script>
<!--	<script src="<?php echo $cdn["popper_js"]; ?>"></script> -->
	<script src="<?php echo $cdn["bootstrap_js"]; ?>"></script>
	<link rel="stylesheet" href="/css/default.css" />
</head>

<body>

	<div class="container">

		<h1>CodeGolf <sup style="color: blue;">(beta)</sup> <img src="/images/logo.png" style="width: 25px;"></h1>

		<ul class="nav nav-tabs">
		<?php
		foreach($pages as $p) {
			if($_GET["page"] == $p) {
				?><li class="nav-item"><a class="nav-link active" disabled="disabled"><?php echo ucfirst($p); ?></a></li><?php
			} else {
				?><li class="nav-item"><a class="nav-link" href="/<?php echo $p; ?>"><?php echo ucfirst($p); ?></a></li><?php
			}
		}
		?>
		</ul>

		<div class="content">
		<?php
		include("pages/" . $_GET["page"] . ".php");
		?>
		</div>

	</div>

</body>

</html>
